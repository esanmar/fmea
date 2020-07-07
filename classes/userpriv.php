<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class userpriv extends userlevels
{

	// Page ID
	public $PageID = "userpriv";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Page object name
	public $PageObjName = "userpriv";

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
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (userlevels)
		if (!isset($GLOBALS["userlevels"]) || get_class($GLOBALS["userlevels"]) == PROJECT_NAMESPACE . "userlevels") {
			$GLOBALS["userlevels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["userlevels"];
		}
		if (!isset($GLOBALS["userlevels"]))
			$GLOBALS["userlevels"] = &$this;

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'userpriv');

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
			SaveDebugMessage();
			AddHeader("Location", $url);
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
			return TRUE;
		}
		return FALSE;
	}
	public $Disabled;
	public $TableNameCount;
	public $Privileges = [];
	public $UserLevelList = [];
	public $UserLevelPrivList = [];
	public $TableList = [];

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$Breadcrumb;

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (!$this->setupApiRequest()) {
			$Security = new AdvancedSecurity();
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel(CurrentProjectID() . 'userlevels');
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canAdmin()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("userlevelslist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
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
		$url = CurrentUrl();
		$url = substr($url, strrpos($url, "/") + 1);
		$Breadcrumb = new Breadcrumb();
		$Breadcrumb->add("list", "userlevels", "userlevelslist.php", "", "userlevels");
		$Breadcrumb->add("userpriv", "UserLevelPermission", $url);
		$this->Heading = $Language->phrase("UserLevelPermission");

		// Load user level settings
		$this->UserLevelList = $GLOBALS["USER_LEVELS"];
		$this->UserLevelPrivList = $GLOBALS["USER_LEVEL_PRIVS"];
		$ar = $GLOBALS["USER_LEVEL_TABLES"];

		// Set up allowed table list
		foreach ($ar as $t) {
			if ($t[3]) { // Allowed
				$tempPriv = $Security->getUserLevelPrivEx($t[4] . $t[0], $Security->CurrentUserLevelID);
				if (($tempPriv & ALLOW_ADMIN) == ALLOW_ADMIN) // Allow Admin
					$this->TableList[] = array_merge($t, [$tempPriv]);
			}
		}
		$this->TableNameCount = count($this->TableList);

		// Get action
		if (Post("action") == "") {
			$this->CurrentAction = "show"; // Display with input box

			// Load key from QueryString
			if (Get("userlevelid") !== NULL) {
				$this->userlevelid->setQueryStringValue(Get("userlevelid"));
			} else {
				$this->terminate("userlevelslist.php"); // Return to list
			}
			if ($this->userlevelid->QueryStringValue == "-1") {
				$this->Disabled = " disabled";
			} else {
				$this->Disabled = "";
			}
		} else {
			$this->CurrentAction = Post("action");

			// Get fields from form
			$this->userlevelid->setFormValue(Post("x_userlevelid"));
			for ($i = 0; $i < $this->TableNameCount; $i++) {
				if (Post("table_" . $i) !== NULL) {
					$this->Privileges[$i] = (int)Post("add_" . $i) +
						(int)Post("delete_" . $i) + (int)Post("edit_" . $i) +
						(int)Post("list_" . $i) + (int)Post("view_" . $i) +
						(int)Post("search_" . $i) + (int)Post("admin_" . $i) +
						(int)Post("import_" . $i) + (int)Post("lookup_" . $i);
				}
			}
		}

		// Should not edit own permissions
		if ($this->userlevelid->CurrentValue == $Security->CurrentUserLevelID)
			$this->terminate("userlevelslist.php"); // Return to list
		switch ($this->CurrentAction) {
			case "show": // Display
				if (!$Security->setupUserLevelEx()) // Get all User Level info
					$this->terminate("userlevelslist.php"); // Return to list
				$ar = [];
				for ($i = 0; $i < $this->TableNameCount; $i++) {
					$tempPriv = $Security->getUserLevelPrivEx($this->TableList[$i][4] . $this->TableList[$i][0], $this->userlevelid->CurrentValue);
					$ar[] = ["table" => ConvertToUtf8($this->getTableCaption($i)), "index" => $i, "permission" => $tempPriv, "allowed" => $this->TableList[$i][5]];
				}
				$this->Privileges["disabled"] = $this->Disabled;
				$this->Privileges["permissions"] = $ar;
				$this->Privileges["add"] = 1; // Add
				$this->Privileges["delete"] = 2; // Delete
				$this->Privileges["edit"] = 4; // Edit
				$this->Privileges["list"] = 8; // List
				$this->Privileges["report"] = 8; // Report
				$this->Privileges["admin"] = 16; // Admin
				$this->Privileges["view"] = 32; // View
				$this->Privileges["search"] = 64; // Search
				$this->Privileges["import"] = 128; // Import
				$this->Privileges["lookup"] = 256; // Lookup
				break;
			case "update": // Update
				if ($this->editRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message

					// Alternatively, comment out the following line to go back to this page
					$this->terminate("userlevelslist.php"); // Return to list
				}
		}
	}

	// Update privileges
	protected function editRow()
	{
		global $Security;
		$c = Conn(Config("USER_LEVEL_PRIV_DBID"));
		foreach ($this->Privileges as $i => $privilege) {
			$sql = "SELECT * FROM " . Config("USER_LEVEL_PRIV_TABLE") . " WHERE " .
				Config("USER_LEVEL_PRIV_TABLE_NAME_FIELD") . " = '" . AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], Config("USER_LEVEL_PRIV_DBID")) . "' AND " .
				Config("USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD") . " = " . $this->userlevelid->CurrentValue;
			$privilege = $privilege & $this->TableList[$i][5]; // Set maximum allowed privilege (protect from hacking) 
			$rs = $c->execute($sql);
			if ($rs && !$rs->EOF) {
				$sql = "UPDATE " . Config("USER_LEVEL_PRIV_TABLE") . " SET " . Config("USER_LEVEL_PRIV_PRIV_FIELD") . " = " . $privilege . " WHERE " .
					Config("USER_LEVEL_PRIV_TABLE_NAME_FIELD") . " = '" . AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], Config("USER_LEVEL_PRIV_DBID")) . "' AND " .
					Config("USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD") . " = " . $this->userlevelid->CurrentValue;
				$c->execute($sql);
			} else {
				$sql = "INSERT INTO " . Config("USER_LEVEL_PRIV_TABLE") . " (" . Config("USER_LEVEL_PRIV_TABLE_NAME_FIELD") . ", " . Config("USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD") . ", " . Config("USER_LEVEL_PRIV_PRIV_FIELD") . ") VALUES ('" . AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0], Config("USER_LEVEL_PRIV_DBID")) . "', " . $this->userlevelid->CurrentValue . ", " . $privilege . ")";
				$c->execute($sql);
			}
			if ($rs)
				$rs->close();
		}
		$Security->setupUserLevel();
		return TRUE;
	}

	// Get table caption
	protected function getTableCaption($i)
	{
		global $Language;
		$caption = "";
		if ($i < $this->TableNameCount) {
			$caption = $Language->TablePhrase($this->TableList[$i][1], "TblCaption");
			if ($caption == "")
				$caption = $this->TableList[$i][2];
			if ($caption == "") {
				$caption = $this->TableList[$i][0];
				$caption = preg_replace('/^\{\w{8}-\w{4}-\w{4}-\w{4}-\w{12}\}/', '', $caption); // Remove project id
			}
		}
		return $caption;
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
} // End class
?>