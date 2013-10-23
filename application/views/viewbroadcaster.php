<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Show Broadcaster</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/seedogive1.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<style type="text/css">
.bc_menu ul{
width:800px;
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
    <div id="formlineTwo">
	<div class="bc_menu" style="height:30px;"><?php if($type=="super") { ?><ul id="bc_menu"><li><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewbroadcaster")) { echo 'class="active"'; }?>>View Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/addbroadcaster">Add Broadcaster</a></li><li><a href="<?php echo base_url();?>index.php/admin/adminstaffregister">Add Broadcaster Admin</a></li><li><a href="<?php echo base_url();?>index.php/admin/manageseeds">Seed Configration</a></li><li><a href="<?php echo base_url();?>index.php/admin/broadcasterdeposit">Add Amount</a></li><li><a href="<?php echo base_url();?>index.php/admin/addvideos">Add Video</a></li></ul><?php } ?></div>
      <table width="950" cellspacing="1">
        <tr><td colspan="6"><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo "<span style='color:green; font-family:13px;'>".$success."</span>"; }
?></td></tr>
        <tr>
          <td bgcolor="#CCCCCC" class="adminView">B Name</td>
          <td bgcolor="#CCCCCC" class="adminView">B Email</td>
		  <td bgcolor="#CCCCCC" class="adminView">B Description</td>
          <td bgcolor="#CCCCCC" class="adminView">B videoTitle</td>
          <td bgcolor="#CCCCCC" class="adminView">B AdminName</td>
           <td bgcolor="#CCCCCC" class="adminView">B Amount</td>
          <td bgcolor="#CCCCCC" class="adminView">Edit</td>
          <td bgcolor="#CCCCCC" class="adminView">Delete</td>
        </tr>
		<?php foreach($broadcaster as $vals):?>
        <tr>
          <td height="24" style="font-size:12px;" align="center" bgcolor="#eff4fa"><?php echo $vals->broadcaster_name;?></td>
          <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->broadcaster_email;?></td>
		   <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->broadcaster_desc;?></td>
          <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->bcvideo_title;?></td>
          <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->admin_type;?></td>
		  <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->bsa_totalamount;?></td>
         
          <td align="center" bgcolor="#eff4fa"><a href="<?php echo base_url();?>index.php/admin/editbroadcaster/<?php echo $vals->broadcaster_id;?>"><img src="<?php echo base_url();?>images/edit_icon.png" width="19" height="18" alt="" /></a></td>
          <td align="center" bgcolor="#eff4fa"><a href="<?php echo base_url();?>index.php/admin/deletebroadcaster/<?php echo $vals->broadcaster_id;?>" onClick="if(confirm('Are u sure to delete')) return true; else return false;"><img src="<?php echo base_url();?>images/delete_icon.png" width="18" height="17" alt="" /></a></td>
        </tr>
        <?php endforeach;?>
      </table>
	  <br/>
	  
<div class="button_row"><?php if($type=="super") {?><?php /*?><a href="<?php echo base_url();?>index.php/admin/addbroadcaster">Add New Broadcaster</a><?php */?>&nbsp;&nbsp;<?php /*?><a href="<?php echo base_url();?>index.php/admin/showvideo">Show Broadcaster Videos</a><?php */?><?php } elseif($type==$bc_id && $type!=$c_id) { ?> <?php /*?><a href="<?php echo base_url();?>index.php/admin/showvideo">Show Broadcaster Videos</a>&nbsp;&nbsp;<a href="<?php echo base_url();?>index.php/admin/editseed/<?php echo $vals->broadcaster_id;?>">Edit seed</a><?php */?><?php } ?></div>
 </div>
    </div>
  </div>
</div>
<div id="footer">
  <div id="footercontainer">
    <div class="menu"><a href="#" title="Home">Home</a> | <a href="#" title="How It Works">How It Works</a> | <a href="#" title="Blog">Blog</a>| <a href="#" title="Advertise">Advertise</a> | <a href="#" title="Contact Us">Contact Us</a></div>
    <div class="copyRights">� 2011, SeeDoGive. All Rights Reserved.</div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
