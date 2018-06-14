<?php

namespace App\Http\Controllers\Pages\Security;

use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ClientAPI\ClientAPI;

class UserMenuController extends Scaffolding {

    use ClientAPI;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'p_menu';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::security_user_menu_index;
        $this->listView = ViewPaths::security_user_menu_list ;
        $this->newView = ViewPaths::security_user_menu_new;
        $this->editView = ViewPaths::security_user_menu_edit;

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
                'tableName' => 'p_menu',
                'tableField'=> 'code'
            ],
            'p_application_id'=>[
                'head' => 'Application Id',
                'tableName' => 'p_menu',
                'tableField'=> 'p_application_id'
            ],
            'parent_id'=>[
                'head' => 'Parent Id',
                'tableName' => 'p_menu',
                'tableField'=> 'parent_id'
            ],
            'file_name'=>[
                'head' => 'Filename',
                'tableName' => 'p_menu',
                'tableField'=> 'file_name'
            ],
            'listing_no'=>[
                'head' => 'Urutan tampil',
                'tableName' => 'p_menu',
                'tableField'=> 'listing_no'
            ]
        ];

        parent::__construct();

        $this->listTable->setPrimaryKey('p_menu_id');
        $this->primaryKey = 'p_menu_id';

        $this->saveAPIUrl = 'security/user_menu/do/insert';
        $this->updateAPIUrl = 'security/user_menu/do/update';
        $this->deleteAPIUrl = 'security/user_menu/do/delete';
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

            $response = $this->client->post('security/user_menu/get/list',
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
            $response = $this->client->post('security/user_menu/get/list', 
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
            $response = $this->client->post('security/user_menu/get/row_by_id',
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

            'p_application_id' => isset($data['application_id']) ? $data['application_id'] : '',
            'code' => isset($data['code']) ? $data['code'] : '',
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : '',
            'file_name' => isset($data['file_name']) ? $data['file_name'] : '',
            'listing_no' => isset($data['listing_no']) ? $data['listing_no'] : '',
            'is_active' => isset($data['is_active']) ? $data['is_active'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'creation_date' => date('Y-m-d H:i:s'),
            'created_by' => \Session::get('logged_user')['username'],
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => \Session::get('logged_user')['username']
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
            'p_application_id' => isset($data['application_id']) ? $data['application_id'] : '',
            'code' => isset($data['code']) ? $data['code'] : '',
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : '',
            'file_name' => isset($data['file_name']) ? $data['file_name'] : '',
            'listing_no' => isset($data['listing_no']) ? $data['listing_no'] : '',
            'is_active' => isset($data['is_active']) ? $data['is_active'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'creation_date' => date('Y-m-d H:i:s'),
            'created_by' => \Session::get('logged_user')['username'],
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => \Session::get('logged_user')['username']
        ];

        $this->updateBody = $body;

    }

}

?>
