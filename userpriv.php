<?php
namespace PHPMaker2020\fmeaPRD;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start();

// Autoload
include_once "autoload.php";
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$userpriv = new userpriv();

// Run the page
$userpriv->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userpriv->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserpriv, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "userpriv";
	fuserpriv = currentForm = new ew.Form("fuserpriv", "userpriv");
	loadjs.done("fuserpriv");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php
$userpriv->showMessage();
?>
<form name="fuserpriv" id="fuserpriv" class="form-inline ew-form ew-user-priv-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="x_userlevelid" id="x_userlevelid" value="<?php echo $userpriv->userlevelid->CurrentValue ?>">
<div class="ew-desktop">
<div class="card ew-card ew-user-priv">
<div class="card-header">
	<h3 class="card-title"><?php echo $Language->phrase("UserLevel") ?><?php echo $Security->getUserLevelName((int)$userpriv->userlevelid->CurrentValue) ?> (<?php echo $userpriv->userlevelid->CurrentValue ?>)</h3>
	<div class="card-tools">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fas fa-search"></i></span>
			</div>
			<input type="search" name="table-name" id="table-name" class="form-control form-control-sm" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		</div>
	</div>
</div>
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-card-body p-0"></div>
</div>
<div class="ew-desktop-button">
<button class="btn btn-primary ew-btn" name="btn-submit" id="btn-submit" type="submit"<?php echo $userpriv->Disabled ?>><?php echo $Language->phrase("Update") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userpriv->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</div>
</form>
<script>
loadjs.ready("makerjs", function() {
	var $ = jQuery,
		priv = <?php echo JsonEncode($userpriv->Privileges) ?>;

	function getDisplayFn(name, trueValue) {
		return function(data) {
			var row = data.record, id = name + '_' + row.index,
				checked = (row.permission & trueValue) == trueValue;
			row.checked = checked;
			return '<div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" class="custom-control-input ew-priv ew-multi-select" name="' + id + '" id="' + id +
				'" value="' + trueValue + '" data-index="' + row.index + '"' +
				((checked) ? ' checked' : '') +
				(((row.allowed & trueValue) != trueValue) ? ' disabled' : '') + '><label class="custom-control-label" for="' + id + '"></label></div>';
		};
	}

	function displayTableName(data) {
		var row = data.record;
		return row.table + '<input type="hidden" name="table_' + row.index + '" value="1">';
	}

	function getRecords(data, params) {
		var rows = priv.permissions.slice(0);
		if (data && data.table) {
			var table = data.table.toLowerCase();
			rows = jQuery.map(rows, function(row) {
				if (row.table.toLowerCase().includes(table))
					return row;
				return null;
			});
		}
		if (params && params.sorting) {
			var asc = params.sorting.match(/ASC$/);
			rows.sort(function(a, b) { // Case-insensitive
				if (b.table.toLowerCase() > a.table.toLowerCase())
					return (asc) ? -1 : 1;
				else if (b.table.toLowerCase() === a.table.toLowerCase())
					return 0
				else if (b.table.toLowerCase() < a.table.toLowerCase())
					return (asc) ? 1 : -1;
			});
		}
		return {
			result: "OK",
			params: jQuery.extend({}, data, params),
			records: rows
		};
	}

	function getTitleHtml(id, phraseId) {
		return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input ew-priv" name="' + id + '" id="' + id + '" onclick="ew.selectAll(this);">' +
			'<label class="custom-control-label" for="' + id + '">' + ew.language.phrase("Permission" + (phraseId || id)) + '</label></div>'
	}

	// Fields
	var _fields = {
		table: {
			title: '<span class="font-weight-normal">' + ew.language.phrase("TableOrView") + '</span>',
			display: displayTableName,
			sorting: true
		}
	};
	["add", "delete", "edit", "list", "lookup", "view", "search", "import", "admin"].forEach(function(id) {
		_fields[id] = {
			title: getTitleHtml(id),
			display: getDisplayFn(id, priv[id]),
			sorting: false
		};
	});

	// Init
	$(".ew-card.ew-user-priv .ew-card-body").ewjtable({
		paging: false,
		sorting: true,
		defaultSorting: "table ASC",
		fields: _fields,
		actions: { listAction: getRecords },
		rowInserted: function(event, data) {
			var $row = data.row;
			$row.find("input[type=checkbox]").on("click", function() {
				var $this = $(this), index = parseInt($this.data("index"), 10), value = parseInt($this.data("value"), 10);
				if (this.checked)
					priv.permissions[index].permission = priv.permissions[index].permission | value;
				else
					priv.permissions[index].permission = priv.permissions[index].permission ^ value;
			});
		},
		recordsLoaded: function(event, data) {
			var sorting = data.serverResponse.params.sorting,
				$c = $(this).find(".ewjtable-column-header-container:first");
			if (!$c.find(".ew-table-header-sort")[0])
				$c.append('<span class="ew-table-header-sort"><i class="fas fa-sort-down"></i></span>');
			$c.find(".ew-table-header-sort i.fas").toggleClass("fa-sort-up", !!sorting.match(/ASC$/)).toggleClass("fa-sort-down", !!sorting.match(/DESC$/));
			ew.initMultiSelectCheckboxes();
			ew.fixLayoutHeight();
		}
	});

	// Re-load records when user click 'Search' button.
	var _timer;
	$("#table-name").on("keydown keypress cut paste", function(e) {
		if (_timer)
			_timer.cancel();
		_timer = $.later(200, null, function() {
			$(".ew-card.ew-user-priv .ew-card-body").ewjtable("load", {
				table: $("#table-name").val()
			});
		});
	});

	// Load all records
	$("#table-name").keydown();
});
</script>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$userpriv->terminate();
?>