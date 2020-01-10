
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

	function select_where_employee_details($sdate, $edate){ 
		$result = $this->db->get('lit_employee_details') ->result();
		foreach ($result as $key => $value) {
			$value->payRoll = $this->getPayRoll($value->emp_id, $sdate, $edate);
		}
		return $result;
	}

	// Get payriol detils
	public function getPayRoll($id = null, $sdate = null, $edate = null)
	{
		return $this->db->where('pay_date >=', $sdate)
		->where('pay_date <=', $edate)	
		->where('emp_ids', $id)
		->get('lit_payroll')->row();
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
		return true;
	}

	public function inserPayroll($data = null, $sDate = null , $eDate = null)
	{
		$data = array_merge($data, array('pay_date' => $sDate, 'pay_end_date' => $eDate));
		$this->db->insert('lit_payroll', $data);
		$id = $this->db->insert_id();
		$this->updateYtd($id, $data, $data['emp_ids']);
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
		$total_reg_ytd 		=  	(int)$emps->total_reg_ytd  + (int)$data['regular_hrs'];
		$total_stat_ytd 	=   (int)$emps->total_stat_ytd + (int)$data['stat_hol'];
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

	// get data for genarate pdf
	public function GetDataForPdf($id)
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

}

?>