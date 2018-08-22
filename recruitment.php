<?php $actlink = basename(__FILE__);
      $title = "Recruitment Page";
  include_once("freelancerheader.php"); ?>
<?php 
    
    $sql = "select count(1) from Job 
            where del_flg = 'N'";
    if($user_ok == true){
        $sql .= " and hire_manager_id != '$log_username' ";
    }
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $ProCount = $row[0];
    
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
?>
<div id="columns" class="columns-container">
            <div class="bg-top"></div>
            <div class="warpper">
                <!-- container -->
                <div class="container">
                    <div class="job-search-all">
                        <div class="job-search-title">
                            <h4 class="title_block">We found <span><?php echo $ProCount;?></span> available jobs for you</h4>
                        </div>
                        <div class="job-list" id="job-list">
                            <div class="job-listnormal">
                                <?php echo $JobRow; ?>
                            </div><!-- end job-listnormal -->
                            <div class="job-load text-center">
                                <a href="#" class="btn btn-default" title="Load more job">Load more job</a>
                            </div><!-- end job-load -->
                        </div><!-- end job-list -->
                    </div>
                </div> <!-- end container -->
            </div><!-- end warpper -->
            <div class="bg-bottom"></div>
        </div><!--end warp-->

        <div class="job-searchform">
            <a href="#" class="btn-close" title="close"><i class="fa fa-close"></i></a>
            <div class="container">
                <div class="job-search">
                    <form id="job-searchbox" action="#" class="form-horizontal">
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
                                <input type="text" class="form-control" id="inputSkill" placeholder="Budget...">
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-sp-12 fr-search">
                                <button type="submit" class="btn btn-primary btn-shadown">Search now</button>
                            </div>
                        </div>
                    </form>
                </div><!-- end job-search -->
            </div>
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