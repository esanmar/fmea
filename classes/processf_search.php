<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class processf_search extends processf
{

	// Page ID
	public $PageID = "search";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'processf';

	// Page object name
	public $PageObjName = "processf_search";

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

		// Table object (fmea)
		if (!isset($GLOBALS['fmea']))
			$GLOBALS['fmea'] = new fmea();

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'search');

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url, "modal" => "1"];
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "processfview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
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
	public $FormClassName = "ew-horizontal ew-form ew-search-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$SearchError, $SkipHeaderFooter;

		// Is modal
		$this->IsModal = (Param("modal") == "1");

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
			if (!$Security->canSearch()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("processflist.php"));
				else
					$this->terminate(GetUrl("login.php"));
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
		$this->CurrentAction = Param("action"); // Set up current action
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

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

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

		// Set up lookup cache
		$this->setupLookupOptions($this->fmea);

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		if ($this->isPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = Post("action");
			if ($this->isSearch()) {

				// Build search string for advanced search, remove blank field
				$this->loadSearchValues(); // Get search values
				if ($this->validateSearch()) {
					$srchStr = $this->buildAdvancedSearch();
				} else {
					$srchStr = "";
					$this->setFailureMessage($SearchError);
				}
				if ($srchStr != "") {
					$srchStr = $this->getUrlParm($srchStr);
					$srchStr = "processflist.php" . "?" . $srchStr;
					$this->terminate($srchStr); // Go to list page
				}
			}
		}

		// Restore search settings from Session
		if ($SearchError == "")
			$this->loadAdvancedSearch();

		// Render row for search
		$this->RowType = ROWTYPE_SEARCH;
		$this->resetAttributes();
		$this->renderRow();
	}

	// Build advanced search
	protected function buildAdvancedSearch()
	{
		$srchUrl = "";
		$this->buildSearchUrl($srchUrl, $this->fmea); // fmea
		$this->buildSearchUrl($srchUrl, $this->step); // step
		$this->buildSearchUrl($srchUrl, $this->flowchartDesc); // flowchartDesc
		$this->buildSearchUrl($srchUrl, $this->partnumber); // partnumber
		$this->buildSearchUrl($srchUrl, $this->operation); // operation
		$this->buildSearchUrl($srchUrl, $this->derivedFromNC, TRUE); // derivedFromNC
		$this->buildSearchUrl($srchUrl, $this->numberOfNC); // numberOfNC
		$this->buildSearchUrl($srchUrl, $this->flowchart); // flowchart
		$this->buildSearchUrl($srchUrl, $this->subprocess); // subprocess
		$this->buildSearchUrl($srchUrl, $this->requirement); // requirement
		$this->buildSearchUrl($srchUrl, $this->potencialFailureMode); // potencialFailureMode
		$this->buildSearchUrl($srchUrl, $this->potencialFailurEffect); // potencialFailurEffect
		$this->buildSearchUrl($srchUrl, $this->kc, TRUE); // kc
		$this->buildSearchUrl($srchUrl, $this->severity); // severity
		if ($srchUrl != "")
			$srchUrl .= "&";
		$srchUrl .= "cmd=search";
		return $srchUrl;
	}

	// Build search URL
	protected function buildSearchUrl(&$url, &$fld, $oprOnly = FALSE)
	{
		global $CurrentForm;
		$wrk = "";
		$fldParm = $fld->Param;
		$fldVal = $CurrentForm->getValue("x_$fldParm");
		$fldOpr = $CurrentForm->getValue("z_$fldParm");
		$fldCond = $CurrentForm->getValue("v_$fldParm");
		$fldVal2 = $CurrentForm->getValue("y_$fldParm");
		$fldOpr2 = $CurrentForm->getValue("w_$fldParm");
		if (is_array($fldVal))
			$fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
		if (is_array($fldVal2))
			$fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
		$fldOpr = strtoupper(trim($fldOpr));
		$fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
		if ($fldOpr == "BETWEEN") {
			$isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
				($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
			if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
				$wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
					"&y_" . $fldParm . "=" . urlencode($fldVal2) .
					"&z_" . $fldParm . "=" . urlencode($fldOpr);
			}
		} else {
			$isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
				($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
			if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
				$wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
					"&z_" . $fldParm . "=" . urlencode($fldOpr);
			} elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
				$wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
			}
			$isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
				($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
			if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
				if ($wrk != "")
					$wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
				$wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
					"&w_" . $fldParm . "=" . urlencode($fldOpr2);
			} elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
				if ($wrk != "")
					$wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
				$wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
			}
		}
		if ($wrk != "") {
			if ($url != "")
				$url .= "&";
			$url .= $wrk;
		}
	}
	protected function searchValueIsNumeric($fld, $value)
	{
		if (IsFloatFormat($fld->Type))
			$value = ConvertToFloatString($value);
		return is_numeric($value);
	}

	// Load search values for validation
	protected function loadSearchValues()
	{

		// Load search values
		$got = FALSE;
		if ($this->fmea->AdvancedSearch->post())
			$got = TRUE;
		if ($this->step->AdvancedSearch->post())
			$got = TRUE;
		if ($this->flowchartDesc->AdvancedSearch->post())
			$got = TRUE;
		if ($this->partnumber->AdvancedSearch->post())
			$got = TRUE;
		if ($this->operation->AdvancedSearch->post())
			$got = TRUE;
		if ($this->derivedFromNC->AdvancedSearch->post())
			$got = TRUE;
		if (is_array($this->derivedFromNC->AdvancedSearch->SearchValue))
			$this->derivedFromNC->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->derivedFromNC->AdvancedSearch->SearchValue);
		if (is_array($this->derivedFromNC->AdvancedSearch->SearchValue2))
			$this->derivedFromNC->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->derivedFromNC->AdvancedSearch->SearchValue2);
		if ($this->numberOfNC->AdvancedSearch->post())
			$got = TRUE;
		if ($this->flowchart->AdvancedSearch->post())
			$got = TRUE;
		if ($this->subprocess->AdvancedSearch->post())
			$got = TRUE;
		if ($this->requirement->AdvancedSearch->post())
			$got = TRUE;
		if ($this->potencialFailureMode->AdvancedSearch->post())
			$got = TRUE;
		if ($this->potencialFailurEffect->AdvancedSearch->post())
			$got = TRUE;
		if ($this->kc->AdvancedSearch->post())
			$got = TRUE;
		if (is_array($this->kc->AdvancedSearch->SearchValue))
			$this->kc->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kc->AdvancedSearch->SearchValue);
		if (is_array($this->kc->AdvancedSearch->SearchValue2))
			$this->kc->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kc->AdvancedSearch->SearchValue2);
		if ($this->severity->AdvancedSearch->post())
			$got = TRUE;
		return $got;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
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

			// derivedFromNC
			$this->derivedFromNC->LinkCustomAttributes = "";
			$this->derivedFromNC->HrefValue = "";
			$this->derivedFromNC->TooltipValue = "";

			// numberOfNC
			$this->numberOfNC->LinkCustomAttributes = "";
			$this->numberOfNC->HrefValue = "";
			$this->numberOfNC->TooltipValue = "";

			// flowchart
			$this->flowchart->LinkCustomAttributes = "";
			$this->flowchart->HrefValue = "";
			$this->flowchart->TooltipValue = "";

			// subprocess
			$this->subprocess->LinkCustomAttributes = "";
			$this->subprocess->HrefValue = "";
			$this->subprocess->TooltipValue = "";

			// requirement
			$this->requirement->LinkCustomAttributes = "";
			$this->requirement->HrefValue = "";
			$this->requirement->TooltipValue = "";

			// potencialFailureMode
			$this->potencialFailureMode->LinkCustomAttributes = "";
			$this->potencialFailureMode->HrefValue = "";
			$this->potencialFailureMode->TooltipValue = "";

			// potencialFailurEffect
			$this->potencialFailurEffect->LinkCustomAttributes = "";
			$this->potencialFailurEffect->HrefValue = "";
			$this->potencialFailurEffect->TooltipValue = "";

			// kc
			$this->kc->LinkCustomAttributes = "";
			$this->kc->HrefValue = "";
			$this->kc->TooltipValue = "";

			// severity
			$this->severity->LinkCustomAttributes = "";
			$this->severity->HrefValue = "";
			$this->severity->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_SEARCH) { // Search row

			// fmea
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			if (!$this->fmea->Raw)
				$this->fmea->AdvancedSearch->SearchValue = HtmlDecode($this->fmea->AdvancedSearch->SearchValue);
			$this->fmea->EditValue = HtmlEncode($this->fmea->AdvancedSearch->SearchValue);
			$this->fmea->PlaceHolder = RemoveHtml($this->fmea->caption());
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			if (!$this->fmea->Raw)
				$this->fmea->AdvancedSearch->SearchValue2 = HtmlDecode($this->fmea->AdvancedSearch->SearchValue2);
			$this->fmea->EditValue2 = HtmlEncode($this->fmea->AdvancedSearch->SearchValue2);
			$this->fmea->PlaceHolder = RemoveHtml($this->fmea->caption());

			// step
			$this->step->EditAttrs["class"] = "form-control";
			$this->step->EditCustomAttributes = "";
			$this->step->EditValue = HtmlEncode($this->step->AdvancedSearch->SearchValue);
			$this->step->PlaceHolder = RemoveHtml($this->step->caption());

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

			// derivedFromNC
			$this->derivedFromNC->EditCustomAttributes = "";
			$this->derivedFromNC->EditValue = $this->derivedFromNC->options(FALSE);
			$this->derivedFromNC->EditCustomAttributes = "";
			$this->derivedFromNC->EditValue2 = $this->derivedFromNC->options(FALSE);

			// numberOfNC
			$this->numberOfNC->EditAttrs["class"] = "form-control";
			$this->numberOfNC->EditCustomAttributes = "";
			if (!$this->numberOfNC->Raw)
				$this->numberOfNC->AdvancedSearch->SearchValue = HtmlDecode($this->numberOfNC->AdvancedSearch->SearchValue);
			$this->numberOfNC->EditValue = HtmlEncode($this->numberOfNC->AdvancedSearch->SearchValue);
			$this->numberOfNC->PlaceHolder = RemoveHtml($this->numberOfNC->caption());
			$this->numberOfNC->EditAttrs["class"] = "form-control";
			$this->numberOfNC->EditCustomAttributes = "";
			if (!$this->numberOfNC->Raw)
				$this->numberOfNC->AdvancedSearch->SearchValue2 = HtmlDecode($this->numberOfNC->AdvancedSearch->SearchValue2);
			$this->numberOfNC->EditValue2 = HtmlEncode($this->numberOfNC->AdvancedSearch->SearchValue2);
			$this->numberOfNC->PlaceHolder = RemoveHtml($this->numberOfNC->caption());

			// flowchart
			$this->flowchart->EditAttrs["class"] = "form-control";
			$this->flowchart->EditCustomAttributes = "";
			if (!$this->flowchart->Raw)
				$this->flowchart->AdvancedSearch->SearchValue = HtmlDecode($this->flowchart->AdvancedSearch->SearchValue);
			$this->flowchart->EditValue = HtmlEncode($this->flowchart->AdvancedSearch->SearchValue);
			$this->flowchart->PlaceHolder = RemoveHtml($this->flowchart->caption());
			$this->flowchart->EditAttrs["class"] = "form-control";
			$this->flowchart->EditCustomAttributes = "";
			if (!$this->flowchart->Raw)
				$this->flowchart->AdvancedSearch->SearchValue2 = HtmlDecode($this->flowchart->AdvancedSearch->SearchValue2);
			$this->flowchart->EditValue2 = HtmlEncode($this->flowchart->AdvancedSearch->SearchValue2);
			$this->flowchart->PlaceHolder = RemoveHtml($this->flowchart->caption());

			// subprocess
			$this->subprocess->EditAttrs["class"] = "form-control";
			$this->subprocess->EditCustomAttributes = "";
			if (!$this->subprocess->Raw)
				$this->subprocess->AdvancedSearch->SearchValue = HtmlDecode($this->subprocess->AdvancedSearch->SearchValue);
			$this->subprocess->EditValue = HtmlEncode($this->subprocess->AdvancedSearch->SearchValue);
			$this->subprocess->PlaceHolder = RemoveHtml($this->subprocess->caption());
			$this->subprocess->EditAttrs["class"] = "form-control";
			$this->subprocess->EditCustomAttributes = "";
			if (!$this->subprocess->Raw)
				$this->subprocess->AdvancedSearch->SearchValue2 = HtmlDecode($this->subprocess->AdvancedSearch->SearchValue2);
			$this->subprocess->EditValue2 = HtmlEncode($this->subprocess->AdvancedSearch->SearchValue2);
			$this->subprocess->PlaceHolder = RemoveHtml($this->subprocess->caption());

			// requirement
			$this->requirement->EditAttrs["class"] = "form-control";
			$this->requirement->EditCustomAttributes = "";
			if (!$this->requirement->Raw)
				$this->requirement->AdvancedSearch->SearchValue = HtmlDecode($this->requirement->AdvancedSearch->SearchValue);
			$this->requirement->EditValue = HtmlEncode($this->requirement->AdvancedSearch->SearchValue);
			$this->requirement->PlaceHolder = RemoveHtml($this->requirement->caption());
			$this->requirement->EditAttrs["class"] = "form-control";
			$this->requirement->EditCustomAttributes = "";
			if (!$this->requirement->Raw)
				$this->requirement->AdvancedSearch->SearchValue2 = HtmlDecode($this->requirement->AdvancedSearch->SearchValue2);
			$this->requirement->EditValue2 = HtmlEncode($this->requirement->AdvancedSearch->SearchValue2);
			$this->requirement->PlaceHolder = RemoveHtml($this->requirement->caption());

			// potencialFailureMode
			$this->potencialFailureMode->EditAttrs["class"] = "form-control";
			$this->potencialFailureMode->EditCustomAttributes = "";
			if (!$this->potencialFailureMode->Raw)
				$this->potencialFailureMode->AdvancedSearch->SearchValue = HtmlDecode($this->potencialFailureMode->AdvancedSearch->SearchValue);
			$this->potencialFailureMode->EditValue = HtmlEncode($this->potencialFailureMode->AdvancedSearch->SearchValue);
			$this->potencialFailureMode->PlaceHolder = RemoveHtml($this->potencialFailureMode->caption());
			$this->potencialFailureMode->EditAttrs["class"] = "form-control";
			$this->potencialFailureMode->EditCustomAttributes = "";
			if (!$this->potencialFailureMode->Raw)
				$this->potencialFailureMode->AdvancedSearch->SearchValue2 = HtmlDecode($this->potencialFailureMode->AdvancedSearch->SearchValue2);
			$this->potencialFailureMode->EditValue2 = HtmlEncode($this->potencialFailureMode->AdvancedSearch->SearchValue2);
			$this->potencialFailureMode->PlaceHolder = RemoveHtml($this->potencialFailureMode->caption());

			// potencialFailurEffect
			$this->potencialFailurEffect->EditAttrs["class"] = "form-control";
			$this->potencialFailurEffect->EditCustomAttributes = "";
			if (!$this->potencialFailurEffect->Raw)
				$this->potencialFailurEffect->AdvancedSearch->SearchValue = HtmlDecode($this->potencialFailurEffect->AdvancedSearch->SearchValue);
			$this->potencialFailurEffect->EditValue = HtmlEncode($this->potencialFailurEffect->AdvancedSearch->SearchValue);
			$this->potencialFailurEffect->PlaceHolder = RemoveHtml($this->potencialFailurEffect->caption());
			$this->potencialFailurEffect->EditAttrs["class"] = "form-control";
			$this->potencialFailurEffect->EditCustomAttributes = "";
			if (!$this->potencialFailurEffect->Raw)
				$this->potencialFailurEffect->AdvancedSearch->SearchValue2 = HtmlDecode($this->potencialFailurEffect->AdvancedSearch->SearchValue2);
			$this->potencialFailurEffect->EditValue2 = HtmlEncode($this->potencialFailurEffect->AdvancedSearch->SearchValue2);
			$this->potencialFailurEffect->PlaceHolder = RemoveHtml($this->potencialFailurEffect->caption());

			// kc
			$this->kc->EditCustomAttributes = "";
			$this->kc->EditValue = $this->kc->options(FALSE);
			$this->kc->EditCustomAttributes = "";
			$this->kc->EditValue2 = $this->kc->options(FALSE);

			// severity
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue = HtmlEncode($this->severity->AdvancedSearch->SearchValue);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue2 = HtmlEncode($this->severity->AdvancedSearch->SearchValue2);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());
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
		if (!CheckInteger($this->step->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->step->errorMessage());
		}
		if (!CheckInteger($this->severity->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->severity->errorMessage());
		}
		if (!CheckInteger($this->severity->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->severity->errorMessage());
		}

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

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("processflist.php"), "", $this->TableVar, TRUE);
		$pageId = "search";
		$Breadcrumb->add("search", $pageId, $url);
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
} // End class
?>