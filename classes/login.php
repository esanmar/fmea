<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class login extends employees
{

	// Page ID
	public $PageID = "login";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Page object name
	public $PageObjName = "login";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken;

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading != "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading != "")
			return $this->Subheading;
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		return $url;
	}

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = FALSE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message != "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fas fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage != "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fas fa-exclamation"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage != "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fas fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage != "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fas fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = [];

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message != "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage != "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage != "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage != "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header != "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer != "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(Config("TOKEN_NAME")) === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn(Post(Config("TOKEN_NAME")), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = Config("CREATE_TOKEN_FUNC"); // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $DashboardReport;
		global $UserTable;

		// Check token
		$this->CheckToken = Config("CHECK_TOKEN");

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = 48 * 60 * 60; // 48 hours for login

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (employees)
		if (!isset($GLOBALS["employees"]) || get_class($GLOBALS["employees"]) == PROJECT_NAMESPACE . "employees") {
			$GLOBALS["employees"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["employees"];
		}
		if (!isset($GLOBALS["employees"]))
			$GLOBALS["employees"] = &$this;

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'login');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = $this->getConnection();

		// User table object (employees)
		$UserTable = $UserTable ?: new employees();
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url != "") {
			if (!Config("DEBUG") && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url];
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
		}
		exit();
	}

	// Set up API request
	public function setupApiRequest()
	{
		global $Security;

		// Check security for API request
		If (ValidApiRequest()) {
			if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel(Config("PROJECT_ID") . $this->TableName);
			if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
			$Security->UserID_Loading();
			$Security->loadUserID();
			$Security->UserID_Loaded();
			return TRUE;
		}
		return FALSE;
	}

	// Properties
	public $Username;
	public $LoginType;
	public $IsModal = FALSE;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$Breadcrumb, $FormError, $SkipHeaderFooter;
		$this->OffsetColumnClass = ""; // Override user table

		// Is modal
		$this->IsModal = (Param("modal") == "1");

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (!$this->setupApiRequest()) {
			$Security = new AdvancedSecurity();
		}
		$this->CurrentAction = Param("action"); // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/") + 1);
		$Breadcrumb = new Breadcrumb();
		$Breadcrumb->add("login", "LoginPage", $url, "", "", TRUE);
		$this->Heading = $Language->phrase("LoginPage");
		$this->Username = ""; // Initialize
		$password = "";
		$lastUrl = $Security->lastUrl(); // Get last URL
		if ($lastUrl == "")
			$lastUrl = "index.php";

		// If session expired, show session expired message
		if (Get("expired") == "1")
			$this->setFailureMessage($Language->phrase("SessionExpired"));

		// If delete personal data successed, show success message
		if (Get("deleted") == "1")
			$this->setSuccessMessage($Language->phrase("PersonalDataDeleteSuccess"));

		// Login
		if (IsLoggingIn()) { // After changing password
			$this->Username = @$_SESSION[SESSION_USER_PROFILE_USER_NAME];
			$password = @$_SESSION[SESSION_USER_PROFILE_PASSWORD];
			$this->LoginType = @$_SESSION[SESSION_USER_PROFILE_LOGIN_TYPE];
			$validPwd = $Security->validateUser($this->Username, $password, FALSE);
			if ($validPwd) {
				$_SESSION[SESSION_USER_PROFILE_USER_NAME] = "";
				$_SESSION[SESSION_USER_PROFILE_PASSWORD] = "";
				$_SESSION[SESSION_USER_PROFILE_LOGIN_TYPE] = "";
			}
		} else if (Get("provider")) { // OAuth provider
			$provider = ucfirst(strtolower(trim(Get("provider")))); // e.g. Google, Facebook
			$validate = $Security->validateUser($this->Username, $password, FALSE, $provider); // Authenticate by provider
			$validPwd = $validate;
			if ($validate) {
				$this->Username = $UserProfile->get("email");
				if (Config("DEBUG") && !$Security->isLoggedIn()) {
					$validPwd = FALSE;
					$this->setFailureMessage(str_replace("%u", $this->Username, $Language->phrase("UserNotFound"))); // Show debug message
				}
			} else {
				$this->setFailureMessage(str_replace("%p", $provider, $Language->phrase("LoginFailed")));
			}
		} else { // Normal login
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			$Security->loadUserLevel(); // Load user level
			if (Post("username") !== NULL) {
				$this->Username = RemoveXss(Post("username"));
				$password = Post("password");
				$this->LoginType = strtolower(RemoveXss(Post("type")));
			} else if (Config("ALLOW_LOGIN_BY_URL") && Get("username") !== NULL) {
				$this->Username = RemoveXss(Get("username"));
				$password = Get("password");
				$this->LoginType = strtolower(RemoveXss(Get("type")));
			}
			if ($this->Username != "") {
				$validate = $this->validateForm($this->Username, $password);
				if (!$validate)
					$this->setFailureMessage($FormError);
				$_SESSION[SESSION_USER_LOGIN_TYPE] = $this->LoginType; // Save user login type
				$_SESSION[SESSION_USER_PROFILE_USER_NAME] = $this->Username; // Save login user name
				$_SESSION[SESSION_USER_PROFILE_LOGIN_TYPE] = $this->LoginType; // Save login type
			} else {
				if ($Security->isLoggedIn()) {
					if ($this->getFailureMessage() == "")
						$this->terminate($lastUrl); // Return to last accessed page
				}
				$validate = FALSE;

				// Restore settings
				if (ReadCookie("Checksum") == strval(crc32(md5(Config("RANDOM_KEY")))))
					$this->Username = Decrypt(ReadCookie("Username"));
				if (ReadCookie("AutoLogin") == "autologin") {
					$this->LoginType = "a";

				// } elseif (ReadCookie("AutoLogin") == "rememberusername") {
				// 	$this->LoginType = "u";

				} else {
					$this->LoginType = "";
				}
			}
			$validPwd = FALSE;
			if ($validate) {

				// Call Logging In event
				$validate = $this->User_LoggingIn($this->Username, $password);
				if ($validate) {
					$validPwd = $Security->validateUser($this->Username, $password, FALSE); // Manual login
					if (!$validPwd) {
						if ($this->getFailureMessage() == "")
							$this->setFailureMessage($Language->phrase("InvalidUidPwd")); // Invalid user name or password
					}
				} else {
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("LoginCancelled")); // Login cancelled
				}
			}
		}

		// After login
		if ($validPwd) {

			// Write cookies
			if ($this->LoginType == "a") { // Auto login
				WriteCookie("AutoLogin", "autologin"); // Set autologin cookie
				WriteCookie("Username", Encrypt($this->Username)); // Set user name cookie
				WriteCookie("Password", Encrypt($password)); // Set password cookie
				WriteCookie('Checksum', crc32(md5(Config("RANDOM_KEY"))));

			// } elseif ($this->LoginType == "u") { // Remember user name
			// 	WriteCookie("AutoLogin", "rememberusername"); // Set remember user name cookie
			// 	WriteCookie("Username", Encrypt($this->Username)); // Set user name cookie
			// 	WriteCookie("Checksum", crc32(md5(Config("RANDOM_KEY"))));

			} else {
				WriteCookie("AutoLogin", ""); // Clear auto login cookie
			}

			// Call loggedin event
			$this->User_LoggedIn($this->Username);
			$this->terminate($lastUrl); // Return to last accessed URL
		} elseif ($this->Username != "" && $password != "") {

			// Call user login error event
			$this->User_LoginError($this->Username, $password);
		}
	}

	// Validate form
	protected function validateForm($usr, $pwd)
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return TRUE;
		if (trim($usr) == "") {
			AddMessage($FormError, $Language->phrase("EnterUid"));
		}
		if (trim($pwd) == "") {
			AddMessage($FormError, $Language->phrase("EnterPwd"));
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form Custom Validate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// User Logging In event
	function User_LoggingIn($usr, &$pwd) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// User Logged In event
	function User_LoggedIn($usr) {

		//echo "User Logged In";
	}

	// User Login Error event
	function User_LoginError($usr, $pwd) {

		//echo "User Login Error";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
} // End class
?>