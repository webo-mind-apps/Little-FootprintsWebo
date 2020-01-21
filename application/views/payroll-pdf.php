<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll</title>
    <style> body{ background:#fff; } *{ font-family:  arial; font-size: 14px; } .img-responsive{ max-width:100% }.text-right{ text-align:right} .text-center{ text-align:center; } p, span{ font-size:24px; font-family:  arial; letter-spacing:1px; } .bold{font-weight:900} .text-right{text-align:right} .date-box{ border:1px solid #000; padding:10px} table tr th{ font-size: 70%; font-family:  arial; padding-bottom:10px } table tr td{ font-family:  arial; font-size: 70%; padding-bottom:8px; } .text-left{ text-align:left } .border-table{ border: 1px solid black; margin-top:5px; padding-top:25px; padding-right:20px; padding-bottom:15px; } .mr-350{ margin-top:350px; } h3{ font-size:34px; } .mt15{ margin-top:25px; padding-top: 25px; position:relative; top:20px; } </style>
</head>
<body>
<?php
$vrelease = 0;
if($pdf['emp']->vacation_release == 1){
    $vrelease = $yrDeduction->vacation;
}

// grosspay 
$grossPay       = ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ) + ($pdf['emp']->miscellaneous_amount) + ($pdf['emp']->wage_amount + $vrelease);
$ytdGrossPay    = ($pdf['emp']->total_reg_ytd )  +  ($pdf['emp']->total_stat_ytd ) + ($pdf['emp']->tmiscellaneous) + ($pdf['emp']->totalWages + $vrelease);
// Total earnings
$totalErnings   = ($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ) +  ($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate );
$ytdTotalErnings= ($pdf['emp']->total_reg_ytd * $pdf['emp']->per_hr_rate )  +  ($pdf['emp']->total_stat_ytd * $pdf['emp']->per_hr_rate );
// Govt Penction
if($grossPay < $pdf['master']->max_pentionable_earning){
    $gvtPention     =((($grossPay - ($pdf['master']->basic_exemption_amt / $pdf['master']->no_pay_period)) * $pdf['master']->emp_contribution) / 100 );
}else{
    $gvtPention = 0.00;
}
if($grossPay < $pdf['master']->ei_amt){
    $eiCount        = (($pdf['master']->ei_cont * $grossPay) / 100);
    $ytdEiCount     = (($pdf['master']->ei_cont * $ytdGrossPay)  / 100);
}else{
    $eiCount = 0.00;
    $ytdEiCount = $pdf['master']->ei_cont;
}

// fedtax
$fedTax         = ($pdf['master']->fed_tax * $grossPay);
$ytdFedtax      = ($pdf['master']->fed_tax * $ytdGrossPay);

// medical
$medical = $pdf['emp']->medical;
$ytdMedical = $yrDeduction->medical;

// vacation
$vacation       = ($pdf['emp']->vocation_rate * $grossPay);
$ytVacation     = ($pdf['emp']->vocation_rate * $ytdGrossPay);
// deduction
$totalDeduction = (($gvtPention + $fedTax + $eiCount + $medical));
$totalYtdDeduction   = (($yrDeduction->govt_pen + $yrDeduction->fedl_tax + $yrDeduction->ei_count + $ytdMedical));
// net Pay
$netPay         =  $grossPay - $totalDeduction;
$ytdNetPay      = ($ytdGrossPay - $totalYtdDeduction);



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
                        <th class="text-right">RATE</th>
                        <th class="text-right">CURRENT <br> HRS/UNITS</th>
                        <th class="text-right">CURRENT <br>AMOUNT</th>
                        <th class="text-right">YTD<br> HRS/UNITS</th>
                        <th class="text-right">YTD<br> AMOUNT</th>
                    </tr>
                    <tr>
                        <td>REGULAR</td>
                        <td class="text-right"><?php echo $pdf['emp']->per_hr_rate ?></td>
                        <td class="text-right"><?php echo $pdf['emp']->regular_hrs ?></td>
                        <td class="text-right"><?php echo number_format( round(($pdf['emp']->regular_hrs * $pdf['emp']->per_hr_rate ),2), 2) ?></td>
                        <td class="text-right"><?php echo number_format( round($pdf['emp']->total_reg_ytd , 2), 2) ?></td>
                        <td class="text-right"><?php echo number_format( round(($pdf['emp']->total_reg_ytd ), 2), 2) ?></td>
                    </tr>
                    <tr>
                        <td>STAT HOL </td>
                        <td class="text-right"><?php echo $pdf['emp']->per_hr_rate ?></td>
                        <td class="text-right"><?php echo $pdf['emp']->stat_hol ?></td>
                        <td class="text-right"><?php echo  number_format( round(($pdf['emp']->per_hr_rate * $pdf['emp']->stat_hol ), 2), 2)?></td>
                        <td class="text-right"><?php echo  number_format( round($pdf['emp']->total_stat_ytd, 2), 2) ?></td> 
                        <td class="text-right"><?php echo  number_format( round(($pdf['emp']->total_stat_ytd), 2), 2) ?></td> 
                    </tr>
                    <tr>
                        <td>WAGE BC</td>
                        <td class="text-right">0.00</td>
                        <td class="text-right">0.00</td>
                        <td class="text-right"><?php echo number_format( round($pdf['emp']->wage_amount, 2), 2) ?></td> 
                        <td class="text-right">0.0</td>
                        <td class="text-right"><?php echo number_format( round($pdf['emp']->totalWages,2), 2) ?></td> 
                    </tr>
                    <tr>
                        <td>MISCELLANEOUS <br>AMOUNT</td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"><?php echo number_format( round($pdf['emp']->miscellaneous_amount, 2), 2) ?></td>
                        <td class="text-right"></td> 
                        <td class="text-right"><?php echo number_format( round($pdf['emp']->tmiscellaneous, 2), 2) ?></td> 
                    </tr>
                   <?php
                    if($pdf['emp']->vacation_release == 1){ ?>
                    <tr>
                        <td>VACATION</td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"><?php echo number_format( round($vrelease, 2), 2) ?></td>
                        <td class="text-right"></td> 
                        <td class="text-right"><?php echo number_format( round($vrelease, 2), 2) ?></td> 
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><br><b>TOTAL GROSS</b> <br><br><br><br></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"><br>
                            <b><?php echo  number_format( round($grossPay, 2), 2) ?></b>
                            <br><br><br><br>
                        </td>
                        <td class="text-right"></td> 
                        <td class="text-right"><br><b><?php echo number_format( round($ytdGrossPay, 2), 2) ?></b><br><br><br><br></td> 
                    </tr>
                    <tr class="mt15">
                        <th class="text-left">DEDUCTIONS</th>
                        <th></th>
                        <th></th>
                        <th class="text-right">CURRENT<br>AMOUNT</th>
                        <th class="text-right"></th>
                        <th class="text-right">YTD<br>AMOUNT</th>
                    </tr>
                    <tr>
                        <td >GOVT PEN</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($gvtPention, 2), 2) ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($yrDeduction->govt_pen, 2), 2) ?></td>
                       
                        
                    </tr>
                    <tr>
                        <td>FEDL TAX</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($fedTax, 2), 2)  ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($yrDeduction->fedl_tax, 2), 2)  ?></td>
                        
                    </tr>
                    <tr>
                        <td>EI  CONT</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($eiCount, 2), 2)  ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($yrDeduction->ei_count, 2), 2)  ?></td>
                        
                    </tr>
                    <tr>
                        <td>MEDICAL</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($medical, 2), 2)  ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($ytdMedical, 2), 2)  ?></td>
                        
                    </tr>
                    
                    <tr>
                        <td>TOTAL DEDUCTIONS</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($totalDeduction, 2), 2) ?></td> 
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($totalYtdDeduction, 2), 2) ?></td> 
                    </tr>
                    <tr>
                        <th class="text-left"><br>NET PAY</th>
                        <td></td>
                        <td></td>
                        <td class="text-right"><br><b><?php echo number_format( round($netPay, 2), 2) ?></b></td>
                        <td></td> 
                        <td class="text-right"><br><b><?php echo number_format( round($ytdNetPay, 2), 2) ?></b></td> 
                    </tr> 
                    <tr>
                        <td>VACATION</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo  number_format( round($vacation, 2), 2)?></td>
                        <td></td>
                        <td class="text-right"><?php echo  number_format( round($ytVacation, 2), 2) ?></td>
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
