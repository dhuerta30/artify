function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

$(document).ready(function(){

    $.fn.exchangePositionWith = function(selector) {
        var other = $(selector);
        this.after(other.clone());
        other.remove();
    };

    $.pdocrud_actions = {
        init: function () {

            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            if(pdocrud_js.checkbox_validation){
                $(document).on('change', '.pdocrud-checkbox:checkbox', function () {
                   if ($(this).is('[required]') || $(this).is('[apply-req-validation]')) {
                       if ($(this).is(':checked')) {
                           $(this).closest(".pdocrud-checkbox-group").find(".pdocrud-checkbox").removeAttr('required');
                           $(this).closest(".pdocrud-checkbox-group").find(".pdocrud-checkbox").attr('apply-req-validation',"1");
                       }
                       else {
                           if ($(this).closest(".pdocrud-checkbox-group").find(".pdocrud-checkbox").is(":checked")) {
                               $(this).closest(".pdocrud-checkbox-group").find(".pdocrud-checkbox").removeAttr('required');
                           }else{
                               $(this).closest(".pdocrud-checkbox-group").find(".pdocrud-checkbox").attr('required', true);
                           }
                       }
                   }
               });
            }
            
            $(document).on("change", ".pdocrud-form-control", function (evt) {
                var instance = $.pdocrud_actions.getInstance(this, "form");
                $.pdocrud_actions.loadDependent(this, instance);
            });
            
             $(document).on("change", ".pdocrud-text, .pdocrud-select", function (evt) {
                var instance = $.pdocrud_actions.getInstance(this, "form");
                var data = $(this).data("condition-logic");
                $.pdocrud_actions.applyLogic(this, instance, data);
            });
            
            $(document).on("click", ".pdocrud-adv-search-btn", function (evt) {
                var instance = $.pdocrud_actions.getInstance(this, "form");
                var data = $(this).data();
                data.form_data = $(this).closest("form.pdocrud-adv-search-form").serialize();
                $.pdocrud_actions.getRenderData(this, instance, data);
            });

          if(pdocrud_js.hasOwnProperty('ajax_actions')){
            $.each(pdocrud_js.ajax_actions, function (index) {
              $(document).on(pdocrud_js.ajax_actions[index].event, '.'+pdocrud_js.ajax_actions[index].class, function (evt) {
                  var instance = $.pdocrud_actions.getInstance(this, "form");
                  var data = {};
                  data.action = "ajax_action";
                  data.function = pdocrud_js.ajax_actions[index].callback_function;
                  data.post_data  = {};
                  data.post_data.element_name = pdocrud_js.ajax_actions[index].element_name;
                  data.post_data.value = $(this).val();
                  if(pdocrud_js.ajax_actions[index].other_elements.length){
                    data.post_data.other_element_name = {};
                    data.post_data.other_element_value = {};
                    $.each(pdocrud_js.ajax_actions[index].other_elements, function (loop) {
                      data.post_data.other_element_name[loop] = pdocrud_js.ajax_actions[index].other_elements[loop];
                      data.post_data.other_element_value[loop] = $('.pdocrud_ajax_action_other_'+pdocrud_js.ajax_actions[index].other_elements[loop]).val();
                    });                    
                  }
                  $.pdocrud_actions.ajax_actions(this, instance, data,  pdocrud_js.ajax_actions[index].return_value_element);
              });
            });
          }

          if(pdocrud_js.hasOwnProperty('js_actions')){
            $.each(pdocrud_js.js_actions, function (index) {
              $(document).on(pdocrud_js.js_actions[index].event, '.'+pdocrud_js.js_actions[index].class, function (evt) {
                  var instance = $.pdocrud_actions.getInstance(this, "form");
                  var data = {};
                  data.action = "js_actions";
                  data.function = pdocrud_js.js_actions[index].callback_function;
                  data.post_data  = {};
                  data.post_data.element_name = pdocrud_js.js_actions[index].element_name;
                  data.post_data.value = $(this).val();
                  if(pdocrud_js.js_actions[index].other_elements.length){
                    data.post_data.other_element_name = {};
                    data.post_data.other_element_value = {};
                    $.each(pdocrud_js.js_actions[index].other_elements, function (loop) {
                      data.post_data.other_element_name[loop] = pdocrud_js.js_actions[index].other_elements[loop];
                      data.post_data.other_element_value[loop] = $('.pdocrud_js_action_other_'+pdocrud_js.ajax_actions[index].other_elements[loop]).val();
                    });                    
                  }
                  $.pdocrud_actions.js_actions(this, instance, data,  pdocrud_js.ajax_actions[index].return_value_element);
              });
            });
          }

          if(pdocrud_js.hasOwnProperty('invoice_headers')){
            var header_count = pdocrud_js.invoice_headers - 1;
            var total_header =  0;
            if($('table.pdocrud-table-view').length){
              total_header =  $('table.pdocrud-table-view tbody tr').length - 1;
              $("table.pdocrud-table-view tbody tr:eq("+header_count+")").exchangePositionWith("table.pdocrud-table-view tbody tr:eq("+total_header+")");
            }

            if($('.pdocrud-form div.form-group').length)
              total_header =  $('.pdocrud-form div.form-group').length - 2;
              $(".pdocrud-form div.form-group:eq("+header_count+")").exchangePositionWith(".pdocrud-form div.form-group:eq("+total_header+")");

              $(document).on("pdocrud_after_ajax_action",function(event,container){
                var total_header =  $('.pdocrud-form div.form-group').length - 2;
                $(".pdocrud-form div.form-group:eq("+header_count+")").exchangePositionWith(".pdocrud-form div.form-group:eq("+total_header+")");
               });              
          }

            $(document).on("click", "table.pdocrud-excel-table tbody tr td.pdocrud-row-cols", function (evt) {
                var cell = $(this);
                var content = $(this).html().trim();
                if($(this).find('input').is(':focus')) return this;
                var width = $(this).width();
                $(this).html('<input type="text" class="pdocrud-excel-cell" value="' + content + '" style="width:'+width+'px" />')
                    .find('input')
                    .trigger('focus')
                    .on({
                      'focusout': function(){
                        $(this).trigger('closeCellData');
                      },
                      'keyup':function(e){
                        if(e.which == '13'){ 
                          $(this).trigger('saveCellData');
                          $(this).trigger('closeCellData');
                        } else if(e.which == '27'){ 
                          $(this).trigger('closeCellData');
                        }
                      },
                      'closeCellData':function(){
                        cell.html(content);
                      },
                      'saveCellData':function(){
                        content = $(this).val();
                        var data = $(this).data();
                        data.action = "CELL_UPDATE";
                        data.content = content;
                        data.column =  cell.closest('table').find('th').eq(cell.index()).data("sortkey");
                        data.id =  cell.closest('tr').data("id");
                        var instance = $(this).closest(".pdocrud-table-container").data("objkey");
                        $.pdocrud_actions.actions(this, data, instance);
                        $(this).trigger('closeCellData');
                      }
                  });
            });
            
            if ($(".pdocrud-slider").length > 0) {
                 var handle = $("#pdocrud-custom-handle");
                    $(".pdocrud-slider").slider({
                    range: $(".pdocrud-slider").data("range"),
                    min: $(".pdocrud-slider").data("min"),
                    max: $(".pdocrud-slider").data("max"),
                    create: function () {
                        handle.text($(this).slider("value"));
                    },
                    slide: function (event, ui) {
                         handle.text( ui.value );
                        if ($(".pdocrud-slider").data("range"))
                            $(".pdocrud-slider").next().val(ui.values[ 0 ] + "-" + ui.values[ 1 ]);
                        else
                            $(".pdocrud-slider").next().val(ui.value);
                    }
                });
            }

            if ($(".pdocrud-spinner").length > 0) {
                    $(".pdocrud-spinner").spinner({
                    step: $(".pdocrud-spinner").data("step"),
                    min: $(".pdocrud-spinner").data("min"),
                    max: $(".pdocrud-spinner").data("max"),
                    start: $(".pdocrud-spinner").data("start"),
                });
            }

            if($(".pdocrud_search_input").length > 0 && pdocrud_js.hasOwnProperty('enable_search_on_enter')) {
              $(document).on("keypress",".pdocrud_search_input", function (e) {
                 if (e.which == 13 && pdocrud_js.enable_search_on_enter) {
                  $("#pdocrud_search_btn").trigger("click");
                 }
              });
            }
            
            $.pdocrud_actions.getAutoSuggestionData(this);
            
            $.pdocrud_actions.setBulkCrudData(this);
            
            $(document).on("change", ".pdocrud-filter", function (evt) {
                var instance = $(this).closest(".pdocrud-filters-container").data("objkey");
                var data = $(this).data();
                var key = data.key;
                var val = $(this).val();
                var filters = $(this).closest(".pdocrud-filters-options").find(".pdocrud-filter-selected");
                if (filters.find("span[data-key='" + key + "']").length > 0){
                    if(val)
                        filters.find("span[data-key='" + key + "']").data("value", val).text(val+" X");
                    else{
                        $(".pdocrud-filters-options").find("span[data-key='" + key + "']").remove();
                    }
                }
                else{
                    filters.append("<span data-key='" + key + "' data-value='" + val + "' class=\"pdocrud-filter-option\">" + val + " X</span>");                
                }
                data.action = "filter";
                $.pdocrud_actions.actions(this, data, instance, "");
            });
            
            $(document).on("click", ".pdocrud-filter-option", function (evt) {
                 var instance = $(this).closest(".pdocrud-filters-container").data("objkey");
                 var obj = $(".pdocrud-filters-options");
                 $(this).remove(); 
                 var data = $(this).data();
                 data.action = "filter";
                 $.pdocrud_actions.actions(obj, data, instance, "");
            });
            
            $(document).on("click", ".pdocrud-filter-option-remove", function (evt) {
                 $(this).siblings(".pdocrud-filter-option").each(function(){
                     $(this).remove();
                 });
                 var data = $(this).data();
                 var instance = $(this).closest(".pdocrud-filters-container").data("objkey");
                 data.action = "filter";
                 $.pdocrud_actions.actions(this, data, instance, "");
            });

            /*$(document).on("focus", ".pdocrud-date", function (evt) {
                $(this).datepicker({
                    dateFormat: pdocrud_js.date.date_format,
                    changeMonth: pdocrud_js.date.change_month,
                    changeYear: pdocrud_js.date.change_year,
                    numberOfMonths:  pdocrud_js.date.no_of_month,
                    showButtonPanel: pdocrud_js.date.show_button_panel,
                    maxDate: pdocrud_js.date.max_date,
                    minDate: pdocrud_js.date.min_date
                });
            });*/
            
            if ($(".pdocrud_tabs").length > 0) {
                $(".pdocrud_tabs").tabs();
            }
            
            if ($(".pdocrud-form").length > 0) {
                $(".pdocrud-form").stepy({
                    backLabel: '<i class="fa fa-arrow-circle-left"></i> Anterior',
                    block: true,
                    nextLabel: 'Siguiente <i class="fa fa-arrow-circle-right"></i>',
                    titleClick: true,
                    titleTarget: '.stepy-tab'
                });
            }
            
           $(document).on("click", ".pdocrud_add_file", function (evt) {
                evt.preventDefault();
                $(this).siblings(".pdocrud-filecontrol-div").find('.pdocrud-file').click();
           });
           
           $(document).on("click", ".pdocrud_remove_file", function (evt) {
                evt.preventDefault();
                $(this).siblings(".pdocrud-file-input-control").val('');
           });
           
            $(document).on("change", ".pdocrud-file", function (evt) {
                evt.preventDefault();
                var filePath = $(this).val()
                if (filePath.match(/fakepath/)) {
                    filePath = filePath.replace(/C:\\fakepath\\/i, '');
                }
                $(this).parent().siblings(".pdocrud-file-input-control").val(filePath);
            });
            
            $(document).on("keyup", "input.pdocruderr, select.pdocruderr, textarea.pdocruderr", function (evt) {
                $(this).next("span.pdocrudform-error").remove();
                $(this).closest(".form-group").removeClass("has-error");
            });

            /*$(document).on("focus", ".pdocrud-datetime", function (evt) {
                $(this).datetimepicker({dateFormat: pdocrud_js.date.date_format,
                    timeFormat: pdocrud_js.date.time_format,
                    changeMonth: pdocrud_js.date.change_month,
                    changeYear: pdocrud_js.date.change_year,
                    numberOfMonths:  pdocrud_js.date.no_of_month,
                    showButtonPanel: pdocrud_js.date.show_button_panel});
            });*/

            $(document).on("focus", ".pdocrud-time", function (evt) {
                $(this).timepicker({
                     timeFormat: pdocrud_js.date.time_format,
                });
            });

            $(document).on("change", ".pdocrud-select-all", function (evt) {
                $.pdocrud_actions.selectAll(this);
            });


            $(document).on('click', '.pdocrud-submit-btn', function (evt) {
                var data_action = $(this).attr("data-action");
                $(this).siblings(".pdocrud_action_type").val(data_action);
            });

            $(document).on('click', '.pdocrud-cancel-btn', function (evt) {
                var formId = $(this).data("form-id");
                $('#' + formId).resetForm();
            });

            $(document).on('change', '.pdocrud-records-per-page', function (evt) {
                var data = $(this).data();
                data.records = $(this).val();
                var instance = $(this).closest(".pdocrud-table-container").data("objkey");
                $.pdocrud_actions.actions(this, data, instance);
            });
            
            $(document).on('change', '.pdocrud_search_cols', function (evt) {
               var type = $(this).find('option:selected').data('type');
               var search_obj = $(this).closest(".pdocrud-search").children();
               
               search_obj.find("#pdocrud_search_box").datepicker("destroy");
               search_obj.find("#pdocrud_search_box").removeClass("pdocrud-date");
               search_obj.find("#pdocrud_search_box").removeClass("pdocrud-datetime");
               search_obj.find("#pdocrud_search_box").removeClass("pdocrud-time");
               search_obj.find("#pdocrud_search_box_to").datepicker("destroy");
               search_obj.find("#pdocrud_search_box_to").removeClass("pdocrud-date");
               search_obj.find("#pdocrud_search_box_to").removeClass("pdocrud-datetime");
               search_obj.find("#pdocrud_search_box_to").removeClass("pdocrud-time");
               search_obj.find("#pdocrud_search_box_to").addClass("pdocrud-hide");
               
               if(type === "date-range"){
                   search_obj.find("#pdocrud_search_box").addClass("pdocrud-date");
                   search_obj.find("#pdocrud_search_box_to").removeClass("pdocrud-hide");
                   search_obj.find("#pdocrud_search_box_to").addClass("pdocrud-date");
               }
               else if(type === "datetime-range"){
                   search_obj.find("#pdocrud_search_box").addClass("pdocrud-datetime");
                   search_obj.find("#pdocrud_search_box_to").removeClass("pdocrud-hide");
                   search_obj.find("#pdocrud_search_box_to").addClass("pdocrud-datetime");
               }
               else if(type === "time-range"){
                   search_obj.find("#pdocrud_search_box").addClass("pdocrud-time");
                   search_obj.find("#pdocrud_search_box_to").addClass("pdocrud-time");
                   search_obj.find("#pdocrud_search_box_to").removeClass("pdocrud-hide");
               }
            });

            $(document).on('click', '.pdocrud-actions-sorting', function (evt) {
                evt.preventDefault();
                var data = $(this).data();
                var instance = $.pdocrud_actions.getInstance(this, ".pdocrudbox");
                $.pdocrud_actions.actions(this, data, instance);
            });

            $(document).on('click', '.pdocrud-view-print', function (evt) {
                evt.preventDefault();
                var content = "<table>" + $(this).closest("table.pdocrud-table-view").find("tbody")[0].outerHTML + "</table>";
                var printwindow = window.open('', 'print window', 'height=400,width=600');
                $.pdocrud_actions.print(content, printwindow);
            });
            
            $(document).on('click', '.pdocrud-close', function (evt) {
                evt.preventDefault();
                $(this).closest("table.pdocrud-table-view").remove();
            });
            
            $(document).on('click', '.pdocrud-data-row', function (evt) {
                if (pdocrud_js.quick_view) {
                    evt.preventDefault();
                    $(this).closest(".pdocrud-table").find(".pdocrud-data-row").removeClass("pdocrud-row-selected");
                    $(this).addClass("pdocrud-row-selected");
                    var data = $(this).data();
                    data.action = "quick_view";
                    var instance = $.pdocrud_actions.getInstance(this, ".pdocrudbox");
                    $.pdocrud_actions.actions(this, data, instance);
                }
            });

            $(document).on('click', 'a.pdocrud-actions', function (evt) {
                evt.preventDefault();
                var printwindow = "";
                var data = $(this).data();
                var instance = $.pdocrud_actions.getInstance(this, ".pdocrudbox");
                if (data.action === "print") {
                    instance = data.objkey;
                    var printdata = $("table[data-obj-key='" + data.objkey + "']")[0].outerHTML;
                    var printwindow = window.open('', 'print window', 'height=400,width=600');
                    $.pdocrud_actions.print(printdata, printwindow);
                }

                if (data.action === "delete") {
                    if (!confirm(pdocrud_js.lang.delete_single_record)) {
                        return;
                    }
                }

                if (data.action === "url") {
                    window.location.href = $(this).attr("href");
                    return;
                }

                if (data.action === "add_row") {
                    $(".pdocrud-left-join").each(function () {
                        var tds = '<tr>';
                        jQuery.each($('tr:last td', this), function () {
                            tds += '<td>' + $(this).html() + '</td>';
                        });
                        tds += '</tr>';
                
                        // Limpia los valores de los elementos de la última fila
                        var $lastRow = $(tds).appendTo('tbody', this);
                        $lastRow.find('input, select, textarea').val('');
                
                        if ($('tbody', this).length > 0) {
                            $('tbody', this).append($lastRow);
                        } else {
                            $(this).append($lastRow);
                        }
                    });
                    return;                   
                }

                if (data.action === "delete_row") {
                    if ($(this).parents("tbody").children().length > 1)
                        $(this).parents("tr").remove();
                    return;
                }

                if (data.action === "read_more") {
                    var content = $(this).data("read-more");
                    if ($(this).data("hide") === "true") {
                        $(this).html("<button class='btn btn-info btn-sm'>Leer más <i class='fa fa-arrow-right'></i></button>");
                        $(this).data("hide", "false");
                        $(this).prev("p").html(content.substr(0, $(this).data("length")) + "...");
                    }
                    else {
                        $(this).html("<button class='btn btn-primary btn-sm'>Ocultar <i class='fa fa-eye-slash'></i></button>");
                        $(this).data("hide", "true");
                        $(this).prev("p").html(content);
                    }
                    return;
                }

                if (data.action === "search") {
                    data.search_col = $(this).closest(".pdocrud-search").children().find(".pdocrud_search_cols").val();
                    data.search_text = $(this).closest(".pdocrud-search").children().find("#pdocrud_search_box").val();
                    var search_to = $(this).closest(".pdocrud-search").children().find("#pdocrud_search_box_to").val();
                    if(search_to)
                        data.search_text2 = search_to;
                }

                if (data.action === "exporttable") {
                    instance = data.objkey;
                    data.exportType = $(this).data("export-type");
                    if (data.exportType === "print")
                        printwindow = window.open('', 'print window', 'height=400,width=600');
                }

                if (data.action === "delete_selected") {
                    if (!confirm(pdocrud_js.lang.delete_select_records)) {
                        return;
                    }
                    var selected = [];
                    var obj_key = $(this).attr("data-obj-key");
                    $("table[data-obj-key='" + obj_key + "']").children().find(".pdocrud-select-cb:checked").each(function () {
                        selected.push($(this).val());
                    });
                    if (selected.length < 1) {
                        alert(pdocrud_js.lang.select_one_entry);
                        return;
                    }
                    data.selected_ids = selected;
                }

                if (data.action === "pagination") {
                    instance = $(this).closest(".pdocrud-table-container").data("objkey");
                    data.exportType = $(this).data("export-type");
                }
                
                if (data.action === "save_crud_table_data") {
                    instance = $(this).closest(".pdocrud-table-container").data("objkey");
                    var updateData = [];
                    $(".input-bulk-crud-update").each(function () {
                        var col = $(this).data("col");
                        var val = $(this).val();
                        var id = $(this).data("id");
                        updateData.push({col: col, id: id, val:val});

                    });
                   data.updateData = JSON.stringify(updateData);
                }

                if (data.action === "add" || data.action === "add_invoice") {
                    instance = $(this).closest(".pdocrud-table-container").data("objkey");
                }

                $.pdocrud_actions.actions(this, data, instance, printwindow);
                evt.stopPropagation();

            });

            $(document).on('click', '.pdocrud-submit', function (evt) {
                var data_action = $(this).data("action");
                $(this).siblings(".pdocrud_action_type").val(data_action);
            });

            $(document).on('click', '.pdocrud-back', function (evt) {
                var data = $(this).data();
                var instance = $(this).closest(".pdocrud-table-container").data("objkey");
                $.pdocrud_actions.actions(this, data, instance);
                evt.preventDefault();
                if ($('body').hasClass("modal-open"))
                    $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                return;
            });
            
            $(document).on('click', '.pdocrud-view-delete', function (evt) {
                if (!confirm(pdocrud_js.lang.delete_single_record)) {
                        return;
                    }
                var data = $(this).data();
                var instance = $(this).closest(".pdocrud-table-container").data("objkey");
                $.pdocrud_actions.actions(this, data, instance);
                evt.preventDefault();
                if ($('body').hasClass("modal-open"))
                    $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                return;
            });
            
            $(document).on('click', '.pdocrud-view-edit', function (evt) {
                var data = $(this).data();
                var instance = $(this).closest(".pdocrud-table-container").data("objkey");
                $.pdocrud_actions.actions(this, data, instance);
                evt.preventDefault();
                if ($('body').hasClass("modal-open"))
                    $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                return;
            });

            $(document).on('submit', '.pdocrud-form', function (evt) {
                if (pdocrud_js.submission_type === "ajax") {
                    evt.preventDefault();
                    $(this).validator('validate');
                    var validation = true;
                    
                    if (pdocrud_js.jsvalidation === "script_validator") {
                        validation = $.pdocrud_actions.validate(this);
                    }
                    else if (pdocrud_js.jsvalidation === "plugin_validator") {
                        $(this).find(".form-group").each(function () {
                            var class_name = $(this).attr("class");
                            if (class_name.indexOf("has-error") >= 0) {
                                validation = false;
                            }
                        });
                    }
                    
                    $(this).find("input[readonly='true']").each(function () {
                        if ($(this).is("[required]") && $(this).val() === "") {
                            $(this).parent(".form-group").addClass("has-error");
                            validation = false;
                        }
                    });


                    if ($(this).find(".g-recaptcha").length) {
                        if (grecaptcha.getResponse() === '') {
                            $(this).find(".g-recaptcha").prepend("<div class='has-errors with-errors'><p>" + pdocrud_js.lang.recaptcha_msg + "</p></div>");
                            validation = false;
                        }
                    }

                    $(document).trigger("pdocrud_before_form_submission", [this]);
                    if (validation) {
                        $.pdocrud_actions.submitData(this);
                    }
                }
            });

            $.pdocrud_actions.createMap(this);
            $(document).trigger("pdocrud_on_load", [this]);
        },
        setBulkCrudData : function(obj){
            if ($(".input-bulk-crud-update").length > 0) {
                 $(".input-bulk-crud-update").each(function(){
                     if($(this).get(0).tagName  === "SELECT")
                        $(this).val($(this).data("orignal-val"));
                 });
            }
        },
        getAutoSuggestionData : function(obj){
             if ($(".pdocrud_search_input").length > 0 && pdocrud_js.auto_suggestion) {
                var instance = $(".pdocrud-table-container").data("objkey");
                var data = $(obj).data();
                data.action = "autosuggest";
                $(".pdocrud_search_input").autocomplete({
                    source: function (request, response) {
                        data.search_text = request.term;
                        data.search_col = $(".pdocrud_search_cols").val();
                        $.ajax({
                            url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                            dataType: "jsonp",
                            type: "post",
                            data: {
                                "pdocrud_data": data,
                                "pdocrud_instance": instance,
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        //console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
                    }
                });
            }
        },
        getRenderData :function (obj, instance, data) {
            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                beforeSend: function () {
                    $("#pdocrud-ajax-loader").show();
                },
                data: {
                    "pdocrud_data": data,
                    "pdocrud_instance": instance,
                },
                success: function (response) {
                    $("#pdocrud-ajax-loader").hide();
                    $(obj).closest("form").next(".pdocrud-adv-search-result").html(response);
                }
            });
        },
        actions: function (obj, data, instance, printwindow) {
            $(document).trigger("pdocrud_before_ajax_action", [obj, data]);
            data = $.pdocrud_actions.getFilterData(obj, data);
            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                beforeSend: function () {
                    $("#pdocrud-ajax-loader").show();
                },
                data: {
                    "pdocrud_data": data,
                    "pdocrud_instance": instance,
                },
                success: function (response) {
                    $("#pdocrud-ajax-loader").hide();
                    if (data.action === "exporttable") {
                        if (data.exportType === "print")
                            $.pdocrud_actions.print(response, printwindow);
                        else
                            window.location.href = response;
                    }
                    else {
                        if ($(obj).closest(".pdocrud-table-container").data("modal")) {
                            var actions_arr = ["view_back", "insert_back", "back", "update_back", "delete", "delete_selected","sort", "asc", "desc", "search", "records_per_page", "pagination"];
                            if ($.inArray(data.action, actions_arr) !== -1) {
                                if ($(obj).parents("body").hasClass("modal-open"))
                                    $(obj).parents("body").removeClass("modal-open");
                                $("#" + instance + "_modal").modal('hide');
                                $(obj).closest(".pdocrud-table-container").html(response);

                            } else {
                                $("#" + instance + "_modal").find(".modal-body").html(response);
                                $("#" + instance + "_modal").modal('show');
                                $("#" + instance + "_modal").on('shown', function () {
                                    $("#" + instance + "_modal").find(".modal-body").find("input").focus();
                                });                               
                                if (data.action === "edit") { 
                                    $("#" + instance + "_modal").find(".modal-body").find(":input[data-condition-logic]").each(function(){
                                        $(this).trigger("change");
                                    });
                                }
                            }
                        }
                        else if (data.action === "inline_edit") {
                            $(obj).closest("tr").html(response);
                        }
                        else if (data.action === "filter") {
                            $(obj).closest(".pdocrud-filters-container").find(".pdocrud-table-container").html(response);
                        }
                        else if (data.action === "onepageview") {
                            var element = $(obj).closest(".pdocrud-one-page-container");
                            $(obj).closest(".pdocrud-one-page-container").after(response);
                            element.remove();
                            $(obj).closest(".pdocrud-one-page-container").html(response);
                        }
                        else if (data.action === "onepageedit") {
                            var element = $(obj).closest(".pdocrud-one-page-container");
                            $(obj).closest(".pdocrud-one-page-container").after(response);
                            element.remove();
                            $(obj).closest(".pdocrud-one-page-container").html(response);
                        }
                        else if (data.action === "quick_view") {
                            var element = $(obj).closest(".pdocrudbox")
                            element.find(".pdocrud-quick-view").remove();
                            element.append("<div class='pdocrud-quick-view'></div>");
                            element.find(".pdocrud-quick-view").html(response);
                            $('html, body').animate({ scrollTop: $(".pdocrud-quick-view").last().offset().top }, 'slow');
                        }
                        else if (data.action === "related_table") {
                            var element = $(obj).closest(".pdocrudbox")
                            element.find(".pdocrud-related-table-view").remove();
                            element.append("<div class='pdocrud-related-table-view'></div>");
                            element.find(".pdocrud-related-table-view").html(response);
                            $('html, body').animate({ scrollTop: $(".pdocrud-related-table-view").offset().top }, 'slow');
                        }
                        else if (data.action === "printpdf") { 
                          var win = window.open(response, '_blank');
                          win.focus();
                        }
                        else {
                            $(obj).closest(".pdocrud-table-container").html(response);
                            if ($(".pdocrud_tabs").length > 0) {
                                $(obj).parents(".pdocrud-table-container").last().html(response);
                            }
                            if (data.action === "edit") { 
                                $(".pdocrud-table-container").find(":input[data-condition-logic]").each(function(){
                                    $(this).trigger("change");
                                });
                            }
                        }
                        if ($(".pdocrud_tabs").length > 0) {
                            $(".pdocrud_tabs").tabs();
                        }   
                        $.pdocrud_actions.createMap(obj);
                    }
                    $.pdocrud_actions.setBulkCrudData(this);
                    $.pdocrud_actions.getAutoSuggestionData(this);
                    $(document).trigger("pdocrud_after_ajax_action", [obj, response]);
                    try {
                        grecaptcha.render('pdo_recaptcha', {
                            sitekey: pdocrud_js.site_key,
                            callback: function (response) {
                            }
                        });
                    }
                    catch (err) {
                        // Handle error(s) here
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
                complete: function () {
                },
            });
        },
         reload: function (obj, data, instance,element) {
            $(document).trigger("pdocrud_before_reload_ajax_action", [obj, data]);

            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                data: {
                    "pdocrud_data": data,
                    "pdocrud_instance": instance,
                },
                success: function (response) {
                    element.html(response);
                    $(document).trigger("pdocrud_after_reload_ajax_action", [obj, response]);
                    try {
                        grecaptcha.render('pdo_recaptcha', {
                            sitekey: pdocrud_js.site_key,
                            callback: function (response) {
                            }
                        });
                    }
                    catch (err) {
                        // Handle error(s) here
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
                complete: function () {
                },
            });
        },
         ajax_actions: function (obj, instance, data, return_value_element) {
            $(document).trigger("pdocrud_before_reload_ajax_action", [obj, data]);
            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                data: {
                    "pdocrud_data": data,
                    "pdocrud_instance": instance,
                },
                success: function (response) {                    
                    $(document).trigger("pdocrud_after_custom_ajax_action", [obj, response]);
                    if(return_value_element){
                      $('.pdocrud_ajax_action_return_'+return_value_element).val(response);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
                complete: function () {
                },
            });
        },
        submitData: function (obj) {
            var data_action_type = $(obj).find(".pdocrud_action_type").val();
            var options = {
                type: "post",
                dataType: "html",
                url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                beforeSubmit: showRequest, // pre-submit callback 
                success: showResponse,  // post-submit callback 
                resetForm: pdocrud_js.reset_form
            };
            $(obj).ajaxSubmit(options);

            function showRequest(formData, jqForm, options) {
                $(document).trigger("pdcrud_before_form_submit", [obj, formData]);
                $("#pdocrud-ajax-loader").show();
            }

            function showResponse(responseText, statusText, xhr, $form) {
                $("#pdocrud-ajax-loader").hide();
                $(obj).find(".pdocrud_message").addClass("hidden");
                $(obj).find(".pdocrud_error").addClass("hidden");
                if (data_action_type == "insert" || data_action_type == "update" || data_action_type == "select" || data_action_type == "email" || data_action_type == "selectform") {
                    
                    if(IsJsonString(responseText)) {
                        var response = JSON.parse(responseText);
                    } else {
                        var response = {};
                        response.error = responseText;
                        response.redirectionurl = 0;
                        response.message = 0;
                    }

                    if (response.redirectionurl.length > 0) {
                        window.location.href = response.redirectionurl;
                    }
                    if (response.message.length > 0) {
                        $(obj).find(".pdocrud_message").removeClass("hidden");
                        $(obj).find(".pdocrud_message").find(".message_content").text(response.message);
                    }
                    if (response.error.length > 0) {
                        $(obj).find(".pdocrud_error").removeClass("hidden");
                        $(obj).find(".pdocrud_error").find(".error_content").text(response.error);
                    }
                    
                    if ($(obj).parents(".pdocrud-one-page-container").length > 0) {
                        var op_cont = $(obj).parents(".pdocrud-one-page-container");
                        var instance = op_cont.children().find(".pdocrud-table-container").data("objkey");
                        var data = op_cont.data();
                        var element = op_cont.children().find(".pdocrud-table-container");
                        $.pdocrud_actions.reload(obj, data, instance, element);
                    }
                }
                else if (data_action_type == "insert_back" || data_action_type == "update_back" || data_action_type == "view_back" || data_action_type == "back") {
                    if ($(obj).parents("body").hasClass("modal-open"))
                        $(obj).parents("body").removeClass("modal-open");
                    $('.modal-backdrop').remove();
                    $(obj).closest(".pdocrud-table-container").html(responseText);
                }
                else if (data_action_type == "insert_close" || data_action_type == "update_close") {
                    
                }
                else if (data_action_type === "export") {
                    window.location.href = responseText;
                }
                else {
                    $(obj).closest(".pdocrud-table-container").html(responseText);
                }
                $.pdocrud_actions.getAutoSuggestionData(this);
                $(document).trigger("pdocrud_after_submission", [obj, responseText]);
            }
        },
        print: function (printdata, printwindow) {
            printwindow.document.write('<html><head><title>Print Data</title>');
            printwindow.document.write('<style type="text/css">.pdocrud-select-cb{display:none} .pdocrud-select-all{display:none}</style>');
            printwindow.document.write('</head><body >');
            printwindow.document.write(printdata);
            printwindow.document.write('</body></html>');
            printwindow.print();
            printwindow.close();
            return true;
        },
        validate: function (form) {
            $(form).find("span.pdocrudform-error").remove();
            $(".form-group").removeClass("has-error");
            var valid = true;
            $(form).find(':input').each(function () {
                $(this).removeClass("has-error");
                $(this).removeClass("pdocruderr");
                if ($(this).data("required")) {
                    if ($(this).val().replace(/\s/g, "") == "") {
                        valid = false;
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.req_field + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-email")) {
                    valid = $.pdocrud_actions.validate_email($(this).val());
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.invalid_email + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-date")) {
                    valid = $.pdocrud_actions.validate_date($(this).val());
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.invalid_date + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-min-length")) {
                    valid = $.pdocrud_actions.validate_length($(this).data("min-length"), $(this).val().length, "min");
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.min_length + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-max-length")) {
                    valid = $.pdocrud_actions.validate_length($(this).data("max-length"), $(this).val().length, "max");
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.min_length + '</span>');
                        $(this).focus();
                    }
                }


                if ($(this).hasAttr("data-exact-length")) {
                    valid = $.pdocrud_actions.validate_length($(this).data("exact-length"), $(this).val().length, "exact");
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.min_length + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-match")) {
                    valid = $.pdocrud_actions.validate_equal_to($(this).val(), $($(this).data("equal-to")).val());
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="pdocrudform-error field-validation-error" for="' + $(this).attr("id") + '">' + pdocrud_js.lang.match + '</span>');
                        $(this).focus();
                    }
                }

                if (valid === false) {
                    $(this).addClass("pdocruderr");
                    $(this).addClass("has-error");
                }
            });

            return valid;
        },
        validate_email: function (email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (regex.test(email) === false)
                return false;

            return true;
        },
        validate_date: function (date) {
            var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
            if (matches == null)
                return false;
            var d = matches[2];
            var m = matches[1] - 1;
            var y = matches[3];
            var composedDate = new Date(y, m, d);
            return composedDate.getDate() == d && composedDate.getMonth() == m && composedDate.getFullYear() == y;
        },
        validate_length: function (reqLen, currentLen, operationType) {
            if (operationType === "min")
                return (currentLen >= reqLen);
            else if (operationType === "max")
                return (currentLen <= reqLen);
            else if (operationType === "match")
                return (currentLen == reqLen);
        },
        validate_equal_to: function (val1, val2) {
            if (val1 === val2)
                return true;
            else
                return false;
        },
        getFilterData: function (obj, data) {
            var filter_span = $(obj).closest(".pdocrud-filters-container").find(".pdocrud-filters-options").find(".pdocrud-filter-selected");
            if (filter_span.length > 0) {
                data.filter_data = new Array();
                filter_span.find(".pdocrud-filter-option").each(function () {
                    data.filter_data.push($(this).data());
                });
            }
            return  data;
        },
        getInstance: function (obj, type) {
            return  $(obj).closest(type).find(".pdoobj").val();
        },
        getDependent: function (obj) {
            return $("select[data-dependent='" + $(obj).attr("id") + "']");
        },
        selectAll: function (obj) {
            if ($(obj).is(":checked"))
                $(obj).parents("table").find(".pdocrud-select-cb").prop('checked', true);
            else
                $(obj).parents("table").find(".pdocrud-select-cb").prop('checked', false);
        },
        createMap: function (obj) {
            $(".pdocrud-gmap").each(function () {
                var mapElemId = $(this).attr("id");
                var googleMapField = $(this).prev();
                var latLng = googleMapField.val().split(',');
                var mapCenter = (latLng.length == 2) ? new google.maps.LatLng(parseFloat(latLng[0]), parseFloat(latLng[1])) : new google.maps.LatLng(51.508742, -0.120850);
                var mapZoom = googleMapField.hasAttr("data-map-zoom") ? googleMapField.data("map-zoom") : 7;
                var mapType = googleMapField.hasAttr("data-map-type") ? googleMapField.data("map-type") : "ROADMAP";

                var mapOptions = {
                    center: mapCenter,
                    zoom: mapZoom,
                    mapTypeId: google.maps.MapTypeId.mapType
                }

                var map = new google.maps.Map(document.getElementById(mapElemId), mapOptions);

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(51.508742, -0.120850),
                    draggable: true,
                    title: "Drag me!"
                });

                google.maps.event.addListener(marker, 'dragend', function () {
                    $(googleMapField).val(this.getPosition().lat() + ',' + this.getPosition().lng());
                });

                marker.setMap(map);

            });
        },
        applyLogic: function (obj, instance, data) {
            var val = $(obj).val();

            var operators = {
                '>': function (a, b) {
                    return a > b
                },
                '=': function (a, b) {
                    return a == b
                },
                '!=': function (a, b) {
                    return a != b
                },
                '<': function (a, b) {
                    return a < b
                }
            };

            for (key in data) {
                var op = data[key].op;
                if ($.isNumeric(val))
                {
                    val = parseInt(val);
                }
                if ($.isNumeric(data[key].condition) && data[key].condition != '0')
                {
                    data[key].condition = parseInt(data[key].condition);
                }
                if (operators[op](val, data[key].condition))
                { 
                    if(data[key].task === "show"){
                        $(":input[name='"+data[key].field.trim()+"']").parent("div.form-group").show();
                    }
                    else if(data[key].task === "hide"){
                        $(":input[name='"+data[key].field.trim()+"']").parent("div.form-group").hide();
                    }
                    else if(data[key].task === "enable"){
                        $(":input[name='"+data[key].field.trim()+"']").attr("disabled", false);
                    }
                    else if(data[key].task === "disable"){
                        $(":input[name='"+data[key].field.trim()+"']").attr("disabled", true);
                    }
                }                
            }
        },
        loadDependent: function (obj, instance) {
            var dependent = $.pdocrud_actions.getDependent(obj);
            if (dependent.length > 0) {
                $.ajax({
                    type: "post",
                    dataType: "html",
                    cache: false,
                    url: pdocrud_js.pdocrudurl + "script/pdocrud.php",
                    beforeSend: function () {
                        $("#pdocrud-ajax-loader").show();
                    },
                    data: {
                        "pdocrud_data[action]": "loadDependent",
                        "pdocrud_data[pdocrud_dependent_name]": dependent.attr("id"),
                        "pdocrud_data[pdocrud_field_name]": $(obj).attr("id"),
                        "pdocrud_data[pdocrud_field_val]": $(obj).val(),
                        "pdocrud_instance": instance,
                    },
                    success: function (response) {
                        dependent.html(response);
                        $("#pdocrud-ajax-loader").hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#pdocrud-ajax-loader").hide();
                    },
                    complete: function () {
                        //console.log()
                    },
                });
            }
        },
    };
    $.pdocrud_actions.init();
});

$.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
};

function refreshCaptcha(id, src) {
    $("#" + id).attr("src", src);
}