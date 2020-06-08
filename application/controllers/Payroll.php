<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Payroll extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_payroll');
		if ($this->session->userdata('admin_login') == false) {
			redirect('home', 'refresh');
		}
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
		$date 	 = $this->input->post('pay_date');
		$company = $this->input->post('company');
		$center  = $this->input->post('center');
		$result  = $this->m_payroll->employeeDetailDate($sdate, $edate, $company, $center, $date);

		$table = '';
		$table .= '<tr> 
						<th>SL.NO</th> 
						<th>FIRST NAME</th> 
						<th>LAST NAME</th> 
						<th>PER HR RATE($)</th> 
						<th class="text-center">REGULAR HRS</th> 
						<th class="text-center">STAT HOL HRS</th> 
						<th class="text-center">WAGES</th> 
						<th class="text-center">MISCELLANEOUS</th> 
						<th class="text-center">MEDICAL</th> 
						<th class="text-center">MEDICAL <br/> CONTRIBUTION</th> 
						<th style="width:115px"	 class="text-center">
							RELEASE <br> 
							VACATION PAY <br>
							<input type="checkbox" class="form-control" id="checkall" value="1">
						</th>
						
					</tr>';
		if (!empty($result)) :
			foreach ($result as $key => $row) {


				$checked = '';
				if (!empty($row->payRoll->is_vacation)) {
					$checked = ($row->payRoll->is_vacation == 1) ? 'checked' : '';
				}

				$rate   		= (!empty($row->payRoll->rate) ? $row->payRoll->rate : $row->hour_rate);
				$reg			= (!empty($row->payRoll->reg_unit) ? $row->payRoll->reg_unit : '');
				$stat_rate		= (!empty($row->payRoll->stat_unit) ?  $row->payRoll->stat_unit : '');
				$wages			= (!empty($row->payRoll->wages) ? $row->payRoll->wages : 0);
				$miscellaneous	= (!empty($row->payRoll->miscellaneous) ?  $row->payRoll->miscellaneous : 0);
				$medical		= (!empty($row->payRoll->medical) ?  $row->payRoll->medical : 0);

				$table .= '     
			<tr>
				<td>
					<input type="hidden"  name="prl_id[]" value="' . (!empty($row->payRoll->id) ? $row->payRoll->id :  "") . '" >
					<input type="hidden"  name="emp_ids[]" value="' . $row->emp_id . '" >
					' . ($key + 1) . '
				</td>
			 
				<td>
					<span>' . $row->first_name . '</span>
				</td>
			 
				<td>
					<span>' . $row->last_name . '</span>
				</td>
			 
				<td>
					<input type="text"  class="form-control"  autocomplete="off" name="rate_hour[]" value="' . $rate . '">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control"  autocomplete="off" name="regular_hrs[]" value="' . $reg . '">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control"  autocomplete="off" name="stat_hol_hrs[]" value="' . $stat_rate . '" >
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control"  autocomplete="off" name="wage_amount[]" value="' . $wages . '">
				</td>
			 
				<td class="text-center">
					<input type="text" class="form-control"  autocomplete="off"  name="miscellaneous_amount[]" value="' . $miscellaneous . '">
				</td>

				<td class="text-center">
					<input type="text" class="form-control" readonly  autocomplete="off" name="medical[]" value="' . $row->medical . '">
				</td>
				<td class="text-center">
					<input type="text" class="form-control" readonly  autocomplete="off" name="medicalcontr[]" value="' . $row->medical_contribution . '">
				</td>
				
				<td class="text-center">
					<input type="checkbox" class="form-control vacchek" ' . $checked . ' name="vacationPay[]" value="1">
					<input type="hidden" class="form-control"  autocomplete="off" name="vacation[]" value="' . $row->vocation_rate . '">
				</td>
			 
				
			</tr>

				';
			}
			echo $table;
		else :
			echo '
				<tr>
					<td colspan="9" class="text-center">
						<img class="img-responsive" src="' . base_url() . 'my_assets/found.gif"> 
						</td>
				</tr>';
		endif;
	}

	// save Payroll
	public function save_payroll()
	{
		// Load form validation library
		if (!empty($_FILES['import']['name'])) {
			$data = array();
			// get file extension
			$valid_extentions = array('xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw');
			$extension = pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION);
			$valid = false;
			foreach ($valid_extentions as $key => $value) {
				if ($extension == $value) {
					$valid = true;
				}
			}
			if ($valid) {
				if ($extension == 'csv') :
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				elseif ($extension == 'xlsx') :
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				else :
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				endif;

				// file path
				$spreadsheet = $reader->load($_FILES['import']['tmp_name']);
				$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$this->savePayrollExcel($allDataInSheet);
				$this->session->set_flashdata('success', 'Payroll imported successfully!');
				redirect('payroll', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Invalid file format!!');
				redirect('payroll', 'refresh');
			}
		} else {
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
					'is_vacation_release' => (isset($post['vacationPay'][$key])) ? '1' : '0',
					'medical'			=> $post['medical'][$key],
					'vacation'			=> $post['vacation'][$key],
					'center'			=> $post['center'],
					'company'			=> $post['company'],
					'pay_start'         => date('Y-m-d', strtotime($sDate)),
					'pay_end'           => date('Y-m-d', strtotime($eDate)),
					'updateOn'          => date('Y-m-d H:i:s'),
					'created_on'		=> date('Y-m-d H:i:s', strtotime($post['pay_date'])),
					'medical_contribution' => $post['medicalcontr'][$key]
				);
				$pid = $post['prl_id'][$key];
				$this->m_payroll->savePayroll($data, $sDate, $eDate, $pid);
			}
			$this->session->set_flashdata('abc', 'success');
			redirect('main_control/pay_roll_page');
		}
	}

	// pdfImport
	public function import_payroll()
	{
		// Load form validation library
		if (!empty($_FILES['import']['name'])) {
			$data = array();
			// get file extension
			$valid_extentions = array('xls', 'xlt', 'xlm', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw');
			$extension = pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION);
			$valid = false;
			foreach ($valid_extentions as $key => $value) {
				if ($extension == $value) {
					$valid = true;
				}
			}

			if ($valid) {
				if ($extension == 'csv') :
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				elseif ($extension == 'xlsx') :
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				else :
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				endif;

				// file path
				$spreadsheet = $reader->load($_FILES['import']['tmp_name']);
				$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$this->savePayrollExcel($allDataInSheet);
				$this->session->set_flashdata('success', 'Payroll imported successfully!');
				redirect('payroll', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Invalid file format!!');
				redirect('payroll', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', 'File is empty');
			redirect('payroll', 'refresh');
		}
	}

	public function savePayrollExcel($importData = null)
	{

		$post = $this->input->post();
		for ($i = 2; $i <= count($importData); $i++) {
			$empDetail = $this->m_payroll->getEmpDetail($importData[$i]['D']);
			if (!empty($empDetail)) {
				$data = array(
					'emp_ids' 		    	=> $importData[$i]['D'],
					'reg_rate' 				=> $importData[$i]['E'],
					'stat_rate' 			=> $importData[$i]['F'],
					'wages' 				=> $importData[$i]['G'],
					'miscellaneous' 		=> $importData[$i]['H'],
					'per_hr_rate'			=> $empDetail->hour_rate,
					'is_vacation_release'	=> $importData[$i]['I'],
					'medical'				=> $empDetail->medical,
					'vacation'				=> $empDetail->vocation_rate,
					'center'				=> $post['center'],
					'company'				=> $post['company'],
					'pay_start'         	=> date('Y-m-d', strtotime($post['pay_date_val'])),
					'pay_end'           	=> date('Y-m-d', strtotime($post['pay_end_date_val'])),
					'updateOn'          	=> date('Y-m-d H:i:s'),
					'medical_contribution'	=> $empDetail->medical_contribution,
					'created_on'		=> date('Y-m-d H:i:s', strtotime($post['pay_date'])),
				);

				$this->m_payroll->savePayroll($data, $data['pay_start'], $data['pay_end'], $pid = null);
			}
		}
		return true;
	}

	// sample formate generate
	public function sample_formate($var = null)
	{
		$company = $this->input->get('company');
		$center  = $this->input->get('center');
		$result  = $this->m_payroll->sampleFormate($company, $center);

		$alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
		$i = 2;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'SL No');
		$sheet->setCellValue('B1', 'FIRST NAME');
		$sheet->setCellValue('C1', 'LAST NAME');
		$sheet->setCellValue('D1', 'EMPLOYEE ID');
		$sheet->setCellValue('E1', 'REGULAR HRS');
		$sheet->setCellValue('F1', 'STAT HOL HRS');
		$sheet->setCellValue('G1', 'WAGES');
		$sheet->setCellValue('H1', 'MISCELLANEOUS');
		$sheet->setCellValue('I1', 'is_vacation_release(1=pay, 0=not pay)');

		foreach ($result as $key => $value) {
			$sheet->setCellValue('A' . $i, $key + 1);
			$sheet->setCellValue('B' . $i, $value->first_name);
			$sheet->setCellValue('C' . $i, $value->last_name);
			$sheet->setCellValue('D' . $i, $value->emp_id);
			$sheet->setCellValue('E' . $i, '');
			$sheet->setCellValue('F' . $i, '');
			$sheet->setCellValue('G' . $i, '');
			$sheet->setCellValue('H' . $i, '');
			$sheet->setCellValue('I' . $i, '0');
			$i += 1;
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'payroll_sample';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output'); // download file 

	}
}
