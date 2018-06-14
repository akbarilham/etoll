@section('gatelist')

<?php 
    // $id = $_GET['p_plaza_id'];
    $id = 1;
?>

<div class="col-md-12 col-lg-12">
    <div class="content-box">
        <div class="head info-bg clearfix">
            <h5 class="content-title pull-left">Plaza Line</h5>
            <div class="functions-btns pull-right">
                <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
            </div>
        </div>

    <?php /*    
        <div class="content">

            <div class="row">
                <div class="col-md-12">

                    {!! Form::open(['url' => 'tollplaza/gateindex', 'role' => 'form', 'id' => 'list-filter-gate', 'method' => 'get', 'class'=>'form-inline' ]) !!}
                    <div class="form-group">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=> 'Search', 'onchange' => 'setGateList("gatelist", "", $id, "")' ]) !!}
                        <?php // <input class="form-control" placeholder="Search" onchange="setGateList('gatelist', '1', {!!$id!!}, '5')" name="search" type="text"> // ?>
                    </div>
                    <div class="form-group">
                        {!! Form::select('searchby', $result->searchby, null, ['class' => 'form-control',  'onchange' => 'setGateList("gatelist")' ]) !!}
                    </div> 
                    <div class="form-group">
                        {!! Form::select('perpage', [5=>5, 10=>10, 30=>30, 100=>100], null, ['class' => 'form-control',  'onchange' => 'setGateList("gatelist")']) !!}
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="page" type="hidden" value="1" />
                        <button class="btn btn-success" type="button"  onclick="addsNew('new', 'p_plaza_gate_id', '{!! $id !!}')">Add New</button>
                    </div>

                    {!! Form::close() !!}
                
                </div>
            </div>

        </div>
        */ ?>

    </div>
</div>

<?php 

$this->tableHead = (object) $result->tableHead;
$this->tableBody = (object) $result->dataQuery;

    $table = '
    <table class="table table-hover">
        <thead>
            <tr>';

            $table .= '<th> No <th>';

            if($this->tableHead != null)
            {
                foreach($this->tableHead as $key=>$value)
                {
                    $table .= '<th>'.$value->head.'</th>';
                }
            }
            
                $table .= '<th> Action <th>';
            

    $table .= '</tr>
        </thead>
        <tbody>';
            if($this->tableBody != null)
            {
                $no = ($this->tableBody->currentPage-1) * $this->tableBody->perpage+1;

                foreach($this->tableBody->body as $rowKey=>$row)
                {
                    $arraydata = (array) $row;
                    $datas = implode('|', array_values($arraydata));

                    $table .= '<tr>';

                    $table .= '<td>'.$no.'.<td>';

                    if($this->tableHead != null)
                    {
                        foreach($this->tableHead as $headKey=>$head)
                        {
                            $table .= '<td>'.$row->$headKey.'</td>';
                        }
                    }

                    $table .= '<td>';

                    // $search = $_GET['search'];
                    $searchby = "gate_code"; 
                    
                    $table .=  '
                    <button class="btn btn-sm btn-primary edit link btn-sm-c-1" data-toggle="tooltip" title="edit" onclick="doViewDetail(\'viewdetail\', \''. $row->p_plaza_gate_id.'\', \''.$datas.'\')"><i class="zmdi zmdi-edit"></i></button>&nbsp;
                    <button class="btn btn-sm btn-danger delete link btn-sm-c-1" data-toggle="tooltip" title="delete" _token="'.csrf_token().'" onclick="doDeletes($(this), \'tollplaza/mydelete\', \''.$row->p_plaza_gate_id.'\', \'p_plaza_gate_id\')"><i class="zmdi zmdi-delete"></i></button>';

                    $table .= '</td>';

                    $table .= '</tr>';

                    $no++;
                }
            }
        $perpage  = $this->tableBody->perpage;
        $page = $this->tableBody->currentPage;

        $table .= '</tbody>
    </table>
    ';

    $table .=   
    '<div class="form-group">
        <input type="hidden" name="id" value="1">
        <input name="_token" id="token" type="hidden" value="'.csrf_token().'"/>
        <button type="button" class="btn btn-default" style="margin-bottom:10px" data-dismiss="modal"onclick="setList(\'list\');">Back</button>
    </div>';

    /* Pagination */
    $currentPage = $this->tableBody->currentPage;
    $lastPage = $this->tableBody->lastPage;
    $nextPage = $currentPage == $lastPage ? $currentPage : $currentPage + 1;
    $previousPage = $currentPage == 1 ? 1 : $currentPage - 1;

    /* Total page information */

    $table .='<span class="pagination text-muted">'.$lastPage.' Pages in total&nbsp;</span>'; 

    $table .= '<ul class="pagination pagination-sm no-margin pull-right">';

    $table .= $previousPage == $currentPage ? '' : '<li onclick="setGateList(\'gatelist\', \''.$previousPage.'\', \''.$id.'\', \''.$perpage.'\')"><a href="#" data-toggle="tooltip" title="'.trans('general.prev-page').'">«</a></li>';

    /* prevent display pagination if only have 1 page; pagination loop if only has more than 1 page */
    if($lastPage > 1)
    {

        /* Pagination Core Loop goes here */
        $spareNext = ($lastPage - $currentPage) > 3 ? $currentPage + 3 : ($currentPage + ($lastPage - $currentPage));

        $sparePrev = $currentPage > 3 ? $currentPage - 3 : 1 ;

        for ($i = $sparePrev; $i <= $spareNext; $i++) {

            if($i == $currentPage)
            {   
                $table .= '<li class="active" onclick="setGateList(\'gatelist\', \''.$i.'\', \''.$id.'\', \''.$perpage.'\')"><a href="#">'.$i.'</a></li>';
            }else{
                $table .= '<li onclick="setGateList(\'gatelist\', \''.$i.'\', \''.$id.'\', \''.$perpage.'\')"><a href="#" data-toggle="tooltip" title="'.trans('general.page').$i.'">'.$i.'</a></li>';
            }
            
        }
        /* Pagination Core Loop ends here */

    }

    $table .= $nextPage == $currentPage ? '' : '<li onclick="setGateList(\'gatelist\', \''.$nextPage.'\', \''.$id.'\', \''.$perpage.'\')"><a href="#" data-toggle="tooltip" title="'.trans('general.next-page').'">»</a></li>';

    $table .= '</ul>';

    /* Pagination end */

    /* Table script */

    $table .= '<script>
        $(\'[data-toggle="tooltip"]\').tooltip(); 
    </script>';

    print $table;

?>
@endsection

@yield('gatelist')
<script type="text/javascript">
function setGateList(request, pagination, p_plaza_id, perpage)
{   
    $('.custom-content-form').html('').hide();
    $('.panel-heading').hide();
    $('.custom-content-list').show();

    $("#list-table-container").LoadingOverlay("show");

    var request = request || '';
    var pagination = pagination || '';
    var p_plaza_id = p_plaza_id || '';
    var perpage = perpage || '';
    var filter = $('#list-filter-gate').serialize();
    filter += '&request=' + request + '&page=' + pagination + '&p_plaza_id=' + p_plaza_id + '&perpage=' + perpage;
    // console.log('filter =  ' + filter); return false;
    var url = 'tollplaza/gateindex';

    
    $.ajax({
        url : url,
        data : filter,
        type : 'get',
        success: function(response) {
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
            $('#list-table-container').html(response);
            $("#list-table-container").LoadingOverlay("hide");
        },
        error: function (xhr, status, error){
            
        }
    });
    return false;
}

function setList(request, pagination)
{   
    $('.custom-content-form').html('').hide();
    $('.head').show();
    $('.panel-heading').show();
    $('.custom-content-list').show();

    $("#list-table-container").LoadingOverlay("show");

    var request = request || '';
    var pagination = pagination || '';
    var filter = $('#list-filter').serialize();
    filter += '&request=' + request + '&page=' + pagination;
    var url = '';

    
    $.ajax({
        url : url,
        data : filter,
        type : 'get',
        success: function(response) {
            //redirect of token expired
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }

            $('#list-table-container').html(response);
            $("#list-table-container").LoadingOverlay("hide");
        },
        error: function (xhr, status, error){
            
        }
    });
    return false;
}
</script> 