<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $selectCategories = '<select id="selectCategories" class="form-control">';
    $sql = "select id,cat_name,cat_value,Del_flg,country_id from FORM_CATEGORIES
            where Del_flg = 'N'  order by id asc";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $id = $row["id"];
        $cat_name = $row["cat_name"];
        $cat_value = $row["cat_value"];
        $selectCategories .= '<option value="'.$cat_value.'">'.$cat_name;
        $selectCategories .= '</option>';
    }
    $selectCategories .= '</select>';
    
    $selectLOCATION = '<select id="selectLocation" class="form-control">';
    $sql = "select id,loc_name,loc_value,Del_flg,country_id from FORM_LOCATION
            where Del_flg = 'N'  order by id asc";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $id = $row["id"];
        $loc_name = $row["loc_name"];
        $loc_value = $row["loc_value"];
        $selectLOCATION .= '<option value="'.$loc_value.'">'.$loc_name;
        $selectLOCATION .= '</option>';
    }
    $selectLOCATION .= '</select>';
    
    $selectProject = '<select id="selectProject" class="form-control">';
    $sql = "select id,pro_name,pro_value,Del_flg,country_id from FORM_PROJECT
            where Del_flg = 'N'  order by id asc";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $id = $row["id"];
        $pro_name = $row["pro_name"];
        $pro_value = $row["pro_value"];
        $selectProject .= '<option value="'.$pro_value.'">'.$pro_name;
        $selectProject .= '</option>';
    }
    $selectProject .= '</select>';
?>