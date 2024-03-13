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

                <div class="row procedimiento">
                    <div class="col-md-12">
                        <h5>Reportes Rut Egresados</h5>
                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label>Busqueda por Rut</label>
                                <input class="form-control rut" type="text">
                                <button class="buscar_rut btn btn-primary mt-3"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                       <div class="lista_pro">
                        <?=$render?>
                        <?=$mask?>
                       </div>
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
    $(document).on("click", ".buscar_rut", function(){
        let rut = $('.rut').val();

        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>home/buscar_rut",
            dataType: "html",
            data: {
                rut: rut,
            },
            beforeSend: function() {
                $("#pdocrud-ajax-loader").show();
            },
            success: function(data){
                $("#pdocrud-ajax-loader").hide();
                $('.lista_pro').html(data);
            }
        });
    });
</script>
<?php require 'layouts/footer.php'; ?>