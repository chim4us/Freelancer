<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("php_codes/db_conx.php");

$tbl_user_login_history = "CREATE TABLE IF NOT EXISTS USER_CREDS(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		username	VARCHAR(25),
		first_name	VARCHAR(255),
		last_name	VARCHAR(255),
		user_dob 	DATETIME,
		status 		CHAR(1),
		email 		VARCHAR(255) NOT NULL,
        email_vri 	ENUM('Y','N') NOT NULL DEFAULT 'N',
        phone 		VARCHAR(20) NOT NULL,
        phone_vri 	ENUM('Y','N') NOT NULL DEFAULT 'N',
        address 	VARCHAR(300) NOT NULL,
        gender 		ENUM('M','F','O') NOT NULL,
        country 	VARCHAR(100) NOT NULL,
        del_flg 		ENUM('Y','N') NOT NULL DEFAULT 'N',
        new_user 	CHAR(1),
        pic_id 		VARCHAR(255) NOT NULL,
        ip 			VARCHAR(255) NOT NULL,
        ip2 			VARCHAR(255) NOT NULL,
        signup_date DATETIME NOT NULL,
        last_login 	DATETIME NOT NULL,
        lchg_time 	DATETIME NOT NULL,
        user_ref 	VARCHAR(25) NOT NULL,
        emp_ids 	VARCHAR(10),
        PRIMARY KEY(id)
);";

$query = mysqli_query($db_conx, $tbl_user_login_history);
if($query === TRUE){
    echo "<h3>USER_CREDS table created ok :) </h3>";
} else {
    echo "<h3>USER_CREDS table NOT created :( </h3>";
}

