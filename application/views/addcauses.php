<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Cause</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#cname").blur(function(){
var cname = $('#cname').val();
/*if(cname=="")
{
$.post("<?php echo base_url();?>index.php/admin/checkcauseename",{cName:cname},function(data){
if(data==0)
{
alert("Cause name already exist");
$("#cname").val('');
$("#cname").focus();
return false;
}
});
}*/
if(cname)
{
$.post("<?php echo base_url();?>index.php/admin/checkcausename",{cName:cname},function(data){
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

/* contact number validations */
$("#cemail").blur(function(){
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
if(hasError == true)
{ return false; }
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
$.post("<?php echo base_url();?>index.php/admin/selectstate",{country_code:country},function(data){
$("#cstate").html(data);
});
});
});
</script>
<style type="text/css">
.bc_menu ul{
width:800px;
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
	  <div class="bc_menu" style="height:30px;"><?php if($type=="super") { ?><ul id="bc_menu"><li><a href="<?php echo base_url();?>index.php/admin/viewcause" >View Cause</a></li><li><a href="<?php echo base_url();?>index.php/admin/addcause" <?php if (strpos($_SERVER['PHP_SELF'], "admin/addcause")) { echo 'class="active"'; }?>>Add cause</a></li><li><a href="<?php echo base_url();?>index.php/admin/admincauseregister" >Add Cause Admin</a></li></ul><?php } ?></div>
<div id="stylized" class="myform">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Add New Cause</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($add) { echo "<span style='color:green; font-family:13px;'>".$add."</span><br/>"; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
?></p>

<label>Name
<span class="small">*</span>
</label>
<input type="text" name="cname" id="cname" value="<?php echo $values['cause_name'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="cemail" id="cemail" value="<?php echo $values['cause_email'];?>" required="required"/>
<label>Description
</label>
<textarea id="cdesc" name="cdesc"><?php echo $values['cause_desc'];?></textarea>
<label for="bcontact">Phone Number
</label>
<input type="text" name="ccontact" id="ccontact" value="<?php echo $values['cause_contact'];?>" maxlength="10"/>
<label for="bcontact">Address
</label>
<input type="text" name="caddress" id="caddress" value="<?php echo $values['cause_address'];?>"/>
<label for="bcountry">Country
</label>
<select name="ccountry" id="ccountry">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>" <?php if($values['cause_country']==$vals->Country_Code) { echo "selected=selected"; }?> ><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label for="cstate">State
</label>
<select name="cstate" id="cstate">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>" <?php if($values['cause_state']==$val->stateid) { echo "selected=selected"; }?> ><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<label for="bcity">City
</label>
<input type="text" name="ccity" id="ccity" value="<?php echo $values['cause_city'];?>"/>
<label for="czipcode">Zip Code
</label>
<input type="text" name="czipcode" id="czipcode" value="<?php echo $values['cause_zipcode'];?>" maxlength="6"/>	
<label for="userfile">Logo
<span class="small">*</span>
</label>
<input type="file" name="userfile" id="userfile" value="" />		

<button type="submit" name="submit">Save</button> &nbsp;<button type="reset" name="submit" class="button1">Reset</button>
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
