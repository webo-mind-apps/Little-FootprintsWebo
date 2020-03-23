<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Db_model extends CI_Model 
{  
    
	function employee_details_insert_update()
	{
			
			$company = $_POST['company_name'];		
			$id=$_POST['emp_id'];
			$employeeId = $_POST['employeeId'];
			$first_name=$_POST['first_name'];
			$last_name=$_POST['last_name'];
			$empsin=$_POST['empsin1']."-".$_POST['empsin2']."-".$_POST['empsin3'];
			$dob=$_POST['dob'];
			$address1=$_POST['address1'];
			$address2=$_POST['address2'];
			$city=$_POST['city'];
			$pincode=$_POST['pincode'];
			$phone=$_POST['phone'];
			$phone_code=$phone;
			$email=$_POST['email'];
			$hire_date=$_POST['hire_date'];
			$rehire_date=$_POST['rehire_date'];
			$empcert=$_POST['empcert'];
			$hour_rate=$_POST['hour_rate'];
			$position=$_POST['position'];
			$medical=$_POST['medical'];
			$medical_contr =$_POST['medical_contr'];
			$vocation_rate=$_POST['vocation_rate'];
			$status=$_POST['status'];
			if(empty($employeeId)){
				$this->db->select(array("emp_id"));
				$this->db->from("lit_employee_details");
				$this->db->order_by("id", "desc");
				$this->db->limit(1);
				$query=$this->db->get();
				$row=$query->result_array(); 
				$emp_id=$row[0]['emp_id'];
				$emp_id_increment=$emp_id+1;
				if($emp_id<9)
				{
					$emp_new_id="00".$emp_id_increment;
				}
				else if($emp_id<99)
				{
					$emp_new_id="0".$emp_id_increment;
				}
				else if($emp_id>=99)
				{
					$emp_new_id=$emp_id_increment;
				}
			}else{
				$emp_new_id = $employeeId;
			}
				
				if(isset($_POST['center'])){
					$this->db->where('empid', $emp_new_id)->delete('emp_center');
					$center = $_POST['center'];
					foreach ($center as $key => $value) {
						$centerData = array('empid' => $emp_new_id, 'center' => $value);
						$this->employeeCenter($centerData);
					}
				}
				
				$data = array('company'=> $company , 'medical_contribution' => $medical_contr,  'emp_id' =>$emp_new_id,'first_name' =>$first_name,'last_name' =>$last_name,'empsin' =>$empsin,'dob' =>$dob,'address1' =>$address1,'address2' =>$address2,'city' =>$city,'pincode' =>$pincode,'phone' =>$phone_code,'email' =>$email,'hire_date' =>$hire_date,'rehire_date' =>$rehire_date,'empcert' =>$empcert,'hour_rate' =>$hour_rate,'emp_position' =>$position,'medical' =>$medical,'vocation_rate' =>$vocation_rate,'status' =>$status);
				
		if(isset($_POST['insert_button']))
		{
		 if($this->db->insert('lit_employee_details',$data))
		 {
			$this->session->set_flashdata('insert','Inserted successfully');
			 return true;
		 }
		 
		}
		
		if(isset($_POST['update_button']))
		{
		 $this->db->where(array('id'=>$id));
		 if($this->db->update('lit_employee_details',$data))
		 {
			$this->session->set_flashdata('update','Updated successfully');
			return true ;
		 }
		 
		}
	}

	public function employeeCenter($data)
	{
		$this->db->insert('emp_center', $data);
		return true;
	}

	function lit_employee_details_fetch()
	{
		$this->db->select('a.*,b.position,b.id as pos_id, c.name as company_name');
		$this->db->from('lit_employee_details a');
		$this->db->join('lit_employee_position b','a.emp_position = b.id','left');
		$this->db->join('lit_company c','c.id = a.company','left');
		$this->db->order_by('a.id', 'desc');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	
	
	public function empCenters()
	{
		$id=$this->uri->segment(3);
		$this->db->select('c.*');
		$this->db->from('lit_employee_details e');
		$this->db->where('e.id',$id);
		$this->db->join('emp_center ec', 'ec.empid = e.emp_id', 'left');
		$this->db->join('lit_center c', 'c.id = ec.center', 'left');
		return $this->db->get()->result();
		
	}

	function employee_details_fetch_for_update()
	{
		$id=$this->uri->segment(3);
		$this->db->select('a.*,b.position,b.id as pos_id');
		$this->db->from('lit_employee_details a');
		$this->db->join('lit_employee_position b','a.emp_position = b.id','left');
		$this->db->where('a.id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	
	
	function lit_employee_position_fetch()
	{
		$this->db->select('*');
		$this->db->from('lit_employee_position');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	
	
	function employee_details_delete($id)
	{
		$this->db->where(array('id'=>$id));
		$this->db->delete('lit_employee_details');
	
	}
	
	function employee_insert_excel_model()
	{
	$this->db->insert_batch('lit_employee_details',$data);
	}
	function emp_pension_insert()
	{
			$year=$_POST['year'];
			$basic_exemption_amt=$_POST['basic'];
			$emp_contribution=$_POST['emp_contn'];
			$max_pentionable_earning=$_POST['annual'];
			$data = array('year' =>$year,'basic_exemption_amt' =>$basic_exemption_amt,'emp_contribution' =>$emp_contribution,'max_pentionable_earning' =>$max_pentionable_earning);
			
			$this->db->select('year');
			$this->db->from('lit_master');
			$this->db->where('year',$year);
			$query=$this->db->get();
			$result="";
			$result=$query->result_array();

			if($result)
			{
				$this->db->where(array('year'=>$year));
				if($this->db->update('lit_master',$data))
				 {
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
				
			}
			else
			{
				
				 if($this->db->insert('lit_master',$data))
				 {
					 
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
			}
	}
	function emp_pension_fetch()
	{
		$this->db->select('id,year,basic_exemption_amt,emp_contribution,max_pentionable_earning');
		$this->db->from('lit_master');
		$this->db->order_by('id', 'desc');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	

	function employee_pension_delete($id)
	{
		
		$data = array('basic_exemption_amt' =>NULL,'emp_contribution' =>NULL,'max_pentionable_earning' =>NULL);
		$this->db->where(array('id'=>$id));
		$this->db->update('lit_master',$data);
	}

	function employee_pension_fetch_for_update()
	{
		$id=$this->uri->segment(3);
		$this->db->select('id,year,basic_exemption_amt,emp_contribution,max_pentionable_earning');
		$this->db->from('lit_master');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	



	function emp_pension_update()
	{
			$id=$_POST['emp_id'];
			$year=$_POST['year'];
			$basic_exemption_amt=$_POST['basic'];
			$emp_contribution=$_POST['emp_contn'];
			$max_pentionable_earning=$_POST['annual'];
			$data = array('year' =>$year,'basic_exemption_amt' =>$basic_exemption_amt,'emp_contribution' =>$emp_contribution,'max_pentionable_earning' =>$max_pentionable_earning);
			
			
				$this->db->where(array('id'=>$id));
				if($this->db->update('lit_master',$data))
				 {
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
			

	}



function emp_federal_fetch()
{
	$this->db->select('id,fed_tax,year');
	$this->db->from('lit_master');
	$this->db->order_by('id', 'desc');
	$query=$this->db->get();
	$result=$query->result_array();
	return $result;
}	

function emp_federal_insert()
	{
			$year=$_POST['year'];
			$federal=$_POST['federal'];
			
			$data = array('year' =>$year,'fed_tax' =>$federal);
			
			$this->db->select('year');
			$this->db->from('lit_master');
			$this->db->where('year',$year);
			$query=$this->db->get();
			$result="";
			$result=$query->result_array();

			if($result)
			{
				$this->db->where(array('year'=>$year));
				if($this->db->update('lit_master',$data))
				 {
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
				
			}
			else
			{
				
				 if($this->db->insert('lit_master',$data))
				 {
					 
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
			}
	}


	
	function emp_federal_update()
	{
			$id=$_POST['emp_id'];
			$year=$_POST['year'];
			$federal=$_POST['federal'];
			$data = array('year' =>$year,'fed_tax' =>$federal);
			
			
				$this->db->where(array('id'=>$id));
				if($this->db->update('lit_master',$data))
				 {
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
			

	}

	function employee_federal_delete($id)
	{
		
		$data = array('fed_tax' =>NULL);
		$this->db->where(array('id'=>$id));
		$this->db->update('lit_master',$data);
	}

	function employee_federal_fetch_for_update()
	{
		$id=$this->uri->segment(3);
		$this->db->select('id,year,fed_tax');
		$this->db->from('lit_master');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	
	


	function ei_contribution()
{
	$this->db->select('id,year,ei_cont,ei_amt');
	$this->db->from('lit_master');
	$this->db->order_by('id', 'desc');
	$query=$this->db->get();
	$result=$query->result_array();
	return $result;
}	

function emp_ei_insert()
	{
	
		$year=$_POST['year'];
		$ei_cont=$_POST['ei_contn'];
		$ei_amt=$_POST['ei_amt'];
		$data = array('year' =>$year,'ei_cont' =>$ei_cont,'ei_amt' =>$ei_amt);
			
			$this->db->select('year');
			$this->db->from('lit_master');
			$this->db->where('year',$year);
			$query=$this->db->get();
			$result="";
			$result=$query->result_array();

			if($result)
			{
				$this->db->where(array('year'=>$year));
				if($this->db->update('lit_master',$data))
				 {
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
				
			}
			else
			{
				
				 if($this->db->insert('lit_master',$data))
				 {
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
			}
	}


	
	function emp_ei_update()
	{
			$id=$_POST['emp_id'];
			$year=$_POST['year'];
			$ei_cont=$_POST['ei_contn'];
			$ei_amt=$_POST['ei_amt'];
			$data = array('year' =>$year,'ei_cont' =>$ei_cont,'ei_amt' =>$ei_amt);
			
			
				$this->db->where(array('id'=>$id));
				if($this->db->update('lit_master',$data))
				 {
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
			

	}

	function employee_ei_delete($id)
	{
		
		$data = array('ei_cont' =>NULL,'ei_amt' =>NULL);
		$this->db->where(array('id'=>$id));
		$this->db->update('lit_master',$data);
	}

	function employee_ei_fetch_for_update()
	{
		$id=$this->uri->segment(3);
		$this->db->select('id,year,ei_cont,ei_amt');
		$this->db->from('lit_master');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	
	function company_master()
	{
		$this->db->select('*');
		$this->db->from('lit_company');
		$this->db->order_by('id', 'desc');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	

	function company_master_delete($id)
	{
		
		$this->db->where(array('id'=>$id));
		$this->db->delete('lit_company');
	}

	function company_master_fetch_for_update()
	{
		$id=$this->uri->segment(3);
		$this->db->select('*');
		$this->db->from('lit_company');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	


	function company_master_insert()
	{
	
		$company_name	= $_POST['comp_name'];
		$at_num			= $_POST['at_num'];
		$num_pay		= $_POST['num_pay'];
		$issuer			= $_POST['issuer'];
		$phone			= $_POST['phone'];
		$address			= $_POST['address'];
		$data = array(
			'name' 			=>$company_name,
			'ac_num' 		=>$at_num, 
			'no_pay_period' => $num_pay,
			'isser' 		=> $issuer,
			'phone' 		=> $phone,
			'address' 		=> $address,
		);
			
				 if($this->db->insert('lit_company',$data))
				 {
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
		
	}
	function company_master_update()
	{
		$id=$_POST['emp_id'];
		$company_name	= $_POST['comp_name'];
		$at_num			= $_POST['at_num'];
		$num_pay		= $_POST['num_pay'];
		$issuer			= $_POST['issuer'];
		$phone			= $_POST['phone'];
		$address			= $_POST['address'];
		$data = array(
			'name' 			=>$company_name,
			'ac_num' 		=>$at_num, 
			'no_pay_period' => $num_pay,
			'isser' 		=> $issuer,
			'phone' 		=> $phone,
			'address' 		=> $address,
		);
		$this->db->where(array('id'=>$id));
			
				 if($this->db->update('lit_company',$data))
				 {
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
		
	}

	

	function center_master()
	{
		$this->db->select('a.*,b.*,b.id as cen_id');
		$this->db->from('lit_company a');
		$this->db->join('lit_center b','a.id = b.company_name','right');
		$this->db->order_by('b.id', 'desc');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	

	function center_master_delete($id)
	{
		
		$this->db->where(array('id'=>$id));
		$this->db->delete('lit_center');
	}

	function center_master_fetch_for_update()
	{
		$id=$this->uri->segment(3);
		$this->db->select('*');
		$this->db->from('lit_center');
		$this->db->where('id',$id);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
	}	


	function center_master_insert()
	{
		$company_name=$_POST['company_name'];
		$center_name=$_POST['center_name'];
		$data = array('company_name' =>$company_name,'center_name' =>$center_name);
			
				 if($this->db->insert('lit_center',$data))
				 {
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
		
	}
	function center_master_update()
	{
		$id=$_POST['emp_id'];
		$company_name=$_POST['company_name'];
		$center_name=$_POST['center_name'];
		$data = array('company_name' =>$company_name,'center_name' =>$center_name);
			
		$this->db->where(array('id'=>$id));
			
				 if($this->db->update('lit_center',$data))
				 {
			
					 return true;
				 }
				 else
		 		{
			 		return false;
				 }
	}



	function center_select_feild($id)
	{
		return $this->db->where('company_name', $id)
		->get('lit_center')->result_array();
	}	

	
}