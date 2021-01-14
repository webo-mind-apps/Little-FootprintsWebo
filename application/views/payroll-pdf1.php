<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PayRoll</title>
</head>
<body>
<style>
body{color:#333;  font-family:  'Arial', Helvetica, sans-serif;}
.border { border:0.1mm solid #333; }
table{ border-collapse: collapse; width:100%; }
.img-responsive{width:200px}
.text-right{text-align:right}
.text-left{text-align:left}
.text-center{text-align:center}
.header{border:0.1mm solid #333; }
.header-h4{font-size:18px; font-weight: 900; line-height:50px; text-transform: uppercase;}
.top-detail{font-size:10px; margin-bottom:10px}
td, th{padding:9px 5px; margin:-1px}
.earning-detail{font-size:10px; margin-bottom:10px}
.border-right{border-right:0.1mm solid #333;}
.deduction{font-size:10px; margin-bottom:10px}
/* thead tr{background-color:#bbdefb  } */

</style>
<?php
    $gross      = ($pdf->currentUnit->reg_amt + $pdf->currentUnit->stat_amt + $pdf->currentUnit->wages + $pdf->currentUnit->miscellaneous + $pdf->currentUnit->medical_contribution );
    $grossYtd   = ($pdf->empYtd['reg_amt'] + $pdf->empYtd['stat_amt'] + $pdf->empYtd['wages'] + $pdf->empYtd['miscellaneous'] + $pdf->empYtd['medical_contribution']);

    if ($pdf->is_vacation):
        $gross      = $gross + $pdf->empYtd['vacation'];
        $grossYtd   = $grossYtd + $pdf->empYtd['vacation'];
    endif;

    $totalDeduction = $pdf->currentUnit->govt_pen + $pdf->currentUnit->fedl  + $pdf->currentUnit->eicount + $pdf->currentUnit->medical;
    $totalYtdDeduction = $pdf->empYtd['govt_pen'] + $pdf->empYtd['fedl']  + $pdf->empYtd['eicount'] + $pdf->empYtd['medical'];

    $netPay = $gross - $totalDeduction;
    $ytdNetPay =$grossYtd - $totalYtdDeduction;

?>
<body style="background-gradient: linear #88FFFF #FFFF44 0 0.5 1 0.5;">
    <table class="header"  style="background-color:#fefeff">
        <tr>
            <td width="25%" style="padding: 20px 5px">
                <img class="img-responsive" style="" src="<?php echo base_url() ?>my_assets/global_assets/images/foot-print-logo.png" alt="">
            </td>
            <td class="text-right ">
                <h4 class="header-h4">Little Footprints Academy</h4>
                <br>
                <p class="header-p" style="font-size:90%; font-weight: 500;">STATEMENT OF EARNINGS AND DEDUCTIONS</p>
            </td>
           
        </tr>
    </table>
    <table class="top-detail border">
        <thead>
            <tr class="border" style="background-color:#f8f8ff">
                <th class="border text-left" >Employee Name / Address</th>
                <th class="border" >Reporting Period</th>
                <th class="border" >Pay Date</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border" style="background-color:#fff">
                <td class="border">
                    <?php echo $pdf->first_name.' '.$pdf->last_name ?>
                    <?php echo $pdf->city ?>, <br>
                    <?php echo $pdf->address1 ?>, <br>
                    <?php echo $pdf->pincode ?>
                </td>
                <td class="border text-center"><?php echo date('d-m-Y', strtotime($pdf->start_on)) ?> - <?php echo date('d-m-Y', strtotime($pdf->end_on)) ?></td>
                <td class="border text-center"><?php echo date('d-m-Y', strtotime($pdf->created_on)) ?></td>
            </tr>
        </tbody>
    </table>

    <table class="earning-detail border">
        <thead>
            <tr class="border" style="background-color:#f1f1f1">
                <th rowspan="2" class="border" >INCOME</th>
                <th colspan="3" class="border" >CURRENT PAYMENT</th>
                <th colspan="2" class="border" >YTD PAYMENT</th>
            </tr>
            <tr class="border" style="background-color:#f8f8ff">
                <th class="border" >RATE</th>
                <th class="border" >HRS/UNITS</th>
                <th class="border" >AMOUNT</th>
                <th class="border" >HRS/UNITS</th>
                <th class="border" >AMOUNT</th>
            </tr>
        </thead>
        <tbody >
            <tr style="background-color:#fff">
                <td>REGULAR</td>
                <td class="text-right"><?php echo number_format( round($pdf->currentUnit->rate,2), 2) ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->currentUnit->reg_unit,2), 2) ?></td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->reg_amt ,2), 2) ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['reg_unit'] , 2), 2) ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['reg_amt'] , 2), 2) ?></td>
            </tr>
            <tr style="background-color:#fff">
                <td>STAT HOL </td>
                <td class="text-right"><?php echo  number_format( round($pdf->currentUnit->rate,2), 2) ?></td>
                <td class="text-right"><?php echo  number_format( round($pdf->currentUnit->stat_unit,2), 2) ?></td>
                <td class="text-right border-right"><?php echo  number_format( round($pdf->currentUnit->stat_amt, 2), 2)?></td>
                <td class="text-right"><?php echo  number_format( round($pdf->empYtd['stat_unit'], 2), 2) ?></td> 
                <td class="text-right"><?php echo  number_format( round($pdf->empYtd['stat_amt'], 2), 2) ?></td> 
            </tr>
            <tr style="background-color:#fff">
                <td>WAGE BC</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->wages, 2), 2) ?></td> 
                <td class="text-right">0.00</td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['wages'],2), 2) ?></td> 
            </tr>
            <tr style="background-color:#fff">
                <td>MISCELLANEOUS <br>AMOUNT</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->miscellaneous, 2), 2) ?></td>
                <td class="text-right">0.00</td> 
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['miscellaneous'], 2), 2) ?></td> 
            </tr>
            <tr style="background-color:#fff">
                <td>EMPLOYER MEDICAL <br> CONTRIBUTION</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->medical_contribution, 2), 2) ?></td>
                <td class="text-right">0.00</td> 
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['medical_contribution'], 2), 2) ?></td> 
            </tr>
            <?php if($pdf->is_vacation == 1){ ?>
                <tr style="background-color:#fff">
                    <td>VACATION</td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->vacation_release, 2), 2) ?></td>
                    <td class="text-right "></td> 
                    <td class="text-right"><?php echo number_format( round($pdf->currentUnit->vacation_accrued, 2), 2) ?></td> 
                </tr>
            <?php }?>
            
        </tbody>
        <tfoot>
            <tr class="border"  style="background-color:#f1f1f1">
                <td><b>TOTAL GROSS</b></td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">
                    <b><?php echo  number_format( round($gross, 2), 2) ?></b>
                </td>
                <td class="text-right"></td> 
                <td class="text-right"><b><?php echo number_format( round($grossYtd, 2), 2) ?></b></td> 
            </tr>
        </tfoot>
    </table>

    <table class="deduction border">
        <thead>
            <tr class="border" style="background-color:#f8f8ff">
                <th width="33%" class="text-left">DEDUCTIONS</th>
                <th width="33%" class="border-right">CURRENT AMOUNT</th>
                <th width="33%">YTD AMOUNT</th>
            </tr>
        </thead>
        <tbody>
           
            <tr style="background-color:#fff">
                <td >GOVT PEN</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->govt_pen, 2), 2) ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['govt_pen'], 2), 2) ?></td>
            </tr>
            <tr style="background-color:#fff">
                <td>FEDL TAX</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->fedl, 2), 2)  ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['fedl'], 2), 2)  ?></td>
            </tr>
            <tr style="background-color:#fff">
                <td>EI  CONT</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->eicount, 2), 2)  ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['eicount'], 2), 2)  ?></td>
                
            </tr>
            <tr style="background-color:#fff">
                <td>MEDICAL</td>
                <td class="text-right border-right"><?php echo number_format( round($pdf->currentUnit->medical, 2), 2)  ?></td>
                <td class="text-right"><?php echo number_format( round($pdf->empYtd['medical'], 2), 2)  ?></td>
            </tr>
            
            <tr style="background-color:#fff">
                <td>TOTAL DEDUCTIONS</td>
                <td class="text-right border-right"><?php echo number_format( round($totalDeduction, 2), 2) ?></td> 
                <td class="text-right"><?php echo number_format( round($totalYtdDeduction, 2), 2) ?></td> 
            </tr>
            <tr class="border" style="background-color:#f1f1f1">
                <th class="text-left">NET PAY</th>
                <td class="text-right"><b><?php echo number_format( round($netPay, 2), 2) ?></b></td>
                <td class="text-right"><b><?php echo number_format( round($ytdNetPay, 2), 2) ?></b></td> 
            </tr> 
            <tr style="background-color:#f8f8ff">
                <td class="text-left">VACATION ACCRUED</td>
                <td class="text-right"><?php 
                if($pdf->is_vacation):
                    echo '0.00';
                else:
                    echo  number_format( round($pdf->currentUnit->vacation, 2), 2);
                endif;
                ?></td>
                <td class="text-right"><?php echo  number_format( round($pdf->currentUnit->vacation_accrued, 2), 2) ?></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
