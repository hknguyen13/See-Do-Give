<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>User Registration</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage1.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });

$("#email").change(function(){
var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
var emailaddressVal = $('#email').val();
if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/user/checkemailval",{emailaddress:emailaddressVal},function(data){
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
$.post("<?php echo base_url();?>index.php/user/checkuseremail",{emailaddress:emailaddressVal},function(data){
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

$("#password").change(function(event){
if(document.getElementById("password").value.length<6){
alert("Password should not less than 6 characters");
document.getElementById("password").value='';
document.getElementById("password").focus();
return false;
}
});

$("#contact").blur(function(){
var contact = $('#contact').val();
var contactnum = contact.length;
if(isNaN(contact))
{
alert("Phone Number must be numerical");
$('#contact').val('');
$('#contact').focus();
return false; 
}
});

$("#country").change(function(){
var country = $("#country").val();
$.post("<?php echo base_url();?>index.php/user/selectuserstate",{country_code:country},function(data){
$("#suresh").html(data);
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
<form action="" method="post">
<h1>User Registration</h1>
<p><?php
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
if($duplicate) { echo "<span style='color:red; font-family:13px;'>".$duplicate."</span><br/>"; }
?></p>
<label>Firstname
</label>
<input type="text" name="firstname" value="" id="firstname"/>
<label>Lastname
</label>
<input type="text" name="lastname" value="" id="lastname"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="email" value="" id="email" required="required" />
<label>Password
<span class="small">*</span>
</label>
<input type="password" name="password" id="password" required="required"  />
<label for="bcontact">Gender
</label>
<input type="radio" name="ugender" id="ugender" value="male" style="width:30px;" /><label style="width:50px; text-align:left; margin-left:2px;">Male</label> <input type="radio" name="ugender" id="ugender" value="female" style="width:96px;" /><label style="width:50px; text-align:left; margin-left:-32px;">Female</label>

<label>Dob
</label>
<input type="text" name="date" id="date" value="" />
<label>Contact No
</label>
<input type="text" name="contact" id="contact" value="" maxlength="10"/>
<label>Country
</label>
<select name="country" id="country">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>"><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label>State
</label>
<select name="state" id="suresh">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>"><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<button type="submit" name="submit">Register</button> &nbsp;<button type="Reset" name="submit" class="button1">Reset</button>
</form>
</div>
</div>
<?php include("footer.php");?>
</body>
</html>
