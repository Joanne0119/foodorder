<!-- from Vijay Thapa Toutorials
https://github.com/vijaythapa333/web-design-course-restaurant?tab=readme-ov-file -->

<?php include('partials/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
                if(isset($_GET['category_title'])){
                    $category_title = $_GET['category_title'];
                }
                else{
                    header('location:' . SETURL);
                }
            ?>
            
            <h2>Foods on <a href="#" class="text-white">"<?= $category_title ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                if(isset($_GET['category_id'])){
                    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;

                    if ($category_id > 0){
                        $conn = getDbConnection();
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT * FROM tbl_food WHERE category_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $category_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $description = $row['description'];
                                $image_name = $row['image_name'];

                                echo '<div class="food-menu-box">
                                        <div class="food-menu-img">
                                            <img src="image/food/'.$image_name.'" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        </div>    
                                        <div class="food-menu-desc">
                                            <h4>'.$title.'</h4>
                                            <p class="food-price">$'.$price.'</p>
                                            <p class="food-detail text-limit">
                                                '.$description.'
                                            </p>
                                            <br>
                                            <a href="order.php?food_id='.$id.'" class="btn btn-primary">Order Now</a>
                                        </div>
                                    </div>';
                            }
                        }   
                        else{
                            echo "<div class='fail'>No Food Available</div>";
                        }
                        $conn->close();
                    }
                }
                else{
                    header('location:' . SETURL);
                }

            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

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