<?php

/**
 * PHPMaker 2020 configuration file
 */
namespace PHPMaker2020\SupplierMapping;

// Prerequisite
if (version_compare(PHP_VERSION, "5.6.0") < 0) // Is PHP 5.6 or later
	die("This script requires PHP 5.6 or later, but you are running " . phpversion() . ".");
if (!function_exists("xml_parser_create"))
	die("This script requires PHP XML Parser.");

/**
 * Constants
 */
define(__NAMESPACE__ . "\PROJECT_NAMESPACE", __NAMESPACE__ . "\\");

// System
define(PROJECT_NAMESPACE . "IS_WINDOWS", strtolower(substr(PHP_OS, 0, 3)) === "win"); // Is Windows OS
define(PROJECT_NAMESPACE . "PATH_DELIMITER", IS_WINDOWS ? "\\" : "/"); // Physical path delimiter

// Data types
define(PROJECT_NAMESPACE . "DATATYPE_NUMBER", 1);
define(PROJECT_NAMESPACE . "DATATYPE_DATE", 2);
define(PROJECT_NAMESPACE . "DATATYPE_STRING", 3);
define(PROJECT_NAMESPACE . "DATATYPE_BOOLEAN", 4);
define(PROJECT_NAMESPACE . "DATATYPE_MEMO", 5);
define(PROJECT_NAMESPACE . "DATATYPE_BLOB", 6);
define(PROJECT_NAMESPACE . "DATATYPE_TIME", 7);
define(PROJECT_NAMESPACE . "DATATYPE_GUID", 8);
define(PROJECT_NAMESPACE . "DATATYPE_XML", 9);
define(PROJECT_NAMESPACE . "DATATYPE_BIT", 10);
define(PROJECT_NAMESPACE . "DATATYPE_OTHER", 11);

// Row types
define(PROJECT_NAMESPACE . "ROWTYPE_HEADER", 0); // Row type header
define(PROJECT_NAMESPACE . "ROWTYPE_VIEW", 1); // Row type view
define(PROJECT_NAMESPACE . "ROWTYPE_ADD", 2); // Row type add
define(PROJECT_NAMESPACE . "ROWTYPE_EDIT", 3); // Row type edit
define(PROJECT_NAMESPACE . "ROWTYPE_SEARCH", 4); // Row type search
define(PROJECT_NAMESPACE . "ROWTYPE_MASTER", 5); // Row type master record
define(PROJECT_NAMESPACE . "ROWTYPE_AGGREGATEINIT", 6); // Row type aggregate init
define(PROJECT_NAMESPACE . "ROWTYPE_AGGREGATE", 7); // Row type aggregate
define(PROJECT_NAMESPACE . "ROWTYPE_DETAIL", 8); // Row type detail
define(PROJECT_NAMESPACE . "ROWTYPE_TOTAL", 9); // Row type group summary
define(PROJECT_NAMESPACE . "ROWTYPE_PREVIEW", 10); // Preview record

// Row total types
define(PROJECT_NAMESPACE . "ROWTOTAL_GROUP", 1); // Page summary
define(PROJECT_NAMESPACE . "ROWTOTAL_PAGE", 2); // Page summary
define(PROJECT_NAMESPACE . "ROWTOTAL_GRAND", 3); // Grand summary

// Row total sub types
define(PROJECT_NAMESPACE . "ROWTOTAL_HEADER", 0); // Header
define(PROJECT_NAMESPACE . "ROWTOTAL_FOOTER", 1); // Footer
define(PROJECT_NAMESPACE . "ROWTOTAL_SUM", 2); // SUM
define(PROJECT_NAMESPACE . "ROWTOTAL_AVG", 3); // AVG
define(PROJECT_NAMESPACE . "ROWTOTAL_MIN", 4); // MIN
define(PROJECT_NAMESPACE . "ROWTOTAL_MAX", 5); // MAX
define(PROJECT_NAMESPACE . "ROWTOTAL_CNT", 6); // CNT

// Empty/Null/Not Null/Init/all values
define(PROJECT_NAMESPACE . "EMPTY_VALUE", "##empty##");
define(PROJECT_NAMESPACE . "INIT_VALUE", "##init##");
define(PROJECT_NAMESPACE . "ALL_VALUE", "##all##");

// List actions
define(PROJECT_NAMESPACE . "ACTION_POSTBACK", "P"); // Post back
define(PROJECT_NAMESPACE . "ACTION_AJAX", "A"); // Ajax
define(PROJECT_NAMESPACE . "ACTION_MULTIPLE", "M"); // Multiple records
define(PROJECT_NAMESPACE . "ACTION_SINGLE", "S"); // Single record

// User level constants
define(PROJECT_NAMESPACE . "ALLOW_ADD", 1); // Add
define(PROJECT_NAMESPACE . "ALLOW_DELETE", 2); // Delete
define(PROJECT_NAMESPACE . "ALLOW_EDIT", 4); // Edit
define(PROJECT_NAMESPACE . "ALLOW_LIST", 8); // List
define(PROJECT_NAMESPACE . "ALLOW_REPORT", 8); // Report
define(PROJECT_NAMESPACE . "ALLOW_ADMIN", 16); // Admin
define(PROJECT_NAMESPACE . "ALLOW_VIEW", 32); // View
define(PROJECT_NAMESPACE . "ALLOW_SEARCH", 64); // Search
define(PROJECT_NAMESPACE . "ALLOW_IMPORT", 128); // Import
define(PROJECT_NAMESPACE . "ALLOW_LOOKUP", 256); // Lookup
define(PROJECT_NAMESPACE . "ALLOW_ALL", 511); // All (1 + 2 + 4 + 8 + 16 + 32 + 64 + 128 + 256)

// Product version
define(PROJECT_NAMESPACE . "PRODUCT_VERSION", "16.0.12");

// Project
define(PROJECT_NAMESPACE . "PROJECT_NAME", "SupplierMapping"); // Project name

/**
 * Character encoding
 * Note: If you use non English languages, you need to set character encoding
 * for some features. Make sure either iconv functions or multibyte string
 * functions are enabled and your encoding is supported. See PHP manual for
 * details.
 */
define(PROJECT_NAMESPACE . "PROJECT_ENCODING", "UTF-8"); // Character encoding
define(PROJECT_NAMESPACE . "IS_DOUBLE_BYTE", in_array(PROJECT_ENCODING, ["GBK", "BIG5", "SHIFT_JIS"])); // Double-byte character encoding
define(PROJECT_NAMESPACE . "FILE_SYSTEM_ENCODING", ""); // File system encoding

// Database
define(PROJECT_NAMESPACE . "IS_MSACCESS", FALSE); // Access
if (!IS_WINDOWS && IS_MSACCESS)
	die("Microsoft Access is supported on Windows server only.");
define(PROJECT_NAMESPACE . "IS_MSSQL", FALSE); // SQL Server
define(PROJECT_NAMESPACE . "IS_MYSQL", TRUE); // MySQL
define(PROJECT_NAMESPACE . "IS_POSTGRESQL", FALSE); // PostgreSQL
define(PROJECT_NAMESPACE . "IS_ORACLE", FALSE); // Oracle
define(PROJECT_NAMESPACE . "IS_SQLITE", FALSE); // SQLite
define(PROJECT_NAMESPACE . "DB_QUOTE_START", "`");
define(PROJECT_NAMESPACE . "DB_QUOTE_END", "`");
define(PROJECT_NAMESPACE . "DB_FETCH_DEFAULT", 0);
define(PROJECT_NAMESPACE . "DB_FETCH_NUM", 1);
define(PROJECT_NAMESPACE . "DB_FETCH_ASSOC", 2);
define(PROJECT_NAMESPACE . "DB_FETCH_BOTH", 3);

// Session
define(PROJECT_NAMESPACE . "SESSION_STATUS", PROJECT_NAME . "_status"); // Login status
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE", SESSION_STATUS . "_UserProfile"); // User profile
define(PROJECT_NAMESPACE . "SESSION_USER_NAME", SESSION_STATUS . "_UserName"); // User name
define(PROJECT_NAMESPACE . "SESSION_USER_LOGIN_TYPE", SESSION_STATUS . "_UserLoginType"); // User login type
define(PROJECT_NAMESPACE . "SESSION_USER_ID", SESSION_STATUS . "_UserID"); // User ID
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE_USER_NAME", SESSION_USER_PROFILE . "_UserName");
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE_PASSWORD", SESSION_USER_PROFILE . "_Password");
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE_LOGIN_TYPE", SESSION_USER_PROFILE . "_LoginType");
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_ID", SESSION_STATUS . "_UserLevel"); // User Level ID
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_LIST", SESSION_STATUS . "_UserLevelList"); // User Level List
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_LIST_LOADED", SESSION_STATUS . "_UserLevelListLoaded"); // User Level List Loaded
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL", SESSION_STATUS . "_UserLevelValue"); // User Level
define(PROJECT_NAMESPACE . "SESSION_PARENT_USER_ID", SESSION_STATUS . "_ParentUserId"); // Parent User ID
define(PROJECT_NAMESPACE . "SESSION_SYS_ADMIN", PROJECT_NAME . "_SysAdmin"); // System admin
define(PROJECT_NAMESPACE . "SESSION_PROJECT_ID", PROJECT_NAME . "_ProjectId"); // User Level project ID
define(PROJECT_NAMESPACE . "SESSION_AR_USER_LEVEL", PROJECT_NAME . "_arUserLevel"); // User Level array
define(PROJECT_NAMESPACE . "SESSION_AR_USER_LEVEL_PRIV", PROJECT_NAME . "_arUserLevelPriv"); // User Level privilege array
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_MSG", PROJECT_NAME . "_UserLevelMessage"); // User Level Message
define(PROJECT_NAMESPACE . "SESSION_MESSAGE", PROJECT_NAME . "_Message"); // System message
define(PROJECT_NAMESPACE . "SESSION_FAILURE_MESSAGE", PROJECT_NAME . "_FailureMessage"); // System error message
define(PROJECT_NAMESPACE . "SESSION_SUCCESS_MESSAGE", PROJECT_NAME . "_SuccessMessage"); // System message
define(PROJECT_NAMESPACE . "SESSION_WARNING_MESSAGE", PROJECT_NAME . "_WarningMessage"); // Warning message
define(PROJECT_NAMESPACE . "SESSION_INLINE_MODE", PROJECT_NAME . "_InlineMode"); // Inline mode
define(PROJECT_NAMESPACE . "SESSION_BREADCRUMB", PROJECT_NAME . "_Breadcrumb"); // Breadcrumb
define(PROJECT_NAMESPACE . "SESSION_TEMP_IMAGES", PROJECT_NAME . "_TempImages"); // Temp images
define(PROJECT_NAMESPACE . "SESSION_CAPTCHA_CODE", PROJECT_NAME . "_Captcha"); // Captcha code
define(PROJECT_NAMESPACE . "SESSION_LANGUAGE_ID", PROJECT_NAME . "_LanguageId"); // Language ID

// ADOdb
define(PROJECT_NAMESPACE . "USE_ADODB", FALSE); // Use ADOdb
if (!isset($GLOBALS["ADODB_OUTP"]))
	$GLOBALS["ADODB_OUTP"] = PROJECT_NAMESPACE . 'SetDebugMessage';

/**
 * Config
 */
$CONFIG = [

	// Debug
	"DEBUG" => FALSE, // TRUE to debug

	// General
	"UNFORMAT_YEAR" => 50, // Unformat year
	"RANDOM_KEY" => 'vjgkGcenx1D9gTim', // Random key for encryption
	"ENCRYPTION_KEY" => '', // Encryption key for data protection
	"PROJECT_STYLESHEET_FILENAME" => "css/SupplierMapping.css", // Project stylesheet file name
	"PROJECT_CHARSET" => "utf-8", // Project charset
	"IS_UTF8" => TRUE, // Project charset
	"EMAIL_CHARSET" => "utf-8", // Email charset
	"HIGHLIGHT_COMPARE" => TRUE, // Highlight compare mode, TRUE(case-insensitive)|FALSE(case-sensitive)
	"PROJECT_ID" => "{2CD6C8DB-382E-4A2A-9B16-71820446E001}", // Project ID (GUID)
	"RELATED_PROJECT_ID" => "", // Related Project ID (GUID)
	"COMPOSITE_KEY_SEPARATOR" => ",", // Composite key separator
	"LAZY_LOAD" => TRUE, // Lazy loading of images
	"BODY_CLASS" => "hold-transition layout-fixed",
	"SIDEBAR_CLASS" => "main-sidebar sidebar-dark-primary",
	"NAVBAR_CLASS" => "main-header navbar navbar-expand navbar-primary navbar-dark",

	// Check Token
	"CHECK_TOKEN" => TRUE,

	// Remove XSS
	"REMOVE_XSS" => TRUE,

	// Class path
	"CLASS_PATH" => "classes/", // With trailing delimiter

	// Font path
	"FONT_PATH" => realpath($RELATIVE_PATH . "font"), // No trailing delimiter

	// Font Awesome
	"USE_FONT_AWESOME_4" => FALSE,

	// External JavaScripts
	"JAVASCRIPT_FILES" => ["plugins/colorpicker/bootstrap-colorpicker.min.js"],

	// External StyleSheets
	"STYLESHEET_FILES" => ["plugins/colorpicker/bootstrap-colorpicker.min.css"],

	// Authentication configuration for Google/Facebook
	"AUTH_CONFIG" => [
		"providers" => [
			"Google" => [
				"enabled" => FALSE,
				"keys" => ["id" => "", "secret" => ""],
				"color" => "danger"
			],
			"Facebook" => [
				"enabled" => FALSE,
				"keys" => ["id" => "", "secret" => ""],
				"color" => "primary"
			]
		],
		"debug_mode" => FALSE,
		"debug_file" => "",
		"curl_options" => NULL
	],

	// Database connection info
	"CONNECTION_INFO" => [
		"DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "172.16.0.71", "port" => 3306, "user" => "root", "pass" => "Ac1turr1", "db" => "suppliermapping"]
	],

	// Database error function
	"ERROR_FUNC" => PROJECT_NAMESPACE . "ErrorFunc",

	// ADODB (Access)
	"PROJECT_CODEPAGE" => 65001, // Code page

	/**
	 * Database time zone
	 * Difference to Greenwich time (GMT) with colon between hours and minutes, e.g. +02:00
	 */
	"DB_TIME_ZONE" => "",

	/**
	 * MySQL charset (for SET NAMES statement, not used by default)
	 * Note: Read https://dev.mysql.com/doc/refman/8.0/en/charset-connection.html
	 * before using this setting.
	 */
	"MYSQL_CHARSET" => "utf8",

	/**
	 * PostgreSQL charset (for SET NAMES statement, not used by default)
	 * Note: Read https://www.postgresql.org/docs/current/static/multibyte.html
	 * before using this setting.
	 */
	"POSTGRESQL_CHARSET" => "UTF8",

	/**
	 * Password (hashed and case-sensitivity)
	 * Note: If you enable hashed password, make sure that the passwords in your
	 * user table are stored as hash of the clear text password. If you also use
	 * case-insensitive password, convert the clear text passwords to lower case
	 * first before calculating hash. Otherwise, existing users will not be able
	 * to login. Hashed password is irreversible, it will be reset during password recovery.
	 */
	"ENCRYPTED_PASSWORD" => FALSE, // Use encrypted password
	"CASE_SENSITIVE_PASSWORD" => FALSE, // Case-sensitive password

	// Session timeout time
	"SESSION_TIMEOUT" => 0, // Session timeout time (minutes)

	// Session keep alive interval
	"SESSION_KEEP_ALIVE_INTERVAL" => 0, // Session keep alive interval (seconds)
	"SESSION_TIMEOUT_COUNTDOWN" => 60, // Session timeout count down interval (seconds)

	// Language settings
	"LANGUAGE_FOLDER" => $RELATIVE_PATH . "lang/",
	"LANGUAGE_DEFAULT_ID" => "en",
	"LOCALE_FOLDER" => $RELATIVE_PATH . "locale/",

	// Antiforgery token
	"TOKEN_NAME" => "token", // DO NOT CHANGE!
	"CHECK_TOKEN_FUNC" => PROJECT_NAMESPACE . "CheckToken",
	"CREATE_TOKEN_FUNC" => PROJECT_NAMESPACE . "CreateToken",
	"CUSTOM_TEMPLATE_DATATYPES" => [DATATYPE_NUMBER, DATATYPE_DATE, DATATYPE_STRING, DATATYPE_BOOLEAN, DATATYPE_TIME], // Data to be passed to Custom Template
	"DATA_STRING_MAX_LENGTH" => 512,

	// Table parameters
	"TABLE_PREFIX" => "||PHPReportMaker||", // For backward compatibility only
	"TABLE_REC_PER_PAGE" => "recperpage", // Records per page
	"TABLE_START_REC" => "start", // Start record
	"TABLE_PAGE_NO" => "pageno", // Page number
	"TABLE_BASIC_SEARCH" => "psearch", // Basic search keyword
	"TABLE_BASIC_SEARCH_TYPE" => "psearchtype", // Basic search type
	"TABLE_ADVANCED_SEARCH" => "advsrch", // Advanced search
	"TABLE_SEARCH_WHERE" => "searchwhere", // Search where clause
	"TABLE_WHERE" => "where", // Table where
	"TABLE_WHERE_LIST" => "where_list", // Table where (list page)
	"TABLE_ORDER_BY" => "orderby", // Table order by
	"TABLE_ORDER_BY_LIST" => "orderby_list", // Table order by (list page)
	"TABLE_SORT" => "sort", // Table sort
	"TABLE_KEY" => "key", // Table key
	"TABLE_SHOW_MASTER" => "showmaster", // Table show master
	"TABLE_SHOW_DETAIL" => "showdetail", // Table show detail
	"TABLE_MASTER_TABLE" => "mastertable", // Master table
	"TABLE_DETAIL_TABLE" => "detailtable", // Detail table
	"TABLE_RETURN_URL" => "return", // Return URL
	"TABLE_EXPORT_RETURN_URL" => "exportreturn", // Export return URL
	"TABLE_GRID_ADD_ROW_COUNT" => "gridaddcnt", // Grid add row count

	// Audit Trail
	"AUDIT_TRAIL_TO_DATABASE" => FALSE, // Write audit trail to DB
	"AUDIT_TRAIL_DBID" => "DB", // Audit trail DBID
	"AUDIT_TRAIL_TABLE_NAME" => "", // Audit trail table name
	"AUDIT_TRAIL_TABLE_VAR" => "", // Audit trail table var
	"AUDIT_TRAIL_FIELD_NAME_DATETIME" => "", // Audit trail DateTime field name
	"AUDIT_TRAIL_FIELD_NAME_SCRIPT" => "", // Audit trail Script field name
	"AUDIT_TRAIL_FIELD_NAME_USER" => "", // Audit trail User field name
	"AUDIT_TRAIL_FIELD_NAME_ACTION" => "", // Audit trail Action field name
	"AUDIT_TRAIL_FIELD_NAME_TABLE" => "", // Audit trail Table field name
	"AUDIT_TRAIL_FIELD_NAME_FIELD" => "", // Audit trail Field field name
	"AUDIT_TRAIL_FIELD_NAME_KEYVALUE" => "", // Audit trail Key Value field name
	"AUDIT_TRAIL_FIELD_NAME_OLDVALUE" => "", // Audit trail Old Value field name
	"AUDIT_TRAIL_FIELD_NAME_NEWVALUE" => "", // Audit trail New Value field name

	// Security
	"ENCRYPTION_ENABLED" => FALSE, // Encryption enabled
	"ADMIN_USER_NAME" => "", // Administrator user name
	"ADMIN_PASSWORD" => "", // Administrator password
	"USE_CUSTOM_LOGIN" => TRUE, // Use custom login
	"ALLOW_LOGIN_BY_URL" => FALSE, // Allow login by URL
	"ALLOW_LOGIN_BY_SESSION" => FALSE, // Allow login by session variables
	"PHPASS_ITERATION_COUNT_LOG2" => [10, 8], // For PasswordHash
	"PASSWORD_HASH" => FALSE, // Use PHP 5.5+ password hashing functions

	// Hierarchical User ID
	"USER_ID_IS_HIERARCHICAL" => TRUE, // Change to FALSE to show one level only

	// Use subquery for master/detail
	"USE_SUBQUERY_FOR_MASTER_USER_ID" => FALSE,

	// User ID
	"USER_ID_ALLOW" => 104,

	// User table/field names
	"USER_TABLE_NAME" => "",
	"LOGIN_USERNAME_FIELD_NAME" => "",
	"LOGIN_PASSWORD_FIELD_NAME" => "",
	"USER_ID_FIELD_NAME" => "",
	"PARENT_USER_ID_FIELD_NAME" => "",
	"USER_LEVEL_FIELD_NAME" => "",
	"USER_PROFILE_FIELD_NAME" => "",
	"REGISTER_ACTIVATE_FIELD_NAME" => "",
	"USER_EMAIL_FIELD_NAME" => "",

	// User Profile Constants
	"USER_PROFILE_SESSION_ID" => "SessionID",
	"USER_PROFILE_LAST_ACCESSED_DATE_TIME" => "LastAccessedDateTime",
	"USER_PROFILE_CONCURRENT_SESSION_COUNT" => 1, // Maximum sessions allowed
	"USER_PROFILE_SESSION_TIMEOUT" => 20,
	"USER_PROFILE_LOGIN_RETRY_COUNT" => "LoginRetryCount",
	"USER_PROFILE_LAST_BAD_LOGIN_DATE_TIME" => "LastBadLoginDateTime",
	"USER_PROFILE_MAX_RETRY" => 3,
	"USER_PROFILE_RETRY_LOCKOUT" => 20,
	"USER_PROFILE_LAST_PASSWORD_CHANGED_DATE" => "LastPasswordChangedDate",
	"USER_PROFILE_PASSWORD_EXPIRE" => 90,
	"USER_PROFILE_LANGUAGE_ID" => "LanguageId",
	"USER_PROFILE_SEARCH_FILTERS" => "SearchFilters",
	"SEARCH_FILTER_OPTION" => "Client",

	// Email
	"PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
	"SMTP_SERVER" => "localhost", // SMTP server
	"SMTP_SERVER_PORT" => 25, // SMTP server port
	"SMTP_SECURE_OPTION" => "",
	"SMTP_SERVER_USERNAME" => "", // SMTP server user name
	"SMTP_SERVER_PASSWORD" => "", // SMTP server password
	"SENDER_EMAIL" => "", // Sender email address
	"RECIPIENT_EMAIL" => "", // Recipient email address
	"MAX_EMAIL_RECIPIENT" => 3,
	"MAX_EMAIL_SENT_COUNT" => 3,
	"EXPORT_EMAIL_COUNTER" => SESSION_STATUS . "_EmailCounter",
	"EMAIL_CHANGE_PASSWORD_TEMPLATE" => "changepwd.html",
	"EMAIL_NOTIFY_TEMPLATE" => "notify.html",
	"EMAIL_REGISTER_TEMPLATE" => "register.html",
	"EMAIL_RESET_PASSWORD_TEMPLATE" => "resetpwd.html",
	"EMAIL_TEMPLATE_PATH" => "html", // Template path

	// Remote file
	"REMOTE_FILE_PATTERN" => '/^((https?\:)?|ftps?\:|s3:)\/\//i',

	// File upload
	"UPLOAD_TEMP_PATH" => "", // Upload temp path (absolute local physical path)
	"UPLOAD_TEMP_HREF_PATH" => "", // Upload temp href path (absolute URL path for download)
	"UPLOAD_DEST_PATH" => "/upload/", // Upload destination path (relative to app root)
	"UPLOAD_HREF_PATH" => "", // Upload file href path (for download)
	"UPLOAD_TEMP_FOLDER_PREFIX" => "temp__", // Upload temp folders prefix
	"UPLOAD_TEMP_FOLDER_TIME_LIMIT" => 1440, // Upload temp folder time limit (minutes)
	"UPLOAD_THUMBNAIL_FOLDER" => "thumbnail", // Temporary thumbnail folder
	"UPLOAD_THUMBNAIL_WIDTH" => 200, // Temporary thumbnail max width
	"UPLOAD_THUMBNAIL_HEIGHT" => 0, // Temporary thumbnail max height
	"UPLOAD_ALLOWED_FILE_EXT" => "gif,jpg,jpeg,bmp,png,doc,docx,xls,xlsx,pdf,zip", // Allowed file extensions
	"IMAGE_ALLOWED_FILE_EXT" => "gif,jpe,jpeg,jpg,png,bmp", // Allowed file extensions for images
	"DOWNLOAD_ALLOWED_FILE_EXT" => "csv,pdf,xls,doc,xlsx,docx", // Allowed file extensions for download (non-image)
	"ENCRYPT_FILE_PATH" => TRUE, // Encrypt file path
	"MAX_FILE_SIZE" => 2000000, // Max file size
	"MAX_FILE_COUNT" => 0, // Max file count
	"THUMBNAIL_DEFAULT_WIDTH" => 0, // Thumbnail default width
	"THUMBNAIL_DEFAULT_HEIGHT" => 0, // Thumbnail default height
	"UPLOADED_FILE_MODE" => 0666, // Uploaded file mode
	"USER_UPLOAD_TEMP_PATH" => "", // User upload temp path (relative to app root) e.g. "tmp/"
	"UPLOAD_CONVERT_ACCENTED_CHARS" => FALSE, // Convert accented chars in upload file name
	"USE_COLORBOX" => TRUE, // Use Colorbox
	"MULTIPLE_UPLOAD_SEPARATOR" => ",", // Multiple upload separator
	"DELETE_UPLOADED_FILES" => FALSE, // Delete uploaded file on deleting record
	"FILE_NOT_FOUND" => "/9j/4AAQSkZJRgABAQAAAQABAAD/7QAuUGhvdG9zaG9wIDMuMAA4QklNBAQAAAAAABIcAigADEZpbGVOb3RGb3VuZAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wgARCAABAAEDAREAAhEBAxEB/8QAFAABAAAAAAAAAAAAAAAAAAAACP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhADEAAAAD+f/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPwB//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAgEBPwB//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAwEBPwB//9k=", // 1x1 jpeg with IPTC data "2#040"="FileNotFound"

	// API
	"API_URL" => "api/index.php", // API accessor URL
	"API_ACTION_NAME" => "action", // API action name
	"API_OBJECT_NAME" => "object", // API object name
	"API_FIELD_NAME" => "field", // API field name
	"API_KEY_NAME" => "key", // API key name
	"API_LIST_ACTION" => "list", // API list action
	"API_VIEW_ACTION" => "view", // API view action
	"API_ADD_ACTION" => "add", // API add action
	"API_EDIT_ACTION" => "edit", // API edit action
	"API_DELETE_ACTION" => "delete", // API delete action
	"API_LOGIN_ACTION" => "login", // API login action
	"API_FILE_ACTION" => "file", // API file action
	"API_UPLOAD_ACTION" => "upload", // API upload action
	"API_FILE_TOKEN_NAME" => "filetoken", // API upload file token name
	"API_JQUERY_UPLOAD_ACTION" => "jupload", // API jQuery upload action
	"API_SESSION_ACTION" => "session", // API get session action
	"API_LOOKUP_ACTION" => "lookup", // API lookup action
	"API_LOGIN_USERNAME" => "username", // API login user name
	"API_LOGIN_PASSWORD" => "password", // API login password
	"API_LOOKUP_PAGE" => "page", // API lookup page name
	"API_PROGRESS_ACTION" => "progress", // API progress action
	"API_EXPORT_CHART_ACTION" => "chart", // API export chart action

	// URL rewrite // PHP
	"USE_URL_REWRITE" => FALSE, // Use URL rewrite

	// Image resize
	"THUMBNAIL_CLASS" => "\PHPThumb\GD",
	"RESIZE_OPTIONS" => ["keepAspectRatio" => FALSE, "resizeUp" => !TRUE, "jpegQuality" => 100],

	// Audit trail
	"AUDIT_TRAIL_PATH" => "", // Audit trail path (relative to app root)

	// Import records
	"IMPORT_CSV_DELIMITER" => ",", // Import to CSV delimiter
	"IMPORT_CSV_QUOTE_CHARACTER" => "\"", // Import to CSV quote character
	"IMPORT_MAX_EXECUTION_TIME" => 300, // Import max execution time
	"IMPORT_FILE_ALLOWED_EXT" => "csv,xls,xlsx", // Import file allowed extensions
	"IMPORT_INSERT_ONLY" => TRUE, // Import by insert only
	"IMPORT_USE_TRANSACTION" => FALSE, // Import use transaction

	// Export records
	"EXPORT_ALL" => TRUE, // Export all records
	"EXPORT_ALL_TIME_LIMIT" => 120, // Export all records time limit
	"XML_ENCODING" => "utf-8", // Encoding for Export to XML
	"EXPORT_ORIGINAL_VALUE" => FALSE,
	"EXPORT_FIELD_CAPTION" => FALSE, // TRUE to export field caption
	"EXPORT_FIELD_IMAGE" => TRUE, // TRUE to export field image
	"EXPORT_CSS_STYLES" => TRUE, // TRUE to export CSS styles
	"EXPORT_MASTER_RECORD" => TRUE, // TRUE to export master record
	"EXPORT_MASTER_RECORD_FOR_CSV" => FALSE, // TRUE to export master record for CSV
	"EXPORT_DETAIL_RECORDS" => TRUE, // TRUE to export detail records
	"EXPORT_DETAIL_RECORDS_FOR_CSV" => FALSE, // TRUE to export detail records for CSV
	"EXPORT_CLASSES" => [
		"email" => "ExportEmail",
		"html" => "ExportHtml",
		"word" => "ExportWord",
		"excel" => "ExportExcel",
		"pdf" => "ExportPdf",
		"csv" => "ExportCsv",
		"xml" => "ExportXml",
		"json" => "ExportJson"
	],

	// Full URL protocols ("http" or "https")
	"FULL_URL_PROTOCOLS" => [
		"href" => "", // Field hyperlink
		"upload" => "", // Upload page
		"resetpwd" => "", // Reset password
		"activate" => "", // Register page activate link
		"tmpfile" => "", // Upload temp file
		"auth" => "", // OAuth base URL
		"export" => "", // export (for reports)
		"genurl" => "" // generate URL (for reports)
	],

	// MIME types
	"MIME_TYPES" => [
		"323" => "text/h323",
		"3g2" => "video/3gpp2",
		"3gp2" => "video/3gpp2",
		"3gp" => "video/3gpp",
		"3gpp" => "video/3gpp",
		"aac" => "audio/aac",
		"aaf" => "application/octet-stream",
		"aca" => "application/octet-stream",
		"accdb" => "application/msaccess",
		"accde" => "application/msaccess",
		"accdt" => "application/msaccess",
		"acx" => "application/internet-property-stream",
		"adt" => "audio/vnd.dlna.adts",
		"adts" => "audio/vnd.dlna.adts",
		"afm" => "application/octet-stream",
		"ai" => "application/postscript",
		"aif" => "audio/x-aiff",
		"aifc" => "audio/aiff",
		"aiff" => "audio/aiff",
		"appcache" => "text/cache-manifest",
		"application" => "application/x-ms-application",
		"art" => "image/x-jg",
		"asd" => "application/octet-stream",
		"asf" => "video/x-ms-asf",
		"asi" => "application/octet-stream",
		"asm" => "text/plain",
		"asr" => "video/x-ms-asf",
		"asx" => "video/x-ms-asf",
		"atom" => "application/atom+xml",
		"au" => "audio/basic",
		"avi" => "video/x-msvideo",
		"axs" => "application/olescript",
		"bas" => "text/plain",
		"bcpio" => "application/x-bcpio",
		"bin" => "application/octet-stream",
		"bmp" => "image/bmp",
		"c" => "text/plain",
		"cab" => "application/vnd.ms-cab-compressed",
		"calx" => "application/vnd.ms-office.calx",
		"cat" => "application/vnd.ms-pki.seccat",
		"cdf" => "application/x-cdf",
		"chm" => "application/octet-stream",
		"class" => "application/x-java-applet",
		"clp" => "application/x-msclip",
		"cmx" => "image/x-cmx",
		"cnf" => "text/plain",
		"cod" => "image/cis-cod",
		"cpio" => "application/x-cpio",
		"cpp" => "text/plain",
		"crd" => "application/x-mscardfile",
		"crl" => "application/pkix-crl",
		"crt" => "application/x-x509-ca-cert",
		"csh" => "application/x-csh",
		"css" => "text/css",
		"csv" => "application/octet-stream",
		"cur" => "application/octet-stream",
		"dcr" => "application/x-director",
		"deploy" => "application/octet-stream",
		"der" => "application/x-x509-ca-cert",
		"dib" => "image/bmp",
		"dir" => "application/x-director",
		"disco" => "text/xml",
		"dlm" => "text/dlm",
		"doc" => "application/msword",
		"docm" => "application/vnd.ms-word.document.macroEnabled.12",
		"docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		"dot" => "application/msword",
		"dotm" => "application/vnd.ms-word.template.macroEnabled.12",
		"dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
		"dsp" => "application/octet-stream",
		"dtd" => "text/xml",
		"dvi" => "application/x-dvi",
		"dvr-ms" => "video/x-ms-dvr",
		"dwf" => "drawing/x-dwf",
		"dwp" => "application/octet-stream",
		"dxr" => "application/x-director",
		"eml" => "message/rfc822",
		"emz" => "application/octet-stream",
		"eot" => "application/vnd.ms-fontobject",
		"eps" => "application/postscript",
		"etx" => "text/x-setext",
		"evy" => "application/envoy",
		"fdf" => "application/vnd.fdf",
		"fif" => "application/fractals",
		"fla" => "application/octet-stream",
		"flr" => "x-world/x-vrml",
		"flv" => "video/x-flv",
		"gif" => "image/gif",
		"gtar" => "application/x-gtar",
		"gz" => "application/x-gzip",
		"h" => "text/plain",
		"hdf" => "application/x-hdf",
		"hdml" => "text/x-hdml",
		"hhc" => "application/x-oleobject",
		"hhk" => "application/octet-stream",
		"hhp" => "application/octet-stream",
		"hlp" => "application/winhlp",
		"hqx" => "application/mac-binhex40",
		"hta" => "application/hta",
		"htc" => "text/x-component",
		"htm" => "text/html",
		"html" => "text/html",
		"htt" => "text/webviewhtml",
		"hxt" => "text/html",
		"ical" => "text/calendar",
		"icalendar" => "text/calendar",
		"ico" => "image/x-icon",
		"ics" => "text/calendar",
		"ief" => "image/ief",
		"ifb" => "text/calendar",
		"iii" => "application/x-iphone",
		"inf" => "application/octet-stream",
		"ins" => "application/x-internet-signup",
		"isp" => "application/x-internet-signup",
		"IVF" => "video/x-ivf",
		"jar" => "application/java-archive",
		"java" => "application/octet-stream",
		"jck" => "application/liquidmotion",
		"jcz" => "application/liquidmotion",
		"jfif" => "image/pjpeg",
		"jpb" => "application/octet-stream",
		"jpg" => "image/jpeg", // Note: Use "jpg" first
		"jpeg" => "image/jpeg",
		"jpe" => "image/jpeg",
		"js" => "application/javascript",
		"json" => "application/json",
		"jsx" => "text/jscript",
		"latex" => "application/x-latex",
		"lit" => "application/x-ms-reader",
		"lpk" => "application/octet-stream",
		"lsf" => "video/x-la-asf",
		"lsx" => "video/x-la-asf",
		"lzh" => "application/octet-stream",
		"m13" => "application/x-msmediaview",
		"m14" => "application/x-msmediaview",
		"m1v" => "video/mpeg",
		"m2ts" => "video/vnd.dlna.mpeg-tts",
		"m3u" => "audio/x-mpegurl",
		"m4a" => "audio/mp4",
		"m4v" => "video/mp4",
		"man" => "application/x-troff-man",
		"manifest" => "application/x-ms-manifest",
		"map" => "text/plain",
		"mdb" => "application/x-msaccess",
		"mdp" => "application/octet-stream",
		"me" => "application/x-troff-me",
		"mht" => "message/rfc822",
		"mhtml" => "message/rfc822",
		"mid" => "audio/mid",
		"midi" => "audio/mid",
		"mix" => "application/octet-stream",
		"mmf" => "application/x-smaf",
		"mno" => "text/xml",
		"mny" => "application/x-msmoney",
		"mov" => "video/quicktime",
		"movie" => "video/x-sgi-movie",
		"mp2" => "video/mpeg",
		"mp3" => "audio/mpeg",
		"mp4" => "video/mp4",
		"mp4v" => "video/mp4",
		"mpa" => "video/mpeg",
		"mpe" => "video/mpeg",
		"mpeg" => "video/mpeg",
		"mpg" => "video/mpeg",
		"mpp" => "application/vnd.ms-project",
		"mpv2" => "video/mpeg",
		"ms" => "application/x-troff-ms",
		"msi" => "application/octet-stream",
		"mso" => "application/octet-stream",
		"mvb" => "application/x-msmediaview",
		"mvc" => "application/x-miva-compiled",
		"nc" => "application/x-netcdf",
		"nsc" => "video/x-ms-asf",
		"nws" => "message/rfc822",
		"ocx" => "application/octet-stream",
		"oda" => "application/oda",
		"odc" => "text/x-ms-odc",
		"ods" => "application/oleobject",
		"oga" => "audio/ogg",
		"ogg" => "video/ogg",
		"ogv" => "video/ogg",
		"ogx" => "application/ogg",
		"one" => "application/onenote",
		"onea" => "application/onenote",
		"onetoc" => "application/onenote",
		"onetoc2" => "application/onenote",
		"onetmp" => "application/onenote",
		"onepkg" => "application/onenote",
		"osdx" => "application/opensearchdescription+xml",
		"otf" => "font/otf",
		"p10" => "application/pkcs10",
		"p12" => "application/x-pkcs12",
		"p7b" => "application/x-pkcs7-certificates",
		"p7c" => "application/pkcs7-mime",
		"p7m" => "application/pkcs7-mime",
		"p7r" => "application/x-pkcs7-certreqresp",
		"p7s" => "application/pkcs7-signature",
		"pbm" => "image/x-portable-bitmap",
		"pcx" => "application/octet-stream",
		"pcz" => "application/octet-stream",
		"pdf" => "application/pdf",
		"pfb" => "application/octet-stream",
		"pfm" => "application/octet-stream",
		"pfx" => "application/x-pkcs12",
		"pgm" => "image/x-portable-graymap",
		"pko" => "application/vnd.ms-pki.pko",
		"pma" => "application/x-perfmon",
		"pmc" => "application/x-perfmon",
		"pml" => "application/x-perfmon",
		"pmr" => "application/x-perfmon",
		"pmw" => "application/x-perfmon",
		"png" => "image/png",
		"pnm" => "image/x-portable-anymap",
		"pnz" => "image/png",
		"pot" => "application/vnd.ms-powerpoint",
		"potm" => "application/vnd.ms-powerpoint.template.macroEnabled.12",
		"potx" => "application/vnd.openxmlformats-officedocument.presentationml.template",
		"ppam" => "application/vnd.ms-powerpoint.addin.macroEnabled.12",
		"ppm" => "image/x-portable-pixmap",
		"pps" => "application/vnd.ms-powerpoint",
		"ppsm" => "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
		"ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
		"ppt" => "application/vnd.ms-powerpoint",
		"pptm" => "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
		"pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
		"prf" => "application/pics-rules",
		"prm" => "application/octet-stream",
		"prx" => "application/octet-stream",
		"ps" => "application/postscript",
		"psd" => "application/octet-stream",
		"psm" => "application/octet-stream",
		"psp" => "application/octet-stream",
		"pub" => "application/x-mspublisher",
		"qt" => "video/quicktime",
		"qtl" => "application/x-quicktimeplayer",
		"qxd" => "application/octet-stream",
		"ra" => "audio/x-pn-realaudio",
		"ram" => "audio/x-pn-realaudio",
		"rar" => "application/octet-stream",
		"ras" => "image/x-cmu-raster",
		"rf" => "image/vnd.rn-realflash",
		"rgb" => "image/x-rgb",
		"rm" => "application/vnd.rn-realmedia",
		"rmi" => "audio/mid",
		"roff" => "application/x-troff",
		"rpm" => "audio/x-pn-realaudio-plugin",
		"rtf" => "application/rtf",
		"rtx" => "text/richtext",
		"scd" => "application/x-msschedule",
		"sct" => "text/scriptlet",
		"sea" => "application/octet-stream",
		"setpay" => "application/set-payment-initiation",
		"setreg" => "application/set-registration-initiation",
		"sgml" => "text/sgml",
		"sh" => "application/x-sh",
		"shar" => "application/x-shar",
		"sit" => "application/x-stuffit",
		"sldm" => "application/vnd.ms-powerpoint.slide.macroEnabled.12",
		"sldx" => "application/vnd.openxmlformats-officedocument.presentationml.slide",
		"smd" => "audio/x-smd",
		"smi" => "application/octet-stream",
		"smx" => "audio/x-smd",
		"smz" => "audio/x-smd",
		"snd" => "audio/basic",
		"snp" => "application/octet-stream",
		"spc" => "application/x-pkcs7-certificates",
		"spl" => "application/futuresplash",
		"spx" => "audio/ogg",
		"src" => "application/x-wais-source",
		"ssm" => "application/streamingmedia",
		"sst" => "application/vnd.ms-pki.certstore",
		"stl" => "application/vnd.ms-pki.stl",
		"sv4cpio" => "application/x-sv4cpio",
		"sv4crc" => "application/x-sv4crc",
		"svg" => "image/svg+xml",
		"svgz" => "image/svg+xml",
		"swf" => "application/x-shockwave-flash",
		"t" => "application/x-troff",
		"tar" => "application/x-tar",
		"tcl" => "application/x-tcl",
		"tex" => "application/x-tex",
		"texi" => "application/x-texinfo",
		"texinfo" => "application/x-texinfo",
		"tgz" => "application/x-compressed",
		"thmx" => "application/vnd.ms-officetheme",
		"thn" => "application/octet-stream",
		"tif" => "image/tiff",
		"tiff" => "image/tiff",
		"toc" => "application/octet-stream",
		"tr" => "application/x-troff",
		"trm" => "application/x-msterminal",
		"ts" => "video/vnd.dlna.mpeg-tts",
		"tsv" => "text/tab-separated-values",
		"ttc" => "application/x-font-ttf",
		"ttf" => "application/x-font-ttf",
		"tts" => "video/vnd.dlna.mpeg-tts",
		"txt" => "text/plain",
		"u32" => "application/octet-stream",
		"uls" => "text/iuls",
		"ustar" => "application/x-ustar",
		"vbs" => "text/vbscript",
		"vcf" => "text/x-vcard",
		"vcs" => "text/plain",
		"vdx" => "application/vnd.ms-visio.viewer",
		"vml" => "text/xml",
		"vsd" => "application/vnd.visio",
		"vss" => "application/vnd.visio",
		"vst" => "application/vnd.visio",
		"vsto" => "application/x-ms-vsto",
		"vsw" => "application/vnd.visio",
		"vsx" => "application/vnd.visio",
		"vtx" => "application/vnd.visio",
		"wav" => "audio/wav",
		"wax" => "audio/x-ms-wax",
		"wbmp" => "image/vnd.wap.wbmp",
		"wcm" => "application/vnd.ms-works",
		"wdb" => "application/vnd.ms-works",
		"webm" => "video/webm",
		"webp" => "image/webp",
		"wks" => "application/vnd.ms-works",
		"wm" => "video/x-ms-wm",
		"wma" => "audio/x-ms-wma",
		"wmd" => "application/x-ms-wmd",
		"wmf" => "application/x-msmetafile",
		"wml" => "text/vnd.wap.wml",
		"wmlc" => "application/vnd.wap.wmlc",
		"wmls" => "text/vnd.wap.wmlscript",
		"wmlsc" => "application/vnd.wap.wmlscriptc",
		"wmp" => "video/x-ms-wmp",
		"wmv" => "video/x-ms-wmv",
		"wmx" => "video/x-ms-wmx",
		"wmz" => "application/x-ms-wmz",
		"woff" => "application/font-woff",
		"woff2" => "application/font-woff2",
		"wps" => "application/vnd.ms-works",
		"wri" => "application/x-mswrite",
		"wrl" => "x-world/x-vrml",
		"wrz" => "x-world/x-vrml",
		"wsdl" => "text/xml",
		"wtv" => "video/x-ms-wtv",
		"wvx" => "video/x-ms-wvx",
		"x" => "application/directx",
		"xaf" => "x-world/x-vrml",
		"xaml" => "application/xaml+xml",
		"xap" => "application/x-silverlight-app",
		"xbap" => "application/x-ms-xbap",
		"xbm" => "image/x-xbitmap",
		"xdr" => "text/plain",
		"xht" => "application/xhtml+xml",
		"xhtml" => "application/xhtml+xml",
		"xla" => "application/vnd.ms-excel",
		"xlam" => "application/vnd.ms-excel.addin.macroEnabled.12",
		"xlc" => "application/vnd.ms-excel",
		"xlm" => "application/vnd.ms-excel",
		"xls" => "application/vnd.ms-excel",
		"xlsb" => "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
		"xlsm" => "application/vnd.ms-excel.sheet.macroEnabled.12",
		"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
		"xlt" => "application/vnd.ms-excel",
		"xltm" => "application/vnd.ms-excel.template.macroEnabled.12",
		"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
		"xlw" => "application/vnd.ms-excel",
		"xml" => "text/xml",
		"xof" => "x-world/x-vrml",
		"xpm" => "image/x-xpixmap",
		"xps" => "application/vnd.ms-xpsdocument",
		"xsd" => "text/xml",
		"xsf" => "text/xml",
		"xsl" => "text/xml",
		"xslt" => "text/xml",
		"xsn" => "application/octet-stream",
		"xtp" => "application/octet-stream",
		"xwd" => "image/x-xwindowdump",
		"z" => "application/x-compress",
		"zip" => "application/x-zip-compressed"
	],

	// Boolean HTML attributes
	"BOOLEAN_HTML_ATTRIBUTES" => [
		"allowfullscreen",
		"allowpaymentrequest",
		"async",
		"autofocus",
		"autoplay",
		"checked",
		"controls",
		"default",
		"defer",
		"disabled",
		"formnovalidate",
		"hidden",
		"ismap",
		"itemscope",
		"loop",
		"multiple",
		"muted",
		"nomodule",
		"novalidate",
		"open",
		"readonly",
		"required",
		"reversed",
		"selected",
		"typemustmatch"
	],

	// HTML singleton tags
	"HTML_SINGLETON_TAGS" => [
		"area",
		"base",
		"br",
		"col",
		"command",
		"embed",
		"hr",
		"img",
		"input",
		"keygen",
		"link",
		"meta",
		"param",
		"source",
		"track",
		"wbr"
	],

	// Use token in URL (reserved, not used, do NOT change!)
	"USE_TOKEN_IN_URL" => FALSE,

	// Use ILIKE for PostgreSQL
	"USE_ILIKE_FOR_POSTGRESQL" => TRUE,

	// Use collation for MySQL
	"LIKE_COLLATION_FOR_MYSQL" => "",

	// Use collation for MsSQL
	"LIKE_COLLATION_FOR_MSSQL" => "",

	// Null / Not Null values
	"NULL_VALUE" => "##null##",
	"NOT_NULL_VALUE" => "##notnull##",

	/**
	 * Search multi value option
	 * 1 - no multi value
	 * 2 - AND all multi values
	 * 3 - OR all multi values
	*/
	"SEARCH_MULTI_VALUE_OPTION" => 3,

	// Quick search
	"BASIC_SEARCH_IGNORE_PATTERN" => "/[\?,\.\^\*\(\)\[\]\\\"]/", // Ignore special characters
	"BASIC_SEARCH_ANY_FIELDS" => FALSE, // Search "All keywords" in any selected fields

	// Validate option
	"CLIENT_VALIDATE" => TRUE,
	"SERVER_VALIDATE" => FALSE,

	// Blob field byte count for hash value calculation
	"BLOB_FIELD_BYTE_COUNT" => 200,

	// Auto suggest max entries
	"AUTO_SUGGEST_MAX_ENTRIES" => 10,

	// Auto suggest for all display fields
	"AUTO_SUGGEST_FOR_ALL_FIELDS" => TRUE,

	// Auto fill original value
	"AUTO_FILL_ORIGINAL_VALUE" => TRUE,

	// Lookup
	"MULTIPLE_OPTION_SEPARATOR" => ",",
	"USE_LOOKUP_CACHE" => TRUE,
	"LOOKUP_CACHE_COUNT" => 100,

	// Page Title Style
	"PAGE_TITLE_STYLE" => "Breadcrumbs",

	// Responsive tables
	"USE_RESPONSIVE_TABLE" => TRUE,
	"RESPONSIVE_TABLE_CLASS" => "table-responsive",

	// Use css-flip
	"CSS_FLIP" => FALSE,
	"RTL_LANGUAGES" => ["ar", "fa", "he", "iw", "ug", "ur"],

	// Mulitple selection
	"OPTION_HTML_TEMPLATE" => '<span class="ew-option">{value}</span>', // Note: class="ew-option" must match CSS style in project stylesheet
	"OPTION_SEPARATOR" => ", ",

	// Cookies
	"CONSENT_COOKIE_NAME" => "ConsentCookie", // Consent cookie name
	"COOKIE_EXPIRY_TIME" => time() + 365*24*60*60, // Change cookie expiry time here
	"COOKIE_CONSENT_CLASS" => "toast-body bg-secondary", // CSS class name for cookie consent
	"COOKIE_CONSENT_BUTTON_CLASS" => "btn btn-dark btn-sm", // CSS class name for cookie consent buttons

	// Mime type
	"DEFAULT_MIME_TYPE" => "application/octet-stream",

	// Auto hide pager
	"AUTO_HIDE_PAGER" => FALSE,
	"AUTO_HIDE_PAGE_SIZE_SELECTOR" => FALSE,

	// Extensions
	"USE_PHPEXCEL" => FALSE,
	"USE_PHPWORD" => FALSE,
	"PDF_STYLESHEET_FILENAME" => "",

	/**
	 * Reports
	 */
	// Chart

	"CHART_SHOW_BLANK_SERIES" => FALSE, // Show blank series
	"CHART_SHOW_ZERO_IN_STACK_CHART" => FALSE, // Show zero in stack chart

	// Drill down setting
	"USE_DRILLDOWN_PANEL" => TRUE, // Use popup panel for drill down

	// Filter
	"SHOW_CURRENT_FILTER" => FALSE, // True to show current filter
	"SHOW_DRILLDOWN_FILTER" => TRUE, // True to show drill down filter

	// Table level constants
	"TABLE_GROUP_PER_PAGE" => "recperpage",
	"TABLE_START_GROUP" => "start",
	"TABLE_SORTCHART" => "sortc", // Table sort chart

	// Page break
	"PAGE_BREAK_HTML" => '<div style="page-break-after:always;"></div>',

	// Export reports
	"REPORT_EXPORT_FUNCTIONS" => [
		"email" => "exportReportEmail",
		"word" => "exportReportWord",
		"excel" => "exportReportExcel",
		"pdf" => "exportReportPdf"
	],

	// Embed PDF documents
	"EMBED_PDF" => TRUE,

	// Download PDF file (instead of shown in browser)
	"DOWNLOAD_PDF_FILE" => FALSE,

	// Advanced Filters
	"REPORT_ADVANCED_FILTERS" => [
		"PastFuture" => ["Past" => "IsPast", "Future" => "IsFuture"],
		"RelativeDayPeriods" => ["Last30Days" => "IsLast30Days", "Last14Days" => "IsLast14Days", "Last7Days" => "IsLast7Days", "Next7Days" => "IsNext7Days", "Next14Days" => "IsNext14Days", "Next30Days" => "IsNext30Days"],
		"RelativeDays" => ["Yesterday" => "IsYesterday", "Today" => "IsToday", "Tomorrow" => "IsTomorrow"],
		"RelativeWeeks" => ["LastTwoWeeks" => "IsLast2Weeks", "LastWeek" => "IsLastWeek", "ThisWeek" => "IsThisWeek", "NextWeek" => "IsNextWeek", "NextTwoWeeks" => "IsNext2Weeks"],
		"RelativeMonths" => ["LastMonth" => "IsLastMonth", "ThisMonth" => "IsThisMonth", "NextMonth" => "IsNextMonth"],
		"RelativeYears" => ["LastYear" => "IsLastYear", "ThisYear" => "IsThisYear", "NextYear" => "IsNextYear"]
	],

	// Float fields default decimal position
	"DEFAULT_DECIMAL_PRECISION" => 2,

	// Chart
	"DEFAULT_CHART_RENDERER" => "",

	// Date/Time without seconds
	"DATETIME_WITHOUT_SECONDS" => FALSE
];

/**
 * Locale settings
 * Note: DO NOT CHANGE THE FOLLOWING $* VARIABLES!
 * If you want to use custom settings, customize the locale files for FormatCurrency/Number/Percent functions.
 * Also read http://www.php.net/localeconv for description of the constants
*/
$DECIMAL_POINT = ".";
$THOUSANDS_SEP = ",";
$CURRENCY_SYMBOL = "$";
$MON_DECIMAL_POINT = ".";
$MON_THOUSANDS_SEP = ",";
$POSITIVE_SIGN = "";
$NEGATIVE_SIGN = "-";
$FRAC_DIGITS = 2;
$P_CS_PRECEDES = 1;
$P_SEP_BY_SPACE = 0;
$N_CS_PRECEDES = 1;
$N_SEP_BY_SPACE = 0;
$P_SIGN_POSN = 1;
$N_SIGN_POSN = 1;
$DATE_SEPARATOR = "/";
$TIME_SEPARATOR = ":";
$DATE_FORMAT = "yyyy/mm/dd";
$DATE_FORMAT_ID = 5;
$TIME_ZONE = "GMT";
$LOCALE = [
	"decimal_point" => &$DECIMAL_POINT,
	"thousands_sep" => &$THOUSANDS_SEP,
	"currency_symbol" => &$CURRENCY_SYMBOL,
	"mon_decimal_point" => &$MON_DECIMAL_POINT,
	"mon_thousands_sep" => &$MON_THOUSANDS_SEP,
	"positive_sign" => &$POSITIVE_SIGN,
	"negative_sign" => &$NEGATIVE_SIGN,
	"frac_digits" => &$FRAC_DIGITS,
	"p_cs_precedes" => &$P_CS_PRECEDES,
	"p_sep_by_space" => &$P_SEP_BY_SPACE,
	"n_cs_precedes" => &$N_CS_PRECEDES,
	"n_sep_by_space" => &$N_SEP_BY_SPACE,
	"p_sign_posn" => &$P_SIGN_POSN,
	"n_sign_posn" => &$N_SIGN_POSN,
	"date_sep" => &$DATE_SEPARATOR,
	"time_sep" => &$TIME_SEPARATOR,
	"date_format" => &$DATE_FORMAT,
	"time_zone" => &$TIME_ZONE
];

// Set default time zone
date_default_timezone_set($TIME_ZONE);

/**
 * Global variables
 */
$CONNECTIONS = []; // Connections
$LANGUAGES = [["en","","english.xml"]];
$Conn = NULL; // Primary connection
$Page = NULL; // Page
$UserTable = NULL; // User table
$Table = NULL; // Main table
$Grid = NULL; // Grid page object
$Language = NULL; // Language
$Security = NULL; // Security
$UserProfile = NULL; // User profile
$CurrentForm = NULL; // Form

// Current language
$CurrentLanguage = "";

// Token
$CurrentToken = "";

// Used by validateForm/validateSearch
$FormError = ""; // Form error message
$SearchError = ""; // Search form error message

// Used by header.php, export checking
$ExportType = "";
$ExportFileName = "";
$ReportExportType = "";
$CustomExportType = "";

// Used by header.php/footer.php, skip header/footer checking
$SkipHeaderFooter = FALSE;
$OldSkipHeaderFooter = $SkipHeaderFooter;

// Debug message
$DebugMessage = "";

// Debug timer
$DebugTimer = NULL;

// Keep temp image names for delete
$TempImages = [];

// Mobile detect
$MobileDetect = NULL;
$IsMobile = NULL;

// Breadcrumb
$Breadcrumb = NULL;

// Login status
$LoginStatus = [];

// LDAP
$Ldap = NULL;

// API
$Api = NULL;
$Request = NULL;
$Response = NULL;
$RequestSecurity = NULL;

// HTML purifier
$PurifierConfig = NULL;
$Purifier = NULL;

// Captcha
$Captcha = NULL;
$CaptchaClass = "CaptchaBase";

// Dashboard report checking
$DashboardReport = FALSE;

// Drilldown panel
$DrillDownInPanel = FALSE;

// Chart
$Chart = NULL;

// Client variables
$ClientVariables = [];

// Custom API actions
$API_ACTIONS = [];

// User level
$USER_LEVELS = [];
$USER_LEVEL_PRIVS = [];
$USER_LEVEL_TABLES = [];
?>
<?php
$CONFIG["PDF_STYLESHEET_FILENAME"] = "css/ewpdf.css"; // Export PDF CSS styles
$CONFIG["PDF_MEMORY_LIMIT"] = "128M"; // Memory limit
$CONFIG["PDF_TIME_LIMIT"] = 120; // Time limit

// Make sure width/height not larger than page width/height or "infinite table loop" error
$CONFIG["PDF_MAX_IMAGE_WIDTH"] = 650; // Portrait
$CONFIG["PDF_MAX_IMAGE_HEIGHT"] = 900; // Portrait
$CONFIG["PDF_IMAGE_SCALE_FACTOR"] = 1.53; // Scale factor
?>