<?php 
include('../admin/connect.php');
include('../template/header_emp.php');
// print_r($_SESSION['emp_logged_in']);

// Check if the user is logged in
if (!isset($_SESSION['emp_logged_in'])) {
    header("Location: userindex.php"); 
    exit;
}

//

$sql = "SELECT * FROM employee";
$result = $conn->query($sql);



if($result->num_rows>0){
    while($row = $result->fetch_assoc()) {
        // Store data from each row into arrays
        $firstName= $row["first_name"];
        $lastname = $row["last_name"];
        $email = $row["email"];
        $dob = $row["dob"];
        $gender = $row["gender"];
        $address = $row["address"];
        $status = $row["status"];
    }
}

$conn -> close();
 ?>


<div class="container text-center mt-5">
<div class="card">
    <div class="card-heder p-3">
    <h1 class="h3 mb-3">Dashboard</h1>
    </div>
    <div class="card-body">
    <p><b>Hi..!<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?></b></p>
    <p>This is your Email.id: <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ""; ?></p>
    </div>
</div>


<div class="card text-center p-3">
    <p><b>First Name:</b> <?php echo $firstName; ?> </p>
    <p><b>Last Name:</b> <?php echo $lastname; ?></p>
    <p><b>Email:</b> <?php echo $email; ?></p>
    <p><b>Date of Birth:</b> <?php echo $dob; ?></p>
    <p><b>Gender:</b> <?php echo $gender; ?></p>
    <p><b>Address:</b> <?php echo $address; ?></p>
    <p><b>Status:</b> <?php echo $status; ?></p>
</div>

       
<button class="btn btn-light"><a href="logout.php">Logout</a></button>

<?php include('../template/footer_emp.php'); ?>


				