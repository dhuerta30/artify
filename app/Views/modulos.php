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

.form-control {
    min-width: 200px;
}

label:not(.form-check-label):not(.custom-file-label) {
    display: flex;
}

.bootstrap-switch.bootstrap-switch-focused {
    border-color: #ccc!important;
    box-shadow: none!important;
}

label.checkbox-inline {
    margin-bottom: 50px;
    margin-top: 25px;
}

.bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary {
    color: white!important;
    background: green!important;
}

.bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-default, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-default {
    color: white!important;
    background: red!important;
}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">
				<?=$render?>
                <?=$switch?>
                <br>
                <?=$render_modulos?>
                <br>
                <?=$render_conf?>
				<div class="emergente"></div>
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

$(document).on("artify_after_ajax_action",function(event, obj, data){
    var dataAction = obj.getAttribute('data-action');

    if(dataAction == "add"){

        $(".active_filter").change(function(){
            let valor = $(this).val();

            if(valor == "Si"){
                $(".mostrar_campos_filtro").removeAttr("disabled", "disabled");
            } else {
                $(".mostrar_campos_filtro").attr("disabled", "disabled");
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
                        $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro").empty().append(`<option value>Seleccionar</option>`);
                        
                        // Añadir nuevas opciones desde el resultado del ajax
                        $.each(data["columnas_tablas"], function(index, obj){
                            $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro").append(`
                                <option value="${obj}">${obj}</option>
                            `);
                        });

                        // Inicializar select2 en los nuevos elementos
                        $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro").select2();

                    } else {
                        // Limpiar los campos si val está vacío y añadir la opción "Seleccionar"
                        $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro").empty().append(`<option value>Seleccionar</option>`);
                        
                        // Vaciar el valor de id_tabla
                        $(".id_tabla").val("");

                        $(".name_view").val("");

                        $(".controller_name").val("");

                        // Inicializar select2 en los nuevos elementos
                        $(".mostrar_campos_busqueda, .mostrar_campos_formulario, .mostrar_columnas_grilla, .mostrar_campos_filtro").select2();
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

        $(".query_tabla").val("id_personas INT(11) AUTO_INCREMENT PRIMARY KEY,\n" +
                "nombre VARCHAR(255) NOT NULL,\n" +
                "apellido VARCHAR(255) NOT NULL,\n" +
                "categoria INT(11) NOT NULL,\n" +
                "producto VARCHAR(100) NOT NULL");

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

        $(".activate_api").change(function() {
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
        });

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
            } else if (val == "Modulo de Inventario") {
                $(".id_tabla").attr("disabled", "disabled").removeAttr("required").val("");
                $(".tabla").val("Inventario");
                $(".name_view").val("Inventario");
                $(".controller_name").val("Inventario");
            } else {
                $(".query").attr("required", "required").removeAttr("disabled");
                $(".query").val("SELECT\n" +
                "nombre as nombre,\n" +
                "apellido as apellido,\n" +
                "categoria as categoria\n" +
                "producto as producto FROM personas");
            }
        });
    }

    if(dataAction == "edit"){

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

/*function construirFrase() {
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
        if (campo2 === "Numerico") {
            campo2 = campo6 ? `INT(${campo6})` : "INT";
            campo6 = ""; // Si es numérico, el campo6 no se usa
        } else if (campo2 === "Caracteres") {
            campo2 = `VARCHAR(${campo6})`; // Si es caracteres, usar VARCHAR con el valor de campo6
        }

        if (campo2 == "Caracteres") {
            campo2 = "VARCHAR()";
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
        var currentContent = $('.columns_table').val();

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
        $('.columns_table').val(nuevasFrases);
        
    });
}


construirFrase();*/

</script>
<?php require 'layouts/footer.php'; ?>