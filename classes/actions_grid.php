<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class actions_grid extends actions
{

	// Page ID
	public $PageID = "grid";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'actions';

	// Page object name
	public $PageObjName = "actions_grid";

	// Grid form hidden field names
	public $FormName = "factionsgrid";
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

		// Table object (actions)
		if (!isset($GLOBALS["actions"]) || get_class($GLOBALS["actions"]) == PROJECT_NAMESPACE . "actions") {
			$GLOBALS["actions"] = &$this;

			// $GLOBALS["MasterTable"] = &$GLOBALS["Table"];
			// if (!isset($GLOBALS["Table"]))
			// 	$GLOBALS["Table"] = &$GLOBALS["actions"];

		}
		$this->AddUrl = "actionsadd.php";

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'grid');

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
		global $actions;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
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

		// Set up lookup cache
		$this->setupLookupOptions($this->idCause);
		$this->setupLookupOptions($this->idResponsible);
		$this->setupLookupOptions($this->idResponsibleDet);

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
				$this->idProcess->setSessionValue("");
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
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex) && $this->RowAction != "delete") {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->idProcess->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->idCause->CurrentValue . "\">";
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
		if ($key != "")
			$key .= Config("COMPOSITE_KEY_SEPARATOR");
		$key .= $rs->fields('idCause');
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

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;
		$CurrentForm->FormName = $this->FormName;

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
		if (!$this->isOverwrite())
			$this->HashValue = $CurrentForm->getValue("k_hash");
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
		$keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->RowOldKey);
		$cnt = count($keys);
		if ($cnt >= 2) {
			if (strval($keys[0]) != "")
				$this->idProcess->OldValue = strval($keys[0]); // idProcess
			else
				$validKey = FALSE;
			if (strval($keys[1]) != "")
				$this->idCause->OldValue = strval($keys[1]); // idCause
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
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// idProcess
			$this->idProcess->EditAttrs["class"] = "form-control";
			$this->idProcess->EditCustomAttributes = "";
			$this->idProcess->EditValue = HtmlEncode($this->idProcess->CurrentValue);
			$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());

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
			$this->RPNCalc->EditValue = $this->RPNCalc->CurrentValue;
			$this->RPNCalc->EditValue = FormatNumber($this->RPNCalc->EditValue, 0, -2, -2, -2);
			$this->RPNCalc->ViewCustomAttributes = "";

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
			$this->expectedRPNPAO->EditValue = $this->expectedRPNPAO->CurrentValue;
			$this->expectedRPNPAO->EditValue = FormatNumber($this->expectedRPNPAO->EditValue, 0, -2, -2, -2);
			$this->expectedRPNPAO->ViewCustomAttributes = "";

			// expectedClosureDate
			$this->expectedClosureDate->EditAttrs["class"] = "form-control";
			$this->expectedClosureDate->EditCustomAttributes = "";
			$this->expectedClosureDate->EditValue = $this->expectedClosureDate->CurrentValue;
			$this->expectedClosureDate->EditValue = FormatDateTime($this->expectedClosureDate->EditValue, 12);
			$this->expectedClosureDate->ViewCustomAttributes = "";

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
			$this->expectedRPNPAD->EditValue = $this->expectedRPNPAD->CurrentValue;
			$this->expectedRPNPAD->EditValue = FormatNumber($this->expectedRPNPAD->EditValue, 0, -2, -2, -2);
			$this->expectedRPNPAD->ViewCustomAttributes = "";

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
			$this->revisedRPNCalc->EditValue = $this->revisedRPNCalc->CurrentValue;
			$this->revisedRPNCalc->EditValue = FormatNumber($this->revisedRPNCalc->EditValue, 0, -2, -2, -2);
			$this->revisedRPNCalc->ViewCustomAttributes = "";

			// Edit refer script
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
			$this->severity->TooltipValue = "";

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
			$this->RPNCalc->TooltipValue = "";

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
			$this->expectedRPNPAO->TooltipValue = "";

			// expectedClosureDate
			$this->expectedClosureDate->LinkCustomAttributes = "";
			$this->expectedClosureDate->HrefValue = "";
			$this->expectedClosureDate->TooltipValue = "";

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
			$this->expectedRPNPAD->TooltipValue = "";

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
			$this->revisedRPNCalc->TooltipValue = "";
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

			// idProcess
			$this->idProcess->setDbValueDef($rsnew, $this->idProcess->CurrentValue, 0, $this->idProcess->ReadOnly);

			// idCause
			$this->idCause->setDbValueDef($rsnew, $this->idCause->CurrentValue, "", $this->idCause->ReadOnly);

			// potentialCauses
			$this->potentialCauses->setDbValueDef($rsnew, $this->potentialCauses->CurrentValue, NULL, $this->potentialCauses->ReadOnly);

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->setDbValueDef($rsnew, $this->currentPreventiveControlMethod->CurrentValue, NULL, $this->currentPreventiveControlMethod->ReadOnly);

			// occurrence
			$this->occurrence->setDbValueDef($rsnew, $this->occurrence->CurrentValue, NULL, $this->occurrence->ReadOnly);

			// currentControlMethod
			$this->currentControlMethod->setDbValueDef($rsnew, $this->currentControlMethod->CurrentValue, NULL, $this->currentControlMethod->ReadOnly);

			// detection
			$this->detection->setDbValueDef($rsnew, $this->detection->CurrentValue, NULL, $this->detection->ReadOnly);

			// recomendedAction
			$this->recomendedAction->setDbValueDef($rsnew, $this->recomendedAction->CurrentValue, NULL, $this->recomendedAction->ReadOnly);

			// idResponsible
			$this->idResponsible->setDbValueDef($rsnew, $this->idResponsible->CurrentValue, NULL, $this->idResponsible->ReadOnly);

			// targetDate
			$this->targetDate->setDbValueDef($rsnew, UnFormatDateTime($this->targetDate->CurrentValue, 14), NULL, $this->targetDate->ReadOnly);

			// revisedKc
			$tmpBool = $this->revisedKc->CurrentValue;
			if ($tmpBool != "1" && $tmpBool != "0")
				$tmpBool = !empty($tmpBool) ? "1" : "0";
			$this->revisedKc->setDbValueDef($rsnew, $tmpBool, NULL, $this->revisedKc->ReadOnly);

			// expectedSeverity
			$this->expectedSeverity->setDbValueDef($rsnew, $this->expectedSeverity->CurrentValue, NULL, $this->expectedSeverity->ReadOnly);

			// expectedOccurrence
			$this->expectedOccurrence->setDbValueDef($rsnew, $this->expectedOccurrence->CurrentValue, NULL, $this->expectedOccurrence->ReadOnly);

			// expectedDetection
			$this->expectedDetection->setDbValueDef($rsnew, $this->expectedDetection->CurrentValue, NULL, $this->expectedDetection->ReadOnly);

			// recomendedActiondet
			$this->recomendedActiondet->setDbValueDef($rsnew, $this->recomendedActiondet->CurrentValue, NULL, $this->recomendedActiondet->ReadOnly);

			// idResponsibleDet
			$this->idResponsibleDet->setDbValueDef($rsnew, $this->idResponsibleDet->CurrentValue, NULL, $this->idResponsibleDet->ReadOnly);

			// targetDatedet
			$this->targetDatedet->setDbValueDef($rsnew, UnFormatDateTime($this->targetDatedet->CurrentValue, 14), NULL, $this->targetDatedet->ReadOnly);

			// kcdet
			$tmpBool = $this->kcdet->CurrentValue;
			if ($tmpBool != "1" && $tmpBool != "0")
				$tmpBool = !empty($tmpBool) ? "1" : "0";
			$this->kcdet->setDbValueDef($rsnew, $tmpBool, NULL, $this->kcdet->ReadOnly);

			// expectedSeveritydet
			$this->expectedSeveritydet->setDbValueDef($rsnew, $this->expectedSeveritydet->CurrentValue, NULL, $this->expectedSeveritydet->ReadOnly);

			// expectedOccurrencedet
			$this->expectedOccurrencedet->setDbValueDef($rsnew, $this->expectedOccurrencedet->CurrentValue, NULL, $this->expectedOccurrencedet->ReadOnly);

			// expectedDetectiondet
			$this->expectedDetectiondet->setDbValueDef($rsnew, $this->expectedDetectiondet->CurrentValue, NULL, $this->expectedDetectiondet->ReadOnly);

			// revisedClosureDatedet
			$this->revisedClosureDatedet->setDbValueDef($rsnew, UnFormatDateTime($this->revisedClosureDatedet->CurrentValue, 14), NULL, $this->revisedClosureDatedet->ReadOnly);

			// revisedSeverity
			$this->revisedSeverity->setDbValueDef($rsnew, $this->revisedSeverity->CurrentValue, NULL, $this->revisedSeverity->ReadOnly);

			// revisedOccurrence
			$this->revisedOccurrence->setDbValueDef($rsnew, $this->revisedOccurrence->CurrentValue, NULL, $this->revisedOccurrence->ReadOnly);

			// revisedDetection
			$this->revisedDetection->setDbValueDef($rsnew, $this->revisedDetection->CurrentValue, NULL, $this->revisedDetection->ReadOnly);

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

			// Check referential integrity for master table 'processf'
			$validMasterRecord = TRUE;
			$masterFilter = $this->sqlMasterFilter_processf();
			$keyValue = isset($rsnew['idProcess']) ? $rsnew['idProcess'] : $rsold['idProcess'];
			if (strval($keyValue) != "") {
				$masterFilter = str_replace("@idProcess@", AdjustSql($keyValue), $masterFilter);
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
		$hash .= GetFieldHash($rs->fields('idProcess')); // idProcess
		$hash .= GetFieldHash($rs->fields('idCause')); // idCause
		$hash .= GetFieldHash($rs->fields('potentialCauses')); // potentialCauses
		$hash .= GetFieldHash($rs->fields('currentPreventiveControlMethod')); // currentPreventiveControlMethod
		$hash .= GetFieldHash($rs->fields('occurrence')); // occurrence
		$hash .= GetFieldHash($rs->fields('currentControlMethod')); // currentControlMethod
		$hash .= GetFieldHash($rs->fields('detection')); // detection
		$hash .= GetFieldHash($rs->fields('recomendedAction')); // recomendedAction
		$hash .= GetFieldHash($rs->fields('idResponsible')); // idResponsible
		$hash .= GetFieldHash($rs->fields('targetDate')); // targetDate
		$hash .= GetFieldHash($rs->fields('revisedKc')); // revisedKc
		$hash .= GetFieldHash($rs->fields('expectedSeverity')); // expectedSeverity
		$hash .= GetFieldHash($rs->fields('expectedOccurrence')); // expectedOccurrence
		$hash .= GetFieldHash($rs->fields('expectedDetection')); // expectedDetection
		$hash .= GetFieldHash($rs->fields('recomendedActiondet')); // recomendedActiondet
		$hash .= GetFieldHash($rs->fields('idResponsibleDet')); // idResponsibleDet
		$hash .= GetFieldHash($rs->fields('targetDatedet')); // targetDatedet
		$hash .= GetFieldHash($rs->fields('kcdet')); // kcdet
		$hash .= GetFieldHash($rs->fields('expectedSeveritydet')); // expectedSeveritydet
		$hash .= GetFieldHash($rs->fields('expectedOccurrencedet')); // expectedOccurrencedet
		$hash .= GetFieldHash($rs->fields('expectedDetectiondet')); // expectedDetectiondet
		$hash .= GetFieldHash($rs->fields('revisedClosureDatedet')); // revisedClosureDatedet
		$hash .= GetFieldHash($rs->fields('revisedSeverity')); // revisedSeverity
		$hash .= GetFieldHash($rs->fields('revisedOccurrence')); // revisedOccurrence
		$hash .= GetFieldHash($rs->fields('revisedDetection')); // revisedDetection
		return md5($hash);
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "processf") {
				$this->idProcess->CurrentValue = $this->idProcess->getSessionValue();
			}

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

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{

		// Hide foreign keys
		$masterTblVar = $this->getCurrentMasterTable();
		if ($masterTblVar == "processf") {
			$this->idProcess->Visible = FALSE;
			if ($GLOBALS["processf"]->EventCancelled)
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