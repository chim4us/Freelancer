<?php

include_once("php_codes/db_conx.php");

$tbl_crncy_syn = "CREATE TABLE IF NOT EXISTS CRNCY_SYN(
        id INT(10) NOT NULL AUTO_INCREMENT,
        acct_crncy_code VARCHAR(3),
        acct_crncy_syn  VARCHAR(10),
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        country_id VARCHAR(8),
        PRIMARY KEY(id)
        );";
$query = mysqli_query($db_conx, $tbl_crncy_syn);
if($query === TRUE){
    echo "<h3>CRNCY_SYN table created ok :) </h3>";
} else {
    echo "<h3>CRNCY_SYN table NOT created :( </h3>";
}

$tbl_crncy_rate = "CREATE TABLE IF NOT EXISTS CRNCY_RATE(
        id INT(10) NOT NULL AUTO_INCREMENT,
        fxd_crncy_code VARCHAR(3),
        var_crncy_code VARCHAR(3),
        rate_code VARCHAR (5),
        del_flg ENUM('Y','N') DEFAULT 'N',
        var_crncy_units DECIMAL(20,4),
        fxd_crncy_units DECIMAL(20,4),
        lchg_time DATETIME ,
        lchg_username VARCHAR(25),
        rtlist_date DATETIME ,
        country_id VARCHAR(8),
        PRIMARY KEY(id)
        );";
$query = mysqli_query($db_conx, $tbl_crncy_rate);
if($query === TRUE){
    echo "<h3>CRNCY_RATE table created ok :) </h3>";
} else {
    echo "<h3>CRNCY_RATE table NOT created :( </h3>";
}

$tbl_Categories = "CREATE TABLE IF NOT EXISTS CATEGORIES(
            id BIGINT(255)  AUTO_INCREMENT,
            cat_name VARCHAR(150) ,
            cat_value VARCHAR(150) ,
            Del_flg ENUM('Y','N')  DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_Categories);
if($query === TRUE){
    echo "<h3>CATEGORIES table created ok :) </h3>";
} else {
    echo "<h3>CATEGORIES table NOT created :( </h3>";
}

$tbl_LOCATION = "CREATE TABLE IF NOT EXISTS LOCATION(
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            loc_name VARCHAR(150) ,
            loc_value VARCHAR(150) ,
            Del_flg ENUM('Y','N')  DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_LOCATION);
if($query === TRUE){
    echo "<h3>LOCATION table created ok :) </h3>";
} else {
    echo "<h3>LOCATION table NOT created :( </h3>";
}

$tbl_PROJECT = "CREATE TABLE IF NOT EXISTS PROJECT(
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            pro_name VARCHAR(150) ,
            pro_value VARCHAR(150) ,
            Del_flg ENUM('Y','N')  DEFAULT 'N',
            country_id VARCHAR(8),
            PRIMARY KEY(id));
        ";
$query = mysqli_query($db_conx, $tbl_PROJECT);
if($query === TRUE){
    echo "<h3>PROJECT table created ok :) </h3>";
} else {
    echo "<h3>PROJECT table NOT created :( </h3>";
}

$tbl_Post = "CREATE TABLE IF NOT EXISTS PROJECT_POST(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        proj_id VARCHAR(150) , 
        proj_pic VARCHAR(255) ,
        title VARCHAR(120) ,
        rank CHAR (1),
        rank_cnt INT(10) ,
        message TEXT ,
        skill VARCHAR(900) ,
        budget_low DECIMAL(20,4),
        budget_high DECIMAL(20,4),
        del_flg ENUM('Y','N')  DEFAULT 'N',
        comp_flg ENUM('Y','N')  DEFAULT 'N',
        lchg_time DATETIME ,
        recre_time DATETIME ,
        exp_date DATETIME ,
        country_id VARCHAR(8),
        PRIMARY KEY(id))";
        //. "UNIQUE KEY userunique (username,proj_id))";
$query = mysqli_query($db_conx, $tbl_Post);
if($query === TRUE){
    echo "<h3>PROJECT_POST table created ok :) </h3>";
} else {
    echo "<h3>PROJECT_POST table NOT created :( </h3>";
}

$tbl_Post_index = "CREATE INDEX IDX_PROJECT_POST_ID ON PROJECT_POST (id);";
$query = mysqli_query($db_conx, $tbl_Post_index);
if($query === TRUE){
    echo "<h3>IDX_PROJECT_POST_ID index created ok :) </h3>";
} else {
    echo "<h3>IDX_PROJECT_POST_ID index NOT created :( </h3>";
}

$tbl_Post_index_msg = "CREATE INDEX IDX_PROJECT_POST_MSG ON PROJECT_POST (username,proj_id,del_flg);";
$query = mysqli_query($db_conx, $tbl_Post_index_msg);
if($query === TRUE){
    echo "<h3>IDX_PROJECT_POST_ID index created ok :) </h3>";
} else {
    echo "<h3>IDX_PROJECT_POST_ID index NOT created :( </h3>";
}

$tbl_Post = "CREATE TABLE IF NOT EXISTS USER_SKILL(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) , 
        skill_id VARCHAR(150) , 
        skill_pic VARCHAR(255) ,
        title VARCHAR(120) ,
        rank CHAR (1),
        rank_cnt INT(10) ,
        message TEXT ,
        skill VARCHAR(900) ,
        budget_low DECIMAL(20,4),
        budget_high DECIMAL(20,4),
        del_flg ENUM('Y','N')  DEFAULT 'N',
        lchg_time DATETIME ,
        recre_time DATETIME ,
        exp_date DATETIME ,
        country_id VARCHAR(8),
        PRIMARY KEY(id))";
        //. "UNIQUE KEY userunique (username,proj_id))";
$query = mysqli_query($db_conx, $tbl_Post);
if($query === TRUE){
    echo "<h3>PROJECT_POST table created ok :) </h3>";
} else {
    echo "<h3>PROJECT_POST table NOT created :( </h3>";
}

$tbl_Post = "CREATE TABLE IF NOT EXISTS PROJECT_POST_HIS(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) , 
        proj_id VARCHAR(150) , 
        proj_pic VARCHAR(255) ,
        title VARCHAR(120) ,
        rank CHAR (1),
        rank_cnt INT(10) ,
        message TEXT ,
        skill VARCHAR(900) ,
        budget_low DECIMAL(20,4),
        budget_high DECIMAL(20,4),
        del_flg ENUM('Y','N') DEFAULT 'N',
        comp_flg ENUM('Y','N')  DEFAULT 'N',
        lchg_time DATETIME ,
        recre_time DATETIME ,
        exp_date DATETIME ,
        country_id VARCHAR(8),
        PRIMARY KEY(id))";
        //. "UNIQUE KEY userunique (username,proj_id))";
$query = mysqli_query($db_conx, $tbl_Post);
if($query === TRUE){
    echo "<h3>PROJECT_POST table created ok :) </h3>";
} else {
    echo "<h3>PROJECT_POST table NOT created :( </h3>";
}

$tbl_Post_assign_user = "CREATE TABLE IF NOT EXISTS PROJECT_ASSIGN_USER(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        pro_post_id BIGINT ,
        proj_id VARCHAR(150) ,
        username VARCHAR(25) ,
        assign_user VARCHAR(25) ,
        assign_date DATETIME ,
        exp_date DATETIME ,
        del_flg ENUM('Y','N') DEFAULT 'N',
        comp_percen INT(4) ,
        comp_flg ENUM('Y','N')  DEFAULT 'N',
        remarks VARCHAR(600) ,
        country_id VARCHAR(8),
        PRIMARY KEY(id))";
$query = mysqli_query($db_conx, $tbl_Post_assign_user);
if($query === TRUE){
    echo "<h3>PROJECT_ASSIGN_USER table created ok :) </h3>";
} else {
    echo "<h3>PROJECT_ASSIGN_USER table NOT created :( </h3>";
}

$tbl_pro_asgn_index = "CREATE INDEX IDX_PROJECT_ASGN_USER ON PROJECT_ASSIGN_USER (assign_user,proj_id,del_flg);";
$query = mysqli_query($db_conx, $tbl_pro_asgn_index);
if($query === TRUE){
    echo "<h3>IDX_PROJECT_ASGN_USER index created ok :) </h3>";
} else {
    echo "<h3>IDX_PROJECT_ASGN_USER index NOT created :( </h3>";
}

$tbl_user_creds = "CREATE TABLE IF NOT EXISTS USER_CREDS(
        id BIGINT(50) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        first_name VARCHAR(255) ,
        last_name VARCHAR(255) ,
        user_dob DATETIME ,
        status CHAR(1),
        email VARCHAR(255) ,
        email_vri ENUM('Y','N')  DEFAULT 'N',
        phone VARCHAR(20) ,
        phone_vri ENUM('Y','N')  DEFAULT 'N',
        address VARCHAR(300) ,
        gender ENUM('M','F','O') ,
        country VARCHAR(100) ,
        del_flg ENUM('Y','N') DEFAULT 'N',
        new_user CHAR(1),
        pic_id VARCHAR(255) ,
        ip VARCHAR(255) ,
        ip2 VARCHAR(255) ,
        signup_date DATETIME ,
        last_login DATETIME ,
        lchg_time DATETIME ,
        user_ref VARCHAR(25) ,
        emp_ids VARCHAR(10),
        country_id VARCHAR(8),
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_user_creds);
if($query === TRUE){
    echo "<h3>USER_CREDS table created ok :) </h3>";
} else {
    echo "<h3>USER_CREDS table NOT created :( </h3>";
}

$tbl_user_login_creds = "CREATE TABLE IF NOT EXISTS USER_LOGIN_CREDS(
        id BIGINT(50) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        role_id VARCHAR(30),
        password VARCHAR(255) ,
        pwd_vry_code VARCHAR(255) ,
        num_pwd_history INT(2) ,
        pwd_history VARCHAR(5072) ,
        pwd_last_mod_time DATETIME ,
        num_pwd_attempts INT(2) ,
        login_time DATETIME ,
        disable_from_date DATETIME ,
        disable_to_date DATETIME ,
        pwd_exp_date DATETIME ,
        last_access_time DATETIME ,
        country_id VARCHAR(8), 
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_user_login_creds);
if($query === TRUE){
    echo "<h3>USER_LOGIN_CREDS table created ok :) </h3>";
} else {
    echo "<h3>USER_LOGIN_CREDS table NOT created :( </h3>";
}

$tbl_Post_index = "CREATE INDEX IDX_USER_LOGIN_CREDS ON USER_LOGIN_CREDS (username);";
$query = mysqli_query($db_conx, $tbl_Post_index);
if($query === TRUE){
    echo "<h3>IDX_PROJECT_POST_ID index created ok :) </h3>";
} else {
    echo "<h3>IDX_PROJECT_POST_ID index NOT created :( </h3>";
}

$tbl_pic_details = "CREATE TABLE IF NOT EXISTS PIC_DETAILS(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        pic_id VARCHAR(50),
        username VARCHAR(25) ,
        lchg_time DATETIME ,
        pic_type VARCHAR(30),
        del_flg ENUM('Y','N') DEFAULT 'N',
        preferred_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8),
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_pic_details);
if($query === TRUE){
    echo "<h3>PIC_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>PIC_DETAILS table NOT created :( </h3>";
}

$tbl_pic_details = "CREATE INDEX IDX_PIC_DETAILS ON PIC_DETAILS (username,pic_id,pic_type);";
$query = mysqli_query($db_conx, $tbl_pic_details);
if($query === TRUE){
    echo "<h3>IDX_PIC_DETAILS index created ok :) </h3>";
} else {
    echo "<h3>IDX_PIC_DETAILS index NOT created :( </h3>";
}

$tbl_pass_details = "CREATE TABLE IF NOT EXISTS PASS_DETAILS(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        password VARCHAR(255) ,
        lchg_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        preferred_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8), 
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_pass_details);
if($query === TRUE){
    echo "<h3>PASS_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>PASS_DETAILS table NOT created :( </h3>";
}

$tbl_phone_email = "CREATE TABLE IF NOT EXISTS USER_PHONE_EMAIL(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        phone VARCHAR(20) ,
        email VARCHAR(255) ,
        phone_email VARCHAR(10) ,
        email_vri_flg ENUM('Y','N') DEFAULT 'N',
        email_vri_time DATETIME ,
        email_vri_code VARCHAR(255) ,
        phone_vri_flg ENUM('Y','N')  DEFAULT 'N',
        phone_vri_time DATETIME ,
        phone_vri_code VARCHAR(255) ,
        lchg_time DATETIME ,
        del_flg ENUM('Y','N') DEFAULT 'N',
        preferred_flg ENUM('Y','N') DEFAULT 'N',
        country_id VARCHAR (8), 
        PRIMARY KEY(id));";
$query = mysqli_query($db_conx, $tbl_phone_email);
if($query === TRUE){
    echo "<h3>USER_PHONE_EMAIL table created ok :) </h3>";
} else {
    echo "<h3>USER_PHONE_EMAIL table NOT created :( </h3>";
}

$idx_user_phone_email = "CREATE INDEX IDX_USER_PHONE_EMAIL ON USER_PHONE_EMAIL (username,phone_email,"
        . "preferred_flg,email,phone);";
$query = mysqli_query($db_conx, $idx_user_phone_email);
if($query === TRUE){
    echo "<h3>IDX_USER_PHONE_EMAIL index created ok :) </h3>";
} else {
    echo "<h3>IDX_USER_PHONE_EMAIL index NOT created :( </h3>";
}

$tbl_general_acct_details = "CREATE TABLE IF NOT EXISTS GENERAL_ACCOUNT_DETAILS(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        acct_num VARCHAR(16) , 
        acct_opn_date DATETIME ,
        frez_code CHAR(1) ,
        frez_reason_code VARCHAR (5) ,
        frez_remarks VARCHAR(60) ,
        acct_cls_flg ENUM('Y','N')  DEFAULT 'N',
        xfer_cr_excp_amt_lim DECIMAL(20,4),
        xfer_dr_excp_amt_lim DECIMAL(20,4),
        balance DECIMAL(20,4),
        cum_dr_amt DECIMAL(20,4),
        cum_cr_amt DECIMAL(20,4),
        del_flg ENUM('Y','N')  DEFAULT 'N',
        last_tran_id VARCHAR(24),
        last_tran_amt DECIMAL(20,4),
        last_clr_tran_id VARCHAR(24),
        last_clr_amt DECIMAL(20,4),
        last_dr_tran_id VARCHAR(24),
        last_dr_amt DECIMAL(20,4),
        lchg_time DATETIME ,
        hash_number VARCHAR(350) ,
        acct_crcny_code VARCHAR(3) ,
        schm_type VARCHAR(3),
        schm_code VARCHAR(5),
        country_id VARCHAR (8), 
        PRIMARY KEY(id))";
$query = mysqli_query($db_conx, $tbl_general_acct_details);
if($query === TRUE){
    echo "<h3>GENERAL_ACCOUNT_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>GENERAL_ACCOUNT_DETAILS table NOT created :( </h3>";
}

$idx_GAD = "CREATE INDEX IDX_GAD ON GENERAL_ACCOUNT_DETAILS (acct_num);";
$query = mysqli_query($db_conx, $idx_GAD);
if($query === TRUE){
    echo "<h3>IDX_GAD index created ok :) </h3>";
} else {
    echo "<h3>IDX_GAD index NOT created :( </h3>";
}

$tbl_DAILY_TRANSACTION = "CREATE TABLE IF NOT EXISTS DAILY_TRANSACTION_DETAILS(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        acct_num VARCHAR(16) ,
        tran_amt DECIMAL(20,4),
        tran_date DATETIME ,
        tran_id VARCHAR(24) ,
        part_tran_type CHAR(1),
        part_tran_srl_num VARCHAR(4),
        tran_sub_type VARCHAR(2),
        tran_type CHAR (1),
        narration VARCHAR(100) ,
        entry_username VARCHAR(25) ,
        entry_date DATETIME ,
        pstd_username VARCHAR(25) ,
        pstd_date DATETIME ,
        pst_flg ENUM('Y','N')  DEFAULT 'N',
        del_flg ENUM('Y','N') DEFAULT 'N',
        tran_crcny_code VARCHAR(3) ,
        tran_gate_way VARCHAR(50) ,
        country_id VARCHAR(8), 
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_DAILY_TRANSACTION);
if($query === TRUE){
    echo "<h3>DAILY_TRANSACTION_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>DAILY_TRANSACTION_DETAILS table NOT created :( </h3>";
}

$tbl_bank_details = "CREATE TABLE IF NOT EXISTS BANK_DETAILS(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        bank_name VARCHAR(255) ,
        acct_num VARCHAR(20) ,
        acct_name VARCHAR(100) ,
        acct_type ENUM('S','C','I','Q') ,
        lchg_time DATETIME ,
        rcre_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8), 
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_bank_details);
if($query === TRUE){
    echo "<h3>BANK_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>BANK_DETAILS table NOT created :( </h3>";
}

$tbl_user_options = "CREATE TABLE IF NOT EXISTS USER_OPTIONS(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        question VARCHAR(2050) ,
        answer VARCHAR(2050) ,
        lchg_time DATETIME ,
        rcre_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8),
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_user_options);
if($query === TRUE){
    echo "<h3>USER_OPTIONS table created ok :) </h3>";
} else {
    echo "<h3>USER_OPTIONS table NOT created :( </h3>";
}

$tbl_user_options_his = "CREATE TABLE IF NOT EXISTS USER_OPTIONS_HIS(
        id BIGINT(255) ,
        user_id BIGINT(100) ,
        username VARCHAR(25) ,
        question VARCHAR(2050) ,
        answer VARCHAR(2050) ,
        lchg_time DATETIME ,
        rcre_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8)
        )";
$query = mysqli_query($db_conx, $tbl_user_options_his);
if($query === TRUE){
    echo "<h3>USER_OPTIONS_HIS table created ok :) </h3>";
} else {
    echo "<h3>USER_OPTIONS_HIS table NOT created :( </h3>";
}

$tbl_user_block_details = "CREATE TABLE IF NOT EXISTS USER_BLOCK_DETAILS(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        block_user VARCHAR(25) ,
        block_flg ENUM('Y','N')  DEFAULT 'N',
        lchg_time DATETIME ,
        rcre_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8), 
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_user_block_details);
if($query === TRUE){
    echo "<h3>USER_BLOCK_DETAILS table created ok :) </h3>";
} else {
    echo "<h3>USER_BLOCK_DETAILS table NOT created :( </h3>";
}

$tbl_rank_system = "CREATE TABLE IF NOT EXISTS RANK_SYSTEM(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        proj_id VARCHAR(150) ,
        rank CHAR (1),
        rank_cnt INT(10) ,
        rank_type VARCHAR(30) ,
        lchg_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8), 
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_rank_system);
if($query === TRUE){
    echo "<h3>RANK_SYSTEM table created ok :) </h3>";
} else {
    echo "<h3>RANK_SYSTEM table NOT created :( </h3>";
}

$tbl_rank_system = "CREATE TABLE IF NOT EXISTS RANK_SYSTEM_HIS(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        rank_num CHAR (1),
        ranked_user VARCHAR(25) ,
        rank_type VARCHAR(30) ,
        lchg_time DATETIME ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        country_id VARCHAR(8),
        PRIMARY KEY(id)
        )";
$query = mysqli_query($db_conx, $tbl_rank_system);
if($query === TRUE){
    echo "<h3>RANK_SYSTEM table created ok :) </h3>";
} else {
    echo "<h3>RANK_SYSTEM table NOT created :( </h3>";
}

$tbl_user_activities = "CREATE TABLE IF NOT EXISTS USER_ACTIVITIES(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        description TEXT ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        entry_date  DATETIME ,
        country_id VARCHAR(8), 
        PRIMARY KEY(id));";
		
$query = mysqli_query($db_conx, $tbl_user_activities);
if($query === TRUE){
    echo "<h3>USER_ACTIVITIES table created ok :) </h3>";
} else {
    echo "<h3>USER_ACTIVITIES table NOT created :( </h3>";
}
        
$tbl_user_login_history = "CREATE TABLE IF NOT EXISTS USER_LOGIN_HISTORY(
        id BIGINT(100) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        login_time DATETIME ,
        ip VARCHAR(255) ,
        ip2 VARCHAR(255) ,
        country_id VARCHAR(8), 
        PRIMARY KEY(id));";
$query = mysqli_query($db_conx, $tbl_user_login_history);
if($query === TRUE){
    echo "<h3>USER_LOGIN_HISTORY table created ok :) </h3>";
} else {
    echo "<h3>USER_LOGIN_HISTORY table NOT created :( </h3>";
}

$tbl_user_complains = "CREATE TABLE IF NOT EXISTS USER_COMPLAINS(
        id BIGINT(255) NOT NULL AUTO_INCREMENT,
        username VARCHAR(25) ,
        ticket_id VARCHAR(25) ,
        mssg_header VARCHAR(255) ,
        mssg_contain TEXT ,
        entry_date  DATETIME ,
        clsd_user VARCHAR(25) ,
        clsd_flg ENUM('Y','N') DEFAULT 'N',
        del_flg ENUM('Y','N') DEFAULT 'N',
        country_id VARCHAR(8), 
        PRIMARY KEY(id));";
		
$query = mysqli_query($db_conx, $tbl_user_complains);
if($query === TRUE){
    echo "<h3>USER_COMPLAINS table created ok :) </h3>";
} else {
    echo "<h3>USER_COMPLAINS table NOT created :( </h3>";
}

$tbl_system_group_cntrl = "CREATE TABLE IF NOT EXISTS SYSTEM_GROUP_CONTROL_TBL(
        id BIGINT(10) NOT NULL AUTO_INCREMENT,
        acct_crcny_code VARCHAR(3) ,
        country_id VARCHAR(8) , 
        site_url VARCHAR(255) ,
        del_flg ENUM('Y','N')  DEFAULT 'N',
        sysdate DATETIME ,
        cum_dr_amt DECIMAL(20,4),
        cum_cr_amt DECIMAL(20,4),
        lchg_time DATETIME ,
        PRIMARY KEY(id));";
		
$query = mysqli_query($db_conx, $tbl_system_group_cntrl);
if($query === TRUE){
    echo "<h3>SYSTEM_GROUP_CONTROL_TBL table created ok :) </h3>";
} else {
    echo "<h3>SYSTEM_GROUP_CONTROL_TBL table NOT created :( </h3>";
}

$insert = "INSERT INTO `SYSTEM_GROUP_CONTROL_TBL` (`id`, `acct_crcny_code`, `country_id`, `site_url`, 
            `del_flg`, `sysdate`, `cum_dr_amt`, `cum_cr_amt`, `lchg_time`) 
            VALUES (NULL, 'NGN', '01', 'localhost', 'N', '2017-10-20 06:00:00', 
            '0.00', '0.00', '2017-10-20 00:06:00');";
$query = mysqli_query($db_conx, $insert);
if($query === TRUE){
    echo "<h3>Insert into SYSTEM_GROUP_CONTROL_TBL table ok :) </h3>";
} else {
    echo "<h3>Insert into SYSTEM_GROUP_CONTROL_TBL table NOT okay :( </h3>";
}

$insert = " INSERT INTO `CATEGORIES`(cat_name,cat_value,Del_flg,country_id) values
            ('Select a category of work','','N','01'),
            ('Websites IT & Software','WITS','N','01'),
            ('Mobile','M','N','01'),
            ('Writing','W','N','01'),
            ('Design','D','N','01'),
            ('Data Entry','DE','N','01'),
            ('Product Sourcing & Manufacturing','PSM','N','01'),
            ('Sales & Marketing','SM','N','01'),
            ('Business, Accounting & Legal','BAL','N','01'),
            ('Local Jobs & Services','LJS','N','01');";
$query = mysqli_query($db_conx, $insert);
if($query === TRUE){
    echo "<h3>Insert into CATEGORIES table ok :) </h3>";
} else {
    echo "<h3>Insert into CATEGORIES table NOT okay :( </h3>";
}
$insert = " INSERT INTO `LOCATION`(loc_name,loc_value,Del_flg,country_id) values
            ('Location','','N','01'),
            ('Submit Some Articles','SSA','N','01'),
            ('Analyze Some Data','ASD','N','01'),
            ('Fill in a Spreadsheet with Data','FIASWD','N','01'),
            ('Local Jobs & Services','LJS','N','01');";
$query = mysqli_query($db_conx, $insert);
if($query === TRUE){
    echo "<h3>Insert into LOCATION table ok :) </h3>";
} else {
    echo "<h3>Insert into LOCATION table NOT okay :( </h3>";
}

$insert = " INSERT INTO `PROJECT`(pro_name,pro_value,Del_flg,country_id) values
            ('Project type','','N','01'),
            ('Submit Some Articles','SSA','N','01'),
            ('Analyze Some Data','ASD','N','01'),
            ('Fill in a Spreadsheet with Data','FIASWD','N','01'),
            ('Local Jobs & Services','LJS','N','01');";
$query = mysqli_query($db_conx, $insert);
if($query === TRUE){
    echo "<h3>Insert into PROJECT table ok :) </h3>";
} else {
    echo "<h3>Insert into PROJECT table NOT okay :( </h3>";
}