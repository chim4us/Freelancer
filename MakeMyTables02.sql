CREATE TABLE IF NOT EXISTS USER_CREDS(
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
        PRIMARY KEY(id),
		INDEX (username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Certification(
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
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Freelancer(
        Id		INT(10) NOT NULL AUTO_INCREMENT,
        user_account_id		VARCHAR(25),
		registration_date	DATETIME,
		location		varchar(255),
		overview		text,
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Skill(
        Id		INT(10) NOT NULL AUTO_INCREMENT,
        skill_name		varchar(128),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (Id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Has_Skill(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        freelancer		VARCHAR(25),
		skill_id	INT(10),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (freelancer) REFERENCES USER_CREDS(username),
		FOREIGN KEY (skill_id) REFERENCES Skill(Id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Test(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        test_name		VARCHAR(25) NOT NULL,
		test_link	text,
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Test_Result(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        freelancer_id		VARCHAR(25),
        test_id		int(10),
        start_time		DATETIME,
        end_time		DATETIME NOT NULL,
        test_result_link		text NOT NULL,
        score		decimal(5,2) NOT NULL,
        display_on_profile		VARCHAR(255),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (test_id) REFERENCES Test(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Payment_type(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        type_name		varchar(128),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Proposal_status_catalog(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        status_name		varchar(128),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id)
)ENGINE = InnoDB;

INSERT INTO `Proposal_status_catalog`(status_name,del_flg) values
            (upper('proposal sent'),'N'),
            (upper('negotiation phase'),'N'),
            (upper('proposal withdrawn'),'N'),
            (upper('proposal rejected'),'N'),
            (upper('proposal accepted'),'N'),
            (upper('job started'),'N'),
            (upper('job finished (successfully)'),'N'),
            (upper('job finished (unsuccessfully)'),'N');
			
CREATE TABLE IF NOT EXISTS Categorie(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		Categorie_text	varchar(255),
		del_flg 	ENUM('Y','N')NOT NULL DEFAULT 'N',
		PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS expected_duration(
        id INT(10) NOT NULL AUTO_INCREMENT,
		duration_text	varchar(255),
		del_flg ENUM('Y','N'),
		INDEX (id),
		PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Complexity(
        id INT(10) NOT NULL AUTO_INCREMENT,
		complexity_text	varchar(255),
		del_flg ENUM('Y','N'),
		INDEX (id),
		PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Job(
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
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Proposal(
        id		INT(10) NOT NULL AUTO_INCREMENT,
        job_id		INT(10),
		freelancer_id  VARCHAR(25),
		proposal_time	DATETIME,
		payment_type_id	INT(10),
		payment_amount	DECIMAL(20,4),
		current_proposal_status_id	int(10),
		client_grade	int(10) NOT NULL,
		client_comment	text NOT NULL,
		freelancer_grade	int(10) NOT NULL,
		freelancer_comment	text NOT NULL,
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id),
		FOREIGN KEY (job_id) REFERENCES Job(id),
		FOREIGN KEY (freelancer_id) REFERENCES USER_CREDS(username),
		FOREIGN KEY (payment_type_id) REFERENCES Payment_type(id),
		FOREIGN KEY (current_proposal_status_id) REFERENCES Proposal_status_catalog(id)
)ENGINE = InnoDB;

-----Please check this after the table creation
CREATE TABLE IF NOT EXISTS Contract(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		proposal_id	INT(10),
		company_id	VARCHAR(25),
		freelancer_id		VARCHAR(25),
		start_time		DATETIME,
		end_time		DATETIME	NOT NULL,
		payment_type_id		INT(10),
		payment_amount		DECIMAL(20,4),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id),
		FOREIGN KEY (proposal_id) REFERENCES Proposal(id),
		FOREIGN KEY (company_id) REFERENCES USER_CREDS(username),
		FOREIGN KEY (freelancer_id) REFERENCES USER_CREDS(username),
		FOREIGN KEY (payment_type_id) REFERENCES Payment_type(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Attachment(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		attachment_in	text,
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		INDEX (id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Message(
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
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Company_Proposal_And_Contract(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		company_name	varchar(25),
		company_location varchar(255),
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (company_name) REFERENCES USER_CREDS(username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Freelancer_Proposal_And_Contract(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		user_account_id	varchar(25),
		reistration_date	DATETIME,
		location	varchar(255),
		overview	text,
		del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (user_account_id) REFERENCES USER_CREDS(username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS USER_LOGIN_CREDS(
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
		del_flg 		ENUM('Y','N') NOT NULL DEFAULT 'N',
        PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS USER_PHONE_EMAIL(
        id INT(10) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone_email VARCHAR(10) NOT NULL,
        email_vri_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        email_vri_time DATETIME NOT NULL,
        email_vri_code VARCHAR(255) NOT NULL,
        phone_vri_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        phone_vri_time DATETIME NOT NULL,
        phone_vri_code VARCHAR(255) NOT NULL,
        lchg_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        preferred_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
		PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS USER_BLOCK_DETAILS(
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
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS USER_LOGIN_HISTORY(
        id INT(10) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) NOT NULL,
        login_time DATETIME NOT NULL,
        ip VARCHAR(255) NOT NULL,
        ip2 VARCHAR(255) NOT NULL,
        PRIMARY KEY(id),
		FOREIGN KEY (username) REFERENCES USER_CREDS(username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Other_Skills(
		id INT(10) NOT NULL AUTO_INCREMENT,
		job_id	INT(10),
		skill_id INT(10),
		PRIMARY KEY(id),
		FOREIGN KEY (job_id) REFERENCES Job(id),
		FOREIGN KEY (skill_id) REFERENCES Skill(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Hire_Manager(
		id INT(10) NOT NULL AUTO_INCREMENT,
		user_account_i	VARCHAR(25) NOT NULL,
		registration_date	DATETIME,
		location		varchar(255),
		company_id	VARCHAR(25) NOT NULL,
		del_flg 		ENUM('Y','N'),
		PRIMARY KEY(id),
		FOREIGN KEY (user_account_i) REFERENCES USER_CREDS(username),
		FOREIGN KEY (company_id) REFERENCES USER_CREDS(username)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Project(
        id		INT(10) NOT NULL AUTO_INCREMENT,
		categorie_id	INT(10),
		pro_title	varchar(128),
		pro_des	text,
		skills			varchar(255),
		budget			decimal(20,4),
		exp_date			DATETIME,
		del_flg 				ENUM('Y','N')NOT NULL DEFAULT 'N',
		company_id	varchar(25),
		PRIMARY KEY(id),
		FOREIGN KEY (categorie_id) REFERENCES Job(id),
		FOREIGN KEY (company_id) REFERENCES USER_CREDS(username)
);