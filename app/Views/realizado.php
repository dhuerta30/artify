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
                        <h5>Reportes Procedimiento Realizado</h5>
                        <hr>

                        <form action="buscar_rango.php" method="get" class="form_search">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="correo">Fecha Solicitud Desde</label>
                                    <input class="form-control" type="date" name="fecha_de" id="fecha_de"  placeholder="">
                                </div>

                                <div class="col-md-6">
                                    <label for="correo">Fecha Solicitud Hasta </label>
                                    <input class="form-control" type="date" name="fecha_a" id="fecha_a" placeholder="">                                
                                </div>
                            </div>	
                            <div class="row mt-3 mb-4">
                                <div class="col-md-12">
                                    <a href="javascript:;" class="btn btn-primary btn_search"><i class="fa fa-search"></i> Buscar</a>
                                </div>
                            </div>	
                        </form>

                       <div class="lista_pro">
                        <?=$render?>
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
    $(document).on("click", ".btn_search", function(){
        let fecha_de = $('#fecha_de').val();
        let fecha_a = $('#fecha_a').val();

        $.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>home/buscar_rango_realizado",
            dataType: "html",
            data: {
                fecha_de: fecha_de,
                fecha_a: fecha_a
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