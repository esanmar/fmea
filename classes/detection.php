<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for detection
 */
class detection extends DbTable
{
	protected $SqlFrom = "";
	protected $SqlSelect = "";
	protected $SqlSelectList = "";
	protected $SqlWhere = "";
	protected $SqlGroupBy = "";
	protected $SqlHaving = "";
	protected $SqlOrderBy = "";
	public $UseSessionForListSql = TRUE;

	// Column CSS classes
	public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
	public $RightColumnClass = "col-sm-10";
	public $OffsetColumnClass = "col-sm-10 offset-sm-2";
	public $TableLeftColumnClass = "w-col-2";

	// Export
	public $ExportDoc;

	// Fields
	public $idDetection;
	public $detection;
	public $description;
	public $methods;
	public $errorProofed;
	public $gonogo;
	public $visualInspection;
	public $color;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'detection';
		$this->TableName = 'detection';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`detection`";
		$this->Dbid = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 104; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// idDetection
		$this->idDetection = new DbField('detection', 'detection', 'x_idDetection', 'idDetection', '`idDetection`', '`idDetection`', 3, 11, -1, FALSE, '`idDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idDetection->IsAutoIncrement = TRUE; // Autoincrement field
		$this->idDetection->IsPrimaryKey = TRUE; // Primary key field
		$this->idDetection->Sortable = TRUE; // Allow sort
		$this->idDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idDetection'] = &$this->idDetection;

		// detection
		$this->detection = new DbField('detection', 'detection', 'x_detection', 'detection', '`detection`', '`detection`', 200, 150, -1, FALSE, '`detection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detection->Nullable = FALSE; // NOT NULL field
		$this->detection->Required = TRUE; // Required field
		$this->detection->Sortable = TRUE; // Allow sort
		$this->fields['detection'] = &$this->detection;

		// description
		$this->description = new DbField('detection', 'detection', 'x_description', 'description', '`description`', '`description`', 201, -1, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// methods
		$this->methods = new DbField('detection', 'detection', 'x_methods', 'methods', '`methods`', '`methods`', 201, -1, -1, FALSE, '`methods`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->methods->Sortable = TRUE; // Allow sort
		$this->fields['methods'] = &$this->methods;

		// errorProofed
		$this->errorProofed = new DbField('detection', 'detection', 'x_errorProofed', 'errorProofed', '`errorProofed`', '`errorProofed`', 202, 1, -1, FALSE, '`errorProofed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->errorProofed->Sortable = TRUE; // Allow sort
		$this->errorProofed->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->errorProofed->Lookup = new Lookup('errorProofed', 'detection', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->errorProofed->Lookup = new Lookup('errorProofed', 'detection', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->errorProofed->OptionCount = 2;
		$this->fields['errorProofed'] = &$this->errorProofed;

		// gonogo
		$this->gonogo = new DbField('detection', 'detection', 'x_gonogo', 'gonogo', '`gonogo`', '`gonogo`', 202, 1, -1, FALSE, '`gonogo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->gonogo->Sortable = TRUE; // Allow sort
		$this->gonogo->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->gonogo->Lookup = new Lookup('gonogo', 'detection', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->gonogo->Lookup = new Lookup('gonogo', 'detection', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->gonogo->OptionCount = 2;
		$this->fields['gonogo'] = &$this->gonogo;

		// visualInspection
		$this->visualInspection = new DbField('detection', 'detection', 'x_visualInspection', 'visualInspection', '`visualInspection`', '`visualInspection`', 202, 1, -1, FALSE, '`visualInspection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->visualInspection->Sortable = TRUE; // Allow sort
		$this->visualInspection->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->visualInspection->Lookup = new Lookup('visualInspection', 'detection', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->visualInspection->Lookup = new Lookup('visualInspection', 'detection', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->visualInspection->OptionCount = 2;
		$this->fields['visualInspection'] = &$this->visualInspection;

		// color
		$this->color = new DbField('detection', 'detection', 'x_color', 'color', '`color`', '`color`', 200, 50, -1, FALSE, '`color`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->color->Sortable = TRUE; // Allow sort
		$this->fields['color'] = &$this->color;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function setLeftColumnClass($class)
	{
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " col-form-label ew-label";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
			$this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
		}
	}

	// Multiple column sort
	public function updateSort(&$fld, $ctrl)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			if ($ctrl) {
				$orderBy = $this->getSessionOrderBy();
				if (ContainsString($orderBy, $sortField . " " . $lastSort)) {
					$orderBy = str_replace($sortField . " " . $lastSort, $sortField . " " . $thisSort, $orderBy);
				} else {
					if ($orderBy != "")
						$orderBy .= ", ";
					$orderBy .= $sortField . " " . $thisSort;
				}
				$this->setSessionOrderBy($orderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sortField . " " . $thisSort); // Save to Session
			}
		} else {
			if (!$ctrl)
				$fld->setSort("");
		}
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`detection`";
	}
	public function sqlFrom() // For backward compatibility
	{
		return $this->getSqlFrom();
	}
	public function setSqlFrom($v)
	{
		$this->SqlFrom = $v;
	}
	public function getSqlSelect() // Select
	{
		return ($this->SqlSelect != "") ? $this->SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}
	public function sqlSelect() // For backward compatibility
	{
		return $this->getSqlSelect();
	}
	public function setSqlSelect($v)
	{
		$this->SqlSelect = $v;
	}
	public function getSqlWhere() // Where
	{
		$where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
		$this->TableFilter = "";
		AddFilter($where, $this->TableFilter);
		return $where;
	}
	public function sqlWhere() // For backward compatibility
	{
		return $this->getSqlWhere();
	}
	public function setSqlWhere($v)
	{
		$this->SqlWhere = $v;
	}
	public function getSqlGroupBy() // Group By
	{
		return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
	}
	public function sqlGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupBy();
	}
	public function setSqlGroupBy($v)
	{
		$this->SqlGroupBy = $v;
	}
	public function getSqlHaving() // Having
	{
		return ($this->SqlHaving != "") ? $this->SqlHaving : "";
	}
	public function sqlHaving() // For backward compatibility
	{
		return $this->getSqlHaving();
	}
	public function setSqlHaving($v)
	{
		$this->SqlHaving = $v;
	}
	public function getSqlOrderBy() // Order By
	{
		return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
	}
	public function sqlOrderBy() // For backward compatibility
	{
		return $this->getSqlOrderBy();
	}
	public function setSqlOrderBy($v)
	{
		$this->SqlOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter)
	{
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = Config("USER_ID_ALLOW");
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get recordset
	public function getRecordset($sql, $rowcnt = -1, $offset = -1)
	{
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->selectLimit($sql, $rowcnt, $offset);
		$conn->raiseErrorFn = "";
		return $rs;
	}

	// Get record count
	public function getRecordCount($sql, $c = NULL)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) &&
			!preg_match('/^\s*select\s+distinct\s+/i', $sql) && !preg_match('/\s+order\s+by\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = $c ?: $this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get SQL
	public function getSql($where, $orderBy = "")
	{
		return BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Table SQL
	public function getCurrentSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->getSql($filter, $sort);
	}

	// Table SQL with List page filter
	public function getListSql()
	{
		$filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->getSqlSelect();
		$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Get record count based on filter (for detail record count in master table pages)
	public function loadRecordCount($filter)
	{
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->getRecordCount($sql);
		$this->CurrentFilter = $origFilter;
		return $cnt;
	}

	// Get record count (for current List page)
	public function listRecordCount()
	{
		$filter = $this->getSessionWhere();
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->getRecordCount($sql);
		return $cnt;
	}

	// INSERT statement
	protected function insertSql(&$rs)
	{
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			$names .= $this->fields[$name]->Expression . ",";
			$values .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	public function insert(&$rs)
	{
		$conn = $this->getConnection();
		$success = $conn->execute($this->insertSql($rs));
		if ($success) {

			// Get insert id if necessary
			$this->idDetection->setDbValue($conn->insert_ID());
			$rs['idDetection'] = $this->idDetection->DbValue;
		}
		return $success;
	}

	// UPDATE statement
	protected function updateSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom || $this->fields[$name]->IsAutoIncrement)
				continue;
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		AddFilter($filter, $where);
		if ($filter != "")
			$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	public function update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE)
	{
		$conn = $this->getConnection();
		$success = $conn->execute($this->updateSql($rs, $where, $curfilter));
		return $success;
	}

	// DELETE statement
	protected function deleteSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		if ($rs) {
			if (array_key_exists('idDetection', $rs))
				AddFilter($where, QuotedName('idDetection', $this->Dbid) . '=' . QuotedValue($rs['idDetection'], $this->idDetection->DataType, $this->Dbid));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		AddFilter($filter, $where);
		if ($filter != "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	public function delete(&$rs, $where = "", $curfilter = FALSE)
	{
		$success = TRUE;
		$conn = $this->getConnection();
		if ($success)
			$success = $conn->execute($this->deleteSql($rs, $where, $curfilter));
		return $success;
	}

	// Load DbValue from recordset or array
	protected function loadDbValues(&$rs)
	{
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idDetection->DbValue = $row['idDetection'];
		$this->detection->DbValue = $row['detection'];
		$this->description->DbValue = $row['description'];
		$this->methods->DbValue = $row['methods'];
		$this->errorProofed->DbValue = $row['errorProofed'];
		$this->gonogo->DbValue = $row['gonogo'];
		$this->visualInspection->DbValue = $row['visualInspection'];
		$this->color->DbValue = $row['color'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idDetection` = @idDetection@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('idDetection', $row) ? $row['idDetection'] : NULL;
		else
			$val = $this->idDetection->OldValue !== NULL ? $this->idDetection->OldValue : $this->idDetection->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idDetection@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
		return $keyFilter;
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") != "" && ReferPageName() != CurrentPageName() && ReferPageName() != "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] != "") {
			return $_SESSION[$name];
		} else {
			return "detectionlist.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "detectionview.php")
			return $Language->phrase("View");
		elseif ($pageName == "detectionedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "detectionadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "detectionlist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("detectionview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("detectionview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "detectionadd.php?" . $this->getUrlParm($parm);
		else
			$url = "detectionadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("detectionedit.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		$url = $this->keyUrl("detectionadd.php", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("detectiondelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idDetection:" . JsonEncode($this->idDetection->CurrentValue, "number");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm != "")
			$url .= $parm . "&";
		if ($this->idDetection->CurrentValue != NULL) {
			$url .= "idDetection=" . urlencode($this->idDetection->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, [128, 204, 205])) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		$arKeys = [];
		$arKey = [];
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("idDetection") !== NULL)
				$arKeys[] = Param("idDetection");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = [];
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get filter from record keys
	public function getFilterFromRecordKeys($setCurrent = TRUE)
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter != "") $keyFilter .= " OR ";
			if ($setCurrent)
				$this->idDetection->CurrentValue = $key;
			else
				$this->idDetection->OldValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = $this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Load row values from recordset
	public function loadListRowValues(&$rs)
	{
		$this->idDetection->setDbValue($rs->fields('idDetection'));
		$this->detection->setDbValue($rs->fields('detection'));
		$this->description->setDbValue($rs->fields('description'));
		$this->methods->setDbValue($rs->fields('methods'));
		$this->errorProofed->setDbValue($rs->fields('errorProofed'));
		$this->gonogo->setDbValue($rs->fields('gonogo'));
		$this->visualInspection->setDbValue($rs->fields('visualInspection'));
		$this->color->setDbValue($rs->fields('color'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// idDetection
		// detection
		// description
		// methods
		// errorProofed
		// gonogo
		// visualInspection
		// color
		// idDetection

		$this->idDetection->ViewValue = $this->idDetection->CurrentValue;
		$this->idDetection->ViewCustomAttributes = "";

		// detection
		$this->detection->ViewValue = $this->detection->CurrentValue;
		$this->detection->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// methods
		$this->methods->ViewValue = $this->methods->CurrentValue;
		$this->methods->ViewCustomAttributes = "";

		// errorProofed
		if (ConvertToBool($this->errorProofed->CurrentValue)) {
			$this->errorProofed->ViewValue = $this->errorProofed->tagCaption(2) != "" ? $this->errorProofed->tagCaption(2) : "1";
		} else {
			$this->errorProofed->ViewValue = $this->errorProofed->tagCaption(1) != "" ? $this->errorProofed->tagCaption(1) : "0";
		}
		$this->errorProofed->ViewCustomAttributes = "";

		// gonogo
		if (ConvertToBool($this->gonogo->CurrentValue)) {
			$this->gonogo->ViewValue = $this->gonogo->tagCaption(2) != "" ? $this->gonogo->tagCaption(2) : "1";
		} else {
			$this->gonogo->ViewValue = $this->gonogo->tagCaption(1) != "" ? $this->gonogo->tagCaption(1) : "0";
		}
		$this->gonogo->ViewCustomAttributes = "";

		// visualInspection
		if (ConvertToBool($this->visualInspection->CurrentValue)) {
			$this->visualInspection->ViewValue = $this->visualInspection->tagCaption(2) != "" ? $this->visualInspection->tagCaption(2) : "1";
		} else {
			$this->visualInspection->ViewValue = $this->visualInspection->tagCaption(1) != "" ? $this->visualInspection->tagCaption(1) : "0";
		}
		$this->visualInspection->ViewCustomAttributes = "";

		// color
		$this->color->ViewValue = $this->color->CurrentValue;
		$this->color->CssClass = "font-weight-bold";
		$this->color->ViewCustomAttributes = "";

		// idDetection
		$this->idDetection->LinkCustomAttributes = "";
		$this->idDetection->HrefValue = "";
		$this->idDetection->TooltipValue = "";

		// detection
		$this->detection->LinkCustomAttributes = "";
		$this->detection->HrefValue = "";
		$this->detection->TooltipValue = "";

		// description
		$this->description->LinkCustomAttributes = "";
		$this->description->HrefValue = "";
		$this->description->TooltipValue = "";

		// methods
		$this->methods->LinkCustomAttributes = "";
		$this->methods->HrefValue = "";
		$this->methods->TooltipValue = "";

		// errorProofed
		$this->errorProofed->LinkCustomAttributes = "";
		$this->errorProofed->HrefValue = "";
		$this->errorProofed->TooltipValue = "";

		// gonogo
		$this->gonogo->LinkCustomAttributes = "";
		$this->gonogo->HrefValue = "";
		$this->gonogo->TooltipValue = "";

		// visualInspection
		$this->visualInspection->LinkCustomAttributes = "";
		$this->visualInspection->HrefValue = "";
		$this->visualInspection->TooltipValue = "";

		// color
		$this->color->LinkCustomAttributes = "";
		$this->color->HrefValue = "";
		$this->color->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Render edit row values
	public function renderEditRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idDetection
		$this->idDetection->EditAttrs["class"] = "form-control";
		$this->idDetection->EditCustomAttributes = "";
		$this->idDetection->EditValue = $this->idDetection->CurrentValue;
		$this->idDetection->ViewCustomAttributes = "";

		// detection
		$this->detection->EditAttrs["class"] = "form-control";
		$this->detection->EditCustomAttributes = "";
		if (!$this->detection->Raw)
			$this->detection->CurrentValue = HtmlDecode($this->detection->CurrentValue);
		$this->detection->EditValue = $this->detection->CurrentValue;
		$this->detection->PlaceHolder = RemoveHtml($this->detection->caption());

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = RemoveHtml($this->description->caption());

		// methods
		$this->methods->EditAttrs["class"] = "form-control";
		$this->methods->EditCustomAttributes = "";
		$this->methods->EditValue = $this->methods->CurrentValue;
		$this->methods->PlaceHolder = RemoveHtml($this->methods->caption());

		// errorProofed
		$this->errorProofed->EditCustomAttributes = "";
		$this->errorProofed->EditValue = $this->errorProofed->options(FALSE);

		// gonogo
		$this->gonogo->EditCustomAttributes = "";
		$this->gonogo->EditValue = $this->gonogo->options(FALSE);

		// visualInspection
		$this->visualInspection->EditCustomAttributes = "";
		$this->visualInspection->EditValue = $this->visualInspection->options(FALSE);

		// color
		$this->color->EditAttrs["class"] = "form-control";
		$this->color->EditCustomAttributes = "";
		if (!$this->color->Raw)
			$this->color->CurrentValue = HtmlDecode($this->color->CurrentValue);
		$this->color->EditValue = $this->color->CurrentValue;
		$this->color->PlaceHolder = RemoveHtml($this->color->caption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	public function aggregateListRowValues()
	{
	}

	// Aggregate list row (for rendering)
	public function aggregateListRow()
	{

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
	{
		if (!$recordset || !$doc)
			return;
		if (!$doc->ExportCustom) {

			// Write header
			$doc->exportTableHeader();
			if ($doc->Horizontal) { // Horizontal format, write header
				$doc->beginExportRow();
				if ($exportPageType == "view") {
					$doc->exportCaption($this->idDetection);
					$doc->exportCaption($this->detection);
					$doc->exportCaption($this->description);
					$doc->exportCaption($this->methods);
					$doc->exportCaption($this->errorProofed);
					$doc->exportCaption($this->gonogo);
					$doc->exportCaption($this->visualInspection);
					$doc->exportCaption($this->color);
				} else {
					$doc->exportCaption($this->idDetection);
					$doc->exportCaption($this->detection);
					$doc->exportCaption($this->description);
					$doc->exportCaption($this->methods);
					$doc->exportCaption($this->errorProofed);
					$doc->exportCaption($this->gonogo);
					$doc->exportCaption($this->visualInspection);
					$doc->exportCaption($this->color);
				}
				$doc->endExportRow();
			}
		}

		// Move to first record
		$recCnt = $startRec - 1;
		if (!$recordset->EOF) {
			$recordset->moveFirst();
			if ($startRec > 1)
				$recordset->move($startRec - 1);
		}
		while (!$recordset->EOF && $recCnt < $stopRec) {
			$recCnt++;
			if ($recCnt >= $startRec) {
				$rowCnt = $recCnt - $startRec + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0)
						$doc->exportPageBreak();
				}
				$this->loadListRowValues($recordset);

				// Render row
				$this->RowType = ROWTYPE_VIEW; // Render view
				$this->resetAttributes();
				$this->renderListRow();
				if (!$doc->ExportCustom) {
					$doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
					if ($exportPageType == "view") {
						$doc->exportField($this->idDetection);
						$doc->exportField($this->detection);
						$doc->exportField($this->description);
						$doc->exportField($this->methods);
						$doc->exportField($this->errorProofed);
						$doc->exportField($this->gonogo);
						$doc->exportField($this->visualInspection);
						$doc->exportField($this->color);
					} else {
						$doc->exportField($this->idDetection);
						$doc->exportField($this->detection);
						$doc->exportField($this->description);
						$doc->exportField($this->methods);
						$doc->exportField($this->errorProofed);
						$doc->exportField($this->gonogo);
						$doc->exportField($this->visualInspection);
						$doc->exportField($this->color);
					}
					$doc->endExportRow($rowCnt);
				}
			}

			// Call Row Export server event
			if ($doc->ExportCustom)
				$this->Row_Export($recordset->fields);
			$recordset->moveNext();
		}
		if (!$doc->ExportCustom) {
			$doc->exportTableFooter();
		}
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0)
	{

		// No binary fields
		return FALSE;
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		$color=$this->color->CurrentValue;

		//$this->detection->CellAttrs["style"] = "background-color: $color";
		$this->RowAttrs["style"] = "background-color: $color; "; 
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>