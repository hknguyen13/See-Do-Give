<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Seedogive</title>
<script type="text/javascript" src="<?php echo base_url();?>jquery/general.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jquery/rating/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jquery/rating/starrating.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>jquery/flowplayer-3.2.8.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
});
function SaveReview()
{
var bc_id=$('#bc_id').val();
var bcvideo_id=$('#bc_videoid').val(); 
var CauseName=$('#cause_name').val();
var rate=$('#rating_value').val();
var userid=$('#userid').val();

if(rate)
{
var seeds = 1;
}
else if(rate=="")
{
	alert("Select rating");
	return false;
}

$.post("<?php echo base_url();?>index.php/user/reviewsubmit",{userId:userid,Seeds:seeds,causename:CauseName,bc_name:bc_id,Bcvideo_id:bcvideo_id},function(data){
	  
if(data==1)
{
alert("Thanks for your donations to Cause");
return true;
}
});
}
</script>
<link href="<?php echo base_url();?>css/rating/starrating.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" media="screen" />	

  <style> 

#at16p {
margin-left:-10px !important;
}
  .overlay {
    padding:40px;	
    width:576px;  
    display:none;
    background-image:url(images/white.png);	
  }
   
  .close {
    background:url(images/close.png) no-repeat;
    position:absolute;
    top:2px;
    right:5px; 
    display:block;
    width:35px;
    height:35px;
    cursor:pointer;
  }
   
  #player {
    height:450px;
    display:block;
  }
  
  </style> 
  
</head>
<body>
<!--header Starts Here-->
<?php if($this->session->userdata['useremail']) { 
$username = $this->session->userdata['userfirstname'];?>

<div id="header">
<div class="cont_box">
<span class="logo"><a href="<?php echo base_url();?>index.php/user/home"><img src="<?php echo base_url();?>images/logo.png" alt=""></a></span>
<span style="float:left; display:block; margin-top:-80px; margin-left:150px; color:#000000;"><a href="<?php echo base_url(); ?>index.php/user/viewuser" style="margin-left:600px; color:#FFFFFF;"><?php echo $username;?></a> | <a href="<?php echo base_url(); ?>index.php/user/logout" style="color:#FFFFFF;">Logout</a></span>
<div class="clear"></div>
</div>
</div>
<!--header Finish Here-->

<!--main_container Starts Here-->
<div id="main_container">

<br />

<!--cont_box Starts Here-->
<div class="cont_box">

<!--step1_block Starts Here-->
<div class="step1_block">
<h1><img src="<?php echo base_url();?>images/step1.jpg" alt=""></h1>
<div style="margin-left:12px;">
		<!-- this A tag is where your Flowplayer will be placed. it can be anywhere -->
		<?php if($video) {?>
		<a  
			 href="<?php echo base_url();?>video/<?php echo $video['bc_videopath'];?>"
			 style="display:block;width:430px;height:250px"  
			 id="player"> 
		</a>
		<?php } else {?>
		
		<a  
			 href="<?php base_url();?>index.php/user/home/<?php echo rand(1,5);?>"
			 style="display:block;width:430px;height:250px"  
			 id="player"><img src="<?php echo base_url();?>images/para_img1.png" /> 
		</a> 
		
	<?php } ?>
	
	<script>
			flowplayer("player", "<?php echo base_url();?>/flowplayer-3.2.8.swf");
		</script>
</div>
</div>

<div>
<form action="" method="post">
<span id="step2">
  <div class="step4">
    <p>And earn 1 seeds</p>
	<ul class='star-rating' style="margin-left:60px;" >
<li class="current-rating" id="current-rating"><!-- will show current rating --></li>
<span id="ratelinks">
<li><a href="javascript:void(0)" title="1 star out of 5" class="one-star">1</a></li>
<li><a href="javascript:void(0)" title="2 stars out of 5" class="two-stars">2</a></li>
<li><a href="javascript:void(0)" title="3 stars out of 5" class="three-stars">3</a></li>
<li><a href="javascript:void(0)" title="4 stars out of 5" class="four-stars">4</a></li>
<li><a href="javascript:void(0)" title="5 stars out of 5" class="five-stars">5</a></li>
</span>
</ul>
    <p style="padding-top:80px;">And earn 2 seeds</p>
	<div class="addthis_toolbox addthis_default_style" style="margin-left:90px;">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<!--<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>-->
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f76d89332199794"></script>
<!-- AddThis Button END -->
  </div>
</span>

<span id="step2">
  <div class="step5">
  	<div class="selectBox">
    <select class="contact_field" id="cause_name" name="cause_name" style="width: 200px; padding:0; margin:0;">
<option value=" ">Select</option>
<?php foreach($causes as $vals): ?>
<option value="<?php echo $vals->cause_id;?>"><?php echo $vals->cause_name;?></option>
<?php endforeach;?>
</select>
<input  type="hidden" name="userid" id="userid"  value="<?php echo $userid; ?>" />
<input  type="hidden" name="rating_value" id="rating_value"  value="" />
<input  type="hidden" name="bc_id" id="bc_id"  value="<?php echo $bc_id; ?>" />
<input  type="hidden" name="bc_videoid" id="bc_videoid"  value="<?php echo $bc_videoid; ?>" />
<br/><br/>
</div>
<button type="button" onclick="SaveReview()" style=" height: 37px; margin-left:80px; margin-top:20px; width:100px;">Give</button>
  	<?php /*?><div class="giveButton"><input type="image" src="<?php echo base_url();?>images/giveButton.jpg" name="submit" id="submit" value="" style="margin-left:0px;" onclick="SaveReview()"/></div><?php */?>
  	<div></div>
  </div>
</span>
</form>
</div>

<div class="clear"></div>
</div>

<div class="green-container bottom">
<div class="green_top_curve">
<div class="green_bottom_curve">

<!--green-left-container Starts Here-->
<div class="green-left-container"></div>

<div class="green-left-containerTwo"><?php if(empty($videos)) { echo "<p style='color:red;'>No Videos For your Location</p>";?><?php } else { ?><?php foreach($videos as $val):?>
<a href="<?php echo base_url();?>index.php/user/home/<?php echo $val->bcbroadcaster_id;?>"><img src="<?php echo base_url();?>images/<?php echo $val->bc_videoimage;?>" /></a><?php endforeach;?>	<?php } ?>
<?php /*?><?php foreach($videos as $val):?><a href="<?php echo base_url();?>index.php/user/home/<?php echo $val->bcbroadcaster_id;?>"><img src="<?php echo base_url();?>images/para_img1.png"/></a><?php endforeach;?><?php */?></div>
<div class="clear"></div>
</div>
</div>
</div>
<!--green-container Finish Here-->
</div>
<div id="footer">
<div id="footercontainer">
	<div class="menu"><?php if($this->session->userdata['useremail']) { ?><a href="<?php echo base_url();?>index.php/user/home" title="Home">Home</a><?php } else {?><a href="<?php echo base_url();?>index.php/user" title="Home">Home</a><?php }?> | <a href="#" title="How It Works">How It Works</a> | <a href="#" title="Blog">Blog</a>| <a href="#" title="Advertise">Advertise</a> | <a href="#" title="Contact Us">Contact Us</a></div>
	<div class="copyRights">© <?php echo date("Y");?>, SeeDoGive. All Rights Reserved.</div>
	<div class="clear"></div>
  </div>
</div>
<?php }?>

</body>
</html>