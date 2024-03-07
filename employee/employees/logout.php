<?php

session_start();
if(isset($_SESSION['emp_logged_in']) && $_SESSION['emp_logged_in']){
    unset($_SESSION['emp_logged_in']);		
    unset($_SESSION['username']);
    unset($_SESSION['email']);

    session_destroy();
}
// print_r($_SESSION);exit;
header("Location:userindex.php");
exit();

?>

        