<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<style>
.btn.btn-default {
    background: #fff;
}
@media (min-width: 576px){
	.modal-dialog {
		max-width: 1200px!important;
		margin: 1.75rem auto;
	}
}

.form-control {
    min-width: 200px;
}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card">
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
    $('.label_Visibilidad_filtro').hide();
    $('.data_visibilidad_filtro').hide();
    $('.data_visibilidad_filtro').attr('required', false);
    $('.pdocrud-button-url').removeClass('pdocrud-actions');
});

$(document).on("change", ".data_activar_filtro_de_busqueda", function(){
    let val = $(this).val();
    if(val == "AUTO_INCREMENT"){
        $('.label_Visibilidad_filtro').show();
        $('.data_visibilidad_filtro').show();
        $('.data_visibilidad_filtro').attr('required', true);
    } else {
        $('.label_Visibilidad_filtro').hide();
        $('.data_visibilidad_filtro').hide();
        $('.data_visibilidad_filtro').attr('required', false);
    }
});

$(document).on("pdocrud_after_submission", function(event, obj, data){
    let json = JSON.parse(data);

    if(json.message){
        $('.pdocrud-back').click();
        $('.pdocrud-button-url').removeClass('pdocrud-actions');
        Swal.fire({
            title: "Genial!",
            text: json.message,
            icon: "success",
            confirmButtonText: "Aceptar"
        });
    }
});

$(document).ready(function(){
    $('.pdocrud-button-url').removeClass('pdocrud-actions');
});
</script>
<?php require 'layouts/footer.php'; ?>