<?php namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProcessController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
            return view('home');
	}
        
        // init departmentSelector page
        public function departmentProcess() {
            if (isset($_POST['department']) && $_POST['department'] != '') {
                if ($_POST['department'] == 'central') {
                    $department = $_POST['department']
            } 
            
            if (isset($_FILES['file'])) {
                $file = fopen($_FILES['file']['tmp_name'],"r");
                $i = 0;
                
                if ($department == 'central') {
                    while(! feof($file)) {
                        $row = fgetcsv($file);

                        if (count($row) == 23) {
                            echo(print_r($row, true));
                        }
                    }
                }
                
                fclose($file);
            } else {
                exit();
            }
        }
}
