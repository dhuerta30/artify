<section class="artify-table-container" data-objkey="<?php echo $objKey; ?>">
	<div class="page-title clearfix panel-heading artify-table-heading">
	    <h3 class="panel-title">
	        <?php if(isset($lang["tableHeading"])){ echo $lang["tableHeading"]; ?>                 
	        <small>
	            <?php if(isset($lang["operation"]))  echo $lang["operation"]; ?>
	        </small>
	        <?php } ?>
	    </h3>            
	</div>
    <div id="artify-table-view table-responsive">
        <?php echo $output; ?>
    </div>
</section>