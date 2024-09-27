<!-- CSS Styles -->
<style type="text/css">
    .xinvoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        font-size: 16px;
        line-height: 24px;
        color: #555;
        background: #d5d5d5;
    }
    .xinvoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    .xinvoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .xinvoice-box table.xinvoice-sender-receiver tr td:nth-child(2) {
        text-align: left;
        float: right;
    }
    .xinvoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    .xinvoice-box table.xinvoice-header tr td.xinvoice-logo {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    .xinvoice-box table.xinvoice-header tr td:nth-child(2) {
        text-align: right;
    }
    .xinvoice-box table tr.xinvoice-sender-receiver table td {
        padding-bottom: 40px;
    }
    .xinvoice-box table tr.xinvoice-item-heading td {
        font-weight: bold;
        color: #fff;
        background: #555090;
    }
    .xinvoice-box table tr.details td {
        padding-bottom: 20px;
    }
    .xinvoice-box table thead tr td{
        border-bottom: 1px solid #eee;
        text-align: center;
    }
    .xinvoice-box table tr.xitem td{
        border-bottom: 1px solid #eee;
        text-align: center;
    }
    .xinvoice-box table tr.xitem.last td {
        border-bottom: none;
    }
    .xinvoice-box table tr.xtotal td {
        text-align: center;
    }
    .xinvoice-box table tr.xtotal td:nth-child(2) {
        font-weight: bold;
    }
    .xinvoice-box table.xinvoice-footer{
        text-align: center;
        font-size: 14px;
    }
    table.xinvoice-items tr td{
        vertical-align: middle;
        height: 50px;
    }
    td.xinvoice-footer-data{
        font-size: 12px;
    }
    table.xinvoice-items tr.xtotal td.xtotal-heading-label{
        height: 40px;
        border-top: none;
        font-weight: bold;
        text-align: right;
    }
    table.xinvoice-items tr.xtotal td.xtotal-heading-data{
        height: 40px;
        border-top: none;
        text-align: center;
    }
    span.xinvoice-payment-label{
        color: #555090;
    }
    tr.xtotal{
        background: #555090;
        color: #fff;
    }
    tr.xtotal td{
        color: #fff;
    }
</style>

<div class="xinvoice-box">
    <?php if (isset($data["section"]["before_header"]["data"])) echo $data["section"]["before_header"]["data"];?>
    <!--Header Section start-->
    <?php if (!isset($data["header"]["display"]) || (isset($data["header"]["display"]) && $data["header"]["display"])) { ?>
        <table cellpadding="0" cellspacing="0" class="xinvoice-header" style="<?php if (isset($data["header"]["style"])) echo $data["header"]["style"]; ?>">
            <tr>
                <td class="xinvoice-logo">
                    <?php
                    if (!isset($data["company"]["logo"]["display"]) || (isset($data["company"]["logo"]["display"]) && $data["company"]["logo"]["display"])) {
                        if (isset($data["company"]["logo"]["data"]))
                            echo $data["company"]["logo"]["data"];
                    }
                    ?>
                </td>
                <td class="xinvoice-sender">
                    <br/>
                    <?php
                    if (!isset($data["from"]["display"]) || (isset($data["from"]["display"]) && $data["from"]["display"] ))
                        foreach ($data["from"] as $key => $val) {
                            $style = "";
                            if (isset($val["display"]) && $val["display"] === false)
                                continue;
                            if (isset($val["style"])) $style = $val["style"];
                            if (isset($val["label"])) echo "<span class='xinvoice-invoice-label'>".$val["label"]. "</span>";
                            if (isset($val["data"]))  echo "<span class='xinvoice-invoice-data' style='". $style ."'>".$val["data"]. "</span><br/>";
                        }
                    ?>
                </td>
            </tr>
        </table>
        <?php
    }
    ?>
    <?php if (isset($data["section"]["after_header"]["data"])) echo $data["section"]["after_header"]["data"];?>
    <!-- Header section end-->
    <!-- Sender and Receiver Details start-->
    <?php if (isset($data["section"]["before_sender_receiver"]["data"])) echo $data["section"]["before_sender_receiver"]["data"];?>
    <?php if (!isset($data["sender_receiver"]["display"]) || (isset($data["sender_receiver"]["display"]) && $data["sender_receiver"]["display"])) { ?>
    <table cellpadding="0" cellspacing="0" class="xinvoice-sender-receiver" style="<?php if (isset($data["sender_receiver"]["style"])) echo $data["sender_receiver"]["style"]; ?>">
        <tr>
            <td class="xinvoice-receiver">
                <?php
                if (!isset($data["to"]["display"]) || (isset($data["to"]["display"]) && $data["to"]["display"]))
                    foreach ($data["to"] as $key => $val) {
                        $style = "";
                        if (isset($val["display"]) && $val["display"] === false)
                            continue;
                        if (isset($val["style"])) $style = $val["style"];
                        if (isset($val["label"])) echo "<span class='xinvoice-invoice-label'>".$val["label"]. "</span>";
                        if (isset($val["data"]))  echo "<span class='xinvoice-invoice-data' style='". $style ."'>".$val["data"]. "</span><br/>";
                    }
                ?>
            </td>
            <td class="xinvoice-invoice-details">
                <?php
                if (isset($data["invoice"]))
                    foreach ($data["invoice"] as $key => $val) {
                        $style = "";
                        if (isset($val["display"]) && $val["display"] === false)
                            continue;
                        if (isset($val["style"])) $style = $val["style"];
                        if (isset($val["label"])) echo "<span class='xinvoice-invoice-label'>".$val["label"]. "</span>";
                        if (isset($val["data"]))  echo "<span class='xinvoice-invoice-data' style='". $style ."'>".$val["data"]. "</span><br/>";
                        ?>
                        <?php
                    }
                ?>
            </td>
        </tr>
    </table>
    <?php }
    ?>
    <?php if (isset($data["section"]["after_sender_receiver"]["data"])) echo $data["section"]["after_sender_receiver"]["data"];?>
    <!--Sender and Receiver Details end-->
    <!--Item Details start -->
    <?php if (isset($data["section"]["before_items"]["data"])) echo $data["section"]["before_items"]["data"];?>
    <?php if (!isset($data["items"]["display"]) || (isset($data["items"]["display"]) && $data["items"]["display"])) { ?>
    <table cellpadding="0" cellspacing="0" class="xinvoice-items" style="<?php if (isset($data["items"]["style"])) echo $data["items"]["style"]; ?>">
        <thead>
            <tr class="xinvoice-item-heading">
                <?php
                if (!isset($data["itemcount"]["display"]) || (isset($data["itemcount"]["display"]) && $data["itemcount"]["display"] )) {
                    ?>
                    <td class="xitem-count">
                        <?php if (isset($data["itemcount"]["count"]["label"])) echo $data["itemcount"]["count"]["label"]; ?>
                    </td>
                    <?php
                }
                $col = 0;
                foreach ($data["item"] as $key => $val) {
                    foreach ($val as $itemName => $itemData) {
                        if (isset($itemData["display"]) && $itemData["display"] === false)
                            continue;
                        if (isset($itemData["label"]))
                            echo "<td>" . $itemData["label"] . "</td>";
                        $col++;
                    }
                    break;
                }
                ?>
            </tr>
        </thead>
            <?php
            $countItem = 0;
            if (isset($data["itemcount"]["display"]) && !$data["itemcount"]["display"] ) {
                $col = $col -1;
            }
            foreach ($data["item"] as $key => $item) {
                $rowClass = "xinvoice-items-odd";
                if($countItem %2 === 0)
                    $rowClass = "xinvoice-items-even";
                $countItem++;
                ?>
                <tr class="xitem <?php echo $rowClass;?>">
                    <?php
                    if (!isset($data["itemcount"]["display"]) || (isset($data["itemcount"]["display"]) && $data["itemcount"]["display"] )) {
                        ?>
                        <td class="xitem-count">
                            <?php echo $countItem; ?>
                        </td>
                        <?php
                    }
                    ?>
                <?php
                foreach ($item as $itemName => $itemData) {
                    if (isset($data["item"][0][$itemName]["display"]) && $data["item"][0][$itemName]["display"] === false)
                        continue;
                    if (isset($itemData["data"]))
                        echo "<td>" . $itemData["data"] . "</td>";
                }
                ?>
                </tr>
                <?php
                }
        ?>
    </table>
    <?php }
    ?>
    <?php if (isset($data["section"]["after_items"]["data"])) echo $data["section"]["after_items"]["data"];?>
    <!-- Item Details end -->
    <!-- Payment Details start -->
    <?php if (isset($data["section"]["before_payment"]["data"])) echo $data["section"]["before_payment"]["data"];?>
    <?php if (!isset($data["payment"]["display"]) || (isset($data["payment"]["display"]) && $data["payment"]["display"] )) { ?>
    <table class="xinvoice-payment-total">
        <tr>
            <td>
                <table class="xinvoice-payment-details" style="<?php if (isset($data["payment"]["style"])) echo $data["payment"]["style"]; ?>">
                    <?php
                    foreach ($data["payment"] as $key => $val) {
                        $style = "";
                        if (isset($val["display"]) && $val["display"] === false)
                            continue;
                        ?>
                        <tr>
                            <td class="xinvoice-payment xinvoice-payment-<?php echo $key ?>">
                                <?php if (isset($val["style"])) $style = $val["style"]; ?>
                                <?php if (isset($val["label"])) echo "<span class='xinvoice-payment-label'>".$val["label"]. "</span>"; ?>
                                <?php if (isset($val["data"])) echo "<span class='xinvoice-payment-data' style='". $style ."'>".$val["data"]. "</span>";?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </td>
            <td>
                <table>
                    <?php if (isset($data["total"])) {
                        foreach ($data["total"] as $key => $val) {
                            $style = "";
                            if (isset($val["display"]) && $val["display"] === false)
                                continue;
                            if (isset($val["style"])) $style = $val["style"];
                            ?>
                            <tr class="xtotal xtotal-<?php echo $key ?>">
                                <td class="xtotal-heading-label" colspan="<?php echo $col; ?>">
                                        <?php if (isset($val["label"])) echo "<span class='xinvoice-total-label'>".$val["label"]. "</span>" ?>
                                </td>
                                <td class="xtotal-heading-data">
                                    <?php if (isset($val["data"]))  echo "<span class='xinvoice-total-data' style='". $style ."'>".$val["data"]. "</span><br/>"; ?>
                                </td>
                            </tr>
                            <?php
                            }
                        } 
                    ?>
                </table>
            </td>
        </tr>
    </table>
        <?php
        }
    ?>
    <?php if (isset($data["section"]["after_payment"]["data"])) echo $data["section"]["after_payment"]["data"];?>
    <!-- Payment Details end -->
    <!-- Message Details start -->
    <?php if (isset($data["section"]["before_message"]["data"])) echo $data["section"]["before_message"]["data"];?>
    <?php if (!isset($data["message"]["display"]) || (isset($data["message"]["display"]) && $data["message"]["display"] )) { ?>
        <table width="100%" class="xinvoice-message" style="<?php if (isset($data["message"]["style"])) echo $data["message"]["style"]; ?>">
            <?php
            foreach ($data["message"] as $key => $val) {
                $style = "";
                if (isset($val["display"]) && $val["display"] === false)
                    continue;
                ?>
                    <tr>
                        <td class="xinvoice-message-<?php echo $key ?>">
                            <?php if (isset($val["style"])) $style = $val["style"]; ?>
                            <?php if (isset($val["label"])) echo "<span class='xinvoice-message-label'>".$val["label"]. "</span>"; ?>
                            <?php if (isset($val["data"])) echo "<span class='xinvoice-message-data' style='". $style ."'>".$val["data"]. "</span>";?>
                        </td>
                    </tr>
                <?php
            }
            ?>
        </table>
    <?php
    }
    ?>
    <?php if (isset($data["section"]["after_message"]["data"])) echo $data["section"]["after_message"]["data"];?>
    <!-- Message Details end -->
    <!-- Footer Details start -->
    <?php if (isset($data["section"]["before_footer"]["data"])) echo $data["section"]["before_footer"]["data"];?>
    <?php if (!isset($data["footer"]["display"]) || (isset($data["footer"]["display"]) && $data["footer"]["display"] )) { ?>
        <htmlpagefooter name="xinvoice-footer-section">
            <table width="100%" class="xinvoice-footer" style="<?php if (isset($data["footer"]["style"])) echo $data["footer"]["style"]; ?>">
                <?php
                foreach ($data["footer"] as $key => $val) {
                    $style = "";
                    if (isset($val["display"]) && $val["display"] === false)
                        continue;
                    ?>
                        <tr>
                            <td class="xinvoice-footer-<?php echo $key ?>">
                                <?php if (isset($val["style"])) $style = $val["style"]; ?>
                                <?php if (isset($val["label"])) echo "<span class='xinvoice-footer-label'>".$val["label"]. "</span>"; ?>
                                <?php if (isset($val["data"])) echo "<span class='xinvoice-footer-data' style='". $style ."'>".$val["data"]. "</span>";?>
                            </td>
                        </tr>
                    <?php
                }
                ?>
            </table>
        </htmlpagefooter>
        <sethtmlpagefooter name="xinvoice-footer-section" value="on" />
        <?php
    }
    ?>
    <?php if (isset($data["section"]["after_footer"]["data"])) echo $data["section"]["after_footer"]["data"];?>
    <!-- Footer Details end -->
</div>