<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" id="" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="text" name="price" placeholder="Price of the food">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category_id" id="">

                        <?php

                            //Create PHP code to display categories from Database
                            //1. Create SQL to get all active categories from database

                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            $res = mysqli_query($conn, $sql);

                            //Count Rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            if($count>0)
                            {
                                while($rows = mysqli_fetch_assoc($res))
                                {    
                                    $id = $rows['id'];
                                    $title = $rows['title'];
                        ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                        <?php
                                }
                            }
                            else
                            {
                        ?>
                                <option value="0">No Category Found</option>
                        <?php
                            }
                        ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" id="" value="Yes">Yes
                        <input type="radio" name="featured" id="" value="No" checked>No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" id="" value="Yes">Yes
                        <input type="radio" name="active" id="" value="No" checked>No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="btn-secondary" name="submit" value="Add Food">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

    if(isset($_POST['submit']))
    {
        //1. Get the data from form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        //2. Upload the image if selected
        //Check whethr the image is selected or not and set the value for image name according

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
                //stop the process
                die();
            }
        }
        else
        {
            //Don't Upload Image and set the image_name value as blank
            $image_name = "";
        }

        //3. Insert Into Database
        $sql = "INSERT INTO tbl_food (title,description,image_name,price,category_id,featured,active) VALUES ('$title','$description','$image_name', '$price', '$category_id', '$featured', '$active')";

        //Excute Query
        $res = mysqli_query($conn, $sql);

        if($res)
        {
            $_SESSION['add'] = "<div class='success'>Food is added successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['add'] = "<div class='error'>Failed to add food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

    }
    else
    {

    }
?>

<?php include('partials/footer.php'); ?>