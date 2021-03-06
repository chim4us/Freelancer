
<?php
include_once("php_codes/check_login_status.php");
/*if($user_ok == false){
    header("location: index.php");
    exit();
}*/
?>
<?php 
if(isset($_GET["job_id"])){
    $JobID = preg_replace('#[^0-9]#i', '', $_GET['job_id']);
    //Check if the Job id is on our table.
    $sql = "select count(1) from Job where id = '$JobID' limit 1";
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
    
    $sql = "select b.company_name,b.company_location from Hire_Manager a, company_client b where
            a.user_account_i = (select hire_manager_id from job where id = '$JobID') and b.id = a.company_id and a.del_flg != 'Y' 
            and b.del_flg != 'Y' limit 1";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $ComName = $row[0];
    $ComLoc = $row[1];
    
    $sql = "select title,DATE_FORMAT(exp_date,'%a %D %b %Y : %H:%i:%s') ExpDate,FORMAT(payment_amount, 2) amt,
            description,main_skill_id,id
             from Job 
            where del_flg = 'N' and id = '$JobID' limit 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $JobTitle = $row[0];
    $JobExpDate = $row[1];
    $JobAmt = $row[2];
    $JobDesc = $row[3];
    $Skill_id = $row[4];
    $id  = $row[5];
    
    $sql = "select skill_name from Skill
    where id = '$Skill_id' limit 1";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $skill_det = $row[0];
    $skill_ft = '<li><a href="#" title="'.$skill_det.'">'.$skill_det.'</a></li>';
    
    $sql = "select count(1) from Other_Skills where job_id = '$id'";
    $query = mysqli_query($db_conx, $sql); 
    $row = mysqli_fetch_row($query);
    $ProCheck = $row[0];
    if($ProCheck > 0){
        $sql = "select b.skill_name from Other_Skills a, Skill b where a.job_id = '$id'
                and a.skill_id = b.id";
        $query = mysqli_query($db_conx, $sql);
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $skill_det = $row["skill_name"];
            $skill_ft .= '<li><a href="#" title="'.$skill_det.'">'.$skill_det.'</a></li>';
        }
    }
    
    $bidding_item = "";
    $sql = "select count(1) from Proposal where job_id = '$id' and del_flg = 'N'";
    $query = mysqli_query($db_conx, $sql); 
    $row = mysqli_fetch_row($query);
    $JobBid = $row[0];
    if($JobBid > 0){
        $sql = "select a.first_name, b.freelancer_comment, a.username, b.id from Proposal b, USER_CREDS a
                where  b.freelancer_id = a.username and b.job_id = '$id' and b.del_flg = 'N' ";
        $query = mysqli_query($db_conx, $sql);
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $Fname = $row["first_name"];
            $Fmessage = $row["freelancer_comment"];
            $Fusername = $row["username"];
            $Fid = $row["id"];
            
            $cnt = 0;
            $fskill = '';
            $sql = "select skill_name from Has_Skill a, Skill b where a.freelancer = '$Fusername' and a.del_flg = 'N'
                     and a.skill_id = b.id and b.del_flg = 'N'";
            $query1 = mysqli_query($db_conx, $sql);
            while($row = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
                if($cnt != 0){
                    $fskill .= ' ,';
                }
                $cnt += 1;
                $fskill .= $row["skill_name"];
            }
            
            $bidding_item .= '<div class="bidding-item">
                              <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 col-sp-12">
                            <div class="media">
                            <div class="pull-left">
                            <img src="img/default/avatar/avatar1.jpg" alt="">
                            </div>
                            <div class="media-body">
                            <span class="name-profile">'.$Fname.'</span><br>
                            <span class="position-profile">'.$fskill.'</span>
                            </div>
                            </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 col-sp-12">
                            <div class="bidding-des">
                            <p>'.$Fmessage.'</p>
                            </div>
                            </div>
                            </div>
                            </div>';
        }
    }else{
        $bidding_item = '<div class="bidding-item">
                            <div class="row">
                            <div class="col-lg-2 col-md-8 col-sm-2 col-xs-5 col-sp-12">
                            No Bid
                            </div>
                            </div>
                            </div>';
    }
}else{
    header("location: recruitment.php");
    exit();
}
?>
<?php $actlink = basename(__FILE__);
      $title = $ComName."'s Team Project Page";
  include_once("freelancerheader.php"); ?>

<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="job-detail">
                        <div class="job-detailtop clearfix">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 col-sp-3">
                                    <div class="job-avatarprofile">
                                        <img class="img-responsive" src="img/default/avatar/avatar-profile.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-9 col-sp-9">
                                    <div class="job-meta">
                                        <h1><?php echo $JobTitle; ?></h1>
                                        <ul class="list-inline">
                                            <li><i class="fa fa-briefcase"></i><?php echo $ComName;?>'s Team</li>
                                            <li><i class="fa fa-clock-o"></i>EXP Date: <?php echo $JobExpDate;?></li>
                                            <li><i class="fa fa-paperclip"></i>Budget: <span class="salary"> &#x20A6; <?php echo $JobAmt;?></span></li>
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
                                        <div class="job-extra-info">
                                            <div class="job-info-lf">
                                                <a class="btn btn-default" href="#" title="Bidding this job">Bidding this job</a>
                                                <a class="btn btn-save" href="#" title="Save this job">Save this job</a>
                                            </div>
                                            <div class="social_share social_block">
                                                <ul class="links">
                                                    <li><a href="#" title="Facebook"><em class="fa fa-facebook"></em><span class="unvisible">facebook</span> </a></li>
                                                    <li><a href="#" title="Twitter"><em class="fa fa-twitter"></em><span class="unvisible">Twitter</span> </a></li>
                                                    <li><a href="#" title="Google"><em class="fa fa-google-plus"></em><span class="unvisible">Google</span> </a></li>
                                                    <li><a href="#" title="Print"><em class="fa fa-print"></em><span class="unvisible">Print</span> </a></li>
                                                    <li><a href="#" title="E-mail"><em class="fa fa-envelope"></em><span class="unvisible">E-mail</span> </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="job-descrip">
                                            <p><?php echo $JobDesc; ?></p>
                                        </div>
                                        <div class="job-tag">
                                            <strong>skill requires</strong>
                                            <ul class="list-inline">
                                                <?php echo $skill_ft; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-other clearfix">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-sp-12">
                                    <div class="tab-info">
                                        <div class="row tab-info-title">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5"><span>Freelancer bidding (<?php echo $JobBid;?>)</span></div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7"><span class="short-pre">Short preview</span></div>
                                        </div>
                                        <div class="tab-info-content box">
                                            <div class="bidding-list">
                                                <?php echo $bidding_item;?>
                                                
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
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><span>about dribbble team</span></div>
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
                                                                    <span class="star star"></span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <a class="link-discover" href="page-recruitment-profile.html" title="Discover more">Discover more <i class="fa fa-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end detail-other -->
                    </div><!-- end job-detail -->
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
            <a href="" ><i class="fa fa-chevron-up"></i></a>    
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