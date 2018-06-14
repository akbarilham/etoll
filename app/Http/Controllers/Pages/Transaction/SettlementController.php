<?php

namespace App\Http\Controllers\Pages\Transaction;

use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use App\ClientAPI\ClientAPI;

class SettlementController extends Scaffolding {

    use ClientAPI;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 't_log_settlement';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::transaction_settlement_index;
        $this->listView = ViewPaths::transaction_settlement_list ;
        $this->newView = ViewPaths::transaction_settlement_new;
        $this->editView = ViewPaths::transaction_settlement_edit;

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
           'filename'=>[
                'head' => 'File name',
                'tableName' => 't_log_settlement',
                'tableField'=> 'filename'
            ],
            'shiftdate'=>[
                'head' => 'Date',
                'tableName' => 't_log_settlement',
                'tableField'=> 'shiftdate'
            ],
            'trxamount'=>[
                'head' => 'Amount',
                'tableName' => 't_log_settlement',
                'tableField'=> 'trxamount'
            ],
            'trxcount'=>[
                'head' => 'Count',
                'tableName' => 't_log_settlement',
                'tableField'=> 'trxcount'
            ],
            'ftpdestination'=>[
                'head' => 'Destination',
                'tableName' => 't_log_settlement',
                'tableField'=> 'ftpdestination'
            ],
            'ftpstatus'=>[
                'head' => 'Status',
                'tableName' => 't_log_settlement',
                'tableField'=> 'ftpstatus'
            ],
        ];

        parent::__construct();
        $this->listTable->allowEdit(false);
        $this->listTable->allowDelete(false);
        $this->baseURI(); 
        $this->saveAPIUrl = 'transaction/settlement/do/insert';
        $this->updateAPIUrl = 'transaction/settlement/do/update';
        $this->deleteAPIUrl = 'transaction/settlement/do/delete';
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

            $response = $this->client->post('transaction/settlement/get/list',
                    [
                        'json'    => [
                            'page' => $this->listFilter['page'] != null ? $this->listFilter['page'] : 1,
                            'perpage' => $this->listFilter['perpage'],
                            'filter' => [
                                "lower(".$searchby.")" => [
                                    'like' => '%'.strtolower($this->listFilter['search']).'%'
                                ]
                            ]
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $result->dataQuery = json_decode($response->getBody());

        }else{

            /* Put listing query without search word here.. */
            $response = $this->client->post('transaction/settlement/get/list', 
                    [
                        'json'    => [
                            'page' => $this->listFilter['page'] != null ? $this->listFilter['page'] : 1,
                            'perpage' => $this->listFilter['perpage']
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $result->dataQuery = json_decode($response->getBody());
        }

        return $result;
        
    }


    /* getNewData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding new page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getNewData()
    {   
        $result = new \stdClass();
            
        return $result;
        
    }


    /* getEditData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding editing page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getEditData()
    {   
        $result = new \stdClass();

        if(isset($_GET['id']) && $_GET['id'] != '')
        {
            $response = $this->client->post('transaction/settlement/get/row_by_id',
                    [
                        'json'    => [
                            'id' => $_GET['id']
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $result->dataQuery = json_decode($response->getBody());
        }

            return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    public function setSaveBody()
    {
        $data = $this->getPostData();

        // echo "<pre>",print_r($data);die();

        /* Add payload here */
        $body = [

            'code' => isset($data['code']) ? $data['code'] : '',
            'name' => isset($data['name']) ? $data['name'] : '',
            'status' => isset($data['status']) ? $data['status'] : '',
        ];

        $this->saveBody = $body;
    }


    /* setUpdateBody should be implemented due to Scaffolding updating system. it is building Payload data before updating to database */

    public function setUpdateBody()
    {
        $data = $this->getPostData();

        //echo "<pre>",print_r($data);die();

        /* Add payload here */
        $body = [
            'id' => isset($data['id']) ? $data['id'] : '',
            'code' => isset($data['code']) ? $data['code'] : '',
            'name' => isset($data['name']) ? $data['name'] : '',
            'status' => isset($data['status']) ? $data['status'] : '',
        ];

        $this->updateBody = $body;
    }

}

?>
