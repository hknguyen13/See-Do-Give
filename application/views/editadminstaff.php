<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Adminstaff</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script> 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
var userid=<?php echo $this->uri->segment(3);?>;
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });
				
$("#username").change(function(){
var username = $('#username').val();
if(username)
{
$.post("<?php echo base_url();?>index.php/admin/checkadmname",{Username:username,user_id:userid},function(data){
//alert(data);
if(data==1)
{
alert("admin name already exist");
$("#username").val('');
$("#username").focus();
return false;
}
});
}
});

$("#email").change(function(){
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
$.post("<?php echo base_url();?>index.php/admin/checkadmemail",{emailaddress:emailaddressVal,user_id:userid},function(data){
if(data==1)
{
alert("EmailAddress already exist");
$("#email").val('');
$("#email").focus();
return false;
}
});
}
});
	
});
</script>
</head>

<body>
<div id="container">
<div id="header">
<?php $id=$this->uri->segment('3'); 
$query = $this->db->query("select * from admin_tbl where admin_id='$id'");
$result = $query->result();
$admin_type = $result['0']->admin_type;?>
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo" style="height:570px;">
<div id="stylized" class="myform">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Edit Admin</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
?></p>
<label for="bcontact">Firstname
</label>
<input type="text" name="firstname" id="firstname" value="<?php echo $names['admin_firstname'];?>"/>
<label for="bcontact">Lastname
</label>
<input type="text" name="lastname" id="lastname" value="<?php echo $names['admin_lastname'];?>" />
<label>Username
<span class="small">*</span>
</label>
<input type="text" name="username" id="username" value="<?php echo $names['admin_username'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="email" id="email" value="<?php echo $names['admin_email'];?>" required="required" />
<label>Password
<span class="small">*</span>
</label>
<input type="password" name="password" id="password" value="<?php echo $names['admin_password'];?>" required="required" readonly="readonly"/>
<label for="bcontact">Phone Number
</label>
<input type="text" name="contact" id="contact" value="<?php echo $names['admin_contact'];?>" maxlength="10" />
<label for="bcontact">Created On
</label>
<input type="text" name="date" id="date" value="<?php echo $names['admin_createdon'];?>"/>
<label for="bcontact">Admin for Broadcaster
</label>
<select name="adminbtype">
<option value=" ">Select</option>
<?php foreach($broadcaster as $val): ?>
<option value="<?php echo $val->broadcaster_name;?>" <?php if($names['admin_type']==$val->broadcaster_name) echo "selected=selected";?>><?php echo $val->broadcaster_name;?></option>
<?php endforeach;?>
</select>
<label for="bcontact">Admin for Cause
</label>
<select name="adminctype">
<option value=" ">Select</option>
<?php foreach($causes as $vals): ?>
<option value="<?php echo $vals->cause_name;?>" <?php if($names['admin_type']==$vals->cause_name) echo "selected=selected";?>><?php echo $vals->cause_name;?></option>
<?php endforeach;?>
</select>
<button type="submit" name="submit">Update</button> &nbsp;<button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewadminstaff'">Back</button>
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
