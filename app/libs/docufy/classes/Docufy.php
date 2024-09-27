<?php

class Docufy
{
    protected $view;
    protected $errCtrl;
    protected $helper;
    protected $settings;
    protected $data;
    protected $langData;
    protected $html;
    protected $templateName;
    protected $totals;
    protected $itemTotals;
    protected $formatData;
    protected $callback;
    protected $colAdd;
    protected $reorderItems;
    protected $email;

    public function __construct($settings = array())
    {
        $this->loadSettings($settings);
        $this->errCtrl = new DocufyErrorCtrl($this->settings);
        $this->helper = new DocufyHelper($this->errCtrl);
        $this->loadLangData();
        $this->loadDefaultData();
        $this->view = new DocufyView();
    }

    protected function loadSettings($settings)
    {
        global $xSettings;
        $this->settings = $xSettings;
        if (is_array($settings) && count($this->settings)) {
            $this->settings = array_merge($this->settings, $settings);
        }
        $this->currentLang = $this->settings["lang"];
        return $this;
    }

    protected function loadLangData()
    {
        $file = DocufyABSPATH . '/languages/' . $this->currentLang . '.ini';
        if (!file_exists($file)) {
            $this->currentLang = "en";
            $file = DocufyABSPATH . '/languages/' . $this->currentLang . '.ini';
        } else {
            $this->errCtrl->addError($this->getLangData("valid_data_file_name"));
        }

        $this->langData = parse_ini_file($file);
        return $this;
    }

    protected function loadDefaultData()
    {
        if (isset($this->settings["datafile"]) && isset($this->settings["defaultData"]) && $this->settings["defaultData"]) {
            $file = DocufyABSPATH . "config/data-files/" . $this->settings["datafile"] . ".php";
            if (file_exists($file)) {
                require_once DocufyABSPATH . "config/data-files/" . $this->settings["datafile"] . ".php";
                global $xData;
                $this->data = $xData;
            } else {
                $this->errCtrl->addError($this->getLangData("valid_data_file_name"));
            }
        }
        return $this;
    }

    /**
     * Get particular configuration setting
     * @param    string   $setting              Config Key for which setting needs to be retreived 
     * return    mixed                          Configuaration setting value
     */
    public function getSettings($setting)
    {
        if (isset($this->settings[$setting]))
            return $this->settings[$setting];
        else
            return $this->getLangData("no_settings_found");
    }

    /**
     * Set particular configuration setting
     * @param   string   $setting                   Config key for setting
     * @param   mixed    $value                     Value for setting
     * return   object                              Object of class
     */
    public function setSettings($setting, $value)
    {
        $this->settings[$setting] = $value;
        return $this;
    }

    /**
     * Set current language
     * @param   string   $lang                            language to be used
     * return   object                                    Object of class
     */
    public function setCurrentLang($lang)
    {
        $this->currentLang = $lang;
        return $this;
    }

    /**
     * Return language data
     * @param   string   $param                           Get data for language
     * return   sting                                     language translation for the parameter
     */
    public function getLangData($param)
    {
        if (isset($this->langData[$param]))
            return $this->langData[$param];
        return $param;
    }

    /**
     * Set language data
     * @param   string   $param                          lanuguage key for which data needs to save
     * @param   string   $val                            Value for the language parameter
     * return   object                                   Object of class
     */
    public function setLangData($param, $val)
    {
        $this->langData[$param] = $val;
        return $this;
    }

    /**
     * Set template name
     * @param   string   $templatename                   template name to be used
     * return   object                                   Object of class
     */
    public function setTemplateName($templatename)
    {
        $this->templateName = $templatename;
        return $this;
    }

    /**
     * get current template name
     * return   string                                   current template name
     */
    public function getTemplateName()
    {
        if (!isset($this->templateName))
            $this->templateName = isset($this->settings["defaultTemplate"]) ? $this->settings["defaultTemplate"]
                : "invoice/invoice_1.php";
        return $this->templateName;
    }

    /**
     * Set the document RTL state
     * @param   string   $direction                      Defines the directionality of the document.Default is ltr
     * return   string                                   current template name
     */
    public function setDirectionality($direction = "ltr")
    {
        $this->settings["direction"] = $direction;
        return $this;
    }

    /**
     * Add callback function to be called on certain event
     * @param   string   $eventName                       Eventname for which callback function needs to be called
     * @param   string   $callback                        Name of callback function
     * return   object                                    Object of class
     */
    public function addCallback($eventName, $callback)
    {
        $this->callback[$eventName][] = $callback;
        return $this;
    }

    protected function handleCallback($eventName, $data)
    {
        if (isset($this->callback[$eventName])) {
            foreach ($this->callback[$eventName] as $callback) {
                if (is_callable($callback))
                    return call_user_func($callback, $data, $this);
            }
        }
        return $data;
    }

    /**
     * Reset all totals fields
     * return   object                                    Object of class
     */
    public function resetTotal()
    {
        unset($this->data["total"]);
        return $this;
    }

    /**
     * Reset all items
     * return   object                                    Object of class
     */
    public function resetItemFields()
    {
        unset($this->data["item"]);
        return $this;
    }

    /**
     * Set complete data array to be used for generating invoice. Supplied array needs to be in same format as 
     * $data format in the data file.
     * @param   array   $data                  data to be set
     * return   object                         Object of class
     */
    public function setInvoiceDataArray($data)
    {
        if (isset($this->data) && count($this->data))
            $this->data = array_merge($this->data, $data);
        else
            $this->data = $data;
        return $this;
    }

    /**
     * Generic function to set data of invoice
     * @param   array   $data                  data to be set
     * @param   array   $type                  type of data
     * return   object                         Object of class
     */
    public function setInvoiceData($data, $type)
    {
        switch (strtolower($type)) {
            case "header":
                return $this->setInvoiceHeaderData($data);
            case "from":
                return $this->setInvoiceFromData($data);
            case "to":
                return $this->setInvoiceToData($data);
            case "company":
                return $this->setInvoiceCompanyData($data);
            case "payment":
                return $this->setInvoicePaymentData($data);
            case "total":
                return $this->setInvoiceTotalData($data);
            case "message":
                return $this->setInvoiceMessageData($data);
            case "footer":
                return $this->setInvoiceFooterData($data);
            case "logo":
                return $this->setInvoiceLogo($data);
            case "date":
                return $this->setInvoiceDate($data);
            case "duedate":
                return $this->setInvoiceDueDate($data);
            case "items":
                return $this->setInvoiceItems($data);
            case "item":
                return $this->setInvoiceItem($data);
            case "all":
                return $this->setInvoiceCompleteData($data);
            default:
                $this->errCtrl->addError($this->getLangData("error_option"));
        }
    }

    /**
     * Set invoice 'header' details e.g. invoice no, date, due date, total due
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceHeaderData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["invoice"]))
                $this->data["invoice"] = array_replace_recursive($this->data["invoice"], $data);
            else
                $this->data["invoice"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'from' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceFromData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["from"]))
                $this->data["from"] = array_replace_recursive($this->data["from"], $data);
            else
                $this->data["from"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'to' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceToData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["to"]))
                $this->data["to"] = array_replace_recursive($this->data["to"], $data);
            else
                $this->data["to"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'Company' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceCompanyData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["company"]))
                $this->data["company"] = array_replace_recursive($this->data["company"], $data);
            else
                $this->data["company"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'Payment' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoicePaymentData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["payment"]))
                $this->data["payment"] = array_replace_recursive($this->data["payment"], $data);
            else
                $this->data["payment"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'Total' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceTotalData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["total"]))
                $this->data["total"] = array_replace_recursive($this->data["total"], $data);
            else
                $this->data["total"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'Message' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceMessageData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["message"]))
                $this->data["message"] = array_replace_recursive($this->data["message"], $data);
            else
                $this->data["message"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'Footer' details 
     * @param   array   $data                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceFooterData($data)
    {
        if (is_array($data) && count($data)) {
            array_walk_recursive($data, array($this, "addDataKey"));
            if (isset($this->data["footer"]))
                $this->data["footer"] = array_replace_recursive($this->data["footer"], $data);
            else
                $this->data["footer"] = $data;
        }
        return $this;
    }

    /**
     * Set invoice 'Logo'  
     * @param   string   $logo                  logo of company
     * return   object                          Object of Docufy
     */
    public function setInvoiceLogo($logo)
    {
        $this->data["company"]["logo"]["data"] = $logo;
        return $this;
    }

    /**
     * Set invoice 'Number'  
     * @param   string   $no                    invoice no. to be set
     * return   object                          Object of Docufy
     */
    public function setInvoiceNo($no)
    {
        $this->data["invoice"]["no"]["data"] = $no;
        return $this;
    }

    /**
     * Set invoice 'Date'  
     * @param   string   $date                  invoice date to be set
     * return   object                          Object of Docufy
     */
    public function setInvoiceDate($date)
    {
        $this->data["invoice"]["date"]["data"] = $date;
        return $this;
    }

    /**
     * Set invoice 'Due Date'  
     * @param   string   $date                  invoice due date to be set
     * return   object                          Object of Docufy
     */
    public function setInvoiceDueDate($date)
    {
        $this->data["invoice"]["due_date"]["data"] = $date;
        return $this;
    }

    /**
     * Set invoice Items  
     * @param   array   $items                  array of items to be added 
     * return   object                          Object of Docufy
     */
    public function setInvoiceItems($items)
    {
        $loop = isset($this->data["item"]) ? count($this->data["item"]) : 0;
        foreach ($items as $item) {
            foreach ($item as $key => $val) {
                $this->data["item"][$loop][$key]["data"] = $val;
            }
            $loop++;
        }
        return $this;
    }

    /**
     * Set invoice single item
     * @param   array   $item                   Item to be added 
     * return   object                          Object of Docufy
     */
    public function setInvoiceItem($item)
    {
        $loop = isset($this->data["item"]) ? count($this->data["item"]) : 0;
        foreach ($item as $key => $val) {
            $this->data["item"][$loop][$key]["data"] = $val;
        }
        return $this;
    }

    /**
     * Set invoice diffrent section data
     * @param   string   $sectionName           section name to be set
     * @param   string   $val                   value of section
     * return   object                          Object of Docufy
     */
    public function setInvoiceSections($sectionName, $val)
    {
        $this->data["section"][$sectionName]["data"] = $val;
        return $this;
    }

    /**
     * Set invoice complete data passed as in array format
     * @param   array   $invoiceData            Complete invoice data array
     * return   object                          Object of Docufy
     */
    public function setInvoiceCompleteData($invoiceData)
    {
        $itemCount = 0;
        $dbCharSeperator = isset($this->settings["dbCharSeparator"]) ? $this->settings["dbCharSeparator"] : "_";
        foreach ($invoiceData as $rows) {
            foreach ($rows as $key => $value) {
                $isItem = false;
                if ($itemCount > 0 && (strpos($key, 'item') === false))
                    continue;
                if (strpos($key, 'item') !== false)
                    $isItem = true;
                if (strpos($key, $dbCharSeperator) !== false) {
                    $keys = explode($dbCharSeperator, $key);
                    $this->updateInvoiceData($keys, $value, $itemCount, $isItem);
                }
            }
            $itemCount++;
        }
    }

    private function updateInvoiceData($keys, $value, $itemCount, $isItem = false, $type = "data")
    {
        switch (count($keys)) {
            case 1:
                $isItem ? $this->data[$keys[0]][$itemCount][$type] = $value : $this->data[$keys[0]][$type] = $value;
                break;
            case 2:
                $isItem ? $this->data[$keys[0]][$itemCount][$keys[1]][$type] = $value : $this->data[$keys[0]][$keys[1]][$type] = $value;
                break;
            case 3:
                $isItem ? $this->data[$keys[0]][$itemCount][$keys[1]][$keys[2]][$type] = $value : $this->data[$keys[0]][$keys[1]][$keys[2]][$type] = $value;
                break;
            case 4:
                $isItem ? $this->data[$keys[0]][$itemCount][$keys[1]][$keys[2]][$keys[3]][$type] = $value : $this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$type] = $value;
                break;
            case 5:
                $isItem ? $this->data[$keys[0]][$itemCount][$keys[1]][$keys[2]][$keys[3]][$keys[4]][$type] = $value : $this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$keys[4]][$type] = $value;
                break;
            default:
                return $this->data;
                break;
        }
    }


    /**
     * Generic function to set label
     * @param   array   $label                  label to be set
     * @param   array   $type                  type of label
     */
    public function setInvoiceLabel($label, $type)
    {
        switch (strtolower($type)) {
            case "header":
                return $this->setInvoiceHeaderLabel($data);
            case "from":
                return $this->setInvoiceFromLabel($label);
            case "to":
                return $this->setInvoiceToLabel($label);
            case "company":
                return $this->setInvoiceCompanyLabel($label);
            case "payment":
                return $this->setInvoicePaymentLabel($label);
            case "total":
                return $this->setInvoiceTotalLabel($label);
            case "message":
                return $this->setInvoiceMessageLabel($label);
            case "footer":
                return $this->setInvoiceFooterLabel($label);
            case "logo":
                return $this->setInvoiceLogo($label);
            case "date":
                return $this->setInvoiceDateLabel($label);
            case "duedate":
                return $this->setInvoiceDueDateLabel($label);
            case "no":
                return $this->setInvoiceNoLabel($label);
            case "item":
                return $this->setInvoiceItemsLabel($label);
            default:
                $this->errCtrl->addError($this->getLangData("error_option"));
        }
    }

    /**
     * Set invoice 'header' details 
     * @param   array   $label                   label in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceHeaderLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["invoice"]))
                $this->data["invoice"] = array_replace_recursive($this->data["invoice"], $label);
            else
                $this->data["invoice"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'from' details 
     * @param   array   $label                   label in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceFromLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["from"]))
                $this->data["from"] = array_replace_recursive($this->data["from"], $label);
            else
                $this->data["from"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'to' details 
     * @param   array   $label                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceToLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["to"]))
                $this->data["to"] = array_replace_recursive($this->data["to"], $label);
            else
                $this->data["to"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'Company' details 
     * @param   array   $label                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceCompanyLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["company"]))
                $this->data["company"] = array_replace_recursive($this->data["company"], $label);
            else
                $this->data["company"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'Payment' details 
     * @param   array   $label                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoicePaymentLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["payment"]))
                $this->data["payment"] = array_replace_recursive($this->data["payment"], $label);
            else
                $this->data["payment"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'Message' details 
     * @param   array   $label                   data in format of array
     * return   object                           Object of Docufy
     */
    public function setInvoiceMessageLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["message"]))
                $this->data["message"] = array_replace_recursive($this->data["message"], $label);
            else
                $this->data["message"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'Footer' details 
     * @param   array   $label                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceFooterLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["footer"]))
                $this->data["footer"] = array_replace_recursive($this->data["footer"], $label);
            else
                $this->data["footer"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'Total' details 
     * @param   array   $label                   data in format of array
     * return   object                          Object of Docufy
     */
    public function setInvoiceTotalLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["total"]))
                $this->data["total"] = array_replace_recursive($this->data["total"], $label);
            else
                $this->data["total"] = $label;
        }
        return $this;
    }

    /**
     * Set invoice 'Invoice no'  
     * @param   string   $label                 invoice no label to be set
     * return   object                          Object of Docufy
     */
    public function setInvoiceNoLabel($label)
    {
        $this->data["invoice"]["no"]["label"] = $label;
        return $this;
    }

    /**
     * Set invoice 'Date' Label  
     * @param   string   $label                 invoice date label to be set
     * return   object                          Object of Docufy
     */
    public function setInvoiceDateLabel($label)
    {
        $this->data["invoice"]["date"]["label"] = $label;
        return $this;
    }

    /**
     * Set invoice 'Due Date'  
     * @param   string   $label                 invoice due date label to be set
     * return   object                          Object of Docufy
     */
    public function setInvoiceDueDateLabel($label)
    {
        $this->data["invoice"]["due_date"]["label"] = $label;
        return $this;
    }

    /**
     * Set invoice Items label  
     * @param   array   $label                  array of items label to be added 
     * return   object                          Object of Docufy
     */
    public function setInvoiceItemsLabel($label)
    {
        if (is_array($label) && count($label)) {
            array_walk_recursive($label, array($this, "addLabelKey"));
            if (isset($this->data["item"][0]))
                $this->data["item"][0] = array_replace_recursive($this->data["item"][0], $label);
            else
                $this->data["item"][0] = $label;
        }
        return $this;
    }

    /**
     * Set display settings of invoice sections  
     * @param   string   $section               section of invoice
     * @param   string   $subsection            sub section of invoice (optional)
     * @param   bool     $display               set display of section true to show, false to hide  
     * return   object                          Object of Docufy
     */
    public function setInvoiceDisplaySettings($section, $subsection = "", $display = true)
    {
        if (!empty($subsection)) {
            if ($section === "items") {
                $this->data[$section][0][$subsection]["display"] = $display;
            } else {
                $this->data[$section][$subsection]["display"] = $display;
            }
        } else {
            $this->data[$section]["display"] = $display;
        }
        return $this;
    }

    /**
     * Set style settings of invoice sections  
     * @param   string   $section               section of invoice
     * @param   string   $subsection            sub section of invoice (optional)
     * @param   string   $style                 set style of section
     * return   object                          Object of Docufy
     */
    public function setInvoiceStyleSettings($section, $subsection = "", $style = "")
    {
        if (!empty($subsection)) {
            if ($section === "items") {
                $this->data[$section][0][$subsection]["style"] = $style;
            } else {
                $this->data[$section][$subsection]["style"] = $style;
            }
        } else {
            $this->data[$section]["style"] = $style;
        }
        return $this;
    }

    /**
     * Set format settings of invoice sections  
     * @param   string   $section               section of invoice
     * @param   string   $subsection            sub section of invoice (optional)
     * @param   array    $format                set format of the invoice section
     * return   object                          Object of Docufy
     */
    public function setInvoiceFormatSettings($section, $subsection = "", $format = "")
    {
        if (!empty($subsection)) {
            if ($section === "items") {
                $this->data[$section][0][$subsection]["format"] = $format;
            } else {
                $this->data[$section][$subsection]["format"] = $format;
            }
        } else {
            $this->data[$section]["format"] = $format;
        }
        return $this;
    }

    /**
     * Get mpdf object
     * @param   array   $param                      Paramater for mpdf object
     * return   object                              Object of mpdf
     */
    public function getMPDFObj($param = array())
    {
        if (!isset($this->mpdf)) {
            require_once DocufyABSPATH . 'classes/library/vendor/autoload.php';

            if (isset($this->settings["mpdfversion"]) && $this->settings["mpdfversion"] === "6") {
                $this->mpdf = new mPDF($this->settings["mode"], $this->settings["format"], $this->settings["default_font_size"], $this->settings["default_font"], $this->settings["mgl"], $this->settings["mgr"], $this->settings["mgt"], $this->settings["mgb"], $this->settings["mgh"], $this->settings["mgf"], $this->settings["orientation"]);
            } else if (isset($this->settings["mpdfversion"]) && ($this->settings["mpdfversion"] === "8" ||
                $this->settings["mpdfversion"] === "7")) {
                $this->mpdf = new \Mpdf\Mpdf(['mode' => $this->settings["mode"], 'format' => $this->settings["format"], 'default_font_size' => $this->settings["default_font_size"], 'default_font' => $this->settings["default_font"], 'mgl' => $this->settings["mgl"], 'mgr' => $this->settings["mgr"], 'mgt' => $this->settings["mgt"], 'mgb' => $this->settings["mgb"], 'mgh' => $this->settings["mgh"], 'mgf' => $this->settings["mgf"], 'orientation' => $this->settings["orientation"]]);
            }
        }
        $this->mpdf->setAutoTopMargin = 'stretch';
        $this->mpdf->setAutoBottomMargin = 'stretch';
        $this->mpdf = $this->setDocumentMetaData($this->mpdf);
        $this->mpdf = $this->setWatermark($this->mpdf);
        $this->mpdf = $this->setMPDFDirectionality($this->mpdf);
        $this->mpdf->autoScriptToLang = true;
        $this->mpdf->autoLangToFont = true;
        if (isset($this->settings["simpleTable"]) && $this->settings["simpleTable"])
            $this->mpdf->simpleTables = true;
        return $this->mpdf;
    }

    /**
     * Apply document metadata
     * return   object                              Object of mpdf
     */
    public function setDocumentMetaData($mpdf)
    {
        if (isset($this->settings["title"]) && !empty($this->settings["title"]))
            $mpdf->SetTitle($this->settings["title"]);
        if (isset($this->settings["author"]) && !empty($this->settings["author"]))
            $mpdf->SetAuthor($this->settings["author"]);
        if (isset($this->settings["creator"]) && !empty($this->settings["creator"]))
            $mpdf->SetCreator($this->settings["creator"]);
        if (isset($this->settings["subject"]) && !empty($this->settings["subject"]))
            $mpdf->SetSubject($this->settings["subject"]);
        if (isset($this->settings["keywords"]) && !empty($this->settings["keywords"]))
            $mpdf->SetKeywords($this->settings["keywords"]);
        return $mpdf;
    }

    /**
     * Apply watermark to mpdf
     * return   object                              Object of mpdf
     */
    public function setWatermark($mpdf)
    {
        if (isset($this->settings["watermark"]) && ($this->settings["watermark"])) {
            if (isset($this->settings["watermarkType"]) && strtolower($this->settings["watermarkType"]) === "text") {
                $mpdf->SetWatermarkText($this->settings["watermarkValue"]);
                $mpdf->showWatermarkText = true;
            } else if (isset($this->settings["watermarkType"]) && strtolower($this->settings["watermarkType"]) === "image") {
                $mpdf->SetWatermarkImage($this->settings["watermarkValue"]);
                $mpdf->showWatermarkImage = true;
            }
        }
        return $mpdf;
    }

    /**
     * Apply direction to mpdf
     * return   object                              Object of mpdf
     */
    public function setMPDFDirectionality($mpdf)
    {
        if (isset($this->settings["direction"])) {
            $mpdf->SetDirectionality($this->settings["direction"]);
        }
        return $mpdf;
    }

    /**
     * Add dynamic totals field
     * @param   string   $totalId                   unique id for each totals
     * @param   string   $lableName                 Lable for the field
     * @param   array    $data                      data to be used to generate the field
     * @param   string   $operation                 Whether to use sum or percentage operation to generate field
     * @param   string   $param                     Parameter like how much percentage etc.
     * @param   bool     $negative                  Whether field will be negative or positive for further calculations.
     * return   object                              Object of Docufy
     */
    public function addInvoiceTotal($totalId, $lableName = "", $data = array(), $operation = "+", $param = 0, $negative = false)
    {
        $this->totals[$totalId] = array("lableName" => $lableName, "data" => $data, "operation" => $operation, "param" => $param, "negative" => $negative);
        return $this;
    }

    /**
     * Add a new column to the invoice table
     * @param   string   $colName                            Unique Column name to be added
     * @param   string   $labelName                          Label name (heading) of column
     * @param   string   $type                               Calculation type of the column whether it is generate using 'sum', 'merge' etc function
     * @param   array    $parameters                         Columns (or value) on the basis of which new column to be added
     * return   object                                       Object of class
     */
    public function addCol($colName, $labelName, $type, $parameters = array())
    {
        $this->colAdd[$colName] = array(
            "labelName" => $labelName,
            "type" => $type,
            "cols" => $parameters
        );
        return $this;
    }

    /**
     * Converts a csv file to pdf
     * @param   string   $filename                           csv filename 
     * @param   string   $param                              Set parameter (style, class etc) for the pdf table generated
     * return   object                                       Object of class
     */
    public function csvToPDF($filename, $param = array())
    {
        $data = $this->csvToArray($filename);
        $html = $this->arrayToHTML($data, $param);
        return $this->generatePDF($html);
    }

    /**
     * Converts a xml file to pdf
     * @param   string   $filename                           xml filename 
     * @param   string   $param                              Set parameter (style, class etc) for the pdf table generated
     * return   object                                       Object of class
     */
    public function xmlToPDF($filename, $param = array())
    {
        $data = $this->xmlToArray($filename);
        $html = $this->arrayToHTML($data, $param);
        return $this->generatePDF($html);
    }

    /**
     * Converts a html file to pdf
     * @param   string   $html                               html data 
     * return   object                                       Object of class
     */
    public function htmlToPDF($html)
    {
        return $this->generatePDF($html);
    }

    /**
     * Set email related settings for xInvoice
     * @param   array    $to                            To email
     * @param   string   $subject                       Subject of email
     * @param   string   $message                       Message of the email
     * @param   array    $from                          From email
     * @param   string   $cc                            CC email
     * @param   string   $bcc                           BCC email
     * return   object                                  Object of class
     */
    public function sendEmail($to, $subject, $message = "", $from = array(), $cc = array(), $bcc = array())
    {
        $this->email = array(
            "from" => $from,
            "to" => $to,
            "subject" => $subject,
            "message" => $message,
            "cc" => $cc,
            "bcc" => $bcc
        );
        $this->setSettings("output", "F");
        return $this;
    }

    /**
     * Reorder items 
     * @param   string   $positionToMovie                    key to which new key must be moved
     * @param   string   $keyName                            key to be moved
     * return   object                                       Object of class
     */
    public function reorderItemPosition($positionToMovie, $keyName)
    {
        $this->reorderItems[] = array($positionToMovie, $keyName);
        return $this;
    }



    /**
     * Get PDOModel object
     * return   object                              Object of PDOModel class
     */
    public function getPDOModelObj()
    {
        $pdoModelObj = new PDOModel();
        $pdoModelObj->setErrorCtrl($this->errCtrl);
        if ($pdoModelObj->connect($this->settings["hostname"], $this->settings["username"], $this->settings["password"], $this->settings["database"], $this->settings["dbtype"], $this->settings["characterset"])) {
            return $pdoModelObj;
        } else {
            $this->errCtrl->addError($this->getLangData("db_connection_error"));
            die();
        }
    }

    public function getErrors()
    {
        $errors = $this->errCtrl->getErrors();
        if (is_array($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br />";
            }
        }
    }

    /**
     * render data as PDF or HTML
     * @param   string  $operationType              whether to generate PDF or HTML
     * @param   array   $data                       Optional parameter to be passed
     * return   mixed                               PDF or HTML
     */
    public function render($operationType = "PDF", $data = array())
    {
        switch (strtoupper($operationType)) {
            case "PDF":
                $output = $this->getPDF();
                return $output;
            case "HTML":
                $output = $this->getHTML();
                return $output;
            default:
                $this->errCtrl->addError($this->getLangData("error_invalid_render_option"));
                return;
        }
    }

    public function getPDF()
    {
        $html = $this->getHTML();
        return $this->generatePDF($html);
    }

    public function generatePDF($html)
    {
        $this->mpdf = $this->getMPDFObj();
        $this->mpdf->AddPage();
        $this->mpdf->WriteHTML($html);
        //        $this->mpdf->page = 0;
        //        $this->mpdf->state = 0;
        //        unset($this->mpdf->pages[0]);        

        $filename = $this->settings["filename"];
        if (strtoupper($this->settings["output"]) === "F") {
            $filename = $this->settings["downloadFolder"] . $this->settings["filename"];
        }
        $output = $this->mpdf->Output($filename, $this->settings["output"]);
        $output = $this->handleCallback('after_pdf', $output);
        if (strtoupper($this->settings["output"]) === "F") {
            $path = $this->settings["pdfPath"] . $this->settings["filename"];
            if (isset($this->email)) {
                $smtp["host"] = $this->xSettings["SMTPHost"];
                $smtp["port"] = $this->xSettings["SMTPPort"];
                $smtp["SMTPAuth"] = $this->xSettings["SMTPAuth"];
                $smtp["username"] = $this->xSettings["SMTPusername"];
                $smtp["password"] = $this->xSettings["SMTPpassword"];
                $smtp["SMTPSecure"] = $this->xSettings["SMTPSecure"];
                $smtp["SMTPKeepAlive"] = $this->xSettings["SMTPKeepAlive"];
                $this->helper->sendEmail(
                    $this->email["to"],
                    $this->email["subject"],
                    $this->email["message"],
                    $this->email["from"],
                    "",
                    array(),
                    array(),
                    array($filename),
                    $this->xSettings["emailMode"],
                    $smtp
                );
            }

            return $path;
        }
        return $output;
    }

    public function getHTML()
    {
        $data = $this->data;
        $data = $this->handleCallback('before_html_formatting', $data);
        $data = $this->getItemColumns($data);
        $data = $this->getAllTotals($data);
        $data = $this->formatData($data);
        $template = $this->getTemplateName();
        $data = $this->handleCallback('after_html_formatting', $data);
        $this->html = $this->view->renderHTML($template, $data);
        $this->html = $this->handleCallback('after_html', $this->html);
        return $this->html;
    }

    protected function getItemColumns($data)
    {
        if (is_array($this->colAdd) && count($this->colAdd) && isset($data["item"])) {
            $count = count($data["item"]);
            foreach ($this->colAdd as $col => $options) {
                $data["item"][0][$col]["label"] = $options["labelName"];
            }
            $data["item"] = $this->addTableCol($data["item"], $this->colAdd, "data");
        }

        if (isset($this->reorderItems)) {
            foreach ($this->reorderItems as $reoder) {
                $data["item"] = $this->reorderItemCols($data["item"], $reoder[0], $reoder[1]);
            }
        }
        return $data;
    }

    protected function getAllTotals($data)
    {
        $itemTotal = $this->getItemSubTotal($data);
        if (isset($data["total"]["subtotal"]["data"]) && isset($this->settings["autoCalcItemTotal"]) && $this->settings["autoCalcItemTotal"])
            $data["total"]["subtotal"]["data"] = $itemTotal;
        $data = $this->getTotals($data);
        if (isset($data["total"]["grandtotal"]["data"]) && isset($this->settings["autoCalcGrandTotal"]) && $this->settings["autoCalcGrandTotal"])
            $data["total"]["grandtotal"]["data"] = $this->getGrandTotal($data);;
        return $data;
    }

    protected function formatData($data)
    {

        if (isset($data["invoice"]["date"]["data"]) && isset($this->settings["defaultDateVal"]) && $this->settings["defaultDateVal"] === "current_date") {
            $data["invoice"]["date"]["data"] = date($this->settings["defaultDateFormat"]);
        }

        if (isset($data["invoice"]["total_due"]["data"]) && isset($data["total"]["grandtotal"]["data"]) && isset($this->settings["defaultTotalDueVal"]) && $this->settings["defaultTotalDueVal"] === "auto") {
            $data["invoice"]["total_due"]["data"] = $data["total"]["grandtotal"]["data"];
        }

        $data = $this->formatLogo($data);

        if (isset($data) && is_array($data) && count($data)) {
            foreach ($data as $key1 => $vals) {
                foreach ($vals as $key2 => $val) {
                    if (isset($val["data"]) && isset($val["format"])) {
                        if (is_array($val["format"][0])) {
                            foreach ($val["format"] as $option) {
                                $formatType = strtolower($option[0]);
                                $format = $option[1];
                                $formattedVal = $this->formatting($val["data"], $formatType, $format);
                                $data[$key1][$key2]["data"] = $formattedVal;
                                $val["data"] = $formattedVal;
                            }
                        } else {
                            $formatType = strtolower($val["format"][0]);
                            $format = $val["format"][1];
                            $formattedVal = $this->formatting($val["data"], $formatType, $format);
                            $data[$key1][$key2]["data"] = $formattedVal;
                        }
                    }
                }
            }
        }

        if (isset($data["item"]) && is_array($data["item"]) && count($data["item"])) {
            $items = $data["item"];
            $loop = 0;
            foreach ($items as $item) {
                foreach ($item as $key => $val) {
                    if (isset($val["data"]) && isset($data["item"][0][$key]["format"])) {
                        if (is_array($data["item"][0][$key]["format"][0])) {
                            foreach ($data["item"][0][$key]["format"] as $option) {
                                $formatType = strtolower($option[0]);
                                $format = $option[1];
                                $formattedVal = $this->formatting($val["data"], $formatType, $format);
                                $data["item"][$loop][$key]["data"] = $formattedVal;
                                $val["data"] = $formattedVal;
                            }
                        } else {
                            $formatType = strtolower($data["item"][0][$key]["format"][0]);
                            $format = $data["item"][0][$key]["format"][1];
                            $formattedVal = $this->formatting($val["data"], $formatType, $format);
                            $data["item"][$loop][$key]["data"] = $formattedVal;
                        }
                    }
                }
                $loop++;
            }
        }
        return $data;
    }

    protected function formatLogo($data)
    {
        if (isset($this->settings["companylogo"]) && $this->settings["companylogo"] === "image") {
            $logo = isset($data["company"]["logo"]["data"]) ? $data["company"]["logo"]["data"] : "";
            $style = isset($data["company"]["logo"]["style"]) ? $data["company"]["logo"]["style"] : "";
            $data["company"]["logo"]["data"] = "<img src='" . $logo . "' style='" . $style . "' />";
        } else {
            $name = isset($data["company"]["name"]["data"]) ? $data["company"]["name"]["data"] : "";
            $tagline = isset($data["company"]["tagline"]["data"]) ? $data["company"]["tagline"]["data"] : "";
            $style = isset($data["company"]["logo"]["style"]) ? $data["company"]["logo"]["style"] : "";
            $data["company"]["logo"]["data"] = "<p style='" . $style . "'> $name <br/>$tagline</p>";
        }
        return $data;
    }

    protected function formatting($val, $formatType, $format)
    {
        $formattedVal = $val;
        if ($formatType === "date") {
            $formattedVal = $this->formatDate($val, $format);
        } else if ($formatType === "number") {
            $formattedVal = $this->formatNumber($val, $format, $formatType);
        } else if ($formatType === "currency") {
            $formattedVal = $this->formatCurrency($val, $format);
        } else if ($formatType === "prefix") {
            $formattedVal = $this->formatString($val, $format, $formatType);
        } else if ($formatType === "suffix") {
            $formattedVal = $this->formatString($val, $format, $formatType);
        } else if ($formatType === "round") {
            $formattedVal = $this->roundNumber($val, $format);
        }
        return $formattedVal;
    }

    protected function formatDate($val, $format)
    {
        $timestamp = strtotime($val);
        $val = date($format, $timestamp);
        return $val;
    }

    protected function formatNumber($val, $format, $formatType)
    {
        if (is_array($format) && isset($format[1]) && isset($format[2])) {
            $decimals = $format[0];
            $decPoint = $format[1];
            $thousandsSep = $format[2];
            $val = number_format((float) $val, $decimals, $decPoint, $thousandsSep);
        } else if (is_array($format) && isset($format[0]) && !isset($format[1])) {
            $decimals = $format[0];
            $val = number_format((float) $val, $decimals);
        }
        return $val;
    }

    protected function roundNumber($val, $format)
    {
        $val = round($val, $format);
        return $val;
    }

    protected function formatCurrency($val, $symbol)
    {
        ($this->settings["currencyDirection"] === "left") ? $val = "$symbol" . $val : $val = $val . "$symbol";
        return $val;
    }

    protected function formatString($val, $format, $formatType)
    {
        if ($formatType === "prefix") {
            $val = $this->addPrefix($val, $format);
        } else if ($formatType === "suffix") {
            $val = $this->addSuffix($val, $format);
        }
        return $val;
    }

    protected function addPrefix($val, $prefix)
    {
        return $prefix . $val;
    }

    protected function addSuffix($val, $suffix)
    {
        return $val . $suffix;
    }

    /**
     * Return item total
     * return   float                                   return sum of all items total
     */
    public function getItemSubTotal($data)
    {
        $sum = 0;
        if (isset($data["item"])) {
            foreach ($data["item"] as $item) {
                if (isset($item['total']["data"]))
                    $sum += $item['total']["data"];
            }
        }
        return $sum;
    }

    public function getGrandTotal($data)
    {
        $sum = 0;
        if (isset($data["total"])) {
            foreach ($data["total"] as $key => $total) {
                if (isset($total["data"]) && $key != "grandtotal")
                    $sum += $total["data"];
            }
        }
        return $sum;
    }

    protected function getTotals($data)
    {
        if (isset($this->totals)) {
            foreach ($this->totals as $key => $totals) {
                $fields = $totals["data"];
                $fieldVal = array();

                foreach ($fields as $field) {
                    if ($field === "item_total")
                        $fieldVal[] = $this->getItemSubTotal($data);
                    else if (isset($data["total"][$field]["data"]))
                        $fieldVal[] = $data["total"][$field]["data"];
                    else if (is_numeric($field))
                        $fieldVal[] = $field;
                }

                if ($totals["operation"] === "+")
                    $fieldData = array_sum($fieldVal);
                else if ($totals["operation"] === "%")
                    $fieldData = array_sum($fieldVal) * $totals["param"] / 100;

                if ($totals["negative"])
                    $fieldData = $fieldData * -1;
                $data["total"][$key]["data"] = $fieldData;
                $data["total"][$key]["label"] = $totals["lableName"];
            }
        }
        return $data;
    }

    public function addDataKey(&$val, $key)
    {
        $val = array("data" => $val);
    }

    public function addLabelKey(&$val, $key)
    {
        $val = array("label" => $val);
    }

    /**
     * Returns the array as output from the csv provided.
     * 
     * @param   string     $fileName                 Name or path of csv file.
     *
     */
    protected function csvToArray($fileName)
    {
        if (empty($fileName)) {
            $this->errCtrl->addError($this->getLangData("valid_input"));
            return false;
        }
        $csvArray = array();
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            $rowIndex = 0;
            while (($lineArray = fgetcsv($handle, 0, $this->settings["delimiter"])) !== FALSE) {
                for ($colIndex = 0; $colIndex < count($lineArray); $colIndex++) {
                    $csvArray[$rowIndex][$colIndex] = $lineArray[$colIndex];
                }
                $rowIndex++;
            }
            fclose($handle);
        }
        $csvArray = $this->formatOutputArray($csvArray);
        return $csvArray;
    }

    /**
     * Returns the array as output from the xml provided.
     * 
     * @param   string     $xmlSource                 Name or path of xml file.
     *
     */
    protected function xmlToArray($xmlSource, $isFile = true)
    {
        if ($isFile)
            $xml = file_get_contents($xmlSource);
        else
            $xml = $xmlSource;

        $xmlObject = new SimpleXMLElement($xml);
        $decodeArray = @json_decode(@json_encode($xmlObject), 1);
        foreach ($decodeArray as $newDecodeArray) {
            $returnArray = $newDecodeArray;
        }
        return $returnArray;
    }

    protected function arrayToHTML($data, $params)
    {
        $html = "";
        $param = "";
        if (count($params) > 0)
            $param = implode(', ', array_map(
                function ($v, $k) {
                    return $k . '=' . $v;
                },
                $params,
                array_keys($params)
            ));
        if (count($data) > 0) {
            $html .= "<table " . $param . "><thead><tr>";
            $html .= "<th>";
            $html .= implode('</th><th>', array_keys(current($data)));
            $html .= "</th>";
            $html .= "</tr></thead><tbody>";
            foreach ($data as $row) : array_map('htmlentities', $row);
                $html .= "<tr><td>";
                $html .= implode('</td><td>', $row);
                $html .= "</td></tr>";
            endforeach;
            $html .= "</tbody></table>";
        }
        return $html;
    }

    protected function formatOutputArray($data)
    {
        $output = array();
        $loop = 0;
        if (isset($data) && is_array($data) && count($data) > 0) {
            $columns = $data[0];
            foreach ($data as $row) {
                if ($loop > 0)
                    $output[] = array_combine($columns, $row);
                $loop++;
            }
        }
        return $output;
    }

    protected function addTableCol($data, $colAddData, $key)
    {
        $loop = 0;
        foreach ($colAddData as $col => $options) {
            foreach ($data as $rows) {
                $fields = array();
                foreach ($options["cols"] as $option) {
                    if (isset($rows[$option]))
                        $fields[] = $rows[$option];
                }
                if (is_array($fields) && count($fields)) {
                    $fieldData = array();
                    foreach ($fields as $field) {
                        $fieldData[] = $field[$key];
                    }
                    $rows[$col][$key] = $this->getNewTableCol($options["type"], $fieldData);
                }
                $data[$loop] = $rows;
                $loop++;
            }
            $loop = 0;
        }

        return $data;
    }

    protected function getNewTableCol($type, $fields)
    {
        switch (strtolower($type)) {
            case "sum":
                return array_sum($fields);
            case "merge":
                return implode(" ", $fields);
            case "divide":
                if (isset($fields[0]) && isset($fields[1]) && $fields[0] != 0) {
                    return $fields[1] / $fields[0];
                }
            case "multiply":
                if (isset($fields[0]) && isset($fields[1]) && $fields[0] != 0) {
                    return $fields[1] * $fields[0];
                }
            case "subtract":
                if (isset($fields[0]) && isset($fields[1]) && $fields[0] != 0) {
                    return $fields[1] - $fields[0];
                }
        }
    }

    protected function reorderItemCols($items, $oldKey, $newKey)
    {
        $newItems = array();
        $position = 0;
        foreach ($items as $item) {
            foreach ($item as $key => $col) {
                if ($key === $newKey) {
                    continue;
                }
                if ($key === $oldKey) {
                    $newItems["item"][$position][$newKey] = $items[$position][$newKey];
                }
                $newItems["item"][$position][$key] = $col;
            }
            $position++;
        }
        return $newItems["item"];
    }
}
