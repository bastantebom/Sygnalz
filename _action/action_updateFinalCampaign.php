<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_POST['direct_access'])){echo "<div class='error_box'>Invalid Direct Access</div>";}
else{
	require "../_config/general.php";
	require "../". VIEW_LIBRARIES."/generateController.php";
	$queryList = new Controller;
        if(!empty($_POST['camp_id'])){
            $queryList->updateCampaignFinal(strip_tags($_POST['campaign_desc']),strip_tags($_POST['credit']),strip_tags($_POST['campaign_date']),strip_tags($_POST['camp_id']));
        }
        else{
            echo $error = $queryList->createDivLayerOpening("", "", "error_box","Opps! Something Wrong");
         
        }
 }
?>
