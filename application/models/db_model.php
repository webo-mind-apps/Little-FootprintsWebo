<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Db_model extends CI_Model 
{  
    
	function employee_details_insert_update()
	{
				$id=$_POST['emp_id'];
				$first_name=$_POST['first_name'];
				$last_name=$_POST['last_name'];
				$empsin=$_POST['empsin1']."-".$_POST['empsin2']."-".$_POST['empsin3'];
				$dob=$_POST['dob'];
				$address1=$_POST['address1'];
				$address2=$_POST['address2'];
				$city=$_POST['city'];
				$pincode=$_POST['pincode'];
				$code=$_POST['code'];
				$phone=$_POST['phone'];
				$phone_code=$code."-".$phone;
				$email=$_POST['email'];
				$hire_date=$_POST['hire_date'];
				$rehire_date=$_POST['rehire_date'];
				$empcert=$_POST['empcert'];
				$hour_rate=$_POST['hour_rate'];
				$position=$_POST['position'];
				$medical=$_POST['medical'];
				$vocation_rate=$_POST['vocation_rate'];
				$status=$_POST['status'];
				
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
				
				
				$data = array('emp_id' =>$emp_new_id,'first_name' =>$first_name,'last_name' =>$last_name,'empsin' =>$empsin,'dob' =>$dob,'address1' =>$address1,'address2' =>$address2,'city' =>$city,'pincode' =>$pincode,'phone' =>$phone_code,'email' =>$email,'hire_date' =>$hire_date,'rehire_date' =>$rehire_date,'empcert' =>$empcert,'hour_rate' =>$hour_rate,'emp_position' =>$position,'medical' =>$medical,'vocation_rate' =>$vocation_rate,'status' =>$status);
				
		if(isset($_POST['insert_button']))
		{
		 if($this->db->insert('lit_employee_details',$data))
		 {
			 return "Inserted-successfully";
		 }
		 else
		 {
			 return "Inserted-failed";
		 }	
		}
		
		if(isset($_POST['update_button']))
		{
		 $this->db->where(array('id'=>$id));
		 if($this->db->update('lit_employee_details',$data))
		 {
			return "Updated-successfully";
		 }
		 else
		 {
			 return "Updated-failed";
		 }
		}
	}
	function lit_employee_details_fetch()
	{
		$this->db->select('a.*,b.position,b.id as pos_id');
		$this->db->from('lit_employee_details a');
		$this->db->join('lit_employee_position b','a.emp_position = b.id','left');
		$this->db->order_by('a.id', 'desc');
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;
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
}
?>