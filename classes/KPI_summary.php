<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class KPI_summary extends KPI
{

	// Page ID
	public $PageID = "summary";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'KPI';

	// Page object name
	public $PageObjName = "KPI_summary";

	// CSS
	public $ReportTableClass = "";
	public $ReportTableStyle = "";

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

		// Table object (KPI)
		if (!isset($GLOBALS["KPI"]) || get_class($GLOBALS["KPI"]) == PROJECT_NAMESPACE . "KPI") {
			$GLOBALS["KPI"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["KPI"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->pageUrl() . "export=print";
		$this->ExportExcelUrl = $this->pageUrl() . "export=excel";
		$this->ExportWordUrl = $this->pageUrl() . "export=word";
		$this->ExportPdfUrl = $this->pageUrl() . "export=pdf";

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'summary');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'KPI');

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

		// Export options
		$this->ExportOptions = new ListOptions("div");
		$this->ExportOptions->TagClassName = "ew-export-option";

		// Filter options
		$this->FilterOptions = new ListOptions("div");
		$this->FilterOptions->TagClassName = "ew-filter-option fsummary";
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
		if ($this->isExport() && !$this->isExport("print") && $fn = Config("REPORT_EXPORT_FUNCTIONS." . $this->Export)) {
			$content = ob_get_clean();
			$this->$fn($content);
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection if not in dashboard
		if (!$DashboardReport)
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

		// Exit if not in dashboard
		if (!$DashboardReport)
			exit();
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
		if (in_array($lookup->LinkTable, [$this->ReportSourceTable, $this->TableVar]))
			$lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
		$lookup->RenderEditFunc = ""; // Set up edit renderer

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

	// Initialize common variables
	public $HideOptions = FALSE;
	public $ExportOptions; // Export options
	public $SearchOptions; // Search options
	public $FilterOptions; // Filter options

	// Records
	public $GroupRecords = [];
	public $DetailRecords = [];
	public $DetailRecordCount = 0;

	// Paging variables
	public $RecordIndex = 0; // Record index
	public $RecordCount = 0; // Record count (start from 1 for each group)
	public $StartGroup = 0; // Start group
	public $StopGroup = 0; // Stop group
	public $TotalGroups = 0; // Total groups
	public $GroupCount = 0; // Group count
	public $GroupCounter = []; // Group counter
	public $DisplayGroups = 1; // Groups per page
	public $GroupRange = 10;
	public $PageSizes = "1,3,10,20,50,-1"; // Page sizes (comma separated)
	public $Sort = "";
	public $Filter = "";
	public $PageFirstGroupFilter = "";
	public $UserIDFilter = "";
	public $DefaultSearchWhere = ""; // Default search WHERE clause
	public $SearchWhere = "";
	public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
	public $SearchRowCount = 0; // For extended search
	public $SearchColumnCount = 0; // For extended search
	public $SearchFieldsPerRow = 1; // For extended search
	public $DrillDownList = "";
	public $DbMasterFilter = ""; // Master filter
	public $DbDetailFilter = ""; // Detail filter
	public $SearchCommand = FALSE;
	public $ShowHeader;
	public $GroupColumnCount = 0;
	public $SubGroupColumnCount = 0;
	public $DetailColumnCount = 0;
	public $TotalCount;
	public $PageTotalCount;
	public $TopContentClass = "col-sm-12 ew-top";
	public $LeftContentClass = "ew-left";
	public $CenterContentClass = "col-sm-6 ew-center";
	public $RightContentClass = "col-sm-6 ew-right";
	public $BottomContentClass = "col-sm-12 ew-bottom";

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $ExportFileName, $Language, $Security, $UserProfile,
			$Security, $FormError, $DrillDownInPanel, $Breadcrumb,
			$DashboardReport, $CustomExportType, $ReportExportType;

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
			if (!$Security->canReport()) {
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
		}
		$ExportFileName = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->isExport() && $custom != "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$CustomExportType = $this->CustomExport;
		$ExportType = $this->Export; // Get export parameter, used in header
		$ReportExportType = $ExportType; // Report export type, used in header

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

		// Setup export options
		$this->setupExportOptions();

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

		// Set up table class
		if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf"))
			$this->ReportTableClass = "ew-table";
		else
			$this->ReportTableClass = "table ew-table";

		// Set field visibility for detail fields
		$this->idFactory->setVisibility();
		$this->dateFmea->setVisibility();
		$this->idworkcenter->setVisibility();
		$this->idProcess->setVisibility();
		$this->step->setVisibility();
		$this->flowchartDesc->setVisibility();
		$this->partnumber->setVisibility();
		$this->operation->setVisibility();
		$this->flowchart->setVisibility();
		$this->severity->setVisibility();
		$this->idCause->setVisibility();
		$this->potentialCauses->setVisibility();
		$this->occurrence->setVisibility();
		$this->detection->setVisibility();
		$this->rpn->setVisibility();
		$this->recomendedAction->setVisibility();
		$this->idResponsible->setVisibility();

		// Set up groups per page dynamically
		$this->setupDisplayGroups();

		// Set up Breadcrumb
		if (!$this->isExport())
			$this->setupBreadcrumb();

		// Check if search command
		$this->SearchCommand = (Get("cmd", "") == "search");

		// Load custom filters
		$this->Page_FilterLoad();

		// Extended filter
		$extendedFilter = "";

		// Restore filter list
		$this->restoreFilterList();

		// Build extended filter
		$extendedFilter = $this->getExtendedFilter();
		AddFilter($this->SearchWhere, $extendedFilter);

		// Call Page Selecting event
		$this->Page_Selecting($this->SearchWhere);

		// Search options
		$this->setupSearchOptions();

		// Set up search panel class
		if ($this->SearchWhere != "")
			AppendClass($this->SearchPanelClass, "show");

		// Get sort
		$this->Sort = $this->getSort();

		// Update filter
		AddFilter($this->Filter, $this->SearchWhere);

		// Get total group count
		$sql = BuildReportSql($this->getSqlSelectGroup(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
		$this->TotalGroups = $this->getRecordCount($sql);
		if ($this->DisplayGroups <= 0 || $this->DrillDown || $DashboardReport) // Display all groups
			$this->DisplayGroups = $this->TotalGroups;
		$this->StartGroup = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGroups > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->isExport())
			$this->DisplayGroups = $this->TotalGroups;
		else
			$this->setupStartGroup();

		// Set no record found message
		if ($this->TotalGroups == 0) {
			if ($Security->canList()) {
				if ($this->SearchWhere == "0=101") {
					$this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($Language->phrase("NoRecord"));
				}
			} else {
				$this->setWarningMessage(DeniedMessage());
			}
		}

		// Hide export options if export/dashboard report/hide options
		if ($this->isExport() || $DashboardReport || $this->HideOptions)
			$this->ExportOptions->hideAllOptions();

		// Hide search/filter options if export/drilldown/dashboard report/hide options
		if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
			$this->SearchOptions->hideAllOptions();
			$this->FilterOptions->hideAllOptions();
		}

		// Get group records
		if ($this->TotalGroups > 0) {
			$grpSort = UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
			$sql = BuildReportSql($this->getSqlSelectGroup(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
			$grpRs = $this->getRecordset($sql, $this->DisplayGroups, $this->StartGroup - 1);
			$this->GroupRecords = $grpRs->getRows(); // Get records of first grouping field
			$this->loadGroupRowValues();
			$this->GroupCount = 1;
		}

		// Init detail records
		$this->DetailRecords = [];
		$this->setupFieldCount();

		// Set the last group to display if not export all
		if ($this->ExportAll && $this->isExport()) {
			$this->StopGroup = $this->TotalGroups;
		} else {
			$this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
		}

		// Stop group <= total number of groups
		if (intval($this->StopGroup) > intval($this->TotalGroups))
			$this->StopGroup = $this->TotalGroups;
		$this->RecordCount = 0;
		$this->RecordIndex = 0;

		// Set up pager
		$this->Pager = new PrevNextPager($this->StartGroup, $this->DisplayGroups, $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
	}

	// Load group row values
	public function loadGroupRowValues()
	{
		$cnt = count($this->GroupRecords); // Get record count
		if ($this->GroupCount < $cnt)
			$this->fmea->setGroupValue($this->GroupRecords[$this->GroupCount][0]);
		else
			$this->fmea->setGroupValue("");
	}

	// Load row values
	public function loadRowValues($record)
	{
		if ($this->RecordIndex == 1) { // Load first row data
			$data = [];
			$data["fmea"] = $record['fmea'];
			$data["idFactory"] = $record['idFactory'];
			$data["dateFmea"] = $record['dateFmea'];
			$data["idEmployee"] = $record['idEmployee'];
			$data["idworkcenter"] = $record['idworkcenter'];
			$data["idProcess"] = $record['idProcess'];
			$data["step"] = $record['step'];
			$data["partnumber"] = $record['partnumber'];
			$data["operation"] = $record['operation'];
			$data["derivedFromNC"] = $record['derivedFromNC'];
			$data["numberOfNC"] = $record['numberOfNC'];
			$data["flowchart"] = $record['flowchart'];
			$data["subprocess"] = $record['subprocess'];
			$data["requirement"] = $record['requirement'];
			$data["potencialFailureMode"] = $record['potencialFailureMode'];
			$data["potencialFailurEffect"] = $record['potencialFailurEffect'];
			$data["kc"] = $record['kc'];
			$data["severity"] = $record['severity'];
			$data["idCause"] = $record['idCause'];
			$data["currentPreventiveControlMethod"] = $record['currentPreventiveControlMethod'];
			$data["occurrence"] = $record['occurrence'];
			$data["currentControlMethod"] = $record['currentControlMethod'];
			$data["detection"] = $record['detection'];
			$data["rpn"] = $record['rpn'];
			$data["idResponsible"] = $record['idResponsible'];
			$data["targetDate"] = $record['targetDate'];
			$data["revisedKc"] = $record['revisedKc'];
			$data["expectedSeverity"] = $record['expectedSeverity'];
			$data["expectedOccurrence"] = $record['expectedOccurrence'];
			$data["expectedDetection"] = $record['expectedDetection'];
			$data["expectedRpn"] = $record['expectedRpn'];
			$data["expectedClosureDate"] = $record['expectedClosureDate'];
			$data["idResponsibleDet"] = $record['idResponsibleDet'];
			$data["targetDatedet"] = $record['targetDatedet'];
			$data["kcdet"] = $record['kcdet'];
			$data["expectedSeveritydet"] = $record['expectedSeveritydet'];
			$data["expectedOccurrencedet"] = $record['expectedOccurrencedet'];
			$data["expectedDetectiondet"] = $record['expectedDetectiondet'];
			$data["expectedRpndet"] = $record['expectedRpndet'];
			$data["revisedClosureDatedet"] = $record['revisedClosureDatedet'];
			$data["revisedClosureDate"] = $record['revisedClosureDate'];
			$data["revisedSeverity"] = $record['revisedSeverity'];
			$data["revisedOccurrence"] = $record['revisedOccurrence'];
			$data["revisedDetection"] = $record['revisedDetection'];
			$data["revisedRpn"] = $record['revisedRpn'];
			$this->Rows[] = $data;
		}
		$this->fmea->setDbValue(GroupValue($this->fmea, $record['fmea']));
		$this->idFactory->setDbValue($record['idFactory']);
		$this->dateFmea->setDbValue($record['dateFmea']);
		$this->partnumbers->setDbValue($record['partnumbers']);
		$this->description->setDbValue($record['description']);
		$this->idEmployee->setDbValue($record['idEmployee']);
		$this->idworkcenter->setDbValue($record['idworkcenter']);
		$this->idProcess->setDbValue($record['idProcess']);
		$this->step->setDbValue($record['step']);
		$this->flowchartDesc->setDbValue($record['flowchartDesc']);
		$this->partnumber->setDbValue($record['partnumber']);
		$this->operation->setDbValue($record['operation']);
		$this->derivedFromNC->setDbValue($record['derivedFromNC']);
		$this->numberOfNC->setDbValue($record['numberOfNC']);
		$this->flowchart->setDbValue($record['flowchart']);
		$this->subprocess->setDbValue($record['subprocess']);
		$this->requirement->setDbValue($record['requirement']);
		$this->potencialFailureMode->setDbValue($record['potencialFailureMode']);
		$this->potencialFailurEffect->setDbValue($record['potencialFailurEffect']);
		$this->kc->setDbValue($record['kc']);
		$this->severity->setDbValue($record['severity']);
		$this->idCause->setDbValue($record['idCause']);
		$this->potentialCauses->setDbValue($record['potentialCauses']);
		$this->currentPreventiveControlMethod->setDbValue($record['currentPreventiveControlMethod']);
		$this->occurrence->setDbValue($record['occurrence']);
		$this->currentControlMethod->setDbValue($record['currentControlMethod']);
		$this->detection->setDbValue($record['detection']);
		$this->rpn->setDbValue($record['rpn']);
		$this->recomendedAction->setDbValue($record['recomendedAction']);
		$this->idResponsible->setDbValue($record['idResponsible']);
		$this->targetDate->setDbValue($record['targetDate']);
		$this->revisedKc->setDbValue($record['revisedKc']);
		$this->expectedSeverity->setDbValue($record['expectedSeverity']);
		$this->expectedOccurrence->setDbValue($record['expectedOccurrence']);
		$this->expectedDetection->setDbValue($record['expectedDetection']);
		$this->expectedRpn->setDbValue($record['expectedRpn']);
		$this->expectedClosureDate->setDbValue($record['expectedClosureDate']);
		$this->recomendedActiondet->setDbValue($record['recomendedActiondet']);
		$this->idResponsibleDet->setDbValue($record['idResponsibleDet']);
		$this->targetDatedet->setDbValue($record['targetDatedet']);
		$this->kcdet->setDbValue($record['kcdet']);
		$this->expectedSeveritydet->setDbValue($record['expectedSeveritydet']);
		$this->expectedOccurrencedet->setDbValue($record['expectedOccurrencedet']);
		$this->expectedDetectiondet->setDbValue($record['expectedDetectiondet']);
		$this->expectedRpndet->setDbValue($record['expectedRpndet']);
		$this->revisedClosureDatedet->setDbValue($record['revisedClosureDatedet']);
		$this->revisedClosureDate->setDbValue($record['revisedClosureDate']);
		$this->perfomedAction->setDbValue($record['perfomedAction']);
		$this->revisedSeverity->setDbValue($record['revisedSeverity']);
		$this->revisedOccurrence->setDbValue($record['revisedOccurrence']);
		$this->revisedDetection->setDbValue($record['revisedDetection']);
		$this->revisedRpn->setDbValue($record['revisedRpn']);
	}

	// Render row
	public function renderRow()
	{
		global $Security, $Language, $Language;
		$conn = $this->getConnection();
		if ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_PAGE) { // Get Page total

			// Build detail SQL
			$firstGrpFld = &$this->fmea;
			$firstGrpFld->getDistinctValues($this->GroupRecords);
			$where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
			if ($this->Filter != "")
				$where = "($this->Filter) AND ($where)";
			$sql = BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
			$rs = $this->getRecordset($sql);
			$records = $rs ? $rs->getRows() : [];
			$this->idCause->getCnt($records);
			$this->PageTotalCount = count($records);
		} elseif ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_GRAND) { // Get Grand total
			$hasCount = FALSE;
			$hasSummary = FALSE;

			// Get total count from SQL directly
			$sql = BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->execute($sql);
			if ($rstot) {
				$cnt = ($rstot->recordCount() > 1) ? $rstot->recordCount() : $rstot->fields[0];
				$rstot->close();
				$hasCount = TRUE;
			} else {
				$cnt = 0;
			}
			$this->TotalCount = $cnt;

			// Get total from SQL directly
			$sql = BuildReportSql($this->getSqlSelectAggregate(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$sql = $this->getSqlAggregatePrefix() . $sql . $this->getSqlAggregateSuffix();
			$rsagg = $conn->execute($sql);
			if ($rsagg) {
				$this->idFactory->Count = $this->TotalCount;
				$this->dateFmea->Count = $this->TotalCount;
				$this->idworkcenter->Count = $this->TotalCount;
				$this->idProcess->Count = $this->TotalCount;
				$this->step->Count = $this->TotalCount;
				$this->flowchartDesc->Count = $this->TotalCount;
				$this->partnumber->Count = $this->TotalCount;
				$this->operation->Count = $this->TotalCount;
				$this->flowchart->Count = $this->TotalCount;
				$this->severity->Count = $this->TotalCount;
				$this->idCause->Count = $this->TotalCount;
				$this->idCause->CntValue = $rsagg->fields("cnt_idcause");
				$this->potentialCauses->Count = $this->TotalCount;
				$this->occurrence->Count = $this->TotalCount;
				$this->detection->Count = $this->TotalCount;
				$this->rpn->Count = $this->TotalCount;
				$this->recomendedAction->Count = $this->TotalCount;
				$this->idResponsible->Count = $this->TotalCount;
				$rsagg->close();
				$hasSummary = TRUE;
			}

			// Accumulate grand summary from detail records
			if (!$hasCount || !$hasSummary) {
				$sql = BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $this->getRecordset($sql);
				$this->DetailRecords = $rs ? $rs->getRows() : [];
			$this->idCause->getCnt($this->DetailRecords);
			}
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		// fmea
		// idFactory
		// dateFmea
		// idworkcenter
		// idProcess
		// step
		// flowchartDesc
		// partnumber
		// operation
		// flowchart
		// severity
		// idCause
		// potentialCauses
		// occurrence
		// detection
		// rpn
		// recomendedAction
		// idResponsible

		if ($this->RowType == ROWTYPE_SEARCH) { // Search row

			// fmea
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			$curVal = trim(strval($this->fmea->AdvancedSearch->SearchValue));
			if ($curVal != "")
				$this->fmea->AdvancedSearch->ViewValue = $this->fmea->lookupCacheOption($curVal);
			else
				$this->fmea->AdvancedSearch->ViewValue = $this->fmea->Lookup !== NULL && is_array($this->fmea->Lookup->Options) ? $curVal : NULL;
			if ($this->fmea->AdvancedSearch->ViewValue !== NULL) { // Load from cache
				$this->fmea->EditValue = array_values($this->fmea->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`fmea`" . SearchString("=", $this->fmea->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->fmea->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->fmea->EditValue = $arwrk;
			}

			// idFactory
			$this->idFactory->EditAttrs["class"] = "form-control";
			$this->idFactory->EditCustomAttributes = "";
			$curVal = trim(strval($this->idFactory->AdvancedSearch->SearchValue));
			if ($curVal != "")
				$this->idFactory->AdvancedSearch->ViewValue = $this->idFactory->lookupCacheOption($curVal);
			else
				$this->idFactory->AdvancedSearch->ViewValue = $this->idFactory->Lookup !== NULL && is_array($this->idFactory->Lookup->Options) ? $curVal : NULL;
			if ($this->idFactory->AdvancedSearch->ViewValue !== NULL) { // Load from cache
				$this->idFactory->EditValue = array_values($this->idFactory->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idFactory`" . SearchString("=", $this->idFactory->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idFactory->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idFactory->EditValue = $arwrk;
			}

			// dateFmea
			$this->dateFmea->EditAttrs["class"] = "form-control";
			$this->dateFmea->EditCustomAttributes = "";
			$this->dateFmea->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dateFmea->AdvancedSearch->SearchValue, 0), 8));
			$this->dateFmea->PlaceHolder = RemoveHtml($this->dateFmea->caption());
			$this->dateFmea->EditAttrs["class"] = "form-control";
			$this->dateFmea->EditCustomAttributes = "";
			$this->dateFmea->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->dateFmea->AdvancedSearch->SearchValue2, 0), 8));
			$this->dateFmea->PlaceHolder = RemoveHtml($this->dateFmea->caption());

			// idworkcenter
			$this->idworkcenter->EditAttrs["class"] = "form-control";
			$this->idworkcenter->EditCustomAttributes = "";
			$curVal = trim(strval($this->idworkcenter->AdvancedSearch->SearchValue));
			if ($curVal != "")
				$this->idworkcenter->AdvancedSearch->ViewValue = $this->idworkcenter->lookupCacheOption($curVal);
			else
				$this->idworkcenter->AdvancedSearch->ViewValue = $this->idworkcenter->Lookup !== NULL && is_array($this->idworkcenter->Lookup->Options) ? $curVal : NULL;
			if ($this->idworkcenter->AdvancedSearch->ViewValue !== NULL) { // Load from cache
				$this->idworkcenter->EditValue = array_values($this->idworkcenter->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`workcenter`" . SearchString("=", $this->idworkcenter->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idworkcenter->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idworkcenter->EditValue = $arwrk;
			}

			// flowchartDesc
			$this->flowchartDesc->EditAttrs["class"] = "form-control";
			$this->flowchartDesc->EditCustomAttributes = "";
			$this->flowchartDesc->EditValue = HtmlEncode($this->flowchartDesc->AdvancedSearch->SearchValue);
			$this->flowchartDesc->PlaceHolder = RemoveHtml($this->flowchartDesc->caption());
			$this->flowchartDesc->EditAttrs["class"] = "form-control";
			$this->flowchartDesc->EditCustomAttributes = "";
			$this->flowchartDesc->EditValue2 = HtmlEncode($this->flowchartDesc->AdvancedSearch->SearchValue2);
			$this->flowchartDesc->PlaceHolder = RemoveHtml($this->flowchartDesc->caption());

			// partnumber
			$this->partnumber->EditAttrs["class"] = "form-control";
			$this->partnumber->EditCustomAttributes = "";
			if (!$this->partnumber->Raw)
				$this->partnumber->AdvancedSearch->SearchValue = HtmlDecode($this->partnumber->AdvancedSearch->SearchValue);
			$this->partnumber->EditValue = HtmlEncode($this->partnumber->AdvancedSearch->SearchValue);
			$this->partnumber->PlaceHolder = RemoveHtml($this->partnumber->caption());
			$this->partnumber->EditAttrs["class"] = "form-control";
			$this->partnumber->EditCustomAttributes = "";
			if (!$this->partnumber->Raw)
				$this->partnumber->AdvancedSearch->SearchValue2 = HtmlDecode($this->partnumber->AdvancedSearch->SearchValue2);
			$this->partnumber->EditValue2 = HtmlEncode($this->partnumber->AdvancedSearch->SearchValue2);
			$this->partnumber->PlaceHolder = RemoveHtml($this->partnumber->caption());

			// operation
			$this->operation->EditAttrs["class"] = "form-control";
			$this->operation->EditCustomAttributes = "";
			if (!$this->operation->Raw)
				$this->operation->AdvancedSearch->SearchValue = HtmlDecode($this->operation->AdvancedSearch->SearchValue);
			$this->operation->EditValue = HtmlEncode($this->operation->AdvancedSearch->SearchValue);
			$this->operation->PlaceHolder = RemoveHtml($this->operation->caption());
			$this->operation->EditAttrs["class"] = "form-control";
			$this->operation->EditCustomAttributes = "";
			if (!$this->operation->Raw)
				$this->operation->AdvancedSearch->SearchValue2 = HtmlDecode($this->operation->AdvancedSearch->SearchValue2);
			$this->operation->EditValue2 = HtmlEncode($this->operation->AdvancedSearch->SearchValue2);
			$this->operation->PlaceHolder = RemoveHtml($this->operation->caption());

			// severity
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue = HtmlEncode($this->severity->AdvancedSearch->SearchValue);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue2 = HtmlEncode($this->severity->AdvancedSearch->SearchValue2);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());

			// idCause
			$this->idCause->EditAttrs["class"] = "form-control";
			$this->idCause->EditCustomAttributes = "";
			if (!$this->idCause->Raw)
				$this->idCause->AdvancedSearch->SearchValue = HtmlDecode($this->idCause->AdvancedSearch->SearchValue);
			$this->idCause->EditValue = HtmlEncode($this->idCause->AdvancedSearch->SearchValue);
			$this->idCause->PlaceHolder = RemoveHtml($this->idCause->caption());
			$this->idCause->EditAttrs["class"] = "form-control";
			$this->idCause->EditCustomAttributes = "";
			if (!$this->idCause->Raw)
				$this->idCause->AdvancedSearch->SearchValue2 = HtmlDecode($this->idCause->AdvancedSearch->SearchValue2);
			$this->idCause->EditValue2 = HtmlEncode($this->idCause->AdvancedSearch->SearchValue2);
			$this->idCause->PlaceHolder = RemoveHtml($this->idCause->caption());
		} elseif ($this->RowType == ROWTYPE_TOTAL && !($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER)) { // Summary row
			$this->RowAttrs->prependClass(($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
			if ($this->RowTotalType == ROWTOTAL_GROUP)
				$this->RowAttrs["data-group"] = $this->fmea->groupValue(); // Set up group attribute

			// fmea
			$curVal = strval($this->fmea->groupValue());
			if ($curVal != "") {
				$this->fmea->GroupViewValue = $this->fmea->lookupCacheOption($curVal);
				if ($this->fmea->GroupViewValue === NULL) { // Lookup from database
					$filterWrk = "`fmea`" . SearchString("=", $curVal, DATATYPE_STRING, "");
					$sqlWrk = $this->fmea->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->fmea->GroupViewValue = $this->fmea->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->fmea->GroupViewValue = $this->fmea->groupValue();
					}
				}
			} else {
				$this->fmea->GroupViewValue = NULL;
			}
			$this->fmea->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
			$this->fmea->ViewCustomAttributes = "";
			$this->fmea->GroupViewValue = DisplayGroupValue($this->fmea, $this->fmea->GroupViewValue);

			// idCause
			$this->idCause->CntViewValue = $this->idCause->CntValue;
			$this->idCause->ViewCustomAttributes = "";
			$this->idCause->CellAttrs["class"] = ($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

			// fmea
			$this->fmea->HrefValue = "";

			// idFactory
			$this->idFactory->HrefValue = "";

			// dateFmea
			$this->dateFmea->HrefValue = "";

			// idworkcenter
			$this->idworkcenter->HrefValue = "";

			// idProcess
			$this->idProcess->HrefValue = "";

			// step
			$this->step->HrefValue = "";

			// flowchartDesc
			$this->flowchartDesc->HrefValue = "";

			// partnumber
			$this->partnumber->HrefValue = "";

			// operation
			$this->operation->HrefValue = "";

			// flowchart
			$this->flowchart->HrefValue = "";

			// severity
			$this->severity->HrefValue = "";

			// idCause
			$this->idCause->HrefValue = "";

			// potentialCauses
			$this->potentialCauses->HrefValue = "";

			// occurrence
			$this->occurrence->HrefValue = "";

			// detection
			$this->detection->HrefValue = "";

			// rpn
			$this->rpn->HrefValue = "";

			// recomendedAction
			$this->recomendedAction->HrefValue = "";

			// idResponsible
			$this->idResponsible->HrefValue = "";
		} else {
			if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER) {
			$this->RowAttrs["data-group"] = $this->fmea->groupValue(); // Set up group attribute
			} else {
			$this->RowAttrs["data-group"] = $this->fmea->groupValue(); // Set up group attribute
			}

			// fmea
			$curVal = strval($this->fmea->groupValue());
			if ($curVal != "") {
				$this->fmea->GroupViewValue = $this->fmea->lookupCacheOption($curVal);
				if ($this->fmea->GroupViewValue === NULL) { // Lookup from database
					$filterWrk = "`fmea`" . SearchString("=", $curVal, DATATYPE_STRING, "");
					$sqlWrk = $this->fmea->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->fmea->GroupViewValue = $this->fmea->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->fmea->GroupViewValue = $this->fmea->groupValue();
					}
				}
			} else {
				$this->fmea->GroupViewValue = NULL;
			}
			$this->fmea->CellCssClass = "ew-rpt-grp-field-1";
			$this->fmea->ViewCustomAttributes = "";
			$this->fmea->GroupViewValue = DisplayGroupValue($this->fmea, $this->fmea->GroupViewValue);
			if (!$this->fmea->LevelBreak)
				$this->fmea->GroupViewValue = "&nbsp;";
			else
				$this->fmea->LevelBreak = FALSE;

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
			$this->idFactory->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->idFactory->ViewCustomAttributes = "";

			// dateFmea
			$this->dateFmea->ViewValue = $this->dateFmea->CurrentValue;
			$this->dateFmea->ViewValue = FormatDateTime($this->dateFmea->ViewValue, 0);
			$this->dateFmea->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->dateFmea->ViewCustomAttributes = "";

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
						$this->idworkcenter->ViewValue = $this->idworkcenter->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idworkcenter->ViewValue = $this->idworkcenter->CurrentValue;
					}
				}
			} else {
				$this->idworkcenter->ViewValue = NULL;
			}
			$this->idworkcenter->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->idworkcenter->ViewCustomAttributes = "";

			// idProcess
			$this->idProcess->ViewValue = $this->idProcess->CurrentValue;
			$this->idProcess->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->idProcess->ViewCustomAttributes = "";

			// step
			$this->step->ViewValue = $this->step->CurrentValue;
			$this->step->ViewValue = FormatNumber($this->step->ViewValue, 0, -2, -2, -2);
			$this->step->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->step->ViewCustomAttributes = "";

			// flowchartDesc
			$this->flowchartDesc->ViewValue = $this->flowchartDesc->CurrentValue;
			$this->flowchartDesc->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->flowchartDesc->ViewCustomAttributes = "";

			// partnumber
			$this->partnumber->ViewValue = $this->partnumber->CurrentValue;
			$this->partnumber->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->partnumber->ViewCustomAttributes = "";

			// operation
			$this->operation->ViewValue = $this->operation->CurrentValue;
			$this->operation->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->operation->ViewCustomAttributes = "";

			// flowchart
			$this->flowchart->ViewValue = $this->flowchart->CurrentValue;
			$this->flowchart->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->flowchart->ViewCustomAttributes = "";

			// severity
			$this->severity->ViewValue = $this->severity->CurrentValue;
			$this->severity->ViewValue = FormatNumber($this->severity->ViewValue, 0, -2, -2, -2);
			$this->severity->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->severity->ViewCustomAttributes = "";

			// idCause
			$this->idCause->ViewValue = $this->idCause->CurrentValue;
			$this->idCause->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->idCause->ViewCustomAttributes = "";

			// potentialCauses
			$this->potentialCauses->ViewValue = $this->potentialCauses->CurrentValue;
			$this->potentialCauses->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->potentialCauses->ViewCustomAttributes = "";

			// occurrence
			$this->occurrence->ViewValue = $this->occurrence->CurrentValue;
			$this->occurrence->ViewValue = FormatNumber($this->occurrence->ViewValue, 0, -2, -2, -2);
			$this->occurrence->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->occurrence->ViewCustomAttributes = "";

			// detection
			$this->detection->ViewValue = $this->detection->CurrentValue;
			$this->detection->ViewValue = FormatNumber($this->detection->ViewValue, 0, -2, -2, -2);
			$this->detection->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->detection->ViewCustomAttributes = "";

			// rpn
			$this->rpn->ViewValue = $this->rpn->CurrentValue;
			$this->rpn->ViewValue = FormatNumber($this->rpn->ViewValue, 0, -2, -2, -2);
			$this->rpn->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->rpn->ViewCustomAttributes = "";

			// recomendedAction
			$this->recomendedAction->ViewValue = $this->recomendedAction->CurrentValue;
			$this->recomendedAction->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
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
							$filterWrk .= "`name`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
						}
						$sqlWrk = $this->idResponsible->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$this->idResponsible->ViewValue = new OptionValues();
							$ari = 0;
							while (!$rswrk->EOF) {
								$arwrk = [];
								$arwrk[1] = $rswrk->fields('df');
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
			$this->idResponsible->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "ew-table-row");
			$this->idResponsible->ViewCustomAttributes = "";

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

			// idworkcenter
			$this->idworkcenter->LinkCustomAttributes = "";
			$this->idworkcenter->HrefValue = "";
			$this->idworkcenter->TooltipValue = "";

			// idProcess
			$this->idProcess->LinkCustomAttributes = "";
			$this->idProcess->HrefValue = "";
			$this->idProcess->TooltipValue = "";

			// step
			$this->step->LinkCustomAttributes = "";
			$this->step->HrefValue = "";
			$this->step->TooltipValue = "";

			// flowchartDesc
			$this->flowchartDesc->LinkCustomAttributes = "";
			$this->flowchartDesc->HrefValue = "";
			$this->flowchartDesc->TooltipValue = "";

			// partnumber
			$this->partnumber->LinkCustomAttributes = "";
			$this->partnumber->HrefValue = "";
			$this->partnumber->TooltipValue = "";

			// operation
			$this->operation->LinkCustomAttributes = "";
			$this->operation->HrefValue = "";
			$this->operation->TooltipValue = "";

			// flowchart
			$this->flowchart->LinkCustomAttributes = "";
			$this->flowchart->HrefValue = "";
			$this->flowchart->TooltipValue = "";

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

			// occurrence
			$this->occurrence->LinkCustomAttributes = "";
			$this->occurrence->HrefValue = "";
			$this->occurrence->TooltipValue = "";

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

			// idResponsible
			$this->idResponsible->LinkCustomAttributes = "";
			$this->idResponsible->HrefValue = "";
			$this->idResponsible->TooltipValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == ROWTYPE_TOTAL) { // Summary row

			// fmea
			$currentValue = $this->fmea->GroupViewValue;
			$viewValue = &$this->fmea->GroupViewValue;
			$viewAttrs = &$this->fmea->ViewAttrs;
			$cellAttrs = &$this->fmea->CellAttrs;
			$hrefValue = &$this->fmea->HrefValue;
			$linkAttrs = &$this->fmea->LinkAttrs;
			$this->Cell_Rendered($this->fmea, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// idCause
			$currentValue = $this->idCause->CntValue;
			$viewValue = &$this->idCause->CntViewValue;
			$viewAttrs = &$this->idCause->ViewAttrs;
			$cellAttrs = &$this->idCause->CellAttrs;
			$hrefValue = &$this->idCause->HrefValue;
			$linkAttrs = &$this->idCause->LinkAttrs;
			$this->Cell_Rendered($this->idCause, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
		} else {

			// fmea
			$currentValue = $this->fmea->groupValue();
			$viewValue = &$this->fmea->GroupViewValue;
			$viewAttrs = &$this->fmea->ViewAttrs;
			$cellAttrs = &$this->fmea->CellAttrs;
			$hrefValue = &$this->fmea->HrefValue;
			$linkAttrs = &$this->fmea->LinkAttrs;
			$this->Cell_Rendered($this->fmea, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// idFactory
			$currentValue = $this->idFactory->CurrentValue;
			$viewValue = &$this->idFactory->ViewValue;
			$viewAttrs = &$this->idFactory->ViewAttrs;
			$cellAttrs = &$this->idFactory->CellAttrs;
			$hrefValue = &$this->idFactory->HrefValue;
			$linkAttrs = &$this->idFactory->LinkAttrs;
			$this->Cell_Rendered($this->idFactory, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// dateFmea
			$currentValue = $this->dateFmea->CurrentValue;
			$viewValue = &$this->dateFmea->ViewValue;
			$viewAttrs = &$this->dateFmea->ViewAttrs;
			$cellAttrs = &$this->dateFmea->CellAttrs;
			$hrefValue = &$this->dateFmea->HrefValue;
			$linkAttrs = &$this->dateFmea->LinkAttrs;
			$this->Cell_Rendered($this->dateFmea, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// idworkcenter
			$currentValue = $this->idworkcenter->CurrentValue;
			$viewValue = &$this->idworkcenter->ViewValue;
			$viewAttrs = &$this->idworkcenter->ViewAttrs;
			$cellAttrs = &$this->idworkcenter->CellAttrs;
			$hrefValue = &$this->idworkcenter->HrefValue;
			$linkAttrs = &$this->idworkcenter->LinkAttrs;
			$this->Cell_Rendered($this->idworkcenter, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// idProcess
			$currentValue = $this->idProcess->CurrentValue;
			$viewValue = &$this->idProcess->ViewValue;
			$viewAttrs = &$this->idProcess->ViewAttrs;
			$cellAttrs = &$this->idProcess->CellAttrs;
			$hrefValue = &$this->idProcess->HrefValue;
			$linkAttrs = &$this->idProcess->LinkAttrs;
			$this->Cell_Rendered($this->idProcess, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// step
			$currentValue = $this->step->CurrentValue;
			$viewValue = &$this->step->ViewValue;
			$viewAttrs = &$this->step->ViewAttrs;
			$cellAttrs = &$this->step->CellAttrs;
			$hrefValue = &$this->step->HrefValue;
			$linkAttrs = &$this->step->LinkAttrs;
			$this->Cell_Rendered($this->step, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// flowchartDesc
			$currentValue = $this->flowchartDesc->CurrentValue;
			$viewValue = &$this->flowchartDesc->ViewValue;
			$viewAttrs = &$this->flowchartDesc->ViewAttrs;
			$cellAttrs = &$this->flowchartDesc->CellAttrs;
			$hrefValue = &$this->flowchartDesc->HrefValue;
			$linkAttrs = &$this->flowchartDesc->LinkAttrs;
			$this->Cell_Rendered($this->flowchartDesc, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// partnumber
			$currentValue = $this->partnumber->CurrentValue;
			$viewValue = &$this->partnumber->ViewValue;
			$viewAttrs = &$this->partnumber->ViewAttrs;
			$cellAttrs = &$this->partnumber->CellAttrs;
			$hrefValue = &$this->partnumber->HrefValue;
			$linkAttrs = &$this->partnumber->LinkAttrs;
			$this->Cell_Rendered($this->partnumber, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// operation
			$currentValue = $this->operation->CurrentValue;
			$viewValue = &$this->operation->ViewValue;
			$viewAttrs = &$this->operation->ViewAttrs;
			$cellAttrs = &$this->operation->CellAttrs;
			$hrefValue = &$this->operation->HrefValue;
			$linkAttrs = &$this->operation->LinkAttrs;
			$this->Cell_Rendered($this->operation, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// flowchart
			$currentValue = $this->flowchart->CurrentValue;
			$viewValue = &$this->flowchart->ViewValue;
			$viewAttrs = &$this->flowchart->ViewAttrs;
			$cellAttrs = &$this->flowchart->CellAttrs;
			$hrefValue = &$this->flowchart->HrefValue;
			$linkAttrs = &$this->flowchart->LinkAttrs;
			$this->Cell_Rendered($this->flowchart, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// severity
			$currentValue = $this->severity->CurrentValue;
			$viewValue = &$this->severity->ViewValue;
			$viewAttrs = &$this->severity->ViewAttrs;
			$cellAttrs = &$this->severity->CellAttrs;
			$hrefValue = &$this->severity->HrefValue;
			$linkAttrs = &$this->severity->LinkAttrs;
			$this->Cell_Rendered($this->severity, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// idCause
			$currentValue = $this->idCause->CurrentValue;
			$viewValue = &$this->idCause->ViewValue;
			$viewAttrs = &$this->idCause->ViewAttrs;
			$cellAttrs = &$this->idCause->CellAttrs;
			$hrefValue = &$this->idCause->HrefValue;
			$linkAttrs = &$this->idCause->LinkAttrs;
			$this->Cell_Rendered($this->idCause, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// potentialCauses
			$currentValue = $this->potentialCauses->CurrentValue;
			$viewValue = &$this->potentialCauses->ViewValue;
			$viewAttrs = &$this->potentialCauses->ViewAttrs;
			$cellAttrs = &$this->potentialCauses->CellAttrs;
			$hrefValue = &$this->potentialCauses->HrefValue;
			$linkAttrs = &$this->potentialCauses->LinkAttrs;
			$this->Cell_Rendered($this->potentialCauses, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// occurrence
			$currentValue = $this->occurrence->CurrentValue;
			$viewValue = &$this->occurrence->ViewValue;
			$viewAttrs = &$this->occurrence->ViewAttrs;
			$cellAttrs = &$this->occurrence->CellAttrs;
			$hrefValue = &$this->occurrence->HrefValue;
			$linkAttrs = &$this->occurrence->LinkAttrs;
			$this->Cell_Rendered($this->occurrence, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// detection
			$currentValue = $this->detection->CurrentValue;
			$viewValue = &$this->detection->ViewValue;
			$viewAttrs = &$this->detection->ViewAttrs;
			$cellAttrs = &$this->detection->CellAttrs;
			$hrefValue = &$this->detection->HrefValue;
			$linkAttrs = &$this->detection->LinkAttrs;
			$this->Cell_Rendered($this->detection, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// rpn
			$currentValue = $this->rpn->CurrentValue;
			$viewValue = &$this->rpn->ViewValue;
			$viewAttrs = &$this->rpn->ViewAttrs;
			$cellAttrs = &$this->rpn->CellAttrs;
			$hrefValue = &$this->rpn->HrefValue;
			$linkAttrs = &$this->rpn->LinkAttrs;
			$this->Cell_Rendered($this->rpn, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// recomendedAction
			$currentValue = $this->recomendedAction->CurrentValue;
			$viewValue = &$this->recomendedAction->ViewValue;
			$viewAttrs = &$this->recomendedAction->ViewAttrs;
			$cellAttrs = &$this->recomendedAction->CellAttrs;
			$hrefValue = &$this->recomendedAction->HrefValue;
			$linkAttrs = &$this->recomendedAction->LinkAttrs;
			$this->Cell_Rendered($this->recomendedAction, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

			// idResponsible
			$currentValue = $this->idResponsible->CurrentValue;
			$viewValue = &$this->idResponsible->ViewValue;
			$viewAttrs = &$this->idResponsible->ViewAttrs;
			$cellAttrs = &$this->idResponsible->CellAttrs;
			$hrefValue = &$this->idResponsible->HrefValue;
			$linkAttrs = &$this->idResponsible->LinkAttrs;
			$this->Cell_Rendered($this->idResponsible, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->setupFieldCount();
	}
	private $_groupCounts = [];

	// Get group count
	public function getGroupCount(...$args)
	{
		$key = "";
		foreach($args as $arg) {
			if ($key != "")
				$key .= "_";
			$key .= strval($arg);
		}
		if ($key == "") {
			return -1;
		} elseif ($key == "0") { // Number of first level groups
			$i = 1;
			while (isset($this->_groupCounts[strval($i)]))
				$i++;
			return $i - 1;
		}
		return isset($this->_groupCounts[$key]) ? $this->_groupCounts[$key] : -1;
	}

	// Set group count
	public function setGroupCount($value, ...$args)
	{
		$key = "";
		foreach($args as $arg) {
			if ($key != "")
				$key .= "_";
			$key .= strval($arg);
		}
		if ($key == "")
			return;
		$this->_groupCounts[$key] = $value;
	}

	// Setup field count
	protected function setupFieldCount()
	{
		$this->GroupColumnCount = 0;
		$this->SubGroupColumnCount = 0;
		$this->DetailColumnCount = 0;
		if ($this->fmea->Visible)
			$this->GroupColumnCount += 1;
		if ($this->idFactory->Visible)
			$this->DetailColumnCount += 1;
		if ($this->dateFmea->Visible)
			$this->DetailColumnCount += 1;
		if ($this->idworkcenter->Visible)
			$this->DetailColumnCount += 1;
		if ($this->idProcess->Visible)
			$this->DetailColumnCount += 1;
		if ($this->step->Visible)
			$this->DetailColumnCount += 1;
		if ($this->flowchartDesc->Visible)
			$this->DetailColumnCount += 1;
		if ($this->partnumber->Visible)
			$this->DetailColumnCount += 1;
		if ($this->operation->Visible)
			$this->DetailColumnCount += 1;
		if ($this->flowchart->Visible)
			$this->DetailColumnCount += 1;
		if ($this->severity->Visible)
			$this->DetailColumnCount += 1;
		if ($this->idCause->Visible)
			$this->DetailColumnCount += 1;
		if ($this->potentialCauses->Visible)
			$this->DetailColumnCount += 1;
		if ($this->occurrence->Visible)
			$this->DetailColumnCount += 1;
		if ($this->detection->Visible)
			$this->DetailColumnCount += 1;
		if ($this->rpn->Visible)
			$this->DetailColumnCount += 1;
		if ($this->recomendedAction->Visible)
			$this->DetailColumnCount += 1;
		if ($this->idResponsible->Visible)
			$this->DetailColumnCount += 1;
	}

	// Get export HTML tag
	protected function getExportTag($type, $custom = FALSE)
	{
		global $Language;
		if (SameText($type, "excel")) {
			return '<a class="ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", TRUE)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", TRUE)) . '" href="#" onclick="return ew.exportWithCharts(event, \'' . $this->ExportExcelUrl . '\', \'' . session_id() . '\');">' . $Language->phrase("ExportToExcel") . '</a>';
		} elseif (SameText($type, "word")) {
			return '<a class="ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", TRUE)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", TRUE)) . '" href="#" onclick="return ew.exportWithCharts(event, \'' . $this->ExportWordUrl . '\', \'' . session_id() . '\');">' . $Language->phrase("ExportToWord") . '</a>';
		} elseif (SameText($type, "pdf")) {
			return '<a class="ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPDF", TRUE)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPDF", TRUE)) . '" href="#" onclick="return ew.exportWithCharts(event, \'' . $this->ExportPdfUrl . '\', \'' . session_id() . '\');">' . $Language->phrase("ExportToPDF") . '</a>';
		} elseif (SameText($type, "email")) {
			return '<a class="ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", TRUE)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", TRUE)) . '" id="emf_KPI" href="#" onclick="return ew.emailDialogShow({ lnk: \'emf_KPI\', hdr: ew.language.phrase(\'ExportToEmailText\'), url: \'' . $this->pageUrl() . 'export=email\', exportid: \'' . session_id() . '\', el: this });">' . $Language->phrase("ExportToEmail") . '</a>';
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

		// Hide options for export
		if ($this->isExport())
			$this->ExportOptions->hideAllOptions();
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
		$item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fsummary\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->add("showall");
		$item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $this->pageUrl() . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

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

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
						case "x_fmea":
							break;
						case "x_idFactory":
							break;
						case "x_idEmployee":
							break;
						case "x_idworkcenter":
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

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;

		// Filter button
		$item = &$this->FilterOptions->add("savecurrentfilter");
		$item->Body = "<a class=\"ew-save-filter\" data-form=\"fsummary\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->add("deletefilter");
		$item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsummary\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export report to Word
	public function exportReportWord($html)
	{
		global $ExportFileName;
		$charset = Config("PROJECT_CHARSET");
		AddHeader("Content-Type", "application/msword" . ($charset ? "; charset=" . $charset : ""));
		AddHeader("Content-Disposition", "attachment; filename=" . $ExportFileName . ".doc");
		AddHeader("Set-Cookie", "fileDownload=true; path=/");
		Write($html);
	}

	// Export report to Excel
	public function exportReportExcel($html)
	{
		global $ExportFileName;
		$charset = Config("PROJECT_CHARSET");
		AddHeader("Content-Type", "application/vnd.ms-excel" . ($charset ? "; charset=" . $charset : ""));
		AddHeader("Content-Disposition", "attachment; filename=" . $ExportFileName . ".xls");
		AddHeader("Set-Cookie", "fileDownload=true; path=/");
		Write($html);
	}

// Export PDF
	public function exportReportPdf($html)
	{
		global $ExportFileName;
		@ini_set("memory_limit", Config("PDF_MEMORY_LIMIT"));
		set_time_limit(Config("PDF_TIME_LIMIT"));
		$html = CheckHtml($html);
		if (Config("DEBUG")) // Add debug message
			$html = str_replace("</body>", GetDebugMessage() . "</body>", $html);
		$dompdf = new \Dompdf\Dompdf(["pdf_backend" => "CPDF"]);
		$doc = new \DOMDocument("1.0", "utf-8");
		@$doc->loadHTML('<?xml encoding="uft-8">' . ConvertToUtf8($html)); // Convert to utf-8
		$spans = $doc->getElementsByTagName("span");
		foreach ($spans as $span) {
			$classNames = $span->getAttribute("class");
			if ($classNames == "ew-filter-caption") // Insert colon
				$span->parentNode->insertBefore($doc->createElement("span", ":&nbsp;"), $span->nextSibling);
			elseif (preg_match('/\bicon\-\w+\b/', $classNames)) // Remove icons
				$span->parentNode->removeChild($span);
		}
		$images = $doc->getElementsByTagName("img");
		$pageSize = $this->ExportPageSize;
		$pageOrientation = $this->ExportPageOrientation;
		$portrait = SameText($pageOrientation, "portrait");
		foreach ($images as $image) {
			$imagefn = $image->getAttribute("src");
			if (file_exists($imagefn)) {
				$imagefn = realpath($imagefn);
				$size = getimagesize($imagefn); // Get image size
				if ($size[0] != 0) {
					if (SameText($pageSize, "letter")) { // Letter paper (8.5 in. by 11 in.)
						$w = $portrait ? 216 : 279;
					} elseif (SameText($pageSize, "legal")) { // Legal paper (8.5 in. by 14 in.)
						$w = $portrait ? 216 : 356;
					} else {
						$w = $portrait ? 210 : 297; // A4 paper (210 mm by 297 mm)
					}
					$w = min($size[0], ($w - 20 * 2) / 25.4 * 72 * Config("PDF_IMAGE_SCALE_FACTOR")); // Resize image, adjust the scale factor if necessary
					$h = $w / $size[0] * $size[1];
					$image->setAttribute("width", $w);
					$image->setAttribute("height", $h);
				}
			}
		}
		$html = $doc->saveHTML();
		$html = ConvertFromUtf8($html);
		$dompdf->load_html($html);
		$dompdf->set_paper($pageSize, $pageOrientation);
		$dompdf->render();
		header('Set-Cookie: fileDownload=true; path=/');
		$exportFile = EndsText(".pdf", $ExportFileName) ? $ExportFileName : $ExportFileName . ".pdf";
		$dompdf->stream($exportFile, ["Attachment" => 1]); // 0 to open in browser, 1 to download
		DeleteTempImages();
		exit();
	}

	// Set up starting group
	protected function setupStartGroup()
	{

		// Exit if no groups
		if ($this->DisplayGroups == 0)
			return;
		$startGrp = Param(Config("TABLE_START_GROUP"), "");
		$pageNo = Param("pageno", "");

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGroup = $startGrp;
			$this->setStartGroup($this->StartGroup);
		} elseif ($pageNo != "") {
			if (is_numeric($pageNo)) {
				$this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
				if ($this->StartGroup <= 0) {
					$this->StartGroup = 1;
				} elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
					$this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
				}
				$this->setStartGroup($this->StartGroup);
			} else {
				$this->StartGroup = $this->getStartGroup();
			}
		} else {
			$this->StartGroup = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGroup) || $this->StartGroup == "") { // Avoid invalid start group counter
			$this->StartGroup = 1; // Reset start group counter
			$this->setStartGroup($this->StartGroup);
		} elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
			$this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
			$this->setStartGroup($this->StartGroup);
		} elseif (($this->StartGroup-1) % $this->DisplayGroups != 0) {
			$this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
			$this->setStartGroup($this->StartGroup);
		}
	}

	// Reset pager
	protected function resetPager()
	{

		// Reset start position (reset command)
		$this->StartGroup = 1;
		$this->setStartGroup($this->StartGroup);
	}

	// Set up number of groups displayed per page
	protected function setupDisplayGroups()
	{
		if (Param(Config("TABLE_GROUP_PER_PAGE")) !== NULL) {
			$wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
			if (is_numeric($wrk)) {
				$this->DisplayGroups = intval($wrk);
			} else {
				if (strtoupper($wrk) == "ALL") { // Display all groups
					$this->DisplayGroups = -1;
				} else {
					$this->DisplayGroups = 1; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGroups); // Save to session

			// Reset start position (reset command)
			$this->StartGroup = 1;
			$this->setStartGroup($this->StartGroup);
		} else {
			if ($this->getGroupPerPage() != "") {
				$this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGroups = 1; // Load default
			}
		}
	}

	// Get sort parameters based on sort links clicked
	protected function getSort()
	{
		if ($this->DrillDown)
			return "";
		$resetSort = Param("cmd") === "resetsort";
		$orderBy = Param("order", "");
		$orderType = Param("ordertype", "");

		// Check for Ctrl pressed
		$ctrl = (Param("ctrl") !== NULL);

		// Check for a resetsort command
		if ($resetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->fmea->setSort("");
			$this->idFactory->setSort("");
			$this->dateFmea->setSort("");
			$this->idworkcenter->setSort("");
			$this->idProcess->setSort("");
			$this->step->setSort("");
			$this->flowchartDesc->setSort("");
			$this->partnumber->setSort("");
			$this->operation->setSort("");
			$this->flowchart->setSort("");
			$this->severity->setSort("");
			$this->idCause->setSort("");
			$this->potentialCauses->setSort("");
			$this->occurrence->setSort("");
			$this->detection->setSort("");
			$this->rpn->setSort("");
			$this->recomendedAction->setSort("");
			$this->idResponsible->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy != "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->updateSort($this->fmea, $ctrl); // fmea
			$this->updateSort($this->idFactory, $ctrl); // idFactory
			$this->updateSort($this->dateFmea, $ctrl); // dateFmea
			$this->updateSort($this->idworkcenter, $ctrl); // idworkcenter
			$this->updateSort($this->idProcess, $ctrl); // idProcess
			$this->updateSort($this->step, $ctrl); // step
			$this->updateSort($this->flowchartDesc, $ctrl); // flowchartDesc
			$this->updateSort($this->partnumber, $ctrl); // partnumber
			$this->updateSort($this->operation, $ctrl); // operation
			$this->updateSort($this->flowchart, $ctrl); // flowchart
			$this->updateSort($this->severity, $ctrl); // severity
			$this->updateSort($this->idCause, $ctrl); // idCause
			$this->updateSort($this->potentialCauses, $ctrl); // potentialCauses
			$this->updateSort($this->occurrence, $ctrl); // occurrence
			$this->updateSort($this->detection, $ctrl); // detection
			$this->updateSort($this->rpn, $ctrl); // rpn
			$this->updateSort($this->recomendedAction, $ctrl); // recomendedAction
			$this->updateSort($this->idResponsible, $ctrl); // idResponsible
			$sortSql = $this->sortSql();
			$this->setOrderBy($sortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Return extended filter
	protected function getExtendedFilter()
	{
		global $FormError;
		$filter = "";
		if ($this->DrillDown)
			return "";
		$restoreSession = FALSE;
		$restoreDefault = FALSE;

		// Reset search command
		if (Get("cmd", "") == "reset") {

			// Set default values
			$this->fmea->AdvancedSearch->unsetSession();
			$this->idFactory->AdvancedSearch->unsetSession();
			$this->dateFmea->AdvancedSearch->unsetSession();
			$this->idworkcenter->AdvancedSearch->unsetSession();
			$this->flowchartDesc->AdvancedSearch->unsetSession();
			$this->partnumber->AdvancedSearch->unsetSession();
			$this->operation->AdvancedSearch->unsetSession();
			$this->severity->AdvancedSearch->unsetSession();
			$this->idCause->AdvancedSearch->unsetSession();
			$restoreDefault = TRUE;
		} else {
			$restoreSession = !$this->SearchCommand;

			// Field fmea
			$this->getDropDownValue($this->fmea);

			// Field idFactory
			$this->getDropDownValue($this->idFactory);

			// Field dateFmea
			if ($this->dateFmea->AdvancedSearch->get()) {
			}

			// Field idworkcenter
			$this->getDropDownValue($this->idworkcenter);

			// Field flowchartDesc
			if ($this->flowchartDesc->AdvancedSearch->get()) {
			}

			// Field partnumber
			if ($this->partnumber->AdvancedSearch->get()) {
			}

			// Field operation
			if ($this->operation->AdvancedSearch->get()) {
			}

			// Field severity
			if ($this->severity->AdvancedSearch->get()) {
			}

			// Field idCause
			if ($this->idCause->AdvancedSearch->get()) {
			}
			if (!$this->validateForm()) {
				$this->setFailureMessage($FormError);
				return $filter;
			}
		}

		// Restore session
		if ($restoreSession) {
			$restoreDefault = TRUE;
			if ($this->fmea->AdvancedSearch->issetSession()) { // Field fmea
				$this->fmea->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->idFactory->AdvancedSearch->issetSession()) { // Field idFactory
				$this->idFactory->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->dateFmea->AdvancedSearch->issetSession()) { // Field dateFmea
				$this->dateFmea->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->idworkcenter->AdvancedSearch->issetSession()) { // Field idworkcenter
				$this->idworkcenter->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->flowchartDesc->AdvancedSearch->issetSession()) { // Field flowchartDesc
				$this->flowchartDesc->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->partnumber->AdvancedSearch->issetSession()) { // Field partnumber
				$this->partnumber->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->operation->AdvancedSearch->issetSession()) { // Field operation
				$this->operation->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->severity->AdvancedSearch->issetSession()) { // Field severity
				$this->severity->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
			if ($this->idCause->AdvancedSearch->issetSession()) { // Field idCause
				$this->idCause->AdvancedSearch->load();
				$restoreDefault = FALSE;
			}
		}

		// Restore default
		if ($restoreDefault)
			$this->loadDefaultFilters();

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL and save to session
		$this->buildDropDownFilter($this->fmea, $filter, $this->fmea->AdvancedSearch->SearchOperator, FALSE, TRUE); // Field fmea
		$this->fmea->AdvancedSearch->save();
		$this->buildDropDownFilter($this->idFactory, $filter, $this->idFactory->AdvancedSearch->SearchOperator, FALSE, TRUE); // Field idFactory
		$this->idFactory->AdvancedSearch->save();
		$this->buildExtendedFilter($this->dateFmea, $filter, FALSE, TRUE); // Field dateFmea
		$this->dateFmea->AdvancedSearch->save();
		$this->buildDropDownFilter($this->idworkcenter, $filter, $this->idworkcenter->AdvancedSearch->SearchOperator, FALSE, TRUE); // Field idworkcenter
		$this->idworkcenter->AdvancedSearch->save();
		$this->buildExtendedFilter($this->flowchartDesc, $filter, FALSE, TRUE); // Field flowchartDesc
		$this->flowchartDesc->AdvancedSearch->save();
		$this->buildExtendedFilter($this->partnumber, $filter, FALSE, TRUE); // Field partnumber
		$this->partnumber->AdvancedSearch->save();
		$this->buildExtendedFilter($this->operation, $filter, FALSE, TRUE); // Field operation
		$this->operation->AdvancedSearch->save();
		$this->buildExtendedFilter($this->severity, $filter, FALSE, TRUE); // Field severity
		$this->severity->AdvancedSearch->save();
		$this->buildExtendedFilter($this->idCause, $filter, FALSE, TRUE); // Field idCause
		$this->idCause->AdvancedSearch->save();

		// Field fmea
		LoadDropDownList($this->fmea->EditValue, $this->fmea->AdvancedSearch->SearchValue);

		// Field idFactory
		LoadDropDownList($this->idFactory->EditValue, $this->idFactory->AdvancedSearch->SearchValue);

		// Field idworkcenter
		LoadDropDownList($this->idworkcenter->EditValue, $this->idworkcenter->AdvancedSearch->SearchValue);
		return $filter;
	}

	// Build dropdown filter
	protected function buildDropDownFilter(&$fld, &$filterClause, $fldOpr, $default = FALSE, $saveFilter = FALSE)
	{
		$fldVal = ($default) ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
		$sql = "";
		if (is_array($fldVal)) {
			foreach ($fldVal as $val) {
				$wrk = $this->getDropDownFilter($fld, $val, $fldOpr);

				// Call Page Filtering event
				if (!StartsString("@@", $val))
					$this->Page_Filtering($fld, $wrk, "dropdown", $fldOpr, $val);
				if ($wrk != "") {
					if ($sql != "")
						$sql .= " OR " . $wrk;
					else
						$sql = $wrk;
				}
			}
		} else {
			$sql = $this->getDropDownFilter($fld, $fldVal, $fldOpr);

			// Call Page Filtering event
			if (!StartsString("@@", $fldVal))
				$this->Page_Filtering($fld, $sql, "dropdown", $fldOpr, $fldVal);
		}
		if ($sql != "") {
			AddFilter($filterClause, $sql);
			if ($saveFilter) $fld->CurrentFilter = $sql;
		}
	}

	// Get dropdown filter
	protected function getDropDownFilter(&$fld, $fldVal, $fldOpr)
	{
		$fldName = $fld->Name;
		$fldExpression = $fld->Expression;
		$fldDataType = $fld->DataType;
		$isMultiple = $fld->HtmlTag == "CHECKBOX" || $fld->HtmlTag == "SELECT" && $fld->SelectMultiple;
		$fldVal = strval($fldVal);
		if ($fldOpr == "") $fldOpr = "=";
		$wrk = "";
		if (SameString($fldVal, Config("NULL_VALUE"))) {
			$wrk = $fldExpression . " IS NULL";
		} elseif (SameString($fldVal, Config("NOT_NULL_VALUE"))) {
			$wrk = $fldExpression . " IS NOT NULL";
		} elseif (SameString($fldVal, EMPTY_VALUE)) {
			$wrk = $fldExpression . " = ''";
		} elseif (SameString($fldVal, ALL_VALUE)) {
			$wrk = "1 = 1";
		} else {
			if ($fld->GroupSql != "") // Use grouping SQL for search if exists
				$fldExpression = str_replace("%s", $fldExpression, $fld->GroupSql);
			if (StartsString("@@", $fldVal)) {
				$wrk = $this->getCustomFilter($fld, $fldVal, $this->Dbid);
			} elseif ($isMultiple && IsMultiSearchOperator($fldOpr) && trim($fldVal) != "" && $fldVal != INIT_VALUE && ($fldDataType == DATATYPE_STRING || $fldDataType == DATATYPE_MEMO)) {
				$wrk = GetMultiSearchSql($fld, $fldOpr, trim($fldVal), $this->Dbid);
			} else {
				if ($fldVal != "" && $fldVal != INIT_VALUE) {
					if ($fldDataType == DATATYPE_DATE && $fld->GroupSql == "" && $fldOpr != "") {
						$wrk = GetDateFilterSql($fldExpression, $fldOpr, $fldVal, $fldDataType, $this->Dbid);
					} else {
						$wrk = GetFilterSql($fldOpr, $fldVal, $fldDataType, $this->Dbid);
						if ($wrk != "") $wrk = $fldExpression . $wrk;
					}
				}
			}
		}
		return $wrk;
	}

	// Get custom filter
	protected function getCustomFilter(&$fld, $fldVal, $dbid = 0)
	{
		$wrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $fldVal && $filter->Enabled) {
					$fldExpr = $fld->Expression;
					$fn = $filter->FunctionName;
					$wrkid = StartsString("@@", $filter->ID) ? substr($filter->ID, 2) : $filter->ID;
					if ($fn != "") {
						$fn = PROJECT_NAMESPACE . $fn;
						$wrk = $fn($fldExpr, $dbid);
					} else
						$wrk = "";
					$this->Page_Filtering($fld, $wrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $wrk;
	}

	// Build extended filter
	protected function buildExtendedFilter(&$fld, &$filterClause, $default = FALSE, $saveFilter = FALSE)
	{
		$wrk = GetExtendedFilter($fld, $default, $this->Dbid);
		if (!$default)
			$this->Page_Filtering($fld, $wrk, "extended", $fld->AdvancedSearch->SearchOperator, $fld->AdvancedSearch->SearchValue, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchOperator2, $fld->AdvancedSearch->SearchValue2);
		if ($wrk != "") {
			AddFilter($filterClause, $wrk);
			if ($saveFilter) $fld->CurrentFilter = $wrk;
		}
	}

	// Get drop down value from querystring
	protected function getDropDownValue(&$fld)
	{
		$parm = $fld->Param;
		if (IsPost())
			return FALSE; // Skip post back
		$opr = Get("z_$parm");
		if ($opr !== NULL)
			$fld->AdvancedSearch->SearchOperator = $opr;
		$val = Get("x_$parm");
		if ($val !== NULL) {
			if (is_array($val))
				$val = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val); 
			$fld->AdvancedSearch->setSearchValue($val);
			return TRUE;
		}
		return FALSE;
	}

	// Dropdown filter exist
	protected function dropDownFilterExist(&$fld, $fldOpr)
	{
		$wrk = "";
		$this->buildDropDownFilter($fld, $wrk, $fldOpr);
		return ($wrk != "");
	}

	// Extended filter exist
	protected function extendedFilterExist(&$fld)
	{
		$extWrk = "";
		$this->buildExtendedFilter($fld, $extWrk);
		return ($extWrk != "");
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

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			$FormError .= ($FormError != "") ? "<p>&nbsp;</p>" : "";
			$FormError .= $formCustomError;
		}
		return $validateForm;
	}

	// Load default value for filters
	protected function loadDefaultFilters()
	{

		/**
		* Set up default values for extended filters
		*/
		// Field fmea

		$this->fmea->AdvancedSearch->loadDefault();

		// Field idFactory
		$this->idFactory->AdvancedSearch->loadDefault();

		// Field dateFmea
		$this->dateFmea->AdvancedSearch->loadDefault();

		// Field idworkcenter
		$this->idworkcenter->AdvancedSearch->loadDefault();

		// Field flowchartDesc
		$this->flowchartDesc->AdvancedSearch->loadDefault();

		// Field partnumber
		$this->partnumber->AdvancedSearch->loadDefault();

		// Field operation
		$this->operation->AdvancedSearch->loadDefault();

		// Field severity
		$this->severity->AdvancedSearch->loadDefault();

		// Field idCause
		$this->idCause->AdvancedSearch->loadDefault();
	}

	// Show list of filters
	public function showFilterList()
	{
		global $Language;

		// Initialize
		$filterList = "";
		$captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
		$captionSuffix = $this->isExport("email") ? ": " : "";

		// Field fmea
		$extWrk = "";
		$this->buildDropDownFilter($this->fmea, $extWrk, $this->fmea->AdvancedSearch->SearchOperator);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fmea->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field idFactory
		$extWrk = "";
		$this->buildDropDownFilter($this->idFactory, $extWrk, $this->idFactory->AdvancedSearch->SearchOperator);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idFactory->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field dateFmea
		$extWrk = "";
		$this->buildExtendedFilter($this->dateFmea, $extWrk);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->dateFmea->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field idworkcenter
		$extWrk = "";
		$this->buildDropDownFilter($this->idworkcenter, $extWrk, $this->idworkcenter->AdvancedSearch->SearchOperator);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idworkcenter->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field flowchartDesc
		$extWrk = "";
		$this->buildExtendedFilter($this->flowchartDesc, $extWrk);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->flowchartDesc->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field partnumber
		$extWrk = "";
		$this->buildExtendedFilter($this->partnumber, $extWrk);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->partnumber->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field operation
		$extWrk = "";
		$this->buildExtendedFilter($this->operation, $extWrk);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->operation->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field severity
		$extWrk = "";
		$this->buildExtendedFilter($this->severity, $extWrk);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->severity->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Field idCause
		$extWrk = "";
		$this->buildExtendedFilter($this->idCause, $extWrk);
		$filter = "";
		if ($extWrk != "")
			$filter .= "<span class=\"ew-filter-value\">$extWrk</span>";
		if ($filter != "")
			$filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->idCause->caption() . "</span>" . $captionSuffix . $filter . "</div>";

		// Show Filters
		if ($filterList != "") {
			$message = "<div id=\"ew-filter-list\" class=\"alert alert-info d-table\"><div id=\"ew-current-filters\">" .
				$Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
			$this->Message_Showing($message, "");
			Write($message);
		}
	}

	// Get list of filters
	public function getFilterList()
	{

		// Initialize
		$filterList = "";

		// Field fmea
		$wrk = "";
		$wrk = ($this->fmea->AdvancedSearch->SearchValue != INIT_VALUE) ? $this->fmea->AdvancedSearch->SearchValue : "";
		if (is_array($wrk))
			$wrk = implode("||", $wrk);
		if ($wrk != "")
			$wrk = "\"x_fmea\":\"" . JsEncode($wrk) . "\"";
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field idFactory
		$wrk = "";
		$wrk = ($this->idFactory->AdvancedSearch->SearchValue != INIT_VALUE) ? $this->idFactory->AdvancedSearch->SearchValue : "";
		if (is_array($wrk))
			$wrk = implode("||", $wrk);
		if ($wrk != "")
			$wrk = "\"x_idFactory\":\"" . JsEncode($wrk) . "\"";
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field dateFmea
		$wrk = "";
		if ($this->dateFmea->AdvancedSearch->SearchValue != "" || $this->dateFmea->AdvancedSearch->SearchValue2 != "") {
			$wrk = "\"x_dateFmea\":\"" . JsEncode($this->dateFmea->AdvancedSearch->SearchValue) . "\"," .
				"\"z_dateFmea\":\"" . JsEncode($this->dateFmea->AdvancedSearch->SearchOperator) . "\"," .
				"\"v_dateFmea\":\"" . JsEncode($this->dateFmea->AdvancedSearch->SearchCondition) . "\"," .
				"\"y_dateFmea\":\"" . JsEncode($this->dateFmea->AdvancedSearch->SearchValue2) . "\"," .
				"\"w_dateFmea\":\"" . JsEncode($this->dateFmea->AdvancedSearch->SearchOperator2) . "\"";
		}
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field idworkcenter
		$wrk = "";
		$wrk = ($this->idworkcenter->AdvancedSearch->SearchValue != INIT_VALUE) ? $this->idworkcenter->AdvancedSearch->SearchValue : "";
		if (is_array($wrk))
			$wrk = implode("||", $wrk);
		if ($wrk != "")
			$wrk = "\"x_idworkcenter\":\"" . JsEncode($wrk) . "\"";
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field flowchartDesc
		$wrk = "";
		if ($this->flowchartDesc->AdvancedSearch->SearchValue != "" || $this->flowchartDesc->AdvancedSearch->SearchValue2 != "") {
			$wrk = "\"x_flowchartDesc\":\"" . JsEncode($this->flowchartDesc->AdvancedSearch->SearchValue) . "\"," .
				"\"z_flowchartDesc\":\"" . JsEncode($this->flowchartDesc->AdvancedSearch->SearchOperator) . "\"," .
				"\"v_flowchartDesc\":\"" . JsEncode($this->flowchartDesc->AdvancedSearch->SearchCondition) . "\"," .
				"\"y_flowchartDesc\":\"" . JsEncode($this->flowchartDesc->AdvancedSearch->SearchValue2) . "\"," .
				"\"w_flowchartDesc\":\"" . JsEncode($this->flowchartDesc->AdvancedSearch->SearchOperator2) . "\"";
		}
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field partnumber
		$wrk = "";
		if ($this->partnumber->AdvancedSearch->SearchValue != "" || $this->partnumber->AdvancedSearch->SearchValue2 != "") {
			$wrk = "\"x_partnumber\":\"" . JsEncode($this->partnumber->AdvancedSearch->SearchValue) . "\"," .
				"\"z_partnumber\":\"" . JsEncode($this->partnumber->AdvancedSearch->SearchOperator) . "\"," .
				"\"v_partnumber\":\"" . JsEncode($this->partnumber->AdvancedSearch->SearchCondition) . "\"," .
				"\"y_partnumber\":\"" . JsEncode($this->partnumber->AdvancedSearch->SearchValue2) . "\"," .
				"\"w_partnumber\":\"" . JsEncode($this->partnumber->AdvancedSearch->SearchOperator2) . "\"";
		}
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field operation
		$wrk = "";
		if ($this->operation->AdvancedSearch->SearchValue != "" || $this->operation->AdvancedSearch->SearchValue2 != "") {
			$wrk = "\"x_operation\":\"" . JsEncode($this->operation->AdvancedSearch->SearchValue) . "\"," .
				"\"z_operation\":\"" . JsEncode($this->operation->AdvancedSearch->SearchOperator) . "\"," .
				"\"v_operation\":\"" . JsEncode($this->operation->AdvancedSearch->SearchCondition) . "\"," .
				"\"y_operation\":\"" . JsEncode($this->operation->AdvancedSearch->SearchValue2) . "\"," .
				"\"w_operation\":\"" . JsEncode($this->operation->AdvancedSearch->SearchOperator2) . "\"";
		}
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field severity
		$wrk = "";
		if ($this->severity->AdvancedSearch->SearchValue != "" || $this->severity->AdvancedSearch->SearchValue2 != "") {
			$wrk = "\"x_severity\":\"" . JsEncode($this->severity->AdvancedSearch->SearchValue) . "\"," .
				"\"z_severity\":\"" . JsEncode($this->severity->AdvancedSearch->SearchOperator) . "\"," .
				"\"v_severity\":\"" . JsEncode($this->severity->AdvancedSearch->SearchCondition) . "\"," .
				"\"y_severity\":\"" . JsEncode($this->severity->AdvancedSearch->SearchValue2) . "\"," .
				"\"w_severity\":\"" . JsEncode($this->severity->AdvancedSearch->SearchOperator2) . "\"";
		}
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Field idCause
		$wrk = "";
		if ($this->idCause->AdvancedSearch->SearchValue != "" || $this->idCause->AdvancedSearch->SearchValue2 != "") {
			$wrk = "\"x_idCause\":\"" . JsEncode($this->idCause->AdvancedSearch->SearchValue) . "\"," .
				"\"z_idCause\":\"" . JsEncode($this->idCause->AdvancedSearch->SearchOperator) . "\"," .
				"\"v_idCause\":\"" . JsEncode($this->idCause->AdvancedSearch->SearchCondition) . "\"," .
				"\"y_idCause\":\"" . JsEncode($this->idCause->AdvancedSearch->SearchValue2) . "\"," .
				"\"w_idCause\":\"" . JsEncode($this->idCause->AdvancedSearch->SearchOperator2) . "\"";
		}
		if ($wrk != "") {
			if ($filterList != "") $filterList .= ",";
			$filterList .= $wrk;
		}

		// Return filter list in json
		if ($filterList != "")
			return "{\"data\":{" . $filterList . "}}";
		else
			return "null";
	}

	// Restore list of filters
	protected function restoreFilterList()
	{

		// Return if not reset filter
		if (Post("cmd", "") != "resetfilter")
			return FALSE;
		$filter = json_decode(Post("filter", ""), TRUE);
		return $this->setupFilterList($filter);
	}

	// Setup list of filters
	protected function setupFilterList($filter)
	{
		if (!is_array($filter))
			return FALSE;

		// Field fmea
		if (!$this->fmea->AdvancedSearch->getFromArray($filter))
			$this->fmea->AdvancedSearch->loadDefault(); // Clear filter
		$this->fmea->AdvancedSearch->save();

		// Field idFactory
		if (!$this->idFactory->AdvancedSearch->getFromArray($filter))
			$this->idFactory->AdvancedSearch->loadDefault(); // Clear filter
		$this->idFactory->AdvancedSearch->save();

		// Field dateFmea
		if (!$this->dateFmea->AdvancedSearch->getFromArray($filter))
			$this->dateFmea->AdvancedSearch->loadDefault(); // Clear filter
		$this->dateFmea->AdvancedSearch->save();

		// Field idworkcenter
		if (!$this->idworkcenter->AdvancedSearch->getFromArray($filter))
			$this->idworkcenter->AdvancedSearch->loadDefault(); // Clear filter
		$this->idworkcenter->AdvancedSearch->save();

		// Field flowchartDesc
		if (!$this->flowchartDesc->AdvancedSearch->getFromArray($filter))
			$this->flowchartDesc->AdvancedSearch->loadDefault(); // Clear filter
		$this->flowchartDesc->AdvancedSearch->save();

		// Field partnumber
		if (!$this->partnumber->AdvancedSearch->getFromArray($filter))
			$this->partnumber->AdvancedSearch->loadDefault(); // Clear filter
		$this->partnumber->AdvancedSearch->save();

		// Field operation
		if (!$this->operation->AdvancedSearch->getFromArray($filter))
			$this->operation->AdvancedSearch->loadDefault(); // Clear filter
		$this->operation->AdvancedSearch->save();

		// Field severity
		if (!$this->severity->AdvancedSearch->getFromArray($filter))
			$this->severity->AdvancedSearch->loadDefault(); // Clear filter
		$this->severity->AdvancedSearch->save();

		// Field idCause
		if (!$this->idCause->AdvancedSearch->getFromArray($filter))
			$this->idCause->AdvancedSearch->loadDefault(); // Clear filter
		$this->idCause->AdvancedSearch->save();
		return TRUE;
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

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', PROJECT_NAMESPACE . 'GetStartsWithAFilter'); // With function, or
		//RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->Name == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["class"] = "xxx";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
} // End class
?>