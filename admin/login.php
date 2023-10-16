<?php
ob_start();
include('../config/constants.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>

    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css"
    rel="stylesheet"
    />

    <link rel="stylesheet" href="../css/admin.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <style>
        .bg{
            background-image: url("../images/bg-login.jpg");
        }
    </style>
</head>
<body class="bg">

    <div class="card" style="width: 35%; margin: 10% auto;">
        <div class="card-body">
            <h2 class="text-center">Food Order System</h2><br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

            <!-- Login Form Starts here -->
            <form method="POST">
                <!-- username input -->
                <div class="form-outline mb-4">
                    <input type="text" name="username" id="userName" class="form-control" />
                    <label class="form-label" for="userName">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" name="password" id="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                    <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                    </div>

                    <div class="col">
                    <!-- Simple link -->
                    <a href="<?php echo SITEURL; ?>admin/update-password.php">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                <!-- Register buttons -->
                <div class="text-center">
                    <p>Not a member? <a href="#!">Register</a></p>
                    <p>or sign up with:</p>
                    <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-google"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-github"></i>
                    </button>
                </div>
            </form>
            </div>
        </div>

        <!-- MDB -->
        <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>

<?php

//Check whether the Submit Button is Clicked or not
if(isset($_POST['submit']))
{
    //Processs for Login
    //1. Get the data from login form
    echo $username = $_POST['username'];
    echo $password = md5($_POST['password']);

    //2. SQL to Check whether the user with username and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //Execute the Query
    $res= mysqli_query($conn,$sql);

    //4. Count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if($count==1)
    {
        //User available and login Success
        $_SESSION['login'] = "<div class='alert alert-success' role='alert'>Login is successful</div>";
        $_SESSION['user'] = $username; //To check whether the user is logged in or not and logout will unset it
        //Redirect to Home Page
        header('location:'.SITEURL.'admin/');

    }
    else
    {
        //User available and login Success
        $_SESSION['login'] = "<div class='alert alert-danger' role='alert'>User Name and Password do not math!</div>";
        //Redirect to Home Page
        header('location:'.SITEURL.'admin/login.php');
    }
}
?>