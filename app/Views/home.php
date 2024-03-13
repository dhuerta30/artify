<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">
				<div class="row mb-3">
				</div>
				<?=$render?>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<?php require 'layouts/footer.php'; ?>