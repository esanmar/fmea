<?php
namespace PHPMaker2020\SupplierMapping;

/**
 * Chart.js renderer
 */
class ChartJsRenderer implements IChartRenderer
{
	public $Chart;
	public $Data;
	public $Options;
	static $DefaultWidth = 600;
	static $DefaultHeight = 500;

	// Constructor
	public function __construct($chart)
	{
		$this->Chart = $chart;
	}

	// Get chart Canvas
	public function getContainer($width, $height)
	{
		$id = $this->Chart->ID; // Chart ID
		return '<div id="div_' . $id . '" class="ew-chart-container"><canvas id="chart_' . $id . '" width="' . $width . '" height="' . $height . '" class="ew-chart-canvas"></canvas></div>';
	}

	// Get chart JavaScript
	public function getScript($width, $height)
	{
		$drilldown = $this->Chart->DrillDownInPanel;
		$typ = $this->Chart->Type ?: ChartTypes::$DefaultType; // Chart type (nnnn)
		$id = $this->Chart->ID; // Chart ID

		// $scroll = $this->Chart->ScrollChart; // Not supported
		// $trends = $this->Chart->Trends;
		// $series = $this->Chart->Series;
		// $align = $this->Chart->Align;

		$chartType = ChartTypes::getName($typ); // Chart type name
		$canvasId = "chart_" . $id;
		$this->loadChart();
		$chartData = ["type" => $chartType, "data" => $this->Data, "options" => $this->Options];
		$chartJson = JsonEncode($chartData);

		// Output JavaScript for Chart.js
		$dataformat = $this->Chart->DataFormat;
		$chartid = "chart_$id" . ($drilldown ? "_" . Random() : "");
		$obj = $drilldown ? "drillDownCharts" : "exportCharts";
		$drilldownAction = "";
		if ($this->Chart->DrillDownUrl != "") {
			if ($this->Chart->UseDrillDownPanel)
				$drilldownAction = "ew.showDrillDown(null, canvas, link.url, link.id, link.hdr);";
			else
				$drilldownAction = 'ew.redirect(link.url, null, "get");';
		}
		$wrk = <<<CHARTJS
<script>
loadjs.ready("head", function() {
	var canvas = document.getElementById("$canvasId"),
		json = $chartJson;
	if (json.data && json.data.datasets.length > 0) { 
		json.options.onHover = function(e) {
			var el = this.getElementAtEvent(e);
			e.target.style.cursor = (el.length) ? "pointer" : "default";
		};
		json.options = jQuery.extend(true, {}, ew.chartJsOptions, json.options); // Deep merge
		var args = { id: "$canvasId", ctx: canvas, config: json };
		jQuery(document).trigger("chart", [args]);
		var chart = new Chart(args.ctx, args.config);
		if (ew.DEBUG)
			console.log(args.config);
		args.ctx.onclick = function(e) {
			var activePoints = chart.getElementsAtEvent(e);
			if (activePoints[0]) {
				var chartData = activePoints[0]["_chart"].config.data,
					idx = activePoints[0]["_index"],
					links = chartData.datasets[0].links,
					link = Array.isArray(links) ? links[idx] : {};
				{$drilldownAction}
			}
		}
		window.exportCharts["chart_$id"] = chart; // Export chart
	} else {
		canvas.classList.add("d-none");
	}
});
</script>
CHARTJS;

		// Show data for debug
		if (Config("DEBUG")) {
			$chartJson = json_encode(json_decode(ConvertToUtf8($chartJson)), JSON_PRETTY_PRINT); // Pretty print
			SetDebugMessage("(Chart JSON):<pre>" . HtmlEncode(ConvertFromUtf8($chartJson)) . "</pre>");
		}
		return $wrk;
	}

	// Load chart
	protected function loadChart()
	{
		$chtType = $this->Chart->loadParameter("type");
		$chartSeries = $this->Chart->Series;
		$chartData = $this->Chart->ViewData;
		$multiSeries = $this->Chart->isSingleSeries() ? 0 : 1; // $multiSeries = 1 (Multi series charts)
		$seriesType = $this->Chart->loadParameter("seriestype");

		// Load default options
		$this->Options = $this->Chart->getParameters("options");
		$title = $this->Chart->loadParameter("caption");

		// Initialise X / Y Axes
		$xAxes = [];
		$yAxes = [];
		$scale = $this->Chart->getParameters("scale"); // Default bar chart scale
		if (is_array($chartData)) {

			// Multi series
			if ($multiSeries == 1) {
				$labels = [];
				$datasets = [];

				// Multi-Y values
				if ($seriesType == "1") {

					// Set up labels
					$cntCat = count($chartData);
					for ($i = 0; $i < $cntCat; $i++) {
						$name = $this->Chart->formatName($chartData[$i][0]);
						$labels[] = $name;
					}

					// Set up datasets
					$cntData = count($chartData);
					$cntSeries = count($chartSeries);
					if ($cntSeries > count($chartData[0]) - 2)
						$cntSeries = count($chartData[0]) - 2;
					for ($i = 0; $i < $cntSeries; $i++) {
						$seriesName = (is_array($chartSeries[$i])) ? $chartSeries[$i][0] : $chartSeries[$i];
						$yAxisId = (is_array($chartSeries[$i])) ? $chartSeries[$i][1] : "";
						if (!EmptyString($yAxisId) && !in_array($yAxisId, array_column($yAxes, "id"))) // Dual axis
							$yAxes[] = ["id" => $yAxisId, "position" => $yAxisId == "P" ? "left" : "right"];
						$color = $this->Chart->getPaletteRgbaColor($i);
						$renderAs = $this->Chart->getRenderAs($i);
						$showSeries = Config("CHART_SHOW_BLANK_SERIES");
						$data = [];
						$links = [];
						for ($j = 0; $j < $cntData; $j++) {
							$val = $chartData[$j][$i + 2];
							$val = ($val === NULL) ? 0 : (float)$val;
							if ($val != 0)
								$showSeries = TRUE;
							$lnk = $this->getChartLink($this->Chart->DrillDownUrl, $this->Chart->Data[$j]);
							$links[] = $lnk;
							$data[] = $val;
						}
						if ($showSeries) {
							$dataset = $this->getDataset($data, $color, $links, $seriesName, $renderAs, $yAxisId);
							$datasets[] = $dataset;
						}
					}

				// Series field
				} else {

					// Get series names
					if (is_array($chartSeries)) {
						$cntSeries = count($chartSeries);
					} else {
						$cntSeries = 0;
					}

					// Set up labels
					$cntData = count($chartData);
					for ($i = 0; $i < $cntData; $i++) {
						$name = $chartData[$i][0];
						if (!in_array($name, $labels)) {
							$labels[] = $name;
						}
					}

					// Set up dataset
					$cntLabels = count($labels);
					$cntData = count($chartData);
					for ($i = 0; $i < $cntSeries; $i++) {
						$seriesName = (is_array($chartSeries[$i])) ? $chartSeries[$i][0] : $chartSeries[$i];
						$yAxisId = (is_array($chartSeries[$i])) ? $chartSeries[$i][1] : ""; 
						if (!EmptyString($yAxisId) && !in_array($yAxisId, array_column($yAxes, "id"))) // Dual axis
							$yAxes[] = ["id" => $yAxisId, "position" => $yAxisId == "P" ? "left" : "right"];
						$color = $this->Chart->getPaletteRgbaColor($i);
						$renderAs = $this->Chart->getRenderAs($i);
						$showSeries = Config("CHART_SHOW_BLANK_SERIES");
						$data = [];
						$links = [];
						for ($j = 0; $j < $cntLabels; $j++) {
							$val = 0;
							$lnk = "";
							for ($k = 0; $k < $cntData; $k++) {
								if ($chartData[$k][0] == $labels[$j] && $chartData[$k][1] == $seriesName) {
									$val = $chartData[$k][2];
									$val = ($val === NULL) ? 0 : (float)$val;
									if ($val != 0)
										$showSeries = TRUE;
									$lnk = $this->getChartLink($this->Chart->DrillDownUrl, $this->Chart->Data[$k]);
									$links[] = $lnk;
									break;
								}
							}
							$data[] = $val;
						}
						if ($showSeries) {
							$dataset = $this->getDataset($data, $color, $links, $seriesName, $renderAs, $yAxisId);
							$datasets[] = $dataset;
						}
					}
				}

				// Set up Data/Options
				$this->Data = ["labels" => $labels, "datasets" => $datasets];
				$this->Options = array_replace_recursive($this->Options, ["responsive" => FALSE, "legend" => ["display" => TRUE], "title" => ["display" => TRUE, "text" => $title]]);

				// Set up tooltips for stacked charts
				if ($this->Chart->isStackedChart())
					$this->Options["tooltips"] = ["mode" => "index"];

				// Set up X/Y Axes
				if ($this->Chart->isCombinationChart()) {
					if (count($scale) > 0)
						$xAxes[] = $scale;
				} else {
					$stack = $this->Chart->isStackedChart() ? ["stacked" => TRUE] : [];
					$ar = $stack;
					if ($this->Chart->isColumnChart())
						$ar = array_replace_recursive($scale, $ar);
					if (count($ar) > 0)
						$xAxes[] = $ar;
					$ar = $stack;
					if ($this->Chart->isBarChart())
						$ar = array_replace_recursive($scale, $ar);
					if (count($ar) > 0)
						$yAxes[] = $ar;
				}

			// Single series
			} else {
				$cntData = count($chartData);
				$labels = [];
				$backgroundColor = [];
				$data = [];
				$links = [];
				for ($i = 0; $i < $cntData; $i++) {
					$name = $this->Chart->formatName($chartData[$i][0]);
					$color = $this->Chart->getPaletteRgbaColor($i);
					if ($chartData[$i][1] != "") 
						$name .= ", " . $chartData[$i][1];
					$val = $chartData[$i][2];
					$val = ($val === NULL) ? 0 : (float)$val;
					$lnk = $this->getChartLink($this->Chart->DrillDownUrl, $this->Chart->Data[$i]);
					$links[] = $lnk;
					$labels[] = $name;
					$backgroundColor[] = $color;
					$data[] = $val;
				}

				// Set bar defaults
				if ($this->Chart->isColumnChart() && count($scale) > 0)
					$xAxes[] = $scale;
				elseif ($this->Chart->isBarChart() && count($scale) > 0)
					$yAxes[] = $scale;

				// Line/Area chart, use first color
				if ($this->Chart->isLineChart() || $this->Chart->isAreaChart())
					$backgroundColor = $this->Chart->getPaletteRgbaColor(0); // Use first color

				// Get dataset
				$dataset = $this->getDataset($data, $backgroundColor, $links);
				$datasets = [$dataset];

				// Set up Data/Options
				$this->Data = ["labels" => $labels, "datasets" => $datasets];
				$this->Options = array_replace_recursive($this->Options, ["responsive" => FALSE, "legend" => ["display" => FALSE], "title" => ["display" => TRUE, "text" => $title]]);
			}

			// Set X / Y Axes
			$this->Options["scales"] = ["xAxes" => $xAxes, "yAxes" => $yAxes];
		}

		// Chart_Rendered event
		if (method_exists($this->Chart, "Chart_Rendered"))
			$this->Chart->Chart_Rendered($this);
	}

	// Get chart link
	protected function getChartLink($src, $row)
	{
		if ($src != "" && is_array($row)) {
			global $Language;
			$cntrow = count($row);
			$lnk = $src;
			$sdt = $this->Chart->SeriesDateType;
			$xdt = $this->Chart->XAxisDateFormat;
			if ($sdt != "")
				$xdt = $sdt;
			if (preg_match("/&t=([^&]+)&/", $lnk, $m))
				$tblCaption = $Language->tablePhrase($m[1], "TblCaption");
			else
				$tblCaption = "";
			for ($i = 0; $i < $cntrow; $i++) { // Link format: %i:Parameter:FieldType%
				if (preg_match("/%" . $i . ":([^%:]*):([\d]+)%/", $lnk, $m)) {
					$fldtype = FieldDataType($m[2]);
					if ($i == 0) { // Format X SQL
						$lnk = str_replace($m[0], Encrypt($this->Chart->getXSql("@" . $m[1], $fldtype, $row[$i], $xdt)), $lnk);
					} elseif ($i == 1) { // Format Series SQL
						$lnk = str_replace($m[0], Encrypt($this->Chart->getSeriesSql("@" . $m[1], $fldtype, $row[$i], $sdt)), $lnk);
					} else {
						$lnk = str_replace($m[0], Encrypt("@" . $m[1] . " = " . QuotedValue($row[$i], $fldtype, $this->Chart->Table->Dbid)), $lnk);
					}
				}
			}
			return ["url" => $lnk, "id" => $this->Chart->ID, "hdr" => $tblCaption];
		}
		return NULL;
	}
	protected function getDataset($data, $color, $links, $seriesName = NULL, $renderAs = "", $yAxisId = "")
	{
		$dataset = $this->Chart->getParameters("dataset"); // Load default dataset options
		$dataset["data"] = $data; // Load data
		$dataset["backgroundColor"] = $color; // Background color
		$changeAlpha = function($c) {
			return preg_replace('/[\d\.]+(?=\))/', "1.0", $c); // Change alpha to 1.0
		};
		if (is_array($color)) {
			$borderColor = array_map($changeAlpha, $color);
			$dataset["borderColor"] = $borderColor;
			$dataset["borderWidth"] = 1;
		} elseif (is_string($color)) {
			$dataset["borderColor"] = $changeAlpha($color);
			$dataset["borderWidth"] = 1;
		}
		$hasLink = count(array_filter($links)) > 0;
		$dataset["links"] = $hasLink ? $links : NULL; // Drill down link
		if ($seriesName !== NULL) { // Multi series
			$dataset["label"] = $seriesName;
			if ($this->Chart->isCombinationChart()) { // Combination chart, set render type / stack id / axis id
				$renderType = $this->getRenderType($renderAs);
				$dataset["type"] = $renderType;
				if ($renderType == "bar" && $this->Chart->isStackedChart()) // Set up stack id
					$dataset["stack"] = $this->Chart->ID;
				if ($this->Chart->isDualAxisChart()) // Set up axis id
					$dataset["yAxisID"] = $yAxisId;
			} elseif ($this->Chart->isStackedChart()) // Stacked chart, set up stack id
				$dataset["stack"] = $this->Chart->ID;
		}
		if ($this->Chart->isLineChart() || $this->Chart->isCombinationChart() && SameText($renderAs, "line")) // Line chart, set no fill
			$dataset["fill"] = FALSE;
		return $dataset;
	}

	// Get render type for combination chart
	protected function getRenderType($renderAs)
	{
		if (SameText($renderAs, "column"))
			return "bar";
		elseif (SameText($renderAs, "line") || SameText($renderAs, "area") && !$this->Chart->isStackedChart())
			return "line";
		else // Default
			return "bar";
	}
}