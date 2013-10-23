<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Seedogive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/seedogive.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>jquery/rating/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#date").datepicker({ showOn: 'focus', buttonText: "select" });
});
</script>
<style type="text/css">
body{
font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}
/* ----------- My Form ----------- */
.myform{
margin:0 auto;
width:400px;
padding:14px;
height:200px;
}
</style>
</head>

<body>
<div id="container">
  <div id="header">
    <div class="logo"><a href="<?php echo base_url();?>index.php/admin"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
    <div id="containerTwo">
      <div class="adminFormBgcolor">
	<div id="stylized" class="myform">
<form action="" method="post">
<h1>Email Registration</h1>
<label>Email
<span class="small">Required Field</span>
</label>
<input type="text" name="email" value="" id="email" required="required" />
<label>Password
<span class="small">Required Field</span>
</label>
<input type="password" name="password" id="password" required="required"  />
<!--<label>Gender
<span class="small">Required Field</span>
</label>
 <input type="radio" name="gender" id="gender" value="male" /> Male &nbsp;<input type="radio" name="gender" id="gender" value="female" /> female-->
 <label>Dob
<span class="small">Required Field</span>
</label>
<input type="text" name="date" id="date" value=""  required="required"/><br/><br/>
<input type="submit" name="submit" value="Sign Up" style="background-color:#666666; color:#FFFFFF;" />
</form>
</div>
      </div>
    </div>
  </div>
</div><div id="footer">
<div id="footercontainer">
 <div class="menu"><a href="#" title="Home">Home</a> | <a href="#" title="How It Works">How It Works</a> | <a href="#" title="Blog">Blog</a>| <a href="#" title="Advertise">Advertise</a> | <a href="#" title="Contact Us">Contact Us</a></div>
 <div class="copyRights">© 2011, SeeDoGive. All Rights Reserved.</div>
 <div class="clear"></div>
    </div>
</div>

</body>
</html>
