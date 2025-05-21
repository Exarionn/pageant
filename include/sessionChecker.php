<?php
// Check if the user is logged in as an admin
if(isset($_SESSION['admin'])){
    // Redirect to the admin header
    header('location: ../tri.admin/adminHome.php');
    exit();
}

// Check if the user is logged in as a judge
if(isset($_SESSION['judge'])){
    // Redirect to the judge header
    header('location: ../tri.judge/judgeHome.php');
    exit();
}

// Check if the user is logged in as a super
if(isset($_SESSION['super'])){
    // Redirect to the super header
    header('location: ../tri.super/superBackup.php');
    exit();
}

?>