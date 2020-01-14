<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class summerized extends CI_Controller {

    public function __construct(){

		parent::__construct();

		$this->load->model('m_summarized'); 

		if($this->session->userdata('admin_login') == false){ redirect('home','location'); }

	} 



	public function index()

	{

		$year = $this->input->get('year');

		$data['emp'] = $this->m_summarized->getEmployees($year);

		$this->load->view('summarized-list', $data);

		

	}



    public function report($id=null)

    {

		$year = $this->input->get('year');

		$data['pdf'] = $this->m_summarized->getEmployee($id);

        $mpdf = new \Mpdf\Mpdf();

		$html = $this->load->view('summerized',$data,true);

		$mpdf->WriteHTML($html);

		$mpdf->Output();

    }



}



/* End of file summerized.php */

