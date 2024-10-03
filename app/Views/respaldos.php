<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <?=$render?>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>
<div id="artify-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
    $(document).on('click', '.export', function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?=$_ENV["BASE_URL"]?>home/export_db",
        dataType: "json",
        beforeSend: function() {
            $("#artify-ajax-loader").show();
        },
        success: function(data) {
          $("#artify-ajax-loader").hide();
          $('#artify_search_btn').click();
            Swal.fire({
                title: "Genial!",
                text: data['success'],
                icon: "success",
                confirmButtonText: "Aceptar"
            });
        },
        error: function() {
            Swal.fire({
                title: "Lo siento!",
                text: 'Error al Exportar',
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        }
      });
    });
  });

  $(document).on("click", ".artify-filter-option-remove, .artify-filter-option", function() {
    $(".artify-filter").val('');
  });

  $(document).on("keyup", "#artify_search_box", function(event) {
    let busqueda = $("#artify_search_box").val();

    if (busqueda == "") {
      $('#artify_search_btn').click();
    }
    
  });
</script>
<?php require 'layouts/footer.php'; ?>