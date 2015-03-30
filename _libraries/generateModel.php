<?php
ob_start();
class Model extends Components{
    //global $dbcon;
        ////connect to database
	function connectDatabase($host,$user,$pass,$db){
                //Connection with the database
		$this->dbcon = new mysqli($host, $user, $pass, $db);
                return $this->dbcon;
	}
        
        ////closes connection to database
	function closeConnection($conn){
                //Closing Database Connection
		$conn->close();
	}
        
        ///insert new User to tbl_user
	function insertUsertoList($conn,$type,$full,$email,$usern,$pass,$phone){
                //Insert email Address on the database
                $passw = md5($pass);
		$conn->query("INSERT INTO tbl_user(fullname,screenname,emailadd,username,password,usertype,phonenumber,initial,user_set) VALUES('$full','','$email','$usern','$passw','$type','$phone',1,'')") or Die(mysql_error());
		$error = $this->createDivLayerOpening("", "", "valid_box","User successfully created!");
                
                return $error;
                //return $
	}

        ///Authenticate user in login area
        function authenticateUser($conn,$user,$temppass){
                $pass= md5($temppass);
                 $resultAuthUser = $conn->query("SELECT * FROM tbl_user WHERE username = '$user' and password = '$pass' ");
                 $resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC);
                 
                 if($resultAuthUser->num_rows == 1){    
                     $_SESSION['username'] = $resultData['username'];
                     $_SESSION['password'] = $resultData['password'];
                     $_SESSION['name'] = $resultData['fullname'];
                      $_SESSION['uid'] = $resultData['userid'];
                      $_SESSION['utype'] = $resultData['usertype'];
                     $type=$resultData['usertype'];
                     switch($type){
                         case 1:
                             header("location:../admin.php");
                             exit();
                         break;
                     
                         case 2:
                              header("location:../vendor.php");
                             exit();
                         break;
                     
                         case 3:
                              header("location:../customer.php");
                             exit();
                         break;
                     
                     }
                 
                } 
                else{
                    
                    header("location:../index.php");
                    exit();
                }
        }
        
        ///Delete User in the tbl_user
        function deleteUser($conn,$user_I_D){
           $conn->query("DELETE FROM tbl_user WHERE userid='$user_I_D'");
           $error = $this->createDivLayerOpening("", "", "warning_box","User successfully deleted!");
           return $error;
        }
        
        function deleteTask($conn,$user_I_D){
           $resultSet = $conn->query("SELECT * FROM tbl_customer a INNER JOIN tbl_task b ON a.user_id = b.customer_id WHERE task_id ='$user_I_D'");
           $resultData=$resultSet->fetch_array(MYSQLI_ASSOC);
           $user = $resultData['user_id'];
           $updateCredit = $resultData['customer_credit'] + $resultData['task_credit'];
           $conn->query("UPDATE tbl_customer SET customer_credit = '$updateCredit' WHERE user_id ='$user'");
           $conn->query("DELETE FROM tbl_task WHERE task_id='$user_I_D'");
           $error = $this->createDivLayerOpening("", "", "warning_box","Task successfully deleted!");
           return $error;
        }
        
        ///display editable fields in table
        function updateUser($conn,$user_I_D){
          $resultAuthUser = $conn->query("SELECT * FROM tbl_user a INNER JOIN tbl_usertype b ON a.usertype = b.usertypeid");
          $finaldat = "";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
            if($user_I_D==$resultData['userid']){
             $stemp = $this->usertypeSelected($conn, $resultData['usertype'],$user_I_D);
              $finaldat.= "<tr>
                        <td><input type='checkbox' /></td>
                        <td><input type='text' value='$resultData[fullname]' id='fulln' style='width:80px;font-size:11px;' /></td>
                        <td><input type='text' value='$resultData[username]' id='usern' style='width:40px;font-size:11px;'/></td>
                        <td><input type='text' value='$resultData[emailadd]' id='emailn' style='width:170px;font-size:11px;'/></td>
                        <td>$stemp</td>
                        <td><input type='text' value='$resultData[phonenumber]' id='phonen' style='width:70px;font-size:11px;'/></td>
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[userid]' />
                        <td colspan='2'><img src='images/save.jpg' style='width:16px;height:16px;' alt='$resultData[userid]' onclick='saveupUser(this.alt)' border='0' /></td>
                        
                    </tr>";  
            }
            else{
              $finaldat.= "<tr>
               
                        <td><input type='checkbox' /></td>
                        <td>$resultData[fullname]</td>
                        <td>$resultData[username]</td>
                        <td>$resultData[emailadd]</td>
                        <td>$resultData[usertypedesc]</td>
                        <td>$resultData[phonenumber]</td>
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[userid]' />
                        <td><img src='images/user_edit.png' alt='$resultData[userid]' class='editUser' onclick='updateUserAccount(this.alt)' border='0' /></td>
                        <td><img src='images/trash.png' alt='$resultData[userid]' title='' class='deleteUser' onclick='delUserAccount(this.alt)'  border='0' /></td>
                    </tr>";
            }
          }
          return $finaldat;
           
        }
        
     ///Check if what type of User  
     public function usertypeSelected($conn,$utype,$uid){
          $finaldata ="";
           $result = $conn->query("SELECT * FROM tbl_usertype");
              if($utype!="xT"){
              $top="<select id='usert' style='width:60px;font-size:11px;'>";
              }
              else{
              $top="<select id='usertype' style='width:300px;'>";
              }
                ///get all email address and create a table to display
                while($resultData=$result->fetch_array(MYSQLI_ASSOC)){
                    if($utype==$resultData['usertypeid']){
                       $finaldata.= "<option selected='selected' value='$resultData[usertypeid]'>$resultData[usertypedesc]</option>";
                            if($resultData['usertypeid']==3){
                                $found = $this->checkCustomerExist($conn,$uid);
                            }
                            else{
                                $found = $this->checkVendorExist($conn,$uid);
                            }
                                if($found =="Yes"){
                                    $top="<select id='usert' disabled='disabled' style='width:60px;font-size:11px;'>";
                                }
                    }
                    //$name=;
                    else{
                       $finaldata.= "<option value='$resultData[usertypeid]'>$resultData[usertypedesc]</option>";
                    }
                }
                $end = "</select>";
           return $top.$finaldata.$end;
      }
      
     ////Update User 
     function updateToUserList($conn,$type,$full,$email,$usern,$phone,$target){
         $conn->query("UPDATE tbl_user SET fullname='$full', emailadd='$email', username='$usern',usertype='$type',phonenumber='$phone' WHERE userid='$target'") or Die(mysql_error());
         $error = $this->createDivLayerOpening("", "", "valid_box","User successfully updated!");
         return $error;
     }
     
     ///Insert New Campaign
     function insertCampignList($conn,$campaign_name,$credit,$date){
         $conn->query("INSERT INTO tbl_campaign(campaign_credit,campaign_date_created,campaign_desc) VALUES('$credit','$date','$campaign_name')") or Die(mysql_error());
	 $error = $this->createDivLayerOpening("", "", "valid_box","Campaign successfully created!");
                
         return $error;
     }
     
     ///Delete Campaign
     function deleteCampaign($conn,$campaign_I_D){
           $conn->query("DELETE FROM tbl_campaign WHERE campaign_id='$campaign_I_D'");
           $error = $this->createDivLayerOpening("", "", "warning_box","Campaign successfully deleted!");
           return $error;
     }
     
     ////
      function updateCampaign($conn,$campaign_I_D){
          $resultAuthUser = $conn->query("SELECT * FROM tbl_campaign");
          $finaldat = "";
          
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
            if($campaign_I_D==$resultData['campaign_id']){
             
              $finaldat.= "<tr>
                        <td><input type='checkbox' /></td>
                        <td colspan='1'><input type='text' value='$resultData[campaign_desc]' id='campaign_desc' style='width:200px;font-size:11px;' /></td>
                        <td><input type='text' value='$resultData[campaign_credit]' id='credit' style='width:40px;font-size:11px;'/></td>
                        <td><input type='text' disabled='disabled' value='$resultData[campaign_date_created]' id='campaign_date' style='width:120px;font-size:11px;'/></td>
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[campaign_id]' />
                        <td colspan='2'><img src='images/save.jpg' style='width:16px;height:16px;' alt='$resultData[campaign_id]' onclick='saveupCampaign(this.alt)' border='0' /></td>
                        
                    </tr>";  
            }
            else{
              $finaldat.= "<tr>
                        <td><input type='checkbox' /></td>
                        <td colspan='1'>$resultData[campaign_desc]</td>
                        <td>$resultData[campaign_credit]</td>
                        <td>$resultData[campaign_date_created]</td>
                       
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[campaign_id]' />
                        <td><img src='images/user_edit.png' alt='$resultData[campaign_id]' class='editUser' onclick='upCampaign(this.alt)' border='0' /></td>
                        <td><img src='images/trash.png' alt='$resultData[campaign_id]' title='' class='deleteUser' onclick='delCampaign(this.alt)'  border='0' /></td>
                    </tr>";
            }
          }
          return $finaldat;
           
        }
        
        function updateToCampaignList($conn,$desc,$credit,$date,$id){
         $conn->query("UPDATE tbl_campaign SET campaign_desc='$desc', campaign_credit='$credit', campaign_date_created='$date' WHERE campaign_id='$id'") or Die(mysql_error());
         $error = $this->createDivLayerOpening("", "", "valid_box","Campaign successfully updated!");
         return $error;
       } 
       
       function getCustomerListFromUser($conn,$cus_id){
         $resultAuthUser = $conn->query("SELECT * FROM tbl_user WHERE usertype = 3 AND user_set != 1");
          $finaldat = "";
          $header = "<select name='cusUser' id='customerUser' style='width:300px;'><option></option>";
          $end ="</select>";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
              $finaldat.= "
                 <option value='$resultData[userid]'>$resultData[fullname]</option>";
          }
          return $header.$finaldat.$end;
       }
       
       function getPlanList($conn,$plan_id){
         if(!is_numeric($plan_id)){
          $resultAuthUser = $conn->query("SELECT * FROM tbl_plan");
          $finaldat = "";
          $header = "<select name='planList' id='customerPlan' style='width:300px;'><option></option>";
          $end ="</select>";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
              $finaldat.= "
                 <option value='$resultData[plan_id]'>$resultData[plan_credit] credits</option>";
          }
          
          return $header.$finaldat.$end;
         }
         
         else{
             $resultAuthUser = $conn->query("SELECT * FROM tbl_plan WHERE plan_id = '$plan_id'");
             $resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC);
             return $resultData['plan_credit'];
         }
       }
        ///Edit customer on this area
       function getCustomer($conn,$cusId){
           $resultAuthUser = $conn->query("SELECT * FROM tbl_customer a LEFT JOIN tbl_user b ON a.user_id = b.userid LEFT JOIN tbl_plan c ON a.plan_id = c.plan_id");
           $finaldat = "";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
            if($cusId==$resultData['user_id']){
              $finaldat.= "<tr>
                        <td><input type='checkbox' /></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[user_id]' />
                        <td colspan='2'><img src='images/save.jpg' style='width:16px;height:16px;' alt='$resultData[user_id]' onclick='saveupUser(this.alt)' border='0' /></td>
                        
                    </tr>";  
            }
            else{
                
               $start = date('Y-m-d', $resultData['plan_started']);
               $end = date('Y-m-d', $resultData['plan_end']);
               $finaldat.= "<tr>    
                        <td><input type='checkbox' /></td>
                        <td>$resultData[fullname]</td>
                        <td>$resultData[plan_credit] credits/month</td>
                        <td>$resultData[customer_credit]</td>
                        <td>$start</td>
                        <td>$end</td>
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[user_id]' />
                       
                        <td><img src='images/trash.png' alt='$resultData[user_id]' title='' class='deleteUser' onclick='delCustomer(this.alt)'  border='0' /></td>
                    </tr>";
            }
          }
          return $finaldat;
       }
       
       function insertCustomerList($conn,$customer,$plan){
         $plan_credit = $this->getPlanList($conn, $plan);
         $timeNow = time();
         $timeNextMonth = time() + (30 * 24 * 60 * 60);
         
         if($this->checkCustomerExist($conn, $customer)=="Yes"){
            $error = $this->createDivLayerOpening("", "", "error_box","Customer already exist!"); 
            return $error; 
         }
         else{
            $conn->query("INSERT INTO tbl_customer(plan_id,user_id,customer_credit,plan_started,plan_end) VALUES('$plan','$customer','$plan_credit','$timeNow','$timeNextMonth')") or Die(mysql_error());
            $conn->query("UPDATE tbl_user SET user_set='1' WHERE userid='$customer'");
            $error = $this->createDivLayerOpening("", "", "valid_box","Customer successfully created!"); 
            return $error;
         }
       }
       
       function checkCustomerExist($conn,$user_id){
            $resultAuthUser = $conn->query("SELECT * FROM tbl_customer WHERE user_id = '$user_id'");
            if($resultAuthUser->num_rows == 1){
                return "Yes";
            }
       }
       
       function deleteCustomer($conn,$cus_id){
           $conn->query("DELETE FROM tbl_customer WHERE user_id='$cus_id'");
           $conn->query("UPDATE tbl_user SET user_set='' WHERE userid='$cus_id'");
           $error = $this->createDivLayerOpening("", "", "warning_box","Customer successfully deleted!");
           return $error;
           
       }

       ////////Create DB For this method Customize
        function insertVendorList($conn,$vendor,$price,$expertise){
         //$plan_credit = $this->getPlanList($conn, $plan);
         $timeNow = time();
         //$timeNextMonth = time() + (30 * 24 * 60 * 60);
         
         $arrExpertise = serialize($expertise);
         
         if($this->checkVendorExist($conn, $vendor)=="Yes"){
            $error = $this->createDivLayerOpening("", "", "error_box","Customer already exist!"); 
            return $error; 
         }
         else{
            $conn->query("INSERT INTO tbl_vendor(user_id,vendor_expertise,vendor_priceaction,date_created,extra) VALUES('$vendor','$arrExpertise','$price','$timeNow','')") or Die(mysql_error());
            $conn->query("UPDATE tbl_user SET user_set='1' WHERE userid='$vendor'");
            $error = $this->createDivLayerOpening("", "", "valid_box","Customer successfully created!"); 
            return $error;
         }
       }
       
       function checkVendorExist($conn,$vendor){
            $resultAuthUser = $conn->query("SELECT * FROM tbl_vendor WHERE user_id = '$vendor'");
            if($resultAuthUser->num_rows == 1){
                return "Yes";
            }
       }
       
       ///////for  of vendor
       function getVendor($conn,$ven_id){
          $resultAuthUser = $conn->query("SELECT * FROM tbl_vendor a LEFT JOIN tbl_user b ON a.user_id = b.userid");
          $finaldat = "";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
            if($ven_id==$resultData['user_id']){
              $listExpertise = $this->getListExpertiseEdit($conn,$ven_id,$resultData['vendor_expertise']); 
              $pricePerAction = $this->getPriceAction($conn, $ven_id, 0);
               $date = date('Y-m-d', time());
              $finaldat.= "<tr>
                        <td><input type='checkbox' /></td>
                        <td><input type='text' value='$resultData[fullname]' id='vendor_name' disabled='disabled' style='width:65px;font-size:11px;' /></td>
                        <td>$listExpertise</td>
                        <td>$pricePerAction</td>
                        <td><input type='text' value='$date' id='vendor_date'disabled='disabled' style='width:65px;font-size:11px;' /></td>
                        <td></td>
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[user_id]' />
                        <td colspan='2'><img src='images/save.jpg' style='width:16px;height:16px;' alt='$resultData[user_id]' onclick='saveupVendor(this.alt)' border='0' /></td>
                        
                    </tr>";  
            }
            else{
               $listExpertise = $this->getListExpertise($conn,0,$resultData['vendor_expertise']);
               $date = date('Y-m-d', $resultData['date_created']);
               //$end = date('Y-m-d', $resultData['plan_end']);
               $finaldat.= "<tr>    
                        <td><input type='checkbox' /></td>
                        <td>$resultData[fullname]</td>
                        <td>$listExpertise</td>
                        <td>$resultData[vendor_priceaction]</td>
                        <td>$date</td>
                       
                        <input type='hidden' class='userId' name='nuserId' value='$resultData[user_id]' />
                        <td><img src='images/user_edit.png' alt='$resultData[user_id]' title='' class='editVendor' onclick='editVendor(this.alt)'  border='0' /></td>
                        <td><img src='images/trash.png' alt='$resultData[user_id]' title='' class='deleteUser' onclick='delVendor(this.alt)'  border='0' /></td>
                    </tr>";
            }
          }
          return $finaldat;
       }
       
       function deleteVendor($conn,$ven_id){
           $conn->query("DELETE FROM tbl_vendor WHERE user_id='$ven_id'");
           $conn->query("UPDATE tbl_user SET user_set='' WHERE userid='$ven_id'");
           $error = $this->createDivLayerOpening("", "", "warning_box","Vendor successfully deleted!");
           return $error;
       }
       
       function getVendorListFromUser($conn,$ven_id){
          $resultAuthUser = $conn->query("SELECT * FROM tbl_user WHERE usertype = 2 AND user_set != 1");
          $finaldat = "";
          $header = "<select name='venUser' id='vendorUser' style='width:300px;'><option></option>";
          $end ="</select>";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
              $finaldat.= "
                 <option value='$resultData[userid]'>$resultData[fullname]</option>";
          }
          return $header.$finaldat.$end;
       }
       
       function getVendorExpertise($conn){
          $resultAuthUser = $conn->query("SELECT * FROM tbl_campaign");
          $finaldat = "";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
              $finaldat.="<input type='checkbox' name='vendorExpertise[]' id='expertise' value='$resultData[campaign_id]' /><label class='check_label'>$resultData[campaign_desc]</label><br />";
          }
          return $finaldat;
       }
       
       function getListExpertise($conn,$id,$expertise){
           
           $actExpertise="";
             $arrExpertise = unserialize($expertise);
                $queryCampaign = $conn->query("SELECT * FROM tbl_campaign");
                while($resultCampaign=$queryCampaign->fetch_array(MYSQLI_ASSOC)){
                   if(empty($id)){
                        if(in_array($resultCampaign['campaign_id'], $arrExpertise)){
                           $actExpertise.="<input type='checkbox' checked='checked' disabled='disabled' name='vendorExpertise[]' id='expertise' value='$resultCampaign[campaign_id]' /><label class='check_label'>$resultCampaign[campaign_desc]</label><br />"; 
                        }
                   }
                    
                }
             return $actExpertise;
       }
       
       
       function getListExpertiseEdit($conn,$id,$expertise){
           $head = "<div id='vexpertise'>";
           $bottom = "</div>";
           $actualExpertise="";
             $arrExpertise = unserialize($expertise);
                $queryCampaign = $conn->query("SELECT * FROM tbl_campaign");
                while($resultCampaign=$queryCampaign->fetch_array(MYSQLI_ASSOC)){
                   if(empty($id)){
                        if(in_array($resultCampaign['campaign_id'], $arrExpertise)){
                           $actualExpertise.="<input type='checkbox' checked='checked' disabled='disabled' name='vendorExpertise[]' id='expertise' value='$resultCampaign[campaign_id]' /><label class='check_label'>$resultCampaign[campaign_desc]</label><br />"; 
                        }
                   }
                   else{
                       if(in_array($resultCampaign['campaign_id'], $arrExpertise)){
                           $actualExpertise.="<input type='checkbox' checked='checked' name='vendorExpertise[]' id='expertise' value='$resultCampaign[campaign_id]' /><label class='check_label'>$resultCampaign[campaign_desc]</label><br />"; 
                       }
                       else{
                           $actualExpertise.="<input type='checkbox' name='vendorExpertise[]' id='expertise' value='$resultCampaign[campaign_id]' /><label class='check_label'>$resultCampaign[campaign_desc]</label><br />"; 
                           
                       }
                     
                   }
                    
                }
                $actualExpertise = $head.$actualExpertise.$bottom;  
             return $actualExpertise;
       }
                  
       
       
       function getCurrentCredit($conn,$user){
            $queryCredit = $conn->query("SELECT * FROM tbl_customer WHERE user_id = '$user'");
               $resultCredit=$queryCredit->fetch_array(MYSQLI_ASSOC);
                return $resultCredit['customer_credit'];
       }
       
       function countDown($conn,$user){
           $queryCredit = $conn->query("SELECT * FROM tbl_customer WHERE user_id = '$user'");
           $resultCredit=$queryCredit->fetch_array(MYSQLI_ASSOC);
           $now = time();
           $daysCount = $resultCredit['plan_end'] - $now;
           $daysLeft = floor($daysCount/(24*60*60));
           
           if($daysLeft > 0){
               return $daysLeft;
           }
           else{
               $this->getCurrentCredit($conn, $user);
               return $this->resetCreditandDays($conn,$user);
           }
           //return date('Y-m-d', $resultCredit['plan_end']);
       }
       
       function resetCreditandDays($conn,$user){
         return $this->getPlanCredit($conn, $user);
       }
       
       function getPlanCredit($conn,$user){
           $queryCredit = $conn->query("SELECT * FROM tbl_customer a LEFT JOIN tbl_plan b ON a.plan_id = b.plan_id WHERE user_id = '$user' ");
           $resultCredit=$queryCredit->fetch_array(MYSQLI_ASSOC);
           $upCreditValue = ceil($resultCredit['customer_credit']/2) + $resultCredit['plan_credit'];  
           return $this->updateCustomerCredit($conn,$user,$upCreditValue);
       }
       
       function updateCustomerCredit($conn,$user,$upCreditValue){
           $timeNow = time();
           $timeNextMonth = time() + (30 * 24 * 60 * 60);
           if($this->createNotification($conn,$user,0,1,0)==true){
            $conn->query("UPDATE tbl_customer SET customer_credit = '$upCreditValue', plan_started='$timeNow', plan_end = '$timeNextMonth'  WHERE user_id='$user'");
            return $this->countDown($conn, $user);
           }
           else{
            return $this->countDown($conn, $user); 
           }
       }
 
       ///this will create a notification
       function createNotification($conn,$user_id,$sender,$note_type,$task){
           $time = time();
           switch($note_type) {
               case 1:
                    $notification_message = "Your monthly credit and number of days to expired has been reset";
               break;
           
               case 2:
                   $notification_message = "Task is grab by ";
               break;
               
               case 3:
                   $notification_message = "Have an issue click on campaign for details. created by ";
               break;
           
               case 4:
                   $notification_message = "Issue has been Approved! ";
               break;
           
               case 5:
                   $notification_message = "Campaign Issue has been replied by ";
               break;
           
               case 6:
                   $notification_message = "Issue has been fixed ";
               break;
           
               case 7:
                   $notification_message = "Campaign already been done by ";
               break;
           
               case 8:
                   $notification_message = "Balance has been cleared by ";
               break;
                    
               default:
               break;
           }
           $conn->query("INSERT INTO tbl_notification(user_id,note_message,note_status,extra,extra2,task_id) 
                     VALUES('$user_id','$notification_message',1,'$time','$sender','$task')") or Die(mysql_error());
           return true;
       }
       
       function getNotification($conn,$user_id){
           $queryCampaign = $conn->query("SELECT * FROM tbl_notification WHERE user_id = '$user_id' ORDER BY note_id DESC LIMIT 5");
           $notification = "";
           if($queryCampaign->num_rows > 0){
               while($resultCredit = $queryCampaign->fetch_array(MYSQLI_ASSOC)){
                  $you = $this->getName($conn, $resultCredit['extra2']);
                  
                  if($resultCredit['task_id']!=0){
                  $notification_task = $this->getTaskName($conn, $resultCredit['task_id']);
                  
                  $noteDisp = "<i><b>".date("F-d",$resultCredit['extra'])."</b></i><b> ". $notification_task."</b> ".$resultCredit['note_message']." ".$you;
                   $notification.= "<ul class='note'><li>$noteDisp</li></ul>";  
                  }
                  else{
                   $noteDisp = "<i><b>".date("F-d",$resultCredit['extra'])."</b></i> ".$resultCredit['note_message']." ".$you;
                   $notification.= "<ul class='note'><li>$noteDisp</li></ul>";  
                  }
               }
           }
           else{
               $notification = "<ul class='note'><li>No Notification</li></ul>";
           } 
           return $notification;
       }
       
       //////for customer login///////
       function getCustomerCampaign($conn){
           $queryCampaign = $conn->query("SELECT * FROM tbl_campaign");
           $listTask="";
           $head="<select id='taskSelection' style='width:300px;'><option></option>";
           $tail="</select>";
           while($resultCampaign=$queryCampaign->fetch_array(MYSQLI_ASSOC)){
               $listTask.="<option value='$resultCampaign[campaign_id]' />$resultCampaign[campaign_desc]</option>"; 
           }
           return $head.$listTask.$tail;
       }
       
       function getCampaignCreditValue($conn,$campaignId){
           $queryCampaign = $conn->query("SELECT * FROM tbl_campaign WHERE campaign_id = '$campaignId'");
           $resultCredit = $queryCampaign->fetch_array(MYSQLI_ASSOC);
         return $resultCredit['campaign_credit'];
       }
       
       ////task status
       // 1 - open
       // 2 - on progress
       // 3 - issue
       // 4 - approve by admin
       // 5 - 
       // 6 - done
       
       function insertCampaignTask($conn,$task,$credit,$url,$uid){
           if($this->getCurrentCredit($conn,$uid)>=$credit){
                $timeNow = time();
                //return $uid = $_SESSION['uid'];
                $conn->query("INSERT INTO tbl_task(campaign_id,url,task_credit,start_count,end_count,customer_id,vendor_id,transaction_id,date_created,task_status,extra,extra2) 
                    VALUES('$task','$url','$credit',0,0,'$uid',0,0,'$timeNow',1,0,0)") or Die(mysql_error());
                $upCredit = $this->getCurrentCredit($conn,$uid) - $credit;
                $conn->query("UPDATE tbl_customer SET customer_credit = '$upCredit' WHERE user_id='$uid'");
                $error = $this->createDivLayerOpening("", "", "valid_box","Customer successfully created task!"); 
                return $error;
           }
           else{
               $error = $this->createDivLayerOpening("", "", "error_box","Sorry!, You don't have enough credit balance!"); 
                return $error;
           }
       }
       
       function getTaskList($conn,$uid){
         $resultAuthUser = $conn->query("SELECT * FROM tbl_task WHERE customer_id = '$uid'");
          $finaldat = "";
          while($resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC)){
              if($resultData['task_status']==3){$status="In Progress";}
              else{$status=$this->checkTaskStatus($resultData['task_status']);}
              $description=$this->getCampaign($conn,$resultData['campaign_id']);
              $vendor=$this->getName($conn,$resultData['vendor_id']);
              $date = date('Y-m-d', $resultData['date_created']);
               //$end = date('Y-m-d', $resultData['plan_end']);
               $start=$this->getCampignCount($resultData['start_count']);
               $end=$this->getCampignCount($resultData['end_count']);
               if($resultData['task_status']==4){
                   $resultAuthUserX=$conn->query("SELECT * FROM tbl_problem WHERE task_id = '$resultData[task_id]'");
                   $resultDataX=$resultAuthUserX->fetch_array(MYSQLI_ASSOC);
         
                   
                   $message=stripslashes($resultDataX['problem_message']);
                   if($resultDataX['problem_state']==2){
                    $finaldat.= "<tr style='background:#FA8072;'>    
                        
                        <td style='background:#FA8072;'>$description</td>
                        <td style='background:#FA8072;'>$resultData[url]</td>
                        <td style='background:#FA8072;'>$date</td>
                        <td style='background:#FA8072;'>$status</td>
                        <td style='background:#FA8072;'>$start</td>
                        <td style='background:#FA8072;'>$end</td>
                        <td style='background:#FA8072;'>$vendor</td>
                        <td style='background:#FA8072;'><img src='images/notice.png' alt='$resultDataX[problem_id]' title='' class='viewtaskIssue' onclick='viewTaskIssue(this.alt)'  border='0' />
                        
                        <td style='background:#FA8072;'><img src='images/valid.png' style='width:24px;height:24px;' alt='$resultDataX[task_id]' title='' class='viewtaskIssue' onclick='fixedIssueTask(this.alt)'  border='0' /></td>
                   </tr>";   
                   }
                   else{
                   $finaldat.= "<tr style='background:#FA8072;'>    
                        
                        <td style='background:#FEE8AA;'>$description</td>
                        <td style='background:#FEE8AA;'>$resultData[url]</td>
                        <td style='background:#FEE8AA;'>$date</td>
                        <td style='background:#FEE8AA;'>$status</td>
                        <td style='background:#FEE8AA;'>$start</td>
                        <td style='background:#FEE8AA;'>$end</td>
                        <td style='background:#FEE8AA;'>$vendor</td>
                        <td style='background:#FEE8AA;'><img src='images/notice.png' alt='$resultDataX[problem_id]' title='' class='viewtaskIssue' onclick='viewTaskIssue(this.alt)'  border='0' />
                        
                        <td style='background:#FEE8AA;'><img src='images/valid.png' style='width:24px;height:24px;' alt='$resultDataX[task_id]' title='' class='viewtaskIssue' onclick='fixedIssueTask(this.alt)'  border='0' /></td>
                   </tr>";}
                                    $finaldat.="<div class='viewApprovedIssue$resultDataX[problem_id]' style='display:none'>
                                        <form action='' method='post' class='niceform'>
                                            <fieldset>
                                                    
                                                    <div style='background-color:#ECF8FD'>$message </div>
                                                <dl>
                                                    
                                                    <dd><textarea style='height:150px;width:400px' class='replyApprovedNote$resultDataX[problem_id]'></textarea></dd>
                                                </dl>

                                                <dl class='submit'>
                                                <a href='#' class='bt_green' onclick='replyIssueCampaignTask($resultDataX[problem_id],$resultDataX[task_id],$resultDataX[problem_to],$resultDataX[problem_from])'><span class='bt_green_lft'></span><strong>Send</strong><span class='bt_green_r'></span></a>  
                                                </dl>
                                            </fieldset>
                                        </form>
                                    </div>";
               }
               elseif($resultData['task_status']==5){
                   $finaldat.= "<tr style='background:#98FB98;'>    
                        
                        <td style='background:#98FB98;'>$description</td>
                        <td style='background:#98FB98;'>$resultData[url]</td>
                        <td style='background:#98FB98;'>$date</td>
                        <td style='background:#98FB98;'>$status</td>
                        <td style='background:#98FB98;'>$start</td>
                        <td style='background:#98FB98;'>$end</td>
                        <td style='background:#98FB98;'>$vendor</td>
                        <td style='background:#98FB98;'><img src='images/trash.png' alt='$resultData[task_id]' title='' class='deleteTask' onclick='delTask(this.alt)'  border='0' /></td>                        
                        <td style='background:#98FB98;'></td>
                   </tr>";   
               }
               
               elseif($resultData['task_status']==6){
                   $finaldat.= "<tr>    
                        
                        <td>$description</td>
                        <td>$resultData[url]</td>
                        <td>$date</td>
                        <td>$status</td>
                        <td>$start</td>
                        <td>$end</td>
                        <td>$vendor</td>
                        
                        <td></td>
                        <td></td>
                   </tr>";
               }
               
               else{
                    $finaldat.= "<tr>    
                        
                        <td>$description</td>
                        <td>$resultData[url]</td>
                        <td>$date</td>
                        <td>$status</td>
                        <td>$start</td>
                        <td>$end</td>
                        <td>$vendor</td>
                        
                        <td><img src='images/trash.png' alt='$resultData[task_id]' title='' class='deleteTask' onclick='delTask(this.alt)'  border='0' /></td>
                        <td></td>
                   </tr>";
               }
        }
        return $finaldat;
       }
       
       function checkTaskStatus($status){
           switch($status){
               case 1:
                   return "Open";
               break;
           
               case 2:
                    return "In Progress";
               break;
           
               case 3:
                    return "Has Issue";
               break;
           
               case 4:
                    return "Has Issue";
               break;
           
               case 5:
                   return "Issue Fixed";
               break;
           
               case 6:
                   return "Campaign Done";
               break;
           }
       }
       
       function getCampaign($conn,$campaign_id){
           $queryCampaign = $conn->query("SELECT * FROM tbl_campaign WHERE campaign_id = '$campaign_id'");
           $resultCredit = $queryCampaign->fetch_array(MYSQLI_ASSOC);
         return $resultCredit['campaign_desc'];
       }
       
       //this will get vendor name
      function getTaskName($conn,$task_id){
          $queryCampaign = $conn->query("SELECT * FROM tbl_task WHERE task_id = '$task_id'");
          $resultCredit = $queryCampaign->fetch_array(MYSQLI_ASSOC);
         return $resultCredit['url'];
      }
       
       function getName($conn,$customer_id){
           $queryCampaign = $conn->query("SELECT * FROM tbl_user WHERE userid = '$customer_id'");
           $resultCredit = $queryCampaign->fetch_array(MYSQLI_ASSOC);
          return $resultCredit['fullname'];
       }
       
       function getCampaignTaskViewVendor($conn,$id){
           $finaldat="";
          $listExpertise = $this->getVendorExpertiseOnly($conn,$id);
            $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE vendor_id = 0"); 
            while($resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC)){
                $needle = $resultCampaignTask['campaign_id'];
                if(count($listExpertise)>=1){
                    if(in_array($needle,$listExpertise)){
                        $status=$this->checkTaskStatus($resultCampaignTask['task_status']);
                        $description=$this->getCampaign($conn,$resultCampaignTask['campaign_id']);
                         $customer=$this->getName($conn,$resultCampaignTask['customer_id']);
                         $start=$this->getCampignCount($resultCampaignTask['start_count']);
                         $end=$this->getCampignCount($resultCampaignTask['end_count']);
                        //$vendor=$this->getVendorName($conn,$resultCampaignTask['vendor_id']);
                       // $date = date('Y-m-d', $resultCampaignTask['date_created']);
                        $finaldat.= "<tr>    
                                        <td>$description</td>
                                        <td>$resultCampaignTask[url]</td>
                                        <td>$customer</td>
                                        <td>$start</td>
                                        <td>$end</td>
                                        <td>$status</td>


                                        <td></td>
                                         <td><img src='images/viewopen.png' alt='' title='' onclick='viewCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'  border='0' /></td>
                                        
                                     </tr>
                        
                                    <div class='form$resultCampaignTask[task_id]' style='display:none'>
                                        <form action='' method='post' class='niceform'>
                                            <fieldset>
                                                <p style='color:#FA8072;'><b>Note: For Task such as Bookmarks, Youtube Video Ratings and Blog Commenting. Beginning count is not necessary</b></p>
                                                <dl>
                                                    <dt><label for='password'>Beginning Count:</label></dt>
                                                    <dd><input type='text' name='username' class='beginCount$resultCampaignTask[task_id]'  size='54' /></dd>
                                                </dl>

                                                <dl class='submit'>
                
                                                <a href='#' class='bt_green' onclick='grabCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'><span class='bt_green_lft'></span><strong>Grab Task</strong><span class='bt_green_r'></span></a>  

                                                </dl>
                                            </fieldset>
                                        </form>
                                    </div>";
                   
                    }
                }  
                else{
                    return "<h4 style='color:#FA8072'>No Task Available For this User, Ask Administrator to set your Expertise</h4>";
                }
            }
            
            return $finaldat;
       }  
       function checkTask($conn,$id){
          $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE task_id = '$id'"); 
          $resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC);
          if($resultCampaignTask['vendor_id']!=0){
              return true;
          }
          else{
              return false;
          }
       }
       
        function getCampaignTaskGrabVendor($conn,$id){
          $finaldat="";
          //$listExpertise = $this->getVendorExpertiseOnly($conn,$id);
          $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE vendor_id = '$id'"); 
            while($resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC)){
                //$needle = $resultCampaignTask['campaign_id'];
                if($queryCampaignTask->num_rows>=0){
                    //if(in_array($needle,$listExpertise)){
                        $status=$this->checkTaskStatus($resultCampaignTask['task_status']);
                        $description=$this->getCampaign($conn,$resultCampaignTask['campaign_id']);
                         $customer=$this->getName($conn,$resultCampaignTask['customer_id']);
                         $start=$this->getCampignCount($resultCampaignTask['start_count']);
                         $end=$this->getCampignCount($resultCampaignTask['end_count']);
                        //$vendor=$this->getVendorName($conn,$resultCampaignTask['vendor_id']);
                       // $date = date('Y-m-d', $resultCampaignTask['date_created']);
                         $resultAuthUserX=$conn->query("SELECT * FROM tbl_problem WHERE task_id = '$resultCampaignTask[task_id]'");
                        $resultDataX=$resultAuthUserX->fetch_array(MYSQLI_ASSOC);
                        
                        $message=stripslashes($resultDataX['problem_message']);
                        if($resultCampaignTask['task_status']==3 || $resultCampaignTask['task_status']==4){
                            if($resultDataX['problem_state']==2){
                                $finaldat.= "<tr>    
                                        <td style='background:#FEE8AA;'>$description</td>
                                        <td style='background:#FEE8AA;'>$resultCampaignTask[url]</td>
                                        <td style='background:#FEE8AA;'>$customer</td>
                                        <td style='background:#FEE8AA;'>$start</td>
                                        <td style='background:#FEE8AA;'>$end</td>
                                        <td style='background:#FEE8AA;'>$status</td>

                                        <td style='background:#FEE8AA;'><img src='images/notice.png' onclick='replyVendorToTask($resultDataX[problem_id])'  border='0' /></td>
                                        <td style='background:#FEE8AA;'></td>
                                     </tr>";  
                            }
                            else{
                              $finaldat.= "<tr>    
                                        <td style='background:#FA8072;'>$description</td>
                                        <td style='background:#FA8072;'>$resultCampaignTask[url]</td>
                                        <td style='background:#FA8072;'>$customer</td>
                                        <td style='background:#FA8072;'>$start</td>
                                        <td style='background:#FA8072;'>$end</td>
                                        <td style='background:#FA8072;'>$status</td>

                                        <td style='background:#FA8072;'><img src='images/notice.png' onclick='replyVendorToTask($resultDataX[problem_id])'  border='0' /></td>
                                        <td style='background:#FA8072;'></td>
                                     </tr>";
                              
                            }
                        }
                        elseif($resultCampaignTask['task_status']==5){
                            $finaldat.= "<tr>    
                                        <td style='background:#98FB98;'>$description</td>
                                        <td style='background:#98FB98;'>$resultCampaignTask[url]</td>
                                        <td style='background:#98FB98;'>$customer</td>
                                        <td style='background:#98FB98;'>$start</td>
                                        <td style='background:#98FB98;'>$end</td>
                                        <td style='background:#98FB98;'>$status</td>

                                        <td style='background:#98FB98;'></td>
                                        <td style='background:#98FB98;'><img src='images/viewopen.png' onclick='endCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'  border='0' /></td>
                                     </tr>";
                        }
                        
                        
                        elseif($resultCampaignTask['task_status']==6){
                            $finaldat.= "<tr>    
                                        <td>$description</td>
                                        <td>$resultCampaignTask[url]</td>
                                        <td>$customer</td>
                                        <td>$start</td>
                                        <td>$end</td>
                                        <td>$status</td>

                                        <td></td>
                                        <td></td>
                                     </tr>";
                        
                        }
                         
                        
                        else{
                         $finaldat.= "<tr>    
                                        <td>$description</td>
                                        <td>$resultCampaignTask[url]</td>
                                        <td>$customer</td>
                                        <td>$start</td>
                                        <td>$end</td>
                                        <td>$status</td>

                                        <td><img src='images/notice.png' onclick='issueCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'  border='0' /></td>
                                        <td><img src='images/viewopen.png' onclick='endCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'  border='0' /></td>
                                     </tr>";   
                        }
                        
                       $finaldat.= "<div class='replyVendor$resultDataX[problem_id]' style='display:none'>
                                        <form action='' method='post' class='niceform'>
                                            <fieldset>
                                                
                                                <p style='background-color:#DEB887'>$message</p>
                                                <p style='color:#FA8072;'></p>
                                                <dl>
                                                    <dt><label for='password'>Issue:</label></dt>
                                                    <dd><textarea style='height:150px;width:400px' class='replyVendorNote$resultDataX[problem_id]'></textarea></dd>
                                                </dl>

                                                <dl class='submit'>
                                                <a href='#' class='bt_green' onclick='sendReplyVendorToTask($resultDataX[problem_id],$resultDataX[task_id],$resultDataX[problem_to],$resultDataX[problem_from])'><span class='bt_green_lft'></span><strong>Create Issue</strong><span class='bt_green_r'></span></a>  
                                                
                                                </dl>
                                            </fieldset>
                                        </form>
                                    </div>
                        
                                    <div class='issue$resultCampaignTask[task_id]' style='display:none'>
                                        <form action='' method='post' class='niceform'>
                                            <fieldset>
                                                
                                                <p style='background-color:#DEB887'>$message</p>
                                                <p style='color:#FA8072;'></p>
                                                <dl>
                                                    <dt><label for='password'>Issue:</label></dt>
                                                    <dd><textarea style='height:150px;width:400px' class='issueNote$resultCampaignTask[task_id]'></textarea></dd>
                                                </dl>

                                                <dl class='submit'>
                                                <a href='#' class='bt_green' onclick='createIssueCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'><span class='bt_green_lft'></span><strong>Create Issue</strong><span class='bt_green_r'></span></a>  
                                                
                                                </dl>
                                            </fieldset>
                                        </form>
                                    </div>
                                    
                                    <div class='end$resultCampaignTask[task_id]' style='display:none'>
                                        <form action='' method='post' class='niceform'>
                                            <fieldset>
                                                <p style='color:#FA8072;'><b>Note: For Task such as Bookmarks, Youtube Video Ratings and Blog Commenting. Beginning count is not necessary</b></p>
                                                <dl>
                                                    <dt><label for='password'>Ending Count:</label></dt>
                                                    <dd><input type='text' name='username' class='endCount$resultCampaignTask[task_id]'  size='54' /></dd>
                                                </dl>

                                                <dl class='submit'>
                                                <a href='#' class='bt_green' onclick='closeCampaignTask($resultCampaignTask[task_id],$resultCampaignTask[campaign_id],$id)'><span class='bt_green_lft'></span><strong>End Task</strong><span class='bt_green_r'></span></a>  
                                                </dl>
                                            </fieldset>
                                        </form>
                                    </div>
                                    ";
                   
                } ///end if 
                else{
                    return "<h4 style='color:#FA8072'>No Task has been Grab Yet</h4>";
                }
            } /// end while
            return $finaldat;
       }  ////end funtion
       
       function getCampignCount($count){
           if($count==0){
               $countData = $count;
           }
           else{
               $countData = $count;
           }
           return $countData;
           
       }
       
       function getVendorExpertiseOnly($conn,$id){
           $queryCampaignTask = $conn->query("SELECT * FROM tbl_vendor WHERE user_id = '$id'");
           $resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC);
           $arrExpertise = $resultCampaignTask['vendor_expertise'];
           return unserialize($arrExpertise);
       }
       
       function upTask($conn,$task,$campaign,$vendor,$begin){
           $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE task_id = '$task'");
           $resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC);
           if($resultCampaignTask['vendor_id']!=0){
              $error = $this->createDivLayerOpening("", "", "error_box","Opps! Someone already grab this task!"); 
                return $error; 
           }
           
           ////
           //// Save Payment first from the cut-off
           else{
               
                $unpaidOwed = $this->queryOwed($conn, $vendor);
                $priceAction = $this->getPriceAction($conn, $vendor, 1);
                $timeNow = time();
                //no unpaid - Insert
                if($this->queryOwed($conn, $vendor)==0){
                    $conn->query("INSERT INTO tbl_payment(payment_vendor,payment_fromcustomer,payment_number,payment_priceaction,payment_start,payment_end,payment_total,payment_status,payment_approver,payment_extra) 
                            VALUES('$vendor',0,1,'$priceAction','$timeNow',0,'$priceAction',1,0,0)") or die(mysql_error());
                }
                
                //here unpaid - update
                else{
                    $paymentNumber = $this->getPaymentNumber($conn,$vendor);
                    $paymentNumber++;
                    $finalOwed = $unpaidOwed + $priceAction;
                    $conn->query("UPDATE tbl_payment SET payment_vendor = '$vendor', payment_number ='$paymentNumber',payment_total ='$finalOwed'");
                }
                
                $conn->query("UPDATE tbl_task SET start_count = '$begin', vendor_id ='$vendor', task_status = 2 WHERE task_id='$task'");
                $this->createNotification($conn, $resultCampaignTask['customer_id'], $vendor, 2, $task);
                $error = $this->createDivLayerOpening("", "", "valid_box","Campaign successfully grab!"); 
                return $error;
           }
       }
       
       function insertIssueTask($conn,$task,$campaign,$vendor,$problem){
           $timeNow = time();
           $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE task_id = '$task'");
           $resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC);
           $conn->query("INSERT INTO tbl_problem(task_id,problem_from,problem_to,problem_state,problem_message,problem_date) 
                                          VALUES('$task','$vendor','$resultCampaignTask[customer_id]',0,'$problem','$timeNow')") or Die(mysql_error());
           //this must be applied upon approved by admin
           $conn->query("UPDATE tbl_task SET task_status = 3 WHERE task_id='$task'");
           //$this->createNotification($conn, $resultCampaignTask['customer_id'], $vendor, 3, $task);
           $error = $this->createDivLayerOpening("", "", "valid_box","Issue successfully created!"); 
           return $error;
       }
       
       function checkIssueTask($conn,$task){
          $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE task_id = '$task' AND task_status = 3"); 
          if($queryCampaignTask->num_rows==1){
              return true;
          }
          else{
              return false;
          }
       }
       
       function getCountProblem($conn){
          $queryCampaignTask = $conn->query("SELECT * FROM tbl_problem WHERE problem_state = 0"); 
          if($queryCampaignTask->num_rows>0){
            return "<span style='font-weight:bolder;color:red;font-size:13px;'>(".$queryCampaignTask->num_rows.")</span>";
          }
          else{
              return "";
          }
       }
       
       
       //////
       //////
       //////
       //////
       ///
       //////
       function insertApprovedIssueTask($conn,$problem,$task,$to,$from,$problem_mes){
            $image = addslashes("<img src='images/status_open.gif' />");
            $problem_mes = "<p>$image<b>From:".$this->getName($conn, $from)."</b><br /><br /><span style=\'margin-left:10px;\'>".  wordwrap(addslashes($problem_mes), 40,"<br />")."</span></p><br/>";
           
            $conn->query("UPDATE tbl_task SET task_status = 4 WHERE task_id='$task'");
            $this->createNotification($conn, $to, $from, 3, $task);
            $this->createNotification($conn, $from, 0, 4, $task);
            $conn->query("UPDATE tbl_problem SET problem_message = '$problem_mes',problem_state = 1 WHERE problem_id='$problem'");
            $error = $this->createDivLayerOpening("", "", "valid_box","Issue approved!"); 
            return $error;
       }
       
       function getProblemList($conn){
           $finaldat="";
           $queryCampaignTask = $conn->query("SELECT * FROM tbl_problem WHERE problem_state = 0"); 
           while($resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC)){
               $description=$this->getTaskName($conn,$resultCampaignTask['task_id']);
               $customer=$this->getName($conn,$resultCampaignTask['problem_to']);
                $vendor=$this->getName($conn,$resultCampaignTask['problem_from']);
                $date = date('Y-m-d', $resultCampaignTask['problem_date']);
                $finaldat.= "<tr>    
                                 <td>$description</td>
                                 <td>$customer</td>
                                 <td>$vendor</td>
                                 <td>$date</td>

                                 <td><img src='images/viewopen.png' alt='' title='' onclick='viewToApprovedTask($resultCampaignTask[problem_id],$resultCampaignTask[task_id],$resultCampaignTask[problem_to],$resultCampaignTask[problem_from])'  border='0' /></td>
                                        
                               </tr>
                
                               <div class='toApproved$resultCampaignTask[problem_id]' style='display:none'>
                                        <form action='' method='post' class='niceform'>
                                            <fieldset>
                                                
                                                <dl>
                                                    <dt><label for='password'>Issue:</label></dt>
                                                    <dd><textarea style='height:300px;width:400px' class='issueApprovedNote$resultCampaignTask[problem_id]'>$resultCampaignTask[problem_message]</textarea></dd>
                                                </dl>

                                                <dl class='submit'>
                                                <a href='#' class='bt_green' onclick='approvedIssueCampaignTask($resultCampaignTask[problem_id],$resultCampaignTask[task_id],$resultCampaignTask[problem_to],$resultCampaignTask[problem_from])'><span class='bt_green_lft'></span><strong>Approved Task</strong><span class='bt_green_r'></span></a>  
                                                </dl>
                                            </fieldset>
                                        </form>
                                    </div>
                ";
         
            }
            return $finaldat;
       }
       
       function addReply($conn,$id,$task,$from,$to,$reply){
           $getProblemMessage = $conn->query("SELECT * FROM tbl_problem WHERE problem_id = '$id'");
           $resultTaskProblem = $getProblemMessage->fetch_array(MYSQLI_ASSOC);
           $image  = addslashes("<img src='images/status_reopened.gif' />");
           $thread = addslashes($resultTaskProblem['problem_message']);
           $reply = $thread."<p>$image<b>From:".$this->getName($conn, $from)."</b><br /><br /><span style=\'margin-left:10px;\'>".  wordwrap(addslashes($reply), 40,"<br />")."</span></p><br/>";
           $conn->query("UPDATE tbl_problem SET problem_message = '$reply',problem_state = 2 WHERE problem_id = '$id'");
           $this->createNotification($conn, $to, $from, 5, $task);
           $error = $this->createDivLayerOpening("", "", "valid_box","Issue approved!"); 
           return $error;
       }
       
       function addVendorReply($conn,$id,$task,$from,$to,$reply){
           $getProblemMessage = $conn->query("SELECT * FROM tbl_problem WHERE problem_id = '$id'");
           $resultTaskProblem = $getProblemMessage->fetch_array(MYSQLI_ASSOC);
           $image  = addslashes("<img src='images/status_reopened.gif' />");
           $thread = addslashes($resultTaskProblem['problem_message']);
           $reply = $thread."<p>$image<b>From:".$this->getName($conn, $from)."</b><br /><br /><span style=\'margin-left:10px;\'>".  wordwrap(addslashes($reply), 40,"<br />")."</span></p><br/>";
           $conn->query("UPDATE tbl_problem SET problem_message = '$reply',problem_state = 3 WHERE problem_id = '$id'");
           $this->createNotification($conn, $to, $from, 5, $task);
           $error = $this->createDivLayerOpening("", "", "valid_box","Issue approved!"); 
           return $error;
       }
       
       function fixedTaskIssue($conn,$id,$uid){
          $conn->query("UPDATE tbl_task SET task_status = 5 WHERE task_id='$id'");
          $this->createNotification($conn, $uid, 0, 6, $id);
          $error = $this->createDivLayerOpening("", "", "valid_box","Issue approved!"); 
          return $error;
           
       }
       
       function endTask($conn,$task,$campaign,$vendor,$end){
           $queryCampaignTask = $conn->query("SELECT * FROM tbl_task WHERE task_id = '$task'");
           $resultCampaignTask = $queryCampaignTask->fetch_array(MYSQLI_ASSOC);
           if($resultCampaignTask['start_count']<$end){
            $conn->query("UPDATE tbl_task SET end_count = '$end', vendor_id ='$vendor', task_status = 6 WHERE task_id='$task'");
            $this->createNotification($conn, $resultCampaignTask['customer_id'], $vendor, 7, $task);
            $error = $this->createDivLayerOpening("", "", "valid_box","Campaign successfully end!"); 
            return $error;
           }
           else{
            $error = $this->createDivLayerOpening("", "", "error_box","Opps! ending count is less than starting count"); 
            return $error;   
           }
       }
       
       ////////////////////////////////////////
       //////////March 15,2012/////////////////
       ///////////////////////////////////////
       function queryOwed($conn, $vendor){
           $queryOwed = $conn->query("SELECT * FROM tbl_payment WHERE payment_vendor = '$vendor' AND payment_status = 1");
           if($queryOwed->num_rows == 1){
               $resultOwed = $queryOwed->fetch_array(MYSQLI_ASSOC);
               return $resultOwed['payment_total'];
           }
           else{
               return 0;
           }
           
       }
       
       function getPriceAction($conn, $vendor ,$toggle){
           $queryPriceAction = $conn->query("SELECT * FROM tbl_vendor WHERE user_id = '$vendor'");
           $resultPriceAction = $queryPriceAction->fetch_array(MYSQLI_ASSOC);
           if($toggle==1){
               return $resultPriceAction['vendor_priceaction'];
           }
           else{
               return  $pricePerActionOption = "<select size='1' style='width:60px;' id='vendorPrice'>
                                <option value='.02'>.02</option>
                                <option value='.002'>.002</option>
                                <option value='.0002'>.0002</option>
                            </select>";
                
           }
       }
       
       function getPaymentNumber($conn, $vendor){
           $queryOwed = $conn->query("SELECT * FROM tbl_payment WHERE payment_vendor = '$vendor' AND payment_status = 1");
           $resultOwed = $queryOwed->fetch_array(MYSQLI_ASSOC);
           return $resultOwed['payment_number'];
       }
       
       function getPaymentList($conn,$id){
           $finaldat = "";
           $queryOwed = $conn->query("SELECT * FROM tbl_payment");
           while($resultOwed = $queryOwed->fetch_array(MYSQLI_ASSOC)){
               $vendor = $this->getName($conn, $resultOwed['payment_vendor']);
               $status = $this->getPaymentStatus($conn,$resultOwed['payment_status']);
               
               if($resultOwed['payment_approver']==0){
                $date = "Not Yet Available";
                $admin = "Not Yet Available";;
               }
               else{
                $date = date('Y-m-d',$resultOwed['payment_end']);
                $admin = $this->getName($conn, $resultOwed['payment_approver']);
               }
               if($resultOwed['payment_status']==1){
                   
               $finaldat.="
                                <tr>    
                                 <td style='background-color:#FA8072'>$vendor</td>
                                 <td style='background-color:#FA8072'>$resultOwed[payment_priceaction]</td>
                                 <td style='background-color:#FA8072'>$resultOwed[payment_number]</td>
                                 <td style='background-color:#FA8072'>$status</td>
                                 <td style='background-color:#FA8072'>$admin</td>
                                 <td style='background-color:#FA8072'>$date</td>
                              
                                 <td style='background-color:#FA8072'><img src='images/pay_1.jpg' style='width:24px;height:24px' onclick='payVendor($resultOwed[payment_id],$resultOwed[payment_vendor])'  border='0' /></td>
                                 <td style='background-color:#FA8072'><img src='images/notice.png' alt='' title='' onclick='viewPaymentHistory($resultOwed[payment_id])'  border='0' /></td>      
                               </tr>";
               }
               else{
                  $finaldat.="
                                <tr>    
                                 <td style='background-color:#98FB98'>$vendor</td>
                                 <td style='background-color:#98FB98'>$resultOwed[payment_priceaction]</td>
                                 <td style='background-color:#98FB98'>$resultOwed[payment_number]</td>
                                 <td style='background-color:#98FB98'>$status</td>
                                 <td style='background-color:#98FB98'>$admin</td>
                                 <td style='background-color:#98FB98'>$date</td>
                                 
                                 <td style='background-color:#98FB98'></td>
                                 <td style='background-color:#98FB98'><img src='images/notice.png' alt='' title='' onclick='viewPaymentHistory($resultOwed[payment_id])'  border='0' /></td>      
                               </tr>"; 
               }
           }
           return $finaldat;
       }
       
       function getPaymentStatus($conn,$status){
           if($status == 1){
               return "Not Yet Paid";
           }
           
           else{
               return "Paid";
           }
       }
       
       function upPayment($conn,$payment,$admin,$vendor){
           $timeNow = time();
           
          $conn->query("UPDATE tbl_payment SET payment_end='$timeNow' ,payment_status = 2,payment_approver='$admin'  WHERE payment_id = '$payment'");
          $this->createNotification($conn, $vendor, $admin, 8, 0);
          $error = $this->createDivLayerOpening("", "", "valid_box","Balance Cleared"); 
          return $error;
       }
       
       function updateVendorList($conn,$vendor,$price,$expertise){
         $timeNow = time();
         $arrExpertise = serialize($expertise);
         $conn->query("UPDATE tbl_vendor SET vendor_expertise='$arrExpertise' ,vendor_priceaction = '$price',date_created='$timeNow'  WHERE user_id = '$vendor'");
         // $this->createNotification($conn, $vendor, $admin, 8, 0);
          $error = $this->createDivLayerOpening("", "", "valid_box","Vendor successfully Updated"); 
          return $error;
       }
}
?> 