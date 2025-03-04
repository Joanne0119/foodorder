<?php include('partials/menu.php'); ?>

<div class="main">
    <h1>Add Food</h1>
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
                <td><input type="text" name="title" placeholder="Title of the food"></td>
            </tr>
            <tr>
                <td>Description: </td>
                <td><textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea></td>
            </tr>
            <tr>
                <td>Price: </td>
                <td><input type="number" name="price"></td>
            </tr>
            <tr>
                <td>Select Image: </td>
                <td><input type="file" name="image"></td>
            </tr>
            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">
                        <?php 
                            $conn = getDbConnection();
                            //1.
                            $sql = "SELECT * FROM tbl_category WHERE active= 'Yes'";
                            //2.
                            $stmt = $conn->prepare($sql);
                            //4.
                            if($stmt->execute()){
                                $result = $stmt->get_result();
                                $count_rows = $result->num_rows;
                                if($count_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $id ?>"><?php echo $title ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                        <option value="0">Category Not Available</option>
                                    <?php
                                }
                            }

                            $stmt->close();
                            $conn->close();
                        ?>
                    </select>
                </td>
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
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category'];
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

                if($image_name!=""){

                    //Auto rename image
                    $ext = end(explode('.', $image_name)); // ex: food1.png
                    $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext; // ex: Food_Food_123.png

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../image/food/".$image_name;

                    //check file type
                    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                    if (!in_array($extension, $allowed_extensions)) {
                        $_SESSION['upload'] = '<div class="fail">Only image files are allowed</div>';
                        header('location:' . SETURL . 'admin/add-food.php');
                        die();
                    }

                    // 檢查目錄是否存在
                    if (!is_dir("../image/food/")) {
                        mkdir("../image/food/", 0755, true);
                    }
                    
                    // Upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Check whether the image is uploaded or not
                    if($upload==false){
                        $_SESSION['upload'] = '<div class="fail">Failed to Upload Image</div>';
                        header('location:'.SETURL.'admin/add-food.php'); // Redirect to a page
                        die();
                    }
                }
            } else{
                //Don't upload and set image name = blank
                $image_name = "";
            }

            $conn = getDbConnection();
            //1.
            $sql = "INSERT INTO tbl_food SET
                title = ?,
                description = ?,
                price = ?,
                image_name = ?,
                category_id = ?,
                feature = ?,
                active = ?
            ";
            //2.
            $stmt = $conn->prepare($sql);
            //3.
            $stmt->bind_param("ssisiss", $title, $description, $price, $image_name, $category_id, $feature, $active);
            //4.
            if($stmt->execute()){
                $_SESSION['add'] = '<div class="success">Food Added Successfully</div>';
                header('location:'.SETURL.'admin/manage-food.php'); // Redirect to a page
                exit;
            }
            else{
                $_SESSION['add'] = '<div class="fail">Failed to Add Food</div>';
                header('location:'.SETURL.'admin/add-food.php'); // Redirect to a page
                exit;
            }
        }
    ?>
</div>
<?php include('partials/footer.php') ?>