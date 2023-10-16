<?php include('partials/menu.php'); ?>

 <div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }

        ?>

        <form action="" method="post" >
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" id="" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" id="" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" id="" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
 </div>

 <?php
    //Check whether the Submit Button is Clicked or not
    if(isset($_POST['submit']))
    {
        // 1. Get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. Check whether the user with current ID and Current Password Exists or Not
        $sql = "SELECT * FROM tbl_admin WHERE id='$id' AND password='$current_password'";
        //3. Check whether the new password and confirm password math or not
        $res = mysqli_query($conn,$sql);

        if($res)
        {
            //Check whether data is available or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //User Exists and Password can be changed

                //Check whether the new password and confirm match or not
                if($new_password == $confirm_password)
                {
                    //Update the password
                    $upt_sql = "UPDATE tbl_admin SET password='$new_password'
                    WHERE id=$id";

                    //Execue the Query
                    $upt_res = mysqli_query($conn, $upt_sql);

                    //Check whether the query excuted or not
                    if($upt_res)
                    {
                        //Display message
                        //Redirect to Manage Admin Page withe Error Message
                        $_SESSION['change-pwd'] = "<div class='error'>Password changed Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');

                    }
                    else
                    {
                        //Display message
                        //Redirect to Manage Admin Page withe Error Message
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change Password</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    
                }
                else
                {
                    //Redirect to Manage Admin Page withe Error Message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //User does not exist set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User Not found</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        //4. Change password if all above is true
    }
 ?>

<?php include('partials/footer.php'); ?>