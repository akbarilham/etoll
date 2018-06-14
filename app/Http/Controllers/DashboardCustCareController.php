<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\ViewPaths;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Models\CUSTOMER_CARE;
use App\ClientAPI\ClientAPI;

class DashboardCustCareController extends Controller
{

    use ClientAPI;

    public function __construct(){
        $this->baseURI();
    }

    public function index()
    {
        return view(ViewPaths::customer_care_dashboard_index);
    }

    public function getdata(Request $request)
    {
        $count = $this->countIssue();

        $date = $request->date;

        $ymd = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        $dec_date_ = date('Y-m-d', strtotime($ymd . "-6 days"));
        /* echo $dec_date_;
         die();*/
        $dateArray = date_parse_from_format('d-m-Y', $dec_date_);
        $day = $dateArray['day'];
        $year = $dateArray['year'];
        $month = $dateArray['month'];

        $data_open = array();
        $data_pending = array();
        $data_closed = array();

        $data_low = array();
        $data_medium = array();
        $data_high = array();

        $data_date = array();

        $issueByType = $this->getCustomerIssueByType($date);

        for ($i = 0; $i <= 6; $i++) {
            $dec_date = date('Y/m/d', strtotime($dec_date_ . "+ " . $i . " days"));
            $dec_date_simple = date('d-M', strtotime($dec_date_ . "+ " . $i . " days"));
            array_push($data_open, intval($this->getcustomer_status_open($dec_date)));
            array_push($data_pending, intval($this->getcustomer_status_pending($dec_date)));
            array_push($data_closed, intval($this->getcustomer_status_closed($dec_date)));

            array_push($data_low, intval($this->getcustomer_priority_low($dec_date)));
            array_push($data_medium, intval($this->getcustomer_priority_medium($dec_date)));
            array_push($data_high, intval($this->getcustomer_priority_hight($dec_date)));

            array_push($data_date, $dec_date_simple);
        }

        $resultArray = array("open" => $data_open, "pending" => $data_pending, "closed" => $data_closed,"low"=>$data_low,"medium"=>$data_medium,"hight"=>$data_high, "date" => $data_date, 'issueType' => $issueByType, 'count' => $count);
        return $resultArray;
    }

    function getcustomer_status_open($date)
    {
        
        $response = $this->client->post('dashboard/customercare/get/status_open',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body->total;

    }

    function getcustomer_status_pending($date)
    {

        $response = $this->client->post('dashboard/customercare/get/status_pending',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body->total;
    }

    function getcustomer_status_closed($date)
    {

         $response = $this->client->post('dashboard/customercare/get/status_closed',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body->total;
    }

    function getcustomer_priority_low($date)
    {

         $response = $this->client->post('dashboard/customercare/get/priority_low',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body->total;
    }

    function getcustomer_priority_medium($date)
    {

        $response = $this->client->post('dashboard/customercare/get/priority_medium',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body->total;
    }

    function getcustomer_priority_hight($date)
    {

        $response = $this->client->post('dashboard/customercare/get/priority_high',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body->total;
    }

    function getCustomerIssueByType($date)
    {

        $response = $this->client->post('dashboard/customercare/get/issue_by_type',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        $rep_body = [];
        foreach ($body as $k=>$val){
            $rep_k =  str_replace('_', ' ', $k);
            $rep_body[$rep_k] = $val;
        }
        return $rep_body;

    }

    function countIssue(){

        $response = $this->client->post('dashboard/customercare/get/issue_count',
                    [
                        'json'    => [],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $body = json_decode($response->getBody());
        return $body;


    }

}