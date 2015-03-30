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

if($_SESSION['utype']!= 1){
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
    
<?php include"_include/admin_menu.php"; ?>
    <div class="center_content">  
    <div class="left_content">
    
    	<div class="sidebar_search">
            <form>
            <input type="text" name="" class="search_input" value="search keyword" onclick="this.value=''" />
            <input type="image" class="search_submit" src="images/search.png" />
            </form>            
        </div>
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>Notifications</h3>
                <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
                <ul>
                <li>New Task created by Customer 1</li>
                </ul>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
    </div>  
    
    <div class="right_content">            
        
    <h2>Manage Payment</h2>              
<table id="rounded-corner">
    <thead>
    	<tr>
            <th scope="col" class="rounded-company">Vendor</th>
            <th scope="col" class="rounded">Price/Action</th>
            <th scope="col" class="rounded">No. of Service</th>
            <th scope="col" class="rounded">Status</th>
            <th scope="col" class="rounded">Approved by</th>
            <th scope="col" class="rounded">Approved date</th>
            <th scope="col" colspan="2" class="rounded-q4">ACTION</th>
            
        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="7" class="rounded-foot-left"></td>
              
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
        </tfoot>
      
    <tbody id="problemList">
    	<?php
            //echo $componentsCreator->queryUserList();
        ?>
    </tbody>
</table>

         
 <div class="messageListener">
        
 </div> 
    </div><!-- end of right content-->   
<div id="update-modal" syle="display:none;"></div>   


                   
</div>   <!--end of center content -->               
    <div class="clear"></div>
    </div> <!--end of main content-->
	

    <div class="footer">
    
    	<div class="left_footer"><?php echo COMPANY_NAME ?> | Copyright 2012</div>
    	<div class="right_footer"><a href="http://www.sygnalz.com">LOGO HERE</a></div>
    
    </div>
		
<?php
//Insert Closing body
$componentsCreator->createPageFooter();
?>