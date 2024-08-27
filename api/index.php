<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set(@date_default_timezone_get());
define('RESTpAPIABSPATH', dirname(__FILE__) . '/');

require_once RESTpAPIABSPATH . "../vendor/autoload.php";
$dotenv = DotenvVault\DotenvVault::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

require_once RESTpAPIABSPATH . "config/config.php";
spl_autoload_register('pdocrudRestAPIAutoLoad');

function pdocrudRestAPIAutoLoad($class) {
    if (file_exists(RESTpAPIABSPATH . "classes/" . $class . ".php"))
        require_once RESTpAPIABSPATH . "classes/" . $class . ".php";
}

function obtenerToken($data, $obj) {  
    $obj->setLangData("success", "Token Generado con éxito");
    return $data;
}

/*function beforeSelect($data, $obj){
	print_r($data);
}*/


$restpAPI = new RESTpAPI();
$restpAPI->addCallback("before_jwt_auth", "obtenerToken");
$restpAPI->render();