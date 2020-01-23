<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('m_payroll'); 
		if($this->session->userdata('admin_login') == false){ redirect('home','refresh'); }
    } 
    
    public function index()
    {
        $data['company'] = $this->m_payroll->companyList();
        $this->load->view('pay_roll', $data); 
    }

    // Payroll by date 
    function pay_roll_dates()
	{ 	
		$sdate 	 = date('Y-m-d', strtotime($this->input->post('payment_date')));
		$edate 	 = date('Y-m-d', strtotime($this->input->post('pay_end_date'))); 
		$company = $this->input->post('company');
		$center  = $this->input->post('center');
		$result  = $this->m_payroll->employeeDetailDate($sdate, $edate, $company, $center);  
		
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
						<th class="text-center">MEDICAL<br>AMOUNT</th> 
						<th style="width:115px"	 class="text-center">
							RELEASE <br> 
							VACATION PAY <br>
							<input type="checkbox" class="form-control" id="checkall" value="1">
						</th>
						
					</tr>';
		if(!empty($result)):
		  foreach($result as $key => $row) { 
            $checked = '';
            if(!empty($row->payRoll->is_vacation)){
				$checked = ($row->payRoll->is_vacation == 1)? 'checked' : '';
            }
			
			$rate   		= (!empty($row->payRoll->rate)? $row->payRoll->rate : $row->hour_rate);
			$reg			= (!empty($row->payRoll->reg_unit)? $row->payRoll->reg_unit : '');
			$stat_rate		= (!empty($row->payRoll->stat_unit)?  $row->payRoll->stat_unit : '');
			$wages			= (!empty($row->payRoll->wages)? $row->payRoll->wages : 0);
			$miscellaneous	= (!empty($row->payRoll->miscellaneous)?  $row->payRoll->miscellaneous : 0);
			$medical		= (!empty($row->payRoll->medical)?  $row->payRoll->medical : 0);

			$table .='     
			<tr>
				<td>
					<input type="hidden"  name="prl_id[]" value="'.(!empty($row->payRoll->id)? $row->payRoll->id :  "" ).'" >
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
					<input type="text" readonly class="form-control" name="rate_hour[]" value="'.$rate.'">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="regular_hrs[]" value="'.$reg.'">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="stat_hol_hrs[]" value="'.$stat_rate.'" >
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control" name="wage_amount[]" value="'.$wages.'">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control"  name="miscellaneous_amount[]" value="'.$miscellaneous.'">
				</td>

				<td class="text-center">
					<input type="text" class="form-control" name="medical[]" value="'.$row->medical.'">
				</td>

				<td class="text-center">
					<input type="checkbox" class="form-control vacchek" '.$checked.' name="vacationPay[]" value="1">
					<input type="hidden" class="form-control" name="vacation[]" value="'.$row->vocation_rate.'">
				</td>
			 
				
			</tr>

				';   	
		  } 
		  echo $table;
		else:
			echo '
				<tr>
					<td colspan="9" class="text-center">
						<img class="img-responsive" src="'.base_url().'my_assets/found.gif"> 
						</td>
				</tr>';
		endif;
		      
   	}

    // save Payroll
    public function save_payroll()
    {
        $post = $this->input->post();
		$sDate = $post['pay_date_val'];
		$eDate = $post['pay_end_date_val'];
		foreach ($post['emp_ids'] as $key => $value) {
			$data = array(
				'emp_ids' 		    => $post['emp_ids'][$key], 
				'reg_rate' 			=> $post['regular_hrs'][$key], 
				'stat_rate' 		=> $post['stat_hol_hrs'][$key], 
				'wages' 			=> $post['wage_amount'][$key], 
				'miscellaneous' 	=> $post['miscellaneous_amount'][$key], 
				'per_hr_rate'		=> $post['rate_hour'][$key],
				'is_vacation_release'=> (isset($post['vacationPay'][$key]))? '1' : '0',
				'medical'			=> $post['medical'][$key],
				'vacation'			=> $post['vacation'][$key],
				'center'			=> $post['center'],
                'company'			=> $post['company'],
                'pay_start'         => date('Y-m-d', strtotime($sDate)),
                'pay_end'           => date('Y-m-d', strtotime($eDate)),
                'updateOn'          => date('Y-m-d H:i:s')
			);
			$pid = $post['prl_id'][$key];
			$this->m_payroll->savePayroll($data, $sDate, $eDate, $pid);
			
        }
		$this->session->set_flashdata('abc','success');
		redirect('main_control/pay_roll_page');
    }
}