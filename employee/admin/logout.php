<?php
session_start();

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // Unsezt or destroy the session variables related to the user login
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['logged_in']);
    unset($_SESSION['role']);
    
    // Destroy the session
    session_destroy();
}

// Redirect the user to the adminindex.php page
header("Location: adminindex.php");
exit();

?>
