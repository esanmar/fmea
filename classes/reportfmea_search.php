<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class reportfmea_search extends reportfmea
{

	// Page ID
	public $PageID = "search";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'reportfmea';

	// Page object name
	public $PageObjName = "reportfmea_search";

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

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'search');

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url, "modal" => "1"];
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "reportfmeaview.php")
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
					$this->terminate(GetUrl("reportfmealist.php"));
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
		$this->setupLookupOptions($this->idFactory);
		$this->setupLookupOptions($this->idEmployee);
		$this->setupLookupOptions($this->idworkcenter);
		$this->setupLookupOptions($this->idCause);

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
					$srchStr = "reportfmealist.php" . "?" . $srchStr;
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
		$this->buildSearchUrl($srchUrl, $this->idFactory); // idFactory
		$this->buildSearchUrl($srchUrl, $this->dateFmea); // dateFmea
		$this->buildSearchUrl($srchUrl, $this->partnumbers); // partnumbers
		$this->buildSearchUrl($srchUrl, $this->description); // description
		$this->buildSearchUrl($srchUrl, $this->idEmployee); // idEmployee
		$this->buildSearchUrl($srchUrl, $this->idworkcenter); // idworkcenter
		$this->buildSearchUrl($srchUrl, $this->idProcess); // idProcess
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
		$this->buildSearchUrl($srchUrl, $this->idCause); // idCause
		$this->buildSearchUrl($srchUrl, $this->potentialCauses); // potentialCauses
		$this->buildSearchUrl($srchUrl, $this->currentPreventiveControlMethod); // currentPreventiveControlMethod
		$this->buildSearchUrl($srchUrl, $this->occurrence); // occurrence
		$this->buildSearchUrl($srchUrl, $this->currentControlMethod); // currentControlMethod
		$this->buildSearchUrl($srchUrl, $this->detection); // detection
		$this->buildSearchUrl($srchUrl, $this->rpn); // rpn
		$this->buildSearchUrl($srchUrl, $this->recomendedAction); // recomendedAction
		$this->buildSearchUrl($srchUrl, $this->idResponsible); // idResponsible
		$this->buildSearchUrl($srchUrl, $this->targetDate); // targetDate
		$this->buildSearchUrl($srchUrl, $this->revisedKc, TRUE); // revisedKc
		$this->buildSearchUrl($srchUrl, $this->expectedSeverity); // expectedSeverity
		$this->buildSearchUrl($srchUrl, $this->expectedOccurrence); // expectedOccurrence
		$this->buildSearchUrl($srchUrl, $this->expectedDetection); // expectedDetection
		$this->buildSearchUrl($srchUrl, $this->expectedRpn); // expectedRpn
		$this->buildSearchUrl($srchUrl, $this->expectedClosureDate); // expectedClosureDate
		$this->buildSearchUrl($srchUrl, $this->recomendedActiondet); // recomendedActiondet
		$this->buildSearchUrl($srchUrl, $this->idResponsibleDet); // idResponsibleDet
		$this->buildSearchUrl($srchUrl, $this->targetDatedet); // targetDatedet
		$this->buildSearchUrl($srchUrl, $this->kcdet, TRUE); // kcdet
		$this->buildSearchUrl($srchUrl, $this->expectedSeveritydet); // expectedSeveritydet
		$this->buildSearchUrl($srchUrl, $this->expectedOccurrencedet); // expectedOccurrencedet
		$this->buildSearchUrl($srchUrl, $this->expectedDetectiondet); // expectedDetectiondet
		$this->buildSearchUrl($srchUrl, $this->expectedRpndet); // expectedRpndet
		$this->buildSearchUrl($srchUrl, $this->revisedClosureDatedet); // revisedClosureDatedet
		$this->buildSearchUrl($srchUrl, $this->revisedClosureDate); // revisedClosureDate
		$this->buildSearchUrl($srchUrl, $this->perfomedAction); // perfomedAction
		$this->buildSearchUrl($srchUrl, $this->revisedSeverity); // revisedSeverity
		$this->buildSearchUrl($srchUrl, $this->revisedOccurrence); // revisedOccurrence
		$this->buildSearchUrl($srchUrl, $this->revisedDetection); // revisedDetection
		$this->buildSearchUrl($srchUrl, $this->revisedRpn); // revisedRpn
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
		if ($this->idFactory->AdvancedSearch->post())
			$got = TRUE;
		if ($this->dateFmea->AdvancedSearch->post())
			$got = TRUE;
		if ($this->partnumbers->AdvancedSearch->post())
			$got = TRUE;
		if ($this->description->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idEmployee->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idworkcenter->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idProcess->AdvancedSearch->post())
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
		if ($this->idCause->AdvancedSearch->post())
			$got = TRUE;
		if ($this->potentialCauses->AdvancedSearch->post())
			$got = TRUE;
		if ($this->currentPreventiveControlMethod->AdvancedSearch->post())
			$got = TRUE;
		if ($this->occurrence->AdvancedSearch->post())
			$got = TRUE;
		if ($this->currentControlMethod->AdvancedSearch->post())
			$got = TRUE;
		if ($this->detection->AdvancedSearch->post())
			$got = TRUE;
		if ($this->rpn->AdvancedSearch->post())
			$got = TRUE;
		if ($this->recomendedAction->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idResponsible->AdvancedSearch->post())
			$got = TRUE;
		if ($this->targetDate->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedKc->AdvancedSearch->post())
			$got = TRUE;
		if (is_array($this->revisedKc->AdvancedSearch->SearchValue))
			$this->revisedKc->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->revisedKc->AdvancedSearch->SearchValue);
		if (is_array($this->revisedKc->AdvancedSearch->SearchValue2))
			$this->revisedKc->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->revisedKc->AdvancedSearch->SearchValue2);
		if ($this->expectedSeverity->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedOccurrence->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedDetection->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedRpn->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedClosureDate->AdvancedSearch->post())
			$got = TRUE;
		if ($this->recomendedActiondet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idResponsibleDet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->targetDatedet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->kcdet->AdvancedSearch->post())
			$got = TRUE;
		if (is_array($this->kcdet->AdvancedSearch->SearchValue))
			$this->kcdet->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kcdet->AdvancedSearch->SearchValue);
		if (is_array($this->kcdet->AdvancedSearch->SearchValue2))
			$this->kcdet->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->kcdet->AdvancedSearch->SearchValue2);
		if ($this->expectedSeveritydet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedOccurrencedet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedDetectiondet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedRpndet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedClosureDatedet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedClosureDate->AdvancedSearch->post())
			$got = TRUE;
		if ($this->perfomedAction->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedSeverity->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedOccurrence->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedDetection->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedRpn->AdvancedSearch->post())
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

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

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

			// idCause
			$this->idCause->LinkCustomAttributes = "";
			$this->idCause->HrefValue = "";
			$this->idCause->TooltipValue = "";

			// potentialCauses
			$this->potentialCauses->LinkCustomAttributes = "";
			$this->potentialCauses->HrefValue = "";
			$this->potentialCauses->TooltipValue = "";

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->LinkCustomAttributes = "";
			$this->currentPreventiveControlMethod->HrefValue = "";
			$this->currentPreventiveControlMethod->TooltipValue = "";

			// occurrence
			$this->occurrence->LinkCustomAttributes = "";
			$this->occurrence->HrefValue = "";
			$this->occurrence->TooltipValue = "";

			// currentControlMethod
			$this->currentControlMethod->LinkCustomAttributes = "";
			$this->currentControlMethod->HrefValue = "";
			$this->currentControlMethod->TooltipValue = "";

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

			// idResponsibleDet
			$this->idResponsibleDet->LinkCustomAttributes = "";
			$this->idResponsibleDet->HrefValue = "";
			$this->idResponsibleDet->TooltipValue = "";

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
		} elseif ($this->RowType == ROWTYPE_SEARCH) { // Search row

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
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			$curVal = trim(strval($this->fmea->AdvancedSearch->SearchValue2));
			if ($curVal != "")
				$this->fmea->AdvancedSearch->ViewValue2 = $this->fmea->lookupCacheOption($curVal);
			else
				$this->fmea->AdvancedSearch->ViewValue2 = $this->fmea->Lookup !== NULL && is_array($this->fmea->Lookup->Options) ? $curVal : NULL;
			if ($this->fmea->AdvancedSearch->ViewValue2 !== NULL) { // Load from cache
				$this->fmea->EditValue2 = array_values($this->fmea->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`fmea`" . SearchString("=", $this->fmea->AdvancedSearch->SearchValue2, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->fmea->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->fmea->EditValue2 = $arwrk;
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
			$this->idFactory->EditAttrs["class"] = "form-control";
			$this->idFactory->EditCustomAttributes = "";
			$curVal = trim(strval($this->idFactory->AdvancedSearch->SearchValue2));
			if ($curVal != "")
				$this->idFactory->AdvancedSearch->ViewValue2 = $this->idFactory->lookupCacheOption($curVal);
			else
				$this->idFactory->AdvancedSearch->ViewValue2 = $this->idFactory->Lookup !== NULL && is_array($this->idFactory->Lookup->Options) ? $curVal : NULL;
			if ($this->idFactory->AdvancedSearch->ViewValue2 !== NULL) { // Load from cache
				$this->idFactory->EditValue2 = array_values($this->idFactory->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idFactory`" . SearchString("=", $this->idFactory->AdvancedSearch->SearchValue2, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idFactory->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idFactory->EditValue2 = $arwrk;
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

			// partnumbers
			$this->partnumbers->EditAttrs["class"] = "form-control";
			$this->partnumbers->EditCustomAttributes = "";
			$this->partnumbers->EditValue = HtmlEncode($this->partnumbers->AdvancedSearch->SearchValue);
			$this->partnumbers->PlaceHolder = RemoveHtml($this->partnumbers->caption());
			$this->partnumbers->EditAttrs["class"] = "form-control";
			$this->partnumbers->EditCustomAttributes = "";
			$this->partnumbers->EditValue2 = HtmlEncode($this->partnumbers->AdvancedSearch->SearchValue2);
			$this->partnumbers->PlaceHolder = RemoveHtml($this->partnumbers->caption());

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = HtmlEncode($this->description->AdvancedSearch->SearchValue);
			$this->description->PlaceHolder = RemoveHtml($this->description->caption());
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue2 = HtmlEncode($this->description->AdvancedSearch->SearchValue2);
			$this->description->PlaceHolder = RemoveHtml($this->description->caption());

			// idEmployee
			$this->idEmployee->EditAttrs["class"] = "form-control";
			$this->idEmployee->EditCustomAttributes = "";
			$curVal = trim(strval($this->idEmployee->AdvancedSearch->SearchValue));
			if ($curVal != "")
				$this->idEmployee->AdvancedSearch->ViewValue = $this->idEmployee->lookupCacheOption($curVal);
			else
				$this->idEmployee->AdvancedSearch->ViewValue = $this->idEmployee->Lookup !== NULL && is_array($this->idEmployee->Lookup->Options) ? $curVal : NULL;
			if ($this->idEmployee->AdvancedSearch->ViewValue !== NULL) { // Load from cache
				$this->idEmployee->EditValue = array_values($this->idEmployee->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idEmployee`" . SearchString("=", $this->idEmployee->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idEmployee->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idEmployee->EditValue = $arwrk;
			}
			$this->idEmployee->EditAttrs["class"] = "form-control";
			$this->idEmployee->EditCustomAttributes = "";
			$curVal = trim(strval($this->idEmployee->AdvancedSearch->SearchValue2));
			if ($curVal != "")
				$this->idEmployee->AdvancedSearch->ViewValue2 = $this->idEmployee->lookupCacheOption($curVal);
			else
				$this->idEmployee->AdvancedSearch->ViewValue2 = $this->idEmployee->Lookup !== NULL && is_array($this->idEmployee->Lookup->Options) ? $curVal : NULL;
			if ($this->idEmployee->AdvancedSearch->ViewValue2 !== NULL) { // Load from cache
				$this->idEmployee->EditValue2 = array_values($this->idEmployee->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idEmployee`" . SearchString("=", $this->idEmployee->AdvancedSearch->SearchValue2, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idEmployee->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idEmployee->EditValue2 = $arwrk;
			}

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
			$this->idworkcenter->EditAttrs["class"] = "form-control";
			$this->idworkcenter->EditCustomAttributes = "";
			$curVal = trim(strval($this->idworkcenter->AdvancedSearch->SearchValue2));
			if ($curVal != "")
				$this->idworkcenter->AdvancedSearch->ViewValue2 = $this->idworkcenter->lookupCacheOption($curVal);
			else
				$this->idworkcenter->AdvancedSearch->ViewValue2 = $this->idworkcenter->Lookup !== NULL && is_array($this->idworkcenter->Lookup->Options) ? $curVal : NULL;
			if ($this->idworkcenter->AdvancedSearch->ViewValue2 !== NULL) { // Load from cache
				$this->idworkcenter->EditValue2 = array_values($this->idworkcenter->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`workcenter`" . SearchString("=", $this->idworkcenter->AdvancedSearch->SearchValue2, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idworkcenter->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idworkcenter->EditValue2 = $arwrk;
			}

			// idProcess
			$this->idProcess->EditAttrs["class"] = "form-control";
			$this->idProcess->EditCustomAttributes = "";
			$this->idProcess->EditValue = HtmlEncode($this->idProcess->AdvancedSearch->SearchValue);
			$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());
			$this->idProcess->EditAttrs["class"] = "form-control";
			$this->idProcess->EditCustomAttributes = "";
			$this->idProcess->EditValue2 = HtmlEncode($this->idProcess->AdvancedSearch->SearchValue2);
			$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());

			// step
			$this->step->EditAttrs["class"] = "form-control";
			$this->step->EditCustomAttributes = "";
			$this->step->EditValue = HtmlEncode($this->step->AdvancedSearch->SearchValue);
			$this->step->PlaceHolder = RemoveHtml($this->step->caption());
			$this->step->EditAttrs["class"] = "form-control";
			$this->step->EditCustomAttributes = "";
			$this->step->EditValue2 = HtmlEncode($this->step->AdvancedSearch->SearchValue2);
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

			// idCause
			$this->idCause->EditAttrs["class"] = "form-control";
			$this->idCause->EditCustomAttributes = "";
			$curVal = trim(strval($this->idCause->AdvancedSearch->SearchValue));
			if ($curVal != "")
				$this->idCause->AdvancedSearch->ViewValue = $this->idCause->lookupCacheOption($curVal);
			else
				$this->idCause->AdvancedSearch->ViewValue = $this->idCause->Lookup !== NULL && is_array($this->idCause->Lookup->Options) ? $curVal : NULL;
			if ($this->idCause->AdvancedSearch->ViewValue !== NULL) { // Load from cache
				$this->idCause->EditValue = array_values($this->idCause->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idCause`" . SearchString("=", $this->idCause->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idCause->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idCause->EditValue = $arwrk;
			}
			$this->idCause->EditAttrs["class"] = "form-control";
			$this->idCause->EditCustomAttributes = "";
			$curVal = trim(strval($this->idCause->AdvancedSearch->SearchValue2));
			if ($curVal != "")
				$this->idCause->AdvancedSearch->ViewValue2 = $this->idCause->lookupCacheOption($curVal);
			else
				$this->idCause->AdvancedSearch->ViewValue2 = $this->idCause->Lookup !== NULL && is_array($this->idCause->Lookup->Options) ? $curVal : NULL;
			if ($this->idCause->AdvancedSearch->ViewValue2 !== NULL) { // Load from cache
				$this->idCause->EditValue2 = array_values($this->idCause->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idCause`" . SearchString("=", $this->idCause->AdvancedSearch->SearchValue2, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idCause->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idCause->EditValue2 = $arwrk;
			}

			// potentialCauses
			$this->potentialCauses->EditAttrs["class"] = "form-control";
			$this->potentialCauses->EditCustomAttributes = "";
			$this->potentialCauses->EditValue = HtmlEncode($this->potentialCauses->AdvancedSearch->SearchValue);
			$this->potentialCauses->PlaceHolder = RemoveHtml($this->potentialCauses->caption());
			$this->potentialCauses->EditAttrs["class"] = "form-control";
			$this->potentialCauses->EditCustomAttributes = "";
			$this->potentialCauses->EditValue2 = HtmlEncode($this->potentialCauses->AdvancedSearch->SearchValue2);
			$this->potentialCauses->PlaceHolder = RemoveHtml($this->potentialCauses->caption());

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->EditAttrs["class"] = "form-control";
			$this->currentPreventiveControlMethod->EditCustomAttributes = "";
			if (!$this->currentPreventiveControlMethod->Raw)
				$this->currentPreventiveControlMethod->AdvancedSearch->SearchValue = HtmlDecode($this->currentPreventiveControlMethod->AdvancedSearch->SearchValue);
			$this->currentPreventiveControlMethod->EditValue = HtmlEncode($this->currentPreventiveControlMethod->AdvancedSearch->SearchValue);
			$this->currentPreventiveControlMethod->PlaceHolder = RemoveHtml($this->currentPreventiveControlMethod->caption());
			$this->currentPreventiveControlMethod->EditAttrs["class"] = "form-control";
			$this->currentPreventiveControlMethod->EditCustomAttributes = "";
			if (!$this->currentPreventiveControlMethod->Raw)
				$this->currentPreventiveControlMethod->AdvancedSearch->SearchValue2 = HtmlDecode($this->currentPreventiveControlMethod->AdvancedSearch->SearchValue2);
			$this->currentPreventiveControlMethod->EditValue2 = HtmlEncode($this->currentPreventiveControlMethod->AdvancedSearch->SearchValue2);
			$this->currentPreventiveControlMethod->PlaceHolder = RemoveHtml($this->currentPreventiveControlMethod->caption());

			// occurrence
			$this->occurrence->EditAttrs["class"] = "form-control";
			$this->occurrence->EditCustomAttributes = "";
			$this->occurrence->EditValue = HtmlEncode($this->occurrence->AdvancedSearch->SearchValue);
			$this->occurrence->PlaceHolder = RemoveHtml($this->occurrence->caption());
			$this->occurrence->EditAttrs["class"] = "form-control";
			$this->occurrence->EditCustomAttributes = "";
			$this->occurrence->EditValue2 = HtmlEncode($this->occurrence->AdvancedSearch->SearchValue2);
			$this->occurrence->PlaceHolder = RemoveHtml($this->occurrence->caption());

			// currentControlMethod
			$this->currentControlMethod->EditAttrs["class"] = "form-control";
			$this->currentControlMethod->EditCustomAttributes = "";
			if (!$this->currentControlMethod->Raw)
				$this->currentControlMethod->AdvancedSearch->SearchValue = HtmlDecode($this->currentControlMethod->AdvancedSearch->SearchValue);
			$this->currentControlMethod->EditValue = HtmlEncode($this->currentControlMethod->AdvancedSearch->SearchValue);
			$this->currentControlMethod->PlaceHolder = RemoveHtml($this->currentControlMethod->caption());
			$this->currentControlMethod->EditAttrs["class"] = "form-control";
			$this->currentControlMethod->EditCustomAttributes = "";
			if (!$this->currentControlMethod->Raw)
				$this->currentControlMethod->AdvancedSearch->SearchValue2 = HtmlDecode($this->currentControlMethod->AdvancedSearch->SearchValue2);
			$this->currentControlMethod->EditValue2 = HtmlEncode($this->currentControlMethod->AdvancedSearch->SearchValue2);
			$this->currentControlMethod->PlaceHolder = RemoveHtml($this->currentControlMethod->caption());

			// detection
			$this->detection->EditAttrs["class"] = "form-control";
			$this->detection->EditCustomAttributes = "";
			$this->detection->EditValue = HtmlEncode($this->detection->AdvancedSearch->SearchValue);
			$this->detection->PlaceHolder = RemoveHtml($this->detection->caption());
			$this->detection->EditAttrs["class"] = "form-control";
			$this->detection->EditCustomAttributes = "";
			$this->detection->EditValue2 = HtmlEncode($this->detection->AdvancedSearch->SearchValue2);
			$this->detection->PlaceHolder = RemoveHtml($this->detection->caption());

			// rpn
			$this->rpn->EditAttrs["class"] = "form-control";
			$this->rpn->EditCustomAttributes = "";
			$this->rpn->EditValue = HtmlEncode($this->rpn->AdvancedSearch->SearchValue);
			$this->rpn->PlaceHolder = RemoveHtml($this->rpn->caption());
			$this->rpn->EditAttrs["class"] = "form-control";
			$this->rpn->EditCustomAttributes = "";
			$this->rpn->EditValue2 = HtmlEncode($this->rpn->AdvancedSearch->SearchValue2);
			$this->rpn->PlaceHolder = RemoveHtml($this->rpn->caption());

			// recomendedAction
			$this->recomendedAction->EditAttrs["class"] = "form-control";
			$this->recomendedAction->EditCustomAttributes = "";
			$this->recomendedAction->EditValue = HtmlEncode($this->recomendedAction->AdvancedSearch->SearchValue);
			$this->recomendedAction->PlaceHolder = RemoveHtml($this->recomendedAction->caption());
			$this->recomendedAction->EditAttrs["class"] = "form-control";
			$this->recomendedAction->EditCustomAttributes = "";
			$this->recomendedAction->EditValue2 = HtmlEncode($this->recomendedAction->AdvancedSearch->SearchValue2);
			$this->recomendedAction->PlaceHolder = RemoveHtml($this->recomendedAction->caption());

			// idResponsible
			$this->idResponsible->EditAttrs["class"] = "form-control";
			$this->idResponsible->EditCustomAttributes = "";
			if (!$this->idResponsible->Raw)
				$this->idResponsible->AdvancedSearch->SearchValue = HtmlDecode($this->idResponsible->AdvancedSearch->SearchValue);
			$this->idResponsible->EditValue = HtmlEncode($this->idResponsible->AdvancedSearch->SearchValue);
			$this->idResponsible->PlaceHolder = RemoveHtml($this->idResponsible->caption());
			$this->idResponsible->EditAttrs["class"] = "form-control";
			$this->idResponsible->EditCustomAttributes = "";
			if (!$this->idResponsible->Raw)
				$this->idResponsible->AdvancedSearch->SearchValue2 = HtmlDecode($this->idResponsible->AdvancedSearch->SearchValue2);
			$this->idResponsible->EditValue2 = HtmlEncode($this->idResponsible->AdvancedSearch->SearchValue2);
			$this->idResponsible->PlaceHolder = RemoveHtml($this->idResponsible->caption());

			// targetDate
			$this->targetDate->EditAttrs["class"] = "form-control";
			$this->targetDate->EditCustomAttributes = "";
			$this->targetDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDate->AdvancedSearch->SearchValue, 0), 8));
			$this->targetDate->PlaceHolder = RemoveHtml($this->targetDate->caption());
			$this->targetDate->EditAttrs["class"] = "form-control";
			$this->targetDate->EditCustomAttributes = "";
			$this->targetDate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDate->AdvancedSearch->SearchValue2, 0), 8));
			$this->targetDate->PlaceHolder = RemoveHtml($this->targetDate->caption());

			// revisedKc
			$this->revisedKc->EditCustomAttributes = "";
			$this->revisedKc->EditValue = $this->revisedKc->options(FALSE);
			$this->revisedKc->EditCustomAttributes = "";
			$this->revisedKc->EditValue2 = $this->revisedKc->options(FALSE);

			// expectedSeverity
			$this->expectedSeverity->EditAttrs["class"] = "form-control";
			$this->expectedSeverity->EditCustomAttributes = "";
			$this->expectedSeverity->EditValue = HtmlEncode($this->expectedSeverity->AdvancedSearch->SearchValue);
			$this->expectedSeverity->PlaceHolder = RemoveHtml($this->expectedSeverity->caption());
			$this->expectedSeverity->EditAttrs["class"] = "form-control";
			$this->expectedSeverity->EditCustomAttributes = "";
			$this->expectedSeverity->EditValue2 = HtmlEncode($this->expectedSeverity->AdvancedSearch->SearchValue2);
			$this->expectedSeverity->PlaceHolder = RemoveHtml($this->expectedSeverity->caption());

			// expectedOccurrence
			$this->expectedOccurrence->EditAttrs["class"] = "form-control";
			$this->expectedOccurrence->EditCustomAttributes = "";
			$this->expectedOccurrence->EditValue = HtmlEncode($this->expectedOccurrence->AdvancedSearch->SearchValue);
			$this->expectedOccurrence->PlaceHolder = RemoveHtml($this->expectedOccurrence->caption());
			$this->expectedOccurrence->EditAttrs["class"] = "form-control";
			$this->expectedOccurrence->EditCustomAttributes = "";
			$this->expectedOccurrence->EditValue2 = HtmlEncode($this->expectedOccurrence->AdvancedSearch->SearchValue2);
			$this->expectedOccurrence->PlaceHolder = RemoveHtml($this->expectedOccurrence->caption());

			// expectedDetection
			$this->expectedDetection->EditAttrs["class"] = "form-control";
			$this->expectedDetection->EditCustomAttributes = "";
			$this->expectedDetection->EditValue = HtmlEncode($this->expectedDetection->AdvancedSearch->SearchValue);
			$this->expectedDetection->PlaceHolder = RemoveHtml($this->expectedDetection->caption());
			$this->expectedDetection->EditAttrs["class"] = "form-control";
			$this->expectedDetection->EditCustomAttributes = "";
			$this->expectedDetection->EditValue2 = HtmlEncode($this->expectedDetection->AdvancedSearch->SearchValue2);
			$this->expectedDetection->PlaceHolder = RemoveHtml($this->expectedDetection->caption());

			// expectedRpn
			$this->expectedRpn->EditAttrs["class"] = "form-control";
			$this->expectedRpn->EditCustomAttributes = "";
			$this->expectedRpn->EditValue = HtmlEncode($this->expectedRpn->AdvancedSearch->SearchValue);
			$this->expectedRpn->PlaceHolder = RemoveHtml($this->expectedRpn->caption());
			$this->expectedRpn->EditAttrs["class"] = "form-control";
			$this->expectedRpn->EditCustomAttributes = "";
			$this->expectedRpn->EditValue2 = HtmlEncode($this->expectedRpn->AdvancedSearch->SearchValue2);
			$this->expectedRpn->PlaceHolder = RemoveHtml($this->expectedRpn->caption());

			// expectedClosureDate
			$this->expectedClosureDate->EditAttrs["class"] = "form-control";
			$this->expectedClosureDate->EditCustomAttributes = "";
			$this->expectedClosureDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->expectedClosureDate->AdvancedSearch->SearchValue, 0), 8));
			$this->expectedClosureDate->PlaceHolder = RemoveHtml($this->expectedClosureDate->caption());
			$this->expectedClosureDate->EditAttrs["class"] = "form-control";
			$this->expectedClosureDate->EditCustomAttributes = "";
			$this->expectedClosureDate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->expectedClosureDate->AdvancedSearch->SearchValue2, 0), 8));
			$this->expectedClosureDate->PlaceHolder = RemoveHtml($this->expectedClosureDate->caption());

			// recomendedActiondet
			$this->recomendedActiondet->EditAttrs["class"] = "form-control";
			$this->recomendedActiondet->EditCustomAttributes = "";
			$this->recomendedActiondet->EditValue = HtmlEncode($this->recomendedActiondet->AdvancedSearch->SearchValue);
			$this->recomendedActiondet->PlaceHolder = RemoveHtml($this->recomendedActiondet->caption());
			$this->recomendedActiondet->EditAttrs["class"] = "form-control";
			$this->recomendedActiondet->EditCustomAttributes = "";
			$this->recomendedActiondet->EditValue2 = HtmlEncode($this->recomendedActiondet->AdvancedSearch->SearchValue2);
			$this->recomendedActiondet->PlaceHolder = RemoveHtml($this->recomendedActiondet->caption());

			// idResponsibleDet
			$this->idResponsibleDet->EditAttrs["class"] = "form-control";
			$this->idResponsibleDet->EditCustomAttributes = "";
			if (!$this->idResponsibleDet->Raw)
				$this->idResponsibleDet->AdvancedSearch->SearchValue = HtmlDecode($this->idResponsibleDet->AdvancedSearch->SearchValue);
			$this->idResponsibleDet->EditValue = HtmlEncode($this->idResponsibleDet->AdvancedSearch->SearchValue);
			$this->idResponsibleDet->PlaceHolder = RemoveHtml($this->idResponsibleDet->caption());
			$this->idResponsibleDet->EditAttrs["class"] = "form-control";
			$this->idResponsibleDet->EditCustomAttributes = "";
			if (!$this->idResponsibleDet->Raw)
				$this->idResponsibleDet->AdvancedSearch->SearchValue2 = HtmlDecode($this->idResponsibleDet->AdvancedSearch->SearchValue2);
			$this->idResponsibleDet->EditValue2 = HtmlEncode($this->idResponsibleDet->AdvancedSearch->SearchValue2);
			$this->idResponsibleDet->PlaceHolder = RemoveHtml($this->idResponsibleDet->caption());

			// targetDatedet
			$this->targetDatedet->EditAttrs["class"] = "form-control";
			$this->targetDatedet->EditCustomAttributes = "";
			$this->targetDatedet->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDatedet->AdvancedSearch->SearchValue, 0), 8));
			$this->targetDatedet->PlaceHolder = RemoveHtml($this->targetDatedet->caption());
			$this->targetDatedet->EditAttrs["class"] = "form-control";
			$this->targetDatedet->EditCustomAttributes = "";
			$this->targetDatedet->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDatedet->AdvancedSearch->SearchValue2, 0), 8));
			$this->targetDatedet->PlaceHolder = RemoveHtml($this->targetDatedet->caption());

			// kcdet
			$this->kcdet->EditCustomAttributes = "";
			$this->kcdet->EditValue = $this->kcdet->options(FALSE);
			$this->kcdet->EditCustomAttributes = "";
			$this->kcdet->EditValue2 = $this->kcdet->options(FALSE);

			// expectedSeveritydet
			$this->expectedSeveritydet->EditAttrs["class"] = "form-control";
			$this->expectedSeveritydet->EditCustomAttributes = "";
			$this->expectedSeveritydet->EditValue = HtmlEncode($this->expectedSeveritydet->AdvancedSearch->SearchValue);
			$this->expectedSeveritydet->PlaceHolder = RemoveHtml($this->expectedSeveritydet->caption());
			$this->expectedSeveritydet->EditAttrs["class"] = "form-control";
			$this->expectedSeveritydet->EditCustomAttributes = "";
			$this->expectedSeveritydet->EditValue2 = HtmlEncode($this->expectedSeveritydet->AdvancedSearch->SearchValue2);
			$this->expectedSeveritydet->PlaceHolder = RemoveHtml($this->expectedSeveritydet->caption());

			// expectedOccurrencedet
			$this->expectedOccurrencedet->EditAttrs["class"] = "form-control";
			$this->expectedOccurrencedet->EditCustomAttributes = "";
			$this->expectedOccurrencedet->EditValue = HtmlEncode($this->expectedOccurrencedet->AdvancedSearch->SearchValue);
			$this->expectedOccurrencedet->PlaceHolder = RemoveHtml($this->expectedOccurrencedet->caption());
			$this->expectedOccurrencedet->EditAttrs["class"] = "form-control";
			$this->expectedOccurrencedet->EditCustomAttributes = "";
			$this->expectedOccurrencedet->EditValue2 = HtmlEncode($this->expectedOccurrencedet->AdvancedSearch->SearchValue2);
			$this->expectedOccurrencedet->PlaceHolder = RemoveHtml($this->expectedOccurrencedet->caption());

			// expectedDetectiondet
			$this->expectedDetectiondet->EditAttrs["class"] = "form-control";
			$this->expectedDetectiondet->EditCustomAttributes = "";
			$this->expectedDetectiondet->EditValue = HtmlEncode($this->expectedDetectiondet->AdvancedSearch->SearchValue);
			$this->expectedDetectiondet->PlaceHolder = RemoveHtml($this->expectedDetectiondet->caption());
			$this->expectedDetectiondet->EditAttrs["class"] = "form-control";
			$this->expectedDetectiondet->EditCustomAttributes = "";
			$this->expectedDetectiondet->EditValue2 = HtmlEncode($this->expectedDetectiondet->AdvancedSearch->SearchValue2);
			$this->expectedDetectiondet->PlaceHolder = RemoveHtml($this->expectedDetectiondet->caption());

			// expectedRpndet
			$this->expectedRpndet->EditAttrs["class"] = "form-control";
			$this->expectedRpndet->EditCustomAttributes = "";
			$this->expectedRpndet->EditValue = HtmlEncode($this->expectedRpndet->AdvancedSearch->SearchValue);
			$this->expectedRpndet->PlaceHolder = RemoveHtml($this->expectedRpndet->caption());
			$this->expectedRpndet->EditAttrs["class"] = "form-control";
			$this->expectedRpndet->EditCustomAttributes = "";
			$this->expectedRpndet->EditValue2 = HtmlEncode($this->expectedRpndet->AdvancedSearch->SearchValue2);
			$this->expectedRpndet->PlaceHolder = RemoveHtml($this->expectedRpndet->caption());

			// revisedClosureDatedet
			$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
			$this->revisedClosureDatedet->EditCustomAttributes = "";
			$this->revisedClosureDatedet->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->revisedClosureDatedet->AdvancedSearch->SearchValue, 0), 8));
			$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());
			$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
			$this->revisedClosureDatedet->EditCustomAttributes = "";
			$this->revisedClosureDatedet->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->revisedClosureDatedet->AdvancedSearch->SearchValue2, 0), 8));
			$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());

			// revisedClosureDate
			$this->revisedClosureDate->EditAttrs["class"] = "form-control";
			$this->revisedClosureDate->EditCustomAttributes = "";
			$this->revisedClosureDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->revisedClosureDate->AdvancedSearch->SearchValue, 0), 8));
			$this->revisedClosureDate->PlaceHolder = RemoveHtml($this->revisedClosureDate->caption());
			$this->revisedClosureDate->EditAttrs["class"] = "form-control";
			$this->revisedClosureDate->EditCustomAttributes = "";
			$this->revisedClosureDate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->revisedClosureDate->AdvancedSearch->SearchValue2, 0), 8));
			$this->revisedClosureDate->PlaceHolder = RemoveHtml($this->revisedClosureDate->caption());

			// perfomedAction
			$this->perfomedAction->EditAttrs["class"] = "form-control";
			$this->perfomedAction->EditCustomAttributes = "";
			$this->perfomedAction->EditValue = HtmlEncode($this->perfomedAction->AdvancedSearch->SearchValue);
			$this->perfomedAction->PlaceHolder = RemoveHtml($this->perfomedAction->caption());
			$this->perfomedAction->EditAttrs["class"] = "form-control";
			$this->perfomedAction->EditCustomAttributes = "";
			$this->perfomedAction->EditValue2 = HtmlEncode($this->perfomedAction->AdvancedSearch->SearchValue2);
			$this->perfomedAction->PlaceHolder = RemoveHtml($this->perfomedAction->caption());

			// revisedSeverity
			$this->revisedSeverity->EditAttrs["class"] = "form-control";
			$this->revisedSeverity->EditCustomAttributes = "";
			$this->revisedSeverity->EditValue = HtmlEncode($this->revisedSeverity->AdvancedSearch->SearchValue);
			$this->revisedSeverity->PlaceHolder = RemoveHtml($this->revisedSeverity->caption());
			$this->revisedSeverity->EditAttrs["class"] = "form-control";
			$this->revisedSeverity->EditCustomAttributes = "";
			$this->revisedSeverity->EditValue2 = HtmlEncode($this->revisedSeverity->AdvancedSearch->SearchValue2);
			$this->revisedSeverity->PlaceHolder = RemoveHtml($this->revisedSeverity->caption());

			// revisedOccurrence
			$this->revisedOccurrence->EditAttrs["class"] = "form-control";
			$this->revisedOccurrence->EditCustomAttributes = "";
			$this->revisedOccurrence->EditValue = HtmlEncode($this->revisedOccurrence->AdvancedSearch->SearchValue);
			$this->revisedOccurrence->PlaceHolder = RemoveHtml($this->revisedOccurrence->caption());
			$this->revisedOccurrence->EditAttrs["class"] = "form-control";
			$this->revisedOccurrence->EditCustomAttributes = "";
			$this->revisedOccurrence->EditValue2 = HtmlEncode($this->revisedOccurrence->AdvancedSearch->SearchValue2);
			$this->revisedOccurrence->PlaceHolder = RemoveHtml($this->revisedOccurrence->caption());

			// revisedDetection
			$this->revisedDetection->EditAttrs["class"] = "form-control";
			$this->revisedDetection->EditCustomAttributes = "";
			$this->revisedDetection->EditValue = HtmlEncode($this->revisedDetection->AdvancedSearch->SearchValue);
			$this->revisedDetection->PlaceHolder = RemoveHtml($this->revisedDetection->caption());
			$this->revisedDetection->EditAttrs["class"] = "form-control";
			$this->revisedDetection->EditCustomAttributes = "";
			$this->revisedDetection->EditValue2 = HtmlEncode($this->revisedDetection->AdvancedSearch->SearchValue2);
			$this->revisedDetection->PlaceHolder = RemoveHtml($this->revisedDetection->caption());

			// revisedRpn
			$this->revisedRpn->EditAttrs["class"] = "form-control";
			$this->revisedRpn->EditCustomAttributes = "";
			$this->revisedRpn->EditValue = HtmlEncode($this->revisedRpn->AdvancedSearch->SearchValue);
			$this->revisedRpn->PlaceHolder = RemoveHtml($this->revisedRpn->caption());
			$this->revisedRpn->EditAttrs["class"] = "form-control";
			$this->revisedRpn->EditCustomAttributes = "";
			$this->revisedRpn->EditValue2 = HtmlEncode($this->revisedRpn->AdvancedSearch->SearchValue2);
			$this->revisedRpn->PlaceHolder = RemoveHtml($this->revisedRpn->caption());
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
		if (!CheckDate($this->dateFmea->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->dateFmea->errorMessage());
		}
		if (!CheckDate($this->dateFmea->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->dateFmea->errorMessage());
		}
		if (!CheckInteger($this->idProcess->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->idProcess->errorMessage());
		}
		if (!CheckInteger($this->idProcess->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->idProcess->errorMessage());
		}
		if (!CheckInteger($this->step->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->step->errorMessage());
		}
		if (!CheckInteger($this->step->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->step->errorMessage());
		}
		if (!CheckInteger($this->severity->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->severity->errorMessage());
		}
		if (!CheckInteger($this->severity->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->severity->errorMessage());
		}
		if (!CheckInteger($this->occurrence->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->occurrence->errorMessage());
		}
		if (!CheckInteger($this->occurrence->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->occurrence->errorMessage());
		}
		if (!CheckInteger($this->detection->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->detection->errorMessage());
		}
		if (!CheckInteger($this->detection->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->detection->errorMessage());
		}
		if (!CheckInteger($this->rpn->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->rpn->errorMessage());
		}
		if (!CheckInteger($this->rpn->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->rpn->errorMessage());
		}
		if (!CheckDate($this->targetDate->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->targetDate->errorMessage());
		}
		if (!CheckDate($this->targetDate->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->targetDate->errorMessage());
		}
		if (!CheckInteger($this->expectedSeverity->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedSeverity->errorMessage());
		}
		if (!CheckInteger($this->expectedSeverity->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedSeverity->errorMessage());
		}
		if (!CheckInteger($this->expectedOccurrence->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedOccurrence->errorMessage());
		}
		if (!CheckInteger($this->expectedOccurrence->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedOccurrence->errorMessage());
		}
		if (!CheckInteger($this->expectedDetection->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedDetection->errorMessage());
		}
		if (!CheckInteger($this->expectedDetection->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedDetection->errorMessage());
		}
		if (!CheckInteger($this->expectedRpn->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedRpn->errorMessage());
		}
		if (!CheckInteger($this->expectedRpn->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedRpn->errorMessage());
		}
		if (!CheckDate($this->expectedClosureDate->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedClosureDate->errorMessage());
		}
		if (!CheckDate($this->expectedClosureDate->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedClosureDate->errorMessage());
		}
		if (!CheckDate($this->targetDatedet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->targetDatedet->errorMessage());
		}
		if (!CheckDate($this->targetDatedet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->targetDatedet->errorMessage());
		}
		if (!CheckInteger($this->expectedSeveritydet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedSeveritydet->errorMessage());
		}
		if (!CheckInteger($this->expectedSeveritydet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedSeveritydet->errorMessage());
		}
		if (!CheckInteger($this->expectedOccurrencedet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedOccurrencedet->errorMessage());
		}
		if (!CheckInteger($this->expectedOccurrencedet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedOccurrencedet->errorMessage());
		}
		if (!CheckInteger($this->expectedDetectiondet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedDetectiondet->errorMessage());
		}
		if (!CheckInteger($this->expectedDetectiondet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedDetectiondet->errorMessage());
		}
		if (!CheckInteger($this->expectedRpndet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedRpndet->errorMessage());
		}
		if (!CheckInteger($this->expectedRpndet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedRpndet->errorMessage());
		}
		if (!CheckDate($this->revisedClosureDatedet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedClosureDatedet->errorMessage());
		}
		if (!CheckDate($this->revisedClosureDatedet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedClosureDatedet->errorMessage());
		}
		if (!CheckDate($this->revisedClosureDate->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedClosureDate->errorMessage());
		}
		if (!CheckDate($this->revisedClosureDate->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedClosureDate->errorMessage());
		}
		if (!CheckInteger($this->revisedSeverity->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedSeverity->errorMessage());
		}
		if (!CheckInteger($this->revisedSeverity->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedSeverity->errorMessage());
		}
		if (!CheckInteger($this->revisedOccurrence->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedOccurrence->errorMessage());
		}
		if (!CheckInteger($this->revisedOccurrence->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedOccurrence->errorMessage());
		}
		if (!CheckInteger($this->revisedDetection->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedDetection->errorMessage());
		}
		if (!CheckInteger($this->revisedDetection->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedDetection->errorMessage());
		}
		if (!CheckInteger($this->revisedRpn->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedRpn->errorMessage());
		}
		if (!CheckInteger($this->revisedRpn->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedRpn->errorMessage());
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

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("reportfmealist.php"), "", $this->TableVar, TRUE);
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