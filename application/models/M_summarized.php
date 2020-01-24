<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_summarized extends CI_Model {

    public function getEmployees($year = '2020')
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
        $sdate = $year.'-01-01';
        $edate = $year.'-12-31';
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = date('Y-m-d', strtotime($edate));
        $this->load->model('m_payStub');
        return $this->m_payStub->empYtd($id, $sdate, $edate);
    }

    // get single employee
    public function getEmployee($id = null)
    {
        $year = $this->input->get('year');
        $sdate = $year.'-01-01';
        $edate = $year.'-12-31';
        $sdate = date('Y-m-d', strtotime($sdate));
        $edate = date('Y-m-d', strtotime($edate));
        $this->load->model('m_payStub');

        $this->db->from('lit_employee_details e');
        $this->db->where('e.id', $id);
        $this->db->join('lit_company c ', 'c.id = e.company', 'left');
        $value = $this->db->get()->row();

        $value->empYtd = $this->m_payStub->empYtd($id, $sdate, $edate);
        $value->master = $this->master($year);
        return $value; 
    }

    

    public function master($year = '2020')
    {
       $this->db->where('year', $year);
       return $this->db->get('lit_master')->row();
    }
}

/* End of file m_summarized.php */
