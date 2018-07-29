<?php $actlink = basename(__FILE__);
      $title = "Home Page";
  include_once("freelancerheader.php"); ?>
<?php
    $sql = "select count(1) from Proposal";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $ProjectCnt = $row[0];
?>

        <div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <!--<div class="container" style="margin-top:0;position:absolute;top:5px">-->
                <div class="container" >
				<div class="row">
                    <div id="block-search" class="block-search">
                        <h1>Wow! We have <span><?php echo $ProjectCnt?>+</span> Jobs for you</h1>
                        <!--<p><a href="#">Subscribe</a> and receive at least 10 jobs each day from us</p>-->
                        <form id="searchbox" action="#" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
                                    <input type="text" class="form-control" id="inputKeywords" placeholder="Keywords...">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
                                    <?php 
                                        include_once("Form_Codes.php"); 
                                        echo $selectCategories;
                                        echo '</div>
                                              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">';
                                        echo $selectLOCATION;
                                    ?>
                                    
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12 fr-search">
                                    <button type="submit" class="btn btn-primary">Search now</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- end #search_block_top -->
                </div> <!-- end Row -->
				<div class="row">
				<div id="block-search" class="block-search">
					<h1>Work with someone perfect for your team<span></span></h1>
					<p>
					<div class="col-md-2">
						<div class="box box-default">
							<img class="profile-user-img img-responsive img-thumbnail Img-center" src="img/Find/text.png" alt="User profile picture">
							<p class="text-center">
							Graphic Designs</br>&nbsp;</p>
						</div>
					</div>
					<div class="col-md-2">
						<div class="box box-default">
							<img class="profile-user-img img-responsive img-thumbnail Img-center" src="img/Find/monitor.png" alt="User profile picture">
							<p class="text-center">
							Digital Marketing</p>
						</div>
					</div>
					<div class="col-md-2">
						<div class="box box-default">
							<img class="profile-user-img img-responsive img-thumbnail Img-center" src="img/Find/computer.png" alt="User profile picture">
							<p class="text-center">
							Web Service providers</p>
						</div>
					</div>
					<div class="col-md-2">
						<div class="box box-default">
							<img class="profile-user-img img-responsive img-thumbnail Img-center" src="img/Find/video-editing.png" alt="User profile picture">
							<p class="text-center">
							Video editors</br>&nbsp;</p>
						</div>
					</div>
					<div class="col-md-2">
						<div class="box box-default">
							<img class="profile-user-img img-responsive img-thumbnail Img-center" src="img/Find/html.png" alt="User profile picture">
							<p class="text-center">
							Programmers</br>&nbsp;</p> 
						</div>
					</div>
					<div class="col-md-2">
						<div class="box box-default">
							<img class="profile-user-img img-responsive img-thumbnail Img-center" src="img/Find/school-material.png" alt="User profile picture">
							<p class="text-center">
							Writers</br>&nbsp;</p>
						</div>
					</div>
					
					</p>
				</div>
				</div>
				<div class="row">
				<div id="block-search" class="block-search">
					<h1>How it works<span></span></h1>
					<div class="row">
					<p>
                                        <div class="col-md-12">
					<h4> Option 1</h4>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/browsers.png" alt="User profile picture">
						<p>Find</p>
						Find a job that your carpable of doing.
						<!--Find a job to tell us about your project. We'll quickly match you with the right freelancers.-->
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/curriculum.png" alt="User profile picture">
						<p>Bid/Proporsal</p>
						Place your bid and submit your proporsal for the job 
						you found, then wait for the owner of the job to award you the job.
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/attach.png" alt="User profile picture">
						<p>Submit Job</p>
						Submit your job and wait for 7 working days to be paid after the owner confirm your job.
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/get-money.png" alt="User profile picture">
						<p>Get Paid</p>
						You got paid. Share your friend/family your testimony.
					</div>
                                        </div>
					</p>
					</div>
					<div class="row">
					<p>
                                        <div class="col-md-12">
					<h4> Option 2</h4>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/wikipedia.png" alt="User profile picture">
						<p>Post Job</p>
						Post a job, tell us about how you want your project to be. 
						We'll quickly match you with the right freelancers 
						that will place thier bids to you.
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/list.png" alt="User profile picture">
						<p>Award</p>
						Award the best freelancer's that you think that they can handle the job for you
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/money.png" alt="User profile picture">
						<p>Pay</p>
						Make Your payment and wait for the freelancer to complete the job for you
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/deal.png" alt="User profile picture">
						<p>Complete Job</p>
						Comfirm the job done by the freelancer.
					</div>
                                        </div>
					</p>
					</div>
					<div class="row">
					<p>
                                        <div class="col-md-12">
					<h4> Option 3</h4>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/student.png" alt="User profile picture">
						<p>Protfolio</p>
						Submit your protfolio as a freelancer.
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/ebook.png" alt="User profile picture">
						<p>Share</p>
						Share your protfolio to your friends,family, groups, pages, foroum and many more on social media's.
					</div>
					<div class="col-md-3">
						<img class="Img-center" src="img/Find/touchscreen.png" alt="User profile picture">
						<p>You Won Job</p>
						You got money jobs from them
					</div>
                                        </div>
					</p>
					</div>
				</div>
				</div>
            </div><!-- end container -->
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