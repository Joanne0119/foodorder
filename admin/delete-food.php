<?php 
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])) { //make sure they exist, else go backt to manage category. To avoid hacking
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0; //check id is a number
        $image_name = isset($_GET['image_name']) ? $_GET['image_name'] : '';
        //Delete Image
        if($image_name != '') {
            $path = "../image/food/" . $image_name;
            $remove = unlink($path);
            if ($remove == false) {
                $_SESSION['remove'] = '<div class="fail">Failed to Remove Food Image</div>';
                header("location:" . SETURL . "admin/manage-food.php");
                die(); // Stop the process
            }
        }

        //Delete Database
        $conn = getDbConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // 1. 
        $sql = "DELETE FROM tbl_food WHERE id = ?";
        // 2.
        $stmt = $conn->prepare($sql);

        // 3. set the data
        $stmt->bind_param("i", $id);

        // 4. execute
        if ($stmt->execute()) {  
            $_SESSION['delete'] = '<div class="success">Food Deleted Succssfuly!</div>';
            header("location:" . SETURL . "admin/manage-food.php");
            exit;
        } else {
            $_SESSION['delete'] = '<div class="fail">Food Fail to Deleted</div>';
            header("location:" . SETURL . " admin/manage-food.php");
        }

        // 關閉語句和連線
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid ID";
        $_SESSION['unauthorize'] = '<div class="fail">Unauthorized Access</div>';
        header("location:" . SETURL . " admin/manage-food.php");
    }
    
?>