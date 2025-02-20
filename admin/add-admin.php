<?php include('partials/menu.php') ?>

<div class="main">
    <h1>Add Admin</h1>
    </br>
    <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add']; // Display session message
            unset($_SESSION['add']); // Remove session message
        }
    ?>
    </br>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" placeholder="Enter your name"></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" placeholder="Enter your username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" placeholder="Enter your password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Add Admin" class="btn-primary"></td>
            </tr>
        </table>
    </form>
</div>
<?php include('partials/footer.php') ?>


<?php 
    if(isset($_POST['submit']))
    {
        // Get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password']; 

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 獲取資料庫連線
        $conn = getDbConnection();

        // SQL Qury to saved data into database
        $sql = "INSERT INTO tbl_admin (full_name, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // 綁定參數
        $stmt->bind_param("sss", $full_name, $username, $hashed_password);

        // 執行預備語句
        $res = $stmt->execute();

        if ($res) {
            // echo "Success";
            $_SESSION['add'] = "Admin Added Successfully";
            header('location:'.SETURL.'admin/manage-admin.php'); // Redirect to a page
        } else {
            // echo "Error: " . mysqli_error($conn);
            $_SESSION['add'] = "Failed to Add Admin";
            header('location:'.SETURL.'admin/add-admin.php'); 
        }

        // 關閉預備語句和資料庫連線
        $stmt->close();
        $conn->close();
    }
    
    mysqli_close($conn); //Close the database connection
?>