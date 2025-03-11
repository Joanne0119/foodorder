<!-- from Vijay Thapa Toutorials
https://github.com/vijaythapa333/web-design-course-restaurant?tab=readme-ov-file -->

<?php include('partials/menu.php'); ?>

            <?php
                if(isset($_GET['food_id'])){
                    $food_id = isset($_GET['food_id']) ? $_GET['food_id'] : 0;

                    $conn = getDbConnection();
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM tbl_food WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $food_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $title = $row["title"];
                        $price = $row["price"];
                        $image_name = $row["image_name"];
                    } 
                    else {
                        echo '<div class="fail">Food Not Found</div>';
                        header("location:" . SETURL);
                        exit;
                    }      
                }
                else{
                    echo '<div class="fail">Unauthorized Access</div>';
                    header("location:" . SETURL);
                    exit;
                }
            ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                            if($image_name == ""){
                                echo "<div class='fail'>Image Not Available</div>";

                            }
                            else{
                                ?>
                                    <img src="image/food/<?= $image_name; ?>" alt="<?= $title; ?>" class="img-responsive img-curve">
                                <?php
                            }

                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?= $title; ?></h3>
                        <input type="hidden" name="food" value="<?= $title; ?>">
                        <p class="food-price">$<?= $price; ?></p>
                        <input type="hidden" name="price" value="<?= $price; ?>">
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                if(isset($_POST['submit'])){
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $order_date = date("Y-m-d h:i:sa");
                    $status = "Ordered"; //Ordered, On Delivery, Delivered, Cancelled
                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    $sql2 = "INSERT INTO tbl_order SET
                        food = ?,
                        price = ?,
                        qty = ?,
                        total = ?,
                        order_date = ?,
                        status = ?,
                        customer_name = ?,
                        customer_contact = ?,
                        customer_email = ?,
                        customer_address = ?
                    ";

                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bind_param("sdidssssss", $food, $price, $qty, $total, $order_date, $status, $customer_name, $customer_contact, $customer_email, $customer_address);
                    if($stmt2->execute()){  
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                        header("location:" . SETURL);
                        exit;  
                    }
                    else{
                        $_SESSION['order'] = "<div class='fail text-center'>Failed to Order Food.</div>";
                        header("location:" . SETURL);
                        exit;
                    }
                }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- social Section Starts Here -->
    <section class="social">
        <div class="container text-center">
            <ul>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a>
                </li>
            </ul>
        </div>
    </section>
    <!-- social Section Ends Here -->

    <?php include('partials/footer.php'); ?>