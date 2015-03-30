<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_POST['direct_access'])){echo "Invalid Direct Access"; }
else{
     require "../_config/general.php";
     require "../". VIEW_LIBRARIES."/generateController.php";
     $validate = new Controller;
     $validate->sendVendorReply(strip_tags($_POST['id']),strip_tags($_POST['task']),strip_tags($_POST['from']),strip_tags($_POST['to']),strip_tags($_POST['creply']));
     //echo $_POST['reply_message'];
}

?>
 