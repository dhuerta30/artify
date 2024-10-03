
<?php 
    $pk = $lang["pk"]; 
    $columnVal = $lang["columnVal"];
?>
<?php if (!$settings["back_operation"]) { ?>
<section class="artify-table-container <?=$lang["tabla"]?>_table_container" data-objkey="<?php echo $objKey; ?>" <?php if (!empty($modal)) { ?> data-modal="true"<?php } ?> >
    <?php } ?>    
    <div class="panel panel-default">
        <div class="alert alert-success hidden artify_message" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only"><?php echo $lang["message"]; ?> :</span>
            <span class="message_content"><?php if(isset($_SESSION["message"])) echo $_SESSION["message"];?></span>
        </div>
        <div class="page-title clearfix panel-heading artify-table-heading">
            <h3 class="panel-title">
                <?php echo $lang["tableHeading"]; ?>                 
                <small>
                    <?php echo $lang["tableSubHeading"]; ?>
                </small>
            </h3>
            <?php
             if (isset($extraData["btnTopAction"]) && is_array($extraData["btnTopAction"]) && count($extraData["btnTopAction"])) { 
                foreach ($extraData["btnTopAction"] as  $action_name => $action) { 
                    list( $key, $text, $attr, $url, $cssClass) = $action;
                     ?>
                    <div class="btn-group pull-right">
                        <a  title="<?php echo $text; ?>" class="artify-top-actions artify-button <?php echo $cssClass; ?> artify-button-<?php echo $action_name; ?> btn btn-success"  
                            href="<?php echo $url;?>"
                            data-action="<?php echo $action_name; ?>" <?php echo implode(' ', array_map(
                                                                function ($v, $k) {
                                                            return $k . "=" ."'". $v."'";
                                                        }, $attr, array_keys($attr)
                                                )); ?> data-obj-key="<?php echo $objKey; ?>">
                            <?php echo $text; ?>
                        </a>                    
                    </div>
               <?php } 
                }
            ?>
            <?php if ($settings["addbtn"]) { ?>
                <div class="btn-group pull-right">
                    <a title="<?php echo $lang["add"]; ?>" class="artify-actions artify-button artify-button-add btn btn-success" href="javascript:;" data-action="add" data-rendertype="SQL" data-obj-key="<?php echo $objKey; ?>">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <?php echo $lang["add"]; ?>
                    </a>                    
                </div>
            <?php } ?>
            <?php if ($settings["refresh"]) { ?>
                <div class="btn-group pull-right">
                    <a href="javascript:;" class="btn btn-primary" data-action="refresh" data-rendertype="SQL" data-obj-key="<?php echo $objKey; ?>"><i class="fa fa-refresh"></i> <?php echo $lang["refresh"]; ?></a>
                </div>
            <?php } else { ?>
                <div class="btn-group pull-right hide">
                    <a href="javascript:;" class="btn btn-primary" data-action="refresh" data-rendertype="SQL" data-obj-key="<?php echo $objKey; ?>"><i class="fa fa-refresh"></i> <?php echo $lang["refresh"]; ?></a>
                </div>
            <?php } ?>

        </div><!-- /.panel-heading -->
        <div class="panel-body artifybox artify-top-buttons">
            <div class="row">
                <div class="col-sm-6">
                    <?php if ($settings["totalRecordsInfo"]) { ?>
                        <p><?php echo $lang["dispaly_records_info"]; ?></p>
                    <?php } ?>
                </div>
                <div class="col-sm-6 pull-right">                    
                    <div class="row artify-search">
                            <?php if ($settings["searchbox"]) { ?>
                                <?php echo $searchbox; ?> 
                        <?php } ?>
                        <?php if ($settings["deleteMultipleBtn"]) { ?>
                            <div class="col-md-1 col-sm-1 col-xs-1 no-padding">
                                <a title="<?php echo $lang["delete_selected"]; ?>" class="artify-actions artify-button artify-button-delete-all btn btn-danger" href="javascript:;" data-action="delete_selected" data-rendertype="SQL" data-obj-key="<?php echo $objKey; ?>">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table este es artify-table table-bordered table-striped table-condensed" data-obj-key="<?php echo $objKey; ?>">
                            <?php if ($settings["headerRow"]) { ?>
                                <thead>
                                    <tr class="artify-header-row">
                                        <?php if ($settings["numberCol"]) { ?>
                                            <th class="w1">
                                                #
                                            </th>
                                            <?php }
                                            if ($settings["checkboxCol"]) { ?>
                                                <th class="w1">
                                                    <input type="checkbox" value="select-all" name="artify_select_all" class="artify-select-all"  />
                                                </th>
                                            <?php }
                                            if ($columns) foreach ($columns as $colkey => $column) { 
                                                ?>
                                                <th <?php echo $column["attr"]; ?> data-action="<?php echo $column["sort"]; ?>"  data-sortkey="<?php echo $colkey; ?>" data-rendertype="SQL" class="artify-actions-sorting artify-<?php echo $column["sort"]; ?>">
                                                    <span> <?php echo $column["colname"];
                                                    echo $column["tooltip"];
                                                    ?>
                                                    </span>
                                                </th>
                                        <?php } ?>
                                            
                                        <?php 
                                        if ($settings["actionbtn"]) { ?>
                                            <th>
                                                <?php echo $lang["actions"] ?>
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
                                $sumrow = false;
                                    ?>
                                    <tr data-id="<?=$rows[$pk]?>" id="artify-row-<?php echo $rowcount; ?>" class="artify-data-row">
                                            <?php if ($settings["numberCol"]) { ?>
                                            <td class="artify-row-count">
                                            <?php echo $rowcount + 1; ?>
                                            </td>
                                        <?php } if ($settings["checkboxCol"]) { ?>
                                        <td class="artify-row-checkbox-actions">
                                            <input type="checkbox" class="artify-select-cb" value="<?php echo $rows[$pk]; ?>" />
                                        </td>
                                        <?php }
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
                                        if($sumrow){
                                            ?>
                                             <td class="artify-row-actions"></td>
                                            <?php continue;             
                                        }
                                        if (is_array($btnActions) && count($btnActions)) {
                                        ?>
                                        <td class="artify-row-actions">

                                        <?php foreach ($btnActions as  $action_name => $action) { 
                                                    list( $key, $colName, $action_val, $type, $text, $attr, $url, $cssClass, $btnWhere) = $action;
                                                    $columnVal = isset($rows[$colName]) ? $rows[$colName] : "";
                                                    $url =  preg_replace('/{[^}]+}/', $rows[$pk], $url);
                                                    if (is_array($text) && isset($text[$rows[$colName]])){
                                                        $action_text = $text[$rows[$colName]];
                                                    } else {
                                                        $action_text = $text;
                                                    }

                                                    $skipBtn = false;
                                                    
                                                    if(!empty($btnWhere) && is_array($btnWhere) && count($btnWhere)){
                                                        if(!empty($btnWhere[1]) && $btnWhere[1] === "="){
                                                            $skipBtn = true;
                                                            if(!empty($btnWhere[2]) && in_array($rows[$lang["colname_where"]], $btnWhere[2])){
                                                                $skipBtn = false;
                                                            }
                                                        }
                                                        else if(!empty($btnWhere[1]) && $btnWhere[1] === "!="){
                                                            $skipBtn = true;
                                                            if(!empty($btnWhere[2]) && !in_array($rows[$lang["colname_where"]], $btnWhere[2])){
                                                                $skipBtn = false;
                                                            }
                                                        }
                                                    }    
                                                    
                                                    if($skipBtn === false)   {
                                                    ?>
                                                    <?php
                                                        $btnClass = "btn ";

                                                        // Define el conjunto de valores para los cuales queremos clases específicas
                                                        $specificActions = ["view", "edit", "inline_edit", "clone", "delete", "url"];

                                                        if (in_array($action_name, $specificActions)) {
                                                            switch ($action_name) {
                                                                case "view":
                                                                    $btnClass .= "btn-info";
                                                                    break;
                                                                case "edit":
                                                                case "inline_edit":
                                                                case "clone":
                                                                    $btnClass .= "btn-warning";
                                                                    break;
                                                                case "delete":
                                                                    $btnClass .= "btn-danger";
                                                                    break;
                                                                case "url":
                                                                    $btnClass .= "btn-default";
                                                                    break;
                                                            }
                                                            $btnClass .= " artify-actions";  // Agrega esta clase solo para los actions específicos
                                                        } else {
                                                            $btnClass .= "btn-default";  // Para cualquier otro action_name
                                                        }

                                                        // Agrega clases adicionales si están definidas
                                                        $btnClass .= (isset($cssClass) && !empty($cssClass)) ? " $cssClass" : "";

                                                        // Sobrescribe btnClass para el caso "url"
                                                        if ($action_name == "url") {
                                                            $btnClass = "btn btn-default";
                                                        }
                                                        ?>
                                                        <a class="<?php echo $btnClass; ?> btn-sm artify-button <?php echo $action_name;?>"
                                                            href="<?php echo $url;?>"
                                                            <?php
                                                            echo implode(' ', array_map(
                                                                            function ($v, $k) {
                                                                                return $k . "=" ."'". $v."'";
                                                                            }, $attr, array_keys($attr)
                                                            )); ?>  
                                                            data-id="<?php echo $rows[$pk]; ?>" 
                                                            data-column-val="<?php echo $columnVal ?>"
                                                            data-unique-id="<?php echo $key; ?>" 
                                                            data-action="<?php echo $type;?>"><?php echo $action_text; ?>
                                                        </a>
                                                        <?php } 
                                                            }
                                                        ?>

                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $rowcount++;
                                } else {
                                ?>
                                <tr class="artify-data-row">
                                    <td class="artify-row-count text-center" colspan="100%">
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
                                                <th <?php echo $column["attr"]; ?> data-action="<?php echo $column["sort"]; ?>" data-sortkey="<?php echo $colkey; ?>" data-rendertype="SQL" class="artify-actions-sorting artify--<?php echo $column["sort"]; ?>">
                                                    <?php echo $column["colname"];
                                                    echo $column["tooltip"];
                                                    ?>
                                                </th>
                                    <?php } ?>
                                    <?php if ($settings["actionbtn"]) {
                                            ?>
                                            <th>
                                            <?php echo $lang["actions"] ?>
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
                    <div class="btn-group pull-left artify-export-options">
                        <ul class="artify-export-options">
                            <?php if ($settings["printBtn"]) { ?>
                                <li><a title="<?php echo $lang["print"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="print" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-print"></i> <?php echo $lang["print"]; ?></a></li>
                            <?php }
                            if ($settings["csvBtn"]) {
                                ?> 
                                <li><a title="<?php echo $lang["csv"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="csv" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-file"></i> <?php echo $lang["csv"]; ?></a></li>
                            <?php }
                            if ($settings["pdfBtn"]) {
                                ?>
                                <li><a title="<?php echo $lang["pdf"]; ?>"class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="pdf" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-file-pdf-o"></i> <?php echo $lang["pdf"]; ?></a></li>                            
                    <?php } if ($settings["excelBtn"]) { ?>
                                <li><a title="<?php echo $lang["excel"]; ?>" class="artify-actions artify-button artify-button-export" href="javascript:;" data-action="exporttable" data-export-type="excel" data-objkey="<?php echo $objKey; ?>"><i class="fa fa-file"></i> <?php echo $lang["excel"]; ?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                    <?php if ($settings["recordsPerPageDropdown"]) { ?>
                        <div class="btn-group pull-right">
                            <?php echo $perPageRecords; ?>
                        </div>
                    <?php } ?>
                        <?php if ($settings["pagination"]) { ?>
                        <div class="btn-group pull-right artify-pagination">
                            <?php echo $pagination; ?>
                        </div>
                         <?php } ?>
                    <div style="clear:both"></div>
                </div>  </div>  
        </div><!-- /.box-body -->
    </div><!-- /.box -->
<?php echo $modal; ?>
<?php if (!$settings["back_operation"]) { ?>
    </section><!-- /.content -->
<?php
}?>