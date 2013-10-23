<div class="logo"><?php if($type=="super") { ?><a href="<?php echo base_url();?>index.php/admin/viewuser"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a><?php } elseif($type==$bc_name) {?><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a><?php } elseif($type==$bc_name) {?>elseif($type==$c_name) {?><a href="<?php echo base_url();?>index.php/admin/viewcause"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a><?php } else { ?><a href="<?php echo base_url();?>index.php/admin/viewcause"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a><?php } ?></div>
    <div class="adminText"><a href="<?php echo base_url();?>index.php/admin/viewuser" title="Admin">Admin</a> | <a href="<?php echo base_url(); ?>index.php/admin/logout" title="Logout">Logout</a></div>
    <div class="clear"></div>
<div id="menu">
<?php if($type=="super") {?>
      <ul>
        <li><a href="<?php echo base_url();?>index.php/admin/viewuser" title="Manage User" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewuser")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/edituser")) {echo 'class="current1"';}?>>Manage Users</a></li>
        <li><a href="<?php echo base_url();?>index.php/admin/getpage" title="Manage Pages" <?php if (strpos($_SERVER['PHP_SELF'], "admin/getpage")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/editpage")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/managepages")) {echo 'class="current1"';}?>>Manage Pages</a></li>
		
        <li><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster" title="Manage Broadcasters" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewbroadcaster")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/editbroadcaster")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/addbroadcaster")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/manageseeds")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/broadcasterdeposit")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/addvideos")) {echo 'class="current1"';}?>>Manage Broadcasters</a></li>
		
        <li><a href="<?php echo base_url();?>index.php/admin/viewcause" title="Manage Causes" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewcause")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/editcause")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/addcause")) {echo 'class="current1"';}?>>Manage Causes</a></li>
		
        <li><a href="<?php echo base_url();?>index.php/admin/viewadminstaff" title="Manage Admin Staff" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewadminstaff")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/adminstaffregister")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/editadminstaff")) {echo 'class="current1"';}?>>Manage Admin Staff</a></li>
		
        <li><a href="<?php echo base_url();?>index.php/admin/managereports" title="Manage Reports" <?php if (strpos($_SERVER['PHP_SELF'], "admin/managereports")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/managecausereports")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/manageuserreports")) {echo 'class="current1"';}?>>Manage Reports</a></li>
		 
      </ul>
	  <?php } elseif($type==$bc_name && $type!=$c_name) {?>
	  <ul>
        <li><a href="<?php echo base_url();?>index.php/admin/viewbroadcaster" title="Manage Broadcasters" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewbroadcaster")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/editbroadcaster")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/addbroadcaster")) {echo 'class="current1"';}?> style="margin-left:-30px;">Manage Broadcasters</a></li>
        <li><a href="<?php echo base_url();?>index.php/admin/managereports" title="Manage Reports" <?php if (strpos($_SERVER['PHP_SELF'], "admin/managereports")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/managecausereports")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/manageuserreports")) {echo 'class="current1"';}?> style="margin-left:10px;">Manage Reports</a></li>
      </ul>
	  <?php } elseif ($type==$c_name && $type!=$bc_name) { ?>
	  <ul>
        <li>
        <li><a href="<?php echo base_url();?>index.php/admin/viewcause" title="Manage Causes" <?php if (strpos($_SERVER['PHP_SELF'], "admin/viewcause")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/editcause")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/addcause")) {echo 'class="current1"';}?> style="margin-left:-30px;">Manage Causes</a></li>
        <li><a href="<?php echo base_url();?>index.php/admin/managecausereports" title="Manage Reports" <?php if (strpos($_SERVER['PHP_SELF'], "admin/managecausereports")) { echo 'class="current1"'; } else if(strpos($_SERVER['PHP_SELF'], "admin/managecausereports")) {echo 'class="current1"';} else if(strpos($_SERVER['PHP_SELF'], "admin/manageuserreports")) {echo 'class="current1"';}?> style="margin-left:10px;">Manage Reports</a></li>
      </ul>
	  <?php } ?>
    </div>