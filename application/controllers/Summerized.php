<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class summerized extends CI_Controller {

    public function __construct(){
		parent::__construct();
		// $this->load->model('pay_roll_model'); 
		if($this->session->userdata('admin_login') == false){ redirect('home','location',); }
	} 

    public function index()
    {
        $mpdf = new \Mpdf\Mpdf();
		$html = $this->load->view('summerized',[],true);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
    }

}

/* End of file summerized.php */
