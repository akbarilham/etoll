<?php

namespace App\Http\Controllers\Pages\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\P_USER;
use App\Models\P_USER_ROLE;
use App\Utils\TableUserPrivilege;
use App\ClientAPI\ClientAPI;

class UserPrivilegeController extends Scaffolding {

    use ClientAPI;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'p_user';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::security_user_privilege_index;
        $this->listView = ViewPaths::security_user_privilege_list;
        $this->newView = ViewPaths::security_user_privilege_new;
        $this->editView = ViewPaths::security_user_privilege_edit;

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
            'full_name'=>[
                'head' => 'Full Name',
                'tableName' => 'p_user',
                'tableField'=> 'full_name'
            ],
            'user_name'=>[
                'head' => 'Username',
                'tableName' => 'p_user',
                'tableField'=> 'user_name'
            ],
            'email_address'=>[
                'head' => 'Email',
                'tableName' => 'p_user',
                'tableField'=> 'email_address'
            ],
        ];

        parent::__construct();

        $this->listTable = new TableUserPrivilege();
        $this->listTable->setPrimaryKey('p_user_id');
        $this->primaryKey = 'p_user_id';

        $this->saveAPIUrl = 'user_privilege/do/save';
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

            $response = $this->client->post('user_privilege/get/list',
                    [
                        'json'    => [
                            'page' => $this->listFilter['page'] != null ? $this->listFilter['page'] : 1,
                            'perpage' => $this->listFilter['perpage'],
                            'filter' => [
                               "lower(".$searchby.")" => [
                                    'like' => '%'.strtolower($this->listFilter['search']).'%'
                                ],
                                'user_status' => 1
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

            $response = $this->client->post('user_privilege/get/list', 
                    [
                        'json'    => [
                            'page' => $this->listFilter['page'] != null ? $this->listFilter['page'] : 1,
                            'perpage' => $this->listFilter['perpage'],
                            'filter' => [
                                'user_status' => 1
                            ]
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

           $response = $this->client->post('user_privilege/get/row_by_id', 
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

        // echo "<pre>",print_r($result);die();

            return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    /* Only supports one user one role */
    public function save(Request $request){

        try{

            /* checking whether user is already registered to certain role */

            $response = $this->client->post($this->saveAPIUrl,
                    [
                        'json'    => [
                            'p_user_id' => $request->user,
                            'p_role_id' => $request->role,
                            'created_by' => \Session::get('logged_user')['username']
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success saving update!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to save data.']);
            }

        }catch(\Exception $e){
            echo $e;
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);

        }
    }

}

?>