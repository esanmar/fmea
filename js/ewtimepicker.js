/**
 * Create Time Picker (for PHPMaker 2020)
 * @license (C) 2019 e.World Technology Ltd.
 */
ew.createTimePicker=function(i,e,t){if(!e.includes("$rowindex$")){var a=jQuery,r=a(ew.getElement(e,i));if(!r.hasClass("ui-timepicker-input")){t.timeFormat&&":"!=ew.TIME_SEPARATOR&&(t.timeFormat=t.timeFormat.replace(/:/g,ew.TIME_SEPARATOR));var n=!a.isBoolean(t.inputGroup)||t.inputGroup;if(delete t.inputGroup,r.timepicker(t).on("showTimepicker",function(){r.data("timepicker-list").width(r.outerWidth()-2)}),n){var p=a('<button type="button"><i class="far fa-clock"></i></button>').addClass("btn btn-default").click(function(){r.timepicker("show")});r.wrap('<div class="input-group"></div>').after(a('<div class="input-group-append"></div>').append(p))}}}};