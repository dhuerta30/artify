
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebar.php"; ?>
        <link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
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
        <?php require "layouts/footer.php"; ?>
        <script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
        <script>
            $(document).on("artify_after_ajax_action", function(event, obj, data){
                var dataAction = obj.getAttribute('data-action');
                var dataId = obj.getAttribute('data-id');

                if(dataAction == "add"){
                
                }

                if(dataAction == "edit"){
                
                }
            });
            $(document).on("artify_after_submission", function(event, obj, data) {
                let json = JSON.parse(data);

                if (json.message) {
                    Swal.fire({
                        icon: "success",
                        text: json["message"],
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".artify-back").click();
                        }
                    });
                }
            });
        </script>