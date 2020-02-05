<?php 
include_once("php_codes/db_conx.php");

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
        del_flg 		ENUM('Y','N') NOT NULL DEFAULT 'N',
        new_user 	CHAR(1),
        pic_id 		VARCHAR(255) ,
        ip 			VARCHAR(255) NOT NULL,
        ip2 			VARCHAR(255) NOT NULL,
        signup_date DATETIME NOT NULL,
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

$tbl_Proposal = "CREATE TABLE IF NOT EXISTS Proposal(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        job_id		INT(10),
		freelancer_id  VARCHAR(25),
		proposal_time	DATETIME,
		payment_type_id	INT(10),
		payment_amount	DECIMAL(20,4),
		current_proposal_status_id	int(10),
		client_grade	int(10) ,
		client_comment	text ,
		freelancer_grade	int(10) ,
		freelancer_comment	text ,
		del_flg ENUM('Y','N')  DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id),
		FOREIGN KEY (job_id) REFERENCES Job(id),
		FOREIGN KEY (freelancer_id) REFERENCES USER_CREDS(username),
		FOREIGN KEY (payment_type_id) REFERENCES Payment_type(id),
		FOREIGN KEY (current_proposal_status_id) REFERENCES Proposal_status_catalog(id)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Proposal);
if($query === TRUE){
    echo "<h3>Proposal table created ok :) </h3>";
} else {
    echo "<h3>Proposal table NOT created :( </h3>";
}

$tbl_Contract = "CREATE TABLE IF NOT EXISTS Contract(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		proposal_id	INT(10),
		company_id	VARCHAR(25),
		freelancer_id		VARCHAR(25),
		start_time		DATETIME,
		end_time		DATETIME	,
		payment_type_id		INT(10),
		payment_amount		DECIMAL(20,4),
		del_flg ENUM('Y','N') DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id),
		FOREIGN KEY (proposal_id) REFERENCES Proposal(id),
		FOREIGN KEY (company_id) REFERENCES USER_CREDS(username),
		FOREIGN KEY (freelancer_id) REFERENCES USER_CREDS(username),
		FOREIGN KEY (payment_type_id) REFERENCES Payment_type(id)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Contract);
if($query === TRUE){
    echo "<h3>Contract table created ok :) </h3>";
} else {
    echo "<h3>Contract table NOT created :( </h3>";
}

$tbl_Attachment = "CREATE TABLE IF NOT EXISTS Attachment(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		attachment_in	text,
		del_flg ENUM('Y','N') DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Attachment);
if($query === TRUE){
    echo "<h3>Attachment table created ok :) </h3>";
} else {
    echo "<h3>Attachment table NOT created :( </h3>";
}

$tbl_Message = "CREATE TABLE IF NOT EXISTS Message(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		freelancer_id		VARCHAR(25),
		hire_manager_id		VARCHAR(25),
		message_time		DATETIME,
		message_text		text,
		proposal_id			INT(10),
		attachment_id	INT(10),
		proposal_status_catalog_i	INT(10),
		PRIMARY KEY(id),
		FOREIGN KEY (freelancer_id) REFERENCES USER_CREDS(username),						
		FOREIGN KEY (hire_manager_id) REFERENCES USER_CREDS(username),				
		FOREIGN KEY (attachment_id) REFERENCES Attachment(id),
		FOREIGN KEY (proposal_id) REFERENCES Proposal(id),
		FOREIGN KEY (proposal_status_catalog_i) REFERENCES Proposal_status_catalog(id)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Message);
if($query === TRUE){
    echo "<h3>Message table created ok :) </h3>";
} else {
    echo "<h3>Message table NOT created :( </h3>";
}

$tbl_Company_Proposal_And_Contract = "CREATE TABLE IF NOT EXISTS Company_Proposal_And_Contract(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		company_name	varchar(25),
		company_location varchar(255),
		del_flg ENUM('Y','N') DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (company_name) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Company_Proposal_And_Contract);
if($query === TRUE){
    echo "<h3>Company_Proposal_And_Contract table created ok :) </h3>";
} else {
    echo "<h3>Company_Proposal_And_Contract table NOT created :( </h3>";
}

$tbl_Freelancer_Proposal_And_Contract = "CREATE TABLE IF NOT EXISTS Freelancer_Proposal_And_Contract(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		user_account_id	varchar(25),
		reistration_date	DATETIME,
		location	varchar(255),
		overview	text,
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (user_account_id) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Freelancer_Proposal_And_Contract);
if($query === TRUE){
    echo "<h3>Freelancer_Proposal_And_Contract table created ok :) </h3>";
} else {
    echo "<h3>Freelancer_Proposal_And_Contract table NOT created :( </h3>";
}

$tbl_USER_LOGIN_CREDS = "CREATE TABLE IF NOT EXISTS USER_LOGIN_CREDS(
        id INT(10) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25),
        role_id VARCHAR(30),
        password VARCHAR(255) ,
        pwd_vry_code VARCHAR(255) ,
        num_pwd_history INT(2) ,
        pwd_history VARCHAR(5072) ,
        pwd_last_mod_time DATETIME ,
        num_pwd_attempts INT(2),
        login_time DATETIME,
        disable_from_date DATETIME,
        disable_to_date DATETIME,
        pwd_exp_date DATETIME,
        last_access_time DATETIME,
		del_flg 		ENUM('Y','N') DEFAULT 'N',
        PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_USER_LOGIN_CREDS);
if($query === TRUE){
    echo "<h3>USER_LOGIN_CREDS table created ok :) </h3>";
} else {
    echo "<h3>USER_LOGIN_CREDS table NOT created :( </h3>";
}

$tbl_USER_PHONE_EMAIL = "CREATE TABLE IF NOT EXISTS USER_PHONE_EMAIL(
        id INT(10) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) NOT NULL,
        phone VARCHAR(20) ,
        email VARCHAR(255) ,
        phone_email VARCHAR(10) NOT NULL,
        email_vri_flg ENUM('Y','N') DEFAULT 'N',
        email_vri_time DATETIME ,
        email_vri_code VARCHAR(255) ,
        phone_vri_flg ENUM('Y','N') DEFAULT 'N',
        phone_vri_time DATETIME ,
        phone_vri_code VARCHAR(255) ,
        lchg_time DATETIME,
        del_flg ENUM('Y','N') DEFAULT 'N',
        preferred_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_USER_PHONE_EMAIL);
if($query === TRUE){
    echo "<h3>USER_PHONE_EMAIL table created ok :) </h3>";
} else {
    echo "<h3>USER_PHONE_EMAIL table NOT created :( </h3>";
}

$tbl_USER_BLOCK_DETAILS = "CREATE TABLE IF NOT EXISTS USER_BLOCK_DETAILS(
        id INT(10)  NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) NOT NULL,
        block_user VARCHAR(25) NOT NULL,
        block_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        lchg_time DATETIME NOT NULL,
        rcre_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username),
		FOREIGN KEY (block_user) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_USER_BLOCK_DETAILS);
if($query === TRUE){
    echo "<h3>USER_BLOCK_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>USER_BLOCK_DETAILS table NOT created :( </h3>";
}

$tbl_USER_LOGIN_HISTORY = "CREATE TABLE IF NOT EXISTS USER_LOGIN_HISTORY(
        id INT(10) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        login_time DATETIME ,
        ip VARCHAR(255) ,
        ip2 VARCHAR(255) ,
        PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_USER_LOGIN_HISTORY);
if($query === TRUE){
    echo "<h3>USER_LOGIN_HISTORY table created ok :) </h3>";
} else {
    echo "<h3>USER_LOGIN_HISTORY table NOT created :( </h3>";
}

$tbl_Other_Skills = "CREATE TABLE IF NOT EXISTS Other_Skills(
		id INT(10) NOT NULL AUTO_INCREMENT,
		job_id	INT(10),
		skill_id INT(10),
		PRIMARY KEY(id),
		FOREIGN KEY (job_id) REFERENCES Job(id),
		FOREIGN KEY (skill_id) REFERENCES Skill(id)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Other_Skills);
if($query === TRUE){
    echo "<h3>Other_Skills table created ok :) </h3>";
} else {
    echo "<h3>Other_Skills table NOT created :( </h3>";
}

$tbl_Hire_Manager = "CREATE TABLE IF NOT EXISTS Hire_Manager(
		id INT(10) NOT NULL AUTO_INCREMENT,
		user_account_i	VARCHAR(25) ,
		registration_date	DATETIME,
		location		varchar(255),
		company_id	VARCHAR(25) ,
		del_flg 		ENUM('Y','N'),
		PRIMARY KEY(id),
		FOREIGN KEY (user_account_i) REFERENCES USER_CREDS(username),
		FOREIGN KEY (company_id) REFERENCES USER_CREDS(username)
		)ENGINE = InnoDB;";
$query = mysqli_query($db_conx, $tbl_Hire_Manager);
if($query === TRUE){
    echo "<h3>Hire_Manager table created ok :) </h3>";
} else {
    echo "<h3>Hire_Manager table NOT created :( </h3>";
}

$tbl_Categories = "CREATE TABLE IF NOT EXISTS FORM_CATEGORIES(
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            cat_name VARCHAR(150) ,
            cat_value VARCHAR(150) ,
            Del_flg ENUM('Y','N') DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_Categories);
if($query === TRUE){
    echo "<h3>CATEGORIES table created ok :) </h3>";
} else {
    echo "<h3>CATEGORIES table NOT created :( </h3>";
}

$tbl_LOCATION = "CREATE TABLE IF NOT EXISTS FORM_LOCATION(
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            loc_name VARCHAR(150) ,
            loc_value VARCHAR(150) ,
            Del_flg ENUM('Y','N') DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_LOCATION);
if($query === TRUE){
    echo "<h3>LOCATION table created ok :) </h3>";
} else {
    echo "<h3>LOCATION table NOT created :( </h3>";
}

$tbl_PROJECT = "CREATE TABLE IF NOT EXISTS FORM_PROJECT(
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            pro_name VARCHAR(150) ,
            pro_value VARCHAR(150) ,
            Del_flg ENUM('Y','N') DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_PROJECT);
if($query === TRUE){
    echo "<h3>PROJECT table created ok :) </h3>";
} else {
    echo "<h3>PROJECT table NOT created :( </h3>";
}

$tbl_PROJECT = "CREATE TABLE IF NOT EXISTS FORM_PAYMENT(
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            pro_name VARCHAR(150) ,
            pro_value VARCHAR(150) ,
            Del_flg ENUM('Y','N')  DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_PROJECT);
if($query === TRUE){
    echo "<h3>FORM_PAYMENT table created ok :) </h3>";
} else {
    echo "<h3>FORM_PAYMENT table NOT created :( </h3>";
}