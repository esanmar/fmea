<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for reportfmea
 */
class reportfmea extends DbTable
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
	public $idProcess;
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
	public $idCause;
	public $potentialCauses;
	public $currentPreventiveControlMethod;
	public $occurrence;
	public $currentControlMethod;
	public $detection;
	public $rpn;
	public $recomendedAction;
	public $idResponsible;
	public $targetDate;
	public $revisedKc;
	public $expectedSeverity;
	public $expectedOccurrence;
	public $expectedDetection;
	public $expectedRpn;
	public $expectedClosureDate;
	public $recomendedActiondet;
	public $idResponsibleDet;
	public $targetDatedet;
	public $kcdet;
	public $expectedSeveritydet;
	public $expectedOccurrencedet;
	public $expectedDetectiondet;
	public $expectedRpndet;
	public $revisedClosureDatedet;
	public $revisedClosureDate;
	public $perfomedAction;
	public $revisedSeverity;
	public $revisedOccurrence;
	public $revisedDetection;
	public $revisedRpn;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'reportfmea';
		$this->TableName = 'reportfmea';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`reportfmea`";
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
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 6;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 104; // User ID Allow
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// fmea
		$this->fmea = new DbField('reportfmea', 'reportfmea', 'x_fmea', 'fmea', '`fmea`', '`fmea`', 200, 255, -1, FALSE, '`fmea`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fmea->IsPrimaryKey = TRUE; // Primary key field
		$this->fmea->Nullable = FALSE; // NOT NULL field
		$this->fmea->Required = TRUE; // Required field
		$this->fmea->Sortable = TRUE; // Allow sort
		$this->fmea->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->fmea->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->fmea->Lookup = new Lookup('fmea', 'fmea', FALSE, 'fmea', ["fmea","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->fmea->Lookup = new Lookup('fmea', 'fmea', FALSE, 'fmea', ["fmea","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['fmea'] = &$this->fmea;

		// idFactory
		$this->idFactory = new DbField('reportfmea', 'reportfmea', 'x_idFactory', 'idFactory', '`idFactory`', '`idFactory`', 200, 50, -1, FALSE, '`idFactory`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idFactory->Sortable = TRUE; // Allow sort
		$this->idFactory->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idFactory->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idFactory->Lookup = new Lookup('idFactory', 'factories', FALSE, 'idFactory', ["factory","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idFactory->Lookup = new Lookup('idFactory', 'factories', FALSE, 'idFactory', ["factory","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idFactory'] = &$this->idFactory;

		// dateFmea
		$this->dateFmea = new DbField('reportfmea', 'reportfmea', 'x_dateFmea', 'dateFmea', '`dateFmea`', CastDateFieldForLike("`dateFmea`", 0, "DB"), 135, 19, 0, FALSE, '`dateFmea`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dateFmea->Sortable = TRUE; // Allow sort
		$this->dateFmea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['dateFmea'] = &$this->dateFmea;

		// partnumbers
		$this->partnumbers = new DbField('reportfmea', 'reportfmea', 'x_partnumbers', 'partnumbers', '`partnumbers`', '`partnumbers`', 201, -1, -1, FALSE, '`partnumbers`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->partnumbers->Sortable = TRUE; // Allow sort
		$this->fields['partnumbers'] = &$this->partnumbers;

		// description
		$this->description = new DbField('reportfmea', 'reportfmea', 'x_description', 'description', '`description`', '`description`', 201, -1, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// idEmployee
		$this->idEmployee = new DbField('reportfmea', 'reportfmea', 'x_idEmployee', 'idEmployee', '`idEmployee`', '`idEmployee`', 200, 50, -1, FALSE, '`idEmployee`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idEmployee->Sortable = TRUE; // Allow sort
		$this->idEmployee->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idEmployee->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idEmployee->Lookup = new Lookup('idEmployee', 'employees', FALSE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idEmployee->Lookup = new Lookup('idEmployee', 'employees', FALSE, 'idEmployee', ["name","surname","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idEmployee'] = &$this->idEmployee;

		// idworkcenter
		$this->idworkcenter = new DbField('reportfmea', 'reportfmea', 'x_idworkcenter', 'idworkcenter', '`idworkcenter`', '`idworkcenter`', 200, 150, -1, FALSE, '`idworkcenter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
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

		// idProcess
		$this->idProcess = new DbField('reportfmea', 'reportfmea', 'x_idProcess', 'idProcess', '`idProcess`', '`idProcess`', 3, 11, -1, FALSE, '`idProcess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idProcess->Nullable = FALSE; // NOT NULL field
		$this->idProcess->Required = TRUE; // Required field
		$this->idProcess->Sortable = TRUE; // Allow sort
		$this->idProcess->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idProcess'] = &$this->idProcess;

		// step
		$this->step = new DbField('reportfmea', 'reportfmea', 'x_step', 'step', '`step`', '`step`', 3, 11, -1, FALSE, '`step`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->step->Sortable = TRUE; // Allow sort
		$this->step->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['step'] = &$this->step;

		// flowchartDesc
		$this->flowchartDesc = new DbField('reportfmea', 'reportfmea', 'x_flowchartDesc', 'flowchartDesc', '`flowchartDesc`', '`flowchartDesc`', 201, -1, -1, FALSE, '`flowchartDesc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->flowchartDesc->Sortable = TRUE; // Allow sort
		$this->fields['flowchartDesc'] = &$this->flowchartDesc;

		// partnumber
		$this->partnumber = new DbField('reportfmea', 'reportfmea', 'x_partnumber', 'partnumber', '`partnumber`', '`partnumber`', 200, 255, -1, FALSE, '`partnumber`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->partnumber->Sortable = TRUE; // Allow sort
		$this->fields['partnumber'] = &$this->partnumber;

		// operation
		$this->operation = new DbField('reportfmea', 'reportfmea', 'x_operation', 'operation', '`operation`', '`operation`', 200, 255, -1, FALSE, '`operation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->operation->Sortable = TRUE; // Allow sort
		$this->fields['operation'] = &$this->operation;

		// derivedFromNC
		$this->derivedFromNC = new DbField('reportfmea', 'reportfmea', 'x_derivedFromNC', 'derivedFromNC', '`derivedFromNC`', '`derivedFromNC`', 202, 1, -1, FALSE, '`derivedFromNC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->derivedFromNC->Sortable = TRUE; // Allow sort
		$this->derivedFromNC->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->derivedFromNC->Lookup = new Lookup('derivedFromNC', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->derivedFromNC->Lookup = new Lookup('derivedFromNC', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->derivedFromNC->OptionCount = 2;
		$this->fields['derivedFromNC'] = &$this->derivedFromNC;

		// numberOfNC
		$this->numberOfNC = new DbField('reportfmea', 'reportfmea', 'x_numberOfNC', 'numberOfNC', '`numberOfNC`', '`numberOfNC`', 200, 255, -1, FALSE, '`numberOfNC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->numberOfNC->Sortable = TRUE; // Allow sort
		$this->fields['numberOfNC'] = &$this->numberOfNC;

		// flowchart
		$this->flowchart = new DbField('reportfmea', 'reportfmea', 'x_flowchart', 'flowchart', '`flowchart`', '`flowchart`', 200, 255, -1, FALSE, '`flowchart`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->flowchart->Sortable = TRUE; // Allow sort
		$this->fields['flowchart'] = &$this->flowchart;

		// subprocess
		$this->subprocess = new DbField('reportfmea', 'reportfmea', 'x_subprocess', 'subprocess', '`subprocess`', '`subprocess`', 200, 255, -1, FALSE, '`subprocess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->subprocess->Sortable = TRUE; // Allow sort
		$this->fields['subprocess'] = &$this->subprocess;

		// requirement
		$this->requirement = new DbField('reportfmea', 'reportfmea', 'x_requirement', 'requirement', '`requirement`', '`requirement`', 200, 255, -1, FALSE, '`requirement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->requirement->Sortable = TRUE; // Allow sort
		$this->fields['requirement'] = &$this->requirement;

		// potencialFailureMode
		$this->potencialFailureMode = new DbField('reportfmea', 'reportfmea', 'x_potencialFailureMode', 'potencialFailureMode', '`potencialFailureMode`', '`potencialFailureMode`', 200, 255, -1, FALSE, '`potencialFailureMode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->potencialFailureMode->Sortable = TRUE; // Allow sort
		$this->fields['potencialFailureMode'] = &$this->potencialFailureMode;

		// potencialFailurEffect
		$this->potencialFailurEffect = new DbField('reportfmea', 'reportfmea', 'x_potencialFailurEffect', 'potencialFailurEffect', '`potencialFailurEffect`', '`potencialFailurEffect`', 200, 255, -1, FALSE, '`potencialFailurEffect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->potencialFailurEffect->Sortable = TRUE; // Allow sort
		$this->fields['potencialFailurEffect'] = &$this->potencialFailurEffect;

		// kc
		$this->kc = new DbField('reportfmea', 'reportfmea', 'x_kc', 'kc', '`kc`', '`kc`', 202, 1, -1, FALSE, '`kc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->kc->Sortable = TRUE; // Allow sort
		$this->kc->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->kc->Lookup = new Lookup('kc', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->kc->Lookup = new Lookup('kc', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->kc->OptionCount = 2;
		$this->fields['kc'] = &$this->kc;

		// severity
		$this->severity = new DbField('reportfmea', 'reportfmea', 'x_severity', 'severity', '`severity`', '`severity`', 3, 11, -1, FALSE, '`severity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->severity->Sortable = TRUE; // Allow sort
		$this->severity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['severity'] = &$this->severity;

		// idCause
		$this->idCause = new DbField('reportfmea', 'reportfmea', 'x_idCause', 'idCause', '`idCause`', '`idCause`', 200, 50, -1, FALSE, '`idCause`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idCause->IsPrimaryKey = TRUE; // Primary key field
		$this->idCause->Nullable = FALSE; // NOT NULL field
		$this->idCause->Required = TRUE; // Required field
		$this->idCause->Sortable = TRUE; // Allow sort
		$this->idCause->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idCause->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idCause->Lookup = new Lookup('idCause', 'causes', FALSE, 'idCause', ["cause","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idCause->Lookup = new Lookup('idCause', 'causes', FALSE, 'idCause', ["cause","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->fields['idCause'] = &$this->idCause;

		// potentialCauses
		$this->potentialCauses = new DbField('reportfmea', 'reportfmea', 'x_potentialCauses', 'potentialCauses', '`potentialCauses`', '`potentialCauses`', 201, -1, -1, FALSE, '`potentialCauses`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->potentialCauses->Sortable = TRUE; // Allow sort
		$this->fields['potentialCauses'] = &$this->potentialCauses;

		// currentPreventiveControlMethod
		$this->currentPreventiveControlMethod = new DbField('reportfmea', 'reportfmea', 'x_currentPreventiveControlMethod', 'currentPreventiveControlMethod', '`currentPreventiveControlMethod`', '`currentPreventiveControlMethod`', 200, 255, -1, FALSE, '`currentPreventiveControlMethod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currentPreventiveControlMethod->Sortable = TRUE; // Allow sort
		$this->fields['currentPreventiveControlMethod'] = &$this->currentPreventiveControlMethod;

		// occurrence
		$this->occurrence = new DbField('reportfmea', 'reportfmea', 'x_occurrence', 'occurrence', '`occurrence`', '`occurrence`', 3, 11, -1, FALSE, '`occurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->occurrence->Sortable = TRUE; // Allow sort
		$this->occurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['occurrence'] = &$this->occurrence;

		// currentControlMethod
		$this->currentControlMethod = new DbField('reportfmea', 'reportfmea', 'x_currentControlMethod', 'currentControlMethod', '`currentControlMethod`', '`currentControlMethod`', 200, 255, -1, FALSE, '`currentControlMethod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currentControlMethod->Sortable = TRUE; // Allow sort
		$this->fields['currentControlMethod'] = &$this->currentControlMethod;

		// detection
		$this->detection = new DbField('reportfmea', 'reportfmea', 'x_detection', 'detection', '`detection`', '`detection`', 3, 11, -1, FALSE, '`detection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detection->Sortable = TRUE; // Allow sort
		$this->detection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['detection'] = &$this->detection;

		// rpn
		$this->rpn = new DbField('reportfmea', 'reportfmea', 'x_rpn', 'rpn', '`rpn`', '`rpn`', 3, 11, -1, FALSE, '`rpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rpn->Sortable = TRUE; // Allow sort
		$this->rpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['rpn'] = &$this->rpn;

		// recomendedAction
		$this->recomendedAction = new DbField('reportfmea', 'reportfmea', 'x_recomendedAction', 'recomendedAction', '`recomendedAction`', '`recomendedAction`', 201, -1, -1, FALSE, '`recomendedAction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->recomendedAction->Sortable = TRUE; // Allow sort
		$this->fields['recomendedAction'] = &$this->recomendedAction;

		// idResponsible
		$this->idResponsible = new DbField('reportfmea', 'reportfmea', 'x_idResponsible', 'idResponsible', '`idResponsible`', '`idResponsible`', 200, 50, -1, FALSE, '`idResponsible`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idResponsible->Sortable = TRUE; // Allow sort
		$this->fields['idResponsible'] = &$this->idResponsible;

		// targetDate
		$this->targetDate = new DbField('reportfmea', 'reportfmea', 'x_targetDate', 'targetDate', '`targetDate`', CastDateFieldForLike("`targetDate`", 0, "DB"), 135, 19, 0, FALSE, '`targetDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->targetDate->Sortable = TRUE; // Allow sort
		$this->targetDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['targetDate'] = &$this->targetDate;

		// revisedKc
		$this->revisedKc = new DbField('reportfmea', 'reportfmea', 'x_revisedKc', 'revisedKc', '`revisedKc`', '`revisedKc`', 202, 1, -1, FALSE, '`revisedKc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->revisedKc->Sortable = TRUE; // Allow sort
		$this->revisedKc->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->revisedKc->Lookup = new Lookup('revisedKc', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->revisedKc->Lookup = new Lookup('revisedKc', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->revisedKc->OptionCount = 2;
		$this->fields['revisedKc'] = &$this->revisedKc;

		// expectedSeverity
		$this->expectedSeverity = new DbField('reportfmea', 'reportfmea', 'x_expectedSeverity', 'expectedSeverity', '`expectedSeverity`', '`expectedSeverity`', 3, 11, -1, FALSE, '`expectedSeverity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedSeverity->Sortable = TRUE; // Allow sort
		$this->expectedSeverity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedSeverity'] = &$this->expectedSeverity;

		// expectedOccurrence
		$this->expectedOccurrence = new DbField('reportfmea', 'reportfmea', 'x_expectedOccurrence', 'expectedOccurrence', '`expectedOccurrence`', '`expectedOccurrence`', 3, 11, -1, FALSE, '`expectedOccurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedOccurrence->Sortable = TRUE; // Allow sort
		$this->expectedOccurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedOccurrence'] = &$this->expectedOccurrence;

		// expectedDetection
		$this->expectedDetection = new DbField('reportfmea', 'reportfmea', 'x_expectedDetection', 'expectedDetection', '`expectedDetection`', '`expectedDetection`', 3, 11, -1, FALSE, '`expectedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedDetection->Sortable = TRUE; // Allow sort
		$this->expectedDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedDetection'] = &$this->expectedDetection;

		// expectedRpn
		$this->expectedRpn = new DbField('reportfmea', 'reportfmea', 'x_expectedRpn', 'expectedRpn', '`expectedRpn`', '`expectedRpn`', 3, 11, -1, FALSE, '`expectedRpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRpn->Sortable = TRUE; // Allow sort
		$this->expectedRpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedRpn'] = &$this->expectedRpn;

		// expectedClosureDate
		$this->expectedClosureDate = new DbField('reportfmea', 'reportfmea', 'x_expectedClosureDate', 'expectedClosureDate', '`expectedClosureDate`', CastDateFieldForLike("`expectedClosureDate`", 0, "DB"), 135, 19, 0, FALSE, '`expectedClosureDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedClosureDate->Sortable = TRUE; // Allow sort
		$this->expectedClosureDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['expectedClosureDate'] = &$this->expectedClosureDate;

		// recomendedActiondet
		$this->recomendedActiondet = new DbField('reportfmea', 'reportfmea', 'x_recomendedActiondet', 'recomendedActiondet', '`recomendedActiondet`', '`recomendedActiondet`', 201, -1, -1, FALSE, '`recomendedActiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->recomendedActiondet->Sortable = TRUE; // Allow sort
		$this->fields['recomendedActiondet'] = &$this->recomendedActiondet;

		// idResponsibleDet
		$this->idResponsibleDet = new DbField('reportfmea', 'reportfmea', 'x_idResponsibleDet', 'idResponsibleDet', '`idResponsibleDet`', '`idResponsibleDet`', 200, 50, -1, FALSE, '`idResponsibleDet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idResponsibleDet->Sortable = TRUE; // Allow sort
		$this->fields['idResponsibleDet'] = &$this->idResponsibleDet;

		// targetDatedet
		$this->targetDatedet = new DbField('reportfmea', 'reportfmea', 'x_targetDatedet', 'targetDatedet', '`targetDatedet`', CastDateFieldForLike("`targetDatedet`", 0, "DB"), 135, 19, 0, FALSE, '`targetDatedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->targetDatedet->Sortable = TRUE; // Allow sort
		$this->targetDatedet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['targetDatedet'] = &$this->targetDatedet;

		// kcdet
		$this->kcdet = new DbField('reportfmea', 'reportfmea', 'x_kcdet', 'kcdet', '`kcdet`', '`kcdet`', 202, 1, -1, FALSE, '`kcdet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->kcdet->Sortable = TRUE; // Allow sort
		$this->kcdet->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->kcdet->Lookup = new Lookup('kcdet', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->kcdet->Lookup = new Lookup('kcdet', 'reportfmea', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->kcdet->OptionCount = 2;
		$this->fields['kcdet'] = &$this->kcdet;

		// expectedSeveritydet
		$this->expectedSeveritydet = new DbField('reportfmea', 'reportfmea', 'x_expectedSeveritydet', 'expectedSeveritydet', '`expectedSeveritydet`', '`expectedSeveritydet`', 3, 11, -1, FALSE, '`expectedSeveritydet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedSeveritydet->Sortable = TRUE; // Allow sort
		$this->expectedSeveritydet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedSeveritydet'] = &$this->expectedSeveritydet;

		// expectedOccurrencedet
		$this->expectedOccurrencedet = new DbField('reportfmea', 'reportfmea', 'x_expectedOccurrencedet', 'expectedOccurrencedet', '`expectedOccurrencedet`', '`expectedOccurrencedet`', 3, 11, -1, FALSE, '`expectedOccurrencedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedOccurrencedet->Sortable = TRUE; // Allow sort
		$this->expectedOccurrencedet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedOccurrencedet'] = &$this->expectedOccurrencedet;

		// expectedDetectiondet
		$this->expectedDetectiondet = new DbField('reportfmea', 'reportfmea', 'x_expectedDetectiondet', 'expectedDetectiondet', '`expectedDetectiondet`', '`expectedDetectiondet`', 3, 11, -1, FALSE, '`expectedDetectiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedDetectiondet->Sortable = TRUE; // Allow sort
		$this->expectedDetectiondet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedDetectiondet'] = &$this->expectedDetectiondet;

		// expectedRpndet
		$this->expectedRpndet = new DbField('reportfmea', 'reportfmea', 'x_expectedRpndet', 'expectedRpndet', '`expectedRpndet`', '`expectedRpndet`', 3, 11, -1, FALSE, '`expectedRpndet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRpndet->Sortable = TRUE; // Allow sort
		$this->expectedRpndet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['expectedRpndet'] = &$this->expectedRpndet;

		// revisedClosureDatedet
		$this->revisedClosureDatedet = new DbField('reportfmea', 'reportfmea', 'x_revisedClosureDatedet', 'revisedClosureDatedet', '`revisedClosureDatedet`', CastDateFieldForLike("`revisedClosureDatedet`", 0, "DB"), 135, 19, 0, FALSE, '`revisedClosureDatedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedClosureDatedet->Sortable = TRUE; // Allow sort
		$this->revisedClosureDatedet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['revisedClosureDatedet'] = &$this->revisedClosureDatedet;

		// revisedClosureDate
		$this->revisedClosureDate = new DbField('reportfmea', 'reportfmea', 'x_revisedClosureDate', 'revisedClosureDate', '`revisedClosureDate`', CastDateFieldForLike("`revisedClosureDate`", 0, "DB"), 135, 19, 0, FALSE, '`revisedClosureDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedClosureDate->Sortable = TRUE; // Allow sort
		$this->revisedClosureDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['revisedClosureDate'] = &$this->revisedClosureDate;

		// perfomedAction
		$this->perfomedAction = new DbField('reportfmea', 'reportfmea', 'x_perfomedAction', 'perfomedAction', '`perfomedAction`', '`perfomedAction`', 201, -1, -1, FALSE, '`perfomedAction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->perfomedAction->Sortable = TRUE; // Allow sort
		$this->fields['perfomedAction'] = &$this->perfomedAction;

		// revisedSeverity
		$this->revisedSeverity = new DbField('reportfmea', 'reportfmea', 'x_revisedSeverity', 'revisedSeverity', '`revisedSeverity`', '`revisedSeverity`', 3, 11, -1, FALSE, '`revisedSeverity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedSeverity->Sortable = TRUE; // Allow sort
		$this->revisedSeverity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedSeverity'] = &$this->revisedSeverity;

		// revisedOccurrence
		$this->revisedOccurrence = new DbField('reportfmea', 'reportfmea', 'x_revisedOccurrence', 'revisedOccurrence', '`revisedOccurrence`', '`revisedOccurrence`', 3, 11, -1, FALSE, '`revisedOccurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedOccurrence->Sortable = TRUE; // Allow sort
		$this->revisedOccurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedOccurrence'] = &$this->revisedOccurrence;

		// revisedDetection
		$this->revisedDetection = new DbField('reportfmea', 'reportfmea', 'x_revisedDetection', 'revisedDetection', '`revisedDetection`', '`revisedDetection`', 3, 11, -1, FALSE, '`revisedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedDetection->Sortable = TRUE; // Allow sort
		$this->revisedDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedDetection'] = &$this->revisedDetection;

		// revisedRpn
		$this->revisedRpn = new DbField('reportfmea', 'reportfmea', 'x_revisedRpn', 'revisedRpn', '`revisedRpn`', '`revisedRpn`', 3, 11, -1, FALSE, '`revisedRpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedRpn->Sortable = TRUE; // Allow sort
		$this->revisedRpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['revisedRpn'] = &$this->revisedRpn;
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
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`reportfmea`";
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
			if (array_key_exists('fmea', $rs))
				AddFilter($where, QuotedName('fmea', $this->Dbid) . '=' . QuotedValue($rs['fmea'], $this->fmea->DataType, $this->Dbid));
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
		$this->fmea->DbValue = $row['fmea'];
		$this->idFactory->DbValue = $row['idFactory'];
		$this->dateFmea->DbValue = $row['dateFmea'];
		$this->partnumbers->DbValue = $row['partnumbers'];
		$this->description->DbValue = $row['description'];
		$this->idEmployee->DbValue = $row['idEmployee'];
		$this->idworkcenter->DbValue = $row['idworkcenter'];
		$this->idProcess->DbValue = $row['idProcess'];
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
		$this->idCause->DbValue = $row['idCause'];
		$this->potentialCauses->DbValue = $row['potentialCauses'];
		$this->currentPreventiveControlMethod->DbValue = $row['currentPreventiveControlMethod'];
		$this->occurrence->DbValue = $row['occurrence'];
		$this->currentControlMethod->DbValue = $row['currentControlMethod'];
		$this->detection->DbValue = $row['detection'];
		$this->rpn->DbValue = $row['rpn'];
		$this->recomendedAction->DbValue = $row['recomendedAction'];
		$this->idResponsible->DbValue = $row['idResponsible'];
		$this->targetDate->DbValue = $row['targetDate'];
		$this->revisedKc->DbValue = $row['revisedKc'];
		$this->expectedSeverity->DbValue = $row['expectedSeverity'];
		$this->expectedOccurrence->DbValue = $row['expectedOccurrence'];
		$this->expectedDetection->DbValue = $row['expectedDetection'];
		$this->expectedRpn->DbValue = $row['expectedRpn'];
		$this->expectedClosureDate->DbValue = $row['expectedClosureDate'];
		$this->recomendedActiondet->DbValue = $row['recomendedActiondet'];
		$this->idResponsibleDet->DbValue = $row['idResponsibleDet'];
		$this->targetDatedet->DbValue = $row['targetDatedet'];
		$this->kcdet->DbValue = $row['kcdet'];
		$this->expectedSeveritydet->DbValue = $row['expectedSeveritydet'];
		$this->expectedOccurrencedet->DbValue = $row['expectedOccurrencedet'];
		$this->expectedDetectiondet->DbValue = $row['expectedDetectiondet'];
		$this->expectedRpndet->DbValue = $row['expectedRpndet'];
		$this->revisedClosureDatedet->DbValue = $row['revisedClosureDatedet'];
		$this->revisedClosureDate->DbValue = $row['revisedClosureDate'];
		$this->perfomedAction->DbValue = $row['perfomedAction'];
		$this->revisedSeverity->DbValue = $row['revisedSeverity'];
		$this->revisedOccurrence->DbValue = $row['revisedOccurrence'];
		$this->revisedDetection->DbValue = $row['revisedDetection'];
		$this->revisedRpn->DbValue = $row['revisedRpn'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`fmea` = '@fmea@' AND `idCause` = '@idCause@'";
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
			return "reportfmealist.php";
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
		if ($pageName == "reportfmeaview.php")
			return $Language->phrase("View");
		elseif ($pageName == "reportfmeaedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "reportfmeaadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "reportfmealist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("reportfmeaview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("reportfmeaview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "reportfmeaadd.php?" . $this->getUrlParm($parm);
		else
			$url = "reportfmeaadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("reportfmeaedit.php", $this->getUrlParm($parm));
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
		$url = $this->keyUrl("reportfmeaadd.php", $this->getUrlParm($parm));
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
		return $this->keyUrl("reportfmeadelete.php", $this->getUrlParm());
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
		if ($this->fmea->CurrentValue != NULL) {
			$url .= "fmea=" . urlencode($this->fmea->CurrentValue);
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
			if (Param("fmea") !== NULL)
				$arKey[] = Param("fmea");
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
				$this->fmea->CurrentValue = $key[0];
			else
				$this->fmea->OldValue = $key[0];
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
		$this->fmea->setDbValue($rs->fields('fmea'));
		$this->idFactory->setDbValue($rs->fields('idFactory'));
		$this->dateFmea->setDbValue($rs->fields('dateFmea'));
		$this->partnumbers->setDbValue($rs->fields('partnumbers'));
		$this->description->setDbValue($rs->fields('description'));
		$this->idEmployee->setDbValue($rs->fields('idEmployee'));
		$this->idworkcenter->setDbValue($rs->fields('idworkcenter'));
		$this->idProcess->setDbValue($rs->fields('idProcess'));
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
		$this->idCause->setDbValue($rs->fields('idCause'));
		$this->potentialCauses->setDbValue($rs->fields('potentialCauses'));
		$this->currentPreventiveControlMethod->setDbValue($rs->fields('currentPreventiveControlMethod'));
		$this->occurrence->setDbValue($rs->fields('occurrence'));
		$this->currentControlMethod->setDbValue($rs->fields('currentControlMethod'));
		$this->detection->setDbValue($rs->fields('detection'));
		$this->rpn->setDbValue($rs->fields('rpn'));
		$this->recomendedAction->setDbValue($rs->fields('recomendedAction'));
		$this->idResponsible->setDbValue($rs->fields('idResponsible'));
		$this->targetDate->setDbValue($rs->fields('targetDate'));
		$this->revisedKc->setDbValue($rs->fields('revisedKc'));
		$this->expectedSeverity->setDbValue($rs->fields('expectedSeverity'));
		$this->expectedOccurrence->setDbValue($rs->fields('expectedOccurrence'));
		$this->expectedDetection->setDbValue($rs->fields('expectedDetection'));
		$this->expectedRpn->setDbValue($rs->fields('expectedRpn'));
		$this->expectedClosureDate->setDbValue($rs->fields('expectedClosureDate'));
		$this->recomendedActiondet->setDbValue($rs->fields('recomendedActiondet'));
		$this->idResponsibleDet->setDbValue($rs->fields('idResponsibleDet'));
		$this->targetDatedet->setDbValue($rs->fields('targetDatedet'));
		$this->kcdet->setDbValue($rs->fields('kcdet'));
		$this->expectedSeveritydet->setDbValue($rs->fields('expectedSeveritydet'));
		$this->expectedOccurrencedet->setDbValue($rs->fields('expectedOccurrencedet'));
		$this->expectedDetectiondet->setDbValue($rs->fields('expectedDetectiondet'));
		$this->expectedRpndet->setDbValue($rs->fields('expectedRpndet'));
		$this->revisedClosureDatedet->setDbValue($rs->fields('revisedClosureDatedet'));
		$this->revisedClosureDate->setDbValue($rs->fields('revisedClosureDate'));
		$this->perfomedAction->setDbValue($rs->fields('perfomedAction'));
		$this->revisedSeverity->setDbValue($rs->fields('revisedSeverity'));
		$this->revisedOccurrence->setDbValue($rs->fields('revisedOccurrence'));
		$this->revisedDetection->setDbValue($rs->fields('revisedDetection'));
		$this->revisedRpn->setDbValue($rs->fields('revisedRpn'));
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
		// idProcess
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
		// idCause
		// potentialCauses
		// currentPreventiveControlMethod
		// occurrence
		// currentControlMethod
		// detection
		// rpn
		// recomendedAction
		// idResponsible
		// targetDate
		// revisedKc
		// expectedSeverity
		// expectedOccurrence
		// expectedDetection
		// expectedRpn
		// expectedClosureDate
		// recomendedActiondet
		// idResponsibleDet
		// targetDatedet
		// kcdet
		// expectedSeveritydet
		// expectedOccurrencedet
		// expectedDetectiondet
		// expectedRpndet
		// revisedClosureDatedet
		// revisedClosureDate
		// perfomedAction
		// revisedSeverity
		// revisedOccurrence
		// revisedDetection
		// revisedRpn
		// fmea

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
		$this->fmea->ViewCustomAttributes = "";

		// idFactory
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
		$curVal = strval($this->idEmployee->CurrentValue);
		if ($curVal != "") {
			$this->idEmployee->ViewValue = $this->idEmployee->lookupCacheOption($curVal);
			if ($this->idEmployee->ViewValue === NULL) { // Lookup from database
				$filterWrk = "`idEmployee`" . SearchString("=", $curVal, DATATYPE_STRING, "");
				$sqlWrk = $this->idEmployee->Lookup->getSql(FALSE, $filterWrk, '', $this);
				$rswrk = Conn()->execute($sqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = [];
					$arwrk[1] = $rswrk->fields('df');
					$arwrk[2] = $rswrk->fields('df2');
					$this->idEmployee->ViewValue = $this->idEmployee->displayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idEmployee->ViewValue = $this->idEmployee->CurrentValue;
				}
			}
		} else {
			$this->idEmployee->ViewValue = NULL;
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

		// idProcess
		$this->idProcess->ViewValue = $this->idProcess->CurrentValue;
		$this->idProcess->ViewCustomAttributes = "";

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

		// idCause
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
		$this->idCause->ViewCustomAttributes = "";

		// potentialCauses
		$this->potentialCauses->ViewValue = $this->potentialCauses->CurrentValue;
		$this->potentialCauses->ViewCustomAttributes = "";

		// currentPreventiveControlMethod
		$this->currentPreventiveControlMethod->ViewValue = $this->currentPreventiveControlMethod->CurrentValue;
		$this->currentPreventiveControlMethod->ViewCustomAttributes = "";

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

		// rpn
		$this->rpn->ViewValue = $this->rpn->CurrentValue;
		$this->rpn->ViewValue = FormatNumber($this->rpn->ViewValue, 0, -2, -2, -2);
		$this->rpn->ViewCustomAttributes = "";

		// recomendedAction
		$this->recomendedAction->ViewValue = $this->recomendedAction->CurrentValue;
		$this->recomendedAction->ViewCustomAttributes = "";

		// idResponsible
		$this->idResponsible->ViewValue = $this->idResponsible->CurrentValue;
		$this->idResponsible->ViewCustomAttributes = "";

		// targetDate
		$this->targetDate->ViewValue = $this->targetDate->CurrentValue;
		$this->targetDate->ViewValue = FormatDateTime($this->targetDate->ViewValue, 0);
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

		// expectedClosureDate
		$this->expectedClosureDate->ViewValue = $this->expectedClosureDate->CurrentValue;
		$this->expectedClosureDate->ViewValue = FormatDateTime($this->expectedClosureDate->ViewValue, 0);
		$this->expectedClosureDate->ViewCustomAttributes = "";

		// recomendedActiondet
		$this->recomendedActiondet->ViewValue = $this->recomendedActiondet->CurrentValue;
		$this->recomendedActiondet->ViewCustomAttributes = "";

		// idResponsibleDet
		$this->idResponsibleDet->ViewValue = $this->idResponsibleDet->CurrentValue;
		$this->idResponsibleDet->ViewCustomAttributes = "";

		// targetDatedet
		$this->targetDatedet->ViewValue = $this->targetDatedet->CurrentValue;
		$this->targetDatedet->ViewValue = FormatDateTime($this->targetDatedet->ViewValue, 0);
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

		// revisedClosureDatedet
		$this->revisedClosureDatedet->ViewValue = $this->revisedClosureDatedet->CurrentValue;
		$this->revisedClosureDatedet->ViewValue = FormatDateTime($this->revisedClosureDatedet->ViewValue, 0);
		$this->revisedClosureDatedet->ViewCustomAttributes = "";

		// revisedClosureDate
		$this->revisedClosureDate->ViewValue = $this->revisedClosureDate->CurrentValue;
		$this->revisedClosureDate->ViewValue = FormatDateTime($this->revisedClosureDate->ViewValue, 0);
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

		// idProcess
		$this->idProcess->LinkCustomAttributes = "";
		$this->idProcess->HrefValue = "";
		$this->idProcess->TooltipValue = "";

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

		// idProcess
		$this->idProcess->EditAttrs["class"] = "form-control";
		$this->idProcess->EditCustomAttributes = "";
		$this->idProcess->EditValue = $this->idProcess->CurrentValue;
		$this->idProcess->PlaceHolder = RemoveHtml($this->idProcess->caption());

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

		// rpn
		$this->rpn->EditAttrs["class"] = "form-control";
		$this->rpn->EditCustomAttributes = "";
		$this->rpn->EditValue = $this->rpn->CurrentValue;
		$this->rpn->PlaceHolder = RemoveHtml($this->rpn->caption());

		// recomendedAction
		$this->recomendedAction->EditAttrs["class"] = "form-control";
		$this->recomendedAction->EditCustomAttributes = "";
		$this->recomendedAction->EditValue = $this->recomendedAction->CurrentValue;
		$this->recomendedAction->PlaceHolder = RemoveHtml($this->recomendedAction->caption());

		// idResponsible
		$this->idResponsible->EditAttrs["class"] = "form-control";
		$this->idResponsible->EditCustomAttributes = "";
		if (!$this->idResponsible->Raw)
			$this->idResponsible->CurrentValue = HtmlDecode($this->idResponsible->CurrentValue);
		$this->idResponsible->EditValue = $this->idResponsible->CurrentValue;
		$this->idResponsible->PlaceHolder = RemoveHtml($this->idResponsible->caption());

		// targetDate
		$this->targetDate->EditAttrs["class"] = "form-control";
		$this->targetDate->EditCustomAttributes = "";
		$this->targetDate->EditValue = FormatDateTime($this->targetDate->CurrentValue, 8);
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

		// expectedClosureDate
		$this->expectedClosureDate->EditAttrs["class"] = "form-control";
		$this->expectedClosureDate->EditCustomAttributes = "";
		$this->expectedClosureDate->EditValue = FormatDateTime($this->expectedClosureDate->CurrentValue, 8);
		$this->expectedClosureDate->PlaceHolder = RemoveHtml($this->expectedClosureDate->caption());

		// recomendedActiondet
		$this->recomendedActiondet->EditAttrs["class"] = "form-control";
		$this->recomendedActiondet->EditCustomAttributes = "";
		$this->recomendedActiondet->EditValue = $this->recomendedActiondet->CurrentValue;
		$this->recomendedActiondet->PlaceHolder = RemoveHtml($this->recomendedActiondet->caption());

		// idResponsibleDet
		$this->idResponsibleDet->EditAttrs["class"] = "form-control";
		$this->idResponsibleDet->EditCustomAttributes = "";
		if (!$this->idResponsibleDet->Raw)
			$this->idResponsibleDet->CurrentValue = HtmlDecode($this->idResponsibleDet->CurrentValue);
		$this->idResponsibleDet->EditValue = $this->idResponsibleDet->CurrentValue;
		$this->idResponsibleDet->PlaceHolder = RemoveHtml($this->idResponsibleDet->caption());

		// targetDatedet
		$this->targetDatedet->EditAttrs["class"] = "form-control";
		$this->targetDatedet->EditCustomAttributes = "";
		$this->targetDatedet->EditValue = FormatDateTime($this->targetDatedet->CurrentValue, 8);
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

		// revisedClosureDatedet
		$this->revisedClosureDatedet->EditAttrs["class"] = "form-control";
		$this->revisedClosureDatedet->EditCustomAttributes = "";
		$this->revisedClosureDatedet->EditValue = FormatDateTime($this->revisedClosureDatedet->CurrentValue, 8);
		$this->revisedClosureDatedet->PlaceHolder = RemoveHtml($this->revisedClosureDatedet->caption());

		// revisedClosureDate
		$this->revisedClosureDate->EditAttrs["class"] = "form-control";
		$this->revisedClosureDate->EditCustomAttributes = "";
		$this->revisedClosureDate->EditValue = FormatDateTime($this->revisedClosureDate->CurrentValue, 8);
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
					$doc->exportCaption($this->idProcess);
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
					$doc->exportCaption($this->idCause);
					$doc->exportCaption($this->potentialCauses);
					$doc->exportCaption($this->currentPreventiveControlMethod);
					$doc->exportCaption($this->occurrence);
					$doc->exportCaption($this->currentControlMethod);
					$doc->exportCaption($this->detection);
					$doc->exportCaption($this->rpn);
					$doc->exportCaption($this->recomendedAction);
					$doc->exportCaption($this->idResponsible);
					$doc->exportCaption($this->targetDate);
					$doc->exportCaption($this->revisedKc);
					$doc->exportCaption($this->expectedSeverity);
					$doc->exportCaption($this->expectedOccurrence);
					$doc->exportCaption($this->expectedDetection);
					$doc->exportCaption($this->expectedRpn);
					$doc->exportCaption($this->expectedClosureDate);
					$doc->exportCaption($this->recomendedActiondet);
					$doc->exportCaption($this->idResponsibleDet);
					$doc->exportCaption($this->targetDatedet);
					$doc->exportCaption($this->kcdet);
					$doc->exportCaption($this->expectedSeveritydet);
					$doc->exportCaption($this->expectedOccurrencedet);
					$doc->exportCaption($this->expectedDetectiondet);
					$doc->exportCaption($this->expectedRpndet);
					$doc->exportCaption($this->revisedClosureDatedet);
					$doc->exportCaption($this->revisedClosureDate);
					$doc->exportCaption($this->perfomedAction);
					$doc->exportCaption($this->revisedSeverity);
					$doc->exportCaption($this->revisedOccurrence);
					$doc->exportCaption($this->revisedDetection);
					$doc->exportCaption($this->revisedRpn);
				} else {
					$doc->exportCaption($this->fmea);
					$doc->exportCaption($this->idFactory);
					$doc->exportCaption($this->dateFmea);
					$doc->exportCaption($this->partnumbers);
					$doc->exportCaption($this->description);
					$doc->exportCaption($this->idEmployee);
					$doc->exportCaption($this->idworkcenter);
					$doc->exportCaption($this->idProcess);
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
					$doc->exportCaption($this->idCause);
					$doc->exportCaption($this->potentialCauses);
					$doc->exportCaption($this->currentPreventiveControlMethod);
					$doc->exportCaption($this->occurrence);
					$doc->exportCaption($this->currentControlMethod);
					$doc->exportCaption($this->detection);
					$doc->exportCaption($this->rpn);
					$doc->exportCaption($this->recomendedAction);
					$doc->exportCaption($this->idResponsible);
					$doc->exportCaption($this->targetDate);
					$doc->exportCaption($this->revisedKc);
					$doc->exportCaption($this->expectedSeverity);
					$doc->exportCaption($this->expectedOccurrence);
					$doc->exportCaption($this->expectedDetection);
					$doc->exportCaption($this->expectedRpn);
					$doc->exportCaption($this->expectedClosureDate);
					$doc->exportCaption($this->recomendedActiondet);
					$doc->exportCaption($this->idResponsibleDet);
					$doc->exportCaption($this->targetDatedet);
					$doc->exportCaption($this->kcdet);
					$doc->exportCaption($this->expectedSeveritydet);
					$doc->exportCaption($this->expectedOccurrencedet);
					$doc->exportCaption($this->expectedDetectiondet);
					$doc->exportCaption($this->expectedRpndet);
					$doc->exportCaption($this->revisedClosureDatedet);
					$doc->exportCaption($this->revisedClosureDate);
					$doc->exportCaption($this->perfomedAction);
					$doc->exportCaption($this->revisedSeverity);
					$doc->exportCaption($this->revisedOccurrence);
					$doc->exportCaption($this->revisedDetection);
					$doc->exportCaption($this->revisedRpn);
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
						$doc->exportField($this->idProcess);
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
						$doc->exportField($this->idCause);
						$doc->exportField($this->potentialCauses);
						$doc->exportField($this->currentPreventiveControlMethod);
						$doc->exportField($this->occurrence);
						$doc->exportField($this->currentControlMethod);
						$doc->exportField($this->detection);
						$doc->exportField($this->rpn);
						$doc->exportField($this->recomendedAction);
						$doc->exportField($this->idResponsible);
						$doc->exportField($this->targetDate);
						$doc->exportField($this->revisedKc);
						$doc->exportField($this->expectedSeverity);
						$doc->exportField($this->expectedOccurrence);
						$doc->exportField($this->expectedDetection);
						$doc->exportField($this->expectedRpn);
						$doc->exportField($this->expectedClosureDate);
						$doc->exportField($this->recomendedActiondet);
						$doc->exportField($this->idResponsibleDet);
						$doc->exportField($this->targetDatedet);
						$doc->exportField($this->kcdet);
						$doc->exportField($this->expectedSeveritydet);
						$doc->exportField($this->expectedOccurrencedet);
						$doc->exportField($this->expectedDetectiondet);
						$doc->exportField($this->expectedRpndet);
						$doc->exportField($this->revisedClosureDatedet);
						$doc->exportField($this->revisedClosureDate);
						$doc->exportField($this->perfomedAction);
						$doc->exportField($this->revisedSeverity);
						$doc->exportField($this->revisedOccurrence);
						$doc->exportField($this->revisedDetection);
						$doc->exportField($this->revisedRpn);
					} else {
						$doc->exportField($this->fmea);
						$doc->exportField($this->idFactory);
						$doc->exportField($this->dateFmea);
						$doc->exportField($this->partnumbers);
						$doc->exportField($this->description);
						$doc->exportField($this->idEmployee);
						$doc->exportField($this->idworkcenter);
						$doc->exportField($this->idProcess);
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
						$doc->exportField($this->idCause);
						$doc->exportField($this->potentialCauses);
						$doc->exportField($this->currentPreventiveControlMethod);
						$doc->exportField($this->occurrence);
						$doc->exportField($this->currentControlMethod);
						$doc->exportField($this->detection);
						$doc->exportField($this->rpn);
						$doc->exportField($this->recomendedAction);
						$doc->exportField($this->idResponsible);
						$doc->exportField($this->targetDate);
						$doc->exportField($this->revisedKc);
						$doc->exportField($this->expectedSeverity);
						$doc->exportField($this->expectedOccurrence);
						$doc->exportField($this->expectedDetection);
						$doc->exportField($this->expectedRpn);
						$doc->exportField($this->expectedClosureDate);
						$doc->exportField($this->recomendedActiondet);
						$doc->exportField($this->idResponsibleDet);
						$doc->exportField($this->targetDatedet);
						$doc->exportField($this->kcdet);
						$doc->exportField($this->expectedSeveritydet);
						$doc->exportField($this->expectedOccurrencedet);
						$doc->exportField($this->expectedDetectiondet);
						$doc->exportField($this->expectedRpndet);
						$doc->exportField($this->revisedClosureDatedet);
						$doc->exportField($this->revisedClosureDate);
						$doc->exportField($this->perfomedAction);
						$doc->exportField($this->revisedSeverity);
						$doc->exportField($this->revisedOccurrence);
						$doc->exportField($this->revisedDetection);
						$doc->exportField($this->revisedRpn);
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
		if ($this->rpn->CurrentValue!== NULL && $this->RPNCalc->CurrentValue !== "")
		{
			if ($this->rpn->CurrentValue > 140) $this->RPNCalc->CellAttrs["style"] = "background-color: red"; 
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>