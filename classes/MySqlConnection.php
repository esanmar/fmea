<?php
/**
 * MySQL API
 * (C) 2020 e.World Technology Limited
 *
 * Based on:
 * v1.42 ADOdb Lite 11 January 2007 (C) 2005-2007 Mark Dickenson. Released LGPL.
 */

/**
 * MySqlConnection
 */
class MySqlConnection
{
	public $_connectionID = false;
	public $database;
	public $dbtype = 'mysqli';
	public $host;
	public $open;
	public $password;
	public $username;
	public $persistent;
	public $debug = false;
	public $debug_console = false;
	public $debug_output;
	public $forcenewconnection = false;
	public $createdatabase = false;
	public $socket = false;
	public $port = false;
	public $clientFlags = 0;
	public $sql;
	public $raiseErrorFn = false;
	public $query_count = 0;
	public $query_time_total = 0;
	public $query_list = [];
	public $query_list_time = [];
	public $query_list_errors = [];
	public $info;
	public $transOff = 0;
	public $transCnt = 0;
	public $transaction_status = true;
	public $sysDate = 'CURDATE()';
	public $sysTimeStamp = 'NOW()';
	public $isoDates = true; // Accepts dates in ISO format
	public $fetchMode;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		global $ADODB_FETCH_MODE;
		$this->fetchMode = $ADODB_FETCH_MODE;
	}

	/**
	 * Get version number
	 *
	 * @return string
	 */
	public static function Version()
	{
		return '1.0.0';
	}

	/**
	 * Check if connected to database
	 *
	 * @return boolean
	 */
	public function IsConnected()
	{
		return $this->_connectionID === false || $this->_connectionID == false;
	}

	/**
	 * Normal Database connection
	 *
	 * @param string $database
	 * @param string $host
	 * @param string $password
	 * @param string $username
	 * @param string $forcenew
	 * @return boolean
	 */
	public function Connect($host = "", $username = "", $password = "", $database = "", $forcenew = false)
	{
		return $this->_connect($host, $username, $password, $database, false, $forcenew);
	}

	/**
	 * Persistent Database connection
	 *
	 * @param string $database
	 * @param string $host
	 * @param string $password
	 * @param string $username
	 * @return boolean
	 */
	public function PConnect($host = "", $username = "", $password = "", $database = "")
	{
		return $this->_connect($host, $username, $password, $database, true, false);
	}

	/**
	 * Force New Database connection
	 *
	 * @param string $database
	 * @param string $host
	 * @param string $password
	 * @param string $username
	 * @return boolean
	 */
	public function NConnect($host = "", $username = "", $password = "", $database = "")
	{
		return $this->_connect($host, $username, $password, $database, false, true);
	}

	/**
	 * Returns SQL query and instantiates sql statement & recordset driver
	 *
	 * @param string $sql
	 * @return MySqlRecordSet|false
	 */
	public function &Execute($sql, $inputarr = false)
	{
		$rs = &$this->do_query($sql, -1, -1, $inputarr);
		return $rs;
	}

	/**
	 * Returns SQL query and instantiates sql statement & recordset driver
	 *
	 * @param string $sql
	 * @param string $nrows
	 * @param string $offset
	 * @return MySqlRecordSet|false
	 */
	public function &SelectLimit($sql, $nrows = -1, $offset = -1, $inputarr = false)
	{
		$rs = &$this->do_query($sql, $offset, $nrows, $inputarr);
		return $rs;
	}

	/**
	 * Display debug output and database error
	 *
	 * @return void
	 */
	public function outp($text, $newline = true)
	{
		global $ADODB_OUTP;
		$this->debug_output = "(" . $this->dbtype . "): " . htmlspecialchars($text) . ". Error: " .
		$this->ErrorMsg() . " (" . $this->ErrorNo() . ")";

		if (defined('ADODB_OUTP')) {
			$fn = ADODB_OUTP;
		} else if (isset($ADODB_OUTP)) {
			$fn = $ADODB_OUTP;
		}

		if (defined('ADODB_OUTP') || isset($ADODB_OUTP)) {
			$fn($this->debug_output, $newline);
			return;
		}
	}

	/**
	 * Connection to database server and selected database
	 *
	 * @return boolean
	 */
	protected function _connect($host = "", $username = "", $password = "", $database = "", $persistent, $forcenew)
	{
		if (!function_exists('mysqli_real_connect')) {
			return false;
		}

		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->persistent = $persistent;
		$this->forcenewconnection = $forcenew;

		$this->_connectionID = @mysqli_init();
		@mysqli_real_connect($this->_connectionID, $this->host, $this->username, $this->password, $this->database, $this->port, $this->socket, $this->clientFlags);

		if (mysqli_connect_errno() != 0) {
			$this->_connectionID = false;
		}

		if ($this->_connectionID === false) {
			if ($fn = $this->raiseErrorFn) {
				$fn($this->dbtype, 'CONNECT', $this->ErrorNo(), $this->ErrorMsg(), $this->host, $this->database, $this);
			}

			return false;
		}

		if (!empty($this->database)) {
			if ($this->SelectDB($this->database) == false) {
				$this->_connectionID = false;
				return false;
			}
		}

		return true;
	}

	/**
	 * Choose a database to connect.
	 *
	 * @param string $dbname Name of the database to select
	 * @return boolean
	 */
	public function SelectDB($dbname)
	{
		$this->database = $dbname;

		if ($this->_connectionID === false) {
			$this->_connectionID = false;
			return false;
		} else {
			$result = @mysqli_select_db($this->_connectionID, $this->database);

			if ($result === false) {
				if ($this->createdatabase == true) {
					$result = @mysqli_query($this->_connectionID, "CREATE DATABASE IF NOT EXISTS " . $this->database);
					if ($result === false) { // Error handling if query fails
						return false;
					}
					$result = @mysqli_select_db($this->_connectionID, $this->database);
					if ($result === false) {
						return false;
					}
				} else {
					return false;
				}
			}
			return true;
		}
	}

	/**
	 * Get database error message
	 *
	 * @return string Database error message
	 */
	public function ErrorMsg()
	{
		if ($this->_connectionID === false) {
			return @mysqli_connect_error();
		} else {
			return @mysqli_error($this->_connectionID);
		}
	}

	/**
	 * Get database error number
	 *
	 * @return integer Database error number
	 */
	public function ErrorNo()
	{
		if ($this->_connectionID === false) {
			return @mysqli_connect_errno();
		} else {
			return @mysqli_errno($this->_connectionID);
		}
	}

	/**
	 * Get number of affected rows from insert/delete/update query
	 *
	 * @return integer Affected rows
	 */
	public function Affected_Rows()
	{
		return @mysqli_affected_rows($this->_connectionID);
	}

	/**
	 * Get the last record id of an inserted item
	 *
	 * @return mixed The last record id of an inserted item
	 */
	public function Insert_ID()
	{
		return @mysqli_insert_id($this->_connectionID);
	}

	/**
	 * Correctly quotes a string so that all strings are escape coded
	 *
	 * @param string $string String to quote
	 * @return string Single-quoted string
	 */
	public function qstr($string)
	{
		return "'" . mysqli_real_escape_string($this->_connectionID, $string) . "'";
	}

	/**
	 * Returns concatenated string
	 *
	 * @param string Strings to concat
	 * @return string Concatenated string
	 */
	public function Concat()
	{
		$arr = func_get_args();
		$list = implode(', ', $arr);

		if (strlen($list) > 0) {
			return "CONCAT($list)";
		} else {
			return '';
		}

	}

	/**
	 * Closes database connection
	 *
	 * @return void
	 */
	public function Close()
	{
		@mysqli_close($this->_connectionID);
		$this->_connectionID = false;
	}

	/**
	 * Starts transaction
	 *
	 * @param string $errfn
	 * @return void
	 */
	public function StartTrans($errfn = 'ADODB_TransMonitor')
	{
		if ($this->transOff > 0) {
			$this->transOff += 1;
			return;
		}
		$this->transaction_status = true;

		if ($this->debug && $this->transCnt > 0) {
			$this->outp("Bad Transaction: StartTrans called within BeginTrans");
		}

		$this->BeginTrans();
		$this->transOff = 1;
	}

	/**
	 * Begin transaction
	 *
	 * @return true
	 */
	public function BeginTrans()
	{
		if ($this->transOff) {
			return true;
		}

		$this->transCnt += 1;
		$this->Execute('SET AUTOCOMMIT=0');
		$this->Execute('BEGIN');
		return true;
	}

	/**
	 * Complete transaction
	 *
	 * @param boolean $autoComplete
	 * @return boolean
	 */
	public function CompleteTrans($autoComplete = true)
	{
		if ($this->transOff > 1) {
			$this->transOff -= 1;
			return true;
		}
		$this->transOff = 0;
		if ($this->transaction_status && $autoComplete) {
			if (!$this->CommitTrans()) {
				$this->transaction_status = false;
				if ($this->debug) {
					$this->outp("Smart Commit failed");
				}

			} else
			if ($this->debug) {
				$this->outp("Smart Commit occurred");
			}

		} else {
			$this->RollbackTrans();
			if ($this->debug) {
				$this->outp("Smart Rollback occurred");
			}

		}
		return $this->transaction_status;
	}

	/**
	 * Commit transaction
	 *
	 * @param boolean $ok
	 * @return true
	 */
	public function CommitTrans($ok = true)
	{
		if ($this->transOff) {
			return true;
		}

		if (!$ok) {
			return
			$this->RollbackTrans();
		}

		if ($this->transCnt) {
			$this->transCnt -= 1;
		}

		$this->Execute('COMMIT');
		$this->Execute('SET AUTOCOMMIT=1');
		return true;
	}

	/**
	 * Rollback transaction
	 *
	 * @return true
	 */
	public function RollbackTrans()
	{
		if ($this->transOff) {
			return true;
		}

		if ($this->transCnt) {
			$this->transCnt -= 1;
		}

		$this->Execute('ROLLBACK');
		$this->Execute('SET AUTOCOMMIT=1');
		return true;
	}

	/**
	 * Fail transaction
	 *
	 * @return void
	 */
	public function FailTrans()
	{
		if ($this->debug) {
			if ($this->transOff == 0) {
				$this->outp("FailTrans outside StartTrans/CompleteTrans");
			} else {
				$this->outp("FailTrans was called");
			}
		}

		$this->transaction_status = false;
	}

	/**
	 * Has failed transaction
	 *
	 * @return boolean
	 */
	public function HasFailedTrans()
	{
		if ($this->transOff > 0) {
			return $this->transaction_status == false;
		}

		return false;
	}

	/**
	 * Returns all records in an array
	 *
	 * @return array All records
	 */
	public function &GetArray($sql, $inputarr = false)
	{
		$data = false;
		$result = &$this->Execute($sql, $inputarr);
		if ($result) {
			$data = &$result->GetArray();
			$result->Close();
		}
		return $data;
	}

	/**
	 * Returns all records in an array
	 */
	public function &GetAll($sql, $inputarr = false)
	{
		$data = &$this->GetArray($sql, $inputarr);
		return $data;
	}

	/**
	 * Returns first element of first row of sql statement. Recordset is disposed for you.
	 *
	 * @param string $sql SQL statement
	 * @param array $inputarr Input bind array
	 * @return mixed Field value
	 */
	public function GetOne($sql, $inputarr = false)
	{
		$ret = false;
		$rs = &$this->Execute($sql, $inputarr);
		if ($rs) {
			if (!$rs->EOF) {
				$ret = reset($rs->fields);
			}

			$rs->Close();
		}
		return $ret;
	}

	/**
	 * Set fetch mode
	 *
	 * @param integer $mode The fetchmode ADODB_FETCH_ASSOC or ADODB_FETCH_NUM
	 * @return integer The previous fetch mode
	 */
	function SetFetchMode($mode) {
		$old = $this->fetchMode;
		$this->fetchMode = $mode;

		if ($old === false) {
			global $ADODB_FETCH_MODE;
			return $ADODB_FETCH_MODE;
		}
		return $old;
	}

	/**
	 * Executes SQL query
	 *
	 * @return MySqlRecordSet|false
	 */
	public function &do_query($sql, $offset, $nrows, $inputarr = false)
	{
		$false = false;

		$limit = '';
		if ($offset >= 0 || $nrows >= 0) {
			$offset = ($offset >= 0) ? $offset . "," : '';
			$nrows = ($nrows >= 0) ? $nrows : '18446744073709551615';
			$limit = ' LIMIT ' . $offset . ' ' . $nrows;
		}

		if ($inputarr && is_array($inputarr)) {
			$sqlarr = explode('?', $sql);
			if (!is_array(reset($inputarr))) {
				$inputarr = [$inputarr];
			}

			foreach ($inputarr as $arr) {
				$sql = '';
				$i = 0;
				foreach ($arr as $v) {
					$sql .= $sqlarr[$i];
					switch (gettype($v)) {
						case 'string':
							$sql .= $this->qstr($v);
							break;
						case 'double':
							$sql .= str_replace(',', '.', $v);
							break;
						case 'boolean':
							$sql .= $v ? 1 : 0;
							break;
						default:
							if ($v === null) {
								$sql .= 'NULL';
							} else {
								$sql .= $v;
							}

					}
					$i += 1;
				}
				$sql .= $sqlarr[$i];
				if ($i + 1 != sizeof($sqlarr)) {
					return $false;
				}

				$this->sql = $sql . $limit;
				$time_start = array_sum(explode(' ', microtime()));
				$this->query_count++;
				$resultId = @mysqli_query($this->_connectionID, $this->sql);
				$time_total = (array_sum(explode(' ', microtime())) - $time_start);
				$this->query_time_total += $time_total;
				if ($this->debug_console) {
					$this->query_list[] = $this->sql;
					$this->query_list_time[] = $time_total;
					$this->query_list_errors[] = $this->ErrorMsg();
				}
				if ($this->debug) {
					$this->outp($sql . $limit);
				}
			}
		} else {
			$this->sql = $sql . $limit;
			$time_start = array_sum(explode(' ', microtime()));
			$this->query_count++;
			$resultId = @mysqli_query($this->_connectionID, $this->sql);
			$time_total = (array_sum(explode(' ', microtime())) - $time_start);
			$this->query_time_total += $time_total;
			if ($this->debug_console) {
				$this->query_list[] = $this->sql;
				$this->query_list_time[] = $time_total;
				$this->query_list_errors[] = $this->ErrorMsg();
			}
			if ($this->debug) {
				$this->outp($sql . $limit);
			}
		}

		if ($resultId === false) { // Error handling if query fails
			if ($fn = $this->raiseErrorFn) {
				$fn($this->dbtype, 'EXECUTE', $this->ErrorNo(), $this->ErrorMsg(), $this->sql, $inputarr, $this);
			}

			return $false;
		}

		if ($resultId === true) { // Return simplified recordset for inserts/updates/deletes with lower overhead
			$recordset = new MySqlRecordSetBase();
			return $recordset;
		}

		$recordset = new MySqlRecordSet($resultId, $this->_connectionID);

		$recordset->_currentRow = 0;

		switch ($this->fetchMode) {
			case 1: // ADODB_FETCH_NUM
				$recordset->fetchMode = MYSQLI_NUM;
				break;
			case 2: // ADODB_FETCH_ASSOC
				$recordset->fetchMode = MYSQLI_ASSOC;
				break;
			default: // ADODB_FETCH_DEFAULT and ADODB_FETCH_BOTH
				$recordset->fetchMode = MYSQLI_BOTH;
				break;
		}

		$recordset->_numOfRows = @mysqli_num_rows($resultId);
		if ($recordset->_numOfRows == 0) {
			$recordset->EOF = true;
		}
		$recordset->_numOfFields = @mysqli_num_fields($resultId);
		$recordset->_fetch();

		return $recordset;
	}
}

/**
 * Class MySqlRecordSet
 */
class MySqlRecordSet extends MySqlRecordSetBase
{
	public $_connectionID;
	public $resultId;
	public $_currentRow = 0;
	public $_numOfRows = -1;
	public $_numOfFields = -1;
	public $fetchMode;

	/**
	 * Constructor
	 *
	 * @param string $resultId
	 * @param string $connectionID
	 */
	public function __construct($resultId, $connectionId)
	{
		$this->fields = [];
		$this->_connectionID = $connectionId;
		$this->record = [];
		$this->resultId = $resultId;
		$this->EOF = false;
	}

	/**
	 * Free recordset
	 *
	 * @return void
	 */
	public function Close()
	{
		@mysqli_free_result($this->resultId);
		$this->fields = [];
		$this->resultId = false;
	}

	/**
	 * Get field value(s) from select query
	 *
	 * @param string $field Field name
	 * @return array|mixed Field value(s)
	 */
	public function Fields($field)
	{
		if (empty($field)) {
			return $this->fields;
		} else {
			return $this->fields[$field];
		}
	}

	/**
	 * Get number of rows from select query
	 *
	 * @return integer Number of rows
	 */
	public function RecordCount()
	{
		return $this->_numOfRows;
	}

	/**
	 * Get number of fields from select query
	 *
	 * @return integer Number of fields
	 */
	public function FieldCount()
	{
		return $this->_numOfFields;
	}

	/**
	 * Move to next record
	 *
	 * @return boolean
	 */
	public function MoveNext()
	{
		$this->fields = @mysqli_fetch_array($this->resultId, $this->fetchMode);
		if ($this->fields) {
			$this->_currentRow += 1;
			return true;
		}
		if (!$this->EOF) {
			$this->_currentRow += 1;
			$this->EOF = true;
		}
		return false;
	}

	/**
	 * Move to the first row in the recordset
	 *
	 * @return boolean
	 */
	public function MoveFirst()
	{
		if ($this->_currentRow == 0) {
			return true;
		}

		return $this->Move(0);
	}

	/**
	 * Move to the last record
	 *
	 * @return boolean
	 */
	public function MoveLast()
	{
		if ($this->EOF) {
			return false;
		}

		return $this->Move($this->_numOfRows - 1);
	}

	/**
	 * Random access to a specific row in the recordset
	 *
	 * @param rowNumber is the row to move to (0-based)
	 * @return boolean True if there still rows available, or false if there are no more rows (EOF).
	 */
	public function Move($rowNumber = 0)
	{
		if ($rowNumber == $this->_currentRow) {
			return true;
		}

		$this->EOF = false;
		if ($this->_numOfRows > 0) {
			if ($rowNumber >= $this->_numOfRows - 1) {
				$rowNumber = $this->_numOfRows - 1;
			}
		}

		if ($this->_seek($rowNumber)) {
			$this->_currentRow = $rowNumber;
			if ($this->_fetch()) {
				return true;
			}
			$this->fields = false;
		}
		$this->EOF = true;
		return false;
	}

	/**
	 * Perform Seek to specific row
	 *
	 * @param integer $row Field offset
	 * @return boolean
	 */
	public function _seek($row)
	{
		if ($this->_numOfRows == 0) {
			return false;
		}

		return @mysqli_data_seek($this->resultId, $row);
	}

	/**
	 * Fill field array with first database element when query initially executed
	 *
	 * @return boolean
	 */
	public function _fetch()
	{
		$this->fields = @mysqli_fetch_array($this->resultId, $this->fetchMode);
		return is_array($this->fields);
	}

	/**
	 * Check if last record reached
	 *
	 * @return boolean
	 */
	public function EOF()
	{
		if ($this->_currentRow < $this->_numOfRows) {
			return false;
		} else {
			$this->EOF = true;
			return true;
		}
	}

	/**
	 * Get all records in an array
	 *
	 * @param integer $nRows Number of rows to return, -1 means every row.
	 * @return array All records
	 */
	public function &GetArray($nRows = -1)
	{
		$results = [];
		$cnt = 0;
		while (!$this->EOF && $nRows != $cnt) {
			$results[] = $this->fields;
			$this->MoveNext();
			$cnt++;
		}
		return $results;
	}

	/**
	 * Get all records in an array
	 *
	 * @param integer $nRows Number of rows to return, -1 means every row.
	 * @return array All records
	 */
	public function &GetRows($nRows = -1)
	{
		$arr = &$this->GetArray($nRows);
		return $arr;
	}

	/**
	 * Get all records in an array
	 *
	 * @param integer $nRows Number of rows to return, -1 means every row.
	 * @return array All records
	 */
	public function &GetAll($nRows = -1)
	{
		$arr = &$this->GetArray($nRows);
		return $arr;
	}

	/**
	 * Fetch field information for a table
	 *
	 * @return object containing the name, type and max_length
	 */
	public function FetchField()
	{
		return @mysqli_fetch_field($this->resultId);
	}
}

/**
 * Empty recordset for updates, inserts, etc.
 */
class MySqlRecordSetBase
{
	public $fields = false;
	public $EOF = true;

	public function MoveNext()
	{
		return;
	}

	public function RecordCount()
	{
		return 0;
	}

	public function FieldCount()
	{
		return 0;
	}

	public function EOF()
	{
		return true;
	}

	public function Close()
	{
		return true;
	}
}