<?php
include_once("php_codes/check_login_status.php");
if($user_ok == false){
    header("location: index.php");
    exit();
}
?>
<?php
    function VeryPhone($smsVrihash,$log_username,$db_conx){
        $sql = "select count(1) from USER_PHONE_EMAIL where username = '$log_username'
                    and phone_vri_code = '$smsVrihash' and phone_email = 'PHONE' and phone_vri_flg = 'N'";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $PCheck = $row[0];
        if($PCheck > 0){
            $sql = "update USER_PHONE_EMAIL set phone_vri_flg = 'Y' 
                    where username = '$log_username' and phone_vri_code = '$smsVrihash'
                    and phone_email = 'PHONE' and phone_vri_flg = 'N' limit 1; ";
            $query = mysqli_query($db_conx, $sql);
            return "SUCCESS";
        }else{
            return "Verify code do not match or already been used";
        }
    }
    
    function VeryEmail($emailVrihash,$log_username,$db_conx){
        $sql = "select count(1) from USER_PHONE_EMAIL where username = '$log_username'
                    and email_vri_code = '$emailVrihash' and phone_email = 'EMAIL' and email_vri_flg = 'N'";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $PCheck = $row[0];
        if($PCheck > 0){
            $sql = "update USER_PHONE_EMAIL set email_vri_flg = 'Y' 
                    where username = '$log_username' and email_vri_code = '$emailVrihash'
                    and phone_email = 'EMAIL' and phone_vri_flg = 'N' limit 1; ";
            $query = mysqli_query($db_conx, $sql);
            return "SUCCESS";
        }else{
            return "Verify code do not match or already been used";
        }
    }
    //This sesson handle the profile update
    if(isset($_POST["Fname"])){
        $FN = preg_replace('#[^a-z0-9 ]#i', '', $_POST['Fname']);
        $LN = preg_replace('#[^a-z0-9 ]#i', '', $_POST['Lname']);
        
        If(($FN != "") &&($LN != "")){
            $sql = "update USER_CREDS set first_name = '$FN', last_name = '$LN'";
            $query = mysqli_query($db_conx, $sql);
            echo 'POSTED_SUCCESS';
            exit();
        }else{
            echo '<div class="alert alert-danger">';
            echo 'Please provide your name\'s';
            echo '</div>';
            exit();
        }
        exit();
    }
    if(isset($_POST["smsVri"])){
        $smsVri = preg_replace('#[^0-9 ]#i', '', $_POST['smsVri']);
        $emailVri = preg_replace('#[^0-9 ]#i', '', $_POST['emailVri']);
        $smsVrihash = md5($smsVri);
        $emailVrihash = md5($emailVri);
        
        if(($smsVri != "") && ($emailVri != "")){
            $checkPh = VeryPhone($smsVrihash, $log_username, $db_conx);
            $checkEm = VeryEmail($emailVrihash, $log_username, $db_conx);
            if(($checkPh == "SUCCESS") && ($checkEm == "SUCCESS")){
                echo '<div class="alert alert-success">';
                echo 'Your record verified';
                echo '</div>';
            }else {
                echo '<div class="alert alert-danger">';
                echo $checkPh;
                echo '</div>';
                exit();
            }
        }else if($smsVri != ""){
            $checkPh = VeryPhone($smsVrihash, $log_username, $db_conx);
            if($checkPh == "SUCCESS") {
                echo '<div class="alert alert-success">';
                echo 'Your record verified';
                echo '</div>';
            }else {
                echo '<div class="alert alert-danger">';
                echo $checkPh;
                echo '</div>';
                exit();
            }
        }else if ($emailVri != ""){
            $checkEm = VeryEmail($emailVrihash, $log_username, $db_conx);
            if($checkPh == "SUCCESS") {
                echo '<div class="alert alert-success">';
                echo 'Your record verified';
                echo '</div>';
            }else {
                echo '<div class="alert alert-danger">';
                echo $checkPh;
                echo '</div>';
                exit();
            }
        }else{
            $sql = "select phone,email from USER_CREDS where username = '$log_username' limit 1";
            $query = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query);
            $phone = $row[0];
            $email = $row[1];
            
            echo '<div class="alert alert-danger">';
            echo ' Please provide the SMS verification code sent to '.$phone.' or the email verification code sent to '.$email;
            echo '</div>';
            exit();
        }
        exit();
    }
    if(isset($_POST["pass1"])){
        $pass = md5($_POST['pass1']);
        $OldPass = md5($_POST['OldPass']);
        
        $sql = "select count(1) from USER_LOGIN_CREDS where password = '$OldPass' and username = '$log_username' limit 1";
        $query = mysqli_query($db_conx, $sql); 
        $row = mysqli_fetch_row($query);
        $PCheck = $row[0];
        if($PCheck == 0){
            echo '<div class="alert alert-danger">';
            echo 'Please provide your valid old password';
            echo '</div>';
            exit();
        }
        
        $sql = "select count(1) from USER_PASS_HISTORY where password = '$pass' and username = '$log_username' limit 1";
        $query = mysqli_query($db_conx, $sql); 
        $row = mysqli_fetch_row($query);
        $PCheck = $row[0];
        if($PCheck > 0){
            echo '<div class="alert alert-danger">';
            echo 'Your password cannot be your old password';
            echo '</div>';
            exit();
        }
        
        $sql = "insert into USER_PASS_HISTORY (select '',username,password, id,now() from user_login_creds where username = '$log_username'); ";
        $query = mysqli_query($db_conx, $sql); 
        $row = mysqli_fetch_row($query);
        
        $sql = "update USER_LOGIN_CREDS set password = '$pass', num_pwd_history = num_pwd_history + 1, 
                pwd_history =  CONCAT(IFNULL(pwd_history,''),',$pass')  , pwd_last_mod_time = now()
                where username = '$log_username' limit 1;";
        $query = mysqli_query($db_conx, $sql); 
        $row = mysqli_fetch_row($query);
        
        echo 'POSTED_SUCCESS';
        exit();
    }
    //This code fetch skill content on our database
    if(isset($_POST["textSkill"])){
        $Skl = preg_replace('#[^a-z0-9]#i', '', $_POST['textSkill']);
        
        $sql = "select skill_name from Skill  
                where upper(skill_name) like upper('%$Skl%') ";
        $query = mysqli_query($db_conx, $sql);
        $skill_Det = '';
        $count =0;
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $skill_name = $row["skill_name"];
            $count += 1;
            
            $skill_Det .= $count . '    ' . $skill_name.'</br>';
        }
        echo $skill_Det;
        exit();
    }
    //Post the Project ID into our data base 
    if(isset($_POST["ComName"])){
        $ComName = preg_replace('#[^a-z0-9 ]#i', '', $_POST['ComName']);
        $ComLoc = preg_replace('#[^a-z0-9 ]#i', '', $_POST['ComLoc']);
        $ComDes = mysqli_real_escape_string($db_conx, $_POST['ComDes']);
        
        $sql = "insert into company_client (company_name,company_desc,company_location,
                del_flg,lchg_time)values('$ComName','$ComDes','$ComLoc','N',now())";
        $query = mysqli_query($db_conx, $sql); 
        $uid = mysqli_insert_id($db_conx);
        
        $sql = "insert into Hire_Manager (user_account_i,registration_date,location,company_id,
                del_flg,lchg_time)values('$log_username',now(),'$ComLoc','$uid',N',now())";
        $query = mysqli_query($db_conx, $sql);
        exit();
    }
?><?php
    $sql = "select first_name, last_name, gender, phone_vri,phone,email from USER_CREDS where username = '$log_username' limit 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $User_Name = $row[0] .' '.$row[1];
    $Fname = $row[0];
    $Lname = $row[1];
    $gender = $row[2];
    $phoneVeri = $row[3];
    $phone = $row[4];
    $email = $row[5];
    
    $sql = "select company_name from company_client where id in (select company_id 
             from Hire_Manager where user_account_i = '$log_username') limit 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $User_ComNam = $row[0];
?>
<?php $actlink = basename(__FILE__);
    $title = "User Settings";
  include_once("freelancerheader.php"); ?>

<style>
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
.alert {
    padding: 20px;
}
</style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script >
    function updPass(){
        var pass1 = _("pass1").value;
        var pass2 = _("pass2").value;
        var OldPass = _("OldPass").value;
        var Pstatus = _("Passstatus");
        if(pass1 == "" || pass2 == "" || OldPass == ""){
            Pstatus.innerHTML = '<div class="alert alert-danger"> Please fill out all the form\'s </div>';
        }else if(pass1 != pass2){
            Pstatus.innerHTML = '<div class="alert alert-danger"> Your password fields do not match </div>';
        }else if(OldPass == pass2){
            Pstatus.innerHTML = '<div class="alert alert-danger"> Your new password cannot be same as your old password </div>';
        }else{
            _("updPassBt").style.display = "none";
            var ajax = ajaxObj("POST", "UserSettings.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText.trim().toUpperCase() == "POSTED_SUCCESS"){
                        _("updPassBt").style.display = "block";
                        window.scrollTo(0, 0);
                        Pstatus.innerHTML = '<div class="alert alert-success"> You have updated your profile </div>';
                    } else {
                        _("updPassBt").style.display = "block";
                        window.scrollTo(0, 0);
                        Pstatus.innerHTML = '<div class="alert alert-danger">' + ajax.responseText + '</div>';
                    }
                }
            }
            ajax.send("pass1="+pass1+"&OldPass="+OldPass);
        }
    }
    function updSms(Ph,Em){
        var smsVri = _("smsVri").value;
        var emailVri = _("emailVri").value;
        var Pstatus = _("Phonestatus");
        
        if((smsVri == "") && (emailVri == "")){
            Pstatus.innerHTML = '<div class="alert alert-danger"> Please provide the SMS verification code sent to '+Ph+' or the email verification code sent to '+Em+'</div>';
        }else{
            //_("updSmsBt").style.display = "none";
            _("updSmsBt").disabled = true;
            var ajax = ajaxObj("POST", "UserSettings.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText.trim().toUpperCase() == "POSTED_SUCCESS"){
                        //_("updSmsBt").style.display = "block";
                        _("updSmsBt").disabled = false;
                        Pstatus.innerHTML = '<div class="alert alert-success"> You have updated your profile </div>';
                    } else {
                        //_("updSmsBt").style.display = "block";
                        _("updSmsBt").disabled = false;
                        //Pstatus.innerHTML = '<div class="alert alert-danger">' + ajax.responseText + '</div>';
                        Pstatus.innerHTML =  ajax.responseText;
                    }
                }
            }
            ajax.send("smsVri="+smsVri+"&emailVri="+emailVri);
        }
    }
    function updNm(){
        var Fname = _("Fname").value;
        var Lname = _("Lname").value;
        var Pstatus = _("upNmstatus");
        if(Fname == "" || Lname == ""){
            Pstatus.innerHTML = '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span><div class="alert alert-danger"> Please fill out all the form\'s </div></span>';
            //Pstatus.innerHTML = '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span><div class="alert alert-danger"> Please fill out all the form\'s </div></span>';
        }else{
            _("updNm").style.display = "none";
            var ajax = ajaxObj("POST", "UserSettings.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText.trim().toUpperCase() == "POSTED_SUCCESS"){
                        _("updNm").style.display = "block";
                        window.scrollTo(0, 0);
                        Pstatus.innerHTML = '<div class="alert alert-success"> You have updated your profile </div>';
                    } else {
                        _("updNm").style.display = "block";
                        window.scrollTo(0, 0);
                        Pstatus.innerHTML = '<div class="alert alert-danger">' + ajax.responseText + '</div>';
                    }
                }
            }
            ajax.send("Fname="+Fname+"&Lname="+Lname);
        }
    }
    
    function Post(){
        var ComName = _("ComName").value;
        var ComLoc = _("ComLoc").value;
        var ComDes = _("ComDes").value;
        var status = _("status");
        
        var ajax = ajaxObj("POST", "page-post-a-project.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText.trim().toUpperCase() == "POSTED_SUCCESS"){
                    window.location = "index.php";
                } else {
                    window.scrollTo(0, 0);
                    status.innerHTML = ajax.responseText;
                }
            }
        }
        ajax.send("ComName="+ComName+"&ComLoc="+ComLoc+"&ComDes="+ComDes);
    }
    
    function CopPost(){
        _("CopSub").style.disabled = true;
        var val = ValidationCop();
        if(val == true){
            Post();
        }else{
            _("CopSub").style.disabled = false;
        }
    }
    
    function ValidationCop(){
        var errorcheck = "";
        var ComName = _("ComName").value;
        var ComLoc = _("ComLoc").value;
        var ComDes = _("ComDes").value;
        var status = _("status");
        
        if((ComName == "")||(ComName == null)){
            _("ComName").style.borderColor = "red";
            _("ComName").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("ComName").onchange = function() {RemoveRed("ComName");};
        }
        if((ComLoc == "")||(ComLoc == null)){
            _("ComLoc").style.borderColor = "red";
            _("ComLoc").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("ComLoc").onchange = function() {RemoveRed("ComLoc");};
        }
        if((ComDes == "")||(ComDes == null)){
            _("ComDes").style.borderColor = "red";
            _("ComDes").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("ComDes").onchange = function() {RemoveRed("ComDes");};
        }
        
        if((ComName == null)||(ComLoc == null)||(ComDes == null)){
            errorcheck = "YES";
        }
        if((ComName == "")||(ComLoc == "")||(ComDes == "")){
            window.scrollTo(0, 0);
            status.innerHTML = '<div class="alert alert-danger">Forms In Red Has Issues</div>';
            return false;
        }else{
            return true;
        }
    }
    
    function RemoveRed(id){
        var status = _("status");
        _(id).style.borderColor = "";
        status.innerHTML = '';
    }
    
    function restrict(elem){
      var tf = _(elem);
      var rx = new RegExp;
      
      if(elem == "Lname"){
        rx = /[^a-z0-9, ]/gi;
      }else if(elem == "Fname"){
        rx = /[^a-z0-9, ]/gi;
      }else if(elem == "email"){
        rx = /[' "]/gi;
      } else if(elem == "Uname"){
        rx = /[^a-z0-9]/gi;
      }else if(elem == "phone"){
        rx = /[^0-9]/gi;
      }else if(elem == "Lname"){
        rx = /[^a-z0-9, ]/gi;
      }else if(elem == "Fname"){
        rx = /[^a-z0-9, ]/gi;
      }else if(elem == "captcha"){
        rx = /[^0-9]/gi;
      }else if(elem == "smsVri"){
        rx = /[^0-9]/gi;
      }else if(elem == "emailVri"){
        rx = /[^0-9]/gi;
      }
      tf.value = tf.value.replace(rx, "");
    }
    
</script>
        <!--start Here-->
        <div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="freelance-detail">
                        <div class="freelance-detail-tab box">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#about-me" aria-controls="about-me" role="tab" data-toggle="tab">General Settings</a></li>
                                <li role="presentation"><a href="#protfolio" aria-controls="protfolio" role="tab" data-toggle="tab">FREELANCER Settings</a></li>
                                <li role="presentation"><a href="#CopSet" aria-controls="my-skills" role="tab" data-toggle="tab">CO-OPERATES Settings</a></li>
                                <li role="presentation"><a href="#hire-me" aria-controls="hire-me" role="tab" data-toggle="tab">PROFILE</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="about-me">
                                    <div class="tabbox-content">
                                        <div class="des">
                                            <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                                <div class="form-group">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-step" id="divselectCategories">
                                                        <label>Allow Email notification?</label>
                                            
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label>Allow SMS notification?</label>
                                                        <input onkeyup="restrict('textProject')" class="form-control" type="text" id="textProject" name="textProject" placeholder="Eg: Design a website">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="protfolio">
                                    <div class="tabbox-content">
                                        <div class="media clearfix">
                                            <div class="pull-left">
                                                <span class="avatar-profile">
                                                    <img class="img-responsive" src="img/default/avatar/avatar4.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h2><?php echo $User_Name;?></h2>
                                                <?php if ($User_ComNam != ""){?>
                                                <h4 class="position-profile"><?php echo $User_ComNam;?>'s team</h4>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="des">
                                            <p class="pdropcap" id="changeEdit">
                                            <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Write something about your organization</label>
                                                <textarea class="form-control" rows="10" id="ComDes" name="ComDes" placeholder="Type something about your company..."></textarea>
						</div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="file-path-wrapper">
                                                    <!--<input class="file-path validate" type="text" placeholder="Upload your file">-->
                                                    <input type="file" class="form-control" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                </div>
                                                </div>
                                            </form>
                                            </p>
                                        </div>
                                        <a class="btn btn-default btn-shadown" href="#" title="Download my resume">Download my resume</a>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="CopSet">
                                    <div class="tabbox-content">
                                        <div class="des">
                                            <div class="row">
                                                <h4>CO-OPERATION SETTINGS</h4></br></br>
                                                
                                                <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
												<div class="form-group">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<label>What is your company name?</label>
													<input onkeyup="restrict('textProject')" class="form-control" type="text" id="ComName" name="ComName" placeholder="Eg: MicroSoft LTD">
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<label>What is your company location?</label>
													<input onkeyup="restrict('textProject')" class="form-control" type="text" id="ComLoc" name="ComLoc" placeholder="Eg: Lagos">
												</div>
												</div>
												<div class="form-group">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<label>Write something about your organization</label>
													<textarea class="form-control" rows="10" id="ComDes" name="ComDes" placeholder="Type something about your company..."></textarea>
												</div>
												</div>
												<div class="form-group">
												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-left">
												<p>By clicking 'Submit button', you are indicating that you have read and agree to the <a href="#" title="Terms & Conditions">Terms & Conditions</a> and <a href="#" title="Privacy Policy">Privacy Policy</a></p>
												</div> 
												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
													<button type="submit" id ="CopSub" onclick="CopPost()" class="btn button btn-primary btn-shadown">Submit your message</button>
												</div> 
												</div>
												</form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="hire-me">
                                    <div class="tabbox-content">
                                        <p id="Pstatus" ></p>
                                        <div class="des">
                                            <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                                <div class="row">
                                                    <p id="upNmstatus" ></p>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="Fname" onkeyup="restrict('Fname')" name="Fname" class="form-control" placeholder="First Name" value="<?php echo $Fname;?>"/>
                                                    </div>
                                                    
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="Lname" onkeyup="restrict('Lname')" name="Lname" class="form-control" placeholder="Last Name" value="<?php echo $Lname;?>"/>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div id="row">
                                                    <button type="submit" id="updNmBt" onclick="updNm();" class="btn button btn-default btn-shadown">Update Names</button>
                                                </div>
                                            </form>
                                                <hr>
                                            <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                                <div class="row">
                                                    <p id ="Passstatus"></p>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="password" id="pass1" name="pass1" class="form-control" placeholder="Password"/>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="password" id="pass2" name="pass2" class="form-control" placeholder="Retype password"/>
                                                    </div>
                                                        </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="password" id="OldPass" name="pass2" class="form-control" placeholder="Old password"/>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" id="updPassBt" onclick="updPass();" class="btn button btn-default btn-shadown">Update Password</button>
                                                </div>
                                            </form>
                                                <hr>
                                                
                                                <form id="postjob-form1" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                                    <div class="row">
                                                        <p id ="Phonestatus"></p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-step">
                                                            <input class="form-control" onkeyup="restrict('smsVri')" type="text" id="smsVri" name="smsVri" placeholder="SMS Verify Code">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-step">
                                                            <input class="form-control" onkeyup="restrict('emailVri')" type="text" id="emailVri" name="emailVri" placeholder="Email Verify Code">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" id="updSmsBt" onclick="updSms('<?php echo $phone;?>','<?php echo $email; ?>');" class="btn button btn-default btn-shadown">Verify SMS</button>
                                                    </div>
                                                </form>
                                                
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end freelance-detail-tab -->
                    </div><!-- end freelance-detail -->    
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