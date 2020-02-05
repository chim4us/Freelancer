<?php $actlink = basename(__FILE__);
      $title = "Freelancer Page";
  include_once("freelancerheader.php"); ?>
<?php 
    function trim_text($text, $count){ 
        $text = str_replace("  ", " ", $text); 
        $string = explode(" ", $text); 
        $trimed = "";
        //echo strlen($text);
        //echo str_word_count($text,0);
        //if(str_word_count($text,0) >= $count){
        if( str_word_count($text,0) > $count){
        for ( $wordCounter = 0; $wordCounter <= $count; $wordCounter++ ) { 
            $trimed .= $string[$wordCounter]; 
            if ( $wordCounter < $count ){
                $trimed .= " "; 
            } 
            else { $trimed .= "..."; } 
        } 
        $trimed = trim($trimed); 
        return $trimed;
        }else{
            return $text;
        }
    }
    /*$sql = "SELECT username, skill_id,title, message, skill, rank_cnt
             FROM USER_SKILL WHERE del_flg = 'N'";*/
    $sql = "";
    $sql = "SELECT hire_manager_id,title, description, main_skill_id,categorie_id
             FROM Job WHERE del_flg = 'N'";
    if($user_ok == true){
        $sql .= " and username != '$log_username' ";
    }
    $query = mysqli_query($db_conx, $sql); 
    $b_check = mysqli_num_rows($query);
    if ($b_check == 0){ 
        $FreelancerRow ='No Record Fetched';
    } else{
        $count =0;
        $FreelancerRow = '';
        
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $User_name = $row["hire_manager_id"];
            $Skill_id = $row["main_skill_id"];
            $Title = $row["title"];
            $Message = $row["description"];
            $Message = trim_text($Message, "100");
            $skill = $row["skill"];
            $Rank_Cnt = $row["rank_cnt"];
            
            $sql = "select first_name,last_name from USER_CREDS
            where username = '$User_name' limit 1";
            $query1 = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query1);
            $user_FName = $row[0];
            $user_LName = $row[1];
            
            $FreelancerRow .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
            $FreelancerRow .= '<div class="job-freelanceritem">';
            $FreelancerRow .= '<a class="projectjob-title" href="#" title="">';
            $FreelancerRow .= '<img class="img-responsive" src="img/default/avatar/avatar4.jpg" alt="">';
            $FreelancerRow .= '</a>';
            $FreelancerRow .= '<div class="project-content">';
            $FreelancerRow .= '<div class="author"><a href="page-freelancer-detail.html" title="">'.$user_FName.' '.$user_LName.'</a> - <span>'.$Title.'</span></div>';
            $FreelancerRow .= '<div class="vote-ratting clearfix">';
            $FreelancerRow .= '<span class="star_content">';
            
            $FreelancerRow .= '<span class="star star_on"></span>';
            $FreelancerRow .= '<span class="star star_on"></span>';
            $FreelancerRow .= '<span class="star star_on"></span>';
            $FreelancerRow .= '<span class="star star_on"></span>';
            $FreelancerRow .= '<span class="star star"></span>';
            
            $FreelancerRow .= '</span>';
            $FreelancerRow .= '</div>';
            $FreelancerRow .= '<div class="desc">';
            $FreelancerRow .= '<p>'.$Message.'</p>';
            $FreelancerRow .= '</div>';
            $FreelancerRow .= '<ul class="list-inline clearfix">';
            
            $skilllen = str_word_count($skill,0);
            $skill = str_replace(";", " ", $skill);
            $string = explode(" ", $skill);
            for ( $Counter = 0; $Counter < $skilllen - 1; $Counter++ ) {
                $FreelancerRow .= '<li><a href="#" title="'.$string[$Counter].'">'.$string[$Counter].'</a></li>';
            }
            $FreelancerRow .= '</ul>';
            $FreelancerRow .= '</div>';
            $FreelancerRow .= '</div>';
            $FreelancerRow .= '</div>';
            
        }
    }
?>
        <div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="job-freelancer">
                        <div class="row">
                            <?php echo $FreelancerRow;?>
                            
                            <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="job-freelanceritem">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                <li><a href="#">&laquo;</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">&raquo;</a></li>
                                </ul>
                                </div>
                            </div>-->
                        </div>
                        <div class="job-loadprofile text-center">
                            <a class="btn btn-default" href="#" title="load more profiles">load more profiles</a>
                        </div>
                    </div><!-- end job-freelancer -->
                </div> <!-- end container -->
            </div><!-- end warpper -->
            <div class="bg-bottom"></div>
        </div><!--end columns-->

        <?php include_once("Searchcontent.php"); ?>
        </div><!-- end job-searchform -->
        <div class="job-advancedsearch">
            <a href="#"><i class="fa fa-search"></i><span>Advanced search</span></a>
        </div><!-- end job-advancedsearch -->

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