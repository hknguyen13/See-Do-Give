<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reset Password</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript">
function CheckPassword()
{
	if($("#pass").val()=="")
	{
		$("#err").attr("style","dislay:block; color:#FF0000;");
		$("#err").html("Enter password");
		$("#pass").focus()
		return false;
	}
	else if($("#confirmpassword").val()=="")
	{
		$("#err").attr("style","dislay:block; color:#FF0000;");
		$("#err").html("Enter confirm password");
		$("#confirmpassword").focus()
		return false;
	}
	else if($("#pass").val()!=$("#confirmpassword").val())
	{
		$("#err").attr("style","dislay:block; color:#FF0000;");
		$("#err").html("Password and confirm password are not same");
		$("#confirmpassword").val('');
		$("#confirmpassword").focus();
		return false;
		
	}
}
</script>
</head>

<body>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/admin"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="stylized" class="myform">
<form action="" method="post"  onsubmit="return CheckPassword();">
<h1>Reset Password</h1>
<span id="err" style="display:none;"></span>
<p><?php
if($blank) { echo "<span style='color:red; font-family:13px;'>".$blank."</span><br/>"; }
if($errors) { echo $errors; }
?></p>
<label for="pass">Password
<span class="small">*</span>
</label> 
<input type="password" name="pass" id="pass" value="" style="width:200px;" />
<label for="confirmpassword">Re-enter Password
<span class="small">*</span>
</label>
<input type="password" name="confirmpassword" id="confirmpassword" value="" style="width:200px;"/>
<button type="submit" name="submit">Submit</button>
</form>
</div>
</div>
<?php include("footer.php");?>
</body>
</html>
