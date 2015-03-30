$(window).load(function () {
  //alert($("#userIdHolder").val());
  //if($("#userIdHolder").val() != ""){
    //refreshDays($("#userIdHolder").val());
    
    getNotification($("#userIdHolder").val());
    //refreshCredit($("#userIdHolder").val());
  //}
  
});


function viewCampaignTask(task_id,camp_id,vend_id){
    //alert(".form"+task_id);
     if(camp_id == 4 || camp_id == 6 || camp_id == 8){
          $(".beginCount").attr('disabled','disabled');
     }
     else{
         $(".beginCount").attr('disabled','');
     }
            $('.form' + task_id).slideToggle('slow', function() {});
}
function endCampaignTask(task_id,camp_id,vend_id){
    //alert(".form"+task_id);
            $('.end' + task_id).slideToggle('slow', function() {});
}

function issueCampaignTask(task_id,camp_id,vend_id){
    //alert(".form"+task_id);
            $('.issue' + task_id).slideToggle('slow', function() {});
}

function viewToApprovedTask(problem,task,to,from){
    $('.toApproved' + problem).slideToggle('slow', function() {});
}


/////////approved issue note
////
////
////
////
function approvedIssueCampaignTask(problem,task,to,from){
    var problem_mes = $('.issueApprovedNote' + problem).val();
    if(problem_mes ==""){
        alert("Please fill the Issue field or You need to refresh the Page!");
    }
    else{
        $.post("_action/action_updateIssueTask.php",{direct_access:task, problem:problem,task:task,to:to,from:from,problem_mes:problem_mes},
            
                        function(data){  
                           $('.toApproved' + problem).slideToggle('slow', function() {});
                           $('.issueApprovedNote' + problem).val("");
                            refreshProblemCount();
                            //alert("Trigger to refresh");
                            refreshProblemList();
                            
                            $(".messageListener").html(data);
                        });
         return false;
    }
}

function createIssueCampaignTask(task_id,camp_id,vend_id){
    var problem = $('.issueNote' + task_id).val();
  
    if(problem ==""){
        alert("Please fill the Issue field or You need to refresh the Page!");
    }
    else{
        $.post("_action/action_addIssueTask.php",{direct_access:task_id, task:task_id,campaign:camp_id,vendor:vend_id,problem:problem},
            
                        function(data){  
                           $('.issue' + task_id).slideToggle('slow', function() {});
                           $('.issueNote' + task_id).val("");
                            refreshVendorAvailableTask(vend_id);
                            refreshVendorGrabTask(vend_id);
                            $(".messageListener").html(data);
                        });
         return false;
    }
   
}

function grabCampaignTask(task_id,camp_id,vend_id){
    var begin_count = $(".beginCount" + task_id).val();
    if(camp_id == 1 || camp_id == 2 || camp_id == 3 || camp_id == 5 || camp_id == 7){
        if(begin_count!= ""){
            if(isNaN(begin_count)){
                alert("Please Place a valid number!");
            }
            
            else{
                $('.form' + task_id).slideToggle('slow', function() {});
                   $.post("_action/action_grabTask.php",{direct_access:task_id, task:task_id,campaign:camp_id,vendor:vend_id,begin:begin_count},
            
                        function(data){  
                            $('.beginCount' + task_id).val("");
                            refreshVendorAvailableTask(vend_id);
                            refreshVendorGrabTask(vend_id);
                            location.reload();
                            $(".messageListener").html(data);
                        });
                        return false;
            }
        }
        
        else{
            alert("Please enter Beginning Count to Continue");
        }
    }
    else{
                begin_count = 0;
                $('.form' + task_id).slideToggle('slow', function() {});
                   $.post("_action/action_grabTask.php",{direct_access:task_id, task:task_id,campaign:camp_id,vendor:vend_id,begin:begin_count},
            
                        function(data){  
                             $('.beginCount' + task_id).val("");
                            refreshVendorGrabTask(vend_id);
                            refreshVendorAvailableTask(vend_id);
                            location.reload();
                            $(".messageListener").html(data);
                        });
                        return false;
    }
}

function closeCampaignTask(task_id,camp_id,vend_id){
    var end_count = $(".endCount" + task_id).val();
    if(camp_id == 1 || camp_id == 2 || camp_id == 3 || camp_id == 5 || camp_id == 7){
        if(end_count!= ""){
            if(isNaN(end_count)){
                alert(end_count);
                alert("Please Place a valid number!");
            }
            
            else{
                $('.end' + task_id).slideToggle('slow', function() {});
                   $.post("_action/action_closeTask.php",{direct_access:task_id, task:task_id,campaign:camp_id,vendor:vend_id,end:end_count},
            
                        function(data){  
                            $('.endCount' + task_id).val("");
                            refreshVendorAvailableTask(vend_id);
                            refreshVendorGrabTask(vend_id);
                            //location.reload();
                            $(".messageListener").html(data);
                        });
                        return false;
            }
        }
        
        else{
            alert("Please enter Ending Count to Continue");
        }
    }
    else{
                end_count = 0;
                $('.end' + task_id).slideToggle('slow', function() {});
                   $.post("_action/action_closeTask.php",{direct_access:task_id, task:task_id,campaign:camp_id,vendor:vend_id,end:end_count},
            
                        function(data){  
                             $('.endCount' + task_id).val("");
                            refreshVendorGrabTask(vend_id);
                            refreshVendorAvailableTask(vend_id);
                            //location.reload();
                            $(".messageListener").html(data);
                        });
                        return false;
    }
}

$(document).ready(function(){
        
        
        //////to add new user////
         $("#addNewUser").click(function(){
            var action_validator = $("#addNewUser").val();
            var usertype = $("#usertype").val();
            var fullname = $("#fullname").val();
            var email = $("#email").val();
            var username = $("#username").val();
            var password = $("#password").val();
            var phone = $("#phonenumber").val();
            if(usertype != "" && fullname != "" && email != "" && username != "" && password != "" && phone != ""){
                $.post("_action/action_addNewUser.php",{direct_access:action_validator, type: usertype, full: fullname, email: email, usern: username, passw: password, phone: phone},
            
                    function(data){
                        $.modal.close();
                        refreshList();
                        $(".messageListener").html(data);
                    });
                    return false;
            } 
           else{
                alert("Please complete the form");
           }
        });
        /////////////////////////
       
        ////////to add new campaign/////
         $("#addNewCampaign").click(function(){
            var action_validator = $("#addNewCampaign").val();
            var campaign_name = $("#campaign_name").val();
            var credit = $("#credit").val();
            var date = $("#curr_date").val();
            
            if(campaign_name != "" && credit != "" && date != ""){
                $.post("_action/action_addNewCampaign.php",{direct_access:action_validator, campaign_name: campaign_name, credit: credit, date: date},
            
                    function(data){
                        $.modal.close();
                        refreshCampaign();
                        $(".messageListener").html(data);
                    });
                    return false;
            } 
           else{
                alert("Please complete the form");
           }
        });
        ////////////////////////////
        
        /////for customer////
         $("#addNewCustomer").click(function(){
            var action_validator = $("#addNewCustomer").val();
            var customer = $("#customerUser").val();
            var plan = $("#customerPlan").val();
           
            //alert(action_validator);
            if( customer!= "" && plan != "" && created != ""){
                $.post("_action/action_addNewCustomer.php",{direct_access: action_validator, customer: customer, plan: plan},
            
                    function(data){
                        $.modal.close();
                        refreshCustomer();
                        $(".messageListener").html(data);
                    });
                    return false;
            } 
           else{
                alert("Please complete the form");
           }
        });
      //////////////////////////
      
      ////////for vendor////////
        $("#addNewVendor").click(function(){
            var action_validator = $("#addNewVendor").val();
            var vendor = $("#vendorUser").val();
            var price = $("#vendorPrice").val();
            var temp = "";
            //var plan = $("#customerPlan").val();
           $("#vexpertise :checked").each(function() {
                   temp = temp + "." + $(this).val();
            });
            if( vendor!= "" && price != "" && temp != ""){
                $.post("_action/action_addNewVendor.php",{direct_access: action_validator,vendor:vendor,price:price, temp:temp},
            
                    function(data){
                        $.modal.close();
                        refreshVendor();
                        $(".messageListener").html(data);
                    });
                    return false;
            } 
           else{
              alert("Please complete the form");
           }
        });
      /////////////////////////
      ////for customer portal login
      $('#taskSelection').change(function() {
         var campaignId =  $('#taskSelection').val();
             $.post("_action/action_getCreditValue.php",{campaignId:campaignId},
            
                    function(data){
                        //alert(data);
                        $("#creditValue").val(data);
                    });
      });
      
      $("#addNewCampaignTask").click(function(){
            var action_validator = $("#addNewCampaignTask").val();
            var task = $("#taskSelection").val();
            var credit = $("#creditValue").val();
            var uid = $("#userIdHolder").val();
            var url = $("#urlTitle").val();
            //var temp = "";
            //var plan = $("#customerPlan").val();
           //alert(uid);
            if( task!= "" && credit != "" && url != "" && uid != ""){
                $.post("_action/action_addNewCampaignTask.php",{direct_access: action_validator,task:task,credit:credit, url:url,uidr:uid},
            
                    function(data){
                        $.modal.close();            
                        refreshTask(uid);
                        refreshDays(uid);
                        refreshCredit(uid);
                      $(".messageListener").html(data);
                    });
                    return false;
            } 
           else{
              alert("Please complete the form");
           }
        });
      
});
function refreshProblemList(){
    //alert("Perform refresh");
    $.post("_action/action_getProblemList.php",{},
            
            function(data){
                $("#problemList").html(data);
            });
            return false;
}

function refreshProblemCount(){
    $.post("_action/action_getProblemCount.php",{},
            
            function(data){
                $(".problemCountDisplay").html(data);
            });
            return false;
}

function refreshList(){
     $.post("_action/action_getUser.php",{},
            
            function(data){
                $("#userList").html(data);
            });
            return false;
}


function refreshCampaign(){
     $.post("_action/action_getCampaign.php",{},
            
            function(data){
                $("#campaignList").html(data);
            });
            return false;
}

function refreshCustomer(){
     $.post("_action/action_getCustomer.php",{},
            
            function(data){
                $("#customerList").html(data);
            });
            return false;
}

function refreshVendor(){
     $.post("_action/action_getVendor.php",{},
            
            function(data){
                $("#vendorList").html(data);
            });
            return false;
}

function refreshTask(id){
     $.post("_action/action_getTask.php",{id:id},
            
            function(data){
                $("#taskList").html(data);
            });
            return false;
}

function refreshCredit(id){
    //alert(id);
     $.post("_action/action_getCredit.php",{id:id},
            
            function(data){
                $(".credit_count").html(data + " Credits");
            });
            return false;
}

function refreshDays(id){
    //alert(id);
     $.post("_action/action_getDaysCount.php",{id:id},
            
            function(data){
                $(".days_count").html(data + " Days to Expire");
            });
            return false;
}

function refreshVendorAvailableTask(id){
    //alert(id);
     $.post("_action/action_getVendorAvailTask.php",{id:id},
            
            function(data){
                $("#vendorCampaignTask").html(data);
            });
            return false;
}

function refreshVendorGrabTask(id){
    $.post("_action/action_getVendorGrabTask.php",{id:id},
            
            function(data){
                $("#vendorGrabTask").html(data);
            });
            return false;
}

function delUserAccount(userid){
    //alert(userid);
    var r=confirm("Are you sure you want delete this user?");
        if (r==true){
            $.post("_action/action_deleteUser.php",{userid:userid},
            
            function(data){
                refreshList();
                $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
      
}

function updateUserAccount(userid){
    $.post("_action/action_updateUser.php",{userid:userid},
            function(data){
                $("#userList").html(data);
               
    });
           return false;
}

function saveupUser(userid){
    var action_validator = "Valid";
    var name = $("#fulln").val();
    var user = $("#usern").val();
    var email = $("#emailn").val();
    var type = $("#usert").val();
    var phone = $("#phonen").val();
    
    if(name != "" && user != "" && email != "" && type != "" && phone != ""){
      
      $.post("_action/action_updateFinalUser.php",{type: type, full: name, email: email, usern: user, phone: phone,target:userid,direct_access:action_validator},
            
        function(data){
            refreshList();
            $(".messageListener").html(data);
        });
        return false;
        } 
    else{
        alert("Please complete the form");
    }
}

function delCampaign(camp_id){
    var r=confirm("Are you sure you want delete this Campaign?");
        if (r==true){
            $.post("_action/action_deleteCampaign.php",{camp_id:camp_id},
            
            function(data){
                refreshCampaign();
                $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
}

function upCampaign(camp_id){
      $.post("_action/action_updateCampaign.php",{camp_id:camp_id},
            function(data){
                $("#campaignList").html(data);
               
    });
           return false;
}

function saveupCampaign(camp_id){
    var action_validator = "Valid";
    var campaign_desc = $("#campaign_desc").val();
    var credit = $("#credit").val();
    var campaign_date = $("#campaign_date").val();
    
    if(campaign_desc != "" && credit != "" && campaign_date != ""){
      
      $.post("_action/action_updateFinalCampaign.php",{campaign_desc: campaign_desc, credit: credit, campaign_date: campaign_date,camp_id:camp_id,direct_access:action_validator},
            
        function(data){
            refreshCampaign();
            $(".messageListener").html(data);
        });
        return false;
        } 
    else{
        alert("Please complete the form");
    }
}


function delCustomer(cus_id){
       var r=confirm("Are you sure you want delete this Customer?");
        if (r==true){
            $.post("_action/action_deleteCustomer.php",{cus_id:cus_id},
            
            function(data){
                refreshCustomer();
                $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
}

function delTask(taskid){
    var uid = $("#userIdHolder").val();
    var r=confirm("Are you sure you want delete this Task?");
        if (r==true){
            $.post("_action/action_deleteTask.php",{taskid:taskid},
            
            function(data){
                refreshTask(uid);
                refreshCredit(uid);
                $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
}

function delVendor(ven_id){
     var r=confirm("Are you sure you want delete this Vendor?");
        if (r==true){
            $.post("_action/action_deleteVendor.php",{ven_id:ven_id},
            
            function(data){
                refreshVendor();
                $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
}

///////notification
function getNotification(id){
      $.post("_action/action_getNotification.php",{id:id},
            
            function(data){
                $(".customerNote").html(data);
            });
            return false;
}

function viewTaskIssue(problem_id){
   // viewApprovedIssue
    $('.viewApprovedIssue' + problem_id).slideToggle('slow', function() {});
}

//reply to Vendor
function replyIssueCampaignTask(id,task,from,to){
    //alert($('.replyApprovedNote' + id).val());
    
    var reply_Message = $('.replyApprovedNote' + id).val();
    //alert(reply_Message);
    if(reply_Message=""){
        alert("Please fill the text area to continue");
    }
    else{
        var reply_Message = $('.replyApprovedNote' + id).val();
         $.post("_action/action_sendReply.php",{creply:reply_Message, direct_access:id, id:id, task:task, from:from, to:to},
            
            function(data){
                //alert(data);
                $('.viewApprovedIssue' + id).slideToggle('slow', function() {});
                $(".messageListener").html(data);
                refreshTask($("#userIdHolder").val());
            });
            return false;
    }
    
}

//fixed the issue


function replyVendorToTask(id){
    $('.replyVendor' + id).slideToggle('slow', function() {});
}

function sendReplyVendorToTask(id,task,to,from){
     
    var reply_Message = $('.replyVendorNote' + id).val();
    //alert(reply_Message);
    if(reply_Message=""){
        alert("Please fill the text area to continue");
    }
    else{
        var reply_Message = $('.replyVendorNote' + id).val();
         $.post("_action/action_sendVendorReply.php",{creply:reply_Message, direct_access:id, id:id, task:task, from:from, to:to},
            
            function(data){
                //alert(data);
                $('.replyVendor' + id).slideToggle('slow', function() {});
                 refreshVendorGrabTask($("#userIdHolder").val());
                $(".messageListener").html(data);
            });
            return false;
    }
}

function fixedIssueTask(problem_id){
    var uid = $("#userIdHolder").val();
    $.post("_action/action_fixedIssue.php",{ direct_access:problem_id, id:problem_id,uid:uid},
            
            function(data){
                //alert(data);
                  refreshTask($("#userIdHolder").val());
                $(".messageListener").html(data);
            });
            return false;
}
