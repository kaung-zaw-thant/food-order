<?php
 //Include Constants File
 include('../config/constants.php');
 //Check whether the id and image name value is set or not
 if(isset($_GET['id']) AND isset($_GET['image_name']))
 {
    //Get the value and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical image file is available
    if($image_name != "")
    {
        //Image is Available. So remove it
        $path = "../images/category/".$image_name;
        //Remove the image
        $remove = unlink($path);

        //If failed to remove image then add an error and stop the process
        if(!$remove)
        {
            //Set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
            //Stop the Process

        }
    }

    //Delete Data from Database
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //Check whether the data is delete from database or not
    if($res)
    {
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to delete Category</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    //Redirect to Manage Category Page with Message
    
 }
 else
 {
    //redirect to Manage Category Page
    header('location:'.SITEURL.'admin/manage-category.php');
 }
?>