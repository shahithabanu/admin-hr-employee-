<?php 
session_start();
include('../template/header.php'); ?>


<?php



if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: adminindex.php");
    exit; 
}




$_SESSION['update_success_message'] = "Record updated successfully";
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Employee Details</div>
                <div class="card-body">
                    <?php
                    include('connect.php');
                    
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM employee WHERE id = $id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            ?>
                            <form method="POST" action="update-process.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="dob">DOB</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['dob']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label><br>
                                    <input type="radio" id="female" name="gender" value="female" <?php echo ($row['gender'] == 'female') ? 'checked' : ''; ?>>
                                    <label for="female">Female</label><br>
                                    <input type="radio" id="male" name="gender" value="male" <?php echo ($row['gender'] == 'male') ? 'checked' : ''; ?>>
                                    <label for="male">Male</label><br>
                                    <input type="radio" id="other" name="gender" value="other" <?php echo ($row['gender'] == 'other') ? 'checked' : ''; ?>>
                                    <label for="other">Other</label>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>">
                                </div>
                                

                                <div class="form-group">
                                            <label for="status">Status : </label>
                                            <select name="status" id="status">
                                                <option value="1 <?php echo ($row['status'] == '1') ? 'selected' : ''; ?>">enable</option>
                                                <option value="0 <?php echo ($row['status'] == '0') ? 'selected' : ''; ?> ">disable</option>
                                            </select>
                                        </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                            <?php
                        } else {
                            echo "Employee not found.";
                        }
                    } else {
                        echo "Invalid request.";
                    }
                    ?>
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
