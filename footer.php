<?php namespace PHPMaker2020\SupplierMapping; ?>
<?php if (!IsExport()) { ?>
<?php if (@!$SkipHeaderFooter) { ?>
		<?php if (isset($DebugTimer)) $DebugTimer->stop() ?>
		</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- ** Note: Only licensed users are allowed to change the copyright statement. ** -->
		<div class="ew-footer-text"><?php echo $Language->projectPhrase("FooterText") ?></div>
		<div class="float-right d-none d-sm-inline-block"></div>
	</footer>
</div>
<!-- ./wrapper -->
<?php } ?>
<!-- template upload (for file upload) -->
<script id="template-upload" type="text/html">
{{for files}}
	<tr class="template-upload">
		<td>
			<span class="preview"></span>
		</td>
		<td>
			<p class="name">{{:name}}</p>
			<p class="error text-danger"></p>
		</td>
		<td>
			<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar bg-success" style="width: 0%;"></div></div>
		</td>
		<td>
			{{if !#index && !~root.options.autoUpload}}
			<button class="btn btn-default btn-sm start" disabled><?php echo $Language->phrase("UploadStart") ?></button>
			{{/if}}
			{{if !#index}}
			<button class="btn btn-default btn-sm cancel"><?php echo $Language->phrase("UploadCancel") ?></button>
			{{/if}}
		</td>
	</tr>
{{/for}}
</script>
<!-- template download (for file upload) -->
<script id="template-download" type="text/html">
{{for files}}
	<tr class="template-download">
		<td>
			<span class="preview">
				{{if !exists}}
				<span class="text-danger"><?php echo $Language->phrase("FileNotFound") ?></span>
				{{else url && extension == "pdf"}}
				<div class="ew-pdfobject" data-url="{{>url}}" style="width: <?php echo Config("UPLOAD_THUMBNAIL_WIDTH") ?>px;"></div>
				{{else url && extension == "mp3"}}
				<audio controls><source type="audio/mpeg" src="{{>url}}"></audio>
				{{else url && extension == "mp4"}}
				<video controls><source type="video/mp4" src="{{>url}}"></video>
				{{else thumbnailUrl}}
				<a href="{{>url}}" title="{{>name}}" download="{{>name}}" class="ew-lightbox"><img src="{{>thumbnailUrl}}"></a>
				{{/if}}
			</span>
		</td>
		<td>
			<p class="name">
				{{if !exists}}
				<span class="text-muted">{{:name}}</span>
				{{else url && thumbnailUrl && extension != "pdf" && extension != "mp3" && extension != "mp4"}}
				<a href="{{>url}}" title="{{>name}}" download="{{>name}}" class="ew-lightbox">{{:name}}</a>
				{{else url}}
				<a href="{{>url}}" title="{{>name}}" download="{{>name}}">{{:name}}</a>
				{{else}}
				<span>{{:name}}</span>
				{{/if}}
			</p>
			{{if error}}
			<div><span class="error text-danger">{{:error}}</span></div>
			{{/if}}
		</td>
		<td>
			<span class="size">{{:~root.formatFileSize(size)}}</span>
		</td>
		<td>
			{{if !~root.options.readOnly && deleteUrl}}
			<button class="btn btn-default btn-sm delete" data-type="{{>deleteType}}" data-url="{{>deleteUrl}}"><?php echo $Language->phrase("UploadDelete") ?></button>
			{{else !~root.options.readOnly}}
			<button class="btn btn-default btn-sm cancel"><?php echo $Language->phrase("UploadCancel") ?></button>
			{{/if}}
		</td>
	</tr>
{{/for}}
</script>
<!-- modal dialog -->
<div id="ew-modal-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- import dialog -->
<div id="ew-import-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div>
<div class="modal-body">
<div class="custom-file">
	<input type="file" class="custom-file-input" id="importfiles" title=" " name="importfiles[]" multiple lang="<?php echo CurrentLanguageID() ?>">
	<label class="custom-file-label ew-file-label" for="importfiles"><?php echo $Language->phrase("ChooseFiles") ?></label>
</div>
<div class="message d-none mt-3"></div>
<div class="progress d-none mt-3"><div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default ew-close-btn" data-dismiss="modal"><?php echo $Language->phrase("CloseBtn") ?></button></div></div></div></div>
<!-- message box -->
<div id="ew-message-box" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn" data-dismiss="modal"><?php echo $Language->phrase("MessageOK") ?></button></div></div></div></div>
<!-- prompt -->
<div id="ew-prompt" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn"><?php echo $Language->phrase("MessageOK") ?></button><button type="button" class="btn btn-default ew-btn" data-dismiss="modal"><?php echo $Language->phrase("CancelBtn") ?></button></div></div></div></div>
<!-- session timer -->
<div id="ew-timer" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn" data-dismiss="modal"><?php echo $Language->phrase("MessageOK") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ew-tooltip"></div>
<?php if (@!$DrillDownInPanel) { ?>
<!-- drill down -->
<div id="ew-drilldown-panel"></div>
<?php } ?>
<?php } ?>
<?php if (!IsExport() || IsExport("print")) { ?>
<script>

// User event handlers
ew.ready(ew.bundleIds, "<?php echo $RELATIVE_PATH ?>js/userevt.js", "load", function() {

	// Global startup script
	// Write your global startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
</body>
</html>