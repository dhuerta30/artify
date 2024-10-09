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

    $.artify_actions = {
        init: function () {

            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            if(artify_js.checkbox_validation){
                $(document).on('change', '.artify-checkbox:checkbox', function () {
                   if ($(this).is('[required]') || $(this).is('[apply-req-validation]')) {
                       if ($(this).is(':checked')) {
                           $(this).closest(".artify-checkbox-group").find(".artify-checkbox").removeAttr('required');
                           $(this).closest(".artify-checkbox-group").find(".artify-checkbox").attr('apply-req-validation',"1");
                       }
                       else {
                           if ($(this).closest(".artify-checkbox-group").find(".artify-checkbox").is(":checked")) {
                               $(this).closest(".artify-checkbox-group").find(".artify-checkbox").removeAttr('required');
                           }else{
                               $(this).closest(".artify-checkbox-group").find(".artify-checkbox").attr('required', true);
                           }
                       }
                   }
               });
            }
            
            $(document).on("change", ".artify-form-control", function (evt) {
                var instance = $.artify_actions.getInstance(this, "form");
                $.artify_actions.loadDependent(this, instance);
            });
            
             $(document).on("change", ".artify-text, .artify-select", function (evt) {
                var instance = $.artify_actions.getInstance(this, "form");
                var data = $(this).data("condition-logic");
                $.artify_actions.applyLogic(this, instance, data);
            });
            
            $(document).on("click", ".artify-adv-search-btn", function (evt) {
                var instance = $.artify_actions.getInstance(this, "form");
                var data = $(this).data();
                data.form_data = $(this).closest("form.artify-adv-search-form").serialize();
                $.artify_actions.getRenderData(this, instance, data);
            });

          if(artify_js.hasOwnProperty('ajax_actions')){
            $.each(artify_js.ajax_actions, function (index) {
              $(document).on(artify_js.ajax_actions[index].event, '.'+artify_js.ajax_actions[index].class, function (evt) {
                  var instance = $.artify_actions.getInstance(this, "form");
                  var data = {};
                  data.action = "ajax_action";
                  data.function = artify_js.ajax_actions[index].callback_function;
                  data.post_data  = {};
                  data.post_data.element_name = artify_js.ajax_actions[index].element_name;
                  data.post_data.value = $(this).val();
                  if(artify_js.ajax_actions[index].other_elements.length){
                    data.post_data.other_element_name = {};
                    data.post_data.other_element_value = {};
                    $.each(artify_js.ajax_actions[index].other_elements, function (loop) {
                      data.post_data.other_element_name[loop] = artify_js.ajax_actions[index].other_elements[loop];
                      data.post_data.other_element_value[loop] = $('.artify_ajax_action_other_'+artify_js.ajax_actions[index].other_elements[loop]).val();
                    });                    
                  }
                  $.artify_actions.ajax_actions(this, instance, data,  artify_js.ajax_actions[index].return_value_element);
              });
            });
          }

          if(artify_js.hasOwnProperty('js_actions')){
            $.each(artify_js.js_actions, function (index) {
              $(document).on(artify_js.js_actions[index].event, '.'+artify_js.js_actions[index].class, function (evt) {
                  var instance = $.artify_actions.getInstance(this, "form");
                  var data = {};
                  data.action = "js_actions";
                  data.function = artify_js.js_actions[index].callback_function;
                  data.post_data  = {};
                  data.post_data.element_name = artify_js.js_actions[index].element_name;
                  data.post_data.value = $(this).val();
                  if(artify_js.js_actions[index].other_elements.length){
                    data.post_data.other_element_name = {};
                    data.post_data.other_element_value = {};
                    $.each(artify_js.js_actions[index].other_elements, function (loop) {
                      data.post_data.other_element_name[loop] = artify_js.js_actions[index].other_elements[loop];
                      data.post_data.other_element_value[loop] = $('.artify_js_action_other_'+artify_js.ajax_actions[index].other_elements[loop]).val();
                    });                    
                  }
                  $.artify_actions.js_actions(this, instance, data,  artify_js.ajax_actions[index].return_value_element);
              });
            });
          }

          if(artify_js.hasOwnProperty('invoice_headers')){
            var header_count = artify_js.invoice_headers - 1;
            var total_header =  0;
            if($('table.artify-table-view').length){
              total_header =  $('table.artify-table-view tbody tr').length - 1;
              $("table.artify-table-view tbody tr:eq("+header_count+")").exchangePositionWith("table.artify-table-view tbody tr:eq("+total_header+")");
            }

            if($('.artify-form div.form-group').length)
              total_header =  $('.artify-form div.form-group').length - 2;
              $(".artify-form div.form-group:eq("+header_count+")").exchangePositionWith(".artify-form div.form-group:eq("+total_header+")");

              $(document).on("artify_after_ajax_action",function(event,container){
                var total_header =  $('.artify-form div.form-group').length - 2;
                $(".artify-form div.form-group:eq("+header_count+")").exchangePositionWith(".artify-form div.form-group:eq("+total_header+")");
               });              
          }

            $(document).on("click", "table.artify-excel-table tbody tr td.artify-row-cols", function (evt) {
                var cell = $(this);
                var content = $(this).html().trim();
                if($(this).find('input').is(':focus')) return this;
                var width = $(this).width();
                $(this).html('<input type="text" class="artify-excel-cell" value="' + content + '" style="width:'+width+'px" />')
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
                        var instance = $(this).closest(".artify-table-container").data("objkey");
                        $.artify_actions.actions(this, data, instance);
                        $(this).trigger('closeCellData');
                      }
                  });
            });
            
            if ($(".artify-slider").length > 0) {
                 var handle = $("#artify-custom-handle");
                    $(".artify-slider").slider({
                    range: $(".artify-slider").data("range"),
                    min: $(".artify-slider").data("min"),
                    max: $(".artify-slider").data("max"),
                    create: function () {
                        handle.text($(this).slider("value"));
                    },
                    slide: function (event, ui) {
                         handle.text( ui.value );
                        if ($(".artify-slider").data("range"))
                            $(".artify-slider").next().val(ui.values[ 0 ] + "-" + ui.values[ 1 ]);
                        else
                            $(".artify-slider").next().val(ui.value);
                    }
                });
            }

            if ($(".artify-spinner").length > 0) {
                    $(".artify-spinner").spinner({
                    step: $(".artify-spinner").data("step"),
                    min: $(".artify-spinner").data("min"),
                    max: $(".artify-spinner").data("max"),
                    start: $(".artify-spinner").data("start"),
                });
            }

            if($(".artify_search_input").length > 0 && artify_js.hasOwnProperty('enable_search_on_enter')) {
              $(document).on("keypress",".artify_search_input", function (e) {
                 if (e.which == 13 && artify_js.enable_search_on_enter) {
                  $(this).closest(".artify-search").find("#artify_search_btn").trigger("click");
                 }
              });
            }
            
            $.artify_actions.getAutoSuggestionData(this);
            
            $.artify_actions.setBulkCrudData(this);
            
            /*$(document).on("change", ".artify-filter", function (evt) {
                var instance = $(this).closest(".artify-filters-container").data("objkey");
                var data = $(this).data();
                var key = data.key;
                var val = $(this).val();
                var filters = $(this).closest(".artify-filters-options").find(".artify-filter-selected");
                if (filters.find("span[data-key='" + key + "']").length > 0){
                    if(val)
                        filters.find("span[data-key='" + key + "']").data("value", val).text(val+" X");
                    else{
                        $(".artify-filters-options").find("span[data-key='" + key + "']").remove();
                    }
                }
                else{
                    filters.append("<span data-key='" + key + "' data-value='" + val + "' class=\"artify-filter-option\">" + val + " X</span>");                
                }
                data.action = "filter";
                $.artify_actions.actions(this, data, instance, "");
            });*/

            $(document).on("click", "#filter-button", function (evt) {
                var instance = $(".artify-filters-container").data("objkey");
                var data = {};
                var filters = $(".artify-filters-options").find(".artify-filter");
                var selectedFilters = $(".artify-filters-options").find(".artify-filter-selected");

                filters.each(function() {
                    var key = $(this).data().key;
                    var val;

                    if ($(this).is(":radio")) {
                        val = $("input[name='" + $(this).attr('name') + "']:checked").val() || '';
                    } else {
                        val = $(this).val();
                    }

                    if (selectedFilters.find("span[data-key='" + key + "']").length > 0) {
                        if (val) {
                            selectedFilters.find("span[data-key='" + key + "']").data("value", val).text(val + " X");
                        } else {
                            selectedFilters.find("span[data-key='" + key + "']").remove();
                        }
                    } else {
                        if (val) {
                            selectedFilters.append("<span data-key='" + key + "' data-value='" + val + "' class='artify-filter-option'>" + val + " X</span>");
                        }
                    }

                    data[key] = val;
                });

                data.action = "filter";
                $.artify_actions.actions(this, data, instance, "");
            });

            $(document).on("click", ".artify-filter-option", function (evt) {
                var instance = $(this).closest(".artify-filters-container").data("objkey");
                var obj = $(".artify-filters-options");
            
                // Obtener el data-key y data-value del elemento clicado
                var dataKey = $(this).data("key");
                var dataValue = $(this).data("value");
            
                // Remover el elemento clicado
                $(this).remove();
            
                // Buscar y resetear el valor del input, radio, checkbox, o select correspondiente
                var filterElement = $('[data-key="' + dataKey + '"]');
                if (filterElement.is(":checkbox") || filterElement.is(":radio")) {
                    filterElement.prop("checked", false);
                } else if (filterElement.is("select")) {
                    filterElement.val("");
                } else {
                    filterElement.val("");
                }
            
                var data = $(this).data();
                data.action = "filter";
                $.artify_actions.actions(obj, data, instance, "");
                $("#filter-button").click();
            });
            
            $(document).on("click", ".artify-filter-option-remove", function (evt) {
                $(this).siblings(".artify-filter-option").each(function(){
                    $(this).remove();
                });

                $(".artify-filter").each(function() {
                    if ($(this).is(":checkbox") || $(this).is(":radio")) {
                        $(this).prop("checked", false);
                    } else {
                        $(this).val("");
                    }
                });

                $(".artify-radio-group input[type='radio']").prop("checked", false);

                var data = $(this).data();
                var instance = $(this).closest(".artify-filters-container").data("objkey");
                data.action = "filter";
                $.artify_actions.actions(this, data, instance, "");
                $("#filter-button").click();
           });

            /*$(document).on("focus", ".artify-date", function (evt) {
                $(this).datepicker({
                    dateFormat: artify_js.date.date_format,
                    changeMonth: artify_js.date.change_month,
                    changeYear: artify_js.date.change_year,
                    numberOfMonths:  artify_js.date.no_of_month,
                    showButtonPanel: artify_js.date.show_button_panel,
                    maxDate: artify_js.date.max_date,
                    minDate: artify_js.date.min_date
                });
            });*/
            
            if ($(".artify_tabs").length > 0) {
                $(".artify_tabs").tabs();
            }
            
            if ($(".artify-form").length > 0) {
                $(".artify-form").stepy({
                    backLabel: '<i class="fa fa-arrow-circle-left"></i> Anterior',
                    block: true,
                    nextLabel: 'Siguiente <i class="fa fa-arrow-circle-right"></i>',
                    titleClick: true,
                    titleTarget: '.stepy-tab'
                });
            }
            
           $(document).on("click", ".artify_add_file", function (evt) {
                evt.preventDefault();
                $(this).siblings(".artify-filecontrol-div").find('.artify-file').click();
           });
           
           $(document).on("click", ".artify_remove_file", function (evt) {
                evt.preventDefault();
                $(this).siblings(".artify-file-input-control").val('');
           });
           
            $(document).on("change", ".artify-file", function (evt) {
                evt.preventDefault();
                var filePath = $(this).val()
                if (filePath.match(/fakepath/)) {
                    filePath = filePath.replace(/C:\\fakepath\\/i, '');
                }
                $(this).parent().siblings(".artify-file-input-control").val(filePath);
            });
            
            $(document).on("keyup", "input.artifyerr, select.artifyerr, textarea.artifyerr", function (evt) {
                $(this).next("span.artifyform-error").remove();
                $(this).closest(".form-group").removeClass("has-error");
            });

            /*$(document).on("focus", ".artify-datetime", function (evt) {
                $(this).datetimepicker({dateFormat: artify_js.date.date_format,
                    timeFormat: artify_js.date.time_format,
                    changeMonth: artify_js.date.change_month,
                    changeYear: artify_js.date.change_year,
                    numberOfMonths:  artify_js.date.no_of_month,
                    showButtonPanel: artify_js.date.show_button_panel});
            });*/

            /*$(document).on("focus", ".artify-time", function (evt) {
                $(this).timepicker({
                     timeFormat: artify_js.date.time_format,
                });
            });*/

            $(document).on("change", ".artify-select-all", function (evt) {
                $.artify_actions.selectAll(this);
            });


            $(document).on('click', '.artify-submit-btn', function (evt) {
                var data_action = $(this).attr("data-action");
                $(this).siblings(".artify_action_type").val(data_action);
            });

            $(document).on('click', '.artify-cancel-btn', function (evt) {
                var formId = $(this).data("form-id");
                $('#' + formId).resetForm();
            });

            $(document).on('change', '.artify-records-per-page', function (evt) {
                var data = $(this).data();
                data.records = $(this).val();
                var instance = $(this).closest(".artify-table-container").data("objkey");
                $.artify_actions.actions(this, data, instance);
            });

            $(document).on('click', '[data-action="refresh"]', function (e) {
                e.preventDefault();
                var data = $(this).data();
                var instance = $(this).closest(".artify-table-container").data("objkey");
                $.artify_actions.actions(this, data, instance);
            });
            
            $(document).on('change', '.artify_search_cols', function (evt) {
               var type = $(this).find('option:selected').data('type');
               var search_obj = $(this).closest(".artify-search").children();
               
               search_obj.find("#artify_search_box").datepicker("destroy");
               search_obj.find("#artify_search_box").removeClass("artify-date");
               search_obj.find("#artify_search_box").removeClass("artify-datetime");
               search_obj.find("#artify_search_box").removeClass("artify-time");
               search_obj.find("#artify_search_box_to").datepicker("destroy");
               search_obj.find("#artify_search_box_to").removeClass("artify-date");
               search_obj.find("#artify_search_box_to").removeClass("artify-datetime");
               search_obj.find("#artify_search_box_to").removeClass("artify-time");
               search_obj.find("#artify_search_box_to").addClass("artify-hide");
               
               if(type === "date-range"){
                   search_obj.find("#artify_search_box").addClass("artify-date");
                   search_obj.find("#artify_search_box_to").removeClass("artify-hide");
                   search_obj.find("#artify_search_box_to").addClass("artify-date");
               }
               else if(type === "datetime-range"){
                   search_obj.find("#artify_search_box").addClass("artify-datetime");
                   search_obj.find("#artify_search_box_to").removeClass("artify-hide");
                   search_obj.find("#artify_search_box_to").addClass("artify-datetime");
               }
               else if(type === "time-range"){
                   search_obj.find("#artify_search_box").addClass("artify-time");
                   search_obj.find("#artify_search_box_to").addClass("artify-time");
                   search_obj.find("#artify_search_box_to").removeClass("artify-hide");
               }
            });

            $(document).on('click', '.artify-actions-sorting', function (evt) {
                evt.preventDefault();
                var data = $(this).data();
                var instance = $.artify_actions.getInstance(this, ".artifybox");
                $.artify_actions.actions(this, data, instance);
            });

            $(document).on('click', '.artify-view-print', function (evt) {
                evt.preventDefault();
                var content = "<table>" + $(this).closest("table.artify-table-view").find("tbody")[0].outerHTML + "</table>";
                var printwindow = window.open('', 'print window', 'height=400,width=600');
                $.artify_actions.print(content, printwindow);
            });
            
            $(document).on('click', '.artify-close', function (evt) {
                evt.preventDefault();
                $(this).closest("table.artify-table-view").remove();
            });
            
            $(document).on('click', '.artify-data-row', function (evt) {
                if (artify_js.quick_view) {
                    evt.preventDefault();
                    $(this).closest(".artify-table").find(".artify-data-row").removeClass("artify-row-selected");
                    $(this).addClass("artify-row-selected");
                    var data = $(this).data();
                    data.action = "quick_view";
                    var instance = $.artify_actions.getInstance(this, ".artifybox");
                    $.artify_actions.actions(this, data, instance);
                }
            });

            $(document).on('click', 'a.artify-actions', function (evt) {
                evt.preventDefault();
                var printwindow = "";
                var data = $(this).data();
                var instance = $.artify_actions.getInstance(this, ".artifybox");
                if (data.action === "print") {
                    instance = data.objkey;
                    var printdata = $("table[data-obj-key='" + data.objkey + "']")[0].outerHTML;
                    var printwindow = window.open('', 'print window', 'height=400,width=600');
                    $.artify_actions.print(printdata, printwindow);
                }

                if (data.action === "delete") {
                    if (!confirm(artify_js.lang.delete_single_record)) {
                        return;
                    }
                }

                if (data.action === "url") {
                    window.location.href = $(this).attr("href");
                    return;
                }


                if (data.action === "add_row_module") {
                    $(".artify-left-join").each(function () {
                        var tds = '<tr>';
                        $.each($('tr:last td', this), function () {
                            tds += '<td>' + $(this).html() + '</td>';
                        });
                        tds += '</tr>';
                
                        // Limpia los valores de los elementos de la última fila
                        var $lastRow = $(tds).appendTo('tbody', this);
                        $lastRow.find('input, select').val('');
                
                        if ($('tbody', this).length > 0) {
                            $('tbody', this).append($lastRow);
                        } else {
                            $(this).append($lastRow);
                        }
                    });
                    return;
                }

                if (data.action === "add_row_artify") {
                   $(".artify-left-join").each(function () {
                        var tds = '<tr>';
                        $(this).find('tr:last td').slice(0, 6).each(function () {
                            tds += '<td>' + $(this).html() + '</td>';
                        });
                        
                        tds += '<td><a href="javascript:;" class="artify-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> Remover</a></td>';
                        tds += '</tr>';

                        var $lastRow = $(tds).appendTo('tbody', this);
                        $lastRow.find('input, select').val('');

                        if ($('tbody', this).length > 0) {
                            $('tbody', this).append(lastRow);
                        } else {
                            $(this).append(lastRow);
                        }
                    });
                    return;
                }

                if (data.action === "edit_row_artify") {
                    $(".artify-left-join").each(function () {
                         var tds = '<tr>';
                         $(this).find('tr:last td').slice(0, 8).each(function () {
                             tds += '<td>' + $(this).html() + '</td>';
                         });
                         
                         tds += '<td><a href="javascript:;" class="artify-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> Remover</a></td>';
                         tds += '</tr>';
 
                         var $lastRow = $(tds).appendTo('tbody', this);
                         $lastRow.find('input, select').val('');
 
                         if ($('tbody', this).length > 0) {
                             $('tbody', this).append(lastRow);
                         } else {
                             $(this).append(lastRow);
                         }
                     });
                     return;
                 }
                    
                if (data.action === "add_row") {

                    var cantidad_columnas = parseFloat($(".cantidad_columnas").val());

                    $(".artify-left-join").each(function () {
                        
                        $(this).find('.icono').select2("destroy");

                        var tds = '<tr>';
                        $(this).find('tr:last td').slice(0, 3).each(function () {
                            tds += '<td class="form-group artify_leftjoin_row_1 artify_leftjoin_col_1">' + $(this).html() + '</td>';
                        });
                        tds += '<td class="form-group artify_leftjoin_row_1 artify_leftjoin_col_1"><a href="javascript:;" class="artify-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> Remover</a></td>';
                        tds += '</tr>';
                
                        // Agregar la nueva fila al final de la tabla
                        var $lastRow = $(tds).appendTo('tbody', this);
                        $lastRow.find('input, select, textarea').val('');
                
                        // Asignar el valor incrementado al campo .valor_aumentado en la nueva fila
                        $(this).find('.icono').select2();

                        var rowCount = $(this).find('tbody tr').length;

                        if (rowCount >= cantidad_columnas) {
                            $('.artify-button-add-row').hide(); // Ocultar el botón cuando se alcance el número de filas
                        }
                
                        if ($('tbody', this).length > 0) {
                            $('tbody', this).append($lastRow);
                        } else {
                            $(this).append($lastRow);
                        }
                    });
                    return;
                }

                if (data.action === "delete_row") {
                    if ($(this).parents("tbody").children().length > 1) {
                            $(this).parents("tr").remove();
    
                            // Reordenar los valores de .valor_aumentado después de eliminar una fila
                            $(".artify-left-join").each(function () {
                                var contador = 1;
                                $(this).find('.valor_aumentado').each(function () {
                                    $(this).val(contador);
                                    contador++;
                                });
                            });
                        }
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
                    data.search_col = $(this).closest(".artify-search").children().find(".artify_search_cols").val();
                    data.search_text = $(this).closest(".artify-search").children().find("#artify_search_box").val();
                    var search_to = $(this).closest(".artify-search").children().find("#artify_search_box_to").val();
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
                    if (!confirm(artify_js.lang.delete_select_records)) {
                        return;
                    }
                    var selected = [];
                    var obj_key = $(this).attr("data-obj-key");
                    $("table[data-obj-key='" + obj_key + "']").children().find(".artify-select-cb:checked").each(function () {
                        selected.push($(this).val());
                    });
                    if (selected.length < 1) {
                        alert(artify_js.lang.select_one_entry);
                        return;
                    }
                    data.selected_ids = selected;
                }

                if (data.action === "pagination") {
                    instance = $(this).closest(".artify-table-container").data("objkey");
                    data.exportType = $(this).data("export-type");
                }
                
                if (data.action === "save_crud_table_data") {
                    instance = $(this).closest(".artify-table-container").data("objkey");

                    var modalElement = jQuery(this).closest(".artify-table-container").find(".modal");
                    if (modalElement.length > 0) {
                        modalElement.modal('hide'); // Ocultar el modal si está abierto
                        modalElement.remove(); // Eliminar el modal del DOM si es necesario
                    }

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
                    instance = $(this).closest(".artify-table-container").data("objkey");   
                }

                $.artify_actions.actions(this, data, instance, printwindow);
                evt.stopPropagation();

            });

            $(document).on('click', '.artify-submit', function (evt) {
                var data_action = $(this).data("action");
                $(this).siblings(".artify_action_type").val(data_action);
            });

            $(document).on('click', '.artify-back', function (evt) {
                var data = $(this).data();
                var instance = $(this).closest(".artify-table-container").data("objkey");
                $.artify_actions.actions(this, data, instance);
                evt.preventDefault();
                if ($('body').hasClass("modal-open"))
                    $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                return;
            });
            
            $(document).on('click', '.artify-view-delete', function (evt) {
                if (!confirm(artify_js.lang.delete_single_record)) {
                        return;
                    }
                var data = $(this).data();
                var instance = $(this).closest(".artify-table-container").data("objkey");
                $.artify_actions.actions(this, data, instance);
                evt.preventDefault();
                if ($('body').hasClass("modal-open"))
                    $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                return;
            });
            
            $(document).on('click', '.artify-view-edit', function (evt) {
                var data = $(this).data();
                var instance = $(this).closest(".artify-table-container").data("objkey");
                $.artify_actions.actions(this, data, instance);
                evt.preventDefault();
                if ($('body').hasClass("modal-open"))
                    $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                return;
            });

            $(document).on('submit', '.artify-form', function (evt) {
                if (artify_js.submission_type === "ajax") {
                    evt.preventDefault();
                    $(this).validator('validate');
                    var validation = true;
                    
                    if (artify_js.jsvalidation === "script_validator") {
                        validation = $.artify_actions.validate(this);
                    }
                    else if (artify_js.jsvalidation === "plugin_validator") {
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
                            $(this).find(".g-recaptcha").prepend("<div class='has-errors with-errors'><p>" + artify_js.lang.recaptcha_msg + "</p></div>");
                            validation = false;
                        }
                    }

                    $(document).trigger("artify_before_form_submission", [this]);
                    if (validation) {
                        $.artify_actions.submitData(this);
                    }
                }
            });

            $.artify_actions.createMap(this);
            $(document).trigger("artify_on_load", [this]);
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
             if ($(".artify_search_input").length > 0 && artify_js.auto_suggestion) {
                var instance = $(".artify-table-container").data("objkey");
                var data = $(obj).data();
                data.action = "autosuggest";
                $(".artify_search_input").autocomplete({
                    source: function (request, response) {
                        data.search_text = request.term;
                        data.search_col = $(".artify_search_cols").val();
                        $.ajax({
                            url: artify_js.artifyurl + "artify/artifycrud.php",
                            dataType: "jsonp",
                            type: "post",
                            data: {
                                "artify_data": data,
                                "artify_instance": instance,
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
                url: artify_js.artifyurl + "artify/artifycrud.php",
                beforeSend: function () {
                    $("#artify-ajax-loader").show();
                },
                data: {
                    "artify_data": data,
                    "artify_instance": instance,
                },
                success: function (response) {
                    $("#artify-ajax-loader").hide();
                    $(obj).closest("form").next(".artify-adv-search-result").html(response);
                }
            });
        },
        actions: function (obj, data, instance, printwindow) {
            $(document).trigger("artify_before_ajax_action", [obj, data]);
            data = $.artify_actions.getFilterData(obj, data);

            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: artify_js.artifyurl + "artify/artifycrud.php",
                beforeSend: function () {
                    $("#artify-ajax-loader").show();
                },
                data: {
                    "artify_data": data,
                    "artify_instance": instance
                },
                success: function (response) {
                    $("#artify-ajax-loader").hide();
                    if (data.action === "exporttable") {
                        if (data.exportType === "print") {
                            $.artify_actions.print(response, printwindow);
                        } else if (data.exportType === "excel") {
                            let json = JSON.parse(response);
                            let url = json.downloadUrl;
                            let fileName = url.substring(url.lastIndexOf('/')+1);
                            window.location.href = artify_js.artifyurl + 'artify/downloads/' + fileName;
                        } else {
                            window.location.href = response;
                            console.log(response);
                        }
                    } else if (data.action === "refresh") {
                        $(obj).closest(".artify-table-container").html(response);
                    } else {
                        if ($(obj).closest(".artify-table-container").data("modal")) {
                            var actions_arr = ["view_back", "insert_back", "back", "update_back", "delete", "sort", "asc", "desc", "delete_selected", "search", "records_per_page", "pagination"];            
                            if ($.inArray(data.action, actions_arr) !== -1) {
                                if ($(obj).parents("body").hasClass("modal-open")){
                                    $(obj).parents("body").removeClass("modal-open");
                                }
                                $("#" + instance + "_modal").modal('hide');
                                $(obj).closest(".artify-table-container").html(response);

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
                            $(obj).closest(".artify-filters-container").find(".artify-table-container").html(response);
                        }

                        else if (data.action === "onepageview") {
                            var element = $(obj).closest(".artify-one-page-container");
                            $(obj).closest(".artify-one-page-container").after(response);
                            element.remove();
                            $(obj).closest(".artify-one-page-container").html(response);
                        }
                        else if (data.action === "onepageedit") {
                            var element = $(obj).closest(".artify-one-page-container");
                            $(obj).closest(".artify-one-page-container").after(response);
                            element.remove();
                            $(obj).closest(".artify-one-page-container").html(response);
                        }
                        else if (data.action === "quick_view") {
                            var element = $(obj).closest(".artifybox")
                            element.find(".artify-quick-view").remove();
                            element.append("<div class='artify-quick-view'></div>");
                            element.find(".artify-quick-view").html(response);
                            $('html, body').animate({ scrollTop: $(".artify-quick-view").last().offset().top }, 'slow');
                        }
                        else if (data.action === "related_table") {
                            var element = $(obj).closest(".artifybox")
                            element.find(".artify-related-table-view").remove();
                            element.append("<div class='artify-related-table-view'></div>");
                            element.find(".artify-related-table-view").html(response);
                            $('html, body').animate({ scrollTop: $(".artify-related-table-view").offset().top }, 'slow');
                        }
                        else if (data.action === "printpdf") { 
                          var win = window.open(response, '_blank');
                          win.focus();
                        }
                        else {
                            $(obj).closest(".artify-table-container").html(response);
                            if ($(".artify_tabs").length > 0) {
                                $(obj).parents(".artify-table-container").last().html(response);
                            }
                            if (data.action === "edit") { 
                                $(".artify-table-container").find(":input[data-condition-logic]").each(function(){
                                    $(this).trigger("change");
                                });
                            }
                        }
                        if ($(".artify_tabs").length > 0) {
                            $(".artify_tabs").tabs();
                        }   
                        $.artify_actions.createMap(obj);
                    }
                    $.artify_actions.setBulkCrudData(this);
                    $.artify_actions.getAutoSuggestionData(this);
                    $(document).trigger("artify_after_ajax_action", [obj, response]);
                    try {
                        grecaptcha.render('pdo_recaptcha', {
                            sitekey: artify_js.site_key,
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
         reload: function (obj, data, instance, element) {
            $(document).trigger("artify_before_reload_ajax_action", [obj, data]);

            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: artify_js.artifyurl + "artify/artifycrud.php",
                data: {
                    "artify_data": data,
                    "artify_instance": instance,
                },
                success: function (response) {
                    element.html(response);
                    $(document).trigger("artify_after_reload_ajax_action", [obj, response]);
                    try {
                        grecaptcha.render('pdo_recaptcha', {
                            sitekey: artify_js.site_key,
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
        customAjaxAction: function (event, eventId, action, ajaxFunction, postData, successCallback) {
            $(document).on(event, "#" + eventId, function () {
                var data = {
                    action: action,
                    function: ajaxFunction,
                    post_data: postData
                };
                var instance = $(".artify-table-container").data("objkey");
        
                $.ajax({
                    type: "post",
                    dataType: "html",
                    cache: false,
                    url: artify_js.artifyurl + "artify/artifycrud.php",
                    beforeSend: function () {
                        $("#artify-ajax-loader").show();
                    },
                    data: {
                        "artify_data": data,
                        "artify_instance": instance,
                    },
                    success: function (response) {
                        $("#artify-ajax-loader").hide();
                        if (typeof successCallback === 'function') {
                            successCallback(response);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
         },
         ajax_actions: function (obj, instance, data, return_value_element) {
            $(document).trigger("artify_before_reload_ajax_action", [obj, data]);
            $.ajax({
                type: "post",
                dataType: "html",
                cache: false,
                url: artify_js.artifyurl + "artify/artifycrud.php",
                data: {
                    "artify_data": data,
                    "artify_instance": instance,
                },
                success: function (response) {                    
                    $(document).trigger("artify_after_custom_ajax_action", [obj, response]);
                    if(return_value_element){
                      $('.artify_ajax_action_return_'+return_value_element).val(response);
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
            var data_action_type = $(obj).find(".artify_action_type").val();
            var options = {
                type: "post",
                dataType: "html",
                url: artify_js.artifyurl + "artify/artifycrud.php",
                beforeSubmit: showRequest, // pre-submit callback 
                success: showResponse,  // post-submit callback 
                resetForm: artify_js.reset_form
            };
            $(obj).ajaxSubmit(options);

            function showRequest(formData, jqForm, options) {
                $(document).trigger("pdcrud_before_form_submit", [obj, formData]);
                $("#artify-ajax-loader").show();
            }

            function showResponse(responseText, statusText, xhr, $form) {
                $("#artify-ajax-loader").hide();
                $(obj).find(".artify_message").addClass("hidden");
                $(obj).find(".artify_error").addClass("hidden");
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
                        $(obj).find(".artify_message").removeClass("hidden");
                        $(obj).find(".artify_message").find(".message_content").text(response.message);
                    }
                    if (response.error.length > 0) {
                        $(obj).find(".artify_error").removeClass("hidden");
                        $(obj).find(".artify_error").find(".error_content").text(response.error);
                    }
                    
                    if ($(obj).parents(".artify-one-page-container").length > 0) {
                        var op_cont = $(obj).parents(".artify-one-page-container");
                        var instance = op_cont.children().find(".artify-table-container").data("objkey");
                        var data = op_cont.data();
                        var element = op_cont.children().find(".artify-table-container");
                        $.artify_actions.reload(obj, data, instance, element);
                    }
                }
                else if (data_action_type == "insert_back" || data_action_type == "update_back" || data_action_type == "view_back" || data_action_type == "back") {
                    if ($(obj).parents("body").hasClass("modal-open"))
                        $(obj).parents("body").removeClass("modal-open");
                    $('.modal-backdrop').remove();
                    $(obj).closest(".artify-table-container").html(responseText);
                }
                else if (data_action_type == "insert_close" || data_action_type == "update_close") {
                    
                }
                else if (data_action_type === "export") {
                    window.location.href = responseText;
                }
                else {
                    $(obj).closest(".artify-table-container").html(responseText);
                }
                $.artify_actions.getAutoSuggestionData(this);
                $(document).trigger("artify_after_submission", [obj, responseText]);
            }
        },
        print: function (printdata, printwindow) {
            printwindow.document.write('<html><head><title>Print Data</title>');
            printwindow.document.write('<style type="text/css">.artify-select-cb{display:none} .artify-select-all{display:none}</style>');
            printwindow.document.write('</head><body >');
            printwindow.document.write(printdata);
            printwindow.document.write('</body></html>');
            printwindow.print();
            printwindow.close();
            return true;
        },
        validate: function (form) {
            $(form).find("span.artifyform-error").remove();
            $(".form-group").removeClass("has-error");
            var valid = true;
            $(form).find(':input').each(function () {
                $(this).removeClass("has-error");
                $(this).removeClass("artifyerr");
                if ($(this).data("required")) {
                    if ($(this).val().replace(/\s/g, "") == "") {
                        valid = false;
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.req_field + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-email")) {
                    valid = $.artify_actions.validate_email($(this).val());
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.invalid_email + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-date")) {
                    valid = $.artify_actions.validate_date($(this).val());
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.invalid_date + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-min-length")) {
                    valid = $.artify_actions.validate_length($(this).data("min-length"), $(this).val().length, "min");
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.min_length + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-max-length")) {
                    valid = $.artify_actions.validate_length($(this).data("max-length"), $(this).val().length, "max");
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.min_length + '</span>');
                        $(this).focus();
                    }
                }


                if ($(this).hasAttr("data-exact-length")) {
                    valid = $.artify_actions.validate_length($(this).data("exact-length"), $(this).val().length, "exact");
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.min_length + '</span>');
                        $(this).focus();
                    }
                }

                if ($(this).hasAttr("data-match")) {
                    valid = $.artify_actions.validate_equal_to($(this).val(), $($(this).data("equal-to")).val());
                    if (valid === false) {
                        $(this).closest(".form-group").addClass("has-error");
                        $(this).after('<span class="artifyform-error field-validation-error" for="' + $(this).attr("id") + '">' + artify_js.lang.match + '</span>');
                        $(this).focus();
                    }
                }

                if (valid === false) {
                    $(this).addClass("artifyerr");
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
            var filter_span = $(obj).closest(".artify-filters-container").find(".artify-filters-options").find(".artify-filter-selected");
            if (filter_span.length > 0) {
                data.filter_data = new Array();
                filter_span.find(".artify-filter-option").each(function () {
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
                $(obj).parents("table").find(".artify-select-cb").prop('checked', true);
            else
                $(obj).parents("table").find(".artify-select-cb").prop('checked', false);
        },
        createMap: function (obj) {
            $(".artify-gmap").each(function () {
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
            var dependent = $.artify_actions.getDependent(obj);
            if (dependent.length > 0) {
                $.ajax({
                    type: "post",
                    dataType: "html",
                    cache: false,
                    url: artify_js.artifyurl + "artify/artifycrud.php",
                    beforeSend: function () {
                        $("#artify-ajax-loader").show();
                    },
                    data: {
                        "artify_data[action]": "loadDependent",
                        "artify_data[artify_dependent_name]": dependent.attr("id"),
                        "artify_data[artify_field_name]": $(obj).attr("id"),
                        "artify_data[artify_field_val]": $(obj).val(),
                        "artify_instance": instance,
                    },
                    success: function (response) {
                        dependent.html(response);
                        $("#artify-ajax-loader").hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#artify-ajax-loader").hide();
                    },
                    complete: function () {
                        //console.log()
                    },
                });
            }
        },
    };
    $.artify_actions.init();
});

$.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
};

function refreshCaptcha(id, src) {
    $("#" + id).attr("src", src);
}
