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
    $sql = "SELECT username, skill_id,title, message, skill, rank_cnt
             FROM USER_SKILL WHERE del_flg = 'N'";
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
            $User_name = $row["username"];
            $Skill_id = $row["skill_id"];
            $Title = $row["title"];
            $Message = $row["message"];
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
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar4.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">Chirstina Aguilera</a> - <span>Web Designer</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>Hello! I’m Christina Aguilera - Graphic Designer from USA. I’m always obsessed by the nice detail. I’m available to hire. Let feel free to contact me via...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Photoshop">Photoshop</a></li>
                                            <li><a href="#" title="Illustration">Illustration</a></li>
                                            <li><a href="#" title="UI/UX">UI/UX</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar5.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">David James</a> - <span>Front End Developer</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>Lorem Khaled Ipsum is a major key to success. The other day the grass was brown, now it’s green because I ain’t give up. Never surrender...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Graphic">Graphic</a></li>
                                            <li><a href="#" title="Marketting">Marketting</a></li>
                                            <li><a href="#" title="HTML5">HTML5</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar6.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">Redikiel</a> - <span>Design</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>The key is to enjoy life, because they don’t want you to enjoy life. I promise you, they don’t want you to jetski, they don’t want you to smile...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="HTML">HTML</a></li>
                                            <li><a href="#" title="Photoshop">Photoshop</a></li>
                                            <li><a href="#" title="Web design">Web design</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar7.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">Johnny Deph</a> - <span>Coppywriter</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>Special cloth alert. They will try to close the door on you, just open it. Let me be clear, you have to make it through the jungle to make it to paradise...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Seo">Seo</a></li>
                                            <li><a href="#" title="Marketting">Marketting</a></li>
                                            <li><a href="#" title="Web design">Web design</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar8.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">David Beckham</a> - <span>Backend Developer</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>The key is to enjoy life, because they don’t want you to enjoy life. I promise you, they don’t want you to jetski, they don’t want you to smile...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Graphic">Graphic</a></li>
                                            <li><a href="#" title="HTML">HTML</a></li>
                                            <li><a href="#" title="JavaScript">JavaScript</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar9.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">Jonathan Evans</a> - <span>UI/UX Designer</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>The key is to enjoy life, because they don’t want you to enjoy life. I promise you, they don’t want you to jetski, they don’t want you to smile...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Graphic">Graphic</a></li>
                                            <li><a href="#" title="Marketting">Marketting</a></li>
                                            <li><a href="#" title="HTML5">HTML5</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar1.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">David Beckham</a> - <span>Backend Developer</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>The key is to enjoy life, because they don’t want you to enjoy life. I promise you, they don’t want you to jetski, they don’t want you to smile...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Graphic">Graphic</a></li>
                                            <li><a href="#" title="HTML">HTML</a></li>
                                            <li><a href="#" title="JavaScript">JavaScript</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="job-freelanceritem">
                                    <a class="projectjob-title" href="#" title="">
                                        <img class="img-responsive" src="img/default/avatar/avatar2.jpg" alt="">
                                    </a>
                                    <div class="project-content">
                                        <div class="author"><a href="page-freelancer-detail.html" title="">Jonathan Evans</a> - <span>UI/UX Designer</span></div>
                                        <div class="vote-ratting clearfix">
                                            <span class="star_content">
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star_on"></span>
                                                <span class="star star"></span>
                                            </span>
                                        </div>
                                        <div class="desc">
                                            <p>The key is to enjoy life, because they don’t want you to enjoy life. I promise you, they don’t want you to jetski, they don’t want you to smile...</p>
                                        </div>
                                        <ul class="list-inline clearfix">
                                            <li><a href="#" title="Graphic">Graphic</a></li>
                                            <li><a href="#" title="Marketting">Marketting</a></li>
                                            <li><a href="#" title="HTML5">HTML5</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="job-freelanceritem">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                <li><a href="#">&laquo;</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">&raquo;</a></li>
                                </ul>
                                </div>
                            </div>
                        </div>
                        <div class="job-loadprofile text-center">
                            <a class="btn btn-default" href="#" title="load more profiles">load more profiles</a>
                        </div>
                    </div><!-- end job-freelancer -->
                </div> <!-- end container -->
            </div><!-- end warpper -->
            <div class="bg-bottom"></div>
        </div><!--end columns-->

        <div class="job-searchform">
            <a href="#" class="btn-close" title="close"><i class="fa fa-close"></i></a>
            <div class="container">
                <div class="job-search">
                    <form id="form-jobsearch" action="#" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                <input type="text" class="form-control" id="inputKeywords" placeholder="Keywords...">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                <select id="selectCategories" class="form-control">
                                    <option>Categories</option>
                                    <option>Websites IT & Software</option>
                                    <option>Mobile</option>
                                    <option>Writing</option>
                                    <option>Design</option>
                                    <option>Data Entry</option>
                                    <option>Product Sourcing & Manufacturing</option>
                                    <option>Sales & Marketing</option>
                                    <option>Business, Accounting & Legal</option>
                                    <option>Local Jobs & Services</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                <select id="selectLocation" class="form-control">
                                    <option>Location</option>
                                    <option>Submit some Articles</option>
                                    <option>Analyze some Data</option>
                                    <option>Fill in a Spreadsheet with Data</option>
                                    <option>Post some Advertisements</option>
                                    <option>Hire a Virtual Assistant </option>
                                    <option>Search the Web for Something</option>
                                    <option>Find Information from Websites</option>
                                    <option>Do some Excel Work</option>
                                    <option>Help with customer support</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                <select id="selectProject" class="form-control">
                                    <option>Project type</option>
                                    <option>Submit some Articles</option>
                                    <option>Analyze some Data</option>
                                    <option>Fill in a Spreadsheet with Data</option>
                                    <option>Post some Advertisements</option>
                                    <option>Hire a Virtual Assistant </option>
                                    <option>Search the Web for Something</option>
                                    <option>Find Information from Websites</option>
                                    <option>Do some Excel Work</option>
                                    <option>Help with customer support</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                <input type="text" class="form-control" id="inputSkill" placeholder="Skill...">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">
                                <input type="text" class="form-control" id="inputSkill" placeholder="Budget">
                                <!--<div id="slider-range" class="tiva-filter">
                                    <label>Budget</label>
                                    <div class="filter-item price-filter">
                                        <div class="layout-slider">
                                            
                                            <input id="price-filter" name="price" value="0;100" />
                                        </div>
                                        <div class="layout-slider-settings"></div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-sp-12 fr-search">
                                <button type="submit" class="btn btn-primary btn-shadown">Search now</button>
                            </div>
                        </div>
                    </form>
                </div><!-- end job-search -->
            </div><!-- end container -->
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