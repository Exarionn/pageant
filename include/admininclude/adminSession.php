<?php 
$admin = $_SESSION['admin'];

if(!isset($admin)){
   header('location: ../include/401.php');
};
?>