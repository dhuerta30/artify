<div class="row">
<div class="col-md-12">

        <div class="card mb-1">
            <div class="card-header page-title">Detalle de Muestra</div>
                <div class="card-body form">

                    <div class="component addrow float-right">
                        <div class="control-group">
                            <div class="controls">
                                <a class="artify-actions artify-button artify-button-add-row btn btn-success" href="javascript:;" data-action="add_row">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $lang["add_row"]; ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php
                        $body = "";
                        $rowCount = 1;
                        foreach ($data as $rows) {
                            $header = "<th>#</th>";
                            $body .= "<tr>";
                            $body .= "<td class='text-right'><input type='text' class='form-control valor_aumentado' value='1' readonly='true'></td>";
                            $colCount = 1;
                            foreach ($rows as $row) {
                                $header .= "<th>" . $row["lable"] . $row["tooltip"] . "</th>";
                                $body .= "<td class='artify_leftjoin_row_$rowCount artify_leftjoin_col_$colCount'>" . $row["element"] . "</td>";
                                $colCount++;
                            }
                            $body .= ' <td class="text-right"><a href="javascript:;" class="artify-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> ' . $lang["remove"] . '</a></td>';
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


                </div>
            </div>
        </div>
</div>
