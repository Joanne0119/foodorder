<?php include('partials/menu.php'); ?>

<div class="main">
    <h1>Update Admin</h1>
    </br>
    <?php 
        $conn = getDbConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0; 

        if($id > 0){
            // 1. 
            $sql = "SELECT * FROM tbl_admin WHERE id = ?";
            // 2.
            $stmt = $conn->prepare($sql);
    
            // 3. set the data
            $stmt->bind_param("i", $id);
    
            // 4. execute
            if ($stmt->execute()) {  
                
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    // 獲取管理員資料
                    $row = $result->fetch_assoc();
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    echo "Admin not found!";
                    header('location: manage-admin.php');
                    exit;
                }
            } else {
                header('location: manage-admin.php');
                exit;
            }
    
            // 關閉語句和連線
            $stmt->close();
        } else {
            echo "Invalid ID";
        }
        
        $conn->close();
    ?>
    </br>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" value="<?= $full_name ?>"></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" value="<?= $username ?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" name="submit" value="Update Admin" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php 
    if(isset($_POST['submit'])){
        //Get all the data
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        $conn = getDbConnection();

        //1. sql query to update
        $sql = "UPDATE tbl_admin SET
        full_name = ?,
        username = ?
        WHERE id = ?
        ";
        //2.
        $stmt = $conn->prepare($sql);

        //3.
        $stmt->bind_param("ssi", $full_name, $username, $id);

        //4.
        $res = $stmt->execute();//執行

        if ($res) {
            // echo "Success";
            $_SESSION['update'] = '<div class="success">Admin Update Successfully</div>';
            header('location:'.SETURL.'admin/manage-admin.php'); // Redirect to a page
            exit;
        } else {
            // echo "Error: " . mysqli_error($conn);
            $_SESSION['update'] = '<div class="fail">Failed to Update Admin</div>';
            header('location:'.SETURL.'admin/manage-admin.php'); 
        }

        // 關閉預備語句和資料庫連線
        $stmt->close();
        $conn->close();
    }


    include('partials/footer.php'); 
?>