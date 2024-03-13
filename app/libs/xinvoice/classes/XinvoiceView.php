<?php

Class XinvoiceView {

    private $template_path;

    function __construct() {
        $this->template_path = XInvoiceABSPATH . "/templates/";
    }

    public function renderHTML($templateName, $data) {
        ob_start();
        require $this->template_path . "$templateName";
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
