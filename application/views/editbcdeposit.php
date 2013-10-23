<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Video</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<?php /*?><script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js"></script><?php */?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
				$("#dates").datepicker({ showOn: 'focus', buttonText: "select" });
  		});
	</script>
</head>

<body>

<div id="container">
<div id="header">
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo">
<div id="stylized" class="myform">
<form action="" method="post" enctype="multipart/form-data" id="form" name="form">
<h1>Add New Broadcaster Video</h1>

<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
?></p>

<label>Broadcaster Name
<span class="small">Required Field</span>
</label>
	<input type="text" name="bsa_broadcasterid" id="bsa_broadcasterid" value="<?php echo $amount['bsa_broadcasterid'];?>" required="required"/>

	<label for="date">Total Amount 
	<span class="small">Required Field</span>
	</label> 
	<input type="text" name="amount" id="amount" value="<?php echo $amount['bsa_totalamount'];?>" required="required"/>
	<label for="date">Total Seeds 
	<span class="small">Required Field</span>
	</label> 
	<input type="text" name="seeds" id="seeds" value="<?php $total = $amount['bsa_seedvalue']*$seeds; echo $total;?>" required="required"/>
	<label for="date">Amount Deposit Date 
	<span class="small">Required Field</span>
	</label> 
	<input type="text" name="dates" id="dates" value="<?php echo $amount['bsa_depositdate'];?>" required="required" readonly="readonly"/>
	<button type="button" name="submit" onClick="location.href='<?=base_url();?>index.php/admin/viewbroadcaster'">Upadte</button> &nbsp;<button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewbroadcaster'">Back</button>
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
</body>
</html>
