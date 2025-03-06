<!-- from Vijay Thapa Toutorials
https://github.com/vijaythapa333/web-design-course-restaurant?tab=readme-ov-file -->

<?php include('partials/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?= SETURL ?>foods-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                $conn = getDbConnection();
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];

                        if($image_name == ""){
                            $image_name = "No-Image.png";
                            echo "<div class='fail'>Image Not Available</div>";
                        }
                        else{
                            echo "<div class='food-menu-box'>
                                <div class='food-menu-img'>
                                <img src='image/food/$image_name' alt='$title' class='img-responsive img-curve'>
                                </div>

                                <div class='food-menu-desc'>
                                    <h4>$title</h4>
                                    <p class='food-price'>$$price</p>
                                    <p class='food-detail text-limit'>
                                        $description
                                    </p>
                                    <br>

                                    <a href='#' class='btn btn-primary'>Order Now</a>
                                </div>
                            </div>";
                        }
                    }
                }
                else{
                    echo "<div class='fail'>No Food Added</div>";
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