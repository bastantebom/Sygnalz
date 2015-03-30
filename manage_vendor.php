<?php 
session_start();
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
require "_include/security.php";
require "_config/general.php";
require VIEW_LIBRARIES."/generateController.php";

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
        
                <h2>Manage Vendor</h2>              
                <table id="rounded-corner">
                    <thead>
                        <tr>
                            <th scope="col" class="rounded-company"></th>
                            <th scope="col"  class="rounded">Name</th>
                            <th scope="col" class="rounded">Campaign Expertise</th>
                            <th scope="col" class="rounded">Price per Action</th>
                            <th scope="col"  class="rounded">Date Created</th>
                            
                            <th scope="col" colspan="2" class="rounded-q4">ACTION</th>

                        </tr>
                    </thead>
                        <tfoot>
                        <tr>
                                <td colspan="6" class="rounded-foot-left"><em>To Add Vendor click the Add New Vendor below.</em></td>
                                <td class="rounded-foot-right">&nbsp;</td>

                        </tr>
                        </tfoot>

                    <tbody id="vendorList">
                        <?php
                            echo $componentsCreator->getVendorList();
                        ?>
                    </tbody>
                </table>

                <a href="#" class="bt_green" id="campaign"><span class="bt_green_lft"></span><strong>Add New Vendor</strong><span class="bt_green_r"></span></a>     
            
                <div class="messageListener">

                </div> 
    </div><!-- end of right content-->   
    
        <div id="update-modal" syle="display:none;"></div>   
        <div id="basic-modal-content">
            
            <div class="form">
                <h2>Add New Vendor</h2> 
                                <dl>
                                    <dt><label for="fullname">List of Vendor:</label></dt>
                                    <dd><?php echo $componentsCreator->queryVendorList(); ?></dd>
                                </dl>
                
                                 <dl>
                                    <dt><label for="password">Price per Action:</label></dt>
                                    <dd><?php echo $componentsCreator->queryPriceAction(); ?></dd>
                                </dl>
                
                                <dl>
                                    <dt><label for="password">Expertise:</label></dt>
                                    <dd style="text-align: left;" id="vexpertise"><?php $componentsCreator->queryVendorExpertise(); ?></dd>
                                    
                                </dl>
                    <form action="" method="post" class="niceform">
                            <fieldset>
                                
                                <dl>
                                    <dt><label for="password">Date Created:</label></dt>
                                    <dd><input type="text" name="username" id="created" disabled="disabled" value="<?php echo $componentsCreator->timeNow(); ?>" size="54" /></dd>
                                </dl>
                                
                                <dl class="submit">
                                <input type="submit" name="submit" id="addNewVendor" value="Save" />
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
</div>    

		
<?php
//Insert Closing body
$componentsCreator->createPageFooter();
?>