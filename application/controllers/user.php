<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('adminmodel');
		$this->load->model('usermodel');
		//$this->load->model('Facebook_model');
		$this->load->library('form_validation');
		$this->load->library( 'jquery_stars' );
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->helper('array');
		error_reporting(E_PARSE);
	}
	
	public function index()
	{
	//$suresh = FACEBOOK_APP_ID;
	if($this->uri->segment('3')=="success")
	{
	$data['success'] = "Registration to the site is done successfully";
	}
	if($this->uri->segment(3)=="successfull")
	{
	$data['success'] = "Password is Reset Successfully";
	}
	/*$fb_data = $this->session->userdata('fb_data');
	$data = array(
	'fb_data' => $fb_data,
	);*/
	$this->load->view('userlogin',$data); 
	}

	function login()
	{
	if(isset($_POST['submit']))
	{
	$email = $this->input->post('email');
	$password = md5($this->input->post('password'));
	$value = $this->usermodel->getuserdata($email,$password);
	if(!empty($value))
	{
	$status = $value['0']->userstatus;
	if($status==1)
	{
	$userinfo = array(
	'userid'  => $value['0']->userid,
	'userfirstname'=>$value['0']->userfirstname,
	'useremail'=>$value['0']->useremail,
	'user_logged_in' => TRUE
	);
	$this->session->set_userdata($userinfo);
	
	redirect("user/home");
	exit;
	}
	else
	{
	$data["error"] = "Please Active the Link";
	}
	}
	else
	{
	$data["error"] = "Invalid Username or Password";
	}
	}
	$this->load->view('userloginpage',$data);  
	}
	
	function userregistration()
	{
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
	if($this->uri->segment('3')=="empty")
	{
	$data["empty"]="Please fill the mandatory fields";
	}
	if($this->uri->segment('3')=="duplicate")
	{
	$data["duplicate"]="Email address already exists";
	}
	if(isset($_POST['submit']))
	{
	$firstname = $this->input->post('firstname'); 
	$lastname = $this->input->post('lastname'); 
	$email = $this->input->post('email'); 
	$password = md5($this->input->post('password'));
	$gender = $this->input->post('ugender');
	$contact = $this->input->post('contact');
	$country = $this->input->post('country');
	$state = $this->input->post('state');
	$date = date("Y-m-d",strtotime($this->input->post('date')));
	$createdon = date("Y-m-d");
	$activationkey = md5(uniqid(rand()));
	
	if($email=="" || $password=="")
	{
	redirect("user/userregistration/empty");
	exit;
	}
	else if($email)
	{
	$query = $this->db->query("select * from user_tbl where useremail='$email'");
	$result = $query->result();
	$useremail = $result['0']->useremail;
	//echo count($result); exit;
	if(count($result)==0)
	{
	$values = array('userfirstname'=>$firstname,'userlastname'=>$lastname,'useremail'=>$email,'userpassword'=>$password,'usergender'=>$gender,'userdob'=>$date,'userphone'=>$contact,'usercreatedon'=>$createdon,'useractivationkey'=>$activationkey,'usercountry'=>$country,'userstate'=>$state
	);
	$insertuserdata = $this->usermodel->insertdata($values);
	if($insertuserdata)
	{
	
	$config['mailtype'] = 'html';
	$config['wordwrap'] = TRUE;

	$this->email->initialize($config);
	$this->email->from('suresh.pegadapelli@gmail.com', 'Seedogive');
	$this->email->to($email);
	$this->email->subject('User Activation');
	$message="<table>
	<tr>
	<td>Dear ".$firstname.",<br><br></td>
	</tr>
	<tr>
	<td>Thank you for signing up. Please click the below activation link to active your account.<br><br></td>
	</tr>
	<tr>
	<td>".base_url()."index.php/user/useractivation/".$activationkey." <br><br></td>
	</tr>
	<tr>
	<td>Thank You</td>
	</tr>
	</table>";
	$this->email->message($message);
	$this->email->send();
		
	redirect("user/thankyou");
	exit;
	}
	}
	else {
	redirect("user/userregistration/duplicate");
	exit;
	}
	}
	}
	$this->load->view('userregistration',$data);  
	}
	
	function thankyou()
	{
	$data['key'] = $this->uri->segment("3");
	$this->load->view('thankyou',$data);
	}
	
	function useractivation()
	{
	$key = $this->uri->segment("3");
	$result = $this->usermodel->getuser($key);
	$id = $result['0']->userid;
	$update = $this->usermodel->updateuser($key);
	if($update)
	{
	$userinfo = array(
	'userid'  => $result['0']->userid,
	'userfirstname'=>$result['0']->userfirstname,
	'useremail'=>$result['0']->useremail,
	'user_logged_in' => TRUE
	);
	$this->session->set_userdata($userinfo);
	
	$this->db->query("update user_tbl set useractivationkey='' where userid='$id'");
	redirect("user/home");
	exit;
	}
	}
	
	
	public function home()
	{
	
	 if($this->session->userdata['useremail'])
	{
	$data['userid'] = $this->session->userdata['userid'];
	$userid = $data['userid'];
	if($this->uri->segment("3")=="success")
	{
	$data['sucess'] = "Thanks for your Contributions to";
	}
	if($this->uri->segment("3")=="failure")
	{
	$data['failure'] = "failed";
	}
	if($this->uri->segment("3"))
	{
	$videoid = $this->uri->segment("3");
	$qry = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$videoid'");
	$rst = $qry->result();
	$data['bc_id'] = $rst['0']->bcbroadcaster_id;
	$data['bc_videoid'] = $rst['0']->bc_videoid;
	$data['video'] = $this->usermodel->showVideo($videoid);
	//print_r($data['video']); exit;
	}
	$date = date('Y-m-d');
	$qur = $this->db->query("select count(video_id) as clicks,video_id from user_watch_videos where user_id='$userid' and watch_date='$date'");
	$res = $qur->result();
	$count = $res['0']->clicks;
	//$data['bid'] = $res['0']->video_id;
	$data['count'] = $count;
    $query = $this->db->query("select * from user_tbl where userid='$userid'");
	$result = $query->result(); 
	$location = $result['0']->usercountry;
	$data['videos'] = $this->usermodel->showvideos($location);
	$data['causes'] = $this->adminmodel->showcauses();

	
	 //print_r($data['causes']); exit; 
	 $data['title'] = "Seedogive";
	 $this->load->view('home',$data);  
	}
	else {
	redirect("user/index");
	exit;
	}
	}
	
	function usergetrating(){
	    $userid = $_REQUEST['userid'];
		//$this->usermodel->GetRating($userid);
		//print_r($this->db->last_query()); 	
	}
	
	function reviewsubmit()
	{
	//echo "suresh"; exit;
	$userId = $this->input->post('userId'); 
	$seeds = $this->input->post('Seeds'); 
	$causename = $this->input->post('causename'); 
	$broadcasterid = $this->input->post('bc_name');
	$broadcastervideoid = $this->input->post('Bcvideo_id');  
	//echo $userId; exit;
	//
	if($userId!='' && ($rating || $causename )){ 
	 
	$query = $this->usermodel->reviewinsertdata($userId,$seeds,$causename,$broadcasterid,$broadcastervideoid);
	
	}
	}
	
	function forgotuserpassword()
	{
	if(isset($_POST['submit']))
	{
	$user_email = $this->input->post('email');
	
	$query = $this->usermodel->forgotUserpassword($user_email);
		$useremail = $query[0]->useremail;
		$UserFirstName = $query[0]->userfirstname;
		if(!empty($query))
		{
		$passkey = md5(uniqid(rand()));
		$update = $this->usermodel->updateuserpsskey($user_email,$passkey);
		if($update)
		{
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		
		$this->email->initialize($config);

		$this->email->from('info@seedogive.com', 'Seedogive');
		$this->email->to($user_email);
		
		$this->email->subject('Forgot Password');
		$message="<table>
		<tr>
		<td>Dear ".$UserFirstName.",<br><br></td>
		</tr>
		<tr>
		<td>You requested to reset your password.<br><br></td>
		</tr>
		<tr>
		<td><a href='".base_url()."index.php/user/resetuserpassword/".$passkey."'>Click here</a> to continue to reset your password. If you cannot click the link, paste the link below in your browser.<br><br></td>
		</tr>
		<tr>
		<td>".base_url()."index.php/user/resetuserpassword/".$passkey." <br><br></td>
		</tr>
		<tr>
		<td>Thank You</td>
		</tr>
		</table>";
		$this->email->message($message);
		$this->email->send();
		$data['succ_msg']=1;
		}
		}
		else
		{
		$data['email'] = "Email does not exist";
		}
	}
	$this->load->view('forgotuserpassword',$data);
	}
	
	function resetuserpassword()
	{
	$key = $this->uri->segment('3');
	if(isset($_POST['submit']))
	{
	$password = md5($this->input->post('pass'));
	
	if($password==" ")
	{
	$data['blank'] = "Please, Fill the fields";
	}
	else if($password)
	{
	$query = $this->usermodel->resetuserPassword($key,$password);
	if($query)
	{
	redirect('user/index/successfull');
	exit;
	}
	}
	/*$result = $this->adminmodel->resetPassword($key);
	$id = $result[0]->admin_id;
	*/
	}
	$this->load->view('resetuserpassword',$data);
	}
	
	function checkemailval()
	{
	$email = $this->input->post('emailaddress');
	if(eregi("^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$", $email)) 
	{
	echo "1";
	}
	else
	{
	echo "0";
	}
	}
     
	function checkuseremail()
	{
	$emailaddress = $this->input->post('emailaddress');
	//echo $emailaddress; exit;
	$query = $this->usermodel->Checkemails($emailaddress);
    $userdata = $query['0']->userid;
	if($userdata)
	{
	echo "1";
	}
	}
	
	function broadcasterregistration()
	{
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
	if($this->uri->segment('3')=="empty")
	{
	$data["empty"]="Please fill the mandatory fields";
	}
	if($this->uri->segment('3')=="duplicate")
	{
	$data["duplicate"]="Please fill the mandatory fields";
	}
	if(isset($_POST['submit']))
	{
	$bname = $this->input->post('bname');
	$bemail = $this->input->post('bemail');
	$bdesc = $this->input->post('bdesc');
	$bcontact = $this->input->post('bcontact');
	$baddress = $this->input->post('baddress');
	$bcountry = $this->input->post('bcountry');
	$bstate = $this->input->post('bstate');
	$bcity = $this->input->post('bcity');
	$bzipcode = $this->input->post('bzipcode');
	$activationkey=md5(uniqid(rand()));
	
	//echo $activationkey; exit;
	if($bname=="" || $bemail=="")
	{
	redirect("user/broadcasterregistration/empty");
	exit;
	}
	else if($bname && $bemail)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_name='$bname' and broadcaster_email='$bemail'");
	$result = $query->result();
	
	if(count($result)==0)
	{
	$this->load->library('upload');
	if (!empty($_FILES['userfile']['name']))
	{
	$_FILES['userfile']['type'] = str_replace('\"' , '' , $_FILES['userfile']['type'] );
	$config['upload_path'] = './images/';
	$config['allowed_types'] = 'gif|jpg|png';
	$config['max_size'] = '556000';    
	
	// Initialize config for File 1
	$this->upload->initialize($config);
	
	if ($this->upload->do_upload('userfile'))
	{
	$data = $this->upload->data();
	$blogo = $data['file_name'];
	}
	else
	{
	echo $this->upload->display_errors();
	}
	}
	
	$values = array('broadcaster_name'=>$bname,'broadcaster_email'=>$bemail,'broadcaster_desc'=>$bdesc,'broadcaster_contact'=>$bcontact,'broadcaster_address'=>$baddress,'broadcaster_country'=>$bcountry,'broadcaster_state'=>$bstate,'broadcaster_city'=>$bcity,'broadcaster_logo'=>$blogo,'broadcaster_zipcode'=>$bzipcode,'broadcaster_activationkey'=>$activationkey);
	
	$insert = $this->adminmodel->broadcasterdata($values);
	if($insert)
	{
	$config['mailtype'] = 'html';
	$config['wordwrap'] = TRUE;
	
	$this->email->initialize($config);
	
	$this->email->from($bemail, $bname);
	$this->email->to('suresh.pegadapelli@gmail.com');
	
	$this->email->subject('Broadcaster Registration');
	$message="<table>
	<tr>
	<td>Dear ".$bname.",<br><br></td>
	</tr>
	<tr>
	<td>".$bcontact.",<br><br></td>
	</tr>
	<tr>
	<td>I want to join into the Site.<br><br></td>
	</tr>
	<tr>
	<td>Thank You</td>
	</tr>
	</table>";
	$this->email->message($message);
	$this->email->send();
	redirect("user/broadcasterthankyou");
	exit;
	}
	else
	{
	$errors = "wrong";
	}
	}
	else {
	redirect("user/userregistration/duplicate");
	exit;
	}
	}
	}
	$this->load->view('bcregistration',$data);
	}
	
	function broadcasterthankyou()
	{
	$this->load->view('bcthankyou');
	}
	
	function bcthankyou()
	{
	$this->load->view('bcthankyou');
	}
	
	function causeregistration()
	{
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
	if($this->uri->segment('3')=="empty")
	{
	$data["empty"]="Please fill the mandatory fields";
	}
	if($this->uri->segment('3')=="duplicate")
	{
	$data["duplicate"]="Please fill the mandatory fields";
	}
	if(isset($_POST['submit']))
	{
	$cname = $this->input->post('cname');
	$cemail = $this->input->post('cemail');
	$cdesc = $this->input->post('cdesc');
	$ccontact = $this->input->post('ccontact');
	$caddress = $this->input->post('caddress');
	$ccountry = $this->input->post('ccountry');
	$cstate = $this->input->post('cstate');
	$ccity = $this->input->post('ccity');
	$czipcode = $this->input->post('czipcode');
	
	//echo $ccountry;  exit;
	if($cname=="" || $cemail=="")
	{
	redirect("user/causeregistration/empty");
	exit;
	}
	else if($cname && $cemail)
	{
	$query = $this->db->query("select * from cause_tbl where cause_name='$cname' and cause_email='$cemail'");
	$result = $query->result();
	
	if(count($result)==0)
	{
	$this->load->library('upload');
	if (!empty($_FILES['userfile']['name']))
	{
	$_FILES['userfile']['type'] = str_replace('\"' , '' , $_FILES['userfile']['type'] );
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '256000';    
 
            // Initialize config for File 1
            $this->upload->initialize($config);
 
            if ($this->upload->do_upload('userfile'))
            {
                $data = $this->upload->data();
				$clogo = $data['file_name'];
            }
            else
            {
                echo $this->upload->display_errors();
            }
	}
	
	
	$values = array('cause_name'=>$cname,'cause_email'=>$cemail,'cause_desc'=>$cdesc,'cause_contact'=>$ccontact,'cause_address'=>$caddress,'cause_country'=>$ccountry,'cause_state'=>$cstate,'cause_city'=>$ccity,'cause_logo'=>$clogo,'cause_zipcode'=>$czipcode
	);
	$insert = $this->adminmodel->causedata($values);
	if($insert)
	{
	$config['mailtype'] = 'html';
	$config['wordwrap'] = TRUE;
	
	$this->email->initialize($config);
	
	$this->email->from($cemail, $cname);
	$this->email->to('suresh.pegadapelli@gmail.com');
	
	$this->email->subject('Cause Registration');
	$message="<table>
	<tr>
	<td>Dear ".$cname.",<br><br></td>
	</tr>
	<tr>
	<td>".$ccontact.",<br><br></td>
	</tr>
	<tr>
	<td>I want to join into the Site.<br><br></td>
	</tr>
	<tr>
	<td>Thank You</td>
	</tr>
	</table>";
	$this->email->message($message);
	$this->email->send();
	redirect("user/bcthankyou");
	exit;
	}
	else
	{
	echo "wrost";
	}
	}
	else {
	redirect("user/userregistration/duplicate");
	exit;
	}
	}
	}
	$this->load->view('caregistration',$data);
	}

	function checkbcemail()
	{
	$email = $this->input->post('emailaddress');
	if(eregi("^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$", $email)) 
	{
	echo "1";
	}
	else
	{
	echo "0";
	}
	}
	
	function broadcasteremail()
	{
	$emailaddress = $this->input->post('emailaddress');
	//echo $emailaddress; exit;
	$query = $this->usermodel->CheckBCemail($emailaddress);
	//print_r($query); exit;
	$userdata=element(0,$query);
	//echo $userdata->user_id;exit;
	if($userdata->broadcaster_id)
	{
	echo "1";
	}
	}
	
	function selectuserstate()
	{
	$country_code = $this->input->post("country_code");
	$query = $this->usermodel->selectuserState($country_code);
	$message.="<select name='state'>";
	foreach($query as $vals) {
	$message.="<option value='$vals->stateid'>".$vals->state_name."</option>";
	}
	$message.="</select>";
	echo $message;
	}

    function facebooklogins()
	{
	$this->load->view('facebooklogin');
	}
	
	function logout()
	{
	 /*$this->session->unset_userdata('useremail');
	 $this->session->unset_userdata('uid');
     $this->session->unset_userdata['me'];
	 redirect(base_url()."index.php/user");*/
	 
	if($this->session->userdata('useremail'))
	{
	//echo "suresh"; exit;
	  $this->session->unset_userdata('useremail');
	  redirect(base_url()."index.php/user");
	}
	else if($this->session->userdata('uid'))
	{
	echo "suresh"; exit;
	$this->session->unset_userdata('uid');
	$me = $this->session->unset_userdata['me'];
	print_r($me); exit;
	redirect(base_url()."index.php/user");
	}
		else{$this->session->unset_userdata('session_id');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('useremail');
		$this->session->unset_userdata('user_logged_in');
		redirect(base_url()."index.php/user");}
	}
	
}
	?>