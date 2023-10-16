<?php include("partials/menu.php");
?>

<?php
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        
        //SQL Query to get the selected food
        $sql = "SELECT * FROM tbl_food WHERE id=$id";

        //Execute Query
        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($res);

        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];

    }
    else
    {

    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1><br><br>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tb-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" id="" value="<?php echo $title; ?>" placeholder="Food Title goes here">
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" id="" value=<?php echo $price; ?>>
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                    <?php
                        if($current_image != "")
                        {
                    ?>
                            <img src="../images/food/<?php echo $current_image; ?>" class="img-category" alt="">
                    <?php
                        }
                        else
                        {
                    ?>
                            <div class="error">Image is not added</div>
                            
                    <?php
                        }
                    ?>
                    <br><br>
                    <input type="file" name="image" id="">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category_id" id="">

                        <?php
                            $category_sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            $category_res = mysqli_query($conn, $category_sql);

                            $count = mysqli_num_rows($category_res);

                            //check whether category available or not
                            if($count > 1)
                            {
                                while($category_row = mysqli_fetch_assoc($category_res))
                                {
                                    $catagory_id = $category_row['id'];
                                    $catagory_title = $category_row['title'];
                                    
                                    ?>
                                        <option <?php if($catagory_id == $current_category){echo "selected";}?> value="<?php echo $catagory_id; ?>"><?php echo $catagory_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "<option value='0'>Category No available!</option>";
                            }
                    
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" <?php if($featured == "Yes"){ echo "checked"; } else{echo "";}?> name="featured" id="" value="Yes">Yes
                        <input type="radio" <?php if($featured == "No"){ echo "checked"; } else{echo "";}?> name="featured" id="" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" <?php echo $checked = ($active == "Yes") ? "checked" : ""; ?> name="active" id="" value="Yes">Yes
                        <input type="radio" <?php echo $checked = ($active == "No") ? "checked" : ""; ?> name="active" id="" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include("partials/footer.php");
?>

<?php

    if(isset($_POST['submit']))
    {
        //Get all the details from the form
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];
        $current_image = $_POST['current_image'];

        //upload the image if selected
        if($_FILES['image']['name'] != "")
        {
            //Upload the Image
            //To upload image we need image name , source path and destination path
            $image_name = $_FILES['image']['name'];

            //Auto Rename our Image
            //Get the Extension of our image(jpg, png, gif, etc) e.g. "special.food.jpg"
            $ext = end(explode('.', $image_name));

            //Rename the Image
            $image_name = "Food_Name_".rand(000, 999).'.'.$ext; // e.g. Food_Category_001.jpg


            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/food/".$image_name;

            //Finally Upload the Image
            $upload = move_uploaded_file($source_path, $destination_path);

            //Check whether the image is uploaded or not
            //And if the image is not uploaded then we will stop the process and redirect with error message
            if(!$upload)
            {
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                //redirect to Manage food
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process
                die();
            }

            if($current_image != "")
            {
                //Current image is available
                //remove the image
                $remove_path = "../images/food/".$current_image;

                $remove = unlink($remove_path);

                //Check whether the image is removed or not
                if(!$remove)
                {
                    //failed to remove current image
                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die();
                }
            }
            
        }
        else
        {
            $image_name = $current_image;
        }

        //Update the food is database
        $upt_sql = "UPDATE tbl_food SET title = '$title', description = '$description', price = '$price', image_name = '$image_name', category_id = '$category_id', featured = '$featured', active = '$active' WHERE id = $id"; 

        //Excute Query
        $res = mysqli_query($conn, $upt_sql);

        if($res)
        {
            $_SESSION['update-food'] = "<div class='success'>Food is updated successfully";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['update-food'] = "<div class='error'>Failed to update</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
?>