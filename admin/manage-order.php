<?php include('partials/menu.php') ?>
    <div class="main">
        <h1>Manage Order</h1>
        <br/>
        <?php 
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update']; // Display session message
                unset($_SESSION['update']); // Remove session message
            }
        ?>
        <br/><br/><br/>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Customer Email</th>
                <th>Customer Address</th>
                <th>Actions</th>
            </tr>
            <?php 
                $conn = getDbConnection();
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                $res = $conn->query($sql);
                $count = $res->num_rows;
                $sn = 1;
                if($count > 0)
                {
                    while($row = $res->fetch_assoc())
                    {
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];

                        ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= $food ?></td>
                                <td>$<?= $price ?></td>
                                <td><?= $qty ?></td>
                                <td>$<?= $total ?></td>
                                <td><?= $order_date ?></td>
                                <td>
                                    <?php 
                                        if($status == "Ordered")
                                        {
                                            echo "<label >$status</label>";
                                        }
                                        elseif($status == "On Delivery")
                                        {
                                            echo "<label style='color: orange;'>$status</label>";
                                        }
                                        elseif($status == "Delivered")
                                        {
                                            echo "<label style='color: green;'>$status</label>";
                                        }
                                        elseif($status == "Cancelled")
                                        {
                                            echo "<label style='color: red;'>$status</label>";
                                        }
                                    ?>
                                </td>
                                <td><?= $customer_name ?></td>
                                <td><?= $customer_contact ?></td>
                                <td><?= $customer_email ?></td>
                                <td><?= $customer_address ?></td>
                                <td>
                                    <a href="<?php echo SETURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                                </td>
                            </tr>
                        <?php
                    }
                }

            ?>
        </table>

    </div>
<?php include('partials/footer.php') ?>