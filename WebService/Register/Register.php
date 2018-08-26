<?php
//require_once("../../php_codes/db_conx_web.php");
//include_once("../../php_codes/db_conx.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class Register {
        
	
	private $register = array();
		
	/*
		you should hookup the DAO here
	*/
	
	public function getRegistered($User,$Email,$Pass,$Gen,$FirNm,$LasNm,$Phone,$RefID,$db_conx){
            $error = "";
            //$dbcon = new DBController();
            
            $ip = preg_replace('#[^0-9.:]#', '', getenv('REMOTE_ADDR'));
            // DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
            $sql = "SELECT id FROM USER_CREDS WHERE upper(username)=upper('$User') LIMIT 1";
            $query = mysqli_query($db_conx, $sql); 
            $u_check = mysqli_num_rows($query);
            // --------------------------------------------
            $sql = "SELECT id FROM USER_CREDS WHERE upper(email)=upper('$Email') LIMIT 1";
            $query = mysqli_query($db_conx, $sql); 
            $e_check = mysqli_num_rows($query);
            // --------------------------------------------
            $sql = "SELECT id FROM USER_CREDS WHERE upper(phone)=upper('$Phone') LIMIT 1";
            $query = mysqli_query($db_conx, $sql); 
            $p_check = mysqli_num_rows($query);
            // FORM DATA ERROR HANDLING
            if($User == "" || $Email == "" || $Pass == "" || $Gen == "" || $FirNm == "" ||$LasNm == "" || $Phone == ""){
                $error = "The form submission is missing values. PHP";
                return $error;
                //exit();
            } else if ($u_check > 0){ 
                $error = "The username you entered is alreay in use";
                //echo "UPDATED|".$db_email;
                return $error;
                exit();
            } else if ($p_check > 0){ 
                $error = "The Phone Number is been used by another account";
                return $error;
                exit();
            } else if ($e_check > 0){ 
                $error = "The email address is been used by another account";
                return $error;
                //exit();
            } else if (strlen($User) < 3 || strlen($User) > 16) {
                $error = "Username must be between 3 and 16 characters";
                return $error;
                //exit(); 
            } else if (is_numeric($User[0])) {
                $error = 'Username cannot begin with a number';
                return $error;
                //exit();
            } else if (strlen($Phone) > 11){
                $error = "The Phone Number provided is invalid";
                return $error;
            }else {
                // END FORM DATA ERROR HANDLING
                // Begin Insertion of data into the database
                // Hash the password and apply your own mysterious unique salt
                $p_hash = md5($Pass);
                $verifynumber = rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
                $phone_hash_vri = md5($verifynumber);
                $verifyemail = rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
                $email_hash_vri = md5($verifyemail);
            
                // Add user info into the database table
                $user_ip = getUserIP();
            
                $sql = "INSERT INTO USER_CREDS (username, first_name, last_name, email, phone, gender, country, 
                    new_user, ip, ip2, signup_date,lchg_time, user_ref)
                    VALUES ('$User', '$FirNm', '$LasNm', '$Email', '$Phone', '$Gen', 'Nigeria', 'Y', '$ip', '$user_ip', 
                    now(),now(), '$RefID')";
                $query = mysqli_query($db_conx, $sql);
                //$this->$register = $dbcon->runQuery($sql);
                //$query = mysqli_query($db_conx, $sql);
            
                $sql = "insert into USER_PHONE_EMAIL (username, phone, phone_email, phone_vri_flg, lchg_time,
                    preferred_flg,phone_vri_code)values('$User','$Phone','PHONE','N',
                    now(),'Y','$phone_hash_vri')";
                $query = mysqli_query($db_conx, $sql);
                //$this->$register = $dbcon->runQuery($sql);
                //$query = mysqli_query($db_conx, $sql);
            
                $sql = "insert into USER_PHONE_EMAIL (username, email, phone_email, phone_vri_flg, lchg_time,
                    preferred_flg,email_vri_code)values('$User','$Email','EMAIL','N',
                    now(),'Y','$email_hash_vri')";
                $query = mysqli_query($db_conx, $sql);
                //$this->$register = $dbcon->runQuery($sql);
                //$query = mysqli_query($db_conx, $sql);
            
                $sql = "INSERT INTO USER_LOGIN_CREDS (username, role_id, password, num_pwd_history,
                    num_pwd_attempts, pwd_exp_date)VALUES ('$User', 'CUST', '$p_hash', 0, 0,
                    DATE_ADD(NOW(), INTERVAL 1440 HOUR))";
                $query = mysqli_query($db_conx, $sql);
                //$this->$register = $dbcon->runQuery($sql);
                //$query = mysqli_query($db_conx, $sql);
            
                $sql = "insert into USER_PASS_DETAILS(username,password,lchg_time,del_flg,preferred_flg)
                    VALUES ('$User','$p_hash',now(),'N','Y')";
                $query = mysqli_query($db_conx, $sql);
                //$this->$register = $dbcon->runQuery($sql);
                //$query = mysqli_query($db_conx, $sql);
            
                // Email the user their activation code
                $to = "$Email";  
                $from = "auto_responder@toptencash.com";
                $subject = 'TOP TEN CASH Welcome Message';
                $message1 = '<!DOCTYPE html>
                <html>
                <head>
                <meta charset="UTF-8">
                <title>freelancer Welcome Message</title>
                </head>
                <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
                <div style="padding:24px; font-size:17px;">Hello '.$FirNm .' '.$LasNm.',
                <br />
                <br />Welcome to FREELANCER Software please use the code '.$verifyemail.' to verify your email
                <br />Or click here to verify your email
                <br /><br />
                <br /><br />
                <br />Please NOTE this URL will expire within 20 minutes
                </div>
                </body>
                </html>';
                $headers = "From: $from\n";
                $headers .= "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                //mail($to, $subject, $message1, $headers);
                return "SIGNUP_SUCCESS";
                //exit();
            }
                
            //$mobile = array($id => ($this->mobiles[$id]) ? $this->mobiles[$id] : $this->mobiles[1]);
            //return $mobile;
	}	
}
function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];   
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        return $ip;
    }
?>
