<?php
include_once("php_codes/check_login_status.php");
if($user_ok == false){
    header("location: index.php");
    exit();
}
?>
<?php
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
    //Post the Project ID into oour data base 
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
    }
?>
<?php $actlink = basename(__FILE__);
    $title = "User Settings";
  include_once("freelancerheader.php"); ?>

<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script >
    function RemoveRed(id){
        var status = _("status");
        _(id).style.borderColor = "";
        status.innerHTML = '';
    }
    function fetch_skill(){
        var textSkill = _("textSkill").value;
        var FetchSkill = _("FetchSkill");
        
        if(textSkill != ''){
            var ajax = ajaxObj("POST", "page-post-a-project.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    //alert(ajax.responseText);
                    FetchSkill.innerHTML = ajax.responseText;
                }
            }
            ajax.send("textSkill="+textSkill);
        }else{
            FetchSkill.innerHTML = "";
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
    function CopPost(){
        _("CopSub").style.disabled = true;
        var val = ValidationCop();
        if(val == true){
            Post();
        }else{
            _("CopSub").style.disabled = false;
        }
    }
    function restrict(elem){
      var tf = _(elem);
      var rx = new RegExp;

      if(elem == "email"){
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
      }
      tf.value = tf.value.replace(rx, "");
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
                    //status.innerHTML = "Posted unsuccessful, "+ajax.responseText;
                    window.scrollTo(0, 0);
                    status.innerHTML = ajax.responseText;
                }
            }
        }
        ajax.send("ComName="+ComName+"&ComLoc="+ComLoc+"&ComDes="+ComDes);
    }
</script>
<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="post-a-project">
                        <h1 class="title_block"><span>USER</span> SETTINGS</h1>
                        <div class="box clearfix">
                            <div class="box-content">
                                <p id="status" style="color: #f00;"></p>
                                <ul class="nav nav-pills">
                                <li><a data-toggle="pill" href="#menu1"><h3>FOR FREELANCER</h3></a></li>
                                <li><a data-toggle="pill" href="#menu2"><h3>FOR CO-OPERATES</h3></a></li>
                                </ul>
                                
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <p>Welcome to user setting where you can edit your profile and many more</p>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <h4>FREELANCER</h4></br></br>
                                        <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                        <div class="form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>What is your project about?</label>
                                            <input onkeyup="restrict('textProject')" class="form-control" type="text" id="textProject" name="textProject" placeholder="Eg: Design a website">
                                        </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div id="menu2" class="tab-pane fade">
                                        <h4>CO-OPERATION</h4></br></br>
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
                    </div><!-- end post-a-project -->
                </div><!-- end container -->
            </div><!-- end warpper -->
            <div class="bg-bottom"></div>
        </div><!--end warp-->
        
        
        
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
                                        <div class="media clearfix">
                                            <div class="pull-left">
                                                <span class="avatar-profile">
                                                    <img class="img-responsive" src="img/default/avatar/avatar4.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h2>christina aguilera</h2>
                                                <h4 class="position-profile">Dribble team</h4>
                                            </div>
                                        </div>
                                        <div class="des">
                                            <p class="pdropcap">Lorem Khaled Ipsum is a major key to success. Celebrate success right, the only way, apple. Give thanks to the most high. Fan luv. The key to success is to keep your head above the water, never they in there, after you overcome they, you will make it to paradise. Learning is cool, but knowing is better, and I know the key to success. You do know, you do know that they don’t want you to have lunch. I’m keeping it real with you, so what you going do is have lunch. The key is to drink coconut, fresh coconut, trust me. To succeed you must believe. When you believe, you will succeed. They never said winning was easy. Some people can’t handle success, I can. Another one. We the best. You smart, you loyal, you a genius. They don’t want us to win.</p>
                                        </div>
                                        <a class="btn btn-default btn-shadown" href="#" title="Download my resume">Download my resume</a>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="protfolio">
                                    <div class="tabbox-content">
                                        <div class="des">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
                                                    <div class="protfolio-image">
                                                        <img class="img-responsive" src="img/image/image1.jpg" alt="">
                                                        <a href="#" title="Animal Man">Animal Man</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
                                                    <div class="protfolio-image">
                                                        <img class="img-responsive" src="img/image/image2.jpg" alt="">
                                                        <a href="#" title="Animal Man">Mountain Landscape</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
                                                    <div class="protfolio-image">
                                                        <img class="img-responsive" src="img/image/image3.jpg" alt="">
                                                        <a href="#" title="Animal Man">Fashion design</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
                                                    <div class="protfolio-image">
                                                        <img class="img-responsive" src="img/image/image4.jpg" alt="">
                                                        <a href="#" title="Animal Man">Mountain Landscape</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="CopSet">
                                    <div class="tabbox-content">
                                        <div class="des">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sp-12">
                                                    <div class="my-progress">
                                                        <h4>CO-OPERATES SETTINGS</h4>
                                                        <div class="my-progresscontent">
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="UI/UX">UI/UX</a>
                                                                    <span class="pull-right">74%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-black-bg progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                                                                        <span class="sr-only">74% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="Web design">Web design</a>
                                                                    <span class="pull-right">85%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
                                                                        <span class="sr-only">85% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="Graphics">Graphics</a>
                                                                    <span class="pull-right">90%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                                                        <span class="sr-only">90% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="Motions">Motions</a>
                                                                    <span class="pull-right">65%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-black-bg progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                                        <span class="sr-only">65% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sp-12">
                                                   <div class="my-progress">
                                                        <h4>Tools & Editor</h4>
                                                        <div class="my-progresscontent">
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="Photoshop">Photoshop</a>
                                                                    <span class="pull-right">94%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 94%">
                                                                        <span class="sr-only">94% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="Illustrator">Illustrator</a>
                                                                    <span class="pull-right">82%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 82%">
                                                                        <span class="sr-only">82% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="Indesign">Indesign</a>
                                                                    <span class="pull-right">77%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-black-bg progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 77%">
                                                                        <span class="sr-only">77% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-item">
                                                                <div class="progress-title">
                                                                    <a href="#" title="After effects">After effects</a>
                                                                    <span class="pull-right">65%</span>
                                                                </div>
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-black-bg progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                                        <span class="sr-only">65% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="hire-me">
                                    <div class="tabbox-content">
                                        <div class="des">
                                            <form method="post" action="#" id="cform">
                                                <div class="row">
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="name" name="name" class="form-control" placeholder="Your name..."/>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="0123456789"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="nameSubject" name="nameSubject" class="form-control" placeholder="Subject..."/>
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="message" name="message" class="form-control" placeholder="Your message..."></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn button btn-default btn-shadown">Submit message</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end freelance-detail-tab -->
                        <div class="detail-other clearfix">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-sp-12">
                                    <div class="tab-info">
                                        <div class="row tab-info-title">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5"><span>Freelancer bidding <?php echo $FreTotalBids;?></span></div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7"><span class="short-pre">Short preview</span></div>
                                        </div>
                                        <div class="tab-info-content box">
                                            <div class="bidding-list">
                                                <div class="bidding-item">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 col-sp-12">
                                                            <div class="media">
                                                                <div class="pull-left">
                                                                    <img src="img/default/avatar/avatar1.jpg" alt="">
                                                                </div>
                                                                <div class="media-body">
                                                                    <span class="name-profile">Redikiel</span><br>
                                                                    <span class="position-profile">Web designer</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 col-sp-12">
                                                            <div class="bidding-des">
                                                                <p>Hello everyone! I’m REDIKIEL - UI/UX Designer from Vietnam. I’m always obsessed by the nice detail. I’m available to hire. Let feel free to contact me via my email, mobile phone, skype or anything like that. Thank you and have a nice day!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bidding-item">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 col-sp-12">
                                                            <div class="media">
                                                                <div class="pull-left">
                                                                    <img src="img/default/avatar/avatar2.jpg" alt="">
                                                                </div>
                                                                <div class="media-body">
                                                                    <span class="name-profile">Wooden Team</span><br>
                                                                    <span class="position-profile">Product Designer</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 col-sp-12">
                                                            <div class="bidding-des">
                                                                <p>In life you have to take the trash out, if you have trash in your life, take it out, throw it away, get rid of it, major key.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bidding-item last">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 col-sp-12">
                                                            <div class="media">
                                                                <div class="pull-left">
                                                                    <img src="img/default/avatar/avatar3.jpg" alt="">
                                                                </div>
                                                                <div class="media-body">
                                                                    <span class="name-profile">D.Beckham</span><br>
                                                                    <span class="position-profile">Graphic Designer</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 col-sp-12">
                                                            <div class="bidding-des">
                                                                <p>I promise you, they don’t want you to jetski, they don’t want you to smile. They will try to close the door on you, just open it. The key is to drink coconut, fresh coconut, trust me.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end tab-info -->
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                    <div class="tab-info">
                                        <div class="row tab-info-title">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><span>Information</span></div>
                                        </div>
                                        <div class="tab-info-content last box">
                                            <div class="tab-info-company">
                                                <ul class="bullet">
                                                    <li>
                                                        <div class="spent"><i class="fa fa-diamond"></i>
                                                            Total Spent <span class="info">$1.400.000</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="spent"><i class="fa fa-briefcase"></i>
                                                            Project Posted <span class="info">2 jobs</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="spent"><i class="fa fa-user-secret"></i>
                                                            Hires <span class="info">3</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="spent"><i class="fa fa-star"></i>
                                                            Rating 
                                                            <span class="info">
                                                                <span class="star_content">
                                                                    <span class="star star_on"></span>
                                                                    <span class="star star_on"></span>
                                                                    <span class="star star_on"></span>
                                                                    <span class="star star_on"></span>
                                                                    <span class="star star_on"></span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end detail-other -->
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