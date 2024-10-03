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

.pdocrud_leftjoin_row_1 {
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
                <?=$render_conf?>
				<div class="emergente"></div>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>

$(document).on("change", ".generar_jwt_token", function() {
    var val = $(this).val();

    if(val == "Si"){
        $(".autenticar_jwt_token").removeAttr("disabled", "disabled");
        $(".generar_token_api").removeClass("d-none");
    } else {
        $(".generar_token_api").addClass("d-none");
        $(".autenticar_jwt_token").attr("disabled", "disabled");
        $(".autenticar_jwt_token").val("");
    }
});

$(document).on("click", ".generar_token_api", function(){
    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>Home/generarToken",
        dataType: 'json',
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            $("#pdocrud-ajax-loader").hide();
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

$(document).on("pdocrud_after_ajax_action",function(event, obj, data){
    var dataAction = obj.getAttribute('data-action');

    if(dataAction == "add"){

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
                $(".id_tabla").attr("disabled", "disabled").removeAttr("required").val("");
                $(".query").removeAttr("required").attr("disabled", "disabled");
                $(".columns_table").val("id INT(11) AUTO_INCREMENT PRIMARY KEY,\n" +
                "nombre VARCHAR(255) NOT NULL,\n" +
                "apellido VARCHAR(255) NOT NULL,\n" +
                "categoria INT(11) NOT NULL,\n" +
                "producto VARCHAR(100) NOT NULL");
                $(".tabla").val("personas");
                $(".name_view").val("personas");
                $(".controller_name").val("Personas");
            } else if (val == "Modulo de Inventario") {
                $(".id_tabla").attr("disabled", "disabled").removeAttr("required").val("");
                $(".query").removeAttr("required").attr("disabled", "disabled");
                $(".columns_table").val('id_inventario INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,\n' +
                'nombre_producto VARCHAR(255) NOT NULL,\n' +
                'tipo VARCHAR(200) NOT NULL,\n' +
                'cantidad VARCHAR(100) NOT NULL,\n' +
                'cantidad_vendida VARCHAR(100) NOT NULL,\n' +
                'nuevos_ingresos VARCHAR(100) NOT NULL,\n' +
                'stock_actual VARCHAR(100) NOT NULL,\n' +
                'ubicacion VARCHAR(255) DEFAULT NULL,\n' +
                'precio INT(11) NOT NULL,\n' +
                'observacion TEXT');

                $(".tabla").val("Inventario");
                $(".name_view").val("Inventario");
                $(".controller_name").val("Inventario");
            } else {
                $(".id_tabla").removeAttr("disabled").attr("required", "required").val("");
                $(".query").attr("required", "required").removeAttr("disabled");
                $(".columns_table").val("");
                $(".tabla").val("");
                $(".name_view").val("");
                $(".controller_name").val("");
            }
        });
    }

    if(dataAction == "edit"){
        $(".columns_table").attr("disabled", "disabled").removeAttr("required");
        $(".tabla").attr("readonly", "true");
        $(".controller_name").attr("readonly", "true");
        $(".modificar_tabla_col").show();

        var tabla = $(".tabla").val();
        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>Home/obtenerTablaActual",
            data: {
                tabla: tabla
            },
            dataType: "json",
            success: function(data){
                console.log(data);
                $.each(data["columnas_tabla"], function(index, obj) {
                    // Acceder al nombre del campo y su tipo
                    var campo = obj.Field;
                    var tipo = obj.Type;

                    $(".vista_previa_campos_tabla").append(`
                        <li class="list-group-item bg-light">${campo}: ${tipo}</li>
                    `);
                });
            }
        });

        var val = $(".crud_type").val();

        if (val == "CRUD") {
            $(".id_tabla").attr("disabled", "disabled").removeAttr("required").val("");
            $(".query").removeAttr("required").attr("disabled", "disabled");
            $(".columns_table").val("id INT(11) AUTO_INCREMENT PRIMARY KEY,\n" +
            "nombre VARCHAR(255) NOT NULL,\n" +
            "apellido VARCHAR(255) NOT NULL,\n" +
            "categoria INT(11) NOT NULL,\n" +
            "producto VARCHAR(100) NOT NULL");
            $(".tabla").val("personas");
            $(".name_view").val("personas");
            $(".controller_name").val("Personas");
        } else if (val == "Modulo de Inventario") {
            $(".id_tabla").attr("disabled", "disabled").removeAttr("required").val("");
            $(".query").removeAttr("required").attr("disabled", "disabled");
            $(".columns_table").val('id_inventario INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,\n' +
            'nombre_producto VARCHAR(255) NOT NULL,\n' +
            'tipo VARCHAR(200) NOT NULL,\n' +
            'cantidad VARCHAR(100) NOT NULL,\n' +
            'cantidad_vendida VARCHAR(100) NOT NULL,\n' +
            'nuevos_ingresos VARCHAR(100) NOT NULL,\n' +
            'stock_actual VARCHAR(100) NOT NULL,\n' +
            'ubicacion VARCHAR(255) DEFAULT NULL,\n' +
            'precio INT(11) NOT NULL,\n' +
            'observacion TEXT');

            $(".tabla").val("Inventario");
            $(".name_view").val("Inventario");
            $(".controller_name").val("Inventario");
        } else {
            $(".id_tabla").removeAttr("disabled").attr("required", "required").val("");
            $(".query").attr("required", "required").removeAttr("disabled");
            $(".columns_table").val("");
            $(".tabla").val("");
            $(".name_view").val("");
            $(".controller_name").val("");
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

$(document).on("pdocrud_after_submission", function(event, obj, data){
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
                $('.pdocrud-back').click();
            }
        });
    }
});

/*function construirFrase() {
    $('.pdocrud-left-join').on("change", ".nombre, .tipo_de_campo, .nulo, .indice, .autoincrementable, .longitud", function() {
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