<?php

namespace App\Http\Controllers\Pages\Master;

use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use App\ClientAPI\ClientAPI;

class OperatorController extends Scaffolding {

    use ClientAPI;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'mst_operator';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::master_operator_index;
        $this->listView = ViewPaths::master_operator_list ;
        $this->newView = ViewPaths::master_operator_new;
        $this->editView = ViewPaths::master_operator_edit;

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
           'code'=>[
                'head' => 'Code',
                'tableName' => 'mst_operator',
                'tableField'=> 'code'
            ],
            'name'=>[
                'head' => 'Operator',
                'tableName' => 'mst_operator',
                'tableField'=> 'name'
            ],
        ];

        parent::__construct();
        $this->baseURI(); 
        $this->saveAPIUrl = 'master/operator/do/insert';
        $this->updateAPIUrl = 'master/operator/do/update';
        $this->deleteAPIUrl = 'master/operator/do/delete';
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

            $response = $this->client->post('master/operator/get/list',
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
            $response = $this->client->post('master/operator/get/list', 
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
            $response = $this->client->post('master/operator/get/row_by_id',
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
