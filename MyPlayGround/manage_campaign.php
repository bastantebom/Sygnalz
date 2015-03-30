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
        
                <h2>Manage Campaign</h2>              
                <table id="rounded-corner">
                    <thead>
                        <tr>
                            <th scope="col" class="rounded-company"></th>
                            <th scope="col" colspan="1" class="rounded">Campaign</th>
                            <th scope="col" class="rounded">Credit</th>
                            <th scope="col" colspan="1" class="rounded">Date Created</th>
                            <th scope="col" colspan="2" class="rounded-q4">ACTION</th>

                        </tr>
                    </thead>
                        <tfoot>
                        <tr>
                                <td colspan="5" class="rounded-foot-left"><em>To Add Campaign click the Add New Campaign below.</em></td>
                                <td class="rounded-foot-right">&nbsp;</td>

                        </tr>
                        </tfoot>

                    <tbody id="campaignList">
                        <?php
                            echo $componentsCreator->queryCampaignList();
                        ?>
                    </tbody>
                </table>

                <a href="#" class="bt_green" id="campaign"><span class="bt_green_lft"></span><strong>Add New Campaign</strong><span class="bt_green_r"></span></a>     
            
                <div class="messageListener">

                </div> 
    </div><!-- end of right content-->   
    
        <div id="update-modal" syle="display:none;"></div>   
        <div id="basic-modal-content">
            <div class="form">
                <h2>Add New Campaign</h2>                     
                    <form action="" method="post" class="niceform">
                            <fieldset>
                                <dl>
                                    <dt><label for="fullname">Campaign:</label></dt>
                                    <dd><input type="text" name="" id="campaign_name" size="54" /></dd>
                                </dl>

                                <dl>
                                    <dt><label for="password">Credit:</label></dt>
                                    <dd><input type="text" name="email" id="credit" size="54" /></dd>
                                </dl>
                                <dl>
                                    <dt><label for="password">Date:</label></dt>
                                    <dd><input type="text" name="username" id="curr_date" disabled="disabled" value="<?php echo $componentsCreator->dateNow(); ?>" size="54" /></dd>
                                </dl>
                                <dl class="submit">
                                <input type="submit" name="submit" id="addNewCampaign" value="Save" />
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