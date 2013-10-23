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
    			$("#date").datepicker({ showOn: 'focus', buttonText: "select" });
				$("#dates").datepicker({ showOn: 'focus', buttonText: "select" });
  		});
	</script>
	<style type="text/css">
.bc_menu ul{
width:700px;
}
.bc_menu ul li {
float:left;
list-style:none;
}
.bc_menu ul li a{
padding:7px;
text-decoration:none;
color:#0000FF;
}
.bc_menu ul li a:hover{
color:#999999;
}
.bc_menu ul li a.active {
color:#000000;
}
</style>
</head>

<body>

<div id="container">
<div id="header">
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo" style="height:570px;">
	   <div class="bc_menu" style="height:30px;"><ul id="bc_menu"><li><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster">View Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/addbroadcaster">Add Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/adminstaffregister">Add Broadcaster Admin</a></li><li><a href="<?php echo base_url();?>index.php/admin/manageseeds">Seed Configration</a></li><li><a href="<?php echo base_url();?>index.php/admin/broadcasterdeposit">Add Amount</a></li><li><a href="<?php echo base_url();?>index.php/admin/addvideos"  <?php if (strpos($_SERVER['PHP_SELF'], "admin/addvideos")) { echo 'class="active"'; }?>>Add Video</a></li></ul></div>
<div id="stylized" class="myform">
<form action="" method="post" enctype="multipart/form-data" id="form" name="form">
<h1>Add New Broadcaster Video</h1>

<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
if($uploadfailed) { echo "<span style='color:red; font-family:13px;'>".$uploadfailed."</span><br/>"; }
if($empty) { echo "<span style='color:red; font-family:13px;'>".$empty."</span><br/>"; }
if($add) { echo "<span style='color:red; font-family:13px;'>".$add."</span><br/>"; }
?></p>

<label>Broadcaster Name
<span class="small">*</span>
</label>
	<select name="bvname">
	<option value=" ">Select</option>
	<?php foreach($broadcaster as $vals): ?>
	<option value="<?php echo $vals->broadcaster_id;?>" <?php if($videos['bcbroadcaster_id']==$vals->broadcaster_id) { echo "selected=selected";} ?>><?php echo $vals->broadcaster_name;?></option>
	<?php endforeach;?>
	</select>
    <label for="date">Video Title
	<span class="small">*</span>
	</label> 
	<input type="text" name="videotitle" id="videotitle" value="<?php echo $videos['bcvideo_title'];?>" required="required"/>
	<label for="date">Video Start Date 
	<span class="small">*</span>
	</label> 
	<input type="text" name="date" id="date" value="<?php echo $videos['bc_videostartdate'];?>" required="required" readonly="readonly"/>
	<label for="date">Video End Date 
	<span class="small">*</span>
	</label> 
	<input type="text" name="dates" id="dates" value="<?php echo $videos['bc_videoenddate'];?>" required="required" readonly="readonly"/>
	<label>Broadcaster Country 
	<span class="small">*</span>
	</label> 
	<select name="bcountry">
	<?php foreach($country as $vals): ?>
	<option value="<?php echo $vals->Country_Code;?>" <?php if($videos['bc_videolocation']==$vals->Country_Code) { echo "selected=selected";} ?>><?php echo $vals->Country_Name;?></option>
	<?php endforeach;?>
	</select>
	<label for="date">Broadcaster Video
	<span class="small">*</span>
	</label> 
	<input type="file" name="userfile" id="userfile" required="required"/>
	<label style="margin-left:120px; width:300px; color:red; margin-top:-20px;">
<span>Uploading video should not be greater than 3MB</span>
</label>
	<button type="submit" name="submit">Save</button> &nbsp;<button type="reset" name="submit" class="button1">Reset</button>
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
