<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Registration</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script> 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });

$("#username").blur(function(){
var username = $('#username').val();
if(username)
{
$.post("<?php echo base_url();?>index.php/admin/checkadminname",{Username:username},function(data){
if(data==1)
{
alert("Admin name already exist");
$("#username").val('');
$("#username").focus();
return false;
}
});
}
});

$("#email").blur(function(){
var hasError = false;
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailaddressVal = $('#email').val();
if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/admin/checkadminemail",{emailaddress:emailaddressVal},function(data){
if(data==0)
{
alert("Enter a valid email address.");
$("#email").val('');
$("#email").focus();
return false;
}
});
}
else if(emailaddressVal)
{
$.post("<?php echo base_url();?>index.php/admin/checkademail",{emailaddress:emailaddressVal},function(data){
if(data==1)
{
alert("EmailAddress already exist");
$("#email").val('');
$("#email").focus();
return false;
}
});
}
if(hasError == true)
{ return false; }
});

$("#password").blur(function(){
var pass = /^[A-Za-z0-9!@#$%^&*()_]{6,16}$/;
var password = $('#password').val();
if(!pass.test(password))
{
//alert(password);
$.post("<?php echo base_url();?>index.php/admin/checkpass",{psw:password},function(data){
if(data==0)
{
alert("Please,enter min 6 charaters");
$("#password").val('');
$("#password").focus();
return false;
}
});
} 
});
});
</script>
<style type="text/css">
.bc_menu ul{
width:700px;
}
.bc_menu ul li {
float:left;
list-style:none;
}
.bc_menu ul li a{
padding:7px;
text-decoration:none;
color:#0000FF;
}
.bc_menu ul li a:hover{
color:#999999;
}
.bc_menu ul li a.active {
color:#000000;
}
</style>
</head>

<body>
<div id="container">
<div id="header">
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo" style="height:570px;">
	   <div class="bc_menu" style="height:30px;"><ul id="bc_menu"><li><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster">View Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/addbroadcaster">Add Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/adminstaffregister" <?php if (strpos($_SERVER['PHP_SELF'], "admin/adminstaffregister")) { echo 'class="active"'; }?>>Add Broadcaster Admin</a></li><li><a href="<?php echo base_url();?>index.php/admin/manageseeds">Seed Configration</a></li><li><a href="<?php echo base_url();?>index.php/admin/broadcasterdeposit">Add Amount</a></li><li><a href="<?php echo base_url();?>index.php/admin/addvideos">Add Video</a></li></ul></div>
<div id="stylized" class="myform">
<form action="" method="post" id="form" name="form">
<h1>Add New Admin</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
if($add) { echo "<span style='color:Green; font-family:13px;'>".$add."</span><br/>"; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
?></p>
<label for="bcontact">Admin for Broadcaster
</label>
<select name="adminbtype">
<option value=" ">Select</option>
<?php foreach($broadcaster as $val): ?>
<option value="<?php echo $val->broadcaster_name;?>" <?php if($val->broadcaster_name==$adminvalues['admin_type']) { echo "selected=selected";}?>><?php echo $val->broadcaster_name;?></option>
<?php endforeach;?>
</select>
<label for="bcontact">Firstname
</label>
<input type="text" name="firstname" id="firstname" value="<?php echo $adminvalues['admin_firstname'];?>"/>
<label for="bcontact">Lastname
</label>
<input type="text" name="lastname" id="lastname" value="<?php echo $adminvalues['admin_lastname'];?>" />
<label>Username
<span class="small">*</span>
</label>
<input type="text" name="username" id="username" value="<?php echo $adminvalues['admin_username'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="email" id="email" value="<?php echo $adminvalues['admin_email'];?>" required="required" />
<label>Password
<span class="small">*</span>
</label>
<input type="password" name="password" id="password" value="" required="required"/>
<label for="bcontact">Phone Number
</label>
<input type="text" name="contact" id="contact" value="<?php echo $adminvalues['admin_contact'];?>" maxlength="10" />
<label for="bcontact">Created On
</label>
<input type="text" name="date" id="date" value="<?php echo $adminvalues['admin_createdon'];?>"/>

<?php /*?><label for="bcontact">Admin for Cause
</label>
<select name="adminctype">
<option value=" ">Select</option>
<?php foreach($causes as $vals): ?>
<option value="<?php echo $vals->cause_id;?>"><?php echo $vals->cause_name;?></option>
<?php endforeach;?>
</select>
<?php */?>
<button type="submit" name="submit">Save</button> &nbsp;<button type="reset" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewadminstaff'">Reset</button>
<div class="spacer"></div>
</form>
</div>
</div>
<div id="images"></div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
<div id="footercontainer">
	<div class="menu"><a href="#" title="Home">Home</a> | <a href="#" title="How It Works">How It Works</a> | <a href="#" title="Blog">Blog</a>| <a href="#" title="Advertise">Advertise</a> | <a href="#" title="Contact Us">Contact Us</a></div>
	<div class="copyRights">© <?php echo date("Y");?>, SeeDoGive. All Rights Reserved.</div>
	<div class="clear"></div>
  </div>
</div>
</body>
</html>
