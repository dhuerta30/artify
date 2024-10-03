<?php if (!$settings["back_operation"]) { ?>
    <section class="artify-table-container" data-objkey="<?php echo $objKey; ?>" <?php if (!empty($modal)) { ?> data-modal="true" <?php } ?>>
    <?php } ?>
    <div class="card">
        <div class="alert alert-success hidden artify_message" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only"><?php echo $lang["message"]; ?> :</span>
            <span class="message_content"><?php if (isset($_SESSION["message"])) echo $_SESSION["message"]; ?></span>
        </div>
        <div class="page-title clearfix card-header artify-table-heading">
            <h3 class="card-title">
                <?php echo $lang["tableHeading"]; ?>
                <small>
                    <?php echo $lang["tableSubHeading"]; ?>
                </small>
            </h3>
            <?php if ($settings["addbtn"]) { ?>
                <div class="btn-group float-right">
                    <a title="<?php echo $lang["add"]; ?>" class="artify-actions artify-button artify-button-add green agregar btn btn-success" href="javascript:;" data-action="add" data-obj-key="<?php echo $objKey; ?>">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <?php echo $lang["add"]; ?>
                    </a>
                </div>
            <?php } ?>
            <?php if ($settings["refresh"]) { ?>
                <div class="btn-group pull-right">
                    <a href="javascript:;" class="btn btn-primary" data-action="refresh" data-rendertype="CRUD" data-obj-key="<?php echo $objKey; ?>"><i class="fa fa-refresh"></i> <?php echo $lang["refresh"]; ?></a>
                </div>
            <?php } else { ?>
                <div class="btn-group pull-right d-none">
                    <a href="javascript:;" class="btn btn-primary" data-action="refresh" data-rendertype="CRUD" data-obj-key="<?php echo $objKey; ?>"><i class="fa fa-refresh"></i> <?php echo $lang["refresh"]; ?></a>
                </div>
            <?php } ?>
            <?php if ($settings["savebtn"]) { ?>
                <div class="btn-group float-right">
                    <a title="<?php echo $lang["save"]; ?>" class="artify-actions artify-button artify-button-save green guardar_datos btn btn-success text-white" href="javascript:;" data-action="save_crud_table_data" data-obj-key="<?php echo $objKey; ?>">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <?php echo $lang["save"]; ?>
                    </a>
                </div>
                <?php }
            if (isset($extraData["btnTopAction"]) && is_array($extraData["btnTopAction"]) && count($extraData["btnTopAction"])) {
                foreach ($extraData["btnTopAction"] as  $action_name => $action) {
                    list($key, $text, $attr, $url, $cssClass) = $action;
                ?>
                    <div class="btn-group float-right">
                        <a title="<?php echo strip_tags($text); ?>" class="artify-top-actions artify-button <?php echo $cssClass; ?> artify-button-<?php echo $action_name; ?>" href="<?php echo $url; ?>" data-action="<?php echo $action_name; ?>" data-obj-key="<?php echo $objKey; ?>">
                            <?php echo $text; ?>
                        </a>
                    </div>
            <?php }
            }
            ?>
        </div><!-- /.card-header -->

        <div class="card-body artifybox artify-top-buttons">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <?php if ($settings["totalRecordsInfo"]) { ?>
                        <p class="card-text mb-2"><?php echo $lang["dispaly_records_info"]; ?></p>
                    <?php } ?>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="row artify-search">
                        <?php if ($settings["searchbox"]) { ?>
                            <?php echo $searchbox; ?>
                        <?php } else { ?>
                            <style>
                                .pdo-search-cols, .pdo-table-search {
                                    display: none!important;
                                }
                            </style>
                             <?php echo $searchbox; ?>
                        <?php } ?>
                        <?php if ($settings["deleteMultipleBtn"]) { ?>
                            <div class="col-md-1 col-sm-1 col-1 no-padding">
                                <a title="<?php echo $lang["delete_selected"]; ?>" class="artify-actions artify-button artify-button-delete-all green btn btn-danger" href="javascript:;" data-action="delete_selected" data-obj-key="<?php echo $objKey; ?>">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (isset($extraData["dateRangeReport"])) { ?>
                <div class="row" style="padding-bottom: 5px">
                    <?php foreach ($extraData["dateRangeReport"] as $key => $dateRange) { ?>
                        <div class="col-md-2 col-lg-2">
                            <a title="<?php echo $dateRange["text"]; ?>" class="artify-actions artify-button  btn btn-success artify-date-range-report" href="javascript:;" data-action="date_range_report" data-action-id="<?php echo $key; ?>" data-obj-key="<?php echo $objKey; ?>">
                                <?php echo $dateRange["text"]; ?>
                            </a>
                        </div>
                    <?php
                    } ?>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $data; ?>
                </div>
            </div>
            <div class="row artify-options-files">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <ul class="artify-export-options">
                        <?php if ($settings["printBtn"]) { ?>
                            <li class="bg-white"><a title="<?php echo $lang["print"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="print" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-print"></i> <?php echo $lang["print"]; ?></a></li>
                        <?php
                        }
                        if ($settings["csvBtn"]) {
                        ?>
                            <li class="bg-white"><a title="<?php echo $lang["csv"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="csv" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-file-o"></i> <?php echo $lang["csv"]; ?></a></li>
                        <?php
                        }
                        if ($settings["pdfBtn"]) {
                        ?>
                            <li class="bg-white"><a title="<?php echo $lang["pdf"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="pdf" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-file-pdf-o"></i> <?php echo $lang["pdf"]; ?></a></li>
                        <?php }
                        if ($settings["excelBtn"]) { ?>
                            <li class="bg-white"><a title="<?php echo $lang["excel"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="excel" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-file-excel"></i> <?php echo $lang["excel"]; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <div class="float-right">
                        <?php if ($settings["pagination"]) { ?>
                            <div class="btn-group artify-pagination">
                                <?php echo $pagination; ?>
                            </div>
                        <?php } ?>
                        <?php if ($settings["recordsPerPageDropdown"]) { ?>
                            <div class="btn-group float-right">
                                <?php echo $perPageRecords; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <?php echo $modal; ?>
    <?php if (!$settings["back_operation"]) { ?>
    </section><!-- /.content -->
<?php
    } ?>