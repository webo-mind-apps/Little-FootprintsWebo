
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

	// update Payment 
	public function updatePayrolls($data = null, $sDate = null , $eDate = null)
	{
		$query = $this->db->where('pay_date >=', $sDate)
		->where('pay_date <=', $eDate)	
		->where('emp_ids', $data['emp_ids'])
		->get('lit_payroll');

		if($query->num_rows() > 0):
			$this->updatePayrollByid($data);
		else:
			$this->inserPayroll($data, $sDate , $eDate);
		endif;
		return true;
	}

	public function updatePayrollByid($data = null)
	{
		$this->db->where('emp_ids', $data['emp_ids'])->update('lit_payroll', $data);
		return true;
	}

	public function inserPayroll($data = null, $sDate = null , $eDate = null)
	{
		$data = array_merge($data, array('pay_date' => $sDate, 'pay_end_date' => $eDate));
		$this->db->insert('lit_payroll', $data);
		return true;
	}

}

?>