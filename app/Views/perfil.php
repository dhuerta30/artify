<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-3 upload_avatar">
                            <?php if(!isset($_SESSION["usuario"][0]["avatar"])): ?>
                                <img class="w-100 avatar" src="<?=$_ENV["BASE_URL"]?>theme/img/avatar.jpg" class="card-img-top">
                            <?php else: ?>
                                <img class="w-100 avatar" src="<?=$_ENV["BASE_URL"]?>app/libs/script/uploads/<?=$_SESSION["usuario"][0]["avatar"]?>" class="card-img-top">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?=$render?>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script>
    $(document).on("pdocrud_after_submission", function(event, obj, data) {
      $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/generar_datos_usuario",
        dataType: "json",
        success: function(response) {
          console.log(response);
          $('.nombre_usuario').text(response['usuario'][0]["nombre"]);
          $(".avatar").attr('src', "<?=$_ENV["BASE_URL"]?>app/libs/script/uploads/" + response['usuario'][0]['avatar']);
        }
      });
    });
</script>
<?php require 'layouts/footer.php'; ?>