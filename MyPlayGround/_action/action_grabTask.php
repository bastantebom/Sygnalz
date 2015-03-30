<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_POST['direct_access'])){echo "Invalid Direct Access"; }
else{
     require "../_config/general.php";
     require "../". VIEW_LIBRARIES."/generateController.php";
     $validate = new Controller;
     $validate->grabTaskToVendor(strip_tags($_POST['task']),strip_tags($_POST['campaign']),strip_tags($_POST['vendor']),strip_tags($_POST['begin']));
     //echo strip_tags($_POST['task']).strip_tags($_POST['campaign']).strip_tags($_POST['vendor']).strip_tags($_POST['begin']);
     //echo "Trace";
    //
}

?>
 