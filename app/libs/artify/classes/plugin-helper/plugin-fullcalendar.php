<script type="text/javascript">
    jQuery(document).on("artify_on_load artify_after_submission artify_after_ajax_action", function (event, container) {
    jQuery("<?php echo $elementName; ?>").fullCalendar(
			<?php echo json_encode($params, JSON_PRETTY_PRINT);?>
		);
    });
     
</script>    