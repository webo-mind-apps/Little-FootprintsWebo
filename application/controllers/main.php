
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function __construct()
       {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('db_model');
		$this->load->library("pagination");
       }

	function index()
	{
		if($this->session->userdata('admin_login'))
		{
		$data['employee_position_fetch']=$this->db_model->lit_employee_position_fetch();
		$this->load->view('form-employee-crud',$data);
		}
		else
		{
			redirect('home');
		}
		
		
	}
	function employee_details_fetch()
	{
		if($this->session->userdata('admin_login'))
		{
		$data['employee_detail_fetch']=$this->db_model->lit_employee_details_fetch();
		$this->load->view('employee-details-view',$data);
		}
		else
		{
			redirect('home');
		}
	}
	
	function employee_details_fetch_for_update()
	{
		if($this->session->userdata('admin_login'))
		{
		
		$data['employee_detail_fetch']=$this->db_model->employee_details_fetch_for_update();
		$data['employee_position_fetch']=$this->db_model->lit_employee_position_fetch();
			$this->load->view('form-employee-crud',$data);
			}
		else
		{
			redirect('home');
		}
		
	}
	
	function employee_details_insert_update()
		{
				
				 if($result=$this->db_model->employee_details_insert_update())
					{
						redirect(base_url().'main/index/#'.$result);
					}
					else
					{
						redirect(base_url().'main/index/#'.$result);
					} 
		}
	
	
		
		function employee_details_delete()
		{
			
			$this->db_model->employee_details_delete($_POST['id']);
		}
		
		function dashboard()
	{
		if($this->session->userdata('admin_login')!='')
		{
		$this->load->view('dashboard');
		}
		else
		{
			redirect('home');
		}
	}
	
}
?>
