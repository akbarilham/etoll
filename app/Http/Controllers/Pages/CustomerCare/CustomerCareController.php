<?php

namespace App\Http\Controllers\Pages\CustomerCare;

use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use App\Utils\TableCustomerCare;
use Illuminate\Http\Request;
use App\Models\CUSTOMER_CARE;
use App\Utils\PHPMailer\PHPMailerAutoload;
use App\ClientAPI\ClientAPI;
use App\Constants\RouteApi;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class CustomerCareController extends Scaffolding {

    use ClientAPI;

    public $issueStatusClosed = 143;
    protected $guzzleClient;

    public function __construct() 
    {
        /* Getting  scaffolding list page filter */
        $this->listFilter = $this->filter();

        /* Setting scaffolding database table */
        $this->DBTableName = 'customer_care';

        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::costumer_care_index;
        $this->listView = ViewPaths::costumer_care_list;
        $this->editView = ViewPaths::costumer_care_edit;
        $this->setEmailView = ViewPaths::customer_care_form_email;

        /* Setting column and searchby option that appear on list page  */
        /*
            select_name as key is Required**
            head's value is Required**

            tableName's value is Optional depending on your data soruce method
            tableField's value is Optional depending on your data soruce method
        */
        $this->listTableHead = [
            'ticket_number'=>[
                'head' => 'Ticket Number',
                'tableName' => 'customer_care',
                'tableField'=> 'ticket_number',
            ],
            'customer_id'=>[
                'head' => 'Customer ID',
                'tableName' => 'customer_care',
                'tableField'=> 'customer_id'
            ],
            'last_name'=>[
                'head' => 'Customer Name',
                'tableName' => 'customer',
                'tableField'=> 'last_name'
            ],
            'created_on'=>[
                'head' => 'Date',
                'tableName' => 'customer',
                'tableField'=> 'created_on'
            ],
            'status'=>[
                'head' => 'Status',
                'tableName' => 'S',
                'tableField'=> 'reference_name'
            ],
            'priority'=>[
                'head' => 'Priority',
                'tableName' => 'P',
                'tableField'=> 'reference_name'
            ],
        ];

        parent::__construct();

        $this->listTable = new TableCustomerCare();
        $this->baseURI(); 

        $this->guzzleClient = new Client();
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

        if($this->listFilter['search'] != null || $this->listFilter['priority'] != null || $this->listFilter['status'] != null)
        {

                /* Put listing query with search here.. */

                $searchby = $this->listTableHead[ $this->listFilter['searchby'] ]['tableName'].'.'.$this->listTableHead[ $this->listFilter['searchby'] ]['tableField'];

                $response = $this->client->post('customercare/get/list',
                        [
                            'json'    => [
                                'page' => $this->listFilter['page'] != null ? $this->listFilter['page'] : 1,
                                'perpage' => (int)$this->listFilter['perpage'],
                                'filter' => [
                                    "lower(".$searchby.")" => [
                                        'like' =>  $this->listFilter['search'] != null ?  '%'.strtolower($this->listFilter['search']).'%' : null
                                    ],
                                    'priority' => $this->listFilter['priority'] != 0 ? (int)$this->listFilter['priority'] : null,
                                    'status' => $this->listFilter['status'] != 0 ? (int)$this->listFilter['status'] : null
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
                $response = $this->client->post('customercare/get/list', 
                        [
                            'json'    => [
                                'page' => $this->listFilter['page'] != null ? $this->listFilter['page'] : 1,
                                'perpage' => (int)$this->listFilter['perpage']
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
            $result->dataQuery =  DB::table($this->DBTableName)->where('id', '=', $_GET['id'] )->first();
        }

            return $result;
        
    }


    /* setSaveBody should be implemented due to Scaffolding saving system. it is building Payload data before inserting to database */

    public function setSaveBody()
    {
        $data = $this->getPostData();

        /* Add payload here */
        $body = [

            'name' => isset($data['name']) ? $data['name'] : '',

        ];
        $this->saveBody = $body;
    }


    /* setUpdateBody should be implemented due to Scaffolding updating system. it is building Payload data before updating to database */

    public function setUpdateBody()
    {
        $data = $this->getPostData();

        /* Add payload here */
        $body = [

            /* Row selector. Default is `id` */
            'id' => isset($data['id']) ? $data['id'] : '', 

            'name' => isset($data['name']) ? $data['name'] : '',
        ];

        $this->updateBody = $body;
    }

    public function view(Request $request)
    {
        $ID = $request->id;

        $response = $this->client->post('customercare/get/view', 
                    [
                        'json'    => [
                            'id' => $ID
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $result = json_decode($response->getBody());

        $issue = $result->issue;
        $priority = $result->priority;
        $status = $result->status;

        return view( $this->editView, compact('issue', 'priority', 'status') );
    }

    public function viewSaveIssue(Request $request) 
    {
        /* If request has solution description than update solution and status else only update priority*/
        if($request->has('solution_description') || $request->has('status'))
        {

            try{

                $ID = $request->id;
                $solution_description = $request->solution_description;
                $status = $request->status;

                /* If Issue has been solved then status set to CLOSED */
                 $response = $this->client->post('customercare/do/update_status',
                    [
                        'json'    => [
                            'id' => $ID,
                            'status' => $status,
                            'solution' => $solution_description,
                            'user_action' => \Session::get('logged_user')['username']
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
                echo json_encode(['status'=>'success', 'msg'=>'Success update data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);
            }


            }catch(\Exception $e){

                echo json_encode(['status'=>'error', 'msg'=>'Failed saving solution and status']);
            }

        }else {

            $ID = $request->id;
            $priority = $request->priority;

            try{

            $response = $this->client->post('customercare/do/update_priority',
                    [
                        'json'    => [
                            'id' => $ID,
                            'priority' => $priority
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
                echo json_encode(['status'=>'success', 'msg'=>'Success update data!']);
            }else {
                echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);
            }

        }catch(\Exception $e){
            
            echo json_encode(['status'=>'error', 'msg'=>'Sorry, Failed to update data.']);

        }

        }

    }

    public function setEmail(Request $request)
    {
        $ID = $request->id;

        $response = $this->client->post('customercare/get/email_data',
                    [
                        'json'    => [
                            'id' => $ID
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $issue = json_decode($response->getBody());

        return view( $this->setEmailView, compact('issue') );
    }

    public function sendEmail(Request $request)
    {
        try {

            $ID = $request->id;
            $response = $this->client->post('customercare/get/email_data',
                    [
                        'json'    => [
                            'id' => $ID
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
            );

            $issue = json_decode($response->getBody());

            /*Email body */
            $img_etc = RouteApi::imgETC;
            $urlsem = RouteApi::urlsemCustomerV2;
            $emailBody = '<div style="border-style: solid;border-width: thin;border-color: #d1e1f9;font-family: \'calibri\'; font-size:14px;">
                      <div align="center" style="margin:15px;"><img src="' . $img_etc . '" width="80" height="50"/></div>
                        <div align="left" style="margin:15px;">
                            Halo ' . $issue->name . ' ,
                        <br/><br/>
                        ' . $request->emailbody . '
                        <br/><br/>
                        ETC Jasamarga
                        <br/>
                        <a href="' . URL(RouteApi::urlsemCustomerV2) . '" target="_blank">' . $urlsem . '</a>
                        </div>
                        <div align="center" style="margin:15px;"><img src="'.RouteApi::imgCust.'" width="100" height="50"/><img src="'.RouteApi::imgCustCare.'" height="40" style="margin-left: 50px;" />
                        </div>
                        </div>
                            ';

            $apiEmailResponse = $this->guzzleClient->request('post', RouteApi::sigmaMessageBroadcast, 
                [
                    'json' => [
                        'content'=> $emailBody,
                        'subject'=> $issue->reference_name.' - Req Number : '.$issue->ticket_number,
                        'to'=> $issue->email
                    ],
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
            ]);

            echo json_encode(['status'=>'success', 'msg'=>'Email has been sent to customer']);

        }catch(\Exception $e){

            echo $e;
            echo json_encode(['status'=>'error', 'msg'=>'Failed to send email']);

        }     

    }

}

?>
