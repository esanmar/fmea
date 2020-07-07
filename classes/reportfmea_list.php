<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class reportfmea_list extends reportfmea
{

	// Page ID
	public $PageID = "list";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'reportfmea';

	// Page object name
	public $PageObjName = "reportfmea_list";

	// Grid form hidden field names
	public $FormName = "freportfmealist";
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

		// Table object (reportfmea)
		if (!isset($GLOBALS["reportfmea"]) || get_class($GLOBALS["reportfmea"]) == PROJECT_NAMESPACE . "reportfmea") {
			$GLOBALS["reportfmea"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reportfmea"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->pageUrl() . "export=print";
		$this->ExportExcelUrl = $this->pageUrl() . "export=excel";
		$this->ExportWordUrl = $this->pageUrl() . "export=word";
		$this->ExportPdfUrl = $this->pageUrl() . "export=pdf";
		$this->ExportHtmlUrl = $this->pageUrl() . "export=html";
		$this->ExportXmlUrl = $this->pageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->pageUrl() . "export=csv";
		$this->AddUrl = "reportfmeaadd.php";
		$this->InlineAddUrl = $this->pageUrl() . "action=add";
		$this->GridAddUrl = $this->pageUrl() . "action=gridadd";
		$this->GridEditUrl = $this->pageUrl() . "action=gridedit";
		$this->MultiDeleteUrl = "reportfmeadelete.php";
		$this->MultiUpdateUrl = "reportfmeaupdate.php";

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'list');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'reportfmea');

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
		$this->FilterOptions->TagClassName = "ew-filter-option freportfmealistsrch";

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
		global $reportfmea;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($reportfmea);
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
			$key .= @$ar['fmea'] . Config("COMPOSITE_KEY_SEPARATOR");
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
		$this->fmea->setVisibility();
		$this->idFactory->setVisibility();
		$this->dateFmea->setVisibility();
		$this->partnumbers->setVisibility();
		$this->description->setVisibility();
		$this->idEmployee->setVisibility();
		$this->idworkcenter->setVisibility();
		$this->idProcess->setVisibility();
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
		$this->idCause->setVisibility();
		$this->potentialCauses->setVisibility();
		$this->currentPreventiveControlMethod->setVisibility();
		$this->occurrence->setVisibility();
		$this->currentControlMethod->setVisibility();
		$this->detection->setVisibility();
		$this->rpn->setVisibility();
		$this->recomendedAction->setVisibility();
		$this->idResponsible->setVisibility();
		$this->targetDate->setVisibility();
		$this->revisedKc->setVisibility();
		$this->expectedSeverity->setVisibility();
		$this->expectedOccurrence->setVisibility();
		$this->expectedDetection->setVisibility();
		$this->expectedRpn->setVisibility();
		$this->expectedClosureDate->setVisibility();
		$this->recomendedActiondet->setVisibility();
		$this->idResponsibleDet->setVisibility();
		$this->targetDatedet->setVisibility();
		$this->kcdet->setVisibility();
		$this->expectedSeveritydet->setVisibility();
		$this->expectedOccurrencedet->setVisibility();
		$this->expectedDetectiondet->setVisibility();
		$this->expectedRpndet->setVisibility();
		$this->revisedClosureDatedet->setVisibility();
		$this->revisedClosureDate->setVisibility();
		$this->perfomedAction->setVisibility();
		$this->revisedSeverity->setVisibility();
		$this->revisedOccurrence->setVisibility();
		$this->revisedDetection->setVisibility();
		$this->revisedRpn->setVisibility();
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
		$this->setupLookupOptions($this->idFactory);
		$this->setupLookupOptions($this->idEmployee);
		$this->setupLookupOptions($this->idworkcenter);
		$this->setupLookupOptions($this->idCause);

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
			} else {
				if (Post("action") !== NULL) {
					$this->CurrentAction = Post("action"); // Get action

					// Process import
					if ($this->isImport()) {
						$this->import(Post(Config("API_FILE_TOKEN_NAME")));
						$this->terminate();
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
		AddFilter($filter, $this->DbDetailFilter);
		AddFilter($filter, $this->SearchWhere);

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
			$this->fmea->setOldValue($arKeyFlds[0]);
			$this->idCause->setOldValue($arKeyFlds[1]);
		}
		return TRUE;
	}

	// Get list of filters
	public function getFilterList()
	{
		global $UserProfile;

		// Initialize
		$filterList = "";
		$savedFilterList = "";
		$filterList = Concat($filterList, $this->fmea->AdvancedSearch->toJson(), ","); // Field fmea
		$filterList = Concat($filterList, $this->idFactory->AdvancedSearch->toJson(), ","); // Field idFactory
		$filterList = Concat($filterList, $this->dateFmea->AdvancedSearch->toJson(), ","); // Field dateFmea
		$filterList = Concat($filterList, $this->partnumbers->AdvancedSearch->toJson(), ","); // Field partnumbers
		$filterList = Concat($filterList, $this->description->AdvancedSearch->toJson(), ","); // Field description
		$filterList = Concat($filterList, $this->idEmployee->AdvancedSearch->toJson(), ","); // Field idEmployee
		$filterList = Concat($filterList, $this->idworkcenter->AdvancedSearch->toJson(), ","); // Field idworkcenter
		$filterList = Concat($filterList, $this->idProcess->AdvancedSearch->toJson(), ","); // Field idProcess
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
		$filterList = Concat($filterList, $this->idCause->AdvancedSearch->toJson(), ","); // Field idCause
		$filterList = Concat($filterList, $this->potentialCauses->AdvancedSearch->toJson(), ","); // Field potentialCauses
		$filterList = Concat($filterList, $this->currentPreventiveControlMethod->AdvancedSearch->toJson(), ","); // Field currentPreventiveControlMethod
		$filterList = Concat($filterList, $this->occurrence->AdvancedSearch->toJson(), ","); // Field occurrence
		$filterList = Concat($filterList, $this->currentControlMethod->AdvancedSearch->toJson(), ","); // Field currentControlMethod
		$filterList = Concat($filterList, $this->detection->AdvancedSearch->toJson(), ","); // Field detection
		$filterList = Concat($filterList, $this->rpn->AdvancedSearch->toJson(), ","); // Field rpn
		$filterList = Concat($filterList, $this->recomendedAction->AdvancedSearch->toJson(), ","); // Field recomendedAction
		$filterList = Concat($filterList, $this->idResponsible->AdvancedSearch->toJson(), ","); // Field idResponsible
		$filterList = Concat($filterList, $this->targetDate->AdvancedSearch->toJson(), ","); // Field targetDate
		$filterList = Concat($filterList, $this->revisedKc->AdvancedSearch->toJson(), ","); // Field revisedKc
		$filterList = Concat($filterList, $this->expectedSeverity->AdvancedSearch->toJson(), ","); // Field expectedSeverity
		$filterList = Concat($filterList, $this->expectedOccurrence->AdvancedSearch->toJson(), ","); // Field expectedOccurrence
		$filterList = Concat($filterList, $this->expectedDetection->AdvancedSearch->toJson(), ","); // Field expectedDetection
		$filterList = Concat($filterList, $this->expectedRpn->AdvancedSearch->toJson(), ","); // Field expectedRpn
		$filterList = Concat($filterList, $this->expectedClosureDate->AdvancedSearch->toJson(), ","); // Field expectedClosureDate
		$filterList = Concat($filterList, $this->recomendedActiondet->AdvancedSearch->toJson(), ","); // Field recomendedActiondet
		$filterList = Concat($filterList, $this->idResponsibleDet->AdvancedSearch->toJson(), ","); // Field idResponsibleDet
		$filterList = Concat($filterList, $this->targetDatedet->AdvancedSearch->toJson(), ","); // Field targetDatedet
		$filterList = Concat($filterList, $this->kcdet->AdvancedSearch->toJson(), ","); // Field kcdet
		$filterList = Concat($filterList, $this->expectedSeveritydet->AdvancedSearch->toJson(), ","); // Field expectedSeveritydet
		$filterList = Concat($filterList, $this->expectedOccurrencedet->AdvancedSearch->toJson(), ","); // Field expectedOccurrencedet
		$filterList = Concat($filterList, $this->expectedDetectiondet->AdvancedSearch->toJson(), ","); // Field expectedDetectiondet
		$filterList = Concat($filterList, $this->expectedRpndet->AdvancedSearch->toJson(), ","); // Field expectedRpndet
		$filterList = Concat($filterList, $this->revisedClosureDatedet->AdvancedSearch->toJson(), ","); // Field revisedClosureDatedet
		$filterList = Concat($filterList, $this->revisedClosureDate->AdvancedSearch->toJson(), ","); // Field revisedClosureDate
		$filterList = Concat($filterList, $this->perfomedAction->AdvancedSearch->toJson(), ","); // Field perfomedAction
		$filterList = Concat($filterList, $this->revisedSeverity->AdvancedSearch->toJson(), ","); // Field revisedSeverity
		$filterList = Concat($filterList, $this->revisedOccurrence->AdvancedSearch->toJson(), ","); // Field revisedOccurrence
		$filterList = Concat($filterList, $this->revisedDetection->AdvancedSearch->toJson(), ","); // Field revisedDetection
		$filterList = Concat($filterList, $this->revisedRpn->AdvancedSearch->toJson(), ","); // Field revisedRpn
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
			$UserProfile->setSearchFilters(CurrentUserName(), "freportfmealistsrch", $filters);
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

		// Field idFactory
		$this->idFactory->AdvancedSearch->SearchValue = @$filter["x_idFactory"];
		$this->idFactory->AdvancedSearch->SearchOperator = @$filter["z_idFactory"];
		$this->idFactory->AdvancedSearch->SearchCondition = @$filter["v_idFactory"];
		$this->idFactory->AdvancedSearch->SearchValue2 = @$filter["y_idFactory"];
		$this->idFactory->AdvancedSearch->SearchOperator2 = @$filter["w_idFactory"];
		$this->idFactory->AdvancedSearch->save();

		// Field dateFmea
		$this->dateFmea->AdvancedSearch->SearchValue = @$filter["x_dateFmea"];
		$this->dateFmea->AdvancedSearch->SearchOperator = @$filter["z_dateFmea"];
		$this->dateFmea->AdvancedSearch->SearchCondition = @$filter["v_dateFmea"];
		$this->dateFmea->AdvancedSearch->SearchValue2 = @$filter["y_dateFmea"];
		$this->dateFmea->AdvancedSearch->SearchOperator2 = @$filter["w_dateFmea"];
		$this->dateFmea->AdvancedSearch->save();

		// Field partnumbers
		$this->partnumbers->AdvancedSearch->SearchValue = @$filter["x_partnumbers"];
		$this->partnumbers->AdvancedSearch->SearchOperator = @$filter["z_partnumbers"];
		$this->partnumbers->AdvancedSearch->SearchCondition = @$filter["v_partnumbers"];
		$this->partnumbers->AdvancedSearch->SearchValue2 = @$filter["y_partnumbers"];
		$this->partnumbers->AdvancedSearch->SearchOperator2 = @$filter["w_partnumbers"];
		$this->partnumbers->AdvancedSearch->save();

		// Field description
		$this->description->AdvancedSearch->SearchValue = @$filter["x_description"];
		$this->description->AdvancedSearch->SearchOperator = @$filter["z_description"];
		$this->description->AdvancedSearch->SearchCondition = @$filter["v_description"];
		$this->description->AdvancedSearch->SearchValue2 = @$filter["y_description"];
		$this->description->AdvancedSearch->SearchOperator2 = @$filter["w_description"];
		$this->description->AdvancedSearch->save();

		// Field idEmployee
		$this->idEmployee->AdvancedSearch->SearchValue = @$filter["x_idEmployee"];
		$this->idEmployee->AdvancedSearch->SearchOperator = @$filter["z_idEmployee"];
		$this->idEmployee->AdvancedSearch->SearchCondition = @$filter["v_idEmployee"];
		$this->idEmployee->AdvancedSearch->SearchValue2 = @$filter["y_idEmployee"];
		$this->idEmployee->AdvancedSearch->SearchOperator2 = @$filter["w_idEmployee"];
		$this->idEmployee->AdvancedSearch->save();

		// Field idworkcenter
		$this->idworkcenter->AdvancedSearch->SearchValue = @$filter["x_idworkcenter"];
		$this->idworkcenter->AdvancedSearch->SearchOperator = @$filter["z_idworkcenter"];
		$this->idworkcenter->AdvancedSearch->SearchCondition = @$filter["v_idworkcenter"];
		$this->idworkcenter->AdvancedSearch->SearchValue2 = @$filter["y_idworkcenter"];
		$this->idworkcenter->AdvancedSearch->SearchOperator2 = @$filter["w_idworkcenter"];
		$this->idworkcenter->AdvancedSearch->save();

		// Field idProcess
		$this->idProcess->AdvancedSearch->SearchValue = @$filter["x_idProcess"];
		$this->idProcess->AdvancedSearch->SearchOperator = @$filter["z_idProcess"];
		$this->idProcess->AdvancedSearch->SearchCondition = @$filter["v_idProcess"];
		$this->idProcess->AdvancedSearch->SearchValue2 = @$filter["y_idProcess"];
		$this->idProcess->AdvancedSearch->SearchOperator2 = @$filter["w_idProcess"];
		$this->idProcess->AdvancedSearch->save();

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

		// Field rpn
		$this->rpn->AdvancedSearch->SearchValue = @$filter["x_rpn"];
		$this->rpn->AdvancedSearch->SearchOperator = @$filter["z_rpn"];
		$this->rpn->AdvancedSearch->SearchCondition = @$filter["v_rpn"];
		$this->rpn->AdvancedSearch->SearchValue2 = @$filter["y_rpn"];
		$this->rpn->AdvancedSearch->SearchOperator2 = @$filter["w_rpn"];
		$this->rpn->AdvancedSearch->save();

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

		// Field expectedRpndet
		$this->expectedRpndet->AdvancedSearch->SearchValue = @$filter["x_expectedRpndet"];
		$this->expectedRpndet->AdvancedSearch->SearchOperator = @$filter["z_expectedRpndet"];
		$this->expectedRpndet->AdvancedSearch->SearchCondition = @$filter["v_expectedRpndet"];
		$this->expectedRpndet->AdvancedSearch->SearchValue2 = @$filter["y_expectedRpndet"];
		$this->expectedRpndet->AdvancedSearch->SearchOperator2 = @$filter["w_expectedRpndet"];
		$this->expectedRpndet->AdvancedSearch->save();

		// Field revisedClosureDatedet
		$this->revisedClosureDatedet->AdvancedSearch->SearchValue = @$filter["x_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchOperator = @$filter["z_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchCondition = @$filter["v_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchValue2 = @$filter["y_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->SearchOperator2 = @$filter["w_revisedClosureDatedet"];
		$this->revisedClosureDatedet->AdvancedSearch->save();

		// Field revisedClosureDate
		$this->revisedClosureDate->AdvancedSearch->SearchValue = @$filter["x_revisedClosureDate"];
		$this->revisedClosureDate->AdvancedSearch->SearchOperator = @$filter["z_revisedClosureDate"];
		$this->revisedClosureDate->AdvancedSearch->SearchCondition = @$filter["v_revisedClosureDate"];
		$this->revisedClosureDate->AdvancedSearch->SearchValue2 = @$filter["y_revisedClosureDate"];
		$this->revisedClosureDate->AdvancedSearch->SearchOperator2 = @$filter["w_revisedClosureDate"];
		$this->revisedClosureDate->AdvancedSearch->save();

		// Field perfomedAction
		$this->perfomedAction->AdvancedSearch->SearchValue = @$filter["x_perfomedAction"];
		$this->perfomedAction->AdvancedSearch->SearchOperator = @$filter["z_perfomedAction"];
		$this->perfomedAction->AdvancedSearch->SearchCondition = @$filter["v_perfomedAction"];
		$this->perfomedAction->AdvancedSearch->SearchValue2 = @$filter["y_perfomedAction"];
		$this->perfomedAction->AdvancedSearch->SearchOperator2 = @$filter["w_perfomedAction"];
		$this->perfomedAction->AdvancedSearch->save();

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
		$this->buildSearchSql($where, $this->idFactory, $default, FALSE); // idFactory
		$this->buildSearchSql($where, $this->dateFmea, $default, FALSE); // dateFmea
		$this->buildSearchSql($where, $this->partnumbers, $default, FALSE); // partnumbers
		$this->buildSearchSql($where, $this->description, $default, FALSE); // description
		$this->buildSearchSql($where, $this->idEmployee, $default, FALSE); // idEmployee
		$this->buildSearchSql($where, $this->idworkcenter, $default, FALSE); // idworkcenter
		$this->buildSearchSql($where, $this->idProcess, $default, FALSE); // idProcess
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
		$this->buildSearchSql($where, $this->idCause, $default, FALSE); // idCause
		$this->buildSearchSql($where, $this->potentialCauses, $default, FALSE); // potentialCauses
		$this->buildSearchSql($where, $this->currentPreventiveControlMethod, $default, FALSE); // currentPreventiveControlMethod
		$this->buildSearchSql($where, $this->occurrence, $default, FALSE); // occurrence
		$this->buildSearchSql($where, $this->currentControlMethod, $default, FALSE); // currentControlMethod
		$this->buildSearchSql($where, $this->detection, $default, FALSE); // detection
		$this->buildSearchSql($where, $this->rpn, $default, FALSE); // rpn
		$this->buildSearchSql($where, $this->recomendedAction, $default, FALSE); // recomendedAction
		$this->buildSearchSql($where, $this->idResponsible, $default, FALSE); // idResponsible
		$this->buildSearchSql($where, $this->targetDate, $default, FALSE); // targetDate
		$this->buildSearchSql($where, $this->revisedKc, $default, FALSE); // revisedKc
		$this->buildSearchSql($where, $this->expectedSeverity, $default, FALSE); // expectedSeverity
		$this->buildSearchSql($where, $this->expectedOccurrence, $default, FALSE); // expectedOccurrence
		$this->buildSearchSql($where, $this->expectedDetection, $default, FALSE); // expectedDetection
		$this->buildSearchSql($where, $this->expectedRpn, $default, FALSE); // expectedRpn
		$this->buildSearchSql($where, $this->expectedClosureDate, $default, FALSE); // expectedClosureDate
		$this->buildSearchSql($where, $this->recomendedActiondet, $default, FALSE); // recomendedActiondet
		$this->buildSearchSql($where, $this->idResponsibleDet, $default, FALSE); // idResponsibleDet
		$this->buildSearchSql($where, $this->targetDatedet, $default, FALSE); // targetDatedet
		$this->buildSearchSql($where, $this->kcdet, $default, FALSE); // kcdet
		$this->buildSearchSql($where, $this->expectedSeveritydet, $default, FALSE); // expectedSeveritydet
		$this->buildSearchSql($where, $this->expectedOccurrencedet, $default, FALSE); // expectedOccurrencedet
		$this->buildSearchSql($where, $this->expectedDetectiondet, $default, FALSE); // expectedDetectiondet
		$this->buildSearchSql($where, $this->expectedRpndet, $default, FALSE); // expectedRpndet
		$this->buildSearchSql($where, $this->revisedClosureDatedet, $default, FALSE); // revisedClosureDatedet
		$this->buildSearchSql($where, $this->revisedClosureDate, $default, FALSE); // revisedClosureDate
		$this->buildSearchSql($where, $this->perfomedAction, $default, FALSE); // perfomedAction
		$this->buildSearchSql($where, $this->revisedSeverity, $default, FALSE); // revisedSeverity
		$this->buildSearchSql($where, $this->revisedOccurrence, $default, FALSE); // revisedOccurrence
		$this->buildSearchSql($where, $this->revisedDetection, $default, FALSE); // revisedDetection
		$this->buildSearchSql($where, $this->revisedRpn, $default, FALSE); // revisedRpn

		// Set up search parm
		if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
			$this->Command = "search";
		}
		if (!$default && $this->Command == "search") {
			$this->fmea->AdvancedSearch->save(); // fmea
			$this->idFactory->AdvancedSearch->save(); // idFactory
			$this->dateFmea->AdvancedSearch->save(); // dateFmea
			$this->partnumbers->AdvancedSearch->save(); // partnumbers
			$this->description->AdvancedSearch->save(); // description
			$this->idEmployee->AdvancedSearch->save(); // idEmployee
			$this->idworkcenter->AdvancedSearch->save(); // idworkcenter
			$this->idProcess->AdvancedSearch->save(); // idProcess
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
			$this->idCause->AdvancedSearch->save(); // idCause
			$this->potentialCauses->AdvancedSearch->save(); // potentialCauses
			$this->currentPreventiveControlMethod->AdvancedSearch->save(); // currentPreventiveControlMethod
			$this->occurrence->AdvancedSearch->save(); // occurrence
			$this->currentControlMethod->AdvancedSearch->save(); // currentControlMethod
			$this->detection->AdvancedSearch->save(); // detection
			$this->rpn->AdvancedSearch->save(); // rpn
			$this->recomendedAction->AdvancedSearch->save(); // recomendedAction
			$this->idResponsible->AdvancedSearch->save(); // idResponsible
			$this->targetDate->AdvancedSearch->save(); // targetDate
			$this->revisedKc->AdvancedSearch->save(); // revisedKc
			$this->expectedSeverity->AdvancedSearch->save(); // expectedSeverity
			$this->expectedOccurrence->AdvancedSearch->save(); // expectedOccurrence
			$this->expectedDetection->AdvancedSearch->save(); // expectedDetection
			$this->expectedRpn->AdvancedSearch->save(); // expectedRpn
			$this->expectedClosureDate->AdvancedSearch->save(); // expectedClosureDate
			$this->recomendedActiondet->AdvancedSearch->save(); // recomendedActiondet
			$this->idResponsibleDet->AdvancedSearch->save(); // idResponsibleDet
			$this->targetDatedet->AdvancedSearch->save(); // targetDatedet
			$this->kcdet->AdvancedSearch->save(); // kcdet
			$this->expectedSeveritydet->AdvancedSearch->save(); // expectedSeveritydet
			$this->expectedOccurrencedet->AdvancedSearch->save(); // expectedOccurrencedet
			$this->expectedDetectiondet->AdvancedSearch->save(); // expectedDetectiondet
			$this->expectedRpndet->AdvancedSearch->save(); // expectedRpndet
			$this->revisedClosureDatedet->AdvancedSearch->save(); // revisedClosureDatedet
			$this->revisedClosureDate->AdvancedSearch->save(); // revisedClosureDate
			$this->perfomedAction->AdvancedSearch->save(); // perfomedAction
			$this->revisedSeverity->AdvancedSearch->save(); // revisedSeverity
			$this->revisedOccurrence->AdvancedSearch->save(); // revisedOccurrence
			$this->revisedDetection->AdvancedSearch->save(); // revisedDetection
			$this->revisedRpn->AdvancedSearch->save(); // revisedRpn
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
		$this->buildBasicSearchSql($where, $this->idFactory, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->dateFmea, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->partnumbers, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->description, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idEmployee, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idworkcenter, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->step, $arKeywords, $type);
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
		$this->buildBasicSearchSql($where, $this->idCause, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->potentialCauses, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->currentPreventiveControlMethod, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->occurrence, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->currentControlMethod, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->detection, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->rpn, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->recomendedAction, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idResponsible, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->targetDate, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedKc, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedSeverity, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedOccurrence, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedDetection, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedRpn, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedClosureDate, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->recomendedActiondet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->idResponsibleDet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->targetDatedet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->kcdet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedSeveritydet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedOccurrencedet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedDetectiondet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->expectedRpndet, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedClosureDate, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->perfomedAction, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedSeverity, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedOccurrence, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedDetection, $arKeywords, $type);
		$this->buildBasicSearchSql($where, $this->revisedRpn, $arKeywords, $type);
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
		if ($this->idFactory->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->dateFmea->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->partnumbers->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->description->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->idEmployee->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->idworkcenter->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->idProcess->AdvancedSearch->issetSession())
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
		if ($this->idCause->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->potentialCauses->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->currentPreventiveControlMethod->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->occurrence->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->currentControlMethod->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->detection->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->rpn->AdvancedSearch->issetSession())
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
		if ($this->expectedRpndet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedClosureDatedet->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedClosureDate->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->perfomedAction->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedSeverity->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedOccurrence->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedDetection->AdvancedSearch->issetSession())
			return TRUE;
		if ($this->revisedRpn->AdvancedSearch->issetSession())
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
		$this->idFactory->AdvancedSearch->unsetSession();
		$this->dateFmea->AdvancedSearch->unsetSession();
		$this->partnumbers->AdvancedSearch->unsetSession();
		$this->description->AdvancedSearch->unsetSession();
		$this->idEmployee->AdvancedSearch->unsetSession();
		$this->idworkcenter->AdvancedSearch->unsetSession();
		$this->idProcess->AdvancedSearch->unsetSession();
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
		$this->idCause->AdvancedSearch->unsetSession();
		$this->potentialCauses->AdvancedSearch->unsetSession();
		$this->currentPreventiveControlMethod->AdvancedSearch->unsetSession();
		$this->occurrence->AdvancedSearch->unsetSession();
		$this->currentControlMethod->AdvancedSearch->unsetSession();
		$this->detection->AdvancedSearch->unsetSession();
		$this->rpn->AdvancedSearch->unsetSession();
		$this->recomendedAction->AdvancedSearch->unsetSession();
		$this->idResponsible->AdvancedSearch->unsetSession();
		$this->targetDate->AdvancedSearch->unsetSession();
		$this->revisedKc->AdvancedSearch->unsetSession();
		$this->expectedSeverity->AdvancedSearch->unsetSession();
		$this->expectedOccurrence->AdvancedSearch->unsetSession();
		$this->expectedDetection->AdvancedSearch->unsetSession();
		$this->expectedRpn->AdvancedSearch->unsetSession();
		$this->expectedClosureDate->AdvancedSearch->unsetSession();
		$this->recomendedActiondet->AdvancedSearch->unsetSession();
		$this->idResponsibleDet->AdvancedSearch->unsetSession();
		$this->targetDatedet->AdvancedSearch->unsetSession();
		$this->kcdet->AdvancedSearch->unsetSession();
		$this->expectedSeveritydet->AdvancedSearch->unsetSession();
		$this->expectedOccurrencedet->AdvancedSearch->unsetSession();
		$this->expectedDetectiondet->AdvancedSearch->unsetSession();
		$this->expectedRpndet->AdvancedSearch->unsetSession();
		$this->revisedClosureDatedet->AdvancedSearch->unsetSession();
		$this->revisedClosureDate->AdvancedSearch->unsetSession();
		$this->perfomedAction->AdvancedSearch->unsetSession();
		$this->revisedSeverity->AdvancedSearch->unsetSession();
		$this->revisedOccurrence->AdvancedSearch->unsetSession();
		$this->revisedDetection->AdvancedSearch->unsetSession();
		$this->revisedRpn->AdvancedSearch->unsetSession();
	}

	// Restore all search parameters
	protected function restoreSearchParms()
	{
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->load();

		// Restore advanced search values
		$this->fmea->AdvancedSearch->load();
		$this->idFactory->AdvancedSearch->load();
		$this->dateFmea->AdvancedSearch->load();
		$this->partnumbers->AdvancedSearch->load();
		$this->description->AdvancedSearch->load();
		$this->idEmployee->AdvancedSearch->load();
		$this->idworkcenter->AdvancedSearch->load();
		$this->idProcess->AdvancedSearch->load();
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
		$this->idCause->AdvancedSearch->load();
		$this->potentialCauses->AdvancedSearch->load();
		$this->currentPreventiveControlMethod->AdvancedSearch->load();
		$this->occurrence->AdvancedSearch->load();
		$this->currentControlMethod->AdvancedSearch->load();
		$this->detection->AdvancedSearch->load();
		$this->rpn->AdvancedSearch->load();
		$this->recomendedAction->AdvancedSearch->load();
		$this->idResponsible->AdvancedSearch->load();
		$this->targetDate->AdvancedSearch->load();
		$this->revisedKc->AdvancedSearch->load();
		$this->expectedSeverity->AdvancedSearch->load();
		$this->expectedOccurrence->AdvancedSearch->load();
		$this->expectedDetection->AdvancedSearch->load();
		$this->expectedRpn->AdvancedSearch->load();
		$this->expectedClosureDate->AdvancedSearch->load();
		$this->recomendedActiondet->AdvancedSearch->load();
		$this->idResponsibleDet->AdvancedSearch->load();
		$this->targetDatedet->AdvancedSearch->load();
		$this->kcdet->AdvancedSearch->load();
		$this->expectedSeveritydet->AdvancedSearch->load();
		$this->expectedOccurrencedet->AdvancedSearch->load();
		$this->expectedDetectiondet->AdvancedSearch->load();
		$this->expectedRpndet->AdvancedSearch->load();
		$this->revisedClosureDatedet->AdvancedSearch->load();
		$this->revisedClosureDate->AdvancedSearch->load();
		$this->perfomedAction->AdvancedSearch->load();
		$this->revisedSeverity->AdvancedSearch->load();
		$this->revisedOccurrence->AdvancedSearch->load();
		$this->revisedDetection->AdvancedSearch->load();
		$this->revisedRpn->AdvancedSearch->load();
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
			$this->updateSort($this->idFactory, $ctrl); // idFactory
			$this->updateSort($this->dateFmea, $ctrl); // dateFmea
			$this->updateSort($this->partnumbers, $ctrl); // partnumbers
			$this->updateSort($this->description, $ctrl); // description
			$this->updateSort($this->idEmployee, $ctrl); // idEmployee
			$this->updateSort($this->idworkcenter, $ctrl); // idworkcenter
			$this->updateSort($this->idProcess, $ctrl); // idProcess
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
			$this->updateSort($this->idCause, $ctrl); // idCause
			$this->updateSort($this->potentialCauses, $ctrl); // potentialCauses
			$this->updateSort($this->currentPreventiveControlMethod, $ctrl); // currentPreventiveControlMethod
			$this->updateSort($this->occurrence, $ctrl); // occurrence
			$this->updateSort($this->currentControlMethod, $ctrl); // currentControlMethod
			$this->updateSort($this->detection, $ctrl); // detection
			$this->updateSort($this->rpn, $ctrl); // rpn
			$this->updateSort($this->recomendedAction, $ctrl); // recomendedAction
			$this->updateSort($this->idResponsible, $ctrl); // idResponsible
			$this->updateSort($this->targetDate, $ctrl); // targetDate
			$this->updateSort($this->revisedKc, $ctrl); // revisedKc
			$this->updateSort($this->expectedSeverity, $ctrl); // expectedSeverity
			$this->updateSort($this->expectedOccurrence, $ctrl); // expectedOccurrence
			$this->updateSort($this->expectedDetection, $ctrl); // expectedDetection
			$this->updateSort($this->expectedRpn, $ctrl); // expectedRpn
			$this->updateSort($this->expectedClosureDate, $ctrl); // expectedClosureDate
			$this->updateSort($this->recomendedActiondet, $ctrl); // recomendedActiondet
			$this->updateSort($this->idResponsibleDet, $ctrl); // idResponsibleDet
			$this->updateSort($this->targetDatedet, $ctrl); // targetDatedet
			$this->updateSort($this->kcdet, $ctrl); // kcdet
			$this->updateSort($this->expectedSeveritydet, $ctrl); // expectedSeveritydet
			$this->updateSort($this->expectedOccurrencedet, $ctrl); // expectedOccurrencedet
			$this->updateSort($this->expectedDetectiondet, $ctrl); // expectedDetectiondet
			$this->updateSort($this->expectedRpndet, $ctrl); // expectedRpndet
			$this->updateSort($this->revisedClosureDatedet, $ctrl); // revisedClosureDatedet
			$this->updateSort($this->revisedClosureDate, $ctrl); // revisedClosureDate
			$this->updateSort($this->perfomedAction, $ctrl); // perfomedAction
			$this->updateSort($this->revisedSeverity, $ctrl); // revisedSeverity
			$this->updateSort($this->revisedOccurrence, $ctrl); // revisedOccurrence
			$this->updateSort($this->revisedDetection, $ctrl); // revisedDetection
			$this->updateSort($this->revisedRpn, $ctrl); // revisedRpn
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
				$this->fmea->setSort("");
				$this->idFactory->setSort("");
				$this->dateFmea->setSort("");
				$this->partnumbers->setSort("");
				$this->description->setSort("");
				$this->idEmployee->setSort("");
				$this->idworkcenter->setSort("");
				$this->idProcess->setSort("");
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
				$this->idCause->setSort("");
				$this->potentialCauses->setSort("");
				$this->currentPreventiveControlMethod->setSort("");
				$this->occurrence->setSort("");
				$this->currentControlMethod->setSort("");
				$this->detection->setSort("");
				$this->rpn->setSort("");
				$this->recomendedAction->setSort("");
				$this->idResponsible->setSort("");
				$this->targetDate->setSort("");
				$this->revisedKc->setSort("");
				$this->expectedSeverity->setSort("");
				$this->expectedOccurrence->setSort("");
				$this->expectedDetection->setSort("");
				$this->expectedRpn->setSort("");
				$this->expectedClosureDate->setSort("");
				$this->recomendedActiondet->setSort("");
				$this->idResponsibleDet->setSort("");
				$this->targetDatedet->setSort("");
				$this->kcdet->setSort("");
				$this->expectedSeveritydet->setSort("");
				$this->expectedOccurrencedet->setSort("");
				$this->expectedDetectiondet->setSort("");
				$this->expectedRpndet->setSort("");
				$this->revisedClosureDatedet->setSort("");
				$this->revisedClosureDate->setSort("");
				$this->perfomedAction->setSort("");
				$this->revisedSeverity->setSort("");
				$this->revisedOccurrence->setSort("");
				$this->revisedDetection->setSort("");
				$this->revisedRpn->setSort("");
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

		// Add group option item
		$item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canView();
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
		$item->Visible = FALSE;
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

		// "view"
		$opt = $this->ListOptions["view"];
		$viewcaption = HtmlTitle($Language->phrase("ViewLink"));
		if ($Security->canView()) {
			$opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode($this->ViewUrl) . "\">" . $Language->phrase("ViewLink") . "</a>";
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

		// "checkbox"
		$opt = $this->ListOptions["checkbox"];
		$opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->fmea->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->idCause->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

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
		$item->Body = "<a class=\"ew-save-filter\" data-form=\"freportfmealistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->add("deletefilter");
		$item->Body = "<a class=\"ew-delete-filter\" data-form=\"freportfmealistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
			$option = $options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == ACTION_MULTIPLE) {
					$item = &$option->add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode($listaction->Icon) . "\" data-caption=\"" . HtmlEncode($caption) . "\"></i> " . $caption : $caption;
					$item->Body = "<a class=\"ew-action ew-list-action\" title=\"" . HtmlEncode($caption) . "\" data-caption=\"" . HtmlEncode($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({f:document.freportfmealist}," . $listaction->toJson(TRUE) . "));\">" . $icon . "</a>";
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

		// idFactory
		if (!$this->isAddOrEdit() && $this->idFactory->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idFactory->AdvancedSearch->SearchValue != "" || $this->idFactory->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// dateFmea
		if (!$this->isAddOrEdit() && $this->dateFmea->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->dateFmea->AdvancedSearch->SearchValue != "" || $this->dateFmea->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// partnumbers
		if (!$this->isAddOrEdit() && $this->partnumbers->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->partnumbers->AdvancedSearch->SearchValue != "" || $this->partnumbers->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// description
		if (!$this->isAddOrEdit() && $this->description->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->description->AdvancedSearch->SearchValue != "" || $this->description->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// idEmployee
		if (!$this->isAddOrEdit() && $this->idEmployee->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idEmployee->AdvancedSearch->SearchValue != "" || $this->idEmployee->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// idworkcenter
		if (!$this->isAddOrEdit() && $this->idworkcenter->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idworkcenter->AdvancedSearch->SearchValue != "" || $this->idworkcenter->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// idProcess
		if (!$this->isAddOrEdit() && $this->idProcess->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->idProcess->AdvancedSearch->SearchValue != "" || $this->idProcess->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
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

		// rpn
		if (!$this->isAddOrEdit() && $this->rpn->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->rpn->AdvancedSearch->SearchValue != "" || $this->rpn->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
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

		// expectedRpndet
		if (!$this->isAddOrEdit() && $this->expectedRpndet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->expectedRpndet->AdvancedSearch->SearchValue != "" || $this->expectedRpndet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedClosureDatedet
		if (!$this->isAddOrEdit() && $this->revisedClosureDatedet->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedClosureDatedet->AdvancedSearch->SearchValue != "" || $this->revisedClosureDatedet->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// revisedClosureDate
		if (!$this->isAddOrEdit() && $this->revisedClosureDate->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->revisedClosureDate->AdvancedSearch->SearchValue != "" || $this->revisedClosureDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
				$this->Command = "search";
		}

		// perfomedAction
		if (!$this->isAddOrEdit() && $this->perfomedAction->AdvancedSearch->get()) {
			$got = TRUE;
			if (($this->perfomedAction->AdvancedSearch->SearchValue != "" || $this->perfomedAction->AdvancedSearch->SearchValue2 != "") && $this->Command == "")
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
		return $got;
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
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
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
		$this->fmea->setDbValue($row['fmea']);
		$this->idFactory->setDbValue($row['idFactory']);
		$this->dateFmea->setDbValue($row['dateFmea']);
		$this->partnumbers->setDbValue($row['partnumbers']);
		$this->description->setDbValue($row['description']);
		$this->idEmployee->setDbValue($row['idEmployee']);
		$this->idworkcenter->setDbValue($row['idworkcenter']);
		$this->idProcess->setDbValue($row['idProcess']);
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
		$this->idCause->setDbValue($row['idCause']);
		$this->potentialCauses->setDbValue($row['potentialCauses']);
		$this->currentPreventiveControlMethod->setDbValue($row['currentPreventiveControlMethod']);
		$this->occurrence->setDbValue($row['occurrence']);
		$this->currentControlMethod->setDbValue($row['currentControlMethod']);
		$this->detection->setDbValue($row['detection']);
		$this->rpn->setDbValue($row['rpn']);
		$this->recomendedAction->setDbValue($row['recomendedAction']);
		$this->idResponsible->setDbValue($row['idResponsible']);
		$this->targetDate->setDbValue($row['targetDate']);
		$this->revisedKc->setDbValue($row['revisedKc']);
		$this->expectedSeverity->setDbValue($row['expectedSeverity']);
		$this->expectedOccurrence->setDbValue($row['expectedOccurrence']);
		$this->expectedDetection->setDbValue($row['expectedDetection']);
		$this->expectedRpn->setDbValue($row['expectedRpn']);
		$this->expectedClosureDate->setDbValue($row['expectedClosureDate']);
		$this->recomendedActiondet->setDbValue($row['recomendedActiondet']);
		$this->idResponsibleDet->setDbValue($row['idResponsibleDet']);
		$this->targetDatedet->setDbValue($row['targetDatedet']);
		$this->kcdet->setDbValue($row['kcdet']);
		$this->expectedSeveritydet->setDbValue($row['expectedSeveritydet']);
		$this->expectedOccurrencedet->setDbValue($row['expectedOccurrencedet']);
		$this->expectedDetectiondet->setDbValue($row['expectedDetectiondet']);
		$this->expectedRpndet->setDbValue($row['expectedRpndet']);
		$this->revisedClosureDatedet->setDbValue($row['revisedClosureDatedet']);
		$this->revisedClosureDate->setDbValue($row['revisedClosureDate']);
		$this->perfomedAction->setDbValue($row['perfomedAction']);
		$this->revisedSeverity->setDbValue($row['revisedSeverity']);
		$this->revisedOccurrence->setDbValue($row['revisedOccurrence']);
		$this->revisedDetection->setDbValue($row['revisedDetection']);
		$this->revisedRpn->setDbValue($row['revisedRpn']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$row = [];
		$row['fmea'] = NULL;
		$row['idFactory'] = NULL;
		$row['dateFmea'] = NULL;
		$row['partnumbers'] = NULL;
		$row['description'] = NULL;
		$row['idEmployee'] = NULL;
		$row['idworkcenter'] = NULL;
		$row['idProcess'] = NULL;
		$row['step'] = NULL;
		$row['flowchartDesc'] = NULL;
		$row['partnumber'] = NULL;
		$row['operation'] = NULL;
		$row['derivedFromNC'] = NULL;
		$row['numberOfNC'] = NULL;
		$row['flowchart'] = NULL;
		$row['subprocess'] = NULL;
		$row['requirement'] = NULL;
		$row['potencialFailureMode'] = NULL;
		$row['potencialFailurEffect'] = NULL;
		$row['kc'] = NULL;
		$row['severity'] = NULL;
		$row['idCause'] = NULL;
		$row['potentialCauses'] = NULL;
		$row['currentPreventiveControlMethod'] = NULL;
		$row['occurrence'] = NULL;
		$row['currentControlMethod'] = NULL;
		$row['detection'] = NULL;
		$row['rpn'] = NULL;
		$row['recomendedAction'] = NULL;
		$row['idResponsible'] = NULL;
		$row['targetDate'] = NULL;
		$row['revisedKc'] = NULL;
		$row['expectedSeverity'] = NULL;
		$row['expectedOccurrence'] = NULL;
		$row['expectedDetection'] = NULL;
		$row['expectedRpn'] = NULL;
		$row['expectedClosureDate'] = NULL;
		$row['recomendedActiondet'] = NULL;
		$row['idResponsibleDet'] = NULL;
		$row['targetDatedet'] = NULL;
		$row['kcdet'] = NULL;
		$row['expectedSeveritydet'] = NULL;
		$row['expectedOccurrencedet'] = NULL;
		$row['expectedDetectiondet'] = NULL;
		$row['expectedRpndet'] = NULL;
		$row['revisedClosureDatedet'] = NULL;
		$row['revisedClosureDate'] = NULL;
		$row['perfomedAction'] = NULL;
		$row['revisedSeverity'] = NULL;
		$row['revisedOccurrence'] = NULL;
		$row['revisedDetection'] = NULL;
		$row['revisedRpn'] = NULL;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("fmea")) != "")
			$this->fmea->OldValue = $this->getKey("fmea"); // fmea
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
		// fmea
		// idFactory
		// dateFmea
		// partnumbers
		// description
		// idEmployee
		// idworkcenter
		// idProcess
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
		// idCause
		// potentialCauses
		// currentPreventiveControlMethod
		// occurrence
		// currentControlMethod
		// detection
		// rpn
		// recomendedAction
		// idResponsible
		// targetDate
		// revisedKc
		// expectedSeverity
		// expectedOccurrence
		// expectedDetection
		// expectedRpn
		// expectedClosureDate
		// recomendedActiondet
		// idResponsibleDet
		// targetDatedet
		// kcdet
		// expectedSeveritydet
		// expectedOccurrencedet
		// expectedDetectiondet
		// expectedRpndet
		// revisedClosureDatedet
		// revisedClosureDate
		// perfomedAction
		// revisedSeverity
		// revisedOccurrence
		// revisedDetection
		// revisedRpn

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// fmea
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
			$this->fmea->ViewCustomAttributes = "";

			// idFactory
			$curVal = strval($this->idFactory->CurrentValue);
			if ($curVal != "") {
				$this->idFactory->ViewValue = $this->idFactory->lookupCacheOption($curVal);
				if ($this->idFactory->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idFactory`" . SearchString("=", $curVal, DATATYPE_STRING, "");
					$sqlWrk = $this->idFactory->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->idFactory->ViewValue = $this->idFactory->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idFactory->ViewValue = $this->idFactory->CurrentValue;
					}
				}
			} else {
				$this->idFactory->ViewValue = NULL;
			}
			$this->idFactory->ViewCustomAttributes = "";

			// dateFmea
			$this->dateFmea->ViewValue = $this->dateFmea->CurrentValue;
			$this->dateFmea->ViewValue = FormatDateTime($this->dateFmea->ViewValue, 0);
			$this->dateFmea->ViewCustomAttributes = "";

			// partnumbers
			$this->partnumbers->ViewValue = $this->partnumbers->CurrentValue;
			$this->partnumbers->ViewCustomAttributes = "";

			// description
			$this->description->ViewValue = $this->description->CurrentValue;
			$this->description->ViewCustomAttributes = "";

			// idEmployee
			$curVal = strval($this->idEmployee->CurrentValue);
			if ($curVal != "") {
				$this->idEmployee->ViewValue = $this->idEmployee->lookupCacheOption($curVal);
				if ($this->idEmployee->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idEmployee`" . SearchString("=", $curVal, DATATYPE_STRING, "");
					$sqlWrk = $this->idEmployee->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->idEmployee->ViewValue = $this->idEmployee->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idEmployee->ViewValue = $this->idEmployee->CurrentValue;
					}
				}
			} else {
				$this->idEmployee->ViewValue = NULL;
			}
			$this->idEmployee->ViewCustomAttributes = "";

			// idworkcenter
			$curVal = strval($this->idworkcenter->CurrentValue);
			if ($curVal != "") {
				$this->idworkcenter->ViewValue = $this->idworkcenter->lookupCacheOption($curVal);
				if ($this->idworkcenter->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`workcenter`" . SearchString("=", $curVal, DATATYPE_STRING, "");
					$sqlWrk = $this->idworkcenter->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->idworkcenter->ViewValue = $this->idworkcenter->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idworkcenter->ViewValue = $this->idworkcenter->CurrentValue;
					}
				}
			} else {
				$this->idworkcenter->ViewValue = NULL;
			}
			$this->idworkcenter->ViewCustomAttributes = "";

			// idProcess
			$this->idProcess->ViewValue = $this->idProcess->CurrentValue;
			$this->idProcess->ViewCustomAttributes = "";

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

			// idCause
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
			$this->idCause->ViewCustomAttributes = "";

			// potentialCauses
			$this->potentialCauses->ViewValue = $this->potentialCauses->CurrentValue;
			$this->potentialCauses->ViewCustomAttributes = "";

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->ViewValue = $this->currentPreventiveControlMethod->CurrentValue;
			$this->currentPreventiveControlMethod->ViewCustomAttributes = "";

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

			// rpn
			$this->rpn->ViewValue = $this->rpn->CurrentValue;
			$this->rpn->ViewValue = FormatNumber($this->rpn->ViewValue, 0, -2, -2, -2);
			$this->rpn->ViewCustomAttributes = "";

			// recomendedAction
			$this->recomendedAction->ViewValue = $this->recomendedAction->CurrentValue;
			$this->recomendedAction->ViewCustomAttributes = "";

			// idResponsible
			$this->idResponsible->ViewValue = $this->idResponsible->CurrentValue;
			$this->idResponsible->ViewCustomAttributes = "";

			// targetDate
			$this->targetDate->ViewValue = $this->targetDate->CurrentValue;
			$this->targetDate->ViewValue = FormatDateTime($this->targetDate->ViewValue, 0);
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

			// expectedRpn
			$this->expectedRpn->ViewValue = $this->expectedRpn->CurrentValue;
			$this->expectedRpn->ViewValue = FormatNumber($this->expectedRpn->ViewValue, 0, -2, -2, -2);
			$this->expectedRpn->ViewCustomAttributes = "";

			// expectedClosureDate
			$this->expectedClosureDate->ViewValue = $this->expectedClosureDate->CurrentValue;
			$this->expectedClosureDate->ViewValue = FormatDateTime($this->expectedClosureDate->ViewValue, 0);
			$this->expectedClosureDate->ViewCustomAttributes = "";

			// recomendedActiondet
			$this->recomendedActiondet->ViewValue = $this->recomendedActiondet->CurrentValue;
			$this->recomendedActiondet->ViewCustomAttributes = "";

			// idResponsibleDet
			$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->CurrentValue;
			$this->idResponsibleDet->ViewCustomAttributes = "";

			// targetDatedet
			$this->targetDatedet->ViewValue = $this->targetDatedet->CurrentValue;
			$this->targetDatedet->ViewValue = FormatDateTime($this->targetDatedet->ViewValue, 0);
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

			// expectedRpndet
			$this->expectedRpndet->ViewValue = $this->expectedRpndet->CurrentValue;
			$this->expectedRpndet->ViewValue = FormatNumber($this->expectedRpndet->ViewValue, 0, -2, -2, -2);
			$this->expectedRpndet->ViewCustomAttributes = "";

			// revisedClosureDatedet
			$this->revisedClosureDatedet->ViewValue = $this->revisedClosureDatedet->CurrentValue;
			$this->revisedClosureDatedet->ViewValue = FormatDateTime($this->revisedClosureDatedet->ViewValue, 0);
			$this->revisedClosureDatedet->ViewCustomAttributes = "";

			// revisedClosureDate
			$this->revisedClosureDate->ViewValue = $this->revisedClosureDate->CurrentValue;
			$this->revisedClosureDate->ViewValue = FormatDateTime($this->revisedClosureDate->ViewValue, 0);
			$this->revisedClosureDate->ViewCustomAttributes = "";

			// perfomedAction
			$this->perfomedAction->ViewValue = $this->perfomedAction->CurrentValue;
			$this->perfomedAction->ViewCustomAttributes = "";

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

			// revisedRpn
			$this->revisedRpn->ViewValue = $this->revisedRpn->CurrentValue;
			$this->revisedRpn->ViewValue = FormatNumber($this->revisedRpn->ViewValue, 0, -2, -2, -2);
			$this->revisedRpn->ViewCustomAttributes = "";

			// fmea
			$this->fmea->LinkCustomAttributes = "";
			$this->fmea->HrefValue = "";
			$this->fmea->TooltipValue = "";

			// idFactory
			$this->idFactory->LinkCustomAttributes = "";
			$this->idFactory->HrefValue = "";
			$this->idFactory->TooltipValue = "";

			// dateFmea
			$this->dateFmea->LinkCustomAttributes = "";
			$this->dateFmea->HrefValue = "";
			$this->dateFmea->TooltipValue = "";

			// partnumbers
			$this->partnumbers->LinkCustomAttributes = "";
			$this->partnumbers->HrefValue = "";
			$this->partnumbers->TooltipValue = "";
			if (!$this->isExport())
				$this->partnumbers->ViewValue = $this->highlightValue($this->partnumbers);

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";
			if (!$this->isExport())
				$this->description->ViewValue = $this->highlightValue($this->description);

			// idEmployee
			$this->idEmployee->LinkCustomAttributes = "";
			$this->idEmployee->HrefValue = "";
			$this->idEmployee->TooltipValue = "";

			// idworkcenter
			$this->idworkcenter->LinkCustomAttributes = "";
			$this->idworkcenter->HrefValue = "";
			$this->idworkcenter->TooltipValue = "";

			// idProcess
			$this->idProcess->LinkCustomAttributes = "";
			$this->idProcess->HrefValue = "";
			$this->idProcess->TooltipValue = "";
			if (!$this->isExport())
				$this->idProcess->ViewValue = $this->highlightValue($this->idProcess);

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

			// idCause
			$this->idCause->LinkCustomAttributes = "";
			$this->idCause->HrefValue = "";
			$this->idCause->TooltipValue = "";

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

			// rpn
			$this->rpn->LinkCustomAttributes = "";
			$this->rpn->HrefValue = "";
			$this->rpn->TooltipValue = "";

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

			// expectedRpn
			$this->expectedRpn->LinkCustomAttributes = "";
			$this->expectedRpn->HrefValue = "";
			$this->expectedRpn->TooltipValue = "";

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

			// expectedRpndet
			$this->expectedRpndet->LinkCustomAttributes = "";
			$this->expectedRpndet->HrefValue = "";
			$this->expectedRpndet->TooltipValue = "";

			// revisedClosureDatedet
			$this->revisedClosureDatedet->LinkCustomAttributes = "";
			$this->revisedClosureDatedet->HrefValue = "";
			$this->revisedClosureDatedet->TooltipValue = "";

			// revisedClosureDate
			$this->revisedClosureDate->LinkCustomAttributes = "";
			$this->revisedClosureDate->HrefValue = "";
			$this->revisedClosureDate->TooltipValue = "";

			// perfomedAction
			$this->perfomedAction->LinkCustomAttributes = "";
			$this->perfomedAction->HrefValue = "";
			$this->perfomedAction->TooltipValue = "";
			if (!$this->isExport())
				$this->perfomedAction->ViewValue = $this->highlightValue($this->perfomedAction);

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

			// revisedRpn
			$this->revisedRpn->LinkCustomAttributes = "";
			$this->revisedRpn->HrefValue = "";
			$this->revisedRpn->TooltipValue = "";
		}

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

	// Load advanced search
	public function loadAdvancedSearch()
	{
		$this->fmea->AdvancedSearch->load();
		$this->idFactory->AdvancedSearch->load();
		$this->dateFmea->AdvancedSearch->load();
		$this->partnumbers->AdvancedSearch->load();
		$this->description->AdvancedSearch->load();
		$this->idEmployee->AdvancedSearch->load();
		$this->idworkcenter->AdvancedSearch->load();
		$this->idProcess->AdvancedSearch->load();
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
		$this->idCause->AdvancedSearch->load();
		$this->potentialCauses->AdvancedSearch->load();
		$this->currentPreventiveControlMethod->AdvancedSearch->load();
		$this->occurrence->AdvancedSearch->load();
		$this->currentControlMethod->AdvancedSearch->load();
		$this->detection->AdvancedSearch->load();
		$this->rpn->AdvancedSearch->load();
		$this->recomendedAction->AdvancedSearch->load();
		$this->idResponsible->AdvancedSearch->load();
		$this->targetDate->AdvancedSearch->load();
		$this->revisedKc->AdvancedSearch->load();
		$this->expectedSeverity->AdvancedSearch->load();
		$this->expectedOccurrence->AdvancedSearch->load();
		$this->expectedDetection->AdvancedSearch->load();
		$this->expectedRpn->AdvancedSearch->load();
		$this->expectedClosureDate->AdvancedSearch->load();
		$this->recomendedActiondet->AdvancedSearch->load();
		$this->idResponsibleDet->AdvancedSearch->load();
		$this->targetDatedet->AdvancedSearch->load();
		$this->kcdet->AdvancedSearch->load();
		$this->expectedSeveritydet->AdvancedSearch->load();
		$this->expectedOccurrencedet->AdvancedSearch->load();
		$this->expectedDetectiondet->AdvancedSearch->load();
		$this->expectedRpndet->AdvancedSearch->load();
		$this->revisedClosureDatedet->AdvancedSearch->load();
		$this->revisedClosureDate->AdvancedSearch->load();
		$this->perfomedAction->AdvancedSearch->load();
		$this->revisedSeverity->AdvancedSearch->load();
		$this->revisedOccurrence->AdvancedSearch->load();
		$this->revisedDetection->AdvancedSearch->load();
		$this->revisedRpn->AdvancedSearch->load();
	}

	// Get export HTML tag
	protected function getExportTag($type, $custom = FALSE)
	{
		global $Language;
		if (SameText($type, "excel")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.freportfmealist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
			else
				return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
		} elseif (SameText($type, "word")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.freportfmealist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
			else
				return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
		} elseif (SameText($type, "pdf")) {
			if ($custom)
				return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.freportfmealist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
			return '<button id="emf_reportfmea" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_reportfmea\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.freportfmealist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
		$item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"freportfmealistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->add("showall");
		$item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $this->pageUrl() . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->add("advancedsearch");
		if (IsMobile())
			$item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"reportfmeasrch.php\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<a class=\"btn btn-default ew-advanced-search\" title=\"" . $Language->phrase("AdvancedSearch") . "\" data-table=\"reportfmea\" data-caption=\"" . $Language->phrase("AdvancedSearch") . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'SearchBtn',url:'reportfmeasrch.php'});\">" . $Language->phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->add("searchhighlight");
		$item->Body = "<a class=\"btn btn-default ew-highlight active\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("Highlight") . "\" data-caption=\"" . $Language->phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"freportfmealistsrch\" data-name=\"" . $this->highlightName() . "\">" . $Language->phrase("HighlightBtn") . "</a>";
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
				case "x_idFactory":
					break;
				case "x_idEmployee":
					break;
				case "x_idworkcenter":
					break;
				case "x_derivedFromNC":
					break;
				case "x_kc":
					break;
				case "x_idCause":
					break;
				case "x_revisedKc":
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
						case "x_fmea":
							break;
						case "x_idFactory":
							break;
						case "x_idEmployee":
							break;
						case "x_idworkcenter":
							break;
						case "x_idCause":
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