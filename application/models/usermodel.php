<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

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
	/*public function index()
	{
		$this->load->view('welcome_message');
	}*/
	function insertdata($values)
	{
	$query = $this->db->insert('user_tbl', $values);
	//print_r($query); exit; 
	return $query;
	}
	
	function getuserdata($email,$password)
	{
	$query = $this->db->query("select * from user_tbl where useremail='$email' and userpassword='$password'");
	return $query->result();
	}
	
	function reviewinsertdata($userId,$seeds,$causename,$broadcasterid,$broadcastervideoid)
	{
	$date = date('Y-m-d h:i:s');
	$query = $this->db->query("select * from seedconfirgation where sc_broadcasterid='$broadcasterid' and status='0'");
	$result = $query->result();
	$bcseed = $result['0']->seeds;
	$bcamount = $result['0']->dollars;
	$this->db->set('datareport_causeid', $causename);
	$this->db->set('datareport_broadcasterid', $broadcasterid);
	$this->db->set('bcvideo_id', $broadcastervideoid);
	$this->db->set('seeds', $seeds);
	$this->db->set('amount', $bcamount);
	$this->db->set('datareport_userid', $userId);
	$this->db->set('datareport_date', $date); 
	$this->db->insert('sitevisiterdata');
	echo "1";exit;
	}
	
	function forgotUserpassword($user_email)
	{
	$query = $this->db->query("select * from user_tbl where useremail='$user_email'");
	return $query->result();
	}
	
	function updateuserpsskey($user_email,$passkey)
	{
	$query = $this->db->query("update user_tbl set userforgotpasskey='$passkey' where useremail='$user_email'");
	return $query;
	}
	
	function resetuserPassword($key,$password)
	{
	$query = $this->db->query("update user_tbl set userpassword='$password' where userforgotpasskey='$key'");
	return $query;
	}
	
	function showvideos($location)
	{
	$query = $this->db->query("select * from broadcastervideo where bc_videolocation='$location'");
	return $query->result();
	}
	
	function showVideo($videoid)
	{
	$userid = $this->session->userdata('userid');
	$query = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$videoid'");
	$query1 = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$videoid'");
	$result = $query1->result();
	$video_id = $result['0']->bc_videoid;
	$date = date('Y-m-d');
	$insertvidecount = $this->db->query("INSERT INTO user_watch_videos (user_id,video_id,broadcasterid,watch_date) VALUES ('$userid','$video_id','$videoid','$date')");
	//print_r($query->result()); exit;
	return $query->row_array();
	}
	
	function Checkemails($emailaddress)
	{
	$query = $this->db->query("select * from user_tbl where useremail='$emailaddress'");
	return $query->result();
	}
	
	function getuser($key)
	{
	//echo "select * from user_tbl where useractivationkey='$key'"; exit;
	$query = $this->db->query("select * from user_tbl where useractivationkey='$key'");
	return $query->result();
	}
	
	function updateuser($key)
	{
	//echo "update user_tbl set userstatus=1 where useractivationkey='$key'"; exit;
	$query = $this->db->query("update user_tbl set userstatus=1 where useractivationkey='$key'");
	return $query;
	}
	
	function CheckBCemail($emailaddress)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_email='$emailaddress'");
	return $query->result();
	}
	
	
	function selectuserState($country_code)
	{
	$query = $this->db->query("select * from user_state where country_code='$country_code'");
	return $query->result();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */