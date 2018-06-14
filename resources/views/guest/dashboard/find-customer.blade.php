<?php
use App\Models\SubscriberInfo;
?>

<div class="table-responsive">
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No OBU</th>
                <th>No Lambung</th>
                <th>Saldo</th>
                <th>Action</th>
                <!--<th>Topup</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($data_subscriber as $value) {
                $no++;
                $currentBalance = $value['current_balance'];
                $styleAmount = "";
                if ($currentBalance <= 20000) {
                    $styleAmount = "color:white;font-weight:bold;background:#f44242;";
                }
              /*  
               * $resultNoLambung = SubscriberInfo::where('subscriber_id', $value['subscriber_id'])
            ->where('info_type_id', 144)
            ->get();
               * 
               */
                
//                $noLambung = "";
                $noLambung = $value['no_lambung'];
                /*if(count($resultNoLambung) >0){
                    $noLambung = $resultNoLambung[0]['info_desc_1'];
                }
                 * 
                 */
                ?>
                <tr style="<?= $styleAmount; ?>">
                    <td><?= $no; ?></td>
                    <td><?= $value['service_no']; ?></td>
                    <td><?= $noLambung; ?></td>
                    <td><?= $self->amountToStr($value['current_balance']); ?></td>
                    <td><button type="button" class="btn btn-primary btn-xs btn-fill" onclick="openTrans('<?= $value['service_no']; ?>')"><i class="fa fa-eye"></i> View Transaksi</button></td>
                    <!--<td><button type="button" class="btn btn-primary btn-xs btn-fill"><i class="fa fa-money"></i> Topup</button></td>-->
                </tr>
                <?php
            }
            ?>
        </tbody> 

    </table>
</div>
<!-- Modal -->

<script>
    function openTrans(title) {
        $('#myModalDashboard').modal('show');
        var txt = '<div class="row"  style="margin-bottom: 20px;">';
        txt += '<div class="col-md-6">';
        txt += '<div class="input-group">';
        txt += '<span class="input-group-addon" id="basic-addon1">Tanggal Awal</span>';
        txt += '<input type="text" class="form-control" data-date-format="yyyy-mm-dd" placeholder="Search for..." id="startdate"   value ="<?= date('Y-m-d'); ?>">';
        txt += '</div>';
        txt += '</div>';
        txt += '<div class="col-md-6">';
        txt += '<div class="input-group">';
        txt += '<span class="input-group-addon" id="basic-addon1">Tanggal Akhir</span>';
        txt += '<input type="text" class="form-control" data-date-format="yyyy-mm-dd"   placeholder="Search for..." id="enddate" value="<?= date('Y-m-d'); ?>">';
        txt += '<span class="input-group-btn">';
        txt += '<button class="btn btn-success btn-fill" id="findTrans" type="button">';
        txt += '<i class="fa fa-search"></i> Search!';
        txt += '</button>';
        txt += '</span>';
        txt += '</div>';
        txt += '</div>';
        txt += '</div>';
        txt += '<div class="row">';
        txt += '<div class="col-md-12" id="pageHistoryTransaction">';
        txt += '</div>';
        txt += '</div>';
        $('#myModalDashboardTitle').html('NO OBU : ' + title);
        $('#myModalDashboardBody').html(txt);
        var startdate = $('#startdate');
        var enddate = $('#enddate');
        startdate.datepicker({
            autoclose: true
       });
        enddate.datepicker({
            autoclose: true
       });
        $('#findTrans').attr("onclick", "getTransactionHistory('<?= URL('page/dashboard/customer'); ?>','" + title + "');");
        getTransactionHistory('<?= URL('page/dashboard/customer'); ?>', title);
    }

    function getTransactionHistory(url, obuNo) {
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
        var _token = $('input[name="_token"]').val();
        $('#pageHistoryTransaction').html('<div class="background-loading"></div>');
        $.post(url,
                {
                    action: 'history',
                    obu_no: obuNo,
                    startdate: startdate,
                    enddate: enddate,
                    _token: _token
                }, function (data, status) {
            $('#pageHistoryTransaction').html(data);
            $('.background-loading').remove();
        }).fail(function (xhr, textStatus, errorThrown) {
            $('#pageHistoryTransaction').html(xhr.responseText);
            $('.background-loading').remove();
        });
    }
</script>
