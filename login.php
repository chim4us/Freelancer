<?php
include_once("php_codes/check_login_status.php");
if($user_ok == true){
    header("location: index.php");
    exit();
}
//include_once("Class/System_control.php");
//require_once("Class/classes.php");
function getUserIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];   
    $remote  = $_SERVER['REMOTE_ADDR'];
    
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
?><?php
    $Msg ="";
    if(isset($_GET["Msg"])){
        $Msg = '<strong style="color:#009900;">'.preg_replace('#[^a-z0-9 ]#i', '', $_GET['Msg']).'</strong>';
    }
?><?php
if(isset($_POST["e"])){
    include_once("php_codes/db_conx.php");
    //include_once("Class/System_control.php");
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
    $p = md5($_POST['p']);
    $ip = preg_replace('#[^0-9.:]#', '', getenv('REMOTE_ADDR'));
    //$remember = preg_replace('#[^a-z]#i', '', $_POST['remember']);
    if($e == "" || $p == ""){
        echo "Please enter your username and password";
        exit();
    }else{
        $sql = "select id from USER_CREDS where email ='$e' or username = '$e'
                or phone = '$e' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $Usr_check = mysqli_num_rows($query);
        if($Usr_check == 0){
            echo "Sorry your creds ID is not on our system";
            exit();
        }
        $sql = "select status from USER_CREDS where email ='$e' or username = '$e'
                 or phone = '$e' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $userstatus = $row[0];
        if($userstatus == "F"){
            echo "Sorry you can no longer login into our system";
            exit();
        }
        
        $sql = "select a.id from USER_LOGIN_CREDS a,USER_CREDS b where a.num_pwd_attempts >= 5
                 and b.username = a.username and (b.email ='$e' or b.username = '$e'
                 or b.phone = '$e')";
        $query = mysqli_query($db_conx, $sql);
        $Usr_Pass_amt = mysqli_num_rows($query);
        if($Usr_Pass_amt > 0){
            echo "You have attempted the maximum password trail please reset your password";
            exit();
        }
        
        $sql = "SELECT b.id, a.username, a.password FROM USER_LOGIN_CREDS a, USER_CREDS b 
                WHERE (b.email ='$e' or b.username = '$e'
                or b.phone = '$e') and b.username = a.username LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $db_id = $row[0];
        $db_username = $row[1];
        $db_pass_str = $row[2];
        if($p != $db_pass_str){
            $sql = "update USER_LOGIN_CREDS set num_pwd_attempts = num_pwd_attempts + 1 
                    where username = '$db_username'";
            $query = mysqli_query($db_conx, $sql);
            echo "Wrong Password Or user details";
            exit();
        } else {
            /*$control = new control_details;
            $con = $control->get_control_details($db_conx);
            $sys_crcny = $con['crcny'];
            $sys_cntry_id = $con['cntry_id'];
            $sys_dr = $con['cum_dr_amt'];
            $sys_cr = $con['cum_cr_amt'];*/
            $user_ip = getUserIP();
            $_SESSION['userid'] = $db_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['password'] = $db_pass_str;
            
            //echo $db_id ." ". $db_username ." ". $db_pass_str;
            //exit();
            
            /*if($remember == "YES"){
                setcookie("userid", $db_id, strtotime('+30 days'),"/","","", TRUE);
                setcookie("username", $db_username, strtotime('+30 days'),"/","","", TRUE);
                setcookie("password", $db_pass_str, strtotime('+30 days'),"/","","", TRUE);
            }*/
            $sql = "update USER_LOGIN_CREDS set num_pwd_attempts = 0 
                    where username = '$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "UPDATE USER_LOGIN_CREDS set login_time=
                    now() WHERE username ='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "UPDATE USER_CREDS SET ip='$ip', last_login=
                    now() WHERE username ='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "insert into USER_LOGIN_HISTORY(username,login_time,ip,ip2) values(
                    '$db_username',now(),'$ip','$user_ip')";
            $query = mysqli_query($db_conx, $sql);
            echo "LOGIN_SUCCESS";
            exit();
        }
    }exit();
}
?>
<?php $actlink = basename(__FILE__);
 $title = "Login Page";
  include_once("freelancerheader.php"); ?>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>
function emptyElement(x){
    _(x).innerHTML = "";
}
function login(){
    var e = _("userid").value;
    var p = _("passwd").value;
    var status = _("status");
    var useridStat = _("useridStat");
    var passwdStat = _("passwdStat");
    if(p == ""){
        passwdStat.innerHTML = 'Password <sup>*</sup></br><i style="color: #f00;">Please provide your password</i>';
        _("passwd").focus();
    }
    if(e == ""){
        useridStat.innerHTML = 'UserName, Email or Phone</br><i style="color: #f00;">Please provide your UserName, Email or Phone</i>';
        _("userid").focus();
    }
    if(e == "" || p == ""){
        status.innerHTML = "Fill out all of the form data";
    }else {
        //document.getElementById("loginbtn").disabled = true;
        _("loginbtn").style.display = "none";
        var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText.trim().toUpperCase() == "LOGIN_SUCCESS"){
                    window.location = "index.php";
                } else {
                    status.innerHTML = "Login unsuccessful, "+ajax.responseText;
                    _("loginbtn").style.display = "block";
                    //document.getElementById("loginbtn").disabled = false;
                }
            }
        }
        ajax.send("e="+e+"&p="+p);
    }
}
</script>
<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action="#" id="create-account-form" class="form-horizontal box panel panel-default">
                                <h3 class="panel-heading">Create an account</h3>
                                <div class="form_content panel-body clearfix">
                                    <p>Registration is quick and easy. It allows you to be able to order from our shop. To start shopping click register.</p>
                                    <a href="register.php" class="btn button btn-default" title="Create an account" rel="nofollow"><i class="fa fa-user left"></i> Create an account</a>
                                </div>
                            </form><!--end form -->
                        </div>
                        <div class="col-lg-6">
                            <form  id="loginform" onsubmit="return false;" method="post" class="form-horizontal box panel panel-default">
                                <h3 class="panel-heading">Already registered?</h3>
                                <p id="status" style="color: #f00;"><?php echo $Msg;?></p>
                                <div class="form_content panel-body clearfix">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="userid" id="useridStat">UserName, Email or Phone</label>
                                            <input type="text" class="form-control" id="userid" name="userid" placeholder="UserName, Email or Phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="passwd" id="passwdStat">Password</label>
                                            <input type="password" class="form-control" id="passwd" name="passwd">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <p class="lost_password">
                                                <a href="#" title="Recover your forgotten password" rel="nofollow">Forgot your password?</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn button btn-default" id="loginbtn" onclick="login()"><i class="fa fa-lock left"></i> Login </button>
                                        </div>
                                    </div>
                                </div>
                            </form><!--end form -->
                        </div>
                    </div>
                </div> <!-- end container -->
            </div><!-- end warpper -->
            <div class="bg-bottom"></div>
        </div><!--end columns-->

        <!-- footer-->
        <footer id="the-footer">
            <!-- start footer-copyright -->
            <div class="footer-copyright">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-sp-12">
                        © 2017 Freelancer. Designed with <i class="fa fa-heart"></i> and <i class="fa fa-coffee"></i> by Tivatheme
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-sp-12">
                        <div class="social_block">
                            <ul class="links">
                                <li><a href="#"><em class="fa fa-facebook"></em><span class="unvisible">facebook</span> </a></li>
                                <li><a href="#"><em class="fa fa-twitter"></em><span class="unvisible">twitter</span> </a></li>
                                <li><a href="#"><em class="fa fa-dribbble"></em><span class="unvisible">dribbble </span> </a></li>
                                <li><a href="#"><em class="fa fa-youtube-play"></em><span class="unvisible">youtube-play</span> </a></li>
                                <li class="last"><a href="#"><em class="fa fa-google-plus"></em><span class="unvisible">google-plus</span> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- end footer-copyright -->
        </footer><!-- end footer -->
        
        <!-- backtop -->
        <div class="go-up">
            <a href="#"><i class="fa fa-chevron-up"></i></a>    
        </div><!-- end backtop -->
    </div> <!-- end all -->

    <!--js fils-->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

    <script src="js/tmpl.js"></script>
    <script src="js/jquery.dependClass-0.1.js"></script>
    <script src="js/draggable-0.1.js"></script>
    <script src="js/jquery.slider.js"></script>
</body>
</html>