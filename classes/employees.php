<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for employees
 */
class employees extends DbTable
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
	public $idEmployee;
	public $name;
	public $surname;
	public $idFactory;
	public $userlevel;
	public $password;
	public $workcenter;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'employees';
		$this->TableName = 'employees';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`employees`";
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
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// idEmployee
		$this->idEmployee = new DbField('employees', 'employees', 'x_idEmployee', 'idEmployee', '`idEmployee`', '`idEmployee`', 200, 50, -1, FALSE, '`idEmployee`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idEmployee->IsPrimaryKey = TRUE; // Primary key field
		$this->idEmployee->Nullable = FALSE; // NOT NULL field
		$this->idEmployee->Required = TRUE; // Required field
		$this->idEmployee->Sortable = TRUE; // Allow sort
		$this->fields['idEmployee'] = &$this->idEmployee;

		// name
		$this->name = new DbField('employees', 'employees', 'x_name', 'name', '`name`', '`name`', 200, 255, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->name->Nullable = FALSE; // NOT NULL field
		$this->name->Required = TRUE; // Required field
		$this->name->Sortable = TRUE; // Allow sort
		$this->fields['name'] = &$this->name;

		// surname
		$this->surname = new DbField('employees', 'employees', 'x_surname', 'surname', '`surname`', '`surname`', 200, 255, -1, FALSE, '`surname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->surname->Nullable = FALSE; // NOT NULL field
		$this->surname->Required = TRUE; // Required field
		$this->surname->Sortable = TRUE; // Allow sort
		$this->fields['surname'] = &$this->surname;

		// idFactory
		$this->idFactory = new DbField('employees', 'employees', 'x_idFactory', 'idFactory', '`idFactory`', '`idFactory`', 200, 50, -1, FALSE, '`EV__idFactory`', TRUE, FALSE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->idFactory->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "en":
				$this->idFactory->Lookup = new Lookup('idFactory', 'factories', TRUE, 'idFactory', ["factory","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idFactory->Lookup = new Lookup('idFactory', 'factories', TRUE, 'idFactory', ["factory","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idFactory->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idFactory'] = &$this->idFactory;

		// userlevel
		$this->userlevel = new DbField('employees', 'employees', 'x_userlevel', 'userlevel', '`userlevel`', '`userlevel`', 3, 11, -1, FALSE, '`userlevel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->userlevel->Required = TRUE; // Required field
		$this->userlevel->Sortable = TRUE; // Allow sort
		$this->userlevel->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->userlevel->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->userlevel->Lookup = new Lookup('userlevel', 'userlevels', FALSE, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->userlevel->Lookup = new Lookup('userlevel', 'userlevels', FALSE, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->userlevel->OptionCount = 3;
		$this->userlevel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['userlevel'] = &$this->userlevel;

		// password
		$this->password = new DbField('employees', 'employees', 'x_password', 'password', '`password`', '`password`', 200, 50, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->password->Required = TRUE; // Required field
		$this->password->Sortable = TRUE; // Allow sort
		$this->fields['password'] = &$this->password;

		// workcenter
		$this->workcenter = new DbField('employees', 'employees', 'x_workcenter', 'workcenter', '`workcenter`', '`workcenter`', 200, 6, -1, FALSE, '`EV__workcenter`', TRUE, FALSE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->workcenter->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "en":
				$this->workcenter->Lookup = new Lookup('workcenter', 'workcenters', FALSE, 'workcenter', ["workcenter","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->workcenter->Lookup = new Lookup('workcenter', 'workcenters', FALSE, 'workcenter', ["workcenter","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['workcenter'] = &$this->workcenter;
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

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`employees`";
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
			"SELECT *, (SELECT DISTINCT `factory` FROM `factories` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`idFactory` = `employees`.`idFactory` LIMIT 1) AS `EV__idFactory`, (SELECT `workcenter` FROM `workcenters` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`workcenter` = `employees`.`workcenter` LIMIT 1) AS `EV__workcenter` FROM `employees`" .
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
		global $Security;

		// Add User ID filter
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$filter = $this->addUserIDFilter($filter);
		}
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = $this->UserIDAllowSecurity;
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
		if ($this->idFactory->AdvancedSearch->SearchValue != "" ||
			$this->idFactory->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->idFactory->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->idFactory->VirtualExpression . " "))
			return TRUE;
		if ($this->workcenter->AdvancedSearch->SearchValue != "" ||
			$this->workcenter->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->workcenter->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->workcenter->VirtualExpression . " "))
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
			if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME"))
				$value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
			if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
				if ($value == $this->fields[$name]->OldValue) // No need to update hashed password if not changed
					continue;
				$value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
			}
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
			if (array_key_exists('idEmployee', $rs))
				AddFilter($where, QuotedName('idEmployee', $this->Dbid) . '=' . QuotedValue($rs['idEmployee'], $this->idEmployee->DataType, $this->Dbid));
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
		$this->idEmployee->DbValue = $row['idEmployee'];
		$this->name->DbValue = $row['name'];
		$this->surname->DbValue = $row['surname'];
		$this->idFactory->DbValue = $row['idFactory'];
		$this->userlevel->DbValue = $row['userlevel'];
		$this->password->DbValue = $row['password'];
		$this->workcenter->DbValue = $row['workcenter'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idEmployee` = '@idEmployee@'";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('idEmployee', $row) ? $row['idEmployee'] : NULL;
		else
			$val = $this->idEmployee->OldValue !== NULL ? $this->idEmployee->OldValue : $this->idEmployee->CurrentValue;
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idEmployee@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "employeeslist.php";
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
		if ($pageName == "employeesview.php")
			return $Language->phrase("View");
		elseif ($pageName == "employeesedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "employeesadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "employeeslist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("employeesview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("employeesview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "employeesadd.php?" . $this->getUrlParm($parm);
		else
			$url = "employeesadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("employeesedit.php", $this->getUrlParm($parm));
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
		$url = $this->keyUrl("employeesadd.php", $this->getUrlParm($parm));
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
		return $this->keyUrl("employeesdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idEmployee:" . JsonEncode($this->idEmployee->CurrentValue, "string");
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
		if ($this->idEmployee->CurrentValue != NULL) {
			$url .= "idEmployee=" . urlencode($this->idEmployee->CurrentValue);
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
			if (Param("idEmployee") !== NULL)
				$arKeys[] = Param("idEmployee");
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
				$this->idEmployee->CurrentValue = $key;
			else
				$this->idEmployee->OldValue = $key;
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
		$this->idEmployee->setDbValue($rs->fields('idEmployee'));
		$this->name->setDbValue($rs->fields('name'));
		$this->surname->setDbValue($rs->fields('surname'));
		$this->idFactory->setDbValue($rs->fields('idFactory'));
		$this->userlevel->setDbValue($rs->fields('userlevel'));
		$this->password->setDbValue($rs->fields('password'));
		$this->workcenter->setDbValue($rs->fields('workcenter'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
		// idEmployee
		// name
		// surname
		// idFactory
		// userlevel
		// password
		// workcenter
		// idEmployee

		$this->idEmployee->ViewValue = $this->idEmployee->CurrentValue;
		$this->idEmployee->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// surname
		$this->surname->ViewValue = $this->surname->CurrentValue;
		$this->surname->ViewCustomAttributes = "";

		// idFactory
		if ($this->idFactory->VirtualValue != "") {
			$this->idFactory->ViewValue = $this->idFactory->VirtualValue;
		} else {
			$this->idFactory->ViewValue = $this->idFactory->CurrentValue;
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

		// userlevel
		if ($Security->canAdmin()) { // System admin
			if (strval($this->userlevel->CurrentValue) != "") {
				$this->userlevel->ViewValue = $this->userlevel->optionCaption($this->userlevel->CurrentValue);
			} else {
				$this->userlevel->ViewValue = NULL;
			}
		} else {
			$this->userlevel->ViewValue = $Language->phrase("PasswordMask");
		}
		$this->userlevel->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// workcenter
		if ($this->workcenter->VirtualValue != "") {
			$this->workcenter->ViewValue = $this->workcenter->VirtualValue;
		} else {
			$this->workcenter->ViewValue = $this->workcenter->CurrentValue;
			$curVal = strval($this->workcenter->CurrentValue);
			if ($curVal != "") {
				$this->workcenter->ViewValue = $this->workcenter->lookupCacheOption($curVal);
				if ($this->workcenter->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`workcenter`" . SearchString("=", $curVal, DATATYPE_STRING, "");
					$sqlWrk = $this->workcenter->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$this->workcenter->ViewValue = $this->workcenter->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->workcenter->ViewValue = $this->workcenter->CurrentValue;
					}
				}
			} else {
				$this->workcenter->ViewValue = NULL;
			}
		}
		$this->workcenter->ViewCustomAttributes = "";

		// idEmployee
		$this->idEmployee->LinkCustomAttributes = "";
		$this->idEmployee->HrefValue = "";
		$this->idEmployee->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// surname
		$this->surname->LinkCustomAttributes = "";
		$this->surname->HrefValue = "";
		$this->surname->TooltipValue = "";

		// idFactory
		$this->idFactory->LinkCustomAttributes = "";
		$this->idFactory->HrefValue = "";
		$this->idFactory->TooltipValue = "";

		// userlevel
		$this->userlevel->LinkCustomAttributes = "";
		$this->userlevel->HrefValue = "";
		$this->userlevel->TooltipValue = "";

		// password
		$this->password->LinkCustomAttributes = "";
		$this->password->HrefValue = "";
		$this->password->TooltipValue = "";

		// workcenter
		$this->workcenter->LinkCustomAttributes = "";
		$this->workcenter->HrefValue = "";
		$this->workcenter->TooltipValue = "";

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

		// idEmployee
		$this->idEmployee->EditAttrs["class"] = "form-control";
		$this->idEmployee->EditCustomAttributes = "";
		if (!$this->idEmployee->Raw)
			$this->idEmployee->CurrentValue = HtmlDecode($this->idEmployee->CurrentValue);
		$this->idEmployee->EditValue = $this->idEmployee->CurrentValue;
		$this->idEmployee->PlaceHolder = RemoveHtml($this->idEmployee->caption());

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		if (!$this->name->Raw)
			$this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = RemoveHtml($this->name->caption());

		// surname
		$this->surname->EditAttrs["class"] = "form-control";
		$this->surname->EditCustomAttributes = "";
		if (!$this->surname->Raw)
			$this->surname->CurrentValue = HtmlDecode($this->surname->CurrentValue);
		$this->surname->EditValue = $this->surname->CurrentValue;
		$this->surname->PlaceHolder = RemoveHtml($this->surname->caption());

		// idFactory
		$this->idFactory->EditAttrs["class"] = "form-control";
		$this->idFactory->EditCustomAttributes = "";
		if (!$this->idFactory->Raw)
			$this->idFactory->CurrentValue = HtmlDecode($this->idFactory->CurrentValue);
		$this->idFactory->EditValue = $this->idFactory->CurrentValue;
		$this->idFactory->PlaceHolder = RemoveHtml($this->idFactory->caption());

		// userlevel
		$this->userlevel->EditAttrs["class"] = "form-control";
		$this->userlevel->EditCustomAttributes = "";
		if (!$Security->canAdmin()) { // System admin
			$this->userlevel->EditValue = $Language->phrase("PasswordMask");
		} else {
			$this->userlevel->EditValue = $this->userlevel->options(TRUE);
		}

		// password
		$this->password->EditAttrs["class"] = "form-control";
		$this->password->EditCustomAttributes = "";
		if (!$this->password->Raw)
			$this->password->CurrentValue = HtmlDecode($this->password->CurrentValue);
		$this->password->EditValue = $this->password->CurrentValue;
		$this->password->PlaceHolder = RemoveHtml($this->password->caption());

		// workcenter
		$this->workcenter->EditAttrs["class"] = "form-control";
		$this->workcenter->EditCustomAttributes = "";
		if (!$this->workcenter->Raw)
			$this->workcenter->CurrentValue = HtmlDecode($this->workcenter->CurrentValue);
		$this->workcenter->EditValue = $this->workcenter->CurrentValue;
		$this->workcenter->PlaceHolder = RemoveHtml($this->workcenter->caption());

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
					$doc->exportCaption($this->idEmployee);
					$doc->exportCaption($this->name);
					$doc->exportCaption($this->surname);
					$doc->exportCaption($this->idFactory);
					$doc->exportCaption($this->userlevel);
					$doc->exportCaption($this->password);
					$doc->exportCaption($this->workcenter);
				} else {
					$doc->exportCaption($this->idEmployee);
					$doc->exportCaption($this->name);
					$doc->exportCaption($this->surname);
					$doc->exportCaption($this->idFactory);
					$doc->exportCaption($this->userlevel);
					$doc->exportCaption($this->password);
					$doc->exportCaption($this->workcenter);
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
						$doc->exportField($this->idEmployee);
						$doc->exportField($this->name);
						$doc->exportField($this->surname);
						$doc->exportField($this->idFactory);
						$doc->exportField($this->userlevel);
						$doc->exportField($this->password);
						$doc->exportField($this->workcenter);
					} else {
						$doc->exportField($this->idEmployee);
						$doc->exportField($this->name);
						$doc->exportField($this->surname);
						$doc->exportField($this->idFactory);
						$doc->exportField($this->userlevel);
						$doc->exportField($this->password);
						$doc->exportField($this->workcenter);
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

	// User ID filter
	public function getUserIDFilter($userId)
	{
		$userIdFilter = '`idEmployee` = ' . QuotedValue($userId, DATATYPE_STRING, Config("USER_TABLE_DBID"));
		$parentUserIdFilter = '`idEmployee` IN (SELECT `idEmployee` FROM ' . "`employees`" . ' WHERE `idEmployee` = ' . QuotedValue($userId, DATATYPE_STRING, Config("USER_TABLE_DBID")) . ')';
		$userIdFilter = "($userIdFilter) OR ($parentUserIdFilter)";
		return $userIdFilter;
	}

	// Add User ID filter
	public function addUserIDFilter($filter = "")
	{
		global $Security;
		$filterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->userIdAllow($id) && !$Security->isAdmin()) {
			$filterWrk = $Security->userIdList();
			if ($filterWrk != "")
				$filterWrk = '`idEmployee` IN (' . $filterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($filterWrk);
		AddFilter($filter, $filterWrk);
		return $filter;
	}

	// Add Parent User ID filter
	public function addParentUserIDFilter($userId)
	{
		global $Security;
		if (!$Security->isAdmin()) {
			$result = $Security->parentUserIDList($userId);
			if ($result != "")
				$result = '`idEmployee` IN (' . $result . ')';
			return $result;
		}
		return "";
	}

	// User ID subquery
	public function getUserIDSubquery(&$fld, &$masterfld)
	{
		global $UserTable;
		$wrk = "";
		$sql = "SELECT " . $masterfld->Expression . " FROM `employees`";
		$filter = $this->addUserIDFilter("");
		if ($filter != "")
			$sql .= " WHERE " . $filter;

		// Use subquery
		if (Config("USE_SUBQUERY_FOR_MASTER_USER_ID")) {
			$wrk = $sql;
		} else {

			// List all values
			if ($rs = Conn($UserTable->Dbid)->execute($sql)) {
				while (!$rs->EOF) {
					if ($wrk != "")
						$wrk .= ",";
					$wrk .= QuotedValue($rs->fields[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
					$rs->moveNext();
				}
				$rs->close();
			}
		}
		if ($wrk != "")
			$wrk = $fld->Expression . " IN (" . $wrk . ")";
		return $wrk;
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