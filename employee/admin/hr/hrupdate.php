<?php 
include('../connect.php');

if (!isset($_SESSION['logged_in'])) {
    header("Location: adminindex.php");
    exit; 
}

include('../../template/header.php'); 

?>
<?php  
$_SESSION['hrupdate_success_message'] = "Record updated successfully"; ?>
 
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update hr Details</div>
                <div class="card-body">
                    <?php
                    
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM hr WHERE id = $id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            ?>
                            <form method="POST" action="hrupdate-process.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="name" class="form-control" id="username" name="username" value="<?php echo $row['user_name']; ?>">
                                </div>
                              
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
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


<?php include('../../template/footer.php'); ?>
