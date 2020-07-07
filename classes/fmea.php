<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for fmea
 */
class fmea extends DbTable
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
	public $fmea;
	public $idFactory;
	public $dateFmea;
	public $partnumbers;
	public $description;
	public $idEmployee;
	public $idworkcenter;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'fmea';
		$this->TableName = 'fmea';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`fmea`";
		$this->Dbid = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 104; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// fmea
		$this->fmea = new DbField('fmea', 'fmea', 'x_fmea', 'fmea', '`fmea`', '`fmea`', 200, 255, -1, FALSE, '`fmea`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fmea->IsPrimaryKey = TRUE; // Primary key field
		$this->fmea->IsForeignKey = TRUE; // Foreign key field
		$this->fmea->Nullable = FALSE; // NOT NULL field
		$this->fmea->Required = TRUE; // Required field
		$this->fmea->Sortable = TRUE; // Allow sort
		$this->fields['fmea'] = &$this->fmea;

		// idFactory
		$this->idFactory = new DbField('fmea', 'fmea', 'x_idFactory', 'idFactory', '`idFactory`', '`idFactory`', 200, 50, -1, FALSE, '`EV__idFactory`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idFactory->Sortable = TRUE; // Allow sort
		$this->idFactory->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idFactory->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idFactory->Lookup = new Lookup('idFactory', 'factories', TRUE, 'idFactory', ["factory","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idFactory->Lookup = new Lookup('idFactory', 'factories', TRUE, 'idFactory', ["factory","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idFactory'] = &$this->idFactory;

		// dateFmea
		$this->dateFmea = new DbField('fmea', 'fmea', 'x_dateFmea', 'dateFmea', '`dateFmea`', CastDateFieldForLike("`dateFmea`", 0, "DB"), 135, 19, 0, FALSE, '`dateFmea`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dateFmea->Sortable = TRUE; // Allow sort
		$this->dateFmea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['dateFmea'] = &$this->dateFmea;

		// partnumbers
		$this->partnumbers = new DbField('fmea', 'fmea', 'x_partnumbers', 'partnumbers', '`partnumbers`', '`partnumbers`', 201, -1, -1, FALSE, '`partnumbers`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->partnumbers->Sortable = TRUE; // Allow sort
		$this->fields['partnumbers'] = &$this->partnumbers;

		// description
		$this->description = new DbField('fmea', 'fmea', 'x_description', 'description', '`description`', '`description`', 201, -1, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// idEmployee
		$this->idEmployee = new DbField('fmea', 'fmea', 'x_idEmployee', 'idEmployee', '`idEmployee`', '`idEmployee`', 200, 50, -1, FALSE, '`EV__idEmployee`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idEmployee->Sortable = TRUE; // Allow sort
		$this->idEmployee->SelectMultiple = TRUE; // Multiple select
		switch ($CurrentLanguage) {
			case "en":
				$this->idEmployee->Lookup = new Lookup('idEmployee', 'employees', TRUE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idEmployee->Lookup = new Lookup('idEmployee', 'employees', TRUE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idEmployee'] = &$this->idEmployee;

		// idworkcenter
		$this->idworkcenter = new DbField('fmea', 'fmea', 'x_idworkcenter', 'idworkcenter', '`idworkcenter`', '`idworkcenter`', 200, 150, -1, FALSE, '`idworkcenter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idworkcenter->Sortable = TRUE; // Allow sort
		$this->idworkcenter->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idworkcenter->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idworkcenter->Lookup = new Lookup('idworkcenter', 'workcenters', FALSE, 'workcenter', ["workcenter","description","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idworkcenter->Lookup = new Lookup('idworkcenter', 'workcenters', FALSE, 'workcenter', ["workcenter","description","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idworkcenter'] = &$this->idworkcenter;
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
			$sortFieldList = ($fld->VirtualExpression != "") ? $fld->VirtualExpression : $sortField;
			if ($ctrl) {
				$orderByList = $this->getSessionOrderByList();
				if (ContainsString($orderByList, $sortFieldList . " " . $lastSort)) {
					$orderByList = str_replace($sortFieldList . " " . $lastSort, $sortFieldList . " " . $thisSort, $orderByList);
				} else {
					if ($orderByList != "") $orderByList .= ", ";
					$orderByList .= $sortFieldList . " " . $thisSort;
				}
				$this->setSessionOrderByList($orderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sortFieldList . " " . $thisSort); // Save to Session
			}
		} else {
			if (!$ctrl)
				$fld->setSort("");
		}
	}

	// Session ORDER BY for List page
	public function getSessionOrderByList()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")];
	}
	public function setSessionOrderByList($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
	}

	// Current detail table name
	public function getCurrentDetailTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")];
	}
	public function setCurrentDetailTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
	}

	// Get detail url
	public function getDetailUrl()
	{

		// Detail url
		$detailUrl = "";
		if ($this->getCurrentDetailTable() == "processf") {
			$detailUrl = $GLOBALS["processf"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_fmea=" . urlencode($this->fmea->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "issue") {
			$detailUrl = $GLOBALS["issue"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_fmea=" . urlencode($this->fmea->CurrentValue);
		}
		if ($detailUrl == "")
			$detailUrl = "fmealist.php";
		return $detailUrl;
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`fmea`";
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
	public function getSqlSelectList() // Select for List page
	{
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (SELECT DISTINCT `factory` FROM `factories` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`idFactory` = `fmea`.`idFactory` LIMIT 1) AS `EV__idFactory`, (SELECT DISTINCT CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->idEmployee) . "',COALESCE(`surname`,'')) FROM `employees` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`idEmployee` = `fmea`.`idEmployee` LIMIT 1) AS `EV__idEmployee` FROM `fmea`" .
			") `TMP_TABLE`";
		return ($this->SqlSelectList != "") ? $this->SqlSelectList : $select;
	}
	public function sqlSelectList() // For backward compatibility
	{
		return $this->getSqlSelectList();
	}
	public function setSqlSelectList($v)
	{
		$this->SqlSelectList = $v;
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
		if ($this->useVirtualFields()) {
			$select = $this->getSqlSelectList();
			$sort = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
		} else {
			$select = $this->getSqlSelect();
			$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		}
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = ($this->useVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Check if virtual fields is used in SQL
	protected function useVirtualFields()
	{
		$where = $this->UseSessionForListSql ? $this->getSessionWhere() : $this->CurrentFilter;
		$orderBy = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
		if ($where != "")
			$where = " " . str_replace(["(", ")"], ["", ""], $where) . " ";
		if ($orderBy != "")
			$orderBy = " " . str_replace(["(", ")"], ["", ""], $orderBy) . " ";
		if ($this->BasicSearch->getKeyword() != "")
			return TRUE;
		if (ContainsString($orderBy, " " . $this->idFactory->VirtualExpression . " "))
			return TRUE;
		if ($this->idEmployee->AdvancedSearch->SearchValue != "" ||
			$this->idEmployee->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->idEmployee->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->idEmployee->VirtualExpression . " "))
			return TRUE;
		return FALSE;
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
		if ($this->useVirtualFields())
			$sql = BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		else
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

		// Cascade Update detail table 'processf'
		$cascadeUpdate = FALSE;
		$rscascade = [];
		if ($rsold && (isset($rs['fmea']) && $rsold['fmea'] != $rs['fmea'])) { // Update detail field 'fmea'
			$cascadeUpdate = TRUE;
			$rscascade['fmea'] = $rs['fmea']; 
		}
		if ($cascadeUpdate) {
			if (!isset($GLOBALS["processf"]))
				$GLOBALS["processf"] = new processf();
			$rswrk = $GLOBALS["processf"]->loadRs("`fmea` = " . QuotedValue($rsold['fmea'], DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = [];
				$fldname = 'idProcess';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$success = $GLOBALS["processf"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($success)
					$success = $GLOBALS["processf"]->update($rscascade, $rskey, $rswrk->fields);
				if (!$success)
					return FALSE;

				// Call Row_Updated event
				$GLOBALS["processf"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->moveNext();
			}
		}

		// Cascade Update detail table 'issue'
		$cascadeUpdate = FALSE;
		$rscascade = [];
		if ($rsold && (isset($rs['fmea']) && $rsold['fmea'] != $rs['fmea'])) { // Update detail field 'fmea'
			$cascadeUpdate = TRUE;
			$rscascade['fmea'] = $rs['fmea']; 
		}
		if ($cascadeUpdate) {
			if (!isset($GLOBALS["issue"]))
				$GLOBALS["issue"] = new issue();
			$rswrk = $GLOBALS["issue"]->loadRs("`fmea` = " . QuotedValue($rsold['fmea'], DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = [];
				$fldname = 'fmea';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$fldname = 'issue';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$success = $GLOBALS["issue"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($success)
					$success = $GLOBALS["issue"]->update($rscascade, $rskey, $rswrk->fields);
				if (!$success)
					return FALSE;

				// Call Row_Updated event
				$GLOBALS["issue"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->moveNext();
			}
		}
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
			if (array_key_exists('fmea', $rs))
				AddFilter($where, QuotedName('fmea', $this->Dbid) . '=' . QuotedValue($rs['fmea'], $this->fmea->DataType, $this->Dbid));
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

		// Cascade delete detail table 'processf'
		if (!isset($GLOBALS["processf"]))
			$GLOBALS["processf"] = new processf();
		$rscascade = $GLOBALS["processf"]->loadRs("`fmea` = " . QuotedValue($rs['fmea'], DATATYPE_STRING, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->getRows() : [];

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$success = $GLOBALS["processf"]->Row_Deleting($dtlrow);
			if (!$success)
				break;
		}
		if ($success) {
			foreach ($dtlrows as $dtlrow) {
				$success = $GLOBALS["processf"]->delete($dtlrow); // Delete
				if (!$success)
					break;
			}
		}

		// Call Row Deleted event
		if ($success) {
			foreach ($dtlrows as $dtlrow)
				$GLOBALS["processf"]->Row_Deleted($dtlrow);
		}

		// Cascade delete detail table 'issue'
		if (!isset($GLOBALS["issue"]))
			$GLOBALS["issue"] = new issue();
		$rscascade = $GLOBALS["issue"]->loadRs("`fmea` = " . QuotedValue($rs['fmea'], DATATYPE_STRING, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->getRows() : [];

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$success = $GLOBALS["issue"]->Row_Deleting($dtlrow);
			if (!$success)
				break;
		}
		if ($success) {
			foreach ($dtlrows as $dtlrow) {
				$success = $GLOBALS["issue"]->delete($dtlrow); // Delete
				if (!$success)
					break;
			}
		}

		// Call Row Deleted event
		if ($success) {
			foreach ($dtlrows as $dtlrow)
				$GLOBALS["issue"]->Row_Deleted($dtlrow);
		}
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
		$this->fmea->DbValue = $row['fmea'];
		$this->idFactory->DbValue = $row['idFactory'];
		$this->dateFmea->DbValue = $row['dateFmea'];
		$this->partnumbers->DbValue = $row['partnumbers'];
		$this->description->DbValue = $row['description'];
		$this->idEmployee->DbValue = $row['idEmployee'];
		$this->idworkcenter->DbValue = $row['idworkcenter'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`fmea` = '@fmea@'";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('fmea', $row) ? $row['fmea'] : NULL;
		else
			$val = $this->fmea->OldValue !== NULL ? $this->fmea->OldValue : $this->fmea->CurrentValue;
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@fmea@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "fmealist.php";
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
		if ($pageName == "fmeaview.php")
			return $Language->phrase("View");
		elseif ($pageName == "fmeaedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "fmeaadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "fmealist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("fmeaview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("fmeaview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "fmeaadd.php?" . $this->getUrlParm($parm);
		else
			$url = "fmeaadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("fmeaedit.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("fmeaedit.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
		if ($parm != "")
			$url = $this->keyUrl("fmeaadd.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("fmeaadd.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
		return $this->keyUrl("fmeadelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "fmea:" . JsonEncode($this->fmea->CurrentValue, "string");
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
		if ($this->fmea->CurrentValue != NULL) {
			$url .= "fmea=" . urlencode($this->fmea->CurrentValue);
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
			if (Param("fmea") !== NULL)
				$arKeys[] = Param("fmea");
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
				$this->fmea->CurrentValue = $key;
			else
				$this->fmea->OldValue = $key;
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
		$this->fmea->setDbValue($rs->fields('fmea'));
		$this->idFactory->setDbValue($rs->fields('idFactory'));
		$this->dateFmea->setDbValue($rs->fields('dateFmea'));
		$this->partnumbers->setDbValue($rs->fields('partnumbers'));
		$this->description->setDbValue($rs->fields('description'));
		$this->idEmployee->setDbValue($rs->fields('idEmployee'));
		$this->idworkcenter->setDbValue($rs->fields('idworkcenter'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// fmea
		// idFactory
		// dateFmea
		// partnumbers
		// description
		// idEmployee
		// idworkcenter
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

		// fmea
		$this->fmea->EditAttrs["class"] = "form-control";
		$this->fmea->EditCustomAttributes = "";
		if (!$this->fmea->Raw)
			$this->fmea->CurrentValue = HtmlDecode($this->fmea->CurrentValue);
		$this->fmea->EditValue = $this->fmea->CurrentValue;
		$this->fmea->PlaceHolder = RemoveHtml($this->fmea->caption());

		// idFactory
		$this->idFactory->EditAttrs["class"] = "form-control";
		$this->idFactory->EditCustomAttributes = "";

		// dateFmea
		$this->dateFmea->EditAttrs["class"] = "form-control";
		$this->dateFmea->EditCustomAttributes = "";
		$this->dateFmea->EditValue = FormatDateTime($this->dateFmea->CurrentValue, 8);
		$this->dateFmea->PlaceHolder = RemoveHtml($this->dateFmea->caption());

		// partnumbers
		$this->partnumbers->EditAttrs["class"] = "form-control";
		$this->partnumbers->EditCustomAttributes = "";
		$this->partnumbers->EditValue = $this->partnumbers->CurrentValue;
		$this->partnumbers->PlaceHolder = RemoveHtml($this->partnumbers->caption());

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = RemoveHtml($this->description->caption());

		// idEmployee
		$this->idEmployee->EditAttrs["class"] = "form-control";
		$this->idEmployee->EditCustomAttributes = "";

		// idworkcenter
		$this->idworkcenter->EditAttrs["class"] = "form-control";
		$this->idworkcenter->EditCustomAttributes = "";

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
					$doc->exportCaption($this->fmea);
					$doc->exportCaption($this->idFactory);
					$doc->exportCaption($this->dateFmea);
					$doc->exportCaption($this->partnumbers);
					$doc->exportCaption($this->description);
					$doc->exportCaption($this->idEmployee);
					$doc->exportCaption($this->idworkcenter);
				} else {
					$doc->exportCaption($this->fmea);
					$doc->exportCaption($this->idFactory);
					$doc->exportCaption($this->dateFmea);
					$doc->exportCaption($this->partnumbers);
					$doc->exportCaption($this->description);
					$doc->exportCaption($this->idEmployee);
					$doc->exportCaption($this->idworkcenter);
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
						$doc->exportField($this->fmea);
						$doc->exportField($this->idFactory);
						$doc->exportField($this->dateFmea);
						$doc->exportField($this->partnumbers);
						$doc->exportField($this->description);
						$doc->exportField($this->idEmployee);
						$doc->exportField($this->idworkcenter);
					} else {
						$doc->exportField($this->fmea);
						$doc->exportField($this->idFactory);
						$doc->exportField($this->dateFmea);
						$doc->exportField($this->partnumbers);
						$doc->exportField($this->description);
						$doc->exportField($this->idEmployee);
						$doc->exportField($this->idworkcenter);
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

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>