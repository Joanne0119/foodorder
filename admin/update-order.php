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
                $sql = "SELECT * FROM tbl_order WHERE id = ?";
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
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                    } else {
                        $_SESSION['no-order-found'] = "<div class='fail'>Order Not Found</div>";
                        header('location: manage-order.php');
                        exit;
                    }
                } else {
                    header('location: manage-order.php');
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
    <form action="" method="POST"> 
    <!-- enctype="multipart/form-data" allow file upload -->
        <table>
            <tr>
                <td>Food Name: </td>
                <td>
                   <b> <?= $food ?> </b>
                </td>
            </tr>
            <tr>
                <td>Price: </td>
                <td>$<?= $price ?></td>
            </tr>
            <tr>
                <td>Qty: </td>
                <td><input type="number" name="qty" value="<?= $qty ?>"></td>
            </tr>
            <tr>
                <td>Status: </td>
                <td>
                    <select name="status">
                        <option <?php if($status == "Ordered"){ echo "selected"; } ?> value="Ordered">Ordered</option>
                        <option <?php if($status == "On Delivery"){ echo "selected"; } ?> value="On Delivery">On Delivery</option>
                        <option <?php if($status == "Delivered"){ echo "selected"; } ?> value="Delivered">Delivered</option>
                        <option <?php if($status == "Cancelled"){ echo "selected"; } ?> value="Cancelled">Cancelled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Customer Name: </td>
                <td><input type="text" name="customer_name" value="<?= $customer_name ?>"></td>
            </tr>
            <tr>
                <td>Customer Contact: </td>
                <td><input type="text" name="customer_contact" value="<?= $customer_contact ?>"></td>
            </tr>
            <tr>
                <td>Customer Email: </td>
                <td><input type="text" name="customer_email" value="<?= $customer_email ?>"></td>
            </tr>
            <tr>
                <td>Customer Address: </td>
                <td><textarea name="customer_address" cols="30" rows="5"><?= $customer_address ?></textarea></td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="price" value="<?= $price ?>">
                    <input type="submit" name="submit" value="Update Order" class="btn-primary">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php 
    if(isset($_POST['submit'])){
        //Get all the data
        $id = $_POST['id'];
        $price = floatval($_POST['price']);
        $qty = intval($_POST['qty']);
        $total = $price * $qty;
        $status = $_POST['status'];
        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email = $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];
        
        //Update Database
        $conn = getDbConnection();

        //1. sql query to update
        $sql = "UPDATE tbl_order SET
        price = ?,
        qty = ?,
        total = ?,
        status = ?,
        customer_name = ?,
        customer_contact = ?,
        customer_email = ?,
        customer_address = ?
        WHERE id = ?
        ";
        //2.
        $stmt = $conn->prepare($sql);

        //3.
        $stmt->bind_param("diisssssi", $price, $qty, $total, $status, $customer_name, $customer_contact, $customer_email, $customer_address, $id);

        //4.
        if ($stmt->execute()) {
            // echo "Success";
            $_SESSION['update'] = '<div class="success">Order Update Successfully</div>';
            header('location:'.SETURL.'admin/manage-order.php'); // Redirect to a page
            exit;
        } else {
            // echo "Error: " . mysqli_error($conn);
            $_SESSION['update'] = '<div class="fail">Failed to Update Order</div>';
            header('location:'.SETURL.'admin/manage-order.php'); 
            exit;
        }

        // 關閉預備語句和資料庫連線
        $stmt->close();
    }

    $conn->close();

    include('partials/footer.php'); 
?>