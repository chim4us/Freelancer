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
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        var_crncy_units DECIMAL(20,4)NOT NULL,
        fxd_crncy_units DECIMAL(20,4)NOT NULL,
        lchg_time DATETIME NOT NULL,
        lchg_username VARCHAR(25) NOT NULL,
        rtlist_date DATETIME NOT NULL,
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
            id BIGINT(255) NOT NULL AUTO_INCREMENT,
            cat_name VARCHAR(150) NOT NULL,
            cat_value VARCHAR(150) NOT NULL,
            Del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
            loc_name VARCHAR(150) NOT NULL,
            loc_value VARCHAR(150) NOT NULL,
            Del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
            pro_name VARCHAR(150) NOT NULL,
            pro_value VARCHAR(150) NOT NULL,
            Del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        proj_id VARCHAR(150) NOT NULL, 
        proj_pic VARCHAR(255) NOT NULL,
        title VARCHAR(120) NOT NULL,
        rank CHAR (1)NOT NULL,
        rank_cnt INT(10) NOT NULL,
        message TEXT NOT NULL,
        skill VARCHAR(900) NOT NULL,
        budget_low DECIMAL(20,4)NOT NULL,
        budget_high DECIMAL(20,4)NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        comp_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        lchg_time DATETIME NOT NULL,
        recre_time DATETIME NOT NULL,
        exp_date DATETIME NOT NULL,
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
        username VARCHAR(25) NOT NULL, 
        skill_id VARCHAR(150) NOT NULL, 
        skill_pic VARCHAR(255) NOT NULL,
        title VARCHAR(120) NOT NULL,
        rank CHAR (1)NOT NULL,
        rank_cnt INT(10) NOT NULL,
        message TEXT NOT NULL,
        skill VARCHAR(900) NOT NULL,
        budget_low DECIMAL(20,4)NOT NULL,
        budget_high DECIMAL(20,4)NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        lchg_time DATETIME NOT NULL,
        recre_time DATETIME NOT NULL,
        exp_date DATETIME NOT NULL,
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
        username VARCHAR(25) NOT NULL, 
        proj_id VARCHAR(150) NOT NULL, 
        proj_pic VARCHAR(255) NOT NULL,
        title VARCHAR(120) NOT NULL,
        rank CHAR (1)NOT NULL,
        rank_cnt INT(10) NOT NULL,
        message TEXT NOT NULL,
        skill VARCHAR(900) NOT NULL,
        budget_low DECIMAL(20,4)NOT NULL,
        budget_high DECIMAL(20,4)NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        comp_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        lchg_time DATETIME NOT NULL,
        recre_time DATETIME NOT NULL,
        exp_date DATETIME NOT NULL,
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
        pro_post_id BIGINT NOT NULL,
        proj_id VARCHAR(150) NOT NULL,
        username VARCHAR(25) NOT NULL,
        assign_user VARCHAR(25) NOT NULL,
        assign_date DATETIME NOT NULL,
        exp_date DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        comp_percen INT(4) NOT NULL,
        comp_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        remarks VARCHAR(600) NOT NULL,
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
        username VARCHAR(25) NOT NULL,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        user_dob DATETIME NOT NULL,
        status CHAR(1),
        email VARCHAR(255) NOT NULL,
        email_vri ENUM('Y','N') NOT NULL DEFAULT 'N',
        phone VARCHAR(20) NOT NULL,
        phone_vri ENUM('Y','N') NOT NULL DEFAULT 'N',
        address VARCHAR(300) NOT NULL,
        gender ENUM('M','F','O') NOT NULL,
        country VARCHAR(100) NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        new_user CHAR(1),
        pic_id VARCHAR(255) NOT NULL,
        ip VARCHAR(255) NOT NULL,
        ip2 VARCHAR(255) NOT NULL,
        signup_date DATETIME NOT NULL,
        last_login DATETIME NOT NULL,
        lchg_time DATETIME NOT NULL,
        user_ref VARCHAR(25) NOT NULL,
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
        username VARCHAR(25) NOT NULL,
        role_id VARCHAR(30),
        password VARCHAR(255) NOT NULL,
        pwd_vry_code VARCHAR(255) NOT NULL,
        num_pwd_history INT(2) NOT NULL,
        pwd_history VARCHAR(5072) NOT NULL,
        pwd_last_mod_time DATETIME NOT NULL,
        num_pwd_attempts INT(2) NOT NULL,
        login_time DATETIME NOT NULL,
        disable_from_date DATETIME NOT NULL,
        disable_to_date DATETIME NOT NULL,
        pwd_exp_date DATETIME NOT NULL,
        last_access_time DATETIME NOT NULL,
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
        username VARCHAR(25) NOT NULL,
        lchg_time DATETIME NOT NULL,
        pic_type VARCHAR(30),
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        preferred_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        password VARCHAR(255) NOT NULL,
        lchg_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        preferred_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        acct_num VARCHAR(16) NOT NULL, 
        acct_opn_date DATETIME NOT NULL,
        frez_code CHAR(1) NOT NULL,
        frez_reason_code VARCHAR (5) NOT NULL,
        frez_remarks VARCHAR(60) NOT NULL,
        acct_cls_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        xfer_cr_excp_amt_lim DECIMAL(20,4)NOT NULL,
        xfer_dr_excp_amt_lim DECIMAL(20,4)NOT NULL,
        balance DECIMAL(20,4)NOT NULL,
        cum_dr_amt DECIMAL(20,4)NOT NULL,
        cum_cr_amt DECIMAL(20,4)NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        last_tran_id VARCHAR(24),
        last_tran_amt DECIMAL(20,4)NOT NULL,
        last_clr_tran_id VARCHAR(24),
        last_clr_amt DECIMAL(20,4)NOT NULL,
        last_dr_tran_id VARCHAR(24),
        last_dr_amt DECIMAL(20,4)NOT NULL,
        lchg_time DATETIME NOT NULL,
        hash_number VARCHAR(350) NOT NULL,
        acct_crcny_code VARCHAR(3) NOT NULL,
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
        acct_num VARCHAR(16) NOT NULL,
        tran_amt DECIMAL(20,4)NOT NULL,
        tran_date DATETIME NOT NULL,
        tran_id VARCHAR(24) NOT NULL,
        part_tran_type CHAR(1),
        part_tran_srl_num VARCHAR(4),
        tran_sub_type VARCHAR(2),
        tran_type CHAR (1),
        narration VARCHAR(100) NOT NULL,
        entry_username VARCHAR(25) NOT NULL,
        entry_date DATETIME NOT NULL,
        pstd_username VARCHAR(25) NOT NULL,
        pstd_date DATETIME NOT NULL,
        pst_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        tran_crcny_code VARCHAR(3) NOT NULL,
        tran_gate_way VARCHAR(50) NOT NULL,
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
        username VARCHAR(25) NOT NULL,
        bank_name VARCHAR(255) NOT NULL,
        acct_num VARCHAR(20) NOT NULL,
        acct_name VARCHAR(100) NOT NULL,
        acct_type ENUM('S','C','I','Q') NOT NULL,
        lchg_time DATETIME NOT NULL,
        rcre_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        question VARCHAR(2050) NOT NULL,
        answer VARCHAR(2050) NOT NULL,
        lchg_time DATETIME NOT NULL,
        rcre_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        id BIGINT(255) NOT NULL,
        user_id BIGINT(100) NOT NULL,
        username VARCHAR(25) NOT NULL,
        question VARCHAR(2050) NOT NULL,
        answer VARCHAR(2050) NOT NULL,
        lchg_time DATETIME NOT NULL,
        rcre_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        block_user VARCHAR(25) NOT NULL,
        block_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        lchg_time DATETIME NOT NULL,
        rcre_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        proj_id VARCHAR(150) NOT NULL,
        rank CHAR (1)NOT NULL,
        rank_cnt INT(10) NOT NULL,
        rank_type VARCHAR(30) NOT NULL,
        lchg_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        rank_num CHAR (1)NOT NULL,
        ranked_user VARCHAR(25) NOT NULL,
        rank_type VARCHAR(30) NOT NULL,
        lchg_time DATETIME NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        username VARCHAR(25) NOT NULL,
        description TEXT NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        entry_date  DATETIME NOT NULL,
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
        username VARCHAR(25) NOT NULL,
        login_time DATETIME NOT NULL,
        ip VARCHAR(255) NOT NULL,
        ip2 VARCHAR(255) NOT NULL,
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
        username VARCHAR(25) NOT NULL,
        ticket_id VARCHAR(25) NOT NULL,
        mssg_header VARCHAR(255) NOT NULL,
        mssg_contain TEXT NOT NULL,
        entry_date  DATETIME NOT NULL,
        clsd_user VARCHAR(25) NOT NULL,
        clsd_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
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
        acct_crcny_code VARCHAR(3) NOT NULL,
        country_id VARCHAR(8) NOT NULL, 
        site_url VARCHAR(255) NOT NULL,
        del_flg ENUM('Y','N') NOT NULL DEFAULT 'N',
        sysdate DATETIME NOT NULL,
        cum_dr_amt DECIMAL(20,4)NOT NULL,
        cum_cr_amt DECIMAL(20,4)NOT NULL,
        lchg_time DATETIME NOT NULL,
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