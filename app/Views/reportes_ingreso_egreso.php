<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link rel="stylesheet" href="<?=$_ENV["BASE_URL"]?>app/libs/script/plugins/datatable/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .page-title.clearfix.card-header.pdocrud-table-heading, .row.pdocrud-options-files {
        display: none;
    }

    .select2-container .select2-selection--single {
        height: 38px!important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px!important;
    }

    table.dataTable {
        white-space: nowrap;
    }
</style>
<link rel="stylesheet" href="<?=$_ENV["BASE_URL"]?>css/flatpickr.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="card mt-4">
            <div class="card-body">

                <div class="row procedimiento">
                    <div class="col-md-12">
                        <h5>Buscar Reportes Por Ingreso o Egreso</h5>
                        <hr>

                        <?=$render?>
                        <?=$mask?>

                       <div class="reportes">
                        <?=$grilla_ingreso_egreso?>
                       </div>
                       
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/flatpickr.js"></script>
<script src="<?=$_ENV["BASE_URL"]?>app/libs/script/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
function datatable(){
    $('.tabla_reportes').DataTable({
        searching: false,
        scrollX: true,
        paging: ($('.tabla_reportes tbody tr').length > 10) ? true : false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
                className: 'btn btn-light',
                filename: function(){
                    return 'reportes';
                },
                exportOptions: {
                    columns: [0, 1, 2, 3] // Define las columnas a exportar
                }
            }
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
}
$(document).ready(function(){
    datatable();
});

$(document).on("click", ".btn_search", function(){
    let rut = $('#rut').val();
    let estado = $('#estado').val();

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/buscar_por_rut_o_estado",
        dataType: "json",
        data: {
            rut: rut,
            estado: estado
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){   
            $("#pdocrud-ajax-loader").hide();
            console.log(data);
            if(data['render']){
                $('.reportes').html("<div class='table-responsive'>"+ data['render'] +"</div>");
                datatable();
                $('.btn_limpiar').removeClass('d-none');
            }
        }
    });
});

$(document).on("click", ".btn_limpiar", function(){
    $('#rut').val("");
    $('.estado').val("0");
    $('.btn_limpiar').addClass('d-none');
});
</script>
<?php require 'layouts/footer.php'; ?>