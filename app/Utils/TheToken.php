<?php

namespace App\Utils;

use Session;
use App\Constants\General;

class TheToken {

	public function getLoginToken( $username, $time ){
		$salt_md5 = md5(General::login_token_salt);
		$token_time = $time -  General::time_minus;

		return md5($username.$salt_md5.$token_time);
	}

	public function authLoginToken(){

		if(Session::get('logged_user') !== null)
		{

			$logged_user_data = Session::get('logged_user');

			$username = $logged_user_data['username'];
			$token_time = strtotime($logged_user_data['time']) - General::time_minus;
			$salt_md5 = md5(General::login_token_salt);

			return md5($username.$salt_md5.$token_time);

		}else{

			return '';

		}
		

	}

}

?>