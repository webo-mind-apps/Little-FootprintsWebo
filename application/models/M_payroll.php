<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class M_payroll extends CI_Model {

    // company list
	public function companyList()
	{
		return $this->db->where('status',1)->get('lit_company')->result();
    }
    
    // employee data by date
    public function employeeDetailDate($sdate = null, $edate = null, $company = null, $center = null, $date = null)
    {
        
        $result = $this->db
		->where('e.status', 0)
		->order_by('e.first_name', 'asc')
		->select('e.*')
		->from('lit_employee_details e')
		->join('emp_center c', 'c.empid = e.emp_id', 'left')
		->where('e.company', $company)
		->where('c.center', $center)
		->get()
		->result();
		
		
		foreach ($result as $key => $value) {
			$value->payRoll = $this->getPayRoll($value->emp_id, $sdate, $edate, $company, $center, $date);
        }
       
        return $result;
    }

    public function getPayRoll($empid = null, $sdate= null, $edate = null, $company = null, $center = null, $date = null)
    {
        $year = date('Y', strtotime($sdate));
        
        if (!empty($date)) {
            $dates = date('Y-m-d 1:00:00', strtotime($date));
            $datee = date('Y-m-d 23:59:00', strtotime($date));
            $this->db->where('created_on >=', $dates);
            $this->db->where('created_on <=', $datee);
        }
        return $this->db->from('lit_payroll_root r')
        ->select('r.*, p.reg_unit, p.stat_unit, p.wages, p.miscellaneous, p.medical, p.rate')
        ->where('r.empid', $empid)
        ->where('r.start_on >=', $sdate)
        ->where('r.end_on <=', $edate)
        ->where('r.year', $year)
        ->where('p.company ', $company)
        ->where('p.center ', $center)
        ->join('lit_payroll p', 'p.root_id = r.id', 'left')
        ->get()
        ->row();
    }

    // Save payroll Details
    public function savePayroll($data = null, $sDate = null, $eDate = null, $pid = null)
    {
        if(empty($pid)){
            $pid = $this->insertPayroll($data);
        }
        $this->insertPayroll($data);
        $master = $this->getMasterDetails($data['pay_start']);
        $rates  = $this->calculateData($data, $master, $pid);
        $this->updatePayroll($rates); 
        
    }

    // insert data in to master table
    public function insertPayroll($data = null)
    {
        
       
        $year = date('Y', strtotime($data['pay_start']));
        $newArray = array(
            'empid'     => $data['emp_ids'], 
            'start_on'  => $data['pay_start'], 
            'end_on'    => $data['pay_end'], 
            'year'      => $year, 
            'is_vacation' => $data['is_vacation_release'],
            'created_on'   => $data['created_on']
        );
        $this->db->where('empid', $newArray['empid']);
        $this->db->where('start_on', $newArray['start_on']);
        $this->db->where('end_on', $newArray['end_on']);
        $this->db->where('year', $newArray['year']);
        $query = $this->db->get('lit_payroll_root');
        
        if($query->num_rows() > 0){
            $pid =  $query->row()->id;
            $this->db->where('empid', $newArray['empid']);
            $this->db->where('start_on', $newArray['start_on']);
            $this->db->where('end_on', $newArray['end_on']);
            $this->db->where('year', $newArray['year']);
            $this->db->update('lit_payroll_root', $newArray);
            return $pid;
            
        }else{
            $this->db->insert('lit_payroll_root', $newArray);
            return $this->db->insert_id();
        }
        
    }

    // calculate the rates and amount
    public function calculateData($data = null , $master = null, $pid = null)
    {
        $numpay = $this->db->where('id', $data['company'])->select('no_pay_period')->get('lit_company')->row()->no_pay_period;
        
        $rates = (object) array(
            'reg_unit'      => 0 , 
            'stat_unit'     => 0 , 
            'reg_amt'       => 0 , 
            'stat_amt'      => 0 , 
            'wages'         => 0 , 
            'miscellaneous' => 0 , 
            'rate'          => 0 , 
            'govt_pen'      => 0 , 
            'fedl'          => 0 , 
            'eicount'       => 0 , 
            'medical'       => 0 , 
            'vacation'      => 0 , 
            'is_vacation'   => 0 , 
            'root_id'       => 0 , 
            'center'        => 0 , 
            'company'       => 0 , 
            'emp_id'        => 0 ,
            'medical_contribution'  => 0 ,

        );


        $rates->reg_unit        =  $data['reg_rate'];
        $rates->stat_unit       =  $data['stat_rate'];
        $rates->rate            =  $data['per_hr_rate'];
        $rates->wages           =  $data['wages'];
        $rates->miscellaneous   =  $data['miscellaneous'];
        $rates->is_vacation     =  $data['is_vacation_release'];
        $rates->medical_contribution =  $data['medical_contribution'];

        $rates->root_id         =  $pid;
        $rates->center          =  $data['center'];
        $rates->company         =  $data['company'];
        $rates->emp_id          =  $data['emp_ids'];

        $rates->reg_amt   = (float)$rates->reg_unit  * (float)$rates->rate;
        $rates->stat_amt  = (float)$rates->stat_unit * (float)$rates->rate;

        $gross = (float)$rates->reg_amt + (float)$rates->stat_amt + (float)$rates->wages + (float)$rates->miscellaneous + (float)$rates->medical_contribution; 
        
        $rates->vacation = (float)$gross * (float)$data['vacation'];
        if($rates->is_vacation):
            $gross =  $gross +  $rates->vacation;
        endif;
        if($gross > 0 ){
            $rates->fedl     = (float)$gross * (float)$master->fed_tax;
            $rates->medical  = $data['medical'];
        }else
        {
            $rates->fedl = 0; $rates->medical  = 0;
        }
        
        
        if($gross <= $master->max_pentionable_earning && $gross > 0):
			$rates->govt_pen    = ((((float)$gross - ((float)$master->basic_exemption_amt / (float)$numpay)) * (float)$master->emp_contribution) / 100);
        else:
			$rates->govt_pen    = 0;
        endif;

        if($gross < $master->ei_amt && $gross > 0):
			$rates->eicount = (((float)$master->ei_cont * (float)$gross) / 100);
		else:
			$rates->eicount = 0;
        endif;

        return $rates;
    }

    // update Data
    public function updatePayroll($data = null)
    {
        $insert  = json_decode(json_encode($data), true);
        $this->db->where('emp_id' , $data->emp_id);
        $this->db->where('company', $data->company);
        $this->db->where('center' , $data->center);
        $this->db->where('root_id', $data->root_id);
        $query = $this->db->get('lit_payroll');
        
        if($query->num_rows() > 0):
            $this->db->where('emp_id' , $data->emp_id);
            $this->db->where('company', $data->company);
            $this->db->where('center' , $data->center);
            $this->db->where('root_id', $data->root_id);
            $this->db->update('lit_payroll', $insert);
        else:
            $this->db->insert('lit_payroll', $insert);
        endif;
        return true;
    }

    public function getMasterDetails($date = null)
	{
		$year = date('Y', strtotime($date));
		return $this->db->where('year', $year)
		->get('lit_master')
		->row();
    }

    // Get Employee Details
    public function getEmpDetail($id = null)
    {
        return  $this->db->where('emp_id', $id)->select('medical,medical_contribution, hour_rate, vocation_rate')->get('lit_employee_details')->row();
    }


    // for sample pdf
    public function sampleFormate($company = null, $center = null)
    {
        return $this->db
		->where('e.status', 0)
		->order_by('e.first_name', 'asc')
		->select('e.*')
		->from('lit_employee_details e')
		->join('emp_center c', 'c.empid = e.emp_id', 'left')
		->where('e.company', $company)
		->where('c.center', $center)
		->get()
		->result();
    }

   

 }

/* End of file M_payroll.php */
