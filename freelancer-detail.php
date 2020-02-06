<?php
include_once("php_codes/check_login_status.php");
?>
<?php

if(isset($_GET["user"])){
    $user = preg_replace('#[^a-z0-9]#i', '', $_GET["user"]);
    
    $sql = "select count(1)
             from USER_CREDS where username = '$user' limit 1";
    $query = mysqli_query($db_conx, $sql); 
    $row = mysqli_fetch_row($query);
    $UserCheck = $row[0];
    
    if($UserCheck == 0){
        header("location: freelancer.php");
        exit();
    }
    
    $sql = "select count(1)
             from USER_CREDS where username = '$user' and del_flg = 'Y' limit 1";
    $query = mysqli_query($db_conx, $sql); 
    $row = mysqli_fetch_row($query);
    $UserCheck = $row[0];
    
    if($UserCheck > 0){
        header("location: freelancer.php");
        exit();
    }
    
    //Get the number of projects bids by the username
    $sql = "select count(1) from Proposal where 
            freelancer_id = '$user' and del_flg = 'N' limit 1";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $FreTotalBids = $row[0];
    
    //Get the user names of the user posted the project
    $sql = "select first_name, last_name from USER_CREDS where 
            username = '$user' and del_flg = 'N' limit 1";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $FreFirstName = $row[0];
    $FreLastName = $row[1];
    
    $sql = "select overview description from Freelancer where user_account_id = '$user'";
    $query1 = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query1);
    $FreDesc = $row[0];
    
}else{
    header("location: freelancer.php");
    exit();
}
?>
<?php $actlink = basename(__FILE__);
      $title = $user."'s profile";
  include_once("freelancerheader.php"); ?>

<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="freelance-detail">
                        <div class="freelance-detail-tab box">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#about-me" aria-controls="about-me" role="tab" data-toggle="tab">About me</a></li>
                                <li role="presentation"><a href="#protfolio" aria-controls="protfolio" role="tab" data-toggle="tab">Protfolio</a></li>
                                <li role="presentation"><a href="#my-skills" aria-controls="my-skills" role="tab" data-toggle="tab">My skills</a></li>
                                <li role="presentation"><a href="#hire-me" aria-controls="hire-me" role="tab" data-toggle="tab">Hire me</a></li>
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
                                                <h2><?php echo $FreFirstName .' '.$FreLastName;?></h2>
                                                <h4 class="position-profile">Dribble team</h4>
                                            </div>
                                        </div>
                                        <div class="des">
                                            <p class="pdropcap"><?php echo $FreDesc;?></p>
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
                                <div role="tabpanel" class="tab-pane" id="my-skills">
                                    <div class="tabbox-content">
                                        <div class="des">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sp-12">
                                                    <div class="my-progress">
                                                        <h4>My skills</h4>
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
                        © 2016 Freelancer. Designed with <i class="fa fa-heart"></i> and <i class="fa fa-coffee"></i>
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
    </div>
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