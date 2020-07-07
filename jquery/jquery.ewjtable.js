/*

ewjTable (requires ew*.js)
@license Copyright (C) 2017 by e.World Technology Limited (http://www.hkvstore.com)

Based on:

jTable 2.4.0
http://www.jtable.org

---------------------------------------------------------------------------

Copyright (C) 2011-2014 by Halil İbrahim Kalkan (http://www.halilibrahimkalkan.com)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

/************************************************************************
* CORE ewjTable module                                                    *
*************************************************************************/
(function ($) {

	var unloadingPage;

	$(window).on('beforeunload', function () {
		unloadingPage = true;
	});
	$(window).on('unload', function () {
		unloadingPage = false;
	});

	$.widget("ew.ewjtable", {

		/************************************************************************
		* DEFAULT OPTIONS / EVENTS                                              *
		*************************************************************************/
		options: {

			//Options
			actions: {},
			fields: {},
			animationsEnabled: true,
			defaultDateFormat: null,
			dialogShowEffect: 'fade',
			dialogHideEffect: 'fade',
			showCloseButton: false,
			loadingAnimationDelay: 500,
			saveUserPreferences: true,
			jqueryuiTheme: false,
			unAuthorizedRequestRedirectUrl: null,

			ajaxSettings: {
				type: 'POST',
				dataType: 'json'
			},

			toolbar: {
				hoverAnimation: true,
				hoverAnimationDuration: 60,
				hoverAnimationEasing: undefined,
				items: []
			},

			//Events
			closeRequested: function (event, data) { },
			formCreated: function (event, data) { },
			formSubmitting: function (event, data) { },
			formClosed: function (event, data) { },
			loadingRecords: function (event, data) { },
			recordsLoaded: function (event, data) { },
			rowInserted: function (event, data) { },
			rowsRemoved: function (event, data) { },

			//Localization
			messages: {
				serverCommunicationError: 'An error occured while communicating to the server.',
				loadingMessage: 'Loading records...',
				noDataAvailable: 'No data available!',
				close: 'Close'
			}

		},

		/************************************************************************
		* PRIVATE FIELDS                                                        *
		*************************************************************************/

		_$mainContainer: null, //Reference to the main container of all elements that are created by this plug-in (jQuery object)

		_$titleDiv: null, //Reference to the title div (jQuery object)
		_$toolbarDiv: null, //Reference to the toolbar div (jQuery object)

		_$table: null, //Reference to the main <table> (jQuery object)
		_$tableBody: null, //Reference to <body> in the table (jQuery object)
		_$tableRows: null, //Array of all <tr> in the table (except "no data" row) (jQuery object array)

		_$busyDiv: null, //Reference to the div that is used to block UI while busy (jQuery object)
		_$busyMessageDiv: null, //Reference to the div that is used to show some message when UI is blocked (jQuery object)

		_columnList: null, //Name of all data columns in the table (select column and command columns are not included) (string array)
		_fieldList: null, //Name of all fields of a record (defined in fields option) (string array)
		_keyField: null, //Name of the key field of a record (that is defined as 'key: true' in the fields option) (string)

		_firstDataColumnOffset: 0, //Start index of first record field in table columns (some columns can be placed before first data column, such as select checkbox column) (integer)
		_lastPostData: null, //Last posted data on load method (object)

		_cache: null, //General purpose cache dictionary (object)

		/************************************************************************
		* CONSTRUCTOR AND INITIALIZATION METHODS                                *
		*************************************************************************/

		/* Contructor.
		*************************************************************************/
		_create: function () {

			//Initialization
			this._normalizeFieldsOptions();
			this._initializeFields();
			this._createFieldAndColumnList();

			//Creating DOM elements
			this._createMainContainer();
			this._createTableTitle();
			this._createToolBar();
			this._createTable();
			this._createBusyPanel();
			this._addNoDataRow();

			this._cookieKeyPrefix = this._generateCookieKeyPrefix();
		},

		/* Normalizes some options for all fields (sets default values).
		*************************************************************************/
		_normalizeFieldsOptions: function () {
			var self = this;
			$.each(self.options.fields, function (fieldName, props) {
				self._normalizeFieldOptions(fieldName, props);
			});
		},

		/* Normalizes some options for a field (sets default values).
		*************************************************************************/
		_normalizeFieldOptions: function (fieldName, props) {
			if (props.listClass == undefined) {
				props.listClass = '';
			}
			if (props.inputClass == undefined) {
				props.inputClass = '';
			}

			//Convert dependsOn to array if it's a comma seperated lists
			if (props.dependsOn && $.type(props.dependsOn) === 'string') {
				var dependsOnArray = props.dependsOn.split(',');
				props.dependsOn = [];
				for (var i = 0; i < dependsOnArray.length; i++) {
					props.dependsOn.push($.trim(dependsOnArray[i]));
				}
			}
		},

		/* Intializes some private variables.
		*************************************************************************/
		_initializeFields: function () {
			this._lastPostData = {};
			this._$tableRows = [];
			this._columnList = [];
			this._fieldList = [];
			this._cache = [];
		},

		/* Fills _fieldList, _columnList arrays and sets _keyField variable.
		*************************************************************************/
		_createFieldAndColumnList: function () {
			var self = this;

			$.each(self.options.fields, function (name, props) {

				//Add field to the field list
				self._fieldList.push(name);

				//Check if this field is the key field
				if (props.key == true) {
					self._keyField = name;
				}

				//Add field to column list if it is shown in the table
				if (props.list != false && props.type != 'hidden') {
					self._columnList.push(name);
				}
			});
		},

		/* Creates the main container div.
		*************************************************************************/
		_createMainContainer: function () {
			this._$mainContainer = $('<div />')
				.addClass('ewjtable-main-container')
				.appendTo(this.element);

			this._jqueryuiThemeAddClass(this._$mainContainer, 'ui-widget');
		},

		/* Creates title of the table if a title supplied in options.
		*************************************************************************/
		_createTableTitle: function () {
			var self = this;

			if (!self.options.title) {
				return;
			}

			var $titleDiv = $('<div />')
				.addClass('ewjtable-title')
				.appendTo(self._$mainContainer);

			self._jqueryuiThemeAddClass($titleDiv, 'ui-widget-header');

			$('<div />')
				.addClass('ewjtable-title-text')
				.appendTo($titleDiv)
				.append(self.options.title);

			if (self.options.showCloseButton) {

				var $textSpan = $('<span />')
					.html(self.options.messages.close);

				$('<button></button>')
					.addClass('ewjtable-command-button ewjtable-close-button')
					.attr('title', self.options.messages.close)
					.append($textSpan)
					.appendTo($titleDiv)
					.click(function (e) {
						e.preventDefault();
						e.stopPropagation();
						self._onCloseRequested();
					});
			}

			self._$titleDiv = $titleDiv;
		},

		/* Creates the table.
		*************************************************************************/
		_createTable: function () {
			this._$table = $('<table></table>')
				.addClass('ewjtable table table-sm')
				.appendTo(this._$mainContainer);

			if (this.options.tableId) {
				this._$table.attr('id', this.options.tableId);
			}

			this._jqueryuiThemeAddClass(this._$table, 'ui-widget-content');

			this._createTableHead();
			this._createTableBody();
		},

		/* Creates header (all column headers) of the table.
		*************************************************************************/
		_createTableHead: function () {
			var $thead = $('<thead></thead>')
				.appendTo(this._$table);

			this._addRowToTableHead($thead);
		},

		/* Adds tr element to given thead element
		*************************************************************************/
		_addRowToTableHead: function ($thead) {
			var $tr = $('<tr></tr>')
				.appendTo($thead);

			this._addColumnsToHeaderRow($tr);
		},

		/* Adds column header cells to given tr element.
		*************************************************************************/
		_addColumnsToHeaderRow: function ($tr) {
			for (var i = 0; i < this._columnList.length; i++) {
				var fieldName = this._columnList[i];
				var $headerCell = this._createHeaderCellForField(fieldName, this.options.fields[fieldName]);
				$headerCell.appendTo($tr);
			}
		},

		/* Creates a header cell for given field.
		*  Returns th jQuery object.
		*************************************************************************/
		_createHeaderCellForField: function (fieldName, field) {
			//***field.width = field.width || '10%'; //default column width: 10%.

			var $headerTextSpan = $('<span />')
				.addClass('ewjtable-column-header-text')
				.html(field.title);

			var $headerContainerDiv = $('<div />')
				.addClass('ewjtable-column-header-container')
				.append($headerTextSpan);

			var $th = $('<th></th>')
				.addClass('ewjtable-column-header')
				.addClass(field.listClass)
				.css('width', field.width)
				.data('fieldName', fieldName)
				.append($headerContainerDiv);

			this._jqueryuiThemeAddClass($th, 'ui-state-default');

			return $th;
		},

		/* Creates an empty header cell that can be used as command column headers.
		*************************************************************************/
		_createEmptyCommandHeader: function () {
			var $th = $('<th></th>')
				.addClass('ewjtable-command-column-header')
				.css('width', '1%');

			this._jqueryuiThemeAddClass($th, 'ui-state-default');

			return $th;
		},

		/* Creates tbody tag and adds to the table.
		*************************************************************************/
		_createTableBody: function () {
			this._$tableBody = $('<tbody></tbody>').appendTo(this._$table);
		},

		/* Creates a div to block UI while ewjTable is busy.
		*************************************************************************/
		_createBusyPanel: function () {
			this._$busyMessageDiv = $('<div />').addClass('ewjtable-busy-message').prependTo(this._$mainContainer);
			this._$busyDiv = $('<div />').addClass('ewjtable-busy-panel-background').prependTo(this._$mainContainer);
			this._jqueryuiThemeAddClass(this._$busyMessageDiv, 'ui-widget-header');
			this._hideBusy();
		},

		/************************************************************************
		* PUBLIC METHODS                                                        *
		*************************************************************************/

		/* Loads data using AJAX call, clears table and fills with new data.
		*************************************************************************/
		load: function (postData, completeCallback) {
			this._lastPostData = postData;
			this._reloadTable(completeCallback);
		},

		/* Refreshes (re-loads) table data with last postData.
		*************************************************************************/
		reload: function (completeCallback) {
			this._reloadTable(completeCallback);
		},

		/* Gets a jQuery row object according to given record key
		*************************************************************************/
		getRowByKey: function (key) {
			for (var i = 0; i < this._$tableRows.length; i++) {
				if (key == this._getKeyValueOfRecord(this._$tableRows[i].data('record'))) {
					return this._$tableRows[i];
				}
			}

			return null;
		},

		/* Completely removes the table from it's container.
		*************************************************************************/
		destroy: function () {
			this.element.empty();
			$.Widget.prototype.destroy.call(this);
		},

		/************************************************************************
		* PRIVATE METHODS                                                       *
		*************************************************************************/

		/* Used to change options dynamically after initialization.
		*************************************************************************/
		_setOption: function (key, value) {

		},

		/* LOADING RECORDS  *****************************************************/

		/* Performs an AJAX call to reload data of the table.
		*************************************************************************/
		_reloadTable: function (completeCallback) {
			var self = this;

			var completeReload = function(data) {
				self._hideBusy();

				//Show the error message if server returns error
				if (data.result != 'OK') { //***
					self._showError(data.message); //***
					return;
				}

				//Re-generate table rows
				self._removeAllRows('reloading');
				self._addRecordsToTable(data.records); //***

				self._onRecordsLoaded(data);

				//Call complete callback
				if (completeCallback) {
					completeCallback(data);
				}
			};

			self._showBusy(self.options.messages.loadingMessage, self.options.loadingAnimationDelay); //Disable table since it's busy
			self._onLoadingRecords();

			//listAction may be a function, check if it is
			if ($.isFunction(self.options.actions.listAction)) {

				//Execute the function
				var funcResult = self.options.actions.listAction(self._lastPostData, self._createJtParamsForLoading());

				//Check if result is a jQuery Deferred object
				if (self._isDeferredObject(funcResult)) {
					funcResult.done(function(data) {
						completeReload(data);
					}).fail(function() {
						self._showError(self.options.messages.serverCommunicationError);
					}).always(function() {
						self._hideBusy();
					});
				} else { //assume it's the data we're loading
					completeReload(funcResult);
				}

			} else { //assume listAction as URL string.

				//Generate URL (with query string parameters) to load records
				var loadUrl = self._createRecordLoadUrl();

				//Load data from server using AJAX
				self._ajax({
					url: loadUrl,
					data: self._lastPostData,
					success: function (data) {
						completeReload(data);
					},
					error: function () {
						self._hideBusy();
						self._showError(self.options.messages.serverCommunicationError);
					}
				});

			}
		},

		/* Creates URL to load records.
		*************************************************************************/
		_createRecordLoadUrl: function () {
			return this.options.actions.listAction;
		},

		_createJtParamsForLoading: function() {
			return {
				//Empty as default, paging, sorting or other extensions can override this method to add additional params to load request
			};
		},

		/* TABLE MANIPULATION METHODS *******************************************/

		/* Creates a row from given record
		*************************************************************************/
		_createRowFromRecord: function (record) {
			var $tr = $('<tr></tr>')
				.addClass('ewjtable-data-row')
				.attr('data-record-key', this._getKeyValueOfRecord(record))
				.data('record', record);

			this._addCellsToRowUsingRecord($tr);
			return $tr;
		},

		/* Adds all cells to given row.
		*************************************************************************/
		_addCellsToRowUsingRecord: function ($row) {
			var record = $row.data('record');
			for (var i = 0; i < this._columnList.length; i++) {
				this._createCellForRecordField(record, this._columnList[i])
					.appendTo($row);
			}
		},

		/* Create a cell for given field.
		*************************************************************************/
		_createCellForRecordField: function (record, fieldName) {
			return $('<td></td>')
				.addClass(this.options.fields[fieldName].listClass)
				.append((this._getDisplayTextForRecordField(record, fieldName)));
		},

		/* Adds a list of records to the table.
		*************************************************************************/
		_addRecordsToTable: function (records) {
			var self = this;

			$.each(records, function (index, record) {
				self._addRow(self._createRowFromRecord(record));
			});

			self._refreshRowStyles();
		},

		/* Adds a single row to the table.
		* NOTE: THIS METHOD IS DEPRECATED AND WILL BE REMOVED FROM FEATURE RELEASES.
		* USE _addRow METHOD.
		*************************************************************************/
		_addRowToTable: function ($tableRow, index, isNewRow, animationsEnabled) {
			var options = {
				index: this._normalizeNumber(index, 0, this._$tableRows.length, this._$tableRows.length)
			};

			if (isNewRow == true) {
				options.isNewRow = true;
			}

			if (animationsEnabled == false) {
				options.animationsEnabled = false;
			}

			this._addRow($tableRow, options);
		},

		/* Adds a single row to the table.
		*************************************************************************/
		_addRow: function ($row, options) {
			//Set defaults
			options = $.extend({
				index: this._$tableRows.length,
				isNewRow: false,
				animationsEnabled: true
			}, options);

			//Remove 'no data' row if this is first row
			if (this._$tableRows.length <= 0) {
				this._removeNoDataRow();
			}

			//Add new row to the table according to it's index
			options.index = this._normalizeNumber(options.index, 0, this._$tableRows.length, this._$tableRows.length);
			if (options.index == this._$tableRows.length) {
				//add as last row
				this._$tableBody.append($row);
				this._$tableRows.push($row);
			} else if (options.index == 0) {
				//add as first row
				this._$tableBody.prepend($row);
				this._$tableRows.unshift($row);
			} else {
				//insert to specified index
				this._$tableRows[options.index - 1].after($row);
				this._$tableRows.splice(options.index, 0, $row);
			}

			this._onRowInserted($row, options.isNewRow);

			//Show animation if needed
			if (options.isNewRow) {
				this._refreshRowStyles();
				if (this.options.animationsEnabled && options.animationsEnabled) {
					this._showNewRowAnimation($row);
				}
			}
		},

		/* Shows created animation for a table row
		* TODO: Make this animation cofigurable and changable
		*************************************************************************/
		_showNewRowAnimation: function ($tableRow) {
			var className = 'ewjtable-row-created';
			if (this.options.jqueryuiTheme) {
				className = className + ' ui-state-highlight';
			}

			$tableRow.addClass(className, 'slow', '', function () {
				$tableRow.removeClass(className, 5000);
			});
		},

		/* Removes a row or rows (jQuery selection) from table.
		*************************************************************************/
		_removeRowsFromTable: function ($rows, reason) {
			var self = this;

			//Check if any row specified
			if ($rows.length <= 0) {
				return;
			}

			//remove from DOM
			$rows.addClass('ewjtable-row-removed').remove();

			//remove from _$tableRows array
			$rows.each(function () {
				var index = self._findRowIndex($(this));
				if (index >= 0) {
					self._$tableRows.splice(index, 1);
				}
			});

			self._onRowsRemoved($rows, reason);

			//Add 'no data' row if all rows removed from table
			if (self._$tableRows.length == 0) {
				self._addNoDataRow();
			}

			self._refreshRowStyles();
		},

		/* Finds index of a row in table.
		*************************************************************************/
		_findRowIndex: function ($row) {
			return this._findIndexInArray($row, this._$tableRows, function ($row1, $row2) {
				return $row1.data('record') == $row2.data('record');
			});
		},

		/* Removes all rows in the table and adds 'no data' row.
		*************************************************************************/
		_removeAllRows: function (reason) {
			//If no rows does exists, do nothing
			if (this._$tableRows.length <= 0) {
				return;
			}

			//Select all rows (to pass it on raising _onRowsRemoved event)
			var $rows = this._$tableBody.find('tr.ewjtable-data-row');

			//Remove all rows from DOM and the _$tableRows array
			this._$tableBody.empty();
			this._$tableRows = [];

			this._onRowsRemoved($rows, reason);

			//Add 'no data' row since we removed all rows
			this._addNoDataRow();
		},

		/* Adds "no data available" row to the table.
		*************************************************************************/
		_addNoDataRow: function () {
			if (this._$tableBody.find('>tr.ewjtable-no-data-row').length > 0) {
				return;
			}

			var $tr = $('<tr></tr>')
				.addClass('ewjtable-no-data-row')
				.appendTo(this._$tableBody);

			var totalColumnCount = this._$table.find('thead th').length;
			$('<td></td>')
				.attr('colspan', totalColumnCount)
				.html(this.options.messages.noDataAvailable)
				.appendTo($tr);
		},

		/* Removes "no data available" row from the table.
		*************************************************************************/
		_removeNoDataRow: function () {
			this._$tableBody.find('.ewjtable-no-data-row').remove();
		},

		/* Refreshes styles of all rows in the table
		*************************************************************************/
		_refreshRowStyles: function () {
			for (var i = 0; i < this._$tableRows.length; i++) {
				if (i % 2 == 0) {
					this._$tableRows[i].addClass('ewjtable-row-even');
				} else {
					this._$tableRows[i].removeClass('ewjtable-row-even');
				}
			}
		},

		/* RENDERING FIELD VALUES ***********************************************/

		/* Gets text for a field of a record according to it's type.
		*************************************************************************/
		_getDisplayTextForRecordField: function (record, fieldName) {
			var field = this.options.fields[fieldName];
			var fieldValue = record[fieldName];

			//if this is a custom field, call display function
			if (field.display) {
				return field.display({ record: record });
			}

			if (field.type == 'date') {
				return this._getDisplayTextForDateRecordField(field, fieldValue);
			} else { //other types
				return fieldValue;
			}
		},

		/* Gets text for a date field.
		*************************************************************************/
		_getDisplayTextForDateRecordField: function (field, fieldValue) {
			if (!fieldValue) {
				return '';
			}

			var displayFormat = field.displayFormat || this.options.defaultDateFormat;
			return ew.formatDate(fieldValue, displayFormat);
		},

		/* TOOLBAR *************************************************************/

		/* Creates the toolbar.
		*************************************************************************/
		_createToolBar: function () {
			this._$toolbarDiv = $('<div />')
			.addClass('ewjtable-toolbar')
			.appendTo(this._$titleDiv);

			for (var i = 0; i < this.options.toolbar.items.length; i++) {
				this._addToolBarItem(this.options.toolbar.items[i]);
			}
		},

		/* Adds a new item to the toolbar.
		*************************************************************************/
		_addToolBarItem: function (item) {

			//Check if item is valid
			if ((item == undefined) || (item.text == undefined && item.icon == undefined)) {
				this._logWarn('Can not add tool bar item since it is not valid!');
				this._logWarn(item);
				return null;
			}

			var $toolBarItem = $('<span></span>')
				.addClass('ewjtable-toolbar-item')
				.appendTo(this._$toolbarDiv);

			this._jqueryuiThemeAddClass($toolBarItem, 'ui-widget ui-state-default ui-corner-all', 'ui-state-hover');

			//cssClass property
			if (item.cssClass) {
				$toolBarItem
					.addClass(item.cssClass);
			}

			//tooltip property
			if (item.tooltip) {
				$toolBarItem
					.attr('title', item.tooltip);
			}

			//icon property
			if (item.icon) {
				var $icon = $('<span class="ewjtable-toolbar-item-icon"></span>').appendTo($toolBarItem);
				if (item.icon === true) {
					//do nothing
				} else if ($.type(item.icon === 'string')) {
					$icon.css('background', 'url("' + item.icon + '")');
				}
			}

			//text property
			if (item.text) {
				$('<span class=""></span>')
					.html(item.text)
					.addClass('ewjtable-toolbar-item-text').appendTo($toolBarItem);
			}

			//click event
			if (item.click) {
				$toolBarItem.click(function () {
					item.click();
				});
			}

			//set hover animation parameters
			var hoverAnimationDuration = undefined;
			var hoverAnimationEasing = undefined;
			if (this.options.toolbar.hoverAnimation) {
				hoverAnimationDuration = this.options.toolbar.hoverAnimationDuration;
				hoverAnimationEasing = this.options.toolbar.hoverAnimationEasing;
			}

			//change class on hover
			$toolBarItem.hover(function () {
				$toolBarItem.addClass('ewjtable-toolbar-item-hover', hoverAnimationDuration, hoverAnimationEasing);
			}, function () {
				$toolBarItem.removeClass('ewjtable-toolbar-item-hover', hoverAnimationDuration, hoverAnimationEasing);
			});

			return $toolBarItem;
		},

		/* ERROR DIALOG *********************************************************/

		/* Shows error message dialog with given message.
		*************************************************************************/
		_showError: function (message) {
			ew.alert(message);
		},

		/* BUSY PANEL ***********************************************************/

		/* Shows busy indicator and blocks table UI.
		* TODO: Make this cofigurable and changable
		*************************************************************************/
		_setBusyTimer: null,
		_showBusy: function (message, delay) {
			var self = this;  //

			//Show a transparent overlay to prevent clicking to the table
			self._$busyDiv
				.width(self._$mainContainer.width())
				.height(self._$mainContainer.height())
				.addClass('ewjtable-busy-panel-background-invisible')
				.show();

			var makeVisible = function () {
				self._$busyDiv.removeClass('ewjtable-busy-panel-background-invisible');
				self._$busyMessageDiv.html(message).show();
			};

			if (delay) {
				if (self._setBusyTimer) {
					return;
				}

				self._setBusyTimer = setTimeout(makeVisible, delay);
			} else {
				makeVisible();
			}
		},

		/* Hides busy indicator and unblocks table UI.
		*************************************************************************/
		_hideBusy: function () {
			clearTimeout(this._setBusyTimer);
			this._setBusyTimer = null;
			this._$busyDiv.hide();
			this._$busyMessageDiv.html('').hide();
		},

		/* Returns true if ewjTable is busy.
		*************************************************************************/
		_isBusy: function () {
			return this._$busyMessageDiv.is(':visible');
		},

		/* Adds jQueryUI class to an item.
		*************************************************************************/
		_jqueryuiThemeAddClass: function ($elm, className, hoverClassName) {
			if (!this.options.jqueryuiTheme) {
				return;
			}

			$elm.addClass(className);

			if (hoverClassName) {
				$elm.hover(function () {
					$elm.addClass(hoverClassName);
				}, function () {
					$elm.removeClass(hoverClassName);
				});
			}
		},

		/* COMMON METHODS *******************************************************/

		/* Performs an AJAX call to specified URL.
		* THIS METHOD IS DEPRECATED AND WILL BE REMOVED FROM FEATURE RELEASES.
		* USE _ajax METHOD.
		*************************************************************************/
		_performAjaxCall: function (url, postData, async, success, error) {
			this._ajax({
				url: url,
				data: postData,
				async: async,
				success: success,
				error: error
			});
		},

		_unAuthorizedRequestHandler: function() {
			if (this.options.unAuthorizedRequestRedirectUrl) {
				location.href = this.options.unAuthorizedRequestRedirectUrl;
			} else {
				location.reload(true);
			}
		},

		/* This method is used to perform AJAX calls in ewjTable instead of direct
		* usage of jQuery.ajax method.
		*************************************************************************/
		_ajax: function (options) {
			var self = this;

			//Handlers for HTTP status codes
			var opts = {
				statusCode: {
					401: function () { //Unauthorized
						self._unAuthorizedRequestHandler();
					}
				}
			};

			opts = $.extend(opts, this.options.ajaxSettings, options);

			//Override success
			opts.success = function (data) {
				//Checking for Authorization error
				if (data && data.unAuthorizedRequest == true) { //***
					self._unAuthorizedRequestHandler();
				}

				if (options.success) {
					options.success(data);
				}
			};

			//Override error
			opts.error = function (jqXHR, textStatus, errorThrown) {
				if (unloadingPage) {
					jqXHR.abort();
					return;
				}

				if (options.error) {
					options.error(arguments);
				}
			};

			//Override complete
			opts.complete = function () {
				if (options.complete) {
					options.complete();
				}
			};

			$.ajax(opts);
		},

		/* Gets value of key field of a record.
		*************************************************************************/
		_getKeyValueOfRecord: function (record) {
			return record[this._keyField];
		},

		/************************************************************************
		* COOKIE                                                                *
		*************************************************************************/

		/* Sets a cookie with given key.
		*************************************************************************/
		_setCookie: function (key, value) {
			key = this._cookieKeyPrefix + key;

			var expireDate = new Date();
			expireDate.setDate(expireDate.getDate() + 30);
			document.cookie = encodeURIComponent(key) + '=' + encodeURIComponent(value) + "; expires=" + expireDate.toUTCString();
		},

		/* Gets a cookie with given key.
		*************************************************************************/
		_getCookie: function (key) {
			key = this._cookieKeyPrefix + key;

			var equalities = document.cookie.split('; ');
			for (var i = 0; i < equalities.length; i++) {
				if (!equalities[i]) {
					continue;
				}

				var splitted = equalities[i].split('=');
				if (splitted.length != 2) {
					continue;
				}

				if (decodeURIComponent(splitted[0]) === key) {
					return decodeURIComponent(splitted[1] || '');
				}
			}

			return null;
		},

		/* Generates a hash key to be prefix for all cookies for this ewjtable instance.
		*************************************************************************/
		_generateCookieKeyPrefix: function () {

			var simpleHash = function (value) {
				var hash = 0;
				if (value.length == 0) {
					return hash;
				}

				for (var i = 0; i < value.length; i++) {
					var ch = value.charCodeAt(i);
					hash = ((hash << 5) - hash) + ch;
					hash = hash & hash;
				}

				return hash;
			};

			var strToHash = '';
			if (this.options.tableId) {
				strToHash = strToHash + this.options.tableId + '#';
			}

			strToHash = strToHash + this._columnList.join('$') + '#c' + this._$table.find('thead th').length;
			return 'ewjtable#' + simpleHash(strToHash);
		},

		/************************************************************************
		* EVENT RAISING METHODS                                                 *
		*************************************************************************/

		_onLoadingRecords: function () {
			this._trigger("loadingRecords", null, {});
		},

		_onRecordsLoaded: function (data) {
			this._trigger("recordsLoaded", null, { records: data.records, serverResponse: data }); //***
		},

		_onRowInserted: function ($row, isNewRow) {
			this._trigger("rowInserted", null, { row: $row, record: $row.data('record'), isNewRow: isNewRow });
		},

		_onRowsRemoved: function ($rows, reason) {
			this._trigger("rowsRemoved", null, { rows: $rows, reason: reason });
		},

		_onCloseRequested: function () {
			this._trigger("closeRequested", null, {});
		}

	});

}(jQuery));


/************************************************************************
* Some UTULITY methods used by ewjTable                                   *
*************************************************************************/
(function ($) {

	$.extend(true, $.ew.ewjtable.prototype, {

		/* Gets property value of an object recursively.
		*************************************************************************/
		_getPropertyOfObject: function (obj, propName) {
			if (propName.indexOf('.') < 0) {
				return obj[propName];
			} else {
				var preDot = propName.substring(0, propName.indexOf('.'));
				var postDot = propName.substring(propName.indexOf('.') + 1);
				return this._getPropertyOfObject(obj[preDot], postDot);
			}
		},

		/* Sets property value of an object recursively.
		*************************************************************************/
		_setPropertyOfObject: function (obj, propName, value) {
			if (propName.indexOf('.') < 0) {
				obj[propName] = value;
			} else {
				var preDot = propName.substring(0, propName.indexOf('.'));
				var postDot = propName.substring(propName.indexOf('.') + 1);
				this._setPropertyOfObject(obj[preDot], postDot, value);
			}
		},

		/* Inserts a value to an array if it does not exists in the array.
		*************************************************************************/
		_insertToArrayIfDoesNotExists: function (array, value) {
			if ($.inArray(value, array) < 0) {
				array.push(value);
			}
		},

		/* Finds index of an element in an array according to given comparision function
		*************************************************************************/
		_findIndexInArray: function (value, array, compareFunc) {

			//If not defined, use default comparision
			if (!compareFunc) {
				compareFunc = function (a, b) {
					return a == b;
				};
			}

			for (var i = 0; i < array.length; i++) {
				if (compareFunc(value, array[i])) {
					return i;
				}
			}

			return -1;
		},

		/* Normalizes a number between given bounds or sets to a defaultValue
		*  if it is undefined
		*************************************************************************/
		_normalizeNumber: function (number, min, max, defaultValue) {
			if (number == undefined || number == null || isNaN(number)) {
				return defaultValue;
			}

			if (number < min) {
				return min;
			}

			if (number > max) {
				return max;
			}

			return number;
		},

		/* Formats a string just like string.format in c#.
		*  Example:
		*  _formatString('Hello {0}','Halil') = 'Hello Halil'
		*************************************************************************/
		_formatString: function () {
			if (arguments.length == 0) {
				return null;
			}

			var str = arguments[0];
			for (var i = 1; i < arguments.length; i++) {
				var placeHolder = '{' + (i - 1) + '}';
				str = str.replace(placeHolder, arguments[i]);
			}

			return str;
		},

		/* Checks if given object is a jQuery Deferred object.
		 */
		_isDeferredObject: function (obj) {
			return obj.then && obj.done && obj.fail;
		},

		//Logging methods ////////////////////////////////////////////////////////

		_logDebug: function (text) {
			if (!window.console) {
				return;
			}

			console.log('ewjTable DEBUG: ' + text);
		},

		_logInfo: function (text) {
			if (!window.console) {
				return;
			}

			console.log('ewjTable INFO: ' + text);
		},

		_logWarn: function (text) {
			if (!window.console) {
				return;
			}

			console.log('ewjTable WARNING: ' + text);
		},

		_logError: function (text) {
			if (!window.console) {
				return;
			}

			console.log('ewjTable ERROR: ' + text);
		}

	});

	/* Fix for array.indexOf method in IE7.
	 * This code is taken from http://www.tutorialspoint.com/javascript/array_indexof.htm */
	if (!Array.prototype.indexOf) {
		Array.prototype.indexOf = function (elt) {
			var len = this.length;
			var from = Number(arguments[1]) || 0;
			from = (from < 0)
				 ? Math.ceil(from)
				 : Math.floor(from);
			if (from < 0)
				from += len;
			for (; from < len; from++) {
				if (from in this &&
					this[from] === elt)
					return from;
			}
			return -1;
		};
	}

})(jQuery);

/************************************************************************
* SELECTING extension for ewjTable                                        *
*************************************************************************/
(function ($) {

	//Reference to base object members
	var base = {
		_create: $.ew.ewjtable.prototype._create,
		_addColumnsToHeaderRow: $.ew.ewjtable.prototype._addColumnsToHeaderRow,
		_addCellsToRowUsingRecord: $.ew.ewjtable.prototype._addCellsToRowUsingRecord,
		_onLoadingRecords: $.ew.ewjtable.prototype._onLoadingRecords,
		_onRecordsLoaded: $.ew.ewjtable.prototype._onRecordsLoaded,
		_onRowsRemoved: $.ew.ewjtable.prototype._onRowsRemoved
	};

	//extension members
	$.extend(true, $.ew.ewjtable.prototype, {

		/************************************************************************
		* DEFAULT OPTIONS / EVENTS                                              *
		*************************************************************************/
		options: {

			//Options
			selecting: false,
			multiselect: false,
			selectingCheckboxes: false,
			selectOnRowClick: true,

			//Events
			selectionChanged: function (event, data) { }
		},

		/************************************************************************
		* PRIVATE FIELDS                                                        *
		*************************************************************************/

		_selectedRecordIdsBeforeLoad: null, //This array is used to store selected row Id's to restore them after a page refresh (string array).
		_$selectAllCheckbox: null, //Reference to the 'select/deselect all' checkbox (jQuery object)
		_shiftKeyDown: false, //True, if shift key is currently down.

		/************************************************************************
		* CONSTRUCTOR                                                           *
		*************************************************************************/

		/* Overrides base method to do selecting-specific constructions.
		*************************************************************************/
		_create: function () {
			if (this.options.selecting && this.options.selectingCheckboxes) {
				++this._firstDataColumnOffset;
				this._bindKeyboardEvents();
			}

			//Call base method
			base._create.apply(this, arguments);
		},

		/* Registers to keyboard events those are needed for selection
		*************************************************************************/
		_bindKeyboardEvents: function () {
			var self = this;
			//Register to events to set _shiftKeyDown value
			$(document)
				.keydown(function (event) {
					switch (event.which) {
						case 16:
							self._shiftKeyDown = true;
							break;
					}
				})
				.keyup(function (event) {
					switch (event.which) {
						case 16:
							self._shiftKeyDown = false;
							break;
					}
				});
		},

		/************************************************************************
		* PUBLIC METHODS                                                        *
		*************************************************************************/

		/* Gets jQuery selection for currently selected rows.
		*************************************************************************/
		selectedRows: function () {
			return this._getSelectedRows();
		},

		/* Makes row/rows 'selected'.
		*************************************************************************/
		selectRows: function ($rows) {
			this._selectRows($rows);

			this._onSelectionChanged($.Event("selectRows")); //TODO: trigger only if selected rows changes?
		},

		/************************************************************************
		* OVERRIDED METHODS                                                     *
		*************************************************************************/

		/* Overrides base method to add a 'select column' to header row.
		*************************************************************************/
		_addColumnsToHeaderRow: function ($tr) {
			if (this.options.selecting && this.options.selectingCheckboxes) {
				if (this.options.multiselect) {
					$tr.append(this._createSelectAllHeader());
				} else {
					$tr.append(this._createEmptyCommandHeader());
				}
			}

			base._addColumnsToHeaderRow.apply(this, arguments);
		},

		/* Overrides base method to add a 'delete command cell' to a row.
		*************************************************************************/
		_addCellsToRowUsingRecord: function ($row) {
			if (this.options.selecting) {
				this._makeRowSelectable($row);
			}

			base._addCellsToRowUsingRecord.apply(this, arguments);
		},

		/* Overrides base event to store selection list
		*************************************************************************/
		_onLoadingRecords: function () {
			if (this.options.selecting) {
				this._storeSelectionList();
			}

			base._onLoadingRecords.apply(this, arguments);
		},

		/* Overrides base event to restore selection list
		*************************************************************************/
		_onRecordsLoaded: function () {
			if (this.options.selecting) {
				this._restoreSelectionList();
			}

			base._onRecordsLoaded.apply(this, arguments);
		},

		/* Overrides base event to check is any selected row is being removed.
		*************************************************************************/
		_onRowsRemoved: function ($rows, reason) {
			if (this.options.selecting && (reason != 'reloading') && ($rows.filter('.ewjtable-row-selected').length > 0)) {
				this._onSelectionChanged($.Event("rowsRemoved"));
			}

			base._onRowsRemoved.apply(this, arguments);
		},

		/************************************************************************
		* PRIVATE METHODS                                                       *
		*************************************************************************/

		/* Creates a header column to select/deselect all rows.
		*************************************************************************/
		_createSelectAllHeader: function () {
			var self = this;

			var $columnHeader = $('<th class=""></th>')
				.addClass('ewjtable-command-column-header ewjtable-column-header-selecting');
			this._jqueryuiThemeAddClass($columnHeader, 'ui-state-default');

			var $headerContainer = $('<div />')
				.addClass('ewjtable-column-header-container')
				.appendTo($columnHeader);

			self._$selectAllCheckbox = $('<input type="checkbox" class="custom-control-input" id="modal_select_all">') //***
				.click(function () {
					if (self._$tableRows.length <= 0) {
						self._$selectAllCheckbox.prop('checked', false);
						return;
					}

					var allRows = self._$tableBody.find('>tr.ewjtable-data-row');
					if (self._$selectAllCheckbox.is(':checked')) {
						self._selectRows(allRows);
					} else {
						self._deselectRows(allRows);
					}

					self._onSelectionChanged($.Event("selectAll", { "rows": allRows }));
				});

			$('<div class="custom-control custom-checkbox d-inline-block"></div>')
				.append(self._$selectAllCheckbox)
				.append('<label class="custom-control-label" for="modal_select_all"></label>')
				.appendTo($headerContainer); //***

			return $columnHeader;
		},

		/* Stores Id's of currently selected records to _selectedRecordIdsBeforeLoad.
		*************************************************************************/
		_storeSelectionList: function () {
			var self = this;

			if (!self.options.selecting) {
				return;
			}

			self._selectedRecordIdsBeforeLoad = [];
			self._getSelectedRows().each(function () {
				self._selectedRecordIdsBeforeLoad.push(self._getKeyValueOfRecord($(this).data('record')));
			});
		},

		/* Selects rows whose Id is in _selectedRecordIdsBeforeLoad;
		*************************************************************************/
		_restoreSelectionList: function () {
			var self = this;

			if (!self.options.selecting) {
				return;
			}

			var selectedRowCount = 0;
			for (var i = 0; i < self._$tableRows.length; ++i) {
				var recordId = self._getKeyValueOfRecord(self._$tableRows[i].data('record'));
				if ($.inArray(recordId, self._selectedRecordIdsBeforeLoad) > -1) {
					self._selectRows(self._$tableRows[i]);
					++selectedRowCount;
				}
			}

			if (self._selectedRecordIdsBeforeLoad.length > 0 && self._selectedRecordIdsBeforeLoad.length != selectedRowCount) {
				self._onSelectionChanged($.Event("restoreSelectionList"));
			}

			self._selectedRecordIdsBeforeLoad = [];
			self._refreshSelectAllCheckboxState();
		},

		/* Gets all selected rows.
		*************************************************************************/
		_getSelectedRows: function () {
			return this._$tableBody
				.find('>tr.ewjtable-row-selected');
		},

		/* Adds selectable feature to a row.
		*************************************************************************/
		_makeRowSelectable: function ($row) {
			var self = this;

			//Select/deselect on row click
			if (self.options.selectOnRowClick) {
				$row.click(function (e) {
					if ($(e.target).is(".custom-control-label")) //***
						return;
					self._invertRowSelection($row);
				});
			}

			//'select/deselect' checkbox column
			if (self.options.selectingCheckboxes) {
				var $cell = $('<td></td>').addClass('ewjtable-selecting-column');
				var type = (self.options.multiselect) ? "checkbox" : "radio"; //***
				var id = "modal_" + type + "_" + ew.random(); //***
				var $selectCheckbox = $('<div class="custom-control custom-' + type + ' d-inline-block"><input type="' + type + '" class="custom-control-input" id="' + id + '"><label class="custom-control-label" for="' + id + '"></label></div>').appendTo($cell); //***
				if (!self.options.selectOnRowClick) {
					$selectCheckbox.find("input").click(function (e) {
						self._invertRowSelection($row);
					});
				}

				$row.append($cell);
			}
		},

		/* Inverts selection state of a single row.
		*************************************************************************/
		_invertRowSelection: function ($row) {
			if ($row.hasClass('ewjtable-row-selected')) {
				this._deselectRows($row);
			} else {
				//Shift key?
				if (this._shiftKeyDown) {
					var rowIndex = this._findRowIndex($row);
					//try to select row and above rows until first selected row
					var beforeIndex = this._findFirstSelectedRowIndexBeforeIndex(rowIndex) + 1;
					if (beforeIndex > 0 && beforeIndex < rowIndex) {
						this._selectRows(this._$tableBody.find('tr').slice(beforeIndex, rowIndex + 1));
					} else {
						//try to select row and below rows until first selected row
						var afterIndex = this._findFirstSelectedRowIndexAfterIndex(rowIndex) - 1;
						if (afterIndex > rowIndex) {
							this._selectRows(this._$tableBody.find('tr').slice(rowIndex, afterIndex + 1));
						} else {
							//just select this row
							this._selectRows($row);
						}
					}
				} else {
					this._selectRows($row);
				}
			}

			this._onSelectionChanged($.Event("invertRowSelection", { "rows": $row }));
		},

		/* Search for a selected row (that is before given row index) to up and returns it's index
		*************************************************************************/
		_findFirstSelectedRowIndexBeforeIndex: function (rowIndex) {
			for (var i = rowIndex - 1; i >= 0; --i) {
				if (this._$tableRows[i].hasClass('ewjtable-row-selected')) {
					return i;
				}
			}

			return -1;
		},

		/* Search for a selected row (that is after given row index) to down and returns it's index
		*************************************************************************/
		_findFirstSelectedRowIndexAfterIndex: function (rowIndex) {
			for (var i = rowIndex + 1; i < this._$tableRows.length; ++i) {
				if (this._$tableRows[i].hasClass('ewjtable-row-selected')) {
					return i;
				}
			}

			return -1;
		},

		/* Makes row/rows 'selected'.
		*************************************************************************/
		_selectRows: function ($rows) {
			if (!this.options.multiselect) {
				this._deselectRows(this._getSelectedRows());
			}

			$rows.addClass('ewjtable-row-selected');
			this._jqueryuiThemeAddClass($rows, 'ui-state-highlight');

			if (this.options.selectingCheckboxes) {
				$rows.find('>td.ewjtable-selecting-column input').prop('checked', true); //***
			}

			this._refreshSelectAllCheckboxState();
		},

		/* Makes row/rows 'non selected'.
		*************************************************************************/
		_deselectRows: function ($rows) {
			$rows.removeClass('ewjtable-row-selected ui-state-highlight');
			if (this.options.selectingCheckboxes) {
				$rows.find('>td.ewjtable-selecting-column input').prop('checked', false); //***
			}

			this._refreshSelectAllCheckboxState();
		},

		/* Updates state of the 'select/deselect' all checkbox according to count of selected rows.
		*************************************************************************/
		_refreshSelectAllCheckboxState: function () {
			if (!this.options.selectingCheckboxes || !this.options.multiselect) {
				return;
			}

			var totalRowCount = this._$tableRows.length;
			var selectedRowCount = this._getSelectedRows().length;

			if (selectedRowCount == 0) {
				this._$selectAllCheckbox.prop('indeterminate', false);
				this._$selectAllCheckbox.prop('checked', false);
			} else if (selectedRowCount == totalRowCount) {
				this._$selectAllCheckbox.prop('indeterminate', false);
				this._$selectAllCheckbox.prop('checked', true);
			} else {
				this._$selectAllCheckbox.prop('checked', false);
				this._$selectAllCheckbox.prop('indeterminate', true);
			}
		},

		/************************************************************************
		* EVENT RAISING METHODS                                                 *
		*************************************************************************/

		_onSelectionChanged: function (e) {
			this._trigger("selectionChanged", null, e || {});
		}

	});

})(jQuery);


/************************************************************************
* PAGING extension for ewjTable                                           *
*************************************************************************/
(function ($) {

	//Reference to base object members
	var base = {
		load: $.ew.ewjtable.prototype.load,
		_create: $.ew.ewjtable.prototype._create,
		_setOption: $.ew.ewjtable.prototype._setOption,
		_createRecordLoadUrl: $.ew.ewjtable.prototype._createRecordLoadUrl,
		_createJtParamsForLoading: $.ew.ewjtable.prototype._createJtParamsForLoading,
		_addRowToTable: $.ew.ewjtable.prototype._addRowToTable,
		_addRow: $.ew.ewjtable.prototype._addRow,
		_removeRowsFromTable: $.ew.ewjtable.prototype._removeRowsFromTable,
		_onRecordsLoaded: $.ew.ewjtable.prototype._onRecordsLoaded
	};

	//extension members
	$.extend(true, $.ew.ewjtable.prototype, {

		/************************************************************************
		* DEFAULT OPTIONS / EVENTS                                              *
		*************************************************************************/
		options: {
			paging: true,
			pageList: 'minimal', //possible values: 'minimal', 'normal'
			pageSize: 10,
			pageSizes: [10, 20, 30],
			pageSizeChangeArea: false,
			gotoPageArea: 'combobox', //possible values: 'textbox', 'combobox', 'none'

			messages: {
				pagingInfo: 'Showing {0}-{1} of {2}',
				pageSizeChangeLabel: 'Row count',
				gotoPageLabel: 'Go to page'
			}

		},

		/************************************************************************
		* PRIVATE FIELDS                                                        *
		*************************************************************************/

		_$bottomPanel: null, //Reference to the panel at the bottom of the table (jQuery object)
		_$pagingListArea: null, //Reference to the page list area in to bottom panel (jQuery object)
		_$pageSizeChangeArea: null, //Reference to the page size change area in to bottom panel (jQuery object)
		_$pageInfoSpan: null, //Reference to the paging info area in to bottom panel (jQuery object)
		_$gotoPageArea: null, //Reference to 'Go to page' input area in to bottom panel (jQuery object)
		_$gotoPageInput: null, //Reference to 'Go to page' input in to bottom panel (jQuery object)
		_totalRecordCount: 0, //Total count of records on all pages
		_currentPageNo: 1, //Current page number

		/************************************************************************
		* CONSTRUCTOR AND INITIALIZING METHODS                                  *
		*************************************************************************/

		/* Overrides base method to do paging-specific constructions.
		*************************************************************************/
		_create: function() {
			base._create.apply(this, arguments);
			if (this.options.paging) {
				this._loadPagingSettings();
				this._createBottomPanel();
				this._createPageListArea();
				this._createGotoPageInput();
				this._createPageSizeSelection();
			}
		},

		/* Loads user preferences for paging.
		*************************************************************************/
		_loadPagingSettings: function() {
			if (!this.options.saveUserPreferences) {
				return;
			}

			var pageSize = this._getCookie('page-size');
			if (pageSize) {
				this.options.pageSize = this._normalizeNumber(pageSize, 1, 1000000, this.options.pageSize);
			}
		},

		/* Creates bottom panel and adds to the page.
		*************************************************************************/
		_createBottomPanel: function() {
			this._$bottomPanel = $('<div />')
				.addClass('ewjtable-bottom-panel')
				.insertAfter(this._$table);

			this._jqueryuiThemeAddClass(this._$bottomPanel, 'ui-state-default');

			$('<div />').addClass('ewjtable-left-area float-left').appendTo(this._$bottomPanel); //***
			$('<div />').addClass('ewjtable-right-area float-right').appendTo(this._$bottomPanel); //***
			$('<div />').addClass('clearfix').appendTo(this._$bottomPanel); //***
		},

		/* Creates page list area.
		*************************************************************************/
		_createPageListArea: function() {
			this._$pagingListArea = $('<span></span>')
				.addClass('ewjtable-page-list')
				.appendTo(this._$bottomPanel.find('.ewjtable-left-area'));

			this._$pageInfoSpan = $('<span></span>')
				.addClass('ewjtable-page-info')
				.appendTo(this._$bottomPanel.find('.ewjtable-right-area'));
		},

		/* Creates page list change area.
		*************************************************************************/
		_createPageSizeSelection: function() {
			var self = this;

			if (!self.options.pageSizeChangeArea) {
				return;
			}

			//Add current page size to page sizes list if not contains it
			if (self._findIndexInArray(self.options.pageSize, self.options.pageSizes) < 0) {
				self.options.pageSizes.push(parseInt(self.options.pageSize));
				self.options.pageSizes.sort(function(a, b) { return a - b; });
			}

			//Add a span to contain page size change items
			self._$pageSizeChangeArea = $('<span></span>')
				.addClass('ewjtable-page-size-change')
				.appendTo(self._$bottomPanel.find('.ewjtable-left-area'));

			//Page size label
			self._$pageSizeChangeArea.append('<span>' + self.options.messages.pageSizeChangeLabel + ': </span>');

			//Page size change combobox
			var $pageSizeChangeCombobox = $('<select></select>').appendTo(self._$pageSizeChangeArea);

			//Add page sizes to the combobox
			for (var i = 0; i < self.options.pageSizes.length; i++) {
				$pageSizeChangeCombobox.append('<option value="' + self.options.pageSizes[i] + '">' + self.options.pageSizes[i] + '</option>');
			}

			//Select current page size
			$pageSizeChangeCombobox.val(self.options.pageSize);

			//Change page size on combobox change
			$pageSizeChangeCombobox.change(function() {
				self._changePageSize(parseInt($(this).val()));
			});
		},

		/* Creates go to page area.
		*************************************************************************/
		_createGotoPageInput: function() {
			var self = this;

			if (!self.options.gotoPageArea || self.options.gotoPageArea == 'none') {
				return;
			}

			//Add a span to contain goto page items
			this._$gotoPageArea = $('<span></span>')
				.addClass('ewjtable-goto-page')
				.appendTo(self._$bottomPanel.find('.ewjtable-left-area'));

			//Goto page label
			this._$gotoPageArea.append('<span>' + self.options.messages.gotoPageLabel + '</span>'); //***

			//Goto page input
			if (self.options.gotoPageArea == 'combobox') {

				self._$gotoPageInput = $('<select></select>')
					.addClass("custom-select custom-select-sm")
					.appendTo(this._$gotoPageArea)
					.data('pageCount', 1)
					.change(function() {
						self._changePage(parseInt($(this).val()));
					});
				self._$gotoPageInput.append('<option value="1">1</option>');

			} else { //textbox

				self._$gotoPageInput = $('<input type="text" maxlength="10" value="' + self._currentPageNo + '" />')
					.addClass("form-control form-control-sm")
					.appendTo(this._$gotoPageArea)
					.keypress(function(event) {
						if (event.which == 13) { //enter
							event.preventDefault();
							self._changePage(parseInt(self._$gotoPageInput.val()));
						} else if (event.which == 43) { // +
							event.preventDefault();
							self._changePage(parseInt(self._$gotoPageInput.val()) + 1);
						} else if (event.which == 45) { // -
							event.preventDefault();
							self._changePage(parseInt(self._$gotoPageInput.val()) - 1);
						} else {
							//Allow only digits
							var isValid = (
								(47 < event.keyCode && event.keyCode < 58 && event.shiftKey == false && event.altKey == false)
									|| (event.keyCode == 8)
									|| (event.keyCode == 9)
							);

							if (!isValid) {
								event.preventDefault();
							}
						}
					});

			}
		},

		/* Refreshes the 'go to page' input.
		*************************************************************************/
		_refreshGotoPageInput: function() {
			if (!this.options.gotoPageArea || this.options.gotoPageArea == 'none') {
				return;
			}

			if (this._totalRecordCount <= 0 || this.options.pageSize > this._totalRecordCount) { //***
				this._$gotoPageArea.hide();
			} else {
				this._$gotoPageArea.show();
			}

			if (this.options.gotoPageArea == 'combobox') {
				var oldPageCount = this._$gotoPageInput.data('pageCount');
				var currentPageCount = this._calculatePageCount();
				if (oldPageCount != currentPageCount) {
					this._$gotoPageInput.empty();

					//Skip some pages is there are too many pages
					var pageStep = 1;
					if (currentPageCount > 10000) {
						pageStep = 100;
					} else if (currentPageCount > 5000) {
						pageStep = 10;
					} else if (currentPageCount > 2000) {
						pageStep = 5;
					} else if (currentPageCount > 1000) {
						pageStep = 2;
					}

					for (var i = pageStep; i <= currentPageCount; i += pageStep) {
						this._$gotoPageInput.append('<option value="' + i + '">' + i + '</option>');
					}

					this._$gotoPageInput.data('pageCount', currentPageCount);
				}
			}

			//same for 'textbox' and 'combobox'
			this._$gotoPageInput.val(this._currentPageNo);
		},

		/************************************************************************
		* OVERRIDED METHODS                                                     *
		*************************************************************************/

		/* Overrides load method to set current page to 1.
		*************************************************************************/
		load: function() {
			this._currentPageNo = 1;

			base.load.apply(this, arguments);
		},

		/* Used to change options dynamically after initialization.
		*************************************************************************/
		_setOption: function(key, value) {
			base._setOption.apply(this, arguments);

			if (key == 'pageSize') {
				this._changePageSize(parseInt(value));
			}
		},

		/* Changes current page size with given value.
		*************************************************************************/
		_changePageSize: function(pageSize) {
			if (pageSize == this.options.pageSize) {
				return;
			}

			this.options.pageSize = pageSize;

			//Normalize current page
			var pageCount = this._calculatePageCount();
			if (this._currentPageNo > pageCount) {
				this._currentPageNo = pageCount;
			}
			if (this._currentPageNo <= 0) {
				this._currentPageNo = 1;
			}

			//if user sets one of the options on the combobox, then select it.
			var $pageSizeChangeCombobox = this._$bottomPanel.find('.ewjtable-page-size-change select');
			if ($pageSizeChangeCombobox.length > 0) {
				if (parseInt($pageSizeChangeCombobox.val()) != pageSize) {
					var selectedOption = $pageSizeChangeCombobox.find('option[value=' + pageSize + ']');
					if (selectedOption.length > 0) {
						$pageSizeChangeCombobox.val(pageSize);
					}
				}
			}

			this._savePagingSettings();
			this._reloadTable();
		},

		/* Saves user preferences for paging
		*************************************************************************/
		_savePagingSettings: function() {
			if (!this.options.saveUserPreferences) {
				return;
			}

			this._setCookie('page-size', this.options.pageSize);
		},

		/* Overrides _createRecordLoadUrl method to add paging info to URL.
		*************************************************************************/
		_createRecordLoadUrl: function() {
			var loadUrl = base._createRecordLoadUrl.apply(this, arguments);
			loadUrl = this._addPagingInfoToUrl(loadUrl, this._currentPageNo);
			return loadUrl;
		},

		/* Overrides _createJtParamsForLoading method to add paging parameters to jtParams object.
		*************************************************************************/
		_createJtParamsForLoading: function () {
			var jtParams = base._createJtParamsForLoading.apply(this, arguments);

			if (this.options.paging) {
				jtParams.start = (this._currentPageNo - 1) * this.options.pageSize;
				jtParams.recperpage = this.options.pageSize;
			}

			return jtParams;
		},

		/* Overrides _addRowToTable method to re-load table when a new row is created.
		* NOTE: THIS METHOD IS DEPRECATED AND WILL BE REMOVED FROM FEATURE RELEASES.
		* USE _addRow METHOD.
		*************************************************************************/
		_addRowToTable: function ($tableRow, index, isNewRow) {
			if (isNewRow && this.options.paging) {
				this._reloadTable();
				return;
			}

			base._addRowToTable.apply(this, arguments);
		},

		/* Overrides _addRow method to re-load table when a new row is created.
		*************************************************************************/
		_addRow: function ($row, options) {
			if (options && options.isNewRow && this.options.paging) {
				this._reloadTable();
				return;
			}

			base._addRow.apply(this, arguments);
		},

		/* Overrides _removeRowsFromTable method to re-load table when a row is removed from table.
		*************************************************************************/
		_removeRowsFromTable: function ($rows, reason) {
			base._removeRowsFromTable.apply(this, arguments);

			if (this.options.paging) {
				if (this._$tableRows.length <= 0 && this._currentPageNo > 1) {
					--this._currentPageNo;
				}

				this._reloadTable();
			}
		},

		/* Overrides _onRecordsLoaded method to to do paging specific tasks.
		*************************************************************************/
		_onRecordsLoaded: function (data) {
			if (this.options.paging) {
				this._totalRecordCount = data.totalRecordCount; //***
				this._createPagingList();
				this._createPagingInfo();
				this._refreshGotoPageInput();
			}

			base._onRecordsLoaded.apply(this, arguments);
		},

		/************************************************************************
		* PRIVATE METHODS                                                       *
		*************************************************************************/

		/* Adds StartIndex and PageSize parameters to a URL as query string.
		*************************************************************************/
		_addPagingInfoToUrl: function (url, pageNumber) {
			if (!this.options.paging) {
				return url;
			}

			var startIndex = (pageNumber - 1) * this.options.pageSize;
			var pageSize = this.options.pageSize;

			return (url + (url.indexOf('?') < 0 ? '?' : '&') + 'start=' + startIndex + '&recperpage=' + pageSize);
		},

		/* Creates and shows the page list.
		*************************************************************************/
		_createPagingList: function () {
			if (this.options.pageSize <= 0) {
				return;
			}

			this._$pagingListArea.empty();
			if (this._totalRecordCount <= 0 || this.options.pageSize > this._totalRecordCount) { //***
				return;
			}

			var pageCount = this._calculatePageCount();

			this._createFirstAndPreviousPageButtons();
			if (this.options.pageList == 'normal') {
				this._createPageNumberButtons(this._calculatePageNumbers(pageCount));
			} else {

			}
			this._createLastAndNextPageButtons(pageCount);
			this._bindClickEventsToPageNumberButtons();

			this._$pagingListArea.wrapInner('<div class="btn-group btn-group-sm" role="group"></div>');
		},

		/* Creates and shows previous and first page links.
		*************************************************************************/
		_createFirstAndPreviousPageButtons: function () {
			var $first = $('<button></button>')
				.addClass('ewjtable-page-number-first btn btn-default')
				.html('<i class="icon-first ew-icon"></i>')
				.data('pageNumber', 1)
				.appendTo(this._$pagingListArea);

			var $previous = $('<button></button>')
				.addClass('ewjtable-page-number-previous btn btn-default')
				.html('<i class="icon-prev ew-icon"></i>')
				.data('pageNumber', this._currentPageNo - 1)
				.appendTo(this._$pagingListArea);

			this._jqueryuiThemeAddClass($first, 'ui-button ui-state-default', 'ui-state-hover');
			this._jqueryuiThemeAddClass($previous, 'ui-button ui-state-default', 'ui-state-hover');

			if (this._currentPageNo <= 1) {
				$first.addClass('ewjtable-page-number-disabled disabled');
				$previous.addClass('ewjtable-page-number-disabled disabled');
				this._jqueryuiThemeAddClass($first, 'ui-state-disabled');
				this._jqueryuiThemeAddClass($previous, 'ui-state-disabled');
			}
		},

		/* Creates and shows next and last page links.
		*************************************************************************/
		_createLastAndNextPageButtons: function (pageCount) {
			var $next = $('<button></button>')
				.addClass('ewjtable-page-number-next btn btn-default')
				.html('<i class="icon-next ew-icon"></i>')
				.data('pageNumber', this._currentPageNo + 1)
				.appendTo(this._$pagingListArea);
			var $last = $('<button></button>')
				.addClass('ewjtable-page-number-last btn btn-default')
				.html('<i class="icon-last ew-icon"></i>')
				.data('pageNumber', pageCount)
				.appendTo(this._$pagingListArea);

			this._jqueryuiThemeAddClass($next, 'ui-button ui-state-default', 'ui-state-hover');
			this._jqueryuiThemeAddClass($last, 'ui-button ui-state-default', 'ui-state-hover');

			if (this._currentPageNo >= pageCount) {
				$next.addClass('ewjtable-page-number-disabled disabled');
				$last.addClass('ewjtable-page-number-disabled disabled');
				this._jqueryuiThemeAddClass($next, 'ui-state-disabled');
				this._jqueryuiThemeAddClass($last, 'ui-state-disabled');
			}
		},

		/* Creates and shows page number links for given number array.
		*************************************************************************/
		_createPageNumberButtons: function (pageNumbers) {
			var previousNumber = 0;
			for (var i = 0; i < pageNumbers.length; i++) {
				//Create "..." between page numbers if needed
				if ((pageNumbers[i] - previousNumber) > 1) {
					$('<button></button>')
						.addClass('ewjtable-page-number-space btn btn-default')
						.html('<i class="fas fa-ellipsis-h ew-icon"></i>')
						.appendTo(this._$pagingListArea);
				}

				this._createPageNumberButton(pageNumbers[i]);
				previousNumber = pageNumbers[i];
			}
		},

		/* Creates a page number link and adds to paging area.
		*************************************************************************/
		_createPageNumberButton: function (pageNumber) {
			var $pageNumber = $('<button></button>')
				.addClass('ewjtable-page-number btn btn-default')
				.html(pageNumber)
				.data('pageNumber', pageNumber)
				.appendTo(this._$pagingListArea);

			this._jqueryuiThemeAddClass($pageNumber, 'ui-button ui-state-default', 'ui-state-hover');

			if (this._currentPageNo == pageNumber) {
				$pageNumber.addClass('ewjtable-page-number-active ewjtable-page-number-disabled');
				this._jqueryuiThemeAddClass($pageNumber, 'ui-state-active');
			}
		},

		/* Calculates total page count according to page size and total record count.
		*************************************************************************/
		_calculatePageCount: function () {
			var pageCount = Math.floor(this._totalRecordCount / this.options.pageSize);
			if (this._totalRecordCount % this.options.pageSize != 0) {
				++pageCount;
			}

			return pageCount;
		},

		/* Calculates page numbers and returns an array of these numbers.
		*************************************************************************/
		_calculatePageNumbers: function (pageCount) {
			if (pageCount <= 4) {
				//Show all pages
				var pageNumbers = [];
				for (var i = 1; i <= pageCount; ++i) {
					pageNumbers.push(i);
				}

				return pageNumbers;
			} else {
				//show first three, last three, current, previous and next page numbers
				var shownPageNumbers = [1, 2, pageCount - 1, pageCount];
				var previousPageNo = this._normalizeNumber(this._currentPageNo - 1, 1, pageCount, 1);
				var nextPageNo = this._normalizeNumber(this._currentPageNo + 1, 1, pageCount, 1);

				this._insertToArrayIfDoesNotExists(shownPageNumbers, previousPageNo);
				this._insertToArrayIfDoesNotExists(shownPageNumbers, this._currentPageNo);
				this._insertToArrayIfDoesNotExists(shownPageNumbers, nextPageNo);

				shownPageNumbers.sort(function (a, b) { return a - b; });
				return shownPageNumbers;
			}
		},

		/* Creates and shows paging informations.
		*************************************************************************/
		_createPagingInfo: function () {
			if (this._totalRecordCount <= 0 || this.options.pageSize > this._totalRecordCount) { //***
				this._$pageInfoSpan.empty();
				return;
			}

			var startNo = (this._currentPageNo - 1) * this.options.pageSize + 1;
			var endNo = this._currentPageNo * this.options.pageSize;
			endNo = this._normalizeNumber(endNo, startNo, this._totalRecordCount, 0);

			if (endNo >= startNo) {
				var pagingInfoMessage = this._formatString(this.options.messages.pagingInfo, startNo, endNo, this._totalRecordCount);
				this._$pageInfoSpan.html(pagingInfoMessage);
			}
		},

		/* Binds click events of all page links to change the page.
		*************************************************************************/
		_bindClickEventsToPageNumberButtons: function () {
			var self = this;
			self._$pagingListArea
				.find('.ewjtable-page-number,.ewjtable-page-number-previous,.ewjtable-page-number-next,.ewjtable-page-number-first,.ewjtable-page-number-last')
				.not('.ewjtable-page-number-disabled')
				.click(function (e) {
					e.preventDefault();
					self._changePage($(this).data('pageNumber'));
				});
		},

		/* Changes current page to given value.
		*************************************************************************/
		_changePage: function (pageNo) {
			pageNo = this._normalizeNumber(pageNo, 1, this._calculatePageCount(), 1);
			if (pageNo == this._currentPageNo) {
				this._refreshGotoPageInput();
				return;
			}

			this._currentPageNo = pageNo;
			this._reloadTable();
		}

	});

})(jQuery);


/************************************************************************
* SORTING extension for jTable                                          *
*************************************************************************/
(function ($) {

	//Reference to base object members
	var base = {
		_initializeFields: $.ew.ewjtable.prototype._initializeFields,
		_normalizeFieldOptions: $.ew.ewjtable.prototype._normalizeFieldOptions,
		_createHeaderCellForField: $.ew.ewjtable.prototype._createHeaderCellForField,
		_createRecordLoadUrl: $.ew.ewjtable.prototype._createRecordLoadUrl,
		_createJtParamsForLoading: $.ew.ewjtable.prototype._createJtParamsForLoading
	};

	//extension members
	$.extend(true, $.ew.ewjtable.prototype, {

		/************************************************************************
		* DEFAULT OPTIONS / EVENTS                                              *
		*************************************************************************/
		options: {
			sorting: false,
			multiSorting: false,
			defaultSorting: ''
		},

		/************************************************************************
		* PRIVATE FIELDS                                                        *
		*************************************************************************/

		_lastSorting: null, //Last sorting of the table

		/************************************************************************
		* OVERRIDED METHODS                                                     *
		*************************************************************************/

		/* Overrides base method to create sorting array.
		*************************************************************************/
		_initializeFields: function () {
			base._initializeFields.apply(this, arguments);

			this._lastSorting = [];
			if (this.options.sorting) {
				this._buildDefaultSortingArray();
			}
		},

		/* Overrides _normalizeFieldOptions method to normalize sorting option for fields.
		*************************************************************************/
		_normalizeFieldOptions: function (fieldName, props) {
			base._normalizeFieldOptions.apply(this, arguments);
			props.sorting = (props.sorting != false);
		},

		/* Overrides _createHeaderCellForField to make columns sortable.
		*************************************************************************/
		_createHeaderCellForField: function (fieldName, field) {
			var $headerCell = base._createHeaderCellForField.apply(this, arguments);
			if (this.options.sorting && field.sorting) {
				this._makeColumnSortable($headerCell, fieldName);
			}

			return $headerCell;
		},

		/* Overrides _createRecordLoadUrl to add sorting specific info to URL.
		*************************************************************************/
		_createRecordLoadUrl: function () {
			var loadUrl = base._createRecordLoadUrl.apply(this, arguments);
			loadUrl = this._addSortingInfoToUrl(loadUrl);
			return loadUrl;
		},

		/************************************************************************
		* PRIVATE METHODS                                                       *
		*************************************************************************/

		/* Builds the sorting array according to defaultSorting string
		*************************************************************************/
		_buildDefaultSortingArray: function () {
			var self = this;

			$.each(self.options.defaultSorting.split(","), function (orderIndex, orderValue) {
				$.each(self.options.fields, function (fieldName, fieldProps) {
					if (fieldProps.sorting) {
						var colOffset = orderValue.indexOf(fieldName);
						if (colOffset > -1) {
							if (orderValue.toUpperCase().indexOf(' DESC', colOffset) > -1) {
								self._lastSorting.push({
									fieldName: fieldName,
									sortOrder: 'DESC'
								});
							} else {
								self._lastSorting.push({
									fieldName: fieldName,
									sortOrder: 'ASC'
								});
							}
						}
					}
				});
			});
		},

		/* Makes a column sortable.
		*************************************************************************/
		_makeColumnSortable: function ($columnHeader, fieldName) {
			var self = this;
			
			$columnHeader
				.addClass('ewjtable-column-header-sortable')
				.click(function (e) {
					e.preventDefault();

					if (!self.options.multiSorting || !e.ctrlKey) {
						self._lastSorting = []; //clear previous sorting
					}
					
					self._sortTableByColumn($columnHeader);
				});

			//Set default sorting
			$.each(this._lastSorting, function (sortIndex, sortField) {
				if (sortField.fieldName == fieldName) {
					if (sortField.sortOrder == 'DESC') {
						$columnHeader.addClass('ewjtable-column-header-sorted-desc');
					} else {
						$columnHeader.addClass('ewjtable-column-header-sorted-asc');
					}
				}
			});
		},

		/* Sorts table according to a column header.
		*************************************************************************/
		_sortTableByColumn: function ($columnHeader) {
			//Remove sorting styles from all columns except this one
			if (this._lastSorting.length == 0) {
				$columnHeader.siblings().removeClass('ewjtable-column-header-sorted-asc jtable-column-header-sorted-desc');
			}

			//If current sorting list includes this column, remove it from the list
			for (var i = 0; i < this._lastSorting.length; i++) {
				if (this._lastSorting[i].fieldName == $columnHeader.data('fieldName')) {
					this._lastSorting.splice(i--, 1);
				}
			}

			//Sort ASC or DESC according to current sorting state
			if ($columnHeader.hasClass('ewjtable-column-header-sorted-asc')) {
				$columnHeader.removeClass('ewjtable-column-header-sorted-asc').addClass('ewjtable-column-header-sorted-desc');
				this._lastSorting.push({
					'fieldName': $columnHeader.data('fieldName'),
					sortOrder: 'DESC'
				});
			} else {
				$columnHeader.removeClass('ewjtable-column-header-sorted-desc').addClass('ewjtable-column-header-sorted-asc');
				this._lastSorting.push({
					'fieldName': $columnHeader.data('fieldName'),
					sortOrder: 'ASC'
				});
			}

			//Load current page again
			this._reloadTable();
		},

		/* Adds jtSorting parameter to a URL as query string.
		*************************************************************************/
		_addSortingInfoToUrl: function (url) {
			if (!this.options.sorting || this._lastSorting.length == 0) {
				return url;
			}

			var sorting = [];
			$.each(this._lastSorting, function (idx, value) {
				sorting.push(value.fieldName + ' ' + value.sortOrder);
			});

			return (url + (url.indexOf('?') < 0 ? '?' : '&') + 'sorting=' + sorting.join(","));
		},

		/* Overrides _createJtParamsForLoading method to add sorging parameters to jtParams object.
		*************************************************************************/
		_createJtParamsForLoading: function () {
			var jtParams = base._createJtParamsForLoading.apply(this, arguments);

			if (this.options.sorting && this._lastSorting.length) {
				var sorting = [];
				$.each(this._lastSorting, function (idx, value) {
					sorting.push(value.fieldName + ' ' + value.sortOrder);
				});

				jtParams.sorting = sorting.join(",");
			}

			return jtParams;
		}

	});

})(jQuery);