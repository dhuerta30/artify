<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?=$render?>
                <?=$render2?>
            </div>
        </div>
    </section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>
$(document).on("pdocrud_after_submission", function(event, obj, data){
    let json = JSON.parse(data);

    $('.pdocrud_error').hide();
    $('.pdocrud_message').hide();
    if(json.message){
        $('.pdocrud-back').click();
        $('#pdocrud_search_btn').click();
        $('.pdocrud-file-input-control').val("");
        Swal.fire({
            title: 'Genial!',
            text: json.message,
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    } else {
        Swal.fire({
            title: 'Lo siento!',
            text: json.error,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
});
</script>
<?php require 'layouts/footer.php'; ?>