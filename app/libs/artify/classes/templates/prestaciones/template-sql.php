<section class="artify-table-container" data-objkey="<?php echo $objKey; ?>" <?php if (!empty($modal)) { ?> data-modal="true"<?php } ?> >
    <div class="card">
        <div class="page-title clearfix card-heading artify-table-heading">
            <h3 class="card-title">
                <?php echo $lang["tableHeading"]; ?>                 
                <small>
                    <?php echo $lang["tableSubHeading"]; ?>
                </small>
            </h3>

        </div><!-- /.card-heading -->
        <div class="card-body artifybox artify-top-buttons">
            <div class="row">
                <div class="col-sm-6">
                    <?php if ($settings["totalRecordsInfo"]) { ?>
                        <p class="card-text"><?php echo $lang["dispaly_records_info"]; ?></p>
                    <?php } ?>
                </div>
                <div class="col-sm-6 float-right">                    
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table artify-table table-bordered table-striped table-condensed" data-obj-key="<?php echo $objKey; ?>">
                            <?php if ($settings["headerRow"]) { ?>
                                <thead>
                                    <tr class="artify-header-row">
                                        <?php if ($settings["numberCol"]) { ?>
                                            <th class="w1">
                                                #
                                            </th>
                                        <?php } ?>
                                        <?php if ($columns) foreach ($columns as $colkey => $column) { ?>
                                                <th <?php echo $column["attr"]; ?> data-action="<?php echo $column["sort"]; ?>"  data-sortkey="<?php echo $colkey; ?>" class="artify-actions-sorting artify-<?php echo $column["sort"]; ?>">
                                                    <?php
                                                    echo $column["colname"];
                                                    echo $column["tooltip"];
                                                    ?>
                                                </th>
        <?php } ?>
                                    </tr>
                                </thead>
<?php } ?>
                            <tbody>
                            <input type="hidden" value="<?php echo $objKey; ?>" class="artify-hidden-data pdoobj" />
                            <?php
                            $rowcount = 0;
                            if ($data)
                                foreach ($data as $rows) {
                                    ?>
                                    <tr id="artify-row-<?php echo $rowcount; ?>" class="artify-data-row">
                                            <?php if ($settings["numberCol"]) { ?>
                                            <td class="artify-row-count">
                                            <?php echo $rowcount + 1; ?>
                                            </td>
                                        <?php } ?>
                                        <?php
                                        foreach ($rows as $col => $row) {
                                            if (is_array($row)) {
                                                ?>    
                                                <td class="artify-row-cols <?php echo $row["class"]; ?>"  <?php echo $row["style"]; ?>>
                                                <?php echo $row["content"]; ?>
                                                </td>
                                                <?php
                                            } else {
                                                ?>    
                                                <td class="artify-row-cols">
                                                <?php echo $row; ?>
                                                </td>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    $rowcount++;
                                } else {
                                ?>
                                <tr class="artify-data-row">
                                    <td class="artify-row-count" colspan="<?php echo count($columns); ?>">
                                <?php echo $lang["no_data"] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                                    <?php if ($settings["footerRow"]) { ?>
                                <tfoot>
                                    <tr class="artify-header-row">
    <?php if ($settings["numberCol"]) { ?>
                                            <th class="w1">
                                                #
                                            </th>
                                            <?php } ?>
                                            <?php if ($columns) foreach ($columns as $colkey => $column) { ?>
                                                <th <?php echo $column["attr"]; ?> data-action="<?php echo $column["sort"]; ?>" data-sortkey="<?php echo $colkey; ?>" class="artify-actions-sorting">
                                                    <?php
                                                    echo $column["colname"];
                                                    echo $column["tooltip"];
                                                    ?>
                                                </th>
                                    <?php } ?>
                                    </tr>
                                </tfoot>
<?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row artify-options-files">
                <div class="col-sm-12">
                    <div class="btn-group float-left artify-export-options">
                        <ul>
                            <?php if ($settings["printBtn"]) { ?>
                                <li><a title="<?php echo $lang["print"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="print" data-objkey="<?php echo $objKey; ?>"><?php echo $lang["print"]; ?></a></li>
                            <?php }
                            if ($settings["csvBtn"]) {
                                ?> 
                                <li><a title="<?php echo $lang["csv"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="csv" data-objkey="<?php echo $objKey; ?>"><?php echo $lang["csv"]; ?></a></li>
                            <?php }
                            if ($settings["pdfBtn"]) {
                                ?>
                                <li><a title="<?php echo $lang["pdf"]; ?>"class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="pdf" data-objkey="<?php echo $objKey; ?>"> <?php echo $lang["pdf"]; ?></a></li>                            
                    <?php } if ($settings["excelBtn"]) { ?>
                                <li><a title="<?php echo $lang["excel"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="excel" data-objkey="<?php echo $objKey; ?>"><?php echo $lang["excel"]; ?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                    <?php if ($settings["recordsPerPageDropdown"]) { ?>
                        <div class="btn-group float-right">
                            <?php echo $perPageRecords; ?>
                        </div>
                    <?php } ?>
                        <?php if ($settings["pagination"]) { ?>
                        <div class="btn-group float-right artify-pagination">
                            <?php echo $pagination; ?>
                        </div>
                         <?php } ?>
                    <div style="clear:both"></div>
                </div>  </div>  
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->