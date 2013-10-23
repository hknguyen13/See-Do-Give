<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
    			$("#fromdate").datepicker({ showOn: 'focus', buttonText: "select" });
				$("#todate").datepicker({ showOn: 'focus', buttonText: "select" });
				$("#cfromdate").datepicker({ showOn: 'focus', buttonText: "select" });
				$("#ctodate").datepicker({ showOn: 'focus', buttonText: "select" });
  		});
	</script>
	
</head>
<body>
<div id="container">
<div id="header">
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo" style="height:570px;">
	  <div id="images"><?php if($type=="super") {?><table style="float:left;">
	  <tr><td style="background-color:#666666; color:#FFFFFF; width:200px; text-align:center;">Report Types</td></tr>
	<tr><td><a href="<?php echo base_url();?>index.php/admin/managereports" style="text-decoration:none; margin-left:20px; color:#000000;">Broadcaster Report</a></td></tr>
	<tr><td><a href="<?php echo base_url();?>index.php/admin/managecausereports" style="text-decoration:none; color:#000000; margin-left:20px;">Cause Report</a></td></tr>
	<tr><td><a href="<?php echo base_url();?>index.php/admin/manageuserreports" style="text-decoration:none; margin-left:20px; color:#000000;">User Report</a></td></tr>
	</table><?php }  else if($type==$bc_name) {?>
	<table style="float:left;">
	  <tr><td style="background-color:#666666; color:#FFFFFF; width:200px; text-align:center;">Report Types</td></tr>
	<tr><td><a href="<?php echo base_url();?>index.php/admin/managereports" style="text-decoration:none; margin-left:20px; color:#000000;">Broadcaster Report</a></td></tr>
	</table><?php } else if($type==$c_name) {?>
	<table style="float:left;">
	 <tr><td style="background-color:#666666; color:#FFFFFF; width:200px; text-align:center;">Report Types</td></tr>
	<tr><td><a href="<?php echo base_url();?>index.php/admin/managecausereports" style="text-decoration:none; color:#000000; margin-left:20px;">Cause Report</a></td></tr>
	</table>
	<?php } ?></div>
<div id="stylized" class="myform" style="margin-left:50px;">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Cause Report</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($suresh) { echo "<span style='color:red; font-family:13px;'>".$suresh."</span><br/>"; }
if($dates) { echo "<span style='color:red; font-family:13px;'>".$dates."</span><br/>"; }
if($success) { echo $success; }
?></p>

<label for="cname">Cause Name
</label>
<select name="cname" id="cname">
<?php foreach($causes as $vals): ?>
<option value="<?php echo $vals->cause_id;?>"><?php echo $vals->cause_name;?></option>
<?php endforeach;?>
</select>
<label>From Date</label>
<input type="text" name="cfromdate" id="cfromdate" value="" size="40" required="required">
<label>To Date</label>
<input type="text" name="ctodate" id="ctodate" value="" size="40" required="required">

<button type="submit" name="submit">Export to CSV</button> &nbsp;<button type="submit" name="display" class="button1">View Report</button>
<div class="spacer"></div>
</form>
</div>
</div>
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