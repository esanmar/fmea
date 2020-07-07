<?php
namespace PHPMaker2020\SupplierMapping;

/**
 * ChartTypes class
 */
class ChartTypes
{

	/**
	 * Supported chart types (for Chart.js)
	 * 
	 * Format - [chart_id, [normal_chart_name, scroll_chart_name]]
	 * chart_id - abnn
	 * **id = chart_id in previous version
	 * - a: 1 = Single Series, 2 = Multi Series, 3 = Stacked, 4 = Combination, 5 = Financial, 6 = Other
	 * - b: 0 = 2D, 1 = 3D
	 * - nn: 01 = Column, 02 = Line, 03 = Area, 04 = Bar, 05 = Pie, 06 = Doughnut
	 *
	 * @var array
	 */
	public static $Types = [

		// Single Series
		[1001, ["bar"]], // Column 2D (**1)
		[1101, ["bar"]], // Column 3D (**5) // NOT supported, revert to Column 2D
		[1002, ["line"]], // Line 2D (**4) // fill=false
		[1003, ["line"]], // Area 2D (**7)
		[1004, ["horizontalBar"]], // Bar 2D (**3)
		[1104, ["horizontalBar"]], // Bar 3D (**104) // NOT supported, revert to Bar 2D
		[1005, ["pie"]], // Pie 2D (**2)
		[1105, ["pie"]], // Pie 3D (**6) // NOT supported, revert to Pie 2D
		[1006, ["doughnut"]], // Doughnut 2D (**8)
		[1106, ["doughnut"]], // Doughnut 3D (**101) // NOT supported, revert to Dougnut 2D

		// Multi Series
		[2001, ["bar"]], // Multi-series Column 2D (**9)
		[2101, ["bar"]], // Multi-series Column 3D (**10) // NOT supported, revert to Column 2D
		[2002, ["line"]], // Multi-series Line 2D (**11) // fill=false
		[2003, ["line"]], // Multi-series Area 2D (**12)
		[2004, ["horizontalBar"]], // Multi-series Bar 2D (**13)
		[2104, ["horizontalBar"]], // Multi-series Bar 3D (**102) // NOT supported, revert to Bar 2D

		// Stacked
		[3001, ["bar"]], // Stacked Column 2D (**14)
		[3101, ["bar"]], // Stacked Column 3D (**15) // NOT supported, revert to Column 2D
		[3003, ["line"]], // Stacked Area 2D (**16)
		[3004, ["horizontalBar"]], // Stacked Bar 2D (**17)
		[3104, ["horizontalBar"]], // Stacked Bar 3D (**103) // NOT supported, revert to Bar 2D

		// Combination
		[4001, ["bar"]], // Multi-series 2D Single Y Combination Chart (Column + Line + Area) // Mixed, type in dataset
		[4101, ["bar"]], // Multi-series 3D Single Y Combination Chart (Column + Line + Area) // NOT supported, revert to 4001
		[4111, ["bar"]], // Multi-series Column 3D + Line - Single Y Axis // NOT supported, revert to 4001
		[4021, ["bar"]], // Stacked Column2D + Line single Y Axis // Mixed, type in dataset
		[4121, ["bar"]], // Stacked Column3D + Line single Y Axis // NOT supported, revert to 4021
		[4031, ["bar"]], // Multi-series 2D Dual Y Combination Chart (Column + Line + Area) (**18) // Mixed, type in dataset
		[4131, ["bar"]], // Multi-series Column 3D + Line - Dual Y Axis (**19) // NOT supported, revert to 4031
		[4141, ["bar"]] // Stacked Column 3D + Line Dual Y Axis // NOT supported, revert to 2D (Stacked Column 2D + Line Dual Y Axis)
	];

	/**
	 * Default type ID
	 *
	 * @var integer
	 */
	public static $DefaultType = 1001; // Default

	/**
	 * Get chart type name
	 *
	 * @param integer $id Chart type ID
	 * @param boolean $scroll Whether chart is scrollable
	 * @return string Chart type name
	 */
	public static function getName($id, $scroll = FALSE) {
		foreach (self::$Types as $type) {
			if ($id == $type[0])
				return ($scroll && count($type[1]) > 1) ? $type[1][1] : $type[1][0];
		}
		return "bar"; // Default
	}

	/**
	 * Get chart renderer class
	 *
	 * @param integer $id Chart type ID
	 * @return string Chart renderer class name
	 */
	public static function getRendererClass($id) {
		$cls = Config("DEFAULT_CHART_RENDERER") ?: "ChartJsRenderer";
		return PROJECT_NAMESPACE . $cls;
	}
}