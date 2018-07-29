<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Accounts{
    public $Account ;
    
    public function createAccount($username,$crcny,$db_conx){
        $Account1 = "ACT".time().rand(1,9).rand(1,9);
        $Account1 = $this->randomAcct(10, $db_conx);
        $hash = $this->Generate_bal_hash($Account1, '0.0000', 'SID0',$db_conx);
        $sql = "insert into GENERAL_ACCOUNT_DETAILS (username, acct_num, acct_opn_date, xfer_cr_excp_amt_lim, 
                xfer_dr_excp_amt_lim, balance, lchg_time, hash_number,
                acct_crcny_code, schm_type, schm_code, country_id)
                values ('$username', '$Account1',now(), 9999999999999999.99,9999999999999999.99,0.0000,
                now(),'$hash','$crcny','CSA','CA101','01')";
        //$query = mysqli_query($db_conx1, $sql);
        $query = mysqli_query($db_conx, $sql);
               
        $this->Account = $Account1;
        //echo $Account1;
    }
    public function Generate_bal_hash($acct,$amt,$tranId,$db_conx){
        $sql = "select username from GENERAL_ACCOUNT_DETAILS where acct_num = '$acct' 
                and rownum =1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $username = $row[0];
        
        $bal_pass = $acct.''.$username.''.$amt.''.$tranId;
        $bal_hash = md5($bal_pass);
        return $bal_hash;
    }
    
    public function verify_bal_hash($AcctNum,$db_conx){
        $sql = "select hash_number, balance, IFNULL(last_tran_id,'SID0'),acct_num,username 
                from GENERAL_ACCOUNT_DETAILS
                where acct_num = '$AcctNum' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $Bk_check = mysqli_num_rows($query);
        if ($Bk_check > 0){
            $row = mysqli_fetch_row($query);
            $bal_hash_tbl = $row[0];
            $amt = $row[1];
            $lastID = $row[2];
            $Acct = $row[3];
            $username = $row[4];
            if($lastID == ""){
                $lastID = "SID0";
            }
        
            $bal_pass = $Acct.''.$username.''.$amt.''.$lastID;
            $bal_hash = md5($bal_pass);
            if($bal_hash_tbl != $bal_hash){
                return "Account is inbalance";
            }else{
                return true;
            }
        }else{
            return "Account does not exist";
        }
    }
    
    private function randomAcct($length,$db_conx){
        $random= "";
        srand((double)microtime()*1000000);
        $chk = 1;
        $data = "1234567890";
        while ($chk == 1){
            for($i = 0; $i < $length; $i++) 
            { 
                $random .= substr($data, (rand()%(strlen($data))), 1); 
            }
            $sql = "select id from GENERAL_ACCOUNT_DETAILS where acct_num = '$random'";
            $query = mysqli_query($db_conx, $sql);
            $Bk_check = mysqli_num_rows($query);
            if ($Bk_check > 0){ 
                $random = "";
            }else{
                $chk = 0;
            }
        }
        return $random; 
    }
}

?>