<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class actions_search extends actions
{

	// Page ID
	public $PageID = "search";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'actions';

	// Page object name
	public $PageObjName = "actions_search";

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

		// Table object (processf)
		if (!isset($GLOBALS['processf']))
			$GLOBALS['processf'] = new processf();

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'search');

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
					if ($pageName == "actionsview.php")
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
					$this->terminate(GetUrl("actionslist.php"));
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
		$this->expectedRpn->setVisibility();
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
		$this->revisedRpn->setVisibility();
		$this->revisedRPNCalc->setVisibility();
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
		$this->setupLookupOptions($this->idCause);
		$this->setupLookupOptions($this->idResponsible);
		$this->setupLookupOptions($this->idResponsibleDet);

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
					$srchStr = "actionslist.php" . "?" . $srchStr;
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
		$this->buildSearchUrl($srchUrl, $this->idProcess); // idProcess
		$this->buildSearchUrl($srchUrl, $this->idCause); // idCause
		$this->buildSearchUrl($srchUrl, $this->potentialCauses); // potentialCauses
		$this->buildSearchUrl($srchUrl, $this->currentPreventiveControlMethod); // currentPreventiveControlMethod
		$this->buildSearchUrl($srchUrl, $this->severity); // severity
		$this->buildSearchUrl($srchUrl, $this->occurrence); // occurrence
		$this->buildSearchUrl($srchUrl, $this->currentControlMethod); // currentControlMethod
		$this->buildSearchUrl($srchUrl, $this->detection); // detection
		$this->buildSearchUrl($srchUrl, $this->RPNCalc); // RPNCalc
		$this->buildSearchUrl($srchUrl, $this->recomendedAction); // recomendedAction
		$this->buildSearchUrl($srchUrl, $this->idResponsible); // idResponsible
		$this->buildSearchUrl($srchUrl, $this->targetDate); // targetDate
		$this->buildSearchUrl($srchUrl, $this->revisedKc, TRUE); // revisedKc
		$this->buildSearchUrl($srchUrl, $this->expectedSeverity); // expectedSeverity
		$this->buildSearchUrl($srchUrl, $this->expectedOccurrence); // expectedOccurrence
		$this->buildSearchUrl($srchUrl, $this->expectedDetection); // expectedDetection
		$this->buildSearchUrl($srchUrl, $this->expectedRpn); // expectedRpn
		$this->buildSearchUrl($srchUrl, $this->expectedRPNPAO); // expectedRPNPAO
		$this->buildSearchUrl($srchUrl, $this->expectedClosureDate); // expectedClosureDate
		$this->buildSearchUrl($srchUrl, $this->recomendedActiondet); // recomendedActiondet
		$this->buildSearchUrl($srchUrl, $this->idResponsibleDet); // idResponsibleDet
		$this->buildSearchUrl($srchUrl, $this->targetDatedet); // targetDatedet
		$this->buildSearchUrl($srchUrl, $this->kcdet, TRUE); // kcdet
		$this->buildSearchUrl($srchUrl, $this->expectedSeveritydet); // expectedSeveritydet
		$this->buildSearchUrl($srchUrl, $this->expectedOccurrencedet); // expectedOccurrencedet
		$this->buildSearchUrl($srchUrl, $this->expectedDetectiondet); // expectedDetectiondet
		$this->buildSearchUrl($srchUrl, $this->expectedRPNPAD); // expectedRPNPAD
		$this->buildSearchUrl($srchUrl, $this->revisedClosureDatedet); // revisedClosureDatedet
		$this->buildSearchUrl($srchUrl, $this->revisedSeverity); // revisedSeverity
		$this->buildSearchUrl($srchUrl, $this->revisedOccurrence); // revisedOccurrence
		$this->buildSearchUrl($srchUrl, $this->revisedDetection); // revisedDetection
		$this->buildSearchUrl($srchUrl, $this->revisedRpn); // revisedRpn
		$this->buildSearchUrl($srchUrl, $this->revisedRPNCalc); // revisedRPNCalc
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
		if ($this->idProcess->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idCause->AdvancedSearch->post())
			$got = TRUE;
		if ($this->potentialCauses->AdvancedSearch->post())
			$got = TRUE;
		if ($this->currentPreventiveControlMethod->AdvancedSearch->post())
			$got = TRUE;
		if ($this->severity->AdvancedSearch->post())
			$got = TRUE;
		if ($this->occurrence->AdvancedSearch->post())
			$got = TRUE;
		if ($this->currentControlMethod->AdvancedSearch->post())
			$got = TRUE;
		if ($this->detection->AdvancedSearch->post())
			$got = TRUE;
		if ($this->RPNCalc->AdvancedSearch->post())
			$got = TRUE;
		if ($this->recomendedAction->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idResponsible->AdvancedSearch->post())
			$got = TRUE;
		if (is_array($this->idResponsible->AdvancedSearch->SearchValue))
			$this->idResponsible->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsible->AdvancedSearch->SearchValue);
		if (is_array($this->idResponsible->AdvancedSearch->SearchValue2))
			$this->idResponsible->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsible->AdvancedSearch->SearchValue2);
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
		if ($this->expectedRPNPAO->AdvancedSearch->post())
			$got = TRUE;
		if ($this->expectedClosureDate->AdvancedSearch->post())
			$got = TRUE;
		if ($this->recomendedActiondet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->idResponsibleDet->AdvancedSearch->post())
			$got = TRUE;
		if (is_array($this->idResponsibleDet->AdvancedSearch->SearchValue))
			$this->idResponsibleDet->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsibleDet->AdvancedSearch->SearchValue);
		if (is_array($this->idResponsibleDet->AdvancedSearch->SearchValue2))
			$this->idResponsibleDet->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->idResponsibleDet->AdvancedSearch->SearchValue2);
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
		if ($this->expectedRPNPAD->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedClosureDatedet->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedSeverity->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedOccurrence->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedDetection->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedRpn->AdvancedSearch->post())
			$got = TRUE;
		if ($this->revisedRPNCalc->AdvancedSearch->post())
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
		// idCause
		// potentialCauses
		// currentPreventiveControlMethod
		// severity
		// occurrence
		// currentControlMethod
		// detection
		// RPNCalc
		// rpn
		// recomendedAction
		// idResponsible
		// targetDate
		// revisedKc
		// expectedSeverity
		// expectedOccurrence
		// expectedDetection
		// expectedRpn
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
		// expectedRPNPAD
		// revisedClosureDatedet
		// revisedClosureDate
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

			// expectedRpn
			$this->expectedRpn->ViewValue = $this->expectedRpn->CurrentValue;
			$this->expectedRpn->ViewValue = FormatNumber($this->expectedRpn->ViewValue, 0, -2, -2, -2);
			$this->expectedRpn->ViewCustomAttributes = "";

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

			// revisedRpn
			$this->revisedRpn->ViewValue = $this->revisedRpn->CurrentValue;
			$this->revisedRpn->ViewValue = FormatNumber($this->revisedRpn->ViewValue, 0, -2, -2, -2);
			$this->revisedRpn->ViewCustomAttributes = "";

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

			// potentialCauses
			$this->potentialCauses->LinkCustomAttributes = "";
			$this->potentialCauses->HrefValue = "";
			$this->potentialCauses->TooltipValue = "";

			// currentPreventiveControlMethod
			$this->currentPreventiveControlMethod->LinkCustomAttributes = "";
			$this->currentPreventiveControlMethod->HrefValue = "";
			$this->currentPreventiveControlMethod->TooltipValue = "";

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

			// revisedRpn
			$this->revisedRpn->LinkCustomAttributes = "";
			$this->revisedRpn->HrefValue = "";
			$this->revisedRpn->TooltipValue = "";

			// revisedRPNCalc
			$this->revisedRPNCalc->LinkCustomAttributes = "";
			$this->revisedRPNCalc->HrefValue = "";
			$this->revisedRPNCalc->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_SEARCH) { // Search row

			// idProcess
			$this->idProcess->EditAttrs["class"] = "form-control";
			$this->idProcess->EditCustomAttributes = "";
			$this->idProcess->EditValue = HtmlEncode($this->idProcess->AdvancedSearch->SearchValue);
			$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());

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

			// potentialCauses
			$this->potentialCauses->EditAttrs["class"] = "form-control";
			$this->potentialCauses->EditCustomAttributes = "";
			$this->potentialCauses->EditValue = HtmlEncode($this->potentialCauses->AdvancedSearch->SearchValue);
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

			// severity
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue = HtmlEncode($this->severity->AdvancedSearch->SearchValue);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());
			$this->severity->EditAttrs["class"] = "form-control";
			$this->severity->EditCustomAttributes = "";
			$this->severity->EditValue2 = HtmlEncode($this->severity->AdvancedSearch->SearchValue2);
			$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());

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

			// RPNCalc
			$this->RPNCalc->EditAttrs["class"] = "form-control";
			$this->RPNCalc->EditCustomAttributes = "";
			$this->RPNCalc->EditValue = HtmlEncode($this->RPNCalc->AdvancedSearch->SearchValue);
			$this->RPNCalc->PlaceHolder = RemoveHtml($this->RPNCalc->caption());
			$this->RPNCalc->EditAttrs["class"] = "form-control";
			$this->RPNCalc->EditCustomAttributes = "";
			$this->RPNCalc->EditValue2 = HtmlEncode($this->RPNCalc->AdvancedSearch->SearchValue2);
			$this->RPNCalc->PlaceHolder = RemoveHtml($this->RPNCalc->caption());

			// recomendedAction
			$this->recomendedAction->EditAttrs["class"] = "form-control";
			$this->recomendedAction->EditCustomAttributes = "background-color: #56d226";
			$this->recomendedAction->EditValue = HtmlEncode($this->recomendedAction->AdvancedSearch->SearchValue);
			$this->recomendedAction->PlaceHolder = RemoveHtml($this->recomendedAction->caption());
			$this->recomendedAction->EditAttrs["class"] = "form-control";
			$this->recomendedAction->EditCustomAttributes = "background-color: #56d226";
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
			$this->targetDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDate->AdvancedSearch->SearchValue, 14), 14));
			$this->targetDate->PlaceHolder = RemoveHtml($this->targetDate->caption());
			$this->targetDate->EditAttrs["class"] = "form-control";
			$this->targetDate->EditCustomAttributes = "";
			$this->targetDate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDate->AdvancedSearch->SearchValue2, 14), 14));
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

			// expectedRPNPAO
			$this->expectedRPNPAO->EditAttrs["class"] = "form-control";
			$this->expectedRPNPAO->EditCustomAttributes = "";
			$this->expectedRPNPAO->EditValue = HtmlEncode($this->expectedRPNPAO->AdvancedSearch->SearchValue);
			$this->expectedRPNPAO->PlaceHolder = RemoveHtml($this->expectedRPNPAO->caption());
			$this->expectedRPNPAO->EditAttrs["class"] = "form-control";
			$this->expectedRPNPAO->EditCustomAttributes = "";
			$this->expectedRPNPAO->EditValue2 = HtmlEncode($this->expectedRPNPAO->AdvancedSearch->SearchValue2);
			$this->expectedRPNPAO->PlaceHolder = RemoveHtml($this->expectedRPNPAO->caption());

			// expectedClosureDate
			$this->expectedClosureDate->EditAttrs["class"] = "form-control";
			$this->expectedClosureDate->EditCustomAttributes = "";
			$this->expectedClosureDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->expectedClosureDate->AdvancedSearch->SearchValue, 12), 12));
			$this->expectedClosureDate->PlaceHolder = RemoveHtml($this->expectedClosureDate->caption());
			$this->expectedClosureDate->EditAttrs["class"] = "form-control";
			$this->expectedClosureDate->EditCustomAttributes = "";
			$this->expectedClosureDate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->expectedClosureDate->AdvancedSearch->SearchValue2, 12), 12));
			$this->expectedClosureDate->PlaceHolder = RemoveHtml($this->expectedClosureDate->caption());

			// recomendedActiondet
			$this->recomendedActiondet->EditAttrs["class"] = "form-control";
			$this->recomendedActiondet->EditCustomAttributes = "";
			if (!$this->recomendedActiondet->Raw)
				$this->recomendedActiondet->AdvancedSearch->SearchValue = HtmlDecode($this->recomendedActiondet->AdvancedSearch->SearchValue);
			$this->recomendedActiondet->EditValue = HtmlEncode($this->recomendedActiondet->AdvancedSearch->SearchValue);
			$this->recomendedActiondet->PlaceHolder = RemoveHtml($this->recomendedActiondet->caption());
			$this->recomendedActiondet->EditAttrs["class"] = "form-control";
			$this->recomendedActiondet->EditCustomAttributes = "";
			if (!$this->recomendedActiondet->Raw)
				$this->recomendedActiondet->AdvancedSearch->SearchValue2 = HtmlDecode($this->recomendedActiondet->AdvancedSearch->SearchValue2);
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
			$this->targetDatedet->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDatedet->AdvancedSearch->SearchValue, 14), 14));
			$this->targetDatedet->PlaceHolder = RemoveHtml($this->targetDatedet->caption());
			$this->targetDatedet->EditAttrs["class"] = "form-control";
			$this->targetDatedet->EditCustomAttributes = "";
			$this->targetDatedet->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->targetDatedet->AdvancedSearch->SearchValue2, 14), 14));
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

			// expectedRPNPAD
			$this->expectedRPNPAD->EditAttrs["class"] = "form-control";
			$this->expectedRPNPAD->EditCustomAttributes = "";
			$this->expectedRPNPAD->EditValue = HtmlEncode($this->expectedRPNPAD->AdvancedSearch->SearchValue);
			$this->expectedRPNPAD->PlaceHolder = RemoveHtml($this->expectedRPNPAD->caption());
			$this->expectedRPNPAD->EditAttrs["class"] = "form-control";
			$this->expectedRPNPAD->EditCustomAttributes = "";
			$this->expectedRPNPAD->EditValue2 = HtmlEncode($this->expectedRPNPAD->AdvancedSearch->SearchValue2);
			$this->expectedRPNPAD->PlaceHolder = RemoveHtml($this->expectedRPNPAD->caption());

			// revisedClosureDatedet
			$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
			$this->revisedClosureDatedet->EditCustomAttributes = "";
			$this->revisedClosureDatedet->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->revisedClosureDatedet->AdvancedSearch->SearchValue, 14), 14));
			$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());
			$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
			$this->revisedClosureDatedet->EditCustomAttributes = "";
			$this->revisedClosureDatedet->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->revisedClosureDatedet->AdvancedSearch->SearchValue2, 14), 14));
			$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());

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

			// revisedRPNCalc
			$this->revisedRPNCalc->EditAttrs["class"] = "form-control";
			$this->revisedRPNCalc->EditCustomAttributes = "";
			$this->revisedRPNCalc->EditValue = HtmlEncode($this->revisedRPNCalc->AdvancedSearch->SearchValue);
			$this->revisedRPNCalc->PlaceHolder = RemoveHtml($this->revisedRPNCalc->caption());
			$this->revisedRPNCalc->EditAttrs["class"] = "form-control";
			$this->revisedRPNCalc->EditCustomAttributes = "";
			$this->revisedRPNCalc->EditValue2 = HtmlEncode($this->revisedRPNCalc->AdvancedSearch->SearchValue2);
			$this->revisedRPNCalc->PlaceHolder = RemoveHtml($this->revisedRPNCalc->caption());
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
		if (!CheckInteger($this->idProcess->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->idProcess->errorMessage());
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
		if (!CheckInteger($this->RPNCalc->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->RPNCalc->errorMessage());
		}
		if (!CheckInteger($this->RPNCalc->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->RPNCalc->errorMessage());
		}
		if (!CheckShortEuroDate($this->targetDate->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->targetDate->errorMessage());
		}
		if (!CheckShortEuroDate($this->targetDate->AdvancedSearch->SearchValue2)) {
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
		if (!CheckInteger($this->expectedRPNPAO->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedRPNPAO->errorMessage());
		}
		if (!CheckInteger($this->expectedRPNPAO->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedRPNPAO->errorMessage());
		}
		if (!CheckStdShortDate($this->expectedClosureDate->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedClosureDate->errorMessage());
		}
		if (!CheckStdShortDate($this->expectedClosureDate->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedClosureDate->errorMessage());
		}
		if (!CheckShortEuroDate($this->targetDatedet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->targetDatedet->errorMessage());
		}
		if (!CheckShortEuroDate($this->targetDatedet->AdvancedSearch->SearchValue2)) {
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
		if (!CheckInteger($this->expectedRPNPAD->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->expectedRPNPAD->errorMessage());
		}
		if (!CheckInteger($this->expectedRPNPAD->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->expectedRPNPAD->errorMessage());
		}
		if (!CheckShortEuroDate($this->revisedClosureDatedet->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedClosureDatedet->errorMessage());
		}
		if (!CheckShortEuroDate($this->revisedClosureDatedet->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedClosureDatedet->errorMessage());
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
		if (!CheckInteger($this->revisedRPNCalc->AdvancedSearch->SearchValue)) {
			AddMessage($SearchError, $this->revisedRPNCalc->errorMessage());
		}
		if (!CheckInteger($this->revisedRPNCalc->AdvancedSearch->SearchValue2)) {
			AddMessage($SearchError, $this->revisedRPNCalc->errorMessage());
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

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("actionslist.php"), "", $this->TableVar, TRUE);
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
} // End class
?>