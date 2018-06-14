<?php
namespace App\Http\Controllers\Pages\Email;
use App\Http\Controllers\Controller;	
use App\Utils\Helper;
use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use App\Models\CUSTOMER;
use App\Models\SEC_USER_DETAILS;

class EmailController extends Controller{
    use Helper;
	public function __construct()
    {
       
    }

    public function sendemail(Request $request){
    	$data = $this->getPostData();
        

        $obj=(object)array('name'=> $data['customer_name'],'obu_number'=>$data['obu_number'],'content'=>json_decode(stripslashes($data['content'])),'address'=>$data['customer_email']);
        $SendEmailJob = new SendEmailJob();
        $SendEmailJob->setEmailBody($obj);
        $SendEmailJob->setEmailAddress($data['customer_email']);
        $SendEmailJob->setEmailSubject($data['email_subject']);
        $delay = Carbon::now();
        $delaySeconds= $delay->addSeconds(3);
        $job= $SendEmailJob->delay($delaySeconds);
         $this->dispatch($job);
	return "Email is send properly";

    }

}

?>