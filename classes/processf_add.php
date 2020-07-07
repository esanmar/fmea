<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class processf_add extends processf
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'processf';

	// Page object name
	public $PageObjName = "processf_add";

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
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

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
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRecord;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SkipHeaderFooter;

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
			if (!$Security->canAdd()) {
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

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-add-form ew-horizontal";
		$postBack = FALSE;

		// Set up current action
		if (IsApi()) {
			$this->CurrentAction = "insert"; // Add record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get form action
			$postBack = TRUE;
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (Get("idProcess") !== NULL) {
				$this->idProcess->setQueryStringValue(Get("idProcess"));
				$this->setKey("idProcess", $this->idProcess->CurrentValue); // Set up key
			} else {
				$this->setKey("idProcess", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "copy"; // Copy record
			} else {
				$this->CurrentAction = "show"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->loadOldRecord();

		// Set up master/detail parameters
		// NOTE: must be after loadOldRecord to prevent master key values overwritten

		$this->setupMasterParms();

		// Load form values
		if ($postBack) {
			$this->loadFormValues(); // Load form values
		}

		// Set up detail parameters
		$this->setupDetailParms();

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues(); // Restore form values
				$this->setFailureMessage($FormError);
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = "show"; // Form error, reset action
				}
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "copy": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("processflist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->setupDetailParms();
				break;
			case "insert": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() != "") // Master/detail add
						$returnUrl = $this->getDetailUrl();
					else
						$returnUrl = $this->getReturnUrl();
					if (GetPageName($returnUrl) == "processflist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "processfview.php")
						$returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
					if (IsApi()) { // Return to caller
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl);
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->setupDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render row based on row type
		$this->RowType = ROWTYPE_ADD; // Render add type

		// Render row
		$this->resetAttributes();
		$this->renderRow();
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
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
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

		// Validate detail grid
		$detailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("actions", $detailTblVar) && $GLOBALS["actions"]->DetailAdd) {
			if (!isset($GLOBALS["actions_grid"]))
				$GLOBALS["actions_grid"] = new actions_grid(); // Get detail page object
			$GLOBALS["actions_grid"]->validateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() != "")
			$conn->beginTrans();

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

		// Add detail records
		if ($addRow) {
			$detailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("actions", $detailTblVar) && $GLOBALS["actions"]->DetailAdd) {
				$GLOBALS["actions"]->idProcess->setSessionValue($this->idProcess->CurrentValue); // Set master key
				if (!isset($GLOBALS["actions_grid"]))
					$GLOBALS["actions_grid"] = new actions_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "actions"); // Load user level of detail table
				$addRow = $GLOBALS["actions_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["actions"]->idProcess->setSessionValue(""); // Clear master key if insert failed
				}
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() != "") {
			if ($addRow) {
				$conn->commitTrans(); // Commit transaction
			} else {
				$conn->rollbackTrans(); // Rollback transaction
			}
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

	// Set up detail parms based on QueryString
	protected function setupDetailParms()
	{

		// Get the keys for master table
		$detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
		if ($detailTblVar !== NULL) {
			$this->setCurrentDetailTable($detailTblVar);
		} else {
			$detailTblVar = $this->getCurrentDetailTable();
		}
		if ($detailTblVar != "") {
			$detailTblVar = explode(",", $detailTblVar);
			if (in_array("actions", $detailTblVar)) {
				if (!isset($GLOBALS["actions_grid"]))
					$GLOBALS["actions_grid"] = new actions_grid();
				if ($GLOBALS["actions_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["actions_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["actions_grid"]->CurrentMode = "add";
					$GLOBALS["actions_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["actions_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["actions_grid"]->setStartRecordNumber(1);
					$GLOBALS["actions_grid"]->idProcess->IsDetailKey = TRUE;
					$GLOBALS["actions_grid"]->idProcess->CurrentValue = $this->idProcess->CurrentValue;
					$GLOBALS["actions_grid"]->idProcess->setSessionValue($GLOBALS["actions_grid"]->idProcess->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("processflist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
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