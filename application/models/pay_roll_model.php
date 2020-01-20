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
		$result = $this->db
		->where('status', 0)
		->order_by('id', 'asc')
		->get('lit_employee_details')
		->result();
		
		
		foreach ($result as $key => $value) {
			$value->payRoll = $this->getPayRoll($value->emp_id, $sdate, $edate, $company, $center);
		}
		
		return $result;
	}

	// Get payriol detils
	public function getPayRoll($id = null, $sdate = null, $edate = null, $company = null, $center = null)
	{
		// if(!empty($company)){
		// 	$this->db->where('e.company');
		// 	if (!empty($center)) {
		// 		# code...
		// 	}
		// }
		
		$this->db->from('lit_payroll p');
		$this->db->select('p.*');
		$this->db->join('lit_employee_details e', 'e.emp_id = p.emp_ids', 'left');
		return $this->db->where('p.pay_date >=', $sdate)
		->where('p.pay_date <=', $edate)	
		->where('p.emp_ids', $id)
		->order_by('id', 'DESC')
		->get()->row();
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
		$this->db->where('emp_ids', $data['emp_ids'])->update('lit_payroll', $data);
		$this->updateYtd($id, $data, $data['emp_ids']);
		$this->updateYtds($data['emp_ids'], $data['medical'], $id);
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
		$this->updateYtds($data['emp_ids'], $data['medical'], $id);
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
	public function updateYtds($empid = null, $medical = 0,  $id = null)
	{
		$pdf = $this->GetDataForPdf($id);
		$oldytd = $this->oldYtdsforadd($empid);
		$oldytd1 = $this->oldYtds($id);

		// grosspay 
		$grossPay       = ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ) + ($pdf['emp']->miscellaneous_amount) + ($pdf['emp']->wage_amount);
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
			$inserData = array(
				'govt_pen' 	=> (float)$gvtPention,
				'fedl_tax' 	=> (float)$fedTax,
				'ei_count' 	=> (float)$eiCount,
				'vacation' 	=> (float)$vacation,
				'payroll_id'=> $id,
				'empid'		=> $empid,
				'medical'   => (float)$medical
			);
		}else{
			$inserData = array(
				'govt_pen' 	=> (float)$oldytd->govt_pen		+ (float)$gvtPention,
				'fedl_tax' 	=> (float)$oldytd->fedl_tax 	+ (float)$fedTax,
				'ei_count' 	=> (float)$oldytd->ei_count 	+ (float)$eiCount,
				'vacation' 	=> (float)$oldytd->vacation 	+ (float)$vacation,
				'medical'   => (float)$oldytd->medical     + (float)$medical,
				'payroll_id'=> $id,
				'empid'		=> $empid,
			);
		}
		
		if(!empty($oldytd1->id)){
		
			$this->db->where('payroll_id', $id)->update('lit_yts', $inserData);
		}else{
			
			$this->db->insert('lit_yts', $inserData);
		}
		return true;
	}

	// oldytds
	public function oldYtds($id = null)
	{
		$query =$this->db->where('payroll_id', $id)->get('lit_yts');
		if($query->num_rows() < 1){
			$query = new stdClass();
			$query->govt_pen = 0;
			$query->fedl_tax = 0;
			$query->ei_count = 0;
			$query->vacation = 0;
			return $query;
		}else{
			return $query->row();	
		}		
	}
	public function oldYtdsforadd($id = null)
	{
		$query =$this->db->where('empid', $id)->order_by('id', 'DESC')->get('lit_yts');
	
		if($query->num_rows() < 1){
			$query = new stdClass();
			$query->govt_pen = 0;
			$query->fedl_tax = 0;
			$query->ei_count = 0;
			$query->vacation = 0;
			return $query;
		}else{
			
			return $query->row();	
		}		
	}


	
	// get data for genarate pdf
	public function GetDataForPdf($id = null)
	{
		$data['master'] = $this->getMasterDetails();
		$data['emp']	= $this->getEmpDetails($id);
		$totlaWages 	= $this->countWages($data['emp']->emp_ids);
		$toatalMiscellaneous =  $this->countMiscellaneous($data['emp']->emp_ids);
		$data['emp']->totalWages = $totlaWages->wage_amount;
		$data['emp']->tmiscellaneous = $toatalMiscellaneous->miscellaneous_amount;

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

	// company list
	public function companyList()
	{
		return $this->db->where('status',1)->get('lit_company')->result();
	}
}
