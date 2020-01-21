<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class m_payStub extends CI_Model {

    public function getDates($company = null)
    {
        $this->db->distinct('p.pay_date');
        $this->db->where('c.company_name', $company);
        // $this->db->where('p.center', $center);
        $this->db->select('CONCAT(date_format(p.pay_date, "%d-%m-%Y")," to ", date_format(pay_end_date,"%d-%m-%Y")) as date');
        $this->db->from('lit_payroll p');
        $this->db->join('lit_center c', 'c.id = p.center', 'left');
        $this->db->order_by('p.id', 'desc');
        return $this->db->get()->result();
    }

    public function empPayslisp($date = null)
    {
        $this->db->distinct('p.pay_date');
        $this->db->where('e.company', $date['company']);   
        $this->db->where('p.pay_date >=', $date['sdate']);
        $this->db->where('p.pay_end_date <=', $date['edate']);

        $this->db->select('p.emp_ids, p.id, e.email');
        $this->db->select('first_name, last_name, CONCAT(date_format(p.pay_date, "%D %b %Y")," &nbsp; TO &nbsp; ", date_format(pay_end_date,"%D %b %Y")) as date');
        
        $this->db->from('lit_payroll p');
        // $this->db->join('lit_center c', 'c.id = p.center', 'left');
        $this->db->join('lit_employee_details e', 'e.emp_id = p.emp_ids', 'left');
        $this->db->join('lit_yts y', 'y.payroll_id = p.id', 'left');
        
        $this->db->order_by('p.id', 'desc');
        return $this->db->get()->result();
    }

}
/* End of file m_payStub.php */
