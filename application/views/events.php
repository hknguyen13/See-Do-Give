<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<?php /*?><script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js"></script><?php */?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script> 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
    			$("#date").datepicker({ showOn: 'focus', buttonText: "select" });
  		});
	</script>
</head>

<body>
<form action="" method="post">
	<label for="eventname">Event Name :</label> 
	<input type="text" name="eventname" id="eventname" value=""/>
	<br/><br/>
	<label for="date">Event Date :</label>
	<input type="text" name="date" id="date" value="" />
	<br/><br/>
	<label for="eventpalce">Event Place :</label>
	<input type="text" name="eventpalce" id="eventpalce" value="" />
	<br/><br/>
	<label for="eventdesc">Event Desc :</label>
	<textarea name="eventdesc"></textarea>
	<br/><br/>
	<input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
