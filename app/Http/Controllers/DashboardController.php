<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionEventInput;
use App\Models\TransactionReconciles;
use App\ClientAPI\ClientAPI;

class DashboardController extends Controller {

    use ClientAPI;

    public function __construct(){
        $this->baseURI();
    }

    public function index() {
//        echo 'dashboard';
        $desc = '';
        return view('guest.dashboard.index', compact('desc'));
    }

    public function postIndex(Request $request) {
//        echo 'dashboard';
        $date_raw = $request->date;
        $shift_raw = $request->shift;
//        $action = $request->action;
        /* if ($action == "count") {
          $this->getTransactionCount($date_raw);
          } else if ($action == "sum") {
          $this->getTransactionSUM($date_raw);
          } else if ($action == "shift") {
          $this->getTransactionShift($date_raw);
          }
         * 
         */
        if (isset($request->action)) {
            if ($request->action == "token") {
                echo Session::token();
            } else {
                $count = $this->getTransactionCount($date_raw);
                $sum = $this->getTransactionSUM($date_raw);
                $shift = $this->getTransactionShift($date_raw);

                $resultArray = array(
                    "count" => $count,
                    "sum" => $sum,
                    "shift" => $shift,
                    "token" => csrf_token(),
                );
                echo json_encode($resultArray, true);
            }
        } else {
            $countVS = $this->getTransactionCountVS($date_raw, $shift_raw);
            $sumVS = $this->getTransactionSUMVS($date_raw, $shift_raw);
            $count = $this->getTransactionCount($date_raw, $shift_raw);
            $sum = $this->getTransactionSUM($date_raw, $shift_raw);
            $shift = $this->getTransactionShift($date_raw);
            $shiftRoadSite = $this->getTransactionShiftRoadSite($date_raw);
            $resumeByShift = $this->getTransactionResumeByShift($date_raw);
            $transactionByUserType = $this->getTransactionByUserType($date_raw);

            //echo "<pre>",print_r($transactionByUserType);die();
            // $sum2 = $this->getTransactionSUMRoadSite($date_raw);
            // $count2 = $this->getTransactionCountRoadSite($date_raw);


            $resultArray = array(
                "countVS" => $countVS,
                "count" => $count,
                "sumVS" => $sumVS,
                "sum" => $sum,
                "shift" => $shift,
                "shiftRoadSite" => $shiftRoadSite,
                "token" => csrf_token(),
                "transactionResume" => $resumeByShift,
                "transactionByUserType" => $transactionByUserType
                // "sum2" => $sum2,
                // "countRoadSite" => $count2,
            );

            //echo "<pre>",print_r($resultArray);die();
            echo json_encode($resultArray, true);
        }

    }

    public function getTransactionByUserType($date_raw)
    {
        $result = [];
        $shift = 1;

        for($i = $shift; $i <= 3; $i++)
        {
             $response = $this->client->post('dashboard/transaction/get/transaction_by_user_type',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw)),
                            "shift_raw" => $i
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
            $result[] = json_decode($response->getBody());
        }

        return $result;
    }

    public function getTransactionCountVS($date_raw, $shift_raw) {
    //         $xAxis = array();
    //         $minusDate = 7;
    //         $totalCBO = array();
    //         $totalRoadSite = array();
    //         $dates = date('d-F', strtotime($date_raw));
    //         $dates2 = date('Y-m-d', strtotime($date_raw));
    //         for ($no = $minusDate - 1; $no >= 1; $no--) {
    //             $dates = date('d-F', strtotime('-' . $no . ' day', strtotime($date_raw)));
    //             $dates2 = date('Y-m-d', strtotime('-' . $no . ' day', strtotime($date_raw)));
    //             if ($shift_raw == 0) {
    //                 $countCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
    //                         ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
    //                         ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
    //                         ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
    //                         ->get();


    //                 $countRoadSite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
    //                         ->where('shifdate', '<=', $dates2 . " 23:59:00")
    // //                        ->where('lalinjmpass1', '>', 0)
    //                         ->selectRaw('SUM(lalinjmpass1) as total')
    //                         ->get();
    //             } else {
    //                 $countCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
    //                         ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
    //                         ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
    //                         ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
    //                         ->where('shift', $shift_raw)
    //                         ->get();


    //                 $countRoadSite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
    //                         ->where('shifdate', '<=', $dates2 . " 23:59:00")
    // //                        ->where('lalinjmpass1', '>', 0)
    //                         ->selectRaw('SUM(lalinjmpass1) as total')
    //                         ->where('shift', $shift_raw)
    //                         ->get();
    //             }


    //             array_push($totalCBO, intval($countCBO[0]['total']));
    //             array_push($totalRoadSite, intval($countRoadSite[0]['total']));
    //             array_push($xAxis, $dates);
    //         }
    //         $dates = date('d-F', strtotime($date_raw));
    //         $dates2 = date('Y-m-d', strtotime($date_raw));
    //         if ($shift_raw == 0) {
    //             $countCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
    //                     ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
    //                     ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
    //                     ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
    //                     ->get();

    //             $countRoadSite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
    //                     ->where('shifdate', '<=', $dates2 . " 23:59:00")
    // //                    ->where('lalinjmpass1', '>', 0)
    //                     ->selectRaw('SUM(lalinjmpass1) as total')
    //                     ->get();
    //         } else {
    //             $countCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
    //                     ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
    //                     ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
    //                     ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
    //                     ->where('shift', $shift_raw)
    //                     ->get();

    //             $countRoadSite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
    //                     ->where('shifdate', '<=', $dates2 . " 23:59:00")
    // //                    ->where('lalinjmpass1', '>', 0)
    //                     ->selectRaw('SUM(lalinjmpass1) as total')
    //                     ->where('shift', $shift_raw)
    //                     ->get();
    //         }


    //         array_push($xAxis, $dates);
    //         array_push($totalCBO, intval($countCBO[0]['total']));
    //         array_push($totalRoadSite, intval($countRoadSite[0]['total']));

    //         $xAxisTrims = $xAxis;
    // //        $totalTrims = $totalCBO;

    //         $resultArray = array(
    //             "id" => 'containerVsDataCount',
    //             "horizontal" => $xAxisTrims,
    //             "seriesData" => [
    //                 array(
    //                     "name" => 'Transaction CBO',
    //                     "data" => $totalCBO,
    //                 ),
    //                 array(
    //                     "name" => 'Transaction Roadside',
    //                     "data" => $totalRoadSite,
    //                     "color" => '#FF0000',
    //                 )
    //             ]
    //         );
    //         return $resultArray;
        $restructureSeriesResult = [];
        $response = $this->client->post('dashboard/transaction/get/transaction_count_vs',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw)),
                            "shift_raw" => intval($shift_raw)
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $resultArray = json_decode($response->getBody());

        foreach($resultArray->seriesData as $k=>$data)
        {
            $restructureSeriesResult[] = (array)$data;
        }

        $resultArray->seriesData = $restructureSeriesResult;

        return $resultArray;
        
    }

    public function getTransactionSUMVS($date_raw, $shift_raw) {
//     $xAxis = array();
//     $minusDate = 7;
//     $totalCBO = array();
//     $dates = date('d-F', strtotime($date_raw));
//     $dates2 = date('Y-m-d', strtotime($date_raw));
//     $totalRoadSite = array();
//     for ($no = $minusDate - 1; $no >= 1; $no--) {
//         $dates = date('d-F', strtotime('-' . $no . ' day', strtotime($date_raw)));
//         $dates2 = date('Y-m-d', strtotime('-' . $no . ' day', strtotime($date_raw)));
//         if ($shift_raw == 0) {
//             $sumCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                     ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                     ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
//                     ->get();

//             $sumRoadsite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                     ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(rpjmpass) as total')
//                     ->get();
//         } else {
//             $sumCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                     ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                     ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
//                     ->where('shift', $shift_raw)
//                     ->get();

//             $sumRoadsite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                     ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(rpjmpass) as total')
//                     ->where('shift', $shift_raw)
//                     ->get();
//         }
//         array_push($totalCBO, intval($sumCBO[0]['total']));
//         array_push($totalRoadSite, intval($sumRoadsite[0]['total']));
//         array_push($xAxis, $dates);
//     }
//     $dates = date('d-F', strtotime($date_raw));
//     $dates2 = date('Y-m-d', strtotime($date_raw));
//     if ($shift_raw == 0) {
//         $sumCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                 ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                 ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
//                 ->get();
//         $sumRoadsite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                 ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(rpjmpass) as total')
//                 ->get();
//     } else {
//         $sumCBO = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                 ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                 ->join('t_event_rated', 't_event_rated.row_id', '=', 't_event_input.uuid_input')
//                 ->where('shift', $shift_raw)
//                 ->get();
//         $sumRoadsite = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                 ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(rpjmpass) as total')
//                 ->where('shift', $shift_raw)
//                 ->get();
//     }

//     array_push($xAxis, $dates);
//     array_push($totalCBO, intval($sumCBO[0]['total']));
//     array_push($totalRoadSite, intval($sumRoadsite[0]['total']));
//     $xAxisTrims = $xAxis;

//     $resultArray = array(
//         "id" => 'containerVsDataSUM',
// //            "title" => 'Transaction (Rp)',
//         "horizontal" => $xAxisTrims,
// //            "data" => $totalTrims,
//         "seriesData" => [
//             array(
//                 "name" => 'Transaction CBO',
//                 "data" => $totalCBO,
//             ), array(
//                 "name" => 'Transaction Roadside',
//                 "data" => $totalRoadSite,
//                 "color" => '#FF0000',
//             )
//         ]
//     );
//     return $resultArray;
// //        return json_encode($resultArray, true);
        $restructureSeriesResult = [];

        $response = $this->client->post('dashboard/transaction/get/transaction_sum_vs',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw)),
                            "shift_raw" => intval($shift_raw)
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $resultArray = json_decode($response->getBody());

        foreach($resultArray->seriesData as $k=>$data)
        {
            $restructureSeriesResult[] = (array)$data;
        }
        
        $resultArray->seriesData = $restructureSeriesResult;

        return $resultArray;
    }

    public function getTransactionCount($date_raw, $shift_raw) {
//         $xAxis = array();
// //        $xAxis = "";
//         $minusDate = 7;
// //        $total = "";
//         $total = array();
//         $totalFromShift = array();
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));

//         for ($no = $minusDate - 1; $no >= 1; $no--) {
//             $dates = date('d-F', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $dates2 = date('Y-m-d', strtotime('-' . $no . ' day', strtotime($date_raw)));
// //            $xAxis .= "'" . $dates . "',";
//             $countTrx = TransactionEventInput::where('t_event_input.event_begin_time', '>=', $dates2 . " 00:00:00")
//                     ->where('t_event_input.event_begin_time', '<=', $dates2 . " 23:59:00")
//                     ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                     ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
//                     ->get();
            
//             $countTrxShiftDate = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                     ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                     ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                     ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
//                     ->get();
// //            $total .= $countTrx[0]['total'] . ",";
//             array_push($total, intval($countTrx[0]['total']));
//             array_push($totalFromShift, intval($countTrxShiftDate[0]['total']));
//             array_push($xAxis, $dates);
//         }
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));
//         $countTrx = TransactionEventInput::where('t_event_input.event_begin_time', '>=', $dates2 . " 00:00:00")
//                 ->where('t_event_input.event_begin_time', '<=', $dates2 . " 23:59:00")
//                 ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                 ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
//                 ->get();
//         $countTrxShiftDate = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                 ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                 ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                 ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
//                 ->get();
        
// //        $total .= $countTrx[0]['total'] . ",";
//         array_push($xAxis, $dates);
//         array_push($total, intval($countTrx[0]['total']));
//         array_push($totalFromShift, intval($countTrxShiftDate[0]['total']));
// //        $xAxisTrim = rtrim($xAxis, ",");
// //        $totalTrim = rtrim($total, ",");
// //        $xAxisTrims = "[" . $xAxisTrim . "]";
// //        $totalTrims = "[" . $totalTrim . "]";

//         $xAxisTrims = $xAxis;
//         $totalTrims = $total;

//         $resultArray = array(
//             "id" => 'containerCount',
// //            "title" => 'Transaction',
//             "horizontal" => $xAxisTrims,
// //            "data" => $totalTrims,
//             "seriesData" => [
//                 array(
//                     "name" => 'Transaction Inquiry By Actual Date',
//                     "data" => $totalTrims,
                    
//                 ),
//                 array(
//                     "name" => 'Transaction Inquiry By Shift Date',
//                     "data" => $totalFromShift,
//                     "color" => '#FF0000',
//                 )
//             ]
//         );
//        header('content-type: application/json; charset=utf-8');
//        return json_encode($resultArray, true);
        $restructureSeriesResult = [];

        $response = $this->client->post('dashboard/transaction/get/transaction_count',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw)),
                            "shift_raw" => $shift_raw
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $resultArray = json_decode($response->getBody());

        foreach($resultArray->seriesData as $k=>$data)
        {
            $restructureSeriesResult[] = (array)$data;
        }
        
        $resultArray->seriesData = $restructureSeriesResult;

        //echo "<pre>",print_r($resultArray);die();
        return $resultArray;
    }

    public function getTransactionSUMRoadSite($date_raw) {
//         $xAxis = array();
//         $minusDate = 7;
//         $total = array();
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));

//         for ($no = $minusDate - 1; $no >= 1; $no--) {
//             $dates = date('d-F', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $dates2 = date('Y-m-d', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $countTrx = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                     ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(rpjmpass) as total')
//                     ->get();
//             array_push($total, intval($countTrx[0]['total']));
//             array_push($xAxis, $dates);
//         }
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));
//         $countTrx = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                 ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(rpjmpass) as total')
//                 ->get();
//         array_push($xAxis, $dates);
//         array_push($total, intval($countTrx[0]['total']));
//         $xAxisTrims = $xAxis;
//         $totalTrims = $total;

//         $resultArray = array(
//             "id" => 'containerSum2',
// //            "title" => 'Transaction (Rp)',
//             "horizontal" => $xAxisTrims,
// //            "data" => $totalTrims,
//             "seriesData" => [
//                 array(
//                     "name" => 'Transaction (Rp)',
//                     "data" => $totalTrims,
//                 )
//             ]
//         );
        $restructureSeriesResult = [];
        $response = $this->client->post('dashboard/transaction/get/transaction_sum_roadsite',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $resultArray = json_decode($response->getBody());

        foreach($resultArray->seriesData as $k=>$data)
        {
            $restructureSeriesResult[] = (array)$data;
        }
        
        $resultArray->seriesData = $restructureSeriesResult;

        return $resultArray;
//        return json_encode($resultArray, true);
    }

    public function getTransactionCountRoadSite($date_raw) {
//         $xAxis = array();
//         $minusDate = 7;
//         $total = array();
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));

//         for ($no = $minusDate - 1; $no >= 1; $no--) {
//             $dates = date('d-F', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $dates2 = date('Y-m-d', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $countTrx = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                     ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                     ->where('lalinjmpass1', '>', 0)
//                     ->selectRaw('SUM(lalinjmpass1) as total')
//                     ->get();
//             array_push($total, intval($countTrx[0]['total']));
//             array_push($xAxis, $dates);
//         }
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));
//         $countTrx = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
//                 ->where('shifdate', '<=', $dates2 . " 23:59:00")
//                 ->where('lalinjmpass1', '>', 0)
//                 ->selectRaw('SUM(lalinjmpass1) as total')
//                 ->get();
//         array_push($xAxis, $dates);
//         array_push($total, intval($countTrx[0]['total']));
//         $xAxisTrims = $xAxis;
//         $totalTrims = $total;

//         $resultArray = array(
//             "id" => 'containerCountRoadSite',
// //            "title" => 'Transaction',
//             "horizontal" => $xAxisTrims,
// //            "data" => $totalTrims,
//             "seriesData" => [
//                 array(
//                     "name" => 'Transaction',
//                     "data" => $totalTrims,
//                 )
//             ]
//         );
//         return $resultArray;
        $restructureSeriesResult = [];

        $response = $this->client->post('dashboard/transaction/get/transaction_count_roadsite',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        
        $resultArray = json_decode($response->getBody());

        foreach($resultArray->seriesData as $k=>$data)
        {
            $restructureSeriesResult[] = (array)$data;
        }
        
        $resultArray->seriesData = $restructureSeriesResult;

        return $resultArray;
//        return json_encode($resultArray, true);
    }

    public function getTransactionSUM($date_raw, $shift_raw) {
//         $xAxis = array();
//         $minusDate = 7;
//         $total = array();
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));
//         $totalFromShift = array();
//         for ($no = $minusDate - 1; $no >= 1; $no--) {
//             $dates = date('d-F', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $dates2 = date('Y-m-d', strtotime('-' . $no . ' day', strtotime($date_raw)));
//             $countTrx = TransactionEventInput::where('t_event_input.processing_date', '>=', $dates2 . " 00:00:00")
//                     ->where('t_event_input.processing_date', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                     ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                     ->whereRaw('t_event_input.uuid_input = t_event_rated.row_id')
//                     ->get();
//             $sumTrxShift = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                     ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                     ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                     ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                     ->whereRaw('t_event_input.uuid_input = t_event_rated.row_id')
//                     ->get();
//             array_push($total, intval($countTrx[0]['total']));
//             array_push($totalFromShift, intval($sumTrxShift[0]['total']));
//             array_push($xAxis, $dates);
//         }
//         $dates = date('d-F', strtotime($date_raw));
//         $dates2 = date('Y-m-d', strtotime($date_raw));
//         $countTrx = TransactionEventInput::where('t_event_input.processing_date', '>=', $dates2 . " 00:00:00")
//                 ->where('t_event_input.processing_date', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                 ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                 ->whereRaw('t_event_input.uuid_input = t_event_rated.row_id')
//                 ->get();
//         $sumTrxShift = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
//                 ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
//                 ->selectRaw('SUM(t_event_input.trx_amount) as total')
//                 ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
//                 ->whereRaw('t_event_input.uuid_input = t_event_rated.row_id')
//                 ->get();
//         array_push($xAxis, $dates);
//         array_push($total, intval($countTrx[0]['total']));
//         array_push($totalFromShift, intval($sumTrxShift[0]['total']));
//         $xAxisTrims = $xAxis;
//         $totalTrims = $total;

//         $resultArray = array(
//             "id" => 'containerSum',
// //            "title" => 'Transaction (Rp)',
//             "horizontal" => $xAxisTrims,
// //            "data" => $totalTrims,
//             "seriesData" => [
//                 array(
//                     "name" => 'Transaction Inquiry By Actual Date (Rp)',
//                     "data" => $totalTrims,
//                 ),array(
//                     "name" => 'Transaction Inquiry By Shift Date (Rp)',
//                     "data" => $totalFromShift,
//                     "color" => '#FF0000',
//                 )
//             ]
//         );
//         return $resultArray;
//        return json_encode($resultArray, true);
        $restructureSeriesResult = [];

        $response = $this->client->post('dashboard/transaction/get/transaction_sum',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw)),
                            "shift_raw" => $shift_raw
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $resultArray = json_decode($response->getBody());

        foreach($resultArray->seriesData as $k=>$data)
        {
            $restructureSeriesResult[] = (array)$data;
        }
        
        $resultArray->seriesData = $restructureSeriesResult;

        return $resultArray;
    }

    public function getTransactionShift($date_raw) {
        // $resultArray = array();
        // $dates2 = date('Y-m-d', strtotime($date_raw));
        // $arrayShiftCount = array();
        // $arrayShiftSum = array();
        // $no = 3;
        // for ($no = 1; $no <= 3; $no++) {
        //     $countTrx = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
        //             ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
        //             ->where('t_event_input.shift', $no)
        //             ->selectRaw('COUNT(t_event_input.input_data_control_id) as total')
        //             ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
        //             ->get();
        //     $sumTrx = TransactionEventInput::where('t_event_input.shift_date', '>=', $dates2 . " 00:00:00")
        //             ->where('t_event_input.shift_date', '<=', $dates2 . " 23:59:00")
        //             ->where('t_event_input.shift', $no)
        //             ->selectRaw('SUM(t_event_input.trx_amount) as total')
        //             ->join('t_event_rated', 't_event_rated.input_data_control_id', '=', 't_event_input.input_data_control_id')
        //             ->get();
        //     $shiftCount = $countTrx[0]['total'];
        //     $shiftSum = $sumTrx[0]['total'];
        //     if (empty($sumTrx[0]['total'])) {
        //         $shiftSum = 0;
        //     }

        //     if (empty($countTrx[0]['total'])) {
        //         $shiftCount = 0;
        //     }
        $resultArray = [];

        $response = $this->client->post('dashboard/transaction/get/transaction_shift',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $responseArray = json_decode($response->getBody());

        foreach($responseArray as $key=>$val)
        {
            $shiftSum = $val->shiftSum;
            $shiftCount = $val->shiftCount;

            array_push($resultArray, array("shiftNumber" => $val->shiftNumber, "shiftCount" => $shiftCount, "shiftSum" => $this->amountToStr($shiftSum)));

                $txt = '<div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title"><strong>Shift ' . $val->shiftNumber . '</strong></h4>
                    <!--<p class="category">Here is a subtitle for this table</p>-->
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <tbody>
                            <tr>
                                <td  style="font-size: 18px">Transaction Quantity</td>
                                <td style="font-size: 18px;text-align:right;">' . $shiftCount . '</td>
                            </tr>
                            <tr>
                                <td style="font-size: 18px">Transaction Amount</td>
                                <td style="font-size: 18px;text-align:right;">' . $this->amountToStr($shiftSum) . '</td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>';

        }


        return $resultArray;
    }

    public function getTransactionShiftRoadSite($date_raw) {
        // $resultArray = array();
        // $dates2 = date('Y-m-d', strtotime($date_raw));
        // $arrayShiftCount = array();
        // $arrayShiftSum = array();
        // for ($no = 1; $no <= 3; $no++) {
        //     $countTrx = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
        //             ->where('shifdate', '<=', $dates2 . " 23:59:00")
        //             ->where('shift', $no)
        //             ->selectRaw('SUM(lalinjmpass1) as total')
        //             ->where('lalinjmpass1', '>', 0)
        //             ->get();
        //     $sumTrx = TransactionReconciles::where('shifdate', '>=', $dates2 . " 00:00:00")
        //             ->where('shifdate', '<=', $dates2 . " 23:59:00")
        //             ->where('shift', $no)
        //             ->selectRaw('SUM(rpjmpass) as total')
        //             ->get();
        //     $shiftCount = $countTrx[0]['total'];
        //     $shiftSum = $sumTrx[0]['total'];
        //     if (empty($sumTrx[0]['total'])) {
        //         $shiftSum = 0;
        //     }

        //     if (empty($countTrx[0]['total'])) {
        //         $shiftCount = 0;
        //     }

        //     array_push($resultArray, array("shiftNumber" => $no, "shiftCount" => $shiftCount, "shiftSum" => $this->amountToStr($shiftSum)));
        // }

        // return $resultArray;

        $response = $this->client->post('dashboard/transaction/get/transaction_shift_roadsite',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw))
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
        $resultArray = json_decode($response->getBody());
        return $resultArray;
    }

    public function getTransactionResumeByShift($date_raw)
    {
        $result = [];
        $shift = 1;

        for($i = $shift; $i <= 3; $i++)
        {
             $response = $this->client->post('dashboard/transaction/get/transaction_resume_by_shift',
                    [
                        'json'    => [
                            "date_raw" => date('m/d/Y', strtotime($date_raw)),
                            "shift_raw" => $i
                        ],
                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );
            $result[] = json_decode($response->getBody());
        }

        return $result;
    }

    public function amountToStr($amount) {
        return ($amount == "-") ? $amount : number_format($amount, 0, ".", ",");
    }

}
