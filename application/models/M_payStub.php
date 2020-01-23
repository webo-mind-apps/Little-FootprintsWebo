<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class m_payStub extends CI_Model {

    public function getDates($company = null)
    {
        $this->db->group_by('p.pay_start');
        $this->db->where('c.company_name', $company);
        // $this->db->where('p.center', $center);
        $this->db->select('CONCAT(date_format(p.pay_start, "%d-%m-%Y")," to ", date_format(pay_end,"%d-%m-%Y")) as date');
        $this->db->from('paystub p');
        $this->db->join('lit_center c', 'c.id = p.center', 'left');
        $this->db->order_by('p.id', 'desc');
        return $this->db->get()->result();
    }

    public function empPayslisp($date = null)
    {
        $this->db->group_by('p.emp_ids');
        
        $this->db->select('p.emp_ids, p.id, e.email, p.pay_start, p.pay_end');
        $this->db->select('first_name, last_name, CONCAT(date_format(p.pay_start, "%D %b %Y")," &nbsp; TO &nbsp; ", date_format(p.pay_end,"%D %b %Y")) as date');
        
        $this->db->where('e.company', $date['company']);   
        $this->db->where('p.pay_start >=', $date['sdate']);
        $this->db->where('p.pay_end <=', $date['edate']);

        $this->db->from('paystub p');
        // $this->db->join('lit_center c', 'c.id = p.center', 'left');
        $this->db->join('lit_employee_details e', 'e.emp_id = p.emp_ids', 'left');
        
        $this->db->order_by('p.id', 'desc');
        return $this->db->get()->result();
    }

    // Get data for genaerate pdf

    public function PdfGet($empid = null, $sdate = null, $edate = null)
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
