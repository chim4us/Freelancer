<?php

	session_start();
	include_once("db_conx.php");
        include_once("RunFunctions.php");
	$user_ok = false;
	$log_id = "";
	$log_username = "";
	$log_password = "";
	function evalLoggedUser($db_conx,$id,$u,$p){
		$sql = "SELECT b.id FROM USER_LOGIN_CREDS a, USER_CREDS b WHERE b.id='$id' 
                       AND b.username='$u' AND a.password='$p' and a.username = b.username AND b.del_flg='N' LIMIT 1";
                //return $sql;
                //exit();
		$query = mysqli_query($db_conx, $sql);
		$numrows = mysqli_num_rows($query);
		if($numrows > 0){
                    //return "Yes";
                    return true;
                }else{
                    return false;
                }
	}
	if(isset($_SESSION["userid"])&& isset($_SESSION["username"])&& isset($_SESSION["password"])){
		$log_id = preg_replace('#[^0-9]#', '',$_SESSION['userid']);
		$log_username = preg_replace('#[^a-z0-9]#i', '',$_SESSION['username']);
		$log_password = preg_replace('#[^a-z0-9]#i', '',$_SESSION['password']);
		$user_ok = evalLoggedUser($db_conx,$log_id,$log_username,$log_password);
	}else if(isset($_COOKIE["userid"])&& isset($_COOKIE["username"])&& isset($_COOKIE["password"])){
		$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
		$_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['user']);
		$_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['pass']);
		$log_id = $_SESSION['userid'];
		$log_username = $_SESSION['username'];
		$log_password = $_SESSION['password'];
		$user_ok = evalLoggedUser($db_conx,$log_id,$log_username,$log_password);
		if($user_ok == true){
			$sql = "UPDATE USER_CREDS SET last_login=now() WHERE username='$log_username' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
                        $query = mysqli_query($db_conx1, $sql);
		}
	}
        
        //echo $user_ok;

?>