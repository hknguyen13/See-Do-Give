<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Seedogive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage1.css" type="text/css" media="screen" />
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
var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
var emailaddressVal = $('#bemail').val();
if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/user/checkbcemail",{emailaddress:emailaddressVal},function(data){
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
$.post("<?php echo base_url();?>index.php/user/broadcasteremail",{emailaddress:emailaddressVal},function(data){
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
$.post("<?php echo base_url();?>index.php/user/selectuserstate",{country_code:country},function(data){
$("#bstate").html(data);
});
});
});
</script>
</head>

<body>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/user/"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="stylized" class="myform">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Broadcaster Registration</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($add) { echo "<span style='color:green; font-family:13px;'>".$add."</span><br/>"; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
if($duplicate) { echo "<span style='color:red; font-family:13px;'>".$duplicate."</span><br/>"; }
?></p>
<label>Name
<span class="small">*</span>
</label>
<input type="text" name="bname" id="bname" value="" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="bemail" id="bemail" value="" required="required"/>
<label>Description
</label>
<textarea id="bdesc" name="bdesc"></textarea>
<label for="bcontact">Phone Number
<span class="small">*</span>
</label>
<input type="text" name="bcontact" id="bcontact" value="" maxlength="10" required="required"/>
<label for="bcontact">Address
</label>
<input type="text" name="baddress" id="baddress" value=""/>
<label for="bcontact">Country
</label>
<select name="bcountry" id="bcountry">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>"><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label for="bcontact">State
</label>
<select name="bstate" id="bstate" class="bstate">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>"><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<label for="bcity">City
</label>
<input type="text" name="bcity" id="bcity" value=""/>
<label for="bcity">Zip Code
</label>
<input type="text" name="bzipcode" id="bzipcode" value="" maxlength="6"/>	
<label for="bcity">Logo
<span class="small">*</span>
</label>
<input type="file" name="userfile" id="userfile" value="" />		

<button type="submit" name="submit">Register</button> &nbsp;<button type="Reset" name="submit" class="button1">Reset</button>
</form>
</div>
</div>
<?php include("footer.php");?>
</body>
</html>
