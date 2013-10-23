<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Broadcaster</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<?php /*?><script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js"></script><?php */?>
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
var userid=<?php echo $this->uri->segment(3);?>;
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });
$("#dates").datepicker({ showOn: 'focus', buttonText: "select" });
$("#modifydate").datepicker({ showOn: 'focus', buttonText: "select" });
$("#videostartdate").datepicker({ showOn: 'focus', buttonText: "select" });
$("#videoenddate").datepicker({ showOn: 'focus', buttonText: "select" });
$("#bname").change(function(){
var bname = $('#bname').val();
if(bname == '') 
{
$.post("<?php echo base_url();?>index.php/admin/checkebname",{bName:bname},function(data){
if(data==0)
{
alert("Please, fill the broadcaster name");
$("#bname").val('');
$("#bname").focus();
return false;
}
});
}
else if(bname)
{
$.post("<?php echo base_url();?>index.php/admin/checkeebname",{bName:bname,user_id:userid},function(data){
//alert(data);
if(data==1)
{
alert("Company name already exist");
$("#bname").val('');
$("#bname").focus();
return false;
}
});
}

if(hasError == true)
{ return false; }
});

$("#bemail").change(function(){
var hasError = false;
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailaddressVal = $('#bemail').val();
if(emailaddressVal == '') 
{
$.post("<?php echo base_url();?>index.php/admin/checkebemail",{email:emailaddressVal},function(data){
if(data==0)
{
alert("Please, fill the broadcaster email");
$("#bemail").val('');
$("#bemail").focus();
return false;
}
});
}
else if(!emailReg.test(emailaddressVal)) 
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
$.post("<?php echo base_url();?>index.php/admin/checkeditemail",{emailaddress:emailaddressVal,user_id:userid},function(data){
if(data==1)
{
alert("EmailAddress already exist");
$("#bemail").val('');
$("#bemail").focus();
return false;
}
});
}

if(hasError == true)
{ return false; }
});

$("#bcontact").change(function(){
//alert("test");
//var hasError = false;
var phone = $('#bcontact').val();
var phonenum = phone.length;

if(isNaN(phone))
{
$.post("<?php echo base_url();?>index.php/admin/checkbnanum",{Phone:phone},function(data){
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
/*if(phonenum!=10)
{
alert("Please enter 10 digits");
return false;
}*/
});
$("#bcountry").change(function(){
var country = $("#bcountry").val();
$.post("<?php echo base_url();?>index.php/admin/selectstate",{country_code:country},function(data){
$("#bstate").html(data);
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
<h1>Edit Broadcaster</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
?></p>

<label>Name
<span class="small">*</span>
</label>
<input type="text" name="bname" id="bname" value="<?php echo $broadcaster['broadcaster_name'];?>" required="required"/>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="bemail" id="bemail" value="<?php echo $broadcaster['broadcaster_email'];?>" required="required"/>
<label>Description
</label>
<textarea id="bdesc" name="bdesc"><?php echo $broadcaster['broadcaster_desc'];?></textarea>
<label for="bcontact">Phone Number
<span class="small">*</span>
</label>
<input type="text" name="bcontact" id="bcontact" value="<?php echo $broadcaster['broadcaster_contact'];?>" maxlength="10"/>
<label for="bcontact">Address
</label>
<input type="text" name="baddress" id="baddress" value="<?php echo $broadcaster['broadcaster_address'];?>"/>
<label for="bcontact">Country
</label>
<select name="bcountry" id="bcountry">
<?php foreach($country as $vals): ?>
<option value="<?php echo $vals->Country_Code;?>"><?php echo $vals->Country_Name;?></option>
<?php endforeach;?>
</select>
<label for="">State
</label>
<select name="bstate" id="bstate">
<?php foreach($states as $val): ?>
<option value="<?php echo $val->stateid;?>" <?php  if($val->stateid==$broadcaster['broadcaster_state']) echo 'selected="selected"';?>><?php echo $val->state_name;?></option>
<?php endforeach;?>
</select>
<label for="bcity">City
</label>
<input type="text" name="bcity" id="bcity" value="<?php echo $broadcaster['broadcaster_city'];?>"/>
<label for="bcity">Zip Code
</label>
<input type="text" name="bzipcode" id="bzipcode" value="<?php echo $broadcaster['broadcaster_zipcode'];?>" maxlength="6"/>	
<label for="bcity">Logo
</label>
<input type="file" name="userfile" id="userfile" value="" /><input type="hidden" name="blogo" value="<?php echo $broadcaster['broadcaster_logo'];?>" />
<label for="date" style="width:500px; text-align:left; margin-bottom:20px; font-size:14px; font-weight:bold;">Seed Configuration
</label> 		
<label for="date">Seeds 
<span class="small">*</span>
</label> 
<select name="seeds" required="required">
<option value=" ">Select</option>
<option value="1" <?php if($seeds['seeds']==1) { echo "selected=selected"; }?>>1</option>
<option value="2" <?php if($seeds['seeds']==2) { echo "selected=selected"; }?>>2</option>
<option value="3" <?php if($seeds['seeds']==3) { echo "selected=selected"; }?>>3</option>
<option value="4" <?php if($seeds['seeds']==4) { echo "selected=selected"; }?>>4</option>
<option value="5" <?php if($seeds['seeds']==5) { echo "selected=selected"; }?>>5</option>
<option value="6" <?php if($seeds['seeds']==6) { echo "selected=selected"; }?>>6</option>
<option value="7" <?php if($seeds['seeds']==7) { echo "selected=selected"; }?>>7</option>
<option value="8" <?php if($seeds['seeds']==8) { echo "selected=selected"; }?>>8</option>
<option value="9" <?php if($seeds['seeds']==9) { echo "selected=selected"; }?>>9</option>
<option value="10" <?php if($seeds['seeds']==10) { echo "selected=selected"; }?>>10</option>
</select>
<label for="date">Dollars
<span class="small">*</span>
</label> 
<select name="dollars" required="required">
<option value=" ">Select</option>
<option value="1" <?php if($seeds['dollars']==1) { echo "selected=selected"; }?>>1</option>
<option value="2" <?php if($seeds['dollars']==2) { echo "selected=selected"; }?>>2</option>
<option value="3" <?php if($seeds['dollars']==3) { echo "selected=selected"; }?>>3</option>
<option value="4" <?php if($seeds['dollars']==4) { echo "selected=selected"; }?>>4</option>
<option value="5" <?php if($seeds['dollars']==5) { echo "selected=selected"; }?>>5</option>
<option value="6" <?php if($seeds['dollars']==6) { echo "selected=selected"; }?>>6</option>
<option value="7" <?php if($seeds['dollars']==7) { echo "selected=selected"; }?>>7</option>
<option value="8" <?php if($seeds['dollars']==8) { echo "selected=selected"; }?>>8</option>
<option value="9" <?php if($seeds['dollars']==9) { echo "selected=selected"; }?>>9</option>
<option value="10" <?php if($seeds['dollars']==10) { echo "selected=selected"; }?>>10</option>
</select>
<label for="date">Seed Config On
<span class="small">*</span>
</label> 
<input type="text" name="modifydate" id="modifydate" value="<?php echo $seeds['createddate'];?>" required="required"/>
<?php /*?><label>Broadcaster Name
<span class="small">Required Field</span>
</label>
<select name="bsa_broadcasterid" id="bsa_broadcasterid" required="required">
<option value=" ">Select</option>
<?php foreach($broadcaster as $vals):?>
<option value="<?php echo $vals->broadcaster_id;?>" <?php if($amount['sc_broadcasterid']==$vals->broadcaster_id) { echo "selected=selected"; }?>><?php echo $vals->broadcaster_name;?></option>
<?php endforeach; ?>
</select><?php */?>
<label for="date" style="width:500px; text-align:left; margin-bottom:20px; font-size:14px; font-weight:bold;">Broadcaster Deposit Amount
</label>
<label for="date">Total Amount 
<span class="small">*</span>
</label> 
<input type="text" name="amount" id="amount" value="<?php echo $amount['bsa_totalamount'];?>" required="required"/>
<label for="date">Total Seeds 
<span class="small">*</span>
</label> 
<input type="text" name="seed" id="seed" value="<?php echo $amount['bsa_seedvalue'];?>" required="required"/>

<label for="date" style="width:500px; text-align:left; margin-bottom:20px; font-size:14px; font-weight:bold;">Broadcaster Video
</label>

<label for="date">Video Title
	<span class="small">*</span>
	</label> 
	<input type="text" name="videotitle" id="videotitle" value="<?php echo $videos['bcvideo_title'];?>" required="required"/>
	<label for="date">Video Start Date 
	<span class="small">*</span>
	</label> 
	<input type="text" name="videostartdate" id="videostartdate" value="<?php echo $videos['bc_videostartdate'];?>" required="required"/>
	<label for="date">Video End Date 
	<span class="small">*</span>
	</label> 
	<input type="text" name="videoenddate" id="videoenddate" value="<?php echo $videos['bc_videoenddate'];?>" required="required"/>
	<label for="date">Broadcaster Video
	<span class="small">*</span>
	</label> 
	<input type="file" name="userfile1" id="userfile1" />
	<input type="hidden" name="videopath" id="videopath" value="<?php echo $videos['bc_videopath'];?>"/>
<button type="submit" name="submit">Update</button> &nbsp;<button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewbroadcaster'">Back</button>
<div class="spacer"></div>
</form>
</div>
<div id="images" style="margin-top:200px; margin-left:50px;"><img src="<?php echo base_url();?>images/<?php echo $broadcaster['broadcaster_logo'];?>" height="100" width="100"/>
<p><?php echo $broadcaster['broadcaster_name'];?></p>
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
