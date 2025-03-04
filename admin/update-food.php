<?php include('partials/menu.php'); ?>

<div class="main">
    <h1>Update Food</h1>
    </br>
    <?php 
        if(isset($_GET['id'])){
            $conn = getDbConnection();

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $id = isset($_GET['id']) ? intval($_GET['id']) : 0; 

            if($id > 0){
                // 1. 
                $sql = "SELECT * FROM tbl_food WHERE id = ?";
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
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $current_image = $row['image_name'];
                        $category_id = $row['category_id'];
                        $feature = $row['feature'];
                        $active = $row['active'];
                    } else {
                        $_SESSION['no-food-found'] = "<div class='fail'>Food Not Found</div>";
                        header('location: manage-food.php');
                        exit;
                    }
                } else {
                    header('location: manage-food.php');
                    exit;
                }
        
                // 關閉語句和連線
                $stmt->close();
            } else {
                echo "Invalid ID";
            }
            
            $conn->close();
        }
    ?>
    </br>
    <form action="" method="POST" enctype="multipart/form-data"> 
    <!-- enctype="multipart/form-data" allow file upload -->
        <table>
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" value="<?= $title ?>"></td>
            </tr>
            <tr>
                <td>Description: </td>
                <td><textarea name="description" cols="30" rows="5"><?= $description ?></textarea></td>
            </tr>
            <tr>
                <td>Price: </td>
                <td><input type="number" name="price" value="<?= $price ?>"></td>
            </tr>
            <tr>
                <td>Current Image: </td>
                <td>
                    <?php
                        if($current_image != ""){
                            ?>
                            <img src="<?php echo SETURL; ?>image/food/<?= $current_image; ?>" width="150px">
                            <?php
                        }
                        else{
                            echo "<div class='fail'>Image Not Added</div>";
                        }
                    ?>
                    
                </td>
            </tr>
            <tr>
                <td>New Image: </td>
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
                                        ?>
                                            <option <?php if($category_id == $row['id']){ echo "selected"; } ?> value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                        <option value="0">Food Not Available</option>
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
                <td><input <?php if($feature == "Yes"){ echo "checked"; } ?> type="radio" name="feature" value="Yes">Yes</td>
                <td><input <?php if($feature == "No"){ echo "checked"; } ?> type="radio" name="feature" value="No">No</td>
            </tr>
            <tr>
                <td>Active: </td>
                <td><input <?php if($active == "Yes"){ echo "checked"; } ?> type="radio" name="active" value="Yes">Yes</td>
                <td><input <?php if($active == "No"){ echo "checked"; } ?> type="radio" name="active" value="No">No</td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?= $current_image ?>">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php 
    if(isset($_POST['submit'])){
        //Get all the data
        $id = $_POST['id'];
        $title = $_POST['title'];
        $price = floatval($_POST['price']);
        $description = $_POST['description'];
        $current_image = $_POST['current_image'];
        $category = $_POST['category'];
        $feature = $_POST['feature'];
        $active = $_POST['active'];

        //Update image
        if(isset($_FILES['image']['name'])){ //if image is selected
            $image_name = $_FILES['image']['name'];

            if($image_name != ""){ 
                //Image is available
                //1. Upload new image
                //Auto rename image
                $ext = end(explode('.', $image_name)); // ex: food1.png
                $image_name = "Food_Food_".rand(0000, 9999).'.'.$ext; // ex: Food_Food_123.png

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../image/food/".$image_name;

                //check file type
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $_SESSION['upload'] = '<div class="fail">Only image files are allowed</div>';
                    header('location:' . SETURL . 'admin/manage-food.php');
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
                //2. Remove current image
                if($current_image != ""){
                    $remove_path = "../image/food/".$current_image;
                    $remove = unlink($remove_path);
                    if ($remove == false) {
                        $_SESSION['remove'] = '<div class="fail">Failed to Remove Food Image</div>';
                        header("location:" . SETURL . "admin/manage-food.php");
                        die(); // Stop the process
                    }
                }
            }
            else{
                $image_name = $current_image;
            }
        }
        else{
            $image_name = $current_image;
        }
        //Update Database
        $conn = getDbConnection();

        //1. sql query to update
        $sql = "UPDATE tbl_food SET
        title = ?,
        description = ?,
        price = ?,
        image_name = ?,
        category_id = ?,
        feature = ?,
        active = ?
        WHERE id = ?
        ";
        //2.
        $stmt = $conn->prepare($sql);

        //3.
        $stmt->bind_param("ssdsissi", $title, $description, $price, $image_name, $category, $feature, $active, $id);

        //4.
        if ($stmt->execute()) {
            // echo "Success";
            $_SESSION['update'] = '<div class="success">Food Update Successfully</div>';
            header('location:'.SETURL.'admin/manage-food.php'); // Redirect to a page
            exit;
        } else {
            // echo "Error: " . mysqli_error($conn);
            $_SESSION['update'] = '<div class="fail">Failed to Update Food</div>';
            header('location:'.SETURL.'admin/manage-food.php'); 
        }

        // 關閉預備語句和資料庫連線
        $stmt->close();
    }

    $conn->close();

    include('partials/footer.php'); 
?>