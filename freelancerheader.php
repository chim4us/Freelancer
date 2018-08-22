<?php
///Included php class code to use
include("Class/Accounts.php");
include("Class/System_control.php");
//check if the user has login also the page is login or register php page 
if((trim($actlink) != "register.php")&&(trim($actlink) != "login.php")&&(trim($actlink) != "page-post-a-project.php") &&( trim($actlink) !="recruitment-detail.php")&&( trim($actlink) != "recruitment-profile.php")){
    include_once("php_codes/check_login_status.php");
}
if((trim($actlink) == "register.php")||(trim($actlink) == "login.php")){
    if($user_ok == true){
        header("location: index.php");
        exit();
    }
}

//get user credientials if the user is logon
if($user_ok == true){
    $sql = "select first_name, last_name from USER_CREDS where username = '$log_username' limit 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $FirstName = $row[0];
    $LastName = $row[1];
    $username = $row[1];
}
?>
<?php 
//get the current page URL
$_SESSION['PGurl'] = $_SERVER['REQUEST_URI']; 
?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
   <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <!--<title>Freelancer Responsive HTML Template</title>-->

    <meta name="keywords" content="Responsive HTML Template">
    <meta name="description" content="Freelancer Responsive HTML Template">
    <meta name="author" content="tivatheme">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- Load google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700%7CDroid+Serif" rel="stylesheet">
    
    <!-- Vendor css --> 
    <link rel="stylesheet" href="css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/jquery.fullPage.css" />
    <link rel="stylesheet" href="css/jslider.css" />

    <!-- Main style -->
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/Edit_css" />
    <style>
    p {
        line-height: 100%;
        line-height: 1.57143;
        font-size: 14px;
    }
    .img-thumbnail{
        box-shadow: none;
    }
</style>
<style>
    #columns {
        line-height: 100%;
    }
    .dropdown1 {
        position: relative;
        display: inline-block;
    }
    /*.dropdown-content {
        width: 500%!important;
        
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 500%;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    
    
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        -ms-border-radius: 0px;
        -o-border-radius: 0px;
        border-radius: 0px;
        
        text-align: left;
        -webkit-box-shadow: 0 6px 20px rgba(0, 0, 0, 0.175);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.175);
    }*/
    .dropdown-content {
        display: none;
        position: absolute;
        background: white;
        background-color: #ffffff;
        width: 510% !important;
        top: 100%;
        margin: 0;
        border: none;
        overflow: auto;
        left: -25%;
        text-align: left;
        
        
    }
    .dropdown1 {
        cursor: pointer;
    }
    .dropdown1 a:hover {background-color: #f1f1f1}
    .show {display:block;}
</style>

</head>
<?php if(trim($actlink) == "index.php") { ?>
<body id="index" class="index">
<?php } else {?>
<body class="page">
<?php } ?>
    <div id="all">
        <!-- header -->
        <header id="top-header" class="clearfix">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-sp-12">
                    <div class="logo">
                        <a href="index.php" title="Freelancer">
                            <img class="img-responsive" src="img/logo.png" alt="">
                        </a>
                    </div><!--end logo-->
                </div>
                <div class="col-lg-7 col-md-2 col-sm-2 col-xs-1 col-sp-2">
                    <span id="btn-menu"><i class="fa fa-bars"></i></span>
                    <nav id="main-nav">
                        <ul class="nav navbar-nav megamenu">
                            <?php if(trim($actlink) == "freelancer.php") { ?>
                            <li class="active">
                            <?php } else{ ?>
                            <li>
                            <?php } ?>
                                <a href='freelancer.php'>Freelancer</a>
                            </li>
                            <?php if(trim($actlink) == "recruitment.php") { ?>
                            <li class="active">
                            <?php } else{ ?>
                            <li>
                            <?php } ?>
                            <a href='recruitment.php'>Recruitment</a></li>
                            <!--<li><a href='page-blog-full-width.html'>Academy</a></li>-->
                            <li class="dropdown">
                            <?php if((trim($actlink) == "blog.php")||(trim($actlink) == "academy.php")) { ?>
                            <li class="active dropdown">
                            <?php } else{ ?>
                            <li class="dropdown">
                            <?php } ?>
                                <a href='#'>Community</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a href='academy.php'>Academy</a></li>
                                        <li><a href='blog.php'>Blog</a></li>
                                    </ul>
                                </div>
                            </li>
                            <?php if(trim($actlink) == "support.php") { ?>
                            <li class="active">
                            <?php } else{ ?>
                            <li>
                            <?php } ?>
                            <a href='support.php'>Support</a></li>
                            <?php if(trim($actlink) == "contact.php") { ?>
                            <li class="active">
                            <?php } else{ ?>
                            <li>
                            <?php } ?>
                            <a href='contact.php'>Contact</a></li>
                            <?php if(trim($actlink) == "about.php") { ?>
                            <li class="active">
                            <?php } else{ ?>
                            <li>
                            <?php } ?>
                            <a href='about.php'>About</a></li>
                        </ul>
                    </nav><!-- end main-nav -->
                </div>
                <div class="col-lg-3 col-md-8 col-sm-7 col-xs-7 col-sp-10">
                    <div class="header_user_info pull-right">
                        <ul class="links">
                            <?php if($user_ok == true){ ?>
                            <li class="first">
                                <!--<a class="btn btn-default" href="page-post-a-project.php" title="Post a Project">Post a Project</a>-->
                                <a class="btn btn-default" href="page-post-a-project.php" title="Post a Project">Post a Project</a>
                            </li>
                            <li>
                                <div class="dropdown1">
                                <a onclick="myFunction()">
                                    <img class="profile-user-img img-responsive img-thumbnail Img-center" style="box-shadow: none; border: 0;"src="img/Find/User.png" alt="User profile picture">
                                </a>
                                <div id="myDropdown" class="dropdown-content">
                                    <?php echo $FirstName.' '.$LastName;?>
                                    <hr>
                                    <?php //echo $bankdtrow;
                                    ?>
                                    
                                </div>
                                </div>
                            </li>
                            <li class="last">
                                <!--<a class="register" href="LogOut.php" title="LogOut"><i class="fa fa-sign-out"></i><span>Log Out</span></a>-->
                                <a class="register" href="LogOut.php" title="LogOut"><i class="fa fa-sign-out"></i><span></span></a>
                            </li>
                            <?php }else{ ?>
                            <li>
                                <a class="login" href="login.php" title="Login to your account">
                                    <!--<i class="fa fa-unlock-alt"></i>-->
                                    <i class="fa fa-sign-in"></i>
                                    
                                    <span>Login</span></a>
                            </li>
                            <li class="last">
                                <a class="register" href="register.php" title="Register"><i class="fa fa-key"></i><span>Register</span></a>
                            </li>
                            <?php } ?>
                        </ul>
                        
                    </div><!-- end header_user_info -->
                </div>
            </div>
        </header>
        
    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
    </script>