<script type="text/javascript">
    jQuery(document).on("ready artify_on_load artify_after_submission artify_after_ajax_action", function (event, container) {
        jQuery("<?php echo $elementName; ?>").addClass("animated <?php echo implode(' ', $params);?>");
    });
</script>    