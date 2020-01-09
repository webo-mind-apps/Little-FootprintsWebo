<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class admin_model extends CI_Model 
   { 
      public function __construct()
	  { 
         parent::__construct(); 
		 $this->load->library("session");
      } 
	 /* function insert_admin()
	{
		$name=$this->input->post('admin_email_id');
		$password=$this->input->post('admin_password'); 
		$password = hash ( "sha512", $password );
		$field =array('admin_email_id'=>$name,'admin_password'=>$password);
		$this->db->insert("admin_details",$field);  
       		
	}   */ 
	function select_admin(){
		$name = $this->input->post('admin_email_id');
		$password = $this->input->post('admin_password');
		$password1= hash("sha512",$password);
		$field =  array('admin_email_id'=>$name,'admin_password'=>$password1);
		$this->db->select('*');
		$this->db->from('admin_details');
		$this->db->where($field);
		$query = $this->db->get();
		$num = $query->num_rows();
		 if($num){ 
			$this->session->set_userdata('admin_login','true');
			$this->session->set_userdata('admin_id',$num[0]['id']);
			return "true";
		 }else{ 
			return "false";
		 } 
	}
	/* function update_password(){ 
		$updateData = array('admin_password'=>$password); 
        $this->db->where('admin_email_id', $array['admin_email_id']);
        $this->db->update('admin_details', $updateData); 
      	} */
   } 
?>
