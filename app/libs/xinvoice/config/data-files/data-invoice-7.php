<?php
global $xData, $xSettings;
/**************** Data settings ********************/
$xData["company"]["logo"]["data"] = "http://xinvoice.biz/script/images/xinvoice-logo-6.png";
$xData["company"]["name"]["data"] = "Company Name, Inc";
$xData["company"]["tagline"]["data"] = "dummy tagline of company";
//$xData["invoice"]["for"]["data"] = "Office Stationary";
$xData["document"]["title"]["data"] = "INVOICE";
$xData["invoice"]["no"]["data"] = "DY-13123";
$xData["invoice"]["date"]["data"] = "01-08-2018";
$xData["invoice"]["total_due"]["data"] = 56890.23;
//$xData["invoice"]["due_date"]["data"] = "01-12-2018";
//$xData["from"]["name"]["data"] = "Company Name, Inc";
$xData["from"]["address1"]["data"] = "123 Sunny Road, CA 31321";
//$xData["from"]["address2"]["data"] = "Sunnyville, CA 12345";
//$xData["from"]["city"]["data"] = "Sunnyvale";
//$xData["from"]["state"]["data"] = "CA";
//$xData["from"]["country"]["data"] = "USA";
//$xData["from"]["postalcode"]["data"] = "452005";
$xData["from"]["email"]["data"] = "info@companyname.com";
$xData["from"]["website"]["data"] = "http://xinvoice.biz";
$xData["to"]["name"]["data"] = "<br/>American Option";
$xData["to"]["address1"]["data"] = "El Monte Road Los Altos Hills";
//$xData["to"]["address2"]["data"] = "Opp. YM, Saratoga Rd";
//$xData["to"]["city"]["data"] = "Sunnyvale";
//$xData["to"]["state"]["data"] = "CA";
//$xData["to"]["country"]["data"] = "USA";
//$xData["to"]["postalcode"]["data"] = "452005";
$xData["to"]["email"]["data"] = "info@digitaldreamstech.com";
$xData["to"]["website"]["data"] = "http://digitaldreamstech.com/";
$xData["payment"]["method1"]["data"] = "<br/>Bank name : Bank name<br/>IFCS : 12003213<br/>Account No : 140023211321";
$xData["payment"]["method2"]["data"] = "<br/>3 weeks after received invoice file";
$xData["payment"]["method3"]["data"] = "<br/> Paypal, Visa, Master Card";
$xData["message"]["sign"]["data"] = "Director<br/> <img src='http://xinvoice.biz/script/images/sign.png' /> ";
$xData["footer"]["note"]["data"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.";
$xData["item"][0]["name"]["data"] = "Computer table";
//$xData["item"][0]["desc"]["data"] = "Computer table";
$xData["item"][0]["qty"]["data"] = 100.344;
$xData["item"][0]["rate"]["data"] = 2500;
$xData["item"][0]["total"]["data"] = 2500.40;
$xData["item"][1]["name"]["data"] = "HP Laptops";
//$xData["item"][1]["desc"]["data"] = "Laptos and computers of HP company";
$xData["item"][1]["qty"]["data"] = 200.42;
$xData["item"][1]["rate"]["data"] = 20;
$xData["item"][1]["total"]["data"] = 4000;
$xData["total"]["subtotal"]["data"] = 4000;
$xData["total"]["discount"]["data"] = -1000;
$xData["total"]["tax"]["data"] = 400;
//$xData["total"]["shipping"]["data"] = 400;
$xData["total"]["grandtotal"]["data"] = 4400;


/**************** label settings ********************/
//$xData["invoice"]["for"]["label"] = "INVOICE FOR: ";
//$xData["invoice"]["document"]["label"] = "";
$xData["invoice"]["no"]["label"] = "INVOICE NO<br/>";
$xData["invoice"]["date"]["label"] = "DATE<br/>";
$xData["invoice"]["total_due"]["label"] = "TOTAL AMOUNT<br/>";
//$xData["invoice"]["due_date"]["label"] = "Due Date: ";
$xData["from"]["address1"]["label"] = "Physical Address: <br/>";
$xData["to"]["name"]["label"] = "INVOICE TO ";
$xData["total"]["subtotal"]["label"] = "Subtotal: ";
$xData["total"]["discount"]["label"] = "Discount: ";
$xData["total"]["tax"]["label"] = "Tax @10%: ";
//$xData["total"]["shipping"]["label"] = "Shipping Charges: ";
$xData["total"]["grandtotal"]["label"] = "<strong>Grand Total:</strong> ";
$xData["payment"]["method1"]["label"] = "<strong>Bank Information</strong>";
$xData["payment"]["method2"]["label"] = "<strong>Valid Day</strong>";
$xData["payment"]["method3"]["label"] = "<strong>We accept</strong>";
$xData["payment"]["note"]["label"] = "";
$xData["footer"]["note"]["label"] = "<strong>TERMS: </strong>";
$xData["itemcount"]["count"]["label"] = "S.NO.";
$xData["item"][0]["name"]["label"] = "ITEM DESCRIPTION";
//$xData["item"][0]["desc"]["label"] = "Desc";
$xData["item"][0]["qty"]["label"] = "QTY";
$xData["item"][0]["rate"]["label"] = "UNIT PRICE";
$xData["item"][0]["total"]["label"] = "TOTAL";

/**************** style settings ********************/
$xData["invoice"]["style"] = "background:".$xSettings["backgroundColor"].";";
$xData["invoice"]["for"]["style"] = "font-size:16px; font-weight:bold";
$xData["invoice"]["no"]["style"] = "color:".$xSettings["fontColor"]."; font-size: 24px; font-weight:bold";
$xData["invoice"]["date"]["style"] =  "color:".$xSettings["fontColor"]."; font-size: 24px; font-weight:bold";
$xData["invoice"]["total_due"]["style"] =  "color:".$xSettings["fontColor"].";font-size: 24px; font-weight:bold";
$xData["header"]["style"] = "font-size:16px; padding-bottom:10px";
$xData["sender_receiver"]["style"] = "margin-top:20px; margin-bottom: 20px";
$xData["to"]["name"]["style"] = "font-size: 16px";
$xData["company"]["logo"]["style"] = "max-width:300px";
$xData["payment"]["style"] = "margin-top:10px; margin-bottom: 20px";
$xData["footer"]["style"] = "font-size:14px";

/**************** display settings ********************/
$xData["header"]["display"] = true;
$xData["invoice"]["total_due"]["display"] = true;
$xData["sender_receiver"]["display"] = true;
$xData["from"]["display"] = true;
$xData["from"]["name"]["display"] = true;
$xData["to"]["display"] = true;
$xData["to"]["name"]["display"] = true;
$xData["items"]["display"] = true;
$xData["item"][0]["qty"]["display"] = true;
$xData["item"][0]["rate"]["display"] = true;
$xData["itemcount"]["display"] = false;
$xData["message"]["display"] = true;
$xData["footer"]["display"] = true;

/****************data formatting settings ********************/
$xData["invoice"]["date"]["format"] = array("date", "Y-m-d");
$xData["invoice"]["due_date"]["format"] = array("date", "Y-m-d");
$xData["invoice"]["total_due"]["format"] = array("currency", "$");
$xData["item"][0]["qty"]["format"] = array(array("round", 2),array("suffix", " pcs"));
$xData["item"][0]["total"]["format"] = array("currency", "$");
$xData["total"]["subtotal"]["format"] = array(array("number", array(2, ".", ",")), array("currency", "$"));
$xData["total"]["discount"]["format"] = array(array("number", array(2, ".", ",")), array("currency", "$"));
$xData["total"]["tax"]["format"] = array(array("number", array(2, ".", ",")), array("currency", "$"));
$xData["total"]["shipping"]["format"] = array("currency", "$");
$xData["total"]["grandtotal"]["format"] = array("currency", "$");