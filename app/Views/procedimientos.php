<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=$_ENV["BASE_URL"]?>css/flatpickr.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">
                

                <div class="row procedimiento_form mb-4">
                    <div class="col-md-12">
                        <h4>Procedimiento (CMDB)</h4>
                        <hr>
                        <select class="form-control" name="espcialidad_select" id="espcialidad_select">
                            <option value="0">Seleccione Especialidad</option>
                            <option value="Cardiologicos">Cardiologicos</option>
                            <option value="Medicina Interna">Medicina Interna</option>
                            <option value="Oftalmologia">Oftalmologia</option>
                            <option value="Otorrinolaringologia">Otorrinolaringologia</option>
                            <option value="Traumatologia">Traumatologia</option>
                            <option value="Endoscopicos">Endoscopicos</option>
                        </select>
                    </div>
                </div>

                <div class="row procedimiento d-none">
                    <div class="col-md-12">
                        <h4>Solicitud de Procedimiento (CMDB)</h4>
                        <hr>
                        <?=$render?>
                        <?=$mask;?>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script src="<?=$_ENV["BASE_URL"]?>js/flatpickr.js"></script>
<script>
    $(document).on("change", "#espcialidad_select", function(){
        let val = $(this).val();

        $('.procedimiento_2').empty();
        $('.procedimiento_2').html(`<option value="0">Seleccionar</option>`);

        if(val != 0){
            $('.procedimiento').removeClass('d-none');
            $('.espacialidad').val(val);
        } else {
            $('.procedimiento').addClass('d-none');
        }

        if(val == "Cardiologicos"){
            $('.procedimiento_2').append(`
                <option value="ECOCARDIOGRAMA">ECOCARDIOGRAMA</option>
                <option value="ESPIROMETRIA">ESPIROMETRIA</option>
                <option value="HOLTER DE PRESION">HOLTER DE PRESION</option>
                <option value="HOLTER DE RITMO">HOLTER DE RITMO</option>
                <option value="TEST DE ESFUERZO">TEST DE ESFUERZO</option>
            `);
        } else if(val == "Medicina Interna"){
            $('.procedimiento_2').append(`
                <option value="ELECTROENCEFALOGRAMA">ELECTROENCEFALOGRAMA</option>
                <option value="ELECTROMIOGRAFIA">ELECTROMIOGRAFIA</option>
            `);
        } else if(val == "Oftalmologia"){
            $('.procedimiento_2').append(`
                <option value="FONDO DE OJO">FONDO DE OJO</option>
                <option value="CURVA DE TENSION OCULAR">CURVA DE TENSION OCULAR</option>
            `);
        } else if(val == "Otorrinolaringologia"){
            $('.procedimiento_2').append(`
                <option value="NASOFIBROLARINGOSCOPIA">NASOFIBROLARINGOSCOPIA</option>
            `);
        } else if(val == "Traumatologia"){
            $('.procedimiento_2').append(`
                <option value="INSTALACION DE YESO">INSTALACION DE YESO</option>
                <option value="RETIRO DE YESO">RETIRO DE YESO</option>
                <option value="INFILTRACION">INFILTRACION</option>
                <option value="INSTALACION DE INMOBILIZADOR U ORTESIS">INSTALACION DE INMOBILIZADOR U ORTESIS</option>
            `);
        } else if(val == "Endoscopicos"){
            $('.procedimiento_2').append(`
                <option value="COLONOSCOPIA">COLONOSCOPIA</option>
                <option value="ENDOSCOPIA">ENDOSCOPIA</option>
                <option value="ERCP">ERCP</option>
                <option value="GASTROSTOMIA">GASTROSTOMIA</option>
            `);
        }
    });

    $(document).ready(function(){
        $(".fecha_registro").flatpickr({
            enableTime: true,
            enableSeconds: true,
            dateFormat: "d-m-Y H:i:S",
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

    $(document).on("click", ".registrar_imprimir", function(){
        let rut = $('.rut').val();
        let fecha_solicitud = $('.fecha_solicitud').val();
        let especialidad = $('.especialidad').val();
        let procedimiento_2 = $('.procedimiento_2').val();
        let servicio = $('.servicio').val();
        let fecha_registro = $('.fecha_registro').val();
        let nombres = $('.nombres').val();
        let apellido_paterno = $('.apellido_paterno').val();
        let apellido_materno = $('.apellido_materno').val();
        let operacion = $('.operacion').val();
        let profesional_solicitante = $('.profesional_solicitante').val();
        let numero_contacto = $('.numero_contacto').val();
        let numero_contacto_2 = $('.numero_contacto_2').val();
        let prioridad = $('.prioridad').val();

        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>home/registrar_e_imprimir_pdf",
            dataType: "json",
            data: {
                rut: rut,
                fecha_solicitud,
                especialidad: especialidad,
                procedimiento_2: procedimiento_2,
                servicio: servicio,
                fecha_registro: fecha_registro,
                nombres: nombres,
                apellido_paterno: apellido_paterno,
                apellido_materno: apellido_materno,
                operacion: operacion,
                profesional_solicitante: profesional_solicitante,
                numero_contacto: numero_contacto,
                numero_contacto_2: numero_contacto_2,
                prioridad: prioridad
            },
            beforeSend: function() {
                $("#pdocrud-ajax-loader").show();
            },
            success: function(data){
                $("#pdocrud-ajax-loader").hide();
                if(data['mensaje']){
                    Swal.fire({
                        title: "Genial!",
                        text: data['mensaje'],
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    });

                    let pdfUrl = data['pdf_url'];
                    var link = document.createElement('a');
                    link.href = "<?=$_ENV["BASE_URL"]?>app/libs/xinvoice/downloads/" + pdfUrl;
                    link.target = '_blank';
                    link.download = 'procedimiento.pdf';
                    link.click();

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

    $(document).on("pdocrud_after_submission",function(event,obj,data){
        let json = JSON.parse(data);
        if(json['error']){
            Swal.fire({
                title: "Atención!",
                text: json['error'],
                icon: "warning",
                confirmButtonText: "Aceptar"
            });
            $('.pdocrud_error').addClass('d-none');
        } else {
            Swal.fire({
                title: "Genial!",
                text: data['message'],
                icon: "success",
                confirmButtonText: "Aceptar"
            });
        }
    });
</script>
<?php require 'layouts/footer.php'; ?>