<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class deduction extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('admin_login') == false){ redirect('home','refresh'); }
        $this->load->model('m_payStub');
        
    }
    
    public function index()
    {
        $this->load->model('pay_roll_model');
        $data['company'] = $this->pay_roll_model->companyList();

        $data['title'] = 'Employee Deduction';
        $this->load->view('deduction', $data, FALSE);
    }

    public function get_deduction()
    {
        $data['company']    = $this->input->post('company');
        $data['year']       = $this->input->post('year');
        $data['month']      = $this->input->post('month');
        $result     = $this->m_payStub->get_deduction($data);
        echo json_encode($result);
    }

    public function export()
    {
        $data['company']    = $this->input->get('company');
        $data['year']       = $this->input->get('year');
        $data['month']      = $this->input->get('month');
        $result['deduction']= $this->m_payStub->get_deduction($data);

        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('deduction-pdf',$result,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function reo()
    {
        $this->load->model('pay_roll_model');
        $data['company']    = $this->pay_roll_model->companyList();
        $data['reason']     = $this->m_payStub->reason();
        $data['title']      = 'Record of Employment';
        $this->load->view('reo', $data, FALSE);
    }

    public function employee()
    {
        $id = $this->input->post('id', true);
        $data = $this->m_payStub->employee($id);
        echo json_encode($data);
    }

    public function employee_detail()
    {
        $id = $this->input->post('id', true);
        $data = $this->m_payStub->employee_detail($id);
        echo json_encode($data);
    }

    public function reo_insert()
    {
        $data = array(
            'emp'       => $this->input->post('employee', true),
            'company'   => $this->input->post('company', true),
            'issued'    => date('Y-m-d', strtotime($this->input->post('issued', true))),
            'fwork'     => date('Y-m-d', strtotime($this->input->post('fwork', true))),
            'lwork'     => date('Y-m-d', strtotime($this->input->post('lwork', true))),
            'recall'    => date('Y-m-d', strtotime($this->input->post('recall', true))),
            'fnending'  => date('Y-m-d', strtotime($this->input->post('fnending', true))),
            'reason'    => $this->input->post('reason', true),
            'modified'  => date('Y-m-d H:i:s'),
        );
        $this->m_payStub->reo_insert($data);
        $this->exportReo($data);
    }

    public function exportReo($datas = null)
    {
        $data = $this->m_payStub->reoReport($datas);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', 'RECORD OF EMPLOYEE');
        $spreadsheet->getActiveSheet()->mergeCells('A1:F1');

        $sheet->setCellValue('A2', 'EMPLOYERS NAME');
        $sheet->setCellValue('B2', $data->name);

        $sheet->setCellValue('A3', 'EMPLOYERS ADDRESS');
        $sheet->setCellValue('B3', $data->caddress);

        $sheet->setCellValue('A4', 'EMPLOYEE NAME');
        $sheet->setCellValue('B4', $data->first_name.' '. $data->last_name);

        $sheet->setCellValue('A5', 'EMPLOYERS ADDRESS');
        $sheet->setCellValue('B5', $data->address1."\n".$data->city."\n".$data->pincode);

        $sheet->setCellValue('A5', 'REASON FOR ISSUING THIS REO');
        $sheet->setCellValue('B5', $data->code.' - '.$data->des);
        // $spreadsheet->getActiveSheet()->mergeCells('A5:A6');
        // $sheet->setCellValue('B6', "For further information, contact \n".$data->isser." \nTelephone No : ".$data->phone);

        // $sheet->setCellValue('A7', 'NAME OF ISSUER');
        // $sheet->setCellValue('B7', $data->isser);

        $sheet->setCellValue('A6', 'DATE ISSUED');
        $sheet->setCellValue('B6', $datas['issued']);

        $sheet->setCellValue('A7', 'CRA BUSINESS NUMBER (BN)');
        $sheet->setCellValue('B7', $data->ac_num);

        $sheet->setCellValue('A8', 'SOCIAL INSURABLE NUMBER');
        $sheet->setCellValue('B8', $data->empsin);

        $sheet->setCellValue('A9', 'FIRST DAY WORKED');
        $sheet->setCellValue('B9', $datas['fwork']);

        $sheet->setCellValue('A10', 'LAST DAY FOR WHICH PAID');
        $sheet->setCellValue('B10', $datas['lwork']);

        $sheet->setCellValue('A11', 'FINAL PAY PERIOD ENDING DATE');
        $sheet->setCellValue('B11', $datas['fnending']);

        $sheet->setCellValue('A12', 'OCCUPATION');
        $sheet->setCellValue('B12', $data->position);

        $sheet->setCellValue('A13', 'EXPECTED DATE OF RECALL');
        $sheet->setCellValue('B13', $datas['recall']);

        $sheet->setCellValue('A14', 'TOTAL INSURABLE HOURS');
        $sheet->setCellValue('B14', round($data->insurable['hours'], 2));

        $sheet->setCellValue('A15', 'TOTAL INSURABLE EARNING');
        $sheet->setCellValue('B15', round($data->insurable['earning'],2));

        $sheet->setCellValue('C2', 'PP');
        $sheet->setCellValue('D2', 'PAY PERIOD ENDING DATE');
        $sheet->setCellValue('E2', 'INSURABLE EARNING');
        $sheet->setCellValue('F2', 'INSURABLE HOURS');

        foreach ($data->payDetail as $key => $value) {
            $gross  =   (
                            $value->lastsPayData->reg_amt +
                            $value->lastsPayData->stat_amt +
                            $value->lastsPayData->wages +
                            $value->lastsPayData->miscellaneous +
                            $value->lastsPayData->medical_contribution
                        );
            $row = $key + 3;

            $sheet->setCellValue('C'.$row, $key + 1);
            $sheet->setCellValue('D'.$row, date('d-m-Y', strtotime($value->end_on)));
            $sheet->setCellValue('E'.$row, round($gross, 2));
            $sheet->setCellValue('F'.$row, $value->lastsPayData->reg_unit);
        }

        // styling
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $styleArrayFirstRow = [
            'font' => [
                'bold'  => true,
                'size'  => 14
            ]
        ];
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:' . $highestColumn . '1' )->applyFromArray($styleArrayFirstRow);

        $bold = [
            'font' => [
                'bold'  => true,
            ]
        ];

        $sheet->getStyle('A1:A30')->applyFromArray($bold);
        $sheet->getStyle('C2:F2')->applyFromArray($bold);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:F')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:B30')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fffde7');
        $spreadsheet->getActiveSheet()->getStyle('C2:F30')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e0f2f1');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'e2e2e2'],
                ],
            ],
        ];
        
        $sheet->getStyle('A1:F50')->applyFromArray($styleArray);

        $filename = $data->first_name.$data->last_name;
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
        $writer->save("php://output");
        exit;
    }

}

