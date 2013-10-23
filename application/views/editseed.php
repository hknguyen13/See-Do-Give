<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Seed</title>
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
<h1>Edit Seed Configuration</h1>

<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($upadted) { echo "<span style='color:green; font-family:13px;'>".$upadted."</span><br/>"; }
?></p>

<label>Broadcaster Name
<span class="small">Required Field</span>
</label>
<select name="bsa_broadcasterid" required="required">
<option value=" ">Select</option>
<?php foreach($broadcaster as $vals):?>
<option value="<?php echo $vals->broadcaster_id;?>" <?php if($vals->broadcaster_id==$seeds['sc_broadcasterid']) { echo "selected=selected"; }?>><?php echo $vals->broadcaster_name;?></option>
<?php endforeach; ?>
</select>
	<label for="date">Seeds 
	<span class="small">Required Field</span>
	</label> 
	<select name="seeds" required="required">
	<option value=" ">Select</option>
	<option value="1" <?php if($seeds['seeds']=="1") echo "selected=selected";?>>1</option>
	<option value="2"  <?php if($seeds['seeds']=="2") echo "selected=selected";?>>2</option>
	<option value="3"  <?php if($seeds['seeds']=="3") echo "selected=selected";?>>3</option>
	<option value="4"  <?php if($seeds['seeds']=="4") echo "selected=selected";?>>4</option>
	<option value="5"  <?php if($seeds['seeds']=="5") echo "selected=selected";?>>5</option>
	<option value="6"  <?php if($seeds['seeds']=="6") echo "selected=selected";?>>6</option>
	<option value="7"  <?php if($seeds['seeds']=="7") echo "selected=selected";?>>7</option>
	<option value="8"  <?php if($seeds['seeds']=="8") echo "selected=selected";?>>8</option>
	<option value="9"  <?php if($seeds['seeds']=="9") echo "selected=selected";?>>9</option>
	<option value="10"  <?php if($seeds['seeds']=="10") echo "selected=selected";?>>10</option>
	</select>
	<label for="date">Dollars
	<span class="small">Required Field</span>
	</label> 
	<select name="dollars" required="required">
	<option value=" ">Select</option>
	<option value="1" <?php if($seeds['dollars']=="1") echo "selected=selected"?>>1</option>
	<option value="2" <?php if($seeds['dollars']=="2") echo "selected=selected"?>>2</option>
	<option value="3" <?php if($seeds['dollars']=="3") echo "selected=selected"?>>3</option>
	<option value="4" <?php if($seeds['dollars']=="4") echo "selected=selected"?>>4</option>
	<option value="5" <?php if($seeds['dollars']=="5") echo "selected=selected"?>>5</option>
	<option value="6" <?php if($seeds['dollars']=="6") echo "selected=selected"?>>6</option>
	<option value="7" <?php if($seeds['dollars']=="7") echo "selected=selected"?>>7</option>
	<option value="8" <?php if($seeds['dollars']=="8") echo "selected=selected"?>>8</option>
	<option value="9" <?php if($seeds['dollars']=="9") echo "selected=selected"?>>9</option>
	<option value="10" <?php if($seeds['dollars']=="10") echo "selected=selected"?>>10</option>
	</select>
	<label for="date">Amount DepositDate 
	<span class="small">Required Field</span>
	</label> 
	<input type="text" name="" id="" value="<?php echo $seeds['createddate']; ?>" required="required" readonly="readonly"/>
	<label for="date">Amount ModifyDate 
	<span class="small">Required Field</span>
	</label> 
	<input type="text" name="dates" id="dates" value="<?php echo $seeds['modifydate']; ?>" required="required" readonly="readonly"/>
	<button type="submit" name="submit">Submit</button> &nbsp;<button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/viewbroadcaster'">Back</button>
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
	<div class="copyRights">� <?php echo date("Y");?>, SeeDoGive. All Rights Reserved.</div>
	<div class="clear"></div>
  </div>
</body>
</html>
