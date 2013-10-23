<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Forgot Password</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#email").blur(function(){
var email = $("#email").val();
alert("test");
$.post("<?php echo base_url();?>index.php/admin/checkaemail",{Email:email,function(data){
//alert(data);
if(data==1)
{
alert("Email does not exist");
$("#email").val('');
$("#email").focus();
return false;
}
});
});
});
</script>
</head>

<body>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/admin"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="stylized" class="myform">
<form method="post" action="">
<h1>Forgot Password</h1>
<p><?php
if($email) { echo "<span style='color:red; font-family:13px;'>".$email."</span><br/>"; }
if($errors) { echo $errors; }
?></p>
<label>Email
<span class="small">*</span>
</label>
<input type="text" name="email" id="email" value="" required="required"/>

<button type="submit" name="submit">Submit</button> 
</form>
</div>
</div>
<?php include("footer.php");?>
</body>
</html>
