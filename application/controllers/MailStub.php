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
        $result  = $this->m_payStub->getDates($company);
        echo json_encode($result);
    }

    // employee payslips
    public function pay_slips()
    {
        $date       = $this->input->post('dates');
        $sliptDate  = explode(' to ', $date);
        $company    = $this->input->post('company');
        $sdate      = date('Y-m-d', strtotime($sliptDate['0']));
        $edate      = date('Y-m-d', strtotime($sliptDate['1']));
        $data       = array(
                        'company'   => $company, 
                        'sdate'     => $sdate, 
                        'edate'     => $edate, 
                    );
        $result     = $this->m_payStub->empPayslisp($data);
        echo json_encode($result);
    }

    // view payslip
    public function view_payroll($empid = null)
    {
        if(!empty($empid)){
            $sdate = $this->input->get('sdate');
            $edate = $this->input->get('edate');
            $result['pdf'] = $this->m_payStub->PdfGet($empid, $sdate, $edate);
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('payroll-pdf',$result,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
			redirect('send-pay-stub');
		}
    }

    	// download payroll on pdf format
	public function download_payroll($id = null)
	{
		if(!empty($id)){
			$sdate = $this->input->get('sdate');
            $edate = $this->input->get('edate');
            $result['pdf'] = $this->m_payStub->PdfGet($id, $sdate, $edate);
       
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('payroll-pdf',$result,true);
			$mpdf->WriteHTML($html);
			$mpdf->Output('payroll.pdf','D');
		}else{
			redirect('send-pay-stub');
		}
    }
    
    // send a as mail
	public function sendMail($id = null)
	{
		if(!empty($id)){
            
            $sdate = $this->input->get('sdate');
            $edate = $this->input->get('edate');
            $result['pdf'] = $this->m_payStub->PdfGet($id, $sdate, $edate);
            $this->m_payStub->updateMailSent($id, $sdate, $edate);
			$mpdf = new \Mpdf\Mpdf();
			$html = $this->load->view('payroll-pdf',$result,true);
			$mpdf->WriteHTML($html);
			$content = $mpdf->Output('', 'S');

			$this->load->config('email');
			$this->load->library('email');
            
            $name= date('d/m/Y', strtotime($result['pdf']->pay_start)). ' TO '. date('d/m/Y', strtotime($result['pdf']->pay_end));

			$from = $this->config->item('smtp_user');
			$to = $result['pdf']->email;
			$subject = 'Pay stub on '.$name;
			$filename = date('d/m/Y', strtotime($result['pdf']->pay_start))."-".date('d/m/Y', strtotime($result['pdf']->pay_end))."_pay-stub.pdf";
			$message = $this->load->view('email/paystub',$result, TRUE);
			$this->email->set_newline("\r\n");
			$this->email->from($from, 'Little FootPrints Academy');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->attach($content, 'attachment', $filename, 'application/pdf');
            
			if ($this->email->send()) {
				$this->session->set_flashdata('success', 'Email as been successfully sent');
				
			} else {
				$this->session->set_flashdata('error', 'Server Error Occurred Please Try agin');
				// show_error($this->email->print_debugger());
			}
		}
		redirect('send-pay-stub');
	}

    /* ********************  NET PAY REPORT   *************** */
    public function net_pay_report()
    {
        $this->load->model('pay_roll_model');
        $data['company'] = $this->pay_roll_model->companyList();
        $data['title'] = 'Net Pay Report';
        $this->load->view('netpay', $data);
    }

    public function net_pay()
    {
        $date       = $this->input->post('dates');
        $sliptDate  = explode(' to ', $date);
        $company    = $this->input->post('company');
        $sdate      = date('Y-m-d', strtotime($sliptDate['0']));
        $edate      = date('Y-m-d', strtotime($sliptDate['1']));
        $data       = array(
                        'company'   => $company, 
                        'sdate'     => $sdate, 
                        'edate'     => $edate, 
                    );
        $result     = $this->m_payStub->net_pay($data);
        echo json_encode($result);
    }

    public function export()
    {
        $date       = $this->input->get('dates');
        $sliptDate  = explode(' to ', $date);
        $company    = $this->input->get('company');
        $sdate      = date('Y-m-d', strtotime($sliptDate['0']));
        $edate      = date('Y-m-d', strtotime($sliptDate['1']));
        $data       = array(
                        'company'   => $company, 
                        'sdate'     => $sdate, 
                        'edate'     => $edate, 
                    );
         $result['pdf'] = $this->m_payStub->net_pay($data);
        if(!empty( $result['pdf'])):
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('netpay-export',$result,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('net-pay.pdf','D');
        else:
            redirect('net-pay-report','refresh');
        endif;         
    }

}

/* End of file MailStub.php */

