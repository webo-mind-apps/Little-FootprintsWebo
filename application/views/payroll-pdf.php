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
$grossPay       = ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ) + ($pdf['emp']->miscellaneous_amount) + ($pdf['emp']->wage_amount);
$ytdGrossPay    = ($pdf['emp']->total_reg_ytd * $pdf['emp']->per_hr_rate )  +  ($pdf['emp']->total_stat_ytd * $pdf['emp']->per_hr_rate ) + ($pdf['emp']->tmiscellaneous) + ($pdf['emp']->totalWages);
// Total earnings
$totalErnings   = ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate );
$ytdTotalErnings= ($pdf['emp']->total_reg_ytd * $pdf['emp']->per_hr_rate )  +  ($pdf['emp']->total_stat_ytd * $pdf['emp']->per_hr_rate );
// Govt Penction
if($grossPay < $pdf['master']->max_pentionable_earning){
    $gvtPention     =(($grossPay - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution);
}else{
    $gvtPention = 0.00;
}
// fedtax
$fedTax         = ($pdf['master']->fed_tax * $grossPay);
$ytdFedtax      = ($pdf['master']->fed_tax * $ytdGrossPay);
// Ei Count
$eiCount        = ($pdf['master']->ei_cont * $grossPay );
$ytdEiCount     = ($pdf['master']->ei_cont * $ytdGrossPay );
// vacation
$vacation       = ($pdf['emp']->vocation_rate * $grossPay);
$ytVacation     = ($pdf['emp']->vocation_rate * $ytdGrossPay);
// deduction
$totalDeduction = (($gvtPention + $fedTax + $eiCount + $vacation));
$totalYtdDeduction   = (($yrDeduction->govt_pen + $yrDeduction->fedl_tax + $yrDeduction->ei_count + $yrDeduction->vacation));
// net Pay
$netPay         =  $grossPay - $totalDeduction;
$ytdNetPay      = ($ytdGrossPay - $totalYtdDeduction );

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
                        <th>RATE</th>
                        <th>CURRENT <br> HRS/UNITS</th>
                        <th>CURRENT <br>AMOUNT</th>
                        <th>YTD<br> HRS/UNITS</th>
                        <th>YTD<br> AMOUNT</th>
                    </tr>
                    <tr>
                        <td>REGULAR</td>
                        <td class="text-center"><?php echo $pdf['emp']->per_hr_rate ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->regular_hrs ?></td>
                        <td class="text-center"><?php echo ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ) ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->total_reg_ytd ?></td>
                        <td class="text-center"><?php echo ($pdf['emp']->total_reg_ytd * $pdf['emp']->per_hr_rate ) ?></td>
                    </tr>
                    <tr>
                        <td>STAT HOL </td>
                        <td class="text-center"><?php echo $pdf['emp']->per_hr_rate ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->stat_hol ?></td>
                        <td class="text-center"><?php echo ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) ?></td>
                        <td class="text-center"><?php echo $pdf['emp']->total_stat_ytd ?></td> 
                        <td class="text-center"><?php echo ($pdf['emp']->total_stat_ytd * $pdf['emp']->per_hr_rate ) ?></td> 
                    </tr>
                    <tr>
                        <td>WAGE BC</td>
                        <td class="text-center">0.00</td>
                        <td class="text-center">0.00</td>
                        <td class="text-center"><?php echo $pdf['emp']->wage_amount ?></td> 
                        <td class="text-center">0.0</td>
                        <td class="text-center"><?php echo $pdf['emp']->totalWages ?></td> 
                    </tr>
                    <tr>
                        <td>MISCELLANEOUS <br>AMOUNT</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"><?php echo $pdf['emp']->miscellaneous_amount ?></td>
                        <td class="text-center"></td> 
                        <td class="text-center"><?php echo $pdf['emp']->tmiscellaneous ?></td> 
                    </tr>
                   
                    <tr>
                        <td><br><b>TOTAL GROSS</b> <br><br><br><br></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"><br>
                            <b><?php echo $grossPay ?></b>
                            <br><br><br><br>
                        </td>
                        <td class="text-center"></td> 
                        <td class="text-center"><br><b><?php echo $ytdGrossPay ?></b><br><br><br><br></td> 
                    </tr>
                    <tr class="mt15">
                        <th class="text-left">DEDUCTIONS</th>
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
                        <td class="text-center"><?php echo round($gvtPention, 2) ?></td>
                        <td></td>
                        <td class="text-center"><?php echo round($yrDeduction->govt_pen, 2) ?></td>
                       
                        
                    </tr>
                    <tr>
                        <td>FEDL TAX</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo round($fedTax, 2)  ?></td>
                        <td></td>
                        <td class="text-center"><?php echo round($yrDeduction->fedl_tax, 2)  ?></td>
                        
                    </tr>
                    <tr>
                        <td>EI  CONT</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo round($eiCount, 2)  ?></td>
                        <td></td>
                        <td class="text-center"><?php echo round($yrDeduction->ei_count, 2)  ?></td>
                        
                    </tr>
                    <tr>
                        <td>Vacation</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo round($vacation, 2)  ?></td>
                        <td></td>
                        <td class="text-center"><?php echo round($yrDeduction->vacation, 2)  ?></td>
                        
                    </tr>
                    
                    <tr>
                        <td>TOTAL DEDUCTIONS</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><?php echo round($totalDeduction, 2) ?></td> 
                        <td></td>
                        <td class="text-center"><?php echo round($totalYtdDeduction, 2) ?></td> 
                    </tr>
                    <tr>
                        <th class="text-left"><br>NET PAY</th>
                        <td></td>
                        <td></td>
                        <td class="text-center"><br><b><?php echo round($netPay, 2) ?></b></td>
                        <td></td> 
                        <td class="text-center"><b><?php echo round($ytdNetPay, 2) ?></b></td> 
                    </tr> 
                </table>

                <table class="mr-350">
                    <tr><th class="text-left"><?php echo $pdf['emp']->fname.' '.$pdf['emp']->lname ?></th></tr>
                    <tr><td><?php echo $pdf['emp']->city ?></td></tr>
                    <tr><td><?php echo $pdf['emp']->address ?></td></tr>
                    <tr><td><?php echo $pdf['emp']->pincode ?></td></tr>
                   
                </table>
            </td>
        </tr>
        
    </table>
         
</body>
</html>
