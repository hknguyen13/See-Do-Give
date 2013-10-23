<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Broadcaster</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript">
$(document).ready(function(){

$("#bname").blur(function(){
var bname = $('#bname').val();
if(bname)
{
$.post("<?php echo base_url();?>index.php/admin/checkcname",{bName:bname},function(data){
if(data==1)
{
alert("Company name already exist");
$("#bname").val('');
$("#bname").focus();
return false;
}
});
}
});
$("#bemail").change(function(){
var hasError = false;
var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
var emailaddressVal = $('#bemail').val();
if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/admin/checkbemail",{emailaddress:emailaddressVal},function(data){
if(data==0)
{
alert("Enter a valid email address.");
$("#bemail").val('');
$("#bemail").focus();
return false;
}
});
}
else if(emailaddressVal)
{
$.post("<?php echo base_url();?>index.php/admin/checkemailaddress",{emailaddress:emailaddressVal},function(data){
if(data==1)
{
alert("EmailAddress already exist");
$("#bemail").val('');
$("#bemail").focus();
return false;
}
});
}
});

$("#bcontact").change(function(){
var phone = $('#bcontact').val();
var phonenum = phone.length;

if(isNaN(phone))
{
$.post("<?php echo base_url();?>index.php/admin/checkbnanumber",{Phone:phone},function(data){
if(data==0)
{
alert("Must be Numbers")
$('#bcontact').val('');
$('#bcontact').focus();
return false; 
}
});
}
else if(phonenum!=10)
{
$.post("<?php echo base_url();?>index.php/admin/checkbnumlen",{Phone:phone},function(data){
if(data==1)
{
alert("Phone number must 10 digits")
$('#bcontact').val('');
$('#bcontact').focus();
return false; 
}
});
}
});
	
/*$("#bzipcode").blur(function(){
var hasError = false;
var phonenumber = $('#bzipcode').val();
var phonenum = phonenumber.length;

if(isNaN(phonenumber))
{
alert("Please enter only digits");
$("#bzipcode").focus();
return false;
}
});*/
$("#bcountry").change(function(){
var country = $("#bcountry").val();
$.post("<?php echo base_url();?>index.php/admin/selectstate",{country_code:country},function(data){
$(".bstate").html(data);
});
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
<div id="formlineTwo">
<div class="bc_menu" style="height:30px;"><ul id="bc_menu"><li><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster">View Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/addbroadcaster" <?php if (strpos($_SERVER['PHP_SELF'], "admin/addbroadcaster")) { echo 'class="active"'; }?>>Add Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/adminstaffregister">Add Broadcaster Admin</a></li><li><a href="<?php echo base_url();?>index.php/admin/manageseeds">Seed Configration</a></li><li><a href="<?php echo base_url();?>index.php/admin/broadcasterdeposit">Add Amount</a></li><li><a href="<?php echo base_url();?>index.php/admin/addvideos"  <?php if (strpos($_SERVER['PHP_SELF'], "admin/addvideos")) { echo 'class="active"'; }?>>Add Video</a></li></ul></div>
<div id="stylized" class="myform">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Add New Broadcaster Form</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($add) { echo "<span style='color:green; font-family:13px;'>".$add."</span><br/>"; }
if($uploadfailed) { echo "<span style='color:red; font-family:13px;'>".$uploadfailed."</span><br/>"; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
?></p>
<label>Name
<span class="small">*</span>
</label>
<input type="text" name="bname" id="bname" value="<?php echo $values['broadcaster_name'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="bemail" id="bemail" value="<?php echo $values['broadcaster_email'];?>" required="required"/>
<label>Description
</label>
<textarea id="bdesc" name="bdesc"><?php echo $values['broadcaster_desc'];?></textarea>
<label for="bcontact">Phone Number
<span class="small">*</span>
</label>
<input type="text" name="bcontact" id="bcontact" value="<?php echo $values['broadcaster_contact'];?>" maxlength="10" required="required"/>
<label for="bcontact">Address
</label>
<input type="text" name="baddress" id="baddress" value="<?php echo $values['broadcaster_address'];?>"/>
<label for="bcontact">Country
</label>
<select name="bcountry" id="bcountry">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>" <?php if($vals->Country_Code==$values['broadcaster_country']) { echo "selected=selected"; }?>><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label for="bcontact">State
</label>
<select name="bstate" id="bstate" class="bstate">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>" <?php if($values['broadcaster_state']==$val->stateid) { echo "selected=selected"; }?> ><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<label for="bcity">City
</label>
<input type="text" name="bcity" id="bcity" value="<?php echo $values['broadcaster_city'];?>"/>
<label for="bcity">Zip Code
</label>
<input type="text" name="bzipcode" id="bzipcode" value="<?php echo $values['broadcaster_zipcode'];?>" maxlength="6"/>	
<label for="bcity">Logo
<span class="small">*</span>
</label>
<input type="file" name="userfile" id="userfile" value="" />		
<label style="margin-left:120px; width:290px; color:red; margin-top:-20px;">
<span>Uploading image should not be greater than 1MB</span>
</label>
<br/>
<button type="submit" name="submit">Save</button> &nbsp;<button type="Reset" name="submit" class="button1">Reset</button>
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
