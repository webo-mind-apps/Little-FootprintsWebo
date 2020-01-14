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
		$data['comapny_fetch']=$this->db_model->company_master();
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
			$data['centers'] = $this->db_model->empCenters();
			
			$data['comapny_fetch']=$this->db_model->company_master();
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
            if($this->session->userdata('admin_login'))
		{
				
				 if($this->db_model->employee_details_insert_update())
					{
						redirect(base_url().'main/index/');
					}
					else
					{
						redirect(base_url().'main/index/');
                    } 
            }
		}
	
	
		
		function employee_details_delete()
		{
            if($this->session->userdata('admin_login'))
		{
			
            $this->db_model->employee_details_delete($_POST['id']);
        }
        else
		{
			redirect('home');
		}
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
    
    function government_pension()
	{
		if($this->session->userdata('admin_login'))
		{
        $data['emp_pension_fetch']=$this->db_model->emp_pension_fetch();
		$this->load->view('government_pension',$data);
		}
		else
		{
			redirect('home');
		}
		
		
	}

	function emp_pension_insert_update()
		{
            if($this->session->userdata('admin_login'))
		{
		if(isset($_POST['insert_button']))
		{
				
				 if($this->db_model->emp_pension_insert())
					{
                        $this->session->set_flashdata('insert','success');
						redirect(base_url().'main/government_pension/');
					}
					else
					{
						redirect(base_url().'main/government_pension/');
                    } 
        }
             
		if(isset($_POST['update_button']))
		{
                    
                    if($this->db_model->emp_pension_update())
					{
                        $this->session->set_flashdata('update','success');
						redirect(base_url().'main/government_pension/');
					}
					else
					{
						redirect(base_url().'main/government_pension/');
					} 
        }
    }
    else
		{
			redirect('home');
		}
    }

    function employee_pension_delete()
		{
            if($this->session->userdata('admin_login'))
		{
			
            $this->db_model->employee_pension_delete($_POST['id']);
        }
        else
		{
			redirect('home');
		}
        }
        function employee_pension_fetch_for_update()
        {
		if($this->session->userdata('admin_login'))
		{
            $data['emp_pension_fetch']=$this->db_model->emp_pension_fetch();
		$data['employee_pension_update_fetch']=$this->db_model->employee_pension_fetch_for_update();
			$this->load->view('government_pension',$data);
			}
		else
		{
			redirect('home');
		}
        }
        
        function federal_tax()
        {
            if($this->session->userdata('admin_login'))
            {
            $data['emp_federal_fetch']=$this->db_model->emp_federal_fetch();
            $this->load->view('federal_tax',$data);
            }
            else
            {
                redirect('home');
            }
            
            
        }

        function emp_federal_insert_update()
		{
            if($this->session->userdata('admin_login'))
		{
		if(isset($_POST['insert_button']))
		{
				
				 if($this->db_model->emp_federal_insert())
					{
                        $this->session->set_flashdata('insert','success');
						redirect(base_url().'main/federal_tax/');
					}
					else
					{
						redirect(base_url().'main/federal_tax/');
                    } 
        }
             
		if(isset($_POST['update_button']))
		{
                    
                    if($this->db_model->emp_federal_update())
					{
                        $this->session->set_flashdata('update','success');
						redirect(base_url().'main/federal_tax/');
					}
					else
					{
                        redirect(base_url().'main/federal_tax/');
					} 
        }
    }
    else
		{
			redirect('home');
		}
    }


    function employee_federal_delete()
		{
            if($this->session->userdata('admin_login'))
		{
			
            $this->db_model->employee_federal_delete($_POST['id']);
        }
        else
		{
			redirect('home');
		}
        }


        function employee_federal_fetch_for_update()
        {
		if($this->session->userdata('admin_login'))
		{
            $data['emp_federal_fetch']=$this->db_model->emp_federal_fetch();
		$data['employee_federal_update_fetch']=$this->db_model->employee_federal_fetch_for_update();
			$this->load->view('federal_tax',$data);
			}
		else
		{
			redirect('home');
		}
		}
		

		function ei_contribution()
        {
            if($this->session->userdata('admin_login'))
            {
            $data['emp_ei_fetch']=$this->db_model->ei_contribution();
            $this->load->view('ei_contribution',$data);
            }
            else
            {
                redirect('home');
            }
            
            
        }

        function emp_ei_insert_update()
		{
            if($this->session->userdata('admin_login'))
		{
		if(isset($_POST['insert_button']))
		{
				
				 if($this->db_model->emp_ei_insert())
					{
                        $this->session->set_flashdata('insert','success');
						redirect(base_url().'main/ei_contribution/');
					}
					else
					{
						redirect(base_url().'main/ei_contribution/');
                    } 
        }
             
		if(isset($_POST['update_button']))
		{
                    
                    if($this->db_model->emp_ei_update())
					{
                        $this->session->set_flashdata('update','success');
						redirect(base_url().'main/ei_contribution/');
					}
					else
					{
                        redirect(base_url().'main/ei_contribution/');
					} 
        }
    }
    else
		{
			redirect('home');
		}
    }


    function employee_ei_delete()
		{
            if($this->session->userdata('admin_login'))
		{
			
            $this->db_model->employee_ei_delete($_POST['id']);
        }
        else
		{
			redirect('home');
		}
        }


        function employee_ei_fetch_for_update()
        {
		if($this->session->userdata('admin_login'))
		{
            $data['emp_ei_fetch']=$this->db_model->ei_contribution();
		$data['employee_ei_update_fetch']=$this->db_model->employee_ei_fetch_for_update();
			$this->load->view('ei_contribution',$data);
			}
		else
		{
			redirect('home');
		}
		}
		


		

		function company_master()
        {
            if($this->session->userdata('admin_login'))
            {
            $data['comapny_fetch']=$this->db_model->company_master();
            $this->load->view('company_master',$data);
            }
            else
            {
                redirect('home');
            }
            
            
        }

        function company_master_insert_update()
		{
            if($this->session->userdata('admin_login'))
		{
		if(isset($_POST['insert_button']))
		{
				
				 if($this->db_model->company_master_insert())
					{
                        $this->session->set_flashdata('insert','success');
						redirect(base_url().'main/company_master/');
					}
					else
					{
						redirect(base_url().'main/company_master/');
                    } 
        }
             
		if(isset($_POST['update_button']))
		{
                    
                    if($this->db_model->company_master_update())
					{
                        $this->session->set_flashdata('update','success');
						redirect(base_url().'main/company_master/');
					}
					else
					{
                        redirect(base_url().'main/company_master/');
					} 
        }
    }
    else
		{
			redirect('home');
		}
    }


    function company_master_delete()
		{
            if($this->session->userdata('admin_login'))
		{
			
            $this->db_model->company_master_delete($_POST['id']);
        }
        else
		{
			redirect('home');
		}
        }


        function company_master_fetch_for_update()
        {
		if($this->session->userdata('admin_login'))
		{
            $data['comapny_fetch']=$this->db_model->company_master();
		$data['company_master_fetch_for_update']=$this->db_model->company_master_fetch_for_update();
			$this->load->view('company_master',$data);
			}
		else
		{
			redirect('home');
		}
        }

    
		function center_master()
        {
            if($this->session->userdata('admin_login'))
            {
			$data['comapny_fetch']=$this->db_model->company_master();
            $data['center_fetch']=$this->db_model->center_master();
            $this->load->view('center_master',$data);
            }
            else
            {
                redirect('home');
            }
            
            
        }

        function center_master_insert_update()
		{
            if($this->session->userdata('admin_login'))
		{
		if(isset($_POST['insert_button']))
		{
				
				 if($this->db_model->center_master_insert())
					{
                        $this->session->set_flashdata('insert','success');
						redirect(base_url().'main/center_master/');
					}
					else
					{
						redirect(base_url().'main/center_master/');
                    } 
        }
             
		if(isset($_POST['update_button']))
		{
                    
                    if($this->db_model->center_master_update())
					{
                        $this->session->set_flashdata('update','success');
						redirect(base_url().'main/center_master/');
					}
					else
					{
                        redirect(base_url().'main/center_master/');
					} 
        }
    }
    else
		{
			redirect('home');
		}
    }


    function center_master_delete()
		{
            if($this->session->userdata('admin_login'))
		{
			
            $this->db_model->center_master_delete($_POST['id']);
        }
        else
		{
			redirect('home');
		}
        }


        function center_master_fetch_for_update()
        {
		if($this->session->userdata('admin_login'))
		{
			$data['comapny_fetch']=$this->db_model->company_master();
            $data['center_fetch']=$this->db_model->center_master();
		$data['center_master_fetch_for_update']=$this->db_model->center_master_fetch_for_update();
			$this->load->view('center_master',$data);
			}
		else
		{
			redirect('home');
		}
		}
		
		function center_select_feild()
        {
            if($this->session->userdata('admin_login'))
            {
			$id = $_POST['company_name'];
			
			$data=$this->db_model->center_select_feild($id);
		  
			echo json_encode($data);
			}
        }

}