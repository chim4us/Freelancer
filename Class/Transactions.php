<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Transaction extends Accounts{
    public function Create_transaction($Account,$Leg,$DRCR,$Amount,$TranID,$db_conx){
        $veriAcct = $this->verify_bal_hash($Account, $db_conx);
        if($veriAcct == true){
            $hash = $this->Generate_bal_hash($Account, $Amount, $TranID, $db_conx);
        }
    }
    
    private function Generate_tran_id($length,$db_conx){
        $random= "";
        $server = $_SERVER['SERVER_NAME'];
        srand((double)microtime()*1000000);
        $chk = 1;
        //$data = "1234567890";
        $data = "ABCDE123IJKLMN67QRSTUVWXYZ";
        $data .= "0FGH45OP89";
        while ($chk == 1){
            for($i = 0; $i < $length; $i++) 
            { 
                $random .= substr($data, (rand()%(strlen($data))), 1); 
            }
            $sql = "select tran_id from DAILY_TRANSACTION_DETAILS where tran_id = '$random'";
            $sql .= " and tran_date = (select sysdate from SYSTEM_GROUP_CONTROL_TBL where ";
            $sql .= " site_url = '$server')";
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