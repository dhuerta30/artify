<div class="row artify-filters-container" data-objkey="<?php echo $objKey; ?>" >
    <div class="col-sm-3">
        <?php if (isset($filters) && count($filters)) { ?>
            <div class="artify-filters-options">
                <div class="artify-filter-selected">
                    <span class="artify-filter-option-remove"><?php echo $lang["clear_all"] ?></span>
                </div>
                <?php
                foreach ($filters as $filter) {
                    echo $filter;
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-sm-9">
        <?php echo $data ?>
    </div>
</div>