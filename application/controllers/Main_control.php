<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_control extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('pay_roll_model'); 
	} 
	function pay_roll_page()
	{   
        $this->load->view('pay_roll'); 
	}	
	function pay_roll_dates()
	{ 	
		$sdate = $this->input->post('payment_date');
		$edate = $this->input->post('pay_end_date'); 
		$result = $this->pay_roll_model->select_where_employee_details($sdate, $edate);  
		
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
			$regular_hrs  = (!empty($row->payRoll->regular_hrs) ? $row->payRoll->regular_hrs: '');
			$stat_hol =  (!empty($row->payRoll->stat_hol) ? $row->payRoll->stat_hol: '');
			$wage_amount =  (!empty($row->payRoll->wage_amount) ? $row->payRoll->wage_amount: '');
			$miscellaneous_amount =  (!empty($row->payRoll->miscellaneous_amount) ? $row->payRoll->miscellaneous_amount: '');
			$payrollId =  (!empty($row->payRoll->id) ? $row->payRoll->id: '');
			if(!empty($regular_hrs) && !empty($stat_hol) && !empty($wage_amount) && !empty($miscellaneous_amount)){
				$btn = '<a href="'.base_url().'download-payroll/'.$payrollId.'" class="pdf-download"><i class="icon-file-download2 ml-2"></i></a>';
			}else{
				$btn = '<a  class="pdf-download disableda"><i class="icon-file-download2 ml-2"></i></a>';
			}

			$table .='     
			<tr>
				<td>
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
					'.$row->hour_rate.'
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
			);

			$this->pay_roll_model->updatePayrolls($data, $sDate, $eDate);
			
		}
		$this->session->set_flashdata('abc','success');
		redirect('main_control/pay_roll_page');
	}  

	// download payroll on pdf format
	public function download_payroll($id = null)
	{

		// $this->load->view('payroll-pdf');	
		
		if(!empty($id)){
			# fetch data from data base 
			# after fetching data pass to view page and display on view page
			$mpdf = new \Mpdf\Mpdf();
			$html = $this->load->view('payroll-pdf',[],true);
			$mpdf->WriteHTML($html);
			$mpdf->Output(); // opens in browser
			//$mpdf->Output('payroll.pdf','D'); // it downloads 
		}else{
			#show error here
		}

	}

}
?>

