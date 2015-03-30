<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_POST['ven_id'])){echo "<div class='error_box'>Invalid Direct Access</div>"; }
else{
     require "../_config/general.php";
     require "../". VIEW_LIBRARIES."/generateController.php";
     $validate = new Controller;
     $validate->delVendor($_POST['ven_id']);
}
?>
