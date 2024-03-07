<?php 
include('connect.php');
include('../template/header.php'); 


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: adminindex.php");
    exit; 
}


$error = array();
$inserted = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $dob = $_POST["dob"];
    // $gender = $_POST["gender"];
    $address = $_POST["address"];
    // $status = $_POST["status"];



    // Validate First Name
    if (empty($firstname)){
        $error['firstname'] = "First name is required";
    }


    // Validate Last Name
    if (empty($lastname)){
        $error['lastname'] = "Last name is required";
    }

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
        $error['password'] = "Password is required";
    } elseif(strlen($password) < 6){
        $error['password'] = "Password must be at least 6 characters";
    }

    // Validate DOB
    if (empty($_POST["dob"])) {
        $error['dob'] = "Date of Birth is required";
    }

    if(isset($_POST['gender'])) {
        $gender = $_POST['gender'];
        // Validate gender
        if($gender != 'female' && $gender != 'male' && $gender != 'others') {
            $error['gender'] = "Please select a valid gender option.";
        }
    } else {
        // gender is not set
        $error['gender'] = "Please select your gender.";
    }
  

    
    // Validate address
    if (empty($_POST["address"])) {
        $error['address'] = "Address is required";
    }

// validates status    
    if(isset($_POST['status'])) {
        $status = $_POST['status'];
        // Validate status
        if($status != '0' && $status != '1') {
            $error['status'] = "Please select a valid status option.";
        }
    } else {
        // status is not set
        $error['status'] = "Please select your status.";
    }
  
  

     // If there are no validation errors, insert data into the database
     
		$pass_md = md5($password);
        if (empty($error)) {
        $sql = "INSERT INTO employee (first_name, last_name, email, password, dob, gender,address,status) VALUES ('$firstname', '$lastname', '$email', '$pass_md', '$dob', '$gender','$address','$status')";

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
                                        <label for="firstname" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your firstname" value="<?php echo isset($firstname) ? $firstname : ''; ?>">
                                        <span class="error">
                                            <?php if(isset($error['firstname'])) echo $error['firstname']; ?>
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="lastname" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>">
                                        <span class="error">
                                            <?php if(isset($error['lastname'])) echo $error['lastname']; ?>
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

                                    <div class="col-md-12">
                                        <label for="dob" class="form-label">DOB</label>
                                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo isset($dob) ? $dob : ''; ?>">
                                        <span class="error">
                                            <?php if(isset($error['dob'])) echo $error['dob']; ?>
                                        </span>
                                    </div>

                                    <div class="col-md-12 pt-3">
                                        <label for="gender" class="form-label">gender</label>
                                        <input type="radio" id="gender" name="gender" value="female">female
                                        <input type="radio" id="gender" name="gender" value="male">male
                                        <input type="radio" id="gender" name="gender" value="others">others
                                        <span class="error">
                                            <?php if(isset($error['gender'])) echo $error['gender']; ?>
                                        </span>
                                    </div><br>

                                    <div class="col-md-12 pt-2">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" value="<?php echo isset($address) ? $address : ''; ?>">
                                        <span class="error">
                                            <?php if(isset($error['address'])) echo $error['address']; ?>
                                        </span>
                                    </div>

                                 
                                    <div class="col-md-12 pt-4">
                                        <label for="status">Status : </label>
                                        <select name="status" id="status">
                                            <Option></Option>
                                            <option value="1">enable</option>
                                            <option value="0">disable</option>
                                        </select>
                                        <span class="error">
                                            <?php if(isset($error['status'])) echo $error['status']; ?>
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

    <?php include('../template/footer.php'); ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Your custom JavaScript -->
    <script src="path/to/your/custom/js/script.js"></script>
</body>

</html>