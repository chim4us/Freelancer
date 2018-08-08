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
    if(isset($_POST["Pro"])){
        $Pro = preg_replace('#[^a-z0-9 ]#i', '', $_POST['Pro']);
        //$Des = preg_replace('#[^a-z0-9.;-)( ]#i', '', $_POST['Des']);
        $Des = mysqli_real_escape_string($db_conx, $_POST['Des']);
        $Skl = preg_replace('#[^a-z0-9; ]#i', '', $_POST['Skl']);
        //$Skl = mysqli_real_escape_string($db_conx, $_POST['Skl']);
        $Bug = preg_replace('#[^0-9]#i', '', $_POST['Bug']);
        //$Dat = preg_replace('#[^a-z0-9]#i', '', $_POST['Dat']);
        $Dat = mysqli_real_escape_string($db_conx, $_POST['Dat']);
        $Cat = preg_replace('#[^a-z0-9]#i', '', $_POST['Cat']);
        $Pay = preg_replace('#[^a-z0-9]#i', '', $_POST['Pay']);
        
        //check if the project already posted
        $sql = "select count(1) from Hire_Manager where
                 user_account_i = '$log_username' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $ProCheck = $row[0];
        if($ProCheck == 0){
            echo 'Please use link <a href="recruitment-detail.php" >Here</a> to register your company on our system before posting any project';
            exit();
        }
        
        //Check if the customer register his company on our system
        $sql = "select count(1) from Job where upper(title) like upper('$Pro')
                 and hire_manager_id = '$log_username' and upper(description) like upper('$Des') limit 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $ProCheck = $row[0];
        if($ProCheck > 0){
            echo "Your Project Already posted";
            exit();
        }
        
        //Check if the expire date is pass date or not
        $todays_date = date("Y-m-d"); 
        $today = strtotime($todays_date); 
        $expiration_date = strtotime($Dat); 
        if ($today > $expiration_date) 
        { 
            echo "Your expire date cannot be a past date";
            exit();
        }
        
        //Go throuth the Skill 
        $myArray = explode(';', $Skl);
        $count =0;
        $SklFst = '';
        foreach($myArray as $my_Array){
            //echo $my_Array.'<br>';
            $count += 1;
            $sql = "select count(1) from Skill  
                    where upper(skill_name) like upper('%$my_Array%')";
            $query = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query);
            $skill = $row[0];
            if($skill == 0){
                $sql = "INSERT INTO Skill (del_flg,skill_name) VALUES ('N', '$my_Array'); ";
                $query = mysqli_query($db_conx, $sql); 
            }
            if($count == 1){
                $sql = "select id from Skill  
                        where upper(skill_name) like upper('$my_Array') limit 1";
                $query = mysqli_query($db_conx, $sql);
                $row = mysqli_fetch_row($query);
                $SklFst = $row[0];
                //$SklFst = $my_Array;
            }
        }
        
        //Get Categorie ID
        $sql = "select a.id from Categorie a, form_categories b 
                where b.cat_name = a.Categorie_text and b.cat_value = '$Cat' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $Cat = $row[0];
        
        //Get payment type ID
        $sql = "select a.id from payment_type a, form_payment b 
                where b.pro_name = a.type_name and b.pro_value = '$Pay' limit 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
        $Pay = $row[0];
        
        //Now post the project
        $sql = "insert into Job(categorie_id,title,description,main_skill_id,exp_date,del_flg,hire_manager_id,
                payment_type_id,payment_amount) values('$Cat','$Pro','$Des','$SklFst',STR_TO_DATE('$Dat','%Y-%m-%d'),
                'N','$log_username',
                '$Pay','$Bug');";
        
        $query = mysqli_query($db_conx, $sql); 
        $uid = mysqli_insert_id($db_conx);
        $uid = mysqli_insert_id($db_conx);
        //echo $sql.' '. $uid;
        //exit();
        
        if($count > 1){
            $myArray = explode(';', $Skl);
            $count =0;
            $SklFst = '';
            foreach($myArray as $my_Array){
                $count += 1;
                if($count > 1){
                    $sql = "INSERT INTO Other_Skills (del_flg,job_id,skill_id) VALUES ('N', '$uid',(select
                            id from Skill where skill_name = '$my_Array' limit 1)); ";
                    $query = mysqli_query($db_conx, $sql); 
                }
            }
        }
        echo "POSTED_SUCCESS";
        exit();
    }
?>
<?php $actlink = basename(__FILE__);
    $title = "Post A Project";
  include_once("freelancerheader.php"); ?>

<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script >
    function RemoveRed(id){
        _(id).style.borderColor = "";
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
    function Validation(){
        var errorcheck = "";
        var textProject = _("textProject").value;
        var description = _("description").value;
        var textSkill = _("textSkill").value;
        var textBudget = _("textBudget").value;
        var textDate = _("textDate").value;
        var selectCategories = _("selectCategories").value;
        var selectPayment = _("selectPayment").value;
        var status = _("status");
        
        if((selectCategories == "")||(selectCategories == null)){
            _("selectCategories").style.borderColor = "red";
            _("selectCategories").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("selectCategories").onchange = function() {RemoveRed("selectCategories");};
        }
        if((selectPayment == "")||(selectPayment == null)){
            _("selectPayment").style.borderColor = "red";
            _("selectPayment").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("selectPayment").onchange = function() {RemoveRed("selectPayment");};
        }
        if((textProject == "")||(textProject == null)){
            _("textProject").style.borderColor = "red";
            _("textProject").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textProject").onchange = function() {RemoveRed("textProject");};
        }
        if((description == "")||(description == null)){
            _("description").style.borderColor = "red";
            _("description").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("description").onchange = function() {RemoveRed("description");};
        }
        if((textSkill == "")||(textSkill == null)){
            _("textSkill").style.borderColor = "red";
            _("textSkill").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textSkill").onchange = function() {RemoveRed("textSkill");};
        }
        if((textBudget == "")||(textBudget == null)){
            _("textBudget").style.borderColor = "red";
            _("textBudget").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textBudget").onchange = function() {RemoveRed("textBudget");};
        }
        if((textDate == "") ||(textDate == null)){
            _("textDate").style.borderColor = "red";
            _("textDate").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textDate").onchange = function() {RemoveRed("textDate");};
        }
        if(isNaN(textBudget) == true){
            _("textBudget").style.borderColor = "red";
            _("textBudget").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textBudget").onchange = function() {RemoveRed("textBudget");};
            errorcheck = "YES";
        }
        if (isNaN(textBudget) == true){
            _("textBudget").style.borderColor = "red";
            _("textBudget").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textBudget").onchange = function() {RemoveRed("textBudget");};
            errorcheck = "YES";
        }
        var d = new Date(textDate);
        if(d == "Invalid Date"){
            _("textDate").style.borderColor = "red";
            _("textDate").style = "border-color: #E1490F;box-shadow: 0 0 5px rgba(207, 220, 0, 0.4);";
            _("textDate").onchange = function() {RemoveRed("textDate");};
            errorcheck = 'Yes';
        }
        if((textProject == null)||(description == null)||(textSkill == null)||(textBudget == null)||(textDate == null)||(selectCategories == null)){
            errorcheck = "YES";
        }
        if((textProject == "")||(description == "")||(textSkill == "")||(textBudget == "")||(textDate == "")||(selectCategories == "")||(errorcheck != "")){
            status.innerHTML = "Forms In Red Has Issues";
            return false;
        }else{
            return true;
        }
    }
    function ValPost(){
        _("Sub").style.disabled = true;
        var val = Validation();
        if(val == true){
            //alert("Here");
            Post();
        }else{
            _("Sub").style.disabled = false;
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
        var textProject = _("textProject").value;
        var description = _("description").value;
        var textSkill = _("textSkill").value;
        var textBudget = _("textBudget").value;
        var textDate = _("textDate").value;
        var selectCategories = _("selectCategories").value;
        var selectPayment = _("selectPayment").value;
        var status = _("status");
        
        var ajax = ajaxObj("POST", "page-post-a-project.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText.trim().toUpperCase() == "POSTED_SUCCESS"){
                    window.location = "index.php";
                } else {
                    status.innerHTML = "Posted unsuccessful, "+ajax.responseText;
                }
            }
        }
        ajax.send("Pro="+textProject+"&Des="+description+"&Skl="+textSkill+"&Bug="+textBudget+"&Dat="+textDate+"&Cat="+selectCategories+"&Pay="+selectPayment);
    }
</script>
<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <a href="../Sprayers/Root/bank.php"></a>
                    <div class="post-a-project">
                        <h1 class="title_block"><span>Post</span> a project</h1>
                        <a href="freelancer.php"></a>
                        <div class="box clearfix">
                            <div class="box-content">
                                <p id="status" style="color: #f00;"></p>
                                <form id="postjob-form" action="#" onsubmit="return false;" class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-step" id="divselectCategories">
                                            <label>What type of work do you require?</label>
                                            <?php 
                                                include_once("Form_Codes.php"); 
                                                echo $selectCategories;
                                            ?>
                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>What is your project about?</label>
                                            <input onkeyup="restrict('textProject')" class="form-control" type="text" id="textProject" name="textProject" placeholder="Eg: Design a website">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Description your project</label>
                                            <textarea class="form-control" rows="10" id="description" name="description" placeholder="Type something about your project..."></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Skill Required</label>
                                            <input onkeyup="restrict('textSkill');fetch_skill()" class="form-control" type="text" id="textSkill" name="textSkill" placeholder="Eg: UI/UX Design...">
                                        </div>
                                        <div id="FetchSkill" >
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-step">
                                            <label>Budget</label>
                                            <input class="form-control" type="text" id="textBudget" name="textBudget" placeholder="Eg: 229.00">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Exp Date</label>
                                            <input class="form-control" type="text" id="textDate" name="textDate" placeholder="Eg: 2018-07-31">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-step">
                                            <label>Payment Method</label>
                                            <?php  
                                                echo $selectPayment;
                                            ?>
                                        </div>
                                    </div>
                                    <!--<div class="choose-plan">
                                        <h4 class="title_block">Choose the pricing plan that fits your needs</h4>
                                        <fieldset>
                                            <div class="checkbox">
                                                <input type="checkbox" name="chkbxFeatured" value="">
                                                <p class="plan-headding"><span>Featured</span>   -   $50.00<p>
                                                <p>Your job will be displayed as normal for 30 days and always in 1st page</p>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="chkbxStandard" value="">
                                                <p class="plan-headding"><span>Standard</span>   -   30.00<p>
                                                <p>Your job will be displayed as normal for 20 days and always in 1st page</p>
                                            </div>
                                            <div class="checkbox">
                                               <input type="checkbox" name="chkbxFree" value="">
                                                <p class="plan-headding"><span>Free</span>   -   0.00<p>
                                                <p>Your job will be displayed as normal for 5 days</p>
                                            </div>
                                        </fieldset>
                                    </div>-->
                                    <div class="form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-left">
                                           <p>By clicking 'Post Project', you are indicating that you have read and agree to the <a href="#" title="Terms & Conditions">Terms & Conditions</a> and <a href="#" title="Privacy Policy">Privacy Policy</a></p>
                                        </div> 
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                                            <button type="submit" id ="Sub" onclick="ValPost()" class="btn button btn-primary btn-shadown">Submit your message</button>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- end post-a-project -->
                </div><!-- end container -->
            </div><!-- end warpper -->
            <div class="bg-bottom"></div>
        </div><!--end warp-->

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
<script>
/*$(document).ready(function(){
    $('#textSkill').keyup(function(){
        var txt = $(this).val();
        if(txt != ''){
            $.ajax({
            url:"fetchSkill.php",
            method:"post",
            data:{search:txt},
            dataType:"text",
            success:function(data)
            {
                $('#FetchSkill').html(data);
            }
            });
        }else{
            $('#FetchSkill').html('');			
        }
    });
});*/
</script>