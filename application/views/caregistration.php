<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Seedogive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage1.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });

$("#cemail").change(function(){
var hasError = false;
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailaddressVal = $('#cemail').val();
if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/admin/checkcauseeemail",{emailaddress:emailaddressVal},function(data){
if(data==0)
{
alert("Enter a valid email address.");
$("#cemail").val('');
$("#cemail").focus();
return false;
}
});
}
else if(emailaddressVal)
{
$.post("<?php echo base_url();?>index.php/admin/checkcauseemail",{emailaddress:emailaddressVal},function(data){
if(data==1)
{
alert("EmailAddress already exist");
$("#cemail").val('');
$("#cemail").focus();
return false;
}
});
}
});

/*contact number validations */
$('#ccontact').change(function(event){
var phone = $('#ccontact').val();
var phonenum = phone.length;
if(isNaN(phone))
{
$.post("<?php echo base_url();?>index.php/admin/checknanumber",{Phone:phone},function(data){
if(data==0)
{
alert("Must be Numbers")
$('#ccontact').val('');
$('#ccontact').focus();
return false; 
}
});
}
else if(phonenum!=10)
{
$.post("<?php echo base_url();?>index.php/admin/checknumberlen",{Phone:phone},function(data){
if(data==1)
{
alert("Phone number must 10 digits")
$('#ccontact').val('');
$('#ccontact').focus();
return false; 
}
});
}
});
$("#ccountry").change(function(){
var country = $("#ccountry").val();
$.post("<?php echo base_url();?>index.php/user/selectuserstate",{country_code:country},function(data){
$("#cstate").html(data);
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
<h1>Add New Cause</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
if($duplicate) { echo "<span style='color:red; font-family:13px;'>".$duplicate."</span><br/>"; }
?></p>

<label>Name
<span class="small">*</span>
</label>
<input type="text" name="cname" id="cname" value="" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="cemail" id="cemail" value="" required="required"/>
<label>Description
</label>
<textarea id="cdesc" name="cdesc"></textarea>
<label for="bcontact">Phone Number
<span class="small">*</span>
</label>
<input type="text" name="ccontact" id="ccontact" value="" maxlength="10" required="required"/>
<label for="bcontact">Address
</label>
<input type="text" name="caddress" id="caddress" value=""/>
<label for="bcountry">Country
</label>
<select name="ccountry" id="ccountry">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>"><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label for="cstate">State
</label>
<select name="cstate" id="cstate">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>"><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<label for="bcity">City
</label>
<input type="text" name="ccity" id="ccity" value=""/>
<label for="czipcode">Zip Code
</label>
<input type="text" name="czipcode" id="czipcode" value="" maxlength="6"/>	
<label for="userfile">Logo
<span class="small">*</span>
</label>
<input type="file" name="userfile" id="userfile" value="" />		

<button type="submit" name="submit">Register</button> &nbsp;<button type="reset" name="submit" class="button1">Reset</button>
</form>
</div>
</div>
<?php include("footer.php");?>
</body>
</html>
