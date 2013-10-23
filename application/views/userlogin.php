<?php
session_start();
define('YOUR_APP_ID', '421917704507112');
define('YOUR_APP_SECRET', 'c553512a0504cb178077ce51918c97a9');

function get_facebook_cookie($app_id, $app_secret) { 
    $signed_request = parse_signed_request(@$_COOKIE['fbsr_' . $app_id], $app_secret);
    // $signed_request should now have most of the old elements
    $signed_request['uid'] = $signed_request['user_id']; // for compatibility 
    if (!is_null($signed_request)) {
        // the cookie is valid/signed correctly
        // lets change "code" into an "access_token"
  // openssl must enable on your server inorder to access HTTPS
        $access_token_response = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code={$signed_request['code']}");
        parse_str($access_token_response);
        $signed_request['access_token'] = $access_token;
        $signed_request['expires'] = time() + $expires;
    }
    return $signed_request;
}

function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}

if (isset($_COOKIE['fbsr_' . YOUR_APP_ID]))
{ 
$cookie = get_facebook_cookie(YOUR_APP_ID, YOUR_APP_SECRET);

$user = json_decode(@file_get_contents(
    'https://graph.facebook.com/me?access_token=' .
    $cookie['access_token']));
 

//Uncomment this to show all available variables
//echo "<pre>";
 //- print_r function expose all the values available to get from facebook login connect.
//print_r($user);
// 1. Save nessary values from $user Object to your Database
// 2. Register a Sesion Variable based on your user account code
 //3. Redirect to Account Dashboard
//echo "</pre>";
//$_SESSION['email'] = $user->email;
$id = $user->id;
$firstname = $user->first_name;
$lastname = $user->last_name;
$email = $user->email;
$gender = $user->gender;
$birthday = $user->birthday;
$hometown = $user->hometown->name;
$location = explode(',',$hometown);
$loc = trim($location['2']);
$Loc = strtoupper(substr($loc,0,2));

if(!empty($user))
{
$query = $this->db->query("select * from user_tbl where facebook_id='$id'");
$result = $query->result();
if(count($result)==0) 
{
$this->db->query("insert into user_tbl (facebook_id,userfirstname,	userlastname,useremail,userpassword,usergender,userdob,userphone,usercountry,userstate,userstatus) values ('$id','$firstname','$lastname','$email','','$gender','$birthday','','$Loc','','1')");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>seedogive</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpage.css" type="text/css" media="screen" />
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
//alert(CauseName);
if(rate)
{
var seeds = 1;
}
else if(rate=="")
{
	alert("Select rating");
	return false;
}

$.post("http://sritcs.net/demos/seedogive/index.php/user/reviewsubmit",{userId:userid,Seeds:seeds,causename:CauseName,bc_name:bc_id,Bcvideo_id:bcvideo_id},function(data){
//alert(data)	  
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
<script type="text/javascript">
$(document).ready(function(){
$("#register").hide();
$("#siteregister").click(function(){
$("#register").toggle();
});
});
</script>
</head>

<body>
<?php if (@$user) { 
$query = $this->db->query("select * from user_tbl where facebook_id='$id'");
$result = $query->result();
$userid = $result['0']->userid; 
$location = $result['0']->usercountry;
$query = $this->db->query("select * from broadcastervideo ");
$videos=$query->result();
$query1 = $this->db->query("select * from cause_tbl where cause_status=0");
$causes=$query1->result();
if($this->uri->segment("3"))
{
$videoid = $this->uri->segment("3");
$qry = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$videoid'");
$rst = $qry->result();
$bc_id= $rst['0']->bcbroadcaster_id;
$bc_videoid = $rst['0']->bc_videoid;
//$userid = $this->session->userdata('userid');
$query2 = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$videoid'");
$query3 = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$videoid'");
$result1 = $query3->result();
$video_id = $result1['0']->bc_videoid;
$date = date('Y-m-d');
$insertvidecount = $this->db->query("INSERT INTO user_watch_videos (user_id,video_id,broadcasterid,watch_date) VALUES ('$userid','$video_id','$videoid','$date')");
	//print_r($query->result()); exit;
$video=$query2->row_array();
//print_r($data['video']); exit;
}
?>
<div id="header">
<div class="cont_box">
<span class="logo"><a href="<?php echo base_url();?>index.php/user/home"><img src="<?php echo base_url();?>images/logo.png" alt=""></a></span>
<span style="float:left; display:block; margin-top:-80px; margin-left:150px; color:#000000;"><a href="<?php echo base_url(); ?>index.php/user/viewuser" style="margin-left:600px; color:#FFFFFF;"><?php echo $user->name;?></a> | <a href="javascript://" onclick="FB.logout(function() { window.location='<?php echo "http://www.seedogive.com/index.php/user/" ?>' }); return false;" >Logout</a></span>
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
		
		<?php /*?><a  
			 href="http://sritcs.net/demos/seedogive/index.php/user/facebooklogins/1" style="display:block;width:430px;height:250px" 
			 id="player"><img src="<?php echo base_url();?>images/para_img1.png" /> 
		</a> <?php */?>
		
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
<a href="http://www.seedogive.com/index.php/user/facebooklogins/<?php echo $val->bcbroadcaster_id;?>"><img src="<?php echo base_url();?>images/<?php echo $val->bc_videoimage;?>" /></a><?php endforeach;?>	<?php } ?>
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

<?php } else { ?>
<div id="header">
<div class="logo"><a href="<?php echo base_url();?>index.php/user"><img src="<?php echo base_url();?>images/seedogive_logo.png" title="See Do Give Logo" alt="See Do Give Logo" /></a></div>
</div>
<div id="container">
<div id="login" style="width:350px;">
<?php if($success) { echo "<span style='color:green'>".$success."</span>"; } ?>
<a  href="#" id="siteregister" style="font-size:14px;">Register</a>
&nbsp;&nbsp;
<!--<a href="#" style="font-size:14px">Signup with Email</a>-->
&nbsp;&nbsp;<a href="<?php echo base_url();?>index.php/user/login" style="font-size:14px">Login</a>&nbsp;&nbsp;&nbsp;&nbsp; <span style="display:block;position:relative;top:-15px;left:150px;"><div id="fb-root"></div>
<fb:login-button perms="email" width="width_value" show_faces="true" autologoutlink="true" size="large">Login with Facebook</fb:login-button></span>

<div id="register" style="display:block;">
<ul>
<li><a href="<?php echo base_url();?>index.php/user/userregistration" style="font-size:14px">User Registration</a></li>
<li><a href="<?php echo base_url();?>index.php/user/broadcasterregistration" style="font-size:14px">Broadcaster Registration</a></li>
<li><a href="<?php echo base_url();?>index.php/user/causeregistration" style="font-size:14px">Cause Registration</a></li>
</ul>
</div>
</div>
</div>
<?php include("footer.php");?>
<?php } ?>
<script src="http://connect.facebook.net/en_US/all.js"></script>   
<script>
 // Initiate FB Object
 FB.init({
   appId: '<?= YOUR_APP_ID ?>', 
   status: true,
   cookie: true, 
   xfbml: true
   });
 // Reloading after successfull login
 FB.Event.subscribe('auth.login', function(response) { 
 window.location.reload(); 
 });
</script>
</body>
</html>




