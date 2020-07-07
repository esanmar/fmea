<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for processf
 */
class processf extends DbTable
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
	public $idProcess;
	public $fmea;
	public $step;
	public $flowchartDesc;
	public $partnumber;
	public $operation;
	public $derivedFromNC;
	public $numberOfNC;
	public $flowchart;
	public $subprocess;
	public $requirement;
	public $potencialFailureMode;
	public $potencialFailurEffect;
	public $kc;
	public $severity;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'processf';
		$this->TableName = 'processf';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`processf`";
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

		// idProcess
		$this->idProcess = new DbField('processf', 'processf', 'x_idProcess', 'idProcess', '`idProcess`', '`idProcess`', 3, 11, -1, FALSE, '`idProcess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idProcess->IsAutoIncrement = TRUE; // Autoincrement field
		$this->idProcess->IsPrimaryKey = TRUE; // Primary key field
		$this->idProcess->IsForeignKey = TRUE; // Foreign key field
		$this->idProcess->Sortable = FALSE; // Allow sort
		$this->idProcess->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idProcess'] = &$this->idProcess;

		// fmea
		$this->fmea = new DbField('processf', 'processf', 'x_fmea', 'fmea', '`fmea`', '`fmea`', 200, 255, -1, FALSE, '`EV__fmea`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->fmea->IsForeignKey = TRUE; // Foreign key field
		$this->fmea->Required = TRUE; // Required field
		$this->fmea->Sortable = TRUE; // Allow sort
		$this->fmea->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->fmea->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->fmea->Lookup = new Lookup('fmea', 'fmea', TRUE, 'fmea', ["fmea","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->fmea->Lookup = new Lookup('fmea', 'fmea', TRUE, 'fmea', ["fmea","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['fmea'] = &$this->fmea;

		// step
		$this->step = new DbField('processf', 'processf', 'x_step', 'step', '`step`', '`step`', 3, 11, -1, FALSE, '`step`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->step->Sortable = TRUE; // Allow sort
		$this->step->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['step'] = &$this->step;

		// flowchartDesc
		$this->flowchartDesc = new DbField('processf', 'processf', 'x_flowchartDesc', 'flowchartDesc', '`flowchartDesc`', '`flowchartDesc`', 201, -1, -1, FALSE, '`flowchartDesc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->flowchartDesc->Sortable = TRUE; // Allow sort
		$this->fields['flowchartDesc'] = &$this->flowchartDesc;

		// partnumber
		$this->partnumber = new DbField('processf', 'processf', 'x_partnumber', 'partnumber', '`partnumber`', '`partnumber`', 200, 255, -1, FALSE, '`partnumber`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->partnumber->Sortable = TRUE; // Allow sort
		$this->fields['partnumber'] = &$this->partnumber;

		// operation
		$this->operation = new DbField('processf', 'processf', 'x_operation', 'operation', '`operation`', '`operation`', 200, 255, -1, FALSE, '`operation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->operation->Sortable = TRUE; // Allow sort
		$this->fields['operation'] = &$this->operation;

		// derivedFromNC
		$this->derivedFromNC = new DbField('processf', 'processf', 'x_derivedFromNC', 'derivedFromNC', '`derivedFromNC`', '`derivedFromNC`', 202, 1, -1, FALSE, '`derivedFromNC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->derivedFromNC->Sortable = TRUE; // Allow sort
		$this->derivedFromNC->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->derivedFromNC->Lookup = new Lookup('derivedFromNC', 'processf', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->derivedFromNC->Lookup = new Lookup('derivedFromNC', 'processf', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->derivedFromNC->OptionCount = 2;
		$this->fields['derivedFromNC'] = &$this->derivedFromNC;

		// numberOfNC
		$this->numberOfNC = new DbField('processf', 'processf', 'x_numberOfNC', 'numberOfNC', '`numberOfNC`', '`numberOfNC`', 200, 255, -1, FALSE, '`numberOfNC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->numberOfNC->Sortable = TRUE; // Allow sort
		$this->fields['numberOfNC'] = &$this->numberOfNC;

		// flowchart
		$this->flowchart = new DbField('processf', 'processf', 'x_flowchart', 'flowchart', '`flowchart`', '`flowchart`', 200, 255, -1, FALSE, '`flowchart`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->flowchart->Sortable = TRUE; // Allow sort
		$this->fields['flowchart'] = &$this->flowchart;

		// subprocess
		$this->subprocess = new DbField('processf', 'processf', 'x_subprocess', 'subprocess', '`subprocess`', '`subprocess`', 200, 255, -1, FALSE, '`subprocess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->subprocess->Sortable = TRUE; // Allow sort
		$this->fields['subprocess'] = &$this->subprocess;

		// requirement
		$this->requirement = new DbField('processf', 'processf', 'x_requirement', 'requirement', '`requirement`', '`requirement`', 200, 255, -1, FALSE, '`requirement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->requirement->Sortable = TRUE; // Allow sort
		$this->fields['requirement'] = &$this->requirement;

		// potencialFailureMode
		$this->potencialFailureMode = new DbField('processf', 'processf', 'x_potencialFailureMode', 'potencialFailureMode', '`potencialFailureMode`', '`potencialFailureMode`', 200, 255, -1, FALSE, '`potencialFailureMode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->potencialFailureMode->Sortable = TRUE; // Allow sort
		$this->fields['potencialFailureMode'] = &$this->potencialFailureMode;

		// potencialFailurEffect
		$this->potencialFailurEffect = new DbField('processf', 'processf', 'x_potencialFailurEffect', 'potencialFailurEffect', '`potencialFailurEffect`', '`potencialFailurEffect`', 200, 255, -1, FALSE, '`potencialFailurEffect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->potencialFailurEffect->Sortable = TRUE; // Allow sort
		$this->fields['potencialFailurEffect'] = &$this->potencialFailurEffect;

		// kc
		$this->kc = new DbField('processf', 'processf', 'x_kc', 'kc', '`kc`', '`kc`', 202, 1, -1, FALSE, '`kc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->kc->Sortable = TRUE; // Allow sort
		$this->kc->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->kc->Lookup = new Lookup('kc', 'processf', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->kc->Lookup = new Lookup('kc', 'processf', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->kc->OptionCount = 2;
		$this->fields['kc'] = &$this->kc;

		// severity
		$this->severity = new DbField('processf', 'processf', 'x_severity', 'severity', '`severity`', '`severity`', 3, 11, -1, FALSE, '`severity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->severity->Sortable = TRUE; // Allow sort
		$this->severity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['severity'] = &$this->severity;
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

	// Current master table name
	public function getCurrentMasterTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")];
	}
	public function setCurrentMasterTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
	}

	// Session master WHERE clause
	public function getMasterFilter()
	{

		// Master filter
		$masterFilter = "";
		if ($this->getCurrentMasterTable() == "fmea") {
			if ($this->fmea->getSessionValue() != "")
				$masterFilter .= "`fmea`=" . QuotedValue($this->fmea->getSessionValue(), DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $masterFilter;
	}

	// Session detail WHERE clause
	public function getDetailFilter()
	{

		// Detail filter
		$detailFilter = "";
		if ($this->getCurrentMasterTable() == "fmea") {
			if ($this->fmea->getSessionValue() != "")
				$detailFilter .= "`fmea`=" . QuotedValue($this->fmea->getSessionValue(), DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_fmea()
	{
		return "`fmea`='@fmea@'";
	}

	// Detail filter
	public function sqlDetailFilter_fmea()
	{
		return "`fmea`='@fmea@'";
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
		if ($this->getCurrentDetailTable() == "actions") {
			$detailUrl = $GLOBALS["actions"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_idProcess=" . urlencode($this->idProcess->CurrentValue);
		}
		if ($detailUrl == "")
			$detailUrl = "processflist.php";
		return $detailUrl;
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`processf`";
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
			"SELECT *, (SELECT DISTINCT `fmea` FROM `fmea` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`fmea` = `processf`.`fmea` LIMIT 1) AS `EV__fmea` FROM `processf`" .
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
		if ($this->fmea->AdvancedSearch->SearchValue != "" ||
			$this->fmea->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->fmea->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->fmea->VirtualExpression . " "))
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

			// Get insert id if necessary
			$this->idProcess->setDbValue($conn->insert_ID());
			$rs['idProcess'] = $this->idProcess->DbValue;
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

		// Cascade Update detail table 'actions'
		$cascadeUpdate = FALSE;
		$rscascade = [];
		if ($rsold && (isset($rs['idProcess']) && $rsold['idProcess'] != $rs['idProcess'])) { // Update detail field 'idProcess'
			$cascadeUpdate = TRUE;
			$rscascade['idProcess'] = $rs['idProcess']; 
		}
		if ($cascadeUpdate) {
			if (!isset($GLOBALS["actions"]))
				$GLOBALS["actions"] = new actions();
			$rswrk = $GLOBALS["actions"]->loadRs("`idProcess` = " . QuotedValue($rsold['idProcess'], DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = [];
				$fldname = 'idProcess';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$fldname = 'idCause';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$success = $GLOBALS["actions"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($success)
					$success = $GLOBALS["actions"]->update($rscascade, $rskey, $rswrk->fields);
				if (!$success)
					return FALSE;

				// Call Row_Updated event
				$GLOBALS["actions"]->Row_Updated($rsdtlold, $rsdtlnew);
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
			if (array_key_exists('idProcess', $rs))
				AddFilter($where, QuotedName('idProcess', $this->Dbid) . '=' . QuotedValue($rs['idProcess'], $this->idProcess->DataType, $this->Dbid));
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

		// Cascade delete detail table 'actions'
		if (!isset($GLOBALS["actions"]))
			$GLOBALS["actions"] = new actions();
		$rscascade = $GLOBALS["actions"]->loadRs("`idProcess` = " . QuotedValue($rs['idProcess'], DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->getRows() : [];

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$success = $GLOBALS["actions"]->Row_Deleting($dtlrow);
			if (!$success)
				break;
		}
		if ($success) {
			foreach ($dtlrows as $dtlrow) {
				$success = $GLOBALS["actions"]->delete($dtlrow); // Delete
				if (!$success)
					break;
			}
		}

		// Call Row Deleted event
		if ($success) {
			foreach ($dtlrows as $dtlrow)
				$GLOBALS["actions"]->Row_Deleted($dtlrow);
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
		$this->idProcess->DbValue = $row['idProcess'];
		$this->fmea->DbValue = $row['fmea'];
		$this->step->DbValue = $row['step'];
		$this->flowchartDesc->DbValue = $row['flowchartDesc'];
		$this->partnumber->DbValue = $row['partnumber'];
		$this->operation->DbValue = $row['operation'];
		$this->derivedFromNC->DbValue = $row['derivedFromNC'];
		$this->numberOfNC->DbValue = $row['numberOfNC'];
		$this->flowchart->DbValue = $row['flowchart'];
		$this->subprocess->DbValue = $row['subprocess'];
		$this->requirement->DbValue = $row['requirement'];
		$this->potencialFailureMode->DbValue = $row['potencialFailureMode'];
		$this->potencialFailurEffect->DbValue = $row['potencialFailurEffect'];
		$this->kc->DbValue = $row['kc'];
		$this->severity->DbValue = $row['severity'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idProcess` = @idProcess@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('idProcess', $row) ? $row['idProcess'] : NULL;
		else
			$val = $this->idProcess->OldValue !== NULL ? $this->idProcess->OldValue : $this->idProcess->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idProcess@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "processflist.php";
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
		if ($pageName == "processfview.php")
			return $Language->phrase("View");
		elseif ($pageName == "processfedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "processfadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "processflist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("processfview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("processfview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "processfadd.php?" . $this->getUrlParm($parm);
		else
			$url = "processfadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("processfedit.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("processfedit.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
			$url = $this->keyUrl("processfadd.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("processfadd.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
		return $this->keyUrl("processfdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "fmea" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_fmea=" . urlencode($this->fmea->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idProcess:" . JsonEncode($this->idProcess->CurrentValue, "number");
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
		if ($this->idProcess->CurrentValue != NULL) {
			$url .= "idProcess=" . urlencode($this->idProcess->CurrentValue);
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
			if (Param("idProcess") !== NULL)
				$arKeys[] = Param("idProcess");
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
				$this->idProcess->CurrentValue = $key;
			else
				$this->idProcess->OldValue = $key;
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
		$this->idProcess->setDbValue($rs->fields('idProcess'));
		$this->fmea->setDbValue($rs->fields('fmea'));
		$this->step->setDbValue($rs->fields('step'));
		$this->flowchartDesc->setDbValue($rs->fields('flowchartDesc'));
		$this->partnumber->setDbValue($rs->fields('partnumber'));
		$this->operation->setDbValue($rs->fields('operation'));
		$this->derivedFromNC->setDbValue($rs->fields('derivedFromNC'));
		$this->numberOfNC->setDbValue($rs->fields('numberOfNC'));
		$this->flowchart->setDbValue($rs->fields('flowchart'));
		$this->subprocess->setDbValue($rs->fields('subprocess'));
		$this->requirement->setDbValue($rs->fields('requirement'));
		$this->potencialFailureMode->setDbValue($rs->fields('potencialFailureMode'));
		$this->potencialFailurEffect->setDbValue($rs->fields('potencialFailurEffect'));
		$this->kc->setDbValue($rs->fields('kc'));
		$this->severity->setDbValue($rs->fields('severity'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
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
		// idProcess

		$this->idProcess->ViewValue = $this->idProcess->CurrentValue;
		$this->idProcess->ViewCustomAttributes = "";

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

		// idProcess
		$this->idProcess->LinkCustomAttributes = "";
		$this->idProcess->HrefValue = "";
		$this->idProcess->TooltipValue = "";

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

		// idProcess
		$this->idProcess->EditAttrs["class"] = "form-control";
		$this->idProcess->EditCustomAttributes = "";
		$this->idProcess->EditValue = $this->idProcess->CurrentValue;
		$this->idProcess->ViewCustomAttributes = "";

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
		}

		// step
		$this->step->EditAttrs["class"] = "form-control";
		$this->step->EditCustomAttributes = "";
		$this->step->EditValue = $this->step->CurrentValue;
		$this->step->PlaceHolder = RemoveHtml($this->step->caption());

		// flowchartDesc
		$this->flowchartDesc->EditAttrs["class"] = "form-control";
		$this->flowchartDesc->EditCustomAttributes = "";
		$this->flowchartDesc->EditValue = $this->flowchartDesc->CurrentValue;
		$this->flowchartDesc->PlaceHolder = RemoveHtml($this->flowchartDesc->caption());

		// partnumber
		$this->partnumber->EditAttrs["class"] = "form-control";
		$this->partnumber->EditCustomAttributes = "";
		if (!$this->partnumber->Raw)
			$this->partnumber->CurrentValue = HtmlDecode($this->partnumber->CurrentValue);
		$this->partnumber->EditValue = $this->partnumber->CurrentValue;
		$this->partnumber->PlaceHolder = RemoveHtml($this->partnumber->caption());

		// operation
		$this->operation->EditAttrs["class"] = "form-control";
		$this->operation->EditCustomAttributes = "";
		if (!$this->operation->Raw)
			$this->operation->CurrentValue = HtmlDecode($this->operation->CurrentValue);
		$this->operation->EditValue = $this->operation->CurrentValue;
		$this->operation->PlaceHolder = RemoveHtml($this->operation->caption());

		// derivedFromNC
		$this->derivedFromNC->EditCustomAttributes = "";
		$this->derivedFromNC->EditValue = $this->derivedFromNC->options(FALSE);

		// numberOfNC
		$this->numberOfNC->EditAttrs["class"] = "form-control";
		$this->numberOfNC->EditCustomAttributes = "";
		if (!$this->numberOfNC->Raw)
			$this->numberOfNC->CurrentValue = HtmlDecode($this->numberOfNC->CurrentValue);
		$this->numberOfNC->EditValue = $this->numberOfNC->CurrentValue;
		$this->numberOfNC->PlaceHolder = RemoveHtml($this->numberOfNC->caption());

		// flowchart
		$this->flowchart->EditAttrs["class"] = "form-control";
		$this->flowchart->EditCustomAttributes = "";
		if (!$this->flowchart->Raw)
			$this->flowchart->CurrentValue = HtmlDecode($this->flowchart->CurrentValue);
		$this->flowchart->EditValue = $this->flowchart->CurrentValue;
		$this->flowchart->PlaceHolder = RemoveHtml($this->flowchart->caption());

		// subprocess
		$this->subprocess->EditAttrs["class"] = "form-control";
		$this->subprocess->EditCustomAttributes = "";
		if (!$this->subprocess->Raw)
			$this->subprocess->CurrentValue = HtmlDecode($this->subprocess->CurrentValue);
		$this->subprocess->EditValue = $this->subprocess->CurrentValue;
		$this->subprocess->PlaceHolder = RemoveHtml($this->subprocess->caption());

		// requirement
		$this->requirement->EditAttrs["class"] = "form-control";
		$this->requirement->EditCustomAttributes = "";
		if (!$this->requirement->Raw)
			$this->requirement->CurrentValue = HtmlDecode($this->requirement->CurrentValue);
		$this->requirement->EditValue = $this->requirement->CurrentValue;
		$this->requirement->PlaceHolder = RemoveHtml($this->requirement->caption());

		// potencialFailureMode
		$this->potencialFailureMode->EditAttrs["class"] = "form-control";
		$this->potencialFailureMode->EditCustomAttributes = "";
		if (!$this->potencialFailureMode->Raw)
			$this->potencialFailureMode->CurrentValue = HtmlDecode($this->potencialFailureMode->CurrentValue);
		$this->potencialFailureMode->EditValue = $this->potencialFailureMode->CurrentValue;
		$this->potencialFailureMode->PlaceHolder = RemoveHtml($this->potencialFailureMode->caption());

		// potencialFailurEffect
		$this->potencialFailurEffect->EditAttrs["class"] = "form-control";
		$this->potencialFailurEffect->EditCustomAttributes = "";
		if (!$this->potencialFailurEffect->Raw)
			$this->potencialFailurEffect->CurrentValue = HtmlDecode($this->potencialFailurEffect->CurrentValue);
		$this->potencialFailurEffect->EditValue = $this->potencialFailurEffect->CurrentValue;
		$this->potencialFailurEffect->PlaceHolder = RemoveHtml($this->potencialFailurEffect->caption());

		// kc
		$this->kc->EditCustomAttributes = "";
		$this->kc->EditValue = $this->kc->options(FALSE);

		// severity
		$this->severity->EditAttrs["class"] = "form-control";
		$this->severity->EditCustomAttributes = "";
		$this->severity->EditValue = $this->severity->CurrentValue;
		$this->severity->PlaceHolder = RemoveHtml($this->severity->caption());

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
					$doc->exportCaption($this->step);
					$doc->exportCaption($this->flowchartDesc);
					$doc->exportCaption($this->partnumber);
					$doc->exportCaption($this->operation);
					$doc->exportCaption($this->derivedFromNC);
					$doc->exportCaption($this->numberOfNC);
					$doc->exportCaption($this->flowchart);
					$doc->exportCaption($this->subprocess);
					$doc->exportCaption($this->requirement);
					$doc->exportCaption($this->potencialFailureMode);
					$doc->exportCaption($this->potencialFailurEffect);
					$doc->exportCaption($this->kc);
					$doc->exportCaption($this->severity);
				} else {
					$doc->exportCaption($this->fmea);
					$doc->exportCaption($this->step);
					$doc->exportCaption($this->flowchartDesc);
					$doc->exportCaption($this->partnumber);
					$doc->exportCaption($this->operation);
					$doc->exportCaption($this->derivedFromNC);
					$doc->exportCaption($this->numberOfNC);
					$doc->exportCaption($this->flowchart);
					$doc->exportCaption($this->subprocess);
					$doc->exportCaption($this->requirement);
					$doc->exportCaption($this->potencialFailureMode);
					$doc->exportCaption($this->potencialFailurEffect);
					$doc->exportCaption($this->kc);
					$doc->exportCaption($this->severity);
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
						$doc->exportField($this->step);
						$doc->exportField($this->flowchartDesc);
						$doc->exportField($this->partnumber);
						$doc->exportField($this->operation);
						$doc->exportField($this->derivedFromNC);
						$doc->exportField($this->numberOfNC);
						$doc->exportField($this->flowchart);
						$doc->exportField($this->subprocess);
						$doc->exportField($this->requirement);
						$doc->exportField($this->potencialFailureMode);
						$doc->exportField($this->potencialFailurEffect);
						$doc->exportField($this->kc);
						$doc->exportField($this->severity);
					} else {
						$doc->exportField($this->fmea);
						$doc->exportField($this->step);
						$doc->exportField($this->flowchartDesc);
						$doc->exportField($this->partnumber);
						$doc->exportField($this->operation);
						$doc->exportField($this->derivedFromNC);
						$doc->exportField($this->numberOfNC);
						$doc->exportField($this->flowchart);
						$doc->exportField($this->subprocess);
						$doc->exportField($this->requirement);
						$doc->exportField($this->potencialFailureMode);
						$doc->exportField($this->potencialFailurEffect);
						$doc->exportField($this->kc);
						$doc->exportField($this->severity);
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

		if ($this->severity->CurrentValue !== NULL && $this->severity->CurrentValue !== "")
		{
			$seve1=$this->severity->CurrentValue;
			$sevColor = ExecuteScalar("SELECT color FROM severity WHERE idSeverity = $seve1");
			$this->severity->CellAttrs["style"] = "background-color: $sevColor";
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>