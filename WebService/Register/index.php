<?php
require_once("../MobileRestHandler.php");
include_once("../../php_codes/db_conx.php");

if(isset($_GET["u"])){
    if(!isset($_GET['e']) || !isset($_GET['p']) || !isset($_GET['g']) || !isset($_GET['FN']) || !isset($_GET['LN']) || !isset($_GET['ph']) || !isset($_GET['RefID'])) {
        deliver_response(400,"The form submission is missing values");
        exit();
    }
    $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    $e = mysqli_real_escape_string($db_conx, $_GET['e']);
    $p = $_GET['p'];
    $g = preg_replace('#[^a-z]#i', '', $_GET['g']);
    $FN = preg_replace('#[^a-z0-9 ]#i', '', $_GET['FN']);
    $LN = preg_replace('#[^a-z0-9 ]#i', '', $_GET['LN']);
    $ph = preg_replace('#[^0-9 ]#i', '', $_GET['ph']);
    $RefID = preg_replace('#[^a-z0-9 ]#i', '', $_GET['RefID']);
    
    
    if($u == "" || $e == "" || $p == "" || $g == "" || $FN == "" ||$LN == "" || $ph == ""){
        deliver_response(400,"The form submission is missing values");
        exit();
    }
    
    $mobileRestHandler = new MobileRestHandler();
    $mobileRestHandler->getRegistered($u,$e,$p,$g,$FN,$LN,$ph,$RefID,$db_conx);
        
}else{
    deliver_response(400,"Invalid request");
}

function deliver_response($statusCode,$rawData){
    $mobileRestHandler = new MobileRestHandler();
    $mobileRestHandler->ReturnErrorMessage($statusCode,$rawData);
}

/*
controls the RESTful services
URL mapping
*/
?>