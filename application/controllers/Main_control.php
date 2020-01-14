<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_control extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('pay_roll_model'); 
		if($this->session->userdata('admin_login') == false){ redirect('home','refresh'); }
	} 
	function pay_roll_page()
	{   $data['company'] = $this->pay_roll_model->companyList();
        $this->load->view('pay_roll', $data); 
	}	
	function pay_roll_dates()
	{ 	
		$sdate 	 = $this->input->post('payment_date');
		$edate 	 = $this->input->post('pay_end_date'); 
		$company = $this->input->post('company');
		$center  = $this->input->post('center');
		$result  = $this->pay_roll_model->select_where_employee_details($sdate, $edate, $company, $center);  
		
		$table = '';
		$table .= '<tr> 
						<th>SL.NO</th> 
						<th>FIRST NAME</th> 
						<th>LAST NAME</th> 
						<th>PER HR RATE($)</th> 
						<th class="text-center">REGULAR HRS</th> 
						<th class="text-center">STAT HOL HRS</th> 
						<th class="text-center">WAGE AMOUNT</th> 
						<th class="text-center">MISCELLANEOUS<br>AMOUNT</th> 
						<th class="text-center">ACTION</th> 
					</tr>';
		if(!empty($result)):
		  foreach($result as $key => $row) { 

			$regular_hrs  			= (!empty($row->payRoll->regular_hrs) ? $row->payRoll->regular_hrs: '');
			$stat_hol 				=  (!empty($row->payRoll->stat_hol) ? $row->payRoll->stat_hol: '');
			$wage_amount 			=  (!empty($row->payRoll->wage_amount) ? $row->payRoll->wage_amount: '');
			$miscellaneous_amount 	=  (!empty($row->payRoll->miscellaneous_amount) ? $row->payRoll->miscellaneous_amount: '');
			$payrollId 				=  (!empty($row->payRoll->id) ? $row->payRoll->id: '');


			if(!empty($regular_hrs) && !empty($stat_hol) && !empty($wage_amount) && !empty($miscellaneous_amount)){

				$btn = '<a href="'.base_url().'download-payroll/'.$payrollId.'" class="pdf-download"><i class="icon-file-download2 ml-2"></i></a>';
			}else{
				$btn = '<a  class="pdf-download disableda"><i class="icon-file-download2 ml-2"></i></a>';
			}

			$table .='     
			<tr>
				<td>
					<input type="hidden"  name="prl_id[]" value="'.$payrollId.'" >
					<input type="hidden"  name="emp_ids[]" value="'.$row->emp_id.'" >
					'.($key + 1).'
				</td>
			 
				<td>
					<span>'.$row->first_name.'</span>
				</td>
			 
				<td>
					<span>'.$row->last_name.'</span>
				</td>
			 
				<td>
					<input type="text" readonly class="form-control" name="rate_hour[]" value="'.$row->hour_rate.'">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="regular_hrs[]" value="'.$regular_hrs.'">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="stat_hol_hrs[]" value="'.$stat_hol.'" >
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="wage_amount[]" value="'.$wage_amount.'">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="miscellaneous_amount[]" value="'.$miscellaneous_amount.'">
				</td>
			 
				<td class="text-center">
					'.$btn.'
				</td>
			</tr>

				';   	
		  } 
		  echo $table;
		else:
			echo '
				<tr>
					<td colspan="9" class="text-center"><h3>No result Found</h3></td>
				</tr>';
		endif;
		      
   }
	function pay_slip_view()
	{  
		$this->load->view('pay_slip_view'); 
	} 
	 
	function save_payroll()
	{  
		$post = $this->input->post();
		$sDate = $post['pay_date_val'];
		$eDate = $post['pay_end_date_val'];
		foreach ($post['emp_ids'] as $key => $value) {
			$data = array(
				'emp_ids' 				=> $post['emp_ids'][$key], 
				'regular_hrs' 			=> $post['regular_hrs'][$key], 
				'stat_hol' 				=> $post['stat_hol_hrs'][$key], 
				'wage_amount' 			=> $post['wage_amount'][$key], 
				'miscellaneous_amount' 	=> $post['miscellaneous_amount'][$key], 
				'per_hr_rate'			=> $post['rate_hour'][$key]
			);
			$pid = $post['prl_id'][$key];
			$this->pay_roll_model->updatePayrolls($data, $sDate, $eDate, $pid);
			
		}
		$this->session->set_flashdata('abc','success');
		redirect('main_control/pay_roll_page');
	}  

	// download payroll on pdf format
	public function download_payroll($id = null)
	{
		if(!empty($id)){
			$result['pdf']= $this->pay_roll_model->GetDataForPdf($id);
			$result['yrDeduction'] = $this->pay_roll_model->oldYtds($id);
			$mpdf = new \Mpdf\Mpdf();
			$html = $this->load->view('payroll-pdf',$result,true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			//$mpdf->Output('payroll.pdf','D');
		}else{
			redirect('main_control/pay_roll_page');
		}

	}

}