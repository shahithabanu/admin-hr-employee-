<?php 
 // Start session
// session_start();
include('../connect.php'); // Include database connection

// Redirect if user is not logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: adminindex.php");
    exit; 
}

// Delete Operation
if(isset($_POST['delete'])){
    $id = $_POST['delete'];
    $sql = "DELETE FROM hr WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Record deleted successfully";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Update Operation
if(isset($_POST['update'])){
    $id = $_POST['update'];
    // Redirect to a page for update
    header("Location: hrupdate.php?id=$id");
    exit();
}


include('../../template/header.php'); // Include header template

?>

<h2 class="text-center mt-5">List Of HR Details</h2>

<div class="table-container p-5">
<?php
// Display success messages
if(isset($_SESSION['success_message'])){
    echo "<div class='alert alert-success' role='alert'>";
    echo $_SESSION['success_message'];
    echo "</div>";
    unset($_SESSION['success_message']);
}

if(isset($_SESSION['hrupdate_success_message'])){
    echo "<div class='alert alert-success' role='alert'>";
    echo $_SESSION['hrupdate_success_message'];
    echo "</div>";
    unset($_SESSION['hrupdate_success_message']);
}

// Fetch HR details from the database
$sql = "SELECT * FROM hr ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $counter = 1; // Initialize counter
    echo "<form method='post'>";
    echo "<table class='table table-bordered p-5'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>";
    echo "</thead>";
    
    echo "<tbody>";

    // Display HR details in table rows
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter++ . "</td>";
        echo "<td>" . $row["user_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
       
        echo "<td>
                <button type='submit' name='update' class='btn btn-success' value='".$row['id']."'>Update</button> 
                <button type='submit' name='delete' class='btn btn-primary' value='".$row['id']."'>Delete</button>
              </td>";
        echo "</tr>";
        
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</form>";
} else {
    echo "0 results";
}

$conn->close(); // Close database connection
?>
</div>

<?php include('../../template/footer.php'); // Include footer template ?>
