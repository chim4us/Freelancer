<?php
include_once("php_codes/check_login_status.php");
?>
<?php 
    
if(isset($_GET["job_id"])){
    $JobID = preg_replace('#[^0-9]#i', '', $_GET['job_id']);
    
    $sql = "select count(1)
             from Job where id = '$JobID' limit 1";
    $query = mysqli_query($db_conx, $sql); 
    $row = mysqli_fetch_row($query);
    $JobCheck = $row[0];
    
    if($JobCheck == 0){
        header("location: recruitment.php");
        exit();
    }
    
    $sql = "select count(1) from Job where id = '$JobID' and del_flg = 'Y' limit 1";
    $query = mysqli_query($db_conx, $sql); 
    $row = mysqli_fetch_row($query);
    $JobCheck = $row[0];
    if($JobCheck > 0){
        header("location: recruitment.php?Msg=Job Deleted");
        exit();
    }
    
    $sql = "select count(1) from job where 
            hire_manager_id = (select hire_manager_id from Job where id = '$JobID') and del_flg = 'N' limit 1";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $ComTotalpro = $row[0];
    
    $sql = "select FORMAT(sum(payment_amount), 2) payment_amount, count(1) from Contract where company_id = 
             (select hire_manager_id from job where id = '$JobID') limit 1";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $ComTotalAmt = $row[0];
    $ComTotalHire = $row[1];
    
    $sql = "select hire_manager_id,DATE_FORMAT(exp_date,'%a %D %b %Y') ExpDate from job where id = '$JobID'";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $JobExpDate = $row[1];
    $ManagerId = $row[0];
    
    $sql = "select id,hire_manager_id username,main_skill_id,title,description, DATE_FORMAT(lgch_date,'%a %D %b %Y : %H:%i:%s') PstdDate,
            FORMAT(payment_amount, 2) amt from Job 
            where del_flg = 'N'";
    if($user_ok == true){
        $sql .= " and hire_manager_id != '$log_username' ";
    }
    $query = mysqli_query($db_conx, $sql); 
    $b_check = mysqli_num_rows($query);
    if ($b_check == 0){ 
        $JobRow ='No Record Fetched';
    } else{
        $count =0;
        $JobRow = '';
        
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $User_name = $row["username"];
            $id = $row["id"];
            $Skill_id = $row["main_skill_id"];
            $Title = $row["title"];
            $Message = $row["description"];
            $PstdDate = $row["PstdDate"];
            $amt = $row["amt"];
            $Message = trim_text($Message, "100");
            //$skill = $row["skill"];
            //$Rank_Cnt = $row["rank_cnt"];
            
            $sql = "select first_name,last_name from USER_CREDS
            where username = '$User_name' limit 1";
            $query1 = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query1);
            $user_FName = $row[0];
            $user_LName = $row[1];
            
            $sql = "select skill_name from Skill
            where id = '$Skill_id' limit 1";
            $query1 = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query1);
            $skill_det = $row[0];
            $skill_ft = '<li><a href="#" title="'.$skill_det.'">'.$skill_det.'</a></li>';
            
            
            $sql = "select count(1) from Other_Skills where job_id = '$id'";
            $query1 = mysqli_query($db_conx, $sql); 
            $row = mysqli_fetch_row($query1);
            $ProCheck = $row[0];
            if($ProCheck > 0){
                $sql = "select b.skill_name from Other_Skills a, Skill b where a.job_id = '$id'
                        and a.skill_id = b.id";
                $query1 = mysqli_query($db_conx, $sql);
                while($row = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
                    $skill_det = $row["skill_name"];
                    $skill_ft .= '<li><a href="#" title="'.$skill_det.'">'.$skill_det.'</a></li>';
                }
            }
            
             $sql = "select b.company_name,b.company_location from Hire_Manager a, company_client b where
                        a.user_account_i = '$log_username' and b.id = a.company_id and a.del_flg != 'Y' 
                        and b.del_flg != 'Y' limit 1";
            $query1 = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query1);
            $ComName = $row[0];
            $ComLoc = $row[1];
            
            
            $JobRow .= '<div class="job-item">';
            $JobRow .= '<div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 col-sp-12">
                        <div class="job-avatar"><img class="img-responsive" src="img/default/logo-company/logo1.png" alt=""></div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-sp-12">';
            $JobRow .= '<div class="extra-info job-name"><a href="recruitment-detail.php?job_id='.$id.'" title="'.$Title.'">'.$Title.'</a></div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                        <div class="extra-info job-company">'.$ComName.'</div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                        <div class="extra-info job-location"><i class="fa fa-map-marker"></i>'.$ComLoc.'</div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                        <div class="extra-info job-posted"><i class="fa fa-clock-o"></i>'.$PstdDate.'</div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                        <div class="extra-info job-salary"><i class="fa fa-paperclip"></i> &#x20A6; '.$amt.'</div>
                        </div>
                        </div>
                        </div>';
        }
    
    }
    
}else{
    header("location: recruitment.php");
    exit();
}?>
<?php $actlink = basename(__FILE__);
      $title = "Dribble Team Project Page";
  include_once("freelancerheader.php"); ?>

<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="job-detail job-recruitment-profile">
                        <div class="job-detailtop clearfix">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 col-sp-3">
                                    <div class="job-avatarprofile">
                                        <img class="img-responsive" src="img/default/avatar/avatar-profile.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-9 col-sp-9">
                                    <div class="job-meta">
                                        <h1>ui/ux designer</h1>
                                        <ul class="list-inline">
                                            <!--<li><i class="fa fa-clock-o"></i>EXP Date: May 25th 2016</li>$JobExpDate-->
                                            <li><i class="fa fa-clock-o"></i>EXP Date: <?php echo $JobExpDate; ?></li>
                                            <li><i class="fa fa-briefcase"></i>Project Posted: <?php echo $ComTotalpro;?></li>
                                            <li><i class="fa fa-chain"></i>Total Spent: <span class="salary">&#x20A6;<?php echo $ComTotalAmt; ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end job-detailtop -->
                        <div class="job-detailbottom clearfix">
                            <div class="row job-margintop">
                                <div class="col-lg-1 col-md-1 hidden-sm hidden-xs"></div>
                                <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12 col-sp-12">
                                    <div class="box clearfix">
                                        <div class="job-descrip">
                                            <p>Lorem Khaled Ipsum is a major key to success. You smart, you loyal, you a genius. Stay focused. The key is to drink coconut, fresh coconut, trust me. It’s important to use cocoa butter. It’s the key to more success, why not live smooth? Why live rough? Cloth talk. Eliptical talk. Lion! Surround yourself with angels, positive energy, beautiful people, beautiful souls, clean heart, angel. Always remember in the jungle there’s a lot of they in there, after you overcome they, you will make it to paradise. They don’t want us to win. The first of the month is coming, we have to get money.</p>
                                            <p>You’ve got to work hard, to make history, simple, you’ve got to make it. In life you have to take the trash out, if you have trash in your life, take it out, throw it away, get rid of it, major key. In life there will be road blocks but we will over come it. Celebrate success right, the only way, apple. It’s on you how you want to live your life.</p>
                                        </div>
                                        <div class="job-tag">
                                            <strong>skill requires</strong>
                                            <ul class="list-inline">
                                                <li><a href="#" title="Photoshop">Photoshop</a></li>
                                                <li><a href="#" title="UI/UX">UI/UX</a></li>
                                                <li><a href="#" title="HTML5">HTML5</a></li>
                                                <li><a href="#" title="Illustrator">Illustrator</a></li>
                                                <li><a href="#" title="JavaScript">JavaScript</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-project">
                            <h4 class="title_block">Project posted (<?php echo $ComTotalpro;?>)</h4>
                            <div class="job-list" id="job-list">
                                <div class="job-listnormal">
                                    <?php echo $JobRow;?>
                                    <div class="job-item">
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 col-sp-12">
                                                <div class="job-avatar"><img class="img-responsive" src="img/default/logo-company/logo1.png" alt=""></div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-sp-12">
                                                <div class="extra-info job-name"><a href="page-recruitment-detail.html" title="Graphic designer for Dribble Project">Graphic designer for Dribble Project</a></div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-company">Dribble Co.</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-location"><i class="fa fa-map-marker"></i>Los Angeles</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-posted"><i class="fa fa-clock-o"></i>June 26th 2016</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-salary"><i class="fa fa-paperclip"></i>$1000</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="job-item">
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 col-sp-12">
                                                <div class="job-avatar"><img class="img-responsive" src="img/default/logo-company/logo2.png" alt=""></div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-sp-12">
                                                <div class="extra-info job-name"><a href="page-recruitment-detail.html" title="Android Developer for Free App">Android Developer for Free App</a></div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-company">Joomlart</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-location"><i class="fa fa-map-marker"></i>Los Angeles</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-posted"><i class="fa fa-clock-o"></i>Unlimitted</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-salary"><i class="fa fa-paperclip"></i>$600</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="job-item">
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 col-sp-12">
                                                <div class="job-avatar"><img class="img-responsive" src="img/default/logo-company/logo3.png" alt=""></div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col-sp-12">
                                                <div class="extra-info job-name"><a href="page-recruitment-detail.html" title="Android Developer for Free App">Online Marketting</a></div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-company">BraveBits</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-location"><i class="fa fa-map-marker"></i>Los Angeles</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-posted"><i class="fa fa-clock-o"></i>May 25th 2016</div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-sp-12">
                                                <div class="extra-info job-salary"><i class="fa fa-paperclip"></i>$300</div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end job-listnormal -->
                            </div><!-- end job-list -->
                        </div><!-- end post-project -->
                    </div><!-- end job-detail -->
                </div> <!-- end container -->
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