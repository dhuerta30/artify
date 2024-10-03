<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-body">
                <?=$render?>
                <?=$loadPluginJsCode?>
            </div>
        </div>
    </section>
</div>
<div id="artify-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
</div>
<script>
    let $_ENV["BASE_URL"] = <?=$_ENV["BASE_URL"]?>;
</script>
<?php
if (!empty($script_js)) { ?>
    <script src="<?=$_ENV["BASE_URL"]?>js/<?=$script_js?>.js"></script>
<?php } ?>
<?php require 'layouts/footer.php'; ?>
