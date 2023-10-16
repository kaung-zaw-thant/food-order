<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count > 0)
                {
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
            ?>
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
            <?php
                        if($image_name != "")
                        {
            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
            <?php
                        }
                        else
                        {
                            echo "<div class='error'>Category not found</div>";
                        }
                        ?>
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                            </a>
                        <?php
                    }
                }
            ?>

            <!-- <a href="category-foods.php">
                <div class="box-3 float-container">
                        <img src="http://localhost/food-order/images/category/Food_Category_912.jpg" alt="Pizza" class="img-responsive img-curve">
                        <h3 class="float-text text-white">Yogurt</h3>
                </div>
            </a>

            <a href="category-foods.php">
                <div class="box-3 float-container">
                        <img src="http://localhost/food-order/images/category/Food_Category_912.jpg" alt="Pizza" class="img-responsive img-curve">
                        <h3 class="float-text text-white">Yogurt</h3>
                </div>
            </a>

            <a href="category-foods.php">
                <div class="box-3 float-container">
                        <img src="http://localhost/food-order/images/category/Food_Category_912.jpg" alt="Pizza" class="img-responsive img-curve">
                        <h3 class="float-text text-white">Yogurt</h3>
                </div>
            </a> -->

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>