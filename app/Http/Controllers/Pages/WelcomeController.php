<?php
	
namespace App\Http\Controllers\Pages;

use App\Constants\ViewPaths;
use App\Utils\Helper;
use Illuminate\Support\Facades\DB;

class WelcomeController {

	public function index()
	{
		return view( ViewPaths::welcome_index );
	}
}


?>