<?php 
include('../connect.php');

if (!isset($_SESSION['logged_in'])) {
    header("Location: adminindex.php");
    exit; 
}

include('../../template/header.php');


$error = array();
$inserted = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];



     // Validate Email
     if (empty($email)){
        $error['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email format";
    }else 
    {
        // Check if email already exists in the database
        $sql_check_email = "SELECT * FROM employee WHERE email='$email'";
        $result_check_email = $conn->query($sql_check_email);
        if ($result_check_email->num_rows > 0) {
            $error['email'] = "Email already exists";
        }
    }

    // Validate password
    if (empty($password)){
        $error['password'] = "password is required";
    } elseif(strlen($password) < 6){
        $error['password'] = "password must be at least 6 characters";
    }

   

  

     // If there are no validation errors, insert data into the database
     
	  $pass_md = md5($password);
     if (empty($error)) {
        $sql = "INSERT INTO hr (user_name, email, password) VALUES ('$username','$email','$pass_md')";

        if ($stmt = $conn->prepare($sql)) {
            //$stmt->bind_param("ssssss", $firstname, $lastname, $address, $city, $zip, $email);

            if ($stmt->execute()) {
                $inserted = true; 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
        }

        $conn->close();
    }
}
?>


<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if ($inserted): ?>
                    <div class="alert alert-success text-center" role="alert">
                        Data inserted successfully!
                    </div>
                    <?php endif; ?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <h2 class="text-center text-black">Add Employee</h2>
                            <div id="addEmployeeForm">
                                <form id="employeeForm" class="row g-3 p-3" method="POST">
                                    <div class="col-md-12">
                                        <label for="username" class="form-label">User name</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?php echo isset($username) ? $username : ''; ?>">
                                        <span class="error">
                                            <?php if(isset($error['username'])) echo $error['username']; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label for="inputEmail4" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Enter your email" value="<?php echo isset($email) ? $email : ''; ?>">
                                        <span class="error">
                                            <?php if(isset($error['email'])) echo $error['email']; ?>
                                        </span>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="inputEmail4" class="password">password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                        <span class="error">
                                            <?php if(isset($error['password'])) echo $error['password']; ?>
                                        </span>
                                    </div>

                                  

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-dark">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php include('../../template/footer.php'); ?>

