<?php
/* Configuration Settings */
global $xSettings;
/* *********************** database *********************** */
//Set the host name to connect for database
$xSettings["hostname"] = "localhost";
//Set the database name
$xSettings["database"] = "xinvoice";
//Set the username for database access
$xSettings["username"] = "root";
//Set the pwd for the database user
$xSettings["password"] = "";
//Set the database type to be used
$xSettings["dbtype"] = "mysql";
//Set the database type to be used
$xSettings["characterset"] = "utf8";

/* ******************** data settings ***************************************** */
//whether to load the default data or not.
$xSettings["defaultData"] = true;
//Set the name of default data file(without extension) to be used.
$xSettings["datafile"] = "data";
//Default template path (All templates are in script/template folder)
$xSettings["defaultTemplate"] = "invoice/invoice_1.php";
//whether to use logo image (image) or company name and tagline(text)
$xSettings["companylogo"] = "image";
//whether to auto calculate item wise total or not
$xSettings["autoCalcItemTotal"] = true;
//whether to auto calculate grand total or not
$xSettings["autoCalcGrandTotal"] = true;
//Default Number format (decimal point, separator, thousand separator)
$xSettings["numberformat"] = array(2, 1);
//Get default value of date. Acceptable values are default data date(config_date) or current date(current_date).
$xSettings["defaultDateVal"] = "config_date";
//Default date format to be used for current_date
$xSettings["defaultDateFormat"] = "Y-m-d";
//Get default value of total due from grand total(auto) or from config data(config) 
$xSettings["defaultTotalDueVal"] = "auto";
//Set default background color of the invoice
$xSettings["backgroundColor"] = "#e2e2e2";
//Set default font color of the invoice
$xSettings["fontColor"] = "#e1a827";
//Default currency symbol. This needs to be set in data files format option.
$xSettings["currency"] = "$";
//Default currency direction
$xSettings["currencyDirection"] = "left";
//Default Language
$xSettings["lang"] = "en";
//whether to add watermark or not
$xSettings["watermark"] = false;
//If watermark is yes, then whether watermark text or image
$xSettings["watermarkType"] = "text";
//Water mark value
$xSettings["watermarkValue"] = "Invoice";
//Default download folder name of invoice
$xSettings["downloadFolder"] = DocufyABSPATH."downloads/";
//Default pdf file name 
$xSettings["filename"] = "invoice.pdf";
//whether to ouput it on browser or browser+force download or save file at particular location
$xSettings["output"] = "I";
//whether to email the pdf generated or not
$xSettings["emailpdf"] = false;
//delimiter for csv file
$xSettings["delimiter"] = ",";
//whether to enable the logs.
$xSettings["enableLogs"] = true;
//Path of log file
$xSettings["logFile"] = DocufyABSPATH."logs/logs.txt";
//whether to enable rest or not.
$xSettings["enableREST"] = true;
//Complete path till download folder to create url for the pdf
$xSettings["pdfPath"] = "";
//Character separator used for database fields
$xSettings["dbCharSeparator"] = "__";
/********************** mpdf object parameters *********/
//You can check these parameters details on mpdf website also.
//mpdf version
$xSettings["mpdfversion"] = "8";
//mode 
$xSettings["mode"] = "";
//paper size
$xSettings["format"] = "A4";
//font size
$xSettings["default_font_size"] = 0;
//default font
$xSettings["default_font"] = "";
//mg left
$xSettings["mgl"] = 0;
//mg right
$xSettings["mgr"] = 0;
//mg top
$xSettings["mgt"] = 5;
//mg bottom
$xSettings["mgb"] = 16;
//mg header
$xSettings["mgh"] = 5;
//mg footer
$xSettings["mgf"] = 9;
//page orientation
$xSettings["orientation"] = "P";
//document direction
$xSettings["direction"] = "ltr";
//Set this true if you do not need complex table borders, 
//improves processing time of mpdf
$xSettings["simpleTable"] = false;
/****************** PDF Meta Data *****/
//PDF title
$xSettings["title"] = "";
//PDF author
$xSettings["author"] = "";
//PDF creator
$xSettings["creator"] = "";
//PDF subject
$xSettings["subject"] = "";
//PDF keywords
$xSettings["keywords"] = "";

/* * ************** Email Related Settings (if 'emailpdf' setting is set true)***************** */
//whether to use phpemail or smtp. For windows hosting, you need SMTP
$xSettings["emailMode"] = "PHPMAIL";

$xSettings["SMTPHost"] = "ajax";

$xSettings["SMTPPort"] = 25;

$xSettings["SMTPAuth"] = true;

$xSettings["SMTPusername"] = "";

$xSettings["SMTPpassword"] = "";

$xSettings["SMTPSecure"] = "";

$xSettings["SMTPKeepAlive"] = true;