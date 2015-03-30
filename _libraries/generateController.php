<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
require "generateView.php";
require "generateModel.php";

class Controller extends Model {
    
    function __construct() {
        //Initialize Database Connection
        $this->dbcon = $this->connectDatabase(HOST, USERNAME, PASSWORD, DATABASE_NAME);
    }

    function inputEmailValidate($content) {    
        ////simple validation check if email structure is valid.
        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)*.([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $content)) {
            echo $this->insertDatabase($this->dbcon, $content);
            $this->closeConnection($this->dbcon);
        } else {
            echo "Email address is Invalid";
        }
    }

    function queryUserList() {
        ///search for all Email listing
        $this->eaddListing = $this->updateUser($this->dbcon,"");
        echo $this->eaddListing;
    }
    
    function searchEmailAddress($content) {    
        ////simple validation check if email structure is valid.
        if (isset($content)&& $content!="" ) {
            echo $this->queryEmailAdd($this->dbcon, $content);
            $this->closeConnection($this->dbcon);
        } else {
            echo "Email address not Found";
        }
    }
    
    function checkUser($user,$pass){
        $usertemp = htmlentities(strip_tags($user));
        $passtemp = htmlentities(strip_tags($pass));
        echo $this->authenticateUser($this->dbcon,$usertemp,$passtemp);       
    }
    
    function connectUserType(){
        echo $this->usertypeSelected($this->dbcon,0,0);
    }
    
    function addUser($type,$full,$email,$usern,$passw,$phone){
        if(!empty($type) && !empty($full) && !empty($email) && !empty($usern) && !empty($passw) && !empty($phone)){
            if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)*.([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
                echo $this->insertUsertoList($this->dbcon,$type,$full,$email,$usern,$passw,$phone);
            }
            else{
                $error = $this->createDivLayerOpening("", "", "error_box","Invalid Email Address!");
                echo $error;
            }
        } else {
            $error = $this->createDivLayerOpening("", "", "error_box","Please complete the form before submission or Invalid Input!");
            echo $error;
        }
    }
    
    function delUser($uID){
        if(is_numeric($uID)){
            echo $this->deleteUser($this->dbcon,$uID);
        }
        else{
            $error = $this->createDivLayerOpening("", "", "error_box","Opps! Something is wrong!");
            echo $error;
        }
    }
    
    function upUser($uID){
        if(is_numeric($uID)){
            echo $this->updateUser($this->dbcon,$uID);
        }
        else{
            $error = $this->createDivLayerOpening("", "", "error_box","Opps! Something is wrong!");
            echo $error;
        }
    }
    
    function updateUserFinal($type,$full,$email,$usern,$phone,$target){
        
        if(!empty($type) && !empty($full) && !empty($email) && !empty($usern) && !empty($target) && !empty($phone)){
            if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)*.([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
                echo $this->updateToUserList($this->dbcon,$type,$full,$email,$usern,$phone,$target);
            }
            else{
                $error = $this->createDivLayerOpening("", "", "error_box","Invalid Email Address!");
                echo $error;
            }
        } else {
            $error = $this->createDivLayerOpening("", "", "error_box","Please complete the form before submission or Invalid Input!");
            echo $error;
        }
    }
    
    function queryCampaignList(){
        $this->ecampaignListing = $this->updateCampaign($this->dbcon,"");
        echo $this->ecampaignListing;
    }
    
    function addCampaign($campaign_name,$credit,$date){
        if(!empty($campaign_name) && !empty($credit) && !empty($date)){
            if(is_numeric($credit)){
                echo $this->insertCampignList($this->dbcon,$campaign_name,$credit,$date);
            }
            else{
                $error = $this->createDivLayerOpening("", "", "error_box","Credit is not a valid! It should be numerical value");
                echo $error;
            }
        } else {
            $error = $this->createDivLayerOpening("", "", "error_box","Please complete the form before submission or Invalid Input!");
            echo $error;
        }
    }
    
    function delCampaign($cID){
        if(is_numeric($cID)){
            echo $this->deleteCampaign($this->dbcon,$cID);
        }
        else{
            $error = $this->createDivLayerOpening("", "", "error_box","Opps! Something is wrong!");
            echo $error;
        }
    }
    
    function upCampaign($cID){
        if(is_numeric($cID)){
            echo $this->updateCampaign($this->dbcon,$cID);
        }
        else{
            $error = $this->createDivLayerOpening("", "", "error_box","Opps! Something is wrong!");
            echo $error;
        }
    }
    
    function updateCampaignFinal($desc,$credit,$date,$cid){
        
        if(!empty($desc) && !empty($credit) && !empty($date) && !empty($cid)){
            if (is_numeric($credit)) {
                echo $this->updateToCampaignList($this->dbcon,$desc,$credit,$date,$cid);
            }
            else{
                $error = $this->createDivLayerOpening("", "", "error_box","Invalid Credit Value!");
                echo $error;
            }
        } else {
            $error = $this->createDivLayerOpening("", "", "error_box","Please complete the form before submission or Invalid Input!");
            echo $error;
        }
    }
    
    function queryCustomerList(){
        echo $this->getCustomerListFromUser($this->dbcon,"");
    }
    
    function queryCustomerPlan(){
        echo $this->getPlanList($this->dbcon,"");
    }
    
    function getCustomerList(){
        echo $this->getCustomer($this->dbcon,"");
    }
    
    function addCustomer($customer,$plan){
        echo $this->insertCustomerList($this->dbcon,$customer,$plan);
        //echo "Test";
    }
    ////////to be edited
    function addVendor($vendor,$price,$temp){
        $try = explode(".",$temp);
        
        for($ctr=0;$ctr<=(count($try)-1);$ctr++){
            if($try[$ctr]!=""){
            $expertise[$ctr]=$try[$ctr];
            }
        }
        echo $this->insertVendorList($this->dbcon,$vendor,$price,$expertise);
        //echo "Test";
    }
    
    function delCustomer($cus_id){
        echo $this->deleteCustomer($this->dbcon,$cus_id);
    }
    
    function getVendorList(){
        echo $this->getVendor($this->dbcon,"");
    }
    
    function queryVendorList(){
        echo $this->getVendorListFromUser($this->dbcon,"");
    }

    function delVendor($ven_id){
        echo $this->deleteVendor($this->dbcon,$ven_id);
    }
    
    function queryVendorExpertise(){
        echo $this->getVendorExpertise($this->dbcon);
    }
    
    function queryPriceAction(){
       return $priceAction = "<select size='1' style='width:300px;' id='vendorPrice'>
                                <option value='.02'>.02</option>
                                <option value='.002'>.002</option>
                                <option value='.0002'>.0002</option>
                            </select>";
    }
    ////for customer login/////
    
    function queryCredit($user_id){
       echo $this->getCurrentCredit($this->dbcon,$user_id);
    }
    
    function queryDaysLeft($user_id){
       echo $this->countDown($this->dbcon,$user_id);
    }
    
    ////query task for creation ofcampaign task in customer portal
    function queryTask(){
        echo $this->getCustomerCampaign($this->dbcon);
    }
    
    /////get credit value of the campaign onchange of selection
    
   function queryCreditValue($campaignId){
       echo $this->getCampaignCreditValue($this->dbcon,$campaignId);
   }
   
   ////add campaign task
   function addCampaignTask($task,$credit,$url,$uid){
       if(!empty($task) && !empty($credit) && !empty($url) && !empty($uid)){
         echo $this->insertCampaignTask($this->dbcon,$task,$credit,$url,$uid);
       }
       else{
        $error = $this->createDivLayerOpening("", "", "error_box","Please complete the form before submission!");
        echo $error;
       }
   }
   
   function queryTaskList($uid){
       echo $this->getTaskList($this->dbcon,$uid);
   }
   
   function queryNotification($id){
       echo $this->getNotification($this->dbcon, $id);
   }
   
   function queryAvailableTask($id){
       echo $this->getCampaignTaskViewVendor($this->dbcon,$id);
   }
   
   function grabTaskToVendor($task,$campaign,$vendor,$begin){
       echo $this->upTask($this->dbcon,$task,$campaign,$vendor,$begin);
       //echo "Track";
   }
   
   function queryGrabTask($id){
       echo $this->getCampaignTaskGrabVendor($this->dbcon,$id);
   }
   
   function delTask($id){
       if($this->checkTask($this->dbcon, $id)==true){
        $error = $this->createDivLayerOpening("", "", "error_box","Opps! this task is In Progress you cannot delete it.!");
        echo $error;
       }
       else{
        echo $this->deleteTask($this->dbcon,$id);
       }
   }
   
   function addIssueTask($task,$campaign,$vendor,$problem){
       if($this->checkIssueTask($this->dbcon,$task)==true){
           $error = $this->createDivLayerOpening("", "", "error_box","Opps! this task has an existing Issue, Please wait to fixed it first");
            echo $error;
       }
       else{
           $problem = addslashes($problem);
            echo $this->insertIssueTask($this->dbcon,$task,$campaign,$vendor,$problem);
       }
   }
   
   function queryCountProblem(){
       echo $this->getCountProblem($this->dbcon);
   }
   
   function queryIssueList(){
       echo $this->getProblemList($this->dbcon);
   }
   
   function updateIssueTask($problem,$task,$to,$from,$problem_mes){
       $problem_mes = addslashes($problem_mes);
       echo $this->insertApprovedIssueTask($this->dbcon,$problem,$task,$to,$from,$problem_mes);
   }
   
   function sendReply($id,$task,$from,$to,$reply){
       $reply = addslashes($reply);
       echo $this->addReply($this->dbcon,$id,$task,$from,$to,$reply);
       //echo $reply;
   }
   
  function sendVendorReply($id,$task,$from,$to,$reply){
       $reply = addslashes($reply);
       echo $this->addVendorReply($this->dbcon,$id,$task,$from,$to,$reply);
       //echo $reply;
   }
   
   function fixedIssue($id,$uid){
       echo $this->fixedTaskIssue($this->dbcon,$id,$uid);
   }
   
   function endTaskToVendor($task,$campaign,$vendor,$end){
       echo $this->endTask($this->dbcon,$task,$campaign,$vendor,$end);
       //echo "Track";
   }
  
   function getOwed($vendor){
       echo $this->queryOwed($this->dbcon, $vendor);
   }
   
   function queryPaymentList($id){
       echo $this->getPaymentList($this->dbcon,$id);
   }
   
   function updatePayment($payment_id,$admin_id,$vendor){
       echo $this->upPayment($this->dbcon,$payment_id,$admin_id,$vendor);
   }
   
   function upVendor($id){
       echo $this->getVendor($this->dbcon,$id);
   }
   

   function saveUpdateVendor($vendor,$price,$temp){
        $try = explode(".",$temp);
        
        for($ctr=0;$ctr<=(count($try)-1);$ctr++){
            if($try[$ctr]!=""){
            $expertise[$ctr]=$try[$ctr];
            }
        }
        echo $this->updateVendorList($this->dbcon,$vendor,$price,$expertise);
        //echo "Test";
    }
   
}

?>