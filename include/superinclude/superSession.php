<?php 
$super = $_SESSION['super'];

if(!isset($super)){
   header('location: ../include/401.php');
};
?>