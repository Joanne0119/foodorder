<?php include('partials/menu.php'); ?>

<div class="main">
    <h1>Change Password</h1>
    </br>
    <?php 
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
    ?>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Current Password: </td>
                <td><input type="password" name="current_password" placeholder="Enter your old password"></td>
            </tr>
            <tr>
                <td>New Password: </td>
                <td><input type="password" name="new_password" placeholder="Enter your new password"></td>
            </tr>
            <tr>
                <td>Comfirm Password: </td>
                <td><input type="password" name="comfirm_password" placeholder="Confirm your password"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php 
    if(isset($_POST['submit'])){
        //Get the data from form
        $id = $_POST['id'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $comfirm_password = $_POST['comfirm_password'];

        // connect to database
        $conn = getDbConnection();

        //1. 
        $sql = "SELECT password FROM tbl_admin WHERE id = ?";
        //2.
        $stmt = $conn->prepare($sql);
        //3.
        $stmt->bind_param("i", $id);
        //4.
        if ($stmt->execute()) {  
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                if(password_verify($current_password, $hashed_password)){
                    // echo "Current Password is valid";

                    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    //update password to database
                    //1.
                    $update_sql = "UPDATE tbl_admin SET password = ? WHERE id = ?";
                    //2.
                    $update_stmt = $conn->prepare($update_sql);
                    //3.
                    $update_stmt->bind_param("si", $new_hashed_password, $id);
                    //4.
                    if($update_stmt->execute()){
                        $_SESSION['update-password'] = '<div class="success">Password Updated Successfully</div>';
                        header('location:'.SETURL.'admin/manage-admin.php'); // Redirect to a page
                    }
                    else{
                        $_SESSION['update-password'] = '<div class="fail">Failed to Update Password</div>';
                        header('location:'.SETURL.'admin/manage-admin.php');
                    }
                }
                else{
                    $_SESSION['password-not-match'] = '<div class="fail">Current Password is incorrect</div>';
                    header('location:'.SETURL.'admin/manage-admin.php');
                }
            }
            else{
                $_SESSION['user-not-found'] = '<div class="fail">Admin Not Found</div>';
                header('location:'.SETURL.'admin/manage-admin.php');
            }
        }
        $stmt->close();
        $conn->close();
    }

    include('partials/footer.php') 
?>
