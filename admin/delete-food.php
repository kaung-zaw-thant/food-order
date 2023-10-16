<?php

    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to Delete

        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Check whether the image is available or not and delete only if available
        if($image_name != "")
        {
            //it has image and need to remove from folder
            //Get image's path
            $path = "../images/food/".$image_name;

            //remove image file from folder
            $remove = unlink($path);

            if(!$remove)
            {
                //Failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process
                die();
            }
        }

        //Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute query
        $res = mysqli_query($conn, $sql);

        if($res)
        {
            $_SESSION['delete'] = "<div class='success'>Food is deleted successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to delete food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        //Redirect to Manage Food Page
        $_SESSION['delete'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }