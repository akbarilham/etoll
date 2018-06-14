<?php

namespace App\Http\Controllers\Pages\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\P_USER;
use App\Models\P_ROLE;
use App\Models\P_MENU;
use App\Models\P_ROLE_MENU;
use App\ClientAPI\ClientAPI;

class UserRoleController extends Scaffolding {

    use ClientAPI;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'p_role';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::security_user_role_index;
        $this->listView = ViewPaths::security_user_role_list;
        $this->newView = ViewPaths::security_user_role_new;
        $this->editView = ViewPaths::security_user_role_edit;

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
            'code'=>[
                'head' => 'Role Name',
                'tableName' => 'p_role',
                'tableField'=> 'code'
            ]
        ];

        parent::__construct();

        $this->listTable->setPrimaryKey('p_role_id');
        $this->listTable->allowDelete(false);
        $this->primaryKey = 'p_role_id';

        $this->saveAPIUrl = 'user_role/do/save';
        $this->updateAPIUrl = 'user_role/do/save';
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

            $response = $this->client->post('security/user_role/get/list',
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

           $response = $this->client->post('security/user_role/get/list', 
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

        $response = $this->client->post('security/user_role/get/new_data', 
                    [
                        'json'    => [],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $result->menus = json_decode($response->getBody());
        // echo "<pre>",print_r($result);die();
        return $result;
        
    }


    /* getEditData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding editing page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getEditData()
    {   
        $result = new \stdClass();

        if(isset($_GET['id']) && $_GET['id'] != '')
        {
            $response = $this->client->post('security/user_role/get/row_by_id', 
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

            $result = json_decode($response->getBody());
        }
        //echo "<pre>",print_r($result);die();

        return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    public function setSaveBody()
    {
        $data = $this->getPostData();

        $body = [

            'code' => isset($data['name']) ? $data['name'] : '',
            'is_active' => isset($data['is_active']) ? $data['is_active'] : 'Y',
            'description' => isset($data['description']) ? $data['description'] : '',
            'creation_date' => date('Y-m-d H:i:s'),
            'created_by' => \Session::get('logged_user')['username'],
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => \Session::get('logged_user')['username']

        ];
        // echo "<pre>",print_r($body);die();
        $this->saveBody = $body;
    }


    /* setUpdateBody should be implemented due to Scaffolding updating system. it is building Payload data before updating to database */

    public function setUpdateBody()
    {
        $data = $this->getPostData();

        /* Add payload here */
        $body = [

            'id' => isset($data['id']) ? $data['id'] : '', 

            'code' => isset($data['name']) ? $data['name'] : '',
            'is_active' => isset($data['is_active']) ? $data['is_active'] : 'Y',
            'description' => isset($data['description']) ? $data['description'] : '',
            'creation_date' => date('Y-m-d H:i:s'),
            'created_by' => \Session::get('logged_user')['username'],
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => \Session::get('logged_user')['username']

        ];

        $this->updateBody = $body;

    }

    public function save(Request $request)
    {

        $this->setSaveBody($request);
        $this->saveBody['menus'] = $request->menus;
        //echo "<pre>",print_r($this->saveBody);die();
        try{

            $response = $this->client->post($this->saveAPIUrl,
                    [
                        'json'    => $this->saveBody,
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>$responseBody->message]);
            }else {
                echo json_encode(['status'=>'error', 'msg'=> $responseBody->message]);
            }

        }catch(\Exception $e){
            
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to add data.']);

        }
        
    }

    public function update(Request $request)
    {

        $this->setUpdateBody($request);
        $this->updateBody['menus'] = $request->menus;
        try{

            $response = $this->client->post($this->updateAPIUrl,
                    [
                        'json'    => $this->updateBody,
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success updating data']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=> 'Success updating data']);
            }

        }catch(\Exception $e){
            
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to add data.']);

        }
    }   

}

?>