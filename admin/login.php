
<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="login-container">
        <h2>Login</h2>
        <br/>
        <?php
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login']; // Display session message
                unset($_SESSION['login']); // Remove session message
            }
            if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message']; // Display session message
                unset($_SESSION['no-login-message']); // Remove session message
            }
        ?>
        <br/><br/>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="login-btn">
                <button class="btn-primary" type="submit" name="submit">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="register.php" class="link">Register</a></p>
    </div>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    // Get the data from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to database
    $conn = getDbConnection();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 1. SQL query to select user
    $sql = "SELECT * FROM tbl_admin WHERE username = ?";
    // 2. Prepare statement
    $stmt = $conn->prepare($sql);
    // 3. Bind parameters
    $stmt->bind_param("s", $username);

    // 4. Execute query
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify password using password_verify()
            if (password_verify($password, $hashed_password)) {
                $_SESSION['login'] = '<div class="success">Login Successfully</div>';
                $_SESSION['user'] = $username;
                header('location:' . SETURL . 'admin/index.php'); // Redirect to a page
                echo "Password found";
            } else {
                $_SESSION['login'] = '<div class="fail">Username or Password is incorrect</div>';
                header('location:' . SETURL . 'admin/login.php');
                echo "Password not found";
            }
        } else {
            $_SESSION['login'] = '<div class="fail">Username or Password is incorrect</div>';
            header('location:' . SETURL . 'admin/login.php');
            echo "Password not found";
        }
    } else {
        $_SESSION['login'] = '<div class="fail">Failed to execute query</div>';
        header('location:' . SETURL . 'admin/login.php');
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
