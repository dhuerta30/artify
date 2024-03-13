<!-- CSS Styles -->
<style type="text/css">
    .xinvoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
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
    .xinvoice-box table.xinvoice-info tr td:nth-child(2) {
        text-align: right;
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
    .xinvoice-box table tr.xinvoice-info table td {
        padding-bottom: 40px;
    }
    .xinvoice-box table tr.xinvoice-item-heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    .xinvoice-box table tr.details td {
        padding-bottom: 20px;
    }
    .xinvoice-box table tr.xitem td{
        border-bottom: 1px solid #eee;
    }
    .xinvoice-box table tr.xitem.last td {
        border-bottom: none;
    }
    .xinvoice-box table tr.xtotal td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    .xinvoice-box table tr.xtotal td.xtotal-heading {
        border-top: 2px solid #eee;
        font-weight: bold;
        text-align: right;
    }
</style>

<div class="xinvoice-box">
    <?php if (isset($data["section"]["before_header"]["data"])) echo $data["section"]["before_header"]["data"];?>
    <!--Header Section start-->
    <?php if (!isset($data["header"]["display"]) || (isset($data["header"]["display"]) && $data["header"]["display"])) { ?>
        <table cellpadding="0" cellspacing="0" class="xinvoice-header" style="<?php if (isset($data["header"]["style"])) echo $data["header"]["style"]; ?>">
            <tr>
                <td class="xinvoice-logo">
                    <?php if (isset($data["company"]["logo"]["data"])) echo $data["company"]["logo"]["data"]; ?>
                </td>
                <td class="xinvoice-invoice-details">
                    <?php
                    if (isset($data["invoice"]))
                        foreach ($data["invoice"] as $key => $val) {
                            if (isset($val["display"]) && $val["display"] === false)
                                continue;
                            if (isset($val["label"])) echo $val["label"];
                            if (isset($val["data"]))  echo $val["data"]. "<br/>";
                            ?>
                            <?php
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
    <table cellpadding="0" cellspacing="0" class="xinvoice-info">
        <tr>
            <td>
                <?php
                if (!isset($data["from"]["display"]) || (isset($data["from"]["display"]) && $data["from"]["display"] ))
                    foreach ($data["from"] as $key => $val) {
                        if (isset($val["display"]) && $val["display"] === false)
                            continue;
                        if (isset($val["label"])) echo $val["label"];
                        if (isset($val["data"])) echo $val["data"] . "<br/>";
                    }
                ?>
            </td>
            <td>
                <?php
                if (!isset($data["to"]["display"]) || (isset($data["to"]["display"]) && $data["to"]["display"]))
                    foreach ($data["to"] as $key => $val) {
                        if (isset($val["display"]) && $val["display"] === false)
                            continue;
                        if (isset($val["label"])) echo $val["label"];
                        if (isset($val["data"])) echo $val["data"] . "<br/>";
                    }
                ?>
            </td>
        </tr>
    </table>
    <?php if (isset($data["section"]["after_sender_receiver"]["data"])) echo $data["section"]["after_sender_receiver"]["data"];?>
    <!--Sender and Receiver Details end-->
    <!--Item Details start -->
    <?php if (isset($data["section"]["before_items"]["data"])) echo $data["section"]["before_items"]["data"];?>
    <table cellpadding="0" cellspacing="0">
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
            <?php
            $countItem = 0;
            foreach ($data["item"] as $key => $item) {
                $countItem++;
                ?>
                    <tr class="xitem">
                        <?php
                        if (!isset($data["itemcount"]["display"]) || (isset($data["itemcount"]["display"]) && $data["itemcount"]["display"] )) {
                            ?>
                            <td class="xitem-count">
                                <?php echo $countItem; ?>
                            </td>
                            <?php
                        } else
                            $col--;
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
                if (isset($data["total"])) {
                    foreach ($data["total"] as $key => $val) {
                        if (isset($val["display"]) && $val["display"] === false)
                            continue;
                        ?>
                        <tr class="xtotal xtotal-<?php echo $key ?>">
                            <td class="xtotal-heading" colspan="<?php echo $col; ?>">
                                <?php if (isset($val["label"])) echo $val["label"]; ?>
                            </td>
                            <td>
                                <?php if (isset($val["data"])) echo $val["data"]; ?>
                            </td>
                        </tr>
                <?php
            }
        }
        ?>
    </table>
    <?php if (isset($data["section"]["after_items"]["data"])) echo $data["section"]["after_items"]["data"];?>
    <!-- Item Details end -->
    <!-- Payment Details start -->
    <?php if (isset($data["section"]["before_payment"]["data"])) echo $data["section"]["before_payment"]["data"];?>
    <?php if (!isset($data["payment"]["display"]) || (isset($data["payment"]["display"]) && $data["payment"]["display"] )) { ?>
            <table class="xinvoice-payment-details">
                <?php
                foreach ($data["payment"] as $key => $val) {
                    if (isset($val["display"]) && $val["display"] === false)
                        continue;
                    ?>
                    <tr>
                        <td class="xinvoice-payment xinvoice-payment-<?php echo $key ?>">
                            <?php if (isset($val["label"])) echo $val["label"]; ?>
                            <?php if (isset($val["data"])) echo $val["data"]; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        <?php
        }
    ?>
    <?php if (isset($data["section"]["after_payment"]["data"])) echo $data["section"]["after_payment"]["data"];?>
    <!-- Payment Details end -->
    <!-- Footer Details start -->
    <?php if (isset($data["section"]["before_footer"]["data"])) echo $data["section"]["before_footer"]["data"];?>
    <?php if (!isset($data["footer"]["display"]) || (isset($data["footer"]["display"]) && $data["footer"]["display"] )) { ?>
            <table class="xinvoice-footer">
                <?php
                foreach ($data["footer"] as $key => $val) {
                    if (isset($val["display"]) && $val["display"] === false)
                        continue;
                    ?>
                        <tr>
                            <td class="xinvoice-footer-<?php echo $key ?>">
                                <?php if (isset($val["label"])) echo $val["label"]; ?>
                                <?php if (isset($val["data"])) echo $val["data"]; ?>
                            </td>
                        </tr>
                    <?php
                }
                ?>
            </table>
        <?php
    }
    ?>
    <?php if (isset($data["section"]["after_footer"]["data"])) echo $data["section"]["after_footer"]["data"];?>
    <!-- Footer Details end -->
</div>