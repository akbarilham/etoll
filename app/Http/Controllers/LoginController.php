<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\P_USER;
use App\Models\P_USER_ROLE;
use App\Models\P_ROLE_MENU;
use App\Models\P_MENU;
use App\Utils\TheToken;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\ClientAPI\ClientAPI;

class LoginController extends Controller {

	use Helper;
	use ClientAPI;
	
	/*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating User for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

	/**
	 * Where to redirect User after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/welcome';
	protected $redirectOnFail = '/login';

	/* Database table where user data stored. */
	protected $userTable = 'p_user';
	protected $identifierField = 'user_name'; // Usually username or email!
	protected $passwordField = 'user_pwd';
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->baseURI();
	}
	public function index() {

		 if ($this->checkIfLoggedIn() == true) {
		 	return redirect($this->redirectTo);
		 } else {
		 	return view('login.indexV2');
		 }

	}

	public function doLogin(Request $request) {
		try {

				$response = $this->client->post('login', ['json' => ['user_name' => $request->username,'user_pwd' => $request->password]]);
				$result =json_decode($response->getBody());
				
				if($result->code == '200'){
					
								$Role = P_USER_ROLE::where('p_user_id', $result->user_id)->get();
								$Menu = P_ROLE_MENU::where('p_role_id', $Role[0]->p_role_id)
												->leftJoin('p_menu AS M', 'p_role_menu.p_menu_id', '=', 'M.p_menu_id')

												->select('M.p_menu_id', 'M.code', 'M.file_name', 'M.parent_id', 'M.listing_no','M.parent_id'

												 )

												->orderby('M.p_menu_id', 'ASC')
												->get();
												
								foreach($Menu as $key=>$m){
									$PARENT = P_MENU::where('p_menu_id', $m->parent_id)->select('code as parent_code')->first();
									$Menu[$key]->parent_code = $PARENT->parent_code;
								}

								
								$authorization = $this->pleaseFixTheMenu($Menu);
								
								$identifierField = $this->identifierField;
								$time = time();
								$logged_user_data = [
									'logged_user' => [
										'username' => $result->username,
										'token' => $result->token,
										'time' => date('Y-m-d H:i:s', $time),
										'name' => $result->fullname,
										'picture' => '',
										'authorization' => json_decode(json_encode($authorization), FALSE), /* you should put $autorization variable here */
									],
								];

								
								$this->storingSession($logged_user_data);
								$this->insertLastLogin($logged_user_data);

								return redirect($this->redirectTo);		
				}		
				else {

						return view('login.indexV2', ['msg' => $result->message]);
				}

		}catch(\Exception $e){
			echo $e;
			return view('errors.404');
		}
	
	}

	public function insertLastLogin($user_data) {
		P_USER::where('user_name', $user_data['logged_user']['username'])
			->update(['last_login_time' => $user_data['logged_user']['time']]);
	}

	public function logout(Request $request) {

		$this->flushSession();
		return redirect($this->redirectOnFail);

	}

	public function checkIfLoggedIn() {
				
		// $Token = new TheToken();
		// $defaultToken = $Token->authLoginToken();

		if ($this->checkSession() !== null) {
			$response = $this->client->post('checkiflogin', ['json' => ['token' => $this->getToken()]]);
			$result =json_decode($response->getBody());
			
			if ($result->code == '200') {
				
				return true;

			} else {

				return false;

			}

		} else {

			return false;

		}

	}

}

?>