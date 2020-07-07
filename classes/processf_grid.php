<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class processf_grid extends processf
{

	// Page ID
	public $PageID = "grid";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'processf';

	// Page object name
	public $PageObjName = "processf_grid";

	// Grid form hidden field names
	public $FormName = "fprocessfgrid";
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
		$this->FormActionName .= "_" . $this->FormName;
		$this->FormKeyName .= "_" . $this->FormName;
		$this->FormOldKeyName .= "_" . $this->FormName;
		$this->FormBlankRowName .= "_" . $this->FormName;
		$this->FormKeyCountName .= "_" . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (processf)
		if (!isset($GLOBALS["processf"]) || get_class($GLOBALS["processf"]) == PROJECT_NAMESPACE . "processf") {
			$GLOBALS["processf"] = &$this;

			// $GLOBALS["MasterTable"] = &$GLOBALS["Table"];
			// if (!isset($GLOBALS["Table"]))
			// 	$GLOBALS["Table"] = &$GLOBALS["processf"];

		}
		$this->AddUrl = "processfadd.php";

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'grid');

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

		// Other options
		if (!$this->OtherOptions)
			$this->OtherOptions = new ListOptionsArray();
		$this->OtherOptions["addedit"] = new ListOptions("div");
		$this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url === "")
			return;
		if (!IsApi())
			$this->Page_Redirecting($url);

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
	public $ShowOtherOptions = FALSE;
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

		// Get grid add count
		$gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->setupListOptions();
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

		// Set up lookup cache
		$this->setupLookupOptions($this->fmea);

		// Search filters
		$srchAdvanced = ""; // Advanced search filter
		$srchBasic = ""; // Basic search filter
		$filter = "";

		// Get command
		$this->Command = strtolower(Get("cmd"));
		if ($this->isPageRequest()) { // Validate request

			// Set up records per page
			$this->setupDisplayRecords();

			// Handle reset command
			$this->resetCmd();

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->isGridAdd() || $this->isGridEdit()) {
					$item = $this->ListOptions["griddelete"];
					if ($item)
						$item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->setupSortOrder();
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
		if ($this->isGridAdd()) {
			if ($this->CurrentMode == "copy") {
				$selectLimit = $this->UseSelectLimit;
				if ($selectLimit) {
					$this->TotalRecords = $this->listRecordCount();
					$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
				} else {
					if ($this->Recordset = $this->loadRecordset())
						$this->TotalRecords = $this->Recordset->RecordCount();
				}
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->TotalRecords;
			} else {
				$this->CurrentFilter = "0=1";
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->GridAddRowCount;
			}
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
			$this->DisplayRecords = $this->TotalRecords; // Display all records
			if ($selectLimit)
				$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
		}

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

	// Switch to Grid Edit mode
	protected function gridEditMode()
	{
		$this->CurrentAction = "gridedit";
		$_SESSION[SESSION_INLINE_MODE] = "gridedit";
		$this->hideFieldsForAddEdit();
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

			// Get new recordset
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->clearInlineMode(); // Clear inline edit mode
		} else {
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
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
				$this->loadOldRecord(); // Load old record
			}
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
			$this->clearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($gridInsert) {

			// Get new recordset
			$this->CurrentFilter = $wrkfilter;
			$sql = $this->getCurrentSql();
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->clearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
		}
		return $gridInsert;
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

	// Set up sort parameters
	protected function setupSortOrder()
	{

		// Check for "order" parameter
		if (Get("order") !== NULL) {
			$this->CurrentOrder = Get("order");
			$this->CurrentOrderType = Get("ordertype", "");
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

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;

		//$this->ListOptions->ButtonClass = ""; // Class for button group
		// Call ListOptions_Load event

		$this->ListOptions_Load();
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
			if ($CurrentForm->hasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
			if ($this->RowOldKey != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($this->RowOldKey) . "\">";
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
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
		if ($this->CurrentMode == "view") { // View mode

		// "edit"
		$opt = $this->ListOptions["edit"];
		$editcaption = HtmlTitle($Language->phrase("EditLink"));
		if ($Security->canEdit()) {
			$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode($this->EditUrl) . "\">" . $Language->phrase("EditLink") . "</a>";
		} else {
			$opt->Body = "";
		}
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex) && $this->RowAction != "delete") {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->idProcess->CurrentValue . "\">";
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_hash\" id=\"k" . $this->RowIndex . "_hash\" value=\"" . $this->HashValue . "\">";
		}
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	public function setRecordKey(&$key, $rs)
	{
		$key = "";
		if ($key != "")
			$key .= Config("COMPOSITE_KEY_SEPARATOR");
		$key .= $rs->fields('idProcess');
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$option = $this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;

		//$option->ButtonClass = ""; // Class for button group
		$item = &$option->add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->add("add");
			$addcaption = HtmlTitle($Language->phrase("AddLink"));
			$this->AddUrl = $this->getAddUrl();
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode($this->AddUrl) . "\">" . $Language->phrase("AddLink") . "</a>";
			$item->Visible = $this->AddUrl != "" && $Security->canAdd();
		}
	}

	// Render other options
	public function renderOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = $options["addedit"];
				$option->UseDropDownButton = FALSE;
				$item = &$option->add("addblankrow");
				$item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->canAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = $options["addedit"];
			$item = $option["add"];
			$this->ShowOtherOptions = $item && $item->Visible;
		}
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

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
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

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;
		$CurrentForm->FormName = $this->FormName;

		// Check field name 'fmea' first before field var 'x_fmea'
		$val = $CurrentForm->hasValue("fmea") ? $CurrentForm->getValue("fmea") : $CurrentForm->getValue("x_fmea");
		if (!$this->fmea->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->fmea->Visible = FALSE; // Disable update for API request
			else
				$this->fmea->setFormValue($val);
		}
		$this->fmea->setOldValue($CurrentForm->getValue("o_fmea"));

		// Check field name 'step' first before field var 'x_step'
		$val = $CurrentForm->hasValue("step") ? $CurrentForm->getValue("step") : $CurrentForm->getValue("x_step");
		if (!$this->step->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->step->Visible = FALSE; // Disable update for API request
			else
				$this->step->setFormValue($val);
		}
		$this->step->setOldValue($CurrentForm->getValue("o_step"));

		// Check field name 'flowchartDesc' first before field var 'x_flowchartDesc'
		$val = $CurrentForm->hasValue("flowchartDesc") ? $CurrentForm->getValue("flowchartDesc") : $CurrentForm->getValue("x_flowchartDesc");
		if (!$this->flowchartDesc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->flowchartDesc->Visible = FALSE; // Disable update for API request
			else
				$this->flowchartDesc->setFormValue($val);
		}
		$this->flowchartDesc->setOldValue($CurrentForm->getValue("o_flowchartDesc"));

		// Check field name 'partnumber' first before field var 'x_partnumber'
		$val = $CurrentForm->hasValue("partnumber") ? $CurrentForm->getValue("partnumber") : $CurrentForm->getValue("x_partnumber");
		if (!$this->partnumber->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->partnumber->Visible = FALSE; // Disable update for API request
			else
				$this->partnumber->setFormValue($val);
		}
		$this->partnumber->setOldValue($CurrentForm->getValue("o_partnumber"));

		// Check field name 'operation' first before field var 'x_operation'
		$val = $CurrentForm->hasValue("operation") ? $CurrentForm->getValue("operation") : $CurrentForm->getValue("x_operation");
		if (!$this->operation->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->operation->Visible = FALSE; // Disable update for API request
			else
				$this->operation->setFormValue($val);
		}
		$this->operation->setOldValue($CurrentForm->getValue("o_operation"));

		// Check field name 'derivedFromNC' first before field var 'x_derivedFromNC'
		$val = $CurrentForm->hasValue("derivedFromNC") ? $CurrentForm->getValue("derivedFromNC") : $CurrentForm->getValue("x_derivedFromNC");
		if (!$this->derivedFromNC->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->derivedFromNC->Visible = FALSE; // Disable update for API request
			else
				$this->derivedFromNC->setFormValue($val);
		}
		$this->derivedFromNC->setOldValue($CurrentForm->getValue("o_derivedFromNC"));

		// Check field name 'numberOfNC' first before field var 'x_numberOfNC'
		$val = $CurrentForm->hasValue("numberOfNC") ? $CurrentForm->getValue("numberOfNC") : $CurrentForm->getValue("x_numberOfNC");
		if (!$this->numberOfNC->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->numberOfNC->Visible = FALSE; // Disable update for API request
			else
				$this->numberOfNC->setFormValue($val);
		}
		$this->numberOfNC->setOldValue($CurrentForm->getValue("o_numberOfNC"));

		// Check field name 'flowchart' first before field var 'x_flowchart'
		$val = $CurrentForm->hasValue("flowchart") ? $CurrentForm->getValue("flowchart") : $CurrentForm->getValue("x_flowchart");
		if (!$this->flowchart->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->flowchart->Visible = FALSE; // Disable update for API request
			else
				$this->flowchart->setFormValue($val);
		}
		$this->flowchart->setOldValue($CurrentForm->getValue("o_flowchart"));

		// Check field name 'subprocess' first before field var 'x_subprocess'
		$val = $CurrentForm->hasValue("subprocess") ? $CurrentForm->getValue("subprocess") : $CurrentForm->getValue("x_subprocess");
		if (!$this->subprocess->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->subprocess->Visible = FALSE; // Disable update for API request
			else
				$this->subprocess->setFormValue($val);
		}
		$this->subprocess->setOldValue($CurrentForm->getValue("o_subprocess"));

		// Check field name 'requirement' first before field var 'x_requirement'
		$val = $CurrentForm->hasValue("requirement") ? $CurrentForm->getValue("requirement") : $CurrentForm->getValue("x_requirement");
		if (!$this->requirement->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->requirement->Visible = FALSE; // Disable update for API request
			else
				$this->requirement->setFormValue($val);
		}
		$this->requirement->setOldValue($CurrentForm->getValue("o_requirement"));

		// Check field name 'potencialFailureMode' first before field var 'x_potencialFailureMode'
		$val = $CurrentForm->hasValue("potencialFailureMode") ? $CurrentForm->getValue("potencialFailureMode") : $CurrentForm->getValue("x_potencialFailureMode");
		if (!$this->potencialFailureMode->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->potencialFailureMode->Visible = FALSE; // Disable update for API request
			else
				$this->potencialFailureMode->setFormValue($val);
		}
		$this->potencialFailureMode->setOldValue($CurrentForm->getValue("o_potencialFailureMode"));

		// Check field name 'potencialFailurEffect' first before field var 'x_potencialFailurEffect'
		$val = $CurrentForm->hasValue("potencialFailurEffect") ? $CurrentForm->getValue("potencialFailurEffect") : $CurrentForm->getValue("x_potencialFailurEffect");
		if (!$this->potencialFailurEffect->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->potencialFailurEffect->Visible = FALSE; // Disable update for API request
			else
				$this->potencialFailurEffect->setFormValue($val);
		}
		$this->potencialFailurEffect->setOldValue($CurrentForm->getValue("o_potencialFailurEffect"));

		// Check field name 'kc' first before field var 'x_kc'
		$val = $CurrentForm->hasValue("kc") ? $CurrentForm->getValue("kc") : $CurrentForm->getValue("x_kc");
		if (!$this->kc->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->kc->Visible = FALSE; // Disable update for API request
			else
				$this->kc->setFormValue($val);
		}
		$this->kc->setOldValue($CurrentForm->getValue("o_kc"));

		// Check field name 'severity' first before field var 'x_severity'
		$val = $CurrentForm->hasValue("severity") ? $CurrentForm->getValue("severity") : $CurrentForm->getValue("x_severity");
		if (!$this->severity->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->severity->Visible = FALSE; // Disable update for API request
			else
				$this->severity->setFormValue($val);
		}
		$this->severity->setOldValue($CurrentForm->getValue("o_severity"));

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
		$keys = [$this->RowOldKey];
		$cnt = count($keys);
		if ($cnt >= 1) {
			if (strval($keys[0]) != "")
				$this->idProcess->OldValue = strval($keys[0]); // idProcess
			else
				$validKey = FALSE;
		} else {
			$validKey = FALSE;
		}

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
		$this->CopyUrl = $this->getCopyUrl();
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
				$this->fmea->OldValue = $this->fmea->CurrentValue;
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
				$this->fmea->OldValue = $this->fmea->CurrentValue;
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

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

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

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "fmea") {
				$this->fmea->CurrentValue = $this->fmea->getSessionValue();
			}

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

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{

		// Hide foreign keys
		$masterTblVar = $this->getCurrentMasterTable();
		if ($masterTblVar == "fmea") {
			$this->fmea->Visible = FALSE;
			if ($GLOBALS["fmea"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
} // End class
?>