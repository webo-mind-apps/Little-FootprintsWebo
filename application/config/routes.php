<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$route['default_controller']        = 'home';
$route['download-payroll/(:any)']   = 'main_control/download_payroll/$1';

$route['payroll']                   = 'Payroll';
$route['import-payroll']            = 'Payroll/import_payroll';

$route['summarized-report']         = 'summerized';
$route['summarized-report/(:num)']  = 'summerized/report/$1';
$route['send-pay-stub']             = 'mailStub';
$route['view-paystub/(:num)']       = 'MailStub/view_payroll/$1';
$route['export-paystub/(:num)']     = 'MailStub/download_payroll/$1';
$route['send-paystub-mail/(:num)']  = 'MailStub/sendMail/$1';
$route['net-pay-report']            = 'MailStub/net_pay_report';
$route['export-net-pay']            = 'MailStub/export';

// Deductions
$route['deduction-report']          = 'deduction';
$route['export-deductions']         = 'deduction/export';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
