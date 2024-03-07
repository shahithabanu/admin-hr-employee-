<?php 
include('../admin/connect.php');

// Check if the user is logged in
// if (!isset($_SESSION['emp_logged_in']) || $_SESSION['emp_logged_in'] !== true) {
//     header("Location: userindex.php"); 
//     exit;
// }

// Fetch employee data
$sql = "SELECT first_name, last_name, gender, dob FROM employee";
$result = $conn->query($sql);

// Initialize variables to store employee data
$firstNames = [];
$lastNames = [];
$genders = [];
$dobs = [];

if ($result->num_rows > 0) {
    // Loop through each row of the result set
    while($row = $result->fetch_assoc()) {
        // Store data from each row into arrays
        $firstNames[] = $row["first_name"];
        $lastNames[] = $row["last_name"];
        $genders[] = $row["gender"];
        $dobs[] = $row["dob"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="h3 mb-3">Dashboard</h1>
        <p><b>Hi..!<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?></b></p>
        <p>This is your Email.id: <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ""; ?></p>
        <p>First Names:</p>
        <ul>
            <?php foreach ($firstNames as $firstName): ?>
                <li><?php echo $firstName; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Last Names:</p>
        <ul>
            <?php foreach ($lastNames as $lastName): ?>
                <li><?php echo $lastName; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Genders:</p>
        <ul>
            <?php foreach ($genders as $gender): ?>
                <li><?php echo $gender; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Dates of Birth:</p>
        <ul>
            <?php foreach ($dobs as $dob): ?>
                <li><?php echo $dob; ?></li>
            <?php endforeach; ?>
        </ul>
        <button class="btn btn-light"><a href="logout.php">Logout</a></button>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php 
include('../admin/connect.php');
include('../template/header_emp.php');

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['emp_logged_in'])) {
    header("Location: userindex.php"); 
    exit;
}

// Fetch employee data from the database
$sql = "SELECT * FROM employee";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    // Fetching data from the first row, assuming there's only one employee record
    $row = $result->fetch_assoc();
    $firstName = $row["first_name"];
    $lastname = $row["last_name"];
    $email = $row["email"];
    $dob = $row["dob"];
    $gender = $row["gender"];
    $address = $row["address"];
    $status = $row["status"]; // Fixing this variable, it was incorrectly set to dob
}

$conn->close();
?>

<div class="container text-center mt-5">
    <div class="card">
        <div class="card-header p-3">
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
</div>

<?php include('../template/footer_emp.php'); ?>
