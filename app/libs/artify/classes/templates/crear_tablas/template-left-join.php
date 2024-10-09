<div class="component addrow float-right">
    <div class="control-group">
        <div class="controls">
            <a class="artify-actions artify-button artify-button-add-row btn btn-success" href="javascript:;" data-action="add_row_artify">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $lang["add_row"]; ?>
            </a>
            <a href="javascript:;" id="generateSQL" class="btn btn-primary d-none">Generar Modificación</a>
        </div>
    </div>
</div>
<?php
$body = "";
$rowCount = 1;
foreach ($data as $rows) {
    $header = "";
    $body .= "<tr>";
    $body .= "";
    $colCount = 1;
    foreach ($rows as $row) {
        $header .= "<th>" . $row["lable"] . $row["tooltip"] . "</th>";
        $body .= "<td class='artify_leftjoin_row_$rowCount artify_leftjoin_col_$colCount'>" . $row["element"] . "</td>";
        $colCount++;
    }
    $body .= '<td><input class="check_modificar d-none" type="checkbox" name="estructura_tabla#$modificado[]" /></td>';
    $body .= ' <td><a href="javascript:;" class="artify-actions btn btn-danger d-none eliminar_filas" data-action="delete_row"><i class="fa fa-remove"></i> ' . $lang["remove"] . '</a></td>';
    $body .= "</tr>";
    $rowCount++;
}
?>
<div class="table-responsive mb-4">
<table class="table artify-left-join responsive">
    <thead>
        <tr>
            <?php if (isset($header)) echo $header; ?>
            <th class="modificar_campo d-none">Modificar Campo</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($body)) echo $body; ?>
    </tbody>
</table>
</div>
