<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class control_details{
    function get_control_details($db_conx){
        $server = $_SERVER['SERVER_NAME'];
        $sql = "select id,acct_crcny_code,country_id,cum_dr_amt,cum_cr_amt from 
                SYSTEM_GROUP_CONTROL_TBL where upper(site_url) = upper('$server')";
        //$sql1 = "insert into test (data)values('$sql')";
        //$query1 = mysqli_query($db_conx, $sql1);
        $query = mysqli_query($db_conx, $sql);
        $Bk_check = mysqli_num_rows($query);
        if ($Bk_check > 0){
            $row = mysqli_fetch_row($query);
            $id = $row[0];
            $crcny = $row[1];
            $cntry_id = $row[2];
            $cum_dr_amt = $row[3];
            $cum_cr_amt = $row[4];
            $control=array("id"=>$id,"crcny"=>$crcny,"cntry_id"=>$cntry_id,"cum_dr_amt"=>$cum_dr_amt,"cum_cr_amt"=>$cum_cr_amt);
            return $control;
        }else{
            return null;
        }
    }
}
?>