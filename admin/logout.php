<?php 
    //Include constants.php
    include('../config/constants.php');
    //1. Destory the Session
    session_destroy();

    //2. Redirect to Login Page
    header('location:'.SITEURL.'admin/login.php');
?>