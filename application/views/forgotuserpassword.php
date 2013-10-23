<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>User Forgot Password</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
</head>

<body>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/user"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="stylized" class="myform">
<form method="post" action="">
<h1>Forgot Password</h1>
<p>
<?php
if($email) { echo "<span style='color:red; font-family:13px;'>".$email."</span><br/>"; }
if($succ_msg==1) { echo '<span style="color:green; font-size:13px; width:200px;">Please Check your email for resetpassword</span><br/>'; }
?></p>
<label for="email">Email
<span class="small">*</span>
</label> 
<input type="text" name="email" id="email" value="" style="width:200px;" required="required"/>
<button type="submit" name="submit">Submit</button>
</form>
</div>
</div>
<?php echo include("footer.php");?>
</body>
</html>
