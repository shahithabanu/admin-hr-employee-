<?php
session_start();
$conn =mysqli_connect ('localhost','root','','admin-employee');
if(mysqli_connect_errno()){
    die ("failed to connect with mysql : " . mysqli_connect_error());
}

$admin = array('sahitha');
 
$admin_url = 'http://localhost/employee/admin/';
$emp_url = 'http://localhost/employee/employees/';
?>
