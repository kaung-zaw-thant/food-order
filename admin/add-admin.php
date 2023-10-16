<?php 
include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br/>
        <br/>
        <?php
            if(isset($_SESSION['add'])) //Checking whether the session is set of not
            {
                echo $_SESSION['add'];//Displaying Session Message
                unset($_SESSION['add']);//Removing Session Message
            }
        ?>
        <form method="POST">
            <div class="row col-6">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name:</label>
                    <input type="text" name="full_name" class="form-control" id="fullName" placeholder="Enter Name">
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control" id="userName" placeholder="Enter User Name">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php 
            // Process the value from From and Save it in Database
            // Check whether the submit butto is clicked or not

            if(isset($_POST['submit']))
            {
                //Button Clicked
                //Get Data from Form
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];
                $password = md5($_POST['password']);

                // 2.  SQL Query to Save the data into database
                $sql = "INSERT INTO tbl_admin SET full_name='$full_name',
                username='$username',password='$password'";

                //3. Excuting Query and Saving Data into Database
                $res = mysqli_query($conn, $sql); 

                //4. Check whether the (Query is Excuted) data is inserted or not and display appropriate message
                if($res)
                {
                $_SESSION['add'] = "<div class='alert alert-success' role='alert'>Admin is added successfully</div>";
                //Redirect Page
                header("location:".SITEURL."admin/manage-admin.php");
                // ob_end_flush();
                }
                else{
                    $_SESSION['add'] = "<div class='alert alert-danger' role='alert'>Failed to add admin</div>";
                //Redirect Page
                header("location:".SITEURL."admin/manage-admin.php");
                }
            }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

