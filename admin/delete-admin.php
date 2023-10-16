<?php  

 //Include constants.php file here
 include('../config/constants.php');
 //1. get the ID of Admin to be deleted
 $id = $_GET['id'];

 //2. Create SQL Query to Delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//Execute the Query
$res = mysqli_query($conn, $sql);

// Check whether the query excuted successfully or not
if($res)
{
    //Query Executed successfully and Admin Deleted
    //Create session variable to Display Message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
    //Redirect to Manage Admin Page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    //Failed to Delete Admin
    $_SESSION['delete'] = "Failed to Delete Admin. Try Again Later.";
    header('location:'.SITEURL.'admin/manage-admin.php');
}

 //3. Redirect to Manage Admin page with message (success/error)

?>