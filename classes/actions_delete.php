<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class actions_delete extends actions
{

	// Page ID
	public $PageID = "delete";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'actions';

	// Page object name
	public $PageObjName = "actions_delete";

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
			define(PROJECT_NAMESPACE . "PAGE_ID", 'delete');

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
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRecord;
	public $TotalRecords = 0;
	public $RecordCount;
	public $RecKeys = [];
	public $StartRowCount = 1;
	public $RowCount = 0;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

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
			if (!$Security->canDelete()) {
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

		// Set up master/detail parameters
		$this->setupMasterParms();

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->getRecordKeys(); // Load record keys
		$filter = $this->getFilterFromRecordKeys();
		if ($filter == "") {
			$this->terminate("actionslist.php"); // Prevent SQL injection, return to list
			return;
		}

		// Set up filter (WHERE Clause)
		$this->CurrentFilter = $filter;

		// Get action
		if (IsApi()) {
			$this->CurrentAction = "delete"; // Delete record directly
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action");
		} elseif (Get("action") == "1") {
			$this->CurrentAction = "delete"; // Delete record directly
		} else {
			$this->CurrentAction = "show"; // Display record
		}
		if ($this->isDelete()) {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->deleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
				if (IsApi()) {
					$this->terminate(TRUE);
					return;
				} else {
					$this->terminate($this->getReturnUrl()); // Return to caller
				}
			} else { // Delete failed
				if (IsApi()) {
					$this->terminate();
					return;
				}
				$this->CurrentAction = "show"; // Display record
			}
		}
		if ($this->isShow()) { // Load records for display
			if ($this->Recordset = $this->loadRecordset())
				$this->TotalRecords = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecords <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->close();
				$this->terminate("actionslist.php"); // Return to list
			}
		}
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
		$row = [];
		$row['idProcess'] = NULL;
		$row['idCause'] = NULL;
		$row['potentialCauses'] = NULL;
		$row['currentPreventiveControlMethod'] = NULL;
		$row['severity'] = NULL;
		$row['occurrence'] = NULL;
		$row['currentControlMethod'] = NULL;
		$row['detection'] = NULL;
		$row['RPNCalc'] = NULL;
		$row['rpn'] = NULL;
		$row['recomendedAction'] = NULL;
		$row['idResponsible'] = NULL;
		$row['targetDate'] = NULL;
		$row['revisedKc'] = NULL;
		$row['expectedSeverity'] = NULL;
		$row['expectedOccurrence'] = NULL;
		$row['expectedDetection'] = NULL;
		$row['expectedRpn'] = NULL;
		$row['expectedRPNPAO'] = NULL;
		$row['expectedClosureDate'] = NULL;
		$row['recomendedActiondet'] = NULL;
		$row['idResponsibleDet'] = NULL;
		$row['targetDatedet'] = NULL;
		$row['kcdet'] = NULL;
		$row['expectedSeveritydet'] = NULL;
		$row['expectedOccurrencedet'] = NULL;
		$row['expectedDetectiondet'] = NULL;
		$row['expectedRpndet'] = NULL;
		$row['expectedRPNPAD'] = NULL;
		$row['revisedClosureDatedet'] = NULL;
		$row['revisedClosureDate'] = NULL;
		$row['perfomedAction'] = NULL;
		$row['revisedSeverity'] = NULL;
		$row['revisedOccurrence'] = NULL;
		$row['revisedDetection'] = NULL;
		$row['revisedRpn'] = NULL;
		$row['revisedRPNCalc'] = NULL;
		return $row;
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

			// revisedRPNCalc
			$this->revisedRPNCalc->LinkCustomAttributes = "";
			$this->revisedRPNCalc->HrefValue = "";
			$this->revisedRPNCalc->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$conn->beginTrans();

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
		if ($deleteRows) {
			$conn->commitTrans(); // Commit the changes
		} else {
			$conn->rollbackTrans(); // Rollback changes
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
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("actionslist.php"), "", $this->TableVar, TRUE);
		$pageId = "delete";
		$Breadcrumb->add("delete", $pageId, $url);
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
} // End class
?>