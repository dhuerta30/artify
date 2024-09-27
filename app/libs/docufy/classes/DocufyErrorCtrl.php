<?php

Class DocufyErrorCtrl {

    private $errors = array();
    private $settings;
    
    public function __construct($settings = array()) {
        $this->settings = $settings;
    }

    function addError($error, $override = false) {
        $this->errors[] = $error;
        $this->writeLogs($error);
        if ($override) {
            echo $error;
            die();
        }
    }

    function getErrors() {
        return $this->errors;
    }
    
    /**
     * Writes logs if enabled in config 
     * @param   string   $text                          error text
     * return   object                                  Object of class
     */
    public function writeLogs($text) {
        try {
            if (isset($this->settings["enableLogs"]) && $this->settings["enableLogs"]) {
                $text = "\n" . date('Y-m-d H:i:s') . " " . $text;
                $handle = fopen($this->settings["logFile"], 'a');
                fwrite($handle, $text);
                fclose($handle);
            }
        } catch (Exception $e) {
            
        }
        return $this;
    }

}