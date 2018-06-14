<?php

use App\Models\SubscriberInfo;
use App\Models\MasterPlaza;
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>History Customer</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

<!--        <style>
            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: "Open Sans", sans-serif
            }

            table,
            td,
            th {
                border: 1px solid #ddd;
                text-align: left
            }

            table {
                border-collapse: collapse;
                /*width: 100%;*/
            }

            th,
            td {
                padding: 10px
            }

            th {
                background: #eee
            }
        </style>-->
        {!! HTML::style('templates/light-bootstrap/assets/css/bootstrap.min.css') !!}
        <!--{!! HTML::style('templates/light-bootstrap/assets/css/animate.min.css')  !!}-->
        <!--{!! HTML::style('templates/light-bootstrap/assets/css/light-bootstrap-dashboard.css')  !!}-->
        {!! HTML::script('templates/light-bootstrap/assets/js/jquery-1.10.2.js') !!}
    </head>
    <body>
        <div id="pages" style="padding-left: 10px;margin-top:10px;">
            <?php
            $startdate = $_GET['startdate'];
            $enddate = $_GET['enddate'];

            $data1 = urldecode($_GET['data1']);
            $data2 = urldecode($_GET['data2']);
            $encodeData1 = json_decode($data1, true);
            $encodeData2 = json_decode($data2, true);
            ?>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12">
                    <div style="text-align: center;font-size: 18px;">Report&nbsp;History&nbsp;Transaction</div>
                    <div style="text-align: center;font-size: 14px;">From&nbsp; <?= $startdate; ?>&nbsp;To&nbsp; <?= $enddate; ?></div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading panel-heading-custom-padding">{!!trans('dashboard.summary_transaction')!!}</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive" style="">
                            <thead>
                                <tr>
                                    <th style="width:10px;text-align: center;">No</th>
                                    <th style="text-align: center;">OBU</th>
                                    <th style="text-align: center;">No Lambung</th>
                                    <th style="text-align: center;">{!!trans('dashboard.police_number')!!}</th>
                                    <th style="text-align: center;">Transaction QTY</th>
                                    <th style="text-align: center;">{!!trans('dashboard.total_transaction')!!}</th>
                                    <th style="text-align: center;">{!!trans('dashboard.balance')!!} (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($encodeData1 as $value) {
                                    $no++;
                                    $subscriberId = $value['subscriber_id'];
//                        $platNo = getSubscriberInfoByType($subscriberId, 121);
                                    $platNo = SubscriberInfo::where('subscriber_id', $subscriberId)
                                            ->where('info_type_id', 121)
                                            ->get();
                                    $resultNoLambung = SubscriberInfo::where('subscriber_id', $value['subscriber_id'])
                                            ->where('info_type_id', 144)
                                            ->get();
//                    print_r($platNo);
                                    ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $value['service_no']; ?></td>
                                        <td><?= $resultNoLambung[0]['info_desc_1']; ?></td>
                                        <td><?= $platNo[0]['info_desc_1']; ?></td>
                                        <td><?= count($encodeData2); ?></td>
                                        <td style="text-align: right;"><?= $self->amountToStr($_GET['total_trans']); ?></td>
                                        <td style="text-align: right;"><?= $self->amountToStr($value['current_balance']); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading panel-heading-custom-padding">{!!trans('dashboard.detail_transaction')!!}</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th style="width: 200px;">{!!trans('dashboard.no_transaction')!!}</th>
                                    <th style="width: 100px;">{!!trans('dashboard.date')!!} - {!!trans('dashboard.time')!!}</th>
                                    <!--<th>Saldo Awal (Rp)</th>-->
                                    <th>{!!trans('dashboard.description')!!}</th>
                                    <th style="width: 100px;">{!!trans('dashboard.transaction_amount')!!} (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($encodeData2 as $value) {
                                    $no++;
                                    $datetime = $value['event_begin_time'];
                                    $time = strtotime($datetime);
                                    $rs_get_plaza = MasterPlaza::where('plaza_code', $value['plaza_code'])->get();
//                    printf($rs_get_plaza);
                                    $amountCredit = 0;
                                    $amountDebit = 0;
                                    $amount = $value['trx_amount'];
//                    password_hash($password, PASSWORD_B);
                                    if ($amount >= 0) {
                                        $amountCredit = $amount;
                                    } else {
                                        $amountDebit = $amount;
                                    }
                                    $refCode = $value['reference_code'];
                                    ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td style="max-width: 10px;"><?= $refCode; ?></td>
                                        <td><?= $value['event_begin_time']; ?></td>
                                        <!--<td>e-Toll Gate Cengkareng</td>-->
                                        <td><?= $rs_get_plaza[0]['plaza_name']; ?></td>
                                        <td style="text-align: right"><?= $self->amountToStr($amountCredit); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>