<?php
if(isset($_GET['gen_pass'])){
    $pass= $_POST['txtPass'];
    $result=encrypt($pass, "FDC");
    $url= "admin.php?&result=".$result;
    header("location: $url");
    die();
}
function encrypt($string, $key) {
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
       $char = substr($string, $i, 1);
       $keychar = substr($key, ($i % strlen($key))-1, 1);
       $char = chr(ord($char)+ord($keychar));
       $result.=$char;
    }
    return base64_encode($result);
 }
 function decrypt($string, $key) {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
       $char = substr($string, $i, 1);
       $keychar = substr($key, ($i % strlen($key))-1, 1);
       $char = chr(ord($char)-ord($keychar));
       $result.=$char;
    }
    return $result;
 }
