<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
//if(!isset($_POST['direct_access'])){echo "Invalid Direct Access"; }
//else{
     require "../_config/general.php";
     require "../". VIEW_LIBRARIES."/generateController.php";
     $validate = new Controller;
     $validate->addCustomer(strip_tags($_POST['customer']),strip_tags($_POST['plan']));
//}

?>
 