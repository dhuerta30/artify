<style>
    label {
        color: #000;
    }
</style>
<?php
foreach ($data as $key => $row) {
    $isLeftColumn = $key >= 0 && $key <= 10; // Improved condition for left column

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
            <p class="artify_help_block help-block form-text with-errors"></p>
        </div>
        <?php
    } else {
        // Content for right column (assuming key > 10)
        if ($key === 11) { // Start right column only on the first element after 10
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
            <p class="artify_help_block help-block form-text with-errors"></p>
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