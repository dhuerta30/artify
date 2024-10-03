<script type="text/javascript">
    jQuery(document).on("artify_on_load artify_after_submission artify_after_ajax_action", function (event, container) {
        CKEDITOR.replace("<?php echo $elementName; ?>" );
    });
</script>    