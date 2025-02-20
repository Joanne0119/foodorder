<?php include('partials/menu.php') ?>
<div class="main">
    <h1>Add Admin</h1>
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
        $password = md5($_POST['password']); //Password encryption with MD5

        // SQL Qury to saved data into database
        $sql = "INSERT INTO tbl_admin SET 
                full_name = $full_name,
                username = $username,
                password = $password
        ";
    }

    //ExeucteQ Qury and save into database
    $conn = mysqli_connect("localhost", "root", ""); //Databse connection
    $db_select = mysqli_select_db($conn, "food_order") or die(mysqli_error($conn));
    $res = mysqli_query($conn, $sql) or die(mysqli_error($sql)); //Execute the SQL Qury
    if ($result) {
        echo "Success";
    } else {
        echo "Error" . mysqli_error($conn);
    }
    
    mysqli_close($conn); //Close the database connection
?>