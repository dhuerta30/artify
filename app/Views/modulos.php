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
    refrechMenu();
    $('.label_Visibilidad_filtro').hide();
    $('.data_visibilidad_filtro').hide();
    $('.data_visibilidad_filtro').attr('required', false);
    $('.pdocrud-button-url').removeClass('pdocrud-actions');
});

$(document).on("change", ".crud_type", function(){
    let val = $(this).val();
    if(val == "CRUD"){
        $(".id_tabla").attr("disabled", "disabled");
        $(".id_tabla").removeAttr("required");
        $(".query").removeAttr("required");
        $(".query").attr("disabled", "disabled");
    } else {
        $(".id_tabla").removeAttr("disabled");
        $(".id_tabla").attr("required", "required");
        $(".query").attr("required", "required");
        $(".query").removeAttr("disabled");
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
        $('.pdocrud-button-url').removeClass('pdocrud-actions');
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

$(document).ready(function() {
    // Función para construir la consulta SQL
    function buildQuery() {
        var query = "SELECT ";
        var columns = [];
        
        $("#table-body tr").each(function() {
            var $row = $(this);
            var columnName = $row.find('input[name="campo_nombre[]"]').val();
            var columnType = $row.find('select[name="campo_tipo[]"]').val();
            var columnEmpty = $row.find('select[name="campo_valor_vacio[]"]').val();
            var columnIndex = $row.find('select[name="campo_indice[]"]').val();
            var columnAutoIncrement = $row.find('select[name="campo_autoincrementable[]"]').val();
            var columnLength = $row.find('input[name="campo_caracteres[]"]').val();

            if (columnName) {
                var columnDefinition = columnName;

                if (columnType) {
                    columnDefinition += " " + columnType;
                }

                if (columnEmpty === "Si") {
                    columnDefinition += " NULL";
                }

                if (columnIndex === "Primario") {
                    columnDefinition += " PRIMARY KEY";
                }

                if (columnAutoIncrement === "Si") {
                    columnDefinition += " AUTO_INCREMENT";
                }

                if (columnLength) {
                    columnDefinition += "(" + columnLength + ")";
                }

                columns.push(columnDefinition);
            }
        });

        query += columns.join(", ");
        query += " FROM table_name"; // Cambia 'table_name' por el nombre real de tu tabla

        $(".query").val(query);
    }

    // Llama a buildQuery cuando cambie el contenido de los campos de entrada
    $("#table-body").on('input change', 'input[name="campo_nombre[]"], select[name="campo_tipo[]"], select[name="campo_valor_vacio[]"], select[name="campo_indice[]"], select[name="campo_autoincrementable[]"], input[name="campo_caracteres[]"]', buildQuery);

    // Función para agregar una fila
    $("#add-row").click(function() {
        var newRow = `
            <tr>
                <td><input type="text" class="form-control" name="campo_nombre[]"></td>
                <td><select class="form-control" name="campo_tipo[]">
                    <option value="">Seleccionar</option>
                    <option value="Numerico">Numerico</option>
                    <option value="Imagen">Imagen</option>
                    <!-- Otros valores -->
                </select></td>
                <td><select class="form-control" name="campo_valor_vacio[]">
                    <option value="">Seleccionar</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select></td>
                <td><select class="form-control" name="campo_indice[]">
                    <option value="">Seleccionar</option>
                    <option value="Primario">Primario</option>
                    <option value="Sin Indice">Sin Indice</option>
                </select></td>
                <td><select class="form-control" name="campo_autoincrementable[]">
                    <option value="">Seleccionar</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select></td>
                <td><input type="text" class="form-control" name="campo_caracteres[]"></td>
                <td><a href="javascript:;" class="pdocrud-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> Remover</a></td>
            </tr>
        `;
        $("#table-body").append(newRow);
        buildQuery(); // Actualiza la consulta después de agregar una fila
    });

    // Función para eliminar una fila
    $(document).on('click', '[data-action="delete_row"]', function() {
        $(this).closest('tr').remove();
        buildQuery(); // Actualiza la consulta después de eliminar una fila
    });

    // Inicializar la consulta al cargar la página
    buildQuery();
});


</script>
<?php require 'layouts/footer.php'; ?>