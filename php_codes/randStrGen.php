<?php
function randStrGen($len){
$result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789$$$$$$$1111111";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
   $randItem = array_rand($charArray);
   $result .= "".$charArray[$randItem];
    }
    return $result;
}

echo '5N'.strtoupper(randStrGen(5));
?>