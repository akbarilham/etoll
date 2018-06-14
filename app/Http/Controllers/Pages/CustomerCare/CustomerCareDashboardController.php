<?php

namespace App\Http\Controllers\Pages\CustomerCare;

use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CUSTOMER_CARE;
use App\Models\P_REFERENCE_LIST;

class CustomerCareDashboardController extends Controller {

    protected $issueReferenceType = '21';

    public function __construct() 
    {
        
    }

    public function index()
    {
        $annualData = $this->annualIssueData();

        return view( ViewPaths::customer_care_dashboard_index, compact('annualData') );
    }

    public function getIssueType()
    {
        $result = P_REFERENCE_LIST::where('p_reference_type_id', $this->issueReferenceType)->get();

        return $result;
    }

    public function annualIssueData()
    {
        $firstDayOfTheYear = date('Y-m-d H:i:s', strtotime('Jan 01'));
        $lastDayOfTheYear = date('Y-m-d H:i:s', strtotime('Dec 31'));

        $data = [];

        foreach($this->getIssueType() as $key=>$issue)
        {
            $issueCount = CUSTOMER_CARE::where('issue_type_id', $issue->p_reference_list_id)
                                ->where('created_on', '>=', $firstDayOfTheYear)
                                ->where('created_on', '<=', $lastDayOfTheYear)
                                ->get();
            $data[] = [
                'name' => $issue->reference_name,
                'count' => $issueCount->count()
            ];
        }

        return $data;
    }


}

?>