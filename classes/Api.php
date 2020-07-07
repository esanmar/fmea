<?php
namespace PHPMaker2020\SupplierMapping;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Class for API
 */
class Api
{
	protected $SecretKey = '0k1YSWokFIbg64my';
	protected $Algorithm = 'HS512';

	// For some reason, the "Authorization" header is removed by IIS, changed to "X-Authorization"
	public $AuthHeader = 'X-Authorization';
	protected $NotBeforeTime = 0;
	protected $ExpireTime = 600;

	// Configuration
	protected $Config = []; // Add other configurations here

	// Process route info and return json
	public function processRoute($pageName)
	{
		if ($pageName != "") {
			$pageClass = PROJECT_NAMESPACE . $pageName;
			if (class_exists($pageClass)) {
				$page = new $pageClass();
				return $page->run();
			}
		}
		return FALSE;
	}

	// Process file request
	public function processFile()
	{
		$file = new FileViewer();
		return $file->getFile();
	}

	// Process file upload
	public function processFileUpload()
	{
		$upload = new HttpUpload();
		return $upload->getUploadedFiles();
	}

	// Process jQuery file upload
	public function processjQueryFileUpload()
	{
		$upload = new FileUploadHandler();
		return $upload->run();
	}

	// Process lookup
	public function processLookup($object)
	{
		$class = PROJECT_NAMESPACE . $object;
		if (class_exists($class)) {
			$lookup = new $class();
			return $lookup->lookup();
		}
		return FALSE;
	}

	// Process session
	public function processSession()
	{
		$session = new SessionHandler();
		return $session->getSession();
	}

	// Process progress
	public function processProgress($token)
	{
		$data = GetCache($token); // Get import progress from file token
		if (is_array($data)) {
			WriteJson($data);
			return TRUE;
		}
		return FALSE;
	}

	// Process export chart
	public function processExportChart() {
		$exporter = new ChartExporter();
		return $exporter->export();
	}

	// Login and return JWT
	public function login($username, $password)
	{
		global $UserProfile, $Security; // Security related
		$UserProfile = new UserProfile(); // Create user profile object
		$Security = new AdvancedSecurity(); // Create security object
		$validPwd = $Security->validateUser($username, $password, FALSE);
		if ($validPwd)
			return $this->createJWT($username, $Security->CurrentUserID, $Security->CurrentParentUserID, $Security->CurrentUserLevelID);
		return FALSE;
	}

	// Create JWT
	protected function createJWT($userName, $userID, $parentUserID, $userLevelID)
	{

		//$tokenId = base64_encode(mcrypt_create_iv(32));
		$tokenId = base64_encode(openssl_random_pseudo_bytes(32));
		$issuedAt = time();
		$notBefore = $issuedAt + $this->NotBeforeTime; // Adding not before time (seconds)
		$expire = $notBefore + $this->ExpireTime; // Adding expire time (seconds)
		$serverName = ServerVar("SERVER_NAME");

		// Create the token as an array
		$ar = [
			"iat" => $issuedAt, // Issued at: time when the token was generated
			"jti" => $tokenId, // Json Token Id: an unique identifier for the token
			"iss" => $serverName, // Issuer
			"nbf" => $notBefore, // Not before
			"exp" => $expire, // Expire
			"security" => [ // Data related to the signer user
				"username" => $userName, // User name
				"userid" => $userID, // User ID
				"parentuserid" => $parentUserID, // Parent user ID
				"userlevelid" => $userLevelID // User Level ID
			]
		];
		$jwt = \Firebase\JWT\JWT::encode(
			$ar, // Data to be encoded in the JWT
			$this->SecretKey, // The signing key
			$this->Algorithm // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
		);
		$result = ["JWT" => $jwt];
		return $result;
	}

	// Decode JWT
	public function decodeJWT($header)
	{
		if (is_array($header) && count($header) > 0) {
			$jwt = $header[0];
			$jwt = preg_replace('/^Bearer\s+/', "", $jwt);
			try {
				$ar = (array)\Firebase\JWT\JWT::decode($jwt, $this->SecretKey, [$this->Algorithm]);
				return (array)$ar["security"];
			}
			catch (\Firebase\JWT\BeforeValidException $e) {
				if (Config("DEBUG"))
					die($e->getMessage());
				return ["BeforeValidException" => $e->getMessage()];
			}
			catch (\Firebase\JWT\ExpiredException $e) {
				if (Config("DEBUG"))
					die($e->getMessage());
				return ["ExpiredException" => $e->getMessage()];
			}
			catch (Exception $e) {
				if (Config("DEBUG"))
					die($e->getMessage());
				return ["Exception" => $e->getMessage()];
			}
		}
		return [];
	}

	/**
	 * Perform API call
	 *
	 * Routes:
	 * 1. list/view/add/edit/delete
	 *  - URL rewrite: api/view/cars/1
	 *  - Without URL rewrite: api/?action=view&object=cars&ID=1
	 * 2. login
	 *  - URL rewrite: api/login
	 *  - Without URL rewrite: api/?action=login
	 * 3. file viewer
	 *  - URL rewrite: api/file/cars/Picture/1
	 *  - Without URL rewrite: api/?action=file&object=cars&field=Picture&key=1
	 * 4. file upload
	 *  - URL rewrite: api/upload
	 *  - Without URL rewrite: api/?action=upload
	 * 5. jQuery file upload
	 *  - URL rewrite: api/jupload
	 *  - Without URL rewrite: api/?action=jupload
	 * 6. session
	 *  - URL rewrite: api/session
	 *  - Without URL rewrite: api/?action=session
	 * 7. lookup (UpdateOption/ModalLookup/AutoSuggest/AutoFill)
	 *  - URL rewrite: api/lookup&ajax=(updateoption|modal|autosuggest|autofill)
	 *  - Without URL rewrite: api/?action=lookup&ajax=(updateoption|modal|autosuggest|autofill)
	 * 8. import progress
	 *  - URL rewrite: api/progress
	 *  - Without URL rewrite: api/?action=progress
	 * 9. export chart
	 *  - URL rewrite: api/exprtchart
	 *  - Without URL rewrite: api/?action=exportchart
	 * @return Response
	 */
	public function run()
	{
		$app = new \Slim\App($this->Config);

		// Register middleware
		$app->add(new \Slim\HttpCache\Cache("private", 0, TRUE));

		// Fetch DI Container
		$container = $app->getContainer();

		// Register service provider
		$container["cache"] = function () {
			return new \Slim\HttpCache\CacheProvider();
		};

		// API
		$api = $this;

		// Handler for routes
		$app->any('/[{params:.*}]', function (Request $request, Response $response, array $args) use ($api) {

			// Handle OPTIONS request
			if ($request->isOptions())
				return $response;

			// Get request data
			$action = $request->getParam(Config("API_ACTION_NAME"));
			$object = $request->getParam(Config("API_OBJECT_NAME"));
			$field = $request->getParam(Config("API_FIELD_NAME"));
			$key = $request->getParam(Config("API_KEY_NAME"));
			$pageName = "";

			// Get route data
			$route = "";
			if (is_array($args) && array_key_exists("params", $args) && strval($args["params"]) != "") {
				$route = explode("/", $args["params"]);
				$cnt = count($route);
				for ($i = 0; $i < $cnt; $i++) {
					if ($i == 0) // First route = action
						$action = $route[$i];
					elseif ($i == 1) // Second route = object
						$object = $route[$i];
				}
			}

			// Set up object and action
			if (strval($action) == "") // Default action = list
				$action = Config("API_LIST_ACTION");
			$API_PAGE_ACTIONS = [Config("API_LIST_ACTION"), Config("API_VIEW_ACTION"), Config("API_ADD_ACTION"), Config("API_EDIT_ACTION"), Config("API_DELETE_ACTION")];
			if (in_array($action, $API_PAGE_ACTIONS)) {
				$pageName = $object . "_" . $action;
			} elseif ($action == Config("API_FILE_ACTION")) { // File viewer
				if ($field == "") // Field
					$field = @$route[2];
				if ($key == "") // Key
					$key = @$route[3];
			} elseif ($action == Config("API_LOOKUP_ACTION")) { // Lookup
				$object = $request->getParam(Config("API_LOOKUP_PAGE")); // Get Lookup Page
			}

			// No cache
			$response = $this->cache->denyCache($response);
			$response = $this->cache->withExpires($response, "-1 year");
			$response = $this->cache->withLastModified($response, time());

			// Handle login
			if ($action == Config("API_LOGIN_ACTION")) {
				if ($request->isGet()) {
					$username = $request->getQueryParam(Config("API_LOGIN_USERNAME"));
					$password = $request->getQueryParam(Config("API_LOGIN_PASSWORD"));
				} else {
					$username = $request->getParsedBodyParam(Config("API_LOGIN_USERNAME"));
					$password = $request->getParsedBodyParam(Config("API_LOGIN_PASSWORD"));
				}
				$jwt = $api->login($username, $password);
				if ($jwt) {
					return $response->withJson($jwt);
				} else {
					return $response->withStatus(401); // Not authorized
				}
			}

			// Set up request/response objects
			global $Request, $RequestSecurity;
			$Request = $request;
			$GLOBALS["Response"] = &$response; // Note: global $Response does not work
			$RequestSecurity = $api->decodeJWT($request->getHeader($api->AuthHeader));

			// Handle custom actions first
			if (in_array($action, array_keys($GLOBALS["API_ACTIONS"]))) {
				$func = $GLOBALS["API_ACTIONS"][$action];
				if (is_callable($func))
					$func($request, $response);
				return $response;
			} elseif ($action == Config("API_UPLOAD_ACTION")) { // Upload file
				$res = $api->processFileUpload();
				return $response;
			} elseif ($action == Config("API_JQUERY_UPLOAD_ACTION")) { // jQuery file upload
				$res = $api->processjQueryFileUpload();
				return $response;
			} elseif ($action == Config("API_FILE_ACTION")) { // File viewer
				$res = $api->processFile();
				return $response;
			} elseif ($action == Config("API_LOOKUP_ACTION")) { // Lookup
				$res = $api->processLookup($object);
				return $response;
			} elseif ($action == Config("API_SESSION_ACTION")) { // Session
				$res = $api->processSession();
				return $response;
			} elseif ($action == Config("API_PROGRESS_ACTION")) { // Import progress
				$res = $api->processProgress($request->getParam(Config("API_FILE_TOKEN_NAME")));
				return $response;
			} elseif ($action == Config("API_EXPORT_CHART_ACTION")) { // Export chart
				$res = $api->processExportChart();
				return $response;
			} else {
				$res = $api->processRoute($pageName);
				return $response;
			}
			$handler = $this->notFoundHandler; // default Slim page not found handler
			return $handler($request, $response);

			//return $response->withStatus(404); // Not found
		});

		// Add CORS headers
		$app->add(function($request, $response, $next) {
			$response = $next($request, $response);
			return $response
				->withHeader("Access-Control-Allow-Origin", DomainUrl())
				->withHeader("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, Accept, Origin, Authorization, X-Authorization")
				->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, PATCH, OPTIONS");
		});
		$app->run();
	}
}
?>