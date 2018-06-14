<?php

namespace App\Http\Controllers\Pages\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use App\ClientAPI\ClientAPI;

class UserController extends Scaffolding {

    use ClientAPI;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'p_user';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::security_user_index;
        $this->listView = ViewPaths::security_user_list;
        $this->newView = ViewPaths::security_user_new;
        $this->editView = ViewPaths::security_user_edit;

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
            'user_status'=>[
                'head' => 'Status',
                'tableName' => 'p_user',
                'tableField'=> 'user_status'
            ],
        ];

        parent::__construct();

        $this->listTable->setPrimaryKey('p_user_id');
        $this->listTable->allowDelete(false);
        $this->primaryKey = 'p_user_id';

        $this->saveAPIUrl = 'user/do/insert';
        $this->updateAPIUrl = 'user/do/update';
        $this->deleteAPIUrl = 'user/do/deactive';
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

            $response = $this->client->post('security/user/get/list',
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

           $response = $this->client->post('security/user/get/list', 
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

       $response = $this->client->post('security/user/get/new_data', 
                    [
                        'json'    => [
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $result = json_decode($response->getBody());
            // echo "<pre>",print_r($result);die();
        return $result;
        
    }


    /* getEditData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding editing page. Feel free to add and customize data source and method here. default method is DB Query */

    public function getEditData()
    {   
        $result = new \stdClass();

        if(isset($_GET['id']) && $_GET['id'] != '')
        {
            $response = $this->client->post('security/user/get/edit_data', 
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
            // $result$data->body[0];   
        }
            //echo "<pre>",print_r($result);die();
            return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    public function setSaveBody(Request $request)
    {
        $data = $this->getPostData();
        $body = [

            'user_name' => isset($data['user_name']) ? $data['user_name'] : '',
            'user_pwd' => password_hash($data['password'], PASSWORD_DEFAULT),
            'full_name' => isset($data['full_name']) ? $data['full_name'] : '',
            'email_address' => isset($data['email_address']) ? $data['email_address'] : '',
            'user_status' => isset($data['user_status']) ? $data['user_status'] : '',
            'p_role_id' => $request->role,

            /*Audit trail*/
            'creation_date' => date('Y-m-d h:i:s'),
            'created_by' => \Session::get('logged_user')['username'],
            'updated_date' => date('Y-m-d h:i:s'),
            'updated_by' => \Session::get('logged_user')['username'],

        ];

        $this->saveBody = $body;
    }

    public function save(Request $request)
    {
        $this->setSaveBody($request);

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

            //echo "<pre>",print_r($responseBody)

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success adding data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to add data.']);
            }

        }catch(\Exception $e){
            echo $e;
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to add data.']);

        }
        
    }


    /* setUpdateBody should be implemented due to Scaffolding updating system. it is building Payload data before updating to database */

    public function setUpdateBody()
    {
        $data = $this->getPostData();

        /* Add payload here */
        $body = [

            'id' => isset($data['id']) ? $data['id'] : '', 

            'user_name' => isset($data['user_name']) ? $data['user_name'] : '',
            'full_name' => isset($data['full_name']) ? $data['full_name'] : '',
            'email_address' => isset($data['email_address']) ? $data['email_address'] : '',
            'user_status' => isset($data['user_status']) ? $data['user_status'] : '',

            'p_role_id' => isset($data['role']) ? $data['role'] : '',

            /*Audit trail*/
            // 'creation_date' => date('Y-m-d h:i:s'),
            // 'created_by' => \Session::get('logged_user')['username'],
            'updated_date' => date('Y-m-d h:i:s'),
            'updated_by' => \Session::get('logged_user')['username'],

        ];

        //echo "<pre>",print_r($body);die();

        $this->updateBody = $body;

    }

    public function update(Request $request)
    {
        $this->setUpdateBody($request);

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
                echo json_encode(['status'=>'success', 'msg'=>'Success update data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);
            }

        }catch(\Exception $e){
            echo $e;
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);

        }
        
    }

    public function changePassword()
    {
        return view( ViewPaths::security_user_change_password );
    }

    public function submitChangePassword(Request $request)
    {
        try {

            $oldPassword = $request->old_password;
            $newPassword = $request->new_password;
            $cnewPassword = $request->c_new_password;

            $response = $this->client->post('security/user/do/change_password', 
                    [
                        'json'    => [
                            'user_name' => \Session::get('logged_user')['username'],
                            'old_password' => $oldPassword,
                            'new_password' => $newPassword
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            //echo "<pre>",print_r($responseBody);die();

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Your password has been changed successfully']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>$responseBody->message]);
            }

        }catch(\Exception $e) {
            echo $e;
        }
        
    }

    /* Overriding save function */

    public function delete()
    {
       $saveBody = $this->getPostData();

        try{

            $response = $this->client->post('user/do/deactive',
                    [
                        'json'    => [
                            'id' => $saveBody['id']
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

            $responseBody = json_decode($response->getBody());

            // echo "<pre>",print_r($responseBody);die();

            if($responseBody->code == 200)
            {
                echo json_encode(['status'=>'success', 'msg'=>'Success update data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);
            }

            //echo json_encode(['status'=>'success', 'msg'=>'Success updating data!']);

        }catch(\Exception $e){

            //echo $e;

            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);

        }
    }

    public function setUserInactive($id)
    {
        DB::table($this->DBTableName)->where($id)->update(['user_status' => 4]);
    }

}

?>