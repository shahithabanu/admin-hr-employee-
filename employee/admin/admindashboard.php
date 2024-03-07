<?php 
include('connect.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: adminindex.php");
    exit; 
}


include('../template/header.php');


// Query to get the count of employees
$sql = "SELECT COUNT(*) as employee_count FROM employee";
$result = $conn->query($sql);

// Check if query was successful
if ($result) {
    $row = $result->fetch_assoc();
    $employee_count = $row['employee_count'];
} else {

    $employee_count = 0; // Default to 0 if query fails

}


// Close the connection
$conn->close();
?>


<div class="container-fluid p-0">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>
                <p>This is your Email.id: <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ""; ?></p>
                <p>This is your Username: <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?></p>
            </div>
        </div>
    </div>
</div>


<div class="col-md-6">
	<div class="card">
		<div class="card-body">
		<h1>Employees count: <?php echo $employee_count; ?></h1>
		</div>
	</div>
</div>

<?php include('../template/footer.php'); ?>
