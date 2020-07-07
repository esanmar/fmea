<?php
namespace PHPMaker2020\SupplierMapping;

/**
 * Chart exporter class for PHPMaker 2020
 * (C) 2020 e.World Technology Limited
 */
class ChartExporter
{

	// Export
	public function export()
	{

		// Check token
		if (!$this->validPost())
			return $this->serverError("Invalid post request.");
		$json = Post("charts", "[]");
		$charts = json_decode($json);
		$files = [];
		foreach ($charts as $chart) {
			$img = FALSE;

			// Charts base64
			if ($chart->stream_type == "base64") {
				try {
					$img = base64_decode(preg_replace('/^data:image\/\w+;base64,/', "", $chart->stream));
				} catch (Exception $e) {
					return $this->serverError($e->getMessage());
				}
			}
			if ($img === FALSE)
				return $this->serverError("Unable to get " . $chart->stream_type . " image from " . $chart->chart_engine . ".");

			// Save the file
			$params = $chart->parameters;
			$filename = "";
			if (preg_match('/exportfilename=(\w+\.png)\|/', $params, $matches)) // Must be .png for security
				$filename = $matches[1];
			if ($filename == "")
				return $this->serverError("Missing file name.");
			$path = ServerMapPath(Config("UPLOAD_DEST_PATH"));
			$realpath = realpath($path);
			if (!file_exists($realpath))
				return $this->serverError("Upload folder does not exist.");
			if (!is_writable($realpath))
				return $this->serverError("Upload folder is not writable.");
			$filepath = realpath($path) . PATH_DELIMITER . $filename;
			file_put_contents($filepath, $img);
			$files[] = $filename;
		}

		// Write success response
		WriteJson(["success" => TRUE, "files" => $files]);
		return TRUE;
	}

	// Send server error
	protected function serverError($msg)
	{
		WriteJson(["success" => FALSE, "error" => $msg]);
		return FALSE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!Config("CHECK_TOKEN") || !IsPost())
			return TRUE;
		$token = Post(Config("TOKEN_NAME"));
		if ($token === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn($token);
		return FALSE;
	}
}
?>