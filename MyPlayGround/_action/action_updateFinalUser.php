<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_POST['direct_access'])){echo "Invalid Direct Access";}
else{
	require "../_config/general.php";
	require "../". VIEW_LIBRARIES."/generateController.php";
	$queryList = new Controller;
        if(!empty($_POST['target'])){
            $queryList->updateUserFinal(strip_tags($_POST['type']),strip_tags($_POST['full']),strip_tags($_POST['email']),strip_tags($_POST['usern']),strip_tags($_POST['phone']),strip_tags($_POST['target']));
        }
        else{
            echo $error = $queryList->createDivLayerOpening("", "", "error_box","Opps! Something Wrong");
         
        }
 }
?>
