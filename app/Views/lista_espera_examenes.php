<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=$_ENV["BASE_URL"]?>css/flatpickr.min.css">
<link rel="stylesheet" href="<?=$_ENV["BASE_URL"]?>app/libs/script/plugins/datatable/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .page-title.clearfix.card-header.pdocrud-table-heading, .row.pdocrud-options-files {
        display: none;
    }
    .pdocrud-search {
        display: none!important;
    }
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">
				<div class="row mb-3">
				</div>
				<h5>Búsqueda Lista Espera Exámenes</h5>
				<hr>

				<div class="examenes">
					<?=$render?>
                    <?=$mask;?>
				</div>

                <div class="datos_search p-3"></div>
                <div class="resultados">
                    <div class='table-responsive'>
                        <?=$render_crud;?>
                    </div>
                </div>

                <div class="cargar_modal"></div>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
	<img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
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
}

$(document).ready(function(){

    datatable();

    $(".fecha_solicitud").flatpickr({
        dateFormat: "Y-m-d",
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
});


$(document).on("click", ".buscar", function(){
    let run = $('.rut').val();
    let nombre_paciente = $('.nombre_paciente').val();
    let estado = $('.estado').val();
    let prestacion = $('.prestacion').val();
    let profesional = $('.profesional').val();
    let fecha_solicitud = $('.fecha_solicitud').val();

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/buscar_examenes",
        dataType: "html",
        data: {
            run: run,
            nombre_paciente: nombre_paciente,
            estado: estado,
            prestacion: prestacion,
            profesional: profesional,
            fecha_solicitud: fecha_solicitud
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            $("#pdocrud-ajax-loader").hide();
            $('.resultados').html(data);
            datatable();
        }
    });

});

$(document).on("click", ".limpiar_filtro", function(){
    $('.rut').val("");
    $('.nombre_paciente').val("");
    $('.estado').val("");
    $('.prestacion').val("");
    $('.profesional').val("");
    $('.fecha_solicitud').val("");
    $('.buscar').click();
    $('.cargar_modal').empty();
});


$(document).on("click", ".egresar_solicitud", function(){
    let id = $(this).data('id');
    let fecha_solicitud = $(this).data('fechasolicitud');

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/cargar_modal_egresar_solicitud",
        dataType: "html",
        data: {
            id: id,
            fecha_solicitud: fecha_solicitud
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            $("#pdocrud-ajax-loader").hide();
            $('.cargar_modal').html(data);
            $('#egresar_solicitud').modal('show');

            $(".fecha_egreso").flatpickr({
                dateFormat: "d-m-Y",
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

        }
    });
});

$(document).on("click", ".procedimientos", function(){
    let id = $(this).data('id');
    let fecha_solicitud = $(this).data('fechasolicitud');

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/cargar_modal_procedimientos",
        dataType: "html",
        data: {
            id: id,
            fecha_solicitud: fecha_solicitud
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            $("#pdocrud-ajax-loader").hide();
            $('.cargar_modal').html(data);
            $('#procedimientos').modal('show');

            $(".fecha").flatpickr({
                dateFormat: "Y-m-d",
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
        }
    });
});


$(document).on("click", ".agregar_notas", function(){
    let id = $(this).data('id');
    let fecha_solicitud = $(this).data('fechasolicitud');

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/cargar_modal_agregar_nota",
        dataType: "html",
        data: {
            id: id,
            fecha_solicitud: fecha_solicitud
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            $("#pdocrud-ajax-loader").hide();
            $('.cargar_modal').html(data);
            $('#agregar_nota').modal('show');
        }
    });
});

$(document).on("click", ".ver_logs", function(){
    let id = $(this).data('id');
    let fecha_solicitud = $(this).data('fechasolicitud');

    $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/cargar_modal_logs",
        dataType: "html",
        data: {
            id: id,
            fecha_solicitud: fecha_solicitud
        },
        beforeSend: function() {
            $("#pdocrud-ajax-loader").show();
        },
        success: function(data){
            $("#pdocrud-ajax-loader").hide();
            $('.cargar_modal').html(data);
            $('#logs').modal('show');
        }
    });
});

$(document).on('click', '.imprimir_solicitud', function () {
    let id = $(this).data('id');
    let fecha_solicitud = $(this).data('fechasolicitud');
    window.open("<?=$_ENV["BASE_URL"]?>home/imprimir_solicitud/id/" + id + "/fecha_solicitud/" + fecha_solicitud);
});

$(document).on("pdocrud_before_ajax_action", function(event, obj, data){
    $('.titulo_modal').html(`
        <i class="fa fa-file-o"></i> Agregar Nota
    `);
});

$(document).on("pdocrud_after_submission", function(event, obj, data){
    let json = JSON.parse(data);

    if(json.message){
        //$('#pdocrud_search_btn').click();
        $('#procedimientos').modal('hide');
        $('#egresar_solicitud').modal('hide');
        $('#agregar_nota').modal('hide');
    
        Swal.fire({
            title: 'Genial!',
            text: json.message,
            icon: 'success',
            confirmButtonText: 'Aceptar',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed) {
                $('.limpiar_filtro').click();
            }
        });
    }

});
</script>
<?php require 'layouts/footer.php'; ?>