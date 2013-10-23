<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Seedogive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage.css" type="text/css" media="screen" />
</head>
<body>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/user"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="login" style="background-color:#FFFFFF; top:280px;">
<h1 style="text-align:left;color:green;font-size:18px;font-weight:bold;">Thanks for Registration</h1>
<br>
<br>
<span style="font-size:14px;text-align:left;">Please check your email for the activation link.</span> <br>
<br>
<?php /*?><span style="margin-left:100px;">(or)</span> <br>
<br>
Click the following link to activate <br>
<br>
<a href="<?php echo base_url();?>index.php/user/useractivation/<?php echo $key; ?>" style="color:#3765CE; font-weight:bold;">Activation
Link</a> <?php */?>
</div>
</div>
<?php include("footer.php");?>
</body>
</html>
