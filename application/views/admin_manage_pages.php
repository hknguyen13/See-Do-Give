<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Pages</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/seedogive1.css" type="text/css" media="screen" />
</head>

<body>
<div id="container">
  <div id="header">
    <?php include("menu.php"); ?>
    <div id="formlineTwo">
      <table width="950" cellspacing="1">
        <tr><td colspan="6"><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo "<span style='color:green; font-family:13px;'>".$success."</span>"; }
?></td></tr>
<tr>
<td bgcolor="#CCCCCC" class="adminView">Page Name</td>
<td bgcolor="#CCCCCC" class="adminView">Page Description</td>
<td bgcolor="#CCCCCC" class="adminView">Edit</td>
<td bgcolor="#CCCCCC" class="adminView">Delete</td>
</tr>
<?php foreach($pageItems as $val):?>
<tr>
<td height="24" style="font-size:12px;" align="center" bgcolor="#eff4fa"><?=$val->PageName;?></td>
<td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?=$val->PageContent;?></td>
<td align="center" bgcolor="#eff4fa"><a href="<?php echo base_url();?>index.php/admin/editpage/<?=$val->PageId;?>"><img src="<?php echo base_url();?>images/edit_icon.png" width="19" height="18" alt="" /></a></td>
<td align="center" bgcolor="#eff4fa"><a href="<?php echo base_url();?>index.php/admin/delpage/<?php echo $val->PageId;?>" onClick="if(confirm('Are u sure to delete')) return true; else return false;"><img src="<?php echo base_url();?>images/delete_icon.png" width="18" height="17" alt="" /></a></td>
</tr>
<?php endforeach;?>
</table>
	  <br/>
<div class="button_row"><a href="<?php echo base_url();?>index.php/admin/managepages">Add New Page</a></div>
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
