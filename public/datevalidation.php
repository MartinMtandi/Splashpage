<?php
$dob = $_REQUEST['dob'];
  
if(substr($dob,0,4) >  2007 ){

    echo "<script> $('#dob').css('border','solid 2px red'); </script>";
}else{
    echo "<script> $('#dob').css('border','solid 2px green'); </script>";
}

?>