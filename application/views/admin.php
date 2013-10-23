<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
	$this->load->library('form_validation');
	$this->load->helper('url');
	$this->load->helper('form');
	$this->load->library('session');
	$this->load->library('email');
	$this->load->helper('array');
	error_reporting(E_PARSE);
}

public function index()
{
	if($this->uri->segment(3)=="success")
	{
	$data['success'] = "Password is Reset Successfully";
	}
	if(isset($_POST['submit']))
	{
	$username = $this->input->post('username');
	$password = md5($this->input->post('password'));
	$value = $this->adminmodel->getadmindata($username,$password);
	if(!empty($value))
	{
	$status = $value['0']->admin_status;
	if($status==1)
	{
	$admininfo = array(
	'adminid'  => $value['0']->admin_id,
	'adminname'=>$value['0']->admin_username,
	'email'=>$value['0']->admin_email,
	'admin_type' => $value['0']->admin_type,
	'admin_logged_in' => TRUE
	);
	$this->session->set_userdata($admininfo);
	
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	$type = $values['0']->admin_type;
	$bc_id = $values['0']->broadcaster_id;
	$c_id = $values['0']->cause_id;
	
	if($type=="super")
	{
	redirect("admin/viewuser");
	exit;
	}
	else if($type==$bc_id)
	{
	redirect("admin/viewbroadcaster");
	exit;
	}
	else if($type==$c_id)
	{
	redirect("admin/viewcause");
	exit;
	}
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
	$this->load->view('adminlogin',$data);
}

function forgotpassword()
{
	if(isset($_POST['submit']))
	{
	$user_email = $this->input->post('email');
	
	$query = $this->adminmodel->forgotPassword($user_email);
	$useremail = $query[0]->admin_email;
	if(!empty($query))
	{
	$passkey = md5(uniqid(rand()));
	$this->adminmodel->updatepsskey($user_email,$passkey);  
	redirect("admin/resetpassword/$passkey");
	exit;
	}
	else
	{
	$data['email'] = "Email does not exist";
	}
	}
	$this->load->view('forgotpassword',$data);
}
	
function resetpassword()
{
	$key = $this->uri->segment('3');
	if(isset($_POST['submit']))
	{
	$password = $this->input->post('pass');
	
	if($password==" ")
	{
	$data['blank'] = "Please, Fill the fields";
	}
	else if($password)
	{
	$query = $this->adminmodel->resetPassword($key,$password);
	if($query)
	{
	redirect('admin/index/success');
	exit;
	}
	}
	/*$result = $this->adminmodel->resetPassword($key);
	$id = $result[0]->admin_id;
	*/
	}
	$this->load->view('resetpassword',$data);
}

function manageseeds()
{
	if($this->uri->segment(3)=="success")
	{
	$data['success'] = "Upadted Successfully";
	}
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['broadcaster'] = $this->adminmodel->getbcaster();
	
	if(isset($_POST['submit']))
	{
	$broadcasterid = $this->input->post('bsa_broadcasterid');
	$seeds = $this->input->post('seeds');
	$dollars = $this->input->post('dollars');
	$depositdate = date("Y-m-d",strtotime($this->input->post('dates')));
	
	$values = array('sc_broadcasterid'=>$broadcasterid,'seeds'=>$seeds,'dollars'=>$dollars,
	'createddate'=>$depositdate);
		
	$query = $this->adminmodel->manageSeed($values);
	
	if($query)
	{
	redirect('admin/manageseeds/success');
	exit;
	}
	}
	$this->load->view('manageseeds',$data);
	}
	else
	{
	redirect('admin');
	exit;
	}
}

function editseed()
{
    if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	$bc_id = $this->uri->segment('3');
	$data['seeds'] = $this->adminmodel->getseeds($bc_id);
	$data['broadcaster'] = $this->adminmodel->getbcaster();
	
	if(isset($_POST['submit']))
	{
	$broadcasterid = $this->input->post('bsa_broadcasterid');
	$seeds = $this->input->post('seeds');
	$dollars = $this->input->post('dollars');
	$modifydate = date("Y-m-d",strtotime($this->input->post('dates')));
	
	$values = array('sc_broadcasterid'=>$broadcasterid,'seeds'=>$seeds,'dollars'=>$dollars,'modifydate'=>$modifydate
	);
	
	$update = $this->adminmodel->editseed($values,$bc_id);
	if($update)
	{
	redirect("admin/viewbroadcaster");
	}
	}
	$this->load->view('editseed',$data);
	}
	else
	{
	redirect("admin");
	exit;
	}
}

function viewuser()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	if($this->uri->segment(3)=="success")
	{
	$data['success'] = "Upadted Successfully";
	}
	if($this->uri->segment(3)=="delsuccess")
	{
	$data['success'] = "Deleted Successfully";
	}
	$data['names'] = $this->adminmodel->showuser();
	
	$this->load->view('viewuser',$data);
	}
	else
	{
	redirect('admin');
	exit;
	}
}
	
function edituser()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$id = $this->uri->segment('3');
	$data['names'] = $this->adminmodel->showusers($id);
	//print_r($data['names']); exit;
	if(isset($_POST['submit']))
	{
	$uname = $this->input->post('uname');
	$uemail = $this->input->post('uemail');
	$udob = $this->input->post('udob');
	$uphone = $this->input->post('uphone');
	$ulocation = $this->input->post('ulocation');
	$ustatus = $this->input->post('ustatus');
	$ugender = $this->input->post('ugender');
	
	$values = array('username'=>$uname,'useremail'=>$uemail,'userdob'=>$udob,'userphone'=>$uphone,'usergender'=>$ugender,'userlocation'=>$ulocation);
	
	$query = $this->adminmodel->updateuser($values,$id);
	//print_r($query); exit;
	if($query)
	{
	redirect("admin/viewuser/success");
	exit;
	}
	}
	$this->load->view('edituser',$data);
	}
	else
	{
	redirect('admin');
	exit;
	}
}
	
function checkuname()
{
	$name = $this->input->post('uName');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->CheckuName($name,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->userid)
	{
	echo "1";
	}
}
	
function CheckuEmail()
{
	$email = $this->input->post('emailaddress');
	$userid = $this->input->post('user_id');
	//echo $email; exit;
	$query = $this->adminmodel->CheckuEmail($email,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->userid)
	{
	echo "1";
	}
}
	
function deleteuser()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$id=(int)$this->uri->segment(3);
	$data = $this->adminmodel->showusers($id);
	//print_r($data); exit;
	$flag = $data[0]->userstatus;
	if($flag==0)
	{
	$query = $this->db->query("update user_tbl set userstatus=1 where userid = '$id'");
	redirect('admin/viewuser/delsuccess');
	exit;
	}
	else if($flag==1)
	{
	redirect('admin/viewuser');
	exit;
	}
	}
	else {
	redirect('admin');
	exit;
	}
}

function managepages()
{
	$this->load->view('admin_pages');
}	

function getpage()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	if($this->uri->segment(3)=="addsuccess")
	{
	$data['success'] = "Add Successfully";
	}
	if($this->uri->segment(3)=="success")
	{
	$data['success'] = "Upadted Successfully";
	}
	if($this->uri->segment(3)=="delsuccess")
	{
	$data['success'] = "Deleted Successfully";
	}
	if($this->input->post("Pageid"))
	$page['pageId']=$this->input->post("Pageid");
	
	if($this->uri->segment(3)!='new')
	$data['pageItems']=$this->adminmodel->adminPages($page);
	
	if($this->input->post("Pageid")){
	$this->load->view('page_view',$data);
	}
	elseif($this->uri->segment(3)=='new'){
	$this->load->view('admin_pages', $data);
	}
	else{
	$this->load->view('admin_manage_pages',$data);
	}
	}
	else {
	redirect('admin');
	}
}

function editpage()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$page = $this->uri->segment(3);
	$data['pageItems'] = $this->adminmodel->editPages($page);
	//print_r($data['pageItems']); exit;
	//$data['Editpage']=element(0,$data['pageItems']);
	
	if(isset($_POST['submit']))
	{
	$pagetitle = $this->input->post("pagetitle");
	$pagename = $this->input->post("pagename");
	$elm1 = $this->input->post("elm1");
	$metatitle = $this->input->post("metatitle");
	
	$query = $this->db->query("update adminpages,pagecontent set adminpages.PageTitle='$pagetitle',adminpages.PageName='$pagename',adminpages.PageMetaTitle='$metatitle',pagecontent.PageContent='$elm1' where adminpages.PageId='$page' and pagecontent.PageContentPageId='$page'");
	if($query)
	{
	redirect("admin/getpage/success");
	exit;
	}
}

$this->load->view('admin_edit_pages',$data);
}
else{
redirect('admin'); exit;
}
}

function delpage()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$id = $this->uri->segment(3);
	$query = $this->adminmodel->DelPage($id);
	if($query)
	{
	redirect("admin/getpage/delsuccess");
	exit;
	}
	}
	else
	{
	redirect('admin');
	exit;
	}
}
	
function viewbroadcaster()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	$bc_id = $data['bc_id'];
	//$this->adminmodel->sessionss();
	if($this->uri->segment(3)=="addsuccess")
	{
	$data['success'] = "Add Successfully";
	}
	if($this->uri->segment(3)=="success")
	{
	$data['success'] = "Upadted Successfully";
	}
	if($this->uri->segment(3)=="delsuccess")
	{
	$data['success'] = "Deleted Successfully";
	}
	if($data['type']=="super")
	{
	$data['broadcaster'] = $this->adminmodel->showbcaster();
	}
	else if($data['type']==$bc_id)
	{
	$data['broadcaster'] = $this->adminmodel->showbroadcaster($bc_id);
	}
	//print_r($data['broadcaster']); exit;
	$this->load->view('viewbroadcaster',$data);
	}
	else 
	{
	redirect('admin');
	exit;
	}
}
	
function addbroadcaster()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
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
	/*$bstartdate = date("Y-m-d",strtotime($this->input->post('bstartdate')));
	$benddate = date("Y-m-d",strtotime($this->input->post('benddate')));*/
	$activationkey=md5(uniqid(rand()));
	
	//echo $activationkey; exit;
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
	//$id = $this->db->insert_id();
	
	if($insert)
	{
	redirect("admin/broadcasterdeposit/$activationkey");
	exit;
	}
	else
	{
	$errors = "wrong";
	}
	}
	$this->load->view('addbroadcaster',$data);
	}
	else
	{
	redirect('admin');
	exit;
	}
}

function checkbemail()
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
	
function checkcname()
{
	$bname = $this->input->post('bName');
	//echo $bname; exit;
	$query = $this->adminmodel->CheckcName($bname);
	$userdata=element(0,$query);
	//echo $userdata->user_id;exit;
	if($userdata->broadcaster_id)
	{
	echo "1";
	}
}

function checkadminname()
{
	$Username = $this->input->post('Username');
	//echo $Username; exit;
	$query = $this->adminmodel->Checkadminname($Username);
	//print_r($query); exit;
	$userdata=element(0,$query);
	//echo $userdata->admin_id;exit;
	if($userdata->admin_id)
	{
	echo "1";
	}
}

function checkemailaddress()
{
	$emailaddress = $this->input->post('emailaddress');
	//echo $emailaddress; exit;
	$query = $this->adminmodel->Checkemail($emailaddress);
	$userdata=element(0,$query);
	//echo $userdata->user_id;exit;
	if($userdata->broadcaster_id)
	{
	echo "1";
	}
}

function broadcasterdeposit()
{
    if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	$activationkey = $this->uri->segment('3');
	$values = $this->adminmodel->actvationkey($activationkey);
	$broadcaster_id = $values[0]->broadcaster_id;
	$data['broadcaster_id'] = $broadcaster_id;
	
	if(isset($_POST['submit']))
	{
	$broadcasterid = $this->input->post('bsa_broadcasterid');
	$amount = $this->input->post('amount');
	$seeds = $this->input->post('seeds');
	$dollars = $this->input->post('dollars');
	$despositdate = date("Y-m-d",strtotime($this->input->post('despositdate')));
	
	$values = array('bsa_broadcasterid'=>$broadcasterid,'bsa_totalamount'=>$amount,'bsa_seedvalue'=>$seeds,'bsa_dollarvalue'=>$dollars,'bsa_depositdate'=>$despositdate
	);
	
	$insert = $this->adminmodel->addamount($values);
	if($insert)
	{
	redirect("admin/viewbroadcaster");
	exit;
	}
	}
	$this->load->view('addbroadcasteramount',$data);
	}
	else
	{
	redirect("admin");
	exit;
	}
}

function editbroadcaster()
	{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
	$Id = $this->uri->segment(3);
	$data['broadcaster'] = $this->adminmodel->getbroadcaster($Id);
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
	$blogo = $this->input->post('blogo');
	$bzipcode = $this->input->post('bzipcode');
	
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
				$blogo = $data['file_name'];
            }
            else
            {
                echo $this->upload->display_errors();
            }
	}
	
	$values = array('broadcaster_name'=>$bname,'broadcaster_email'=>$bemail,'broadcaster_desc'=>$bdesc,'broadcaster_contact'=>$bcontact,'broadcaster_address'=>$baddress,'broadcaster_country'=>$bcountry,'broadcaster_state'=>$bstate,'broadcaster_city'=>$bcity,'broadcaster_logo'=>$blogo,'broadcaster_zipcode'=>$bzipcode
	);
	$update = $this->adminmodel->editbroadcasterdata($values,$Id);
	if($update)
	{
	redirect("admin/editbcdeposit/$Id");
	exit;
	}
	else
	{
	echo "wrost";
	}
	}
	$this->load->view('editbroadcaster',$data);
	}
	else {
	redirect('admin'); exit;
	}
}

function editbcdeposit()
{
    if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	$Id = $this->uri->segment('3');
	$data['amount'] = $this->adminmodel->getbcdeposit($Id);
	$query = $this->db->query("select * from seedconfirgation where sc_broadcasterid='$Id'");
	$result = $query->result();
	$data['seeds'] = $result['0']->seeds;
	//print_r($data['amount']); exit;
	/*if(isset($_POST['submit']))
	{
	$broadcasterid = $this->input->post('bsa_broadcasterid');
	$amount = $this->input->post('amount');
	$seeds = $this->input->post('seeds');
	$dollars = $this->input->post('dollars');
	$despositdate = date("Y-m-d",strtotime($this->input->post('dates')));
	
	$values = array('bsa_broadcasterid'=>$broadcasterid,'bsa_totalamount'=>$amount,'bsa_seedvalue'=>$seeds,'bsa_dollarvalue'=>$dollars,'bsa_depositdate'=>$despositdate
	);
	
	$insert = $this->adminmodel->addamount($values);
	if($insert)
	{
	redirect("admin/viewbroadcaster");
	exit;
	}
	}*/
	$this->load->view('editbcdeposit',$data);
	}
	else
	{
	redirect("admin");
	exit;
	}
}
	
function deletebroadcaster()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$Id=(int)$this->uri->segment(3);
	$data = $this->adminmodel->getbroadcaster($Id);
	$flag = $data[0]->broadcaster_status;
	if($flag==0)
	{
	$query = $this->db->query("update broadcaster_tbl set broadcaster_status=1 where broadcaster_id = '$Id'");
	redirect('admin/viewbroadcaster/delsuccess');
	exit;
	}
	else if($flag==1)
	{
	redirect('admin/viewbroadcaster');
	exit;
	}
	}
	else {
	redirect('admin');
	exit;
	}
}

function showvideo()
	{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['videosname'] = $this->adminmodel->showvideos();
	$this->load->view('showvideos',$data);
	}
	else{
	redirect('admin');
		exit;
	}
	}
	
function addvideos()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['bnames'] = $this->adminmodel->showbroadcaster();
	$data['country'] = $this->adminmodel->getcountry();
	if(isset($_POST['submit']))
	{
	$bvname = $this->input->post("bvname");
	$bstartdate = date("Y-m-d",strtotime($this->input->post('date')));
	$benddate = date("Y-m-d",strtotime($this->input->post('dates')));
	$bcountry = $this->input->post("bcountry");
	
	//print_r(phpinfo()); exit;
	$this->load->library('upload');
	if (!empty($_FILES['userfile']['name']))
	{
	$_FILES['userfile']['type'] = str_replace('\"' , '' , $_FILES['userfile']['type'] );
	
	$config['upload_path'] = './video/';
	$config['allowed_types'] = 'flv|jpg|png|jpeg';
	$config['max_size'] = '9087654321';    
	
	// Initialize config for File 1
	$this->upload->initialize($config);
	
	if ($this->upload->do_upload('userfile'))
	{
	$data = $this->upload->data();
	//$thumb = $this->_createThumbnail($data['file_name']);
	$blogo = $data['file_name'];
	}
	else
	{
	echo $this->upload->display_errors();
	}
	}
	//echo $blogo; exit;
	$values = array('bcbroadcaster_id'=>$bvname,'bc_videostartdate'=>$bstartdate,'bc_videoenddate'=>$benddate,'bc_videolocation'=>$bcountry,'bc_videopath'=>$blogo);
	
	$query = $this->adminmodel->insertvideos($values);
	$id = $this->db->insert_id();
	if($query)
	{
	redirect("admin/showvideo");
	exit;
	}
	else
	{
	echo "waste";
	}
	}
	$this->load->view('addvideo',$data);
	}
	else {
	redirect('admin');
	exit;
	}
}
	
function editvideos()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['bnames'] = $this->adminmodel->showbroadcaster();
	$data['country'] = $this->adminmodel->getcountry();
	$id = $this->uri->segment('3');
	$data['videosname'] = $this->adminmodel->getvideos($id);
	if(isset($_POST['submit']))
	{
	$bvname = $this->input->post("bvname");
	$bstartdate = date("Y-m-d",strtotime($this->input->post('date')));
	$benddate = date("Y-m-d",strtotime($this->input->post('dates')));
	$bcountry = $this->input->post("bcountry");
	$bvideo = $this->input->post("videopath");
	
	$this->load->library('upload');
	if(isset($_FILES['userfile']) && !empty($_FILES['userfile']))
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
	$bvideo = $data['file_name'];
	}
	else
	{
	echo $this->upload->display_errors();
	}
	}
	$values = array('broadcaster_id'=>$bvname,'videostartdate'=>$bstartdate,'videoenddate'=>$benddate,'bvideo_location'=>$bcountry,'videopath'=>$bvideo);
	
	$query = $this->adminmodel->editVideos($values,$id);
	if($query)
	{
	redirect("admin/showvideos");
	exit;
	}
	else
	{
	echo "waste";
	}
	}
	$this->load->view('editvideo',$data);
	}
	else{
	redirect('admin');
	exit;
	}
}

function viewcause()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	$data['c_id'] = $values['0']->cause_id;
	
	//echo $data['c_id']; exit;
	$c_id = $data['c_id'];
	if($this->uri->segment(3)=="addsuccess")
	{
	$data['success'] = "Add Successfully";
	}
	if($this->uri->segment(3)=="success")
	{
	$data['success'] = "Upadted Successfully";
	}
	if($this->uri->segment(3)=="delsuccess")
	{
	$data['success'] = "Deleted Successfully";
	}
	if($data['type']=="super")
	{
	$data['cause'] = $this->adminmodel->showcauses();
	//print_r($data['cause']); exit;
	}
	else if($data['type']==$c_id)
	{
	$data['cause'] = $this->adminmodel->showcause($c_id);
	//print_r($data['cause']); exit;
	}
	//$data['causes'] = $this->adminmodel->showcauses();
	//print_r($data['broadcaster']); exit;
	$this->load->view('viewcauses',$data);
	}
	else {
	redirect('admin');
	exit;
	}
}	

function addcause()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
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
	$id = $this->db->insert_id();
	if($insert)
	{
	redirect("admin/viewcause/addsuccess");
	exit;
	}
	else
	{
	echo "wrost";
	}
	}
	$this->load->view('addcauses',$data);
	}
	else
	{
	redirect('admin');
	}
}
	
function checkcausename()
{
	$cname = $this->input->post('cName');
	//echo $bname; exit;
	$query = $this->adminmodel->CheckcauseName($cname);
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->cause_id)
	{
	echo "1";
	}
}
	
function checkcauseemail()
{
	$emailaddress = $this->input->post('emailaddress');
	//echo $emailaddress; exit;
	$query = $this->adminmodel->CheckcauseEmail($emailaddress);
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->cause_id)
	{
	echo "1";
	}
}
	
function editcause()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['country'] = $this->adminmodel->getcountry();
	$data['states'] = $this->adminmodel->getstate();
	$Id = $this->uri->segment(3);
	$data['causes'] = $this->adminmodel->getcauses($Id);
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
	$clogo = $this->input->post('clogo');
	$czipcode = $this->input->post('czipcode');
	
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
	$values = array('cause_name'=>$cname,'cause_email'=>$cemail,'cause_desc'=>$cdesc,'cause_contact'=>$ccontact,'cause_address'=>$caddress,'cause_country'=>$ccountry,'cause_state'=>$cstate,'cause_city'=>$ccity,'cause_zipcode'=>$czipcode,'cause_logo'=>$clogo
	);
	$update = $this->adminmodel->editcausedata($values,$Id);
	if($update)
	{
	redirect("admin/viewcause/success");
	}
	else
	{
	echo "wrost";
	}
	}
	$this->load->view('editcauses',$data);
	}
	else{
	redirect('admin'); exit;
	}
}
	
function deletecause()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$Id=(int)$this->uri->segment(3);
	$data = $this->adminmodel->getcauses($Id);
	$flag = $data[0]->cause_status;
	if($flag==0)
	{
	$query = $this->db->query("update cause_tbl set cause_status=1 where cause_id = '$Id'");
	redirect('admin/viewcause/delsuccess');
	exit;
	}
	else if($flag==1)
	{
	redirect('admin/viewcause');
	exit;
	}
	}
	else{
	redirect('admin'); exit;
	}
}

function viewadminstaff()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	if($this->uri->segment(3)=="delsuccess")
	{
	$data['success'] = "Deleted Successfully";
	}
	$data['names'] = $this->adminmodel->viewAdmin();
	//print_r($data['names']); exit;
	$this->load->view('viewadmin',$data);
	}
	else
	{
	redirect("admin");
	exit;
	}
}

function adminstaffregister()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['broadcaster'] = $this->adminmodel->showbroadcaster();
	$data['causes'] = $this->adminmodel->showcauses();
	if(isset($_POST['submit']))
	{
	$username = $this->input->post('username');
	$password = md5($this->input->post('password'));
	$firstname = $this->input->post('firstname');
	$lastname = $this->input->post('lastname');
	$email = $this->input->post('email');
	$contact = $this->input->post('contact');
	$type = $this->input->post('adminbtype');
	$date = date("Y-m-d",strtotime($this->input->post('date')));
	
	//$insert = $this->db->query("insert into admin_tbl (admin_username,) values ()");
	
	$values = array('admin_username'=>$username,'admin_password'=>$password,'admin_email'=>$email,'admin_contact'=>$contact,'admin_createdon'=>$date,'admin_firstname'=>$firstname,'admin_lastname'=>$lastname,'admin_type'=>$type,'admin_status'=>1
	);
	$insert = $this->adminmodel->insertdata($values);
	if($insert)
	{
	redirect("admin/viewadminstaff");
	exit;
	}
	else{
	$data['error'] = "Not Inserted Properly";
	}
	}
	$this->load->view('adminregister',$data);
	}
	else {
	redirect("admin");
	exit;
	}
}

function editadminstaff()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$id = $this->uri->segment('3');
	$data['names'] = $this->adminmodel->viewadmins($id);
	//print_r($data['names']); exit;
	if(isset($_POST['submit']))
	{
	$username = $this->input->post('username');
	/*$password = $this->input->post('password');*/
	$firstname = $this->input->post('firstname');
	$lastname = $this->input->post('lastname');
	$email = $this->input->post('email');
	$contact = $this->input->post('contact');
	$type = $this->input->post('adminbtype');
	$date = date("Y-m-d",strtotime($this->input->post('date')));
	
	$values = array('admin_username'=>$username,'admin_email'=>$email,'admin_contact'=>$contact,'admin_createdon'=>$date,'admin_firstname'=>$firstname,'admin_lastname'=>$lastname,'admin_type'=>$type
	);
	$editdata = $this->adminmodel->editdata($values,$id);
	//print_r($editdata); exit;
	if($editdata)
	{
	redirect("admin/viewadminstaff");
	exit;
	}
	else{
	$data['error'] = "Not Inserted Properly";
	}
	}
	$this->load->view('editadminstaff',$data);
	}
	else{
	redirect("admin");
	exit;
	}
}

function deleteadmin()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$id=(int)$this->uri->segment(3);
	$data = $this->adminmodel->viewadmins($id);
	//print_r($data); exit;
	$flag = $data[0]->admin_status;
	if($flag==0)
	{
	$query = $this->db->query("update admin_tbl set admin_status=1 where admin_id = '$id'");
	redirect('admin/viewadminstaff/delsuccess');
	exit;
	}
	else if($flag==1)
	{
	redirect('admin/viewadminstaff');
	exit;
	}
	}
	else {
	redirect("admin");
	exit;
	}
}

function managereports()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	
	$data['broadcaster'] = $this->adminmodel->showbroadcaster($data['bc_id']);
	
	$data['causes'] = $this->adminmodel->showcauses();
	$data['names'] = $this->adminmodel->showusers();
	if(isset($_POST['submit']))
	{
	$bname = $this->input->post("bname");
	$bfromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
	$btodate = date("Y-m-d",strtotime($this->input->post('todate')));
	
	$bname1 = $this->adminmodel->showbc($bname);
	$brname = $bname1['0']->broadcaster_name;
	if($bfromdate > $btodate)
	{
	$data['dates'] = "From date should be less than To date";
	$this->load->view('managereport',$data);
	}
	else {
	if($bname)
	{
	$query = $this->adminmodel->breport($bname,$bfromdate,$btodate);
	
	//$result = $query->result();
	//$cause = $result['0']->uname;
	$name = $brname.'_'.date("Ymd").".csv";
	$this->load->helper('csv');
	//echo query_to_csv($query);
	
	query_to_csv($query, TRUE, $name);
	//exit;	
	}
	}
	}
	else if(isset($_POST['display']))
	{
	$bname = $this->input->post("bname");
	$bfromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
	$btodate = date("Y-m-d",strtotime($this->input->post('todate')));
	
	$bname1 = $this->adminmodel->showbc($bname);
	$brname = $bname1['0']->bname;
	if($bfromdate > $btodate)
	{
	$data['dates'] = "From date should be less than To date";
	$this->load->view('managereport',$data);
	}
	else {
	if($bname)
	{
	$query = $this->adminmodel->breport($bname,$bfromdate,$btodate);
	//$this->load->helper('csv');
	//echo query_to_csv($query, TRUE, $name)."<br/>";
	$data['report'] = $query->result();
	$this->load->view('generatebreport',$data);
	}
	}
	}
	else
	{
	$this->load->view('managereport',$data);
	}
	}
	else{
	redirect('admin'); exit;
	}
}

function managecausereports()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	//$data['bc_id'] = $values['0']->broadcaster_id;
	$data['c_id'] = $values['0']->cause_id;
	
	$data['broadcaster'] = $this->adminmodel->showbroadcaster();
	$data['causes'] = $this->adminmodel->showcause($data['c_id']);
	$data['names'] = $this->adminmodel->showusers();
	if(isset($_POST['submit']))
	{
	$cname = $this->input->post("cname");
	$cfromdate = date("Y-m-d",strtotime($this->input->post('cfromdate')));
	$ctodate = date("Y-m-d",strtotime($this->input->post('ctodate')));
	
	$cname1 = $this->adminmodel->showcn($cname);
	$crname = $cname1['0']->cause_name;
	if($cfromdate > $ctodate)
	{
	$data['dates'] = "From date should be less than To date";
	$this->load->view('managecausereport',$data);
	}
	else {
	if($cname)
	{
	$query = $this->adminmodel->creport($cname,$cfromdate,$ctodate);
	
	//$result = $query->result();
	//$cause = $result['0']->uname;
	$name = $crname.'_'.date("Ymd").".csv";
	$this->load->helper('csv');
	//echo query_to_csv($query);
	
	query_to_csv($query, TRUE, $name);
	//exit;	
	}
	}
	}
	else if(isset($_POST['display']))
	{
	$cname = $this->input->post("cname");
	$cfromdate = date("Y-m-d",strtotime($this->input->post('cfromdate')));
	$ctodate = date("Y-m-d",strtotime($this->input->post('ctodate')));
	
	$cname1 = $this->adminmodel->showcn($cname);
	$crname = $cname1['0']->cause_name;
	if($cfromdate > $ctodate)
	{
	$data['dates'] = "From date should be less than To date";
	$this->load->view('managecausereport',$data);
	}
	else {
	if($cname)
	{
	$query = $this->adminmodel->creport($cname,$cfromdate,$ctodate);
	$data['report'] = $query->result();
	$this->load->view('generatecreport',$data);
	}
	}
	}
	else
	{
	$this->load->view('managecausereport',$data);
	}
	}
	else{
	redirect('admin'); exit;
	}
}

function manageuserreports()
{
	if($this->session->userdata['email'])
	{
	$admin_type = $this->session->userdata['admin_type'];
	$values = $this->adminmodel->admintype($admin_type);
	
	$data['type'] = $values['0']->admin_type;
	$data['bc_id'] = $values['0']->broadcaster_id;
	if(isset($_POST['submit']))
	{
	$uname = $this->input->post("username");
	if($uname)
	{
	$query = $this->adminmodel->activeuser();
	$name = "users".'_'.date("Ymd").".csv";
	$this->load->helper('csv');
	query_to_csv($query, TRUE, $name);
	}
	}
	else if(isset($_POST['display']))
	{
	$uname = $this->input->post("username");
	if($uname)
	{
	$query = $this->adminmodel->activeuser();
	$data['report'] = $query->result();
	$this->load->view('generateureport',$data);
	}
	}
	else
	{
	$this->load->view('manageuserreport',$data);
	}
	}
	else{
	redirect('admin'); exit;
	}
}

    function checkebname()
	{
	$name = $this->input->post('bName');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->CheckeditbName($name,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->broadcaster_id)
	{
	echo "1";
	}
	}
	
	function checkeditemail()
	{
	$email = $this->input->post('emailaddress');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->Checkeditbemail($email,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->broadcaster_id)
	{
	echo "1";
	}
	}
	
	function checkeebname()
	{
	$name = $this->input->post('bName');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->CheckeditbName($name,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->cause_id)
	{
	echo "1";
	}
	}
	
	function checkeditcausename()
	{
	$name = $this->input->post('cName');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->CheckeditcName($name,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->cause_id)
	{
	echo "1";
	}
	}
	
	function checkeditcauseemail()
	{
	$email = $this->input->post('emailaddress');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->Checkeditcemail($email,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->cause_id)
	{
	echo "1";
	}
	}
	
	function checkaemail()
	{
	$email = $this->input->post('Email');
	$query = $this->adminmodel->CheckAemail($email);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->admin_id)
	{
	echo "1";
	}
	}
	
	function checkademail()
	{
	$email = $this->input->post('emailaddress');
	$query = $this->adminmodel->CheckAdemail($email);
	//print_r($query); exit;
	$userdata=element(0,$query);
		
	if($userdata->admin_id)
	{
	echo "1";
	}
	}
	
	function checkempemail()
	{
	$emailaddress = $this->input->post('emailaddress');
	if(!empty($emailaddress))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checknanumber()
	{
	$phone = $this->input->post('Phone');
	if(is_nan($phone))
	{
	echo "0";
	}
	//echo $phone; 
	}
	
	function checkbnanumber()
	{
	$phone = $this->input->post('Phone');
	if(is_nan($phone))
	{
	echo "0";
	}
	//echo $phone; 
	}
	
	function checkbnanum()
	{
	$phone = $this->input->post('Phone');
	if(is_nan($phone))
	{
	echo "0";
	}
	//echo $phone; 
	}
	
	function checkunannum()
	{
	$phone = $this->input->post('Phone');
	if(is_nan($phone))
	{
	echo "0";
	}
	//echo $phone; 
	}
	
	function checknumberlen()
	{
	$phone = $this->input->post('Phone');
	if(strlen($phone)!=10)
	{
	echo "1"; 
	}
	}
	
	function checkunumlen()
	{
	$phone = $this->input->post('Phone');
	if(strlen($phone)!=10)
	{
	echo "1"; 
	}
	}
	
	function checkbnumlen()
	{
	$phone = $this->input->post('Phone');
	if(strlen($phone)!=10)
	{
	echo "1"; 
	}
	}
	
	function checkcauseename()
	{
	$cname = $this->input->post('cName');
	if(!empty($cname))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checkbename()
	{
	$bname = $this->input->post('bName');
	if(!empty($bname))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	/*function checkeebname()
	{
	$bname = $this->input->post('bName');
	if(!empty($bname))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}*/
	
	function checkbeemail()
	{
	$email = $this->input->post('email');
	if(!empty($email))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checkebemail()
	{
	$email = $this->input->post('email');
	if(!empty($email))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checkcauseeemail()
	{
	$email = $this->input->post('emailaddress');
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
	{
	echo "1";
	}
	else
	{
	echo "0";
	}
	}
	
	function checkvaliduemail()
	{
	$email = $this->input->post('emailaddress');
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
	{
	echo "1";
	}
	else
	{
	echo "0";
	}
	}
	
	function checkeuname()
	{
	$uName = $this->input->post('uName');
	if(!empty($uName))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checkeuemail()
	{
	$email = $this->input->post('email');
	if(!empty($email))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checkadminusername()
	{
	$username = $this->input->post('Username');
	if(!empty($username))
	{
	echo "1"; 
	}
	else
	{
	echo "0";
	}
	}
	
	function checkadminemail()
	{
	$email = $this->input->post('emailaddress');
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
	{
	echo "1";
	}
	else
	{
	echo "0";
	}
	}
	
	function checkpass()
	{
	$psw = $this->input->post('psw');
	if(eregi("^[A-Za-z0-9!@#$%^&*()_]{6,16}$", $psw)) 
	{
	echo "1";
	}
	else
	{
	echo "0";
	}
	}
	
	function checkadmname()
	{
	$username = $this->input->post('Username');
	$userid = $this->input->post('user_id');
	//echo $userid; exit;
	$query = $this->adminmodel->Checkeditadmusername($username,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->admin_id)
	{
	echo "1";
	}
	}
	
	function checkadmemail()
	{
	$email = $this->input->post('emailaddress');
	$userid = $this->input->post('user_id');
	//echo $name; exit;
	$query = $this->adminmodel->Checkeditadmemail($email,$userid);
	//print_r($query); exit;
	$userdata=element(0,$query);
		//echo $userdata->user_id;exit;
	if($userdata->admin_id)
	{
	echo "1";
	}
	}	
function logout()
{
	if($this->session->userdata('adminname'))
	{
	$this->session->unset_userdata('adminname');
	redirect(base_url()."index.php/admin");
	}
	else{$this->session->unset_userdata('session_id');
	$this->session->unset_userdata('adminid');
	$this->session->unset_userdata('email');
	$this->session->unset_userdata('admin_logged_in');
	redirect(base_url()."index.php/admin");}
}


}
	?>