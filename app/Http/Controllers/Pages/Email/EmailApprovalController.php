<?php
namespace App\Http\Controllers\Pages\Email;
use App\Http\Controllers\Controller;	
use App\Utils\Helper;
use Illuminate\Http\Request;
use App\Jobs\SendEmailApprovalJob;
use Carbon\Carbon;
use App\Models\CUSTOMER;
use App\Models\SEC_USER_DETAILS;

class EmailApprovalController extends Controller{
    use Helper;
	public function __construct()
    {
       
    }

    public function sendemail(Request $request){
    	$data = $this->getPostData();
        

        $obj=(object)array('name'=> $data['customer_name'],'obu_number'=>$data['obu_number'],'content'=>json_decode(stripslashes($data['content'])),'address'=>$data['customer_email']);
        $SendEmailApprovalJob = new SendEmailApprovalJob();
        $SendEmailApprovalJob->setEmailBody($obj);
        $SendEmailApprovalJob->setEmailAddress($data['customer_email']);
        $SendEmailApprovalJob->setEmailSubject($data['email_subject']);
        $delay = Carbon::now();
        $delaySeconds= $delay->addSeconds(1);
        $job= $SendEmailApprovalJob->delay($delaySeconds);
         $this->dispatch($job);
	return "Email is send properly";

    }

}

?>