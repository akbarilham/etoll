<?php

use App\Models\SubscriberInfo;
use App\Models\MasterPlaza;
//echo json_encode($data_detail_obu);

?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-sm btn-fill" onclick="printElemCustomerHistory('pageHistory', '<?= trans('dashboard.summary_transaction'); ?>','<?=$_POST['startdate'];?>','<?=$_POST['enddate'];?>')">Print <i class="fa fa-print"></i></button>
        <a href="<?=URL('/page/dashboard/customer/pdf?enddate='.$_POST['enddate'].'&startdate='.$_POST['startdate'].'&total_trans='.$data_event_input_transaction[0]['total'].'&data1='. urlencode(json_encode($data_detail_obu)).'&data2='. urlencode(json_encode($data_event_input)));?>" class="btn btn-danger btn-sm btn-fill" 
           target="_blank"
           >Export PDF <i class="fa fa-file-pdf-o"></i></a>
    </div>
</div>
<div id="pageHistory">
    
    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-custom-padding">{!!trans('dashboard.summary_transaction')!!}</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>OBU</th>
                            <th>No Lambung</th>
                            <th>{!!trans('dashboard.police_number')!!}</th>
                            <th>Transaction QTY</th>
                            <th>{!!trans('dashboard.total_transaction')!!}</th>
                            <th>{!!trans('dashboard.balance')!!} (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($data_detail_obu as $value) {
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
                                <td><?= count($data_event_input); ?></td>
                                <td><?= $self->amountToStr($data_event_input_transaction[0]['total']); ?></td>
                                <td><?= $self->amountToStr($value['current_balance']); ?></td>
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
                            <th>No</th>
                            <th>{!!trans('dashboard.no_transaction')!!}</th>
                            <th>{!!trans('dashboard.date')!!} - {!!trans('dashboard.time')!!}</th>
                            <!--<th>Saldo Awal (Rp)</th>-->
                            <th>{!!trans('dashboard.description')!!}</th>
                            <th>{!!trans('dashboard.transaction_amount')!!} (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($data_event_input as $value) {
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
                                <td><?= $refCode; ?></td>
                                <td><?= $value['event_begin_time']; ?></td>
                                <!--<td>e-Toll Gate Cengkareng</td>-->
                                <td><?= $rs_get_plaza[0]['plaza_name']; ?></td>
                                <td style="text-align: right;"><?= $self->amountToStr($amountCredit); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>