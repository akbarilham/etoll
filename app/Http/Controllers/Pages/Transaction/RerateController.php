<?php

namespace App\Http\Controllers\Pages\Transaction;

// use App\Http\Controllers\Basics\Scaffolding;
use App\Constants\ViewPaths;
use App\Utils\Helper;
use App\Utils\Curl;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Constants\RouteApi;

class RerateController {

    use Curl;

    public function __construct() 
    {
        /* Setting scaffolding view path */
        $this->indexView = ViewPaths::transaction_rerate_index;

    }


    /* getIndexData must be implemented due to Scaffolding inheritance. it is containing any data required for scaffolding index page. Feel free to add and customize data source and method here. default method is DB Query */

    public function index()
    {
       return view( $this->indexView);
    }

    /* Saving rerate */
    public function save(Request $request)
    {
        $external_id = $request->reference;
        $user_by = \Session::get('logged_user')['username'];

        $body = [
            'body' => [
                'uuid_input' => $external_id,
                'user_by' => $user_by,
            ]
        ];

        $url = RouteApi::apiRerate;
        $bodyJSON = json_encode($body);
        $response = $this->doPostJSON($url, $bodyJSON);

        echo $response;
    }

}

?>
