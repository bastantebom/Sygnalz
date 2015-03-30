<?php 
session_start();
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){
   header("location:index.php");
exit();
   // print $_SESSION['username']
}

if($_SESSION['utype']!= 2){
header("location:index.php");
exit(); 
}

require "_config/general.php";
require VIEW_LIBRARIES."/generateController.php";
//Instanciate the Components Object
$componentsCreator = new Controller;
$componentsCreator->createPageHeader(COMPANY_NAME,JQUERY_DIR,JAVASCRIPT_DIR,CSS_DIR);
?>

<div id="main_container">

<?php include"_include/panel_header.php"; ?>
    
    <div class="main_content">
    
<?php include"_include/vendor_menu.php"; ?>
    <div class="center_content">  
    <div class="left_content">
    
    	<div class="sidebar_search">
            <form>
            <input type="text" name="" class="search_input" value="search keyword" onclick="this.value=''" />
            <input type="image" class="search_submit" src="images/search.png" />
            </form>            
        </div>
         <input type="hidden" id="userIdHolder" value="<?php echo $_SESSION['uid']; ?>"/>
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>Notifications</h3>
               <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
                <span class="customerNote"><?php echo $componentsCreator->queryNotification($_SESSION['uid']); ?></span>               
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
         
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>Owed Amount</h3>
               <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
               <br />
               <br />
               <h2 class="vendorOwed"><?php echo " USD". $componentsCreator->getOwed($_SESSION['uid']); ?></h2> 
                              
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
    </div>  
    
    <div class="right_content">            
        
    <h2>Available Campaign Task</h2>              
<table id="rounded-corner">
    <thead>
    	<tr>
            <th scope="col" class="rounded-company">Campaign</th>
            <th scope="col" class="rounded">URL or Title</th>
            <th scope="col" class="rounded">Customer</th>
            <th scope="col" class="rounded">Start Count</th>
            <th scope="col" class="rounded">End Count</th>
            <th scope="col" class="rounded">Status</th>
            
            <th scope="col" colspan="2" class="rounded-q4">ACTION</th>
            
        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="7" class="rounded-foot-left"></td>
              
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
        </tfoot>
      
    <tbody id="vendorCampaignTask">
    	<?php
            echo $componentsCreator->queryAvailableTask($_SESSION['uid']);
        ?>
    </tbody>
</table>
<br />
<h2>Grab Campaign Task</h2>              
<table id="rounded-corner">
    <thead>
    	<tr>
            <th scope="col" class="rounded-company">Campaign</th>
            <th scope="col" class="rounded">URL or Title</th>
            <th scope="col" class="rounded">Customer</th>
            <th scope="col" class="rounded">Start Count</th>
            <th scope="col" class="rounded">End Count</th>
            <th scope="col" class="rounded">Status</th>
            
            
            
            <th scope="col" colspan="2" class="rounded-q4">ACTION</th>
            
        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="7" class="rounded-foot-left"></td>
              
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
        </tfoot>
      
    <tbody id="vendorGrabTask">
    	<?php
            echo $componentsCreator->queryGrabTask($_SESSION['uid']);
        ?>
    </tbody>
</table> 



 <div class="messageListener">      
 </div> 
    
    </div><!-- end of right content-->   
            
    <div class="clear"></div>
    </div> <!--end of main content-->
	
</div>
    <div class="footer">
    
    	<div class="left_footer"><?php echo COMPANY_NAME ?> | Copyright 2012</div>
    	<div class="right_footer"><a href="http://www.sygnalz.com">LOGO HERE</a></div>
    
    </div>

		
<?php
//Insert Closing body
$componentsCreator->createPageFooter();
?>