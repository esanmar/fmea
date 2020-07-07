(function(window) {
    "use strict";
    var CanvasPrototype = window.HTMLCanvasElement && window.HTMLCanvasElement.prototype;
    var hasBlobConstructor = window.Blob && function() {
        try {
            return Boolean(new Blob());
        } catch (e) {
            return false;
        }
    }();
    var hasArrayBufferViewSupport = hasBlobConstructor && window.Uint8Array && function() {
        try {
            return new Blob([ new Uint8Array(100) ]).size === 100;
        } catch (e) {
            return false;
        }
    }();
    var BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
    var dataURIPattern = /^data:((.*?)(;charset=.*?)?)(;base64)?,/;
    var dataURLtoBlob = (hasBlobConstructor || BlobBuilder) && window.atob && window.ArrayBuffer && window.Uint8Array && function(dataURI) {
        var matches, mediaType, isBase64, dataString, byteString, arrayBuffer, intArray, i, bb;
        matches = dataURI.match(dataURIPattern);
        if (!matches) {
            throw new Error("invalid data URI");
        }
        mediaType = matches[2] ? matches[1] : "text/plain" + (matches[3] || ";charset=US-ASCII");
        isBase64 = !!matches[4];
        dataString = dataURI.slice(matches[0].length);
        if (isBase64) {
            byteString = atob(dataString);
        } else {
            byteString = decodeURIComponent(dataString);
        }
        arrayBuffer = new ArrayBuffer(byteString.length);
        intArray = new Uint8Array(arrayBuffer);
        for (i = 0; i < byteString.length; i += 1) {
            intArray[i] = byteString.charCodeAt(i);
        }
        if (hasBlobConstructor) {
            return new Blob([ hasArrayBufferViewSupport ? intArray : arrayBuffer ], {
                type: mediaType
            });
        }
        bb = new BlobBuilder();
        bb.append(arrayBuffer);
        return bb.getBlob(mediaType);
    };
    if (window.HTMLCanvasElement && !CanvasPrototype.toBlob) {
        if (CanvasPrototype.mozGetAsFile) {
            CanvasPrototype.toBlob = function(callback, type, quality) {
                var self = this;
                setTimeout(function() {
                    if (quality && CanvasPrototype.toDataURL && dataURLtoBlob) {
                        callback(dataURLtoBlob(self.toDataURL(type, quality)));
                    } else {
                        callback(self.mozGetAsFile("blob", type));
                    }
                });
            };
        } else if (CanvasPrototype.toDataURL && dataURLtoBlob) {
            CanvasPrototype.toBlob = function(callback, type, quality) {
                var self = this;
                setTimeout(function() {
                    callback(dataURLtoBlob(self.toDataURL(type, quality)));
                });
            };
        }
    }
    if (typeof define === "function" && define.amd) {
        define(function() {
            return dataURLtoBlob;
        });
    } else if (typeof module === "object" && module.exports) {
        module.exports = dataURLtoBlob;
    } else {
        window.dataURLtoBlob = dataURLtoBlob;
    }
})(window);

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"));
    } else {
        factory(window.jQuery);
    }
})(function($) {
    "use strict";
    var counter = 0, jsonAPI = $, jsonParse = "parseJSON";
    if ("JSON" in window && "parse" in JSON) {
        jsonAPI = JSON;
        jsonParse = "parse";
    }
    $.ajaxTransport("iframe", function(options) {
        if (options.async) {
            var initialIframeSrc = options.initialIframeSrc || "javascript:false;", form, iframe, addParamChar;
            return {
                send: function(_, completeCallback) {
                    form = $('<form style="display:none;"></form>');
                    form.attr("accept-charset", options.formAcceptCharset);
                    addParamChar = /\?/.test(options.url) ? "&" : "?";
                    if (options.type === "DELETE") {
                        options.url = options.url + addParamChar + "_method=DELETE";
                        options.type = "POST";
                    } else if (options.type === "PUT") {
                        options.url = options.url + addParamChar + "_method=PUT";
                        options.type = "POST";
                    } else if (options.type === "PATCH") {
                        options.url = options.url + addParamChar + "_method=PATCH";
                        options.type = "POST";
                    }
                    counter += 1;
                    iframe = $('<iframe src="' + initialIframeSrc + '" name="iframe-transport-' + counter + '"></iframe>').bind("load", function() {
                        var fileInputClones, paramNames = $.isArray(options.paramName) ? options.paramName : [ options.paramName ];
                        iframe.unbind("load").bind("load", function() {
                            var response;
                            try {
                                response = iframe.contents();
                                if (!response.length || !response[0].firstChild) {
                                    throw new Error();
                                }
                            } catch (e) {
                                response = undefined;
                            }
                            completeCallback(200, "success", {
                                iframe: response
                            });
                            $('<iframe src="' + initialIframeSrc + '"></iframe>').appendTo(form);
                            window.setTimeout(function() {
                                form.remove();
                            }, 0);
                        });
                        form.prop("target", iframe.prop("name")).prop("action", options.url).prop("method", options.type);
                        if (options.formData) {
                            $.each(options.formData, function(index, field) {
                                $('<input type="hidden"/>').prop("name", field.name).val(field.value).appendTo(form);
                            });
                        }
                        if (options.fileInput && options.fileInput.length && options.type === "POST") {
                            fileInputClones = options.fileInput.clone();
                            options.fileInput.after(function(index) {
                                return fileInputClones[index];
                            });
                            if (options.paramName) {
                                options.fileInput.each(function(index) {
                                    $(this).prop("name", paramNames[index] || options.paramName);
                                });
                            }
                            form.append(options.fileInput).prop("enctype", "multipart/form-data").prop("encoding", "multipart/form-data");
                            options.fileInput.removeAttr("form");
                        }
                        form.submit();
                        if (fileInputClones && fileInputClones.length) {
                            options.fileInput.each(function(index, input) {
                                var clone = $(fileInputClones[index]);
                                $(input).prop("name", clone.prop("name")).attr("form", clone.attr("form"));
                                clone.replaceWith(input);
                            });
                        }
                    });
                    form.append(iframe).appendTo(document.body);
                },
                abort: function() {
                    if (iframe) {
                        iframe.unbind("load").prop("src", initialIframeSrc);
                    }
                    if (form) {
                        form.remove();
                    }
                }
            };
        }
    });
    $.ajaxSetup({
        converters: {
            "iframe text": function(iframe) {
                return iframe && $(iframe[0].body).text();
            },
            "iframe json": function(iframe) {
                return iframe && jsonAPI[jsonParse]($(iframe[0].body).text());
            },
            "iframe html": function(iframe) {
                return iframe && $(iframe[0].body).html();
            },
            "iframe xml": function(iframe) {
                var xmlDoc = iframe && iframe[0];
                return xmlDoc && $.isXMLDoc(xmlDoc) ? xmlDoc : $.parseXML(xmlDoc.XMLDocument && xmlDoc.XMLDocument.xml || $(xmlDoc.body).html());
            },
            "iframe script": function(iframe) {
                return iframe && $.globalEval($(iframe[0].body).text());
            }
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "jquery-ui/ui/widget" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("./vendor/jquery.ui.widget"));
    } else {
        factory(window.jQuery);
    }
})(function($) {
    "use strict";
    $.support.fileInput = !(new RegExp("(Android (1\\.[0156]|2\\.[01]))" + "|(Windows Phone (OS 7|8\\.0))|(XBLWP)|(ZuneWP)|(WPDesktop)" + "|(w(eb)?OSBrowser)|(webOS)" + "|(Kindle/(1\\.0|2\\.[05]|3\\.0))").test(window.navigator.userAgent) || $('<input type="file"/>').prop("disabled"));
    $.support.xhrFileUpload = !!(window.ProgressEvent && window.FileReader);
    $.support.xhrFormDataFileUpload = !!window.FormData;
    $.support.blobSlice = window.Blob && (Blob.prototype.slice || Blob.prototype.webkitSlice || Blob.prototype.mozSlice);
    function getDragHandler(type) {
        var isDragOver = type === "dragover";
        return function(e) {
            e.dataTransfer = e.originalEvent && e.originalEvent.dataTransfer;
            var dataTransfer = e.dataTransfer;
            if (dataTransfer && $.inArray("Files", dataTransfer.types) !== -1 && this._trigger(type, $.Event(type, {
                delegatedEvent: e
            })) !== false) {
                e.preventDefault();
                if (isDragOver) {
                    dataTransfer.dropEffect = "copy";
                }
            }
        };
    }
    $.widget("blueimp.fileupload", {
        options: {
            dropZone: $(document),
            pasteZone: undefined,
            fileInput: undefined,
            replaceFileInput: true,
            paramName: undefined,
            singleFileUploads: true,
            limitMultiFileUploads: undefined,
            limitMultiFileUploadSize: undefined,
            limitMultiFileUploadSizeOverhead: 512,
            sequentialUploads: false,
            limitConcurrentUploads: undefined,
            forceIframeTransport: false,
            redirect: undefined,
            redirectParamName: undefined,
            postMessage: undefined,
            multipart: true,
            maxChunkSize: undefined,
            uploadedBytes: undefined,
            recalculateProgress: true,
            progressInterval: 100,
            bitrateInterval: 500,
            autoUpload: true,
            uniqueFilenames: undefined,
            messages: {
                uploadedBytes: "Uploaded bytes exceed file size"
            },
            i18n: function(message, context) {
                message = this.messages[message] || message.toString();
                if (context) {
                    $.each(context, function(key, value) {
                        message = message.replace("{" + key + "}", value);
                    });
                }
                return message;
            },
            formData: function(form) {
                return form.serializeArray();
            },
            add: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                if (data.autoUpload || data.autoUpload !== false && $(this).fileupload("option", "autoUpload")) {
                    data.process().done(function() {
                        data.submit();
                    });
                }
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 0
        },
        _specialOptions: [ "fileInput", "dropZone", "pasteZone", "multipart", "forceIframeTransport" ],
        _blobSlice: $.support.blobSlice && function() {
            var slice = this.slice || this.webkitSlice || this.mozSlice;
            return slice.apply(this, arguments);
        },
        _BitrateTimer: function() {
            this.timestamp = Date.now ? Date.now() : new Date().getTime();
            this.loaded = 0;
            this.bitrate = 0;
            this.getBitrate = function(now, loaded, interval) {
                var timeDiff = now - this.timestamp;
                if (!this.bitrate || !interval || timeDiff > interval) {
                    this.bitrate = (loaded - this.loaded) * (1e3 / timeDiff) * 8;
                    this.loaded = loaded;
                    this.timestamp = now;
                }
                return this.bitrate;
            };
        },
        _isXHRUpload: function(options) {
            return !options.forceIframeTransport && (!options.multipart && $.support.xhrFileUpload || $.support.xhrFormDataFileUpload);
        },
        _getFormData: function(options) {
            var formData;
            if ($.type(options.formData) === "function") {
                return options.formData(options.form);
            }
            if ($.isArray(options.formData)) {
                return options.formData;
            }
            if ($.type(options.formData) === "object") {
                formData = [];
                $.each(options.formData, function(name, value) {
                    formData.push({
                        name: name,
                        value: value
                    });
                });
                return formData;
            }
            return [];
        },
        _getTotal: function(files) {
            var total = 0;
            $.each(files, function(index, file) {
                total += file.size || 1;
            });
            return total;
        },
        _initProgressObject: function(obj) {
            var progress = {
                loaded: 0,
                total: 0,
                bitrate: 0
            };
            if (obj._progress) {
                $.extend(obj._progress, progress);
            } else {
                obj._progress = progress;
            }
        },
        _initResponseObject: function(obj) {
            var prop;
            if (obj._response) {
                for (prop in obj._response) {
                    if (obj._response.hasOwnProperty(prop)) {
                        delete obj._response[prop];
                    }
                }
            } else {
                obj._response = {};
            }
        },
        _onProgress: function(e, data) {
            if (e.lengthComputable) {
                var now = Date.now ? Date.now() : new Date().getTime(), loaded;
                if (data._time && data.progressInterval && now - data._time < data.progressInterval && e.loaded !== e.total) {
                    return;
                }
                data._time = now;
                loaded = Math.floor(e.loaded / e.total * (data.chunkSize || data._progress.total)) + (data.uploadedBytes || 0);
                this._progress.loaded += loaded - data._progress.loaded;
                this._progress.bitrate = this._bitrateTimer.getBitrate(now, this._progress.loaded, data.bitrateInterval);
                data._progress.loaded = data.loaded = loaded;
                data._progress.bitrate = data.bitrate = data._bitrateTimer.getBitrate(now, loaded, data.bitrateInterval);
                this._trigger("progress", $.Event("progress", {
                    delegatedEvent: e
                }), data);
                this._trigger("progressall", $.Event("progressall", {
                    delegatedEvent: e
                }), this._progress);
            }
        },
        _initProgressListener: function(options) {
            var that = this, xhr = options.xhr ? options.xhr() : $.ajaxSettings.xhr();
            if (xhr.upload) {
                $(xhr.upload).bind("progress", function(e) {
                    var oe = e.originalEvent;
                    e.lengthComputable = oe.lengthComputable;
                    e.loaded = oe.loaded;
                    e.total = oe.total;
                    that._onProgress(e, options);
                });
                options.xhr = function() {
                    return xhr;
                };
            }
        },
        _deinitProgressListener: function(options) {
            var xhr = options.xhr ? options.xhr() : $.ajaxSettings.xhr();
            if (xhr.upload) {
                $(xhr.upload).unbind("progress");
            }
        },
        _isInstanceOf: function(type, obj) {
            return Object.prototype.toString.call(obj) === "[object " + type + "]";
        },
        _getUniqueFilename: function(name, map) {
            name = String(name);
            if (map[name]) {
                name = name.replace(/(?: \(([\d]+)\))?(\.[^.]+)?$/, function(_, p1, p2) {
                    var index = p1 ? Number(p1) + 1 : 1;
                    var ext = p2 || "";
                    return " (" + index + ")" + ext;
                });
                return this._getUniqueFilename(name, map);
            }
            map[name] = true;
            return name;
        },
        _initXHRData: function(options) {
            var that = this, formData, file = options.files[0], multipart = options.multipart || !$.support.xhrFileUpload, paramName = $.type(options.paramName) === "array" ? options.paramName[0] : options.paramName;
            options.headers = $.extend({}, options.headers);
            if (options.contentRange) {
                options.headers["Content-Range"] = options.contentRange;
            }
            if (!multipart || options.blob || !this._isInstanceOf("File", file)) {
                options.headers["Content-Disposition"] = 'attachment; filename="' + encodeURI(file.uploadName || file.name) + '"';
            }
            if (!multipart) {
                options.contentType = file.type || "application/octet-stream";
                options.data = options.blob || file;
            } else if ($.support.xhrFormDataFileUpload) {
                if (options.postMessage) {
                    formData = this._getFormData(options);
                    if (options.blob) {
                        formData.push({
                            name: paramName,
                            value: options.blob
                        });
                    } else {
                        $.each(options.files, function(index, file) {
                            formData.push({
                                name: $.type(options.paramName) === "array" && options.paramName[index] || paramName,
                                value: file
                            });
                        });
                    }
                } else {
                    if (that._isInstanceOf("FormData", options.formData)) {
                        formData = options.formData;
                    } else {
                        formData = new FormData();
                        $.each(this._getFormData(options), function(index, field) {
                            formData.append(field.name, field.value);
                        });
                    }
                    if (options.blob) {
                        formData.append(paramName, options.blob, file.uploadName || file.name);
                    } else {
                        $.each(options.files, function(index, file) {
                            if (that._isInstanceOf("File", file) || that._isInstanceOf("Blob", file)) {
                                var fileName = file.uploadName || file.name;
                                if (options.uniqueFilenames) {
                                    fileName = that._getUniqueFilename(fileName, options.uniqueFilenames);
                                }
                                formData.append($.type(options.paramName) === "array" && options.paramName[index] || paramName, file, fileName);
                            }
                        });
                    }
                }
                options.data = formData;
            }
            options.blob = null;
        },
        _initIframeSettings: function(options) {
            var targetHost = $("<a></a>").prop("href", options.url).prop("host");
            options.dataType = "iframe " + (options.dataType || "");
            options.formData = this._getFormData(options);
            if (options.redirect && targetHost && targetHost !== location.host) {
                options.formData.push({
                    name: options.redirectParamName || "redirect",
                    value: options.redirect
                });
            }
        },
        _initDataSettings: function(options) {
            if (this._isXHRUpload(options)) {
                if (!this._chunkedUpload(options, true)) {
                    if (!options.data) {
                        this._initXHRData(options);
                    }
                    this._initProgressListener(options);
                }
                if (options.postMessage) {
                    options.dataType = "postmessage " + (options.dataType || "");
                }
            } else {
                this._initIframeSettings(options);
            }
        },
        _getParamName: function(options) {
            var fileInput = $(options.fileInput), paramName = options.paramName;
            if (!paramName) {
                paramName = [];
                fileInput.each(function() {
                    var input = $(this), name = input.prop("name") || "files[]", i = (input.prop("files") || [ 1 ]).length;
                    while (i) {
                        paramName.push(name);
                        i -= 1;
                    }
                });
                if (!paramName.length) {
                    paramName = [ fileInput.prop("name") || "files[]" ];
                }
            } else if (!$.isArray(paramName)) {
                paramName = [ paramName ];
            }
            return paramName;
        },
        _initFormSettings: function(options) {
            if (!options.form || !options.form.length) {
                options.form = $(options.fileInput.prop("form"));
                if (!options.form.length) {
                    options.form = $(this.options.fileInput.prop("form"));
                }
            }
            options.paramName = this._getParamName(options);
            if (!options.url) {
                options.url = options.form.prop("action") || location.href;
            }
            options.type = (options.type || $.type(options.form.prop("method")) === "string" && options.form.prop("method") || "").toUpperCase();
            if (options.type !== "POST" && options.type !== "PUT" && options.type !== "PATCH") {
                options.type = "POST";
            }
            if (!options.formAcceptCharset) {
                options.formAcceptCharset = options.form.attr("accept-charset");
            }
        },
        _getAJAXSettings: function(data) {
            var options = $.extend({}, this.options, data);
            this._initFormSettings(options);
            this._initDataSettings(options);
            return options;
        },
        _getDeferredState: function(deferred) {
            if (deferred.state) {
                return deferred.state();
            }
            if (deferred.isResolved()) {
                return "resolved";
            }
            if (deferred.isRejected()) {
                return "rejected";
            }
            return "pending";
        },
        _enhancePromise: function(promise) {
            promise.success = promise.done;
            promise.error = promise.fail;
            promise.complete = promise.always;
            return promise;
        },
        _getXHRPromise: function(resolveOrReject, context, args) {
            var dfd = $.Deferred(), promise = dfd.promise();
            context = context || this.options.context || promise;
            if (resolveOrReject === true) {
                dfd.resolveWith(context, args);
            } else if (resolveOrReject === false) {
                dfd.rejectWith(context, args);
            }
            promise.abort = dfd.promise;
            return this._enhancePromise(promise);
        },
        _addConvenienceMethods: function(e, data) {
            var that = this, getPromise = function(args) {
                return $.Deferred().resolveWith(that, args).promise();
            };
            data.process = function(resolveFunc, rejectFunc) {
                if (resolveFunc || rejectFunc) {
                    data._processQueue = this._processQueue = (this._processQueue || getPromise([ this ])).then(function() {
                        if (data.errorThrown) {
                            return $.Deferred().rejectWith(that, [ data ]).promise();
                        }
                        return getPromise(arguments);
                    }).then(resolveFunc, rejectFunc);
                }
                return this._processQueue || getPromise([ this ]);
            };
            data.submit = function() {
                if (this.state() !== "pending") {
                    data.jqXHR = this.jqXHR = that._trigger("submit", $.Event("submit", {
                        delegatedEvent: e
                    }), this) !== false && that._onSend(e, this);
                }
                return this.jqXHR || that._getXHRPromise();
            };
            data.abort = function() {
                if (this.jqXHR) {
                    return this.jqXHR.abort();
                }
                this.errorThrown = "abort";
                that._trigger("fail", null, this);
                return that._getXHRPromise(false);
            };
            data.state = function() {
                if (this.jqXHR) {
                    return that._getDeferredState(this.jqXHR);
                }
                if (this._processQueue) {
                    return that._getDeferredState(this._processQueue);
                }
            };
            data.processing = function() {
                return !this.jqXHR && this._processQueue && that._getDeferredState(this._processQueue) === "pending";
            };
            data.progress = function() {
                return this._progress;
            };
            data.response = function() {
                return this._response;
            };
        },
        _getUploadedBytes: function(jqXHR) {
            var range = jqXHR.getResponseHeader("Range"), parts = range && range.split("-"), upperBytesPos = parts && parts.length > 1 && parseInt(parts[1], 10);
            return upperBytesPos && upperBytesPos + 1;
        },
        _chunkedUpload: function(options, testOnly) {
            options.uploadedBytes = options.uploadedBytes || 0;
            var that = this, file = options.files[0], fs = file.size, ub = options.uploadedBytes, mcs = options.maxChunkSize || fs, slice = this._blobSlice, dfd = $.Deferred(), promise = dfd.promise(), jqXHR, upload;
            if (!(this._isXHRUpload(options) && slice && (ub || ($.type(mcs) === "function" ? mcs(options) : mcs) < fs)) || options.data) {
                return false;
            }
            if (testOnly) {
                return true;
            }
            if (ub >= fs) {
                file.error = options.i18n("uploadedBytes");
                return this._getXHRPromise(false, options.context, [ null, "error", file.error ]);
            }
            upload = function() {
                var o = $.extend({}, options), currentLoaded = o._progress.loaded;
                o.blob = slice.call(file, ub, ub + ($.type(mcs) === "function" ? mcs(o) : mcs), file.type);
                o.chunkSize = o.blob.size;
                o.contentRange = "bytes " + ub + "-" + (ub + o.chunkSize - 1) + "/" + fs;
                that._trigger("chunkbeforesend", null, o);
                that._initXHRData(o);
                that._initProgressListener(o);
                jqXHR = (that._trigger("chunksend", null, o) !== false && $.ajax(o) || that._getXHRPromise(false, o.context)).done(function(result, textStatus, jqXHR) {
                    ub = that._getUploadedBytes(jqXHR) || ub + o.chunkSize;
                    if (currentLoaded + o.chunkSize - o._progress.loaded) {
                        that._onProgress($.Event("progress", {
                            lengthComputable: true,
                            loaded: ub - o.uploadedBytes,
                            total: ub - o.uploadedBytes
                        }), o);
                    }
                    options.uploadedBytes = o.uploadedBytes = ub;
                    o.result = result;
                    o.textStatus = textStatus;
                    o.jqXHR = jqXHR;
                    that._trigger("chunkdone", null, o);
                    that._trigger("chunkalways", null, o);
                    if (ub < fs) {
                        upload();
                    } else {
                        dfd.resolveWith(o.context, [ result, textStatus, jqXHR ]);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    o.jqXHR = jqXHR;
                    o.textStatus = textStatus;
                    o.errorThrown = errorThrown;
                    that._trigger("chunkfail", null, o);
                    that._trigger("chunkalways", null, o);
                    dfd.rejectWith(o.context, [ jqXHR, textStatus, errorThrown ]);
                }).always(function() {
                    that._deinitProgressListener(o);
                });
            };
            this._enhancePromise(promise);
            promise.abort = function() {
                return jqXHR.abort();
            };
            upload();
            return promise;
        },
        _beforeSend: function(e, data) {
            if (this._active === 0) {
                this._trigger("start");
                this._bitrateTimer = new this._BitrateTimer();
                this._progress.loaded = this._progress.total = 0;
                this._progress.bitrate = 0;
            }
            this._initResponseObject(data);
            this._initProgressObject(data);
            data._progress.loaded = data.loaded = data.uploadedBytes || 0;
            data._progress.total = data.total = this._getTotal(data.files) || 1;
            data._progress.bitrate = data.bitrate = 0;
            this._active += 1;
            this._progress.loaded += data.loaded;
            this._progress.total += data.total;
        },
        _onDone: function(result, textStatus, jqXHR, options) {
            var total = options._progress.total, response = options._response;
            if (options._progress.loaded < total) {
                this._onProgress($.Event("progress", {
                    lengthComputable: true,
                    loaded: total,
                    total: total
                }), options);
            }
            response.result = options.result = result;
            response.textStatus = options.textStatus = textStatus;
            response.jqXHR = options.jqXHR = jqXHR;
            this._trigger("done", null, options);
        },
        _onFail: function(jqXHR, textStatus, errorThrown, options) {
            var response = options._response;
            if (options.recalculateProgress) {
                this._progress.loaded -= options._progress.loaded;
                this._progress.total -= options._progress.total;
            }
            response.jqXHR = options.jqXHR = jqXHR;
            response.textStatus = options.textStatus = textStatus;
            response.errorThrown = options.errorThrown = errorThrown;
            this._trigger("fail", null, options);
        },
        _onAlways: function(jqXHRorResult, textStatus, jqXHRorError, options) {
            this._trigger("always", null, options);
        },
        _onSend: function(e, data) {
            if (!data.submit) {
                this._addConvenienceMethods(e, data);
            }
            var that = this, jqXHR, aborted, slot, pipe, options = that._getAJAXSettings(data), send = function() {
                that._sending += 1;
                options._bitrateTimer = new that._BitrateTimer();
                jqXHR = jqXHR || ((aborted || that._trigger("send", $.Event("send", {
                    delegatedEvent: e
                }), options) === false) && that._getXHRPromise(false, options.context, aborted) || that._chunkedUpload(options) || $.ajax(options)).done(function(result, textStatus, jqXHR) {
                    that._onDone(result, textStatus, jqXHR, options);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    that._onFail(jqXHR, textStatus, errorThrown, options);
                }).always(function(jqXHRorResult, textStatus, jqXHRorError) {
                    that._deinitProgressListener(options);
                    that._onAlways(jqXHRorResult, textStatus, jqXHRorError, options);
                    that._sending -= 1;
                    that._active -= 1;
                    if (options.limitConcurrentUploads && options.limitConcurrentUploads > that._sending) {
                        var nextSlot = that._slots.shift();
                        while (nextSlot) {
                            if (that._getDeferredState(nextSlot) === "pending") {
                                nextSlot.resolve();
                                break;
                            }
                            nextSlot = that._slots.shift();
                        }
                    }
                    if (that._active === 0) {
                        that._trigger("stop");
                    }
                });
                return jqXHR;
            };
            this._beforeSend(e, options);
            if (this.options.sequentialUploads || this.options.limitConcurrentUploads && this.options.limitConcurrentUploads <= this._sending) {
                if (this.options.limitConcurrentUploads > 1) {
                    slot = $.Deferred();
                    this._slots.push(slot);
                    pipe = slot.then(send);
                } else {
                    this._sequence = this._sequence.then(send, send);
                    pipe = this._sequence;
                }
                pipe.abort = function() {
                    aborted = [ undefined, "abort", "abort" ];
                    if (!jqXHR) {
                        if (slot) {
                            slot.rejectWith(options.context, aborted);
                        }
                        return send();
                    }
                    return jqXHR.abort();
                };
                return this._enhancePromise(pipe);
            }
            return send();
        },
        _onAdd: function(e, data) {
            var that = this, result = true, options = $.extend({}, this.options, data), files = data.files, filesLength = files.length, limit = options.limitMultiFileUploads, limitSize = options.limitMultiFileUploadSize, overhead = options.limitMultiFileUploadSizeOverhead, batchSize = 0, paramName = this._getParamName(options), paramNameSet, paramNameSlice, fileSet, i, j = 0;
            if (!filesLength) {
                return false;
            }
            if (limitSize && files[0].size === undefined) {
                limitSize = undefined;
            }
            if (!(options.singleFileUploads || limit || limitSize) || !this._isXHRUpload(options)) {
                fileSet = [ files ];
                paramNameSet = [ paramName ];
            } else if (!(options.singleFileUploads || limitSize) && limit) {
                fileSet = [];
                paramNameSet = [];
                for (i = 0; i < filesLength; i += limit) {
                    fileSet.push(files.slice(i, i + limit));
                    paramNameSlice = paramName.slice(i, i + limit);
                    if (!paramNameSlice.length) {
                        paramNameSlice = paramName;
                    }
                    paramNameSet.push(paramNameSlice);
                }
            } else if (!options.singleFileUploads && limitSize) {
                fileSet = [];
                paramNameSet = [];
                for (i = 0; i < filesLength; i = i + 1) {
                    batchSize += files[i].size + overhead;
                    if (i + 1 === filesLength || batchSize + files[i + 1].size + overhead > limitSize || limit && i + 1 - j >= limit) {
                        fileSet.push(files.slice(j, i + 1));
                        paramNameSlice = paramName.slice(j, i + 1);
                        if (!paramNameSlice.length) {
                            paramNameSlice = paramName;
                        }
                        paramNameSet.push(paramNameSlice);
                        j = i + 1;
                        batchSize = 0;
                    }
                }
            } else {
                paramNameSet = paramName;
            }
            data.originalFiles = files;
            $.each(fileSet || files, function(index, element) {
                var newData = $.extend({}, data);
                newData.files = fileSet ? element : [ element ];
                newData.paramName = paramNameSet[index];
                that._initResponseObject(newData);
                that._initProgressObject(newData);
                that._addConvenienceMethods(e, newData);
                result = that._trigger("add", $.Event("add", {
                    delegatedEvent: e
                }), newData);
                return result;
            });
            return result;
        },
        _replaceFileInput: function(data) {
            var input = data.fileInput, inputClone = input.clone(true), restoreFocus = input.is(document.activeElement);
            data.fileInputClone = inputClone;
            $("<form></form>").append(inputClone)[0].reset();
            input.after(inputClone).detach();
            if (restoreFocus) {
                inputClone.focus();
            }
            $.cleanData(input.unbind("remove"));
            this.options.fileInput = this.options.fileInput.map(function(i, el) {
                if (el === input[0]) {
                    return inputClone[0];
                }
                return el;
            });
            if (input[0] === this.element[0]) {
                this.element = inputClone;
            }
        },
        _handleFileTreeEntry: function(entry, path) {
            var that = this, dfd = $.Deferred(), entries = [], dirReader, errorHandler = function(e) {
                if (e && !e.entry) {
                    e.entry = entry;
                }
                dfd.resolve([ e ]);
            }, successHandler = function(entries) {
                that._handleFileTreeEntries(entries, path + entry.name + "/").done(function(files) {
                    dfd.resolve(files);
                }).fail(errorHandler);
            }, readEntries = function() {
                dirReader.readEntries(function(results) {
                    if (!results.length) {
                        successHandler(entries);
                    } else {
                        entries = entries.concat(results);
                        readEntries();
                    }
                }, errorHandler);
            };
            path = path || "";
            if (entry.isFile) {
                if (entry._file) {
                    entry._file.relativePath = path;
                    dfd.resolve(entry._file);
                } else {
                    entry.file(function(file) {
                        file.relativePath = path;
                        dfd.resolve(file);
                    }, errorHandler);
                }
            } else if (entry.isDirectory) {
                dirReader = entry.createReader();
                readEntries();
            } else {
                dfd.resolve([]);
            }
            return dfd.promise();
        },
        _handleFileTreeEntries: function(entries, path) {
            var that = this;
            return $.when.apply($, $.map(entries, function(entry) {
                return that._handleFileTreeEntry(entry, path);
            })).then(function() {
                return Array.prototype.concat.apply([], arguments);
            });
        },
        _getDroppedFiles: function(dataTransfer) {
            dataTransfer = dataTransfer || {};
            var items = dataTransfer.items;
            if (items && items.length && (items[0].webkitGetAsEntry || items[0].getAsEntry)) {
                return this._handleFileTreeEntries($.map(items, function(item) {
                    var entry;
                    if (item.webkitGetAsEntry) {
                        entry = item.webkitGetAsEntry();
                        if (entry) {
                            entry._file = item.getAsFile();
                        }
                        return entry;
                    }
                    return item.getAsEntry();
                }));
            }
            return $.Deferred().resolve($.makeArray(dataTransfer.files)).promise();
        },
        _getSingleFileInputFiles: function(fileInput) {
            fileInput = $(fileInput);
            var entries = fileInput.prop("webkitEntries") || fileInput.prop("entries"), files, value;
            if (entries && entries.length) {
                return this._handleFileTreeEntries(entries);
            }
            files = $.makeArray(fileInput.prop("files"));
            if (!files.length) {
                value = fileInput.prop("value");
                if (!value) {
                    return $.Deferred().resolve([]).promise();
                }
                files = [ {
                    name: value.replace(/^.*\\/, "")
                } ];
            } else if (files[0].name === undefined && files[0].fileName) {
                $.each(files, function(index, file) {
                    file.name = file.fileName;
                    file.size = file.fileSize;
                });
            }
            return $.Deferred().resolve(files).promise();
        },
        _getFileInputFiles: function(fileInput) {
            if (!(fileInput instanceof $) || fileInput.length === 1) {
                return this._getSingleFileInputFiles(fileInput);
            }
            return $.when.apply($, $.map(fileInput, this._getSingleFileInputFiles)).then(function() {
                return Array.prototype.concat.apply([], arguments);
            });
        },
        _onChange: function(e) {
            var that = this, data = {
                fileInput: $(e.target),
                form: $(e.target.form)
            };
            this._getFileInputFiles(data.fileInput).always(function(files) {
                data.files = files;
                if (that.options.replaceFileInput) {
                    that._replaceFileInput(data);
                }
                if (that._trigger("change", $.Event("change", {
                    delegatedEvent: e
                }), data) !== false) {
                    that._onAdd(e, data);
                }
            });
        },
        _onPaste: function(e) {
            var items = e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.items, data = {
                files: []
            };
            if (items && items.length) {
                $.each(items, function(index, item) {
                    var file = item.getAsFile && item.getAsFile();
                    if (file) {
                        data.files.push(file);
                    }
                });
                if (this._trigger("paste", $.Event("paste", {
                    delegatedEvent: e
                }), data) !== false) {
                    this._onAdd(e, data);
                }
            }
        },
        _onDrop: function(e) {
            e.dataTransfer = e.originalEvent && e.originalEvent.dataTransfer;
            var that = this, dataTransfer = e.dataTransfer, data = {};
            if (dataTransfer && dataTransfer.files && dataTransfer.files.length) {
                e.preventDefault();
                this._getDroppedFiles(dataTransfer).always(function(files) {
                    data.files = files;
                    if (that._trigger("drop", $.Event("drop", {
                        delegatedEvent: e
                    }), data) !== false) {
                        that._onAdd(e, data);
                    }
                });
            }
        },
        _onDragOver: getDragHandler("dragover"),
        _onDragEnter: getDragHandler("dragenter"),
        _onDragLeave: getDragHandler("dragleave"),
        _initEventHandlers: function() {
            if (this._isXHRUpload(this.options)) {
                this._on(this.options.dropZone, {
                    dragover: this._onDragOver,
                    drop: this._onDrop,
                    dragenter: this._onDragEnter,
                    dragleave: this._onDragLeave
                });
                this._on(this.options.pasteZone, {
                    paste: this._onPaste
                });
            }
            if ($.support.fileInput) {
                this._on(this.options.fileInput, {
                    change: this._onChange
                });
            }
        },
        _destroyEventHandlers: function() {
            this._off(this.options.dropZone, "dragenter dragleave dragover drop");
            this._off(this.options.pasteZone, "paste");
            this._off(this.options.fileInput, "change");
        },
        _destroy: function() {
            this._destroyEventHandlers();
        },
        _setOption: function(key, value) {
            var reinit = $.inArray(key, this._specialOptions) !== -1;
            if (reinit) {
                this._destroyEventHandlers();
            }
            this._super(key, value);
            if (reinit) {
                this._initSpecialOptions();
                this._initEventHandlers();
            }
        },
        _initSpecialOptions: function() {
            var options = this.options;
            if (options.fileInput === undefined) {
                options.fileInput = this.element.is('input[type="file"]') ? this.element : this.element.find('input[type="file"]');
            } else if (!(options.fileInput instanceof $)) {
                options.fileInput = $(options.fileInput);
            }
            if (!(options.dropZone instanceof $)) {
                options.dropZone = $(options.dropZone);
            }
            if (!(options.pasteZone instanceof $)) {
                options.pasteZone = $(options.pasteZone);
            }
        },
        _getRegExp: function(str) {
            var parts = str.split("/"), modifiers = parts.pop();
            parts.shift();
            return new RegExp(parts.join("/"), modifiers);
        },
        _isRegExpOption: function(key, value) {
            return key !== "url" && $.type(value) === "string" && /^\/.*\/[igm]{0,3}$/.test(value);
        },
        _initDataAttributes: function() {
            var that = this, options = this.options, data = this.element.data();
            $.each(this.element[0].attributes, function(index, attr) {
                var key = attr.name.toLowerCase(), value;
                if (/^data-/.test(key)) {
                    key = key.slice(5).replace(/-[a-z]/g, function(str) {
                        return str.charAt(1).toUpperCase();
                    });
                    value = data[key];
                    if (that._isRegExpOption(key, value)) {
                        value = that._getRegExp(value);
                    }
                    options[key] = value;
                }
            });
        },
        _create: function() {
            this._initDataAttributes();
            this._initSpecialOptions();
            this._slots = [];
            this._sequence = this._getXHRPromise(true);
            this._sending = this._active = 0;
            this._initProgressObject(this);
            this._initEventHandlers();
        },
        active: function() {
            return this._active;
        },
        progress: function() {
            return this._progress;
        },
        add: function(data) {
            var that = this;
            if (!data || this.options.disabled) {
                return;
            }
            if (data.fileInput && !data.files) {
                this._getFileInputFiles(data.fileInput).always(function(files) {
                    data.files = files;
                    that._onAdd(null, data);
                });
            } else {
                data.files = $.makeArray(data.files);
                this._onAdd(null, data);
            }
        },
        send: function(data) {
            if (data && !this.options.disabled) {
                if (data.fileInput && !data.files) {
                    var that = this, dfd = $.Deferred(), promise = dfd.promise(), jqXHR, aborted;
                    promise.abort = function() {
                        aborted = true;
                        if (jqXHR) {
                            return jqXHR.abort();
                        }
                        dfd.reject(null, "abort", "abort");
                        return promise;
                    };
                    this._getFileInputFiles(data.fileInput).always(function(files) {
                        if (aborted) {
                            return;
                        }
                        if (!files.length) {
                            dfd.reject();
                            return;
                        }
                        data.files = files;
                        jqXHR = that._onSend(null, data);
                        jqXHR.then(function(result, textStatus, jqXHR) {
                            dfd.resolve(result, textStatus, jqXHR);
                        }, function(jqXHR, textStatus, errorThrown) {
                            dfd.reject(jqXHR, textStatus, errorThrown);
                        });
                    });
                    return this._enhancePromise(promise);
                }
                data.files = $.makeArray(data.files);
                if (data.files.length) {
                    return this._onSend(null, data);
                }
            }
            return this._getXHRPromise(false, data && data.context);
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "./jquery.fileupload" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("./jquery.fileupload"));
    } else {
        factory(window.jQuery);
    }
})(function($) {
    "use strict";
    var originalAdd = $.blueimp.fileupload.prototype.options.add;
    $.widget("blueimp.fileupload", $.blueimp.fileupload, {
        options: {
            processQueue: [],
            add: function(e, data) {
                var $this = $(this);
                data.process(function() {
                    return $this.fileupload("process", data);
                });
                originalAdd.call(this, e, data);
            }
        },
        processActions: {},
        _processFile: function(data, originalData) {
            var that = this, dfd = $.Deferred().resolveWith(that, [ data ]), chain = dfd.promise();
            this._trigger("process", null, data);
            $.each(data.processQueue, function(i, settings) {
                var func = function(data) {
                    if (originalData.errorThrown) {
                        return $.Deferred().rejectWith(that, [ originalData ]).promise();
                    }
                    return that.processActions[settings.action].call(that, data, settings);
                };
                chain = chain.then(func, settings.always && func);
            });
            chain.done(function() {
                that._trigger("processdone", null, data);
                that._trigger("processalways", null, data);
            }).fail(function() {
                that._trigger("processfail", null, data);
                that._trigger("processalways", null, data);
            });
            return chain;
        },
        _transformProcessQueue: function(options) {
            var processQueue = [];
            $.each(options.processQueue, function() {
                var settings = {}, action = this.action, prefix = this.prefix === true ? action : this.prefix;
                $.each(this, function(key, value) {
                    if ($.type(value) === "string" && value.charAt(0) === "@") {
                        settings[key] = options[value.slice(1) || (prefix ? prefix + key.charAt(0).toUpperCase() + key.slice(1) : key)];
                    } else {
                        settings[key] = value;
                    }
                });
                processQueue.push(settings);
            });
            options.processQueue = processQueue;
        },
        processing: function() {
            return this._processing;
        },
        process: function(data) {
            var that = this, options = $.extend({}, this.options, data);
            if (options.processQueue && options.processQueue.length) {
                this._transformProcessQueue(options);
                if (this._processing === 0) {
                    this._trigger("processstart");
                }
                $.each(data.files, function(index) {
                    var opts = index ? $.extend({}, options) : options, func = function() {
                        if (data.errorThrown) {
                            return $.Deferred().rejectWith(that, [ data ]).promise();
                        }
                        return that._processFile(opts, data);
                    };
                    opts.index = index;
                    that._processing += 1;
                    that._processingQueue = that._processingQueue.then(func, func).always(function() {
                        that._processing -= 1;
                        if (that._processing === 0) {
                            that._trigger("processstop");
                        }
                    });
                });
            }
            return this._processingQueue;
        },
        _create: function() {
            this._super();
            this._processing = 0;
            this._processingQueue = $.Deferred().resolveWith(this).promise();
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "load-image", "load-image-meta", "load-image-scale", "load-image-exif", "canvas-to-blob", "./jquery.fileupload-process" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("blueimp-load-image/js/load-image"), require("blueimp-load-image/js/load-image-meta"), require("blueimp-load-image/js/load-image-scale"), require("blueimp-load-image/js/load-image-exif"), require("blueimp-canvas-to-blob"), require("./jquery.fileupload-process"));
    } else {
        factory(window.jQuery, window.loadImage);
    }
})(function($, loadImage) {
    "use strict";
    $.blueimp.fileupload.prototype.options.processQueue.unshift({
        action: "loadImageMetaData",
        disableImageHead: "@",
        disableExif: "@",
        disableExifThumbnail: "@",
        disableExifSub: "@",
        disableExifGps: "@",
        disabled: "@disableImageMetaDataLoad"
    }, {
        action: "loadImage",
        prefix: true,
        fileTypes: "@",
        maxFileSize: "@",
        noRevoke: "@",
        disabled: "@disableImageLoad"
    }, {
        action: "resizeImage",
        prefix: "image",
        maxWidth: "@",
        maxHeight: "@",
        minWidth: "@",
        minHeight: "@",
        crop: "@",
        orientation: "@",
        forceResize: "@",
        disabled: "@disableImageResize"
    }, {
        action: "saveImage",
        quality: "@imageQuality",
        type: "@imageType",
        disabled: "@disableImageResize"
    }, {
        action: "saveImageMetaData",
        disabled: "@disableImageMetaDataSave"
    }, {
        action: "resizeImage",
        prefix: "preview",
        maxWidth: "@",
        maxHeight: "@",
        minWidth: "@",
        minHeight: "@",
        crop: "@",
        orientation: "@",
        thumbnail: "@",
        canvas: "@",
        disabled: "@disableImagePreview"
    }, {
        action: "setImage",
        name: "@imagePreviewName",
        disabled: "@disableImagePreview"
    }, {
        action: "deleteImageReferences",
        disabled: "@disableImageReferencesDeletion"
    });
    $.widget("blueimp.fileupload", $.blueimp.fileupload, {
        options: {
            loadImageFileTypes: /^image\/(gif|jpeg|png|svg\+xml)$/,
            loadImageMaxFileSize: 1e7,
            imageMaxWidth: 1920,
            imageMaxHeight: 1080,
            imageOrientation: false,
            imageCrop: false,
            disableImageResize: true,
            previewMaxWidth: 80,
            previewMaxHeight: 80,
            previewOrientation: true,
            previewThumbnail: true,
            previewCrop: false,
            previewCanvas: true
        },
        processActions: {
            loadImage: function(data, options) {
                if (options.disabled) {
                    return data;
                }
                var that = this, file = data.files[data.index], dfd = $.Deferred();
                if ($.type(options.maxFileSize) === "number" && file.size > options.maxFileSize || options.fileTypes && !options.fileTypes.test(file.type) || !loadImage(file, function(img) {
                    if (img.src) {
                        data.img = img;
                    }
                    dfd.resolveWith(that, [ data ]);
                }, options)) {
                    return data;
                }
                return dfd.promise();
            },
            resizeImage: function(data, options) {
                if (options.disabled || !(data.canvas || data.img)) {
                    return data;
                }
                options = $.extend({
                    canvas: true
                }, options);
                var that = this, dfd = $.Deferred(), img = options.canvas && data.canvas || data.img, resolve = function(newImg) {
                    if (newImg && (newImg.width !== img.width || newImg.height !== img.height || options.forceResize)) {
                        data[newImg.getContext ? "canvas" : "img"] = newImg;
                    }
                    data.preview = newImg;
                    dfd.resolveWith(that, [ data ]);
                }, thumbnail;
                if (data.exif) {
                    if (options.orientation === true) {
                        options.orientation = data.exif.get("Orientation");
                    }
                    if (options.thumbnail) {
                        thumbnail = data.exif.get("Thumbnail");
                        if (thumbnail) {
                            loadImage(thumbnail, resolve, options);
                            return dfd.promise();
                        }
                    }
                    if (data.orientation) {
                        delete options.orientation;
                    } else {
                        data.orientation = options.orientation;
                    }
                }
                if (img) {
                    resolve(loadImage.scale(img, options));
                    return dfd.promise();
                }
                return data;
            },
            saveImage: function(data, options) {
                if (!data.canvas || options.disabled) {
                    return data;
                }
                var that = this, file = data.files[data.index], dfd = $.Deferred();
                if (data.canvas.toBlob) {
                    data.canvas.toBlob(function(blob) {
                        if (!blob.name) {
                            if (file.type === blob.type) {
                                blob.name = file.name;
                            } else if (file.name) {
                                blob.name = file.name.replace(/\.\w+$/, "." + blob.type.substr(6));
                            }
                        }
                        if (file.type !== blob.type) {
                            delete data.imageHead;
                        }
                        data.files[data.index] = blob;
                        dfd.resolveWith(that, [ data ]);
                    }, options.type || file.type, options.quality);
                } else {
                    return data;
                }
                return dfd.promise();
            },
            loadImageMetaData: function(data, options) {
                if (options.disabled) {
                    return data;
                }
                var that = this, dfd = $.Deferred();
                loadImage.parseMetaData(data.files[data.index], function(result) {
                    $.extend(data, result);
                    dfd.resolveWith(that, [ data ]);
                }, options);
                return dfd.promise();
            },
            saveImageMetaData: function(data, options) {
                if (!(data.imageHead && data.canvas && data.canvas.toBlob && !options.disabled)) {
                    return data;
                }
                var file = data.files[data.index], blob = new Blob([ data.imageHead, this._blobSlice.call(file, 20) ], {
                    type: file.type
                });
                blob.name = file.name;
                data.files[data.index] = blob;
                return data;
            },
            setImage: function(data, options) {
                if (data.preview && !options.disabled) {
                    data.files[data.index][options.name || "preview"] = data.preview;
                }
                return data;
            },
            deleteImageReferences: function(data, options) {
                if (!options.disabled) {
                    delete data.img;
                    delete data.canvas;
                    delete data.preview;
                    delete data.imageHead;
                }
                return data;
            }
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "load-image", "./jquery.fileupload-process" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("blueimp-load-image/js/load-image"), require("./jquery.fileupload-process"));
    } else {
        factory(window.jQuery, window.loadImage);
    }
})(function($, loadImage) {
    "use strict";
    $.blueimp.fileupload.prototype.options.processQueue.unshift({
        action: "loadAudio",
        prefix: true,
        fileTypes: "@",
        maxFileSize: "@",
        disabled: "@disableAudioPreview"
    }, {
        action: "setAudio",
        name: "@audioPreviewName",
        disabled: "@disableAudioPreview"
    });
    $.widget("blueimp.fileupload", $.blueimp.fileupload, {
        options: {
            loadAudioFileTypes: /^audio\/.*$/
        },
        _audioElement: document.createElement("audio"),
        processActions: {
            loadAudio: function(data, options) {
                if (options.disabled) {
                    return data;
                }
                var file = data.files[data.index], url, audio;
                if (this._audioElement.canPlayType && this._audioElement.canPlayType(file.type) && ($.type(options.maxFileSize) !== "number" || file.size <= options.maxFileSize) && (!options.fileTypes || options.fileTypes.test(file.type))) {
                    url = loadImage.createObjectURL(file);
                    if (url) {
                        audio = this._audioElement.cloneNode(false);
                        audio.src = url;
                        audio.controls = true;
                        data.audio = audio;
                        return data;
                    }
                }
                return data;
            },
            setAudio: function(data, options) {
                if (data.audio && !options.disabled) {
                    data.files[data.index][options.name || "preview"] = data.audio;
                }
                return data;
            }
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "load-image", "./jquery.fileupload-process" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("blueimp-load-image/js/load-image"), require("./jquery.fileupload-process"));
    } else {
        factory(window.jQuery, window.loadImage);
    }
})(function($, loadImage) {
    "use strict";
    $.blueimp.fileupload.prototype.options.processQueue.unshift({
        action: "loadVideo",
        prefix: true,
        fileTypes: "@",
        maxFileSize: "@",
        disabled: "@disableVideoPreview"
    }, {
        action: "setVideo",
        name: "@videoPreviewName",
        disabled: "@disableVideoPreview"
    });
    $.widget("blueimp.fileupload", $.blueimp.fileupload, {
        options: {
            loadVideoFileTypes: /^video\/.*$/
        },
        _videoElement: document.createElement("video"),
        processActions: {
            loadVideo: function(data, options) {
                if (options.disabled) {
                    return data;
                }
                var file = data.files[data.index], url, video;
                if (this._videoElement.canPlayType && this._videoElement.canPlayType(file.type) && ($.type(options.maxFileSize) !== "number" || file.size <= options.maxFileSize) && (!options.fileTypes || options.fileTypes.test(file.type))) {
                    url = loadImage.createObjectURL(file);
                    if (url) {
                        video = this._videoElement.cloneNode(false);
                        video.src = url;
                        video.controls = true;
                        data.video = video;
                        return data;
                    }
                }
                return data;
            },
            setVideo: function(data, options) {
                if (data.video && !options.disabled) {
                    data.files[data.index][options.name || "preview"] = data.video;
                }
                return data;
            }
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "./jquery.fileupload-process" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("./jquery.fileupload-process"));
    } else {
        factory(window.jQuery);
    }
})(function($) {
    "use strict";
    $.blueimp.fileupload.prototype.options.processQueue.push({
        action: "validate",
        always: true,
        acceptFileTypes: "@",
        maxFileSize: "@",
        minFileSize: "@",
        maxNumberOfFiles: "@",
        disabled: "@disableValidation"
    });
    $.widget("blueimp.fileupload", $.blueimp.fileupload, {
        options: {
            getNumberOfFiles: $.noop,
            messages: {
                maxNumberOfFiles: "Maximum number of files exceeded",
                acceptFileTypes: "File type not allowed",
                maxFileSize: "File is too large",
                minFileSize: "File is too small"
            }
        },
        processActions: {
            validate: function(data, options) {
                if (options.disabled) {
                    return data;
                }
                var dfd = $.Deferred(), settings = this.options, file = data.files[data.index], fileSize;
                if (options.minFileSize || options.maxFileSize) {
                    fileSize = file.size;
                }
                if ($.type(options.maxNumberOfFiles) === "number" && (settings.getNumberOfFiles() || 0) + data.files.length > options.maxNumberOfFiles) {
                    file.error = settings.i18n("maxNumberOfFiles");
                } else if (options.acceptFileTypes && !(options.acceptFileTypes.test(file.type) || options.acceptFileTypes.test(file.name))) {
                    file.error = settings.i18n("acceptFileTypes");
                } else if (fileSize > options.maxFileSize) {
                    file.error = settings.i18n("maxFileSize");
                } else if ($.type(fileSize) === "number" && fileSize < options.minFileSize) {
                    file.error = settings.i18n("minFileSize");
                } else {
                    delete file.error;
                }
                if (file.error || data.files.error) {
                    data.files.error = true;
                    dfd.rejectWith(this, [ data ]);
                } else {
                    dfd.resolveWith(this, [ data ]);
                }
                return dfd.promise();
            }
        }
    });
});

(function(factory) {
    "use strict";
    if (typeof define === "function" && define.amd) {
        define([ "jquery", "blueimp-tmpl", "./jquery.fileupload-image", "./jquery.fileupload-audio", "./jquery.fileupload-video", "./jquery.fileupload-validate" ], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"), require("blueimp-tmpl"), require("./jquery.fileupload-image"), require("./jquery.fileupload-audio"), require("./jquery.fileupload-video"), require("./jquery.fileupload-validate"));
    } else {
        factory(window.jQuery, window.tmpl);
    }
})(function($, tmpl) {
    "use strict";
    $.blueimp.fileupload.prototype._specialOptions.push("filesContainer", "uploadTemplateId", "downloadTemplateId");
    $.widget("blueimp.fileupload", $.blueimp.fileupload, {
        options: {
            autoUpload: false,
            uploadTemplateId: "template-upload",
            downloadTemplateId: "template-download",
            filesContainer: undefined,
            prependFiles: false,
            dataType: "json",
            messages: {
                unknownError: "Unknown error"
            },
            getNumberOfFiles: function() {
                return this.filesContainer.children().not(".processing").length;
            },
            getFilesFromResponse: function(data) {
                if (data.result && $.isArray(data.result.files)) {
                    return data.result.files;
                }
                return [];
            },
            add: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var $this = $(this), that = $this.data("blueimp-fileupload") || $this.data("fileupload"), options = that.options;
                data.context = that._renderUpload(data.files).data("data", data).addClass("processing");
                options.filesContainer[options.prependFiles ? "prepend" : "append"](data.context);
                that._forceReflow(data.context);
                that._transition(data.context);
                data.process(function() {
                    return $this.fileupload("process", data);
                }).always(function() {
                    data.context.each(function(index) {
                        $(this).find(".size").text(that._formatFileSize(data.files[index].size));
                    }).removeClass("processing");
                    that._renderPreviews(data);
                }).done(function() {
                    data.context.find(".start").prop("disabled", false);
                    if (that._trigger("added", e, data) !== false && (options.autoUpload || data.autoUpload) && data.autoUpload !== false) {
                        data.submit();
                    }
                }).fail(function() {
                    if (data.files.error) {
                        data.context.each(function(index) {
                            var error = data.files[index].error;
                            if (error) {
                                $(this).find(".error").text(error);
                            }
                        });
                    }
                });
            },
            send: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var that = $(this).data("blueimp-fileupload") || $(this).data("fileupload");
                if (data.context && data.dataType && data.dataType.substr(0, 6) === "iframe") {
                    data.context.find(".progress").addClass(!$.support.transition && "progress-animated").attr("aria-valuenow", 100).children().first().css("width", "100%");
                }
                return that._trigger("sent", e, data);
            },
            done: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var that = $(this).data("blueimp-fileupload") || $(this).data("fileupload"), getFilesFromResponse = data.getFilesFromResponse || that.options.getFilesFromResponse, files = getFilesFromResponse(data), template, deferred;
                if (data.context) {
                    data.context.each(function(index) {
                        var file = files[index] || {
                            error: "Empty file upload result"
                        };
                        deferred = that._addFinishedDeferreds();
                        that._transition($(this)).done(function() {
                            var node = $(this);
                            template = that._renderDownload([ file ]).replaceAll(node);
                            that._forceReflow(template);
                            that._transition(template).done(function() {
                                data.context = $(this);
                                that._trigger("completed", e, data);
                                that._trigger("finished", e, data);
                                deferred.resolve();
                            });
                        });
                    });
                } else {
                    template = that._renderDownload(files)[that.options.prependFiles ? "prependTo" : "appendTo"](that.options.filesContainer);
                    that._forceReflow(template);
                    deferred = that._addFinishedDeferreds();
                    that._transition(template).done(function() {
                        data.context = $(this);
                        that._trigger("completed", e, data);
                        that._trigger("finished", e, data);
                        deferred.resolve();
                    });
                }
            },
            fail: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var that = $(this).data("blueimp-fileupload") || $(this).data("fileupload"), template, deferred;
                if (data.context) {
                    data.context.each(function(index) {
                        if (data.errorThrown !== "abort") {
                            var file = data.files[index];
                            file.error = file.error || data.errorThrown || data.i18n("unknownError");
                            deferred = that._addFinishedDeferreds();
                            that._transition($(this)).done(function() {
                                var node = $(this);
                                template = that._renderDownload([ file ]).replaceAll(node);
                                that._forceReflow(template);
                                that._transition(template).done(function() {
                                    data.context = $(this);
                                    that._trigger("failed", e, data);
                                    that._trigger("finished", e, data);
                                    deferred.resolve();
                                });
                            });
                        } else {
                            deferred = that._addFinishedDeferreds();
                            that._transition($(this)).done(function() {
                                $(this).remove();
                                that._trigger("failed", e, data);
                                that._trigger("finished", e, data);
                                deferred.resolve();
                            });
                        }
                    });
                } else if (data.errorThrown !== "abort") {
                    data.context = that._renderUpload(data.files)[that.options.prependFiles ? "prependTo" : "appendTo"](that.options.filesContainer).data("data", data);
                    that._forceReflow(data.context);
                    deferred = that._addFinishedDeferreds();
                    that._transition(data.context).done(function() {
                        data.context = $(this);
                        that._trigger("failed", e, data);
                        that._trigger("finished", e, data);
                        deferred.resolve();
                    });
                } else {
                    that._trigger("failed", e, data);
                    that._trigger("finished", e, data);
                    that._addFinishedDeferreds().resolve();
                }
            },
            progress: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var progress = Math.floor(data.loaded / data.total * 100);
                if (data.context) {
                    data.context.each(function() {
                        $(this).find(".progress").attr("aria-valuenow", progress).children().first().css("width", progress + "%");
                    });
                }
            },
            progressall: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var $this = $(this), progress = Math.floor(data.loaded / data.total * 100), globalProgressNode = $this.find(".fileupload-progress"), extendedProgressNode = globalProgressNode.find(".progress-extended");
                if (extendedProgressNode.length) {
                    extendedProgressNode.html(($this.data("blueimp-fileupload") || $this.data("fileupload"))._renderExtendedProgress(data));
                }
                globalProgressNode.find(".progress").attr("aria-valuenow", progress).children().first().css("width", progress + "%");
            },
            start: function(e) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var that = $(this).data("blueimp-fileupload") || $(this).data("fileupload");
                that._resetFinishedDeferreds();
                that._transition($(this).find(".fileupload-progress")).done(function() {
                    that._trigger("started", e);
                });
            },
            stop: function(e) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var that = $(this).data("blueimp-fileupload") || $(this).data("fileupload"), deferred = that._addFinishedDeferreds();
                $.when.apply($, that._getFinishedDeferreds()).done(function() {
                    that._trigger("stopped", e);
                });
                that._transition($(this).find(".fileupload-progress")).done(function() {
                    $(this).find(".progress").attr("aria-valuenow", "0").children().first().css("width", "0%");
                    $(this).find(".progress-extended").html("&nbsp;");
                    deferred.resolve();
                });
            },
            processstart: function(e) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                $(this).addClass("fileupload-processing");
            },
            processstop: function(e) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                $(this).removeClass("fileupload-processing");
            },
            destroy: function(e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                var that = $(this).data("blueimp-fileupload") || $(this).data("fileupload"), removeNode = function() {
                    that._transition(data.context).done(function() {
                        $(this).remove();
                        that._trigger("destroyed", e, data);
                    });
                };
                if (data.url) {
                    data.dataType = data.dataType || that.options.dataType;
                    $.ajax(data).done(removeNode).fail(function() {
                        that._trigger("destroyfailed", e, data);
                    });
                } else {
                    removeNode();
                }
            }
        },
        _resetFinishedDeferreds: function() {
            this._finishedUploads = [];
        },
        _addFinishedDeferreds: function(deferred) {
            if (!deferred) {
                deferred = $.Deferred();
            }
            this._finishedUploads.push(deferred);
            return deferred;
        },
        _getFinishedDeferreds: function() {
            return this._finishedUploads;
        },
        _enableDragToDesktop: function() {
            var link = $(this), url = link.prop("href"), name = link.prop("download"), type = "application/octet-stream";
            link.bind("dragstart", function(e) {
                try {
                    e.originalEvent.dataTransfer.setData("DownloadURL", [ type, name, url ].join(":"));
                } catch (ignore) {}
            });
        },
        _formatFileSize: function(bytes) {
            if (typeof bytes !== "number") {
                return "";
            }
            if (bytes >= 1e9) {
                return (bytes / 1e9).toFixed(2) + " GB";
            }
            if (bytes >= 1e6) {
                return (bytes / 1e6).toFixed(2) + " MB";
            }
            return (bytes / 1e3).toFixed(2) + " KB";
        },
        _formatBitrate: function(bits) {
            if (typeof bits !== "number") {
                return "";
            }
            if (bits >= 1e9) {
                return (bits / 1e9).toFixed(2) + " Gbit/s";
            }
            if (bits >= 1e6) {
                return (bits / 1e6).toFixed(2) + " Mbit/s";
            }
            if (bits >= 1e3) {
                return (bits / 1e3).toFixed(2) + " kbit/s";
            }
            return bits.toFixed(2) + " bit/s";
        },
        _formatTime: function(seconds) {
            var date = new Date(seconds * 1e3), days = Math.floor(seconds / 86400);
            days = days ? days + "d " : "";
            return days + ("0" + date.getUTCHours()).slice(-2) + ":" + ("0" + date.getUTCMinutes()).slice(-2) + ":" + ("0" + date.getUTCSeconds()).slice(-2);
        },
        _formatPercentage: function(floatValue) {
            return (floatValue * 100).toFixed(2) + " %";
        },
        _renderExtendedProgress: function(data) {
            return this._formatBitrate(data.bitrate) + " | " + this._formatTime((data.total - data.loaded) * 8 / data.bitrate) + " | " + this._formatPercentage(data.loaded / data.total) + " | " + this._formatFileSize(data.loaded) + " / " + this._formatFileSize(data.total);
        },
        _renderTemplate: function(func, files) {
            if (!func) {
                return $();
            }
            var result = func({
                files: files,
                formatFileSize: this._formatFileSize,
                options: this.options
            });
            if (result instanceof $) {
                return result;
            }
            return $(this.options.templatesContainer).html(result).children();
        },
        _renderPreviews: function(data) {
            data.context.find(".preview").each(function(index, elm) {
                $(elm).append(data.files[index].preview);
            });
        },
        _renderUpload: function(files) {
            return this._renderTemplate(this.options.uploadTemplate, files);
        },
        _renderDownload: function(files) {
            return this._renderTemplate(this.options.downloadTemplate, files).find("a[download]").each(this._enableDragToDesktop).end();
        },
        _startHandler: function(e) {
            e.preventDefault();
            var button = $(e.currentTarget), template = button.closest(".template-upload"), data = template.data("data");
            button.prop("disabled", true);
            if (data && data.submit) {
                data.submit();
            }
        },
        _cancelHandler: function(e) {
            e.preventDefault();
            var template = $(e.currentTarget).closest(".template-upload,.template-download"), data = template.data("data") || {};
            data.context = data.context || template;
            if (data.abort) {
                data.abort();
            } else {
                data.errorThrown = "abort";
                this._trigger("fail", e, data);
            }
        },
        _deleteHandler: function(e) {
            e.preventDefault();
            var button = $(e.currentTarget);
            this._trigger("destroy", e, $.extend({
                context: button.closest(".template-download"),
                type: "DELETE"
            }, button.data()));
        },
        _forceReflow: function(node) {
            return $.support.transition && node.length && node[0].offsetWidth;
        },
        _transition: function(node) {
            var dfd = $.Deferred();
            if ($.support.transition && node.hasClass("fade") && node.is(":visible")) {
                node.bind($.support.transition.end, function(e) {
                    if (e.target === node[0]) {
                        node.unbind($.support.transition.end);
                        dfd.resolveWith(node);
                    }
                }).toggleClass("in");
            } else {
                node.toggleClass("in");
                dfd.resolveWith(node);
            }
            return dfd;
        },
        _initButtonBarEventHandlers: function() {
            var fileUploadButtonBar = this.element.find(".fileupload-buttonbar"), filesList = this.options.filesContainer;
            this._on(fileUploadButtonBar.find(".start"), {
                click: function(e) {
                    e.preventDefault();
                    filesList.find(".start").click();
                }
            });
            this._on(fileUploadButtonBar.find(".cancel"), {
                click: function(e) {
                    e.preventDefault();
                    filesList.find(".cancel").click();
                }
            });
            this._on(fileUploadButtonBar.find(".delete"), {
                click: function(e) {
                    e.preventDefault();
                    filesList.find(".toggle:checked").closest(".template-download").find(".delete").click();
                    fileUploadButtonBar.find(".toggle").prop("checked", false);
                }
            });
            this._on(fileUploadButtonBar.find(".toggle"), {
                change: function(e) {
                    filesList.find(".toggle").prop("checked", $(e.currentTarget).is(":checked"));
                }
            });
        },
        _destroyButtonBarEventHandlers: function() {
            this._off(this.element.find(".fileupload-buttonbar").find(".start, .cancel, .delete"), "click");
            this._off(this.element.find(".fileupload-buttonbar .toggle"), "change.");
        },
        _initEventHandlers: function() {
            this._super();
            this._on(this.options.filesContainer, {
                "click .start": this._startHandler,
                "click .cancel": this._cancelHandler,
                "click .delete": this._deleteHandler
            });
            this._initButtonBarEventHandlers();
        },
        _destroyEventHandlers: function() {
            this._destroyButtonBarEventHandlers();
            this._off(this.options.filesContainer, "click");
            this._super();
        },
        _enableFileInputButton: function() {
            this.element.find(".fileinput-button input").prop("disabled", false).parent().removeClass("disabled");
        },
        _disableFileInputButton: function() {
            this.element.find(".fileinput-button input").prop("disabled", true).parent().addClass("disabled");
        },
        _initTemplates: function() {
            var options = this.options;
            options.templatesContainer = this.document[0].createElement(options.filesContainer.prop("nodeName"));
            if (tmpl) {
                if (options.uploadTemplateId) {
                    options.uploadTemplate = tmpl(options.uploadTemplateId);
                }
                if (options.downloadTemplateId) {
                    options.downloadTemplate = tmpl(options.downloadTemplateId);
                }
            }
        },
        _initFilesContainer: function() {
            var options = this.options;
            if (options.filesContainer === undefined) {
                options.filesContainer = this.element.find(".files");
            } else if (!(options.filesContainer instanceof $)) {
                options.filesContainer = $(options.filesContainer);
            }
        },
        _initSpecialOptions: function() {
            this._super();
            this._initFilesContainer();
            this._initTemplates();
        },
        _create: function() {
            this._super();
            this._resetFinishedDeferreds();
            if (!$.support.fileInput) {
                this._disableFileInputButton();
            }
        },
        enable: function() {
            var wasDisabled = false;
            if (this.options.disabled) {
                wasDisabled = true;
            }
            this._super();
            if (wasDisabled) {
                this.element.find("input, button").prop("disabled", false);
                this._enableFileInputButton();
            }
        },
        disable: function() {
            if (!this.options.disabled) {
                this.element.find("input, button").prop("disabled", true);
                this._disableFileInputButton();
            }
            this._super();
        }
    });
});