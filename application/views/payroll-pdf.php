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
    $totalDeduction = $pdf->govt_pen + $pdf->fedl + $pdf->eicount + $pdf->medical;
    $totalYtdDeduction = $pdf->govt_pen_ytd + $pdf->fedl_ytd + $pdf->eicount_ytd + $pdf->medical_ytd;

    $netPay = $pdf->gross - $totalDeduction;
    $ytdNetPay =$pdf->gross_ytd - $totalYtdDeduction;

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
                        <span ><?php echo date('d-m-Y', strtotime($pdf->pay_start)) ?></span>
                       
                    </div>
                    <br>
                    <div>
                        <span class="bold"><b>PAY END DATE:</b></span>
                        <span><?php echo date('d-m-Y', strtotime($pdf->pay_end)) ?> <br> </span>
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
                        <td class="text-right"><?php echo number_format( round($pdf->per_hr_rate,2), 2) ?></td>
                        <td class="text-right"><?php echo number_format( round($pdf->reg_rate,2), 2) ?></td>
                        <td class="text-right"><?php echo number_format( round($pdf->reg_amt ,2), 2) ?></td>
                        <td class="text-right"><?php echo number_format( round($pdf->reg_unit , 2), 2) ?></td>
                        <td class="text-right"><?php echo number_format( round($pdf->reg_ytd , 2), 2) ?></td>
                    </tr>
                    <tr>
                        <td>STAT HOL </td>
                        <td class="text-right"><?php echo  number_format( round($pdf->per_hr_rate,2), 2) ?></td>
                        <td class="text-right"><?php echo  number_format( round($pdf->stat_rate,2), 2) ?></td>
                        <td class="text-right"><?php echo  number_format( round($pdf->stat_amt, 2), 2)?></td>
                        <td class="text-right"><?php echo  number_format( round($pdf->stat_unit, 2), 2) ?></td> 
                        <td class="text-right"><?php echo  number_format( round($pdf->stat_ytd, 2), 2) ?></td> 
                    </tr>
                    <tr>
                        <td>WAGE BC</td>
                        <td class="text-right">0.00</td>
                        <td class="text-right">0</td>
                        <td class="text-right"><?php echo number_format( round($pdf->wages, 2), 2) ?></td> 
                        <td class="text-right">0.00</td>
                        <td class="text-right"><?php echo number_format( round($pdf->wages_ytd,2), 2) ?></td> 
                    </tr>
                    <tr>
                        <td>MISCELLANEOUS <br>AMOUNT</td>
                        <td class="text-right">0.00</td>
                        <td class="text-right">0</td>
                        <td class="text-right"><?php echo number_format( round($pdf->miscellaneous, 2), 2) ?></td>
                        <td class="text-right">0.00</td> 
                        <td class="text-right"><?php echo number_format( round($pdf->miscellaneous_ytd, 2), 2) ?></td> 
                    </tr>
                   <?php
                    $bvacation = 0;
                    if($pdf->is_vacation_release == 1){ ?>
                    <tr>
                        <td>VACATION</td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"><?php echo number_format( round($pdf->vacation, 2), 2) ?></td>
                        <td class="text-right"></td> 
                        <td class="text-right"><?php echo number_format( round($pdf->vacation_release, 2), 2) ?></td> 
                    </tr>
                    <?php }else{
                        $bvacation = $pdf->vacation;
                    } ?>
                    <tr>
                        <td><br><b>TOTAL GROSS</b> <br><br><br><br></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"><br>
                            <b><?php echo  number_format( round($pdf->gross, 2), 2) ?></b>
                            <br><br><br><br>
                        </td>
                        <td class="text-right"></td> 
                        <td class="text-right"><br><b><?php echo number_format( round($pdf->gross_ytd, 2), 2) ?></b><br><br><br><br></td> 
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
                        <td class="text-right"><?php echo number_format( round($pdf->govt_pen, 2), 2) ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->govt_pen_ytd, 2), 2) ?></td>
                       
                        
                    </tr>
                    <tr>
                        <td>FEDL TAX</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->fedl, 2), 2)  ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->fedl_ytd, 2), 2)  ?></td>
                        
                    </tr>
                    <tr>
                        <td>EI  CONT</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->eicount, 2), 2)  ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->eicount_ytd, 2), 2)  ?></td>
                        
                    </tr>
                    <tr>
                        <td>MEDICAL</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->medical, 2), 2)  ?></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format( round($pdf->medical_ytd, 2), 2)  ?></td>
                        
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
                        <td class="text-right"><?php echo  number_format( round($bvacation, 2), 2)?></td>
                        <td></td>
                        <td class="text-right"><?php echo  number_format( round($pdf->vacation_release, 2), 2) ?></td>
                    </tr>
                </table>

                <table class="mr-350">
                    <tr><th class="text-left"><?php echo $pdf->first_name.' '.$pdf->last_name ?></th></tr>
                    <tr><td><?php echo $pdf->city ?></td></tr>
                    <tr><td><?php echo $pdf->address1 ?></td></tr>
                    <tr><td><?php echo $pdf->pincode ?></td></tr>
                   
                </table>
            </td>
        </tr>
        
    </table>
         
</body>
</html>
