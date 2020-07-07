<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class actions_list extends actions
{

	// Page ID
	public $PageID = "list";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'actions';

	// Page object name
	public $PageObjName = "actions_list";

	// Grid form hidden field names
	public $FormName = "factionslist";
	public $FormActionName = "k_action";
	public $FormKeyName = "k_key";
	public $FormOldKeyName = "k_oldkey";
	public $FormBlankRowName = "k_blankrow";
	public $FormKeyCountName = "key_count";

	// Page URLs
	public $AddUrl;
	public $EditUrl;
	public $CopyUrl;
	public $DeleteUrl;
	public $ViewUrl;
	public $ListUrl;

	// Export URLs
	public $ExportPrintUrl;
	public $ExportHtmlUrl;
	public $ExportExcelUrl;
	public $ExportWordUrl;
	public $ExportXmlUrl;
	public $ExportCsvUrl;
	public $ExportPdfUrl;

	// Custom export
	public $ExportExcelCustom = TRUE;
	public $ExportWordCustom = TRUE;
	public $ExportPdfCustom = TRUE;
	public $ExportEmailCustom = TRUE;

	// Update URLs
	public $InlineAddUrl;
	public $InlineCopyUrl;
	public $InlineEditUrl;
	public $GridAddUrl;
	public $GridEditUrl;
	public $MultiDeleteUrl;
	public $MultiUpdateUrl;

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
		if ($this->TableName)
			return $Language->phrase($this->PageID);
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
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
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
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
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

		// Table object (actions)
		if (!isset($GLOBALS["actions"]) || get_class($GLOBALS["actions"]) == PROJECT_NAMESPACE . "actions") {
			$GLOBALS["actions"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["actions"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->pageUrl() . "export=print";
		$this->ExportExcelUrl = $this->pageUrl() . "export=excel";
		$this->ExportWordUrl = $this->pageUrl() . "export=word";
		$this->ExportPdfUrl = $this->pageUrl() . "export=pdf";
		$this->ExportHtmlUrl = $this->pageUrl() . "export=html";
		$this->ExportXmlUrl = $this->pageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->pageUrl() . "export=csv";
		$this->AddUrl = "actionsadd.php";
		$this->InlineAddUrl = $this->pageUrl() . "action=add";
		$this->GridAddUrl = $this->pageUrl() . "action=gridadd";
		$this->GridEditUrl = $this->pageUrl() . "action=gridedit";
		$this->MultiDeleteUrl = "actionsdelete.php";
		$this->MultiUpdateUrl = "actionsupdate.php";

		// Table object (processf)
		if (!isset($GLOBALS['processf']))
			$GLOBALS['processf'] = new processf();

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'list');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'actions');

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

		// List options
		$this->ListOptions = new ListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new ListOptions("div");
		$this->ExportOptions->TagClassName = "ew-export-option";

		// Import options
		$this->ImportOptions = new ListOptions("div");
		$this->ImportOptions->TagClassName = "ew-import-option";

		// Other options
		if (!$this->OtherOptions)
			$this->OtherOptions = new ListOptionsArray();
		$this->OtherOptions["addedit"] = new ListOptions("div");
		$this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
		$this->OtherOptions["detail"] = new ListOptions("div");
		$this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
		$this->OtherOptions["action"] = new ListOptions("div");
		$this->OtherOptions["action"]->TagClassName = "ew-action-option";

		// Filter options
		$this->FilterOptions = new ListOptions("div");
		$this->FilterOptions->TagClassName = "ew-filter-option factionslistsrch";

		// List actions
		$this->ListActions = new ListActions();
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;
		if (Post("customexport") === NULL) {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $actions;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
			if (is_array(@$_SESSION[SESSION_TEMP_IMAGES])) // Restore temp images
				$TempImages = @$_SESSION[SESSION_TEMP_IMAGES];
			if (Post("data") !== NULL)
				$content = Post("data");
			$ExportFileName = Post("filename", "");
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($actions);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
	if ($this->CustomExport) { // Save temp images array for custom export
		if (is_array($TempImages))
			$_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
	}
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

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = [];
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
			}
		}
		return $rows;
	}

	// Get record from array
	protected function getRecordFromArray($ar)
	{
		$row = [];
		if (is_array($ar)) {
			foreach ($ar as $fldname => $val) {
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									Config("API_FIELD_NAME") . "=" . $fld->Param . "&" .
									Config("API_KEY_NAME") . "=" . rawurlencode($this->getRecordKeyValue($ar)))); //*** need to add this? API may not be in the same folder
								$row[$fldname] = ["mimeType" => ContentType($val), "url" => $url];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
								$row[$fldname] = ["mimeType" => MimeContentType($val), "url" => FullUrl($fld->hrefPath() . $val)];
							} else { // Multiple files
								$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
								$ar = [];
								foreach ($files as $file) {
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => FullUrl($fld->hrefPath() . $file)];
								}
								$row[$fldname] = $ar;
							}
						}
					} else {
						$row[$fldname] = $val;
					}
				}
			}
		}
		return $row;
	}

	// Get record key value from array
	protected function getRecordKeyValue($ar)
	{
		$key = "";
		if (is_array($ar)) {
			$key .= @$ar['idProcess'] . Config("COMPOSITE_KEY_SEPARATOR");
			$key .= @$ar['idCause'];
		}
		return $key;
	}

	/**
	 * Hide fields for add/edit
	 *
	 * @return void
	 */
	protected function hideFieldsForAddEdit()
	{
	}

	// Lookup data
	public function lookup()
	{
		global $Language, $Security;
		if (!isset($Language))
			$Language = new Language(Config("LANGUAGE_FOLDER"), Post("language", ""));

		// Set up API request
		if (!$this->setupApiRequest())
			return FALSE;

		// Get lookup object
		$fieldName = Post("field");
		if (!array_key_exists($fieldName, $this->fields))
			return FALSE;
		$lookupField = $this->fields[$fieldName];
		$lookup = $lookupField->Lookup;
		if ($lookup === NULL)
			return FALSE;
		$tbl = $lookup->getTable();
		if (!$Security->allowLookup(Config("PROJECT_ID") . $tbl->TableName)) // Lookup permission
			return FALSE;

		// Get lookup parameters
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Get("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
			$lookup->FilterFields = []; // Skip parent fields if any
			$lookup->FilterValues[] = $keys; // Lookup values
			$pageSize = -1; // Show all records
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect != "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter != "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy != "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson($this); // Use settings from current page
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

	// Class variables
	public $ListOptions; // List options
	public $ExportOptions; // Export options
	public $SearchOptions; // Search options
	public $OtherOptions; // Other options
	public $FilterOptions; // Filter options
	public $ImportOptions; // Import options
	public $ListActions; // List actions
	public $SelectedCount = 0;
	public $SelectedIndex = 0;
	public $DisplayRecords = 10;
	public $StartRecord;
	public $StopRecord;
	public $TotalRecords = 0;
	public $RecordRange = 10;
	public $PageSizes = "3,10,20,50,-1"; // Page sizes (comma separated)
	public $DefaultSearchWhere = ""; // Default search WHERE clause
	public $SearchWhere = ""; // Search WHERE clause
	public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
	public $SearchRowCount = 0; // For extended search
	public $SearchColumnCount = 0; // For extended search
	public $SearchFieldsPerRow = 1; // For extended search
	public $RecordCount = 0; // Record count
	public $EditRowCount;
	public $StartRowCount = 1;
	public $RowCount = 0;
	public $Attrs = []; // Row attributes and cell attributes
	public $RowIndex = 0; // Row index
	public $KeyCount = 0; // Key count
	public $RowAction = ""; // Row action
	public $RowOldKey = ""; // Row old key (for copy)
	public $MultiColumnClass = "col-sm";
	public $MultiColumnEditClass = "w-100";
	public $DbMasterFilter = ""; // Master filter
	public $DbDetailFilter = ""; // Detail filter
	public $MasterRecordExists;
	public $MultiSelectKey;
	public $Command;
	public $RestoreSearch = FALSE;
	public $HashValue; // Hash value
	public $DetailPages;
	public $OldRecordset;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SearchError;

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (!$this->setupApiRequest()) {
			$Security = new AdvancedSecurity();
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canList()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				$this->terminate(GetUrl("index.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
			}
		}

		// Create form object
		$CurrentForm = new HttpForm();

		// Get export parameters
		$custom = "";
		if (Param("export") !== NULL) {
			$this->Export = Param("export");
			$custom = Param("custom", "");
		} elseif (IsPost()) {
			if (Post("exporttype") !== NULL)
				$this->Export = Post("exporttype");
			$custom = Post("custom", "");
		} elseif (Get("cmd") == "json") {
			$this->Export = Get("cmd");
		} else {
			$this->setExportReturnUrl(CurrentUrl());
		}
		$ExportFileName = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->isExport() && $custom != "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$CustomExportType = $this->CustomExport;
		$ExportType = $this->Export; // Get export parameter, used in header

		// Custom export (post back from ew.applyTemplate), export and terminate page
		if (Post("customexport") !== NULL) {
			$this->CustomExport = Post("customexport");
			$this->Export = $this->CustomExport;
			$this->terminate();
		}

		// Update Export URLs
		if (Config("USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (Config("USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = Param("action"); // Set up current action

		// Get grid add count
		$gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->setupListOptions();

		// Setup export options
		$this->setupExportOptions();

		// Setup import options
		$this->setupImportOptions();
		$this->idProcess->setVisibility();
		$this->idCause->setVisibility();
		$this->potentialCauses->setVisibility();
		$this->currentPreventiveControlMethod->setVisibility();
		$this->severity->setVisibility();
		$this->occurrence->setVisibility();
		$this->currentControlMethod->setVisibility();
		$this->detection->setVisibility();
		$this->RPNCalc->setVisibility();
		$this->rpn->Visible = FALSE;
		$this->recomendedAction->setVisibility();
		$this->idResponsible->setVisibility();
		$this->targetDate->setVisibility();
		$this->revisedKc->setVisibility();
		$this->expectedSeverity->setVisibility();
		$this->expectedOccurrence->setVisibility();
		$this->expectedDetection->setVisibility();
		$this->expectedRpn->Visible = FALSE;
		$this->expectedRPNPAO->setVisibility();
		$this->expectedClosureDate->setVisibility();
		$this->recomendedActiondet->setVisibility();
		$this->idResponsibleDet->setVisibility();
		$this->targetDatedet->setVisibility();
		$this->kcdet->setVisibility();
		$this->expectedSeveritydet->setVisibility();
		$this->expectedOccurrencedet->setVisibility();
		$this->expectedDetectiondet->setVisibility();
		$this->expectedRpndet->Visible = FALSE;
		$this->expectedRPNPAD->setVisibility();
		$this->revisedClosureDatedet->setVisibility();
		$this->revisedClosureDate->Visible = FALSE;
		$this->perfomedAction->Visible = FALSE;
		$this->revisedSeverity->setVisibility();
		$this->revisedOccurrence->setVisibility();
		$this->revisedDetection->setVisibility();
		$this->revisedRpn->Visible = FALSE;
		$this->revisedRPNCalc->setVisibility();
		$this->hideFieldsForAddEdit();

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

		// Set up master detail parameters
		$this->setupMasterParms();

		// Setup other options
		$this->setupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions["checkbox"]->Visible = TRUE;
				break;
			}
		}

		// Set up lookup cache
		$this->setupLookupOptions($this->idCause);
		$this->setupLookupOptions($this->idResponsible);
		$this->setupLookupOptions($this->idResponsibleDet);
		$this->AllowAddDeleteRow = FALSE; // Do not allow add/delete row

		// Search filters
		$srchAdvanced = ""; // Advanced search filter
		$srchBasic = ""; // Basic search filter
		$filter = "";

		// Get command
		$this->Command = strtolower(Get("cmd"));
		if ($this->isPageRequest()) { // Validate request

			// Process list action first
			if ($this->processListAction()) // Ajax request
				$this->terminate();

			// Set up records per page
			$this->setupDisplayRecords();

			// Handle reset command
			$this->resetCmd();

			// Set up Breadcrumb
			if (!$this->isExport())
				$this->setupBreadcrumb();

			// Check QueryString parameters
			if (Get("action") !== NULL) {
				$this->CurrentAction = Get("action");

				// Clear inline mode
				if ($this->isCancel())
					$this->clearInlineMode();

				// Switch to inline add mode
				if ($this->isAdd() || $this->isCopy())
					$this->inlineAddMode();

				// Switch to grid add mode
				if ($this->isGridAdd())
					$this->gridAddMode();
			} else {
				if (Post("action") !== NULL) {
					$this->CurrentAction = Post("action"); // Get action

					// Process import
					if ($this->isImport()) {
						$this->import(Post(Config("API_FILE_TOKEN_NAME")));
						$this->terminate();
					}

					// Insert Inline
					if ($this->isInsert() && @$_SESSION[SESSION_INLINE_MODE] == "add")
						$this->inlineInsert();

					// Grid Insert
					if ($this->isGridInsert() && @$_SESSION[SESSION_INLINE_MODE] == "gridadd") {
						if ($this->validateGridForm()) {
							$gridInsert = $this->gridInsert();
						} else {
							$gridInsert = FALSE;
							$this->setFailureMessage($FormError);
						}
						if ($gridInsert) {
						} else {
							$this->EventCancelled = TRUE;
							$this->gridAddMode(); // Stay in Grid add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->isExport()) {
				$this->ListOptions->hideAllOptions(["sequence"]);
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->isGridAdd() || $this->isGridEdit()) {
				$this->ListOptions->hideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->isExport() || $this->CurrentAction) {
				$this->ExportOptions->hideAllOptions();
				$this->FilterOptions->hideAllOptions();
				$this->ImportOptions->hideAllOptions();
			}

			// Hide other options
			if ($this->isExport())
				$this->OtherOptions->hideAllOptions();

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->isGridAdd() || $this->isGridEdit()) {
					$item = $this->ListOptions["griddelete"];
					if ($item)
						$item->Visible = TRUE;
				}
			}

			// Get default search criteria
			AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(TRUE));
			AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(TRUE));

			// Get basic search values
			$this->loadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->loadSearchValues(); // Get search values

			// Process filter list
			if ($this->processFilterList())
				$this->terminate();
			if (!$this->validateSearch())
				$this->setFailureMessage($SearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms())
				$this->restoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->setupSortOrder();

			// Get basic search criteria
			if ($SearchError == "")
				$srchBasic = $this->basicSearchWhere();

			// Get search criteria for advanced search
			if ($SearchError == "")
				$srchAdvanced = $this->advancedSearchWhere();
		}

		// Restore display records
		if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
			$this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecords = 10; // Load default
			$this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
		}

		// Load Sorting Order
		if ($this->Command != "json")
			$this->loadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->checkSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->loadDefault();
			if ($this->BasicSearch->Keyword != "")
				$srchBasic = $this->basicSearchWhere();

			// Load advanced search from default
			if ($this->loadAdvancedSearchDefault()) {
				$srchAdvanced = $this->advancedSearchWhere();
			}
		}

		// Restore search settings from Session
		if ($SearchError == "")
			$this->loadAdvancedSearch();

		// Build search criteria
		AddFilter($this->SearchWhere, $srchAdvanced);
		AddFilter($this->SearchWhere, $srchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRecord = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRecord);
		} elseif ($this->Command != "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$filter = "";
		if (!$Security->canList())
			$filter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
		AddFilter($filter, $this->DbDetailFilter);
		AddFilter($filter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "processf") {
			global $processf;
			$rsmaster = $processf->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("processflist.php"); // Return to master page
			} else {
				$processf->loadListRowValues($rsmaster);
				$processf->RowType = ROWTYPE_MASTER; // Master row
				$processf->renderListRow();
				$rsmaster->close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSql = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $filter;
		} else {
			$this->setSessionWhere($filter);
			$this->CurrentFilter = "";
		}

		// Export data only
		if (!$this->CustomExport && in_array($this->Export, array_keys(Config("EXPORT_CLASSES")))) {
			$this->exportData();
			$this->terminate();
		}
		if ($this->isGridAdd()) {
			$this->CurrentFilter = "0=1";
			$this->StartRecord = 1;
			$this->DisplayRecords = $this->GridAddRowCount;
			$this->TotalRecords = $this->DisplayRecords;
			$this->StopRecord = $this->DisplayRecords;
		} else {
			$selectLimit = $this->UseSelectLimit;
			if ($selectLimit) {
				$this->TotalRecords = $this->listRecordCount();
			} else {
				if ($this->Recordset = $this->loadRecordset())
					$this->TotalRecords = $this->Recordset->RecordCount();
			}
			$this->StartRecord = 1;
			if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) // Display all records
				$this->DisplayRecords = $this->TotalRecords;
			if (!($this->isExport() && $this->ExportAll)) // Set up start record position
				$this->setupStartRecord();
			if ($selectLimit)
				$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

			// Set no record found message
			if (!$this->CurrentAction && $this->TotalRecords == 0) {
				if (!$Security->canList())
					$this->setWarningMessage(DeniedMessage());
				if ($this->SearchWhere == "0=101")
					$this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
				else
					$this->setWarningMessage($Language->phrase("NoRecord"));
			}
		}

		// Search options
		$this->setupSearchOptions();

		// Set up search panel class
		if ($this->SearchWhere != "")
			AppendClass($this->SearchPanelClass, "show");

		// Normal return
		if (IsApi()) {
			$rows = $this->getRecordsFromRecordset($this->Recordset);
			$this->Recordset->close();
			WriteJson(["success" => TRUE, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
			$this->terminate(TRUE);
		}

		// Set up pager
		$this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
	}

	// Set up number of records displayed per page
	protected function setupDisplayRecords()
	{
		$wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
		if ($wrk != "") {
			if (is_numeric($wrk)) {
				$this->DisplayRecords = (int)$wrk;
			} else {
				if (SameText($wrk, "all")) { // Display all records
					$this->DisplayRecords = -1;
				} else {
					$this->DisplayRecords = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecords); // Save to Session

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Exit inline mode
	protected function clearInlineMode()
	{
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	protected function gridAddMode()
	{
		$this->CurrentAction = "gridadd";
		$_SESSION[SESSION_INLINE_MODE] = "gridadd";
		$this->hideFieldsForAddEdit();
	}

	// Switch to Inline Add mode
	protected function inlineAddMode()
	{
		global $Security, $Language;
		if (!$Security->canAdd())
			return FALSE; // Add not allowed
		$this->CurrentAction = "add";
		$_SESSION[SESSION_INLINE_MODE] = "add"; // Enable inline add
		return TRUE;
	}

	// Perform update to Inline Add/Copy record
	protected function inlineInsert()
	{
		global $Language, $CurrentForm, $FormError;
		$this->loadOldRecord(); // Load old record
		$CurrentForm->Index = 0;
		$this->loadFormValues(); // Get form values

		// Validate form
		if (!$this->validateForm()) {
			$this->setFailureMessage($FormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->addRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up add success message
			$this->clearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Build filter for all keys
	protected function buildKeyFilter()
	{
		global $CurrentForm;
		$wrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$CurrentForm->Index = $rowindex;
		$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		while ($thisKey != "") {
			if ($this->setupKeyValues($thisKey)) {
				$filter = $this->getRecordFilter();
				if ($wrkFilter != "")
					$wrkFilter .= " OR ";
				$wrkFilter .= $filter;
			} else {
				$wrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$CurrentForm->Index = $rowindex;
			$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		}
		return $wrkFilter;
	}

	// Set up key values
	protected function setupKeyValues($key)
	{
		$arKeyFlds = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
		if (count($arKeyFlds) >= 2) {
			$this->idProcess->setOldValue($arKeyFlds[0]);
			if (!is_numeric($this->idProcess->OldValue))
				return FALSE;
			$this->idCause->setOldValue($arKeyFlds[1]);
		}
		return TRUE;
	}

	// Perform Grid Add
	public function gridInsert()
	{
		global $Language, $CurrentForm, $FormError;
		$rowindex = 1;
		$gridInsert = FALSE;
		$conn = $this->getConnection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->beginTrans();

		// Init key filter
		$wrkfilter = "";
		$addcnt = 0;
		$key = "";

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "" && $rowaction != "insert")
				continue; // Skip
			$this->loadFormValues(); // Get form values
			if (!$this->emptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->validateForm()) {
					$gridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($FormError);
				} else {
					$gridInsert = $this->addRow($this->OldRecordset); // Insert this row
				}
				if ($gridInsert) {
					if ($key != "")
						$key .= Config("COMPOSITE_KEY_SEPARATOR");
					$key .= $this->idProcess->CurrentValue;
					if ($key != "")
						$key .= Config("COMPOSITE_KEY_SEPARATOR");
					$key .= $this->idCause->CurrentValue;

					// Add filter for this record
					$filter = $this->getRecordFilter();
					if ($wrkfilter != "")
						$wrkfilter .= " OR ";
					$wrkfilter .= $filter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->phrase("NoAddRecord"));
			$gridInsert = FALSE;
		}
		if ($gridInsert) {
			$conn->commitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $wrkfilter;
			$sql = $this->getCurrentSql();
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->phrase("InsertSuccess")); // Set up insert success message
			$this->clearInlineMode(); // Clear grid add mode
		} else {
			$conn->rollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
		}
		return $gridInsert;
	}

	// Check if empty row
	public function emptyRow()
	{
		global $CurrentForm;
		if ($CurrentForm->hasValue("x_idProcess") && $CurrentForm->hasValue("o_idProcess") && $this->idProcess->CurrentValue != $this->idProcess->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_idCause") && $CurrentForm->hasValue("o_idCause") && $this->idCause->CurrentValue != $this->idCause->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_potentialCauses") && $CurrentForm->hasValue("o_potentialCauses") && $this->potentialCauses->CurrentValue != $this->potentialCauses->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_currentPreventiveControlMethod") && $CurrentForm->hasValue("o_currentPreventiveControlMethod") && $this->currentPreventiveControlMethod->CurrentValue != $this->currentPreventiveControlMethod->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_severity") && $CurrentForm->hasValue("o_severity") && $this->severity->CurrentValue != $this->severity->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_occurrence") && $CurrentForm->hasValue("o_occurrence") && $this->occurrence->CurrentValue != $this->occurrence->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_currentControlMethod") && $CurrentForm->hasValue("o_currentControlMethod") && $this->currentControlMethod->CurrentValue != $this->currentControlMethod->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_detection") && $CurrentForm->hasValue("o_detection") && $this->detection->CurrentValue != $this->detection->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_RPNCalc") && $CurrentForm->hasValue("o_RPNCalc") && $this->RPNCalc->CurrentValue != $this->RPNCalc->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_recomendedAction") && $CurrentForm->hasValue("o_recomendedAction") && $this->recomendedAction->CurrentValue != $this->recomendedAction->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_idResponsible") && $CurrentForm->hasValue("o_idResponsible") && $this->idResponsible->CurrentValue != $this->idResponsible->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_targetDate") && $CurrentForm->hasValue("o_targetDate") && $this->targetDate->CurrentValue != $this->targetDate->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_revisedKc") && $CurrentForm->hasValue("o_revisedKc") && ConvertToBool($this->revisedKc->CurrentValue) != ConvertToBool($this->revisedKc->OldValue))
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedSeverity") && $CurrentForm->hasValue("o_expectedSeverity") && $this->expectedSeverity->CurrentValue != $this->expectedSeverity->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedOccurrence") && $CurrentForm->hasValue("o_expectedOccurrence") && $this->expectedOccurrence->CurrentValue != $this->expectedOccurrence->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedDetection") && $CurrentForm->hasValue("o_expectedDetection") && $this->expectedDetection->CurrentValue != $this->expectedDetection->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedRPNPAO") && $CurrentForm->hasValue("o_expectedRPNPAO") && $this->expectedRPNPAO->CurrentValue != $this->expectedRPNPAO->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedClosureDate") && $CurrentForm->hasValue("o_expectedClosureDate") && $this->expectedClosureDate->CurrentValue != $this->expectedClosureDate->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_recomendedActiondet") && $CurrentForm->hasValue("o_recomendedActiondet") && $this->recomendedActiondet->CurrentValue != $this->recomendedActiondet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_idResponsibleDet") && $CurrentForm->hasValue("o_idResponsibleDet") && $this->idResponsibleDet->CurrentValue != $this->idResponsibleDet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_targetDatedet") && $CurrentForm->hasValue("o_targetDatedet") && $this->targetDatedet->CurrentValue != $this->targetDatedet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_kcdet") && $CurrentForm->hasValue("o_kcdet") && ConvertToBool($this->kcdet->CurrentValue) != ConvertToBool($this->kcdet->OldValue))
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedSeveritydet") && $CurrentForm->hasValue("o_expectedSeveritydet") && $this->expectedSeveritydet->CurrentValue != $this->expectedSeveritydet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedOccurrencedet") && $CurrentForm->hasValue("o_expectedOccurrencedet") && $this->expectedOccurrencedet->CurrentValue != $this->expectedOccurrencedet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedDetectiondet") && $CurrentForm->hasValue("o_expectedDetectiondet") && $this->expectedDetectiondet->CurrentValue != $this->expectedDetectiondet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_expectedRPNPAD") && $CurrentForm->hasValue("o_expectedRPNPAD") && $this->expectedRPNPAD->CurrentValue != $this->expectedRPNPAD->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_revisedClosureDatedet") && $CurrentForm->hasValue("o_revisedClosureDatedet") && $this->revisedClosureDatedet->CurrentValue != $this->revisedClosureDatedet->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_revisedSeverity") && $CurrentForm->hasValue("o_revisedSeverity") && $this->revisedSeverity->CurrentValue != $this->revisedSeverity->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_revisedOccurrence") && $CurrentForm->hasValue("o_revisedOccurrence") && $this->revisedOccurrence->CurrentValue != $this->revisedOccurrence->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_revisedDetection") && $CurrentForm->hasValue("o_revisedDetection") && $this->revisedDetection->CurrentValue != $this->revisedDetection->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_revisedRPNCalc") && $CurrentForm->hasValue("o_revisedRPNCalc") && $this->revisedRPNCalc->CurrentValue != $this->revisedRPNCalc->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	public function validateGridForm()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else if (!$this->validateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	public function getGridFormValues()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = [];

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->getFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	public function restoreCurrentRowFormValues($idx)
	{
		global $CurrentForm;

		// Get row based on current index
		$CurrentForm->Index = $idx;
		$this->loadFormValues(); // Load form values
	}

	// Get list of filters
	public function getFilterList()
	{
		global $UserProfile;

		// Initialize
		$filterList = "";
		$savedFilterList = "";
		$filterList = Concat($filterList, $this->idProcess->AdvancedSearch->toJson(), ","); // Field idProcess
		$filterList = Concat($filterList, $this->idCause->AdvancedSearch->toJson(), ","); // Field idCause
		$filterList = Concat($filterList, $this->potentialCauses->AdvancedSearch->toJson(), ","); // Field potentialCauses
		$filterList = Concat($filterList, $this->currentPreventiveControlMethod->AdvancedSearch->toJson(), ","); // Field currentPreventiveControlMethod
		$filterList = Concat($filterList, $this->severity->AdvancedSearch->toJson(), ","); // Field severity
		$filterList = Concat($filterList, $this->occurrence->AdvancedSearch->toJson(), ","); // Field occurrence
		$filterList = Concat($filterList, $this->currentControlMethod->AdvancedSearch->toJson(), ","); // Field currentControlMethod
		$filterList = Concat($filterList, $this->detection->AdvancedSearch->toJson(), ","); // Field detection
		$filterList = Concat($filterList, $this->RPNCalc->AdvancedSearch->toJson(), ","); // Field RPNCalc
		$filterList = Concat($filterList, $this->recomendedAction->AdvancedSearch->toJson(), ","); // Field recomendedAction
		$filterList = Concat($filterList, $this->idResponsible->AdvancedSearch->toJson(), ","); // Field idResponsible
		$filterList = Concat($filterList, $this->targetDate->AdvancedSearch->toJson(), ","); // Field targetDate
		$filterList = Concat($filterList, $this->revisedKc->AdvancedSearch->toJson(), ","); // Field revisedKc
		$filterList = Concat($filterList, $this->expectedSeverity->AdvancedSearch->toJson(), ","); // Field expectedSeverity
		$filterList = Concat($filterList, $this->expectedOccurrence->AdvancedSearch->toJson(), ","); // Field expectedOccurrence
		$filterList = Concat($filterList, $this->expectedDetection->AdvancedSearch->toJson(), ","); // Field expectedDetection
		$filterList = Concat($filterList, $this->expectedRpn->AdvancedSearch->toJson(), ","); // Field expectedRpn
		$filterList = Concat($filterList, $this->expectedRPNPAO->AdvancedSearch->toJson(), ","); // Field expectedRPNPAO
		$filterList = Concat($filterList, $this->expectedClosureDate->AdvancedSearch->toJson(), ","); // Field expectedClosureDate
		$filterList = Concat($filterList, $this->recomendedActiondet->AdvancedSearch->toJson(), ","); // Field recomendedActiondet
		$filterList = Concat($filterList, $this->idResponsibleDet->AdvancedSearch->toJson(), ","); // Field idResponsibleDet
		$filterList = Concat($filterList, $this->targetDatedet->AdvancedSearch->toJson(), ","); // Field targetDatedet
		$filterList = Concat($filterList, $this->kcdet->AdvancedSearch->toJson(), ","); // Field kcdet
		$filterList = Concat($filterList, $this->expectedSeveritydet->AdvancedSearch->toJson(), ","); // Field expectedSeveritydet
		$filterList = Concat($filterList, $this->expectedOccurrencedet->AdvancedSearch->toJson(), ","); // Field expectedOccurrencedet
		$filterList = Concat($filterList, $this->expectedDetectiondet->AdvancedSearch->toJson(), ","); // Field expectedDetectiondet
		$filterList = Concat($filterList, $this->expectedRPNPAD->AdvancedSearch->toJson(), ","); // Field expectedRPNPAD
		$filterList = Concat($filterList, $this->revisedClosureDatedet->AdvancedSearch->toJson(), ","); // Field revisedClosureDatedet
		$filterList = Concat($filterList, $this->revisedSeverity->AdvancedSearch->toJson(), ","); // Field revisedSeverity
		$filterList = Concat($filterList, $this->revisedOccurrence->AdvancedSearch->toJson(), ","); // Field revisedOccurrence
		$filterList = Concat($filterList, $this->revisedDetection->AdvancedSearch->toJson(), ","); // Field revisedDetection
		$filterList = Concat($filterList, $this->revisedRpn->AdvancedSearch->toJson(), ","); // Field revisedRpn
		$filterList = Concat($filterList, $this->revisedRPNCalc->AdvancedSearch->toJson(), ","); // Field revisedRPNCalc
		if ($this->BasicSearch->Keyword != "") {
			$wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
			$filterList = Concat($filterList, $wrk, ",");
		}

		// Return filter list in JSON
		if ($filterList != "")
			$filterList = "\"data\":{" . $filterList . "}";
		if ($savedFilterList != "")
			$filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
		return ($filterList != "") ? "{" . $filterList . "}" : "null";
	}

	// Process filter list
	protected function processFilterList()
	{
		global $UserProfile;
		if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
			$filters = Post("filters");
			$UserProfile->setSearchFilters(CurrentUserName(), "factionslistsrch", $filters);
			WriteJson([["success" => TRUE]]); // Success
			return TRUE;
		} elseif (Post("cmd") == "resetfilter") {
			$this->restoreFilterList();
		}
		return FALSE;
	}

	// Restore list of filters
	protected function restoreFilterList()
	{

		// Return if not reset filter
		if (Post("cmd") !== "resetfilter")
			return FALSE;
		$filter = json_decode(Post("filter"), TRUE);
		$this->Command = "search";

		// Field idProcess
		$this->idProcess->AdvancedSearch->SearchValue = @$filter["x_idProcess"];
		$this->idProcess->AdvancedSearch->SearchOperator = @$filter["z_idProcess"];
		$this->idProcess->AdvancedSearch->SearchCondition = @$filter["v_idProcess"];
		$this->idProcess->AdvancedSearch->SearchValue2 = @$filter["y_idProcess"];
		$this->idProcess->AdvancedSearch->SearchOperator2 = @$filter["w_idProcess"];
		$this->idProcess->AdvancedSearch->save();

		// Field idCause
		$this->idCause->AdvancedSearch->SearchValue = @$filter["x_idCause"];
		$this->idCause->AdvancedSearch->SearchOperator = @$filter["z_idCause"];
		$this->idCause->AdvancedSearch->SearchCondition = @$filter["v_idCause"];
		$this->idCause->AdvancedSearch->SearchValue2 = @$filter["y_idCause"];
		$this->idCause->AdvancedSearch->SearchOperator2 = @$filter["w_idCause"];
		$this->idCause->AdvancedSearch->save();

		// Field potentialCauses
		$this->potentialCauses->AdvancedSearch->SearchValue = @$filter["x_potentialCauses"];
		$this->potentialCauses->AdvancedSearch->SearchOperator = @$filter["z_potentialCauses"];
		$this->potentialCauses->AdvancedSearch->SearchCondition = @$filter["v_potentialCauses"];
		$this->potentialCauses->AdvancedSearch->SearchValue2 = @$filter["y_potentialCauses"];
		$this->potentialCauses->AdvancedSearch->SearchOperator2 = @$filter["w_potentialCauses"];
		$this->potentialCauses->AdvancedSearch->save();

		// Field currentPreventiveControlMethod
		$this->currentPreventiveControlMethod->AdvancedSearch->SearchValue = @$filter["x_currentPreventiveControlMethod"];
		$this->currentPreventiveControlMethod->AdvancedSearch->SearchOperator = @$filter["z_currentPreventiveControlMethod"];
		$this->currentPreventiveControlMethod->AdvancedSearch->SearchCondition = @$filter["v_currentPreventiveControlMethod"];
		$this->currentPreventiveControlMethod->AdvancedSearch->SearchValue2 = @$filter["y_currentPreventiveControlMethod"];
		$this->currentPreventiveControlMethod->AdvancedSearch->SearchOperator2 = @$filter["w_currentPreventiveControlMethod"];
		$this->currentPreventiveControlMethod->AdvancedSearch->save();

		// Field severity
		$this->severity->AdvancedSearch->SearchValue = @$filter["x_severity"];
		$this->severity->AdvancedSearch->SearchOperator = @$filter["z_severity"];
		$this->severity->AdvancedSearch->SearchCondition = @$filter["v_severity"];
		$this->severity->AdvancedSearch->SearchValue2 = @$filter["y_severity"];
		$this->severity->AdvancedSearch->SearchOperator2 = @$filter["w_severity"];
		$this->severity->AdvancedSearch->save();

		// Field occurrence
		$this->occurrence->AdvancedSearch->SearchValue = @$filter["x_occurrence"];
		$this->occurrence->AdvancedSearch->SearchOperator = @$filter["z_occurrence"];
		$this->occurrence->AdvancedSearch->SearchCondition = @$filter["v_occurrence"];
		$this->occurrence->AdvancedSearch->SearchValue2 = @$filter["y_occurrence"];
		$this->occurrence->AdvancedSearch->SearchOperator2 = @$filter["w_occurrence"];
		$this->occurrence->AdvancedSearch->save();

		// Field currentControlMethod
		$this->currentControlMethod->AdvancedSearch->SearchValue = @$filter["x_currentControlMethod"];
		$this->currentControlMethod->AdvancedSearch->SearchOperator = @$filter["z_currentControlMethod"];
		$this->currentControlMethod->AdvancedSearch->SearchCondition = @$filter["v_currentControlMethod"];
		$this->currentControlMethod->AdvancedSearch->SearchValue2 = @$filter["y_currentControlMethod"];
		$this->currentControlMethod->AdvancedSearch->SearchOperator2 = @$filter["w_currentControlMethod"];
		$this->currentControlMethod->AdvancedSearch->save();

		// Field detection
		$this->detection->AdvancedSearch->SearchValue = @$filter["x_detection"];
		$this->detection->AdvancedSearch->SearchOperator = @$filter["z_detection"];
		$this->detection->AdvancedSearch->SearchCondition = @$filter["v_detection"];
		$this->detection->AdvancedSearch->SearchValue2 = @$filter["y_detection"];
		$this->detection->AdvancedSearch->SearchOperator2 = @$filter["w_detection"];
		$this->detection->AdvancedSearch->save();

		// Field RPNCalc
		$this->RPNCalc->AdvancedSearch->SearchValue = @$filter["x_RPNCalc"];
		$this->RPNCalc->AdvancedSearch->SearchOperator = @$filter["z_RPNCalc"];
		$this->RPNCalc->AdvancedSearch->SearchCondition = @$filter["v_RPNCalc"];
		$this->RPNCalc->AdvancedSearch->SearchValue2 = @$filter["y_RPNCalc"];
		$this->RPNCalc->AdvancedSearch->SearchOperator2 = @$filter["w_RPNCalc"];
		$this->RPNCalc->AdvancedSearch->save();

		// Field recomendedAction
		$this->recomendedAction->AdvancedSearch->SearchValue = @$filter["x_recomendedAction"];
		$this->recomendedAction->AdvancedSearch->SearchOperator = @$filter["z_recomendedAction"];
		$this->recomendedAction->AdvancedSearch->SearchCondition = @$filter["v_recomendedAction"];
		$this->recomendedAction->AdvancedSearch->SearchValue2 = @$filter["y_recomendedAction"];
		$this->recomendedAction->AdvancedSearch->SearchOperator2 = @$filter["w_recomendedAction"];
		$this->recomendedAction->AdvancedSearch->save();

		// Field idResponsible
		$this->idResponsible->AdvancedSearch->SearchValue = @$filter["x_idResponsible"];
		$this->idResponsible->AdvancedSearch->SearchOperator = @$filter["z_idResponsible"];
		$this->idResponsible->AdvancedSearch->SearchCondition = @$filter["v_idResponsible"];
		$this->idResponsible->AdvancedSearch->SearchValue2 = @$filter["y_idResponsible"];
		$this->idResponsible->AdvancedSearch->SearchOperator2 = @$filter["w_idResponsible"];
		$this->idResponsible->AdvancedSearch->save();

		// Field targetDate
		$this->targetDate->AdvancedSearch->SearchValue = @$filter["x_targetDate"];
		$this->targetDate->AdvancedSearch->SearchOperator = @$filter["z_targetDate"];
		$this->targetDate->AdvancedSearch->SearchCondition = @$filter["v_targetDate"];
		$this->targetDate->AdvancedSearch->SearchValue2 = @$filter["y_targetDate"];
		$this->targetDate->AdvancedSearch->SearchOperator2 = @$filter["w_targetDate"];
		$this->targetDate->AdvancedSearch->save();

		// Field revisedKc
		$this->revisedKc->AdvancedSearch->SearchValue = @$filter["x_revisedKc"];
		$this->revisedKc->AdvancedSearch->SearchOperator = @$filter["z_revisedKc"];
		$this->revisedKc->AdvancedSearch->SearchCondition = @$filter["v_revisedKc"];
		$this->revisedKc->AdvancedSearch->SearchValue2 = @$filter["y_revisedKc"];
		$this->revisedKc->AdvancedSearch->SearchOperator2 = @$filter["w_revisedKc"];
		$this->revisedKc->AdvancedSearch->save();

		// Field expectedSeverity
		$this->expectedSeverity->AdvancedSearch->SearchValue = @$filter["x_expectedSeverity"];
		$this->expectedSeverity->AdvancedSearch->SearchOperator = @$filter["z_expectedSeverity"];
		$this->expectedSeverity->AdvancedSearch->SearchCondition = @$filter["v_expectedSeverity"];
		$this->expectedSeverity->AdvancedSearch->SearchValue2 = @$filter["y_expectedSeverity"];
		$this->expectedSeverity->AdvancedSearch->SearchOperator2 = @$filter["w_expectedSeverity"];
		$this->expectedSeverity->AdvancedSearch->save();

		// Field expectedOccurrence
		$this->expectedOccurrence->AdvancedSearch->SearchValue = @$filter["x_expectedOccurrence"];
		$this->expectedOccurrence->AdvancedSearch->SearchOperator = @$filter["z_expectedOccurrence"];
		$this->expectedOccurrence->AdvancedSearch->SearchCondition = @$filter["v_expectedOccurrence"];
		$this->expectedOccurrence->AdvancedSearch->SearchValue2 = @$filter["y_expectedOccurrence"];
		$this->expectedOccurrence->AdvancedSearch->SearchOperator2 = @$filter["w_expectedOccurrence"];
		$this->expectedOccurrence->AdvancedSearch->save();

		// Field expectedDetection
		$this->expectedDetection->AdvancedSearch->SearchValue = @$filter["x_expectedDetection"];
		$this->expectedDetection->AdvancedSearch->SearchOperator = @$filter["z_expectedDetection"];
		$this->expectedDetection->AdvancedSearch->SearchCondition = @$filter["v_expectedDetection"];
		$this->expectedDetection->AdvancedSearch->SearchValue2 = @$filter["y_expectedDetection"];
		$this->expectedDetection->AdvancedSearch->SearchOperator2 = @$filter["w_expectedDetection"];
		$this->expectedDetection->AdvancedSearch->save();

		// Field expectedRpn
		$this->expectedRpn->AdvancedSearch->SearchValue = @$filter["x_expectedRpn"];
		$this->expectedRpn->AdvancedSearch->SearchOperator = @$filter["z_expectedRpn"];
		$this->expectedRpn->AdvancedSearch->SearchCondition = @$filter["v_expectedRpn"];
		$this->expectedRpn->AdvancedSearch->SearchValue2 = @$filter["y_expectedRpn"];
		$this->expectedRpn->AdvancedSearch->SearchOperator2 = @$filter["w_expectedRpn"];
		$this->expectedRpn->AdvancedSearch->save();

		// Field expectedRPNPAO
		$this->expectedRPNPAO->AdvancedSearch->SearchValue = @$filter["x_expectedRPNPAO"];
		$this->expectedRPNPAO->AdvancedSearch->SearchOperator = @$filter["z_expectedRPNPAO"];
		$this->expectedRPNPAO->AdvancedSearch->SearchCondition = @$filter["v_expectedRPNPAO"];
		$this->expectedRPNPAO->AdvancedSearch->SearchValue2 = @$filter["y_expectedRPNPAO"];
		$this->expectedRPNPAO->AdvancedSearch->SearchOperator2 = @$filter["w_expectedRPNPAO"];
		$this->expectedRPNPAO->AdvancedSearch->save();

		// Field expectedClosureDate
		$this->expectedClosureDate->AdvancedSearch->SearchValue = @$filter["x_expectedClosureDate"];
		$this->expectedClosureDate->AdvancedSearch->SearchOperator = @$filter["z_expectedClosureDate"];
		$this->expectedClosureDate->AdvancedSearch->SearchCondition = @$filter["v_expectedClosureDate"];
		$this->expectedClosureDate->AdvancedSearch->SearchValue2 = @$filter["y_expectedClosureDate"];
		$this->expectedClosureDate->AdvancedSearch->SearchOperator2 = @$filter["w_expectedClosureDate"];
		$this->expectedClosureDate->AdvancedSearch->save();

		// Field recomendedActiondet
		$this->recomendedActiondet->AdvancedSearch->SearchValue = @$filter["x_recomendedActiondet"];
		$this->recomendedActiondet->AdvancedSearch->SearchOperator = @$filter["z_recomendedActiondet"];
		$this->recomendedActiondet->AdvancedSearch->SearchCondition = @$filter["v_recomendedActiondet"];
		$this->recomendedActiondet->AdvancedSearch->SearchValue2 = @$filter["y_recomendedActiondet"];
		$this->recomendedActiondet->AdvancedSearch->SearchOperator2 = @$filter["w_recomendedActiondet"];
		$this->recomendedActiondet->AdvancedSearch->save();

		// Field idResponsibleDet
		$this->idResponsibleDet->AdvancedSearch->SearchValue = @$filter["x_idResponsibleDet"];
		$this->idResponsibleDet->AdvancedSearch->SearchOperator = @$filter["z_idResponsibleDet"];
		$this->idResponsibleDet->AdvancedSearch->SearchCondition = @$filter["v_idResponsibleDet"];
		$this->idResponsibleDet->AdvancedSearch->SearchValue2 = @$filter["y_idResponsibleDet"];
		$this->idResponsibleDet->AdvancedSearch->SearchOperator2 = @$filter["w_idResponsibleDet"];
		$this->idResponsibleDet->AdvancedSearch->save();

		// Field targetDatedet
		$this->targetDatedet->AdvancedSearch->SearchValue = @$filter["x_targetDatedet"];
		$this->targetDatedet->AdvancedSearch->SearchOperator = @$filter["z_targetDatedet"];
		$this->targetDatedet->AdvancedSearch->SearchCondition = @$filter["v_targetDatedet"];
		$this->targetDatedet->AdvancedSearch->SearchValue2 = @$filter["y_targetDatedet"];
		$this->targetDatedet->AdvancedSearch->SearchOperator2 = @$filter["w_targetDatedet"];
		$this->targetDatedet->AdvancedSearch->save();

		// Field kcdet
		$this->kcdet->AdvancedSearch->SearchValue = @$filter["x_kcdet"];
		$this->kcdet->AdvancedSearch->SearchOperator = @$filter["z_kcdet"];
		$this->kcdet->AdvancedSearch->SearchCondition = @$filter["v_kcdet"];
		$this->kcdet->AdvancedSearch->SearchValue2 = @$filter["y_kcdet"];
		$this->kcdet->AdvancedSearch->SearchOperator2 = @$filter["w_kcdet"];
		$this->kcdet->AdvancedSearch->save();

		// Field expectedSeveritydet
		$this->expectedSeveritydet->AdvancedSearch->SearchValue = @$filter["x_expectedSeveritydet"];
		$this->expectedSeveritydet->AdvancedSearch->SearchOperator = @$filter["z_expectedSeveritydet"];
		$this->expectedSeveritydet->AdvancedSearch->SearchCondition = @$filter["v_expectedSeveritydet"];
		$this->expectedSeveritydet->AdvancedSearch->SearchValue2 = @$filter["y_expectedSeveritydet"];
		$this->expectedSeveritydet->AdvancedSearch->SearchOperator2 = @$filter["w_expectedSeveritydet"];
		$this->expectedSeveritydet->AdvancedSearch->save();

		// Field expectedOccurrencedet
		$this->expectedOccurrencedet->AdvancedSearch->SearchValue = @$filter["x_expectedOccurrencedet"];
		$this->expectedOccurrencedet->AdvancedSearch->SearchOperator = @$filter["z_expectedOccurrencedet"];
		$this->expectedOccurrencedet->AdvancedSearch->SearchCondition = @$filter["v_expectedOccurrencedet"];
		$this->expectedOccurrencedet->AdvancedSearch->SearchValue2 = @$filter["y_expectedOccurrencedet"];
		$this->expectedOccurrencedet->AdvancedSearch->SearchOperator2 = @$filter["w_expectedOccurrencedet"];
		$this->expectedOccurrencedet->AdvancedSearch->save();

		// Field expectedDetectiondet
		$this->expectedDetectiondet->AdvancedSearch->SearchValue = @$filter["x_expectedDetectiondet"];
		$this->expectedDetectiondet->AdvancedSearch->SearchOperator = @$filter["z_expectedDetectiondet"];
		$this->expectedDetectiondet->AdvancedSearch->SearchCondition = @$filter["v_expectedDetectiondet"];
		$this->expectedDetectiondet->AdvancedSearch->SearchValue2 = @$filter["y_expectedDetectiondet"];
		$this->expectedDetectiondet->AdvancedSearch->SearchOperator2 = @$filter["w_expectedDetectiondet"];
		$this->expectedDetectiondet->AdvancedSearch->save();

		// Field expectedRPNPAD
		$this->expectedRPNPAD->AdvancedSearch->SearchValue = @$filter["x_expectedRPNPAD"];
		$this->expectedRPNPAD->AdvancedSearch->SearchOperator = @$filter["z_expectedRPNPAD"];
		$this->expectedRPNPAD->AdvancedSearch->SearchCondition = @$filter["v_expectedRPNPAD"];
		$this->expectedRPNPAD->AdvancedSearch->SearchValue2 = @$filter["y_expectedRPNPAD"];
		$this->expectedRPNPAD->AdvancedSearch->SearchOperator2 = @$filter["w_expectedRPNPAD"];
		$this->expectedRPNPAD->AdvancedSearch->save();

		// Field revisedClosureDatedet
		$this->revisedClosureDatedet->AdvancedSearch->SearchValue = @$filter["x_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchOperator = @$filter["z_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchCondition = @$filter["v_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchValue2 = @$filter["y_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchOperator2 = @$filter["w_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->save();

		// Field revisedSeverity
		$this->revisedSeverity->AdvancedSearch->SearchValue = @$filter["x_revisedSeverity"];
		$this->revisedSeverity->AdvancedSearch->SearchOperator = @$filter["z_revisedSeverity"];
		$this->revisedSeverity->AdvancedSearch->SearchCondition = @$filter["v_revisedSeverity"];
		$this->revisedSeverity->AdvancedSearch->SearchValue2 = @$filter["y_revisedSeverity"];
		$this->revisedSeverity->AdvancedSearch->SearchOperator2 = @$filter["w_revisedSeverity"];
		$this->revisedSeverity->AdvancedSearch->save();

		// Field revisedOccurrence
		$this->revisedOccurrence->AdvancedSearch->SearchValue = @$filter["x_revisedOccurrence"];
		$this->revisedOccurrence->AdvancedSearch->SearchOperator = @$filter["z_revisedOccurrence"];
		$this->revisedOccurrence->AdvancedSearch->SearchCondition = @$filter["v_revisedOccurrence"];
		$this->revisedOccurrence->AdvancedSearch->SearchValue2 = @$filter["y_revisedOccurrence"];
		$this->revisedOccurrence->AdvancedSearch->SearchOperator2 = @$filter["w_revisedOccurrence"];
		$this->revisedOccurrence->AdvancedSearch->save();

		// Field revisedDetection
		$this->revisedDetection->AdvancedSearch->SearchValue = @$filter["x_revisedDetection"];
		$this->revisedDetection->AdvancedSearch->SearchOperator = @$filter["z_revisedDetection"];
		$this->revisedDetection->AdvancedSearch->SearchCondition = @$filter["v_revisedDetection"];
		$this->revisedDetection->AdvancedSearch->SearchValue2 = @$filter["y_revisedDetection"];
		$this->revisedDetection->AdvancedSearch->SearchOperator2 = @$filter["w_revisedDetection"];
		$this->revisedDetection->AdvancedSearch->save();

		// Field revisedRpn
		$this->revisedRpn->AdvancedSearch->SearchValue = @$filter["x_revisedRpn"];
		$this->revisedRpn->AdvancedSearch->SearchOperator = @$filter["z_revisedRpn"];
		$this->revisedRpn->AdvancedSearch->SearchCondition = @$filter["v_revisedRpn"];
		$this->revisedRpn->AdvancedSearch->SearchValue2 = @$filter["y_revisedRpn"];
		$this->revisedRpn->AdvancedSearch->SearchOperator2 = @$filter["w_revisedRpn"];
		$this->revisedRpn->AdvancedSearch->save();

		// Field revisedRPNCalc
		$this->revisedRPNCalc->AdvancedSearch->SearchValue = @$filter["x_revisedRPNCalc"];
		$this->revisedRPNCalc->AdvancedSearch->SearchOperator = @$filter["z_revisedRPNCalc"];
		$this->revisedRPNCalc->AdvancedSearch->SearchCondition = @$filter["v_revisedRPNCalc"];
		$this->revisedRPNCalc->AdvancedSearch->SearchValue2 = @$filter["y_revisedRPNCalc"];
		$this->revisedRPNCalc->AdvancedSearch->SearchOperator2 = @$filter["w_revisedRPNCalc"];
		$this->revisedRPNCalc->AdvancedSearch->save();
		$this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
		$this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
	}

	// Advanced search WHERE clause based on QueryString
	protected function advancedSearchWhere($default = FALSE)
	{
		global $Security;
		$where = "";
		if (!$Security->canSearch())
			return "";
		$this->buildSearchSql($where, $this->idProcess, $default, FALSE); // idProcess
		$this->buildSearchSql($where, $this->idCause, $default, FALSE); // idCause
		$this->buildSearchSql($where, $this->potentialCauses, $default, FALSE); // potentialCauses
		$this->buildSearchSql($where, $this->currentPreventiveControlMethod, $default, FALSE); // currentPreventiveControlMethod
		$this->buildSearchSql($where, $this->severity, $default, FALSE); // severity
		$this->buildSearchSql($where, $this->occurrence, $default, FALSE); // occurrence
		$this->buildSearchSql($where, $this->currentControlMethod, $default, FALSE); // currentControlMethod
		$this->buildSearchSql($where, $this->detection, $default, FALSE); // detection
		$this->buildSearchSql($where, $this->RPNCalc, $default, FALSE); // RPNCalc
		$this->buildSearchSql($where, $this->recomendedAction, $default, FALSE); // recomendedAction
		$this->buildSearchSql($where, $this->idResponsible, $default, TRUE); // idResponsible
		$this->buildSearchSql($where, $this->targetDate, $default, FALSE); // targetDate
		$this->buildSearchSql($where, $this->revisedKc, $default, FALSE); // revisedKc
		$this->buildSearchSql($where, $this->expectedSeverity, $default, FALSE); // expectedSeverity
		$this->buildSearchSql($where, $this->expectedOccurrence, $default, FALSE); // expectedOccurrence
		$this->buildSearchSql($where, $this->expectedDetection, $default, FALSE); // expectedDetection
		$this->buildSearchSql($where, $this->expectedRpn, $default, FALSE); // expectedRpn
		$this->buildSearchSql($where, $this->expectedRPNPAO, $default, FALSE); // expectedRPNPAO
		$this->buildSearchSql($where, $this->expectedClosureDate, $default, FALSE); // expectedClosureDate
		$this->buildSearchSql($where, $this->recomendedActiondet, $default, FALSE); // recomendedActiondet
		$this->buildSearchSql($where, $this->idResponsibleDet, $default, TRUE); // idResponsibleDet
		$this->buildSearchSql($where, $this->targetDatedet, $default, FALSE); // targetDatedet
		$this->buildSearchSql($where, $this->kcdet, $default, FALSE); // kcdet
		$this->buildSearchSql($where, $this->expectedSeveritydet, $default, FALSE); // expectedSeveritydet
		$this->buildSearchSql($where, $this->expectedOccurrencedet, $default, FALSE); // expectedOccurrencedet
		$this->buildSearchSql($where, $this->expectedDetectiondet, $default, FALSE); // expectedDetectiondet
		$this->buildSearchSql($where, $this->expectedRPNPAD, $default, FALSE); // expectedRPNPAD
		$this->buildSearchSql($where, $this->revisedClosureDatedet, $default, FALSE); // revisedClosureDatedet
		$this->buildSearchSql($where, $this->revisedSeverity, $default, FALSE); // revisedSeverity
		$this->buildSearchSql($where, $this->revisedOccurrence, $default, FALSE); // revisedOccurrence
		$this->buildSearchSql($where, $this->revisedDetection, $default, FALSE); // revisedDetection
		$this->buildSearchSql($where, $this->revisedRpn, $default, FALSE); // revisedRpn
		$this->buildSearchSql($where, $this->revisedRPNCalc, $default, FALSE); // revisedRPNCalc

		// Set up search parm
		if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
			$this->Command = "search";
		}
		if (!$default && $this->Command == "search") {
			$this->idProcess->AdvancedSearch->save(); // idProcess
			$this->idCause->AdvancedSearch->save(); // idCause
			$this->potentialCauses->AdvancedSearch->save(); // potentialCauses
			$this->currentPreventiveControlMethod->AdvancedSearch->save(); // currentPreventiveControlMethod
			$this->severity->AdvancedSearch->save(); // severity
			$this->occurrence->AdvancedSearch->save(); // occurrence
			$this->currentControlMethod->AdvancedSearch->save(); // currentControlMethod
			$this->detection->AdvancedSearch->save(); // detection
			$this->RPNCalc->AdvancedSearch->save(); // RPNCalc
			$this->recomendedAction->AdvancedSearch->save(); // recomendedAction
			$this->idResponsible->AdvancedSearch->save(); // idResponsible
			$this->targetDate->AdvancedSearch->save(); // targetDate
			$this->revisedKc->AdvancedSearch->save(); // revisedKc
			$this->expectedSeverity->AdvancedSearch->save(); // expectedSeverity
			$this->expectedOccurrence->AdvancedSearch->save(); // expectedOccurrence
			$this->expectedDetection->AdvancedSearch->save(); // expectedDetection
			$this->expectedRpn->AdvancedSearch->save(); // expectedRpn
			$this->expectedRPNPAO->AdvancedSearch->save(); // expectedRPNPAO
			$this->expectedClosureDate->AdvancedSearch->save(); // expectedClosureDate
			$this->recomendedActiondet->AdvancedSearch->save(); // recomendedActiondet
			$this->idResponsibleDet->AdvancedSearch->save(); // idResponsibleDet
			$this->targetDatedet->AdvancedSearch->save(); // targetDatedet
			$this->kcdet->AdvancedSearch->save(); // kcdet
			$this->expectedSeveritydet->AdvancedSearch->save(); // expectedSeveritydet
			$this->expectedOccurrencedet->AdvancedSearch->save(); // expectedOccurrencedet
			$this->expectedDetectiondet->AdvancedSearch->save(); // expectedDetectiondet
			$this->expectedRPNPAD->AdvancedSearch->save(); // expectedRPNPAD
			$this->revisedClosureDatedet->AdvancedSearch->save(); // revisedClosureDatedet
			$this->revisedSeverity->AdvancedSearch->save(); // revisedSeverity
			$this->revisedOccurrence->AdvancedSearch->save(); // revisedOccurrence
			$this->revisedDetection->AdvancedSearch->save(); // revisedDetection
			$this->revisedRpn->AdvancedSearch->save(); // revisedRpn
			$this->revisedRPNCalc->AdvancedSearch->save(); // revisedRPNCalc
		}
		return $where;
	}

	// Build search SQL
	protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
	{
		$fldParm = $fld->Param;
		$fldVal = ($default) ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
		$fldOpr = ($default) ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
		$fldCond = ($default) ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
		$fldVal2 = ($default) ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
		$fldOpr2 = ($default) ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
		$wrk = "";
		if (is_array($fldVal))
			$fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
		if (is_array($fldVal2))
			$fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
		$fldOpr = strtoupper(trim($fldOpr));
		if ($fldOpr == "")
			$fldOpr = "=";
		$fldOpr2 = strtoupper(trim($fldOpr2));
		if ($fldOpr2 == "")
			$fldOpr2 = "=";
		if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 || !IsMultiSearchOperator($fldOpr))
			$multiValue = FALSE;
		if ($multiValue) {
			$wrk1 = ($fldVal != "") ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
			$wrk2 = ($fldVal2 != "") ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
			$wrk = $wrk1; // Build final SQL
			if ($wrk2 != "")
				$wrk = ($wrk != "") ? "($wrk) $fldCond ($wrk2)" : $wrk2;
		} else {
			$fldVal = $this->convertSearchValue($fld, $fldVal);
			$fldVal2 = $this->convertSearchValue($fld, $fldVal2);
			$wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
		}
		AddFilter($where, $wrk);
	}

	// Convert search value
	protected function convertSearchValue(&$fld, $fldVal)
	{
		if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE"))
			return $fldVal;
		$value = $fldVal;
		if ($fld->isBoolean()) {
			if ($fldVal != "")
				$value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
		} elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
			if ($fldVal != "")
				$value = UnFormatDateTime($fldVal, $fld->DateTimeFormat);
		}
		return $value;
	}

	// Return basic search SQL
	protected function basicSearchSql($arKeywords, $type)
	{
		$where = "";
		$this->buildBasicSearchSql($where, $this->idProcess, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idCause, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->potentialCauses, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->currentPreventiveControlMethod, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->occurrence, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->currentControlMethod, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->detection, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->RPNCalc, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->recomendedAction, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idResponsible, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->targetDate, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedKc, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedSeverity, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedOccurrence, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedDetection, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedRPNPAO, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedClosureDate, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->recomendedActiondet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idResponsibleDet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->targetDatedet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->kcdet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedSeveritydet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedOccurrencedet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedDetectiondet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedRPNPAD, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedClosureDatedet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->perfomedAction, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedSeverity, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedOccurrence, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedDetection, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedRpn, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedRPNCalc, $arKeywords, $type);
		return $where;
	}

	// Build basic search SQL
	protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
	{
		$defCond = ($type == "OR") ? "OR" : "AND";
		$arSql = []; // Array for SQL parts
		$arCond = []; // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$keyword = $arKeywords[$i];
			$keyword = trim($keyword);
			if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
				$keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
				$ar = explode("\\", $keyword);
			} else {
				$ar = [$keyword];
			}
			foreach ($ar as $keyword) {
				if ($keyword != "") {
					$wrk = "";
					if ($keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j - 1] = "OR";
					} elseif ($keyword == Config("NULL_VALUE")) {
						$wrk = $fld->Expression . " IS NULL";
					} elseif ($keyword == Config("NOT_NULL_VALUE")) {
						$wrk = $fld->Expression . " IS NOT NULL";
					} elseif ($fld->IsVirtual) {
						$wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
					} elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
						$wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
					}
					if ($wrk != "") {
						$arSql[$j] = $wrk;
						$arCond[$j] = $defCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSql);
		$quoted = FALSE;
		$sql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt - 1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$quoted)
						$sql .= "(";
					$quoted = TRUE;
				}
				$sql .= $arSql[$i];
				if ($quoted && $arCond[$i] != "OR") {
					$sql .= ")";
					$quoted = FALSE;
				}
				$sql .= " " . $arCond[$i] . " ";
			}
			$sql .= $arSql[$cnt - 1];
			if ($quoted)
				$sql .= ")";
		}
		if ($sql != "") {
			if ($where != "")
				$where .= " OR ";
			$where .= "(" . $sql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	protected function basicSearchWhere($default = FALSE)
	{
		global $Security;
		$searchStr = "";
		if (!$Security->canSearch())
			return "";
		$searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($searchKeyword != "") {
			$ar = $this->BasicSearch->keywordList($default);

			// Search keyword in any fields
			if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $keyword) {
					if ($keyword != "") {
						if ($searchStr != "")
							$searchStr .= " " . $searchType . " ";
						$searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
					}
				}
			} else {
				$searchStr = $this->basicSearchSql($ar, $searchType);
			}
			if (!$default && in_array($this->Command, ["", "reset", "resetall"]))
				$this->Command = "search";
		}
		if (!$default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($searchKeyword);
			$this->BasicSearch->setType($searchType);
		}
		return $searchStr;
	}

	// Check if search parm exists
	protected function checkSearchParms()
	{

		// Check basic search
		if ($this->BasicSearch->issetSession())
			return TRUE;
		if ($this->idProcess->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->idCause->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->potentialCauses->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->currentPreventiveControlMethod->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->severity->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->occurrence->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->currentControlMethod->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->detection->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->RPNCalc->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->recomendedAction->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->idResponsible->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->targetDate->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedKc->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedSeverity->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedOccurrence->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedDetection->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedRpn->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedRPNPAO->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedClosureDate->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->recomendedActiondet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->idResponsibleDet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->targetDatedet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->kcdet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedSeveritydet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedOccurrencedet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedDetectiondet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->expectedRPNPAD->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedClosureDatedet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedSeverity->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedOccurrence->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedDetection->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedRpn->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedRPNCalc->AdvancedSearch->issetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	protected function resetSearchParms()
	{

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->resetBasicSearchParms();

		// Clear advanced search parameters
		$this->resetAdvancedSearchParms();
	}

	// Load advanced search default values
	protected function loadAdvancedSearchDefault()
	{
		return FALSE;
	}

	// Clear all basic search parameters
	protected function resetBasicSearchParms()
	{
		$this->BasicSearch->unsetSession();
	}

	// Clear all advanced search parameters
	protected function resetAdvancedSearchParms()
	{
		$this->idProcess->AdvancedSearch->unsetSession();
		$this->idCause->AdvancedSearch->unsetSession();
		$this->potentialCauses->AdvancedSearch->unsetSession();
		$this->currentPreventiveControlMethod->AdvancedSearch->unsetSession();
		$this->severity->AdvancedSearch->unsetSession();
		$this->occurrence->AdvancedSearch->unsetSession();
		$this->currentControlMethod->AdvancedSearch->unsetSession();
		$this->detection->AdvancedSearch->unsetSession();
		$this->RPNCalc->AdvancedSearch->unsetSession();
		$this->recomendedAction->AdvancedSearch->unsetSession();
		$this->idResponsible->AdvancedSearch->unsetSession();
		$this->targetDate->AdvancedSearch->unsetSession();
		$this->revisedKc->AdvancedSearch->unsetSession();
		$this->expectedSeverity->AdvancedSearch->unsetSession();
		$this->expectedOccurrence->AdvancedSearch->unsetSession();
		$this->expectedDetection->AdvancedSearch->unsetSession();
		$this->expectedRpn->AdvancedSearch->unsetSession();
		$this->expectedRPNPAO->AdvancedSearch->unsetSession();
		$this->expectedClosureDate->AdvancedSearch->unsetSession();
		$this->recomendedActiondet->AdvancedSearch->unsetSession();
		$this->idResponsibleDet->AdvancedSearch->unsetSession();
		$this->targetDatedet->AdvancedSearch->unsetSession();
		$this->kcdet->AdvancedSearch->unsetSession();
		$this->expectedSeveritydet->AdvancedSearch->unsetSession();
		$this->expectedOccurrencedet->AdvancedSearch->unsetSession();
		$this->expectedDetectiondet->AdvancedSearch->unsetSession();
		$this->expectedRPNPAD->AdvancedSearch->unsetSession();
		$this->revisedClosureDatedet->AdvancedSearch->unsetSession();
		$this->revisedSeverity->AdvancedSearch->unsetSession();
		$this->revisedOccurrence->AdvancedSearch->unsetSession();
		$this->revisedDetection->AdvancedSearch->unsetSession();
		$this->revisedRpn->AdvancedSearch->unsetSession();
		$this->revisedRPNCalc->AdvancedSearch->unsetSession();
	}

	// Restore all search parameters
	protected function restoreSearchParms()
	{
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->load();

		// Restore advanced search values
		$this->idProcess->AdvancedSearch->load();
		$this->idCause->AdvancedSearch->load();
		$this->potentialCauses->AdvancedSearch->load();
		$this->currentPreventiveControlMethod->AdvancedSearch->load();
		$this->severity->AdvancedSearch->load();
		$this->occurrence->AdvancedSearch->load();
		$this->currentControlMethod->AdvancedSearch->load();
		$this->detection->AdvancedSearch->load();
		$this->RPNCalc->AdvancedSearch->load();
		$this->recomendedAction->AdvancedSearch->load();
		$this->idResponsible->AdvancedSearch->load();
		$this->targetDate->AdvancedSearch->load();
		$this->revisedKc->AdvancedSearch->load();
		$this->expectedSeverity->AdvancedSearch->load();
		$this->expectedOccurrence->AdvancedSearch->load();
		$this->expectedDetection->AdvancedSearch->load();
		$this->expectedRpn->AdvancedSearch->load();
		$this->expectedRPNPAO->AdvancedSearch->load();
		$this->expectedClosureDate->AdvancedSearch->load();
		$this->recomendedActiondet->AdvancedSearch->load();
		$this->idResponsibleDet->AdvancedSearch->load();
		$this->targetDatedet->AdvancedSearch->load();
		$this->kcdet->AdvancedSearch->load();
		$this->expectedSeveritydet->AdvancedSearch->load();
		$this->expectedOccurrencedet->AdvancedSearch->load();
		$this->expectedDetectiondet->AdvancedSearch->load();
		$this->expectedRPNPAD->AdvancedSearch->load();
		$this->revisedClosureDatedet->AdvancedSearch->load();
		$this->revisedSeverity->AdvancedSearch->load();
		$this->revisedOccurrence->AdvancedSearch->load();
		$this->revisedDetection->AdvancedSearch->load();
		$this->revisedRpn->AdvancedSearch->load();
		$this->revisedRPNCalc->AdvancedSearch->load();
	}

	// Set up sort parameters
	protected function setupSortOrder()
	{

		// Check for Ctrl pressed
		$ctrl = Get("ctrl") !== NULL;

		// Check for "order" parameter
		if (Get("order") !== NULL) {
			$this->CurrentOrder = Get("order");
			$this->CurrentOrderType = Get("ordertype", "");
			$this->updateSort($this->idProcess, $ctrl); // idProcess
			$this->updateSort($this->idCause, $ctrl); // idCause
			$this->updateSort($this->potentialCauses, $ctrl); // potentialCauses
			$this->updateSort($this->currentPreventiveControlMethod, $ctrl); // currentPreventiveControlMethod
			$this->updateSort($this->severity, $ctrl); // severity
			$this->updateSort($this->occurrence, $ctrl); // occurrence
			$this->updateSort($this->currentControlMethod, $ctrl); // currentControlMethod
			$this->updateSort($this->detection, $ctrl); // detection
			$this->updateSort($this->RPNCalc, $ctrl); // RPNCalc
			$this->updateSort($this->recomendedAction, $ctrl); // recomendedAction
			$this->updateSort($this->idResponsible, $ctrl); // idResponsible
			$this->updateSort($this->targetDate, $ctrl); // targetDate
			$this->updateSort($this->revisedKc, $ctrl); // revisedKc
			$this->updateSort($this->expectedSeverity, $ctrl); // expectedSeverity
			$this->updateSort($this->expectedOccurrence, $ctrl); // expectedOccurrence
			$this->updateSort($this->expectedDetection, $ctrl); // expectedDetection
			$this->updateSort($this->expectedRPNPAO, $ctrl); // expectedRPNPAO
			$this->updateSort($this->expectedClosureDate, $ctrl); // expectedClosureDate
			$this->updateSort($this->recomendedActiondet, $ctrl); // recomendedActiondet
			$this->updateSort($this->idResponsibleDet, $ctrl); // idResponsibleDet
			$this->updateSort($this->targetDatedet, $ctrl); // targetDatedet
			$this->updateSort($this->kcdet, $ctrl); // kcdet
			$this->updateSort($this->expectedSeveritydet, $ctrl); // expectedSeveritydet
			$this->updateSort($this->expectedOccurrencedet, $ctrl); // expectedOccurrencedet
			$this->updateSort($this->expectedDetectiondet, $ctrl); // expectedDetectiondet
			$this->updateSort($this->expectedRPNPAD, $ctrl); // expectedRPNPAD
			$this->updateSort($this->revisedClosureDatedet, $ctrl); // revisedClosureDatedet
			$this->updateSort($this->revisedSeverity, $ctrl); // revisedSeverity
			$this->updateSort($this->revisedOccurrence, $ctrl); // revisedOccurrence
			$this->updateSort($this->revisedDetection, $ctrl); // revisedDetection
			$this->updateSort($this->revisedRPNCalc, $ctrl); // revisedRPNCalc
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	protected function loadSortOrder()
	{
		$orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($orderBy == "") {
			if ($this->getSqlOrderBy() != "") {
				$orderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($orderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)

	protected function resetCmd()
	{

		// Check if reset command
		if (StartsString("reset", $this->Command)) {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->resetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idProcess->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
				$this->setSessionOrderByList($orderBy);
				$this->idProcess->setSort("");
				$this->idCause->setSort("");
				$this->potentialCauses->setSort("");
				$this->currentPreventiveControlMethod->setSort("");
				$this->severity->setSort("");
				$this->occurrence->setSort("");
				$this->currentControlMethod->setSort("");
				$this->detection->setSort("");
				$this->RPNCalc->setSort("");
				$this->recomendedAction->setSort("");
				$this->idResponsible->setSort("");
				$this->targetDate->setSort("");
				$this->revisedKc->setSort("");
				$this->expectedSeverity->setSort("");
				$this->expectedOccurrence->setSort("");
				$this->expectedDetection->setSort("");
				$this->expectedRPNPAO->setSort("");
				$this->expectedClosureDate->setSort("");
				$this->recomendedActiondet->setSort("");
				$this->idResponsibleDet->setSort("");
				$this->targetDatedet->setSort("");
				$this->kcdet->setSort("");
				$this->expectedSeveritydet->setSort("");
				$this->expectedOccurrencedet->setSort("");
				$this->expectedDetectiondet->setSort("");
				$this->expectedRPNPAD->setSort("");
				$this->revisedClosureDatedet->setSort("");
				$this->revisedSeverity->setSort("");
				$this->revisedOccurrence->setSort("");
				$this->revisedDetection->setSort("");
				$this->revisedRPNCalc->setSort("");
			}

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Set up list options
	protected function setupListOptions()
	{
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "copy"
		$item = &$this->ListOptions->add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canAdd() && $this->isAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->add("checkbox");
		$item->Visible = $Security->canDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
		$item->moveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;

		//$this->ListOptions->ButtonClass = ""; // Class for button group
		// Call ListOptions_Load event

		$this->ListOptions_Load();
		$this->setupListOptionsExt();
		$item = $this->ListOptions[$this->ListOptions->GroupOptionName];
		$item->Visible = $this->ListOptions->groupOptionVisible();
	}

	// Render list options
	public function renderListOptions()
	{
		global $Security, $Language, $CurrentForm;
		$this->ListOptions->loadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode != "view") {
			$CurrentForm->Index = $this->RowIndex;
			$actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$keyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $CurrentForm->getValue($this->FormKeyName);
				$this->setupKeyValues($rowkey);

				// Reload hidden key for delete
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . HtmlEncode($rowkey) . "\">";
			}
			if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->isGridAdd() || $this->isGridEdit()) {
				$options = &$this->ListOptions;
				$options->UseButtonGroup = TRUE; // Use button group for grid delete button
				$opt = $options["griddelete"];
				if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$opt->Body = "&nbsp;";
				} else {
					$opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$opt = $this->ListOptions["copy"];
		if ($this->isInlineAddRow() || $this->isInlineCopyRow()) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->addMasterUrl($this->pageUrl() . "action=cancel");
			$opt->Body = "<div" . (($opt->OnLeft) ? " class=\"text-right\"" : "") . ">" .
				"<a class=\"ew-grid-link ew-inline-insert\" title=\"" . HtmlTitle($Language->phrase("InsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InsertLink")) . "\" href=\"#\" onclick=\"return ew.forms(this).submit('" . $this->pageName() . "');\">" . $Language->phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ew-grid-link ew-inline-cancel\" title=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"action\" id=\"action\" value=\"insert\"></div>";
			return;
		}

		// Set up list action buttons
		$opt = $this->ListOptions["listactions"];
		if ($opt && !$this->isExport() && !$this->CurrentAction) {
			$body = "";
			$links = [];
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
					$links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(TRUE) . "}," . $listaction->toJson(TRUE) . "));\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(TRUE) . "}," . $listaction->toJson(TRUE) . "));\">" . $icon . $listaction->Caption . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$opt->Body = $body;
				$opt->Visible = TRUE;
			}
		}

		// "checkbox"
		$opt = $this->ListOptions["checkbox"];
		$opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->idProcess->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->idCause->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->add("add");
		$addcaption = HtmlTitle($Language->phrase("AddLink"));
		$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode($this->AddUrl) . "\">" . $Language->phrase("AddLink") . "</a>";
		$item->Visible = $this->AddUrl != "" && $Security->canAdd();

		// Inline Add
		$item = &$option->add("inlineadd");
		$item->Body = "<a class=\"ew-add-edit ew-inline-add\" title=\"" . HtmlTitle($Language->phrase("InlineAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InlineAddLink")) . "\" href=\"" . HtmlEncode($this->InlineAddUrl) . "\">" .$Language->phrase("InlineAddLink") . "</a>";
		$item->Visible = $this->InlineAddUrl != "" && $Security->canAdd();
		$item = &$option->add("gridadd");
		$item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" href=\"" . HtmlEncode($this->GridAddUrl) . "\">" . $Language->phrase("GridAddLink") . "</a>";
		$item->Visible = $this->GridAddUrl != "" && $Security->canAdd();
		$option = $options["action"];

		// Add multi delete
		$item = &$option->add("multidelete");
		$item->Body = "<a class=\"ew-action ew-multi-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteSelectedLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteSelectedLink")) . "\" href=\"#\" onclick=\"return ew.submitAction(event, {f:document.factionslist, url:'" . $this->MultiDeleteUrl . "', data:{action:'show'}});return false;\">" . $Language->phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = $Security->canDelete();

		// Set up options default
		foreach ($options as $option) {
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;

			//$option->ButtonClass = ""; // Class for button group
			$item = &$option->add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->add("savecurrentfilter");
		$item->Body = "<a class=\"ew-save-filter\" data-form=\"factionslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->add("deletefilter");
		$item->Body = "<a class=\"ew-delete-filter\" data-form=\"factionslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	public function renderOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (!$this->isGridAdd() && !$this->isGridEdit()) { // Not grid add/edit mode
			$option = $options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == ACTION_MULTIPLE) {
					$item = &$option->add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode($listaction->Icon) . "\" data-caption=\"" . HtmlEncode($caption) . "\"></i> " . $caption : $caption;
					$item->Body = "<a class=\"ew-action ew-list-action\" title=\"" . HtmlEncode($caption) . "\" data-caption=\"" . HtmlEncode($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({f:document.factionslist}," . $listaction->toJson(TRUE) . "));\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecords <= 0) {
				$option = $options["addedit"];
				$item = $option["gridedit"];
				if ($item)
					$item->Visible = FALSE;
				$option = $options["action"];
				$option->hideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as $option)
				$option->hideAllOptions();

			// Grid-Add
			if ($this->isGridAdd()) {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = $options["addedit"];
					$option->UseDropDownButton = FALSE;
					$item = &$option->add("addblankrow");
					$item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->canAdd();
				}
				$option = $options["action"];
				$option->UseDropDownButton = FALSE;

				// Add grid insert
				$item = &$option->add("gridinsert");
				$item->Body = "<a class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" href=\"#\" onclick=\"return ew.forms(this).submit('" . $this->pageName() . "');\">" . $Language->phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->add("gridcancel");
				$cancelurl = $this->addMasterUrl($this->pageUrl() . "action=cancel");
				$item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	protected function processListAction()
	{
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$filter = $this->getFilterFromRecordKeys();
		$userAction = Post("useraction", "");
		if ($filter != "" && $userAction != "") {

			// Check permission first
			$actionCaption = $userAction;
			if (array_key_exists($userAction, $this->ListActions->Items)) {
				$actionCaption = $this->ListActions[$userAction]->Caption;
				if (!$this->ListActions[$userAction]->Allow) {
					$errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
					if (Post("ajax") == $userAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $filter;
			$sql = $this->getCurrentSql();
			$conn = $this->getConnection();
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$rs = $conn->execute($sql);
			$conn->raiseErrorFn = "";
			$this->CurrentAction = $userAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->beginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$processed = $this->Row_CustomAction($userAction, $row);
					if (!$processed)
						break;
					$rs->moveNext();
				}
				if ($processed) {
					$conn->commitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "" && !ob_get_length()) // No output
						$this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->rollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage != "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->close();
			$this->CurrentAction = ""; // Clear action
			if (Post("ajax") == $userAction) { // Ajax
				if ($this->getSuccessMessage() != "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->clearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() != "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->clearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

// Set up list options (extended codes)
	protected function setupListOptionsExt()
	{

		// Hide detail items for dropdown if necessary
		$this->ListOptions->hideDetailItemsForDropDown();
	}

// Render list options (extended codes)
	protected function renderListOptionsExt()
	{
		global $Security, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idProcess->CurrentValue = NULL;
		$this->idProcess->OldValue = $this->idProcess->CurrentValue;
		$this->idCause->CurrentValue = NULL;
		$this->idCause->OldValue = $this->idCause->CurrentValue;
		$this->potentialCauses->CurrentValue = NULL;
		$this->potentialCauses->OldValue = $this->potentialCauses->CurrentValue;
		$this->currentPreventiveControlMethod->CurrentValue = NULL;
		$this->currentPreventiveControlMethod->OldValue = $this->currentPreventiveControlMethod->CurrentValue;
		$this->severity->CurrentValue = NULL;
		$this->severity->OldValue = $this->severity->CurrentValue;
		$this->occurrence->CurrentValue = NULL;
		$this->occurrence->OldValue = $this->occurrence->CurrentValue;
		$this->currentControlMethod->CurrentValue = NULL;
		$this->currentControlMethod->OldValue = $this->currentControlMethod->CurrentValue;
		$this->detection->CurrentValue = NULL;
		$this->detection->OldValue = $this->detection->CurrentValue;
		$this->RPNCalc->CurrentValue = NULL;
		$this->RPNCalc->OldValue = $this->RPNCalc->CurrentValue;
		$this->rpn->CurrentValue = NULL;
		$this->rpn->OldValue = $this->rpn->CurrentValue;
		$this->recomendedAction->CurrentValue = NULL;
		$this->recomendedAction->OldValue = $this->recomendedAction->CurrentValue;
		$this->idResponsible->CurrentValue = NULL;
		$this->idResponsible->OldValue = $this->idResponsible->CurrentValue;
		$this->targetDate->CurrentValue = NULL;
		$this->targetDate->OldValue = $this->targetDate->CurrentValue;
		$this->revisedKc->CurrentValue = NULL;
		$this->revisedKc->OldValue = $this->revisedKc->CurrentValue;
		$this->expectedSeverity->CurrentValue = NULL;
		$this->expectedSeverity->OldValue = $this->expectedSeverity->CurrentValue;
		$this->expectedOccurrence->CurrentValue = NULL;
		$this->expectedOccurrence->OldValue = $this->expectedOccurrence->CurrentValue;
		$this->expectedDetection->CurrentValue = NULL;
		$this->expectedDetection->OldValue = $this->expectedDetection->CurrentValue;
		$this->expectedRpn->CurrentValue = NULL;
		$this->expectedRpn->OldValue = $this->expectedRpn->CurrentValue;
		$this->expectedRPNPAO->CurrentValue = NULL;
		$this->expectedRPNPAO->OldValue = $this->expectedRPNPAO->CurrentValue;
		$this->expectedClosureDate->CurrentValue = NULL;
		$this->expectedClosureDate->OldValue = $this->expectedClosureDate->CurrentValue;
		$this->recomendedActiondet->CurrentValue = NULL;
		$this->recomendedActiondet->OldValue = $this->recomendedActiondet->CurrentValue;
		$this->idResponsibleDet->CurrentValue = NULL;
		$this->idResponsibleDet->OldValue = $this->idResponsibleDet->CurrentValue;
		$this->targetDatedet->CurrentValue = NULL;
		$this->targetDatedet->OldValue = $this->targetDatedet->CurrentValue;
		$this->kcdet->CurrentValue = NULL;
		$this->kcdet->OldValue = $this->kcdet->CurrentValue;
		$this->expectedSeveritydet->CurrentValue = NULL;
		$this->expectedSeveritydet->OldValue = $this->expectedSeveritydet->CurrentValue;
		$this->expectedOccurrencedet->CurrentValue = NULL;
		$this->expectedOccurrencedet->OldValue = $this->expectedOccurrencedet->CurrentValue;
		$this->expectedDetectiondet->CurrentValue = NULL;
		$this->expectedDetectiondet->OldValue = $this->expectedDetectiondet->CurrentValue;
		$this->expectedRpndet->CurrentValue = NULL;
		$this->expectedRpndet->OldValue = $this->expectedRpndet->CurrentValue;
		$this->expectedRPNPAD->CurrentValue = NULL;
		$this->expectedRPNPAD->OldValue = $this->expectedRPNPAD->CurrentValue;
		$this->revisedClosureDatedet->CurrentValue = NULL;
		$this->revisedClosureDatedet->OldValue = $this->revisedClosureDatedet->CurrentValue;
		$this->revisedClosureDate->CurrentValue = NULL;
		$this->revisedClosureDate->OldValue = $this->revisedClosureDate->CurrentValue;
		$this->perfomedAction->CurrentValue = NULL;
		$this->perfomedAction->OldValue = $this->perfomedAction->CurrentValue;
		$this->revisedSeverity->CurrentValue = NULL;
		$this->revisedSeverity->OldValue = $this->revisedSeverity->CurrentValue;
		$this->revisedOccurrence->CurrentValue = NULL;
		$this->revisedOccurrence->OldValue = $this->revisedOccurrence->CurrentValue;
		$this->revisedDetection->CurrentValue = NULL;
		$this->revisedDetection->OldValue = $this->revisedDetection->CurrentValue;
		$this->revisedRpn->CurrentValue = NULL;
		$this->revisedRpn->OldValue = $this->revisedRpn->CurrentValue;
		$this->revisedRPNCalc->CurrentValue = NULL;
		$this->revisedRPNCalc->OldValue = $this->revisedRPNCalc->CurrentValue;
	}

	// Load basic search values
	protected function loadBasicSearchValues()
	{
		$this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), FALSE);
		if ($this->BasicSearch->Keyword != "" && $this->Command == "")
			$this->Command = "search";
		$this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), FALSE);
	}

	// Load search values for validation
	protected function loadSearchValues()
	{

		// Load search values
		$got = FALSE;

		// idProcess
		if (!$this->isAddOrEdit() && $this->idProcess->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idProcess->AdvancedSearch->SearchValue != "" || $this->idProcess->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// idCause
		if (!$this->isAddOrEdit() && $this->idCause->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idCause->AdvancedSearch->SearchValue != "" || $this->idCause->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// potentialCauses
		if (!$this->isAddOrEdit() && $this->potentialCauses->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->potentialCauses->AdvancedSearch->SearchValue != "" || $this->potentialCauses->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// currentPreventiveControlMethod
		if (!$this->isAddOrEdit() && $this->currentPreventiveControlMethod->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->currentPreventiveControlMethod->AdvancedSearch->SearchValue != "" || $this->currentPreventiveControlMethod->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// severity
		if (!$this->isAddOrEdit() && $this->severity->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->severity->AdvancedSearch->SearchValue != "" || $this->severity->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// occurrence
		if (!$this->isAddOrEdit() && $this->occurrence->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->occurrence->AdvancedSearch->SearchValue != "" || $this->occurrence->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// currentControlMethod
		if (!$this->isAddOrEdit() && $this->currentControlMethod->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->currentControlMethod->AdvancedSearch->SearchValue != "" || $this->currentControlMethod->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// detection
		if (!$this->isAddOrEdit() && $this->detection->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->detection->AdvancedSearch->SearchValue != "" || $this->detection->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// RPNCalc
		if (!$this->isAddOrEdit() && $this->RPNCalc->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->RPNCalc->AdvancedSearch->SearchValue != "" || $this->RPNCalc->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// recomendedAction
		if (!$this->isAddOrEdit() && $this->recomendedAction->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->recomendedAction->AdvancedSearch->SearchValue != "" || $this->recomendedAction->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// idResponsible
		if (!$this->isAddOrEdit() && $this->idResponsible->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idResponsible->AdvancedSearch->SearchValue != "" || $this->idResponsible->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		if (is_array($this->idResponsible->AdvancedSearch->SearchValue))
			$this->idResponsible->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsible->AdvancedSearch->SearchValue);
		if (is_array($this->idResponsible->AdvancedSearch->SearchValue2))
			$this->idResponsible->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsible->AdvancedSearch->SearchValue2);

		// targetDate
		if (!$this->isAddOrEdit() && $this->targetDate->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->targetDate->AdvancedSearch->SearchValue != "" || $this->targetDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedKc
		if (!$this->isAddOrEdit() && $this->revisedKc->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedKc->AdvancedSearch->SearchValue != "" || $this->revisedKc->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		if (is_array($this->revisedKc->AdvancedSearch->SearchValue))
			$this->revisedKc->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->revisedKc->AdvancedSearch->SearchValue);
		if (is_array($this->revisedKc->AdvancedSearch->SearchValue2))
			$this->revisedKc->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->revisedKc->AdvancedSearch->SearchValue2);

		// expectedSeverity
		if (!$this->isAddOrEdit() && $this->expectedSeverity->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedSeverity->AdvancedSearch->SearchValue != "" || $this->expectedSeverity->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedOccurrence
		if (!$this->isAddOrEdit() && $this->expectedOccurrence->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedOccurrence->AdvancedSearch->SearchValue != "" || $this->expectedOccurrence->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedDetection
		if (!$this->isAddOrEdit() && $this->expectedDetection->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedDetection->AdvancedSearch->SearchValue != "" || $this->expectedDetection->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedRpn
		if (!$this->isAddOrEdit() && $this->expectedRpn->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedRpn->AdvancedSearch->SearchValue != "" || $this->expectedRpn->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedRPNPAO
		if (!$this->isAddOrEdit() && $this->expectedRPNPAO->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedRPNPAO->AdvancedSearch->SearchValue != "" || $this->expectedRPNPAO->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedClosureDate
		if (!$this->isAddOrEdit() && $this->expectedClosureDate->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedClosureDate->AdvancedSearch->SearchValue != "" || $this->expectedClosureDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// recomendedActiondet
		if (!$this->isAddOrEdit() && $this->recomendedActiondet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->recomendedActiondet->AdvancedSearch->SearchValue != "" || $this->recomendedActiondet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// idResponsibleDet
		if (!$this->isAddOrEdit() && $this->idResponsibleDet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idResponsibleDet->AdvancedSearch->SearchValue != "" || $this->idResponsibleDet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		if (is_array($this->idResponsibleDet->AdvancedSearch->SearchValue))
			$this->idResponsibleDet->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsibleDet->AdvancedSearch->SearchValue);
		if (is_array($this->idResponsibleDet->AdvancedSearch->SearchValue2))
			$this->idResponsibleDet->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsibleDet->AdvancedSearch->SearchValue2);

		// targetDatedet
		if (!$this->isAddOrEdit() && $this->targetDatedet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->targetDatedet->AdvancedSearch->SearchValue != "" || $this->targetDatedet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// kcdet
		if (!$this->isAddOrEdit() && $this->kcdet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->kcdet->AdvancedSearch->SearchValue != "" || $this->kcdet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		if (is_array($this->kcdet->AdvancedSearch->SearchValue))
			$this->kcdet->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kcdet->AdvancedSearch->SearchValue);
		if (is_array($this->kcdet->AdvancedSearch->SearchValue2))
			$this->kcdet->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kcdet->AdvancedSearch->SearchValue2);

		// expectedSeveritydet
		if (!$this->isAddOrEdit() && $this->expectedSeveritydet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedSeveritydet->AdvancedSearch->SearchValue != "" || $this->expectedSeveritydet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedOccurrencedet
		if (!$this->isAddOrEdit() && $this->expectedOccurrencedet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedOccurrencedet->AdvancedSearch->SearchValue != "" || $this->expectedOccurrencedet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedDetectiondet
		if (!$this->isAddOrEdit() && $this->expectedDetectiondet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedDetectiondet->AdvancedSearch->SearchValue != "" || $this->expectedDetectiondet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// expectedRPNPAD
		if (!$this->isAddOrEdit() && $this->expectedRPNPAD->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedRPNPAD->AdvancedSearch->SearchValue != "" || $this->expectedRPNPAD->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedClosureDatedet
		if (!$this->isAddOrEdit() && $this->revisedClosureDatedet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedClosureDatedet->AdvancedSearch->SearchValue != "" || $this->revisedClosureDatedet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedSeverity
		if (!$this->isAddOrEdit() && $this->revisedSeverity->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedSeverity->AdvancedSearch->SearchValue != "" || $this->revisedSeverity->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedOccurrence
		if (!$this->isAddOrEdit() && $this->revisedOccurrence->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedOccurrence->AdvancedSearch->SearchValue != "" || $this->revisedOccurrence->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedDetection
		if (!$this->isAddOrEdit() && $this->revisedDetection->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedDetection->AdvancedSearch->SearchValue != "" || $this->revisedDetection->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedRpn
		if (!$this->isAddOrEdit() && $this->revisedRpn->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedRpn->AdvancedSearch->SearchValue != "" || $this->revisedRpn->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedRPNCalc
		if (!$this->isAddOrEdit() && $this->revisedRPNCalc->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedRPNCalc->AdvancedSearch->SearchValue != "" || $this->revisedRPNCalc->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		return $got;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'idProcess' first before field var 'x_idProcess'
		$val = $CurrentForm->hasValue("idProcess") ? $CurrentForm->getValue("idProcess") : $CurrentForm->getValue("x_idProcess");
		if (!$this->idProcess->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idProcess->Visible = FALSE; // Disable update for API request
			else
				$this->idProcess->setFormValue($val);
		}
		$this->idProcess->setOldValue($CurrentForm->getValue("o_idProcess"));

		// Check field name 'idCause' first before field var 'x_idCause'
		$val = $CurrentForm->hasValue("idCause") ? $CurrentForm->getValue("idCause") : $CurrentForm->getValue("x_idCause");
		if (!$this->idCause->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idCause->Visible = FALSE; // Disable update for API request
			else
				$this->idCause->setFormValue($val);
		}
		$this->idCause->setOldValue($CurrentForm->getValue("o_idCause"));

		// Check field name 'potentialCauses' first before field var 'x_potentialCauses'
		$val = $CurrentForm->hasValue("potentialCauses") ? $CurrentForm->getValue("potentialCauses") : $CurrentForm->getValue("x_potentialCauses");
		if (!$this->potentialCauses->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->potentialCauses->Visible = FALSE; // Disable update for API request
			else
				$this->potentialCauses->setFormValue($val);
		}
		$this->potentialCauses->setOldValue($CurrentForm->getValue("o_potentialCauses"));

		// Check field name 'currentPreventiveControlMethod' first before field var 'x_currentPreventiveControlMethod'
		$val = $CurrentForm->hasValue("currentPreventiveControlMethod") ? $CurrentForm->getValue("currentPreventiveControlMethod") : $CurrentForm->getValue("x_currentPreventiveControlMethod");
		if (!$this->currentPreventiveControlMethod->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->currentPreventiveControlMethod->Visible = FALSE; // Disable update for API request
			else
				$this->currentPreventiveControlMethod->setFormValue($val);
		}
		$this->currentPreventiveControlMethod->setOldValue($CurrentForm->getValue("o_currentPreventiveControlMethod"));

		// Check field name 'severity' first before field var 'x_severity'
		$val = $CurrentForm->hasValue("severity") ? $CurrentForm->getValue("severity") : $CurrentForm->getValue("x_severity");
		if (!$this->severity->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->severity->Visible = FALSE; // Disable update for API request
			else
				$this->severity->setFormValue($val);
		}
		$this->severity->setOldValue($CurrentForm->getValue("o_severity"));

		// Check field name 'occurrence' first before field var 'x_occurrence'
		$val = $CurrentForm->hasValue("occurrence") ? $CurrentForm->getValue("occurrence") : $CurrentForm->getValue("x_occurrence");
		if (!$this->occurrence->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->occurrence->Visible = FALSE; // Disable update for API request
			else
				$this->occurrence->setFormValue($val);
		}
		$this->occurrence->setOldValue($CurrentForm->getValue("o_occurrence"));

		// Check field name 'currentControlMethod' first before field var 'x_currentControlMethod'
		$val = $CurrentForm->hasValue("currentControlMethod") ? $CurrentForm->getValue("currentControlMethod") : $CurrentForm->getValue("x_currentControlMethod");
		if (!$this->currentControlMethod->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->currentControlMethod->Visible = FALSE; // Disable update for API request
			else
				$this->currentControlMethod->setFormValue($val);
		}
		$this->currentControlMethod->setOldValue($CurrentForm->getValue("o_currentControlMethod"));

		// Check field name 'detection' first before field var 'x_detection'
		$val = $CurrentForm->hasValue("detection") ? $CurrentForm->getValue("detection") : $CurrentForm->getValue("x_detection");
		if (!$this->detection->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->detection->Visible = FALSE; // Disable update for API request
			else
				$this->detection->setFormValue($val);
		}
		$this->detection->setOldValue($CurrentForm->getValue("o_detection"));

		// Check field name 'RPNCalc' first before field var 'x_RPNCalc'
		$val = $CurrentForm->hasValue("RPNCalc") ? $CurrentForm->getValue("RPNCalc") : $CurrentForm->getValue("x_RPNCalc");
		if (!$this->RPNCalc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->RPNCalc->Visible = FALSE; // Disable update for API request
			else
				$this->RPNCalc->setFormValue($val);
		}
		$this->RPNCalc->setOldValue($CurrentForm->getValue("o_RPNCalc"));

		// Check field name 'recomendedAction' first before field var 'x_recomendedAction'
		$val = $CurrentForm->hasValue("recomendedAction") ? $CurrentForm->getValue("recomendedAction") : $CurrentForm->getValue("x_recomendedAction");
		if (!$this->recomendedAction->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->recomendedAction->Visible = FALSE; // Disable update for API request
			else
				$this->recomendedAction->setFormValue($val);
		}
		$this->recomendedAction->setOldValue($CurrentForm->getValue("o_recomendedAction"));

		// Check field name 'idResponsible' first before field var 'x_idResponsible'
		$val = $CurrentForm->hasValue("idResponsible") ? $CurrentForm->getValue("idResponsible") : $CurrentForm->getValue("x_idResponsible");
		if (!$this->idResponsible->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idResponsible->Visible = FALSE; // Disable update for API request
			else
				$this->idResponsible->setFormValue($val);
		}
		$this->idResponsible->setOldValue($CurrentForm->getValue("o_idResponsible"));

		// Check field name 'targetDate' first before field var 'x_targetDate'
		$val = $CurrentForm->hasValue("targetDate") ? $CurrentForm->getValue("targetDate") : $CurrentForm->getValue("x_targetDate");
		if (!$this->targetDate->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->targetDate->Visible = FALSE; // Disable update for API request
			else
				$this->targetDate->setFormValue($val);
			$this->targetDate->CurrentValue = UnFormatDateTime($this->targetDate->CurrentValue, 14);
		}
		$this->targetDate->setOldValue($CurrentForm->getValue("o_targetDate"));

		// Check field name 'revisedKc' first before field var 'x_revisedKc'
		$val = $CurrentForm->hasValue("revisedKc") ? $CurrentForm->getValue("revisedKc") : $CurrentForm->getValue("x_revisedKc");
		if (!$this->revisedKc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->revisedKc->Visible = FALSE; // Disable update for API request
			else
				$this->revisedKc->setFormValue($val);
		}
		$this->revisedKc->setOldValue($CurrentForm->getValue("o_revisedKc"));

		// Check field name 'expectedSeverity' first before field var 'x_expectedSeverity'
		$val = $CurrentForm->hasValue("expectedSeverity") ? $CurrentForm->getValue("expectedSeverity") : $CurrentForm->getValue("x_expectedSeverity");
		if (!$this->expectedSeverity->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedSeverity->Visible = FALSE; // Disable update for API request
			else
				$this->expectedSeverity->setFormValue($val);
		}
		$this->expectedSeverity->setOldValue($CurrentForm->getValue("o_expectedSeverity"));

		// Check field name 'expectedOccurrence' first before field var 'x_expectedOccurrence'
		$val = $CurrentForm->hasValue("expectedOccurrence") ? $CurrentForm->getValue("expectedOccurrence") : $CurrentForm->getValue("x_expectedOccurrence");
		if (!$this->expectedOccurrence->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedOccurrence->Visible = FALSE; // Disable update for API request
			else
				$this->expectedOccurrence->setFormValue($val);
		}
		$this->expectedOccurrence->setOldValue($CurrentForm->getValue("o_expectedOccurrence"));

		// Check field name 'expectedDetection' first before field var 'x_expectedDetection'
		$val = $CurrentForm->hasValue("expectedDetection") ? $CurrentForm->getValue("expectedDetection") : $CurrentForm->getValue("x_expectedDetection");
		if (!$this->expectedDetection->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedDetection->Visible = FALSE; // Disable update for API request
			else
				$this->expectedDetection->setFormValue($val);
		}
		$this->expectedDetection->setOldValue($CurrentForm->getValue("o_expectedDetection"));

		// Check field name 'expectedRPNPAO' first before field var 'x_expectedRPNPAO'
		$val = $CurrentForm->hasValue("expectedRPNPAO") ? $CurrentForm->getValue("expectedRPNPAO") : $CurrentForm->getValue("x_expectedRPNPAO");
		if (!$this->expectedRPNPAO->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedRPNPAO->Visible = FALSE; // Disable update for API request
			else
				$this->expectedRPNPAO->setFormValue($val);
		}
		$this->expectedRPNPAO->setOldValue($CurrentForm->getValue("o_expectedRPNPAO"));

		// Check field name 'expectedClosureDate' first before field var 'x_expectedClosureDate'
		$val = $CurrentForm->hasValue("expectedClosureDate") ? $CurrentForm->getValue("expectedClosureDate") : $CurrentForm->getValue("x_expectedClosureDate");
		if (!$this->expectedClosureDate->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedClosureDate->Visible = FALSE; // Disable update for API request
			else
				$this->expectedClosureDate->setFormValue($val);
			$this->expectedClosureDate->CurrentValue = UnFormatDateTime($this->expectedClosureDate->CurrentValue, 12);
		}
		$this->expectedClosureDate->setOldValue($CurrentForm->getValue("o_expectedClosureDate"));

		// Check field name 'recomendedActiondet' first before field var 'x_recomendedActiondet'
		$val = $CurrentForm->hasValue("recomendedActiondet") ? $CurrentForm->getValue("recomendedActiondet") : $CurrentForm->getValue("x_recomendedActiondet");
		if (!$this->recomendedActiondet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->recomendedActiondet->Visible = FALSE; // Disable update for API request
			else
				$this->recomendedActiondet->setFormValue($val);
		}
		$this->recomendedActiondet->setOldValue($CurrentForm->getValue("o_recomendedActiondet"));

		// Check field name 'idResponsibleDet' first before field var 'x_idResponsibleDet'
		$val = $CurrentForm->hasValue("idResponsibleDet") ? $CurrentForm->getValue("idResponsibleDet") : $CurrentForm->getValue("x_idResponsibleDet");
		if (!$this->idResponsibleDet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idResponsibleDet->Visible = FALSE; // Disable update for API request
			else
				$this->idResponsibleDet->setFormValue($val);
		}
		$this->idResponsibleDet->setOldValue($CurrentForm->getValue("o_idResponsibleDet"));

		// Check field name 'targetDatedet' first before field var 'x_targetDatedet'
		$val = $CurrentForm->hasValue("targetDatedet") ? $CurrentForm->getValue("targetDatedet") : $CurrentForm->getValue("x_targetDatedet");
		if (!$this->targetDatedet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->targetDatedet->Visible = FALSE; // Disable update for API request
			else
				$this->targetDatedet->setFormValue($val);
			$this->targetDatedet->CurrentValue = UnFormatDateTime($this->targetDatedet->CurrentValue, 14);
		}
		$this->targetDatedet->setOldValue($CurrentForm->getValue("o_targetDatedet"));

		// Check field name 'kcdet' first before field var 'x_kcdet'
		$val = $CurrentForm->hasValue("kcdet") ? $CurrentForm->getValue("kcdet") : $CurrentForm->getValue("x_kcdet");
		if (!$this->kcdet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->kcdet->Visible = FALSE; // Disable update for API request
			else
				$this->kcdet->setFormValue($val);
		}
		$this->kcdet->setOldValue($CurrentForm->getValue("o_kcdet"));

		// Check field name 'expectedSeveritydet' first before field var 'x_expectedSeveritydet'
		$val = $CurrentForm->hasValue("expectedSeveritydet") ? $CurrentForm->getValue("expectedSeveritydet") : $CurrentForm->getValue("x_expectedSeveritydet");
		if (!$this->expectedSeveritydet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedSeveritydet->Visible = FALSE; // Disable update for API request
			else
				$this->expectedSeveritydet->setFormValue($val);
		}
		$this->expectedSeveritydet->setOldValue($CurrentForm->getValue("o_expectedSeveritydet"));

		// Check field name 'expectedOccurrencedet' first before field var 'x_expectedOccurrencedet'
		$val = $CurrentForm->hasValue("expectedOccurrencedet") ? $CurrentForm->getValue("expectedOccurrencedet") : $CurrentForm->getValue("x_expectedOccurrencedet");
		if (!$this->expectedOccurrencedet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedOccurrencedet->Visible = FALSE; // Disable update for API request
			else
				$this->expectedOccurrencedet->setFormValue($val);
		}
		$this->expectedOccurrencedet->setOldValue($CurrentForm->getValue("o_expectedOccurrencedet"));

		// Check field name 'expectedDetectiondet' first before field var 'x_expectedDetectiondet'
		$val = $CurrentForm->hasValue("expectedDetectiondet") ? $CurrentForm->getValue("expectedDetectiondet") : $CurrentForm->getValue("x_expectedDetectiondet");
		if (!$this->expectedDetectiondet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedDetectiondet->Visible = FALSE; // Disable update for API request
			else
				$this->expectedDetectiondet->setFormValue($val);
		}
		$this->expectedDetectiondet->setOldValue($CurrentForm->getValue("o_expectedDetectiondet"));

		// Check field name 'expectedRPNPAD' first before field var 'x_expectedRPNPAD'
		$val = $CurrentForm->hasValue("expectedRPNPAD") ? $CurrentForm->getValue("expectedRPNPAD") : $CurrentForm->getValue("x_expectedRPNPAD");
		if (!$this->expectedRPNPAD->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->expectedRPNPAD->Visible = FALSE; // Disable update for API request
			else
				$this->expectedRPNPAD->setFormValue($val);
		}
		$this->expectedRPNPAD->setOldValue($CurrentForm->getValue("o_expectedRPNPAD"));

		// Check field name 'revisedClosureDatedet' first before field var 'x_revisedClosureDatedet'
		$val = $CurrentForm->hasValue("revisedClosureDatedet") ? $CurrentForm->getValue("revisedClosureDatedet") : $CurrentForm->getValue("x_revisedClosureDatedet");
		if (!$this->revisedClosureDatedet->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->revisedClosureDatedet->Visible = FALSE; // Disable update for API request
			else
				$this->revisedClosureDatedet->setFormValue($val);
			$this->revisedClosureDatedet->CurrentValue = UnFormatDateTime($this->revisedClosureDatedet->CurrentValue, 14);
		}
		$this->revisedClosureDatedet->setOldValue($CurrentForm->getValue("o_revisedClosureDatedet"));

		// Check field name 'revisedSeverity' first before field var 'x_revisedSeverity'
		$val = $CurrentForm->hasValue("revisedSeverity") ? $CurrentForm->getValue("revisedSeverity") : $CurrentForm->getValue("x_revisedSeverity");
		if (!$this->revisedSeverity->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->revisedSeverity->Visible = FALSE; // Disable update for API request
			else
				$this->revisedSeverity->setFormValue($val);
		}
		$this->revisedSeverity->setOldValue($CurrentForm->getValue("o_revisedSeverity"));

		// Check field name 'revisedOccurrence' first before field var 'x_revisedOccurrence'
		$val = $CurrentForm->hasValue("revisedOccurrence") ? $CurrentForm->getValue("revisedOccurrence") : $CurrentForm->getValue("x_revisedOccurrence");
		if (!$this->revisedOccurrence->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->revisedOccurrence->Visible = FALSE; // Disable update for API request
			else
				$this->revisedOccurrence->setFormValue($val);
		}
		$this->revisedOccurrence->setOldValue($CurrentForm->getValue("o_revisedOccurrence"));

		// Check field name 'revisedDetection' first before field var 'x_revisedDetection'
		$val = $CurrentForm->hasValue("revisedDetection") ? $CurrentForm->getValue("revisedDetection") : $CurrentForm->getValue("x_revisedDetection");
		if (!$this->revisedDetection->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->revisedDetection->Visible = FALSE; // Disable update for API request
			else
				$this->revisedDetection->setFormValue($val);
		}
		$this->revisedDetection->setOldValue($CurrentForm->getValue("o_revisedDetection"));

		// Check field name 'revisedRPNCalc' first before field var 'x_revisedRPNCalc'
		$val = $CurrentForm->hasValue("revisedRPNCalc") ? $CurrentForm->getValue("revisedRPNCalc") : $CurrentForm->getValue("x_revisedRPNCalc");
		if (!$this->revisedRPNCalc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->revisedRPNCalc->Visible = FALSE; // Disable update for API request
			else
				$this->revisedRPNCalc->setFormValue($val);
		}
		$this->revisedRPNCalc->setOldValue($CurrentForm->getValue("o_revisedRPNCalc"));
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->idProcess->CurrentValue = $this->idProcess->FormValue;
		$this->idCause->CurrentValue = $this->idCause->FormValue;
		$this->potentialCauses->CurrentValue = $this->potentialCauses->FormValue;
		$this->currentPreventiveControlMethod->CurrentValue = $this->currentPreventiveControlMethod->FormValue;
		$this->severity->CurrentValue = $this->severity->FormValue;
		$this->occurrence->CurrentValue = $this->occurrence->FormValue;
		$this->currentControlMethod->CurrentValue = $this->currentControlMethod->FormValue;
		$this->detection->CurrentValue = $this->detection->FormValue;
		$this->RPNCalc->CurrentValue = $this->RPNCalc->FormValue;
		$this->recomendedAction->CurrentValue = $this->recomendedAction->FormValue;
		$this->idResponsible->CurrentValue = $this->idResponsible->FormValue;
		$this->targetDate->CurrentValue = $this->targetDate->FormValue;
		$this->targetDate->CurrentValue = UnFormatDateTime($this->targetDate->CurrentValue, 14);
		$this->revisedKc->CurrentValue = $this->revisedKc->FormValue;
		$this->expectedSeverity->CurrentValue = $this->expectedSeverity->FormValue;
		$this->expectedOccurrence->CurrentValue = $this->expectedOccurrence->FormValue;
		$this->expectedDetection->CurrentValue = $this->expectedDetection->FormValue;
		$this->expectedRPNPAO->CurrentValue = $this->expectedRPNPAO->FormValue;
		$this->expectedClosureDate->CurrentValue = $this->expectedClosureDate->FormValue;
		$this->expectedClosureDate->CurrentValue = UnFormatDateTime($this->expectedClosureDate->CurrentValue, 12);
		$this->recomendedActiondet->CurrentValue = $this->recomendedActiondet->FormValue;
		$this->idResponsibleDet->CurrentValue = $this->idResponsibleDet->FormValue;
		$this->targetDatedet->CurrentValue = $this->targetDatedet->FormValue;
		$this->targetDatedet->CurrentValue = UnFormatDateTime($this->targetDatedet->CurrentValue, 14);
		$this->kcdet->CurrentValue = $this->kcdet->FormValue;
		$this->expectedSeveritydet->CurrentValue = $this->expectedSeveritydet->FormValue;
		$this->expectedOccurrencedet->CurrentValue = $this->expectedOccurrencedet->FormValue;
		$this->expectedDetectiondet->CurrentValue = $this->expectedDetectiondet->FormValue;
		$this->expectedRPNPAD->CurrentValue = $this->expectedRPNPAD->FormValue;
		$this->revisedClosureDatedet->CurrentValue = $this->revisedClosureDatedet->FormValue;
		$this->revisedClosureDatedet->CurrentValue = UnFormatDateTime($this->revisedClosureDatedet->CurrentValue, 14);
		$this->revisedSeverity->CurrentValue = $this->revisedSeverity->FormValue;
		$this->revisedOccurrence->CurrentValue = $this->revisedOccurrence->FormValue;
		$this->revisedDetection->CurrentValue = $this->revisedDetection->FormValue;
		$this->revisedRPNCalc->CurrentValue = $this->revisedRPNCalc->FormValue;
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = $this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = "";
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->idProcess->setDbValue($row['idProcess']);
		$this->idCause->setDbValue($row['idCause']);
		if (array_key_exists('EV__idCause', $rs->fields)) {
			$this->idCause->VirtualValue = $rs->fields('EV__idCause'); // Set up virtual field value
		} else {
			$this->idCause->VirtualValue = ""; // Clear value
		}
		$this->potentialCauses->setDbValue($row['potentialCauses']);
		$this->currentPreventiveControlMethod->setDbValue($row['currentPreventiveControlMethod']);
		$this->severity->setDbValue($row['severity']);
		$this->occurrence->setDbValue($row['occurrence']);
		$this->currentControlMethod->setDbValue($row['currentControlMethod']);
		$this->detection->setDbValue($row['detection']);
		$this->RPNCalc->setDbValue($row['RPNCalc']);
		$this->rpn->setDbValue($row['rpn']);
		$this->recomendedAction->setDbValue($row['recomendedAction']);
		$this->idResponsible->setDbValue($row['idResponsible']);
		if (array_key_exists('EV__idResponsible', $rs->fields)) {
			$this->idResponsible->VirtualValue = $rs->fields('EV__idResponsible'); // Set up virtual field value
		} else {
			$this->idResponsible->VirtualValue = ""; // Clear value
		}
		$this->targetDate->setDbValue($row['targetDate']);
		$this->revisedKc->setDbValue($row['revisedKc']);
		$this->expectedSeverity->setDbValue($row['expectedSeverity']);
		$this->expectedOccurrence->setDbValue($row['expectedOccurrence']);
		$this->expectedDetection->setDbValue($row['expectedDetection']);
		$this->expectedRpn->setDbValue($row['expectedRpn']);
		$this->expectedRPNPAO->setDbValue($row['expectedRPNPAO']);
		$this->expectedClosureDate->setDbValue($row['expectedClosureDate']);
		$this->recomendedActiondet->setDbValue($row['recomendedActiondet']);
		$this->idResponsibleDet->setDbValue($row['idResponsibleDet']);
		if (array_key_exists('EV__idResponsibleDet', $rs->fields)) {
			$this->idResponsibleDet->VirtualValue = $rs->fields('EV__idResponsibleDet'); // Set up virtual field value
		} else {
			$this->idResponsibleDet->VirtualValue = ""; // Clear value
		}
		$this->targetDatedet->setDbValue($row['targetDatedet']);
		$this->kcdet->setDbValue($row['kcdet']);
		$this->expectedSeveritydet->setDbValue($row['expectedSeveritydet']);
		$this->expectedOccurrencedet->setDbValue($row['expectedOccurrencedet']);
		$this->expectedDetectiondet->setDbValue($row['expectedDetectiondet']);
		$this->expectedRpndet->setDbValue($row['expectedRpndet']);
		$this->expectedRPNPAD->setDbValue($row['expectedRPNPAD']);
		$this->revisedClosureDatedet->setDbValue($row['revisedClosureDatedet']);
		$this->revisedClosureDate->setDbValue($row['revisedClosureDate']);
		$this->perfomedAction->setDbValue($row['perfomedAction']);
		$this->revisedSeverity->setDbValue($row['revisedSeverity']);
		$this->revisedOccurrence->setDbValue($row['revisedOccurrence']);
		$this->revisedDetection->setDbValue($row['revisedDetection']);
		$this->revisedRpn->setDbValue($row['revisedRpn']);
		$this->revisedRPNCalc->setDbValue($row['revisedRPNCalc']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idProcess'] = $this->idProcess->CurrentValue;
		$row['idCause'] = $this->idCause->CurrentValue;
		$row['potentialCauses'] = $this->potentialCauses->CurrentValue;
		$row['currentPreventiveControlMethod'] = $this->currentPreventiveControlMethod->CurrentValue;
		$row['severity'] = $this->severity->CurrentValue;
		$row['occurrence'] = $this->occurrence->CurrentValue;
		$row['currentControlMethod'] = $this->currentControlMethod->CurrentValue;
		$row['detection'] = $this->detection->CurrentValue;
		$row['RPNCalc'] = $this->RPNCalc->CurrentValue;
		$row['rpn'] = $this->rpn->CurrentValue;
		$row['recomendedAction'] = $this->recomendedAction->CurrentValue;
		$row['idResponsible'] = $this->idResponsible->CurrentValue;
		$row['targetDate'] = $this->targetDate->CurrentValue;
		$row['revisedKc'] = $this->revisedKc->CurrentValue;
		$row['expectedSeverity'] = $this->expectedSeverity->CurrentValue;
		$row['expectedOccurrence'] = $this->expectedOccurrence->CurrentValue;
		$row['expectedDetection'] = $this->expectedDetection->CurrentValue;
		$row['expectedRpn'] = $this->expectedRpn->CurrentValue;
		$row['expectedRPNPAO'] = $this->expectedRPNPAO->CurrentValue;
		$row['expectedClosureDate'] = $this->expectedClosureDate->CurrentValue;
		$row['recomendedActiondet'] = $this->recomendedActiondet->CurrentValue;
		$row['idResponsibleDet'] = $this->idResponsibleDet->CurrentValue;
		$row['targetDatedet'] = $this->targetDatedet->CurrentValue;
		$row['kcdet'] = $this->kcdet->CurrentValue;
		$row['expectedSeveritydet'] = $this->expectedSeveritydet->CurrentValue;
		$row['expectedOccurrencedet'] = $this->expectedOccurrencedet->CurrentValue;
		$row['expectedDetectiondet'] = $this->expectedDetectiondet->CurrentValue;
		$row['expectedRpndet'] = $this->expectedRpndet->CurrentValue;
		$row['expectedRPNPAD'] = $this->expectedRPNPAD->CurrentValue;
		$row['revisedClosureDatedet'] = $this->revisedClosureDatedet->CurrentValue;
		$row['revisedClosureDate'] = $this->revisedClosureDate->CurrentValue;
		$row['perfomedAction'] = $this->perfomedAction->CurrentValue;
		$row['revisedSeverity'] = $this->revisedSeverity->CurrentValue;
		$row['revisedOccurrence'] = $this->revisedOccurrence->CurrentValue;
		$row['revisedDetection'] = $this->revisedDetection->CurrentValue;
		$row['revisedRpn'] = $this->revisedRpn->CurrentValue;
		$row['revisedRPNCalc'] = $this->revisedRPNCalc->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("idProcess")) != "")
			$this->idProcess->OldValue = $this->getKey("idProcess"); // idProcess
		else
			$validKey = FALSE;
		if (strval($this->getKey("idCause")) != "")
			$this->idCause->OldValue = $this->getKey("idCause"); // idCause
		else
			$validKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = $this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->getViewUrl();
		$this->EditUrl = $this->getEditUrl();
		$this->InlineEditUrl = $this->getInlineEditUrl();
		$this->CopyUrl = $this->getCopyUrl();
		$this->InlineCopyUrl = $this->getInlineCopyUrl();
		$this->DeleteUrl = $this->getDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idProcess
		// idCause
		// potentialCauses
		// currentPreventiveControlMethod
		// severity
		// occurrence
		// currentControlMethod
		// detection
		// RPNCalc
		// rpn

		$this->rpn->CellCssStyle = "white-space: nowrap;";

		// recomendedAction
		// idResponsible
		// targetDate
		// revisedKc
		// expectedSeverity
		// expectedOccurrence
		// expectedDetection
		// expectedRpn

		$this->expectedRpn->CellCssStyle = "white-space: nowrap;";

		// expectedRPNPAO
		// expectedClosureDate
		// recomendedActiondet
		// idResponsibleDet
		// targetDatedet
		// kcdet
		// expectedSeveritydet
		// expectedOccurrencedet
		// expectedDetectiondet
		// expectedRpndet

		$this->expectedRpndet->CellCssStyle = "white-space: nowrap;";

		// expectedRPNPAD
		// revisedClosureDatedet
		// revisedClosureDate

		$this->revisedClosureDate->CellCssStyle = "white-space: nowrap;";

		// perfomedAction
		// revisedSeverity
		// revisedOccurrence
		// revisedDetection
		// revisedRpn
		// revisedRPNCalc

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// idProcess
			$this->idProcess->ViewValue = $this->idProcess->CurrentValue;
			$this->idProcess->ViewValue = FormatNumber($this->idProcess->ViewValue, 0, -2, -2, -2);
			$this->idProcess->ViewCustomAttributes = "";

			// idCause
			if ($this->idCause->VirtualValue != "") {
				$this->idCause->ViewValue = $this->idCause->VirtualValue;
			} else {
				$curVal = strval($this->idCause->CurrentValue);
				if ($curVal != "") {
					$this->idCause->ViewValue = $this->idCause->lookupCacheOption($curVal);
					if ($this->idCause->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idCause`" . SearchString("=", $curVal, DATATYPE_STRING, "");
						$sqlWrk = $this->idCause->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->idCause->ViewValue = $this->idCause->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idCause->ViewValue = $this->idCause->CurrentValue;
						}
					}
				} else {
					$this->idCause->ViewValue = NULL;
				}
			}
			$this->idCause->ViewCustomAttributes = "";

			// potentialCauses
			$this->potentialCauses->ViewValue = $this->potentialCauses->CurrentValue;
			$this->potentialCauses->ViewCustomAttributes = "";

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->ViewValue = $this->currentPreventiveControlMethod->CurrentValue;
			$this->currentPreventiveControlMethod->ViewCustomAttributes = "";

			// severity
			$this->severity->ViewValue = $this->severity->CurrentValue;
			$this->severity->ViewValue = FormatNumber($this->severity->ViewValue, 0, -2, -2, -2);
			$this->severity->ViewCustomAttributes = "";

			// occurrence
			$this->occurrence->ViewValue = $this->occurrence->CurrentValue;
			$this->occurrence->ViewValue = FormatNumber($this->occurrence->ViewValue, 0, -2, -2, -2);
			$this->occurrence->ViewCustomAttributes = "";

			// currentControlMethod
			$this->currentControlMethod->ViewValue = $this->currentControlMethod->CurrentValue;
			$this->currentControlMethod->ViewCustomAttributes = "";

			// detection
			$this->detection->ViewValue = $this->detection->CurrentValue;
			$this->detection->ViewValue = FormatNumber($this->detection->ViewValue, 0, -2, -2, -2);
			$this->detection->ViewCustomAttributes = "";

			// RPNCalc
			$this->RPNCalc->ViewValue = $this->RPNCalc->CurrentValue;
			$this->RPNCalc->ViewValue = FormatNumber($this->RPNCalc->ViewValue, 0, -2, -2, -2);
			$this->RPNCalc->ViewCustomAttributes = "";

			// recomendedAction
			$this->recomendedAction->ViewValue = $this->recomendedAction->CurrentValue;
			$this->recomendedAction->ViewCustomAttributes = "";

			// idResponsible
			if ($this->idResponsible->VirtualValue != "") {
				$this->idResponsible->ViewValue = $this->idResponsible->VirtualValue;
			} else {
				$curVal = strval($this->idResponsible->CurrentValue);
				if ($curVal != "") {
					$this->idResponsible->ViewValue = $this->idResponsible->lookupCacheOption($curVal);
					if ($this->idResponsible->ViewValue === NULL) { // Lookup from database
						$arwrk = explode(",", $curVal);
						$filterWrk = "";
						foreach ($arwrk as $wrk) {
							if ($filterWrk != "")
								$filterWrk .= " OR ";
							$filterWrk .= "`idEmployee`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
						}
						$sqlWrk = $this->idResponsible->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$this->idResponsible->ViewValue = new OptionValues();
							$ari = 0;
							while (!$rswrk->EOF) {
								$arwrk = [];
								$arwrk[1] = $rswrk->fields('df');
								$arwrk[2] = $rswrk->fields('df2');
								$this->idResponsible->ViewValue->add($this->idResponsible->displayValue($arwrk));
								$rswrk->MoveNext();
								$ari++;
							}
							$rswrk->Close();
						} else {
							$this->idResponsible->ViewValue = $this->idResponsible->CurrentValue;
						}
					}
				} else {
					$this->idResponsible->ViewValue = NULL;
				}
			}
			$this->idResponsible->ViewCustomAttributes = "";

			// targetDate
			$this->targetDate->ViewValue = $this->targetDate->CurrentValue;
			$this->targetDate->ViewValue = FormatDateTime($this->targetDate->ViewValue, 14);
			$this->targetDate->ViewCustomAttributes = "";

			// revisedKc
			if (ConvertToBool($this->revisedKc->CurrentValue)) {
				$this->revisedKc->ViewValue = $this->revisedKc->tagCaption(2) != "" ? $this->revisedKc->tagCaption(2) : "1";
			} else {
				$this->revisedKc->ViewValue = $this->revisedKc->tagCaption(1) != "" ? $this->revisedKc->tagCaption(1) : "0";
			}
			$this->revisedKc->ViewCustomAttributes = "";

			// expectedSeverity
			$this->expectedSeverity->ViewValue = $this->expectedSeverity->CurrentValue;
			$this->expectedSeverity->ViewValue = FormatNumber($this->expectedSeverity->ViewValue, 0, -2, -2, -2);
			$this->expectedSeverity->ViewCustomAttributes = "";

			// expectedOccurrence
			$this->expectedOccurrence->ViewValue = $this->expectedOccurrence->CurrentValue;
			$this->expectedOccurrence->ViewValue = FormatNumber($this->expectedOccurrence->ViewValue, 0, -2, -2, -2);
			$this->expectedOccurrence->ViewCustomAttributes = "";

			// expectedDetection
			$this->expectedDetection->ViewValue = $this->expectedDetection->CurrentValue;
			$this->expectedDetection->ViewValue = FormatNumber($this->expectedDetection->ViewValue, 0, -2, -2, -2);
			$this->expectedDetection->ViewCustomAttributes = "";

			// expectedRPNPAO
			$this->expectedRPNPAO->ViewValue = $this->expectedRPNPAO->CurrentValue;
			$this->expectedRPNPAO->ViewValue = FormatNumber($this->expectedRPNPAO->ViewValue, 0, -2, -2, -2);
			$this->expectedRPNPAO->ViewCustomAttributes = "";

			// expectedClosureDate
			$this->expectedClosureDate->ViewValue = $this->expectedClosureDate->CurrentValue;
			$this->expectedClosureDate->ViewValue = FormatDateTime($this->expectedClosureDate->ViewValue, 12);
			$this->expectedClosureDate->ViewCustomAttributes = "";

			// recomendedActiondet
			$this->recomendedActiondet->ViewValue = $this->recomendedActiondet->CurrentValue;
			$this->recomendedActiondet->ViewCustomAttributes = "";

			// idResponsibleDet
			if ($this->idResponsibleDet->VirtualValue != "") {
				$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->VirtualValue;
			} else {
				$curVal = strval($this->idResponsibleDet->CurrentValue);
				if ($curVal != "") {
					$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->lookupCacheOption($curVal);
					if ($this->idResponsibleDet->ViewValue === NULL) { // Lookup from database
						$arwrk = explode(",", $curVal);
						$filterWrk = "";
						foreach ($arwrk as $wrk) {
							if ($filterWrk != "")
								$filterWrk .= " OR ";
							$filterWrk .= "`idEmployee`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
						}
						$sqlWrk = $this->idResponsibleDet->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$this->idResponsibleDet->ViewValue = new OptionValues();
							$ari = 0;
							while (!$rswrk->EOF) {
								$arwrk = [];
								$arwrk[1] = $rswrk->fields('df');
								$arwrk[2] = $rswrk->fields('df2');
								$this->idResponsibleDet->ViewValue->add($this->idResponsibleDet->displayValue($arwrk));
								$rswrk->MoveNext();
								$ari++;
							}
							$rswrk->Close();
						} else {
							$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->CurrentValue;
						}
					}
				} else {
					$this->idResponsibleDet->ViewValue = NULL;
				}
			}
			$this->idResponsibleDet->ViewCustomAttributes = "";

			// targetDatedet
			$this->targetDatedet->ViewValue = $this->targetDatedet->CurrentValue;
			$this->targetDatedet->ViewValue = FormatDateTime($this->targetDatedet->ViewValue, 14);
			$this->targetDatedet->ViewCustomAttributes = "";

			// kcdet
			if (ConvertToBool($this->kcdet->CurrentValue)) {
				$this->kcdet->ViewValue = $this->kcdet->tagCaption(2) != "" ? $this->kcdet->tagCaption(2) : "1";
			} else {
				$this->kcdet->ViewValue = $this->kcdet->tagCaption(1) != "" ? $this->kcdet->tagCaption(1) : "0";
			}
			$this->kcdet->ViewCustomAttributes = "";

			// expectedSeveritydet
			$this->expectedSeveritydet->ViewValue = $this->expectedSeveritydet->CurrentValue;
			$this->expectedSeveritydet->ViewValue = FormatNumber($this->expectedSeveritydet->ViewValue, 0, -2, -2, -2);
			$this->expectedSeveritydet->ViewCustomAttributes = "";

			// expectedOccurrencedet
			$this->expectedOccurrencedet->ViewValue = $this->expectedOccurrencedet->CurrentValue;
			$this->expectedOccurrencedet->ViewValue = FormatNumber($this->expectedOccurrencedet->ViewValue, 0, -2, -2, -2);
			$this->expectedOccurrencedet->ViewCustomAttributes = "";

			// expectedDetectiondet
			$this->expectedDetectiondet->ViewValue = $this->expectedDetectiondet->CurrentValue;
			$this->expectedDetectiondet->ViewValue = FormatNumber($this->expectedDetectiondet->ViewValue, 0, -2, -2, -2);
			$this->expectedDetectiondet->ViewCustomAttributes = "";

			// expectedRPNPAD
			$this->expectedRPNPAD->ViewValue = $this->expectedRPNPAD->CurrentValue;
			$this->expectedRPNPAD->ViewValue = FormatNumber($this->expectedRPNPAD->ViewValue, 0, -2, -2, -2);
			$this->expectedRPNPAD->ViewCustomAttributes = "";

			// revisedClosureDatedet
			$this->revisedClosureDatedet->ViewValue = $this->revisedClosureDatedet->CurrentValue;
			$this->revisedClosureDatedet->ViewValue = FormatDateTime($this->revisedClosureDatedet->ViewValue, 14);
			$this->revisedClosureDatedet->ViewCustomAttributes = "";

			// revisedSeverity
			$this->revisedSeverity->ViewValue = $this->revisedSeverity->CurrentValue;
			$this->revisedSeverity->ViewValue = FormatNumber($this->revisedSeverity->ViewValue, 0, -2, -2, -2);
			$this->revisedSeverity->ViewCustomAttributes = "";

			// revisedOccurrence
			$this->revisedOccurrence->ViewValue = $this->revisedOccurrence->CurrentValue;
			$this->revisedOccurrence->ViewValue = FormatNumber($this->revisedOccurrence->ViewValue, 0, -2, -2, -2);
			$this->revisedOccurrence->ViewCustomAttributes = "";

			// revisedDetection
			$this->revisedDetection->ViewValue = $this->revisedDetection->CurrentValue;
			$this->revisedDetection->ViewValue = FormatNumber($this->revisedDetection->ViewValue, 0, -2, -2, -2);
			$this->revisedDetection->ViewCustomAttributes = "";

			// revisedRPNCalc
			$this->revisedRPNCalc->ViewValue = $this->revisedRPNCalc->CurrentValue;
			$this->revisedRPNCalc->ViewValue = FormatNumber($this->revisedRPNCalc->ViewValue, 0, -2, -2, -2);
			$this->revisedRPNCalc->ViewCustomAttributes = "";

			// idProcess
			$this->idProcess->LinkCustomAttributes = "";
			$this->idProcess->HrefValue = "";
			$this->idProcess->TooltipValue = "";

			// idCause
			$this->idCause->LinkCustomAttributes = "";
			$this->idCause->HrefValue = "";
			$this->idCause->TooltipValue = "";
			if (!$this->isExport())
				$this->idCause->ViewValue = $this->highlightValue($this->idCause);

			// potentialCauses
			$this->potentialCauses->LinkCustomAttributes = "";
			$this->potentialCauses->HrefValue = "";
			$this->potentialCauses->TooltipValue = "";
			if (!$this->isExport())
				$this->potentialCauses->ViewValue = $this->highlightValue($this->potentialCauses);

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->LinkCustomAttributes = "";
			$this->currentPreventiveControlMethod->HrefValue = "";
			$this->currentPreventiveControlMethod->TooltipValue = "";
			if (!$this->isExport())
				$this->currentPreventiveControlMethod->ViewValue = $this->highlightValue($this->currentPreventiveControlMethod);

			// severity
			$this->severity->LinkCustomAttributes = "";
			$this->severity->HrefValue = "";
			$this->severity->TooltipValue = "";

			// occurrence
			$this->occurrence->LinkCustomAttributes = "";
			$this->occurrence->HrefValue = "";
			$this->occurrence->TooltipValue = "";

			// currentControlMethod
			$this->currentControlMethod->LinkCustomAttributes = "";
			$this->currentControlMethod->HrefValue = "";
			$this->currentControlMethod->TooltipValue = "";
			if (!$this->isExport())
				$this->currentControlMethod->ViewValue = $this->highlightValue($this->currentControlMethod);

			// detection
			$this->detection->LinkCustomAttributes = "";
			$this->detection->HrefValue = "";
			$this->detection->TooltipValue = "";

			// RPNCalc
			$this->RPNCalc->LinkCustomAttributes = "";
			$this->RPNCalc->HrefValue = "";
			$this->RPNCalc->TooltipValue = "";

			// recomendedAction
			$this->recomendedAction->LinkCustomAttributes = "";
			$this->recomendedAction->HrefValue = "";
			$this->recomendedAction->TooltipValue = "";
			if (!$this->isExport())
				$this->recomendedAction->ViewValue = $this->highlightValue($this->recomendedAction);

			// idResponsible
			$this->idResponsible->LinkCustomAttributes = "";
			$this->idResponsible->HrefValue = "";
			$this->idResponsible->TooltipValue = "";
			if (!$this->isExport())
				$this->idResponsible->ViewValue = $this->highlightValue($this->idResponsible);

			// targetDate
			$this->targetDate->LinkCustomAttributes = "";
			$this->targetDate->HrefValue = "";
			$this->targetDate->TooltipValue = "";

			// revisedKc
			$this->revisedKc->LinkCustomAttributes = "";
			$this->revisedKc->HrefValue = "";
			$this->revisedKc->TooltipValue = "";

			// expectedSeverity
			$this->expectedSeverity->LinkCustomAttributes = "";
			$this->expectedSeverity->HrefValue = "";
			$this->expectedSeverity->TooltipValue = "";

			// expectedOccurrence
			$this->expectedOccurrence->LinkCustomAttributes = "";
			$this->expectedOccurrence->HrefValue = "";
			$this->expectedOccurrence->TooltipValue = "";

			// expectedDetection
			$this->expectedDetection->LinkCustomAttributes = "";
			$this->expectedDetection->HrefValue = "";
			$this->expectedDetection->TooltipValue = "";

			// expectedRPNPAO
			$this->expectedRPNPAO->LinkCustomAttributes = "";
			$this->expectedRPNPAO->HrefValue = "";
			$this->expectedRPNPAO->TooltipValue = "";

			// expectedClosureDate
			$this->expectedClosureDate->LinkCustomAttributes = "";
			$this->expectedClosureDate->HrefValue = "";
			$this->expectedClosureDate->TooltipValue = "";

			// recomendedActiondet
			$this->recomendedActiondet->LinkCustomAttributes = "";
			$this->recomendedActiondet->HrefValue = "";
			$this->recomendedActiondet->TooltipValue = "";
			if (!$this->isExport())
				$this->recomendedActiondet->ViewValue = $this->highlightValue($this->recomendedActiondet);

			// idResponsibleDet
			$this->idResponsibleDet->LinkCustomAttributes = "";
			$this->idResponsibleDet->HrefValue = "";
			$this->idResponsibleDet->TooltipValue = "";
			if (!$this->isExport())
				$this->idResponsibleDet->ViewValue = $this->highlightValue($this->idResponsibleDet);

			// targetDatedet
			$this->targetDatedet->LinkCustomAttributes = "";
			$this->targetDatedet->HrefValue = "";
			$this->targetDatedet->TooltipValue = "";

			// kcdet
			$this->kcdet->LinkCustomAttributes = "";
			$this->kcdet->HrefValue = "";
			$this->kcdet->TooltipValue = "";

			// expectedSeveritydet
			$this->expectedSeveritydet->LinkCustomAttributes = "";
			$this->expectedSeveritydet->HrefValue = "";
			$this->expectedSeveritydet->TooltipValue = "";

			// expectedOccurrencedet
			$this->expectedOccurrencedet->LinkCustomAttributes = "";
			$this->expectedOccurrencedet->HrefValue = "";
			$this->expectedOccurrencedet->TooltipValue = "";

			// expectedDetectiondet
			$this->expectedDetectiondet->LinkCustomAttributes = "";
			$this->expectedDetectiondet->HrefValue = "";
			$this->expectedDetectiondet->TooltipValue = "";

			// expectedRPNPAD
			$this->expectedRPNPAD->LinkCustomAttributes = "";
			$this->expectedRPNPAD->HrefValue = "";
			$this->expectedRPNPAD->TooltipValue = "";

			// revisedClosureDatedet
			$this->revisedClosureDatedet->LinkCustomAttributes = "";
			$this->revisedClosureDatedet->HrefValue = "";
			$this->revisedClosureDatedet->TooltipValue = "";

			// revisedSeverity
			$this->revisedSeverity->LinkCustomAttributes = "";
			$this->revisedSeverity->HrefValue = "";
			$this->revisedSeverity->TooltipValue = "";

			// revisedOccurrence
			$this->revisedOccurrence->LinkCustomAttributes = "";
			$this->revisedOccurrence->HrefValue = "";
			$this->revisedOccurrence->TooltipValue = "";

			// revisedDetection
			$this->revisedDetection->LinkCustomAttributes = "";
			$this->revisedDetection->HrefValue = "";
			$this->revisedDetection->TooltipValue = "";

			// revisedRPNCalc
			$this->revisedRPNCalc->LinkCustomAttributes = "";
			$this->revisedRPNCalc->HrefValue = "";
			$this->revisedRPNCalc->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// idProcess
			$this->idProcess->EditAttrs["class"] = "form-control";
			$this->idProcess->EditCustomAttributes = "";
			if ($this->idProcess->getSessionValue() != "") {
				$this->idProcess->CurrentValue = $this->idProcess->getSessionValue();
				$this->idProcess->OldValue = $this->idProcess->CurrentValue;
				$this->idProcess->ViewValue = $this->idProcess->CurrentValue;
				$this->idProcess->ViewValue = FormatNumber($this->idProcess->ViewValue, 0, -2, -2, -2);
				$this->idProcess->ViewCustomAttributes = "";
			} else {
				$this->idProcess->EditValue = HtmlEncode($this->idProcess->CurrentValue);
				$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());
			}

			// idCause
			$this->idCause->EditAttrs["class"] = "form-control";
			$this->idCause->EditCustomAttributes = "";
			$curVal = trim(strval($this->idCause->CurrentValue));
			if ($curVal != "")
				$this->idCause->ViewValue = $this->idCause->lookupCacheOption($curVal);
			else
				$this->idCause->ViewValue = $this->idCause->Lookup !== NULL && is_array($this->idCause->Lookup->Options) ? $curVal : NULL;
			if ($this->idCause->ViewValue !== NULL) { // Load from cache
				$this->idCause->EditValue = array_values($this->idCause->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idCause`" . SearchString("=", $this->idCause->CurrentValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idCause->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idCause->EditValue = $arwrk;
			}

			// potentialCauses
			$this->potentialCauses->EditAttrs["class"] = "form-control";
			$this->potentialCauses->EditCustomAttributes = "";
			$this->potentialCauses->EditValue = HtmlEncode($this->potentialCauses->CurrentValue);
			$this->potentialCauses->PlaceHolder = RemoveHtml($this->potentialCauses->caption());

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->EditAttrs["class"] = "form-control";
			$this->currentPreventiveControlMethod->EditCustomAttributes = "";
			if (!$this->currentPreventiveControlMethod->Raw)
				$this->currentPreventiveControlMethod->CurrentValue = HtmlDecode($this->currentPreventiveControlMethod->CurrentValue);
			$this->currentPreventiveControlMethod->EditValue = HtmlEncode($this->currentPreventiveControlMethod->CurrentValue);
			$this->currentPreventiveControlMethod->PlaceHolder = RemoveHtml($this->currentPreventiveControlMethod->caption());

			// severity
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue = HtmlEncode($this->severity->CurrentValue);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());

			// occurrence
			$this->occurrence->EditAttrs["class"] = "form-control";
			$this->occurrence->EditCustomAttributes = "";
			$this->occurrence->EditValue = HtmlEncode($this->occurrence->CurrentValue);
			$this->occurrence->PlaceHolder = RemoveHtml($this->occurrence->caption());

			// currentControlMethod
			$this->currentControlMethod->EditAttrs["class"] = "form-control";
			$this->currentControlMethod->EditCustomAttributes = "";
			if (!$this->currentControlMethod->Raw)
				$this->currentControlMethod->CurrentValue = HtmlDecode($this->currentControlMethod->CurrentValue);
			$this->currentControlMethod->EditValue = HtmlEncode($this->currentControlMethod->CurrentValue);
			$this->currentControlMethod->PlaceHolder = RemoveHtml($this->currentControlMethod->caption());

			// detection
			$this->detection->EditAttrs["class"] = "form-control";
			$this->detection->EditCustomAttributes = "";
			$this->detection->EditValue = HtmlEncode($this->detection->CurrentValue);
			$this->detection->PlaceHolder = RemoveHtml($this->detection->caption());

			// RPNCalc
			$this->RPNCalc->EditAttrs["class"] = "form-control";
			$this->RPNCalc->EditCustomAttributes = "";
			$this->RPNCalc->EditValue = HtmlEncode($this->RPNCalc->CurrentValue);
			$this->RPNCalc->PlaceHolder = RemoveHtml($this->RPNCalc->caption());

			// recomendedAction
			$this->recomendedAction->EditAttrs["class"] = "form-control";
			$this->recomendedAction->EditCustomAttributes = "background-color: #56d226";
			$this->recomendedAction->EditValue = HtmlEncode($this->recomendedAction->CurrentValue);
			$this->recomendedAction->PlaceHolder = RemoveHtml($this->recomendedAction->caption());

			// idResponsible
			$this->idResponsible->EditCustomAttributes = "";
			$curVal = trim(strval($this->idResponsible->CurrentValue));
			if ($curVal != "")
				$this->idResponsible->ViewValue = $this->idResponsible->lookupCacheOption($curVal);
			else
				$this->idResponsible->ViewValue = $this->idResponsible->Lookup !== NULL && is_array($this->idResponsible->Lookup->Options) ? $curVal : NULL;
			if ($this->idResponsible->ViewValue !== NULL) { // Load from cache
				$this->idResponsible->EditValue = array_values($this->idResponsible->Lookup->Options);
				if ($this->idResponsible->ViewValue == "")
					$this->idResponsible->ViewValue = $Language->phrase("PleaseSelect");
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$arwrk = explode(",", $curVal);
					$filterWrk = "";
					foreach ($arwrk as $wrk) {
						if ($filterWrk != "")
							$filterWrk .= " OR ";
						$filterWrk .= "`idEmployee`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
					}
				}
				$sqlWrk = $this->idResponsible->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idResponsible->ViewValue = new OptionValues();
					$ari = 0;
					while (!$rswrk->EOF) {
						$arwrk = [];
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$arwrk[2] = HtmlEncode($rswrk->fields('df2'));
						$this->idResponsible->ViewValue->add($this->idResponsible->displayValue($arwrk));
						$rswrk->MoveNext();
						$ari++;
					}
					$rswrk->MoveFirst();
				} else {
					$this->idResponsible->ViewValue = $Language->phrase("PleaseSelect");
				}
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idResponsible->EditValue = $arwrk;
			}

			// targetDate
			$this->targetDate->EditAttrs["class"] = "form-control";
			$this->targetDate->EditCustomAttributes = "";
			$this->targetDate->EditValue = HtmlEncode(FormatDateTime($this->targetDate->CurrentValue, 14));
			$this->targetDate->PlaceHolder = RemoveHtml($this->targetDate->caption());

			// revisedKc
			$this->revisedKc->EditCustomAttributes = "";
			$this->revisedKc->EditValue = $this->revisedKc->options(FALSE);

			// expectedSeverity
			$this->expectedSeverity->EditAttrs["class"] = "form-control";
			$this->expectedSeverity->EditCustomAttributes = "";
			$this->expectedSeverity->EditValue = HtmlEncode($this->expectedSeverity->CurrentValue);
			$this->expectedSeverity->PlaceHolder = RemoveHtml($this->expectedSeverity->caption());

			// expectedOccurrence
			$this->expectedOccurrence->EditAttrs["class"] = "form-control";
			$this->expectedOccurrence->EditCustomAttributes = "";
			$this->expectedOccurrence->EditValue = HtmlEncode($this->expectedOccurrence->CurrentValue);
			$this->expectedOccurrence->PlaceHolder = RemoveHtml($this->expectedOccurrence->caption());

			// expectedDetection
			$this->expectedDetection->EditAttrs["class"] = "form-control";
			$this->expectedDetection->EditCustomAttributes = "";
			$this->expectedDetection->EditValue = HtmlEncode($this->expectedDetection->CurrentValue);
			$this->expectedDetection->PlaceHolder = RemoveHtml($this->expectedDetection->caption());

			// expectedRPNPAO
			$this->expectedRPNPAO->EditAttrs["class"] = "form-control";
			$this->expectedRPNPAO->EditCustomAttributes = "";
			$this->expectedRPNPAO->EditValue = HtmlEncode($this->expectedRPNPAO->CurrentValue);
			$this->expectedRPNPAO->PlaceHolder = RemoveHtml($this->expectedRPNPAO->caption());

			// expectedClosureDate
			$this->expectedClosureDate->EditAttrs["class"] = "form-control";
			$this->expectedClosureDate->EditCustomAttributes = "";
			$this->expectedClosureDate->EditValue = HtmlEncode(FormatDateTime($this->expectedClosureDate->CurrentValue, 12));
			$this->expectedClosureDate->PlaceHolder = RemoveHtml($this->expectedClosureDate->caption());

			// recomendedActiondet
			$this->recomendedActiondet->EditAttrs["class"] = "form-control";
			$this->recomendedActiondet->EditCustomAttributes = "";
			if (!$this->recomendedActiondet->Raw)
				$this->recomendedActiondet->CurrentValue = HtmlDecode($this->recomendedActiondet->CurrentValue);
			$this->recomendedActiondet->EditValue = HtmlEncode($this->recomendedActiondet->CurrentValue);
			$this->recomendedActiondet->PlaceHolder = RemoveHtml($this->recomendedActiondet->caption());

			// idResponsibleDet
			$this->idResponsibleDet->EditCustomAttributes = "";
			$curVal = trim(strval($this->idResponsibleDet->CurrentValue));
			if ($curVal != "")
				$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->lookupCacheOption($curVal);
			else
				$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->Lookup !== NULL && is_array($this->idResponsibleDet->Lookup->Options) ? $curVal : NULL;
			if ($this->idResponsibleDet->ViewValue !== NULL) { // Load from cache
				$this->idResponsibleDet->EditValue = array_values($this->idResponsibleDet->Lookup->Options);
				if ($this->idResponsibleDet->ViewValue == "")
					$this->idResponsibleDet->ViewValue = $Language->phrase("PleaseSelect");
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$arwrk = explode(",", $curVal);
					$filterWrk = "";
					foreach ($arwrk as $wrk) {
						if ($filterWrk != "")
							$filterWrk .= " OR ";
						$filterWrk .= "`idEmployee`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
					}
				}
				$sqlWrk = $this->idResponsibleDet->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idResponsibleDet->ViewValue = new OptionValues();
					$ari = 0;
					while (!$rswrk->EOF) {
						$arwrk = [];
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$arwrk[2] = HtmlEncode($rswrk->fields('df2'));
						$this->idResponsibleDet->ViewValue->add($this->idResponsibleDet->displayValue($arwrk));
						$rswrk->MoveNext();
						$ari++;
					}
					$rswrk->MoveFirst();
				} else {
					$this->idResponsibleDet->ViewValue = $Language->phrase("PleaseSelect");
				}
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idResponsibleDet->EditValue = $arwrk;
			}

			// targetDatedet
			$this->targetDatedet->EditAttrs["class"] = "form-control";
			$this->targetDatedet->EditCustomAttributes = "";
			$this->targetDatedet->EditValue = HtmlEncode(FormatDateTime($this->targetDatedet->CurrentValue, 14));
			$this->targetDatedet->PlaceHolder = RemoveHtml($this->targetDatedet->caption());

			// kcdet
			$this->kcdet->EditCustomAttributes = "";
			$this->kcdet->EditValue = $this->kcdet->options(FALSE);

			// expectedSeveritydet
			$this->expectedSeveritydet->EditAttrs["class"] = "form-control";
			$this->expectedSeveritydet->EditCustomAttributes = "";
			$this->expectedSeveritydet->EditValue = HtmlEncode($this->expectedSeveritydet->CurrentValue);
			$this->expectedSeveritydet->PlaceHolder = RemoveHtml($this->expectedSeveritydet->caption());

			// expectedOccurrencedet
			$this->expectedOccurrencedet->EditAttrs["class"] = "form-control";
			$this->expectedOccurrencedet->EditCustomAttributes = "";
			$this->expectedOccurrencedet->EditValue = HtmlEncode($this->expectedOccurrencedet->CurrentValue);
			$this->expectedOccurrencedet->PlaceHolder = RemoveHtml($this->expectedOccurrencedet->caption());

			// expectedDetectiondet
			$this->expectedDetectiondet->EditAttrs["class"] = "form-control";
			$this->expectedDetectiondet->EditCustomAttributes = "";
			$this->expectedDetectiondet->EditValue = HtmlEncode($this->expectedDetectiondet->CurrentValue);
			$this->expectedDetectiondet->PlaceHolder = RemoveHtml($this->expectedDetectiondet->caption());

			// expectedRPNPAD
			$this->expectedRPNPAD->EditAttrs["class"] = "form-control";
			$this->expectedRPNPAD->EditCustomAttributes = "";
			$this->expectedRPNPAD->EditValue = HtmlEncode($this->expectedRPNPAD->CurrentValue);
			$this->expectedRPNPAD->PlaceHolder = RemoveHtml($this->expectedRPNPAD->caption());

			// revisedClosureDatedet
			$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
			$this->revisedClosureDatedet->EditCustomAttributes = "";
			$this->revisedClosureDatedet->EditValue = HtmlEncode(FormatDateTime($this->revisedClosureDatedet->CurrentValue, 14));
			$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());

			// revisedSeverity
			$this->revisedSeverity->EditAttrs["class"] = "form-control";
			$this->revisedSeverity->EditCustomAttributes = "";
			$this->revisedSeverity->EditValue = HtmlEncode($this->revisedSeverity->CurrentValue);
			$this->revisedSeverity->PlaceHolder = RemoveHtml($this->revisedSeverity->caption());

			// revisedOccurrence
			$this->revisedOccurrence->EditAttrs["class"] = "form-control";
			$this->revisedOccurrence->EditCustomAttributes = "";
			$this->revisedOccurrence->EditValue = HtmlEncode($this->revisedOccurrence->CurrentValue);
			$this->revisedOccurrence->PlaceHolder = RemoveHtml($this->revisedOccurrence->caption());

			// revisedDetection
			$this->revisedDetection->EditAttrs["class"] = "form-control";
			$this->revisedDetection->EditCustomAttributes = "";
			$this->revisedDetection->EditValue = HtmlEncode($this->revisedDetection->CurrentValue);
			$this->revisedDetection->PlaceHolder = RemoveHtml($this->revisedDetection->caption());

			// revisedRPNCalc
			$this->revisedRPNCalc->EditAttrs["class"] = "form-control";
			$this->revisedRPNCalc->EditCustomAttributes = "";
			$this->revisedRPNCalc->EditValue = HtmlEncode($this->revisedRPNCalc->CurrentValue);
			$this->revisedRPNCalc->PlaceHolder = RemoveHtml($this->revisedRPNCalc->caption());

			// Add refer script
			// idProcess

			$this->idProcess->LinkCustomAttributes = "";
			$this->idProcess->HrefValue = "";

			// idCause
			$this->idCause->LinkCustomAttributes = "";
			$this->idCause->HrefValue = "";

			// potentialCauses
			$this->potentialCauses->LinkCustomAttributes = "";
			$this->potentialCauses->HrefValue = "";

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->LinkCustomAttributes = "";
			$this->currentPreventiveControlMethod->HrefValue = "";

			// severity
			$this->severity->LinkCustomAttributes = "";
			$this->severity->HrefValue = "";

			// occurrence
			$this->occurrence->LinkCustomAttributes = "";
			$this->occurrence->HrefValue = "";

			// currentControlMethod
			$this->currentControlMethod->LinkCustomAttributes = "";
			$this->currentControlMethod->HrefValue = "";

			// detection
			$this->detection->LinkCustomAttributes = "";
			$this->detection->HrefValue = "";

			// RPNCalc
			$this->RPNCalc->LinkCustomAttributes = "";
			$this->RPNCalc->HrefValue = "";

			// recomendedAction
			$this->recomendedAction->LinkCustomAttributes = "";
			$this->recomendedAction->HrefValue = "";

			// idResponsible
			$this->idResponsible->LinkCustomAttributes = "";
			$this->idResponsible->HrefValue = "";

			// targetDate
			$this->targetDate->LinkCustomAttributes = "";
			$this->targetDate->HrefValue = "";

			// revisedKc
			$this->revisedKc->LinkCustomAttributes = "";
			$this->revisedKc->HrefValue = "";

			// expectedSeverity
			$this->expectedSeverity->LinkCustomAttributes = "";
			$this->expectedSeverity->HrefValue = "";

			// expectedOccurrence
			$this->expectedOccurrence->LinkCustomAttributes = "";
			$this->expectedOccurrence->HrefValue = "";

			// expectedDetection
			$this->expectedDetection->LinkCustomAttributes = "";
			$this->expectedDetection->HrefValue = "";

			// expectedRPNPAO
			$this->expectedRPNPAO->LinkCustomAttributes = "";
			$this->expectedRPNPAO->HrefValue = "";

			// expectedClosureDate
			$this->expectedClosureDate->LinkCustomAttributes = "";
			$this->expectedClosureDate->HrefValue = "";

			// recomendedActiondet
			$this->recomendedActiondet->LinkCustomAttributes = "";
			$this->recomendedActiondet->HrefValue = "";

			// idResponsibleDet
			$this->idResponsibleDet->LinkCustomAttributes = "";
			$this->idResponsibleDet->HrefValue = "";

			// targetDatedet
			$this->targetDatedet->LinkCustomAttributes = "";
			$this->targetDatedet->HrefValue = "";

			// kcdet
			$this->kcdet->LinkCustomAttributes = "";
			$this->kcdet->HrefValue = "";

			// expectedSeveritydet
			$this->expectedSeveritydet->LinkCustomAttributes = "";
			$this->expectedSeveritydet->HrefValue = "";

			// expectedOccurrencedet
			$this->expectedOccurrencedet->LinkCustomAttributes = "";
			$this->expectedOccurrencedet->HrefValue = "";

			// expectedDetectiondet
			$this->expectedDetectiondet->LinkCustomAttributes = "";
			$this->expectedDetectiondet->HrefValue = "";

			// expectedRPNPAD
			$this->expectedRPNPAD->LinkCustomAttributes = "";
			$this->expectedRPNPAD->HrefValue = "";

			// revisedClosureDatedet
			$this->revisedClosureDatedet->LinkCustomAttributes = "";
			$this->revisedClosureDatedet->HrefValue = "";

			// revisedSeverity
			$this->revisedSeverity->LinkCustomAttributes = "";
			$this->revisedSeverity->HrefValue = "";

			// revisedOccurrence
			$this->revisedOccurrence->LinkCustomAttributes = "";
			$this->revisedOccurrence->HrefValue = "";

			// revisedDetection
			$this->revisedDetection->LinkCustomAttributes = "";
			$this->revisedDetection->HrefValue = "";

			// revisedRPNCalc
			$this->revisedRPNCalc->LinkCustomAttributes = "";
			$this->revisedRPNCalc->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();

		// Save data for Custom Template
		if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD)
			$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Validate search
	protected function validateSearch()
	{
		global $SearchError;

		// Initialize
		$SearchError = "";

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return TRUE;

		// Return validate result
		$validateSearch = ($SearchError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateSearch = $validateSearch && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($SearchError, $formCustomError);
		}
		return $validateSearch;
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->idProcess->Required) {
			if (!$this->idProcess->IsDetailKey && $this->idProcess->FormValue != NULL && $this->idProcess->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idProcess->caption(), $this->idProcess->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->idProcess->FormValue)) {
			AddMessage($FormError, $this->idProcess->errorMessage());
		}
		if ($this->idCause->Required) {
			if (!$this->idCause->IsDetailKey && $this->idCause->FormValue != NULL && $this->idCause->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idCause->caption(), $this->idCause->RequiredErrorMessage));
			}
		}
		if ($this->potentialCauses->Required) {
			if (!$this->potentialCauses->IsDetailKey && $this->potentialCauses->FormValue != NULL && $this->potentialCauses->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->potentialCauses->caption(), $this->potentialCauses->RequiredErrorMessage));
			}
		}
		if ($this->currentPreventiveControlMethod->Required) {
			if (!$this->currentPreventiveControlMethod->IsDetailKey && $this->currentPreventiveControlMethod->FormValue != NULL && $this->currentPreventiveControlMethod->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->currentPreventiveControlMethod->caption(), $this->currentPreventiveControlMethod->RequiredErrorMessage));
			}
		}
		if ($this->severity->Required) {
			if (!$this->severity->IsDetailKey && $this->severity->FormValue != NULL && $this->severity->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->severity->caption(), $this->severity->RequiredErrorMessage));
			}
		}
		if ($this->occurrence->Required) {
			if (!$this->occurrence->IsDetailKey && $this->occurrence->FormValue != NULL && $this->occurrence->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->occurrence->caption(), $this->occurrence->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->occurrence->FormValue)) {
			AddMessage($FormError, $this->occurrence->errorMessage());
		}
		if ($this->currentControlMethod->Required) {
			if (!$this->currentControlMethod->IsDetailKey && $this->currentControlMethod->FormValue != NULL && $this->currentControlMethod->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->currentControlMethod->caption(), $this->currentControlMethod->RequiredErrorMessage));
			}
		}
		if ($this->detection->Required) {
			if (!$this->detection->IsDetailKey && $this->detection->FormValue != NULL && $this->detection->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->detection->caption(), $this->detection->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->detection->FormValue)) {
			AddMessage($FormError, $this->detection->errorMessage());
		}
		if ($this->RPNCalc->Required) {
			if (!$this->RPNCalc->IsDetailKey && $this->RPNCalc->FormValue != NULL && $this->RPNCalc->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->RPNCalc->caption(), $this->RPNCalc->RequiredErrorMessage));
			}
		}
		if ($this->recomendedAction->Required) {
			if (!$this->recomendedAction->IsDetailKey && $this->recomendedAction->FormValue != NULL && $this->recomendedAction->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->recomendedAction->caption(), $this->recomendedAction->RequiredErrorMessage));
			}
		}
		if ($this->idResponsible->Required) {
			if ($this->idResponsible->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idResponsible->caption(), $this->idResponsible->RequiredErrorMessage));
			}
		}
		if ($this->targetDate->Required) {
			if (!$this->targetDate->IsDetailKey && $this->targetDate->FormValue != NULL && $this->targetDate->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->targetDate->caption(), $this->targetDate->RequiredErrorMessage));
			}
		}
		if (!CheckShortEuroDate($this->targetDate->FormValue)) {
			AddMessage($FormError, $this->targetDate->errorMessage());
		}
		if ($this->revisedKc->Required) {
			if ($this->revisedKc->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->revisedKc->caption(), $this->revisedKc->RequiredErrorMessage));
			}
		}
		if ($this->expectedSeverity->Required) {
			if (!$this->expectedSeverity->IsDetailKey && $this->expectedSeverity->FormValue != NULL && $this->expectedSeverity->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedSeverity->caption(), $this->expectedSeverity->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->expectedSeverity->FormValue)) {
			AddMessage($FormError, $this->expectedSeverity->errorMessage());
		}
		if ($this->expectedOccurrence->Required) {
			if (!$this->expectedOccurrence->IsDetailKey && $this->expectedOccurrence->FormValue != NULL && $this->expectedOccurrence->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedOccurrence->caption(), $this->expectedOccurrence->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->expectedOccurrence->FormValue)) {
			AddMessage($FormError, $this->expectedOccurrence->errorMessage());
		}
		if ($this->expectedDetection->Required) {
			if (!$this->expectedDetection->IsDetailKey && $this->expectedDetection->FormValue != NULL && $this->expectedDetection->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedDetection->caption(), $this->expectedDetection->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->expectedDetection->FormValue)) {
			AddMessage($FormError, $this->expectedDetection->errorMessage());
		}
		if ($this->expectedRPNPAO->Required) {
			if (!$this->expectedRPNPAO->IsDetailKey && $this->expectedRPNPAO->FormValue != NULL && $this->expectedRPNPAO->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedRPNPAO->caption(), $this->expectedRPNPAO->RequiredErrorMessage));
			}
		}
		if ($this->expectedClosureDate->Required) {
			if (!$this->expectedClosureDate->IsDetailKey && $this->expectedClosureDate->FormValue != NULL && $this->expectedClosureDate->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedClosureDate->caption(), $this->expectedClosureDate->RequiredErrorMessage));
			}
		}
		if ($this->recomendedActiondet->Required) {
			if (!$this->recomendedActiondet->IsDetailKey && $this->recomendedActiondet->FormValue != NULL && $this->recomendedActiondet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->recomendedActiondet->caption(), $this->recomendedActiondet->RequiredErrorMessage));
			}
		}
		if ($this->idResponsibleDet->Required) {
			if ($this->idResponsibleDet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idResponsibleDet->caption(), $this->idResponsibleDet->RequiredErrorMessage));
			}
		}
		if ($this->targetDatedet->Required) {
			if (!$this->targetDatedet->IsDetailKey && $this->targetDatedet->FormValue != NULL && $this->targetDatedet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->targetDatedet->caption(), $this->targetDatedet->RequiredErrorMessage));
			}
		}
		if (!CheckShortEuroDate($this->targetDatedet->FormValue)) {
			AddMessage($FormError, $this->targetDatedet->errorMessage());
		}
		if ($this->kcdet->Required) {
			if ($this->kcdet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->kcdet->caption(), $this->kcdet->RequiredErrorMessage));
			}
		}
		if ($this->expectedSeveritydet->Required) {
			if (!$this->expectedSeveritydet->IsDetailKey && $this->expectedSeveritydet->FormValue != NULL && $this->expectedSeveritydet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedSeveritydet->caption(), $this->expectedSeveritydet->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->expectedSeveritydet->FormValue)) {
			AddMessage($FormError, $this->expectedSeveritydet->errorMessage());
		}
		if ($this->expectedOccurrencedet->Required) {
			if (!$this->expectedOccurrencedet->IsDetailKey && $this->expectedOccurrencedet->FormValue != NULL && $this->expectedOccurrencedet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedOccurrencedet->caption(), $this->expectedOccurrencedet->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->expectedOccurrencedet->FormValue)) {
			AddMessage($FormError, $this->expectedOccurrencedet->errorMessage());
		}
		if ($this->expectedDetectiondet->Required) {
			if (!$this->expectedDetectiondet->IsDetailKey && $this->expectedDetectiondet->FormValue != NULL && $this->expectedDetectiondet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedDetectiondet->caption(), $this->expectedDetectiondet->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->expectedDetectiondet->FormValue)) {
			AddMessage($FormError, $this->expectedDetectiondet->errorMessage());
		}
		if ($this->expectedRPNPAD->Required) {
			if (!$this->expectedRPNPAD->IsDetailKey && $this->expectedRPNPAD->FormValue != NULL && $this->expectedRPNPAD->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->expectedRPNPAD->caption(), $this->expectedRPNPAD->RequiredErrorMessage));
			}
		}
		if ($this->revisedClosureDatedet->Required) {
			if (!$this->revisedClosureDatedet->IsDetailKey && $this->revisedClosureDatedet->FormValue != NULL && $this->revisedClosureDatedet->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->revisedClosureDatedet->caption(), $this->revisedClosureDatedet->RequiredErrorMessage));
			}
		}
		if (!CheckShortEuroDate($this->revisedClosureDatedet->FormValue)) {
			AddMessage($FormError, $this->revisedClosureDatedet->errorMessage());
		}
		if ($this->revisedSeverity->Required) {
			if (!$this->revisedSeverity->IsDetailKey && $this->revisedSeverity->FormValue != NULL && $this->revisedSeverity->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->revisedSeverity->caption(), $this->revisedSeverity->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->revisedSeverity->FormValue)) {
			AddMessage($FormError, $this->revisedSeverity->errorMessage());
		}
		if ($this->revisedOccurrence->Required) {
			if (!$this->revisedOccurrence->IsDetailKey && $this->revisedOccurrence->FormValue != NULL && $this->revisedOccurrence->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->revisedOccurrence->caption(), $this->revisedOccurrence->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->revisedOccurrence->FormValue)) {
			AddMessage($FormError, $this->revisedOccurrence->errorMessage());
		}
		if ($this->revisedDetection->Required) {
			if (!$this->revisedDetection->IsDetailKey && $this->revisedDetection->FormValue != NULL && $this->revisedDetection->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->revisedDetection->caption(), $this->revisedDetection->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->revisedDetection->FormValue)) {
			AddMessage($FormError, $this->revisedDetection->errorMessage());
		}
		if ($this->revisedRPNCalc->Required) {
			if (!$this->revisedRPNCalc->IsDetailKey && $this->revisedRPNCalc->FormValue != NULL && $this->revisedRPNCalc->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->revisedRPNCalc->caption(), $this->revisedRPNCalc->RequiredErrorMessage));
			}
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Delete records based on current filter
	protected function deleteRows()
	{
		global $Language, $Security;
		if (!$Security->canDelete()) {
			$this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$deleteRows = TRUE;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
			$rs->close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->getRows() : [];

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->close();

		// Call row deleting event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$deleteRows = $this->Row_Deleting($row);
				if (!$deleteRows)
					break;
			}
		}
		if ($deleteRows) {
			$key = "";
			foreach ($rsold as $row) {
				$thisKey = "";
				if ($thisKey != "")
					$thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
				$thisKey .= $row['idProcess'];
				if ($thisKey != "")
					$thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
				$thisKey .= $row['idCause'];
				if (Config("DELETE_UPLOADED_FILES")) // Delete old files
					$this->deleteUploadedFiles($row);
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				$deleteRows = $this->delete($row); // Delete
				$conn->raiseErrorFn = "";
				if ($deleteRows === FALSE)
					break;
				if ($key != "")
					$key .= ", ";
				$key .= $thisKey;
			}
		}
		if (!$deleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("DeleteCancelled"));
			}
		}

		// Call Row Deleted event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}

		// Write JSON for API request (Support single row only)
		if (IsApi() && $deleteRows) {
			$row = $this->getRecordsFromRecordset($rsold, TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $deleteRows;
	}

	/**
	 * Import file
	 *
	 * @param string $filetoken File token to locate the uploaded import file
	 * @return boolean
	 */
	public function import($filetoken)
	{
		global $Security, $Language;
		if (!$Security->canImport())
			return FALSE; // Import not allowed

		// Check if valid token
		if (EmptyValue($filetoken))
			return FALSE;

		// Get uploaded files by token
		$upload = new HttpUpload();
		$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $upload->getUploadedFileName($filetoken, TRUE));
		$exts = explode(",", Config("IMPORT_FILE_ALLOWED_EXT"));
		$totCnt = 0;
		$totSuccessCnt = 0;
		$totFailCnt = 0;
		$result = [Config("API_FILE_TOKEN_NAME") => $filetoken, "files" => [], "success" => FALSE];

		// Import records
		foreach ($files as $file) {
			$res = [Config("API_FILE_TOKEN_NAME") => $filetoken, "file" => basename($file)];
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

			// Ignore log file
			if ($ext == "txt")
				continue;
			if (!in_array($ext, $exts)) {
				$res = array_merge($res, ["error" => str_replace("%e", $ext, $Language->phrase("ImportMessageInvalidFileExtension"))]);
				WriteJson($res);
				return FALSE;
			}

			// Set up options for Page Importing event
			// Get optional data from $_POST first

			$ar = array_keys($_POST);
			$options = [];
			foreach ($ar as $key) {
				if (!in_array($key, ["action", Config("TOKEN_NAME"), "filetoken"]))
					$options[$key] = $_POST[$key];
			}

			// Merge default options
			$options = array_merge(["maxExecutionTime" => $this->ImportMaxExecutionTime, "file" => $file, "activeSheet" => 0, "headerRowNumber" => 0, "headers" => [], "offset" => 0, "limit" => 0], $options);
			if ($ext == "csv")
				$options = array_merge(["inputEncoding" => $this->ImportCsvEncoding, "delimiter" => $this->ImportCsvDelimiter, "enclosure" => $this->ImportCsvQuoteCharacter], $options);
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($ext));

			// Call Page Importing server event
			if (!$this->Page_Importing($reader, $options)) {
				WriteJson($res);
				return FALSE;
			}

			// Set max execution time
			if ($options["maxExecutionTime"] > 0)
				ini_set("max_execution_time", $options["maxExecutionTime"]);
			try {
				if ($ext == "csv") {
					if ($options["inputEncoding"] != '')
						$reader->setInputEncoding($options["inputEncoding"]);
					if ($options["delimiter"] != '')
						$reader->setDelimiter($options["delimiter"]);
					if ($options["enclosure"] != '')
						$reader->setEnclosure($options["enclosure"]);
				}
				$spreadsheet = @$reader->load($file);
			} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
				$res = array_merge($res, ["error" => $e->getMessage()]);
				WriteJson($res);
				return FALSE;
			}

			// Get active worksheet
			$spreadsheet->setActiveSheetIndex($options["activeSheet"]);
			$worksheet = $spreadsheet->getActiveSheet();

			// Get row and column indexes
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

			// Get column headers
			$headers = $options["headers"];
			$headerRow = 0;
			if (count($headers) == 0) { // Undetermined, load from header row
				$headerRow = $options["headerRowNumber"] + 1;
				$headers = $this->getImportHeaders($worksheet, $headerRow, $highestColumn);
			}
			if (count($headers) == 0) { // Unable to load header
				$res["error"] = $Language->phrase("ImportMessageNoHeaderRow");
				WriteJson($res);
				return FALSE;
			}
			foreach ($headers as $name) {
				if (!array_key_exists($name, $this->fields)) { // Unidentified field, not header row
					$res["error"] = str_replace('%f', $name, $Language->phrase("ImportMessageInvalidFieldName"));
					WriteJson($res);
					return FALSE;
				}
			}
			$startRow = $headerRow + 1;
			$endRow = $highestRow;
			if ($options["offset"] > 0)
				$startRow += $options["offset"];
			if ($options["limit"] > 0) {
				$endRow = $startRow + $options["limit"] - 1;
				if ($endRow > $highestRow)
					$endRow = $highestRow;
			}
			if ($endRow >= $startRow)
				$records = $this->getImportRecords($worksheet, $startRow, $endRow, $highestColumn);
			else
				$records = [];
			$recordCnt = count($records);
			$cnt = 0;
			$successCnt = 0;
			$failCnt = 0;
			$failList = [];
			$relLogFile = IncludeTrailingDelimiter(UploadPath(FALSE) . Config("UPLOAD_TEMP_FOLDER_PREFIX") . $filetoken, FALSE) . $filetoken . ".txt";
			$res = array_merge($res, ["totalCount" => $recordCnt, "count" => $cnt, "successCount" => $successCnt, "failCount" => 0]);

			// Begin transaction
			if ($this->ImportUseTransaction) {
				$conn = $this->getConnection();
				$conn->beginTrans();
			}

			// Process records
			foreach ($records as $values) {
				$importSuccess = FALSE;
				try {
					$row = array_combine($headers, $values);
					$cnt++;
					$res["count"] = $cnt;
					if ($this->importRow($row, $cnt)) {
						$successCnt++;
						$importSuccess = TRUE;
					} else {
						$failCnt++;
						$failList["row" . $cnt] = $this->getFailureMessage();
						$this->clearFailureMessage(); // Clear error message
					}
				} catch (Exception $e) {
					$failCnt++;
					if ($failList["row" . $cnt] == "")
						$failList["row" . $cnt] = $e->getMessage();
				}

				// Reset count if import fail + use transaction
				if (!$importSuccess && $this->ImportUseTransaction) {
					$successCnt = 0;
					$failCnt = $cnt;
				}

				// Save progress to cache
				$res["successCount"] = $successCnt;
				$res["failCount"] = $failCnt;
				SetCache($filetoken, $res);

				// No need to process further if import fail + use transaction
				if (!$importSuccess && $this->ImportUseTransaction)
					break;
			}
			$res["failList"] = $failList;

			// Commit/Rollback transaction
			if ($this->ImportUseTransaction) {
				$conn = $this->getConnection();
				if ($failCnt > 0) // Rollback
					$conn->rollbackTrans();
				else // Commit
					$conn->commitTrans();
			}
			$totCnt += $cnt;
			$totSuccessCnt += $successCnt;
			$totFailCnt += $failCnt;

			// Call Page Imported server event
			$this->Page_Imported($reader, $res);
			if ($totCnt > 0 && $totFailCnt == 0) { // Clean up if all records imported
				$res["success"] = TRUE;
				$result["success"] = TRUE;
			} else {
				$res["log"] = $relLogFile;
				$result["success"] = FALSE;
			}
			$result["files"][] = $res;
		}
		if ($result["success"])
			CleanUploadTempPaths($filetoken);
		WriteJson($result);
		return $result["success"];
	}

	/**
	 * Get import header
	 *
	 * @param object $ws PhpSpreadsheet worksheet
	 * @param integer $rowIdx Row index for header row (1-based)
	 * @param string $endColName End column Name (e.g. "F")
	 * @return array
	 */
	protected function getImportHeaders($ws, $rowIdx, $endColName) {
		$ar = $ws->rangeToArray("A" . $rowIdx . ":" . $endColName . $rowIdx);
		return $ar[0];
	}

	/**
	 * Get import records
	 *
	 * @param object $ws PhpSpreadsheet worksheet
	 * @param integer $startRowIdx Start row index
	 * @param integer $endRowIdx End row index
	 * @param string $endColName End column Name (e.g. "F")
	 * @return array
	 */
	protected function getImportRecords($ws, $startRowIdx, $endRowIdx, $endColName) {
		$ar = $ws->rangeToArray("A" . $startRowIdx . ":" . $endColName . $endRowIdx);
		return $ar;
	}

	/**
	 * Import a row
	 *
	 * @param array $row
	 * @param integer $cnt
	 * @return boolean
	 */
	protected function importRow($row, $cnt)
	{
		global $Language;

		// Call Row Import server event
		if (!$this->Row_Import($row, $cnt))
			return FALSE;

		// Check field values
		foreach ($row as $name => $value) {
			$fld = $this->fields[$name];
			if (!$this->checkValue($fld, $value)) {
				$this->setFailureMessage(str_replace(["%f", "%v"], [$fld->Name, $value], $Language->phrase("ImportMessageInvalidFieldValue")));
				return FALSE;
			}
		}

		// Insert/Update to database
		if (!$this->ImportInsertOnly && $oldrow = $this->load($row)) {
			$res = $this->update($row, "", $oldrow);
		} else {
			$res = $this->insert($row);
		}
		return $res;
	}

	/**
	 * Check field value
	 *
	 * @param object $fld Field object
	 * @param object $value
	 * @return boolean
	 */
	protected function checkValue($fld, $value)
	{
		if ($fld->DataType == DATATYPE_NUMBER && !is_numeric($value))
			return FALSE;
		elseif ($fld->DataType == DATATYPE_DATE && !CheckDate($value))
			return FALSE;
		return TRUE;
	}

	// Load row
	protected function load($row)
	{
		$filter = $this->getRecordFilter($row);
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF)
			return $rs->fields;
		else
			return NULL;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check referential integrity for master table 'actions'
		$validMasterRecord = TRUE;
		$masterFilter = $this->sqlMasterFilter_processf();
		if (strval($this->idProcess->CurrentValue) != "") {
			$masterFilter = str_replace("@idProcess@", AdjustSql($this->idProcess->CurrentValue, "DB"), $masterFilter);
		} else {
			$validMasterRecord = FALSE;
		}
		if ($validMasterRecord) {
			if (!isset($GLOBALS["processf"]))
				$GLOBALS["processf"] = new processf();
			$rsmaster = $GLOBALS["processf"]->loadRs($masterFilter);
			$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->close();
		}
		if (!$validMasterRecord) {
			$relatedRecordMsg = str_replace("%t", "processf", $Language->phrase("RelatedRecordRequired"));
			$this->setFailureMessage($relatedRecordMsg);
			return FALSE;
		}
		$conn = $this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// idProcess
		$this->idProcess->setDbValueDef($rsnew, $this->idProcess->CurrentValue, 0, FALSE);

		// idCause
		$this->idCause->setDbValueDef($rsnew, $this->idCause->CurrentValue, "", FALSE);

		// potentialCauses
		$this->potentialCauses->setDbValueDef($rsnew, $this->potentialCauses->CurrentValue, NULL, FALSE);

		// currentPreventiveControlMethod
		$this->currentPreventiveControlMethod->setDbValueDef($rsnew, $this->currentPreventiveControlMethod->CurrentValue, NULL, FALSE);

		// severity
		$this->severity->setDbValueDef($rsnew, $this->severity->CurrentValue, NULL, FALSE);

		// occurrence
		$this->occurrence->setDbValueDef($rsnew, $this->occurrence->CurrentValue, NULL, FALSE);

		// currentControlMethod
		$this->currentControlMethod->setDbValueDef($rsnew, $this->currentControlMethod->CurrentValue, NULL, FALSE);

		// detection
		$this->detection->setDbValueDef($rsnew, $this->detection->CurrentValue, NULL, FALSE);

		// RPNCalc
		$this->RPNCalc->setDbValueDef($rsnew, $this->RPNCalc->CurrentValue, NULL, FALSE);

		// recomendedAction
		$this->recomendedAction->setDbValueDef($rsnew, $this->recomendedAction->CurrentValue, NULL, FALSE);

		// idResponsible
		$this->idResponsible->setDbValueDef($rsnew, $this->idResponsible->CurrentValue, NULL, FALSE);

		// targetDate
		$this->targetDate->setDbValueDef($rsnew, UnFormatDateTime($this->targetDate->CurrentValue, 14), NULL, FALSE);

		// revisedKc
		$tmpBool = $this->revisedKc->CurrentValue;
		if ($tmpBool != "1" && $tmpBool != "0")
			$tmpBool = !empty($tmpBool) ? "1" : "0";
		$this->revisedKc->setDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// expectedSeverity
		$this->expectedSeverity->setDbValueDef($rsnew, $this->expectedSeverity->CurrentValue, NULL, FALSE);

		// expectedOccurrence
		$this->expectedOccurrence->setDbValueDef($rsnew, $this->expectedOccurrence->CurrentValue, NULL, FALSE);

		// expectedDetection
		$this->expectedDetection->setDbValueDef($rsnew, $this->expectedDetection->CurrentValue, NULL, FALSE);

		// expectedRPNPAO
		$this->expectedRPNPAO->setDbValueDef($rsnew, $this->expectedRPNPAO->CurrentValue, NULL, FALSE);

		// expectedClosureDate
		$this->expectedClosureDate->setDbValueDef($rsnew, UnFormatDateTime($this->expectedClosureDate->CurrentValue, 12), NULL, FALSE);

		// recomendedActiondet
		$this->recomendedActiondet->setDbValueDef($rsnew, $this->recomendedActiondet->CurrentValue, NULL, FALSE);

		// idResponsibleDet
		$this->idResponsibleDet->setDbValueDef($rsnew, $this->idResponsibleDet->CurrentValue, NULL, FALSE);

		// targetDatedet
		$this->targetDatedet->setDbValueDef($rsnew, UnFormatDateTime($this->targetDatedet->CurrentValue, 14), NULL, FALSE);

		// kcdet
		$tmpBool = $this->kcdet->CurrentValue;
		if ($tmpBool != "1" && $tmpBool != "0")
			$tmpBool = !empty($tmpBool) ? "1" : "0";
		$this->kcdet->setDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// expectedSeveritydet
		$this->expectedSeveritydet->setDbValueDef($rsnew, $this->expectedSeveritydet->CurrentValue, NULL, FALSE);

		// expectedOccurrencedet
		$this->expectedOccurrencedet->setDbValueDef($rsnew, $this->expectedOccurrencedet->CurrentValue, NULL, FALSE);

		// expectedDetectiondet
		$this->expectedDetectiondet->setDbValueDef($rsnew, $this->expectedDetectiondet->CurrentValue, NULL, FALSE);

		// expectedRPNPAD
		$this->expectedRPNPAD->setDbValueDef($rsnew, $this->expectedRPNPAD->CurrentValue, NULL, FALSE);

		// revisedClosureDatedet
		$this->revisedClosureDatedet->setDbValueDef($rsnew, UnFormatDateTime($this->revisedClosureDatedet->CurrentValue, 14), NULL, FALSE);

		// revisedSeverity
		$this->revisedSeverity->setDbValueDef($rsnew, $this->revisedSeverity->CurrentValue, NULL, FALSE);

		// revisedOccurrence
		$this->revisedOccurrence->setDbValueDef($rsnew, $this->revisedOccurrence->CurrentValue, NULL, FALSE);

		// revisedDetection
		$this->revisedDetection->setDbValueDef($rsnew, $this->revisedDetection->CurrentValue, NULL, FALSE);

		// revisedRPNCalc
		$this->revisedRPNCalc->setDbValueDef($rsnew, $this->revisedRPNCalc->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($insertRow && $this->ValidateKey && strval($rsnew['idProcess']) == "") {
			$this->setFailureMessage($Language->phrase("InvalidKeyValue"));
			$insertRow = FALSE;
		}

		// Check if key value entered
		if ($insertRow && $this->ValidateKey && strval($rsnew['idCause']) == "") {
			$this->setFailureMessage($Language->phrase("InvalidKeyValue"));
			$insertRow = FALSE;
		}

		// Check for duplicate key
		if ($insertRow && $this->ValidateKey) {
			$filter = $this->getRecordFilter($rsnew);
			$rsChk = $this->loadRs($filter);
			if ($rsChk && !$rsChk->EOF) {
				$keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
				$this->setFailureMessage($keyErrMsg);
				$rsChk->close();
				$insertRow = FALSE;
			}
		}
		if ($insertRow) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = "";
			if ($addRow) {
			}
		} else {
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("InsertCancelled"));
			}
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Clean upload path if any
		if ($addRow) {
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Load advanced search
	public function loadAdvancedSearch()
	{
		$this->idProcess->AdvancedSearch->load();
		$this->idCause->AdvancedSearch->load();
		$this->potentialCauses->AdvancedSearch->load();
		$this->currentPreventiveControlMethod->AdvancedSearch->load();
		$this->severity->AdvancedSearch->load();
		$this->occurrence->AdvancedSearch->load();
		$this->currentControlMethod->AdvancedSearch->load();
		$this->detection->AdvancedSearch->load();
		$this->RPNCalc->AdvancedSearch->load();
		$this->recomendedAction->AdvancedSearch->load();
		$this->idResponsible->AdvancedSearch->load();
		$this->targetDate->AdvancedSearch->load();
		$this->revisedKc->AdvancedSearch->load();
		$this->expectedSeverity->AdvancedSearch->load();
		$this->expectedOccurrence->AdvancedSearch->load();
		$this->expectedDetection->AdvancedSearch->load();
		$this->expectedRpn->AdvancedSearch->load();
		$this->expectedRPNPAO->AdvancedSearch->load();
		$this->expectedClosureDate->AdvancedSearch->load();
		$this->recomendedActiondet->AdvancedSearch->load();
		$this->idResponsibleDet->AdvancedSearch->load();
		$this->targetDatedet->AdvancedSearch->load();
		$this->kcdet->AdvancedSearch->load();
		$this->expectedSeveritydet->AdvancedSearch->load();
		$this->expectedOccurrencedet->AdvancedSearch->load();
		$this->expectedDetectiondet->AdvancedSearch->load();
		$this->expectedRPNPAD->AdvancedSearch->load();
		$this->revisedClosureDatedet->AdvancedSearch->load();
		$this->revisedSeverity->AdvancedSearch->load();
		$this->revisedOccurrence->AdvancedSearch->load();
		$this->revisedDetection->AdvancedSearch->load();
		$this->revisedRpn->AdvancedSearch->load();
		$this->revisedRPNCalc->AdvancedSearch->load();
	}

	// Get export HTML tag
	protected function getExportTag($type, $custom = FALSE)
	{
		global $Language;
		if (SameText($type, "excel")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.factionslist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
			else
				return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
		} elseif (SameText($type, "word")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.factionslist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
			else
				return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
		} elseif (SameText($type, "pdf")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.factionslist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
			else
				return "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\">" . $Language->phrase("ExportToPDF") . "</a>";
		} elseif (SameText($type, "html")) {
			return "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
		} elseif (SameText($type, "xml")) {
			return "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
		} elseif (SameText($type, "csv")) {
			return "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
		} elseif (SameText($type, "email")) {
			$url = $custom ? ",url:'" . $this->pageUrl() . "export=email&amp;custom=1'" : "";
			return '<button id="emf_actions" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_actions\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.factionslist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
		} elseif (SameText($type, "print")) {
			return "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
		}
	}

	// Set up export options
	protected function setupExportOptions()
	{
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->add("print");
		$item->Body = $this->getExportTag("print");
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->add("excel");
		$item->Body = $this->getExportTag("excel", $this->ExportExcelCustom);
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->add("word");
		$item->Body = $this->getExportTag("word", $this->ExportWordCustom);
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->add("html");
		$item->Body = $this->getExportTag("html");
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->add("xml");
		$item->Body = $this->getExportTag("xml");
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->add("csv");
		$item->Body = $this->getExportTag("csv");
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->add("pdf");
		$item->Body = $this->getExportTag("pdf", $this->ExportPdfCustom);
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->add("email");
		$item->Body = $this->getExportTag("email", $this->ExportEmailCustom);
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up search options
	protected function setupSearchOptions()
	{
		global $Language;
		$this->SearchOptions = new ListOptions("div");
		$this->SearchOptions->TagClassName = "ew-search-option";

		// Search button
		$item = &$this->SearchOptions->add("searchtoggle");
		$searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
		$item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"factionslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->add("showall");
		$item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $this->pageUrl() . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->add("advancedsearch");
		if (IsMobile())
			$item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"actionssrch.php\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-table=\"actions\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'SearchBtn',url:'actionssrch.php'});\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->add("searchhighlight");
		$item->Body = "<a class=\"btn btn-default ew-highlight active\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"factionslistsrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
		$item->Visible = ($this->SearchWhere != "" && $this->TotalRecords > 0);

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->isExport() || $this->CurrentAction)
			$this->SearchOptions->hideAllOptions();
		global $Security;
		if (!$Security->canSearch()) {
			$this->SearchOptions->hideAllOptions();
			$this->FilterOptions->hideAllOptions();
		}
	}

	// Set up import options
	protected function setupImportOptions()
	{
		global $Security, $Language;

		// Import
		$item = &$this->ImportOptions->add("import");
		$item->Body = "<a class=\"ew-import-link ew-import\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("ImportText") . "\" data-caption=\"" . $Language->phrase("ImportText") . "\" onclick=\"return ew.importDialogShow({lnk:this,hdr:ew.language.phrase('ImportText')});\">" . $Language->phrase("Import") . "</a>";
		$item->Visible = $Security->canImport();
		$this->ImportOptions->UseButtonGroup = TRUE;
		$this->ImportOptions->UseDropDownButton = FALSE;
		$this->ImportOptions->DropDownButtonPhrase = $Language->phrase("ButtonImport");

		// Add group option item
		$item = &$this->ImportOptions->add($this->ImportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	/**
	 * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	 *
	 * @param boolean $return Return the data rather than output it
	 * @return mixed
	 */
	public function exportData($return = FALSE)
	{
		global $Language;
		$utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");
		$selectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($selectLimit) {
			$this->TotalRecords = $this->listRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->loadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecords = $rs->RecordCount();
		}
		$this->StartRecord = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
			$this->DisplayRecords = $this->TotalRecords;
			$this->StopRecord = $this->TotalRecords;
		} else { // Export one page only
			$this->setupStartRecord(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecords <= 0) {
				$this->StopRecord = $this->TotalRecords;
			} else {
				$this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
			}
		}
		if ($selectLimit)
			$rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
		$this->ExportDoc = GetExportDocument($this, "h");
		$doc = &$this->ExportDoc;
		if (!$doc)
			$this->setFailureMessage($Language->phrase("ExportClassNotFound")); // Export class not found
		if (!$rs || !$doc) {
			RemoveHeader("Content-Type"); // Remove header
			RemoveHeader("Content-Disposition");
			$this->showMessage();
			return;
		}
		if ($selectLimit) {
			$this->StartRecord = 1;
			$this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;
		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();

		// Export master record
		if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "processf") {
			global $processf;
			if (!isset($processf))
				$processf = new processf();
			$rsmaster = $processf->loadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$exportStyle = $doc->Style;
				$doc->setStyle("v"); // Change to vertical
				if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
					$doc->Table = &$processf;
					$processf->exportDocument($doc, $rsmaster);
					$doc->exportEmptyRow();
					$doc->Table = &$this;
				}
				$doc->setStyle($exportStyle); // Restore
				$rsmaster->close();
			}
		}
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		$doc->Text .= $header;
		$this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		$doc->Text .= $footer;

		// Close recordset
		$rs->close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$doc->exportHeaderAndFooter();

		// Clean output buffer (without destroying output buffer)
		$buffer = ob_get_contents(); // Save the output buffer
		if (!Config("DEBUG") && $buffer)
			ob_clean();

		// Write debug message if enabled
		if (Config("DEBUG") && !$this->isExport("pdf"))
			echo GetDebugMessage();

		// Output data
		if ($this->isExport("email")) {

			// Export-to-email disabled
		} else {
			$doc->export();
			if ($return) {
				RemoveHeader("Content-Type"); // Remove header
				RemoveHeader("Content-Disposition");
				$content = ob_get_contents();
				if ($content)
					ob_clean();
				if ($buffer)
					echo $buffer; // Resume the output buffer
				return $content;
			}
		}
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{
		$validMaster = FALSE;

		// Get the keys for master table
		if (Get(Config("TABLE_SHOW_MASTER")) !== NULL) {
			$masterTblVar = Get(Config("TABLE_SHOW_MASTER"));
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "processf") {
				$validMaster = TRUE;
				if (Get("fk_idProcess") !== NULL) {
					$GLOBALS["processf"]->idProcess->setQueryStringValue(Get("fk_idProcess"));
					$this->idProcess->setQueryStringValue($GLOBALS["processf"]->idProcess->QueryStringValue);
					$this->idProcess->setSessionValue($this->idProcess->QueryStringValue);
					if (!is_numeric($GLOBALS["processf"]->idProcess->QueryStringValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		} elseif (Post(Config("TABLE_SHOW_MASTER")) !== NULL) {
			$masterTblVar = Post(Config("TABLE_SHOW_MASTER"));
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "processf") {
				$validMaster = TRUE;
				if (Post("fk_idProcess") !== NULL) {
					$GLOBALS["processf"]->idProcess->setFormValue(Post("fk_idProcess"));
					$this->idProcess->setFormValue($GLOBALS["processf"]->idProcess->FormValue);
					$this->idProcess->setSessionValue($this->idProcess->FormValue);
					if (!is_numeric($GLOBALS["processf"]->idProcess->FormValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		}
		if ($validMaster) {

			// Update URL
			$this->AddUrl = $this->addMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($masterTblVar);

			// Reset start record counter (new master key)
			if (!$this->isAddOrEdit()) {
				$this->StartRecord = 1;
				$this->setStartRecordNumber($this->StartRecord);
			}

			// Clear previous master key from Session
			if ($masterTblVar != "processf") {
				if ($this->idProcess->CurrentValue == "")
					$this->idProcess->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// Get default connection and filter
			$conn = $this->getConnection();
			$lookupFilter = "";

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL and connection
			switch ($fld->FieldVar) {
				case "x_idCause":
					break;
				case "x_idResponsible":
					break;
				case "x_revisedKc":
					break;
				case "x_idResponsibleDet":
					break;
				case "x_kcdet":
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
				$totalCnt = $this->getRecordCount($sql, $conn);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_idCause":
							break;
						case "x_idResponsible":
							break;
						case "x_idResponsibleDet":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Set up starting record parameters
	public function setupStartRecord()
	{
		if ($this->DisplayRecords == 0)
			return;
		if ($this->isPageRequest()) { // Validate request
			$startRec = Get(Config("TABLE_START_REC"));
			$pageNo = Get(Config("TABLE_PAGE_NO"));
			if ($pageNo !== NULL) { // Check for "pageno" parameter first
				if (is_numeric($pageNo)) {
					$this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
					if ($this->StartRecord <= 0) {
						$this->StartRecord = 1;
					} elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1)/$this->DisplayRecords) * $this->DisplayRecords + 1) {
						$this->StartRecord = (int)(($this->TotalRecords - 1)/$this->DisplayRecords) * $this->DisplayRecords + 1;
					}
					$this->setStartRecordNumber($this->StartRecord);
				}
			} elseif ($startRec !== NULL) { // Check for "start" parameter
				$this->StartRecord = $startRec;
				$this->setStartRecordNumber($this->StartRecord);
			}
		}
		$this->StartRecord = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
			$this->StartRecord = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRecord);
		} elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
			$this->StartRecord = (int)(($this->TotalRecords - 1)/$this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRecord);
		} elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
			$this->StartRecord = (int)(($this->StartRecord - 1)/$this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRecord);
		}
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}

	// Page Importing event
	function Page_Importing($reader, &$options) {

		//var_dump($reader); // Import data reader
		//var_dump($options); // Show all options for importing
		//return FALSE; // Return FALSE to skip import

		return TRUE;
	}

	// Row Import event
	function Row_Import(&$row, $cnt) {

		//echo $cnt; // Import record count
		//var_dump($row); // Import row
		//return FALSE; // Return FALSE to skip import

		return TRUE;
	}

	// Page Imported event
	function Page_Imported($reader, $results) {

		//var_dump($reader); // Import data reader
		//var_dump($results); // Import results

	}
} // End class
?>