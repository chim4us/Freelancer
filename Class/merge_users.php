<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class merge_users{
    public function mer_user($Pay_usr,$amt,$Recv_usr,$log_username,$db_conx,$db_conx1){
       $tran_id = uniqid();
       $sql = "insert into DAILY_TRANSACTION_DETAILS(acct_num,tran_amt,tran_date,tran_id,
                part_tran_type,part_tran_srl_num,tran_sub_type,tran_type,entry_username,
                entry_date,tran_crcny_code,country_id,pay_username)values(
                (select acct_num from GENERAL_ACCOUNT_DETAILS where user_name = '$Pay_usr'),'$amt',now(),
                '$tran_id','D','1','CI','T','$log_username',now(),'NGN','01','$Pay_usr')";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
        
        $sql = "insert into DAILY_TRANSACTION_DETAILS(acct_num,tran_amt,tran_date,tran_id,
                part_tran_type,part_tran_srl_num,tran_sub_type,tran_type,entry_username,
                entry_date,tran_crcny_code,country_id,pay_username)values(
                (select acct_num from GENERAL_ACCOUNT_DETAILS where user_name = '$Recv_usr'),'$amt',now(),
                '$tran_id','C','2','CI','T','$log_username',now(),'NGN','01','$Recv_usr')";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
            
        $sql = "update GENERAL_ACCOUNT_DETAILS set wthdrable_amt = wthdrable_amt - $amt where 
                username = '$Pay_usr' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
    }
    
    public function fetch_user($log_username,$amt,$db_conx,$db_conx1){
        $amt_col = $amt;
        $sql = "select count(1) 
               from USER_CREDS a, GENERAL_ACCOUNT_DETAILS b, USER_PACK_SECL c
                    where a.username = b.username and a.status ='A' and a.username != '$log_username'
                    and a.user_ref != '$log_username' and a.username = c.username and c.username = b.username
                    and b.cum_cr_amt >= (select nxt_amt_pay from USER_PACK_SECL where com_flg = 'Y'
                    and username = a.username and nxt_amt_pay > 0) and b.pay_stp_flg ='N' and c.pay_stp_flg = 'N'
                    and c.nxt_amt_col > 0 and c.approve_flg = 'Y' and b.wthdrable_amt > 0 and a.username != 'admin'
                    group by c.id,a.username,b.wthdrable_amt,b.acct_num order by c.id asc limit 1";
        $query = mysqli_query($db_conx, $sql);
        //$query = mysqli_query($db_conx1, $sql);
        $row = mysqli_fetch_row($query);
        $cnt = $row[0];
        if($cnt == 0){
            return null;
        }else{
            $tran_id = uniqid();
            $tran_srl = 1;
            while ($amt >= 0){
                $sql = "select c.id,a.username,b.wthdrable_amt,b.acct_num 
                    from USER_CREDS a, GENERAL_ACCOUNT_DETAILS b, USER_PACK_SECL c
                    where a.username = b.username and a.status ='A' and a.username != '$log_username'
                    and a.user_ref != '$log_username' and a.username = c.username and c.username = b.username
                    and b.cum_cr_amt >= (select nxt_amt_pay from USER_PACK_SECL where com_flg = 'Y'
                    and username = a.username and nxt_amt_pay > 0) and b.pay_stp_flg ='N' and c.pay_stp_flg = 'N'
                    and c.nxt_amt_col > 0 and c.approve_flg = 'Y' and b.wthdrable_amt > 0 and c.fast_flg = 'Y'
                    and a.username != 'admin'
                    group by c.id,a.username,b.wthdrable_amt,b.acct_num order by c.id asc limit 1 ";
                $query = mysqli_query($db_conx, $sql); 
                $fast_check = mysqli_num_rows($query);
                if($fast_check == 0){
                $sql = "select c.id,a.username,b.wthdrable_amt,b.acct_num 
                    from USER_CREDS a, GENERAL_ACCOUNT_DETAILS b, USER_PACK_SECL c
                    where a.username = b.username and a.status ='A' and a.username != '$log_username'
                    and a.user_ref != '$log_username' and a.username = c.username and c.username = b.username
                    and b.cum_cr_amt >= (select nxt_amt_pay from USER_PACK_SECL where com_flg = 'Y'
                    and username = a.username and nxt_amt_pay > 0) and b.pay_stp_flg ='N' and c.pay_stp_flg = 'N'
                    and c.nxt_amt_col > 0 and c.approve_flg = 'Y' and b.wthdrable_amt > 0 and a.username != 'admin'
                    group by c.id,a.username,b.wthdrable_amt,b.acct_num order by c.id asc limit 1 ";
                $query = mysqli_query($db_conx, $sql);
                }
                //$query = mysqli_query($db_conx1, $sql);
                $row = mysqli_fetch_row($query);
                $id = $row[0];
                $payuser = $row[1];
                $pay_amt = $row[2];
                $pay_acct = $row[3];
                
                if($pay_amt < $amt){
                    $amt2pay = $pay_amt;
                }else {
                   $amt2pay = $amt;
                }
                $sql = "insert into DAILY_TRANSACTION_DETAILS(acct_num,tran_amt,tran_date,tran_id,
                    part_tran_type,part_tran_srl_num,tran_sub_type,tran_type,entry_username,
                    entry_date,tran_crcny_code,country_id,pay_username)values('$pay_acct','$amt2pay',
                    convert_tz(now(),'EST','GMT'),
                    '$tran_id','D','$tran_srl','CI','T','$log_username',
                    convert_tz(now(),'EST','GMT'),'NGN','01','$payuser')";
                $query = mysqli_query($db_conx, $sql);
                $query = mysqli_query($db_conx1, $sql);
            
                $sql = "update GENERAL_ACCOUNT_DETAILS set wthdrable_amt = wthdrable_amt - $amt2pay where 
                    username = '$payuser' limit 1";
                $query = mysqli_query($db_conx, $sql);
                $query = mysqli_query($db_conx1, $sql);
                $amt = $amt - $pay_amt;
                $tran_srl += 1;
            }
            $sql = "select acct_num from GENERAL_ACCOUNT_DETAILS where username = '$log_username' 
                    limit 1";
            $query = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query);
            $Acct_num = $row[0];
            
            $sql = "insert into DAILY_TRANSACTION_DETAILS(acct_num,tran_amt,tran_date,tran_id,
                    part_tran_type,part_tran_srl_num,tran_sub_type,tran_type,entry_username,
                    entry_date,tran_crcny_code,country_id)values('$Acct_num','$amt_col',
                    convert_tz(now(),'EST','GMT'),
                    '$tran_id','C','$tran_srl','CI','T','$log_username',
                    convert_tz(now(),'EST','GMT'),'NGN','01')";
            $query = mysqli_query($db_conx, $sql);
            $query = mysqli_query($db_conx1, $sql);
            
            $sql = "update USER_TIMING set exp_flg ='Y' where username = '$log_username' and tm_type ='N' limit 1";
            $query = mysqli_query($db_conx1, $sql);
            $query = mysqli_query($db_conx, $sql);
            
            $sql ="insert into USER_TIMING(username,tm_type,tran_id,tran_date,del_flg,lchg_time,exp_date,exp_date_char,
                    exp_flg,country_id)
                    values('$log_username','D','$tran_id',
                    convert_tz(now(),'EST','GMT'),'N',convert_tz(now(),'EST','GMT'),
                    convert_tz(DATE_ADD(NOW(), INTERVAL 24 HOUR),'EST','GMT'),
                    convert_tz(DATE_ADD(NOW(), INTERVAL 24 HOUR),'EST','GMT'),
                    'N','01')";
            $query = mysqli_query($db_conx, $sql);
            $query = mysqli_query($db_conx1, $sql);
            
            return $tran_id;
        }
    
    }
    
    public function check_user($log_username,$amt,$db_conx,$db_conx1){
        $sql = "select sum(b.wthdrable_amt) > $amt amount 
                from USER_CREDS a, GENERAL_ACCOUNT_DETAILS b, USER_PACK_SECL c
                    where a.username = b.username and a.status ='A' and a.username != '$log_username'
                    and a.user_ref != '$log_username' and a.username = c.username and c.username = b.username
                    and b.cum_cr_amt >= (select nxt_amt_pay from USER_PACK_SECL where com_flg = 'Y'
                    and username = a.username and nxt_amt_pay > 0) and b.pay_stp_flg ='N' and c.pay_stp_flg = 'N'
                    and c.nxt_amt_col > 0 and c.approve_flg = 'Y' and b.wthdrable_amt > 0 and a.username != 'admin'
                    group by c.id,a.username,b.wthdrable_amt,b.acct_num order by c.id asc limit 1";
        $query = mysqli_query($db_conx1, $sql);
        $row = mysqli_fetch_row($query);
        $owin_amt = $row[0];
        
        if($owin_amt >= 1){
            return "YES";
        }else{
            return "NO";
        }
    }
    
    public function mer_admin($id,$amt,$db_conx,$db_conx1){
       $sql = "select username from SYSTEM_ADMIN where cum_cr_amt = (
               select MIN(cum_cr_amt) from SYSTEM_ADMIN limit 1)limit 1";
       
        $tran_id = uniqid();
        
        $sql = "insert into USER_PACK_SECL (username,pack_amt,pack_name,user_paid_amt,pack_id,lchg_time,
                com_flg,pay_stp_flg,nxt_amt_col,nxt_amt_pay)values
                ('$Uname','$Amount','$packName','$Amount','$id',
                convert_tz(now(),'EST','GMT'),'Y','N','$Amount','$Amount')";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
        
        $sql = "update GENERAL_ACCOUNT_DETAILS set cum_cr_amt = cum_cr_amt + $Amount,
                wthdrable_amt = wthdrable_amt + $Amount,
                balance = balance + $Amount where 
                username = '$Uname' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
        
        $sql = "insert into DAILY_TRANSACTION_DETAILS(acct_num,tran_amt,tran_date,tran_id,
                part_tran_type,part_tran_srl_num,tran_sub_type,tran_type,entry_username,
                entry_date,tran_crcny_code,country_id,pay_username,pst_flg,pstd_date)values(
                'ACT150538783767','$Amount',convert_tz(now(),'EST','GMT'),
                '$tran_id','D','1','CI','T','$log_username',
                convert_tz(now(),'EST','GMT'),'NGN','01','system','Y','$log_username')";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
        
        $sql = "insert into DAILY_TRANSACTION_DETAILS(acct_num,tran_amt,tran_date,tran_id,
                part_tran_type,part_tran_srl_num,tran_sub_type,tran_type,entry_username,
                entry_date,tran_crcny_code,country_id,pay_username,pst_flg,pstd_date)values(
                (select acct_num from GENERAL_ACCOUNT_DETAILS where username = '$Uname'),'$Amount',
                convert_tz(now(),'EST','GMT'),
                '$tran_id','C','2','CI','T','$log_username',
                convert_tz(now(),'EST','GMT'),'NGN','02','system','Y','$log_username')";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
            
        $sql = "update GENERAL_ACCOUNT_DETAILS set wthdrable_amt = wthdrable_amt - $Amount, 
                balance = balance - $Amount where 
                username = 'system' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $query = mysqli_query($db_conx1, $sql);
    }
}