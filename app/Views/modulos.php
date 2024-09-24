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

.form-control {
    min-width: 200px;
}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">
				<?=$render?>
				<div class="emergente"></div>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>
$(document).on("pdocrud_after_ajax_action",function(event, obj, data){
    //refrechMenu();
    var dataAction = obj.getAttribute('data-action');

    if(dataAction == "add"){

        $(".modificar_tabla_col").hide();

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
        $(".columns_table").attr("disabled", "disabled");
        $(".tabla").attr("readonly", "true");
        $(".controller_name").attr("readonly", "true");
        $(".modificar_tabla_col").show();
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