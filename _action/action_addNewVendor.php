<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_POST['direct_access'])){echo "Invalid Direct Access"; }
else{
     require "../_config/general.php";
     require "../". VIEW_LIBRARIES."/generateController.php";
     $validate = new Controller;
     $validate->addVendor(strip_tags($_POST['vendor']),strip_tags($_POST['price']),strip_tags($_POST['temp']));
     ////$try = explode(".",$_POST['temp']);
     //print_r($try);
}

?>
 