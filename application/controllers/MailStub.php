<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MailStub extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('admin_login') == false){ redirect('home','refresh'); }
        $this->load->model('m_payStub');
        
    }
    
    public function index()
    {
        $this->load->model('pay_roll_model');
        $data['company'] = $this->pay_roll_model->companyList();

        $data['title'] = 'Mail pay stub';
        $this->load->view('mail-stub', $data, FALSE);
    }

    // payroll
    public function pay_roll_dates(){
        $company = $this->input->post('company');
        $center = $this->input->post('center');
        $result = $this->m_payStub->getDates($company, $center);
        echo json_encode($result);
    }

    // employee payslips
    public function pay_slips()
    {
        $date       = $this->input->post('dates');
        $sliptDate  = explode(' to ', $date);
        $company    = $this->input->post('company');
        $center     = $this->input->post('center');
        $sdate      = date('Y-m-d', strtotime($sliptDate['0']));
        $edate      = date('Y-m-d', strtotime($sliptDate['1']));
        $data       = array(
                        'company'   => $company, 
                        'center'    => $center, 
                        'sdate'     => $sdate, 
                        'edate'     => $edate, 
                    );
        $result     = $this->m_payStub->empPayslisp($data);
        echo json_encode($result);
    }


}

/* End of file MailStub.php */

