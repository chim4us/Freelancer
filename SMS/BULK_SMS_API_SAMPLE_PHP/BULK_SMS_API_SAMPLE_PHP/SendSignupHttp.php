<?php 
	if(isset($_POST['txtUserName']))
	{

		/*Require the PostRequest function for posting the API request to the server */
		require ("PostRequest.php");
	
		$resellerusername = "PUT_YOUR_RESELLER_USERNAME_HERE"; 
		$isReseller = $_POST['rbIsReseller'];	
		$username = $_POST['txtUserName'] ;
		$password = $_POST['txtPassword'] ;
		$companyname = $_POST['txtCompany'];
		$firstname = $_POST['txtFirstName'];
		$lastname = $_POST['txtLastName'];
		$cellphone = $_POST['txtCellPhoneNumber'];
		
		$email = $_POST['txtEmail'];
		$address = "";
		$city = $_POST['txtCity'];
		$state = $_POST['txtState'];
		$country = $_POST['txtCountry'];
		$emailtosms = "0";
		
		/* ==================================================
		SUBMIT A REQUEST TO SIGN UP VIA THE HTTP API
		=====================================================*/
		// submit these variables to the server
		$data = array(	'ResellerUN' => $resellerusername , 
					  	'CustomerUN' => $username ,
					 	'IsReseller' => $isReseller,
						'FN' => $firstname,
						'LN' => $lastname , 
						
						'EMAIL' => $email , 
						'COMPANY' => $companyname , 
						'ADDRESS' => $address  , 
						'CITY' => $city , 
						'STATE' => $state , 
						'COUNTRY' => $country , 
						'CELL' => $cellphone , 
						
						'EmailToSms' => $emailtosms, 
						'PASSWORD' => $password);
		
		// send a request to the API url
		list($header, $content) = PostRequest("http://98.102.204.231/smsapi/CustomerSignUp.aspx?", $data);
		
		// display the result of the request
		//echo $content . '<br>';
		
		$tok = strtok($content, " "); //Split the $content result into words
		
		if($tok == "OK") //Success
		{
			//Redirect user to the signup thank you page
			header("Location: signup_thankyou.html");

		}
		else{
			//Display the full error message
			$tok = strtok(" ");
			$tok = strtok("");

			//echo  $tok . "<br>";
		}
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>

<body>
<table  align="center" border="0" cellSpacing="0" width="80%" >
		<tr>
			<td style="PADDING-TOP: 10px" vAlign="top" colspan="2">
			<h3 align="center">Please use your Browser&#39;s Back Button to go back and 
			correct your sign up data</h3>
			</td>
		</tr>
		<tr>
			<td style="PADDING-TOP: 10px; font-weight:bold; color:red" valign="top" colspan="2" align="center">
			<?php
				echo  $tok . "<br>";
			?>
			</td>
		</tr>
</table>
</body>

</html>
