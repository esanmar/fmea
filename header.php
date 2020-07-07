<?php namespace PHPMaker2020\SupplierMapping; ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $Language->projectPhrase("BodyTitle") ?></title>
<meta charset="utf-8">
<?php if ($ReportExportType != "" && $ReportExportType != "print") { // Stylesheet for exporting reports ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?><?php echo CssFile(Config("PROJECT_STYLESHEET_FILENAME")) ?>">
<?php if ($ReportExportType == "pdf" && Config("PDF_STYLESHEET_FILENAME")) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?><?php echo CssFile(Config("PDF_STYLESHEET_FILENAME")) ?>">
<?php } ?>
<?php } ?>
<?php if (!IsExport() || IsExport("print")) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>adminlte3/css/<?php echo CssFile("adminlte.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>plugins/fontawesome-free/css/v4-shims.css">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>css/OverlayScrollbars.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?><?php echo CssFile(Config("PROJECT_STYLESHEET_FILENAME")) ?>">
<?php if ($CustomExportType == "pdf" && Config("PDF_STYLESHEET_FILENAME")) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?><?php echo CssFile(Config("PDF_STYLESHEET_FILENAME")) ?>">
<?php } ?>
<script src="<?php echo $RELATIVE_PATH ?>js/ewpolyfill.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>js/loadjs.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>js/ewcfg.js"></script>
<script>
Object.assign(ew, {
	LANGUAGE_ID: "<?php echo $CurrentLanguage ?>",
	DATE_SEPARATOR: "<?php echo $DATE_SEPARATOR ?>", // Date separator
	TIME_SEPARATOR: "<?php echo $TIME_SEPARATOR ?>", // Time separator
	DATE_FORMAT: "<?php echo $DATE_FORMAT ?>", // Default date format
	DATE_FORMAT_ID: <?php echo $DATE_FORMAT_ID ?>, // Default date format ID
	DATETIME_WITHOUT_SECONDS: <?php echo Config("DATETIME_WITHOUT_SECONDS") ? "true" : "false" ?>, // Date/Time without seconds
	DECIMAL_POINT: "<?php echo $DECIMAL_POINT ?>",
	THOUSANDS_SEP: "<?php echo $THOUSANDS_SEP ?>",
	SESSION_TIMEOUT: <?php echo Config("SESSION_TIMEOUT") > 0 ? SessionTimeoutTime() : 0 ?>, // Session timeout time (seconds)
	SESSION_TIMEOUT_COUNTDOWN: <?php echo Config("SESSION_TIMEOUT_COUNTDOWN") ?>, // Count down time to session timeout (seconds)
	SESSION_KEEP_ALIVE_INTERVAL: <?php echo Config("SESSION_KEEP_ALIVE_INTERVAL") ?>, // Keep alive interval (seconds)
	RELATIVE_PATH: "<?php echo $RELATIVE_PATH ?>", // Relative path
	IS_LOGGEDIN: <?php echo IsLoggedIn() ? "true" : "false" ?>, // Is logged in
	IS_SYS_ADMIN: <?php echo IsSysAdmin() ? "true" : "false" ?>, // Is sys admin
	CURRENT_USER_NAME: "<?php echo JsEncode(CurrentUserName()) ?>", // Current user name
	IS_AUTOLOGIN: <?php echo IsAutoLogin() ? "true" : "false" ?>, // Is logged in with option "Auto login until I logout explicitly"
	TIMEOUT_URL: "<?php echo $RELATIVE_PATH ?>index.php", // Timeout URL // PHP
	TOKEN_NAME: "<?php echo Config("TOKEN_NAME") ?>", // Token name
	API_FILE_TOKEN_NAME: "<?php echo Config("API_FILE_TOKEN_NAME") ?>", // API file token name
	API_URL: "<?php echo $RELATIVE_PATH ?><?php echo Config("API_URL") ?>", // API file name // PHP
	API_ACTION_NAME: "<?php echo Config("API_ACTION_NAME") ?>", // API action name
	API_OBJECT_NAME: "<?php echo Config("API_OBJECT_NAME") ?>", // API object name
	API_FIELD_NAME: "<?php echo Config("API_FIELD_NAME") ?>", // API field name
	API_KEY_NAME: "<?php echo Config("API_KEY_NAME") ?>", // API key name
	API_LIST_ACTION: "<?php echo Config("API_LIST_ACTION") ?>", // API list action
	API_VIEW_ACTION: "<?php echo Config("API_VIEW_ACTION") ?>", // API view action
	API_ADD_ACTION: "<?php echo Config("API_ADD_ACTION") ?>", // API add action
	API_EDIT_ACTION: "<?php echo Config("API_EDIT_ACTION") ?>", // API edit action
	API_DELETE_ACTION: "<?php echo Config("API_DELETE_ACTION") ?>", // API delete action
	API_LOGIN_ACTION: "<?php echo Config("API_LOGIN_ACTION") ?>", // API login action
	API_FILE_ACTION: "<?php echo Config("API_FILE_ACTION") ?>", // API file action
	API_UPLOAD_ACTION: "<?php echo Config("API_UPLOAD_ACTION") ?>", // API upload action
	API_JQUERY_UPLOAD_ACTION: "<?php echo Config("API_JQUERY_UPLOAD_ACTION") ?>", // API jQuery upload action
	API_SESSION_ACTION: "<?php echo Config("API_SESSION_ACTION") ?>", // API get session action
	API_LOOKUP_ACTION: "<?php echo Config("API_LOOKUP_ACTION") ?>", // API lookup action
	API_LOOKUP_PAGE: "<?php echo Config("API_LOOKUP_PAGE") ?>", // API lookup page name
	API_PROGRESS_ACTION: "<?php echo Config("API_PROGRESS_ACTION") ?>", // API progress action
	API_EXPORT_CHART_ACTION: "<?php echo Config("API_EXPORT_CHART_ACTION") ?>", // API export chart action
	API_JWT_AUTHORIZATION_HEADER: "X-Authorization", // API JWT authorization header
	API_JWT_TOKEN: "", // API JWT token
	USE_URL_REWRITE: <?php echo Config("USE_URL_REWRITE") ? "true" : "false" ?>, // URL rewrite
	MULTIPLE_OPTION_SEPARATOR: "<?php echo Config("MULTIPLE_OPTION_SEPARATOR") ?>", // Multiple option separator
	AUTO_SUGGEST_MAX_ENTRIES: <?php echo Config("AUTO_SUGGEST_MAX_ENTRIES") ?>, // Auto-Suggest max entries
	IMAGE_FOLDER: "images/", // Image folder
	SESSION_ID: "<?php echo Encrypt(session_id()) ?>", // Session ID
	UPLOAD_THUMBNAIL_WIDTH: <?php echo Config("UPLOAD_THUMBNAIL_WIDTH") ?>, // Upload thumbnail width
	UPLOAD_THUMBNAIL_HEIGHT: <?php echo Config("UPLOAD_THUMBNAIL_HEIGHT") ?>, // Upload thumbnail height
	MULTIPLE_UPLOAD_SEPARATOR: "<?php echo Config("MULTIPLE_UPLOAD_SEPARATOR") ?>", // Upload multiple separator
	IMPORT_FILE_ALLOWED_EXT: "<?php echo Config("IMPORT_FILE_ALLOWED_EXT") ?>", // Import file allowed extensions
	USE_COLORBOX: <?php echo Config("USE_COLORBOX") ? "true" : "false" ?>,
	USE_JAVASCRIPT_MESSAGE: false,
	PROJECT_STYLESHEET_FILENAME: "<?php echo Config("PROJECT_STYLESHEET_FILENAME") ?>", // Project style sheet
	PDF_STYLESHEET_FILENAME: "<?php echo Config("PDF_STYLESHEET_FILENAME") ?: "" ?>", // PDF style sheet // PHP
	EMBED_PDF: <?php echo Config("EMBED_PDF") ? "true" : "false" ?>,
	ANTIFORGERY_TOKEN: "<?php echo @$CurrentToken ?>", // PHP
	CSS_FLIP: <?php echo Config("CSS_FLIP") ? "true" : "false" ?>,
	LAZY_LOAD: <?php echo Config("LAZY_LOAD") ? "true" : "false" ?>,
	USE_RESPONSIVE_TABLE: <?php echo Config("USE_RESPONSIVE_TABLE") ? "true" : "false" ?>,
	RESPONSIVE_TABLE_CLASS: "<?php echo Config("RESPONSIVE_TABLE_CLASS") ?>",
	DEBUG: <?php echo Config("DEBUG") ? "true" : "false" ?>,
	SEARCH_FILTER_OPTION: "<?php echo Config("SEARCH_FILTER_OPTION") ?>",
	OPTION_HTML_TEMPLATE: <?php echo JsonEncode(Config("OPTION_HTML_TEMPLATE")) ?>
});
loadjs("<?php echo $RELATIVE_PATH ?>jquery/jquery-3.4.1.min.js", "jquery");
loadjs([
	"<?php echo $RELATIVE_PATH ?>js/mobile-detect.min.js",
	"<?php echo $RELATIVE_PATH ?>js/purify.min.js",
	"<?php echo $RELATIVE_PATH ?>jquery/load-image.all.min.js"
], "others");
<?php echo $Language->toJson() ?>
ew.vars = <?php echo JsonEncode($ClientVariables) ?>;
ew.ready("jquery", "<?php echo $RELATIVE_PATH ?>jquery/jsrender.min.js", "jsrender", ew.renderJsTemplates);
ew.ready("jsrender", "<?php echo $RELATIVE_PATH ?>jquery/jquery.overlayScrollbars.min.js", "scrollbars", ew.initSidebarScrollbars); // Init sidebar scrollbars after rendering menu
ew.ready("jquery", "<?php echo $RELATIVE_PATH ?>jquery/jquery.ui.widget.min.js", "widget");
ew.loadjs(["<?php echo $RELATIVE_PATH ?>moment/moment.min.js", "<?php echo $RELATIVE_PATH ?>js/Chart.min.js"], "moment");
</script>
<?php include_once $RELATIVE_PATH . "ewmenu.php"; ?>
<script>
var cssfiles = [
	"<?php echo $RELATIVE_PATH ?>css/Chart.min.css",
	"<?php echo $RELATIVE_PATH ?>css/jquery.fileupload.css",
	"<?php echo $RELATIVE_PATH ?>css/jquery.fileupload-ui.css"
];
cssfiles.push("<?php echo $RELATIVE_PATH ?>colorbox/colorbox.css");
loadjs(cssfiles, "css");
var cssjs = [];
<?php foreach (array_merge(Config("STYLESHEET_FILES"), Config("JAVASCRIPT_FILES")) as $file) { // External Stylesheets and JavaScripts ?>
cssjs.push("<?php echo (IsRemote($file) ? "" : $RELATIVE_PATH) . $file ?>");
<?php } ?>
var jqueryjs = [
	"<?php echo $RELATIVE_PATH ?>adminlte3/js/adminlte.js",
	"<?php echo $RELATIVE_PATH ?>bootstrap4/js/bootstrap.bundle.min.js",
	"<?php echo $RELATIVE_PATH ?>jquery/jquery.fileDownload.min.js",
	"<?php echo $RELATIVE_PATH ?>jquery/jqueryfileupload.min.js",
	"<?php echo $RELATIVE_PATH ?>jquery/typeahead.jquery.min.js"
];
jqueryjs.push("<?php echo $RELATIVE_PATH ?>colorbox/jquery.colorbox-min.js");
jqueryjs.push("<?php echo $RELATIVE_PATH ?>js/pdfobject.min.js");
ew.ready(["jquery", "widget", "scrollbars", "moment", "others"], [jqueryjs, "<?php echo $RELATIVE_PATH ?>js/ew.js"], "makerjs");
ew.ready("makerjs", [cssjs, "<?php echo $RELATIVE_PATH ?>js/userfn.js"], "head");
</script>
<script>
loadjs.ready("head", function() {

	// Global client script
	// Write your client script here, no need to add script tags.

});
</script>
<!-- Navbar -->
<script type="text/html" id="navbar-menu-items" class="ew-js-template" data-name="navbar" data-seq="10" data-data="navbar" data-method="appendTo" data-target="#ew-navbar">
{{if items}}
	{{for items}}
		<li id="{{:id}}" name="{{:name}}" class="{{if parentId == -1}}nav-item ew-navbar-item{{/if}}{{if isHeader && parentId > -1}}dropdown-header{{/if}}{{if items}} dropdown{{/if}}{{if items && parentId != -1}} dropdown-submenu{{/if}}{{if items && level == 1}} dropdown-hover{{/if}} d-none d-md-block">
			{{if isHeader && parentId > -1}}
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
			{{else}}
			<a href="{{:href}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}} class="{{if parentId == -1}}nav-link{{else}}dropdown-item{{/if}}{{if active}} active{{/if}}{{if items}} dropdown-toggle ew-dropdown{{/if}}"{{if items}} role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"{{/if}}>
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
			</a>
			{{/if}}
			{{if items}}
			<ul class="dropdown-menu">
				{{include tmpl="#navbar-menu-items"/}}
			</ul>
			{{/if}}
		</li>
	{{/for}}
{{/if}}
</script>
<!-- Sidebar -->
<script type="text/html" class="ew-js-template" data-name="menu" data-seq="10" data-data="menu" data-target="#ew-menu">
{{if items}}
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="{{:accordion}}">
	{{include tmpl="#menu-items"/}}
	</ul>
{{/if}}
</script>
<script type="text/html" id="menu-items">
{{if items}}
	{{for items}}
		<li id="{{:id}}" name="{{:name}}" class="{{if isHeader}}nav-header{{else}}nav-item{{if items}} has-treeview{{/if}}{{if active}} active current{{/if}}{{if open}} menu-open{{/if}}{{/if}}{{if isNavbarItem}} d-block d-md-none{{/if}}">
			{{if isHeader}}
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
				{{if label}}
				<span class="right">
					{{:label}}
				</span>
				{{/if}}
			{{else}}
			<a href="{{:href}}" class="nav-link{{if active}} active{{/if}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}}>
				{{if icon}}<i class="nav-icon {{:icon}}"></i>{{/if}}
				<p><span class="menu-item-text">{{:text}}</span>
					{{if items}}
						<i class="right fas fa-angle-left"></i>
						{{if label}}
							<span class="right">
								{{:label}}
							</span>
						{{/if}}
					{{else}}
						{{if label}}
							<span class="right">
								{{:label}}
							</span>
						{{/if}}
					{{/if}}
				</p>
			</a>
			{{/if}}
			{{if items}}
			<ul class="nav nav-treeview"{{if open}} style="display: block;"{{/if}}>
				{{include tmpl="#menu-items"/}}
			</ul>
			{{/if}}
		</li>
	{{/for}}
{{/if}}
</script>
<script type="text/html" class="ew-js-template" data-name="languages" data-seq="10" data-data="languages" data-method="<?php echo $Language->Method ?>" data-target="<?php echo HtmlEncode($Language->Target) ?>">
<?php echo $Language->getTemplate() ?>
</script>
<?php } ?>
<meta name="generator" content="PHPMaker 2020">
</head>
<body class="<?php echo Config("BODY_CLASS") ?>" dir="<?php echo Config("CSS_FLIP") ? "rtl" : "ltr" ?>">
<?php if (@!$SkipHeaderFooter) { ?>
<?php if (!IsExport()) { ?>
<div class="wrapper ew-layout">
	<!-- Main Header -->
	<!-- Navbar -->
	<nav class="<?php echo Config("NAVBAR_CLASS") ?>">
		<!-- Left navbar links -->
		<ul id="ew-navbar" class="navbar-nav">
			<li class="nav-item d-block">
				<a class="nav-link" data-widget="pushmenu" href="#" onclick="return false;"><i class="fas fa-bars"></i></a>
			</li>
			<a class="navbar-brand d-none" href="processflist.php">
				<img src="<?php echo $RELATIVE_PATH ?>images/aci.GIF" alt="" class="brand-image ew-brand-image">
			</a>
		</ul>
		<!-- Right navbar links -->
		<ul id="ew-navbar-right" class="navbar-nav ml-auto"></ul>
	</nav>
	<!-- /.navbar -->
	<!-- Main Sidebar Container -->
	<aside class="<?php echo Config("SIDEBAR_CLASS") ?>">
		<!-- Brand Logo //** Note: Only licensed users are allowed to change the logo ** -->
		<a href="processflist.php" class="brand-link">
			<img src="<?php echo $RELATIVE_PATH ?>images/aci.GIF" alt="" class="brand-image ew-brand-image">
		</a>
		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar Menu -->
			<nav id="ew-menu" class="mt-2"></nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
	<?php if (Config("PAGE_TITLE_STYLE") != "None") { ?>
			<div class="container-fluid">
				<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><?php echo CurrentPageHeading() ?> <small class="text-muted"><?php echo CurrentPageSubheading() ?></small></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<?php Breadcrumb()->render() ?>
				</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
	<?php } ?>
		</div>
		<!-- /.content-header -->
		<!-- Main content -->
		<section class="content">
		<div class="container-fluid">
<?php } ?>
<?php } ?>