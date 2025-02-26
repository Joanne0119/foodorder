<?php include('partials/menu.php'); ?>

<div class="main">
    <h1>Add Admin</h1>
    </br>
    <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add']; // Display session message
            unset($_SESSION['add']); // Remove session message
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload']; // Display session message
            unset($_SESSION['upload']); // Remove session message
        }
    ?>
    <br/>
    <form action="" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" placeholder="Enter title"></td>
            </tr>
            <tr>
                <td>Select Image: </td>
                <td><input type="file" name="image"></td>
            </tr>
            <tr>
                <td>Feature: </td>
                <td><input type="radio" name="feature" value="Yes">Yes</td>
                <td><input type="radio" name="feature" value="No">No</td>
            </tr>
            <tr>
                <td>Active: </td>
                <td><input type="radio" name="active" value="Yes">Yes</td>
                <td><input type="radio" name="active" value="No">No</td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Add Category" class="btn-primary"></td>
            </tr>
        </table>
    </form>
    <?php
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            if(isset($_POST['feature'])){   
                $feature = $_POST['feature'];
            }else{
                $feature = "No";
            }
            if(isset($_POST['active'])){
                $active = $_POST['active'];
            }else{
                $active = "No";
            }
            // print_r($_FILES);
            // die();
            if(isset($_FILES['image']['name'])){
                $image_name = $_FILES['image']['name'];

                //Auto rename image
                $ext = end(explode('.', $image_name)); // ex: food1.png
                $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // ex: Food_Category_123.png

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../image/category/".$image_name;

                //check file type
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $_SESSION['upload'] = '<div class="fail">Only image files are allowed</div>';
                    header('location:' . SETURL . 'admin/add-category.php');
                    die();
                }

                // 檢查目錄是否存在
                if (!is_dir("../image/category/")) {
                    mkdir("../image/category/", 0755, true);
                }
                
                // Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                //Check whether the image is uploaded or not
                if($upload==false){
                    $_SESSION['upload'] = '<div class="fail">Failed to Upload Image</div>';
                    header('location:'.SETURL.'admin/add-category.php'); // Redirect to a page
                    die();
                }
            } else{
                //Don't upload and set image name = blank
                $image_name = "";
            }

            $conn = getDbConnection();
            //1.
            $sql = "INSERT INTO tbl_category SET
                title = ?,
                image_name = ?,
                feature = ?,
                active = ?
            ";
            //2.
            $stmt = $conn->prepare($sql);
            //3.
            $stmt->bind_param("ssss", $title, $image_name, $feature, $active);
            //4.
            if($stmt->execute()){
                $_SESSION['add'] = '<div class="success">Category Added Successfully</div>';
                header('location:'.SETURL.'admin/manage-category.php'); // Redirect to a page
                exit;
            }
            else{
                $_SESSION['add'] = '<div class="fail">Failed to Add Category</div>';
                header('location:'.SETURL.'admin/add-category.php'); // Redirect to a page
                exit;
            }
        }
    ?>
</div>
<?php include('partials/footer.php') ?>