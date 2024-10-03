<div class="component addrow float-right">
    <div class="control-group">
        <div class="controls">
            <a class="artify-actions artify-button artify-button-add-row btn btn-success agregar_muestras d-none" href="javascript:;" data-action="add_row_module">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $lang["add"]; ?>
            </a>
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
    $body .= ' <td><a href="javascript:;" class="artify-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> ' . $lang["remove"] . '</a></td>';
    $body .= "</tr>";
    $rowCount++;
}
?>
<div class="table-responsive">
<table class="table artify-left-join responsive">
    <thead>
        <tr>
            <?php if (isset($header)) echo $header; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($body)) echo $body; ?>
    </tbody>
</table>
</div>
