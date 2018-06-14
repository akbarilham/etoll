<?php
	
namespace App\Http\Middleware;

use Closure;
use Session;
use App\ClientAPI\ClientAPI;
	
class AuthLogin {
	use ClientAPI;
	public function __construct(){
		$this->baseURI();
	}
	public function handle($request, Closure $next){

		if($this->checkSession() !== null)
		{
			$response = $this->client->post('checkiflogin', ['json' => ['token' => $this->getToken(), 'username' => $request->session()->get('logged_user.username') ]]);

			$result =json_decode($response->getBody());

			//echo "<pre>",print_r($result);die();

			if ($result->code == '200') {

				/*Replace new token */
				$request->session()->put('logged_user.token', $result->token);

				/* Continue request */
				return $next($request);

			}else{
				Session::flush();
				Session::save();
				echo "SESSION_EXPIRED";exit();
				//return redirect('/login');

			}
			
		}else{

			// echo "<pre>",print_r( Session::get('logged_user'));
			// echo "session not set!";die();
			return redirect('/login');

		}
		
	}

}

?>

