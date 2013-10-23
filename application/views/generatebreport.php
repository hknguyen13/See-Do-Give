<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SeeDoGive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
</head>

<body>
<div id="container">
<div id="header">
<div style="padding:0 0 8px 0; margin:0;"><a href="<?php echo base_url();?>index.php/user/"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
 <div style="margin-left:100px; margin-top:20px;">
<table width="800" cellspacing="1">
        <tr>
          <td bgcolor="#CCCCCC" class="adminView">Broadcaster Name</td>
          <td bgcolor="#CCCCCC" class="adminView">User Email</td>
          <td bgcolor="#CCCCCC" class="adminView">User Location</td>
          <td bgcolor="#CCCCCC" class="adminView">Cause</td>
		   <td bgcolor="#CCCCCC" class="adminView">Clicks</td>
          <td bgcolor="#CCCCCC" class="adminView">Seeds</td>
          <td bgcolor="#CCCCCC" class="adminView">Amount</td>
        </tr>
		<?php foreach($report as $vals):?>
        <tr>
          <td height="24" style="font-size:12px;" align="center" bgcolor="#eff4fa"><?php echo $vals->broadcaster_name;?></td>
          <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->useremail;?></td>
          <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->usercountry;?></td>
		  <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->cause_name;?></td>
		  <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->clicks;?></td>
          <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->seeds;?></td>
		  <td align="center" style="font-size:12px;" bgcolor="#eff4fa"><?php echo $vals->amount;?></td>
        </tr>
        <?php endforeach;?>
      </table>
	  <p style="margin-left:745px;"><button type="button" name="submit" class="button1" onClick="location.href='<?=base_url();?>index.php/admin/managereports'">Back</button></p>
	    </div>
</div>
</div>
<div id="footer" style="margin-top:300px;">
<div id="footercontainer">
	<div class="menu"><a href="#" title="Home">Home</a> | <a href="#" title="How It Works">How It Works</a> | <a href="#" title="Blog">Blog</a>| <a href="#" title="Advertise">Advertise</a> | <a href="#" title="Contact Us">Contact Us</a></div>
	<div class="copyRights">© <?php echo date("Y");?>, SeeDoGive. All Rights Reserved.</div>
	<div class="clear"></div>
  </div>
</div>
</body>
</html>