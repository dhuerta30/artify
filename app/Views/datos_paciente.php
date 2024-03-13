<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=$_ENV["BASE_URL"]?>css/flatpickr.min.css">
<style>
    .chosen-container {
        width: 100% !important;
    }

    .ui-autocomplete {
        position: absolute !important;
        max-height: 400px; /* ajusta la altura máxima según sea necesario */
        max-width: 338px;
        overflow-x: auto; /* permite el desplazamiento vertical si hay demasiados elementos */
    }

    .ui-menu-item {
        font-size: 14px;
    }

    .ui-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    ul#sugerencias-lista {
        position: absolute;
        z-index: 200;
        width: 100%;
    }

    .select2-container .select2-selection--single {
        height: 38px!important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 7px!important;
    }

    .select2-container {
        width: 90%!important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-12">
                        <h5>Formulario de Solicitud de Exámen</h5>
                        <hr>
                        <h5 class="bg-default border w-lg-25 w-md-100 p-2 text-center bg-light">Datos Paciente</h5>
                        <?=$render;?>
                        <?=$mask;?>

                        <div class="resultado_datos_paciente hide"></div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h5 class="bg-default border w-lg-50 w-md-100 p-2 text-center bg-light">Diagnóstico y antecedentes clínicos del paciente</h5>
                        <?=$render2;?>
                        <?=$chosen;?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h5 class="bg-default border w-lg-25 w-md-100 p-2 text-center bg-light">Detalle de Solicitud</h5>
                        <div class="agregar_detalle">
                            <?=$render4;?>
                        </div>

                        <div class="result_solicitud">
                            <?=$render3;?>
                            <?=$chosen2;?>
                            <?=$chosen3;?>
                        </div>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="javascript:;" class="btn btn-primary btn-sm guardar"><i class="fa fa-save"></i> Guardar</a>
                    </div>
                </div>

                <div class="cargar_modal"></div>

            </div>
        </div>
    </section>
</div>
<div id="pdocrud-ajax-loader">
    <img  width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script src="<?=$_ENV["BASE_URL"]?>js/flatpickr.js"></script>
<script>
        $(document).ready(function(){
           
            $(document).on('click', '.eliminar_dato', function() {
                var index = $(this).data('id');

                Swal.fire({
                    title: "Estas seguro de querer eliminar este Dato?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si!",
                    cancelButtonText: "No"
                    }).then((result) => {
                    if (result.isConfirmed) {

                        $(this).closest('.pdocrud-data-row').remove();

                        // Contar las filas restantes
                        var filasRestantes = $('.table.pdocrud-table tbody .pdocrud-data-row').length;

                        // Comprobar si no hay filas restantes
                        if (filasRestantes == 0) {
                            $('.table.pdocrud-table tbody').prepend(`
                                <tr class="pdocrud-data-row">
                                    <td class="pdocrud-row-count text-center no-sort" colspan="100%">
                                        No se han ingresado Datos                    
                                    </td>
                                </tr>
                            `);
                        }

                    }
                });

            });

            $('.direccion').after(`
                <div class="sugerencias-container">
                    <ul id="sugerencias-lista" class="list-group"></ul>
                </div>
            `);

            $('.pdocrud_help_block').remove();

            var inputDireccion = $('#ZGF0b3NfcGFjaWVudGUjJGRpcmVjY2lvbkAzZHNmc2RmKio5OTM0MzI0');
            var listaSugerencias = $('#sugerencias-lista');

            inputDireccion.on('input', function() {
                var searchText = $(this).val();

                if (searchText.length >= 3) {
                $.ajax({
                    url: 'https://api.geoapify.com/v1/geocode/autocomplete',
                    method: 'GET',
                    data: {
                    text: searchText,
                    apiKey: 'e7349d1f5d4945df95f4e8a6d05b7fe7'
                    },
                    success: function(result) {
                    // Limpia la lista de sugerencias
                    listaSugerencias.empty();

                        if (result.features && result.features.length > 0) {
                            // Agrega cada sugerencia a la lista desplegable
                            result.features.forEach(function(feature) {
                            var suggestedAddress = feature.properties.formatted;
                            var listItem = $('<li class="list-group-item btn btn-light">').text(suggestedAddress);

                            // Agrega un evento clic para actualizar el valor del input al hacer clic en la sugerencia
                            listItem.on('click', function() {
                                inputDireccion.val(suggestedAddress);
                                // Oculta la lista de sugerencias después de hacer clic
                                listaSugerencias.empty();
                            });

                            listaSugerencias.append(listItem);
                            });
                        }
                    }
                });
                } else {
                // Si el texto es corto, limpia la lista de sugerencias
                listaSugerencias.empty();
                }
            });

            // Cierra la lista de sugerencias al hacer clic fuera de ella
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.sugerencias-container').length) {
                listaSugerencias.empty();
                }
            });

            $(".fecha_y_hora_ingreso").flatpickr({
                enableTime: true,
                enableSeconds: true,
                altFormat: "d m Y H:i:S",
                allowInput: true,
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

            $(".fecha_nacimiento").flatpickr({
                dateFormat: "d-m-Y",
                allowInput: true,
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
            let rut = $('.rut').val();
            let nombres = $('.nombres').val();
            let apellido_paterno = $('.apellido_paterno').val();
            let apellido_materno = $('.apellido_materno').val();
            let fecha_nacimiento = $('.fecha_nacimiento').val();
            let edad = $('.edad').val();
            let direccion = $('.direccion').val();
            let sexo = $('.sexo').val();
            let fecha_y_hora_ingreso = $('.fecha_y_hora_ingreso').val();

            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>home/buscar_datos_pacientes",
                dataType: "json",
                data: {
                    rut: rut,
                    nombres: nombres,
                    apellido_materno: apellido_materno,
                    apellido_paterno: apellido_paterno,
                    fecha_nacimiento: fecha_nacimiento,
                    edad: edad,
                    direccion: direccion,
                    sexo: sexo,
                    fecha_y_hora_ingreso: fecha_y_hora_ingreso
                },
                beforeSend: function() {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data){
                    $("#pdocrud-ajax-loader").hide();
                    if(data['success']){
                       $('.agregar_paciente').hide();
                        $('.limpiar').removeClass('d-none');
                        $(".rut").val(data["data"][0]["rut"]);
                        $(".nombres").val(data["data"][0]["nombres"]);
                        $(".apellido_paterno").val(data["data"][0]["apellido_paterno"]);
                        $(".apellido_materno").val(data["data"][0]["apellido_materno"]);
                        $(".fecha_nacimiento").val(data["data"][0]["fecha_nacimiento"]);
                        $(".edad").val(data["data"][0]["edad"]);
                        $(".direccion").val(data["data"][0]["direccion"]);
                        $(".sexo").val(data["data"][0]["sexo"]);
                        $('.paciente').val(data["data"][0]["id_datos_paciente"]);
                       
                        Swal.fire({
                            title: "Genial!",
                            text: data['success'],
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        });
                    } else {
                        $(".rut").val("");
                        $(".nombres").val("");
                        $(".apellido_paterno").val("");
                        $(".apellido_materno").val("");
                        $(".fecha_nacimiento").val("");
                        $(".edad").val("");
                        $(".direccion").val("");
                        $(".sexo").val("");
                        $('.paciente').val("");
                        Swal.fire({
                            title: "Atención!",
                            text: data['error'],
                            icon: "warning",
                            confirmButtonText: "Aceptar"
                        });
                    }
                   
                    //$('.resultado_datos_paciente').removeClass('hide');
                    //$('.resultado_datos_paciente').html(data);
                }
            });
        });

        $(document).on("click", ".guardar", function(){
            // Datos Paciente
            let rut = $('.rut').val();
            let nombres = $('.nombres').val();
            let apellido_paterno = $('.apellido_paterno').val();
            let apellido_materno = $('.apellido_materno').val();
            let fecha_nacimiento = $('.fecha_nacimiento').val();
            let edad = $('.edad').val();
            let direccion = $('.direccion').val();
            let sexo = $('.sexo').val();
            let fecha_y_hora_ingreso = $('.fecha_y_hora_ingreso').val();

            //Diagnóstico y antecedentes clínicos del paciente
            let especialidad = $('.especialidad').val();
            let profesional = $('.profesional').val();
            let diagnostico = $('.diagnostico').val();
            let sintomas_principales = $('.sintomas_principales').val();
            let diagnostico_libre = $('.diagnostico_libre').val();
            
            // Detalle de Solicitud
            let paciente = $('.paciente').val();
           
            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>home/ingresar_datos_pacientes",
                dataType: "json",
                data: {
                    rut: rut,
                    nombres: nombres,
                    apellido_materno: apellido_materno,
                    apellido_paterno: apellido_paterno,
                    fecha_nacimiento: fecha_nacimiento,
                    edad: edad,
                    direccion: direccion,
                    sexo: sexo,
                    fecha_y_hora_ingreso: fecha_y_hora_ingreso,
                    especialidad: especialidad,
                    profesional: profesional,
                    diagnostico: diagnostico,
                    sintomas_principales: sintomas_principales,
                    diagnostico_libre: diagnostico_libre,
                    paciente: paciente
                },
                beforeSend: function() {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data){
                    $("#pdocrud-ajax-loader").hide();
                    if(data['success']){
                        $('.agregar_paciente').show();
                        $('.limpiar').addClass('d-none');
                        $('.result_solicitud').html(data['render3']);
                        Swal.fire({
                            title: "Genial!",
                            text: data['success'],
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        });

                        $('.rut').val("");
                        $('.paciente').val("");
                        $('.nombres').val("");
                        $('.apellido_paterno').val("");
                        $('.apellido_materno').val("");

                        $('.fecha_nacimiento').val("");

                        $('.edad').val("");
                        $('.direccion').val("");
                        $('.sexo').val("");

                        $('.fecha_y_hora_ingreso').val("");

                        $('.especialidad').val("");
                        $('.especialidad').chosen('destroy');
                        $('.especialidad').chosen();

                        $('.profesional').val("");
                        $('.diagnostico').val("");
                        $('.sintomas_principales').val("");
                        $('.diagnostico_libre').val("");

                    } else {
                        Swal.fire({
                            title: "Atención!",
                            text: data['error'],
                            icon: "warning",
                            confirmButtonText: "Aceptar"
                        });
                    }
                }
            });
        });


        $(document).on("click", ".contraste", function(){
            let contraste = [];
            $('.contraste:checked').each(function() {
                contraste.push($(this).val());
            });

           if(contraste.includes('Examen con contraste')){
            $('.filed_creatinina').removeClass("d-none");
           } else {
            $('.filed_creatinina').addClass("d-none");
            $('.creatinina').val("");
           }

        });

        $(document).on("change keyup", ".fecha_nacimiento", function(){
            let fecha_nac = $(this).val();

            if (fecha_nac) {
                $("#pdocrud-ajax-loader").show();
                $.ajax({
                    type: "POST",
                    url: "<?=$_ENV["BASE_URL"]?>home/generar_edad",
                    dataType: "json",
                    data: {
                        fecha_nac: fecha_nac
                    },
                    success: function(data){
                        $("#pdocrud-ajax-loader").hide();
                        if (!data.error) {
                            $('.limpiar').removeClass('d-none');
                            if (data.fecha_nacimiento <= 0) {
                                $('.edad').val("");
                            } else {
                                $('.edad').val(data.fecha_nacimiento);
                            }
                        } else {
                            $('.edad').val("");
                            Swal.fire({
                                title: "Lo siento!",
                                text: data.error,
                                icon: "error",
                                confirmButtonText: "Aceptar"
                            });
                        }
                    }
                });
            } else {
                $('.edad').val("");
            }
        });

        $(document).on("click", ".agregar_detalle_solicitud", function(){
            let codigo_fonasa = $('.codigo_fonasa').val();
            let paciente = $('.paciente').val();
            let tipo_solicitud = $('.tipo_solicitud').val();
            let fecha_solicitud = $('.fecha_solicitud').val();
            let tipo_examen = $('.tipo_examen').val();
            let examen = $('.examen').val();
            let plano = $('.plano').val();
            let extremidad = $('.extremidad').val();
            let observacion = $('.observacion').val();
            let contraste = [];
            $('.contraste:checked').each(function() {
                contraste.push($(this).val());
            });

            let creatinina = '';
            if(contraste.includes('Examen con contraste')) {
                creatinina = $('.creatinina').val();
            }

            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>home/ingresar_detalle_solicitud",
                dataType: "json",
                data: {
                    codigo_fonasa: codigo_fonasa,
                    paciente: paciente,
                    tipo_solicitud: tipo_solicitud,
                    fecha_solicitud: fecha_solicitud,
                    tipo_examen: tipo_examen,
                    examen: examen,
                    plano: plano,
                    extremidad: extremidad,
                    observacion: observacion,
                    contraste: contraste,
                    creatinina: creatinina
                },
                beforeSend: function() {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data){
                    $("#pdocrud-ajax-loader").hide();
                    if(data['success']){
                        Swal.fire({
                            title: "Genial!",
                            text: data['success'],
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        });

                        $('.pdocrud-data-row').remove();
                        $.each(data["data"], function(index, dato) {
                            $('.table.pdocrud-table tbody').prepend(`
                                <tr class="pdocrud-data-row">
                                    <td>${dato.codigo_fonasa}</td>
                                    <td>${dato.tipo_solicitud}</td>
                                    <td>${dato.tipo_examen}</td>
                                    <td>${dato.examen}</td>
                                    <td>${(dato.contraste != "") ? dato.contraste : '<div class="badge badge-danger">Sin Contraste</div>'}</td>
                                    <td>${(dato.plano != "") ? dato.plano : '<div class="badge badge-danger">Sin Plano</div>'}</td>
                                    <td>${(dato.extremidad) ? dato.extremidad : '<div class="badge badge-danger">Sin Extremidad</div>'}</td>
                                    <td>
                                        <a class="btn-danger btn-sm eliminar_dato" href="javascript:;" title="Eliminar" data-id="${index}"><i class="fa fa-times fa-fw"></i></a>
                                    </td>
                                </tr>
                            `);
                        });

                        $('.codigo_fonasa').val("");
                        //$('.paciente').val("");

                        $('.tipo_solicitud').val("");

                        $('.tipo_examen').val("");
                        $('.tipo_examen').html("<option value>Seleccionar</option>");
                        $('.tipo_examen').chosen('destroy');
                        $('.tipo_examen').chosen();

                        $('.examen').val("");

                        $('.plano').val("");
                        $('.plano').chosen('destroy');
                        $('.plano').chosen();
                        
                        $('.extremidad').val("");
                        $('.extremidad').chosen('destroy');
                        $('.extremidad').chosen();

                        $('.observacion').val("");
                        $('.contraste').prop('checked', false);

                        $('.filed_creatinina').addClass("d-none");
                        $('.creatinina').val("");
                    } else {
                        Swal.fire({
                            title: "Atención!",
                            text: data['error'],
                            icon: "warning",
                            confirmButtonText: "Aceptar"
                        });
                    }
                }
            });
        });


        $(document).on("click", ".eliminar_examen", function(){
            $('.examen').val("");
            $('.codigo_fonasa').val("");
        });

        $(document).on("click", ".eliminar_diagnostico", function(){
            $('.diagnostico').val("");
        });

        $(document).on("change", ".tipo_solicitud", function(){
            let tipo_solicitud = $(this).val();

            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>home/cargar_datos_tipo_examen",
                dataType: "json",
                data: {
                    tipo_solicitud: tipo_solicitud,
                },
                beforeSend: function() {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data){
                    $("#pdocrud-ajax-loader").hide();
                    $('.tipo_examen').empty();
                    $('.tipo_examen').html("<option value='0'>Seleccionar</option>");

                    // Agregar nuevas opciones
                    $.each(data['tipo_examen'], function(key, value) {
                        if(tipo_solicitud != 0){
                            $('.tipo_examen').append('<option value="' + key + '">' + value + '</option>');
                        } else {
                            $('.tipo_examen').val("0");
                            $('.tipo_examen').chosen("destroy");
                            $('.tipo_examen').chosen();
                            $(".examen").autocomplete("destroy");
                        }
                    });

                    // Actualizar Chosen
                    $('.tipo_examen').trigger('chosen:updated');

                }
            });
        });


        $(document).on("click", ".limpiar", function(){
            $('.limpiar').addClass('d-none');
            $('.agregar_paciente').show();
            $(".rut").val("");
            $(".nombres").val("");
            $(".apellido_paterno").val("");
            $(".apellido_materno").val("");
            $(".fecha_nacimiento").val("");
            $(".edad").val("");
            $(".direccion").val("");
            $(".sexo").val("");
            $('.paciente').val("");
            $('.paciente').trigger('chosen:updated');
        });


        $(document).on("change", ".tipo_examen", function () {
            let tipo_examen = $(this).val();
            if(tipo_examen != 0){
                cargarAutocompletado(tipo_examen);
            } else {
                $(".examen").autocomplete("destroy");
            }
        });


        $(".examen").on("keydown", function (e) {
            if (e.keyCode == 8 || e.keyCode == 46) {
               $('.codigo_fonasa').val("");
            }
        });

        function cargarAutocompletado(tipo_examen) {
            $(".examen").autocomplete({
                minLength: 1,
                delay: 0,
                autoFocus: true,
                source: function (request, response) {
                    $.ajax({
                        url: "<?=$_ENV["BASE_URL"]?>home/buscar_examenes_prestacion",
                        type: 'POST',
                        dataType: 'json',
                        data: { query: request.term, tipo_examen: tipo_examen }, // Enviar el tipo_examen
                        success: function (data) {
                            if (!data['error']) {
                                response(data['glosa']);
                            } else {
                                Swal.fire({
                                    title: "Lo siento!",
                                    text: data['error'],
                                    icon: "error",
                                    confirmButtonText: "Aceptar"
                                });
                            }
                        }
                    });
                },
                open: function (event, ui) {
                    var term = $(".examen").val();
                    var matcher = new RegExp("(" + $.ui.autocomplete.escapeRegex(term) + ")", "ig");
                    $(".ui-autocomplete").find("li").each(function () {
                        var text = $(this).text();
                        $(this).html(text.replace(matcher, "<span style='color:black; font-weight: bold;'>$1</span>"));
                    });
                },
                select: function (event, ui) {
                    let val = ui['item']['value'];

                    $.ajax({
                        type: "POST",
                        url: "<?=$_ENV["BASE_URL"]?>home/buscar_examenes_prestacion",
                        dataType: "json",
                        data: {
                            query: val,
                            tipo_examen: tipo_examen // Enviar el tipo_examen
                        },
                        beforeSend: function () {
                            $("#pdocrud-ajax-loader").show();
                        },
                        success: function (data) {
                            if (data['codigo_fonasa']) {
                                $("#pdocrud-ajax-loader").hide();
                                $('.codigo_fonasa').val(data['codigo_fonasa']);
                            }
                        }
                    });
                }
            });
        }

        $(".diagnostico").autocomplete({
            minLength: 3,
            delay: 0,
            autoFocus: true,
            source: function(request, response) {
                $.ajax({
                    url: "<?=$_ENV["BASE_URL"]?>home/buscar_codigos_crud_daga",
                    type: 'POST',
                    dataType: 'json',
                    data: { query: request.term },
                    success: function(data) {
                        response(data['operacion']);
                    }
                });
            },
            open: function (event, ui) {
                var term = $(".diagnostico").val();
                var matcher = new RegExp("(" + $.ui.autocomplete.escapeRegex(term) + ")", "ig");
                $(".ui-autocomplete").find("li").each(function () {
                    var text = $(this).text();
                    $(this).html(text.replace(matcher, "<span style='color:black; font-weight: bold;'>$1</span>"));
                });
            }
        });

        function obtener_profesionales(){
            $.ajax({
                url: "<?=$_ENV["BASE_URL"]?>home/obtener_profesionales",
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data) {
                    $("#pdocrud-ajax-loader").hide();
                    $('.profesional').empty();
                    $('.profesional').html("<option value>Seleccionar</option>");

                    $.each(data['data'], function(key, value) {
                        $('.profesional').append('<option value="' + value.id_profesional + '">' + value.nombre_profesional + ' ' + value.apellido_profesional + '</option>');
                    });
                }
            });
        }

        $(document).ready(function() {

            $('.profesional').select2();
            obtener_profesionales();

            $('.profesional').on('select2:open', function() {
                obtener_profesionales();
            });

            $('.profesional').on('select2:select', function(e) {
                $(this).val(e.params.data.id).trigger('change.select2');
            });

        });

        /*$(".profesional").autocomplete({
            minLength: 1,
            delay: 0,
            autoFocus: true,
            source: function(request, response) {
                $.ajax({
                    url: "home/buscar_profesional",
                    type: 'POST',
                    dataType: 'json',
                    data: { query: request.term },
                    success: function(data) {
                        response(data['nombre_profesional']);
                    }
                });
            },
            open: function (event, ui) {
                var term = $(".profesional").val();
                var matcher = new RegExp("(" + $.ui.autocomplete.escapeRegex(term) + ")", "ig");
                $(".ui-autocomplete").find("li").each(function () {
                    var text = $(this).text();
                    $(this).html(text.replace(matcher, "<span style='color:black; font-weight: bold;'>$1</span>"));
                });
            }
        });*/


        $(document).on("click", ".agregar_profesional", function(){
            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>home/agregar_profesional",
                dataType: "html",
                beforeSend: function() {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data){
                    $("#pdocrud-ajax-loader").hide();
                    $('.cargar_modal').html(data);
                    $('#Profesional').modal('show');
                }
            });
        });

        $(document).on("pdocrud_after_submission", function(event, obj, data){
            let json = JSON.parse(data);

            if(json.message){
                $('#Profesional').modal('hide');
                Swal.fire({
                    title: "Genial!",
                    text: json.message,
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
            }
        });


        $(document).on("click", ".agregar_paciente", function(){
            let rut = $('.rut').val();
            let nombres = $('.nombres').val();
            let apellido_paterno = $('.apellido_paterno').val();
            let apellido_materno = $('.apellido_materno').val();
            let fecha_nacimiento = $('.fecha_nacimiento').val();
            let edad = $('.edad').val();
            let direccion = $('.direccion').val();
            let sexo = $('.sexo').val();
            let fecha_y_hora_ingreso = $('.fecha_y_hora_ingreso').val();

            $.ajax({
                type: "POST",
                url: "<?=$_ENV["BASE_URL"]?>home/agregar_paciente",
                dataType: "json",
                data: {
                    rut: rut,
                    nombres: nombres,
                    apellido_materno: apellido_materno,
                    apellido_paterno: apellido_paterno,
                    fecha_nacimiento: fecha_nacimiento,
                    edad: edad,
                    direccion: direccion,
                    sexo: sexo,
                    fecha_y_hora_ingreso: fecha_y_hora_ingreso
                },
                beforeSend: function() {
                    $("#pdocrud-ajax-loader").show();
                },
                success: function(data){
                    $("#pdocrud-ajax-loader").hide();
                    if(data['success']){
                        $('.result_solicitud').html(data['render3']);
                        $('.paciente').val(data['id']);
                        $('.agregar_paciente').hide();
                        Swal.fire({
                            title: "Genial!",
                            text: data['success'],
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        });

                    } else {
                        Swal.fire({
                            title: "Atención!",
                            text: data['error'],
                            icon: "warning",
                            confirmButtonText: "Aceptar"
                        });
                    }
                }
            });
        });
    </script>
<?php require 'layouts/footer.php'; ?>