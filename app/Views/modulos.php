<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<style>
.btn.btn-default {
    background: #fff;
}
@media (min-width: 576px){
	.modal-dialog {
		max-width: 700px!important;
		margin: 1.75rem auto;
	}
}

.mt-customs {
    margin-top: 55px;
}

.bootstrap-tagsinput input {
    width: 200px!important;
}

.mt-custom {
    margin-top: 44px;
}

label {
    margin-bottom: 6px!important;
}

.tag {
    background-color: #5cb85c;
    color: #fff;
    padding: 2px 5px;
    border-radius: 3px;
    margin-right: 5px;
    margin-bottom: 5px;
    cursor: pointer;
    font-size: 0.9rem;
}

.fwb {
    font-weight: bold;
}

label:not(.form-check-label):not(.custom-file-label) {
    font-size: 13px;
    display:flex;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #000000!important;
    border: 1px solid #000000!important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #fff!important;
}

.select2-container .select2-selection--single {
    height: 38px!important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 7px!important;
}

.select2-container {
    width:100%!important;
}

.artify_leftjoin_row_1 {
    width: 7.692307692307692%;
}

body {
    overflow-x: hidden;
}

.bootstrap-switch.bootstrap-switch-focused {
    border-color: #ccc!important;
    box-shadow: none!important;
}

.bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary {
    color: white!important;
    background: green!important;
}

.bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-default, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-default {
    color: white!important;
    background: red!important;
}

.circle-number {
    background: green;
    padding: 4px 10px;
    border-radius: 50%;
    color: #fff;
}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="create-tablas-tab" data-toggle="tab" href="#create-tablas" role="tab" aria-controls="create-tablas" aria-selected="true"><span class="circle-number">1</span> Crear Tablas</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="create-modulos-tab" data-toggle="tab" href="#create-modulos" role="tab" aria-controls="create-modulos" aria-selected="false"><span class="circle-number">2</span> Generador de Módulos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="create-pdf-tab" data-toggle="tab" href="#create-pdf" role="tab" aria-controls="create-pdf" aria-selected="false"><span class="circle-number">3</span> Configuraciones de PDF</a>
                    </li>
                </ul>
            
                <div class="tab-content pt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="create-tablas" role="tabpanel" aria-labelledby="create-tablas-tab">
                        <?=$render_tablas?>
                    </div>
                    <div class="tab-pane fade" id="create-modulos" role="tabpanel" aria-labelledby="create-modulos-tab">
                        <?=$render?>
                        <?=$switch?>
                        <?=$tags?>
                    </div>
                    <div class="tab-pane fade" id="create-pdf" role="tabpanel" aria-labelledby="create-pdf-tab">
                        <?=$render_pdf?>
                    </div>
                </div>


			</div>
		</div>
	</section>
</div>
<div id="artify-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>
$(document).on("change", ".generar_jwt_token", function() {
    var val = $(this).val();

    if(val == "Si"){
        $(".autenticar_jwt_token").removeAttr("disabled", "disabled");
        $(".tiempo_caducidad_token").removeAttr("disabled", "disabled");
        $(".generar_token_api").removeClass("d-none");
    } else {
        $(".generar_token_api").addClass("d-none");
        $(".autenticar_jwt_token").attr("disabled", "disabled");
        $(".tiempo_caducidad_token").attr("disabled", "disabled");
        $(".autenticar_jwt_token").val("");
    }
});

$(document).on("click", ".generar_token_api", function(){
    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>Home/generarToken",
        dataType: 'json',
        beforeSend: function() {
            $("#artify-ajax-loader").show();
        },
        success: function(data){
            $("#artify-ajax-loader").hide();
            let token = data["data"];
            $(".autenticar_jwt_token").val(token);
            Swal.fire({
                title: "Genial!",
                text: "Token Generado con éxito",
                icon: "success",
                confirmButtonText: "Aceptar"
            });
        }
    });
});

$(document).on("artify_after_ajax_action", function(event, obj, data){
    var dataAction = obj.getAttribute('data-action');
    var dataId = obj.getAttribute('data-id');

    if(dataAction == "add"){

        construirFrase();

        $("form").on("keypress", "input", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                return false;
            }
        });

        $(".type_callback").select2();

        $(function() {
            var textosPermitidosList = ['Imagen', 'Archivo Único', 'Multiples Archivos', 'Radiobox', 'Checkbox', 'Combobox', 'Combobox Multiple', 'Campo de Texto', 'Campo de Área de Texto', 'Campo de Fecha', 'Campo de Fecha y Hora', 'Campo de Hora'];

            $('.type_fields').tagsinput({
                allowDuplicates: true,
                typeaheadjs: {
                    name: 'textosPermitidosList',
                    source: function(query, syncResults) {
                        // Filtra los elementos de la lista permitida según el término de búsqueda
                        var matches = textosPermitidosList.filter(function(item) {
                            return item.toLowerCase().indexOf(query.toLowerCase()) !== -1;
                        });
                        syncResults(matches);
                    }
                }
            });

            $('.type_fields').on('beforeItemAdd', function(event) {
                var texto = event.item;

                // Si el texto no está en la lista de permitidos, cancelamos la adición
                if (textosPermitidosList.indexOf(texto) === -1) {
                    event.cancel = true;
                    Swal.fire({
                        title: "Lo siento",
                        text: 'Este texto no está permitido.',
                        confirmButtonText: "Aceptar",
                        icon: "error"
                    });
                }
            });
        });

        $('.tabla_principal_union').change(function() {
            let val = $('.tabla_principal_union').val(); // Obtenemos el array de valores seleccionados
            let lastSelected = val[val.length - 1]; // Obtenemos el último valor seleccionado
            
            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>Home/obtener_campos_relacion_union_interna",
                dataType: "json",
                data: {
                    lastSelected: lastSelected
                },
                beforeSend: function() {
                    $("#artify-ajax-loader").show();
                },
                success: function(data){
                    $("#artify-ajax-loader").hide();

                    $(".campos_relacion_union_tabla_principal").empty();
                    $.each(data["data"], function(index, obj){
                        $(".campos_relacion_union_tabla_principal").append(`
                            <option value="${obj}">${obj}</option>
                        `);
                    });
                }
            });
        });

        $('.tabla_secundaria_union').change(function() {
            let val = $(".tabla_secundaria_union").val(); // Obtenemos el array de valores seleccionados
            let lastSelected = val[val.length - 1]; // Obtenemos el último valor seleccionado
            
            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>Home/obtener_campos_relacion_union_interna",
                dataType: "json",
                data: {
                    lastSelected: lastSelected
                },
                beforeSend: function() {
                    $("#artify-ajax-loader").show();
                },
                success: function(data){
                    $("#artify-ajax-loader").hide();

                    $(".campos_relacion_union_tabla_secundaria").empty();
                    $.each(data["data"], function(index, obj){
                        $(".campos_relacion_union_tabla_secundaria").append(`
                            <option value="${obj}">${obj}</option>
                        `);
                    });
                }
            });
        });

        $('.tabla_principal_union, .tabla_secundaria_union').on('change', function () {
            let principalValues = $('.tabla_principal_union').val() || [];

            // Obtener los valores seleccionados del segundo multiselect
            let secundariaValues = $('.tabla_secundaria_union').val() || [];

            // Comprobar si alguno de los valores del segundo multiselect coincide con los del primero
            let commonValues = secundariaValues.filter(value => principalValues.includes(value));

            if (commonValues.length > 0) {
                // Si hay valores comunes, eliminar esos valores del segundo multiselect
                secundariaValues = secundariaValues.filter(value => !commonValues.includes(value));
                $('.tabla_secundaria_union').val(secundariaValues).trigger('change');

                // Mostrar la alerta con SweetAlert2
                Swal.fire({
                    icon: 'warning',
                    title: 'Valores duplicados',
                    text: 'No se permite la misma tabla en ambos Campos.',
                    confirmButtonText: "Aceptar"
                });
            }
        });

        $(function() {
            var textosPermitidos = ['radio', 'dropdown', 'date', 'text'];

            $('.tipo_de_filtro').tagsinput({
                allowDuplicates: true,
                typeaheadjs: {
                    name: 'textosPermitidos',
                    source: function(query, syncResults) {
                        // Filtra los elementos de la lista permitida según el término de búsqueda
                        var matches = textosPermitidos.filter(function(item) {
                            return item.toLowerCase().indexOf(query.toLowerCase()) !== -1;
                        });
                        syncResults(matches);
                    }
                }
            });

            $('.tipo_de_filtro').on('beforeItemAdd', function(event) {
                var texto = event.item;

                // Si el texto no está en la lista de permitidos, cancelamos la adición
                if (textosPermitidos.indexOf(texto) === -1) {
                    event.cancel = true;
                    Swal.fire({
                        title: "Lo siento",
                        text: 'Este texto no está permitido.',
                        confirmButtonText: "Aceptar",
                        icon: "error"
                    });
                }
            });
        });

        $('.campos_relacion_union_tabla_principal, .campos_relacion_union_tabla_secundaria').select2();

        $(".regresar_tablas").click(function(){
            $('.leftjoin_tr').remove();
        });

        $(".artify-cancel-btn").click(function(){
            $('a[data-action="delete_row"]').click();
        });

        $("#create-tablas-tab, #create-pdf-tab").click(function(){
            $(".regresar_modulos").click();
        });

        $("#create-modulos-tab, #create-pdf-tab, #config-api-tab").click(function(){
            $('.leftjoin_tr').remove();
            $('.regresar_tablas').click();
        });

        $(".activar_union_interna").change(function(){
            let valor = $(this).val();

            if(valor == "Si"){
                $(".tabla_principal_union").removeAttr("disabled", "disabled");
                $(".tabla_secundaria_union").removeAttr("disabled", "disabled");
                $(".campos_relacion_union_tabla_principal").removeAttr("disabled", "disabled");
                $(".campos_relacion_union_tabla_secundaria").removeAttr("disabled", "disabled");
                $(".esconder_tipo_union").removeClass("d-none");
            } else {
                $(".tabla_principal_union").attr("disabled", "disabled");
                $(".tabla_secundaria_union").attr("disabled", "disabled");
                $(".campos_relacion_union_tabla_principal").attr("disabled", "disabled");
                $(".campos_relacion_union_tabla_secundaria").attr("disabled", "disabled");
                $(".esconder_tipo_union").addClass("d-none");
            }
        });

        $(".active_filter").change(function(){
            let valor = $(this).val();

            if(valor == "Si"){
                $(".mostrar_campos_filtro").removeAttr("disabled", "disabled");
                $(".posicion_filtro").removeAttr("disabled", "disabled");
                $(".esconder_tipo_filtro").removeClass("d-none");
                $(".tipo_de_filtro").removeAttr("disabled", "disabled");
            } else {
                $(".mostrar_campos_filtro").attr("disabled", "disabled");
                $(".posicion_filtro").attr("disabled", "disabled");
                $(".esconder_tipo_filtro").addClass("d-none");
                $(".tipo_de_filtro").attr("disabled", "disabled");
            }
        });

        $(".tabla").change(function(){
            let val = $(this).val();

            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>Home/obtener_id_tabla",
                dataType: 'json',
                data: {
                    val: val
                },
                beforeSend: function() {
                    $("#artify-ajax-loader").show();
                },
                success: function(data){
                    $("#artify-ajax-loader").hide();

                    if (val != "") {
                        // Asignar el valor del ID
                        $(".id_tabla").val(data["id_tablas"]);

                        $(".name_view").val(val);

                        let controllerName = val.charAt(0).toUpperCase() + val.slice(1);
                        $(".controller_name").val(controllerName);

                        // Limpiar los selectores de campos y añadir la opción "Seleccionar"
                        $(".tabla_principal_union, .tabla_secundaria_union, .mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro, .mostrar_campos_formulario_editar, .campos_condicion, .ordenar_grilla_por, .nombre_columnas, .nombre_campos").empty();
                        
                        // Añadir nuevas opciones desde el resultado del ajax
                        $.each(data["columnas_tablas"], function(index, obj){
                            $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro, .mostrar_campos_formulario_editar, .campos_condicion, .ordenar_grilla_por, .nombre_columnas, .nombre_campos").append(`
                                <option value="${obj}">${obj}</option>
                            `);
                        });


                        $.each(data["tablas"], function(index, obj){
                            $(".tabla_principal_union, .tabla_secundaria_union").append(`
                                <option value="${obj.nombre_tabla}">${obj.nombre_tabla}</option>
                            `);
                        });

                        // Inicializar select2 en los nuevos elementos
                        $(".tabla_principal_union, .tabla_secundaria_union, .mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro, .mostrar_campos_formulario_editar, .campos_condicion, .ordenar_grilla_por, .nombre_columnas, .nombre_campos").select2();

                    } else {
                        // Limpiar los campos si val está vacío y añadir la opción "Seleccionar"
                        $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro, .mostrar_campos_formulario_editar, .campos_condicion, .ordenar_grilla_por, .nombre_columnas, .nombre_campos").empty();
                        
                        // Vaciar el valor de id_tabla
                        $(".id_tabla").val("");

                        $(".name_view").val("");

                        $(".controller_name").val("");

                        // Inicializar select2 en los nuevos elementos
                        $(".tabla_principal_union, .tabla_secundaria_union, .mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro, .mostrar_campos_formulario_editar, .campos_condicion, .ordenar_grilla_por, .nombre_columnas, .nombre_campos").select2();
                    }
                }
            });
        });

        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>Home/obtener_tablas",
            dataType: "json",
            beforeSend: function() {
                $("#artify-ajax-loader").show();
            },
            success: function(data){
                $("#artify-ajax-loader").hide();
                
                // Limpiar opciones anteriores del select
                $(".tabla").empty();
                $(".tabla").html(`<option value>Seleccionar</option>`);
                // Añadir nuevas opciones desde el resultado del ajax
                $.each(data["tablas"], function(index, obj){
                    $(".tabla").append(`
                        <option value="${obj.nombre_tabla}">${obj.nombre_tabla}</option>
                    `);
                });
                
                // Actualizar select2 para que reconozca los nuevos valores
                $(".tabla").trigger('change'); 
            }
        });

        // Inicializar select2
        $(".tabla").select2();

        $(".titulo_modulo").text("Agregar");
        $('.siguiente_1').click(function() {
            $('#pdf-tab').tab('show');
        });

        $('.siguiente_2').click(function() {
            $('#Api-tab').tab('show');
        });

        $('.anterior').click(function() {
            $('#modulos-tab').tab('show');
        });

        $('.atras').click(function() {
            $('#pdf-tab').tab('show');
        });

        $(".modificar_tabla_col").hide();
        $(".campos_view_tabla").hide();

        $(".activate_pdf").change(function() {
            var val = $(this).val();

            if(val == "Si"){
                $(".logo_pdf").removeAttr("disabled", "disabled");
                $(".marca_de_agua_pdf").removeAttr("disabled", "disabled");
                $(".consulta_pdf").removeAttr("disabled", "disabled");
            } else {
                $(".logo_pdf").attr("disabled", "disabled");
                $(".marca_de_agua_pdf").attr("disabled", "disabled");
                $(".consulta_pdf").attr("disabled", "disabled");
            }
        });

        $(".template_fields").change(function() {
            var template_fields = $(this).val();

            if(template_fields == "Si"){
                $(".cantidad_campos_a_mostrar_plantilla_html").removeAttr("disabled", "disabled");
            } else {
                $(".cantidad_campos_a_mostrar_plantilla_html").attr("disabled", "disabled");
            }
        });
        
        $(".activar_recaptcha").change(function() {
            var val = $(this).val();

            if(val == "Si"){
                $(".sitekey_recaptcha").removeAttr("disabled", "disabled");
                $(".sitesecret_repatcha").removeAttr("disabled", "disabled");
            } else {
                $(".sitekey_recaptcha").attr("disabled", "disabled");
                $(".sitesecret_repatcha").attr("disabled", "disabled");
            }
        });

        /*$(".activate_api").change(function() {
            var val = $(this).val();

            if(val == "Si"){
                $(".api_type").removeAttr("disabled", "disabled");
                $(".api_type").bootstrapSwitch('disabled', false);

                $(".query_get").removeAttr("disabled", "disabled");
                $(".query_post").removeAttr("disabled", "disabled");
                $(".query_put").removeAttr("disabled", "disabled");
                $(".query_delete").removeAttr("disabled", "disabled");
                $(".consulta_api").removeAttr("disabled", "disabled");
            } else {
                $(".api_type").attr("disabled", "disabled");
                $(".generar_token_api").addClass("d-none");
                $(".api_type").bootstrapSwitch('disabled', true);

                $(".query_get").attr("disabled", "disabled");
                $(".query_post").attr("disabled", "disabled");
                $(".query_put").attr("disabled", "disabled");
                $(".query_delete").attr("disabled", "disabled");
                $(".consulta_api").attr("disabled", "disabled");
            }
        });*/

        $(".activate_nested_table").change(function() {
            var val = $(this).val();

            if(val == "Si"){
                $(".agregar_muestras").removeClass("d-none");
                $(".nivel").removeAttr("disabled", "disabled");
                $(".tabla_db").removeAttr("disabled", "disabled");
                $(".consulta_crear_tabla").removeAttr("disabled", "disabled");
                $(".name_controller_db").removeAttr("disabled", "disabled");
                $(".name_view_db").removeAttr("disabled", "disabled");
                $(".tabla_db").val("tabla_secundaria");
                $(".consulta_crear_tabla").val("id INT(11) AUTO_INCREMENT PRIMARY KEY,\n" +
                "nombre VARCHAR(255) NOT NULL,\n" +
                "apellido VARCHAR(255) NOT NULL,\n" +
                "categoria INT(11) NOT NULL,\n" +
                "producto VARCHAR(100) NOT NULL");
                $(".leftjoin_grilla").removeClass("d-none");
            } else {
                $(".agregar_muestras").addClass("d-none");
                $(".leftjoin_grilla").addClass("d-none");
                $(".nivel").attr("disabled", "disabled");
                $(".tabla_db").attr("disabled", "disabled");
                $(".consulta_crear_tabla").attr("disabled", "disabled");
                $(".name_controller_db").attr("disabled", "disabled");
                $(".name_view_db").attr("disabled", "disabled");
                $(".tabla_db").val("");
                $(".consulta_crear_tabla").val("");
            }
        });

        $(".crud_type").change(function() {
            var val = $(this).val();

            if (val == "CRUD") {
                $(".query").removeAttr("required").attr("disabled", "disabled");
                $(".mostrar_columnas_grilla").removeAttr("disabled", "disabled");
                $(".mostrar_campos_busqueda").removeAttr("disabled", "disabled");
                $(".mostrar_columna_acciones_grilla").removeAttr("disabled", "disabled");
                $(".mostrar_campos_formulario_editar").removeAttr("disabled", "disabled");
                $(".posicion_botones_accion_grilla").removeAttr("disabled", "disabled");
                $(".refrescar_grilla").removeAttr("disabled", "disabled");
                $(".nombre_columnas").removeAttr("disabled", "disabled");

                $(".actions_buttons_grid").removeAttr("disabled", "disabled");
                $(".actions_buttons_grid").bootstrapSwitch('disabled', false);

                $(".clone_row").removeAttr("disabled", "disabled");
                $(".activar_numeracion_columnas").removeAttr("disabled", "disabled");
                $(".mostrar_paginacion").removeAttr("disabled", "disabled");
                $(".cantidad_de_registros_por_pagina").removeAttr("disabled", "disabled");
                $(".activar_registros_por_pagina").removeAttr("disabled", "disabled");
                $(".posicionarse_en_la_pagina").removeAttr("disabled", "disabled");
                $(".activar_edicion_en_linea").removeAttr("disabled", "disabled");
                $(".activate_deleteMultipleBtn").removeAttr("disabled", "disabled");
                $(".active_popup").removeAttr("disabled", "disabled");
                $(".active_search").removeAttr("disabled", "disabled");
                $(".button_add").removeAttr("disabled", "disabled");
                $(".active_filter").removeAttr("disabled", "disabled");
                $(".function_filter_and_search").removeAttr("disabled", "disabled");
                $(".ordenar_grilla_por").removeAttr("disabled", "disabled");
                $(".tipo_orden").removeAttr("disabled", "disabled");

                $("input[value='Ver']").prop('disabled', false);
                $("input[value='Editar']").prop('disabled', false);
                $("input[value='Eliminar']").prop('disabled', false);
                $("input[value='Guardar y regresar']").prop('disabled', false);
                $("input[value='Regresar']").prop('disabled', false);
                $("input[value='Personalizado PDF']").prop('disabled', false);

                $("input[value='Ver']").bootstrapSwitch('disabled', false);
                $("input[value='Editar']").bootstrapSwitch('disabled', false);
                $("input[value='Eliminar']").bootstrapSwitch('disabled', false);
                $("input[value='Guardar y regresar']").bootstrapSwitch('disabled', false);
                $("input[value='Regresar']").bootstrapSwitch('disabled', false);
                $("input[value='Personalizado PDF']").bootstrapSwitch('disabled', false);

            } else if (val == "Modulo de Inventario") {
                $(".id_tabla").attr("disabled", "disabled").removeAttr("required").val("");
                $(".tabla").val("Inventario");
                $(".name_view").val("Inventario");
                $(".controller_name").val("Inventario");
            } else if(val == "Formulario de inserción"){
                $(".query").attr("disabled", "disabled").val("");
                $(".mostrar_columnas_grilla").attr("disabled", "disabled");
                $(".mostrar_campos_busqueda").attr("disabled", "disabled");
                $(".mostrar_columna_acciones_grilla").attr("disabled", "disabled");
                $(".mostrar_campos_formulario_editar").attr("disabled", "disabled");
                $(".posicion_botones_accion_grilla").attr("disabled", "disabled");
                $(".refrescar_grilla").attr("disabled", "disabled");
                $(".nombre_columnas").attr("disabled", "disabled");

                $(".actions_buttons_grid").attr("disabled", "disabled");
                $(".actions_buttons_grid").bootstrapSwitch('disabled', true);

                $(".clone_row").attr("disabled", "disabled");
                $(".activar_numeracion_columnas").attr("disabled", "disabled");
                $(".mostrar_paginacion").attr("disabled", "disabled");
                $(".cantidad_de_registros_por_pagina").attr("disabled", "disabled");
                $(".activar_registros_por_pagina").attr("disabled", "disabled");
                $(".posicionarse_en_la_pagina").attr("disabled", "disabled");
                $(".activar_edicion_en_linea").attr("disabled", "disabled");
                $(".activate_deleteMultipleBtn").attr("disabled", "disabled");
                $(".active_popup").attr("disabled", "disabled");
                $(".active_search").attr("disabled", "disabled");
                $(".button_add").attr("disabled", "disabled");
                $(".active_filter").attr("disabled", "disabled");
                $(".function_filter_and_search").attr("disabled", "disabled");
                $(".ordenar_grilla_por").attr("disabled", "disabled");
                $(".tipo_orden").attr("disabled", "disabled");

                $("input[value='Ver']").prop('disabled', true);
                $("input[value='Editar']").prop('disabled', true);
                $("input[value='Eliminar']").prop('disabled', true);
                $("input[value='Guardar y regresar']").prop('disabled', true);
                $("input[value='Regresar']").prop('disabled', true);
                $("input[value='Personalizado PDF']").prop('disabled', true);

                $("input[value='Ver']").bootstrapSwitch('disabled', true);
                $("input[value='Editar']").bootstrapSwitch('disabled', true);
                $("input[value='Eliminar']").bootstrapSwitch('disabled', true);
                $("input[value='Guardar y regresar']").bootstrapSwitch('disabled', true);
                $("input[value='Regresar']").bootstrapSwitch('disabled', true);
                $("input[value='Personalizado PDF']").bootstrapSwitch('disabled', true);

            } else {
                $(".query").attr("required", "required").removeAttr("disabled");
                $(".query").val("SELECT\n" +
                "nombre as nombre,\n" +
                "apellido as apellido,\n" +
                "categoria as categoria\n" +
                "producto as producto FROM personas");

                $(".mostrar_columnas_grilla").attr("disabled", "disabled");
                $(".mostrar_campos_busqueda").removeAttr("disabled", "disabled");
                $(".mostrar_columna_acciones_grilla").removeAttr("disabled", "disabled");
                $(".mostrar_campos_formulario_editar").removeAttr("disabled", "disabled");
                $(".posicion_botones_accion_grilla").removeAttr("disabled", "disabled");
                $(".refrescar_grilla").removeAttr("disabled", "disabled");
                $(".nombre_columnas").removeAttr("disabled", "disabled");

                $(".actions_buttons_grid").removeAttr("disabled", "disabled");
                $(".actions_buttons_grid").bootstrapSwitch('disabled', false);

                $(".clone_row").removeAttr("disabled", "disabled");
                $(".activar_numeracion_columnas").removeAttr("disabled", "disabled");
                $(".mostrar_paginacion").removeAttr("disabled", "disabled");
                $(".cantidad_de_registros_por_pagina").removeAttr("disabled", "disabled");
                $(".activar_registros_por_pagina").removeAttr("disabled", "disabled");
                $(".posicionarse_en_la_pagina").removeAttr("disabled", "disabled");
                $(".activar_edicion_en_linea").removeAttr("disabled", "disabled");
                $(".activate_deleteMultipleBtn").removeAttr("disabled", "disabled");
                $(".active_popup").removeAttr("disabled", "disabled");
                $(".active_search").removeAttr("disabled", "disabled");
                $(".button_add").removeAttr("disabled", "disabled");
                $(".active_filter").removeAttr("disabled", "disabled");
                $(".function_filter_and_search").removeAttr("disabled", "disabled");
                $(".ordenar_grilla_por").attr("disabled", "disabled");
                $(".tipo_orden").attr("disabled", "disabled");

                $("input[value='Ver']").prop('disabled', false);
                $("input[value='Editar']").prop('disabled', false);
                $("input[value='Eliminar']").prop('disabled', false);
                $("input[value='Guardar y regresar']").prop('disabled', false);
                $("input[value='Regresar']").prop('disabled', false);
                $("input[value='Personalizado PDF']").prop('disabled', false);

                $("input[value='Ver']").bootstrapSwitch('disabled', false);
                $("input[value='Editar']").bootstrapSwitch('disabled', false);
                $("input[value='Eliminar']").bootstrapSwitch('disabled', false);
                $("input[value='Guardar y regresar']").bootstrapSwitch('disabled', false);
                $("input[value='Regresar']").bootstrapSwitch('disabled', false);
                $("input[value='Personalizado PDF']").bootstrapSwitch('disabled', false);
            }
        });
    }

    if(dataAction == "edit"){

        $("form").on("keypress", "input", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                return false;
            }
        });

        $('.tipo_de_filtro').tagsinput({
            allowDuplicates: true
        });

        $(".tabla_anidada").removeClass("d-none");

        $(".regresar_tablas").click(function(){
            $('.leftjoin_tr').remove();
        });

        $("#create-tablas-tab, #create-pdf-tab").click(function(){
            $(".regresar_modulos").click();
        });

        $("#create-modulos-tab, #create-pdf-tab, #config-api-tab").click(function(){
            $('.leftjoin_tr').remove();
            $('.regresar_tablas').click();
        });

        $(".artify-button-add-row").attr("data-action", "edit_row_artify");

        $(".modificar_campo").each(function() {
            $(this).on('change', function() {
                checkInput();
            });
        });

        function checkInput() {
            let hasValue = false; // Variable para verificar si hay algún valor

            // Itera sobre cada campo de entrada
            $(".modificar_campo").each(function() {
                // Comprobar si el campo actual no está vacío
                if ($(this).val().trim() === "Si") {
                    hasValue = true; // Hay al menos un campo que tiene valor
                    return false; // Rompe el bucle each
                }
            });

            // Mostrar u ocultar el botón basado en si hay valores
            if (hasValue) {
                $(".generar_modificacion").removeClass("d-none"); // Mostrar el botón
            } else {
                $(".generar_modificacion").addClass("d-none"); // Ocultar el botón
            }
        }

        $(".artify-cancel-btn").click(function(){
            $("#generateSQL").addClass("d-none");
        });

        //$("#generateSQL").removeClass("d-none");
        $(".eliminar_filas").removeClass("d-none");
        $(".modificar_campo").removeClass("d-none");
        $(".agregar_campo").removeClass("d-none");

        /*$("input[type='text'][name='estructura_tabla#$nombre_campo[]']").each(function() {
            $(this).attr('readonly', true); // Limpia el valor del campo de texto
        });*/

        $("#generateSQL").on("click", function() {
            let sqlStatements = `\n`;
            const rows = document.querySelectorAll(".artify-left-join tbody tr");

            rows.forEach((row) => {
                const nombreCampo = row.querySelector("input[name='estructura_tabla#$campo_anterior[]']").value;
                const nuevoNombreCampo = row.querySelector("input[name='estructura_tabla#$nombre_nuevo_campo[]']").value;
                const tipoCampo = row.querySelector("select[name='estructura_tabla#$tipo[]']").value;
                const caracteres = row.querySelector("input[name='estructura_tabla#$caracteres[]']").value;
                const autoincremental = row.querySelector("select[name='estructura_tabla#$autoincremental[]']").value;
                const indice = row.querySelector("select[name='estructura_tabla#$indice[]']").value;
                const valorNulo = row.querySelector("select[name='estructura_tabla#$valor_nulo[]']").value;

                // Verificar si el checkbox de modificado existe
                let modificado = row.querySelector("select[name='estructura_tabla#$modificar_campo[]']").value;

                if (modificado == "Si") {
                    // Construir el tipo de datos
                    let tipoSQL = "";
                    let valorSQL = "";
                    if (tipoCampo === "Caracteres") {
                        tipoSQL += `VARCHAR(${caracteres})`;
                    }

                    if (tipoCampo === "Entero") {
                        tipoSQL += `INT(${caracteres})`;
                    }

                    if (tipoCampo === "Fecha") {
                        tipoSQL += `DATE`;
                    }

                    if (tipoCampo === "Texto") {
                        tipoSQL += `TEXT`;
                    }

                    if (tipoCampo === "Hora") {
                        tipoSQL += `TIME`;
                    }

                    if (valorNulo === "No") {
                        valorSQL += `NOT NULL`;
                    } else {
                        valorSQL += `NULL`;
                    }

                    let alterSQL = "";
                    // Verificar si es autoincremental
                    if (autoincremental === "Si" && indice === "Primario" && valorNulo === "No") {
                        alterSQL += "MODIFY "+ nombreCampo + " " + tipoSQL +" NOT NULL; \n" +
                        "DROP PRIMARY KEY; \n" +
                        "CHANGE " + nombreCampo + " " + nuevoNombreCampo + " " + tipoSQL + " NOT NULL; \n" +
                        "MODIFY " + nuevoNombreCampo + " " + tipoSQL + " AUTO_INCREMENT PRIMARY KEY NOT NULL;";
                    } else {
                        // Construir la columna
                        alterSQL = `CHANGE ${nombreCampo} ${nuevoNombreCampo} ${tipoSQL} ${valorSQL}`;
                    }

                    // Añadir esta consulta al resultado final
                    sqlStatements += alterSQL + ",\n";
                }
            });

            // Remover la última coma y salto de línea si hay campos modificados
            if (sqlStatements.trim().length > 0) {
                sqlStatements = sqlStatements.trim().slice(0, -1);
            }

            // Colocar el resultado en el textarea
            document.querySelector(".modificar_tabla").value = sqlStatements;

            $("input[type='text'][name='estructura_tabla#$nombre_nuevo_campo[]']").each(function() {
                $(this).val(''); // Limpia el valor del campo de texto
            });
            $(".modificar_campo").val("");
        });

        $(".artify-actions.btn.btn-danger.eliminar_filas").first().remove();
        
        $(".nombre_tabla").attr("readonly", true);

        $("#create-tablas-tab, #create-pdf-tab").click(function(){
            $(".regresar_modulos").click();
        });


        let tabla = $(".nombre_tabla").val();

        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>Home/obtener_columnas_tabla",
            dataType: 'json',
            data: {
                tabla: tabla
            },
            beforeSend: function() {
                $("#artify-ajax-loader").show();
            },
            success: function(data){
                $("#artify-ajax-loader").hide();

                $(".campo_anterior").each(function(index) {
                    // If there are enough data items, set the value
                    if (data["columnas_tablas"][index]) {
                        $(this).attr('readonly', true);
                        $(this).val(data["columnas_tablas"][index]);
                    } else {
                        // Clear the field if no corresponding data is available
                        $(this).val('');
                    }
                });
            }
        });

        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>Home/obtener_tabla_id",
            dataType: "json",
            data: {
                dataId: dataId
            },
            beforeSend: function() {
                $("#artify-ajax-loader").show();
            },
            success: function(data){
                $("#artify-ajax-loader").hide();
                
                if (data && data.modulos && data.modulos.length > 0) {
                    // Agregar la opción seleccionada al select
                    $(".tabla").append(`
                        <option selected value="${data.modulos[0].tabla}">${data.modulos[0].tabla}</option>
                    `);
                    
                    // Actualizar select2 para que reconozca los nuevos valores
                    $(".tabla").trigger('change'); 
                } else {
                    console.warn("No se encontraron módulos válidos en la respuesta.");
                }
            }
        });

        if (!$(".tabla").hasClass("select2-hidden-accessible")) {
            $(".tabla").select2();
        }

        var template_fields = $(".template_fields").val();

        if(template_fields == "Si"){
            $(".cantidad_campos_a_mostrar_plantilla_html").removeAttr("disabled", "disabled");
        } else {
            $(".cantidad_campos_a_mostrar_plantilla_html").attr("disabled", "disabled");
        }

        $(".template_fields").change(function() {
            var template_fields = $(this).val();

            if(template_fields == "Si"){
                $(".cantidad_campos_a_mostrar_plantilla_html").removeAttr("disabled", "disabled");
            } else {
                $(".cantidad_campos_a_mostrar_plantilla_html").attr("disabled", "disabled");
            }
        });

        var val = $(".activar_recaptcha").val();

        if(val == "Si"){
            $(".sitekey_recaptcha").removeAttr("disabled", "disabled");
            $(".sitesecret_repatcha").removeAttr("disabled", "disabled");
        } else {
            $(".sitekey_recaptcha").attr("disabled", "disabled");
            $(".sitesecret_repatcha").attr("disabled", "disabled");
        }

        $(".activar_recaptcha").change(function() {
            var val = $(this).val();

            if(val == "Si"){
                $(".sitekey_recaptcha").removeAttr("disabled", "disabled");
                $(".sitesecret_repatcha").removeAttr("disabled", "disabled");
            } else {
                $(".sitekey_recaptcha").attr("disabled", "disabled");
                $(".sitesecret_repatcha").attr("disabled", "disabled");
            }
        });

        $(".titulo_modulo").text("Editar");
        $('.siguiente_1').click(function() {
            $('#pdf-tab').tab('show');
        });

        $('.siguiente_2').click(function() {
            $('#Api-tab').tab('show');
        });

        $('.anterior').click(function() {
            $('#modulos-tab').tab('show');
        });

        $('.atras').click(function() {
            $('#pdf-tab').tab('show');
        });

        $(".modificar_tabla_col").show();

        var val = $(".crud_type").val();

        if (val == "CRUD") {
            $(".query").removeAttr("required").attr("disabled", "disabled");
        } else if (val == "Modulo de Inventario") {
            $(".query").removeAttr("required").attr("disabled", "disabled");
            $(".tabla").val("Inventario");
            $(".name_view").val("Inventario");
            $(".controller_name").val("Inventario");
        } else {
            $(".id_tabla").removeAttr("disabled").attr("required", "required").val("");
            $(".query").attr("required", "required").removeAttr("disabled");
        }
    }

    if(dataAction == "delete"){
        refrechMenu();
    }
});


function refrechMenu(){
	$.ajax({
		type: "POST",
		url: "<?=$_ENV["BASE_URL"]?>home/refrescarMenu",
		dataType: "json",
		success: function(response){
            console.log(response);
			$('.menu_generator').html(response);
		}
	});
}

$(document).on("artify_after_submission", function(event, obj, data){
    let json = JSON.parse(data);

    if(json.message){
        refrechMenu();
        Swal.fire({
            title: "Genial!",
            text: json.message,
            icon: "success",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Guardado con éxito!",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
                $('.artify-back').click();
            }
        });
    }
});

function construirFrase() {
    $('.artify-left-join').on("change", ".nombre, .tipo_de_campo, .nulo, .indice, .autoincrementable, .longitud", function() {
        var $row = $(this).closest('tr');
        
        // Obtener valores de los campos de la fila actual
        var campo1 = $row.find('.nombre').val().trim();
        var campo2 = $row.find('.tipo_de_campo').val().trim();
        var campo3 = $row.find('.nulo').val().trim();
        var campo4 = $row.find('.indice').val().trim();
        var campo5 = $row.find('.autoincrementable').val().trim();
        var campo6 = $row.find('.longitud').val().trim();

        // Convertir valores según reglas definidas
        if (campo2 === "Entero") {
            campo2 = campo6 ? `INT(${campo6})` : "INT";
            campo6 = ""; // Si es numérico, el campo6 no se usa
        } else if (campo2 === "Caracteres") {
            campo2 = `VARCHAR(${campo6})`; // Si es caracteres, usar VARCHAR con el valor de campo6
        }

        if (campo2 == "Caracteres") {
            campo2 = "VARCHAR()";
        }

        if (campo2 == "Texto") {
            campo2 = "TEXT";
        }

        if(campo2 == "Número Decimal"){
            campo2 = "DECIMAL";
        }

        if (campo2 == "Fecha") {
            campo2 = "DATE";
        }

        if (campo2 == "Hora") {
            campo2 = "TIME";
        }

        if(campo2 == "Booleano"){
            campo2 = "BOOLEAN";
        }

        if (campo3 == "Si") {
            campo3 = "NULL";
        } else {
            campo3 = "NOT NULL";
        }

        if (campo4 == "Primario") {
            campo4 = "PRIMARY KEY";
        } else {
            campo4 = "";
        }

        if (campo5 == "Si") {
            campo5 = "AUTO_INCREMENT";
        } else {
            campo5 = "";
        }

        // Construir la nueva frase
        var nuevaFrase = `${campo1} ${campo2} ${campo4} ${campo3} ${campo5} `.trim();

        // Obtener el contenido actual del textarea
        var currentContent = $('.query_tabla').val();

        // Dividir el contenido en líneas y eliminar duplicados
        var frases = currentContent.split('\n').map(f => f.trim());
        var frasesUnicas = new Map();

        // Añadir las frases únicas a un Map usando el campo1 como clave para evitar duplicados
        frases.forEach(frase => {
            if (frase.length > 0) {
                var key = frase.split(' ')[0]; // Usar el primer campo como clave para evitar duplicados
                frasesUnicas.set(key, frase);
            }
        });

        // Obtener la última frase del textarea
        var ultimaFrase = Array.from(frasesUnicas.values()).pop();

        // Si la última frase no termina con una coma, agregarla
        if (ultimaFrase && !ultimaFrase.endsWith(',')) {
            ultimaFrase += ',';
            frasesUnicas.set(ultimaFrase.split(' ')[0], ultimaFrase); // Actualizar el Map con la última frase modificada
        }

        // Agregar la nueva frase al Map
        if (nuevaFrase.length > 0) {
            var key = nuevaFrase.split(' ')[0]; // Usar el primer campo como clave
            frasesUnicas.set(key, nuevaFrase);
        }

        // Convertir el Map de vuelta a una cadena de texto
        var nuevasFrases = Array.from(frasesUnicas.values()).join('\n');

        // Actualizar el textarea con las frases únicas
        $('.query_tabla').val(nuevasFrases);
        
    });
}

</script>
<?php require 'layouts/footer.php'; ?>