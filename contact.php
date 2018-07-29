<?php $actlink = basename(__FILE__);
      $title = "Contact Page";
  include_once("freelancerheader.php"); ?>
<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="contact-us">
                        <h1 class="title_block"><span>Contact</span> us</h1>
                        <div id="contact-map" class="clearfix">
                            <div id="map"></div><!-- end map -->
                            <div class="hidden-lg hidden-md hidden-sm hidden-xs contact-address">No one victorial road iwaya yaba lagos Nigeria</div>
                        </div><!-- end contact-map -->
                        <div class="contact-form clearfix">
                            <form action="#" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="name" name="name" placeholder="Name*"/>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="email" id="email" name="email" placeholder="Email*"/>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <input type="email" id="phone" name="phone" placeholder="Phone*"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea id="message" name="message" placeholder="enter your message*"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 text-right">
                                        <span class="reset">Reset All Field</span>
                                       <button type="submit" class="btn button btn-default btn-shadown">Submit your message</button>
                                    </div> 
                                </div>
                            </form>
                        </div><!-- end contac-form -->
                    </div><!-- end contact-us -->
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
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyBd1UJcqm8K9sZ4p9xloWUHSzsFaovKxuM"></script>
    <script src="js/custom.js"></script>

    <script src="js/tmpl.js"></script>
    <script src="js/jquery.dependClass-0.1.js"></script>
    <script src="js/draggable-0.1.js"></script>
    <script src="js/jquery.slider.js"></script>
</body>
</html>