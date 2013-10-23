<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit User</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>	
<script type="text/javascript">

var userid=<?php echo $this->uri->segment(3);?>;
$(document).ready(function(){

$("#udob").datepicker({ showOn: 'focus', buttonText: "select" });

$("#uname").change(function(){
var uname = $('#uname').val();
if(uname == "") 
{
$.post("<?php echo base_url();?>index.php/admin/checkeuname",{uName:uname},function(data){
if(data==0)
{
alert("Please, fill the user name");
$("#uname").val('');
$("#uname").focus();
return false;
}
});
}
else if(uname)
{
$.post("<?php echo base_url();?>index.php/admin/checkuname",{uName:uname,user_id:userid},function(data){
//alert(data);
if(data==1)
{
alert("Name already exist");
$("#uname").focus();
return false;
}
});
}

if(hasError == true)
{ return false; }
});

$("#uemail").change(function(){
var hasError = false;
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailaddressVal = $('#uemail').val();
if(emailaddressVal == '') 
{
$.post("<?php echo base_url();?>index.php/admin/checkeuemail",{email:emailaddressVal},function(data){
if(data==0)
{
alert("Please, fill the user email");
$("#uemail").val('');
$("#uemail").focus();
return false;
}
});
}
else if(!emailReg.test(emailaddressVal)) 
{
$.post("<?php echo base_url();?>index.php/admin/checkvaliduemail",{emailaddress:emailaddressVal},function(data){
if(data==0)
{
alert("Enter a valid email address.");
$("#uemail").val('');
$("#uemail").focus();
return false;
}
});
}
else if(emailaddressVal)
{

$.post("<?php echo base_url();?>index.php/admin/CheckuEmail",{emailaddress:emailaddressVal,user_id:userid},function(data){
//alert(data);
if(data==1)
{
alert("EmailAddress already exist");
$("#uemail").focus();
return false;
}
});
}

if(hasError == true)
{ return false; }
});

$("#uphone").change(function(){
var phone = $('#uphone').val();
var phonenum = phone.length;
if(isNaN(phone))
{
alert("Phone Number must be numerical");
$('#uphone').val('');
$('#uphone').focus();
return false; 
/*$.post("<?php echo base_url();?>index.php/admin/checkunannum",{Phone:phone},function(data){
if(data==1)
{
alert("Phone Number must be numerical")
$('#uphone').val('');
$('#uphone').focus();
return false; 
}
});*/
}
else if(phonenum!=10)
{
$.post("<?php echo base_url();?>index.php/admin/checkunumlen",{Phone:phone},function(data){
if(data==1)
{
alert("Phone number must 10 digits")
$('#uphone').val('');
$('#uphone').focus();
return false; 
}
});
}
});
	
$("#bzipcode").change(function(){
var hasError = false;
var phonenumber = $('#bzipcode').val();
var phonenum = phonenumber.length;

if(isNaN(phonenumber))
{
alert("Please enter only digits");
$("#bzipcode").focus();
return false;
}
});
$("#country").change(function(){
var country = $("#country").val();
$.post("<?php echo base_url();?>index.php/admin/selectstate",{country_code:country},function(data){
$(".state").html(data);
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
<h1>Edit User</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($fail) { echo "<span style='color:red; font-family:13px;'>".$fail."</span><br/>"; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
if($success) { echo $success; }
?></p>

<label>Name
<span class="small">*</span>
</label>
<input type="text" name="firstname" id="firstname" value="<?php echo $names['userfirstname'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="uemail" id="uemail" value="<?php echo $names['useremail'];?>" required="required"/>
<label>Dob
</label>
<input type="text" name="udob" id="udob" value="<?php echo $names['userdob'];?>"/>
<label for="bcontact">Gender
</label>
<input type="radio" name="ugender" id="ugender" value="male" <?php if($names['usergender']=="male") echo "checked";?> style="width:30px;" /><label style="width:50px; text-align:left; margin-left:2px;">Male</label> <input type="radio" name="ugender" id="ugender" value="female"  <?php if($names['usergender']=="female") echo "checked";?> style="width:96px;" /><label style="width:50px; text-align:left; margin-left:-32px;">Female</label>

<label for="bcontact">Phone Number
</label>
<input type="text" maxlength="10" name="uphone" id="uphone" value="<?php echo $names['userphone'];?>"/>
<label>Country
</label>
<select name="country" id="country">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>" <?php if($names['usercountry']==$vals->Country_Code) { echo "selected=selected"; }?>><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label>State
</label>
<select name="state" id="state" class="state">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>" <?php if($names['userstate']==$val->stateid) { echo "selected=selected"; }?>><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>

<button type="submit" name="submit">Update</button> &nbsp;<button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewuser'">Back</button>
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
