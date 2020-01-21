<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$route['default_controller']        = 'home';
$route['download-payroll/(:any)']   = 'main_control/download_payroll/$1';
$route['payroll']                   = 'main_control/pay_roll_page';
$route['summarized-report']         = 'summerized';
$route['summarized-report/(:num)']  = 'summerized/report/$1';
$route['send-pay-stub']             = 'mailStub';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
