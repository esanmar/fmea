<?php namespace PHPMaker2020\fmeaPRD; ?>
<?php

/**
 * Table class for KPI
 */
class KPI extends ReportTable
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
	public $ShowGroupHeaderAsRow = FALSE;
	public $ShowCompactSummaryFooter = TRUE;

	// Export
	public $ExportDoc;
	public $KPIFMEA;

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
		$this->TableVar = 'KPI';
		$this->TableName = 'KPI';
		$this->TableType = 'REPORT';

		// Update Table
		$this->UpdateTable = "`reportfmea`";
		$this->ReportSourceTable = 'reportfmea'; // Report source table
		$this->Dbid = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (report only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->UserIDAllowSecurity = 0; // User ID Allow

		// fmea
		$this->fmea = new ReportField('KPI', 'KPI', 'x_fmea', 'fmea', '`fmea`', '`fmea`', 200, 255, -1, FALSE, '`fmea`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->fmea->GroupingFieldId = 1;
		$this->fmea->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->fmea->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fmea->GroupByType = "";
		$this->fmea->GroupInterval = "0";
		$this->fmea->GroupSql = "";
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
		$this->fmea->AdvancedSearch->SearchValueDefault = INIT_VALUE;
		$this->fmea->SourceTableVar = 'reportfmea';
		$this->fields['fmea'] = &$this->fmea;

		// idFactory
		$this->idFactory = new ReportField('KPI', 'KPI', 'x_idFactory', 'idFactory', '`idFactory`', '`idFactory`', 200, 50, -1, FALSE, '`idFactory`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
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
		$this->idFactory->AdvancedSearch->SearchValueDefault = INIT_VALUE;
		$this->idFactory->SourceTableVar = 'reportfmea';
		$this->fields['idFactory'] = &$this->idFactory;

		// dateFmea
		$this->dateFmea = new ReportField('KPI', 'KPI', 'x_dateFmea', 'dateFmea', '`dateFmea`', CastDateFieldForLike("`dateFmea`", 0, "DB"), 135, 19, 0, FALSE, '`dateFmea`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dateFmea->Sortable = TRUE; // Allow sort
		$this->dateFmea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->dateFmea->SourceTableVar = 'reportfmea';
		$this->fields['dateFmea'] = &$this->dateFmea;

		// partnumbers
		$this->partnumbers = new ReportField('KPI', 'KPI', 'x_partnumbers', 'partnumbers', '`partnumbers`', '`partnumbers`', 201, -1, -1, FALSE, '`partnumbers`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->partnumbers->Sortable = TRUE; // Allow sort
		$this->partnumbers->SourceTableVar = 'reportfmea';
		$this->fields['partnumbers'] = &$this->partnumbers;

		// description
		$this->description = new ReportField('KPI', 'KPI', 'x_description', 'description', '`description`', '`description`', 201, -1, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->description->SourceTableVar = 'reportfmea';
		$this->fields['description'] = &$this->description;

		// idEmployee
		$this->idEmployee = new ReportField('KPI', 'KPI', 'x_idEmployee', 'idEmployee', '`idEmployee`', '`idEmployee`', 200, 50, -1, FALSE, '`EV__idEmployee`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
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
		$this->idEmployee->AdvancedSearch->SearchValueDefault = INIT_VALUE;
		$this->idEmployee->SourceTableVar = 'reportfmea';
		$this->fields['idEmployee'] = &$this->idEmployee;

		// idworkcenter
		$this->idworkcenter = new ReportField('KPI', 'KPI', 'x_idworkcenter', 'idworkcenter', '`idworkcenter`', '`idworkcenter`', 200, 150, -1, FALSE, '`idworkcenter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idworkcenter->Sortable = TRUE; // Allow sort
		$this->idworkcenter->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idworkcenter->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "en":
				$this->idworkcenter->Lookup = new Lookup('idworkcenter', 'workcenters', FALSE, 'workcenter', ["workcenter","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idworkcenter->Lookup = new Lookup('idworkcenter', 'workcenters', FALSE, 'workcenter', ["workcenter","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idworkcenter->AdvancedSearch->SearchValueDefault = INIT_VALUE;
		$this->idworkcenter->SourceTableVar = 'reportfmea';
		$this->fields['idworkcenter'] = &$this->idworkcenter;

		// idProcess
		$this->idProcess = new ReportField('KPI', 'KPI', 'x_idProcess', 'idProcess', '`idProcess`', '`idProcess`', 3, 11, -1, FALSE, '`idProcess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idProcess->Nullable = FALSE; // NOT NULL field
		$this->idProcess->Required = TRUE; // Required field
		$this->idProcess->Sortable = TRUE; // Allow sort
		$this->idProcess->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->idProcess->SourceTableVar = 'reportfmea';
		$this->fields['idProcess'] = &$this->idProcess;

		// step
		$this->step = new ReportField('KPI', 'KPI', 'x_step', 'step', '`step`', '`step`', 3, 11, -1, FALSE, '`step`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->step->Sortable = TRUE; // Allow sort
		$this->step->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->step->SourceTableVar = 'reportfmea';
		$this->fields['step'] = &$this->step;

		// flowchartDesc
		$this->flowchartDesc = new ReportField('KPI', 'KPI', 'x_flowchartDesc', 'flowchartDesc', '`flowchartDesc`', '`flowchartDesc`', 201, -1, -1, FALSE, '`flowchartDesc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->flowchartDesc->Sortable = TRUE; // Allow sort
		$this->flowchartDesc->SourceTableVar = 'reportfmea';
		$this->fields['flowchartDesc'] = &$this->flowchartDesc;

		// partnumber
		$this->partnumber = new ReportField('KPI', 'KPI', 'x_partnumber', 'partnumber', '`partnumber`', '`partnumber`', 200, 255, -1, FALSE, '`partnumber`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->partnumber->Sortable = TRUE; // Allow sort
		$this->partnumber->SourceTableVar = 'reportfmea';
		$this->fields['partnumber'] = &$this->partnumber;

		// operation
		$this->operation = new ReportField('KPI', 'KPI', 'x_operation', 'operation', '`operation`', '`operation`', 200, 255, -1, FALSE, '`operation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->operation->Sortable = TRUE; // Allow sort
		$this->operation->SourceTableVar = 'reportfmea';
		$this->fields['operation'] = &$this->operation;

		// derivedFromNC
		$this->derivedFromNC = new ReportField('KPI', 'KPI', 'x_derivedFromNC', 'derivedFromNC', '`derivedFromNC`', '`derivedFromNC`', 202, 1, -1, FALSE, '`derivedFromNC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->derivedFromNC->Sortable = TRUE; // Allow sort
		$this->derivedFromNC->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->derivedFromNC->Lookup = new Lookup('derivedFromNC', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->derivedFromNC->Lookup = new Lookup('derivedFromNC', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->derivedFromNC->OptionCount = 2;
		$this->derivedFromNC->SourceTableVar = 'reportfmea';
		$this->fields['derivedFromNC'] = &$this->derivedFromNC;

		// numberOfNC
		$this->numberOfNC = new ReportField('KPI', 'KPI', 'x_numberOfNC', 'numberOfNC', '`numberOfNC`', '`numberOfNC`', 200, 255, -1, FALSE, '`numberOfNC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->numberOfNC->Sortable = TRUE; // Allow sort
		$this->numberOfNC->SourceTableVar = 'reportfmea';
		$this->fields['numberOfNC'] = &$this->numberOfNC;

		// flowchart
		$this->flowchart = new ReportField('KPI', 'KPI', 'x_flowchart', 'flowchart', '`flowchart`', '`flowchart`', 200, 255, -1, FALSE, '`flowchart`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->flowchart->Sortable = TRUE; // Allow sort
		$this->flowchart->SourceTableVar = 'reportfmea';
		$this->fields['flowchart'] = &$this->flowchart;

		// subprocess
		$this->subprocess = new ReportField('KPI', 'KPI', 'x_subprocess', 'subprocess', '`subprocess`', '`subprocess`', 200, 255, -1, FALSE, '`subprocess`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->subprocess->Sortable = TRUE; // Allow sort
		$this->subprocess->SourceTableVar = 'reportfmea';
		$this->fields['subprocess'] = &$this->subprocess;

		// requirement
		$this->requirement = new ReportField('KPI', 'KPI', 'x_requirement', 'requirement', '`requirement`', '`requirement`', 200, 255, -1, FALSE, '`requirement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->requirement->Sortable = TRUE; // Allow sort
		$this->requirement->SourceTableVar = 'reportfmea';
		$this->fields['requirement'] = &$this->requirement;

		// potencialFailureMode
		$this->potencialFailureMode = new ReportField('KPI', 'KPI', 'x_potencialFailureMode', 'potencialFailureMode', '`potencialFailureMode`', '`potencialFailureMode`', 200, 255, -1, FALSE, '`potencialFailureMode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->potencialFailureMode->Sortable = TRUE; // Allow sort
		$this->potencialFailureMode->SourceTableVar = 'reportfmea';
		$this->fields['potencialFailureMode'] = &$this->potencialFailureMode;

		// potencialFailurEffect
		$this->potencialFailurEffect = new ReportField('KPI', 'KPI', 'x_potencialFailurEffect', 'potencialFailurEffect', '`potencialFailurEffect`', '`potencialFailurEffect`', 200, 255, -1, FALSE, '`potencialFailurEffect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->potencialFailurEffect->Sortable = TRUE; // Allow sort
		$this->potencialFailurEffect->SourceTableVar = 'reportfmea';
		$this->fields['potencialFailurEffect'] = &$this->potencialFailurEffect;

		// kc
		$this->kc = new ReportField('KPI', 'KPI', 'x_kc', 'kc', '`kc`', '`kc`', 202, 1, -1, FALSE, '`kc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->kc->Sortable = TRUE; // Allow sort
		$this->kc->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->kc->Lookup = new Lookup('kc', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->kc->Lookup = new Lookup('kc', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->kc->OptionCount = 2;
		$this->kc->SourceTableVar = 'reportfmea';
		$this->fields['kc'] = &$this->kc;

		// severity
		$this->severity = new ReportField('KPI', 'KPI', 'x_severity', 'severity', '`severity`', '`severity`', 3, 11, -1, FALSE, '`severity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->severity->Sortable = TRUE; // Allow sort
		$this->severity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->severity->SourceTableVar = 'reportfmea';
		$this->fields['severity'] = &$this->severity;

		// idCause
		$this->idCause = new ReportField('KPI', 'KPI', 'x_idCause', 'idCause', '`idCause`', '`idCause`', 200, 50, -1, FALSE, '`idCause`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idCause->IsPrimaryKey = TRUE; // Primary key field
		$this->idCause->Nullable = FALSE; // NOT NULL field
		$this->idCause->Required = TRUE; // Required field
		$this->idCause->Sortable = TRUE; // Allow sort
		$this->idCause->SourceTableVar = 'reportfmea';
		$this->fields['idCause'] = &$this->idCause;

		// potentialCauses
		$this->potentialCauses = new ReportField('KPI', 'KPI', 'x_potentialCauses', 'potentialCauses', '`potentialCauses`', '`potentialCauses`', 201, -1, -1, FALSE, '`potentialCauses`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->potentialCauses->Sortable = TRUE; // Allow sort
		$this->potentialCauses->SourceTableVar = 'reportfmea';
		$this->fields['potentialCauses'] = &$this->potentialCauses;

		// currentPreventiveControlMethod
		$this->currentPreventiveControlMethod = new ReportField('KPI', 'KPI', 'x_currentPreventiveControlMethod', 'currentPreventiveControlMethod', '`currentPreventiveControlMethod`', '`currentPreventiveControlMethod`', 200, 255, -1, FALSE, '`currentPreventiveControlMethod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currentPreventiveControlMethod->Sortable = TRUE; // Allow sort
		$this->currentPreventiveControlMethod->SourceTableVar = 'reportfmea';
		$this->fields['currentPreventiveControlMethod'] = &$this->currentPreventiveControlMethod;

		// occurrence
		$this->occurrence = new ReportField('KPI', 'KPI', 'x_occurrence', 'occurrence', '`occurrence`', '`occurrence`', 3, 11, -1, FALSE, '`occurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->occurrence->Sortable = TRUE; // Allow sort
		$this->occurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->occurrence->SourceTableVar = 'reportfmea';
		$this->fields['occurrence'] = &$this->occurrence;

		// currentControlMethod
		$this->currentControlMethod = new ReportField('KPI', 'KPI', 'x_currentControlMethod', 'currentControlMethod', '`currentControlMethod`', '`currentControlMethod`', 200, 255, -1, FALSE, '`currentControlMethod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currentControlMethod->Sortable = TRUE; // Allow sort
		$this->currentControlMethod->SourceTableVar = 'reportfmea';
		$this->fields['currentControlMethod'] = &$this->currentControlMethod;

		// detection
		$this->detection = new ReportField('KPI', 'KPI', 'x_detection', 'detection', '`detection`', '`detection`', 3, 11, -1, FALSE, '`detection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detection->Sortable = TRUE; // Allow sort
		$this->detection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->detection->SourceTableVar = 'reportfmea';
		$this->fields['detection'] = &$this->detection;

		// rpn
		$this->rpn = new ReportField('KPI', 'KPI', 'x_rpn', 'rpn', '`rpn`', '`rpn`', 3, 11, -1, FALSE, '`rpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rpn->Sortable = TRUE; // Allow sort
		$this->rpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->rpn->SourceTableVar = 'reportfmea';
		$this->fields['rpn'] = &$this->rpn;

		// recomendedAction
		$this->recomendedAction = new ReportField('KPI', 'KPI', 'x_recomendedAction', 'recomendedAction', '`recomendedAction`', '`recomendedAction`', 201, -1, -1, FALSE, '`recomendedAction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->recomendedAction->Sortable = TRUE; // Allow sort
		$this->recomendedAction->SourceTableVar = 'reportfmea';
		$this->fields['recomendedAction'] = &$this->recomendedAction;

		// idResponsible
		$this->idResponsible = new ReportField('KPI', 'KPI', 'x_idResponsible', 'idResponsible', '`idResponsible`', '`idResponsible`', 200, 50, -1, FALSE, '`EV__idResponsible`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idResponsible->Sortable = TRUE; // Allow sort
		$this->idResponsible->SelectMultiple = TRUE; // Multiple select
		switch ($CurrentLanguage) {
			case "en":
				$this->idResponsible->Lookup = new Lookup('idResponsible', 'employees', TRUE, 'name', ["surname","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idResponsible->Lookup = new Lookup('idResponsible', 'employees', TRUE, 'name', ["surname","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idResponsible->SourceTableVar = 'reportfmea';
		$this->fields['idResponsible'] = &$this->idResponsible;

		// targetDate
		$this->targetDate = new ReportField('KPI', 'KPI', 'x_targetDate', 'targetDate', '`targetDate`', CastDateFieldForLike("`targetDate`", 0, "DB"), 135, 19, 0, FALSE, '`targetDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->targetDate->Sortable = TRUE; // Allow sort
		$this->targetDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->targetDate->SourceTableVar = 'reportfmea';
		$this->fields['targetDate'] = &$this->targetDate;

		// revisedKc
		$this->revisedKc = new ReportField('KPI', 'KPI', 'x_revisedKc', 'revisedKc', '`revisedKc`', '`revisedKc`', 202, 1, -1, FALSE, '`revisedKc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->revisedKc->Sortable = TRUE; // Allow sort
		$this->revisedKc->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->revisedKc->Lookup = new Lookup('revisedKc', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->revisedKc->Lookup = new Lookup('revisedKc', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->revisedKc->OptionCount = 2;
		$this->revisedKc->SourceTableVar = 'reportfmea';
		$this->fields['revisedKc'] = &$this->revisedKc;

		// expectedSeverity
		$this->expectedSeverity = new ReportField('KPI', 'KPI', 'x_expectedSeverity', 'expectedSeverity', '`expectedSeverity`', '`expectedSeverity`', 3, 11, -1, FALSE, '`expectedSeverity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedSeverity->Sortable = TRUE; // Allow sort
		$this->expectedSeverity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedSeverity->SourceTableVar = 'reportfmea';
		$this->fields['expectedSeverity'] = &$this->expectedSeverity;

		// expectedOccurrence
		$this->expectedOccurrence = new ReportField('KPI', 'KPI', 'x_expectedOccurrence', 'expectedOccurrence', '`expectedOccurrence`', '`expectedOccurrence`', 3, 11, -1, FALSE, '`expectedOccurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedOccurrence->Sortable = TRUE; // Allow sort
		$this->expectedOccurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedOccurrence->SourceTableVar = 'reportfmea';
		$this->fields['expectedOccurrence'] = &$this->expectedOccurrence;

		// expectedDetection
		$this->expectedDetection = new ReportField('KPI', 'KPI', 'x_expectedDetection', 'expectedDetection', '`expectedDetection`', '`expectedDetection`', 3, 11, -1, FALSE, '`expectedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedDetection->Sortable = TRUE; // Allow sort
		$this->expectedDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedDetection->SourceTableVar = 'reportfmea';
		$this->fields['expectedDetection'] = &$this->expectedDetection;

		// expectedRpn
		$this->expectedRpn = new ReportField('KPI', 'KPI', 'x_expectedRpn', 'expectedRpn', '`expectedRpn`', '`expectedRpn`', 3, 11, -1, FALSE, '`expectedRpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRpn->Sortable = TRUE; // Allow sort
		$this->expectedRpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedRpn->SourceTableVar = 'reportfmea';
		$this->fields['expectedRpn'] = &$this->expectedRpn;

		// expectedClosureDate
		$this->expectedClosureDate = new ReportField('KPI', 'KPI', 'x_expectedClosureDate', 'expectedClosureDate', '`expectedClosureDate`', CastDateFieldForLike("`expectedClosureDate`", 0, "DB"), 135, 19, 0, FALSE, '`expectedClosureDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedClosureDate->Sortable = TRUE; // Allow sort
		$this->expectedClosureDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->expectedClosureDate->SourceTableVar = 'reportfmea';
		$this->fields['expectedClosureDate'] = &$this->expectedClosureDate;

		// recomendedActiondet
		$this->recomendedActiondet = new ReportField('KPI', 'KPI', 'x_recomendedActiondet', 'recomendedActiondet', '`recomendedActiondet`', '`recomendedActiondet`', 201, -1, -1, FALSE, '`recomendedActiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->recomendedActiondet->Sortable = TRUE; // Allow sort
		$this->recomendedActiondet->SourceTableVar = 'reportfmea';
		$this->fields['recomendedActiondet'] = &$this->recomendedActiondet;

		// idResponsibleDet
		$this->idResponsibleDet = new ReportField('KPI', 'KPI', 'x_idResponsibleDet', 'idResponsibleDet', '`idResponsibleDet`', '`idResponsibleDet`', 200, 50, -1, FALSE, '`EV__idResponsibleDet`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idResponsibleDet->Sortable = TRUE; // Allow sort
		$this->idResponsibleDet->SelectMultiple = TRUE; // Multiple select
		switch ($CurrentLanguage) {
			case "en":
				$this->idResponsibleDet->Lookup = new Lookup('idResponsibleDet', 'employees', TRUE, 'name', ["surname","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idResponsibleDet->Lookup = new Lookup('idResponsibleDet', 'employees', TRUE, 'name', ["surname","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idResponsibleDet->SourceTableVar = 'reportfmea';
		$this->fields['idResponsibleDet'] = &$this->idResponsibleDet;

		// targetDatedet
		$this->targetDatedet = new ReportField('KPI', 'KPI', 'x_targetDatedet', 'targetDatedet', '`targetDatedet`', CastDateFieldForLike("`targetDatedet`", 0, "DB"), 135, 19, 0, FALSE, '`targetDatedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->targetDatedet->Sortable = TRUE; // Allow sort
		$this->targetDatedet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->targetDatedet->SourceTableVar = 'reportfmea';
		$this->fields['targetDatedet'] = &$this->targetDatedet;

		// kcdet
		$this->kcdet = new ReportField('KPI', 'KPI', 'x_kcdet', 'kcdet', '`kcdet`', '`kcdet`', 202, 1, -1, FALSE, '`kcdet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->kcdet->Sortable = TRUE; // Allow sort
		$this->kcdet->DataType = DATATYPE_BOOLEAN;
		switch ($CurrentLanguage) {
			case "en":
				$this->kcdet->Lookup = new Lookup('kcdet', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->kcdet->Lookup = new Lookup('kcdet', 'KPI', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->kcdet->OptionCount = 2;
		$this->kcdet->SourceTableVar = 'reportfmea';
		$this->fields['kcdet'] = &$this->kcdet;

		// expectedSeveritydet
		$this->expectedSeveritydet = new ReportField('KPI', 'KPI', 'x_expectedSeveritydet', 'expectedSeveritydet', '`expectedSeveritydet`', '`expectedSeveritydet`', 3, 11, -1, FALSE, '`expectedSeveritydet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedSeveritydet->Sortable = TRUE; // Allow sort
		$this->expectedSeveritydet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedSeveritydet->SourceTableVar = 'reportfmea';
		$this->fields['expectedSeveritydet'] = &$this->expectedSeveritydet;

		// expectedOccurrencedet
		$this->expectedOccurrencedet = new ReportField('KPI', 'KPI', 'x_expectedOccurrencedet', 'expectedOccurrencedet', '`expectedOccurrencedet`', '`expectedOccurrencedet`', 3, 11, -1, FALSE, '`expectedOccurrencedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedOccurrencedet->Sortable = TRUE; // Allow sort
		$this->expectedOccurrencedet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedOccurrencedet->SourceTableVar = 'reportfmea';
		$this->fields['expectedOccurrencedet'] = &$this->expectedOccurrencedet;

		// expectedDetectiondet
		$this->expectedDetectiondet = new ReportField('KPI', 'KPI', 'x_expectedDetectiondet', 'expectedDetectiondet', '`expectedDetectiondet`', '`expectedDetectiondet`', 3, 11, -1, FALSE, '`expectedDetectiondet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedDetectiondet->Sortable = TRUE; // Allow sort
		$this->expectedDetectiondet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedDetectiondet->SourceTableVar = 'reportfmea';
		$this->fields['expectedDetectiondet'] = &$this->expectedDetectiondet;

		// expectedRpndet
		$this->expectedRpndet = new ReportField('KPI', 'KPI', 'x_expectedRpndet', 'expectedRpndet', '`expectedRpndet`', '`expectedRpndet`', 3, 11, -1, FALSE, '`expectedRpndet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->expectedRpndet->Sortable = TRUE; // Allow sort
		$this->expectedRpndet->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->expectedRpndet->SourceTableVar = 'reportfmea';
		$this->fields['expectedRpndet'] = &$this->expectedRpndet;

		// revisedClosureDatedet
		$this->revisedClosureDatedet = new ReportField('KPI', 'KPI', 'x_revisedClosureDatedet', 'revisedClosureDatedet', '`revisedClosureDatedet`', CastDateFieldForLike("`revisedClosureDatedet`", 0, "DB"), 135, 19, 0, FALSE, '`revisedClosureDatedet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedClosureDatedet->Sortable = TRUE; // Allow sort
		$this->revisedClosureDatedet->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->revisedClosureDatedet->SourceTableVar = 'reportfmea';
		$this->fields['revisedClosureDatedet'] = &$this->revisedClosureDatedet;

		// revisedClosureDate
		$this->revisedClosureDate = new ReportField('KPI', 'KPI', 'x_revisedClosureDate', 'revisedClosureDate', '`revisedClosureDate`', CastDateFieldForLike("`revisedClosureDate`", 0, "DB"), 135, 19, 0, FALSE, '`revisedClosureDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedClosureDate->Sortable = TRUE; // Allow sort
		$this->revisedClosureDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->revisedClosureDate->SourceTableVar = 'reportfmea';
		$this->fields['revisedClosureDate'] = &$this->revisedClosureDate;

		// perfomedAction
		$this->perfomedAction = new ReportField('KPI', 'KPI', 'x_perfomedAction', 'perfomedAction', '`perfomedAction`', '`perfomedAction`', 201, -1, -1, FALSE, '`perfomedAction`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->perfomedAction->Sortable = TRUE; // Allow sort
		$this->perfomedAction->SourceTableVar = 'reportfmea';
		$this->fields['perfomedAction'] = &$this->perfomedAction;

		// revisedSeverity
		$this->revisedSeverity = new ReportField('KPI', 'KPI', 'x_revisedSeverity', 'revisedSeverity', '`revisedSeverity`', '`revisedSeverity`', 3, 11, -1, FALSE, '`revisedSeverity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedSeverity->Sortable = TRUE; // Allow sort
		$this->revisedSeverity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->revisedSeverity->SourceTableVar = 'reportfmea';
		$this->fields['revisedSeverity'] = &$this->revisedSeverity;

		// revisedOccurrence
		$this->revisedOccurrence = new ReportField('KPI', 'KPI', 'x_revisedOccurrence', 'revisedOccurrence', '`revisedOccurrence`', '`revisedOccurrence`', 3, 11, -1, FALSE, '`revisedOccurrence`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedOccurrence->Sortable = TRUE; // Allow sort
		$this->revisedOccurrence->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->revisedOccurrence->SourceTableVar = 'reportfmea';
		$this->fields['revisedOccurrence'] = &$this->revisedOccurrence;

		// revisedDetection
		$this->revisedDetection = new ReportField('KPI', 'KPI', 'x_revisedDetection', 'revisedDetection', '`revisedDetection`', '`revisedDetection`', 3, 11, -1, FALSE, '`revisedDetection`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedDetection->Sortable = TRUE; // Allow sort
		$this->revisedDetection->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->revisedDetection->SourceTableVar = 'reportfmea';
		$this->fields['revisedDetection'] = &$this->revisedDetection;

		// revisedRpn
		$this->revisedRpn = new ReportField('KPI', 'KPI', 'x_revisedRpn', 'revisedRpn', '`revisedRpn`', '`revisedRpn`', 3, 11, -1, FALSE, '`revisedRpn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->revisedRpn->Sortable = TRUE; // Allow sort
		$this->revisedRpn->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->revisedRpn->SourceTableVar = 'reportfmea';
		$this->fields['revisedRpn'] = &$this->revisedRpn;

		// KPIFMEA
		$this->KPIFMEA = new DbChart($this, 'KPIFMEA', 'KPIFMEA', 'fmea', 'idProcess', 1001, '', 0, 'COUNT', 400, 400);
		$this->KPIFMEA->SortType = 0;
		$this->KPIFMEA->SortSequence = "";
		$this->KPIFMEA->SqlSelect = "SELECT `fmea`, '', COUNT(`idProcess`) FROM ";
		$this->KPIFMEA->SqlGroupBy = "`fmea`";
		$this->KPIFMEA->SqlOrderBy = "";
		$this->KPIFMEA->SeriesDateType = "";
		$this->KPIFMEA->ID = "KPI_KPIFMEA"; // Chart ID
		$this->KPIFMEA->setParameters([
			["type", "1001"],
			["seriestype", "0"]
		]); // Chart type / Chart series type
		$this->KPIFMEA->setParameters([
			["caption", $this->KPIFMEA->caption()],
			["xaxisname", $this->KPIFMEA->xAxisName()]
		]); // Chart caption / X axis name
		$this->KPIFMEA->setParameter("yaxisname", $this->KPIFMEA->yAxisName()); // Y axis name
		$this->KPIFMEA->setParameters([
			["shownames", "1"],
			["showvalues", "1"],
			["showhovercap", "1"]
		]); // Show names / Show values / Show hover
		$this->KPIFMEA->setParameter("alpha", "50"); // Chart alpha
		$this->KPIFMEA->setParameter("colorpalette", "#5899DA,#E8743B,#19A979,#ED4A7B,#945ECF,#13A4B4,#525DF4,#BF399E,#6C8893,#EE6868,#2F6497"); // Chart color palette
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Multiple column sort
	protected function updateSort(&$fld, $ctrl)
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
			if ($fld->GroupingFieldId == 0) {
				if ($ctrl) {
					$orderBy = $this->getDetailOrderBy();
					if (strpos($orderBy, $sortField . " " . $lastSort) !== FALSE) {
						$orderBy = str_replace($sortField . " " . $lastSort, $sortField . " " . $thisSort, $orderBy);
					} else {
						if ($orderBy != "") $orderBy .= ", ";
						$orderBy .= $sortField . " " . $thisSort;
					}
					$this->setDetailOrderBy($orderBy); // Save to Session
				} else {
					$this->setDetailOrderBy($sortField . " " . $thisSort); // Save to Session
				}
			}
		} else {
			if ($fld->GroupingFieldId == 0 && !$ctrl) $fld->setSort("");
		}
	}

	// Get Sort SQL
	protected function sortSql()
	{
		$dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = [];
		foreach ($this->fields as $fld) {
			if ($fld->getSort() != "") {
				$fldsql = $fld->Expression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->GroupSql != "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sortSql = "";
		foreach ($argrps as $grp) {
			if ($sortSql != "") $sortSql .= ", ";
			$sortSql .= $grp;
		}
		if ($dtlSortSql != "") {
			if ($sortSql != "") $sortSql .= ", ";
			$sortSql .= $dtlSortSql;
		}
		return $sortSql;
	}

	// Table Level Group SQL
	private $_sqlFirstGroupField = "";
	private $_sqlSelectGroup = "";
	private $_sqlOrderByGroup = "";

	// First Group Field
	public function getSqlFirstGroupField($alias = FALSE)
	{
		if ($this->_sqlFirstGroupField != "")
			return $this->_sqlFirstGroupField;
		$firstGroupField = &$this->fmea;
		$expr = $firstGroupField->Expression;
		if ($firstGroupField->GroupSql != "") {
			$expr = str_replace("%s", $firstGroupField->Expression, $firstGroupField->GroupSql);
			if ($alias)
				$expr .= " AS " . QuotedName($firstGroupField->getGroupName(), $this->Dbid);
		}
		return $expr;
	}
	public function setSqlFirstGroupField($v)
	{
		$this->_sqlFirstGroupField = $v;
	}

	// Select Group
	public function getSqlSelectGroup()
	{
		return ($this->_sqlSelectGroup != "") ? $this->_sqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField(TRUE) . " FROM " . $this->getSqlFrom();
	}
	public function setSqlSelectGroup($v)
	{
		$this->_sqlSelectGroup = $v;
	}

	// Order By Group
	public function getSqlOrderByGroup()
	{
		if ($this->_sqlOrderByGroup != "")
			return $this->_sqlOrderByGroup;
		return $this->getSqlFirstGroupField() . " ASC";
	}
	public function setSqlOrderByGroup($v)
	{
		$this->_sqlOrderByGroup = $v;
	}

	// Summary properties
	private $_sqlSelectAggregate = "";
	private $_sqlAggregatePrefix = "";
	private $_sqlAggregateSuffix = "";
	private $_sqlSelectCount = "";

	// Select Aggregate
	public function getSqlSelectAggregate()
	{
		return ($this->_sqlSelectAggregate != "") ? $this->_sqlSelectAggregate : "SELECT COUNT(*) AS `cnt_idcause` FROM " . $this->getSqlFrom();
	}
	public function setSqlSelectAggregate($v)
	{
		$this->_sqlSelectAggregate = $v;
	}

	// Aggregate Prefix
	public function getSqlAggregatePrefix()
	{
		return ($this->_sqlAggregatePrefix != "") ? $this->_sqlAggregatePrefix : "";
	}
	public function setSqlAggregatePrefix($v)
	{
		$this->_sqlAggregatePrefix = $v;
	}

	// Aggregate Suffix
	public function getSqlAggregateSuffix()
	{
		return ($this->_sqlAggregateSuffix != "") ? $this->_sqlAggregateSuffix : "";
	}
	public function setSqlAggregateSuffix($v)
	{
		$this->_sqlAggregateSuffix = $v;
	}

	// Select Count
	public function getSqlSelectCount()
	{
		return ($this->_sqlSelectCount != "") ? $this->_sqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}
	public function setSqlSelectCount($v)
	{
		$this->_sqlSelectCount = $v;
	}

	// Render for lookup
	public function renderLookup()
	{
		$this->fmea->ViewValue = GetDropDownDisplayValue($this->fmea->CurrentValue, "", 0);
		$this->idFactory->ViewValue = GetDropDownDisplayValue($this->idFactory->CurrentValue, "", 0);
		$this->dateFmea->ViewValue = FormatDateTime($this->dateFmea->CurrentValue, 0);
		$this->partnumbers->ViewValue = $this->partnumbers->CurrentValue;
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->idEmployee->ViewValue = GetDropDownDisplayValue($this->idEmployee->CurrentValue, "", 0);
		$this->idworkcenter->ViewValue = GetDropDownDisplayValue($this->idworkcenter->CurrentValue, "", 0);
		$this->flowchartDesc->ViewValue = $this->flowchartDesc->CurrentValue;
		$this->partnumber->ViewValue = $this->partnumber->CurrentValue;
		$this->operation->ViewValue = $this->operation->CurrentValue;
		$this->severity->ViewValue = $this->severity->CurrentValue;
		$this->idCause->ViewValue = $this->idCause->CurrentValue;
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
		if ($this->SqlSelect != "")
			return $this->SqlSelect;
		$select = "*";
		$groupField = &$this->fmea;
		if ($groupField->GroupSql != "") {
			$expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
			$select .= ", " . $expr;
		}
		return "SELECT " . $select . " FROM " . $this->getSqlFrom();
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
			"SELECT *, (SELECT DISTINCT `surname` FROM `employees` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`name` = `KPI`.`idResponsible` LIMIT 1) AS `EV__idResponsible` FROM `reportfmea`" .
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
			return "";
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
		if ($pageName == "")
			return $Language->phrase("View");
		elseif ($pageName == "")
			return $Language->phrase("Edit");
		elseif ($pageName == "")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "?" . $this->getUrlParm($parm);
		else
			$url = "";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("", $this->getUrlParm($parm));
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
		$url = $this->keyUrl("", $this->getUrlParm($parm));
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
		return $this->keyUrl("", $this->getUrlParm());
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
		global $DashboardReport;
		if ($this->CurrentAction || $this->isExport() ||
			$this->DrillDown || $DashboardReport ||
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

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0)
	{

		// No binary fields
		return FALSE;
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