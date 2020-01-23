<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class M_payroll extends CI_Model {

    // company list
	public function companyList()
	{
		return $this->db->where('status',1)->get('lit_company')->result();
    }
    
    // employee data by date
    public function employeeDetailDate($sdate = null, $edate = null, $company = null, $center = null)
    {
        $result = $this->db
		->where('e.status', 0)
		->order_by('e.id', 'asc')
		->select('e.*')
		->from('lit_employee_details e')
		->join('emp_center c', 'c.empid = e.emp_id', 'left')
		->where('e.company', $company)
		->where('c.center', $center)
		->get()
		->result();
		
		
		foreach ($result as $key => $value) {
			$value->payRoll = $this->getPayRoll($value->emp_id, $sdate, $edate, $company, $center);
		}
        return $result;
    }

    public function getPayRoll($empid = null, $sdate= null, $edate = null, $company = null, $center = null)
    {
        $this->db->from('lit_employee_details e');
        $this->db->join('paystub  p', 'p.emp_ids = e.emp_id', 'left');
        $this->db->where('p.company', $company);
        $this->db->where('p.emp_ids', $empid);
        $this->db->where('p.center', $center);
        $this->db->where('p.pay_start >=', $sdate);
        $this->db->where('p.pay_end <=', $edate);
        $this->db->order_by('id', 'desc');
        $this->db->select('e.first_name, e.last_name, e.hour_rate, e.medical, e.vocation_rate, p.per_hr_rate, p.emp_ids, p.id, p.stat_rate, p.reg_rate, p.wages, p.miscellaneous, p.is_vacation_release');
        return $this->db->get()->row();
    }

    // Save payroll Details
    public function savePayroll($data = null, $sDate = null, $eDate = null, $pid = null)
    {
        if(empty($pid)){
            $pid = $this->insertPayroll($data);
        }
        $this->updatePayroll($data, $pid);
    }

    // insert Payroll
    public function insertPayroll($data = null)
    {
        $this->db->insert('paystub', $data);
        return $this->db->insert_id();
    }

    // update Payroll
    public function updatePayroll($data = null, $pid = null)
    {
        
       
        $oldData = $this->db->where('emp_ids',$data['emp_ids'])
        ->where('id <>', $pid)
        ->order_by('id', 'desc')
        ->get('paystub')
        ->row_array();

            
       
        if(!empty($oldData)){
            $oldData = $this->PdfGet($oldData['emp_ids'], $oldData['pay_start'], $oldData['pay_end']);
        }

        $master = $this->getMasterDetails($data['pay_end']);
        if(empty($oldData)){
            $oldData['reg_amt']             = 0;
            $oldData['stat_amt']            = 0;
            $oldData['reg_unit']            = 0;
            $oldData['stat_unit']           = 0;
            $oldData['reg_ytd']             = 0;
            $oldData['stat_ytd']            = 0;
            $oldData['wages_ytd']           = 0;
            $oldData['miscellaneous_ytd']   = 0;
            $oldData['vacation_release']    = 0;
            $oldData['govt_pen']            = 0;
            $oldData['fedl']                = 0;
            $oldData['eicount']             = 0;
            $oldData['govt_pen_ytd']        = 0;
            $oldData['fedl_ytd']            = 0;
            $oldData['eicount_ytd']         = 0;
            $oldData['medical_ytd']         = 0;
            $oldData['gross']               = 0;
            $oldData['gross_ytd']           = 0;
            $oldData['net']                 = 0;
            $oldData['net_ytd']             = 0;
        }

        $oldData['per_hr_rate']         = $data['per_hr_rate'];
        $oldData['reg_rate']            = $data['reg_rate'];
        $oldData['stat_rate']           = $data['stat_rate'];
        $oldData['wages']               = $data['wages'];
        $oldData['miscellaneous']       = $data['miscellaneous'];
        $oldData['vacation']            = $data['vacation'];
        $oldData['medical']             = $data['medical'];
        $oldData['is_vacation_release'] = $data['is_vacation_release'];

        $grossVacation = 0;
        $grossVacationytd = 0;
        // if($oldData['is_vacation_release'] == 1){
        //     $grossVacationytd = $oldData['vacation_release'] + $data['vacation'];
        //     $grossVacation = $data['vacation'];
        // }

        $reg_amt        = $oldData['per_hr_rate'] * $oldData['reg_rate'];   // reg amount
        $reg_unit       = $oldData['reg_rate'] + $oldData['reg_unit'];      // Reg YTD HRS/UNITS
        $reg_ytd        = $oldData['reg_ytd'] + $reg_amt;                   // reg ytd

        $stat_amt       = $oldData['per_hr_rate'] * $oldData['stat_rate'];  // stat hol amount
        $stat_unit      = $oldData['stat_rate'] + $oldData['stat_unit'];    // stat hol YTD HRS/UNITS
        $stat_ytd       = $oldData['stat_ytd'] + $stat_amt;                 // stat hol ytd

        $wages_ytd      = $oldData['wages_ytd'] + $data['wages'];            // wages ytd
        $miscellaneous_ytd = $oldData['miscellaneous_ytd'] + $data['miscellaneous']; // Miscellaneous Ytd



        $gross          = $reg_amt + $stat_amt + $data['wages'] + $data['miscellaneous'] + $grossVacation; // Gross pay
        $gross_ytd      = $reg_ytd + $stat_ytd + $wages_ytd + $miscellaneous_ytd + $grossVacationytd;  // Gross ytd

        $fedl               = ($master->fed_tax * $gross);                              // fedl Tax
        $fedl_ytd = $fedl + $oldData['fedl_ytd'];

        $vacation_release   = $oldData['vacation_release'] + ($data['vacation'] *  $gross);
        $vacation       = ($data['vacation'] *  $gross);                                            // vacation
        $medical_ytd = $oldData['medical_ytd'] + $data['medical'];
        
        //  govt Penction
        if($gross < $master->max_pentionable_earning){
			$govt_pen    = ((($gross - ($master->basic_exemption_amt / $master->no_pay_period)) * $master->emp_contribution) / 100);
		}else{
			$govt_pen = 0;
        }

        $govt_pen_ytd = $govt_pen + $oldData['govt_pen_ytd'];
        
        // EI contribution
		if($gross < $master->ei_amt){
			$eicount = (($master->ei_cont * $gross) / 100);
		}else{
			$eicount = 0;
        }
        $eicount_ytd = $oldData['eicount_ytd'] + $eicount;

        $newdata = array(
            'reg_amt'               => $reg_amt,
            'reg_unit'              => $reg_unit,
            'reg_ytd'               => $reg_ytd,
            'stat_amt'              => $stat_amt,
            'stat_unit'             => $stat_unit,
            'stat_ytd'              => $stat_ytd,
            'wages_ytd'             => $wages_ytd,
            'miscellaneous_ytd'     => $miscellaneous_ytd,
            'gross'                 => $gross,
            'gross_ytd'             => $gross_ytd,
            'fedl'                  => $fedl,
            'vacation_release'      => $vacation_release,
            'govt_pen'              => $govt_pen,
            'eicount'               => $eicount,
            'fedl_ytd'              => $fedl_ytd,
            'medical_ytd'           => $medical_ytd,
            'govt_pen_ytd'          => $govt_pen_ytd,
            'eicount_ytd'           => $eicount_ytd,
            'per_hr_rate'           => $oldData['per_hr_rate'],        
            'reg_rate'              => $oldData['reg_rate'],          
            'stat_rate'             => $oldData['stat_rate'],         
            'wages'                 => $oldData['wages'],             
            'miscellaneous'         => $oldData['miscellaneous'],     
            'vacation'              => $vacation,           
            'medical'               => $oldData['medical'],            
            'is_vacation_release'   => $oldData['is_vacation_release'],

        );

        $this->db->where('id', $pid);
        $this->db->update('paystub', $newdata);
        return true;
        
    }

    public function getMasterDetails($date = null)
	{
		$year = date('Y', strtotime($date));
		return $this->db->where('year', $year)
		->get('lit_master')
		->row();
    }
    
    public function PdfGet($empid = null, $sdate = null, $edate = null)
    {
        $this->db->from('paystub p');
        $this->db->join('lit_employee_details  e', 'e.emp_id = p.emp_ids', 'left');
        
        $this->db->where('p.emp_ids', $empid);
        $this->db->where('p.pay_start >=', $sdate);
        $this->db->where('p.pay_end <=', $edate);

        $this->db->select('e.first_name, e.last_name, e.address1, e.city, e.pincode, e.phone, p.is_vacation_release, p.pay_start, p.pay_end, p.reg_rate, p.stat_rate, p.per_hr_rate');
        // $this->db->select_sum('p.per_hr_rate');
        $this->db->select_sum('p.reg_rate');
        $this->db->select_sum('p.stat_rate');
        $this->db->select_sum('p.reg_amt');
        $this->db->select_sum('p.stat_amt');
        $this->db->select_sum('p.reg_unit');
        $this->db->select_sum('p.stat_unit');
        $this->db->select_sum('p.reg_ytd');
        $this->db->select_sum('p.stat_ytd');
        $this->db->select_sum('p.wages');
        $this->db->select_sum('p.miscellaneous');
        $this->db->select_sum('p.wages_ytd');
        $this->db->select_sum('p.miscellaneous_ytd');
        $this->db->select_sum('p.vacation');
        $this->db->select_sum('p.govt_pen');
        $this->db->select_sum('p.fedl');
        $this->db->select_sum('p.eicount');
        $this->db->select_sum('p.medical');
        $this->db->select_sum('p.govt_pen_ytd');
        $this->db->select_sum('p.fedl_ytd');
        $this->db->select_sum('p.eicount_ytd');
        $this->db->select_sum('p.medical_ytd');
        $this->db->select_sum('p.gross');
        $this->db->select_sum('p.gross_ytd');
        $this->db->select_sum('p.vacation_release');
        
        return $this->db->get()->row_array();
    }
}

/* End of file M_payroll.php */
