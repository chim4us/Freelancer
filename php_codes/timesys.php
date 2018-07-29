<?php
if(isset($_POST["checktime"])){
    $var = preg_replace('#[^a-z0-9]#i', '',$_SESSION['expireDate']);
    $check = strtotime($var) - time();
    if($check <= "00:00:00"){
        //echo "bad</br>";
        //exit();
    }else{
        echo gmdate("H:i:s",$check)."</br>";
        exit();
    }
}else{
    $var = preg_replace('#[^a-z0-9]#i', '',$_SESSION['expireDate']);
    $check = strtotime($var) - time();
}
?>
<script src="../js/main.js"></script>
<script src="../js/ajax.js"></script>
<script>
    window.setInterval(function(){
        var ajax = ajaxObj("POST", "timesys.php");
        ajax.onreadystatechange = function() {
              if(ajaxReturn(ajax) == true) {
                  if(ajax.responseText.trim().toUpperCase() == "DELETE"){
                      window.location = "Delete.php?UID=chim4us1";
                  } else {
                      //alert(ajax.responseText);
                      status.innerHTML = ajax.responseText;
                      window.location = "#status";
                  }
              }
          }
          ajax.send("checktime=check");
    }, 1000);
</script>