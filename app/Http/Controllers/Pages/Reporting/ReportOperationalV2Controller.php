<?php

namespace App\Http\Controllers\Pages\Reporting;
use App\Constants\ViewPaths;
use App\Http\Controllers\Controller;
use App\Utils\Helper;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\Snappy\Facades\SnappyPdf as SPDF;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\P_PLAZA;
use App\Models\P_PLAZA_GATE;
use App\ClientAPI\ClientAPI;

class ReportOperationalV2Controller extends Controller {

	use Helper;

	use ClientAPI;

	public function __construct()
	{
		$this->baseURI();
	}

	public function showreport(Request $request) {

		$dtfrom = date('Y-m-d', strtotime(strtr($request->input('dtfrom'), '/', '-')));
		$dtto = date('Y-m-d', strtotime(strtr($request->input('dtto'), '/', '-')));

		if ($this->validateDate($dtfrom) == false || $this->validateDate($dtto) == false) {
			return \Redirect::back()->withEmpty('Invalid date format');
		}

		$plaza = $request->input('i_plaza');
		$lane = $request->input('i_lane');
		$format = $request->input('exformat');

		$response = $this->client->post('report/get/operationalV2', 
                    [
                        'json'    => [
                            'dtfrom' => $dtfrom,
							'dtto' => $dtto,
							'plaza' => $plaza,
							'lane' => $lane,
							'format' => $format
                        ],

                        'headers' => [
                            'Accept'     => 'application/json',
                            'x-access-token'      => $this->getToken()
                        ]
                    ]
                );

        $query = json_decode($response->getBody());

		// echo "<pre>",print_r($query->history_data->rows);die();


		if ($format == "pdf") {

			/* Using snappy pdf */
			$data = [
				'dtfrom'		=> date("d F Y", strtotime(strtr($dtfrom, '/', '-'))),
				'dtto'			=> date("d F Y", strtotime(strtr($dtto, '/', '-'))),
				'recap_data'	=> $query->recap_data->rows,
				'history_data'	=> $query->history_data->rows
			];

			//echo "<pre>",print_r($data);die();

			$spdf = SPDF::loadView('pages.reporting.rptview_operationalV2', $data);
			$spdf->setPaper('A4', 'landscape');
			return $spdf->download('operational_report.pdf');


		} else {

			$data = [
				'dtfrom'		=> date("d F Y", strtotime(strtr($dtfrom, '/', '-'))),
				'dtto'			=> date("d F Y", strtotime(strtr($dtto, '/', '-'))),
				'recap_data'	=> $query->recap_data->rows,
				'history_data'	=> $query->history_data->rows
			];

			if (count($data['history_data']) <= 1) {
				return \Redirect::back()->withEmpty('Empty data');
			}

			ob_end_clean();
			ob_start();


			Excel::create('Filename', function($excel) use($data) {

			    $excel->sheet('Recap Data', function($sheet) use($data) {

			        $sheet->fromArray($data['recap_data']);

			    });

			    $excel->sheet('History Data', function($sheet) use($data) {

			        $sheet->fromArray($data['history_data']);

			    });

			})->export('xls');


			//return \Redirect::back()->withEmpty('Unavailable report format');

		}

	}

	public function Index() {
		$items = DB::table("p_plaza")->get();
		view()->share('plaza', $items);
		return view(ViewPaths::reporting_operational_v2_index);
	}

	public function getLane(Request $request){

		if($request->has('plaza_code')){

			$plaza_code = $request->plaza_code;

			$PLAZA = P_PLAZA::where('plaza_code', $plaza_code)->first();

			$PLAZA_GATE = P_PLAZA_GATE::where('p_plaza_id', $PLAZA->p_plaza_id)->get();

			$html = "";

			foreach($PLAZA_GATE as $key=>$GATE){
				$html .= "<option value='".$GATE->gate_code."'>".$GATE->gate_code."</option>";
			}

			echo $html;die();
			//echo "<pre>", print_r($PLAZA_GATE);die();

			echo $plaza_id;

		}
	}

}