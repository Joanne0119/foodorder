<?php 
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])) { //make sure they exist, else go backt to manage category. To avoid hacking
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0; //check id is a number
        $image_name = isset($_GET['image_name']) ? $_GET['image_name'] : '';
        //Delete Image
        if($image_name != '') {
            $path = "../image/category/" . $image_name;
            $remove = unlink($path);
            if ($remove == false) {
                $_SESSION['remove'] = '<div class="fail">Failed to Remove Category Image</div>';
                header("location:" . SETURL . "admin/manage-category.php");
                die(); // Stop the process
            }
        }

        //Delete Database
        $conn = getDbConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // 1. 
        $sql = "DELETE FROM tbl_category WHERE id = ?";
        // 2.
        $stmt = $conn->prepare($sql);

        // 3. set the data
        $stmt->bind_param("i", $id);

        // 4. execute
        if ($stmt->execute()) {  
            $_SESSION['delete'] = '<div class="success">Category Deleted Succssfuly!</div>';
            header("location:" . SETURL . "admin/manage-category.php");
            exit;
        } else {
            $_SESSION['delete'] = '<div class="fail">Category Fail to Deleted</div>';
            header("location:" . SETURL . " admin/manage-category.php");
        }

        // 關閉語句和連線
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid ID";
        header("location:" . SETURL . " admin/manage-category.php");
    }
    
?>