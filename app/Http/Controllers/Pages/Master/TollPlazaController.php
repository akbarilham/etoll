<?php

namespace App\Http\Controllers\Pages\Master;

use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Utils\TablePlaza;
use App\ClientAPI\ClientAPI;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class TollPlazaController extends Scaffolding {
    use ClientAPI;

    public function __construct() 
    {

        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'p_plaza';
        $this->DBTableGate = 'p_plaza_gate';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::master_tollplaza_index;
        $this->listView = ViewPaths::master_tollplaza_list;
        $this->newView = ViewPaths::master_tollplaza_new;
        $this->editView = ViewPaths::master_tollplaza_edit;
        $this->gateView = 'pages.master.toll_plaza.plaza_gate.index';

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
           'plaza_code'=>[
                'head' => 'Plaza Code',
                'tableName' => 'p_plaza',
                'tableField'=> 'plaza_code'
            ],
            'plaza_name'=>[
                'head' => 'Plaza Name',
                'tableName' => 'p_plaza',
                'tableField'=> 'plaza_name'
            ],
            'total_gate'=>[
                'head' => 'Total Line',
                'tableName' => 'p_plaza_gate',
                'tableField'=> 'gate_code'
            ]
        ];

        parent::__construct();
        $this->listTable =  new TablePlaza();
        $this->listTable->setPrimaryKey('p_plaza_id');
        $this->primaryKey = 'p_plaza_ID';  
        $this->baseURI();
    }


    /* getIndexData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding index page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getIndexData()
    {
        $result = new \stdClass();
            
        return $result;
    }


    /* getListData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding list page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getListData()
    {   
        $result = new \stdClass();

        if(isset($this->listFilter['search']) && $this->listFilter['search'] != '')
        {

            /* Put listing query with search here.. */
            $searchby = $this->listTableHead[ $this->listFilter['searchby'] ]['tableName'].'.'.$this->listTableHead[ $this->listFilter['searchby'] ]['tableField'];

            $response = $this->client->post('tollplaza/get/search', [
                'json' => ['token' => $this->getToken(),
                'val' => $this->listFilter['search'],
                'col' => $searchby,
                'pageSize' => $this->listFilter['perpage'],
                'page' => $this->listFilter['page']
                ]
            ]);
            $res =json_decode($response->getBody());
            $result->dataQuery = $res;

        }else{

            /* Put listing query without search word here.. */
            $response = $this->client->post('tollplaza/get/list', [
                'json' => ['token' => $this->getToken(),
                'pageSize' => $this->listFilter['perpage'],
                'page' => $this->listFilter['page']
                ]
            ]);
            $res =json_decode($response->getBody());
            $result->dataQuery = $res;
            if ($result->dataQuery == null) {
                $result->dataQuery = new \stdClass();
                $result->dataQuery->value = false;
            }

        }

        return $result;
        
    }


    /* nextGateIndex are custom additional function to push the Plaza Gate data because it need it for make data layout refer scaffolding table */

    public function nextGateIndex()
    {
        $result = new \stdClass();

        if(isset($this->listFilter['search']) && $this->listFilter['search'] != '')
        {
            
            $this->listTableHead = [
               'gate_code'=>[
                    'head' => 'Line Code',
                    'tableName' => 'p_plaza_gate',
                    'tableField'=> 'gate_code'
                ],
                'seq_no'=>[
                    'head' => 'Sequence Number',
                    'tableName' => 'p_plaza_gate',
                    'tableField'=> 'seq_no'
                ],
                'description'=>[
                    'head' => 'Description',
                    'tableName' => 'p_plaza_gate',
                    'tableField'=> 'description'
                ]
            ];

            $result->searchby = $this->getSearchOption($this->listTableHead);

            $result->tableHead = json_decode(json_encode($this->listTableHead));

           /* Put listing query with search here.. */
            $searchby = $this->listTableHead[ $this->listFilter['searchby'] ]['tableName'].'.'.$this->listTableHead[ $this->listFilter['searchby'] ]['tableField'];

            $response = $this->client->post('tollplaza/get/gate_search', [
                'json' => ['token' => $this->getToken(),
                'val' => $this->listFilter['search'],
                'col' => $searchby,
                'pageSize' => $this->listFilter['perpage'],
                'page' => $this->listFilter['page']
                ]
            ]);
            $res =json_decode($response->getBody());
            $result->dataQuery = $res;

        } else {

            $this->listTableHead = [
               'gate_code'=>[
                    'head' => 'Line Code',
                    'tableName' => 'p_plaza_gate',
                    'tableField'=> 'gate_code'
                ],
                'seq_no'=>[
                    'head' => 'Sequence Number',
                    'tableName' => 'p_plaza_gate',
                    'tableField'=> 'seq_no'
                ],
                'description'=>[
                    'head' => 'Description',
                    'tableName' => 'p_plaza_gate',
                    'tableField'=> 'description'
                ]
            ];

            $result->searchby = $this->getSearchOption($this->listTableHead);

            $result->tableHead = json_decode(json_encode($this->listTableHead));

            $response = $this->client->post('tollplaza/get/gate_list', [
                'json' => ['token' => $this->getToken(),
                'val' => $_GET['p_plaza_id'],
                'pageSize' => $this->listFilter['perpage'],
                'page' => $this->listFilter['page']
                ]
            ]);
            $res =json_decode($response->getBody());
            $result->dataQuery = $res;

        }

        // return view( $this->gateView, compact('result') );
        return view( $this->gateView )->with(['result' => $result]);

    }


    /* getViewTotalData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding new page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getViewTotalData()
    {   

        if(isset($_GET['id']) && $_GET['id'] != '') {
            $datas = explode("|", $_GET['datas']);

            $str = '<meta name="csrf-token" content="'.csrf_token().'">';
            $str .= "<div class='modal-body'>";
            $str .= "<form action='tollplaza/update' role='form' data-validate='parsley'>";
            $str .= "<input type='hidden' name='p_plaza_id' value=\"".$datas[0]."\">";
            $str .= "<div class='form-group'>
                        <label for='plaza_code'>Plaza Code</label>
                        <input type='text' name='plaza_code' class='form-control' placeholder='Plaza Code' value=\"".$datas[1]."\" required='true'>
                    </div>";
            $str .= "<div class='form-group'>
                        <label for='plaza_name'>Plaza Name</label>
                        <input type='text' name='plaza_name' class='form-control' placeholder='Plaza Name' value=\"".$datas[2]."\" required='true'>
                    </div>";                    
            $str .= '<button type="button" name="approval_status" class="btn btn-success pull-right" onclick="doSaves($(this))">Save</button>';
            $str .= "<button type='button' class='btn btn-default pull-right' style='margin-right:10px' data-dismiss='modal' onclick='setList(\"list\")'>Close</button>";
            $str .= "<div style='clear:both'></div>";
            $str .= "</form>
                </div>";

            echo $str;
        }
        
    }    


    /* getViewDetailData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding new page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getViewDetailData()
    {   

        if(isset($_GET['id']) && $_GET['id'] != '') {

            $datas = explode("|", $_GET['datas']);

            $str = '<meta name="csrf-token" content="'.csrf_token().'">';
            $str .= "<div class='modal-body'>";
            $str .= "<form action='tollplaza/update' role='form' data-validate='parsley'>";
            $str .= "<input type='hidden' name='p_plaza_gate_id' value=\"".$datas[0]."\">";            
            $str .= "<div class='form-group'>
                        <label for='gate_code'>Line Code</label>
                        <input type='text' name='gate_code' class='form-control' placeholder='Line Code' value=\"".$datas[1]."\" required='true'>
                    </div>";
            $str .= "<div class='form-group'>
                        <label for='seq_no'>Sequence Number</label>
                        <input type='text' name='seq_no' class='form-control' placeholder='Sequence Number' value=\"".$datas[2]."\" required='true'>
                    </div>";
            $str .= "<div class='form-group'>
                        <label for='description'>Description</label>
                        <input type='text' name='description' class='form-control' placeholder='Description' value=\"".$datas[3]."\" required='true'>
                    </div>";
            $str .= "<input type='hidden' name='p_plaza_id' value=\"".$datas[4]."\">";
            $str .= '<button type="button" name="approval_status" class="btn btn-success pull-right" onclick="doSaves($(this))">Save</button>';
            $str .= "<button type='button' class='btn btn-default pull-right' style='margin-right:10px' data-dismiss='modal' onclick='setList(\"list\")'>Close</button>";
            $str .= "<div style='clear:both'></div>";
            $str .= "</form>
                </div>";

            echo $str;
        }

        
    }        


    /* getNewData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding new page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getNewData()
    {   
        $result = new \stdClass();

        return $result;
        
    }    


    /* getNewPlazaData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding new page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getNewPlazaData()
    {   
        $countData = DB::table($this->DBTableName)
                    ->select($this->DBTableName.'.p_plaza_id', $this->DBTableName.'.plaza_name')
                    ->get();

        if(isset($_GET['param']) && $_GET['param'] != '') {

            if ($_GET['param'] == 'p_plaza_id') {

                $str = '<meta name="csrf-token" content="'.csrf_token().'">';
                $str .=     '<div class="modal-body">';
                $str .=         '<form action="tollplaza/save" role="form" data-validate="parsley">';
                $str .=             '<input type="hidden" name="p_plaza_id" value="">';
                $str .=                 '<div class="form-group">';
                $str .=                     '<label for="plaza_code">Plaza Code</label>';
                $str .=                     '<input type="text" name="plaza_code" class="form-control" placeholder="Plaza Code" value="" required="true">';
                $str .=                 '</div>';
                $str .=                 '<div class="form-group">';
                $str .=                     '<label for="plaza_code">Plaza Name</label>';
                $str .=                     '<input type="text" name="plaza_name" class="form-control" placeholder="Plaza Name" value="" required="true">';
                $str .=                 '</div>';    
                $str .= '<button type="button" name="save" class="btn btn-success pull-right" onclick="doSaves($(this))">Save</button>';
                $str .= '<button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList(\'list\')">Close</button>';
                $str .=             '<div style="clear:both"></div>';
                $str .=         '</form>';
                $str .=     '</div>';

                echo $str;

            } else if ($_GET['param'] == 'p_plaza_gate_id') {

                $str = '<meta name="csrf-token" content="'.csrf_token().'">';
                $str .=     '<div class="modal-body">';
                $str .=         '<form action="tollplaza/save" role="form" data-validate="parsley">';
                $str .=             '<input type="hidden" name="p_plaza_gate_id" value="">';
                if ($_GET['id'] == null) {
                    $str .=                 '<div class="form-group">';
                    $str .=                     '<label for="gate_code">Plaza ID</label>';
                    $str .=                     '<select class="form-control" name="p_plaza_id">';
                    foreach ($countData as $objectCountData) {
                        $str .=                         '<option value="'.$objectCountData->p_plaza_id.'">'.$objectCountData->plaza_name.'</option>';
                    }                
                    $str .=                     '</select>';
                    $str .=                 '</div>'; 
                } else {
                    $str .= '<input type="hidden" name="p_plaza_id" value="'.$_GET['id'].'">'; 
                }
                $str .=                 '<div class="form-group">';
                $str .=                     '<label for="gate_code">Line Code</label>';
                $str .=                     '<input type="text" name="gate_code" class="form-control" placeholder="Line Code" value="" required="true">';
                $str .=                 '</div>';
                $str .=                 '<div class="form-group">';
                $str .=                     '<label for="seq_no">Sequence Number</label>';
                $str .=                     '<input type="text" name="seq_no" class="form-control" placeholder="Sequence Number" value="" required="true">';
                $str .=                 '</div>';    
                $str .=                 '<div class="form-group">';
                $str .=                     '<label for="description">Description</label>';
                $str .=                     '<input type="text" name="description" class="form-control" placeholder="Description" value="" required="true">';
                $str .=                 '</div>';                    
                $str .= '<button type="button" name="save" class="btn btn-success pull-right" onclick="doSaves($(this))">Save</button>';
                $str .= '<button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList(\'list\')">Close</button>';
                $str .=             '<div style="clear:both"></div>';
                $str .=         '</form>';
                $str .=     '</div>';

                echo $str;

            }

        }
        
    }


    /* getEditData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding editing page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getEditData()
    {   
        $result = new \stdClass();

        if(isset($_GET['id']) && $_GET['id'] != '')
        {
            $result->dataQuery =  DB::table($this->DBTableGate)->where('p_plaza_gate_id', '=', $_GET['p_plaza_gate_id'] )->first();         
        }

        return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    public function setSaveBody()
    {
        $data = $this->getPostData();
        $switchvar = key($data);

        switch ($switchvar) {

            case 'p_plaza_id':

                $response = $this->client->post('tollplaza/do/insert', [
                    'json'       => ['token' => $this->getToken(),
                    'plaza_code' => isset($data['plaza_code']) ? $data['plaza_code'] : '',
                    'plaza_name' => isset($data['plaza_name']) ? $data['plaza_name'] : '',
                    'created_by' => \Session::get('logged_user')['username']
                    ]
                ]);
                $res = json_decode($response->getBody());
                $this->saveBody = $res;

                break;

            case 'p_plaza_gate_id':

                $response = $this->client->post('tollplaza/do/gate_insert', [
                    'json'          => ['token' => $this->getToken(),
                    'gate_code'     => isset($data['gate_code']) ? $data['gate_code'] : '',
                    'seq_no'        => isset($data['seq_no']) ? $data['seq_no'] : '',
                    'p_plaza_id'    => isset($data['p_plaza_id']) ? $data['p_plaza_id'] : '',
                    'description'   => isset($data['description']) ? $data['description'] : '',
                    'created_by'    => \Session::get('logged_user')['username']
                    ]
                ]);
                $res = json_decode($response->getBody());
                $this->saveBody = $res;
                break;

            default:
                return json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to add data.']);
                break;
        }

    }


    /* setUpdateBody should be implemented due to Scaffolding updating system. it is building Payload data before updating to database */

    public function setUpdateBody()
    {
        $data = $this->getPostData();
        $switchvar = key($data);

        switch ($switchvar) {

            case 'p_plaza_id':

                $response = $this->client->post('tollplaza/do/update', [
                    'json'       => ['token' => $this->getToken(),
                    'p_plaza_id' => isset($data['p_plaza_id']) ? $data['p_plaza_id'] : '',
                    'plaza_code' => isset($data['plaza_code']) ? $data['plaza_code'] : '',
                    'plaza_name' => isset($data['plaza_name']) ? $data['plaza_name'] : '',
                    'updated_by' => \Session::get('logged_user')['username']
                    ]
                ]);
                $res = json_decode($response->getBody());
                $this->updateBody = $res;

                break;

            case 'p_plaza_gate_id':

                $response = $this->client->post('tollplaza/do/gate_update', [
                    'json'            => ['token' => $this->getToken(),
                    'p_plaza_gate_id' => isset($data['p_plaza_gate_id']) ? $data['p_plaza_gate_id'] : '',
                    'gate_code'       => isset($data['gate_code']) ? $data['gate_code'] : '',
                    'seq_no'          => isset($data['seq_no']) ? $data['seq_no'] : '',
                    'p_plaza_id'      => isset($data['p_plaza_id']) ? $data['p_plaza_id'] : '',
                    'description'     => isset($data['description']) ? $data['description'] : '',
                    'updated_by'      => \Session::get('logged_user')['username']
                    ]
                ]);
                $res = json_decode($response->getBody());
                $this->updateBody = $res;

                break;

            default:
                return json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);
                break;
        }

    }

    /* myDeleteExec should be implemented due to Scaffolding updating system. it is building Delete data */

    public function myDeleteExec()
    {
        $data = $this->getPostData();
        $switchvar = $data['tollplaza'];

        switch ($switchvar) {

            case 'p_plaza_id':

                $response = $this->client->post('tollplaza/do/delete', [
                    'json'       => ['token' => $this->getToken(),
                    'p_plaza_id' => isset($data['p_plaza_id']) ? $data['p_plaza_id'] : ''
                    ]
                ]);
                $res = json_decode($response->getBody());
                $this->deleteBody = $res;

                break;

            case 'p_plaza_gate_id':
                $response = $this->client->post('tollplaza/do/gate_delete', [
                    'json'            => ['token' => $this->getToken(),
                    'p_plaza_gate_id' => isset($data['p_plaza_gate_id']) ? $data['p_plaza_gate_id'] : ''
                    ]
                ]);
                $res = json_decode($response->getBody());
                $this->deleteBody = $res;
                break;

            default:
                return json_encode(['status'=>'error', 'msg'=>'Sorry, datas was failed.']);
                break;
        }

    }      

    public function save(Request $request)
    {
        $this->setSaveBody($request);

        if($this->saveBody->code == '200') {

            echo json_encode(['status'=>'success', 'msg'=>'Success adding data!']);

        } else {

            echo json_encode(['status'=>'error', 'msg'=> $this->saveBody->message ]);

        }
        
    }  

    public function update(Request $request)
    {
        $this->setUpdateBody();

        if($this->updateBody->code == '200') {

            echo json_encode(['status'=>'success', 'msg'=>'Success updating data!']);

        } else {

            echo json_encode(['status'=>'error', 'msg'=> $this->updateBody->message ]);

        }

    } 

    public function myDelete(Request $request)
    {

        $this->myDeleteExec($request);

        if($this->deleteBody->code == '200') {

            echo json_encode(['status'=>'success', 'msg'=>'Success deleting data!']);

        } else {

            echo json_encode(['status'=>'error', 'msg'=> $this->deleteBody->message ]);

        }

    }       

}

?>