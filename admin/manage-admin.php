<?php include('partials/menu.php') ?>
        <div class="main">
            <h1>Manage Admin</h1>
            <br/>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add']; // Display session message
                    unset($_SESSION['add']); // Remove session message
                }
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; // Display session message
                    unset($_SESSION['delete']); // Remove session message
                }
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update']; // Display session message
                    unset($_SESSION['update']); // Remove session message
                }
                if(isset($_SESSION['update-password']))
                {
                    echo $_SESSION['update-password']; // Display session message
                    unset($_SESSION['update-password']); // Remove session message
                }
                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found']; // Display session message
                    unset($_SESSION['user-not-found']); // Remove session message
                }
                if(isset($_SESSION['password-not-match']))
                {
                    echo $_SESSION['password-not-match']; // Display session message
                    unset($_SESSION['password-not-match']); // Remove session message
                }
            ?>
            </br>
            <a href="add-admin.php" class="btn-primary">add admin</a>
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    $conn = getDbConnection();

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM tbl_admin"; //get the data
                    $result = $conn->query($sql);

                    $sn = 1;

                    if ($result->num_rows > 0) {  
                        while($row = $result->fetch_assoc()) { //run through the result data, and print it out
                        ?>
                         <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= $row["full_name"]; ?></td>
                            <td><?= $row["username"]; ?></td>
                            <td>
                                <a href="<?php echo SETURL; ?>admin/update-password.php?id=<?php echo $row["id"]; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SETURL; ?>admin/update-admin.php?id=<?php echo $row["id"]; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SETURL; ?>admin/delete-admin.php?id=<?php echo $row["id"]; ?>" class="btn-danger">Delete Admin</a>
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
    