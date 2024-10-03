<div class="table-responsive">
    <table class="artify-table table table-striped table-hover table-bordered table-condensed <?php if(isset($settings["tableCellEdit"]) && $settings["tableCellEdit"]) echo "artify-excel-table" ?>" data-obj-key="<?php echo $objKey; ?>">
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
                    if(!in_array($column["col"], $colsRemove)){
                    ?>
                        <th <?php echo $column["attr"]; ?> data-action="<?php echo $column["sort"]; ?>"  data-sortkey="<?php echo $colkey; ?>" data-rendertype="CRUD" class="artify-actions-sorting artify-<?php echo $column["sort"]; ?>">
                            <span> <?php echo $column["colname"];
                            echo $column["tooltip"];
                            ?>
                            </span>
                        </th>
                    <?php }
                }
                if ($settings["actionbtn"]) {
                    ?>
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
        $rowcount = $settings["row_no"];
        if ($data)
            foreach ($data as $rows) {
            $sumrow = false;
                ?>
                <tr data-id="<?php if(isset($rows[$pk])) echo $rows[$pk]; ?>" id="artify-row-<?php echo $rowcount; ?>" class="artify-data-row <?php if(isset($rows[0]["class"])) echo $rows[0]["class"]; ?>" <?php if(isset($rows[0]["style"])) echo $rows[0]["style"]; ?>>
                   <?php  if ($settings["numberCol"]) { ?>
                    <td class="artify-row-count">
                    <?php echo $rowcount + 1; ?>
                    </td>
                   <?php } if ($settings["checkboxCol"]) { ?>
                    <td class="artify-row-checkbox-actions">
                        <input type="checkbox" class="artify-select-cb" value="<?php echo $rows[$pk]; ?>" />
                    </td>
                    <?php }
                    foreach ($rows as $col => $row) {
                         if(!in_array($col, $colsRemove)){
                        if (is_array($row)) {
                            ?>    
                            <td class="artify-row-cols <?php if(isset($row["class"])) echo $row["class"]; ?>"  <?php if(isset($row["style"])) echo $row["style"]; ?>>
                            <?php if(isset($row["sum_type"])) { echo $lang[$row["sum_type"]]; $sumrow = true; }?>
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
                        
                        $url = preg_replace_callback('/{([^}]+)}/', function ($matches) use ($rows) {
                            $field = $matches[1]; // El campo dentro de las llaves
                            return isset($rows[$field]) ? $rows[$field] : $matches[0]; // Devuelve el valor del campo o el marcador original si no existe
                        }, $url);
                        
                        if (is_array($text) && isset($text[$rows[$colName]])){
                            $action_text = $text[$rows[$colName]];
                        } else {
                            $action_text = $text;
                        }

                        $skipBtn = false;
                        
                        if(!empty($btnWhere) && is_array($btnWhere) && count($btnWhere)){
                            $field = $btnWhere[0];
                            if(!empty($btnWhere[1]) && $btnWhere[1] === "="){
                                $skipBtn = true;
                                if(!empty($btnWhere[2]) && in_array($rows[$field], $btnWhere[2])){
                                    $skipBtn = false;
                                }
                            }
                            else if(!empty($btnWhere[1]) && $btnWhere[1] === "!="){
                                $skipBtn = true;
                                if(!empty($btnWhere[2]) && !in_array($rows[$field], $btnWhere[2])){
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
                <?php } if ($settings["checkboxCol"]) { ?>
                    <th class="w1">
                        <input type="checkbox" value="select-all" name="artify_select_all" class="artify-select-all"  />
                    </th>
                <?php } ?>
                <?php if ($columns) foreach ($columns as $colkey => $column) { 
                    if(!in_array($column["col"], $colsRemove)){
                    ?>
                        <th <?php echo $column["attr"]; ?> data-action="<?php echo $column["sort"]; ?>"  data-sortkey="<?php echo $colkey; ?>" class="artify-actions-sorting artify-<?php echo $column["sort"]; ?>">
                            <?php echo $column["colname"];
                            echo $column["tooltip"];
                            ?>
                        </th>
                    <?php }
                }
                if ($settings["actionbtn"]) {
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