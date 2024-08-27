<?php
/* Configuaration Settings */
function getEnvBoolean($envName) {
    $envValue = $_ENV[$envName];
    return filter_var($envValue, FILTER_VALIDATE_BOOLEAN);
}

global $config;
/************************ database ************************/
//Set the host name to connect for database
$config["hostname"] =  $_ENV['DB_HOST'];
//Set the database name
$config["database"] = $_ENV['DB_NAME'];
//Set the username for database access
$config["username"] = $_ENV['DB_USER'];
//Set the pwd for the database user
$config["password"] = $_ENV['DB_PASS'];
//Set the database type to be used
$config["dbtype"] = $_ENV['DB_TYPE'];

$config["characterset"] = $_ENV['CHARACTER_SET'];
/************************ Log, Cache and IP  Settings ************************/
// Whether to enable logs recording or not
$config["enableLogs"] = getEnvBoolean('ENABLE_LOGS');
//Path of log file
$config["logFile"] = "logs/logs.txt";
// Whether to enable caching or not
$config["enableCache"] = getEnvBoolean('ENABLE_CACHE');
//Cache duration
$config["cacheDuration"] = $_ENV['CACHE_DURATION'];
// Whether to block some specific IP address (leave empty if you don't want to block any IP address)
$config["blockIPs"] = array();
// Whether to allow only some specific IP address (leave empty if you don't want to allow only specific IP address)
$config["allowedIPs"] = array();
//Set table names to block access of that tables. e.g. orders,products
$config["blockTables"] = array();
/************************ Authentication Settings ************************/
//whether to enable the JWT authentication or not.
$config["enableJWTAuth"] = getEnvBoolean('ENABLE_JWTAUTH');

$config["encodeHtml"] = getEnvBoolean('ENCODE_HTML');
//secret key to be used for JWT 
$config["secretkey"] = $_ENV['SECRET_KEY'];
//Enter the details of issued server. Default is localhost
$config["iss"] = $_ENV['DB_HOST'];
//expiration time in seconds from the time of creation
$config["expTime"] = $_ENV['EXP_TIME'];
//Unique Field name to be used for creating payload (normally primary key of the user table)
$config["userIdFieldName"] = $_ENV['USER_ID_FIELD_NAME'];
//Password field name
$config["passwordFieldName"] = $_ENV['PASSWORD_FIELD_NAME'];
//encrypt password empty if no encryption to be used else specify encryption method
$config["encryptPassword"] = $_ENV['ENCRYPT_PASSWORD'];
/************************ Other Settings ************************/
// Set default response type
$config["defaultResponseType"] = $_ENV['DEFAULT_RESPONSE_TYPE'];
// Whether to allow access origin or not
$config["allowOriginHeader"] = $_ENV['ALLOW_ORIGIN_HEADER'];
// Allow origin urls
$config["allowOriginURL"] = "*";
// value separator in where condition of url 
$config["valueSeparator"] = ":";
//whether to allow execute query
$config["allowQueryExecution"] = $_ENV['ALLOW_QUERY_EXECUTION'];
//Set table format
$config["tableFormat"] = $_ENV['TABLE_FORMAT'];//else "horizontle" "verticle"