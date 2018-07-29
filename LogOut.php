<?php

	session_start();
	$_SESSION = array();
	if(isset($_COOKIE["userid"])&& isset($_COOKIE["username"])&&isset($_COOKIE["password"])){
		setcookie("userid",'',strtotime( '-5 days' ), '/');
		setcookie("username",'',strtotime( '-5 days' ), '/');
		setcookie("password",'',strtotime( '-5 days' ), '/');
	}
        if(isset($_SESSION['PGurl'])) 
            $url = $_SESSION['PGurl']; // holds url for last page visited.
        else 
            $url = "index.php"; // default page for 
        
	session_destroy();
        echo $url;
        
	if(isset($_SESSION['username'])){
		header("location: $url?msg=Error:_logout_failed");
            //$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
            
	}else{
		header("location: $url");
            //$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
		exit();
	}
        
        //<?php 

?>