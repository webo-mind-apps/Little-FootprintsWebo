<?php
class Pay_roll_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	} 

	function insert_payroll_list()
	{    
		    $emp_ids     	  	  = $_POST['emp_ids'];
		    $first_name     	  = $_POST['first_name'];
		    $last_name     		  = $_POST['last_name'];
			$per_hr_rate		  = $_POST['per_hr_rate'];
			$regular_hrs		  = $_POST['regular_hrs']; 
			$stat_hol_hrs		  = $_POST['stat_hol_hrs'];
			$wage_amount		  = $_POST['wage_amount'];
			$miscellaneous_amount = $_POST['miscellaneous_amount'];
			$payment_date         = $_POST['pay_date_val'];
			$payment_end_date     = $_POST['pay_end_date_val'];
			 
		  for($i=0;$i<count($first_name);$i++)
		  { 
		  	$emp_ids     	 		   =  $emp_ids[$i];
			$first_name_db				= $first_name[$i];
			$last_name_db				= $last_name[$i];
			$per_hr_rate_db			    = $per_hr_rate[$i]; 
			$regular_hrs_db				= $regular_hrs[$i];
			$stat_hol_hrs_db			= $stat_hol_hrs[$i];
			$wage_amount_db				= $wage_amount[$i];
			$miscellaneous_amount_db	= $miscellaneous_amount[$i]; 

			$field = array('emp_ids'=>$emp_ids,'first_name'=>$first_name_db,'last_name'=>$last_name_db,'per_hr_rate'=>$per_hr_rate_db,'regular_hrs'=>$regular_hrs_db,'stat_hol'=>$stat_hol_hrs_db,'wage_amount'=>$wage_amount_db,'miscellaneous_amount'=>$miscellaneous_amount_db,'pay_date'=>$payment_date,'pay_end_date'=>$payment_end_date);

          
			if($this->db->insert("lit_payroll",$field)){
			     return TRUE;
			}else{
			     return false;
			}
		 }
		
	} 

	function select_where_employee_details($sdate = null, $edate = null, $company = null, $center = null){ 
		
	}

	// Get payriol detils
	public function getPayRoll($id = null, $sdate = null, $edate = null, $company = null, $center = null)
	{
		
		$this->db->from('lit_payroll p');
		$this->db->select('p.*');
		$this->db->join('lit_employee_details e', 'e.emp_id = p.emp_ids', 'left');
		if(!empty($company)){
			$this->db->where('e.company', $company);
			if (!empty($center)) {
				$this->db->where('p.center', $center);
			}
		}
		$this->db->where('p.emp_ids', $id);
		$this->db->where('p.pay_date <=', $edate);	
		$this->db->where('p.pay_date >=', $sdate);
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->row();
	}



	function select_pay_roll_details($payment_date,$pay_end_date){  
		$this->db->select('*');
		$this->db->from('lit_payroll'); 
		$where_arr = array('pay_date'=>$payment_date,'pay_end_date'=>$pay_end_date);
		$this->db->where($where_arr);
		$query=$this->db->get();
		$a=$query->result_array();   
		return $a;
	}

	function select_employee_details(){  
		$this->db->select('id,emp_id,first_name,last_name,status,hour_rate');
		$this->db->from('lit_employee_details'); 
		$this->db->where('status','0'); 
		$query=$this->db->get();
		$a=$query->result_array();   
		return $a;
	}

	// // update Payment 
	public function updatePayrolls($data = null, $sDate = null , $eDate = null, $id = null)
	{
		
		if(!empty($id)):
			$this->updatePayrollByid($data, $id);
		else:
			$this->inserPayroll($data, $sDate , $eDate);
		endif;
		
		return true;
	}

	public function updatePayrollByid($data = null, $id = null)
	{
		$this->db->where('id', $id)->update('lit_payroll', $data);
		$this->updateYtd($id, $data, $data['emp_ids']);
		$this->updateYtds($data, $id);
		// $this->updateYtds($data['emp_ids'], $data['medical'], $id, $data['vacation_release']);
		return true;
	}

	public function inserPayroll($data = null, $sDate = null , $eDate = null)
	{
		$sDate = date('Y-m-d', strtotime($sDate));
		$eDate = date('Y-m-d', strtotime($eDate));
		$data = array_merge($data, array('pay_date' => $sDate, 'pay_end_date' => $eDate));
		$this->db->insert('lit_payroll', $data);
		$id = $this->db->insert_id();
		$this->updateYtd($id, $data, $data['emp_ids']);
		$this->updateYtds($data, $id);
		// $this->updateYtds($data['emp_ids'], $data['medical'], $id, $data['vacation_release']);
		return true;
	}

	// // YTD Update
	public function updateYtd($id = null, $data = null, $empid = null)
	{
		$emps = $this->fetchSingleEmp($empid, $id);
		if(empty($emps)){
			$emps = new stdClass();
			$emps->total_reg_ytd = 0;
			$emps->total_stat_ytd = 0;
		}
		$total_reg_ytd 		=  	(float)$emps->total_reg_ytd  + ((float)$data['regular_hrs'] * (float)$data['per_hr_rate']);
		$total_stat_ytd 	=   (float)$emps->total_stat_ytd + ((float)$data['stat_hol'] * (float)$data['per_hr_rate']);
		$datas = array(
			'total_reg_ytd' 	=> $total_reg_ytd, 
			'total_stat_ytd' 	=> $total_stat_ytd
		);
		$this->db->where('id', $id);
		$this->db->update('lit_payroll', $datas);
		return true;		
	}

	// // get single employee details
	public function fetchSingleEmp($empid = null, $id = null)
	{
		return $this->db->where('emp_ids',$empid)->where('id <>', $id)->order_by('id', 'DESC')->get('lit_payroll')->row();
	}


	// updateYts
	public function updateYtds($data = null, $id = null)
	{
		$pdf = $this->GetDataForPdf($id);
		$oldytd = $this->oldYtdsforadd($data['emp_ids'], $data['center']);
		$oldytd1 = $this->oldYtds($id);

		if($data['vacation'] == 1){
			$data['vacation'] = $yrDeduction->vacation;
		}
		
		// grosspay 
		$grossPay       = ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ) + ($pdf['emp']->miscellaneous_amount) + ($pdf['emp']->wage_amount + $data['vacation']);
		// Govt Penction
		if($grossPay < $pdf['master']->max_pentionable_earning){
			$gvtPention     =((($grossPay - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution) / 100);
		}else{
			$gvtPention = 0.00;
		}
		// EI contribution
		if($grossPay < $pdf['master']->ei_amt){
			$eiCount        = (($pdf['master']->ei_cont * $grossPay) / 100);
		}else{
			$eiCount = 0.00;
		}

		$fedTax       = ($pdf['master']->fed_tax * $grossPay); // fedl 	Tax
		$vacation     = ($pdf['emp']->vocation_rate * $grossPay); // vacation
		if(!empty($oldytd1->id)){
			$oldytd_before = $this->oldBeforeYtds($data['emp_ids'], $data['center']);
			
			if($oldytd->id == $oldytd_before->id){
				$inserData = array(
					'govt_pen' 	=> (float)$gvtPention,
					'fedl_tax' 	=> (float)$fedTax,
					'ei_count' 	=> (float)$eiCount,
					'vacation' 	=> (float)$data['vacation'],
					'medical'   => (float)$data['medical'],
					'payroll_id'=> $id,
					'empid'		=> $data['emp_ids'],
					'center'	=> $data['center'],
				);
			}else{
				$inserData = array(
					'govt_pen' 	=> (float)$oldytd_before->govt_pen		+ (float)$gvtPention,
					'fedl_tax' 	=> (float)$oldytd_before->fedl_tax 		+ (float)$fedTax,
					'ei_count' 	=> (float)$oldytd_before->ei_count 		+ (float)$eiCount,
					'vacation' 	=> (float)$oldytd_before->vacation 		+ (float)$data['vacation'],
					'medical'   => (float)$oldytd_before->medical      	+ (float)$data['medical'],
					'payroll_id'=> $id,
					'empid'		=> $data['emp_ids'],
					'center'	=> $data['center'],
				);
			}

			$this->db->where('payroll_id', $id)->update('lit_yts', $inserData);
		}else{
			$inserData = array(
				'govt_pen' 	=> (float)$oldytd->govt_pen		+ (float)$gvtPention,
				'fedl_tax' 	=> (float)$oldytd->fedl_tax 	+ (float)$fedTax,
				'ei_count' 	=> (float)$oldytd->ei_count 	+ (float)$eiCount,
				'vacation' 	=> (float)$oldytd->vacation 	+ (float)$data['vacation'],
				'medical'   => (float)$oldytd->medical      + (float)$data['medical'],
				'payroll_id'=> $id,
				'empid'		=> $data['emp_ids'],
				'center'	=> $data['center'],
			);
			$this->db->insert('lit_yts', $inserData);
		}
		
	
		return true;
	}

	// oldytds
	public function oldYtds($id = null)
	{
		// echo $id; exit;
		$query =$this->db->where('payroll_id', $id)->get('lit_yts');
		if($query->num_rows() < 1){
			$query = new stdClass();
			$query->govt_pen = 0;
			$query->fedl_tax = 0;
			$query->ei_count = 0;
			$query->vacation = 0;
			$query->medical  = 0;

			return $query;
		}else{
			return $query->row();
		}		
	}
	public function oldYtdsforadd($id = null, $center = null)
	{
		$query =$this->db->where('empid', $id)->where('center', $center)->order_by('id', 'DESC')->get('lit_yts');
	
		if($query->num_rows() < 1){
			$query = new stdClass();
			$query->govt_pen = 0;
			$query->fedl_tax = 0;
			$query->ei_count = 0;
			$query->vacation = 0;
			$query->medical  = 0;
			return $query;
		}else{
			
			return $query->row();	
		}		
	}

	// old before one
	public function oldBeforeYtds($id = null, $center = null)
	{
		$query =$this->db->where('empid', $id)->where('center', $center)->order_by('id', 'DESC')->get('lit_yts');
	
		if($query->num_rows() < 1){
			$query = new stdClass();
			$query->govt_pen = 0;
			$query->fedl_tax = 0;
			$query->ei_count = 0;
			$query->vacation = 0;
			$query->medical  = 0;
			return $query;
		}else{
			
			return $query->row(1);	
		}		
	}


	
	// get data for genarate pdf
	public function GetDataForPdf($id = null)
	{
		$data['master'] = $this->getMasterDetails();
		$data['emp']	= $this->getEmpDetails($id);

		$empid 		= $data['emp']->emp_ids;
		$endDate 	= $data['emp']->pay_end_date;
		$startDate  = $data['emp']->pay_date;

		$countRow = $this->countRow($empid, $endDate, $startDate);
		
		$totalWages 			= $this->countWages($empid);
		$totalMiscellaneous 	= $this->countMiscellaneous($empid);

		$unitReg  				= $this->countUnitReg($empid, $startDate, $endDate);
		$unitStat  				= $this->countUnitStat($empid, $startDate, $endDate);

		$yhruReg 				= $this->yhruReg($empid , $endDate);
		$yhruStatHol 			= $this->yhruStatHol($empid, $endDate);


		$data['emp']->totalWages 		= $totalWages->wage_amount;
		$data['emp']->tmiscellaneous 	= $totalMiscellaneous->miscellaneous_amount;
		$data['emp']->yhruReg 			= $yhruReg->regular_hrs;
		$data['emp']->yhruStatHol 		= $yhruStatHol->stat_hol;
		if($countRow > 1){
			$data['emp']->regular_hrs 		= $unitReg->regular_hrs;
			$data['emp']->stat_hol 			= $unitStat->stat_hol;
		}
		$data['emp']->total_reg_ytd 	= $unitReg->total_reg_ytd;
		$data['emp']->total_stat_ytd 	= $unitStat->total_stat_ytd;

		return $data;
	}

	// get Master Table
	public function getMasterDetails()
	{
		$year = date('Y');
		return $this->db->where('year', $year)
		->get('lit_master')
		->row();
	}

	// get Emplyee Data
	public function getEmpDetails($id = null)
	{
		return $this->db->where('p.id', $id)
		->select('p.*, e.first_name as fname, e.last_name as lname, e.address1 as address, e.email, e.pincode, e.city, e.phone, e.vocation_rate, e.hour_rate')
		->from('lit_payroll p')
		->join('lit_employee_details e', 'e.emp_id = p.emp_ids', 'left')
		->get()
		->row();
	}

	// count of tottal wages
	public function yhruReg($id = null, $date = null)
	{
		return $this->db->where('emp_ids', $id)
		->where('pay_end_date <=', $date)
		->select_sum('regular_hrs')
		->get('lit_payroll')->row();
	}

	// count of tottal wages
	public function yhruStatHol($id = null, $date = null)
	{
		return $this->db->where('emp_ids', $id)
		->where('pay_end_date <=', $date)
		->select_sum('stat_hol')
		->get('lit_payroll')->row();
	}

	// count of tottal wages
	public function countWages($id = null)
	{
		return $this->db->where('emp_ids', $id)
		->select_sum('wage_amount')
		->get('lit_payroll')->row();
	}

	// count of tottal Micelanice
	public function countMiscellaneous($id = null)
	{
		return $this->db->where('emp_ids', $id)
		->select_sum('miscellaneous_amount')
		->get('lit_payroll')->row();
	}

	// count of Regular unit
	public function countUnitReg($empid = null, $startDate = null, $endDate = null)
	{
		$edate = date('Y-01-01', strtotime($startDate));
		return $this->db->where('emp_ids', $empid)
		->where('pay_date <=', $startDate)
		->where('pay_end_date >=', $edate)
		->select_sum('total_reg_ytd')
		->select_sum('regular_hrs')
		->get('lit_payroll')
		->row();
	}


		// count of stathol unit
	public function countUnitStat($empid = null, $startDate = null, $endDate = null)
	{
		$edate = date('Y-01-01', strtotime($startDate));
		return $this->db->where('emp_ids', $empid)
		->where('pay_date <=', $startDate)
		->where('pay_end_date >=', $edate)
		->select_sum('stat_hol')
		->select_sum('total_stat_ytd')
		->get('lit_payroll')
		->row();;
	}


	// company list
	public function companyList()
	{
		return $this->db->where('status',1)->get('lit_company')->result();
	}

	public function AllYtds($data = null, $id = null)
	{

		$countRow = $this->countRow($data['empid'],  $data['edate'], $data['sdate']);

		if($countRow > 1){
			$dateResult = $this->dateByIds($data);
			foreach ($dateResult as $key => $value) {
				$ytdGet[$key] = $this->ytdGetForPdf($value->id);
			}
			$query = new stdClass();
			$query->govt_pen = 0;
			$query->fedl_tax = 0;
			$query->ei_count = 0;
			$query->vacation = 0;
			$query->medical  = 0;

			foreach ($ytdGet as $key => $values) {
				$query->govt_pen += $values->govt_pen;
				$query->fedl_tax += $values->fedl_tax;
				$query->ei_count += $values->ei_count;
				$query->vacation += $values->vacation;
				$query->medical  += $values->medical;
			}
			return $query;
		}
		else{
			$query =$this->db->where('payroll_id', $id)->get('lit_yts');
			return $query->row();
		}

		
	}


	//  date By ids
	public function dateByIds($data)
	{
		return $this->db->where('emp_ids', $data['empid'])
		->where('pay_date <=', $data['sdate'])
		// ->where('pay_end_date >=', $data['edate'])
		->select('id')
		->get('lit_payroll')
		->result();
	}

	// ytdTotal
	public function ytdGetForPdf($id)
	{
		return  $this->db->where('payroll_id', $id)->get('lit_yts')->row();
	}

	// count of row
	public function countRow($empid, $endDate, $startDate)
	{
		$edate = date('Y-01-01', strtotime($startDate));
		$query =  $this->db->where('emp_ids', $empid)
		->where('pay_date <=', $startDate)
		->where('pay_end_date >=', $endDate)
		->select('id')
		->get('lit_payroll');
		return $query->num_rows();
	}
}
