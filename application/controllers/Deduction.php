<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class deduction extends CI_Controller {

    
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

        $data['title'] = 'Employee Deduction';
        $this->load->view('deduction', $data, FALSE);
    }

    public function get_deduction()
    {
        $data['company']    = $this->input->post('company');
        $data['year']       = $this->input->post('year');
        $data['month']      = $this->input->post('month');
        $result     = $this->m_payStub->get_deduction($data);
        echo json_encode($result);
    }

    public function export()
    {
        $data['company']    = $this->input->get('company');
        $data['year']       = $this->input->get('year');
        $data['month']      = $this->input->get('month');
        $result['deduction']= $this->m_payStub->get_deduction($data);

        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('deduction-pdf',$result,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

}

