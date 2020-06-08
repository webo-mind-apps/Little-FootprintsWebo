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
            /* text-align: left; */
            background-color: #4CAF50;
            color: white;
            }
             
        .img-responsive{ max-width:100% }
        .text-right{ text-align:right} 
        .text-center{ text-align:center !important; } 
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
                <h4>STATEMENT OF  DEDUCTIONS</h4>
            </td>
            <td class="date-box" width="24%">
                <div >
                    <div>
                        <span class="bold"><b>STATEMENT DATE: </b></span>
                        <span class="span-date"><?php echo date('M, Y', strtotime($deduction[0]->start_on)) ?></span>
                       
                    </div>
                   
                </div>
                
            </td>
        </tr>
    </table>

    <table width=100% id="customers">
        <thead>
            <tr>
				<th rowspan="2">SL NO</th>
                <th rowspan="2">First Name</th>
                <th rowspan="2">Last Name</th>
				<th class="text-center cols3" style="text-align:center" colspan="3"><h3 style="margin: 0;">DEDUCTIONS</h3></th>
            </tr>
			<tr>
				<th class="text-right">Employee</th>
                <th class="text-right">Employer</th>
				<th class="text-right">Total</th>
			</tr>
        </thead>
        <tbody>
            <?php 
            
            $temployee = $temployer = $ttotal = 0;
            foreach ($deduction as $key => $value) { 
                $cpp            =   0; 
                $ei             =   0; 
                $empDeduction   =   0;
                $emprDeduction  =   0;
                $totalDeduction =   0;

                $cpp            =  $value->empYtd['govt_pen'];
                $ei             = ($value->empYtd['eicount'] * 1.4);
                $empDeduction   = ($value->empYtd['govt_pen'] + $value->empYtd['fedl'] + $value->empYtd['eicount']);
                $emprDeduction  = ($cpp + $ei );
                $totalDeduction = $empDeduction + $emprDeduction;

                $temployee  += $empDeduction;
                $temployer  += $emprDeduction;
                $ttotal     += $totalDeduction;
            ?>
                <tr>
                    <td><?php echo $key+1  ?></td>
                    <td><?php echo $value->first_name?></td>
                    <td><?php echo $value->last_name ?></td>
                    <td class="text-right"><?php echo  number_format( round($empDeduction, 2), 2)?></td>
                    <td class="text-right"><?php echo  number_format( round($emprDeduction, 2), 2)?></td>
                    <td class="text-right"><?php echo  number_format( round($totalDeduction, 2), 2)?></td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="3" class="text-right"><b>Total</b></th>
                <th class="text-right"><?php echo number_format( round($temployee, 2), 2) ?></th>
                <th class="text-right"><?php echo number_format( round($temployer, 2), 2) ?></th>
                <th class="text-right"><?php echo number_format( round($ttotal, 2), 2) ?></th>
            </tr>
        </tbody>
    </table>
</body>
</html>