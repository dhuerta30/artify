<div class="row pdocrud-filters-container" data-objkey="<?php echo $objKey; ?>">
    <div class="col-md-12">
        <?php if (isset($filters) && count($filters)) { ?>
            <div class="pdocrud-filters-options text-center">
                <div class="pdocrud-filter-selected text-center">
                    <span class="pdocrud-filter-option-remove btn btn-success mb-3"><i class="fa fa-paint-brush"></i> <?php echo $lang["clear_all"] ?></span>
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
    <div class="col-md-12">
        <?php echo $data ?>
    </div>
</div>