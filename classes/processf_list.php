<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class processf_list extends processf
{

	// Page ID
	public $PageID = "list";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'processf';

	// Page object name
	public $PageObjName = "processf_list";

	// Grid form hidden field names
	public $FormName = "fprocessflist";
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
	public $ExportExcelCustom = FALSE;
	public $ExportWordCustom = FALSE;
	public $ExportPdfCustom = FALSE;
	public $ExportEmailCustom = FALSE;

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

		// Table object (processf)
		if (!isset($GLOBALS["processf"]) || get_class($GLOBALS["processf"]) == PROJECT_NAMESPACE . "processf") {
			$GLOBALS["processf"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["processf"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->pageUrl() . "export=print";
		$this->ExportExcelUrl = $this->pageUrl() . "export=excel";
		$this->ExportWordUrl = $this->pageUrl() . "export=word";
		$this->ExportPdfUrl = $this->pageUrl() . "export=pdf";
		$this->ExportHtmlUrl = $this->pageUrl() . "export=html";
		$this->ExportXmlUrl = $this->pageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->pageUrl() . "export=csv";
		$this->AddUrl = "processfadd.php?" . Config("TABLE_SHOW_DETAIL") . "=";
		$this->InlineAddUrl = $this->pageUrl() . "action=add";
		$this->GridAddUrl = $this->pageUrl() . "action=gridadd";
		$this->GridEditUrl = $this->pageUrl() . "action=gridedit";
		$this->MultiDeleteUrl = "processfdelete.php";
		$this->MultiUpdateUrl = "processfupdate.php";

		// Table object (fmea)
		if (!isset($GLOBALS['fmea']))
			$GLOBALS['fmea'] = new fmea();

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'list');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'processf');

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
		$this->FilterOptions->TagClassName = "ew-filter-option fprocessflistsrch";

		// List actions
		$this->ListActions = new ListActions();
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
		global $processf;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($processf);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
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
			$key .= @$ar['idProcess'];
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
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->idProcess->Visible = FALSE;
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
	public $actions_Count;
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
		$this->idProcess->Visible = FALSE;
		$this->fmea->setVisibility();
		$this->step->setVisibility();
		$this->flowchartDesc->setVisibility();
		$this->partnumber->setVisibility();
		$this->operation->setVisibility();
		$this->derivedFromNC->setVisibility();
		$this->numberOfNC->setVisibility();
		$this->flowchart->setVisibility();
		$this->subprocess->setVisibility();
		$this->requirement->setVisibility();
		$this->potencialFailureMode->setVisibility();
		$this->potencialFailurEffect->setVisibility();
		$this->kc->setVisibility();
		$this->severity->setVisibility();
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
		$this->setupLookupOptions($this->fmea);

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

				// Switch to grid edit mode
				if ($this->isGridEdit())
					$this->gridEditMode();

				// Switch to inline add mode
				if ($this->isAdd() || $this->isCopy())
					$this->inlineAddMode();
			} else {
				if (Post("action") !== NULL) {
					$this->CurrentAction = Post("action"); // Get action

					// Process import
					if ($this->isImport()) {
						$this->import(Post(Config("API_FILE_TOKEN_NAME")));
						$this->terminate();
					}

					// Grid Update
					if (($this->isGridUpdate() || $this->isGridOverwrite()) && @$_SESSION[SESSION_INLINE_MODE] == "gridedit") {
						if ($this->validateGridForm()) {
							$gridUpdate = $this->gridUpdate();
						} else {
							$gridUpdate = FALSE;
							$this->setFailureMessage($FormError);
						}
						if ($gridUpdate) {
						} else {
							$this->EventCancelled = TRUE;
							$this->gridEditMode(); // Stay in Grid edit mode
						}
					}

					// Insert Inline
					if ($this->isInsert() && @$_SESSION[SESSION_INLINE_MODE] == "add")
						$this->inlineInsert();
				} elseif (@$_SESSION[SESSION_INLINE_MODE] == "gridedit") { // Previously in grid edit mode
					if (Get(Config("TABLE_START_REC")) !== NULL || Get(Config("TABLE_PAGE_NO")) !== NULL) // Stay in grid edit mode if paging
						$this->gridEditMode();
					else // Reset grid edit
						$this->clearInlineMode();
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
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "fmea") {
			global $fmea;
			$rsmaster = $fmea->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("fmealist.php"); // Return to master page
			} else {
				$fmea->loadListRowValues($rsmaster);
				$fmea->RowType = ROWTYPE_MASTER; // Master row
				$fmea->renderListRow();
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

	// Switch to Grid Edit mode
	protected function gridEditMode()
	{
		$this->CurrentAction = "gridedit";
		$_SESSION[SESSION_INLINE_MODE] = "gridedit";
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

	// Perform update to grid
	public function gridUpdate()
	{
		global $Language, $CurrentForm, $FormError;
		$gridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->buildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		if ($rs = $conn->execute($sql)) {
			$rsold = $rs->getRows();
			$rs->close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->beginTrans();
		$key = "";

		// Update row index and get row key
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$CurrentForm->Index = $rowindex;
			$rowkey = strval($CurrentForm->getValue($this->FormKeyName));
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction != "insertdelete") { // Skip insert then deleted rows
				$this->loadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$gridUpdate = $this->setupKeyValues($rowkey); // Set up key values
				} else {
					$gridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->emptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($gridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->getRecordFilter();
						$gridUpdate = $this->deleteRows(); // Delete this row
					} else if (!$this->validateForm()) {
						$gridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($FormError);
					} else {
						if ($rowaction == "insert") {
							$gridUpdate = $this->addRow(); // Insert this row
						} else {
							if ($rowkey != "") {

								// Overwrite record, just reload hash value
								if ($this->isGridOverwrite())
									$this->loadRowHash();
								$this->SendEmail = FALSE; // Do not send email on update success
								$gridUpdate = $this->editRow(); // Update this row
							}
						} // End update
					}
				}
				if ($gridUpdate) {
					if ($key != "")
						$key .= ", ";
					$key .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($gridUpdate) {
			$conn->commitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
			$this->clearInlineMode(); // Clear inline edit mode
		} else {
			$conn->rollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
		}
		return $gridUpdate;
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
		if (count($arKeyFlds) >= 1) {
			$this->idProcess->setOldValue($arKeyFlds[0]);
			if (!is_numeric($this->idProcess->OldValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	public function emptyRow()
	{
		global $CurrentForm;
		if ($CurrentForm->hasValue("x_fmea") && $CurrentForm->hasValue("o_fmea") && $this->fmea->CurrentValue != $this->fmea->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_step") && $CurrentForm->hasValue("o_step") && $this->step->CurrentValue != $this->step->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_flowchartDesc") && $CurrentForm->hasValue("o_flowchartDesc") && $this->flowchartDesc->CurrentValue != $this->flowchartDesc->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_partnumber") && $CurrentForm->hasValue("o_partnumber") && $this->partnumber->CurrentValue != $this->partnumber->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_operation") && $CurrentForm->hasValue("o_operation") && $this->operation->CurrentValue != $this->operation->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_derivedFromNC") && $CurrentForm->hasValue("o_derivedFromNC") && ConvertToBool($this->derivedFromNC->CurrentValue) != ConvertToBool($this->derivedFromNC->OldValue))
			return FALSE;
		if ($CurrentForm->hasValue("x_numberOfNC") && $CurrentForm->hasValue("o_numberOfNC") && $this->numberOfNC->CurrentValue != $this->numberOfNC->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_flowchart") && $CurrentForm->hasValue("o_flowchart") && $this->flowchart->CurrentValue != $this->flowchart->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_subprocess") && $CurrentForm->hasValue("o_subprocess") && $this->subprocess->CurrentValue != $this->subprocess->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_requirement") && $CurrentForm->hasValue("o_requirement") && $this->requirement->CurrentValue != $this->requirement->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_potencialFailureMode") && $CurrentForm->hasValue("o_potencialFailureMode") && $this->potencialFailureMode->CurrentValue != $this->potencialFailureMode->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_potencialFailurEffect") && $CurrentForm->hasValue("o_potencialFailurEffect") && $this->potencialFailurEffect->CurrentValue != $this->potencialFailurEffect->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_kc") && $CurrentForm->hasValue("o_kc") && ConvertToBool($this->kc->CurrentValue) != ConvertToBool($this->kc->OldValue))
			return FALSE;
		if ($CurrentForm->hasValue("x_severity") && $CurrentForm->hasValue("o_severity") && $this->severity->CurrentValue != $this->severity->OldValue)
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
		$filterList = Concat($filterList, $this->fmea->AdvancedSearch->toJson(), ","); // Field fmea
		$filterList = Concat($filterList, $this->step->AdvancedSearch->toJson(), ","); // Field step
		$filterList = Concat($filterList, $this->flowchartDesc->AdvancedSearch->toJson(), ","); // Field flowchartDesc
		$filterList = Concat($filterList, $this->partnumber->AdvancedSearch->toJson(), ","); // Field partnumber
		$filterList = Concat($filterList, $this->operation->AdvancedSearch->toJson(), ","); // Field operation
		$filterList = Concat($filterList, $this->derivedFromNC->AdvancedSearch->toJson(), ","); // Field derivedFromNC
		$filterList = Concat($filterList, $this->numberOfNC->AdvancedSearch->toJson(), ","); // Field numberOfNC
		$filterList = Concat($filterList, $this->flowchart->AdvancedSearch->toJson(), ","); // Field flowchart
		$filterList = Concat($filterList, $this->subprocess->AdvancedSearch->toJson(), ","); // Field subprocess
		$filterList = Concat($filterList, $this->requirement->AdvancedSearch->toJson(), ","); // Field requirement
		$filterList = Concat($filterList, $this->potencialFailureMode->AdvancedSearch->toJson(), ","); // Field potencialFailureMode
		$filterList = Concat($filterList, $this->potencialFailurEffect->AdvancedSearch->toJson(), ","); // Field potencialFailurEffect
		$filterList = Concat($filterList, $this->kc->AdvancedSearch->toJson(), ","); // Field kc
		$filterList = Concat($filterList, $this->severity->AdvancedSearch->toJson(), ","); // Field severity
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
			$UserProfile->setSearchFilters(CurrentUserName(), "fprocessflistsrch", $filters);
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

		// Field fmea
		$this->fmea->AdvancedSearch->SearchValue = @$filter["x_fmea"];
		$this->fmea->AdvancedSearch->SearchOperator = @$filter["z_fmea"];
		$this->fmea->AdvancedSearch->SearchCondition = @$filter["v_fmea"];
		$this->fmea->AdvancedSearch->SearchValue2 = @$filter["y_fmea"];
		$this->fmea->AdvancedSearch->SearchOperator2 = @$filter["w_fmea"];
		$this->fmea->AdvancedSearch->save();

		// Field step
		$this->step->AdvancedSearch->SearchValue = @$filter["x_step"];
		$this->step->AdvancedSearch->SearchOperator = @$filter["z_step"];
		$this->step->AdvancedSearch->SearchCondition = @$filter["v_step"];
		$this->step->AdvancedSearch->SearchValue2 = @$filter["y_step"];
		$this->step->AdvancedSearch->SearchOperator2 = @$filter["w_step"];
		$this->step->AdvancedSearch->save();

		// Field flowchartDesc
		$this->flowchartDesc->AdvancedSearch->SearchValue = @$filter["x_flowchartDesc"];
		$this->flowchartDesc->AdvancedSearch->SearchOperator = @$filter["z_flowchartDesc"];
		$this->flowchartDesc->AdvancedSearch->SearchCondition = @$filter["v_flowchartDesc"];
		$this->flowchartDesc->AdvancedSearch->SearchValue2 = @$filter["y_flowchartDesc"];
		$this->flowchartDesc->AdvancedSearch->SearchOperator2 = @$filter["w_flowchartDesc"];
		$this->flowchartDesc->AdvancedSearch->save();

		// Field partnumber
		$this->partnumber->AdvancedSearch->SearchValue = @$filter["x_partnumber"];
		$this->partnumber->AdvancedSearch->SearchOperator = @$filter["z_partnumber"];
		$this->partnumber->AdvancedSearch->SearchCondition = @$filter["v_partnumber"];
		$this->partnumber->AdvancedSearch->SearchValue2 = @$filter["y_partnumber"];
		$this->partnumber->AdvancedSearch->SearchOperator2 = @$filter["w_partnumber"];
		$this->partnumber->AdvancedSearch->save();

		// Field operation
		$this->operation->AdvancedSearch->SearchValue = @$filter["x_operation"];
		$this->operation->AdvancedSearch->SearchOperator = @$filter["z_operation"];
		$this->operation->AdvancedSearch->SearchCondition = @$filter["v_operation"];
		$this->operation->AdvancedSearch->SearchValue2 = @$filter["y_operation"];
		$this->operation->AdvancedSearch->SearchOperator2 = @$filter["w_operation"];
		$this->operation->AdvancedSearch->save();

		// Field derivedFromNC
		$this->derivedFromNC->AdvancedSearch->SearchValue = @$filter["x_derivedFromNC"];
		$this->derivedFromNC->AdvancedSearch->SearchOperator = @$filter["z_derivedFromNC"];
		$this->derivedFromNC->AdvancedSearch->SearchCondition = @$filter["v_derivedFromNC"];
		$this->derivedFromNC->AdvancedSearch->SearchValue2 = @$filter["y_derivedFromNC"];
		$this->derivedFromNC->AdvancedSearch->SearchOperator2 = @$filter["w_derivedFromNC"];
		$this->derivedFromNC->AdvancedSearch->save();

		// Field numberOfNC
		$this->numberOfNC->AdvancedSearch->SearchValue = @$filter["x_numberOfNC"];
		$this->numberOfNC->AdvancedSearch->SearchOperator = @$filter["z_numberOfNC"];
		$this->numberOfNC->AdvancedSearch->SearchCondition = @$filter["v_numberOfNC"];
		$this->numberOfNC->AdvancedSearch->SearchValue2 = @$filter["y_numberOfNC"];
		$this->numberOfNC->AdvancedSearch->SearchOperator2 = @$filter["w_numberOfNC"];
		$this->numberOfNC->AdvancedSearch->save();

		// Field flowchart
		$this->flowchart->AdvancedSearch->SearchValue = @$filter["x_flowchart"];
		$this->flowchart->AdvancedSearch->SearchOperator = @$filter["z_flowchart"];
		$this->flowchart->AdvancedSearch->SearchCondition = @$filter["v_flowchart"];
		$this->flowchart->AdvancedSearch->SearchValue2 = @$filter["y_flowchart"];
		$this->flowchart->AdvancedSearch->SearchOperator2 = @$filter["w_flowchart"];
		$this->flowchart->AdvancedSearch->save();

		// Field subprocess
		$this->subprocess->AdvancedSearch->SearchValue = @$filter["x_subprocess"];
		$this->subprocess->AdvancedSearch->SearchOperator = @$filter["z_subprocess"];
		$this->subprocess->AdvancedSearch->SearchCondition = @$filter["v_subprocess"];
		$this->subprocess->AdvancedSearch->SearchValue2 = @$filter["y_subprocess"];
		$this->subprocess->AdvancedSearch->SearchOperator2 = @$filter["w_subprocess"];
		$this->subprocess->AdvancedSearch->save();

		// Field requirement
		$this->requirement->AdvancedSearch->SearchValue = @$filter["x_requirement"];
		$this->requirement->AdvancedSearch->SearchOperator = @$filter["z_requirement"];
		$this->requirement->AdvancedSearch->SearchCondition = @$filter["v_requirement"];
		$this->requirement->AdvancedSearch->SearchValue2 = @$filter["y_requirement"];
		$this->requirement->AdvancedSearch->SearchOperator2 = @$filter["w_requirement"];
		$this->requirement->AdvancedSearch->save();

		// Field potencialFailureMode
		$this->potencialFailureMode->AdvancedSearch->SearchValue = @$filter["x_potencialFailureMode"];
		$this->potencialFailureMode->AdvancedSearch->SearchOperator = @$filter["z_potencialFailureMode"];
		$this->potencialFailureMode->AdvancedSearch->SearchCondition = @$filter["v_potencialFailureMode"];
		$this->potencialFailureMode->AdvancedSearch->SearchValue2 = @$filter["y_potencialFailureMode"];
		$this->potencialFailureMode->AdvancedSearch->SearchOperator2 = @$filter["w_potencialFailureMode"];
		$this->potencialFailureMode->AdvancedSearch->save();

		// Field potencialFailurEffect
		$this->potencialFailurEffect->AdvancedSearch->SearchValue = @$filter["x_potencialFailurEffect"];
		$this->potencialFailurEffect->AdvancedSearch->SearchOperator = @$filter["z_potencialFailurEffect"];
		$this->potencialFailurEffect->AdvancedSearch->SearchCondition = @$filter["v_potencialFailurEffect"];
		$this->potencialFailurEffect->AdvancedSearch->SearchValue2 = @$filter["y_potencialFailurEffect"];
		$this->potencialFailurEffect->AdvancedSearch->SearchOperator2 = @$filter["w_potencialFailurEffect"];
		$this->potencialFailurEffect->AdvancedSearch->save();

		// Field kc
		$this->kc->AdvancedSearch->SearchValue = @$filter["x_kc"];
		$this->kc->AdvancedSearch->SearchOperator = @$filter["z_kc"];
		$this->kc->AdvancedSearch->SearchCondition = @$filter["v_kc"];
		$this->kc->AdvancedSearch->SearchValue2 = @$filter["y_kc"];
		$this->kc->AdvancedSearch->SearchOperator2 = @$filter["w_kc"];
		$this->kc->AdvancedSearch->save();

		// Field severity
		$this->severity->AdvancedSearch->SearchValue = @$filter["x_severity"];
		$this->severity->AdvancedSearch->SearchOperator = @$filter["z_severity"];
		$this->severity->AdvancedSearch->SearchCondition = @$filter["v_severity"];
		$this->severity->AdvancedSearch->SearchValue2 = @$filter["y_severity"];
		$this->severity->AdvancedSearch->SearchOperator2 = @$filter["w_severity"];
		$this->severity->AdvancedSearch->save();
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
		$this->buildSearchSql($where, $this->fmea, $default, FALSE); // fmea
		$this->buildSearchSql($where, $this->step, $default, FALSE); // step
		$this->buildSearchSql($where, $this->flowchartDesc, $default, FALSE); // flowchartDesc
		$this->buildSearchSql($where, $this->partnumber, $default, FALSE); // partnumber
		$this->buildSearchSql($where, $this->operation, $default, FALSE); // operation
		$this->buildSearchSql($where, $this->derivedFromNC, $default, FALSE); // derivedFromNC
		$this->buildSearchSql($where, $this->numberOfNC, $default, FALSE); // numberOfNC
		$this->buildSearchSql($where, $this->flowchart, $default, FALSE); // flowchart
		$this->buildSearchSql($where, $this->subprocess, $default, FALSE); // subprocess
		$this->buildSearchSql($where, $this->requirement, $default, FALSE); // requirement
		$this->buildSearchSql($where, $this->potencialFailureMode, $default, FALSE); // potencialFailureMode
		$this->buildSearchSql($where, $this->potencialFailurEffect, $default, FALSE); // potencialFailurEffect
		$this->buildSearchSql($where, $this->kc, $default, FALSE); // kc
		$this->buildSearchSql($where, $this->severity, $default, FALSE); // severity

		// Set up search parm
		if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
			$this->Command = "search";
		}
		if (!$default && $this->Command == "search") {
			$this->fmea->AdvancedSearch->save(); // fmea
			$this->step->AdvancedSearch->save(); // step
			$this->flowchartDesc->AdvancedSearch->save(); // flowchartDesc
			$this->partnumber->AdvancedSearch->save(); // partnumber
			$this->operation->AdvancedSearch->save(); // operation
			$this->derivedFromNC->AdvancedSearch->save(); // derivedFromNC
			$this->numberOfNC->AdvancedSearch->save(); // numberOfNC
			$this->flowchart->AdvancedSearch->save(); // flowchart
			$this->subprocess->AdvancedSearch->save(); // subprocess
			$this->requirement->AdvancedSearch->save(); // requirement
			$this->potencialFailureMode->AdvancedSearch->save(); // potencialFailureMode
			$this->potencialFailurEffect->AdvancedSearch->save(); // potencialFailurEffect
			$this->kc->AdvancedSearch->save(); // kc
			$this->severity->AdvancedSearch->save(); // severity
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
		$this->buildBasicSearchSql($where, $this->fmea, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->flowchartDesc, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->partnumber, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->operation, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->derivedFromNC, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->numberOfNC, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->flowchart, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->subprocess, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->requirement, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->potencialFailureMode, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->potencialFailurEffect, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->kc, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->severity, $arKeywords, $type);
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
		if ($this->fmea->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->step->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->flowchartDesc->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->partnumber->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->operation->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->derivedFromNC->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->numberOfNC->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->flowchart->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->subprocess->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->requirement->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->potencialFailureMode->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->potencialFailurEffect->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->kc->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->severity->AdvancedSearch->issetSession())
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
		$this->fmea->AdvancedSearch->unsetSession();
		$this->step->AdvancedSearch->unsetSession();
		$this->flowchartDesc->AdvancedSearch->unsetSession();
		$this->partnumber->AdvancedSearch->unsetSession();
		$this->operation->AdvancedSearch->unsetSession();
		$this->derivedFromNC->AdvancedSearch->unsetSession();
		$this->numberOfNC->AdvancedSearch->unsetSession();
		$this->flowchart->AdvancedSearch->unsetSession();
		$this->subprocess->AdvancedSearch->unsetSession();
		$this->requirement->AdvancedSearch->unsetSession();
		$this->potencialFailureMode->AdvancedSearch->unsetSession();
		$this->potencialFailurEffect->AdvancedSearch->unsetSession();
		$this->kc->AdvancedSearch->unsetSession();
		$this->severity->AdvancedSearch->unsetSession();
	}

	// Restore all search parameters
	protected function restoreSearchParms()
	{
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->load();

		// Restore advanced search values
		$this->fmea->AdvancedSearch->load();
		$this->step->AdvancedSearch->load();
		$this->flowchartDesc->AdvancedSearch->load();
		$this->partnumber->AdvancedSearch->load();
		$this->operation->AdvancedSearch->load();
		$this->derivedFromNC->AdvancedSearch->load();
		$this->numberOfNC->AdvancedSearch->load();
		$this->flowchart->AdvancedSearch->load();
		$this->subprocess->AdvancedSearch->load();
		$this->requirement->AdvancedSearch->load();
		$this->potencialFailureMode->AdvancedSearch->load();
		$this->potencialFailurEffect->AdvancedSearch->load();
		$this->kc->AdvancedSearch->load();
		$this->severity->AdvancedSearch->load();
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
			$this->updateSort($this->fmea, $ctrl); // fmea
			$this->updateSort($this->step, $ctrl); // step
			$this->updateSort($this->flowchartDesc, $ctrl); // flowchartDesc
			$this->updateSort($this->partnumber, $ctrl); // partnumber
			$this->updateSort($this->operation, $ctrl); // operation
			$this->updateSort($this->derivedFromNC, $ctrl); // derivedFromNC
			$this->updateSort($this->numberOfNC, $ctrl); // numberOfNC
			$this->updateSort($this->flowchart, $ctrl); // flowchart
			$this->updateSort($this->subprocess, $ctrl); // subprocess
			$this->updateSort($this->requirement, $ctrl); // requirement
			$this->updateSort($this->potencialFailureMode, $ctrl); // potencialFailureMode
			$this->updateSort($this->potencialFailurEffect, $ctrl); // potencialFailurEffect
			$this->updateSort($this->kc, $ctrl); // kc
			$this->updateSort($this->severity, $ctrl); // severity
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
				$this->fmea->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
				$this->setSessionOrderByList($orderBy);
				$this->fmea->setSort("");
				$this->step->setSort("");
				$this->flowchartDesc->setSort("");
				$this->partnumber->setSort("");
				$this->operation->setSort("");
				$this->derivedFromNC->setSort("");
				$this->numberOfNC->setSort("");
				$this->flowchart->setSort("");
				$this->subprocess->setSort("");
				$this->requirement->setSort("");
				$this->potencialFailureMode->setSort("");
				$this->potencialFailurEffect->setSort("");
				$this->kc->setSort("");
				$this->severity->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canAdd() && $this->isAdd();
		$item->OnLeft = TRUE;

		// "detail_actions"
		$item = &$this->ListOptions->add("detail_actions");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->allowList(CurrentProjectID() . 'actions') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["actions_grid"]))
			$GLOBALS["actions_grid"] = new actions_grid();

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new SubPages();
		$pages->add("actions");
		$this->DetailPages = $pages;

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

		// "edit"
		$opt = $this->ListOptions["edit"];
		$editcaption = HtmlTitle($Language->phrase("EditLink"));
		if ($Security->canEdit()) {
			$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode($this->EditUrl) . "\">" . $Language->phrase("EditLink") . "</a>";
		} else {
			$opt->Body = "";
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
		$detailViewTblVar = "";
		$detailCopyTblVar = "";
		$detailEditTblVar = "";

		// "detail_actions"
		$opt = $this->ListOptions["detail_actions"];
		if ($Security->allowList(CurrentProjectID() . 'actions')) {
			$body = $Language->phrase("DetailLink") . $Language->TablePhrase("actions", "TblCaption");
			$body .= "&nbsp;" . str_replace("%c", $this->actions_Count, $Language->phrase("DetailCount"));
			$body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("actionslist.php?" . Config("TABLE_SHOW_MASTER") . "=processf&fk_idProcess=" . urlencode(strval($this->idProcess->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["actions_grid"]->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'processf')) {
				$caption = $Language->phrase("MasterDetailEditLink");
				$url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=actions");
				$links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
				if ($detailEditTblVar != "")
					$detailEditTblVar .= ",";
				$detailEditTblVar .= "actions";
			}
			if ($links != "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
			$opt->Body = $body;
			if ($this->ShowMultipleDetails)
				$opt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
			$links = "";
			if ($detailViewTblVar != "") {
				$links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($detailEditTblVar != "") {
				$links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($detailCopyTblVar != "") {
				$links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links != "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlTitle($Language->phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
				$body .= "<ul class=\"dropdown-menu ew-menu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$opt = $this->ListOptions["details"];
			$opt->Body = $body;
		}

		// "checkbox"
		$opt = $this->ListOptions["checkbox"];
		$opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->idProcess->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
		if ($this->isGridEdit() && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->idProcess->CurrentValue . "\">";
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_hash\" id=\"k" . $this->RowIndex . "_hash\" value=\"" . $this->HashValue . "\">";
		}
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
		$option = $options["detail"];
		$detailTableLink = "";
		$item = &$option->add("detailadd_actions");
		$url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=actions");
		$caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $GLOBALS["actions"]->tableCaption();
		$item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["actions"]->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'processf') && $Security->canAdd());
		if ($item->Visible) {
			if ($detailTableLink != "")
				$detailTableLink .= ",";
			$detailTableLink .= "actions";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->add("detailsadd");
			$url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
			$caption = $Language->phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = $detailTableLink != "" && $Security->canAdd();

			// Hide single master/detail items
			$ar = explode(",", $detailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = $option["detailadd_" . $ar[$i]])
					$item->Visible = FALSE;
			}
		}

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->add("gridedit");
		$item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode($this->GridEditUrl) . "\">" . $Language->phrase("GridEditLink") . "</a>";
		$item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
		$option = $options["action"];

		// Add multi delete
		$item = &$option->add("multidelete");
		$item->Body = "<a class=\"ew-action ew-multi-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteSelectedLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteSelectedLink")) . "\" href=\"#\" onclick=\"return ew.submitAction(event, {f:document.fprocessflist, url:'" . $this->MultiDeleteUrl . "', data:{action:'show'}});return false;\">" . $Language->phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ew-save-filter\" data-form=\"fprocessflistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->add("deletefilter");
		$item->Body = "<a class=\"ew-delete-filter\" data-form=\"fprocessflistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ew-action ew-list-action\" title=\"" . HtmlEncode($caption) . "\" data-caption=\"" . HtmlEncode($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({f:document.fprocessflist}," . $listaction->toJson(TRUE) . "));\">" . $icon . "</a>";
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

			// Grid-Edit
			if ($this->isGridEdit()) {
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
				if ($this->UpdateConflict == "U") { // Record already updated by other user
					$item = &$option->add("reload");
					$item->Body = "<a class=\"ew-action ew-grid-reload\" title=\"" . HtmlTitle($Language->phrase("ReloadLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ReloadLink")) . "\" href=\"" . HtmlEncode($this->GridEditUrl) . "\">" . $Language->phrase("ReloadLink") . "</a>";
					$item = &$option->add("overwrite");
					$item->Body = "<a class=\"ew-action ew-grid-overwrite\" title=\"" . HtmlTitle($Language->phrase("OverwriteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("OverwriteLink")) . "\" href=\"#\" onclick=\"return ew.forms(this).submit('" . $this->pageName() . "');\">" . $Language->phrase("OverwriteLink") . "</a>";
					$item = &$option->add("cancel");
					$cancelurl = $this->addMasterUrl($this->pageUrl() . "action=cancel");
					$item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("ConflictCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ConflictCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("ConflictCancelLink") . "</a>";
				} else {
					$item = &$option->add("gridsave");
					$item->Body = "<a class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" href=\"#\" onclick=\"return ew.forms(this).submit('" . $this->pageName() . "');\">" . $Language->phrase("GridSaveLink") . "</a>";
					$item = &$option->add("gridcancel");
					$cancelurl = $this->addMasterUrl($this->pageUrl() . "action=cancel");
					$item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
				}
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
		$links = "";
		$btngrps = "";
		$sqlwrk = "`idProcess`=" . AdjustSql($this->idProcess->CurrentValue, $this->Dbid) . "";

		// Column "detail_actions"
		if ($this->DetailPages["actions"] && $this->DetailPages["actions"]->Visible) {
			$link = "";
			$option = $this->ListOptions["detail_actions"];
			$url = "actionspreview.php?t=processf&f=" . Encrypt($sqlwrk);
			$btngrp = "<div data-table=\"actions\" data-url=\"" . $url . "\">";
			if ($Security->allowList(CurrentProjectID() . 'processf')) {
				$label = $Language->TablePhrase("actions", "TblCaption");
				$label .= "&nbsp;" . JsEncode(str_replace("%c", $this->actions_Count, $Language->phrase("DetailCount")));
				$link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"actions\" data-url=\"" . $url . "\">" . $label . "</a></li>";
				$links .= $link;
				$detaillnk = JsEncodeAttribute("actionslist.php?" . Config("TABLE_SHOW_MASTER") . "=processf&fk_idProcess=" . urlencode(strval($this->idProcess->CurrentValue)) . "");
				$btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("actions", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
			}
			if (!isset($GLOBALS["actions_grid"]))
				$GLOBALS["actions_grid"] = new actions_grid();
			if ($GLOBALS["actions_grid"]->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'processf')) {
				$caption = $Language->phrase("MasterDetailViewLink");
				$url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=actions");
				$btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
			}
			if ($GLOBALS["actions_grid"]->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'processf')) {
				$caption = $Language->phrase("MasterDetailEditLink");
				$url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=actions");
				$btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
			}
			$btngrp .= "</div>";
			if ($link != "") {
				$btngrps .= $btngrp;
				$option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
			}
		}

		// Hide detail items if necessary
		$this->ListOptions->hideDetailItemsForDropDown();

		// Column "preview"
		$option = $this->ListOptions["preview"];
		if (!$option) { // Add preview column
			$option = &$this->ListOptions->add("preview");
			$option->OnLeft = TRUE;
			if ($option->OnLeft) {
				$option->moveTo($this->ListOptions->itemPos("checkbox") + 1);
			} else {
				$option->moveTo($this->ListOptions->itemPos("checkbox"));
			}
			$option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit());
			$option->ShowInDropDown = FALSE;
			$option->ShowInButtonGroup = FALSE;
		}
		if ($option) {
			$option->Body = "<i class=\"ew-preview-row-btn ew-icon icon-expand\"></i>";
			$option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
			if ($option->Visible)
				$option->Visible = $links != "";
		}

		// Column "details" (Multiple details)
		$option = $this->ListOptions["details"];
		if ($option) {
			$option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
			if ($option->Visible)
				$option->Visible = $links != "";
		}
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idProcess->CurrentValue = NULL;
		$this->idProcess->OldValue = $this->idProcess->CurrentValue;
		$this->fmea->CurrentValue = NULL;
		$this->fmea->OldValue = $this->fmea->CurrentValue;
		$this->step->CurrentValue = NULL;
		$this->step->OldValue = $this->step->CurrentValue;
		$this->flowchartDesc->CurrentValue = NULL;
		$this->flowchartDesc->OldValue = $this->flowchartDesc->CurrentValue;
		$this->partnumber->CurrentValue = NULL;
		$this->partnumber->OldValue = $this->partnumber->CurrentValue;
		$this->operation->CurrentValue = NULL;
		$this->operation->OldValue = $this->operation->CurrentValue;
		$this->derivedFromNC->CurrentValue = NULL;
		$this->derivedFromNC->OldValue = $this->derivedFromNC->CurrentValue;
		$this->numberOfNC->CurrentValue = NULL;
		$this->numberOfNC->OldValue = $this->numberOfNC->CurrentValue;
		$this->flowchart->CurrentValue = NULL;
		$this->flowchart->OldValue = $this->flowchart->CurrentValue;
		$this->subprocess->CurrentValue = NULL;
		$this->subprocess->OldValue = $this->subprocess->CurrentValue;
		$this->requirement->CurrentValue = NULL;
		$this->requirement->OldValue = $this->requirement->CurrentValue;
		$this->potencialFailureMode->CurrentValue = NULL;
		$this->potencialFailureMode->OldValue = $this->potencialFailureMode->CurrentValue;
		$this->potencialFailurEffect->CurrentValue = NULL;
		$this->potencialFailurEffect->OldValue = $this->potencialFailurEffect->CurrentValue;
		$this->kc->CurrentValue = NULL;
		$this->kc->OldValue = $this->kc->CurrentValue;
		$this->severity->CurrentValue = NULL;
		$this->severity->OldValue = $this->severity->CurrentValue;
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

		// fmea
		if (!$this->isAddOrEdit() && $this->fmea->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->fmea->AdvancedSearch->SearchValue != "" || $this->fmea->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// step
		if (!$this->isAddOrEdit() && $this->step->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->step->AdvancedSearch->SearchValue != "" || $this->step->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// flowchartDesc
		if (!$this->isAddOrEdit() && $this->flowchartDesc->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->flowchartDesc->AdvancedSearch->SearchValue != "" || $this->flowchartDesc->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// partnumber
		if (!$this->isAddOrEdit() && $this->partnumber->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->partnumber->AdvancedSearch->SearchValue != "" || $this->partnumber->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// operation
		if (!$this->isAddOrEdit() && $this->operation->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->operation->AdvancedSearch->SearchValue != "" || $this->operation->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// derivedFromNC
		if (!$this->isAddOrEdit() && $this->derivedFromNC->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->derivedFromNC->AdvancedSearch->SearchValue != "" || $this->derivedFromNC->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		if (is_array($this->derivedFromNC->AdvancedSearch->SearchValue))
			$this->derivedFromNC->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->derivedFromNC->AdvancedSearch->SearchValue);
		if (is_array($this->derivedFromNC->AdvancedSearch->SearchValue2))
			$this->derivedFromNC->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->derivedFromNC->AdvancedSearch->SearchValue2);

		// numberOfNC
		if (!$this->isAddOrEdit() && $this->numberOfNC->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->numberOfNC->AdvancedSearch->SearchValue != "" || $this->numberOfNC->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// flowchart
		if (!$this->isAddOrEdit() && $this->flowchart->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->flowchart->AdvancedSearch->SearchValue != "" || $this->flowchart->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// subprocess
		if (!$this->isAddOrEdit() && $this->subprocess->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->subprocess->AdvancedSearch->SearchValue != "" || $this->subprocess->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// requirement
		if (!$this->isAddOrEdit() && $this->requirement->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->requirement->AdvancedSearch->SearchValue != "" || $this->requirement->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// potencialFailureMode
		if (!$this->isAddOrEdit() && $this->potencialFailureMode->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->potencialFailureMode->AdvancedSearch->SearchValue != "" || $this->potencialFailureMode->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// potencialFailurEffect
		if (!$this->isAddOrEdit() && $this->potencialFailurEffect->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->potencialFailurEffect->AdvancedSearch->SearchValue != "" || $this->potencialFailurEffect->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// kc
		if (!$this->isAddOrEdit() && $this->kc->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->kc->AdvancedSearch->SearchValue != "" || $this->kc->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		if (is_array($this->kc->AdvancedSearch->SearchValue))
			$this->kc->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kc->AdvancedSearch->SearchValue);
		if (is_array($this->kc->AdvancedSearch->SearchValue2))
			$this->kc->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kc->AdvancedSearch->SearchValue2);

		// severity
		if (!$this->isAddOrEdit() && $this->severity->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->severity->AdvancedSearch->SearchValue != "" || $this->severity->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}
		return $got;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'fmea' first before field var 'x_fmea'
		$val = $CurrentForm->hasValue("fmea") ? $CurrentForm->getValue("fmea") : $CurrentForm->getValue("x_fmea");
		if (!$this->fmea->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->fmea->Visible = FALSE; // Disable update for API request
			else
				$this->fmea->setFormValue($val);
		}

		// Check field name 'step' first before field var 'x_step'
		$val = $CurrentForm->hasValue("step") ? $CurrentForm->getValue("step") : $CurrentForm->getValue("x_step");
		if (!$this->step->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->step->Visible = FALSE; // Disable update for API request
			else
				$this->step->setFormValue($val);
		}

		// Check field name 'flowchartDesc' first before field var 'x_flowchartDesc'
		$val = $CurrentForm->hasValue("flowchartDesc") ? $CurrentForm->getValue("flowchartDesc") : $CurrentForm->getValue("x_flowchartDesc");
		if (!$this->flowchartDesc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->flowchartDesc->Visible = FALSE; // Disable update for API request
			else
				$this->flowchartDesc->setFormValue($val);
		}

		// Check field name 'partnumber' first before field var 'x_partnumber'
		$val = $CurrentForm->hasValue("partnumber") ? $CurrentForm->getValue("partnumber") : $CurrentForm->getValue("x_partnumber");
		if (!$this->partnumber->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->partnumber->Visible = FALSE; // Disable update for API request
			else
				$this->partnumber->setFormValue($val);
		}

		// Check field name 'operation' first before field var 'x_operation'
		$val = $CurrentForm->hasValue("operation") ? $CurrentForm->getValue("operation") : $CurrentForm->getValue("x_operation");
		if (!$this->operation->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->operation->Visible = FALSE; // Disable update for API request
			else
				$this->operation->setFormValue($val);
		}

		// Check field name 'derivedFromNC' first before field var 'x_derivedFromNC'
		$val = $CurrentForm->hasValue("derivedFromNC") ? $CurrentForm->getValue("derivedFromNC") : $CurrentForm->getValue("x_derivedFromNC");
		if (!$this->derivedFromNC->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->derivedFromNC->Visible = FALSE; // Disable update for API request
			else
				$this->derivedFromNC->setFormValue($val);
		}

		// Check field name 'numberOfNC' first before field var 'x_numberOfNC'
		$val = $CurrentForm->hasValue("numberOfNC") ? $CurrentForm->getValue("numberOfNC") : $CurrentForm->getValue("x_numberOfNC");
		if (!$this->numberOfNC->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->numberOfNC->Visible = FALSE; // Disable update for API request
			else
				$this->numberOfNC->setFormValue($val);
		}

		// Check field name 'flowchart' first before field var 'x_flowchart'
		$val = $CurrentForm->hasValue("flowchart") ? $CurrentForm->getValue("flowchart") : $CurrentForm->getValue("x_flowchart");
		if (!$this->flowchart->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->flowchart->Visible = FALSE; // Disable update for API request
			else
				$this->flowchart->setFormValue($val);
		}

		// Check field name 'subprocess' first before field var 'x_subprocess'
		$val = $CurrentForm->hasValue("subprocess") ? $CurrentForm->getValue("subprocess") : $CurrentForm->getValue("x_subprocess");
		if (!$this->subprocess->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->subprocess->Visible = FALSE; // Disable update for API request
			else
				$this->subprocess->setFormValue($val);
		}

		// Check field name 'requirement' first before field var 'x_requirement'
		$val = $CurrentForm->hasValue("requirement") ? $CurrentForm->getValue("requirement") : $CurrentForm->getValue("x_requirement");
		if (!$this->requirement->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->requirement->Visible = FALSE; // Disable update for API request
			else
				$this->requirement->setFormValue($val);
		}

		// Check field name 'potencialFailureMode' first before field var 'x_potencialFailureMode'
		$val = $CurrentForm->hasValue("potencialFailureMode") ? $CurrentForm->getValue("potencialFailureMode") : $CurrentForm->getValue("x_potencialFailureMode");
		if (!$this->potencialFailureMode->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->potencialFailureMode->Visible = FALSE; // Disable update for API request
			else
				$this->potencialFailureMode->setFormValue($val);
		}

		// Check field name 'potencialFailurEffect' first before field var 'x_potencialFailurEffect'
		$val = $CurrentForm->hasValue("potencialFailurEffect") ? $CurrentForm->getValue("potencialFailurEffect") : $CurrentForm->getValue("x_potencialFailurEffect");
		if (!$this->potencialFailurEffect->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->potencialFailurEffect->Visible = FALSE; // Disable update for API request
			else
				$this->potencialFailurEffect->setFormValue($val);
		}

		// Check field name 'kc' first before field var 'x_kc'
		$val = $CurrentForm->hasValue("kc") ? $CurrentForm->getValue("kc") : $CurrentForm->getValue("x_kc");
		if (!$this->kc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->kc->Visible = FALSE; // Disable update for API request
			else
				$this->kc->setFormValue($val);
		}

		// Check field name 'severity' first before field var 'x_severity'
		$val = $CurrentForm->hasValue("severity") ? $CurrentForm->getValue("severity") : $CurrentForm->getValue("x_severity");
		if (!$this->severity->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->severity->Visible = FALSE; // Disable update for API request
			else
				$this->severity->setFormValue($val);
		}

		// Check field name 'idProcess' first before field var 'x_idProcess'
		$val = $CurrentForm->hasValue("idProcess") ? $CurrentForm->getValue("idProcess") : $CurrentForm->getValue("x_idProcess");
		if (!$this->idProcess->IsDetailKey && !$this->isGridAdd() && !$this->isAdd())
			$this->idProcess->setFormValue($val);
		if (!$this->isOverwrite())
			$this->HashValue = $CurrentForm->getValue("k_hash");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		if (!$this->isGridAdd() && !$this->isAdd())
			$this->idProcess->CurrentValue = $this->idProcess->FormValue;
		$this->fmea->CurrentValue = $this->fmea->FormValue;
		$this->step->CurrentValue = $this->step->FormValue;
		$this->flowchartDesc->CurrentValue = $this->flowchartDesc->FormValue;
		$this->partnumber->CurrentValue = $this->partnumber->FormValue;
		$this->operation->CurrentValue = $this->operation->FormValue;
		$this->derivedFromNC->CurrentValue = $this->derivedFromNC->FormValue;
		$this->numberOfNC->CurrentValue = $this->numberOfNC->FormValue;
		$this->flowchart->CurrentValue = $this->flowchart->FormValue;
		$this->subprocess->CurrentValue = $this->subprocess->FormValue;
		$this->requirement->CurrentValue = $this->requirement->FormValue;
		$this->potencialFailureMode->CurrentValue = $this->potencialFailureMode->FormValue;
		$this->potencialFailurEffect->CurrentValue = $this->potencialFailurEffect->FormValue;
		$this->kc->CurrentValue = $this->kc->FormValue;
		$this->severity->CurrentValue = $this->severity->FormValue;
		if (!$this->isOverwrite())
			$this->HashValue = $CurrentForm->getValue("k_hash");
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
			if (!$this->EventCancelled)
				$this->HashValue = $this->getRowHash($rs); // Get hash value for record
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
		$this->fmea->setDbValue($row['fmea']);
		if (array_key_exists('EV__fmea', $rs->fields)) {
			$this->fmea->VirtualValue = $rs->fields('EV__fmea'); // Set up virtual field value
		} else {
			$this->fmea->VirtualValue = ""; // Clear value
		}
		$this->step->setDbValue($row['step']);
		$this->flowchartDesc->setDbValue($row['flowchartDesc']);
		$this->partnumber->setDbValue($row['partnumber']);
		$this->operation->setDbValue($row['operation']);
		$this->derivedFromNC->setDbValue($row['derivedFromNC']);
		$this->numberOfNC->setDbValue($row['numberOfNC']);
		$this->flowchart->setDbValue($row['flowchart']);
		$this->subprocess->setDbValue($row['subprocess']);
		$this->requirement->setDbValue($row['requirement']);
		$this->potencialFailureMode->setDbValue($row['potencialFailureMode']);
		$this->potencialFailurEffect->setDbValue($row['potencialFailurEffect']);
		$this->kc->setDbValue($row['kc']);
		$this->severity->setDbValue($row['severity']);
		if (!isset($GLOBALS["actions_grid"]))
			$GLOBALS["actions_grid"] = new actions_grid();
		$detailFilter = $GLOBALS["actions"]->sqlDetailFilter_processf();
		$detailFilter = str_replace("@idProcess@", AdjustSql($this->idProcess->DbValue, "DB"), $detailFilter);
		$GLOBALS["actions"]->setCurrentMasterTable("processf");
		$detailFilter = $GLOBALS["actions"]->applyUserIDFilters($detailFilter);
		$this->actions_Count = $GLOBALS["actions"]->loadRecordCount($detailFilter);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idProcess'] = $this->idProcess->CurrentValue;
		$row['fmea'] = $this->fmea->CurrentValue;
		$row['step'] = $this->step->CurrentValue;
		$row['flowchartDesc'] = $this->flowchartDesc->CurrentValue;
		$row['partnumber'] = $this->partnumber->CurrentValue;
		$row['operation'] = $this->operation->CurrentValue;
		$row['derivedFromNC'] = $this->derivedFromNC->CurrentValue;
		$row['numberOfNC'] = $this->numberOfNC->CurrentValue;
		$row['flowchart'] = $this->flowchart->CurrentValue;
		$row['subprocess'] = $this->subprocess->CurrentValue;
		$row['requirement'] = $this->requirement->CurrentValue;
		$row['potencialFailureMode'] = $this->potencialFailureMode->CurrentValue;
		$row['potencialFailurEffect'] = $this->potencialFailurEffect->CurrentValue;
		$row['kc'] = $this->kc->CurrentValue;
		$row['severity'] = $this->severity->CurrentValue;
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
		// fmea
		// step
		// flowchartDesc
		// partnumber
		// operation
		// derivedFromNC
		// numberOfNC
		// flowchart
		// subprocess
		// requirement
		// potencialFailureMode
		// potencialFailurEffect
		// kc
		// severity

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// fmea
			if ($this->fmea->VirtualValue != "") {
				$this->fmea->ViewValue = $this->fmea->VirtualValue;
			} else {
				$curVal = strval($this->fmea->CurrentValue);
				if ($curVal != "") {
					$this->fmea->ViewValue = $this->fmea->lookupCacheOption($curVal);
					if ($this->fmea->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`fmea`" . SearchString("=", $curVal, DATATYPE_STRING, "");
						$sqlWrk = $this->fmea->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->fmea->ViewValue = $this->fmea->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->fmea->ViewValue = $this->fmea->CurrentValue;
						}
					}
				} else {
					$this->fmea->ViewValue = NULL;
				}
			}
			$this->fmea->ViewCustomAttributes = "";

			// step
			$this->step->ViewValue = $this->step->CurrentValue;
			$this->step->ViewValue = FormatNumber($this->step->ViewValue, 0, -2, -2, -2);
			$this->step->ViewCustomAttributes = "";

			// flowchartDesc
			$this->flowchartDesc->ViewValue = $this->flowchartDesc->CurrentValue;
			$this->flowchartDesc->ViewCustomAttributes = "";

			// partnumber
			$this->partnumber->ViewValue = $this->partnumber->CurrentValue;
			$this->partnumber->ViewCustomAttributes = "";

			// operation
			$this->operation->ViewValue = $this->operation->CurrentValue;
			$this->operation->ViewCustomAttributes = "";

			// derivedFromNC
			if (ConvertToBool($this->derivedFromNC->CurrentValue)) {
				$this->derivedFromNC->ViewValue = $this->derivedFromNC->tagCaption(2) != "" ? $this->derivedFromNC->tagCaption(2) : "1";
			} else {
				$this->derivedFromNC->ViewValue = $this->derivedFromNC->tagCaption(1) != "" ? $this->derivedFromNC->tagCaption(1) : "0";
			}
			$this->derivedFromNC->ViewCustomAttributes = "";

			// numberOfNC
			$this->numberOfNC->ViewValue = $this->numberOfNC->CurrentValue;
			$this->numberOfNC->ViewCustomAttributes = "";

			// flowchart
			$this->flowchart->ViewValue = $this->flowchart->CurrentValue;
			$this->flowchart->ViewCustomAttributes = "";

			// subprocess
			$this->subprocess->ViewValue = $this->subprocess->CurrentValue;
			$this->subprocess->ViewCustomAttributes = "";

			// requirement
			$this->requirement->ViewValue = $this->requirement->CurrentValue;
			$this->requirement->ViewCustomAttributes = "";

			// potencialFailureMode
			$this->potencialFailureMode->ViewValue = $this->potencialFailureMode->CurrentValue;
			$this->potencialFailureMode->ViewCustomAttributes = "";

			// potencialFailurEffect
			$this->potencialFailurEffect->ViewValue = $this->potencialFailurEffect->CurrentValue;
			$this->potencialFailurEffect->ViewCustomAttributes = "";

			// kc
			if (ConvertToBool($this->kc->CurrentValue)) {
				$this->kc->ViewValue = $this->kc->tagCaption(2) != "" ? $this->kc->tagCaption(2) : "1";
			} else {
				$this->kc->ViewValue = $this->kc->tagCaption(1) != "" ? $this->kc->tagCaption(1) : "0";
			}
			$this->kc->ViewCustomAttributes = "";

			// severity
			$this->severity->ViewValue = $this->severity->CurrentValue;
			$this->severity->ViewValue = FormatNumber($this->severity->ViewValue, 0, -2, -2, -2);
			$this->severity->ViewCustomAttributes = "";

			// fmea
			$this->fmea->LinkCustomAttributes = "";
			$this->fmea->HrefValue = "";
			$this->fmea->TooltipValue = "";
			if (!$this->isExport())
				$this->fmea->ViewValue = $this->highlightValue($this->fmea);

			// step
			$this->step->LinkCustomAttributes = "";
			$this->step->HrefValue = "";
			$this->step->TooltipValue = "";

			// flowchartDesc
			$this->flowchartDesc->LinkCustomAttributes = "";
			$this->flowchartDesc->HrefValue = "";
			$this->flowchartDesc->TooltipValue = "";
			if (!$this->isExport())
				$this->flowchartDesc->ViewValue = $this->highlightValue($this->flowchartDesc);

			// partnumber
			$this->partnumber->LinkCustomAttributes = "";
			$this->partnumber->HrefValue = "";
			$this->partnumber->TooltipValue = "";
			if (!$this->isExport())
				$this->partnumber->ViewValue = $this->highlightValue($this->partnumber);

			// operation
			$this->operation->LinkCustomAttributes = "";
			$this->operation->HrefValue = "";
			$this->operation->TooltipValue = "";
			if (!$this->isExport())
				$this->operation->ViewValue = $this->highlightValue($this->operation);

			// derivedFromNC
			$this->derivedFromNC->LinkCustomAttributes = "";
			$this->derivedFromNC->HrefValue = "";
			$this->derivedFromNC->TooltipValue = "";

			// numberOfNC
			$this->numberOfNC->LinkCustomAttributes = "";
			$this->numberOfNC->HrefValue = "";
			$this->numberOfNC->TooltipValue = "";
			if (!$this->isExport())
				$this->numberOfNC->ViewValue = $this->highlightValue($this->numberOfNC);

			// flowchart
			$this->flowchart->LinkCustomAttributes = "";
			$this->flowchart->HrefValue = "";
			$this->flowchart->TooltipValue = "";
			if (!$this->isExport())
				$this->flowchart->ViewValue = $this->highlightValue($this->flowchart);

			// subprocess
			$this->subprocess->LinkCustomAttributes = "";
			$this->subprocess->HrefValue = "";
			$this->subprocess->TooltipValue = "";
			if (!$this->isExport())
				$this->subprocess->ViewValue = $this->highlightValue($this->subprocess);

			// requirement
			$this->requirement->LinkCustomAttributes = "";
			$this->requirement->HrefValue = "";
			$this->requirement->TooltipValue = "";
			if (!$this->isExport())
				$this->requirement->ViewValue = $this->highlightValue($this->requirement);

			// potencialFailureMode
			$this->potencialFailureMode->LinkCustomAttributes = "";
			$this->potencialFailureMode->HrefValue = "";
			$this->potencialFailureMode->TooltipValue = "";
			if (!$this->isExport())
				$this->potencialFailureMode->ViewValue = $this->highlightValue($this->potencialFailureMode);

			// potencialFailurEffect
			$this->potencialFailurEffect->LinkCustomAttributes = "";
			$this->potencialFailurEffect->HrefValue = "";
			$this->potencialFailurEffect->TooltipValue = "";
			if (!$this->isExport())
				$this->potencialFailurEffect->ViewValue = $this->highlightValue($this->potencialFailurEffect);

			// kc
			$this->kc->LinkCustomAttributes = "";
			$this->kc->HrefValue = "";
			$this->kc->TooltipValue = "";

			// severity
			$this->severity->LinkCustomAttributes = "";
			$this->severity->HrefValue = "";
			$this->severity->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// fmea
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			if ($this->fmea->getSessionValue() != "") {
				$this->fmea->CurrentValue = $this->fmea->getSessionValue();
				if ($this->fmea->VirtualValue != "") {
					$this->fmea->ViewValue = $this->fmea->VirtualValue;
				} else {
					$curVal = strval($this->fmea->CurrentValue);
					if ($curVal != "") {
						$this->fmea->ViewValue = $this->fmea->lookupCacheOption($curVal);
						if ($this->fmea->ViewValue === NULL) { // Lookup from database
							$filterWrk = "`fmea`" . SearchString("=", $curVal, DATATYPE_STRING, "");
							$sqlWrk = $this->fmea->Lookup->getSql(FALSE, $filterWrk, '', $this);
							$rswrk = Conn()->execute($sqlWrk);
							if ($rswrk && !$rswrk->EOF) { // Lookup values found
								$arwrk = [];
								$arwrk[1] = $rswrk->fields('df');
								$this->fmea->ViewValue = $this->fmea->displayValue($arwrk);
								$rswrk->Close();
							} else {
								$this->fmea->ViewValue = $this->fmea->CurrentValue;
							}
						}
					} else {
						$this->fmea->ViewValue = NULL;
					}
				}
				$this->fmea->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->fmea->CurrentValue));
				if ($curVal != "")
					$this->fmea->ViewValue = $this->fmea->lookupCacheOption($curVal);
				else
					$this->fmea->ViewValue = $this->fmea->Lookup !== NULL && is_array($this->fmea->Lookup->Options) ? $curVal : NULL;
				if ($this->fmea->ViewValue !== NULL) { // Load from cache
					$this->fmea->EditValue = array_values($this->fmea->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`fmea`" . SearchString("=", $this->fmea->CurrentValue, DATATYPE_STRING, "");
					}
					$sqlWrk = $this->fmea->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->fmea->EditValue = $arwrk;
				}
			}

			// step
			$this->step->EditAttrs["class"] = "form-control";
			$this->step->EditCustomAttributes = "";
			$this->step->EditValue = HtmlEncode($this->step->CurrentValue);
			$this->step->PlaceHolder = RemoveHtml($this->step->caption());

			// flowchartDesc
			$this->flowchartDesc->EditAttrs["class"] = "form-control";
			$this->flowchartDesc->EditCustomAttributes = "";
			$this->flowchartDesc->EditValue = HtmlEncode($this->flowchartDesc->CurrentValue);
			$this->flowchartDesc->PlaceHolder = RemoveHtml($this->flowchartDesc->caption());

			// partnumber
			$this->partnumber->EditAttrs["class"] = "form-control";
			$this->partnumber->EditCustomAttributes = "";
			if (!$this->partnumber->Raw)
				$this->partnumber->CurrentValue = HtmlDecode($this->partnumber->CurrentValue);
			$this->partnumber->EditValue = HtmlEncode($this->partnumber->CurrentValue);
			$this->partnumber->PlaceHolder = RemoveHtml($this->partnumber->caption());

			// operation
			$this->operation->EditAttrs["class"] = "form-control";
			$this->operation->EditCustomAttributes = "";
			if (!$this->operation->Raw)
				$this->operation->CurrentValue = HtmlDecode($this->operation->CurrentValue);
			$this->operation->EditValue = HtmlEncode($this->operation->CurrentValue);
			$this->operation->PlaceHolder = RemoveHtml($this->operation->caption());

			// derivedFromNC
			$this->derivedFromNC->EditCustomAttributes = "";
			$this->derivedFromNC->EditValue = $this->derivedFromNC->options(FALSE);

			// numberOfNC
			$this->numberOfNC->EditAttrs["class"] = "form-control";
			$this->numberOfNC->EditCustomAttributes = "";
			if (!$this->numberOfNC->Raw)
				$this->numberOfNC->CurrentValue = HtmlDecode($this->numberOfNC->CurrentValue);
			$this->numberOfNC->EditValue = HtmlEncode($this->numberOfNC->CurrentValue);
			$this->numberOfNC->PlaceHolder = RemoveHtml($this->numberOfNC->caption());

			// flowchart
			$this->flowchart->EditAttrs["class"] = "form-control";
			$this->flowchart->EditCustomAttributes = "";
			if (!$this->flowchart->Raw)
				$this->flowchart->CurrentValue = HtmlDecode($this->flowchart->CurrentValue);
			$this->flowchart->EditValue = HtmlEncode($this->flowchart->CurrentValue);
			$this->flowchart->PlaceHolder = RemoveHtml($this->flowchart->caption());

			// subprocess
			$this->subprocess->EditAttrs["class"] = "form-control";
			$this->subprocess->EditCustomAttributes = "";
			if (!$this->subprocess->Raw)
				$this->subprocess->CurrentValue = HtmlDecode($this->subprocess->CurrentValue);
			$this->subprocess->EditValue = HtmlEncode($this->subprocess->CurrentValue);
			$this->subprocess->PlaceHolder = RemoveHtml($this->subprocess->caption());

			// requirement
			$this->requirement->EditAttrs["class"] = "form-control";
			$this->requirement->EditCustomAttributes = "";
			if (!$this->requirement->Raw)
				$this->requirement->CurrentValue = HtmlDecode($this->requirement->CurrentValue);
			$this->requirement->EditValue = HtmlEncode($this->requirement->CurrentValue);
			$this->requirement->PlaceHolder = RemoveHtml($this->requirement->caption());

			// potencialFailureMode
			$this->potencialFailureMode->EditAttrs["class"] = "form-control";
			$this->potencialFailureMode->EditCustomAttributes = "";
			if (!$this->potencialFailureMode->Raw)
				$this->potencialFailureMode->CurrentValue = HtmlDecode($this->potencialFailureMode->CurrentValue);
			$this->potencialFailureMode->EditValue = HtmlEncode($this->potencialFailureMode->CurrentValue);
			$this->potencialFailureMode->PlaceHolder = RemoveHtml($this->potencialFailureMode->caption());

			// potencialFailurEffect
			$this->potencialFailurEffect->EditAttrs["class"] = "form-control";
			$this->potencialFailurEffect->EditCustomAttributes = "";
			if (!$this->potencialFailurEffect->Raw)
				$this->potencialFailurEffect->CurrentValue = HtmlDecode($this->potencialFailurEffect->CurrentValue);
			$this->potencialFailurEffect->EditValue = HtmlEncode($this->potencialFailurEffect->CurrentValue);
			$this->potencialFailurEffect->PlaceHolder = RemoveHtml($this->potencialFailurEffect->caption());

			// kc
			$this->kc->EditCustomAttributes = "";
			$this->kc->EditValue = $this->kc->options(FALSE);

			// severity
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue = HtmlEncode($this->severity->CurrentValue);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());

			// Add refer script
			// fmea

			$this->fmea->LinkCustomAttributes = "";
			$this->fmea->HrefValue = "";

			// step
			$this->step->LinkCustomAttributes = "";
			$this->step->HrefValue = "";

			// flowchartDesc
			$this->flowchartDesc->LinkCustomAttributes = "";
			$this->flowchartDesc->HrefValue = "";

			// partnumber
			$this->partnumber->LinkCustomAttributes = "";
			$this->partnumber->HrefValue = "";

			// operation
			$this->operation->LinkCustomAttributes = "";
			$this->operation->HrefValue = "";

			// derivedFromNC
			$this->derivedFromNC->LinkCustomAttributes = "";
			$this->derivedFromNC->HrefValue = "";

			// numberOfNC
			$this->numberOfNC->LinkCustomAttributes = "";
			$this->numberOfNC->HrefValue = "";

			// flowchart
			$this->flowchart->LinkCustomAttributes = "";
			$this->flowchart->HrefValue = "";

			// subprocess
			$this->subprocess->LinkCustomAttributes = "";
			$this->subprocess->HrefValue = "";

			// requirement
			$this->requirement->LinkCustomAttributes = "";
			$this->requirement->HrefValue = "";

			// potencialFailureMode
			$this->potencialFailureMode->LinkCustomAttributes = "";
			$this->potencialFailureMode->HrefValue = "";

			// potencialFailurEffect
			$this->potencialFailurEffect->LinkCustomAttributes = "";
			$this->potencialFailurEffect->HrefValue = "";

			// kc
			$this->kc->LinkCustomAttributes = "";
			$this->kc->HrefValue = "";

			// severity
			$this->severity->LinkCustomAttributes = "";
			$this->severity->HrefValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// fmea
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			if ($this->fmea->getSessionValue() != "") {
				$this->fmea->CurrentValue = $this->fmea->getSessionValue();
				if ($this->fmea->VirtualValue != "") {
					$this->fmea->ViewValue = $this->fmea->VirtualValue;
				} else {
					$curVal = strval($this->fmea->CurrentValue);
					if ($curVal != "") {
						$this->fmea->ViewValue = $this->fmea->lookupCacheOption($curVal);
						if ($this->fmea->ViewValue === NULL) { // Lookup from database
							$filterWrk = "`fmea`" . SearchString("=", $curVal, DATATYPE_STRING, "");
							$sqlWrk = $this->fmea->Lookup->getSql(FALSE, $filterWrk, '', $this);
							$rswrk = Conn()->execute($sqlWrk);
							if ($rswrk && !$rswrk->EOF) { // Lookup values found
								$arwrk = [];
								$arwrk[1] = $rswrk->fields('df');
								$this->fmea->ViewValue = $this->fmea->displayValue($arwrk);
								$rswrk->Close();
							} else {
								$this->fmea->ViewValue = $this->fmea->CurrentValue;
							}
						}
					} else {
						$this->fmea->ViewValue = NULL;
					}
				}
				$this->fmea->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->fmea->CurrentValue));
				if ($curVal != "")
					$this->fmea->ViewValue = $this->fmea->lookupCacheOption($curVal);
				else
					$this->fmea->ViewValue = $this->fmea->Lookup !== NULL && is_array($this->fmea->Lookup->Options) ? $curVal : NULL;
				if ($this->fmea->ViewValue !== NULL) { // Load from cache
					$this->fmea->EditValue = array_values($this->fmea->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`fmea`" . SearchString("=", $this->fmea->CurrentValue, DATATYPE_STRING, "");
					}
					$sqlWrk = $this->fmea->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->fmea->EditValue = $arwrk;
				}
			}

			// step
			$this->step->EditAttrs["class"] = "form-control";
			$this->step->EditCustomAttributes = "";
			$this->step->EditValue = HtmlEncode($this->step->CurrentValue);
			$this->step->PlaceHolder = RemoveHtml($this->step->caption());

			// flowchartDesc
			$this->flowchartDesc->EditAttrs["class"] = "form-control";
			$this->flowchartDesc->EditCustomAttributes = "";
			$this->flowchartDesc->EditValue = HtmlEncode($this->flowchartDesc->CurrentValue);
			$this->flowchartDesc->PlaceHolder = RemoveHtml($this->flowchartDesc->caption());

			// partnumber
			$this->partnumber->EditAttrs["class"] = "form-control";
			$this->partnumber->EditCustomAttributes = "";
			if (!$this->partnumber->Raw)
				$this->partnumber->CurrentValue = HtmlDecode($this->partnumber->CurrentValue);
			$this->partnumber->EditValue = HtmlEncode($this->partnumber->CurrentValue);
			$this->partnumber->PlaceHolder = RemoveHtml($this->partnumber->caption());

			// operation
			$this->operation->EditAttrs["class"] = "form-control";
			$this->operation->EditCustomAttributes = "";
			if (!$this->operation->Raw)
				$this->operation->CurrentValue = HtmlDecode($this->operation->CurrentValue);
			$this->operation->EditValue = HtmlEncode($this->operation->CurrentValue);
			$this->operation->PlaceHolder = RemoveHtml($this->operation->caption());

			// derivedFromNC
			$this->derivedFromNC->EditCustomAttributes = "";
			$this->derivedFromNC->EditValue = $this->derivedFromNC->options(FALSE);

			// numberOfNC
			$this->numberOfNC->EditAttrs["class"] = "form-control";
			$this->numberOfNC->EditCustomAttributes = "";
			if (!$this->numberOfNC->Raw)
				$this->numberOfNC->CurrentValue = HtmlDecode($this->numberOfNC->CurrentValue);
			$this->numberOfNC->EditValue = HtmlEncode($this->numberOfNC->CurrentValue);
			$this->numberOfNC->PlaceHolder = RemoveHtml($this->numberOfNC->caption());

			// flowchart
			$this->flowchart->EditAttrs["class"] = "form-control";
			$this->flowchart->EditCustomAttributes = "";
			if (!$this->flowchart->Raw)
				$this->flowchart->CurrentValue = HtmlDecode($this->flowchart->CurrentValue);
			$this->flowchart->EditValue = HtmlEncode($this->flowchart->CurrentValue);
			$this->flowchart->PlaceHolder = RemoveHtml($this->flowchart->caption());

			// subprocess
			$this->subprocess->EditAttrs["class"] = "form-control";
			$this->subprocess->EditCustomAttributes = "";
			if (!$this->subprocess->Raw)
				$this->subprocess->CurrentValue = HtmlDecode($this->subprocess->CurrentValue);
			$this->subprocess->EditValue = HtmlEncode($this->subprocess->CurrentValue);
			$this->subprocess->PlaceHolder = RemoveHtml($this->subprocess->caption());

			// requirement
			$this->requirement->EditAttrs["class"] = "form-control";
			$this->requirement->EditCustomAttributes = "";
			if (!$this->requirement->Raw)
				$this->requirement->CurrentValue = HtmlDecode($this->requirement->CurrentValue);
			$this->requirement->EditValue = HtmlEncode($this->requirement->CurrentValue);
			$this->requirement->PlaceHolder = RemoveHtml($this->requirement->caption());

			// potencialFailureMode
			$this->potencialFailureMode->EditAttrs["class"] = "form-control";
			$this->potencialFailureMode->EditCustomAttributes = "";
			if (!$this->potencialFailureMode->Raw)
				$this->potencialFailureMode->CurrentValue = HtmlDecode($this->potencialFailureMode->CurrentValue);
			$this->potencialFailureMode->EditValue = HtmlEncode($this->potencialFailureMode->CurrentValue);
			$this->potencialFailureMode->PlaceHolder = RemoveHtml($this->potencialFailureMode->caption());

			// potencialFailurEffect
			$this->potencialFailurEffect->EditAttrs["class"] = "form-control";
			$this->potencialFailurEffect->EditCustomAttributes = "";
			if (!$this->potencialFailurEffect->Raw)
				$this->potencialFailurEffect->CurrentValue = HtmlDecode($this->potencialFailurEffect->CurrentValue);
			$this->potencialFailurEffect->EditValue = HtmlEncode($this->potencialFailurEffect->CurrentValue);
			$this->potencialFailurEffect->PlaceHolder = RemoveHtml($this->potencialFailurEffect->caption());

			// kc
			$this->kc->EditCustomAttributes = "";
			$this->kc->EditValue = $this->kc->options(FALSE);

			// severity
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue = HtmlEncode($this->severity->CurrentValue);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());

			// Edit refer script
			// fmea

			$this->fmea->LinkCustomAttributes = "";
			$this->fmea->HrefValue = "";

			// step
			$this->step->LinkCustomAttributes = "";
			$this->step->HrefValue = "";

			// flowchartDesc
			$this->flowchartDesc->LinkCustomAttributes = "";
			$this->flowchartDesc->HrefValue = "";

			// partnumber
			$this->partnumber->LinkCustomAttributes = "";
			$this->partnumber->HrefValue = "";

			// operation
			$this->operation->LinkCustomAttributes = "";
			$this->operation->HrefValue = "";

			// derivedFromNC
			$this->derivedFromNC->LinkCustomAttributes = "";
			$this->derivedFromNC->HrefValue = "";

			// numberOfNC
			$this->numberOfNC->LinkCustomAttributes = "";
			$this->numberOfNC->HrefValue = "";

			// flowchart
			$this->flowchart->LinkCustomAttributes = "";
			$this->flowchart->HrefValue = "";

			// subprocess
			$this->subprocess->LinkCustomAttributes = "";
			$this->subprocess->HrefValue = "";

			// requirement
			$this->requirement->LinkCustomAttributes = "";
			$this->requirement->HrefValue = "";

			// potencialFailureMode
			$this->potencialFailureMode->LinkCustomAttributes = "";
			$this->potencialFailureMode->HrefValue = "";

			// potencialFailurEffect
			$this->potencialFailurEffect->LinkCustomAttributes = "";
			$this->potencialFailurEffect->HrefValue = "";

			// kc
			$this->kc->LinkCustomAttributes = "";
			$this->kc->HrefValue = "";

			// severity
			$this->severity->LinkCustomAttributes = "";
			$this->severity->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		if ($this->fmea->Required) {
			if (!$this->fmea->IsDetailKey && $this->fmea->FormValue != NULL && $this->fmea->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->fmea->caption(), $this->fmea->RequiredErrorMessage));
			}
		}
		if ($this->step->Required) {
			if (!$this->step->IsDetailKey && $this->step->FormValue != NULL && $this->step->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->step->caption(), $this->step->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->step->FormValue)) {
			AddMessage($FormError, $this->step->errorMessage());
		}
		if ($this->flowchartDesc->Required) {
			if (!$this->flowchartDesc->IsDetailKey && $this->flowchartDesc->FormValue != NULL && $this->flowchartDesc->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->flowchartDesc->caption(), $this->flowchartDesc->RequiredErrorMessage));
			}
		}
		if ($this->partnumber->Required) {
			if (!$this->partnumber->IsDetailKey && $this->partnumber->FormValue != NULL && $this->partnumber->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->partnumber->caption(), $this->partnumber->RequiredErrorMessage));
			}
		}
		if ($this->operation->Required) {
			if (!$this->operation->IsDetailKey && $this->operation->FormValue != NULL && $this->operation->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->operation->caption(), $this->operation->RequiredErrorMessage));
			}
		}
		if ($this->derivedFromNC->Required) {
			if ($this->derivedFromNC->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->derivedFromNC->caption(), $this->derivedFromNC->RequiredErrorMessage));
			}
		}
		if ($this->numberOfNC->Required) {
			if (!$this->numberOfNC->IsDetailKey && $this->numberOfNC->FormValue != NULL && $this->numberOfNC->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->numberOfNC->caption(), $this->numberOfNC->RequiredErrorMessage));
			}
		}
		if ($this->flowchart->Required) {
			if (!$this->flowchart->IsDetailKey && $this->flowchart->FormValue != NULL && $this->flowchart->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->flowchart->caption(), $this->flowchart->RequiredErrorMessage));
			}
		}
		if ($this->subprocess->Required) {
			if (!$this->subprocess->IsDetailKey && $this->subprocess->FormValue != NULL && $this->subprocess->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->subprocess->caption(), $this->subprocess->RequiredErrorMessage));
			}
		}
		if ($this->requirement->Required) {
			if (!$this->requirement->IsDetailKey && $this->requirement->FormValue != NULL && $this->requirement->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->requirement->caption(), $this->requirement->RequiredErrorMessage));
			}
		}
		if ($this->potencialFailureMode->Required) {
			if (!$this->potencialFailureMode->IsDetailKey && $this->potencialFailureMode->FormValue != NULL && $this->potencialFailureMode->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->potencialFailureMode->caption(), $this->potencialFailureMode->RequiredErrorMessage));
			}
		}
		if ($this->potencialFailurEffect->Required) {
			if (!$this->potencialFailurEffect->IsDetailKey && $this->potencialFailurEffect->FormValue != NULL && $this->potencialFailurEffect->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->potencialFailurEffect->caption(), $this->potencialFailurEffect->RequiredErrorMessage));
			}
		}
		if ($this->kc->Required) {
			if ($this->kc->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->kc->caption(), $this->kc->RequiredErrorMessage));
			}
		}
		if ($this->severity->Required) {
			if (!$this->severity->IsDetailKey && $this->severity->FormValue != NULL && $this->severity->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->severity->caption(), $this->severity->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->severity->FormValue)) {
			AddMessage($FormError, $this->severity->errorMessage());
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

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$oldKeyFilter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($oldKeyFilter);
		$conn = $this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// fmea
			$this->fmea->setDbValueDef($rsnew, $this->fmea->CurrentValue, NULL, $this->fmea->ReadOnly);

			// step
			$this->step->setDbValueDef($rsnew, $this->step->CurrentValue, NULL, $this->step->ReadOnly);

			// flowchartDesc
			$this->flowchartDesc->setDbValueDef($rsnew, $this->flowchartDesc->CurrentValue, NULL, $this->flowchartDesc->ReadOnly);

			// partnumber
			$this->partnumber->setDbValueDef($rsnew, $this->partnumber->CurrentValue, NULL, $this->partnumber->ReadOnly);

			// operation
			$this->operation->setDbValueDef($rsnew, $this->operation->CurrentValue, NULL, $this->operation->ReadOnly);

			// derivedFromNC
			$tmpBool = $this->derivedFromNC->CurrentValue;
			if ($tmpBool != "1" && $tmpBool != "0")
				$tmpBool = !empty($tmpBool) ? "1" : "0";
			$this->derivedFromNC->setDbValueDef($rsnew, $tmpBool, NULL, $this->derivedFromNC->ReadOnly);

			// numberOfNC
			$this->numberOfNC->setDbValueDef($rsnew, $this->numberOfNC->CurrentValue, NULL, $this->numberOfNC->ReadOnly);

			// flowchart
			$this->flowchart->setDbValueDef($rsnew, $this->flowchart->CurrentValue, NULL, $this->flowchart->ReadOnly);

			// subprocess
			$this->subprocess->setDbValueDef($rsnew, $this->subprocess->CurrentValue, NULL, $this->subprocess->ReadOnly);

			// requirement
			$this->requirement->setDbValueDef($rsnew, $this->requirement->CurrentValue, NULL, $this->requirement->ReadOnly);

			// potencialFailureMode
			$this->potencialFailureMode->setDbValueDef($rsnew, $this->potencialFailureMode->CurrentValue, NULL, $this->potencialFailureMode->ReadOnly);

			// potencialFailurEffect
			$this->potencialFailurEffect->setDbValueDef($rsnew, $this->potencialFailurEffect->CurrentValue, NULL, $this->potencialFailurEffect->ReadOnly);

			// kc
			$tmpBool = $this->kc->CurrentValue;
			if ($tmpBool != "1" && $tmpBool != "0")
				$tmpBool = !empty($tmpBool) ? "1" : "0";
			$this->kc->setDbValueDef($rsnew, $tmpBool, NULL, $this->kc->ReadOnly);

			// severity
			$this->severity->setDbValueDef($rsnew, $this->severity->CurrentValue, NULL, $this->severity->ReadOnly);

			// Check hash value
			$rowHasConflict = (!IsApi() && $this->getRowHash($rs) != $this->HashValue);

			// Call Row Update Conflict event
			if ($rowHasConflict)
				$rowHasConflict = $this->Row_UpdateConflict($rsold, $rsnew);
			if ($rowHasConflict) {
				$this->setFailureMessage($Language->phrase("RecordChangedByOtherUser"));
				$this->UpdateConflict = "U";
				$rs->close();
				return FALSE; // Update Failed
			}

			// Check referential integrity for master table 'fmea'
			$validMasterRecord = TRUE;
			$masterFilter = $this->sqlMasterFilter_fmea();
			$keyValue = isset($rsnew['fmea']) ? $rsnew['fmea'] : $rsold['fmea'];
			if (strval($keyValue) != "") {
				$masterFilter = str_replace("@fmea@", AdjustSql($keyValue), $masterFilter);
			} else {
				$validMasterRecord = FALSE;
			}
			if ($validMasterRecord) {
				if (!isset($GLOBALS["fmea"]))
					$GLOBALS["fmea"] = new fmea();
				$rsmaster = $GLOBALS["fmea"]->loadRs($masterFilter);
				$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->close();
			}
			if (!$validMasterRecord) {
				$relatedRecordMsg = str_replace("%t", "fmea", $Language->phrase("RelatedRecordRequired"));
				$this->setFailureMessage($relatedRecordMsg);
				$rs->close();
				return FALSE;
			}

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);

			// Check for duplicate key when key changed
			if ($updateRow) {
				$newKeyFilter = $this->getRecordFilter($rsnew);
				if ($newKeyFilter != $oldKeyFilter) {
					$rsChk = $this->loadRs($newKeyFilter);
					if ($rsChk && !$rsChk->EOF) {
						$keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
						$this->setFailureMessage($keyErrMsg);
						$rsChk->close();
						$updateRow = FALSE;
					}
				}
			}
			if ($updateRow) {
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = "";
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage != "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Clean upload path if any
		if ($editRow) {
		}

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
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

	// Load row hash
	protected function loadRowHash()
	{
		$filter = $this->getRecordFilter();

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$rsRow = $conn->Execute($sql);
		$this->HashValue = ($rsRow && !$rsRow->EOF) ? $this->getRowHash($rsRow) : ""; // Get hash value for record
		$rsRow->close();
	}

	// Get Row Hash
	public function getRowHash(&$rs)
	{
		if (!$rs)
			return "";
		$hash = "";
		$hash .= GetFieldHash($rs->fields('fmea')); // fmea
		$hash .= GetFieldHash($rs->fields('step')); // step
		$hash .= GetFieldHash($rs->fields('flowchartDesc')); // flowchartDesc
		$hash .= GetFieldHash($rs->fields('partnumber')); // partnumber
		$hash .= GetFieldHash($rs->fields('operation')); // operation
		$hash .= GetFieldHash($rs->fields('derivedFromNC')); // derivedFromNC
		$hash .= GetFieldHash($rs->fields('numberOfNC')); // numberOfNC
		$hash .= GetFieldHash($rs->fields('flowchart')); // flowchart
		$hash .= GetFieldHash($rs->fields('subprocess')); // subprocess
		$hash .= GetFieldHash($rs->fields('requirement')); // requirement
		$hash .= GetFieldHash($rs->fields('potencialFailureMode')); // potencialFailureMode
		$hash .= GetFieldHash($rs->fields('potencialFailurEffect')); // potencialFailurEffect
		$hash .= GetFieldHash($rs->fields('kc')); // kc
		$hash .= GetFieldHash($rs->fields('severity')); // severity
		return md5($hash);
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check referential integrity for master table 'processf'
		$validMasterRecord = TRUE;
		$masterFilter = $this->sqlMasterFilter_fmea();
		if (strval($this->fmea->CurrentValue) != "") {
			$masterFilter = str_replace("@fmea@", AdjustSql($this->fmea->CurrentValue, "DB"), $masterFilter);
		} else {
			$validMasterRecord = FALSE;
		}
		if ($validMasterRecord) {
			if (!isset($GLOBALS["fmea"]))
				$GLOBALS["fmea"] = new fmea();
			$rsmaster = $GLOBALS["fmea"]->loadRs($masterFilter);
			$validMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->close();
		}
		if (!$validMasterRecord) {
			$relatedRecordMsg = str_replace("%t", "fmea", $Language->phrase("RelatedRecordRequired"));
			$this->setFailureMessage($relatedRecordMsg);
			return FALSE;
		}
		$conn = $this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// fmea
		$this->fmea->setDbValueDef($rsnew, $this->fmea->CurrentValue, NULL, FALSE);

		// step
		$this->step->setDbValueDef($rsnew, $this->step->CurrentValue, NULL, FALSE);

		// flowchartDesc
		$this->flowchartDesc->setDbValueDef($rsnew, $this->flowchartDesc->CurrentValue, NULL, FALSE);

		// partnumber
		$this->partnumber->setDbValueDef($rsnew, $this->partnumber->CurrentValue, NULL, FALSE);

		// operation
		$this->operation->setDbValueDef($rsnew, $this->operation->CurrentValue, NULL, FALSE);

		// derivedFromNC
		$tmpBool = $this->derivedFromNC->CurrentValue;
		if ($tmpBool != "1" && $tmpBool != "0")
			$tmpBool = !empty($tmpBool) ? "1" : "0";
		$this->derivedFromNC->setDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// numberOfNC
		$this->numberOfNC->setDbValueDef($rsnew, $this->numberOfNC->CurrentValue, NULL, FALSE);

		// flowchart
		$this->flowchart->setDbValueDef($rsnew, $this->flowchart->CurrentValue, NULL, FALSE);

		// subprocess
		$this->subprocess->setDbValueDef($rsnew, $this->subprocess->CurrentValue, NULL, FALSE);

		// requirement
		$this->requirement->setDbValueDef($rsnew, $this->requirement->CurrentValue, NULL, FALSE);

		// potencialFailureMode
		$this->potencialFailureMode->setDbValueDef($rsnew, $this->potencialFailureMode->CurrentValue, NULL, FALSE);

		// potencialFailurEffect
		$this->potencialFailurEffect->setDbValueDef($rsnew, $this->potencialFailurEffect->CurrentValue, NULL, FALSE);

		// kc
		$tmpBool = $this->kc->CurrentValue;
		if ($tmpBool != "1" && $tmpBool != "0")
			$tmpBool = !empty($tmpBool) ? "1" : "0";
		$this->kc->setDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// severity
		$this->severity->setDbValueDef($rsnew, $this->severity->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
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
		$this->fmea->AdvancedSearch->load();
		$this->step->AdvancedSearch->load();
		$this->flowchartDesc->AdvancedSearch->load();
		$this->partnumber->AdvancedSearch->load();
		$this->operation->AdvancedSearch->load();
		$this->derivedFromNC->AdvancedSearch->load();
		$this->numberOfNC->AdvancedSearch->load();
		$this->flowchart->AdvancedSearch->load();
		$this->subprocess->AdvancedSearch->load();
		$this->requirement->AdvancedSearch->load();
		$this->potencialFailureMode->AdvancedSearch->load();
		$this->potencialFailurEffect->AdvancedSearch->load();
		$this->kc->AdvancedSearch->load();
		$this->severity->AdvancedSearch->load();
	}

	// Get export HTML tag
	protected function getExportTag($type, $custom = FALSE)
	{
		global $Language;
		if (SameText($type, "excel")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fprocessflist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
			else
				return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
		} elseif (SameText($type, "word")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fprocessflist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
			else
				return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
		} elseif (SameText($type, "pdf")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fprocessflist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
			return '<button id="emf_processf" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_processf\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fprocessflist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
		$item->Body = $this->getExportTag("excel");
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->add("word");
		$item->Body = $this->getExportTag("word");
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
		$item->Body = $this->getExportTag("pdf");
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->add("email");
		$item->Body = $this->getExportTag("email");
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
		$item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fprocessflistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->add("showall");
		$item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $this->pageUrl() . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->add("advancedsearch");
		if (IsMobile())
			$item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"processfsrch.php\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-table=\"processf\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'SearchBtn',url:'processfsrch.php'});\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->add("searchhighlight");
		$item->Body = "<a class=\"btn btn-default ew-highlight active\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fprocessflistsrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
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
		if (Config("EXPORT_MASTER_RECORD") && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "fmea") {
			global $fmea;
			if (!isset($fmea))
				$fmea = new fmea();
			$rsmaster = $fmea->loadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$exportStyle = $doc->Style;
				$doc->setStyle("v"); // Change to vertical
				if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
					$doc->Table = &$fmea;
					$fmea->exportDocument($doc, $rsmaster);
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
			if ($masterTblVar == "fmea") {
				$validMaster = TRUE;
				if (Get("fk_fmea") !== NULL) {
					$GLOBALS["fmea"]->fmea->setQueryStringValue(Get("fk_fmea"));
					$this->fmea->setQueryStringValue($GLOBALS["fmea"]->fmea->QueryStringValue);
					$this->fmea->setSessionValue($this->fmea->QueryStringValue);
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
			if ($masterTblVar == "fmea") {
				$validMaster = TRUE;
				if (Post("fk_fmea") !== NULL) {
					$GLOBALS["fmea"]->fmea->setFormValue(Post("fk_fmea"));
					$this->fmea->setFormValue($GLOBALS["fmea"]->fmea->FormValue);
					$this->fmea->setSessionValue($this->fmea->FormValue);
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
			if ($masterTblVar != "fmea") {
				if ($this->fmea->CurrentValue == "")
					$this->fmea->setSessionValue("");
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
				case "x_fmea":
					break;
				case "x_derivedFromNC":
					break;
				case "x_kc":
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
						case "x_fmea":
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