<?php
namespace PHPMaker2020\fmeaPRD;

/**
 * Page class
 */
class fmea_add extends fmea
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}";

	// Table name
	public $TableName = 'fmea';

	// Page object name
	public $PageObjName = "fmea_add";

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

		// Table object (fmea)
		if (!isset($GLOBALS["fmea"]) || get_class($GLOBALS["fmea"]) == PROJECT_NAMESPACE . "fmea") {
			$GLOBALS["fmea"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["fmea"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees']))
			$GLOBALS['employees'] = new employees();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'fmea');

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
		global $fmea;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($fmea);
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
					if ($pageName == "fmeaview.php")
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
			$key .= @$ar['fmea'];
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
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRecord;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;
	public $DetailPages; // Detail pages object

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
					$this->terminate(GetUrl("fmealist.php"));
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
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

		// Set up detail page object
		$this->setupDetailPages();

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
		$this->setupLookupOptions($this->idFactory);
		$this->setupLookupOptions($this->idEmployee);
		$this->setupLookupOptions($this->idworkcenter);

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
			if (Get("fmea") !== NULL) {
				$this->fmea->setQueryStringValue(Get("fmea"));
				$this->setKey("fmea", $this->fmea->CurrentValue); // Set up key
			} else {
				$this->setKey("fmea", ""); // Clear key
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
					$this->terminate("fmealist.php"); // No matching record, return to list
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
					if (GetPageName($returnUrl) == "fmealist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "fmeaview.php")
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
		$this->fmea->CurrentValue = NULL;
		$this->fmea->OldValue = $this->fmea->CurrentValue;
		$this->idFactory->CurrentValue = NULL;
		$this->idFactory->OldValue = $this->idFactory->CurrentValue;
		$this->dateFmea->CurrentValue = NULL;
		$this->dateFmea->OldValue = $this->dateFmea->CurrentValue;
		$this->partnumbers->CurrentValue = NULL;
		$this->partnumbers->OldValue = $this->partnumbers->CurrentValue;
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->idEmployee->CurrentValue = NULL;
		$this->idEmployee->OldValue = $this->idEmployee->CurrentValue;
		$this->idworkcenter->CurrentValue = NULL;
		$this->idworkcenter->OldValue = $this->idworkcenter->CurrentValue;
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

		// Check field name 'idFactory' first before field var 'x_idFactory'
		$val = $CurrentForm->hasValue("idFactory") ? $CurrentForm->getValue("idFactory") : $CurrentForm->getValue("x_idFactory");
		if (!$this->idFactory->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idFactory->Visible = FALSE; // Disable update for API request
			else
				$this->idFactory->setFormValue($val);
		}

		// Check field name 'dateFmea' first before field var 'x_dateFmea'
		$val = $CurrentForm->hasValue("dateFmea") ? $CurrentForm->getValue("dateFmea") : $CurrentForm->getValue("x_dateFmea");
		if (!$this->dateFmea->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->dateFmea->Visible = FALSE; // Disable update for API request
			else
				$this->dateFmea->setFormValue($val);
			$this->dateFmea->CurrentValue = UnFormatDateTime($this->dateFmea->CurrentValue, 0);
		}

		// Check field name 'partnumbers' first before field var 'x_partnumbers'
		$val = $CurrentForm->hasValue("partnumbers") ? $CurrentForm->getValue("partnumbers") : $CurrentForm->getValue("x_partnumbers");
		if (!$this->partnumbers->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->partnumbers->Visible = FALSE; // Disable update for API request
			else
				$this->partnumbers->setFormValue($val);
		}

		// Check field name 'description' first before field var 'x_description'
		$val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
		if (!$this->description->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->description->Visible = FALSE; // Disable update for API request
			else
				$this->description->setFormValue($val);
		}

		// Check field name 'idEmployee' first before field var 'x_idEmployee'
		$val = $CurrentForm->hasValue("idEmployee") ? $CurrentForm->getValue("idEmployee") : $CurrentForm->getValue("x_idEmployee");
		if (!$this->idEmployee->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idEmployee->Visible = FALSE; // Disable update for API request
			else
				$this->idEmployee->setFormValue($val);
		}

		// Check field name 'idworkcenter' first before field var 'x_idworkcenter'
		$val = $CurrentForm->hasValue("idworkcenter") ? $CurrentForm->getValue("idworkcenter") : $CurrentForm->getValue("x_idworkcenter");
		if (!$this->idworkcenter->IsDetailKey) {
			if (IsApi() && $val == NULL)
				$this->idworkcenter->Visible = FALSE; // Disable update for API request
			else
				$this->idworkcenter->setFormValue($val);
		}
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->fmea->CurrentValue = $this->fmea->FormValue;
		$this->idFactory->CurrentValue = $this->idFactory->FormValue;
		$this->dateFmea->CurrentValue = $this->dateFmea->FormValue;
		$this->dateFmea->CurrentValue = UnFormatDateTime($this->dateFmea->CurrentValue, 0);
		$this->partnumbers->CurrentValue = $this->partnumbers->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->idEmployee->CurrentValue = $this->idEmployee->FormValue;
		$this->idworkcenter->CurrentValue = $this->idworkcenter->FormValue;
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
		if (array_key_exists('EV__idFactory', $rs->fields)) {
			$this->idFactory->VirtualValue = $rs->fields('EV__idFactory'); // Set up virtual field value
		} else {
			$this->idFactory->VirtualValue = ""; // Clear value
		}
		$this->dateFmea->setDbValue($row['dateFmea']);
		$this->partnumbers->setDbValue($row['partnumbers']);
		$this->description->setDbValue($row['description']);
		$this->idEmployee->setDbValue($row['idEmployee']);
		if (array_key_exists('EV__idEmployee', $rs->fields)) {
			$this->idEmployee->VirtualValue = $rs->fields('EV__idEmployee'); // Set up virtual field value
		} else {
			$this->idEmployee->VirtualValue = ""; // Clear value
		}
		$this->idworkcenter->setDbValue($row['idworkcenter']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['fmea'] = $this->fmea->CurrentValue;
		$row['idFactory'] = $this->idFactory->CurrentValue;
		$row['dateFmea'] = $this->dateFmea->CurrentValue;
		$row['partnumbers'] = $this->partnumbers->CurrentValue;
		$row['description'] = $this->description->CurrentValue;
		$row['idEmployee'] = $this->idEmployee->CurrentValue;
		$row['idworkcenter'] = $this->idworkcenter->CurrentValue;
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
		// fmea
		// idFactory
		// dateFmea
		// partnumbers
		// description
		// idEmployee
		// idworkcenter

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// fmea
			$this->fmea->ViewValue = $this->fmea->CurrentValue;
			$this->fmea->ViewCustomAttributes = "";

			// idFactory
			if ($this->idFactory->VirtualValue != "") {
				$this->idFactory->ViewValue = $this->idFactory->VirtualValue;
			} else {
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
			if ($this->idEmployee->VirtualValue != "") {
				$this->idEmployee->ViewValue = $this->idEmployee->VirtualValue;
			} else {
				$curVal = strval($this->idEmployee->CurrentValue);
				if ($curVal != "") {
					$this->idEmployee->ViewValue = $this->idEmployee->lookupCacheOption($curVal);
					if ($this->idEmployee->ViewValue === NULL) { // Lookup from database
						$arwrk = explode(",", $curVal);
						$filterWrk = "";
						foreach ($arwrk as $wrk) {
							if ($filterWrk != "")
								$filterWrk .= " OR ";
							$filterWrk .= "`idEmployee`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
						}
						$sqlWrk = $this->idEmployee->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$this->idEmployee->ViewValue = new OptionValues();
							$ari = 0;
							while (!$rswrk->EOF) {
								$arwrk = [];
								$arwrk[1] = $rswrk->fields('df');
								$arwrk[2] = $rswrk->fields('df2');
								$this->idEmployee->ViewValue->add($this->idEmployee->displayValue($arwrk));
								$rswrk->MoveNext();
								$ari++;
							}
							$rswrk->Close();
						} else {
							$this->idEmployee->ViewValue = $this->idEmployee->CurrentValue;
						}
					}
				} else {
					$this->idEmployee->ViewValue = NULL;
				}
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
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// fmea
			$this->fmea->EditAttrs["class"] = "form-control";
			$this->fmea->EditCustomAttributes = "";
			if (!$this->fmea->Raw)
				$this->fmea->CurrentValue = HtmlDecode($this->fmea->CurrentValue);
			$this->fmea->EditValue = HtmlEncode($this->fmea->CurrentValue);
			$this->fmea->PlaceHolder = RemoveHtml($this->fmea->caption());

			// idFactory
			$this->idFactory->EditAttrs["class"] = "form-control";
			$this->idFactory->EditCustomAttributes = "";
			$curVal = trim(strval($this->idFactory->CurrentValue));
			if ($curVal != "")
				$this->idFactory->ViewValue = $this->idFactory->lookupCacheOption($curVal);
			else
				$this->idFactory->ViewValue = $this->idFactory->Lookup !== NULL && is_array($this->idFactory->Lookup->Options) ? $curVal : NULL;
			if ($this->idFactory->ViewValue !== NULL) { // Load from cache
				$this->idFactory->EditValue = array_values($this->idFactory->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`idFactory`" . SearchString("=", $this->idFactory->CurrentValue, DATATYPE_STRING, "");
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
			$this->dateFmea->EditValue = HtmlEncode(FormatDateTime($this->dateFmea->CurrentValue, 8));
			$this->dateFmea->PlaceHolder = RemoveHtml($this->dateFmea->caption());

			// partnumbers
			$this->partnumbers->EditAttrs["class"] = "form-control";
			$this->partnumbers->EditCustomAttributes = "";
			$this->partnumbers->EditValue = HtmlEncode($this->partnumbers->CurrentValue);
			$this->partnumbers->PlaceHolder = RemoveHtml($this->partnumbers->caption());

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = RemoveHtml($this->description->caption());

			// idEmployee
			$this->idEmployee->EditCustomAttributes = "";
			$curVal = trim(strval($this->idEmployee->CurrentValue));
			if ($curVal != "")
				$this->idEmployee->ViewValue = $this->idEmployee->lookupCacheOption($curVal);
			else
				$this->idEmployee->ViewValue = $this->idEmployee->Lookup !== NULL && is_array($this->idEmployee->Lookup->Options) ? $curVal : NULL;
			if ($this->idEmployee->ViewValue !== NULL) { // Load from cache
				$this->idEmployee->EditValue = array_values($this->idEmployee->Lookup->Options);
				if ($this->idEmployee->ViewValue == "")
					$this->idEmployee->ViewValue = $Language->phrase("PleaseSelect");
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
				$sqlWrk = $this->idEmployee->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idEmployee->ViewValue = new OptionValues();
					$ari = 0;
					while (!$rswrk->EOF) {
						$arwrk = [];
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$arwrk[2] = HtmlEncode($rswrk->fields('df2'));
						$this->idEmployee->ViewValue->add($this->idEmployee->displayValue($arwrk));
						$rswrk->MoveNext();
						$ari++;
					}
					$rswrk->MoveFirst();
				} else {
					$this->idEmployee->ViewValue = $Language->phrase("PleaseSelect");
				}
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idEmployee->EditValue = $arwrk;
			}

			// idworkcenter
			$this->idworkcenter->EditAttrs["class"] = "form-control";
			$this->idworkcenter->EditCustomAttributes = "";
			$curVal = trim(strval($this->idworkcenter->CurrentValue));
			if ($curVal != "")
				$this->idworkcenter->ViewValue = $this->idworkcenter->lookupCacheOption($curVal);
			else
				$this->idworkcenter->ViewValue = $this->idworkcenter->Lookup !== NULL && is_array($this->idworkcenter->Lookup->Options) ? $curVal : NULL;
			if ($this->idworkcenter->ViewValue !== NULL) { // Load from cache
				$this->idworkcenter->EditValue = array_values($this->idworkcenter->Lookup->Options);
			} else { // Lookup from database
				if ($curVal == "") {
					$filterWrk = "0=1";
				} else {
					$filterWrk = "`workcenter`" . SearchString("=", $this->idworkcenter->CurrentValue, DATATYPE_STRING, "");
				}
				$sqlWrk = $this->idworkcenter->Lookup->getSql(TRUE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				$arwrk = $rswrk ? $rswrk->getRows() : [];
				if ($rswrk)
					$rswrk->close();
				$this->idworkcenter->EditValue = $arwrk;
			}

			// Add refer script
			// fmea

			$this->fmea->LinkCustomAttributes = "";
			$this->fmea->HrefValue = "";

			// idFactory
			$this->idFactory->LinkCustomAttributes = "";
			$this->idFactory->HrefValue = "";

			// dateFmea
			$this->dateFmea->LinkCustomAttributes = "";
			$this->dateFmea->HrefValue = "";

			// partnumbers
			$this->partnumbers->LinkCustomAttributes = "";
			$this->partnumbers->HrefValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// idEmployee
			$this->idEmployee->LinkCustomAttributes = "";
			$this->idEmployee->HrefValue = "";

			// idworkcenter
			$this->idworkcenter->LinkCustomAttributes = "";
			$this->idworkcenter->HrefValue = "";
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
		if ($this->idFactory->Required) {
			if (!$this->idFactory->IsDetailKey && $this->idFactory->FormValue != NULL && $this->idFactory->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idFactory->caption(), $this->idFactory->RequiredErrorMessage));
			}
		}
		if ($this->dateFmea->Required) {
			if (!$this->dateFmea->IsDetailKey && $this->dateFmea->FormValue != NULL && $this->dateFmea->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->dateFmea->caption(), $this->dateFmea->RequiredErrorMessage));
			}
		}
		if (!CheckDate($this->dateFmea->FormValue)) {
			AddMessage($FormError, $this->dateFmea->errorMessage());
		}
		if ($this->partnumbers->Required) {
			if (!$this->partnumbers->IsDetailKey && $this->partnumbers->FormValue != NULL && $this->partnumbers->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->partnumbers->caption(), $this->partnumbers->RequiredErrorMessage));
			}
		}
		if ($this->description->Required) {
			if (!$this->description->IsDetailKey && $this->description->FormValue != NULL && $this->description->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
			}
		}
		if ($this->idEmployee->Required) {
			if ($this->idEmployee->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idEmployee->caption(), $this->idEmployee->RequiredErrorMessage));
			}
		}
		if ($this->idworkcenter->Required) {
			if (!$this->idworkcenter->IsDetailKey && $this->idworkcenter->FormValue != NULL && $this->idworkcenter->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idworkcenter->caption(), $this->idworkcenter->RequiredErrorMessage));
			}
		}

		// Validate detail grid
		$detailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("processf", $detailTblVar) && $GLOBALS["processf"]->DetailAdd) {
			if (!isset($GLOBALS["processf_grid"]))
				$GLOBALS["processf_grid"] = new processf_grid(); // Get detail page object
			$GLOBALS["processf_grid"]->validateGridForm();
		}
		if (in_array("issue", $detailTblVar) && $GLOBALS["issue"]->DetailAdd) {
			if (!isset($GLOBALS["issue_grid"]))
				$GLOBALS["issue_grid"] = new issue_grid(); // Get detail page object
			$GLOBALS["issue_grid"]->validateGridForm();
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
		$this->fmea->setDbValueDef($rsnew, $this->fmea->CurrentValue, "", FALSE);

		// idFactory
		$this->idFactory->setDbValueDef($rsnew, $this->idFactory->CurrentValue, NULL, FALSE);

		// dateFmea
		$this->dateFmea->setDbValueDef($rsnew, UnFormatDateTime($this->dateFmea->CurrentValue, 0), NULL, FALSE);

		// partnumbers
		$this->partnumbers->setDbValueDef($rsnew, $this->partnumbers->CurrentValue, NULL, FALSE);

		// description
		$this->description->setDbValueDef($rsnew, $this->description->CurrentValue, NULL, FALSE);

		// idEmployee
		$this->idEmployee->setDbValueDef($rsnew, $this->idEmployee->CurrentValue, NULL, FALSE);

		// idworkcenter
		$this->idworkcenter->setDbValueDef($rsnew, $this->idworkcenter->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($insertRow && $this->ValidateKey && strval($rsnew['fmea']) == "") {
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

		// Add detail records
		if ($addRow) {
			$detailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("processf", $detailTblVar) && $GLOBALS["processf"]->DetailAdd) {
				$GLOBALS["processf"]->fmea->setSessionValue($this->fmea->CurrentValue); // Set master key
				if (!isset($GLOBALS["processf_grid"]))
					$GLOBALS["processf_grid"] = new processf_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "processf"); // Load user level of detail table
				$addRow = $GLOBALS["processf_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["processf"]->fmea->setSessionValue(""); // Clear master key if insert failed
				}
			}
			if (in_array("issue", $detailTblVar) && $GLOBALS["issue"]->DetailAdd) {
				$GLOBALS["issue"]->fmea->setSessionValue($this->fmea->CurrentValue); // Set master key
				if (!isset($GLOBALS["issue_grid"]))
					$GLOBALS["issue_grid"] = new issue_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "issue"); // Load user level of detail table
				$addRow = $GLOBALS["issue_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["issue"]->fmea->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("processf", $detailTblVar)) {
				if (!isset($GLOBALS["processf_grid"]))
					$GLOBALS["processf_grid"] = new processf_grid();
				if ($GLOBALS["processf_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["processf_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["processf_grid"]->CurrentMode = "add";
					$GLOBALS["processf_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["processf_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["processf_grid"]->setStartRecordNumber(1);
					$GLOBALS["processf_grid"]->fmea->IsDetailKey = TRUE;
					$GLOBALS["processf_grid"]->fmea->CurrentValue = $this->fmea->CurrentValue;
					$GLOBALS["processf_grid"]->fmea->setSessionValue($GLOBALS["processf_grid"]->fmea->CurrentValue);
				}
			}
			if (in_array("issue", $detailTblVar)) {
				if (!isset($GLOBALS["issue_grid"]))
					$GLOBALS["issue_grid"] = new issue_grid();
				if ($GLOBALS["issue_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["issue_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["issue_grid"]->CurrentMode = "add";
					$GLOBALS["issue_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["issue_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["issue_grid"]->setStartRecordNumber(1);
					$GLOBALS["issue_grid"]->fmea->IsDetailKey = TRUE;
					$GLOBALS["issue_grid"]->fmea->CurrentValue = $this->fmea->CurrentValue;
					$GLOBALS["issue_grid"]->fmea->setSessionValue($GLOBALS["issue_grid"]->fmea->CurrentValue);
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
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("fmealist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
	}

	// Set up detail pages
	protected function setupDetailPages()
	{
		$pages = new SubPages();
		$pages->Style = "tabs";
		$pages->add('processf');
		$pages->add('issue');
		$this->DetailPages = $pages;
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
				case "x_idFactory":
					break;
				case "x_idEmployee":
					break;
				case "x_idworkcenter":
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
						case "x_idFactory":
							break;
						case "x_idEmployee":
							break;
						case "x_idworkcenter":
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