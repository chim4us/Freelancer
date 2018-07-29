<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
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
                                <?php 
                                    include_once("Form_Codes.php"); 
                                    echo $selectCategories;
                                    echo '</div>
                                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">';
                                    echo $selectLOCATION;
                                    echo '</div>
                                          </div>
                                          <div class="form-group">
                                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12">';
                                    echo $selectProject;
                                ?>
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