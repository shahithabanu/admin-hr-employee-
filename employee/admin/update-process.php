<?php
session_start();
include('connect.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: adminindex.php");
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['id'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['address'], $_POST['status'])) {
        // Escape special characters for security
        $id = $conn->real_escape_string($_POST['id']);
        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $dob = $conn->real_escape_string($_POST['dob']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $address = $conn->real_escape_string($_POST['address']);
        $status = $conn->real_escape_string($_POST['status']);
        
        // Update query
        $sql = "UPDATE employee SET first_name='$first_name', last_name='$last_name', email='$email', dob='$dob', gender='$gender', address='$address', status='$status' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to view employee page
            header("Location: viewemployee.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
}


$conn->close();
?>
