<?php
include_once("php_codes/check_login_status.php");
if($user_ok == true){
    header("location: index.php");
    exit();
}
function getUserIP()
    {
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
    if(isset($_GET["RefID"])){
        if($_GET["RefID"] != ""){
            if(isset($_COOKIE["RefID"])){
                setcookie("RefID",'',strtotime( '-5 days' ), '/');
            }
            $RefID = preg_replace('#[^a-z0-9]#i', '', $_GET['RefID']);
            setcookie("RefID", $RefID, strtotime('+30 days'),"/","","", TRUE);
            $_SESSION['RefID'] = $RefID;
            $RefID1 = preg_replace('#[^a-z0-9]#i', '',$_SESSION['RefID']);
        }else{
            $RefID = "admin";
        }
    }else{
        $RefID = "admin";
    }
?><?php 
    if(isset($_POST["emailcheck"])){
        include_once("php_codes/db_conx.php");
        $email = mysqli_real_escape_string($db_conx, $_POST['emailcheck']);
        
        $sql = "SELECT id FROM USER_CREDS WHERE upper(email)= upper('$email') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $uname_check = mysqli_num_rows($query);
        if ($uname_check < 1) {
            //echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
            exit();
        } else {
            echo $email . ' is taken';
            exit();
        }
        
        $sql = "select id from USER_PHONE_EMAIL where upper(email) = upper('$email') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $uname_check = mysqli_num_rows($query);
        if ($uname_check < 1) {
            //echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
            exit();
        } else {
            echo $email . ' is taken';
            exit();
        }
        exit();
    }
?>
<?php
    /// This condition checks if user phone exist
    if(isset($_POST["phonecheck"])){
        include_once("php_codes/db_conx.php");
        $phone = preg_replace('#[^0-9]#i', '', $_POST['phonecheck']);
        $sql = "SELECT id FROM USER_CREDS WHERE upper(phone)= upper('$phone') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $uname_check = mysqli_num_rows($query);
        if (strlen($phone) > 11) {
            echo 'Phone number must not be more than 11 characters';
            exit();
        }
        if ($uname_check < 1) {
            //echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
            exit();
        } else {
            echo $phone . ' is taken';
            exit();
        }
        
        $sql = "select id from USER_PHONE_EMAIL where upper(phone) = upper('$phone') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $uname_check = mysqli_num_rows($query);
        if ($uname_check < 1) {
            //echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
            exit();
        } else {
            echo $phone . ' is taken';
            exit();
        }
        exit();
    }
?>
<?php
    /// This condition checks if username exist
    if(isset($_POST["usernamecheck"])){
        include_once("php_codes/db_conx.php");
        $username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
        
        $sql = "SELECT id FROM USER_CREDS WHERE upper(username)= upper('$username') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $uname_check = mysqli_num_rows($query);
        if (strlen($username) < 3 || strlen($username) > 16) {
            echo '3 - 16 characters please';
            exit();
        }
        if (is_numeric($username[0])) {
            echo 'Usernames must begin with a letter';
            exit();
        }
        if ($uname_check < 1) {
            //echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
            exit();
        } else {
            echo $username . ' is taken';
            exit();
        }
        exit();
    }
?>
<?php
// Ajax calls this REGISTRATION code to execute
    if(isset($_POST["u"])){
    // CONNECT TO THE DATABASE
        //include("Class/System_control.php");
        include_once("php_codes/db_conx.php");
        //$control = new control_details;
        /*$con = $control->get_control_details($db_conx);
        $sys_crcny = $con['crcny'];
        $sys_cntry_id = $con['cntry_id'];
        $sys_dr = $con['cum_dr_amt'];
        $sys_cr = $con['cum_cr_amt'];*/
        // GATHER THE POSTED DATA INTO LOCAL VARIABLES
        $u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
        $e = mysqli_real_escape_string($db_conx, $_POST['e']);
        $p = $_POST['p'];
        $g = preg_replace('#[^a-z]#i', '', $_POST['g']);
        $FN = preg_replace('#[^a-z0-9 ]#i', '', $_POST['FN']);
        $LN = preg_replace('#[^a-z0-9 ]#i', '', $_POST['LN']);
        $ph = preg_replace('#[^0-9 ]#i', '', $_POST['ph']);
        $RefID = preg_replace('#[^a-z0-9 ]#i', '', $_POST['RefID']);
        /*$captcha = preg_replace('#[^a-z0-9 ]#i', '', $_POST['captcha']);
        if($_SESSION['captcha_text'] != $captcha){
            echo "The answer you provided is wrong ";
            exit();
        }*/
        // GET USER IP ADDRESS
        $ip = preg_replace('#[^0-9.:]#', '', getenv('REMOTE_ADDR'));
        // DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
        $sql = "SELECT id FROM USER_CREDS WHERE upper(username)=upper('$u') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $u_check = mysqli_num_rows($query);
        // -------------------------------------------
        $sql = "SELECT id FROM USER_CREDS WHERE upper(email)=upper('$e') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $e_check = mysqli_num_rows($query);
        // --------------------------------------------
        $sql = "SELECT id FROM USER_CREDS WHERE upper(phone)=upper('$ph') LIMIT 1";
        $query = mysqli_query($db_conx, $sql); 
        $p_check = mysqli_num_rows($query);
        //echo 'U '.$u.' E '.$e.' P '.$p.' G '.$g.' FN '.$FN.' LN '.$LN.'</br>';
        // FORM DATA ERROR HANDLING
        if($u == "" || $e == "" || $p == "" || $g == "" || $FN == "" ||$LN == ""){
            echo "The form submission is missing values. PHP";
            exit();
        } else if ($u_check > 0){ 
            echo "The username you entered is alreay taken";
            echo "UPDATED|".$db_email;
            exit();
        } else if ($p_check > 0){ 
            echo "The Phone Number is been used by another account";
            exit();
        } else if ($e_check > 0){ 
            echo "The email address is been used by another account";
            exit();
        } else if (strlen($u) < 3 || strlen($u) > 16) {
            echo "Username must be between 3 and 16 characters";
            exit(); 
        } else if (is_numeric($u[0])) {
            echo 'Username cannot begin with a number';
            exit();
        } else if (strlen($Phone) > 11){
                $error = "The Phone Number provided is invalid";
                return $error;
        }else {
            // END FORM DATA ERROR HANDLING
            // Begin Insertion of data into the database
            // Hash the password and apply your own mysterious unique salt
            $p_hash = md5($p);
            $verifynumber = rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
            $phone_hash_vri = md5($verifynumber);
            $verifyemail = rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
            $email_hash_vri = md5($verifyemail);
            
            // Add user info into the database table
            $user_ip = getUserIP();
            
            $sql = "INSERT INTO USER_CREDS (username, first_name, last_name, email, phone, gender, country, 
                    new_user, ip, ip2, signup_date,lchg_time, user_ref)
                    VALUES ('$u', '$FN', '$LN', '$e', '$ph', '$g', 'Nigeria', 'Y', '$ip', '$user_ip', 
                    now(),now(), '$RefID')";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "insert into USER_PHONE_EMAIL (username, phone, phone_email, phone_vri_flg, lchg_time,
                    preferred_flg,phone_vri_code)values('$u','$ph','PHONE','N',
                    now(),'Y','$phone_hash_vri')";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "insert into USER_PHONE_EMAIL (username, email, phone_email, phone_vri_flg, lchg_time,
                    preferred_flg,email_vri_code)values('$u','$e','EMAIL','N',
                    now(),'Y','$email_hash_vri')";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "INSERT INTO USER_LOGIN_CREDS (username, role_id, password, num_pwd_history,
                    num_pwd_attempts, pwd_exp_date)VALUES ('$u', 'CUST', '$p_hash', 0, 0,
                    DATE_ADD(NOW(), INTERVAL 1440 HOUR))";
            $query = mysqli_query($db_conx, $sql);
            
            $sql = "insert into USER_PASS_DETAILS(username,password,lchg_time,del_flg,preferred_flg)
                    VALUES ('$u','$p_hash',now(),'N','Y')";
            $query = mysqli_query($db_conx, $sql);
            
            // Email the user their activation code
            $to = "$e";  
            $from = "auto_responder@toptencash.com";
            $subject = 'TOP TEN CASH Welcome Message';
            $message1 = '<!DOCTYPE html>
            <html>
            <head>
            <meta charset="UTF-8">
            <title>freelancer Welcome Message</title>
            </head>
            <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
            <div style="padding:24px; font-size:17px;">Hello '.$FN .' '.$LN.',
            <br />
            <br />Welcome to FREELANCER Software please use the code '.$verifyemail.' to verify your email
            <br />Or click here to verify your email
            <br /><br />
            <br /><br />
            <br />Please NOTE this URL will expire within 20 minutes
            </div>
            </body>
            </html>';
            $headers = "From: $from\n";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            //mail($to, $subject, $message1, $headers);
            echo "SIGNUP_SUCCESS";
            exit();
        }
        exit();
    }
?>
<?php $actlink = basename(__FILE__);
      $title = "Register Page";
  include_once("freelancerheader.php"); ?>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script >
function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    var UnameStat = _("UnameStat");
    var status = _("status");
    status.innerHTML = '';
    var emailStat = _("emailStat");
    var phoneStat = _("phoneStat");
    var LnameStat = _("LnameStat");
    var firstnameStat = _("firstnameStat");
    var pass1Stat = _("pass1Stat");
    var pass2Stat = _("pass2Stat");
    var genderStat = _("genderStat");
    
    if(elem =="gender"){
        genderStat.innerHTML = 'Gender <sup>*</sup>';
    }else if(elem =="pass1"){
        pass1Stat.innerHTML = 'Password <sup>*</sup>';
    }else if(elem =="pass2"){
        pass2Stat.innerHTML = 'Retype Password <sup>*</sup>';
    }else if(elem == "email"){
        emailStat.innerHTML = 'Email Address <sup>*</sup>';
        rx = /[' "]/gi;
    } else if(elem == "Uname"){
        UnameStat.innerHTML = 'User Name <sup>*</sup>';
        rx = /[^a-z0-9]/gi;
    }else if(elem == "phone"){
        phoneStat.innerHTML = 'Phone <sup>*</sup>';
        rx = /[^0-9]/gi;
    }else if(elem == "Lname"){
        LnameStat.innerHTML = 'Last Name <sup>*</sup>';
        rx = /[^a-z0-9, ]/gi;
    }else if(elem == "Fname"){
        firstnameStat.innerHTML = 'First Name <sup>*</sup>';
        rx = /[^a-z0-9, ]/gi;
    }else if(elem == "captcha"){
        rx = /[^0-9]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}
function checkemail(){
    var e = _("email").value;
    if(e != ""){
        var ajax = ajaxObj("POST","register.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                emailStat.innerHTML = 'Email Address<sup>*</sup></br><i style="color: #f00;">'+ajax.responseText+'</i>';
            }
        }
        ajax.send("emailcheck="+e);
    }
}
function checkinputs(x){
    if(g == ""){
        genderStat.innerHTML = 'Gender <sup>*</sup></br><i style="color: #f00;">Please select your gender</i>';
        _("gender").focus();
    }
    if(p2 == ""){
        if(p1 != ""){
            pass2Stat.innerHTML = 'Retype Password <sup>*</sup></br><i style="color: #f00;">Please retype your password</i>';
        }else{
            pass2Stat.innerHTML = 'Retype Password <sup>*</sup></br><i style="color: #f00;">Please provide your password</i>';
        }
        _("pass2").focus();
    }
    if(p1 == ""){
        pass1Stat.innerHTML = 'Password <sup>*</sup></br><i style="color: #f00;">Please provide your password</i>';
        _("pass1").focus();
    }
    if(ph ==""){
        phoneStat.innerHTML = 'Phone <sup>*</sup></br><i style="color: #f00;">Please provide your phone number</i>';
        _("phone").focus();
    }
    if(e == ""){
        emailStat.innerHTML = 'Email Address<sup>*</sup></br><i style="color: #f00;">Please provide your Email</i>';
        _("email").focus();
    }
    if(LN == ""){
        LnameStat.innerHTML = 'Last Name <sup>*</sup></br><i style="color: #f00;">Please provide your last name</i>';
        _("Lname").focus();
    }
    if(FN == ""){
        firstnameStat.innerHTML = 'First Name <sup>*</sup></br><i style="color: #f00;">Please provide your first name</i>';
        _("Fname").focus();
    }
    if(u == ""){
        UnameStat.innerHTML = 'User Name<sup>*</sup></br><i style="color: #f00;">Please provide your username</i>';
        _("Uname").focus();
    }
}
function checkphone(){
    var p = _("phone").value;
    if(p != ""){
        var ajax = ajaxObj("POST","register.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                _("phoneStat").innerHTML = ajax.responseText;
            }
        }
        ajax.send("phonecheck="+p);
    }
}
function emptyElement(x){
    _(x).innerHTML = "";
    _("Phonestatus").innerHTML = "";
    _("unamestatus").innerHTML = "";
    _("emailstatus").innerHTML = "";
}
function checkusername(){
    var u = _("Uname").value;
    if(u != ""){
        var ajax = ajaxObj("POST","register.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                _("UnameStat").innerHTML ='User Name<sup>*</sup></br><i style="color: #f00;">'+ajax.responseText+'</i>';
               //_("UnameStat").innerHTML = ajax.responseText;
            }
        }
        ajax.send("usernamecheck="+u);
    }
}

function signup(){
    var u = _("Uname").value;
    var FN = _("Fname").value;
    var LN = _("Lname").value;
    var RefID = _("RefID").value;
    var e = _("email").value;
    var p1 = _("pass1").value;
    var p2 = _("pass2").value;
    var g = _("gender").value;
    var ph = _("phone").value;
    var status = _("status");
    var UnameStat = _("UnameStat");
    var emailStat = _("emailStat");
    var phoneStat = _("phoneStat");
    var firstnameStat = _("firstnameStat");
    var LnameStat = _("LnameStat");
    var pass1Stat = _("pass1Stat");
    var pass2Stat = _("pass2Stat");
    var genderStat = _("genderStat");
    
    if(g == ""){
        genderStat.innerHTML = 'Gender <sup>*</sup></br><i style="color: #f00;">Please select your gender</i>';
        _("gender").focus();
    }
    if(p2 == ""){
        if(p1 != ""){
            pass2Stat.innerHTML = 'Retype Password <sup>*</sup></br><i style="color: #f00;">Please retype your password</i>';
        }else{
            pass2Stat.innerHTML = 'Retype Password <sup>*</sup></br><i style="color: #f00;">Please provide your password</i>';
        }
        _("pass2").focus();
    }
    if(p1 == ""){
        pass1Stat.innerHTML = 'Password <sup>*</sup></br><i style="color: #f00;">Please provide your password</i>';
        _("pass1").focus();
    }
    if(ph ==""){
        phoneStat.innerHTML = 'Phone <sup>*</sup></br><i style="color: #f00;">Please provide your phone number</i>';
        _("phone").focus();
    }
    if(e == ""){
        emailStat.innerHTML = 'Email Address<sup>*</sup></br><i style="color: #f00;">Please provide your Email</i>';
        _("email").focus();
    }
    if(LN == ""){
        LnameStat.innerHTML = 'Last Name <sup>*</sup></br><i style="color: #f00;">Please provide your last name</i>';
        _("Lname").focus();
    }
    if(FN == ""){
        firstnameStat.innerHTML = 'First Name <sup>*</sup></br><i style="color: #f00;">Please provide your first name</i>';
        _("Fname").focus();
    }
    if(u == ""){
        UnameStat.innerHTML = 'User Name<sup>*</sup></br><i style="color: #f00;">Please provide your username</i>';
        _("Uname").focus();
    }
    if(u == "" || e == "" || p1 == "" || p2 == "" || FN == "" || g == "" || LN == ""||ph ==""){
        status.innerHTML = "Fill out all of the form data javascript";
    } else if(p1 != p2){
            status.innerHTML = "Your password fields do not match";
        } else {
            _("RegBtn").style.display = "none";
            var ajax = ajaxObj("POST", "register.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText.trim().toUpperCase() != "SIGNUP_SUCCESS"){
                        status.innerHTML = ajax.responseText;
                        _("RegBtn").style.display = "block";
                        window.location = "#status";
                    } else {
                        window.location = "login.php?Msg=User " + u + " successfully created please login";
                    }
                }
            }
            ajax.send("u="+u+"&e="+e+"&p="+p1+"&FN="+FN+"&g="+g+"&LN="+LN+"&RefID="+RefID+"&ph="+ph);
        }
    }
</script>
<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                            <form onsubmit="return false;" method="post" action="#" id="form-account-creation" class="form-horizontal box panel panel-default">
                                <h3 class="panel-heading">Create an account</h3>
                                <div class="form_content panel-body clearfix">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                        <p id="status" style="color: #f00;"></p>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="Uname" id="UnameStat">User Name <sup>*</sup></label>
                                            <input onkeyup="restrict('Uname')" onchange="checkusername()" type="text" class="form-control" id="Uname" name="Uname" placeholder="User Name">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="firstname" id="firstnameStat">First Name <sup>*</sup></label>
                                            <input onkeyup="restrict('Fname')" type="text" class="form-control" id="Fname" name="Fname" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="lastname" id="LnameStat">Last Name <sup>*</sup></label>
                                            <input onkeyup="restrict('Lname')" type="text" class="form-control" id="Lname" name="Lname" placeholder="Last Name">
                                            <input type="hidden" id="RefID" name="RefID" value="<?php echo $RefID; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="email" id="emailStat">Email Address <sup>*</sup></label>
                                            <input onchange="checkemail()" onblur="checkemail()" onkeyup="restrict('email')" type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="phone" id="phoneStat">Phone <sup>*</sup></label>
                                            <input id="phone" name="phone" onkeyup="restrict('phone')" type="text" class="form-control" placeholder="Phone(080xxxxxxxx)" maxlength="11">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="pass1" id="pass1Stat">Password <sup>*</sup></label>
                                            <input type="password" onkeyup="restrict('pass1')" class="form-control" id="pass1" name="pass1" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="pass2" id="pass2Stat">Retype Password <sup>*</sup></label>
                                            <input type="password" onkeyup="restrict('pass2')" class="form-control" id="pass2" name="pass2" placeholder="Retype password">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-lg-12">
                                            <label for="gender" id="genderStat">Gender <sup>*</sup></label>
                                            <select id="gender" onchange="restrict('gender')" class="form-control" placeholder="Gender">
                                                <option value="">Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="O">Others (Corporate)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <button class="btn button btn-default" id="RegBtn" onclick="signup()">Register</button>
                                            <p class="pull-right required"><span><sup>*</sup>Required field</span></p>
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
                        © 2016 Freelancer. Designed with <i class="fa fa-heart"></i> and <i class="fa fa-coffee"></i> by Tivatheme
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