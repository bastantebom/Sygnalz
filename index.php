<?php 
session_start();

//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['name']);
}

require "_config/general.php";
require VIEW_LIBRARIES."/generateView.php";
//$content = "";

//Instanciate the Components Object
$componentsCreator = new Components;
$componentsCreator->createPageHeader(COMPANY_NAME,JQUERY_DIR,JAVASCRIPT_DIR,CSS_DIR);
?>

<div id="main_container">

<div class="login_form">
         
         <h3><?php echo COMPANY_NAME?> Login</h3>
         
         <a href="#" class="forgot_pass">Forgot password</a> 
         
         <form action="_action/action_Authenticate.php" method="post" class="niceform">
         
                <fieldset>
                    <dl>
                        <dt><label for="email">Username:</label></dt>
                        <dd><input type="text" name="username" id="username" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">Password:</label></dt>
                        <dd><input type="password" name="password" id="password" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                    <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Remember me</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="submit" id="submitbtn" value="Enter" style="width:100px;float:right;margin-right: 20px;"/>
                     </dl>
                    
                </fieldset>
         </form>
     
   
    <div class="footer" style="width:600px;">
    	<div class="left_footer"><?php echo COMPANY_NAME ?> | Copyright 2012</div>
    	<div class="right_footer"><a href="http://www.sygnalz.com">LOGO HERE</a></div>
    </div>
</div> 
</div>		
<?php
//Insert Closing body
$componentsCreator->createPageFooter();
?>