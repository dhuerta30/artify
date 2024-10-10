<div class="component addrow float-right">
    <div class="control-group mb-3">
        <div class="controls">
            <a class="artify-actions artify-button artify-button-add-row btn btn-success" href="javascript:;" data-action="add_row_artify">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $lang["add_row"]; ?>
            </a>
            <a href="javascript:;" id="generateSQL" class="btn btn-primary generar_modificacion d-none">Generar Modificación</a>
        </div>
    </div>
</div>
<?php
$body = "";
$rowCount = 1;
foreach ($data as $rows) {
    $header = "";
    $body .= "<tr class='leftjoin_tr'>";
    $body .= "";
    $colCount = 1;
    foreach ($rows as $row) {
        $header .= "<th>" . $row["lable"] . $row["tooltip"] . "</th>";
        $body .= "<td class='artify_leftjoin_row_$rowCount artify_leftjoin_col_$colCount'>" . $row["element"] . "</td>";
        $colCount++;
    }
    $body .= ' <td><a href="javascript:;" class="artify-actions btn btn-danger d-none eliminar_filas" data-action="delete_row"><i class="fa fa-remove"></i> ' . $lang["remove"] . '</a></td>';
    $body .= "</tr>";
    $rowCount++;
}
?>
<div class="table-responsive mb-4">
<table class="table artify-left-join responsive">
    <thead>
        <tr class="bg-dark">
            <?php if (isset($header)) echo $header; ?>
            <th><label class="control-label col-form-label">Acción</label></th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($body)) echo $body; ?>
    </tbody>
</table>
</div>


<style>
label:not(.form-check-label):not(.custom-file-label) {
   justify-content: center;
}
</style>

<div class="form-group mt-4 text-center">
    <input type="submit" class="btn btn-primary artify-form-control artify-submit mb-3" data-action="insert" value="Guardar">
    <button type="button" class="btn btn-danger artify-form-control artify-button mb-3 artify-back regresar_tablas" data-action="back">Regresar</button> 
    <button type="reset" class="btn btn-danger artify-form-control artify-button mb-3 artify-cancel-btn">Cancelar</button>
</div>