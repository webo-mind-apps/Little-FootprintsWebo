<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Net Pay</title>
    <style>
        *, th, td{
            font-family:  'Arial', Helvetica, sans-serif;
            font-size: 11px;
        }

             #customers {
            margin-top:10px;
            border-collapse: collapse;
            width: 100%;
            }

            #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
            }
             
        .img-responsive{ max-width:100% }
        .text-right{ text-align:right} 
        .text-center{ text-align:center; } 
        p, span{   font-family:  'Arial', Helvetica, sans-serif; letter-spacing:1px; } 
        /* .bold{font-weight:700}  */
        .text-right{text-align:right} 
        .date-box{ border:1px solid #000; padding:10px} 
       
        .text-left{ text-align:left } 
        .border-table{ border: 1px solid black; margin-top:5px; padding-top:25px; padding-right:20px; padding-bottom:15px; } 
        .mr-50{ margin-top:50px; } 
        h4{ font-size:25px;  font-family:  'Arial', Helvetica, sans-serif;} 
        .mt15{ margin-top:25px; padding-top: 25px; position:relative; top:20px; } 
        p{ font-size:30px }
        span.bold{
            font-size:15px;
            letter-spacing:0px;
        }
        span.span-date{font-size:14px; letter-spacing:0px;}
    </style>
</head>
<body>

<table >
    
        <tr>
            <td width="25%">
                <img class="img-responsive" src="<?php echo base_url() ?>my_assets/global_assets/images/foot-print-logo.png" alt="">
            </td>
            <td class="text-center tagtext">
                <p>Little Footprints Academy</p>
                <br>
                <br>
                <h4>STATEMENT OF EARNINGS AND DEDUCTIONS</h4>
            </td>
            <td class="date-box" width="24%">
                <div >
                    <div>
                        <span class="bold"><b>PAYMENT DATE:</b></span>
                        <span class="span-date"><?php echo date('d-m-Y', strtotime($pdf[0]->start_on)) ?></span>
                       
                    </div>
                    <br>

                    <div>
                        <span class="bold"><b>PAY PERIOD START DATE:</b></span>
                        <span class="span-date"><?php echo date('d-m-Y', strtotime($pdf[0]->start_on)) ?></span>
                       
                    </div>
                    <br>
                    <div>
                        <span class="bold"><b>PAY PERIOD END DATE:</b></span>
                        <span class="span-date" ><?php echo date('d-m-Y', strtotime($pdf[0]->end_on)) ?> <br> </span>
                    </div>
                </div>
                
            </td>
        </tr>
    </table>

    <table width=100% id="customers">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Emp Id</th>
                <th>Name</th>
                <th>Rate P/h</th>
                <th>Regular Amount</th>
                <th>Stat hol Amount</th>
                <th>Gross Pay</th>
                <th>Deduction</th>
                <th>Net Pay</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pdf as $key => $value) { 
                $vacation = 0;
                if ($value->is_vacation == 1):
                    $vacation = $value->empYtd['vacation'];
                endif;

                $gross = $value->empYtd['reg_amt'] + $value->empYtd['stat_amt'] + $value->empYtd['wages'] + $value->empYtd['miscellaneous'] + $vacation;
                $deduction = $value->empYtd['govt_pen'] + $value->empYtd['fedl'] + $value->empYtd['eicount'] + $value->empYtd['medical'];
                $net = $gross - $deduction;

            ?>
                <tr>
                    <td><?php echo $key+1  ?></td>
                    <td><?php echo $value->empid    ?></td>
                    <td><?php echo $value->first_name.' '.$value->last_name ?></td>
                    <td class="text-right"><?php echo  number_format( round($value->hour_rate, 2), 2)?></td>
                    <td class="text-right"><?php echo  number_format( round($value->empYtd['reg_amt'], 2), 2)?></td>
                    <td class="text-right"><?php echo  number_format( round($value->empYtd['stat_amt'], 2), 2)?></td>
                    <td class="text-right"><?php echo  number_format( round($gross, 2), 2) ?></td>
                    <td class="text-right"><?php echo  number_format( round($deduction, 2), 2) ?></td>
                    <td class="text-right"><?php echo  number_format( round($net, 2), 2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>