<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$route['default_controller'] = 'main_control';
$route['download-payroll/(:any)']   = 'main_control/download_payroll/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
