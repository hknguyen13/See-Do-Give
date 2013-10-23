<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Seedogive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/rating/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });
});
</script>
</head>

<body>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/user"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="stylized" class="myform">
<form method="post" action="">
<h1>User Login</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
?></p>
<label>User Name
<span class="small">*</span>
</label>
<input type="text" name="email" id="email" value="" required="required"/>
<label>Password
<span class="small">*</span>
</label>
<input type="password" name="password" id="password" required="required"/>
<button type="submit" name="submit">Login</button> &nbsp;<a href="<?php echo base_url();?>index.php/user/forgotuserpassword" style="font-size:13px; margin-top:5px;">Forgot Password</a>
</form>
</div>
</div>
<?php echo include("footer.php");?>
</body>
</html>
