<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Cause</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript">
var userid=<?php echo $this->uri->segment(3);?>;
$(document).ready(function(){

$("#cname").change(function(){
var cname = $('#cname').val();
if(cname == '') 
{
$.post("<?php echo base_url();?>index.php/admin/checkcauseename",{cName:cname},function(data){
if(data==0)
{
alert("Please enter your cause name.")
$("#cname").val('');
$("#cname").focus();
return false;
}
});
}
else if(cname)
{
$.post("<?php echo base_url();?>index.php/admin/checkeditcausename",{cName:cname,user_id:userid},function(data){
//alert(data);
if(data==1)
{
alert("Cause name already exist");
$("#cname").val('');
$("#cname").focus();
return false;
}
});
}

if(hasError == true)
{ return false; }
});

$("#cemail").change(function(){
var hasError = false;
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailaddressVal = $('#cemail').val();
if(emailaddressVal == '') 
{
$.post("<?php echo base_url();?>index.php/admin/checkempemail",{emailaddress:emailaddressVal},function(data){
if(data==0)
{
alert("Please enter your email address.")
$("#cemail").val('');
$("#cemail").focus();
return false;
}
});
}
else if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/admin/checkcauseeemail",{emailaddress:emailaddressVal},function(data){
if(data==0)
{
alert("Enter a valid email address.")
$("#cemail").val('');
$("#cemail").focus();
return false;
}
});
}
else if(emailaddressVal)
{
$.post("<?php echo base_url();?>index.php/admin/checkeditcauseemail",{emailaddress:emailaddressVal,user_id:userid},function(data){
if(data==1)
{
alert("EmailAddress already exist");
$("#cemail").val('');
$("#cemail").focus();
return false;
}
});
}

if(hasError == true)
{ return false; }
});
$("#ccontact").change(function(){
//alert("test");
//var hasError = false;
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
$(".ccountry").change(function(){
var country = $(".ccountry").val();
$.post("<?php echo base_url();?>index.php/admin/selectstate",{country_code:country},function(data){
$(".cstate").html(data);
});
});
});
</script>
</head>

<body>
<div id="container">
<div id="header">
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo">
<div id="stylized" class="myform">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Edit Cause</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
?></p>

<label>Name
<span class="small">*</span>
</label>
<input type="text" name="cname" id="cname" value="<?php echo $causes['cause_name'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="cemail" id="cemail" value="<?php echo $causes['cause_email'];?>" required="required"/>
<label>Description
</label>
<textarea id="cdesc" name="cdesc"><?php echo $causes['cause_desc'];?></textarea>
<label for="bcontact">Phone Number
<span class="small"></span>
</label>
<input type="text" name="ccontact" id="ccontact" value="<?php echo $causes['cause_contact'];?>" maxlength="10"/>
<label for="bcontact">Address
</label>
<input type="text" name="caddress" id="caddress" value="<?php echo $causes['cause_address'];?>"/>
<label>Country
</label>
<select name="ccountry" id="ccountry" class="ccountry">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>" <?php if($vals->Country_Code==$causes['cause_country']) echo "selected=selected"?>><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label for="cstate">State
</label>
<select name="cstate" id="cstate" class="cstate">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>" <?php if($val->stateid==$causes['cause_state']) echo "selected=selected"?>><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<label for="bcity">City
</label>
<input type="text" name="ccity" id="ccity" value="<?php echo $causes['cause_city'];?>"/>
<label for="czipcode">Zip Code
</label>
<input type="text" name="czipcode" id="czipcode" value="<?php echo $causes['cause_zipcode'];?>" maxlength="6"/>	
<label for="userfile">Logo
</label>
<input type="file" name="userfile" id="userfile" value="" /><input type="hidden" name="clogo" value="<?php echo $causes['cause_logo'];?>" />		

<button type="submit" name="submit">Update</button> &nbsp;<button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewcause'">Back</button>
<div class="spacer"></div>
</form>
</div>
<div id="images" style="margin-top:200px; margin-left:50px;"><img src="<?php echo base_url();?>images/<?php echo $causes['cause_logo'];?>" height="100" width="100"/>
<p><?php echo $causes['cause_name'];?></p></div>
</div>
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
