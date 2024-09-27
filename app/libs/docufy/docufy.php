<?php
/*enable this for development purpose */
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(0);
date_default_timezone_set(@date_default_timezone_get());
define('DocufyABSPATH', dirname(__FILE__) . '/');
require_once DocufyABSPATH . "config/settings.php";
spl_autoload_register('xinvoiceAutoLoad');

function xinvoiceAutoLoad($class) {
    if (file_exists(DocufyABSPATH . "classes/" . $class . ".php"))
        require_once DocufyABSPATH . "classes/" . $class . ".php";
}
//example callback function
//function beforeHTMLFormatting( $data, $obj){
//    modify the data as per requirement
//    return $data;
//}

//REST Support
if (isset($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $data);
    if (isset($data["path"]) && $data["path"] === "pdf") {
        $postedData = file_get_contents('php://input');
        if ($postedData) {
            $requestContentType = getRequestContentType();
            if ($requestContentType === "json") {
                $data = array_merge($data, json_decode($postedData, true));
            } else if ($requestContentType === "array") {
                parse_str($postedData, $postVar);
                $data = array_merge($data, $postVar);
            }
            $settings["output"] = "F";
            $xinvoice = new Xinvoice($settings);

        if (!empty($requestContentType))
            header("Content-Type:" . $requestContentType);
            if ($xinvoice->getSettings("enableREST")) {
                if (isset($data["data"]))
                    $xinvoice->setInvoiceDataArray($data["data"]);
                echo $xinvoice->render();
            }
        }
    }
}

function getRequestContentType() {
    $requestContentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : "json";
    if (strpos($requestContentType, 'json') !== false) {
        return "json";
    } else if (strpos($requestContentType, 'x-www-form-urlencoded') !== false) {
        return "array";
    } else {
        return "json";
    }
}