<style type="text/css">
    /*table td, table th{
        border:1px solid black;*/

    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 0.5px solid black;
    }
    td {
        padding-left: 4px;
        padding-right: 4px;
    }
    .page-break {
        page-break-inside:avoid;
        page-break-after: always;
    }
    .bg-blue{
        background-color: #0B5799;
    }
    .white{
        color: #FFFFFF;
    }

    /* Hover cell effect! */

    .container {
        padding: 50px !important;
        font-family: Calibri !important;
    }
</style>
<div class="container">
    <center><img width="200px" src="/var/www/html/etoll-admin/public/images/jasa_marga_logo.jpg"/></center>
    <h4 align="center">LAPORAN OPERASIONAL TOL JM ACCESS</h4>
    <span style="font-size: 14px;">PT JASA MARGA (PERSERO) Tbk.</span><br>
    <span style="font-size: 14px;">Tanggal : </span><span>{{$dtfrom}} - {{$dtto}}</span><br>

    <h5>REKAP PENDAPATAN DATA TRANSAKSI</h5>
    <?php 
        /* Count data rows */
        $recap_data_count = count($recap_data);
        $history_data_count = count($history_data);
    ?>

    <table class="table" style="font-size: 12px; width: 100%;">
        <thead>
        <tr align="center" class=" bg-blue white">
            <td rowspan="2">No</td>
            <td rowspan="2">Tanggal</td>
            <td rowspan="2">Gerbang Tol</td>
            <td rowspan="2">Lane</td>
            <td rowspan="2">Shift</td>
            <td colspan="4">Golongan</td>
            <td rowspan="2">Transaksi</td>
            <td rowspan="2">Pendapatan (Rp.)</td>
        </tr>

        <tr align="center" class=" bg-blue white">
            <td>I</td>
            <td>II</td>
            <td>III</td>
            <td>IV</td>
        </tr>

        </thead>
        <tbody>

            @php ($i=1)
            @foreach ($recap_data as $key => $item)
                <tr>
                    <td >{{ $i }}</td>
                    <td >{{ date('d F Y', strtotime( $item->tanggal )) }}</td>
                    <td >{{ $item->gerbang_tol }}</td>
                    <td >{{ $item->lane }}</td>
                    <td >{{ $item->shift }}</td>
                    <td align="left">{{ $item->GOL001 }}</td>
                    <td align="left">{{ $item->GOL002 }}</td>
                    <td align="left">{{ $item->GOL003 }}</td>
                    <td align="left">{{ $item->GOL004 }}</td>
                    <td align="left">{{ $item->TRANSAKSI}}</td>
                    <td align="right">{{ number_format(intval($item->PENDAPATAN)) }}</td>
                </tr>
                @php ($i++)

                    @if($i % 20 ==0)
                    

                            <table class="table page-break" style="font-size: 12px; width: 100%;">
                                <thead>
                                    <tr align="center" class=" bg-blue white">
                                        <td rowspan="2">No</td>
                                        <td rowspan="2">Tanggal</td>
                                        <td rowspan="2">Gerbang Tol</td>
                                        <td rowspan="2">Lane</td>
                                        <td rowspan="2">Shift</td>
                                        <td colspan="4">Golongan</td>
                                        <td rowspan="2">Transaksi</td>
                                        <td rowspan="2">Pendapatan</td>
                                    </tr>
                                    <tr align="center" class=" bg-blue white">
                                        <td>I</td>
                                        <td>II</td>
                                        <td>III</td>
                                        <td>IV</td>
                                    </tr>
                                </thead>
                                <tbody>

                    @endif

            @endforeach
                <?php
                    $total_recap_amount = 0;
                    $total_recap_transaction = 0;

                    foreach($recap_data as $key=>$val){
                        $total_recap_transaction += $val->TRANSAKSI;
                        $total_recap_amount += $val->PENDAPATAN;
                    }
                ?>
                <tr>
                    <td colspan="9"><strong>TOTAL</strong></td>
                    <td align="left">{{ $total_recap_transaction }}</td>
                    <td align="right">{{ number_format(intval($total_recap_amount)) }}</td>
                </tr>

        </tbody>

        <tfoot>
        </tfoot>
    </table>


    <div class="page-break"></div>
    <h5>DATA TRANSAKSI</h5>

    <table class="table" style="font-size: 12px;width: 100%">
        
            <tr align="center" class=" bg-blue white">
                <th >No</th>
                <th >Tanggal</th>
                <th >Jam</th>
                <th >Gerbang Tol</th>
                <th >Lane</th>
                <th >Shift</th>
                <th >Gol</th>
                <th >ID Perangkat</th>
                <th >Customer</th>
                <th >Jumlah (Rp.)</th>
                <th >Usr Type</th>
                <th >Status</th>
            </tr>
        

        
            
            @php ($i=1)
            @foreach ($history_data as $key => $item)
                <tr>
                    <td >{{ $i }}</td>
                    <td >{{ $item->tanggal }}</td>
                    <td >{{ $item->jam }}</td>
                    <td >{{ $item->gerbang_tol }}</td>
                    <td >{{ $item->lane }}</td>
                    <td >{{ $item->shift }}</td>
                    <td >{{ $item->golongan }}</td>
                    <td >{{ $item->NO_SERIAL_OBU }}</td>
                    <td >{{ $item->customer }}</td>
                    <td align="right">{{ number_format(intval($item->jumlah)) }}</td>
                    <td >{{ $item->USER_TYPE }}</td>
                    <td >{{ $item->status }}</td>
                </tr>
                @php ($i++)

                @if($i % 35 == 0)

                    <table class="table page-break" style="font-size: 12px;width: 100%">
                        <tr align="center" class=" bg-blue white">
                            <th >No</th>
                            <th >Tanggal</th>
                            <th >Jam</th>
                            <th >Gerbang Tol</th>
                            <th >Lane</th>
                            <th >Shift</th>
                            <th >Gol</th>
                            <th >ID Perangkat</th>
                            <th >Customer</th>
                            <th >Jumlah (Rp.)</th>
                            <th >Usr Type</th>
                            <th >Status</th>
                        </tr>

                @endif

            @endforeach

        
    </table>


</div>