<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<style>
    .page-title.clearfix.card-header.pdocrud-table-heading, .row.pdocrud-options-files {
        display: none;
    }
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">
				<div class="row mb-3">
				</div>
				<h5>Gestión de LE de procedimientos Internos</h5>
				<hr>

				<div class="row">
					<div class="col-md-3">
						<label>Buscar</label>
						<input class="form-control palabra_buscar" type="text">
						<button class="btn btn-primary buscar_gestion mt-3 mb-4"><i class="fa fa-search"></i> Buscar</button>
					</div>
				</div>
				<div class="gestion">
					<?=$render?>
				</div>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
	<img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script>
	$(document).on("click", ".buscar_gestion", function(){
		let val = $('.palabra_buscar').val();

		$.ajax({
			type: "POST",
			url: "<?=$_ENV["BASE_URL"]?>home/buscar_gestion",
			dataType: "html",
			data: {
				val: val
			},
			beforeSend: function() {
                $("#pdocrud-ajax-loader").show();
            },
			success: function(data){
				$("#pdocrud-ajax-loader").hide();
				$('.gestion').html(data);
			}
		});
	});
</script>
<?php require 'layouts/footer.php'; ?>