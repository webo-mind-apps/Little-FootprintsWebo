<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        *{
            font-family:Arial,Helvetica,sans-serif;
        }
        .fx_background{
            background-image:url(<?php echo base_url('/my_assets/') ?>summarized.png); 
            height:1050px;
            width:100%;
            margin:0px;
            background-size:100%;
        }
        @page {
            margin: 0mm;
            margin-header: 0mm;
            margin-footer: 0mm;
        }
        .font8{
            font-size:9px;
        }
        p{
            font-weight:600;
            color:#333;
            font-size:12px;
            font-family:Arial,Helvetica,sans-serif;
        }
        .empr-name1{
            position:absolute;
            top:30px;
            left:65px;
            font-weight:bold;
        }
        .year-1{
            position:absolute;
            top:33px;
            left:400px
        }
        .emptincom-1{
            position:absolute;
            top:85px;
            right:230px
        }

        .empt-tax-deduction-1{
            position:absolute;
            top:85px;
            right:57px
        }

        .accno-1{
            position:absolute;
            top:120px;
            left:79px;
            font-size:11px; 
        }
        .province-1{
            position:absolute;
            top:130px;
            left:383px;
            width:75px;
        }
        .cpp-1{
            position:absolute;
            top:130px;
            right:230px;
        }
        .insurable-1{
            position:absolute;
            top:130px;
            right:57px
        }
        .social-insurance-1{
            position:absolute;
            top:165px;
            left:85px
        }
        .cpp-qpp-1{
            position:absolute;
            top:179px;
            right:57px
        }
        .lastname-1{
            position:absolute;
            top:245px;
            left:85px;
        }
        .fname-1{
            position:absolute;
            top:245px;
            left:293px;
        }
        .address{
            position:absolute;
            top:270px;
            left:75px;
        }
        .premiums{
            position:absolute;
            top:225px;
            right:230px;
        }
        /* ****************** */
        .empr-name2{
            position:absolute;
            top:530px;
            left:65px;
            font-weight:bold;
        }
        .year-2{
            position:absolute;
            top:533px;
            left:400px
        }
        .emptincom-2{
            position:absolute;
            top:585px;
            right:230px;
        }

        .empt-tax-deduction-2{
            position:absolute;
            top:585px;
            right:57px
        }

        .accno-2{
            position:absolute;
            top:620px;
            left:79px;
            font-size:11px; 
        }
        .province-2{
            position:absolute;
            top:630px;
            left:383px;
            width:75px;
        }
        .cpp-2{
            position:absolute;
            top:630px;
            right:230px;
        }
        .insurable-2{
            position:absolute;
            top:630px;
            right:57px
        }
        .social-insurance-2{
            position:absolute;
            top:665px;
            left:85px
        }
        .cpp-qpp-2{
            position:absolute;
            top:679px;
            right:57px
        }
        .lastname-2{
            position:absolute;
            top:745px;
            left:85px;
        }
        .fname-2{
            position:absolute;
            top:745px;
            left:293px;
        }
        .address-2{
            position:absolute;
            top:770px;
            left:75px;
        }
        .premiums-2{
            position:absolute;
            top:725px;
            right:230px;
        }
    </style>
</head>
<body>
<?php

$gross = ($pdf->empYtd['wages'] + $pdf->empYtd['miscellaneous'] + $pdf->empYtd['reg_amt'] + $pdf->empYtd['stat_amt']);

$deductions = ($pdf->empYtd['govt_pen'] + $pdf->empYtd['fedl'] + $pdf->empYtd['eicount'] + $pdf->empYtd['medical']);

$eiammount = ($gross <= $pdf->master->ei_amt)? $gross : $pdf->master->ei_amt;
$cppamount = ($gross <= $pdf->master->max_pentionable_earning)? $gross : $pdf->master->max_pentionable_earning;
?>
    <div class="fx_background"></div>
        <p class="empr-name1 font8" >
            <?php echo $pdf->name ?><br>
        </p>
        <p class="year-1"><?php echo $this->input->get('year') ?></p>
        <p class="emptincom-1"><?php echo   sprintf("%.2f",$gross) ?></p>
        <p class="empt-tax-deduction-1"><?php echo sprintf("%.2f",$deductions) ?></p>
        <p class="accno-1"><?php echo $pdf->ac_num ?></p>
        <p class="province-1">BC</p>
        <p class="cpp-1"><?php echo sprintf("%.2f",$pdf->empYtd['govt_pen']) ?></p>
        <p class="insurable-1"><?php echo sprintf("%.2f",$eiammount) ?></p>
        <p class="social-insurance-1"><?php echo $pdf->empsin ?></p>
        <p class="cpp-qpp-1"><?php echo sprintf("%.2f",$cppamount) ?></p>
        <p class="lastname-1"><?php echo strtoupper($pdf->first_name) ?></p>
        <p class="fname-1"><?php echo strtoupper($pdf->last_name) ?></p>
        <p class="address"><?php echo $pdf->city.'<br>'. $pdf->address2.'<br>'.$pdf->pincode ?></p>
        <p class="premiums"><?php echo sprintf("%.2f",$pdf->empYtd['eicount']) ?></p>

        <p class="empr-name2 font8" >
            <?php echo $pdf->name ?><br>
        </p>
        <p class="year-2"><?php echo $this->input->get('year') ?></p>
        <p class="emptincom-2"><?php echo sprintf("%.2f",$gross) ?></p>
        <p class="empt-tax-deduction-2"><?php echo sprintf("%.2f",$deductions) ?></p>
        <p class="accno-2"><?php echo $pdf->ac_num ?></p>
        <p class="province-2">BC</p>
        <p class="cpp-2"><?php echo sprintf("%.2f",$pdf->empYtd['govt_pen']) ?></p>
        <p class="insurable-2"><?php echo sprintf("%.2f",$eiammount) ?></p>
        <p class="social-insurance-2"><?php echo $pdf->empsin ?></p>
        <p class="cpp-qpp-2"><?php echo sprintf("%.2f",$cppamount) ?></p>
        <p class="lastname-2"><?php echo strtoupper($pdf->first_name) ?></p>
        <p class="fname-2"><?php echo strtoupper($pdf->last_name) ?></p>
        <p class="address-2"><?php echo $pdf->city.'<br>'. $pdf->address2.'<br>'.$pdf->pincode ?></p>
        <p class="premiums-2"><?php echo sprintf("%.2f",$pdf->empYtd['eicount']) ?></p>

</body>
</html>