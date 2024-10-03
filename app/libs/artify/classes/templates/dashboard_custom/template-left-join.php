<div class="row">
<div class="col-md-12">

        <div class="card mb-1">
            <div class="card-header page-title"><?php echo $lang["title_left_join"]; ?></div>
                <div class="card-body form">

                    <div class="component addrow float-right">
                        <div class="control-group">
                            <div class="controls">
                                <a class="artify-actions artify-button artify-button-add-row btn btn-info" href="javascript:;" data-action="add_row">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $lang["add_row"]; ?>
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
                            $colCount = 1;
                            foreach ($rows as $row) {
                                $header .= "<th>" . $row["lable"] . $row["tooltip"] . "</th>";
                                $body .= "<td class='form-group artify_leftjoin_row_$rowCount artify_leftjoin_col_$colCount'>" . $row["element"];
                                $colCount++;
                            }
                            //$body .= ' <td class="form-group artify_leftjoin_row_1 artify_leftjoin_col_1"><a href="javascript:;" class="artify-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> ' . $lang["remove"] . '</a></td>';
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
