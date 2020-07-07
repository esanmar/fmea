<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for actions
 */
class actions extends DbTable
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
	public $idCause;
	public $potentialCauses;
	public $currentPreventiveControlMethod;
	public $severity;
	public $occurrence;
	public $currentControlMethod;
	public $detection;
	public $RPNCalc;
	public $rpn;
	public $recomendedAction;
	public $idResponsible;
	public $targetDate;
	public $revisedKc;
	public $expectedSeverity;
	public $expectedOccurrence;
	public $expectedDetection;
	public $expectedRpn;
	public $expectedRPNPAO;
	public $expectedClosureDate;
	public $recomendedActiondet;
	public $idResponsibleDet;
	public $targetDatedet;
	public $kcdet;
	public $expectedSeveritydet;
	public $expectedOccurrencedet;
	public $expectedDetectiondet;
	public $expectedRpndet;
	public $expectedRPNPAD;
	public $revisedClosureDatedet;
	public $revisedClosureDate;
	public $perfomedAction;
	public $revisedSeverity;
	public $revisedOccurrence;
	public $revisedDetection;
	public $revisedRpn;
	public $revisedRPNCalc;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'actions';
		$this->TableName = 'actions';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`actions`";
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
		$this->idProcess = new DbField('actions', 'actions', 'x_idProcess', 'idProcess', '`idProcess`', '`idProcess`', 3, 11, -1, FALSE, '`idProcess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idProcess->IsPrimaryKey = TRUE; // Primary key field
		$this->idProcess->IsForeignKey = TRUE; // Foreign key field
		$this->idProcess->Nullable = FALSE; // NOT NULL field
		$this->idProcess->Required = TRUE; // Required field
		$this->idProcess->Sortable = TRUE; // Allow sort
		$this->idProcess->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idProcess'] = &$this->idProcess;

		// idCause
		$this->idCause = new DbField('actions', 'actions', 'x_idCause', 'idCause', '`idCause`', '`idCause`', 200, 50, -1, FALSE, '`EV__idCause`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->idCause->IsPrimaryKey = TRUE; // Primary key field
		$this->idCause->Nullable = FALSE; // NOT NULL field
		$this->idCause->Required = TRUE; // Required field
		$this->idCause->Sortable = TRUE; // Allow sort
		$this->idCause->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idCause->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idCause->Lookup = new Lookup('idCause', 'causes', TRUE, 'idCause', ["cause","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idCause->Lookup = new Lookup('idCause', 'causes', TRUE, 'idCause', ["cause","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idCause'] = &$this->idCause;

		// potentialCauses
		$this->potentialCauses = new DbField('actions', 'actions', 'x_potentialCauses', 'potentialCauses', '`potentialCauses`', '`potentialCauses`', 201, -1, -1, FALSE, '`potentialCauses`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->potentialCauses->Sortable = TRUE; // Allow sort
		$this->fields['potentialCauses'] = &$this->potentialCauses;

		// currentPreventiveControlMethod
		$this->currentPreventiveControlMethod = new DbField('actions', 'actions', 'x_currentPreventiveControlMethod', 'currentPreventiveControlMethod', '`currentPreventiveControlMethod`', '`currentPreventiveControlMethod`', 200, 255, -1, FALSE, '`currentPreventiveControlMethod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currentPreventiveControlMethod->Sortable = TRUE; // Allow sort
		$this->fields['currentPreventiveControlMethod'] = &$this->currentPreventiveControlMethod;

		// severity
		$this->severity = new DbField('actions', 'actions', 'x_severity', 'severity', '`severity`', '`severity`', 3, 11, -1, FALSE, '`severity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->severity->Sortable = FALSE; // Allow sort
		$this->severity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['severity'] = &$this->severity;

		// occurrence
		$this->occurrence = new DbField('actions', 'actions', 'x_occurrence', 'occurrence', '`occurrence`', '`occurrence`', 3, 11, -1, FALSE, '`occurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->occurrence->Sortable = TRUE; // Allow sort
		$this->occurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['occurrence'] = &$this->occurrence;

		// currentControlMethod
		$this->currentControlMethod = new DbField('actions', 'actions', 'x_currentControlMethod', 'currentControlMethod', '`currentControlMethod`', '`currentControlMethod`', 200, 255, -1, FALSE, '`currentControlMethod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currentControlMethod->Sortable = TRUE; // Allow sort
		$this->fields['currentControlMethod'] = &$this->currentControlMethod;

		// detection
		$this->detection = new DbField('actions', 'actions', 'x_detection', 'detection', '`detection`', '`detection`', 3, 11, -1, FALSE, '`detection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detection->Sortable = TRUE; // Allow sort
		$this->detection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['detection'] = &$this->detection;

		// RPNCalc
		$this->RPNCalc = new DbField('actions', 'actions', 'x_RPNCalc', 'RPNCalc', '`severity` * `occurrence` * `detection`', '`severity` * `occurrence` * `detection`', 20, 31, -1, FALSE, '`severity` * `occurrence` * `detection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RPNCalc->IsCustom = TRUE; // Custom field
		$this->RPNCalc->Sortable = TRUE; // Allow sort
		$this->RPNCalc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['RPNCalc'] = &$this->RPNCalc;

		// rpn
		$this->rpn = new DbField('actions', 'actions', 'x_rpn', 'rpn', '`rpn`', '`rpn`', 3, 11, -1, FALSE, '`rpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rpn->Sortable = FALSE; // Allow sort
		$this->rpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['rpn'] = &$this->rpn;

		// recomendedAction
		$this->recomendedAction = new DbField('actions', 'actions', 'x_recomendedAction', 'recomendedAction', '`recomendedAction`', '`recomendedAction`', 201, -1, -1, FALSE, '`recomendedAction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->recomendedAction->Sortable = TRUE; // Allow sort
		$this->fields['recomendedAction'] = &$this->recomendedAction;

		// idResponsible
		$this->idResponsible = new DbField('actions', 'actions', 'x_idResponsible', 'idResponsible', '`idResponsible`', '`idResponsible`', 200, 50, -1, FALSE, '`EV__idResponsible`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idResponsible->Sortable = TRUE; // Allow sort
		$this->idResponsible->SelectMultiple = TRUE; // Multiple select
		switch ($CurrentLanguage) {
			case "en":
				$this->idResponsible->Lookup = new Lookup('idResponsible', 'employees', TRUE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idResponsible->Lookup = new Lookup('idResponsible', 'employees', TRUE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idResponsible'] = &$this->idResponsible;

		// targetDate
		$this->targetDate = new DbField('actions', 'actions', 'x_targetDate', 'targetDate', '`targetDate`', CastDateFieldForLike("`targetDate`", 14, "DB"), 135, 19, 14, FALSE, '`targetDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->targetDate->Sortable = TRUE; // Allow sort
		$this->targetDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
		$this->fields['targetDate'] = &$this->targetDate;

		// revisedKc
		$this->revisedKc = new DbField('actions', 'actions', 'x_revisedKc', 'revisedKc', '`revisedKc`', '`revisedKc`', 202, 1, -1, FALSE, '`revisedKc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->revisedKc->Sortable = TRUE; // Allow sort
		$this->revisedKc->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->revisedKc->Lookup = new Lookup('revisedKc', 'actions', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->revisedKc->Lookup = new Lookup('revisedKc', 'actions', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->revisedKc->OptionCount = 2;
		$this->fields['revisedKc'] = &$this->revisedKc;

		// expectedSeverity
		$this->expectedSeverity = new DbField('actions', 'actions', 'x_expectedSeverity', 'expectedSeverity', '`expectedSeverity`', '`expectedSeverity`', 3, 11, -1, FALSE, '`expectedSeverity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedSeverity->Sortable = TRUE; // Allow sort
		$this->expectedSeverity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedSeverity'] = &$this->expectedSeverity;

		// expectedOccurrence
		$this->expectedOccurrence = new DbField('actions', 'actions', 'x_expectedOccurrence', 'expectedOccurrence', '`expectedOccurrence`', '`expectedOccurrence`', 3, 11, -1, FALSE, '`expectedOccurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedOccurrence->Sortable = TRUE; // Allow sort
		$this->expectedOccurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedOccurrence'] = &$this->expectedOccurrence;

		// expectedDetection
		$this->expectedDetection = new DbField('actions', 'actions', 'x_expectedDetection', 'expectedDetection', '`expectedDetection`', '`expectedDetection`', 3, 11, -1, FALSE, '`expectedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedDetection->Sortable = TRUE; // Allow sort
		$this->expectedDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedDetection'] = &$this->expectedDetection;

		// expectedRpn
		$this->expectedRpn = new DbField('actions', 'actions', 'x_expectedRpn', 'expectedRpn', '`expectedRpn`', '`expectedRpn`', 3, 11, -1, FALSE, '`expectedRpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRpn->Sortable = FALSE; // Allow sort
		$this->expectedRpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedRpn'] = &$this->expectedRpn;

		// expectedRPNPAO
		$this->expectedRPNPAO = new DbField('actions', 'actions', 'x_expectedRPNPAO', 'expectedRPNPAO', '`expectedSeverity` * `expectedOccurrence` *  `expectedDetection`', '`expectedSeverity` * `expectedOccurrence` *  `expectedDetection`', 20, 31, -1, FALSE, '`expectedSeverity` * `expectedOccurrence` *  `expectedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRPNPAO->IsCustom = TRUE; // Custom field
		$this->expectedRPNPAO->Sortable = TRUE; // Allow sort
		$this->expectedRPNPAO->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedRPNPAO'] = &$this->expectedRPNPAO;

		// expectedClosureDate
		$this->expectedClosureDate = new DbField('actions', 'actions', 'x_expectedClosureDate', 'expectedClosureDate', '`expectedClosureDate`', CastDateFieldForLike("`expectedClosureDate`", 12, "DB"), 135, 19, 12, FALSE, '`expectedClosureDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedClosureDate->Sortable = TRUE; // Allow sort
		$this->expectedClosureDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateYMD"));
		$this->fields['expectedClosureDate'] = &$this->expectedClosureDate;

		// recomendedActiondet
		$this->recomendedActiondet = new DbField('actions', 'actions', 'x_recomendedActiondet', 'recomendedActiondet', '`recomendedActiondet`', '`recomendedActiondet`', 201, -1, -1, FALSE, '`recomendedActiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->recomendedActiondet->Sortable = TRUE; // Allow sort
		$this->fields['recomendedActiondet'] = &$this->recomendedActiondet;

		// idResponsibleDet
		$this->idResponsibleDet = new DbField('actions', 'actions', 'x_idResponsibleDet', 'idResponsibleDet', '`idResponsibleDet`', '`idResponsibleDet`', 200, 50, -1, FALSE, '`EV__idResponsibleDet`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idResponsibleDet->Sortable = TRUE; // Allow sort
		$this->idResponsibleDet->SelectMultiple = TRUE; // Multiple select
		switch ($CurrentLanguage) {
			case "en":
				$this->idResponsibleDet->Lookup = new Lookup('idResponsibleDet', 'employees', TRUE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idResponsibleDet->Lookup = new Lookup('idResponsibleDet', 'employees', TRUE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idResponsibleDet'] = &$this->idResponsibleDet;

		// targetDatedet
		$this->targetDatedet = new DbField('actions', 'actions', 'x_targetDatedet', 'targetDatedet', '`targetDatedet`', CastDateFieldForLike("`targetDatedet`", 14, "DB"), 135, 19, 14, FALSE, '`targetDatedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->targetDatedet->Sortable = TRUE; // Allow sort
		$this->targetDatedet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
		$this->fields['targetDatedet'] = &$this->targetDatedet;

		// kcdet
		$this->kcdet = new DbField('actions', 'actions', 'x_kcdet', 'kcdet', '`kcdet`', '`kcdet`', 202, 1, -1, FALSE, '`kcdet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->kcdet->Sortable = TRUE; // Allow sort
		$this->kcdet->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->kcdet->Lookup = new Lookup('kcdet', 'actions', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->kcdet->Lookup = new Lookup('kcdet', 'actions', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->kcdet->OptionCount = 2;
		$this->fields['kcdet'] = &$this->kcdet;

		// expectedSeveritydet
		$this->expectedSeveritydet = new DbField('actions', 'actions', 'x_expectedSeveritydet', 'expectedSeveritydet', '`expectedSeveritydet`', '`expectedSeveritydet`', 3, 11, -1, FALSE, '`expectedSeveritydet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedSeveritydet->Sortable = TRUE; // Allow sort
		$this->expectedSeveritydet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedSeveritydet'] = &$this->expectedSeveritydet;

		// expectedOccurrencedet
		$this->expectedOccurrencedet = new DbField('actions', 'actions', 'x_expectedOccurrencedet', 'expectedOccurrencedet', '`expectedOccurrencedet`', '`expectedOccurrencedet`', 3, 11, -1, FALSE, '`expectedOccurrencedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedOccurrencedet->Sortable = TRUE; // Allow sort
		$this->expectedOccurrencedet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedOccurrencedet'] = &$this->expectedOccurrencedet;

		// expectedDetectiondet
		$this->expectedDetectiondet = new DbField('actions', 'actions', 'x_expectedDetectiondet', 'expectedDetectiondet', '`expectedDetectiondet`', '`expectedDetectiondet`', 3, 11, -1, FALSE, '`expectedDetectiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedDetectiondet->Sortable = TRUE; // Allow sort
		$this->expectedDetectiondet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedDetectiondet'] = &$this->expectedDetectiondet;

		// expectedRpndet
		$this->expectedRpndet = new DbField('actions', 'actions', 'x_expectedRpndet', 'expectedRpndet', '`expectedRpndet`', '`expectedRpndet`', 3, 11, -1, FALSE, '`expectedRpndet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRpndet->Sortable = FALSE; // Allow sort
		$this->expectedRpndet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedRpndet'] = &$this->expectedRpndet;

		// expectedRPNPAD
		$this->expectedRPNPAD = new DbField('actions', 'actions', 'x_expectedRPNPAD', 'expectedRPNPAD', '`expectedSeveritydet` * `expectedOccurrencedet` *  `expectedDetectiondet`', '`expectedSeveritydet` * `expectedOccurrencedet` *  `expectedDetectiondet`', 20, 31, -1, FALSE, '`expectedSeveritydet` * `expectedOccurrencedet` *  `expectedDetectiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRPNPAD->IsCustom = TRUE; // Custom field
		$this->expectedRPNPAD->Sortable = TRUE; // Allow sort
		$this->expectedRPNPAD->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedRPNPAD'] = &$this->expectedRPNPAD;

		// revisedClosureDatedet
		$this->revisedClosureDatedet = new DbField('actions', 'actions', 'x_revisedClosureDatedet', 'revisedClosureDatedet', '`revisedClosureDatedet`', CastDateFieldForLike("`revisedClosureDatedet`", 14, "DB"), 135, 19, 14, FALSE, '`revisedClosureDatedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedClosureDatedet->Sortable = TRUE; // Allow sort
		$this->revisedClosureDatedet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
		$this->fields['revisedClosureDatedet'] = &$this->revisedClosureDatedet;

		// revisedClosureDate
		$this->revisedClosureDate = new DbField('actions', 'actions', 'x_revisedClosureDate', 'revisedClosureDate', '`revisedClosureDate`', CastDateFieldForLike("`revisedClosureDate`", 14, "DB"), 135, 19, 14, FALSE, '`revisedClosureDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedClosureDate->Sortable = FALSE; // Allow sort
		$this->revisedClosureDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
		$this->fields['revisedClosureDate'] = &$this->revisedClosureDate;

		// perfomedAction
		$this->perfomedAction = new DbField('actions', 'actions', 'x_perfomedAction', 'perfomedAction', '`perfomedAction`', '`perfomedAction`', 201, -1, -1, FALSE, '`perfomedAction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->perfomedAction->Sortable = FALSE; // Allow sort
		$this->fields['perfomedAction'] = &$this->perfomedAction;

		// revisedSeverity
		$this->revisedSeverity = new DbField('actions', 'actions', 'x_revisedSeverity', 'revisedSeverity', '`revisedSeverity`', '`revisedSeverity`', 3, 11, -1, FALSE, '`revisedSeverity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedSeverity->Sortable = TRUE; // Allow sort
		$this->revisedSeverity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedSeverity'] = &$this->revisedSeverity;

		// revisedOccurrence
		$this->revisedOccurrence = new DbField('actions', 'actions', 'x_revisedOccurrence', 'revisedOccurrence', '`revisedOccurrence`', '`revisedOccurrence`', 3, 11, -1, FALSE, '`revisedOccurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedOccurrence->Sortable = TRUE; // Allow sort
		$this->revisedOccurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedOccurrence'] = &$this->revisedOccurrence;

		// revisedDetection
		$this->revisedDetection = new DbField('actions', 'actions', 'x_revisedDetection', 'revisedDetection', '`revisedDetection`', '`revisedDetection`', 3, 11, -1, FALSE, '`revisedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedDetection->Sortable = TRUE; // Allow sort
		$this->revisedDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedDetection'] = &$this->revisedDetection;

		// revisedRpn
		$this->revisedRpn = new DbField('actions', 'actions', 'x_revisedRpn', 'revisedRpn', '`revisedRpn`', '`revisedRpn`', 3, 11, -1, FALSE, '`revisedRpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedRpn->Sortable = FALSE; // Allow sort
		$this->revisedRpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedRpn'] = &$this->revisedRpn;

		// revisedRPNCalc
		$this->revisedRPNCalc = new DbField('actions', 'actions', 'x_revisedRPNCalc', 'revisedRPNCalc', '`revisedSeverity` * `revisedOccurrence` *  `revisedDetection`', '`revisedSeverity` * `revisedOccurrence` *  `revisedDetection`', 20, 31, -1, FALSE, '`revisedSeverity` * `revisedOccurrence` *  `revisedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedRPNCalc->IsCustom = TRUE; // Custom field
		$this->revisedRPNCalc->Sortable = TRUE; // Allow sort
		$this->revisedRPNCalc->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedRPNCalc'] = &$this->revisedRPNCalc;
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
		if ($this->getCurrentMasterTable() == "processf") {
			if ($this->idProcess->getSessionValue() != "")
				$masterFilter .= "`idProcess`=" . QuotedValue($this->idProcess->getSessionValue(), DATATYPE_NUMBER, "DB");
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
		if ($this->getCurrentMasterTable() == "processf") {
			if ($this->idProcess->getSessionValue() != "")
				$detailFilter .= "`idProcess`=" . QuotedValue($this->idProcess->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_processf()
	{
		return "`idProcess`=@idProcess@";
	}

	// Detail filter
	public function sqlDetailFilter_processf()
	{
		return "`idProcess`=@idProcess@";
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`actions`";
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
		return ($this->SqlSelect != "") ? $this->SqlSelect : "SELECT *, `severity` * `occurrence` * `detection` AS `RPNCalc`, `expectedSeverity` * `expectedOccurrence` *  `expectedDetection` AS `expectedRPNPAO`, `expectedSeveritydet` * `expectedOccurrencedet` *  `expectedDetectiondet` AS `expectedRPNPAD`, `revisedSeverity` * `revisedOccurrence` *  `revisedDetection` AS `revisedRPNCalc` FROM " . $this->getSqlFrom();
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
			"SELECT *, `severity` * `occurrence` * `detection` AS `RPNCalc`, `expectedSeverity` * `expectedOccurrence` *  `expectedDetection` AS `expectedRPNPAO`, `expectedSeveritydet` * `expectedOccurrencedet` *  `expectedDetectiondet` AS `expectedRPNPAD`, `revisedSeverity` * `revisedOccurrence` *  `revisedDetection` AS `revisedRPNCalc`, (SELECT DISTINCT `cause` FROM `causes` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`idCause` = `actions`.`idCause` LIMIT 1) AS `EV__idCause`, (SELECT DISTINCT CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->idResponsible) . "',COALESCE(`surname`,'')) FROM `employees` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`idEmployee` = `actions`.`idResponsible` LIMIT 1) AS `EV__idResponsible`, (SELECT DISTINCT CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->idResponsibleDet) . "',COALESCE(`surname`,'')) FROM `employees` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`idEmployee` = `actions`.`idResponsibleDet` LIMIT 1) AS `EV__idResponsibleDet` FROM `actions`" .
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
		if ($this->idCause->AdvancedSearch->SearchValue != "" ||
			$this->idCause->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->idCause->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->idCause->VirtualExpression . " "))
			return TRUE;
		if ($this->idResponsible->AdvancedSearch->SearchValue != "" ||
			$this->idResponsible->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->idResponsible->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->idResponsible->VirtualExpression . " "))
			return TRUE;
		if ($this->idResponsibleDet->AdvancedSearch->SearchValue != "" ||
			$this->idResponsibleDet->AdvancedSearch->SearchValue2 != "" ||
			ContainsString($where, " " . $this->idResponsibleDet->VirtualExpression . " "))
			return TRUE;
		if (ContainsString($orderBy, " " . $this->idResponsibleDet->VirtualExpression . " "))
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
			if (array_key_exists('idCause', $rs))
				AddFilter($where, QuotedName('idCause', $this->Dbid) . '=' . QuotedValue($rs['idCause'], $this->idCause->DataType, $this->Dbid));
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
		$this->idProcess->DbValue = $row['idProcess'];
		$this->idCause->DbValue = $row['idCause'];
		$this->potentialCauses->DbValue = $row['potentialCauses'];
		$this->currentPreventiveControlMethod->DbValue = $row['currentPreventiveControlMethod'];
		$this->severity->DbValue = $row['severity'];
		$this->occurrence->DbValue = $row['occurrence'];
		$this->currentControlMethod->DbValue = $row['currentControlMethod'];
		$this->detection->DbValue = $row['detection'];
		$this->RPNCalc->DbValue = $row['RPNCalc'];
		$this->rpn->DbValue = $row['rpn'];
		$this->recomendedAction->DbValue = $row['recomendedAction'];
		$this->idResponsible->DbValue = $row['idResponsible'];
		$this->targetDate->DbValue = $row['targetDate'];
		$this->revisedKc->DbValue = $row['revisedKc'];
		$this->expectedSeverity->DbValue = $row['expectedSeverity'];
		$this->expectedOccurrence->DbValue = $row['expectedOccurrence'];
		$this->expectedDetection->DbValue = $row['expectedDetection'];
		$this->expectedRpn->DbValue = $row['expectedRpn'];
		$this->expectedRPNPAO->DbValue = $row['expectedRPNPAO'];
		$this->expectedClosureDate->DbValue = $row['expectedClosureDate'];
		$this->recomendedActiondet->DbValue = $row['recomendedActiondet'];
		$this->idResponsibleDet->DbValue = $row['idResponsibleDet'];
		$this->targetDatedet->DbValue = $row['targetDatedet'];
		$this->kcdet->DbValue = $row['kcdet'];
		$this->expectedSeveritydet->DbValue = $row['expectedSeveritydet'];
		$this->expectedOccurrencedet->DbValue = $row['expectedOccurrencedet'];
		$this->expectedDetectiondet->DbValue = $row['expectedDetectiondet'];
		$this->expectedRpndet->DbValue = $row['expectedRpndet'];
		$this->expectedRPNPAD->DbValue = $row['expectedRPNPAD'];
		$this->revisedClosureDatedet->DbValue = $row['revisedClosureDatedet'];
		$this->revisedClosureDate->DbValue = $row['revisedClosureDate'];
		$this->perfomedAction->DbValue = $row['perfomedAction'];
		$this->revisedSeverity->DbValue = $row['revisedSeverity'];
		$this->revisedOccurrence->DbValue = $row['revisedOccurrence'];
		$this->revisedDetection->DbValue = $row['revisedDetection'];
		$this->revisedRpn->DbValue = $row['revisedRpn'];
		$this->revisedRPNCalc->DbValue = $row['revisedRPNCalc'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idProcess` = @idProcess@ AND `idCause` = '@idCause@'";
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
		if (is_array($row))
			$val = array_key_exists('idCause', $row) ? $row['idCause'] : NULL;
		else
			$val = $this->idCause->OldValue !== NULL ? $this->idCause->OldValue : $this->idCause->CurrentValue;
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idCause@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
			return "actionslist.php";
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
		if ($pageName == "actionsview.php")
			return $Language->phrase("View");
		elseif ($pageName == "actionsedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "actionsadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "actionslist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("actionsview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("actionsview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "actionsadd.php?" . $this->getUrlParm($parm);
		else
			$url = "actionsadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("actionsedit.php", $this->getUrlParm($parm));
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
		$url = $this->keyUrl("actionsadd.php", $this->getUrlParm($parm));
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
		return $this->keyUrl("actionsdelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "processf" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idProcess=" . urlencode($this->idProcess->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idProcess:" . JsonEncode($this->idProcess->CurrentValue, "number");
		$json .= ",idCause:" . JsonEncode($this->idCause->CurrentValue, "string");
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
		if ($this->idCause->CurrentValue != NULL) {
			$url .= "&idCause=" . urlencode($this->idCause->CurrentValue);
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
		} else {
			if (Param("idProcess") !== NULL)
				$arKey[] = Param("idProcess");
			elseif (IsApi() && Key(0) !== NULL)
				$arKey[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKey[] = Route(2);
			else
				$arKeys = NULL; // Do not setup
			if (Param("idCause") !== NULL)
				$arKey[] = Param("idCause");
			elseif (IsApi() && Key(1) !== NULL)
				$arKey[] = Key(1);
			elseif (IsApi() && Route(3) !== NULL)
				$arKey[] = Route(3);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = [];
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) != 2)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // idProcess
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
				$this->idProcess->CurrentValue = $key[0];
			else
				$this->idProcess->OldValue = $key[0];
			if ($setCurrent)
				$this->idCause->CurrentValue = $key[1];
			else
				$this->idCause->OldValue = $key[1];
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
		$this->idCause->setDbValue($rs->fields('idCause'));
		$this->potentialCauses->setDbValue($rs->fields('potentialCauses'));
		$this->currentPreventiveControlMethod->setDbValue($rs->fields('currentPreventiveControlMethod'));
		$this->severity->setDbValue($rs->fields('severity'));
		$this->occurrence->setDbValue($rs->fields('occurrence'));
		$this->currentControlMethod->setDbValue($rs->fields('currentControlMethod'));
		$this->detection->setDbValue($rs->fields('detection'));
		$this->RPNCalc->setDbValue($rs->fields('RPNCalc'));
		$this->rpn->setDbValue($rs->fields('rpn'));
		$this->recomendedAction->setDbValue($rs->fields('recomendedAction'));
		$this->idResponsible->setDbValue($rs->fields('idResponsible'));
		$this->targetDate->setDbValue($rs->fields('targetDate'));
		$this->revisedKc->setDbValue($rs->fields('revisedKc'));
		$this->expectedSeverity->setDbValue($rs->fields('expectedSeverity'));
		$this->expectedOccurrence->setDbValue($rs->fields('expectedOccurrence'));
		$this->expectedDetection->setDbValue($rs->fields('expectedDetection'));
		$this->expectedRpn->setDbValue($rs->fields('expectedRpn'));
		$this->expectedRPNPAO->setDbValue($rs->fields('expectedRPNPAO'));
		$this->expectedClosureDate->setDbValue($rs->fields('expectedClosureDate'));
		$this->recomendedActiondet->setDbValue($rs->fields('recomendedActiondet'));
		$this->idResponsibleDet->setDbValue($rs->fields('idResponsibleDet'));
		$this->targetDatedet->setDbValue($rs->fields('targetDatedet'));
		$this->kcdet->setDbValue($rs->fields('kcdet'));
		$this->expectedSeveritydet->setDbValue($rs->fields('expectedSeveritydet'));
		$this->expectedOccurrencedet->setDbValue($rs->fields('expectedOccurrencedet'));
		$this->expectedDetectiondet->setDbValue($rs->fields('expectedDetectiondet'));
		$this->expectedRpndet->setDbValue($rs->fields('expectedRpndet'));
		$this->expectedRPNPAD->setDbValue($rs->fields('expectedRPNPAD'));
		$this->revisedClosureDatedet->setDbValue($rs->fields('revisedClosureDatedet'));
		$this->revisedClosureDate->setDbValue($rs->fields('revisedClosureDate'));
		$this->perfomedAction->setDbValue($rs->fields('perfomedAction'));
		$this->revisedSeverity->setDbValue($rs->fields('revisedSeverity'));
		$this->revisedOccurrence->setDbValue($rs->fields('revisedOccurrence'));
		$this->revisedDetection->setDbValue($rs->fields('revisedDetection'));
		$this->revisedRpn->setDbValue($rs->fields('revisedRpn'));
		$this->revisedRPNCalc->setDbValue($rs->fields('revisedRPNCalc'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
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

		// rpn
		$this->rpn->ViewValue = $this->rpn->CurrentValue;
		$this->rpn->ViewValue = FormatNumber($this->rpn->ViewValue, 0, -2, -2, -2);
		$this->rpn->ViewCustomAttributes = "";

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

		// expectedRpndet
		$this->expectedRpndet->ViewValue = $this->expectedRpndet->CurrentValue;
		$this->expectedRpndet->ViewValue = FormatNumber($this->expectedRpndet->ViewValue, 0, -2, -2, -2);
		$this->expectedRpndet->ViewCustomAttributes = "";

		// expectedRPNPAD
		$this->expectedRPNPAD->ViewValue = $this->expectedRPNPAD->CurrentValue;
		$this->expectedRPNPAD->ViewValue = FormatNumber($this->expectedRPNPAD->ViewValue, 0, -2, -2, -2);
		$this->expectedRPNPAD->ViewCustomAttributes = "";

		// revisedClosureDatedet
		$this->revisedClosureDatedet->ViewValue = $this->revisedClosureDatedet->CurrentValue;
		$this->revisedClosureDatedet->ViewValue = FormatDateTime($this->revisedClosureDatedet->ViewValue, 14);
		$this->revisedClosureDatedet->ViewCustomAttributes = "";

		// revisedClosureDate
		$this->revisedClosureDate->ViewValue = $this->revisedClosureDate->CurrentValue;
		$this->revisedClosureDate->ViewValue = FormatDateTime($this->revisedClosureDate->ViewValue, 14);
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

		// expectedRpndet
		$this->expectedRpndet->LinkCustomAttributes = "";
		$this->expectedRpndet->HrefValue = "";
		$this->expectedRpndet->TooltipValue = "";

		// expectedRPNPAD
		$this->expectedRPNPAD->LinkCustomAttributes = "";
		$this->expectedRPNPAD->HrefValue = "";
		$this->expectedRPNPAD->TooltipValue = "";

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

		// revisedRPNCalc
		$this->revisedRPNCalc->LinkCustomAttributes = "";
		$this->revisedRPNCalc->HrefValue = "";
		$this->revisedRPNCalc->TooltipValue = "";

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
		$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());

		// idCause
		$this->idCause->EditAttrs["class"] = "form-control";
		$this->idCause->EditCustomAttributes = "";

		// potentialCauses
		$this->potentialCauses->EditAttrs["class"] = "form-control";
		$this->potentialCauses->EditCustomAttributes = "";
		$this->potentialCauses->EditValue = $this->potentialCauses->CurrentValue;
		$this->potentialCauses->PlaceHolder = RemoveHtml($this->potentialCauses->caption());

		// currentPreventiveControlMethod
		$this->currentPreventiveControlMethod->EditAttrs["class"] = "form-control";
		$this->currentPreventiveControlMethod->EditCustomAttributes = "";
		if (!$this->currentPreventiveControlMethod->Raw)
			$this->currentPreventiveControlMethod->CurrentValue = HtmlDecode($this->currentPreventiveControlMethod->CurrentValue);
		$this->currentPreventiveControlMethod->EditValue = $this->currentPreventiveControlMethod->CurrentValue;
		$this->currentPreventiveControlMethod->PlaceHolder = RemoveHtml($this->currentPreventiveControlMethod->caption());

		// severity
		$this->severity->EditAttrs["class"] = "form-control";
		$this->severity->EditCustomAttributes = "";

		// occurrence
		$this->occurrence->EditAttrs["class"] = "form-control";
		$this->occurrence->EditCustomAttributes = "";
		$this->occurrence->EditValue = $this->occurrence->CurrentValue;
		$this->occurrence->PlaceHolder = RemoveHtml($this->occurrence->caption());

		// currentControlMethod
		$this->currentControlMethod->EditAttrs["class"] = "form-control";
		$this->currentControlMethod->EditCustomAttributes = "";
		if (!$this->currentControlMethod->Raw)
			$this->currentControlMethod->CurrentValue = HtmlDecode($this->currentControlMethod->CurrentValue);
		$this->currentControlMethod->EditValue = $this->currentControlMethod->CurrentValue;
		$this->currentControlMethod->PlaceHolder = RemoveHtml($this->currentControlMethod->caption());

		// detection
		$this->detection->EditAttrs["class"] = "form-control";
		$this->detection->EditCustomAttributes = "";
		$this->detection->EditValue = $this->detection->CurrentValue;
		$this->detection->PlaceHolder = RemoveHtml($this->detection->caption());

		// RPNCalc
		$this->RPNCalc->EditAttrs["class"] = "form-control";
		$this->RPNCalc->EditCustomAttributes = "";
		$this->RPNCalc->EditValue = $this->RPNCalc->CurrentValue;
		$this->RPNCalc->EditValue = FormatNumber($this->RPNCalc->EditValue, 0, -2, -2, -2);
		$this->RPNCalc->ViewCustomAttributes = "";

		// rpn
		$this->rpn->EditAttrs["class"] = "form-control";
		$this->rpn->EditCustomAttributes = "";
		$this->rpn->EditValue = $this->rpn->CurrentValue;
		$this->rpn->PlaceHolder = RemoveHtml($this->rpn->caption());

		// recomendedAction
		$this->recomendedAction->EditAttrs["class"] = "form-control";
		$this->recomendedAction->EditCustomAttributes = "background-color: #56d226";
		$this->recomendedAction->EditValue = $this->recomendedAction->CurrentValue;
		$this->recomendedAction->PlaceHolder = RemoveHtml($this->recomendedAction->caption());

		// idResponsible
		$this->idResponsible->EditAttrs["class"] = "form-control";
		$this->idResponsible->EditCustomAttributes = "";

		// targetDate
		$this->targetDate->EditAttrs["class"] = "form-control";
		$this->targetDate->EditCustomAttributes = "";
		$this->targetDate->EditValue = FormatDateTime($this->targetDate->CurrentValue, 14);
		$this->targetDate->PlaceHolder = RemoveHtml($this->targetDate->caption());

		// revisedKc
		$this->revisedKc->EditCustomAttributes = "";
		$this->revisedKc->EditValue = $this->revisedKc->options(FALSE);

		// expectedSeverity
		$this->expectedSeverity->EditAttrs["class"] = "form-control";
		$this->expectedSeverity->EditCustomAttributes = "";
		$this->expectedSeverity->EditValue = $this->expectedSeverity->CurrentValue;
		$this->expectedSeverity->PlaceHolder = RemoveHtml($this->expectedSeverity->caption());

		// expectedOccurrence
		$this->expectedOccurrence->EditAttrs["class"] = "form-control";
		$this->expectedOccurrence->EditCustomAttributes = "";
		$this->expectedOccurrence->EditValue = $this->expectedOccurrence->CurrentValue;
		$this->expectedOccurrence->PlaceHolder = RemoveHtml($this->expectedOccurrence->caption());

		// expectedDetection
		$this->expectedDetection->EditAttrs["class"] = "form-control";
		$this->expectedDetection->EditCustomAttributes = "";
		$this->expectedDetection->EditValue = $this->expectedDetection->CurrentValue;
		$this->expectedDetection->PlaceHolder = RemoveHtml($this->expectedDetection->caption());

		// expectedRpn
		$this->expectedRpn->EditAttrs["class"] = "form-control";
		$this->expectedRpn->EditCustomAttributes = "";
		$this->expectedRpn->EditValue = $this->expectedRpn->CurrentValue;
		$this->expectedRpn->PlaceHolder = RemoveHtml($this->expectedRpn->caption());

		// expectedRPNPAO
		$this->expectedRPNPAO->EditAttrs["class"] = "form-control";
		$this->expectedRPNPAO->EditCustomAttributes = "";
		$this->expectedRPNPAO->EditValue = $this->expectedRPNPAO->CurrentValue;
		$this->expectedRPNPAO->EditValue = FormatNumber($this->expectedRPNPAO->EditValue, 0, -2, -2, -2);
		$this->expectedRPNPAO->ViewCustomAttributes = "";

		// expectedClosureDate
		$this->expectedClosureDate->EditAttrs["class"] = "form-control";
		$this->expectedClosureDate->EditCustomAttributes = "";
		$this->expectedClosureDate->EditValue = $this->expectedClosureDate->CurrentValue;
		$this->expectedClosureDate->EditValue = FormatDateTime($this->expectedClosureDate->EditValue, 12);
		$this->expectedClosureDate->ViewCustomAttributes = "";

		// recomendedActiondet
		$this->recomendedActiondet->EditAttrs["class"] = "form-control";
		$this->recomendedActiondet->EditCustomAttributes = "";
		if (!$this->recomendedActiondet->Raw)
			$this->recomendedActiondet->CurrentValue = HtmlDecode($this->recomendedActiondet->CurrentValue);
		$this->recomendedActiondet->EditValue = $this->recomendedActiondet->CurrentValue;
		$this->recomendedActiondet->PlaceHolder = RemoveHtml($this->recomendedActiondet->caption());

		// idResponsibleDet
		$this->idResponsibleDet->EditAttrs["class"] = "form-control";
		$this->idResponsibleDet->EditCustomAttributes = "";

		// targetDatedet
		$this->targetDatedet->EditAttrs["class"] = "form-control";
		$this->targetDatedet->EditCustomAttributes = "";
		$this->targetDatedet->EditValue = FormatDateTime($this->targetDatedet->CurrentValue, 14);
		$this->targetDatedet->PlaceHolder = RemoveHtml($this->targetDatedet->caption());

		// kcdet
		$this->kcdet->EditCustomAttributes = "";
		$this->kcdet->EditValue = $this->kcdet->options(FALSE);

		// expectedSeveritydet
		$this->expectedSeveritydet->EditAttrs["class"] = "form-control";
		$this->expectedSeveritydet->EditCustomAttributes = "";
		$this->expectedSeveritydet->EditValue = $this->expectedSeveritydet->CurrentValue;
		$this->expectedSeveritydet->PlaceHolder = RemoveHtml($this->expectedSeveritydet->caption());

		// expectedOccurrencedet
		$this->expectedOccurrencedet->EditAttrs["class"] = "form-control";
		$this->expectedOccurrencedet->EditCustomAttributes = "";
		$this->expectedOccurrencedet->EditValue = $this->expectedOccurrencedet->CurrentValue;
		$this->expectedOccurrencedet->PlaceHolder = RemoveHtml($this->expectedOccurrencedet->caption());

		// expectedDetectiondet
		$this->expectedDetectiondet->EditAttrs["class"] = "form-control";
		$this->expectedDetectiondet->EditCustomAttributes = "";
		$this->expectedDetectiondet->EditValue = $this->expectedDetectiondet->CurrentValue;
		$this->expectedDetectiondet->PlaceHolder = RemoveHtml($this->expectedDetectiondet->caption());

		// expectedRpndet
		$this->expectedRpndet->EditAttrs["class"] = "form-control";
		$this->expectedRpndet->EditCustomAttributes = "";
		$this->expectedRpndet->EditValue = $this->expectedRpndet->CurrentValue;
		$this->expectedRpndet->PlaceHolder = RemoveHtml($this->expectedRpndet->caption());

		// expectedRPNPAD
		$this->expectedRPNPAD->EditAttrs["class"] = "form-control";
		$this->expectedRPNPAD->EditCustomAttributes = "";
		$this->expectedRPNPAD->EditValue = $this->expectedRPNPAD->CurrentValue;
		$this->expectedRPNPAD->EditValue = FormatNumber($this->expectedRPNPAD->EditValue, 0, -2, -2, -2);
		$this->expectedRPNPAD->ViewCustomAttributes = "";

		// revisedClosureDatedet
		$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
		$this->revisedClosureDatedet->EditCustomAttributes = "";
		$this->revisedClosureDatedet->EditValue = FormatDateTime($this->revisedClosureDatedet->CurrentValue, 14);
		$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());

		// revisedClosureDate
		$this->revisedClosureDate->EditAttrs["class"] = "form-control";
		$this->revisedClosureDate->EditCustomAttributes = "";
		$this->revisedClosureDate->EditValue = FormatDateTime($this->revisedClosureDate->CurrentValue, 14);
		$this->revisedClosureDate->PlaceHolder = RemoveHtml($this->revisedClosureDate->caption());

		// perfomedAction
		$this->perfomedAction->EditAttrs["class"] = "form-control";
		$this->perfomedAction->EditCustomAttributes = "";
		$this->perfomedAction->EditValue = $this->perfomedAction->CurrentValue;
		$this->perfomedAction->PlaceHolder = RemoveHtml($this->perfomedAction->caption());

		// revisedSeverity
		$this->revisedSeverity->EditAttrs["class"] = "form-control";
		$this->revisedSeverity->EditCustomAttributes = "";
		$this->revisedSeverity->EditValue = $this->revisedSeverity->CurrentValue;
		$this->revisedSeverity->PlaceHolder = RemoveHtml($this->revisedSeverity->caption());

		// revisedOccurrence
		$this->revisedOccurrence->EditAttrs["class"] = "form-control";
		$this->revisedOccurrence->EditCustomAttributes = "";
		$this->revisedOccurrence->EditValue = $this->revisedOccurrence->CurrentValue;
		$this->revisedOccurrence->PlaceHolder = RemoveHtml($this->revisedOccurrence->caption());

		// revisedDetection
		$this->revisedDetection->EditAttrs["class"] = "form-control";
		$this->revisedDetection->EditCustomAttributes = "";
		$this->revisedDetection->EditValue = $this->revisedDetection->CurrentValue;
		$this->revisedDetection->PlaceHolder = RemoveHtml($this->revisedDetection->caption());

		// revisedRpn
		$this->revisedRpn->EditAttrs["class"] = "form-control";
		$this->revisedRpn->EditCustomAttributes = "";
		$this->revisedRpn->EditValue = $this->revisedRpn->CurrentValue;
		$this->revisedRpn->PlaceHolder = RemoveHtml($this->revisedRpn->caption());

		// revisedRPNCalc
		$this->revisedRPNCalc->EditAttrs["class"] = "form-control";
		$this->revisedRPNCalc->EditCustomAttributes = "";
		$this->revisedRPNCalc->EditValue = $this->revisedRPNCalc->CurrentValue;
		$this->revisedRPNCalc->EditValue = FormatNumber($this->revisedRPNCalc->EditValue, 0, -2, -2, -2);
		$this->revisedRPNCalc->ViewCustomAttributes = "";

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
					$doc->exportCaption($this->idProcess);
					$doc->exportCaption($this->idCause);
					$doc->exportCaption($this->potentialCauses);
					$doc->exportCaption($this->currentPreventiveControlMethod);
					$doc->exportCaption($this->severity);
					$doc->exportCaption($this->occurrence);
					$doc->exportCaption($this->currentControlMethod);
					$doc->exportCaption($this->detection);
					$doc->exportCaption($this->RPNCalc);
					$doc->exportCaption($this->recomendedAction);
					$doc->exportCaption($this->idResponsible);
					$doc->exportCaption($this->targetDate);
					$doc->exportCaption($this->revisedKc);
					$doc->exportCaption($this->expectedSeverity);
					$doc->exportCaption($this->expectedOccurrence);
					$doc->exportCaption($this->expectedDetection);
					$doc->exportCaption($this->expectedRpn);
					$doc->exportCaption($this->expectedRPNPAO);
					$doc->exportCaption($this->expectedClosureDate);
					$doc->exportCaption($this->recomendedActiondet);
					$doc->exportCaption($this->idResponsibleDet);
					$doc->exportCaption($this->targetDatedet);
					$doc->exportCaption($this->kcdet);
					$doc->exportCaption($this->expectedSeveritydet);
					$doc->exportCaption($this->expectedOccurrencedet);
					$doc->exportCaption($this->expectedDetectiondet);
					$doc->exportCaption($this->expectedRPNPAD);
					$doc->exportCaption($this->revisedClosureDatedet);
					$doc->exportCaption($this->perfomedAction);
					$doc->exportCaption($this->revisedSeverity);
					$doc->exportCaption($this->revisedOccurrence);
					$doc->exportCaption($this->revisedDetection);
					$doc->exportCaption($this->revisedRpn);
					$doc->exportCaption($this->revisedRPNCalc);
				} else {
					$doc->exportCaption($this->idProcess);
					$doc->exportCaption($this->idCause);
					$doc->exportCaption($this->potentialCauses);
					$doc->exportCaption($this->currentPreventiveControlMethod);
					$doc->exportCaption($this->severity);
					$doc->exportCaption($this->occurrence);
					$doc->exportCaption($this->currentControlMethod);
					$doc->exportCaption($this->detection);
					$doc->exportCaption($this->RPNCalc);
					$doc->exportCaption($this->recomendedAction);
					$doc->exportCaption($this->idResponsible);
					$doc->exportCaption($this->targetDate);
					$doc->exportCaption($this->revisedKc);
					$doc->exportCaption($this->expectedSeverity);
					$doc->exportCaption($this->expectedOccurrence);
					$doc->exportCaption($this->expectedDetection);
					$doc->exportCaption($this->expectedRPNPAO);
					$doc->exportCaption($this->expectedClosureDate);
					$doc->exportCaption($this->recomendedActiondet);
					$doc->exportCaption($this->idResponsibleDet);
					$doc->exportCaption($this->targetDatedet);
					$doc->exportCaption($this->kcdet);
					$doc->exportCaption($this->expectedSeveritydet);
					$doc->exportCaption($this->expectedOccurrencedet);
					$doc->exportCaption($this->expectedDetectiondet);
					$doc->exportCaption($this->expectedRPNPAD);
					$doc->exportCaption($this->revisedClosureDatedet);
					$doc->exportCaption($this->revisedSeverity);
					$doc->exportCaption($this->revisedOccurrence);
					$doc->exportCaption($this->revisedDetection);
					$doc->exportCaption($this->revisedRPNCalc);
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
						$doc->exportField($this->idProcess);
						$doc->exportField($this->idCause);
						$doc->exportField($this->potentialCauses);
						$doc->exportField($this->currentPreventiveControlMethod);
						$doc->exportField($this->severity);
						$doc->exportField($this->occurrence);
						$doc->exportField($this->currentControlMethod);
						$doc->exportField($this->detection);
						$doc->exportField($this->RPNCalc);
						$doc->exportField($this->recomendedAction);
						$doc->exportField($this->idResponsible);
						$doc->exportField($this->targetDate);
						$doc->exportField($this->revisedKc);
						$doc->exportField($this->expectedSeverity);
						$doc->exportField($this->expectedOccurrence);
						$doc->exportField($this->expectedDetection);
						$doc->exportField($this->expectedRpn);
						$doc->exportField($this->expectedRPNPAO);
						$doc->exportField($this->expectedClosureDate);
						$doc->exportField($this->recomendedActiondet);
						$doc->exportField($this->idResponsibleDet);
						$doc->exportField($this->targetDatedet);
						$doc->exportField($this->kcdet);
						$doc->exportField($this->expectedSeveritydet);
						$doc->exportField($this->expectedOccurrencedet);
						$doc->exportField($this->expectedDetectiondet);
						$doc->exportField($this->expectedRPNPAD);
						$doc->exportField($this->revisedClosureDatedet);
						$doc->exportField($this->perfomedAction);
						$doc->exportField($this->revisedSeverity);
						$doc->exportField($this->revisedOccurrence);
						$doc->exportField($this->revisedDetection);
						$doc->exportField($this->revisedRpn);
						$doc->exportField($this->revisedRPNCalc);
					} else {
						$doc->exportField($this->idProcess);
						$doc->exportField($this->idCause);
						$doc->exportField($this->potentialCauses);
						$doc->exportField($this->currentPreventiveControlMethod);
						$doc->exportField($this->severity);
						$doc->exportField($this->occurrence);
						$doc->exportField($this->currentControlMethod);
						$doc->exportField($this->detection);
						$doc->exportField($this->RPNCalc);
						$doc->exportField($this->recomendedAction);
						$doc->exportField($this->idResponsible);
						$doc->exportField($this->targetDate);
						$doc->exportField($this->revisedKc);
						$doc->exportField($this->expectedSeverity);
						$doc->exportField($this->expectedOccurrence);
						$doc->exportField($this->expectedDetection);
						$doc->exportField($this->expectedRPNPAO);
						$doc->exportField($this->expectedClosureDate);
						$doc->exportField($this->recomendedActiondet);
						$doc->exportField($this->idResponsibleDet);
						$doc->exportField($this->targetDatedet);
						$doc->exportField($this->kcdet);
						$doc->exportField($this->expectedSeveritydet);
						$doc->exportField($this->expectedOccurrencedet);
						$doc->exportField($this->expectedDetectiondet);
						$doc->exportField($this->expectedRPNPAD);
						$doc->exportField($this->revisedClosureDatedet);
						$doc->exportField($this->revisedSeverity);
						$doc->exportField($this->revisedOccurrence);
						$doc->exportField($this->revisedDetection);
						$doc->exportField($this->revisedRPNCalc);
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
			//edsa01 FORMULAS

		if ($this->idProcess->CurrentValue !== NULL && $this->idProcess->CurrentValue !== "")
		{
			$det2=$this->idProcess->CurrentValue;
			$cau=$this->idCause->CurrentValue;
			$sev = ExecuteScalar("SELECT severity FROM processf WHERE idProcess = $det2");
			$this->severity->ViewValue = $sev;
			$this->severity->CurrentValue = $sev;
			$this->expectedSeverity->CurrentValue = $sev;
			$this->expectedSeverity->ViewValue = $sev;
		}
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);
		//edsa01 COLORES

			if ($this->severity->CurrentValue !== NULL && $this->severity->CurrentValue !== "")
		{
			$seve1=$this->severity->CurrentValue;
			$sevColor = ExecuteScalar("SELECT color FROM severity WHERE idSeverity = $seve1");
			$this->severity->CellAttrs["style"] = "background-color: $sevColor";
		}
		if ($this->occurrence->CurrentValue!== NULL && $this->occurrence->CurrentValue !== "")
		{
			$occ=$this->occurrence->CurrentValue;
			$occColor = ExecuteScalar("SELECT color FROM occurrence WHERE idOccurrence = $occ");
			$this->occurrence->CellAttrs["style"] = "background-color: $occColor";
		}
		if ($this->detection->CurrentValue !== NULL && $this->detection->CurrentValue !== "")
		{
			$det=$this->detection->CurrentValue;
			$detColor = ExecuteScalar("SELECT color FROM detection WHERE idDetection = $det");
			$this->detection->CellAttrs["style"] = "background-color: $detColor";
		}
		if ($this->RPNCalc->CurrentValue!== NULL && $this->RPNCalc->CurrentValue !== "")
		{
			if ($this->RPNCalc->CurrentValue > 140) $this->RPNCalc->CellAttrs["style"] = "background-color: red"; 
		}

		//edsa01 FORMULAS
		if ($this->idProcess->CurrentValue !== NULL && $this->idProcess->CurrentValue !== "")
		{
			$det2=$this->idProcess->CurrentValue;
			$cau=$this->idCause->CurrentValue;
			$sev = ExecuteScalar("SELECT severity FROM processf WHERE idProcess = $det2");
			$this->severity->ViewValue = $sev;
			$this->severity->CurrentValue = $sev;
			$this->expectedSeverity->CurrentValue = $sev;
			$this->expectedSeverity->ViewValue = $sev;
			$this->RPNCalc->CurrentValue = $sev * $this->occurrence->CurrentValue * $this->detection->CurrentValue;

			/*
			$detect = ExecuteScalar("SELECT detection FROM actions WHERE idProcess = $det2 and idCause = $cau");
			$this->expectedDetection->CurrentValue=$detect;
			$this->expectedDetection->ViewValue=$detect;
			$ocurr = ExecuteScalar("SELECT occurrence FROM actions WHERE idProcess = $det2 and idCause = $cau");
			$this->expectedOccurrence->CurrentValue=$ocurr;
			$this->expectedOccurrence->ViewValue=$ocurr;
			*/
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>