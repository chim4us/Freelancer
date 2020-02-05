<?php
include_once("php_codes/db_conx.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tbl_USER_CREDS = "CREATE TABLE IF NOT EXISTS USER_CREDS(
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
        address 	VARCHAR(300),
        gender 		ENUM('M','F','O') NOT NULL,
        country 	VARCHAR(100) NOT NULL,
        del_flg 	ENUM('Y','N') NOT NULL DEFAULT 'N',
        new_user 	CHAR(1),
        pic_id 		VARCHAR(255) ,
        ip 		VARCHAR(255) NOT NULL,
        ip2 		VARCHAR(255) NOT NULL,
        signup_date     DATETIME NOT NULL,
        last_login 	DATETIME,
        lchg_time 	DATETIME NOT NULL,
        user_ref 	VARCHAR(25) NOT NULL,
        emp_ids 	VARCHAR(10),
        PRIMARY KEY(id),
	INDEX (username)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_USER_CREDS);
if($query === TRUE){
    echo "<h3>USER_CREDS table created ok :) </h3>";
} else {
    echo "<h3>USER_CREDS table NOT created :( </h3>";
}


$tbl_Certification = "CREATE TABLE IF NOT EXISTS Certification(
        Id INT(10) NOT NULL AUTO_INCREMENT,
        Freelancer_id VARCHAR(25),
	certification_nam VARCHAR(255),
	provider varchar(255),
	description	text,
	date_earned	DATETIME,
	certification_link	text NOT NULL,
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        PRIMARY KEY(id),
	FOREIGN KEY (Freelancer_id) REFERENCES USER_CREDS(username)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Certification);
if($query === TRUE){
    echo "<h3>Certification table created ok :) </h3>";
} else {
    echo "<h3>Certification table NOT created :( </h3>";
}

$tbl_Freelancer = "CREATE TABLE IF NOT EXISTS Freelancer(
        Id		INT(10) NOT NULL AUTO_INCREMENT,
        user_account_id		VARCHAR(25),
	registration_date	DATETIME,
	location		varchar(255),
	overview		text,
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Freelancer);
if($query === TRUE){
    echo "<h3>Freelancer table created ok :) </h3>";
} else {
    echo "<h3>Freelancer table NOT created :( </h3>";
}

$tbl_Skill = "CREATE TABLE IF NOT EXISTS Skill(
        Id		INT(10) NOT NULL AUTO_INCREMENT,
        skill_name		varchar(128),
	del_flg ENUM('Y','N') DEFAULT 'N',
	PRIMARY KEY(id),
	INDEX (Id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Skill);
if($query === TRUE){
    echo "<h3>Skill table created ok :) </h3>";
} else {
    echo "<h3>Skill table NOT created :( </h3>";
}

$tbl_Has_Skill = "CREATE TABLE IF NOT EXISTS Has_Skill(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        freelancer		VARCHAR(25),
	skill_id	INT(10),
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id),
	FOREIGN KEY (freelancer) REFERENCES USER_CREDS(username),
	FOREIGN KEY (skill_id) REFERENCES Skill(Id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Has_Skill);
if($query === TRUE){
    echo "<h3>Has_Skill table created ok :) </h3>";
} else {
    echo "<h3>Has_Skill table NOT created :( </h3>";
}

$tbl_Test = "CREATE TABLE IF NOT EXISTS Test(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        test_name		VARCHAR(25) NOT NULL,
	test_link	text,
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id),
	INDEX (id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Test);
if($query === TRUE){
    echo "<h3>Test table created ok :) </h3>";
} else {
    echo "<h3>Test table NOT created :( </h3>";
}

$tbl_Test_Result = "CREATE TABLE IF NOT EXISTS Test_Result(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        freelancer_id		VARCHAR(25),
        test_id		int(10),
        start_time		DATETIME,
        end_time		DATETIME ,
        test_result_link		text ,
        score		decimal(5,2) ,
        display_on_profile		VARCHAR(255),
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id),
	FOREIGN KEY (test_id) REFERENCES Test(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Test_Result);
if($query === TRUE){
    echo "<h3>Test_Result table created ok :) </h3>";
} else {
    echo "<h3>Test_Result table NOT created :( </h3>";
}

$tbl_Payment_type = "CREATE TABLE IF NOT EXISTS Payment_type(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        type_name		varchar(128),
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id),
	INDEX (id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Payment_type);
if($query === TRUE){
    echo "<h3>Payment_type table created ok :) </h3>";
} else {
    echo "<h3>Payment_type table NOT created :( </h3>";
}

$tbl_Proposal_status_catalog = "CREATE TABLE IF NOT EXISTS Proposal_status_catalog(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        status_name		varchar(128),
	del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
	PRIMARY KEY(id),
	INDEX (id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Proposal_status_catalog);
if($query === TRUE){
    echo "<h3>Proposal_status_catalog table created ok :) </h3>";
} else {
    echo "<h3>Proposal_status_catalog table NOT created :( </h3>";
}


$inst_Proposal_status_catalog_int = "INSERT INTO `Proposal_status_catalog`(status_name,del_flg) values
            (upper('proposal sent'),'N'),
            (upper('negotiation phase'),'N'),
            (upper('proposal withdrawn'),'N'),
            (upper('proposal rejected'),'N'),
            (upper('proposal accepted'),'N'),
            (upper('job started'),'N'),
            (upper('job finished (successfully)'),'N'),
            (upper('job finished (unsuccessfully)'),'N');";
$query = mysqli_query($db_conx, $inst_Proposal_status_catalog_int);
if($query === TRUE){
    echo "<h3>Proposal_status_catalog table record inserted :) </h3>";
} else {
    echo "<h3>Proposal_status_catalog table record NOT inserted :( </h3>";
}


$tbl_Categorie = "CREATE TABLE IF NOT EXISTS Categorie(
        id		INT(10) NOT NULL AUTO_INCREMENT,
	Categorie_text	varchar(255),
	del_flg 	ENUM('Y','N')NOT NULL DEFAULT 'N',
	PRIMARY KEY(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Categorie);
if($query === TRUE){
    echo "<h3>Categorie table created ok :) </h3>";
} else {
    echo "<h3>Categorie table NOT created :( </h3>";
}

$tbl_Categorie = "CREATE TABLE IF NOT EXISTS Categorie(
        id		INT(10) NOT NULL AUTO_INCREMENT,
	Categorie_text	varchar(255),
	del_flg 	ENUM('Y','N')NOT NULL DEFAULT 'N',
	PRIMARY KEY(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Categorie);
if($query === TRUE){
    echo "<h3>Categorie table created ok :) </h3>";
} else {
    echo "<h3>Categorie table NOT created :( </h3>";
}

$tbl_expected_duration = "CREATE TABLE IF NOT EXISTS expected_duration(
        id INT(10) NOT NULL AUTO_INCREMENT,
	duration_text	varchar(255),
	del_flg ENUM('Y','N'),
	INDEX (id),
	PRIMARY KEY(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_expected_duration);
if($query === TRUE){
    echo "<h3>expected_duration table created ok :) </h3>";
} else {
    echo "<h3>expected_duration table NOT created :( </h3>";
}

$tbl_Complexity = "CREATE TABLE IF NOT EXISTS Complexity(
        id INT(10) NOT NULL AUTO_INCREMENT,
	complexity_text	varchar(255),
	del_flg ENUM('Y','N'),
	INDEX (id),
	PRIMARY KEY(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Complexity);
if($query === TRUE){
    echo "<h3>Complexity table created ok :) </h3>";
} else {
    echo "<h3>Complexity table NOT created :( </h3>";
}

$tbl_Job = "CREATE TABLE IF NOT EXISTS Job(
	id INT(10) NOT NULL AUTO_INCREMENT,
	categorie_id	INT(10),
	title	varchar(128),
	description	text,
	main_skill_id	INT(10),
	exp_date			DATETIME,
	del_flg 				ENUM('Y','N')NOT NULL DEFAULT 'N',
	hire_manager_id	VARCHAR(25) NOT NULL,	
	expected_duration_id	INT(10),
	complexity_id	INT(10),
	payment_type_id	INT(10),
	payment_amount	decimal(20,4),
        PRIMARY KEY(id),
	INDEX (id),
	FOREIGN KEY (categorie_id) REFERENCES Categorie(id),
	FOREIGN KEY (hire_manager_id) REFERENCES USER_CREDS(username),
	FOREIGN KEY (expected_duration_id) REFERENCES expected_duration(id),
	FOREIGN KEY (complexity_id) REFERENCES Complexity(id),
	FOREIGN KEY (main_skill_id) REFERENCES Skill(id),
	FOREIGN KEY (payment_type_id) REFERENCES Payment_type(id)
	)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Job);
if($query === TRUE){
    echo "<h3>Job table created ok :) </h3>";
} else {
    echo "<h3>Job table NOT created :( </h3>";
}