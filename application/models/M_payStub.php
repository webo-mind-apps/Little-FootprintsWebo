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
        $this->db->select('p.empid, p.id, e.email, p.start_on, p.end_on');
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
        }
       return $sum;
    }


    public function PdfGet1($empid = null, $sdate = null, $edate = null)
    {
        $this->db->from('paystub p');
        $this->db->join('lit_employee_details  e', 'e.emp_id = p.emp_ids', 'left');
        
        $this->db->where('p.emp_ids', $empid);
        $this->db->where('p.pay_start >=', $sdate);
        $this->db->where('p.pay_end <=', $edate);

        $this->db->select('e.first_name, e.last_name, e.address1, e.city, e.pincode, e.phone, p.is_vacation_release, p.pay_start, p.pay_end, p.per_hr_rate');
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
        
        return $this->db->get()->row();
    }

}
/* End of file m_payStub.php */
