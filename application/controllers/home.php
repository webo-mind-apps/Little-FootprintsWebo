<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Home extends CI_Controller { 
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('admin_model');	
	} 
	
	function index(){  
		$this->load->view('admin_login');	
		}
	/* function insertion(){
		$this->admin_model->insert_admin();
	} */ 
	function selection(){
		$data=$this->admin_model->select_admin();
		
		if($data=="true")
		{
			redirect('main/dashboard');
		}
		else
		{
			redirect('home');
		} 
	}
	function forget_password()
	{
		$this->load->view('login_password_recovery');
	}
	function reset_password()
	{
		$this->load->view('Reset_password');
		//$this->admin_model->update_password();
	}
	function logout()
	{
		$this->session->unset_userdata('admin_login');
		$this->session->unset_userdata('admin_id');
		redirect('home');
	}
}