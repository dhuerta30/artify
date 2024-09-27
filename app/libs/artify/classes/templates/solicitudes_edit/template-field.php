<style>
    label {
        color: #fff;
    }
</style>
<?php
foreach ($data as $key => $row) {
    $isLeftColumn = $key >= 0 && $key <= 6; // Improved condition for left column
    $isMiddleColumn = $key >= 7 && $key <= 11; // Condition for the second right column
    $isFullWidthColumn = $key > 11; // Condition for full width column

    if ($key === 0) {
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-1">
                    <div class="card-header text-white">Datos del Paciente</div>
                        <div class="card-body form">
        <?php
    }

    if ($isLeftColumn) {
        // Content for left column
        ?>
        <div class="form-group">
            <?php echo $row["lable"]; echo $row["tooltip"]; ?>
            <?php echo $row["element"]; ?>
        </div>
        <?php
    } elseif ($isMiddleColumn) {
        // Content for right column (6-10)
        if ($key === 7) { // Start right column only on the first element after 5
            ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-1">
                    <div class="card-header text-white">Datos de la Muestra</div>
                        <div class="card-body form">
            <?php
        }
        ?>
        <div class="form-group">
            <?php echo $row["lable"]; echo $row["tooltip"]; ?>
            <?php echo $row["element"]; ?>
        </div>
        <?php
    } elseif ($isFullWidthColumn) {
        // Content for full width column (11 and above)
        if ($key === 12) { // Start full width column only on the first element after 10
            ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-header text-white">Resultado</div>
                        <div class="card-body form">
            <?php
        }
        ?>
        <div class="form-group">
            <?php echo $row["lable"]; echo $row["tooltip"]; ?>
            <?php echo $row["element"]; ?>
        </div>
        <?php
    }

    if ($key === count($data) - 1) { // Close row at the end
        ?>
                </div>
            </div>
        </div>
        </div>
        <?php
    }
}
?>
