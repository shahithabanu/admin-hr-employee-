<?php 
include('../connect.php');

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: adminindex.php");
    exit; 
}

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['id'], $_POST['username'], $_POST['email'])) {
        // Escape special characters for security
        $id = $conn->real_escape_string($_POST['id']);
        $user_name = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        
        // Update query
        $sql = "UPDATE hr SET user_name='$user_name', email='$email' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to view employee page
            header("Location: viewhr.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
}


include('../../template/header.php'); 


$conn->close();
?>
<?php include('../../template/footer.php'); ?>
