<?php
if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){
   header("location:index.php");
exit();
   // print $_SESSION['username']
}
?>
