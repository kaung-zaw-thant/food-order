<?php include('partials/menu.php'); ?>

<?php 
    //Check whether the id is set or not
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        //Create SQL Query to get all other details
        $sql = "SELECT * FROM tbl_category WHERE id=$id";

        //Excute the Query
        $res = mysqli_query($conn, $sql);

        //Count the Rows to check whether the id is valid or not
        $count = mysqli_num_rows($res);

        if($count ==1)
        {
            //Get all the data
            $rows = mysqli_fetch_assoc($res);
            $title = $rows['title'];
            $current_image = $rows['image_name'];
            $featured = $rows['featured'];
            $active = $rows['active'];
        }
        else
        {
            //redirect to manage category with session message
            $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" id="">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                        ?>
                                <img src="../images/category/<?php echo $current_image; ?>" alt="" class="img-category">
                        <?php

                            }
                            else
                            {
                                echo "<div class='error'>Image is not added</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes" id="">Yes
                        <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No" id="">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes" id="">Yes
                        <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No" id="">No
                    </td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php  echo $current_image; ?>">
                    <td><input type="submit" name="submit" value="Update Category" class="btn-secondary"></td> 
                </tr>
            </table>
        </form>

        <?php

            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //Check whether the image is selected or not
                if($_FILES['image']['name'] != "")
                {
                    //Get the Image Details
                    $image_name = $_FILES['image']['name'];
                    //Auto Rename our Image
                    //Get the Extension of our image(jpg, png, gif, etc) e.g. "special.food.jpg"
                    $ext = end(explode('.', $image_name));

                    //Rename the Image
                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. Food_Category_001.jpg


                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //Finally Upload the Image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Check whether the image is uploaded or not
                    //And if the image is not uploaded then we will stop the process and redirect with error message
                    if(!$upload)
                    {
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    die();
                    }


                    if($current_image != "")
                    {
                        //Remove the Current Image
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);

                        //Check whether the image is removed or not
                        if(!$remove)
                        {
                            //Failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current Image</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }
                    }
                     
                }
                else
                {
                    $image_name = $current_image;
                }

                $upd_sql = "UPDATE tbl_category SET title = '$title',
                featured = '$featured',image_name = '$image_name', active = '$active' WHERE id=$id";

                $upt_res = mysqli_query($conn, $upd_sql);

                if($upt_res)
                {
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='sucess'>Failed to Update Category</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {

            }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>