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
        $year = date('Y', strtotime($sdate));
        return $this->db->from('lit_payroll_root r')
        ->select('r.*, p.reg_unit, p.stat_unit, p.wages, p.miscellaneous, p.medical')
        ->where('r.empid', $empid)
        ->where('r.start_on >=', $sdate)
        ->where('r.end_on <=', $edate)
        ->where('r.year', $year)
        ->where('p.company ', $company)
        ->where('p.center ', $center)
        ->join('lit_payroll p', 'p.emp_id = r.empid', 'left')
        ->get()
        ->row();
    }

    // Save payroll Details
    public function savePayroll($data = null, $sDate = null, $eDate = null, $pid = null)
    {
        if(empty($pid)){
            $pid = $this->insertPayroll($data);
        }
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
        );
        $this->db->where('empid', $newArray['empid']);
        $this->db->where('start_on', $newArray['start_on']);
        $this->db->where('end_on', $newArray['end_on']);
        $this->db->where('year', $newArray['year']);
        $query = $this->db->get('lit_payroll_root');
        
        if($query->num_rows() > 0){
            return $query->row()->id;
        }else{
            $this->db->insert('lit_payroll_root', $newArray);
            return $this->db->insert_id();
        }
        
    }

    // calculate the rates and amount
    public function calculateData($data = null , $master = null, $pid = null)
    {
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
            'emp_id'        => 0
        );

        $rates->reg_unit        =  $data['reg_rate'];
        $rates->stat_unit       =  $data['stat_rate'];
        $rates->rate            =  $data['per_hr_rate'];
        $rates->wages           =  $data['wages'];
        $rates->miscellaneous   =  $data['miscellaneous'];
        $rates->is_vacation     =  $data['is_vacation_release'];

        $rates->root_id         =  $pid;
        $rates->center          =  $data['center'];
        $rates->company         =  $data['company'];
        $rates->emp_id          =  $data['emp_ids'];

        $rates->reg_amt   = (float)$rates->reg_unit  * (float)$rates->rate;
        $rates->stat_amt  = (float)$rates->stat_unit * (float)$rates->rate;

        $gross = (float)$rates->reg_amt + (float)$rates->stat_amt + (float)$rates->wages + (float)$rates->miscellaneous; 

        $rates->fedl     = (float)$gross * (float)$master->fed_tax;
        $rates->vacation = (float)$gross * (float)$data['vacation'];
        $rates->medical  = $data['medical'];
        
        if($gross <= $master->max_pentionable_earning):
			$rates->govt_pen    = ((((float)$gross - ((float)$master->basic_exemption_amt / (float)$master->no_pay_period)) * (float)$master->emp_contribution) / 100);
        else:
			$rates->govt_pen    = 0;
        endif;

        if($gross < $master->ei_amt):
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

    // insert Payroll
    public function insertPayroll1($data = null)
    {
        $this->db->insert('paystub', $data);
        return $this->db->insert_id();
    }

    // update Payroll
    public function updatePayroll1($data = null, $pid = null)
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

   
    
    public function PdfGet1($empid = null, $sdate = null, $edate = null)
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
