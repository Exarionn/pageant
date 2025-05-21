<?php 
$judge = $_SESSION['judge'];

if(!isset($judge)){
   header('location: ../include/401.php');
};
?>