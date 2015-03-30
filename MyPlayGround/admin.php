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
        
    <h2>Manage User</h2>              
<table id="rounded-corner">
    <thead>
    	<tr>
            <th scope="col" class="rounded-company"></th>
            <th scope="col" class="rounded">Name</th>
            <th scope="col" class="rounded">User</th>
            <th scope="col" class="rounded">Email</th>
            <th scope="col" class="rounded">User Type</th>
            <th scope="col" class="rounded">Phone</th>
            <th scope="col" colspan="2" class="rounded-q4">ACTION</th>
            
        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="7" class="rounded-foot-left"><em>To Add User click the Add New User below.<br ><b style="color:#60C8F2;">User type can't be changed if they are set in Customer or Vendor.</b></em></td>
              
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
        </tfoot>
      
    <tbody id="userList">
    	<?php
            echo $componentsCreator->queryUserList();
        ?>
    </tbody>
</table>

     <a href="#" class="bt_green" id="basic"><span class="bt_green_lft"></span><strong>Add New User</strong><span class="bt_green_r"></span></a>     
 <div class="messageListener">
        
 </div> 
    </div><!-- end of right content-->   
<div id="update-modal" syle="display:none;"></div>   
<div id="basic-modal-content">
<div class="form">
 <h2>Add New User</h2>
<label for="email">User Type:</label>

 <?php echo $componentsCreator->connectUserType(); ?>                         
  
<form action="" method="post" class="niceform">
          
                <fieldset>

                    <dl>
                        <dt><label for="fullname">Full Name:</label></dt>
                        <dd><input type="text" name="" id="fullname" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="password">Email:</label></dt>
                        <dd><input type="text" name="email" id="email" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="password">Username:</label></dt>
                        <dd><input type="text" name="username" id="username" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="password">Password:</label></dt>
                        <dd><input type="password" name="username" id="password" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="password">Phone Number:</label></dt>
                        <dd><input type="text" name="" id="phonenumber" size="54" /></dd>
                    </dl>             
                     <dl class="submit">
                    <input type="submit" name="submit" id="addNewUser" value="Save" />
                     </dl>
     
                </fieldset>
                
 </form>
</div>
<div style="display:none;">
	<img src='img/x.png' alt='' />
</div>     
                   
</div>   <!--end of center content -->               
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