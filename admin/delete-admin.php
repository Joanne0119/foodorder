<?php 
    include('../config/constants.php');
    $conn = getDbConnection();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0; //check id is a number

    if($id > 0){
        // 1. 
        $sql = "DELETE FROM tbl_admin WHERE id = ?";
        // 2.
        $stmt = $conn->prepare($sql);

        // 3. set the data
        $stmt->bind_param("i", $id);

        // 4. execute
        if ($stmt->execute()) {  
            $_SESSION['delete'] = '<div class="success">Admin Deleted Succssfuly!</div>';
            header("location:" . SETURL . "admin/manage-admin.php");
            exit;
        } else {
            $_SESSION['delete'] = '<div class="fail">Admin Fail to Deleted</div>';
            header("location:" . SETURL . " admin/manage-admin.php");
        }

        // 關閉語句和連線
        $stmt->close();
    } else {
        echo "Invalid ID";
    }
    
    $conn->close();
?>