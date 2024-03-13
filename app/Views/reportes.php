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
                        <h5>Buscar Reportes por Año</h5>
                        <hr>

                        <?=$render?>
                        <?=$mask?>
                        <?=$select2?>

                        <div class="error"></div>
                       <div class="reportes">
                        <?=$render_crud;?>
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
$(document).ready(function(){
    $('.tabla_reportes').DataTable({
        searching: false,
        scrollX: true,
        paging: ($('.tabla_reportes tbody tr').length > 10) ? true : false,
        order: [[0, 'desc']],
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] // Define las columnas a exportar
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
});
$(document).on("click", ".btn_search", function(){
    let ano_desde = $('#ano_desde').val();
    let ano_hasta = $('#ano_hasta').val();

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/buscar_por_ano",
        dataType: "json",
        data: {
            ano_desde: ano_desde,
            ano_hasta: ano_hasta
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            if(data['render']){
                $("#pdocrud-ajax-loader").hide();
                $('.reportes').html("<div class='table-responsive'>"+ data['render'] +"</div>");
                $('.tabla_reportes').DataTable({
                    searching: false,
                    scrollX: true,
                    paging: ($('.tabla_reportes tbody tr').length > 10) ? true : false,
                    order: [[0, 'desc']],
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
                $('.btn_limpiar').removeClass('d-none');
                $('.error').empty();
            } else {
                $("#pdocrud-ajax-loader").hide();
                $('.error').html("<div class='alert alert-danger text-center'>"+ data['error'] +"</div>");
            }
        }
    });
});

$("#fecha").flatpickr({
    allowInput: true,
    //defaultDate: new Date(),
    locale: {
        firstDayOfWeek: 1, // Lunes como primer día de la semana
        weekdays: {
            shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            longhand: [
                'Domingo',
                'Lunes',
                'Martes',
                'Miércoles',
                'Jueves',
                'Viernes',
                'Sábado'
            ]
        },
        months: {
            shorthand: [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Ago',
                'Sep',
                'Oct',
                'Nov',
                'Dic'
            ],
            longhand: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ]
        }
    }
});

function ComboAno() {
   var n = (new Date()).getFullYear();
   var selectDesde = document.getElementById("ano_desde");
   var selectHasta = document.getElementById("ano_hasta");

   for (var i = n; i >= 1900; i--) {
      selectDesde.options.add(new Option(i, i));
      selectHasta.options.add(new Option(i, i));
   }
}

window.onload = ComboAno;

$(document).on("click", ".btn_limpiar", function(){
    $('#rut').val("");
    $('.ano_desde').select2('destroy');
    $('.ano_desde').val("");
    $('.ano_desde').select2();
    $('.ano_desde').html('<option>Seleccionar Año Desde</option>');

    $('.ano_hasta').select2('destroy');
    $('.ano_hasta').val("");
    $('.ano_hasta').select2();
    $('.ano_hasta').html('<option>Seleccionar Año Hasta</option>');
    ComboAno();
    $('.btn_limpiar').addClass('d-none');
    $('.error').empty();
});

$(document).on("click", ".btn_search", function(){
    $('.btn_limpiar').addClass('d-none');
});
</script>
<?php require 'layouts/footer.php'; ?>