<?php 
include('connect.php');

if(isset($_POST['delete'])){
    $id = $conn->real_escape_string($_POST['delete']);
    $sql = "DELETE FROM employee WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Record deleted successfully";
        // Redirect after the DELETE operation is complete
        header("Location: ".$admin_url."viewemployee.php");
         exit(); // Stop script execution after redirection
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

include('../template/header.php');

if (!isset($_SESSION['logged_in'])) {
    header("Location: adminindex.php");
    exit; 
}


// session_start(); 

?>

<h2 class="text-center mt-5">List Of Employee Details</h2>

<div class="table-container p-5">
<?php


$sql = "SELECT * FROM employee ORDER BY created_at DESC";
$result = $conn->query($sql);

if(isset($_SESSION['success_message'])){
    echo "<div class='alert alert-success' role='alert'>";
    echo $_SESSION['success_message'];
    echo "</div>";
    unset($_SESSION['success_message']);
}

if(isset($_SESSION['update_success_message'])){
    echo "<div class='alert alert-success' role='alert'>";
    echo $_SESSION['update_success_message'];
    echo "</div>";
    unset($_SESSION['update_success_message']);
}

if ($result->num_rows > 0) {
    $counter = 1; // Initialize counter
    echo "<form method='post'>";
    echo "<table class='table table-bordered p-5'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>DOB</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Status</th>
        <th>Action</th>
    </tr>";
    echo "</thead>";
    
    echo "<tbody>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter++ . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["dob"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . ($row["status"] == 1 ? 'Enabled' : 'Disabled') . "</td>";
        echo "<td>
                <button type='button' onclick='redirectToUpdate(".$row['id'].")' class='btn btn-success'>Update</button>
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

$conn->close();
?>
</div>

<?php include('../template/footer.php'); ?>

<script>
function redirectToUpdate(id) {
    window.location.href = 'update.php?id=' + id;
}
</script>
