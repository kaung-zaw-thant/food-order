<?php 
include('../config/constants.php');
include('login-check.php');
?>
<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    </head>

    <body>
    <?php ob_start(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <!-- Menu Section Starts -->
        <!-- <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div> -->
        <!-- <ul class="nav nav-tabs justify-content-end h-auto">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage-admin.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage-category.php">Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage-food.php">Food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage-order.php">Order</a>
            </li>
            <li class="logout.php">
                <a class="nav-link">Log Out</a>
            </li>
        </ul>     -->

        <nav class="navbar navbar-expand-lg" style="background-color: #ff4757;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="manage-admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="manage-category.php">Category</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="manage-food.php">Food</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="manage-order.php">Order</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log Out</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        
        <!-- Menu Section Ends -->