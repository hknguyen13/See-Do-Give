<?php
class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Facebook_model');
	}
	
	function index()
	{
		$fb_data = $this->session->userdata('fb_data');
		$data = array(
					'fb_data' => $fb_data,
					);
		
		$this->load->view('welcome', $data);
	}
	
	function topsecret()
	{
		$fb_data = $this->session->userdata('fb_data');
		
		if((!$fb_data['uid']) or (!$fb_data['me']))
		{
			redirect('welcome');
		}
		else
		{
			$data = array(
						'fb_data' => $fb_data,
						);
			
			$this->load->view('topsecret', $data);
		}
	}
	
	function hello()
	{
	$fb_data = $this->session->userdata('fb_data');
    if($fb_data)
	{
	$data = array(
	'fb_data' => $fb_data,
	);
	$this->load->view('hello',$data);
	}
	}
	
	function logout()
	{
	  $this->session->unset_userdata('fb_data');
	  redirect(base_url()."index.php/user");
	}
}
?>