<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class m_payStub extends CI_Model {

    public function getDates($company = null)
    {
        $this->db->select('CONCAT(date_format(r.start_on, "%d-%m-%Y")," to ", date_format(r.end_on,"%d-%m-%Y")) as date');

        $this->db->group_by('r.start_on');
        $this->db->where('c.company_name', $company);

        $this->db->from('lit_payroll_root r');
        $this->db->join('lit_payroll p', 'p.root_id = r.id', 'left');
        $this->db->join('lit_center c', 'c.id = p.center', 'left');

        $this->db->order_by('r.id', 'desc');
        return $this->db->get()->result();
    }

    public function empPayslisp($data = null)
    {
        $year = date('Y', strtotime($data['sdate']));
        
        $this->db->group_by('p.empid');
        $this->db->select('p.empid, p.id, e.email, p.start_on, p.end_on, p.is_mail_sent');
        $this->db->select('first_name, last_name, CONCAT(date_format(p.start_on, "%D %b %Y")," &nbsp; TO &nbsp; ", date_format(p.end_on,"%D %b %Y")) as date');
        $this->db->where('e.company', $data['company']);   
        $this->db->where('start_on >=', $data['sdate']);
        $this->db->where('end_on <=', $data['edate']);
        $this->db->where('year', $year);
        $this->db->order_by('e.first_name', 'asc');
        $this->db->from('lit_payroll_root p');
        $this->db->join('lit_employee_details e', 'e.emp_id = p.empid', 'left');
        return $this->db->get()->result();
    }

    // Get data for generate pdf

    public function PdfGet($id = null, $sdate = null, $edate = null)
    {
        return $payroll = $this->getPayroll($id, $sdate, $edate);
    }


    public function updateMailSent($id = null, $sdate = null, $edate = null)
    {
        $this->db->where('id', $id);
        $this->db->update('lit_payroll_root', array('is_mail_sent' => 1));
        return true;        
    }


    public function getPayroll($id = null, $sdate = null, $edate = null)
    {
        
        $this->db->select('r.*, e.first_name, e.email, e.last_name, e.address1, e.city, e.pincode, e.phone');
        
        $this->db->from('lit_payroll_root r');
        $this->db->join('lit_employee_details e', 'e.emp_id = r.empid', 'left');
        $this->db->where('r.id', $id);

        $payrollDetail = $this->db->get()->row();
        
        $payrollDetail->currentUnit = $this->currentUnit($id);
        $payrollDetail->empYtd      = $this->empYtd($payrollDetail->empid, $sdate, $edate);
        return $payrollDetail;
    }

    public function currentUnit($id = null)
    {
        return $this->db->where('root_id', $id)
        ->select_sum('reg_unit')
        ->select_sum('stat_unit')
        ->select_sum('reg_amt')
        ->select_sum('stat_amt')
        ->select_sum('wages')
        ->select_sum('miscellaneous')
        ->select_sum('govt_pen')
        ->select_sum('fedl')
        ->select_sum('eicount')
        ->select_sum('medical')
        ->select_sum('vacation')
        ->select_sum('medical_contribution')
        ->select('rate', 'is_vacation')
        ->get('lit_payroll')->row();
    }

    // get employee ytd
    public function empYtd($empid = null, $sdate = null, $edate = null)
    {
        $year = date('Y', strtotime($sdate));
        $payrolls = $this->db->where('empid', $empid)
        ->where('end_on <=', $edate)
        ->where('year ', $year)
        ->select('id')
        ->get('lit_payroll_root')
        ->result();
        foreach ($payrolls as $key => $value) {
            $empYtd[$key] =  $this->currentUnit($value->id);
        }
        


            $sum['reg_unit']       = 0;
            $sum['stat_unit']      = 0;
            $sum['reg_amt']        = 0;
            $sum['stat_amt']       = 0;
            $sum['wages']          = 0;
            $sum['miscellaneous']  = 0;
            $sum['govt_pen']       = 0;
            $sum['fedl']           = 0;
            $sum['eicount']        = 0;
            $sum['medical']        = 0;
            $sum['vacation']       = 0;
            $sum['medical_contribution']       = 0;

        if(!empty($empYtd)){
            foreach($empYtd as $item) {
                $sum['reg_unit']        += $item->reg_unit;
                $sum['stat_unit']       += $item->stat_unit;
                $sum['reg_amt']         += $item->reg_amt;
                $sum['stat_amt']        += $item->stat_amt;
                $sum['wages']           += $item->wages;
                $sum['miscellaneous']   += $item->miscellaneous;
                $sum['govt_pen']        += $item->govt_pen;
                $sum['fedl']            += $item->fedl;
                $sum['eicount']         += $item->eicount;
                $sum['medical']         += $item->medical;
                $sum['vacation']        += $item->vacation;
                $sum['medical_contribution'] += $item->medical_contribution;
            }
        }

       return $sum;
    }


/* **********************  NET PAY  *********************** */
    public function net_pay($data = null)
    {
        $year = date('Y', strtotime($data['sdate']));
        $this->db->group_by('p.empid');
        $this->db->select('p.*');
        $this->db->select('first_name, last_name, CONCAT(date_format(p.start_on, "%D %b %Y")," &nbsp; TO &nbsp; ", date_format(p.end_on,"%D %b %Y")) as date, hour_rate');
        $this->db->where('e.company', $data['company']);   
        $this->db->where('start_on >=', $data['sdate']);
        $this->db->where('end_on <=', $data['edate']);
        $this->db->where('year', $year);
        $this->db->order_by('e.first_name', 'asc');
        $this->db->from('lit_payroll_root p');
        $this->db->join('lit_employee_details e', 'e.emp_id = p.empid', 'left');
        $result =  $this->db->get()->result();
        
        foreach ($result as $key => $value) {
            $value->empYtd      = $this->empYtd($value->empid, $value->start_on, $value->end_on);
        }
       return $result;
    }

    public function get_deduction($data = null)
    {
        
     
        $year  = $data['year'];
        $sdate = date('Y-m-d H:i:s', strtotime($year.'-'.$data['month'].'-01 00:00:00'));
        $edate =  date('Y-m-t  H:i:s', strtotime($year.'-'.$data['month'].'-20 00:00:00'));
        $this->db->group_by('p.empid');
        $this->db->select('p.*');
        $this->db->select('first_name, last_name, hour_rate');
        $this->db->where('e.company', $data['company']);   
        $this->db->where('created_on >=', $sdate);
        $this->db->where('created_on <=', $edate);
        $this->db->where('year', $year);
        $this->db->order_by('e.first_name', 'asc');
        $this->db->from('lit_payroll_root p');
        $this->db->join('lit_employee_details e', 'e.emp_id = p.empid', 'left');
        $result =  $this->db->get()->result();
        
        foreach ($result as $key => $value) {
            $value->empYtd      = $this->empYtd($value->empid, $value->start_on, $value->end_on);
        }
       return $result;
    }

    
}
/* End of file m_payStub.php */
