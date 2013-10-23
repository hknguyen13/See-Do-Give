<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>

	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	
	});
	</script>
</head>
<body>
<?php echo form_open('welcome/register');?>
Username:<input type="text" name="username" value="" required="required"><br/><br/>
Password:<input type="password" name="password" value="" required="required"><br/><br/>
Email:<input type="text" name="email" value="" required="required"><br/><br/>
Phone:<input type="text" name="phone" value="" required="required"><br/><br/>
<input type="submit" name="submit" value="Submit">
<?php echo form_close();?>
</body>
</html>