<?php include('partials/menu.php') ?>
    <div class="main">
        <h1>Manage Food</h1>
        <br/>
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
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update']; // Display session message
                unset($_SESSION['update']); // Remove session message
            }
            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove']; // Display session message
                unset($_SESSION['remove']); // Remove session message
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete']; // Display session message
                unset($_SESSION['delete']); // Remove session message
            }
            if(isset($_SESSION['no-food-found']))
            {
                echo $_SESSION['no-food-found']; // Display session message
                unset($_SESSION['no-food-found']); // Remove session message
            }
            if(isset($_SESSION['unauthorize']))
            {
                echo $_SESSION['unauthorize']; // Display session message
                unset($_SESSION['unauthorize']); // Remove session message
            }
        ?>
        <br/>
        <a href="<?php echo SETURL; ?>admin/add-food.php" class="btn-primary">add food</a>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Feature</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php
                $conn = getDbConnection();

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM tbl_food"; //get the data
                $result = $conn->query($sql);

                $sn = 1;

                if ($result->num_rows > 0) {  
                    while($row = $result->fetch_assoc()) { //run through the result data, and print it out
                    ?>
                        <tr>
                        <td><?= $sn++; ?></td>
                        <td><?= $row["title"]; ?></td>
                        <td>$<?= $row["price"]; ?></td>
                        <td><?= $row["description"]; ?></td>
                        <td>
                            <?php
                                if($row["image_name"] != ""){
                                    ?>
                                    <img src="<?php echo SETURL; ?>image/food/<?php echo $row["image_name"]; ?>" width="150px"> 
                                    <?php
                                }
                                else{
                                    echo "<div class='fail'>Image Not Added</div>";
                                }
                            ?>
                        </td>
                        <td><?= $row["feature"]; ?></td>
                        <td><?= $row["active"]; ?></td>
                        <td>
                            <a href="<?php echo SETURL; ?>admin/update-food.php?id=<?php echo $row["id"]; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php echo SETURL; ?>admin/delete-food.php?id=<?php echo $row["id"]; ?>&image_name=<?php echo $row["image_name"]; ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>

                    <?php
                    }
                } else {
                    echo "No Data";
                }
                
            ?>
        </table>

    </div>
<?php include('partials/footer.php') ?>