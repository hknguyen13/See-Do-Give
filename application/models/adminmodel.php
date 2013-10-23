<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminmodel extends CI_Model {

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
	
	function getadmindata($username,$password)
	{
	$query = $this->db->query("select * from admin_tbl where admin_username='$username' and admin_password='$password'");
	return $query->result();
	}
	
	function viewAdmin()
	{
	$query = $this->db->query("select * from admin_tbl where admin_status=1");
	return $query->result();
	} 
	
	function viewadmins($id)
	{
	$query = $this->db->query("select * from admin_tbl where admin_id='$id'");
	return $query->row_array();
	} 
	
	function editdata($values,$id)
	{
	$this->db->where('admin_id', $id);
	$query = $this->db->update('admin_tbl', $values); 
	return $query;
	}
	
	function insertdata($values)
	{
	$query = $this->db->insert('admin_tbl', $values);
	//print_r($query); exit; 
	return $query;
	}
	
	function admintype($admin_type)
	{
	$query = $this->db->query("select * from admin_tbl left join broadcaster_tbl on admin_tbl.admin_type=broadcaster_tbl.broadcaster_name left join cause_tbl on admin_tbl.admin_type=cause_tbl.cause_name where admin_type='$admin_type'");
	return $query->result();
	}
	
	/*function adminctype($admin_type)
	{
	$query = $this->db->query("select * from admin_tbl left join cause_tbl on admin_tbl.admin_type=caster_tbl.cause_id  where admin_type='$admin_type'");
	return $query->result();
	}*/
	
	function showuser()
	{
	$query = $this->db->query("select * from user_tbl where userstatus='1'");
	return $query->result();
	} 
	
	function activeuser($uname)
	{
	$query = $this->db->query("select userfirstname,useremail,bcvideo_title,cause_name,datareport_date,seeds as clicks from sitevisiterdata left join user_tbl on sitevisiterdata.datareport_userid=user_tbl.userid left join broadcastervideo on sitevisiterdata.bcvideo_id=broadcastervideo.bc_videoid left join cause_tbl on sitevisiterdata.datareport_causeid=cause_tbl.cause_id where sitevisiterdata.datareport_userid='$uname'");

	return $query;
	
	}
	
	function showusers($id)
	{
	$query = $this->db->query("select * from user_tbl where userid='$id'");
	return $query->row_array();
	} 
	
	function updateuser($values,$id)
	{
	$this->db->where('userid', $id);
	$query = $this->db->update('user_tbl', $values); 
	return $query;
	}
	
	function getbcaster()
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_status=0");
	return $query->result();
	}
	
	function manageSeed($values)
	{
	$query = $this->db->insert('seedconfirgation', $values); 
	return $query;
	}
	
	function editamount($id)
	{
	$query = $this->db->query("select * from broadcasterdepositamount where bsa_broadcasterid='$id'");
	return $query->row_array();
	}
	
	function getseeds($id)
	{
	$query = $this->db->query("select * from seedconfirgation where status=0 and sc_broadcasterid='$id'");
	return $query->row_array();
	}
	
	function showbrcaster()
	{
	$query = $this->db->query("select * from broadcaster_tbl left join admin_tbl on broadcaster_tbl.broadcaster_name=admin_tbl.admin_type left join broadcastervideo on broadcaster_tbl.broadcaster_id=broadcastervideo.bcbroadcaster_id left join broadcasterdepositamount on broadcaster_tbl.broadcaster_id=broadcasterdepositamount.bsa_broadcasterid where broadcaster_status=0");
	return $query->result();
	}
	
	/*function xxx()
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_status=0");
	return $query->result();
	}*/
	
	function showbrocaster()
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_status=0");
	return $query->result();
	}
	
	function showbcaster()
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_status=0 and broadcaster_adminid is null");
	return $query->result();
	}
	
	function showbroadcaster($bc_id)
	{
	$query = $this->db->query("select * from broadcaster_tbl left join admin_tbl on broadcaster_tbl.broadcaster_name=admin_tbl.admin_type left join broadcastervideo on broadcaster_tbl.broadcaster_id=broadcastervideo.bcbroadcaster_id left join broadcasterdepositamount on broadcaster_tbl.broadcaster_id=broadcasterdepositamount.bsa_broadcasterid where broadcaster_status=0 and broadcaster_name='$bc_id'");
	return $query->result();
	}
	
	function showcauses()
	{
	$query = $this->db->query("select * from cause_tbl where cause_status=0");
	return $query->result();
	}
	
	function viewcauses()
	{
	$query = $this->db->query("select * from cause_tbl where cause_status=0");
	return $query->result();
	}
	
	function showcause($c_name)
	{
	$query = $this->db->query("select * from cause_tbl where cause_status=0 and cause_name='$c_name'");
	return $query->result();
	}
	
	function getbroadcaster($Id)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_id='$Id'");
	return $query->row_array();
	}
	
	function actvationkey($activationkey)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_activationkey='$activationkey'");
	return $query->result();
	}
	
	function addamount($values)
	{
	$query = $this->db->insert('broadcasterdepositamount', $values); 
	return $query;
	}
	
	function getcauses($Id)
	{
	$query = $this->db->query("select * from cause_tbl where cause_id='$Id'");
	return $query->row_array();
	}
	
	function getcountry()
	{
	$query = $this->db->query("select * from user_country_code");
	return $query->result();
	}
	
	function getstate()
	{
	$query = $this->db->query("select * from user_state ");
	return $query->result();
	}
	
	function broadcasterdata($values)
	{
	$query = $this->db->insert('broadcaster_tbl', $values); 
	return $query;
	}
	
	function CheckuName($name,$user_id)
	{
	$query = $this->db->query("select * from user_tbl where username='$name' and userid!='$user_id'");
	return $query->result();
	//return $query;
	}
	
	function CheckeditbName($name,$user_id)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_name='$name' and broadcaster_id!='$user_id'");
	return $query->result();
	//return $query;
	}
	
function CheckAemail($email)
	{
	$query = $this->db->query("select * from admin_tbl where admin_email='$email' ");
	return $query->result();
	//return $query;
	}
	
	function Checkeditbemail($email,$user_id)
	{
	$query = $this->db->query("select * from broadcaster_tbl where bemail='$email' and broadcaster_id!='$user_id'");
	return $query->result();
	//return $query;
	}
	
	function CheckeditcName($name,$user_id)
	{
	$query = $this->db->query("select * from cause_tbl where cause_name='$name' and cause_id!='$user_id'");
	return $query->result();
	//return $query;
	}
	
	function Checkeditcemail($email,$user_id)
	{
	$query = $this->db->query("select * from cause_tbl where cause_email='$email' and cause_id!='$user_id'");
	return $query->result();
	//return $query;
	}
	
	function CheckuEmail($email,$user_id)
	{
	$query = $this->db->query("select * from user_tbl where useremail='$email' and userid!='$user_id'");
	return $query->result();
	//return $query;
	}
	
	function CheckcName($bname)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_name='$bname'");
	return $query->result();
	//return $query;
	}
	
	function Checkadminname($Username)
	{
	$query = $this->db->query("select * from admin_tbl where admin_username='$Username'");
	return $query->result();
	}
	
	function Checkemail($emailaddress)
	{
	$query = $this->db->query("select * from broadcaster_tbl where bemail='$emailaddress'");
	return $query->result();
	//return $query;
	}
	
	function CheckcauseName($cname)
	{
	$query = $this->db->query("select * from cause_tbl where cause_name='$cname'");
	return $query->result();
	//return $query;
	}
	
	function CheckcauseEmail($emailaddress)
	{
	$query = $this->db->query("select * from cause_tbl where cause_email='$emailaddress'");
	return $query->result();
	//return $query;
	}
	
	function causedata($values)
	{
	$query = $this->db->insert('cause_tbl', $values); 
	return $query;
	}
	
	function editbroadcasterdata($data,$bid)
	{
	$this->db->where('broadcaster_id', $bid);
	$query = $this->db->update('broadcaster_tbl', $data); 
	return $query;
	}
	
	function editcausedata($data,$cid)
	{
	$this->db->where('cause_id', $cid);
	$query = $this->db->update('cause_tbl', $data); 
	return $query;
	}
	
	function addevents($values)
	{
	$query = $this->db->insert('events_tbl', $values); 
	return $query;
	}
	
	function adminPages($page='')
	{
		$this->db->select('*');
		$this->db->from('adminpages');
		$this->db->join('pagecontent','PageId  = PageContentPageId');
		$this->db->where('PageStatus', '0');
		if($page['pageId']!='')
		$this->db->where('PageId',$page['pageId']);
		
		$query = $this->db->get();
		//print_r($this->db->last_query());//exit;
		return $query->result();
	}
	
	function editPages($page)
	{
	$query = $this->db->query("select * from adminpages left join pagecontent on adminpages.PageId=pagecontent.PageContentPageId where adminpages.PageId='$page'");
	return $query->row_array();
	}
	
	function DelPage($id)
	{
		$query = $this->db->query("update adminpages set pagestatus=1 where PageId = '$id'");
		return $query;
	}
	
	function showvideos()
	{
	$query = $this->db->query("select * from broadcastervideo");
	return $query->result();
	}
	
	function insertvideos($values)
	{
	$query = $this->db->insert('broadcastervideo', $values); 
	return $query;
	}
	
	function editVideos($values,$id)
	{
	$this->db->where('bc_videoid', $id);
	$query = $this->db->update('broadcastervideo', $data); 
	return $query;
	}
	
	function getvideos($id)
	{
	$query = $this->db->query("select * from broadcastervideo where bcbroadcaster_id='$id'");
	return $query->row_array();
	}
	
	function breport($bid,$bfromdate,$btodate)
	{
	$query = $this->db->query("select broadcaster_name,useremail,usercountry,cause_name,seeds as clicks, seeds,amount from sitevisiterdata left join broadcaster_tbl on sitevisiterdata.datareport_broadcasterid=broadcaster_tbl.broadcaster_id left join user_tbl on sitevisiterdata.datareport_userid=user_tbl.userid left join cause_tbl on sitevisiterdata.datareport_causeid=cause_tbl.cause_id   
	where  sitevisiterdata.datareport_broadcasterid='$bid' and datareport_date between '$bfromdate' and '$btodate'");
	return $query;
	}
	
	/*function breport($bid,$bfromdate,$btodate)
	{
	$query = $this->db->query("select broadcaster_name,useremail,userlocation,cause_name,seeds,amount,count(video_id) as Clicks, from sitevisiterdata left join broadcaster_tbl on sitevisiterdata.datareport_broadcasterid = broadcaster_tbl.broadcaster_id left join user_tbl on sitevisiterdata.datareport_userid = user_tbl.userid left join cause_tbl on sitevisiterdata.datareport_causeid = cause_tbl.cause_id left join broadcastervideo on broadcaster_tbl.broadcaster_id = broadcastervideo.bcbroadcaster_id where sitevisiterdata.datareport_broadcasterid='$bid' and datareport_date between '$bfromdate' and '$btodate'");
	return $query;
	}*/
	
	function creport($cid,$cfromdate,$ctodate)
	{
	$query = $this->db->query("select cause_name,broadcaster_name,broadcaster_email,userfirstname,amount from sitevisiterdata left join user_tbl on sitevisiterdata.datareport_userid=user_tbl.userid left join broadcaster_tbl on sitevisiterdata.datareport_broadcasterid=broadcaster_tbl.broadcaster_id left join cause_tbl on sitevisiterdata.datareport_causeid=cause_tbl.cause_id where sitevisiterdata.datareport_causeid='$cid' and datareport_date between '$cfromdate' and '$ctodate'");
	return $query;
	}
	
	/*function creport($cid,$cfromdate,$ctodate)
	{
	$query = $this->db->query("select cause_name,broadcaster_name,broadcaster_email,userfirstname,amount from sitevisiterdata left join broadcaster_tbl on sitevisiterdata.datareport_broadcasterid = broadcaster_tbl.broadcaster_id left join user_tbl on sitevisiterdata.datareport_userid = user_tbl.userid left join cause_tbl on sitevisiterdata.datareport_causeid = cause_tbl.cause_id left join broadcastervideo on broadcaster_tbl.broadcaster_id = broadcastervideo.bcbroadcaster_id where sitevisiterdata.datareport_causeid='$cid' and datareport_date between '$cfromdate' and '$ctodate'");
	return $query;
	}*/
	
	function checkLogin($username,$password)
	{
	$query = $this->db->query("select * from admin_tbl where admin_username='$username' and admin_password='$password'");
	return $query->result();
	}
	
	function forgotpassword($user_email)
	{
	$query = $this->db->query("select * from admin_tbl where admin_email='$user_email'");
	return $query->result();
	}
	
	function updatepsskey($user_email,$passkey)
	{
	$query = $this->db->query("update admin_tbl set admin_forgotpasskey='$passkey' where admin_email='$user_email'");
	return $query;
	}
	
	function resetPassword($key,$password)
	{
	$query = $this->db->query("update admin_tbl set admin_password='$password' where admin_forgotpasskey='$key'");
	return $query;
	}
	
	function CheckAdemail($email)
	{
	$query = $this->db->query("select * from admin_tbl where admin_email='$email'");
	return $query->result();
	}
	
	function Checkeditadmusername($username,$userid)
	{
	$query = $this->db->query("select * from admin_tbl where admin_username='$username' and admin_id!='$userid'");
	return $query->result();
	}
	
	function Checkeditadmemail($email,$userid)
	{
	$query = $this->db->query("select * from admin_tbl where admin_email='$email' and admin_id!='$userid'");
	return $query->result();
	}
	
	function showbc($bname)
	{
	$query = $this->db->query("select * from broadcaster_tbl where broadcaster_id='$bname'");
	return $query->result();
	}
	
	function showcn($cname)
	{
	$query = $this->db->query("select * from cause_tbl where cause_id='$cname'");
	return $query->result();
	}
	
	function editseed($id)
	{
	/*$this->db->where('sc_broadcasterid', $id);
	$query = $this->db->update('seedconfirgation',$values); */
	$query = $this->db->query("update seedconfirgation set status=1 where sc_broadcasterid='$id' and status='0'");
	return $query;
	}
	
	function insertseed($id)
	{
	/*$this->db->where('sc_broadcasterid', $id);
	$query = $this->db->update('seedconfirgation',$values); */
	$query = $this->db->query("update seedconfirgation set status=1 where sc_broadcasterid='$id' and status='0'");
	return $query;
	}
	
	function getbcdeposit($Id)
	{
	$query = $this->db->query("select * from broadcasterdepositamount where bsa_broadcasterid='$Id'");
	return $query->row_array();
	}
	
	function selectState($country_code)
	{
	$query = $this->db->query("select * from user_state where country_code='$country_code'");
	return $query->result();
	}
	
	function gettotalamount($bid)
	{
	$query = $this->db->query("select * from seedconfirgation where sc_broadcasterid='$bid'");
	return $query->result();
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>