<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends CI_Controller {

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
		$this->load->model('Bookingmodel');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('form');
		//$this->load->library('session');
		$this->load->library('email');
		$this->load->helper('array');
		error_reporting(E_PARSE);
	}
	 
	public function index()
	{
	    $data['names'] = $this->Bookingmodel->showplaces();
		$this->load->view('home',$data);
	}
	
	public function checkplaces()
	{
	$id = $this->input->post('id');
	$values  = $this->Bookingmodel->showplace($id);
			/*foreach ($data as $vals)
			{
			echo $vals->state_name; 
			}
			exit;*/
    $select = "<select name='placename1' id='placename1' class='input_filed' style='width:51%'>";
	foreach ($values as $vals)
	{
	//echo $vals->state_name;
	$select .= "<option value='$vals->place_id'>".$vals->place_name."</option>";	
	}
	$select .= "</select>";
	echo $select;
	}
}	