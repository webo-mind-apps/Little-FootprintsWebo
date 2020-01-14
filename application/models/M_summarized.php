<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_summarized extends CI_Model {

    public function getEmployees($year = '2017')
    {
        
        $this->db->from('lit_employee_details');
        $result =  $this->db->get()->result();
        foreach ($result as $key => $value) {
            $value->ytds = $this->getYtds($value->emp_id, $year);
        }
        return $result;
    }

    public function getYtds($id = null, $year = null)
    {
        $year = $year.'-12-31';
        $filter = date('Y-m-d h:i:s', strtotime($year));
        $this->db->where('empid', $id);
        $this->db->where('created_on <=', $filter);
        $this->db->order_by('id', 'desc');
        return $this->db->get('lit_yts')->row(1);
    }

    // get single employee
    public function getEmployee($id = null)
    {
        $this->db->from('lit_employee_details e');
        $this->db->where('e.id', $id);
        $this->db->join('lit_company c ', 'c.id = e.company', 'left');
        $value = $this->db->get()->row();
        
        $value->ytds            = $this->getYtds($value->emp_id, $this->input->get('year'));       
        $value->wages           = $this->countWages($value->emp_id, $this->input->get('year'));
        $value->miscellaneous   = $this->countMiscellaneous($value->emp_id, $this->input->get('year'));
        $value->payrolls        = $this->payrolls($value->emp_id, $this->input->get('year'));
        $value->master          = $this->master($this->input->get('year'));
        return $value; 
    }

    // count of tottal wages
	public function countWages($id = null, $year = null)
	{
        return $this->db->where('emp_ids', $id)
        ->where('pay_end_date <=', $year)
		->select_sum('wage_amount')
		->get('lit_payroll')->row()->wage_amount;
    }
    
    	// count of total Miscellaneous
	public function countMiscellaneous($id = null, $year = null)
	{
        return $this->db->where('emp_ids', $id)
        ->where('pay_end_date <=', $year)
		->select_sum('miscellaneous_amount')
		->get('lit_payroll')->row()->miscellaneous_amount;
    }
    
    public function payrolls($id = null, $year = null)
    {
        $this->db->where('emp_ids', $id);
        $this->db->where('pay_end_date <=', $year);
        $this->db->order_by('id', 'desc');
        $this->db->select('(regular_hrs * per_hr_rate) as reg, (stat_hol * per_hr_rate) as stathol');
        $query = $this->db->get('lit_payroll')->result();

        $reg = 0;
        $stat = 0;
        foreach ($query as $key => $value) {
            $reg = ($reg + $value->reg);
            $stat = ($stat + $value->stathol);
        }

        $data['reg'] =  $reg;
        $data['stahol'] =  $stat;
        return $data;
        
    }

    public function master($year = '2020')
    {
       $this->db->where('year', $year);
       return $this->db->get('lit_master')->row();
    }
}

/* End of file m_summarized.php */
