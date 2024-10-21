<div class="row artify-filters-container" data-objkey="<?php echo $objKey; ?>">
    <div class="col-md-3">
        <?php if (isset($filters) && count($filters)) { ?>
            <div class="artify-filters-options text-center">
                <div class="artify-filter-selected text-center">
                    <span class="artify-filter-option-remove btn btn-success mb-3"><i class="fa fa-paint-brush"></i> <?php echo $lang["clear_all"] ?></span>
                </div>
                <?php
                foreach ($filters as $filter) {
                    echo $filter;
                }
                ?>
            </div>
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary" id="filter-button"><i class="fa fa-search"></i> <?php echo $lang["filter_text"] ?></button>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col-md-9">
        <?php echo $data ?>
    </div>
</div>