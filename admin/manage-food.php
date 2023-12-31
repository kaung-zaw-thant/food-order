<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['unauthorize']))
            {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

            if(isset($_SESSION['remove-failed']))
            {
                echo $_SESSION['remove-failed'];
                unset($_SESSION['remove-failed']);
            }

            if(isset($_SESSION['update-food']))
            {
                echo $_SESSION['update-food'];
                unset($_SESSION['update-food']);
            }
        ?>
        <br><br>

        <!-- Button to Add Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
            <br/>
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                <?php
                    //Create a SQL Query to Get all the food
                    $sql = "SELECT * FROM tbl_food";

                    //Execute query
                    $res = mysqli_query($conn, $sql);

                    //Count Rows to check whether we have foods or not
                    $count = mysqli_num_rows($res);
                    $sn = 1;

                    if($count>0)
                    {
                        //we have food in database
                        //var_dump(mysqli_fetch_assoc($res));
                        while($row = mysqli_fetch_assoc($res))
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $price; ?></td>
                                <td>
                                    <?php
                                        if($image_name != "")
                                        {
                                    ?>
                                            <img src="../images/food/<?php echo $image_name; ?>" alt="" class="img-category">
                                    <?php
                                        }
                                        else
                                        {
                                            echo "<div class='error'>Image is not added</div>";
                                        }
                                    ?>
                                    
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete</a>
                                </td>
                            </tr>
                <?php
                        }

                    }
                    else
                    {
                        echo "<tr><td><div class='error'>Food is not added</div></td></tr>";
                    }


                ?>
                
            </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>