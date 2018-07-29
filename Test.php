<?php
/*function makecoffee($types = array("cappuccino"), $coffeeMaker = NULL)
{
    $device = is_null($coffeeMaker) ? "hands" : $coffeeMaker;
    return "Making a cup of ".join(", ", $types)." with $device.\n";
}
//echo makecoffee();
echo makecoffee(array("cappuccino", "lavazza"), "teapot");
exit();*/
function makecoffee($types = array("cappuccino"=>"12"), $coffeeMaker = NULL)
{
    $device = is_null($coffeeMaker) ? "hands" : $coffeeMaker;
    $val = "";
    foreach($types as $x=>$x_value)
    {
        $val .= " Making a cup of " . $x . ", in " . $x_value . ' with '.$device.'\n';
        //echo "<br>";
    }
    //return "Making a cup of ".join(", ", $types)." with $device.\n";
  return $val;
}
//echo makecoffee();
echo makecoffee(array("cappuccino"=>"20", "lavazza"=>"30"), "teapot");
exit();

?>

<?php
include_once("php_codes/check_login_status.php");

$server = $_SERVER['SERVER_NAME'];
echo $server;
        $sql = "select id,acct_crcny_code,country_id,cum_dr_amt,cum_cr_amt from 
                SYSTEM_GROUP_CONTROL_TBL where site_url like '%$server%'";
        $query = mysqli_query($db_conx, $sql);
        $Bk_check = mysqli_num_rows($query);
        if ($Bk_check > 0){
            $row = mysqli_fetch_row($query);
            $id = $row[0];
            $crcny = $row[1];
            $cntry_id = $row[2];
            $cum_dr_amt = $row[3];
            $cum_cr_amt = $row[4];
            //echo $cum_cr_amt . ' '. $crcny;
            //$control=array("id"=>$id,"crcny"=>$crcny,"cntry_id"=>$cntry_id,"cum_dr_amt"=>$cum_dr_amt,"cum_cr_amt"=>$cum_cr_amt);
            //return $control;
        }else{
            //return null;
        }
        

exit();
include_once("php_codes/db_conx.php");
//include("Class/Accounts.php");
//include("Class/System_control.php");

session_start();
echo $_SESSION['userid'].' ID</br>';
if(isset($_SESSION["userid"])){
    echo $_SESSION["userid"].'</br>';
}if(isset($_SESSION["username"])){
    echo $_SESSION["username"].'</br>';
}
if(isset($_SESSION["password"])){
    echo $_SESSION["password"].'</br>';
}
if(isset($_SESSION["userid"])&& isset($_SESSION["username"])&& isset($_SESSION["password"])){
    echo "Good";
    exit();
}else{
    echo "Bad";
    exit();
}
exit();

$_SESSION['userid'] = $db_id;
$_SESSION['username'] = $db_username;
$_SESSION['password'] = $db_pass_str;

$custAcct = new Accounts;
/*$custAcct->createAccount("Test","NGN", $db_conx);
//exit();
$username = "9304952585";
$cust = $custAcct->verify_bal_hash($username, $db_conx);
echo $cust;
exit();
//verify_bal_hash($username,$db_conx);*/

$control = new control_details;
$con = $control->get_control_details($db_conx);
echo $con['id'] . ' ' . $con['crcny'] .'</br>';
echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'].'</br>';
echo "http://" .  $_SERVER['REQUEST_URI'].'</br>';
echo "http://" . $_SERVER['SERVER_NAME'] .'</br>';
echo "request url " .  $_SERVER['REQUEST_URI'].'</br>';
echo "server name " . $_SERVER['SERVER_NAME'] .'</br>';
exit();
function randomPrefix($length) 
{
$random= "";
srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ"; 
$data = "abcdefghijklmn123opq45rs67tuv89wxyz0"; 
//$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++) 
{ 
$random .= substr($data, (rand()%(strlen($data))), 1); 
}

return $random; 
}

echo '5Q'.randomPrefix(5).'</br>';

$three = substr('chim4us', 0, 5);

$num0 = (rand(10,100));
$num1 = date("Ymd");
$num2 = (rand(100,1000));
$num3 = time();
$randnum = $num0 . $num1 . $num2 . $num3;
echo 'Num 2 '.$num2.'</br>';

$data = "abcdefghijklmn123opq45rs67tuv89wxyz0";
$res = (rand()%(strlen($data)));
//$res = rand();
echo 'Res: '.$res;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$created_date = date("Y-m-d H:i:s");
echo $created_date."<br/>";
echo PHP_VERSION." ".PHP_VERSION_ID." ".PHP_URL_USER;
/*$sql = "INSERT INTO $tbl_name(created_date)VALUES('$created_date')";
$result = mysql_query($sql);*/
?>

<html>
    <!--<style >
    .rating {
  unicode-bidi: bidi-override;
  direction: rtl;
}
.rating > span {
  display: inline-block;
  position: relative;
  width: 1.1em;
}
.rating > span:hover:before,
.rating > span:hover ~ span:before {
   content: "\2605";
   position: absolute;
}</style>
<div class="rating">
<span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
</div>-->
<style >
    div.stars {
  width: 270px;
  display: inline-block;
}
 
input.star { display: none; }
 
label.star {
  float: right;
  padding: 2.5px;
  font-size: 10px;
  color: #444;
  transition: all .2s;
}
 
input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}
 
input.star-5:checked ~ label.star:before {
  color: #FE7;
  /*text-shadow: 0 0 20px #952;*/
}
 
input.star-1:checked ~ label.star:before { color: #F62; }
 
label.star:hover { transform: rotate(-15deg) scale(1.3); }
 
label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}

</style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>
    function Cancel(x){
        alert(x);
        /*var AcNm = _("AcctHdNm").value;
        var AcNu = _("AcctNum").value;
        var AcTp = _("AcctTp").value;
        var status = _("status");
        if(BnNm == "" || AcNm == "" || AcNu == "" || AcTp == ""){
            status.innerHTML = "Fill out all of the form data";
        } else {
            var ajax = ajaxObj("POST", "bank.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText.trim().toUpperCase() != "ADDED_SUCCESS"){
                        status.innerHTML = ajax.responseText;
                    } else {
                        window.location = "bank.php";
                    }
                }
            }
            ajax.send("BnNm="+BnNm+"&AcNm="+AcNm+"&AcNu="+AcNu+"&AcTp="+AcTp);
        }*/
    }
</script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</br>
<div class="stars">
  <form action="">
    <input class="star star-5" id="star-5" type="radio" name="star" value="5" onclick="Cancel(5)"/>
    <label class="star star-5" for="star-5"></label>
    <input class="star star-4" id="star-4" type="radio" name="star" value="4" onclick="Cancel(4)"/>
    <label class="star star-4" for="star-4"></label>
    <input class="star star-3" id="star-3" type="radio" name="star" value="3" onclick="Cancel(3)"/>
    <label class="star star-3" for="star-3"></label>
    <input class="star star-2" id="star-2" type="radio" name="star" value="2" onclick="Cancel(2)"/>
    <label class="star star-2" for="star-2"></label>
    <input class="star star-1" id="star-1" type="radio" name="star" value="1" onclick="Cancel(1)"/>
    <label class="star star-1" for="star-1"></label>
    <!--<button type="button" class="btn btn-block btn-default" onclick="Cancel()">Cancel</button></div>';-->
    
    <!--$button .= '<script>uploadedit('.$bank_id.',\''.$Account_name.'\',\''.$Acct_type.'\',\''.
$Account_num.'\',\''.$bank_name.'\');</script>';-->
  </form>
</div>

</br>
<style >
    div.emeka {
  width: 270px;
  display: inline-block;
}
 
input.emeka { display: none; }
 
label.emeka {
  float: right;
  padding: 2.5px;
  font-size: 10px;
  color: #444;
  transition: all .2s;
}
 
input.emeka:checked ~ label.emeka:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}
 
input.emeka-5:checked ~ label.emeka:before {
  color: #FE7;
  /*text-shadow: 0 0 20px #952;*/
}
 
input.emeka-1:checked ~ label.emeka:before { color: #F62; }
 
label.emeka:hover { transform: rotate(-15deg) scale(1.3); }
 
label.emeka:before {
  content: '\f006';
  font-family: FontAwesome;
}

</style>
<div class="emeka">
  <form action="">
    <input class="emeka emeka-5" id="emeka-5" type="radio" name="emeka" value="5" onclick="Cancel(5)"/>
    <label class="emeka emeka-5" for="emeka-5"></label>
    <input class="emeka emeka-4" id="emeka-4" type="radio" name="emeka" value="4" onclick="Cancel(4)"/>
    <label class="emeka emeka-4" for="emeka-4"></label>
    <input class="emeka emeka-3" id="emeka-3" type="radio" name="emeka" value="3" onclick="Cancel(3)"/>
    <label class="emeka emeka-3" for="emeka-3"></label>
    <input class="emeka emeka-2" id="emeka-2" type="radio" name="emeka" value="2" onclick="Cancel(2)"/>
    <label class="emeka emeka-2" for="emeka-2"></label>
    <input class="emeka emeka-1" id="emeka-1" type="radio" name="emeka" value="1" onclick="Cancel(1)"/>
    <label class="emeka emeka-1" for="emeka-1"></label>
  </form>
</div>

</br>
<style >
    div.chimdi {
  /*width: 270px;*/
  display: inline-block;
}
 
input.chimdi { display: none; }
 
label.chimdi {
  float: right;
  padding: 2.5px;
  font-size: 10px;
  color: #444;
  transition: all .2s;
}
 
input.chimdi:checked ~ label.chimdi:before {
  content: "\f005";
  color: #FD4;
  transition: all .25s;
}
 
input.chimdi-5:checked ~ label.chimdi:before {
  color: #FE7;
  /*text-shadow: 0 0 20px #952;*/
}
 
input.chimdi-1:checked ~ label.chimdi:before { color: #F62; }
 
label.chimdi:hover { transform: rotate(-15deg) scale(1.3); }
 
label.chimdi:before {
  content: "\f006";
  font-family: FontAwesome;
}

</style>
<div class="chimdi">
  <form action="">
    <input class="chimdi chimdi-5" id="chimdi-5" type="radio" name="chimdi" value="5" onclick="Cancel(5)"/>
    <label class="chimdi chimdi-5" for="chimdi-5"></label>
    <input class="chimdi chimdi-4" id="chimdi-4" type="radio" name="chimdi" value="4" onclick="Cancel(4)"/>
    <label class="chimdi chimdi-4" for="chimdi-4"></label>
    <input class="chimdi chimdi-3" id="chimdi-3" type="radio" name="chimdi" value="3" onclick="Cancel(3)"/>
    <label class="chimdi chimdi-3" for="chimdi-3"></label>
    <input class="chimdi chimdi-2" id="chimdi-2" type="radio" name="chimdi" value="2" onclick="Cancel(2)"/>
    <label class="chimdi chimdi-2" for="chimdi-2"></label>
    <input class="chimdi chimdi-1" id="chimdi-1" type="radio" name="chimdi" value="1" onclick="Cancel(1)"/>
    <label class="chimdi chimdi-1" for="chimdi-1"></label>
  </form>
</div>

<?php 
function randomPrefixbkp($length) 
{ 
$random= "";
srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ"; 
$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz"; 
$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++) 
{ 
$random .= substr($data, (rand()%(strlen($data))), 1); 
}

return $random; 
}

//echo randomPrefix(3).'</br>';
?>