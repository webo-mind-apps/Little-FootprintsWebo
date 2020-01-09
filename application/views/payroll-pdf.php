<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll</title>
    <style> body{ background:#fff; } *{ font-family:  arial; font-size: 14px; } .img-responsive{ max-width:100% } .text-center{ text-align:center; } p, span{ font-size:24px; font-family:  arial; letter-spacing:1px; } .bold{font-weight:900} .text-right{text-align:right} .date-box{ border:1px solid #000; padding:20px 10px } table tr th{ font-size: 70%; font-family:  arial; padding-bottom:10px } table tr td{ font-family:  arial; font-size: 70%; padding-bottom:8px; } .text-left{ text-align:left } .border-table{ border: 1px solid black; margin-top:5px; padding-top:25px; padding-bottom:15px; } .mr-350{ margin-top:350px; } h3{ font-size:34px; } .mt15{ margin-top:25px; padding-top: 25px; position:relative; top:20px; } </style>
</head>
<body>
<?php
// grosspay 
$grossPay = ($pdf['emp']->regular_hrs * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate );

// Total earnings
$totalErnings = ($pdf['emp']->regular_hrs * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate );

// Govt Penction
$gvtPention = (($pdf['master']->govt_pen - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution);

// fedtax
$fedTax = (($pdf['master']->fed_tax - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution);

// Ei Count
$eiCount = (($pdf['master']->ei_cont - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution);

// vacation
$vacation = (($pdf['emp']->vocation_rate - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution);

?>
    <table >
        <tr>
            <td width="18%">
                <img class="img-responsive" src="<?php echo base_url() ?>my_assets/global_assets/images/foot-print-logo.png" alt="">
            </td>
            <td class="text-center">
                <p>Little Footprints Academy</p>
                <br>
                <br>
                <h3>STATEMENT OF EARNINGS AND DEDUCTIONS</h3>
            </td>
            <td class="date-box" width="22%">
                <div >
                    <div>
                        <span class="bold"><b>PAYMENT DATE:</b></span>
                        <span ><?php echo date('d-m-Y', strtotime($pdf['emp']->pay_date)) ?></span>
                       
                    </div>
                    <br>
                    <div>
                        <span class="bold"><b>PAY END DATE:</b></span>
                        <span><?php echo date('d-m-Y', strtotime($pdf['emp']->pay_end_date)) ?> <br> </span>
                    </div>
                </div>
                
            </td>
        </tr>
    </table>
    <table class="border-table" width="100%">
        <tr>
            <td>

                <table width="100%">
                    <tr>
                        <th class="text-left">EARNINGS</th>
                        <th>DATE <br> YMMDD </th>
                        <th>RATE</th>
                        <th>CURRENT <br> HRS/UNITS</th>
                        <th>CURRENT <br>AMOUNT</th>
                        <th>YTD<br> HRS/UNITS</th>
                        <th>YTD<br> AMOUNT</th>
                    </tr>
                    <tr>
                        <td>REGULAR</td>
                        <td></td>
                        <td class="text-center"><?php echo $pdf['emp']->regular_hrs ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->per_hr_rate ?></td>
                        <td class="text-center"><?php echo ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ) ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->per_hr_rate ?></td>
                        <td class="text-center">need to Store</td>
                    </tr>
                    <tr>
                        <td>STAT HOL </td>
                        <td></td>
                        <td class="text-center"><?php echo $pdf['emp']->regular_hrs ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->stat_hol ?></td>
                        <td class="text-center"><?php echo ($pdf['emp']->regular_hrs * $pdf['emp']->stat_hol ) ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->per_hr_rate ?></td> 
                        <td class="text-center">need to fetch</td> 
                    </tr>
                    <tr>
                        <td>WAGE BC</td>
                        <td></td>
                        <td class="text-center">18.0000</td>
                        <td class="text-center">0.000</td>
                        <td class="text-center">0.0</td>
                        <td class="text-center"><?php echo $pdf['emp']->wage_amount ?></td> 
                        <td class="text-center">0.0</td> 
                    </tr>
                    <tr>
                        <td>TOTAL EARNINGS</td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"><?php echo $totalErnings ?></td>
                        <td class="text-center"></td> 
                        <td class="text-center">need to fetch</td> 
                    </tr>
                    <tr>
                        <td>LESS TAXABLE BENEFITS</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">0.0</td>
                        <td class="text-center"></td> 
                        <td class="text-center">0.0</td> 
                    </tr>
                    <tr>
                        <td><br>TOTAL GROSS <br><br><br><br></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"><br>
                            <?php echo $grossPay ?>
                            <br><br><br><br>
                        </td>
                        <td class="text-center"></td> 
                        <td class="text-center"><br>need to fetch <br><br><br><br></td> 
                    </tr>
                    <tr class="mt15">
                        <th class="text-left">DEDUCTIONS</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>CURRENT<br>AMOUNT</th>
                        <th></th>
                        <th>YTD<br>AMOUNT</th>
                    </tr>
                    <tr>
                        <td >GOVT PEN</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo $gvtPention ?></td>
                        <td></td>
                        <td class="text-center"><?php echo $gvtPention ?></td>
                       
                        
                    </tr>
                    <tr>
                        <td>FEDL TAX</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo $fedTax  ?></td>
                        <td></td>
                        <td class="text-center"><?php echo $fedTax  ?></td>
                        
                    </tr>
                    <tr>
                        <td>EI  CONT</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo $eiCount  ?></td>
                        <td></td>
                        <td class="text-center"><?php echo $eiCount  ?></td>
                        
                    </tr>
                    <tr>
                        <td>Vacation</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo $vacation  ?></td>
                        <td></td>
                        <td class="text-center"><?php echo $vacation  ?></td>
                        
                    </tr>
                    
                    <tr>
                        <td>TOTAL DEDUCTIONS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">229.8</td> 
                        <td></td>
                        <td class="text-center">908.0</td> 
                    </tr>
                    <tr>
                        <th class="text-left"><br>NET PAY</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><br><b>1120.1</b></td>
                        <td></td> 
                        <td></td> 
                    </tr> 
                </table>

                <table class="mr-350">
                    <tr><th class="text-left">xyz</th></tr>
                    <tr><td>KAUR MANPREE</td></tr>
                    <tr><td>111 139</td></tr>
                    <tr><td>72 AV</td></tr>
                    <tr><td>SURREY BC V3W 2</td></tr>
                    <tr><td>CANADA</td></tr>
                </table>
            </td>
        </tr>
        
    </table>
         
</body>
</html>
