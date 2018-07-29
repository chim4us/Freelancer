<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $db_conx = mysqli_connect("localhost", "toptenca_usr1", "Csou9_7+?[[F","toptenca_test");
    if (mysqli_connect_errno()){
        echo mysqli_connect_error();
        echo "DB connect1";
        exit();
    }
    
    include 'Mailin.php';
    $sql = "select email,first_name from USER_advert where email = 'ttc092017@gmail.com'
            order by id asc limit 1";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $email = $row["email"];
    $Fame = $row["first_name"];
    $msg = 'Hi '.$Fame.' we are toptencash organization.
            WHAT DO WE DO
            1.We double your investment by 50% after 10 days of investment completion.
            2.We credit you 5% of first donation of every referral you bring into our system
            To be part of us kindly visit our site 
            by click <a href="https://www.toptencash.com/index.php?RefID=admin">Here</a> ';
    $mailin = new Mailin('ttc092017@gmail.com', 'yxXQLAJd4OFRkGwv');
    $mailin->
    addTo($email, $Fame)->
    setFrom('ttc092017@gmail.com', 'toptencash')->
    setReplyTo('ttc092017@gmail.com','toptencash')->
    setSubject('Secured system for Nigerians')->
    setText($msg)->
    setHtml($msg);
    $res = $mailin->send();
    echo $res;
    echo '</br> Done';
    }
/**
The success message will be returned in this format::
{'result' => true, 'message' => 'Email sent'}
*/