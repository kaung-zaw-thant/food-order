<?php include('partials-front/menu.php'); ?>

<?php 
    //check whether food id is set or not
    if(isset($_GET['food_id']))
    {
        //Get the food id and details of the selected food
        $food_id = $_GET['food_id'];

        //Get the details of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
        //Excute the Query
        $res = mysqli_query($conn, $sql);
        //Count the rows
        $count = mysqli_num_rows($res);
        //Check whether the data is available or not
        if($count==1)
        {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
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
                                if($image_name != "")
                                {
                            ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                                }
                                else
                                {
                                    echo "<div class='error'>Image not Available</div>";
                                }
                            ?>
                            </div>
            
                            <div class="food-menu-desc">
                                <h3><?php echo $title; ?></h3>
                                <input type="hidden" name="food" value="<?php echo $title; ?>">
                                <p class="food-price">$<?php echo $price; ?></p>
                                <input type="hidden" name="price" value="<?php echo $price; ?>">
                                <div class="order-label">Quantity</div>
                                <input type="number" name="qty" class="input-responsive" value="1" required>
                                
                            </div>

                        </fieldset>
                        
                        <fieldset>
                            <legend>Delivery Details</legend>
                            <div class="order-label">Full Name</div>
                            <input type="text" name="full-name" placeholder="Name" class="input-responsive" required>

                            <div class="order-label">Phone Number</div>
                            <input type="tel" name="contact" placeholder="09*******" class="input-responsive" required>

                            <div class="order-label">Email</div>
                            <input type="email" name="email" placeholder="******@gmail.com" class="input-responsive" required>

                            <div class="order-label">Address</div>
                            <textarea name="address" rows="10" placeholder="Street, City, Country" class="input-responsive" required></textarea>

                            <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                        </fieldset>

                    </form>

                </div>
            </section>
            <!-- fOOD sEARCH Section Ends Here -->

        <?php
        }
        else
        {
            //fodd not available
            //redirect to Home page
            header('location:'.SITEURL);
        }
    }
    else
    {
        //Redirect to homepage
        header("location:".SITEURL);
    }
?>

<?php
    //Check whether submt button is clicked or not
    if(isset($_POST['submit']))
    {
        // Get all the details from the form
        $food = $_POST['food'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $total = $price * $qty; 
        $order_date = date("Y-m-d h:i:sa"); //Order date
        $status = "Ordered"; //Ordered, On Delivery, Delivered, Cancelled
        $customer_name = $_POST['full-name'];
        $customer_contact = $_POST['contact'];
        $customer_email = $_POST['email'];
        $customer_address = $_POST['address'];


        //Save the Order in Database
        //Create SQL to save the data
        $sql = "INSERT INTO tbl_order (food,price,qty,total,order_date,status,customer_name,customer_contact,customer_email,customer_address)
        VALUES ('$food', '$price', '$qty', '$total', '$order_date', '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address')";

        $res = mysqli_query($conn, $sql);

        if($res)
        {
            //Query Executed and Order Saved
            $_SESSION['order'] = "<div class='alert alert-success d-inline-flex p-2 m-6' role='alert'>Food ordered successfully</div>";
            header('location:'.SITEURL);
        }
        else
        {
            //Failed to Save Order
            $_SESSION['order'] = "<div class='alert alert-danger' role='alert'>Failed to order food</div>";
            header('location:'.SITEURL);
        }


    }
?>

    <?php include('partials-front/footer.php'); ?>