<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function trim_text($text, $count){
    $text = str_replace("  ", " ", $text); 
    $string = explode(" ", $text); 
    $trimed = "";
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
    
function skill($Skill_id,$db_conx) {
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
}