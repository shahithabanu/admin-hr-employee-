<?php
include('../admin/connect.php'); 


if (isset($_SESSION['emp_logged_in'])){
    header("Location: employeedashboard.php");
    exit; 
}

$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username=$_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if(empty($_POST["email"])){
        $error['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['email'] = "Invalid email format";
    }
    
    if (empty($password)){
        $error['password'] = "Password is required";
    } elseif(strlen($password) < 6){
        $error['password'] = "Password must be at least 6 characters";
    }

	if (empty($error)) {

        $email = stripcslashes($email);  
        $password = stripcslashes($password); 
        
        $email = mysqli_real_escape_string($conn, $email);  
        $password = mysqli_real_escape_string($conn, $password);  
      
		
		$pass_md = md5($password);
        $sql = "SELECT * FROM employee WHERE email = '$email' AND password = '$pass_md'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  

    
        if ($count == 1) {  
			$_SESSION['emp_logged_in'] = true;		
			$_SESSION['username']=$username;
			$_SESSION['email']=$email;
			
            header("Location: employeedashboard.php");
            
        }
        else {  
            // Store error message in session
            $_SESSION['error'] = "<div class='alert alert-danger'>Login failed. Invalid email or password.</div>";  
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-login-in.html" />

	<title>login In | AdminKit Demo</title>

	<link href="/employee/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


	<style>
		.error{
			color:red;
		}
	</style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome to employee Login!</h1>
							<p class="lead">
								login in to your account to continue
							</p>
						</div>

						<?php
                // Check if error message is set in session and display it
                if(isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    // Unset the error session variable to clear it after displaying
                    unset($_SESSION['error']);
                }
                ?>
						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="post">

									<div class="mb-3">
                                            <label class="form-label">username</label>
                                            <input class="form-control form-control-lg" type="username" name="username" placeholder="Enter your username"/>
                                            <span class="error"><?php if(isset($error['username'])) echo $error['username']; ?></span>
										</div>

										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                            <span class="error"><?php if(isset($error['email'])) echo $error['email']; ?></span>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
											<span class="error"><?php if(isset($error['password'])) echo $error['password']; ?></span>
										</div>
										<div>
									
										</div>
										<div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary" name="submit">login in</button>
                                        </div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>

</body>

</html>