<?php 

/*Requrire the PostRequest function for posting the API request to the server */
require ("PostRequest.php");
	
$username = $_POST['txtUserName'] ;
$password = $_POST['txtPassword'] ;
$senderId = $_POST['txtSenderId'];
$destination = $_POST['txtDestination'];
$longSms = 0;
if(isset($_POST['ckcLongSms']))
{
 $longSms = $_POST['ckcLongSms'];
}

$message = $_POST['txtMessage'];

/* ==================================================
SUBMIT A REQUEST TO SEND THE SMS TO VIA THE HTTP API
=====================================================*/
// submit these variables to the server
$data = array(	'UN' => $username, 
			  	'p' => $password,
			 	'SA' => $senderId,
				'DA' => $destination,
				'L' => $longSms, 
				'M' => $message);

// send a request to the API url
list($header, $content) = PostRequest("http://98.102.204.231/smsapi/Send.aspx?", $data);

// display the result of the request
//echo $content . '<br>';

$tok = strtok($content, " "); //Split the $content result into workds

if($tok == "OK") //Success
{
	$tok = strtok(" ");
	echo "Sms sent succesfully using " .$tok . " SMS credits(s).";
}
else{
	//Diaply the full error message
	echo "The following error occured: <br> ".  $content . "<br>";
}

/* =========================================================================
SUBMIT ANOTHER REQUEST TO GET THE NUMBER OF SMS BALANCE IN THE ACCOUNT
============================================================================*/
//submit these variables to the server
$data2 = array(	'UN' => $username, 
			  	'p' => $password);

list($header2, $content2) = PostRequest("http://98.102.204.231/smsapi/GetCreditBalance.aspx?", $data);

// display the result of the request
//echo $content . '<br>';

$tok2 = strtok($content2, " "); //Split the $content result into workds

if($tok2 == "OK") //Success
{
	$tok2 = strtok(" ");
	echo "<br>Account SMS Credit Balance: " . $tok2 . "<br>" ;
}
else{
	//Diaply the full error message
	echo "The following error occured: <br> ".  $content2 . "<br>";
}

?>

