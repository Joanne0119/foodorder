<!-- from Vijay Thapa Toutorials
https://github.com/vijaythapa333/web-design-course-restaurant?tab=readme-ov-file -->

<?php include('partials/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                $conn = getDbConnection();
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM tbl_category
                        WHERE active = 'Yes'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        if ($image_name == "") {
                            $image_name = "No-Image.png";
                            echo "<div class='fail'>Image Not Available</div>";
                        }     
                        else{
                            echo '<a href="category-foods.html">
                            <div class="box-3 float-container">
                                <img src="image/category/'.$image_name.'" alt="'.$title.'" class="img-responsive img-curve">
                                <h3 class="float-text text-white">'.$title.'</h3>    
                            </div>
                            </a>';
                        }
                    }
                }
                else{
                    echo "<div class='fail'>Category Not Added</div>";
                }


            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


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