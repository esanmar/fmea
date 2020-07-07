<?php
namespace PHPMaker2020\SupplierMapping;

// Upload handler
class UploadHandler extends \UploadHandler
{

	// Upload ID
	protected $UploadId = "";

	// Upload Table
	protected $UploadTable = "";

	// Session ID
	protected $SessionId = "";

	// Override constructor
	public function __construct($uploadId = "", $uploadTable = "", $sessionId = "", $options = null, $initialize = true, $error_messages = null)
	{
		$this->UploadId = $uploadId;
		$this->UploadTable = $uploadTable;
		$this->SessionId = $sessionId;
		parent::__construct($options, $initialize, $error_messages);
	}

	// Override initialize()
	protected function initialize()
	{
		if (IsGet() && Get("delete") !== NULL)
			$this->delete();
		else
			parent::initialize();
	}

	// Override get_user_id()
	protected function get_user_id()
	{
		$id = Config("UPLOAD_TEMP_FOLDER_PREFIX") . $this->SessionId;
		if ($this->UploadId != "") {
			$uid = $this->UploadId;
			if ($this->UploadTable != "")
				$uid = $this->UploadTable . "/" . $uid;
			$id .= "/" . $uid;
		}
		return $id;
	}

	// Override get_unique_filename()
	protected function get_unique_filename($file_path, $name, $size, $type, $error, $index, $content_range)
	{
		if (Config("UPLOAD_CONVERT_ACCENTED_CHARS")) {
			$name = htmlentities($name, ENT_COMPAT, "UTF-8");
			$name = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1', $name);
			$name = html_entity_decode($name, ENT_COMPAT, "UTF-8");
		}
		$name = Convert("UTF-8", FILE_SYSTEM_ENCODING, $name);
		return parent::get_unique_filename($file_path, $name, $size, $type, $error, $index, $content_range);
	}

	// Override get_singular_param_name()
	protected function get_singular_param_name()
	{
		return $this->options["param_name"];
	}

	// Override get_file_names_params()
	protected function get_file_names_params()
	{
		return []; // Not used
	}

	// Override handle_file_upload()
	protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null)
	{

		// Delete all files in directory if replace
		if (Param("replace") == "1") {
			$upload_dir = $this->get_upload_path();
			if ($ar = glob($upload_dir . "/*.*")) {
				foreach ($ar as $v)
					@unlink($v);
			}
			foreach ($this->options["image_versions"] as $version => $options) {
				if (!empty($version)) {
					if ($ar = glob($upload_dir . "/" . $version . "/*.*")) {
						foreach ($ar as $v)
							@unlink($v);
					}
				}
			}
		}
		return parent::handle_file_upload($uploaded_file, $name, $size, $type, $error, $index, $content_range);
	}

	// Override post()
	public function post($print_response = true)
	{
		if ($this->get_query_param("_method") === "DELETE") {
			return $this->delete($print_response);
		}
		$upload = $this->get_upload_data($this->options["param_name"]);

		// Parse the Content-Disposition header, if available:
		$content_disposition_header = $this->get_server_var("HTTP_CONTENT_DISPOSITION");
		$file_name = $content_disposition_header ?
			rawurldecode(preg_replace(
				'/(^[^"]+")|("$)/',
				"",
				$content_disposition_header
			)) : null;

		// Parse the Content-Range header, which has the following form:
		// Content-Range: bytes 0-524287/2000000

		$content_range_header = $this->get_server_var("HTTP_CONTENT_RANGE");
		$content_range = $content_range_header ?
			preg_split('/[^0-9]+/', $content_range_header) : null;
		$size = $content_range ? $content_range[3] : null;
		$files = [];
		if ($upload && is_array($upload["tmp_name"])) {

			// "param_name" is an array identifier like "files[]",
			// $upload is a multi-dimensional array:

			foreach ($upload["tmp_name"] as $index => $value) {
				$files[] = $this->handle_file_upload(
					$upload["tmp_name"][$index],
					$file_name ? $file_name : $upload["name"][$index],
					$size ? $size : $upload["size"][$index],
					$upload["type"][$index],
					$upload["error"][$index],
					$index,
					$content_range
				);
			}
		} else {

			// "param_name" is a single object identifier like "file",
			// $upload is a one-dimensional array:

			$files[] = $this->handle_file_upload(
				isset($upload["tmp_name"]) ? $upload["tmp_name"] : null,
				$file_name ? $file_name : (isset($upload["name"]) ?
						$upload["name"] : null),
				$size ? $size : (isset($upload["size"]) ?
						$upload["size"] : $this->get_server_var("CONTENT_LENGTH")),
				isset($upload["type"]) ?
						$upload["type"] : $this->get_server_var("CONTENT_TYPE"),
				isset($upload["error"]) ? $upload["error"] : null,
				null,
				$content_range
			);
		}
		$response = ["files" => $files]; // Set key as "files" for jquery.fileupload-ui.js
		return $this->generate_response($response, $print_response);
	}

	// Override upcount_name_callback()
	protected function upcount_name_callback($matches)
	{
		$index = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
		$ext = isset($matches[2]) ? $matches[2] : "";
		return "(" . $index . ")" . $ext;
	}

	// Override upcount_name()
	protected function upcount_name($name)
	{
		return preg_replace_callback(
			'/(?:(?:\(([\d]+)\))?(\.[^.]+))?$/',
			[$this, "upcount_name_callback"],
			$name,
			1);
	}

	// Override get_scaled_image_file_paths()
	protected function get_scaled_image_file_paths($file_name, $version)
	{
		$ar = parent::get_scaled_image_file_paths($file_name, $version);
		$file_path = $this->get_upload_path($file_name);
		foreach ($ar as &$path)
			$path = preg_replace('/(?<!:)\/\//', "/", $path);
		return $ar;
	}

	// Override readfile()
	protected function readfile($file_path) {
		global $Response;
		if (is_object($Response) && !IsRemote($file_path)) {
			if ($fd = fopen($file_path, "r")) {
				$stream = new \Slim\Http\Stream($fd);
				$Response = $Response->withBody($stream);
			}
		} else {
			return parent::readfile($file_path);
		}
	}

	// Override body()
	protected function body($str) {
		Write($str);
	}

	// Override header()
	protected function header($str) {
		@list($name, $value) = explode(":", $str, 2);
		if (trim($name) != "")
			AddHeader(trim($name), trim($value));
	}

	// Override send_content_type_header()
	protected function send_content_type_header() {
		$this->header("Vary: Accept");
		if (strpos($this->get_server_var("HTTP_ACCEPT"), "application/json") !== false) {
			$this->header("Content-type: application/json; charset=utf-8");
		} else {
			$this->header("Content-type: text/plain");
		}
	}

	// Override set_additional_file_properties()
	protected function set_additional_file_properties($file) {
		parent::set_additional_file_properties($file);
		$path = $this->get_upload_path($file->name);
		$parts = pathinfo($path);
		$file->extension = strtolower($parts["extension"]);
		$file->exists = TRUE;
		if (getimagesize($path, $info) !== FALSE && isset($info["APP13"])) {
			$iptc = iptcparse($info["APP13"]);
			if ($iptc !== FALSE && @$iptc["2#040"][0] == "FileNotFound")
				$file->exists = FALSE;
		}
	}

	// Override get_file_type
	protected function get_file_type($file_path) {
		switch (strtolower(pathinfo($file_path, PATHINFO_EXTENSION))) {
			case 'jpeg':
			case 'jpg':
				return 'image/jpeg';
			case 'png':
				return 'image/png';
			case 'gif':
				return 'image/gif';
			case 'pdf':
				return 'application/pdf';
			default:
				return '';
		}
	}
}

/**
 * Class for file upload
 */
class FileUploadHandler
{

	// Perform file upload (Uncomment ** for database connectivity)
	public function run()
	{
		global $Language;
		$Language = new Language();

		//**$GLOBALS["Conn"] = GetConnection();
		// Set up upload parameters

		$uploadId = Param("id", "");
		$uploadTable = Param("table", "");
		$sessionIdEncrypted = Param("session", "");
		$sessionId = Decrypt($sessionIdEncrypted);
		if (EmptyString($sessionIdEncrypted) || EmptyString($sessionId)) {
			WriteJson(["files" => [["error" => "Invalid session"]]]);
			return FALSE;
		}
		$exts = Param("exts", "");
		$arExt = explode(",", $exts);
		$allowedExt = Config("UPLOAD_ALLOWED_FILE_EXT");
		if ($allowedExt != "") {
			$arAllowedExt = explode(",", $allowedExt);
			$exts = implode(",", array_intersect($arExt, $arAllowedExt)) ?: $allowedExt; // Make sure $exts is a subset of $allowedExt
		} elseif ($exts == "") {
			$exts = "[\s\S]+"; // Allow all file types
		}
		$filetypes = '/\\.(' . str_replace(",", "|", $exts) . ')$/i';
		$maxsize = Param("maxsize");
		if ($maxsize != NULL)
			$maxsize = (int)$maxsize;
		$maxfilecount = Param("maxfilecount");
		if ($maxfilecount != NULL) {
			$maxfilecount = (int)$maxfilecount;
			if ($maxfilecount < 1)
				$maxfilecount = NULL;
		}
		$url = GetApiUrl(Config("API_JQUERY_UPLOAD_ACTION"), "rnd=" . Random() .
			(($uploadId != "") ? "&id=" . $uploadId : "") .
			(($uploadTable != "") ? "&table=" . $uploadTable : "") .
			(($sessionId != "") ? "&session=" . $sessionIdEncrypted : "")); // Add id/table/session for display and delete
		$url = preg_replace('/^(\.\.\/)*/', "", $url); // Remove relative path, e.g. "../"
		$uploaddir = UploadTempPath();
		$uploadurl = UploadTempPath(FALSE);
		$inlineFileTypes = array_merge(["gif", "jpg", "jpeg", "png", "bmp"], (Config("EMBED_PDF") || !Config("DOWNLOAD_PDF_FILE")) ? ["pdf"] : []);
		$options = [
			"param_name" => $uploadId,
			"delete_type" => "POST", // POST or DELETE, set this option to POST for server not supporting DELETE requests
			"user_dirs" => TRUE,
			"download_via_php" => 1,
			"script_url" => $url,
			"upload_dir" => $uploaddir,
			"upload_url" => $uploadurl,
			"max_file_size" => $maxsize,
			"max_number_of_files" => $maxfilecount,
			"accept_file_types" => $filetypes,
			"inline_file_types" => '/\.(' . implode("|", $inlineFileTypes) . ')$/i',
			"image_library" => 0, // Set to 0 to use the GD library to scale and orient images
			"image_versions" => [
				"" => [
					"auto_orient" => TRUE // Automatically rotate images based on EXIF meta data
				],
				Config("UPLOAD_THUMBNAIL_FOLDER") => [
					"max_width" => Config("UPLOAD_THUMBNAIL_WIDTH"),
					"max_height" => Config("UPLOAD_THUMBNAIL_HEIGHT"),
					"jpeg_quality" => 100,
					"png_quality" => 9
				]
			]
		];
		$error_messages = [
			1 => $Language->phrase("UploadErrMsg1"),
			2 => $Language->phrase("UploadErrMsg2"),
			3 => $Language->phrase("UploadErrMsg3"),
			4 => $Language->phrase("UploadErrMsg4"),
			6 => $Language->phrase("UploadErrMsg6"),
			7 => $Language->phrase("UploadErrMsg7"),
			8 => $Language->phrase("UploadErrMsg8"),
			'post_max_size' => $Language->phrase("UploadErrMsgPostMaxSize"),
			'max_file_size' => $Language->phrase("UploadErrMsgMaxFileSize"),
			'min_file_size' => $Language->phrase("UploadErrMsgMinFileSize"),
			'accept_file_types' => $Language->phrase("UploadErrMsgAcceptFileTypes"),
			'max_number_of_files' => $Language->phrase("UploadErrMsgMaxNumberOfFiles"),
			'max_width' => $Language->phrase("UploadErrMsgMaxWidth"),
			'min_width' => $Language->phrase("UploadErrMsgMinWidth"),
			'max_height' => $Language->phrase("UploadErrMsgMaxHeight"),
			'min_height' => $Language->phrase("UploadErrMsgMinHeight")
		];
		ob_end_clean();
		$upload_handler = new UploadHandler($uploadId, $uploadTable, $sessionId, $options, TRUE, $error_messages);

		// Close connection
		//**CloseConnections();

		return TRUE;
	}
}
?>