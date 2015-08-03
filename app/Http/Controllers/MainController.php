<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent;
use Carbon\Carbon;

class MainController extends Controller {

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
        public function departmentSelector() {
            $results = DB::select('select * from department_store where 1');

            return view('index', ['departments' => $results]);
        }

        public function centralPageController() {
            $results = DB::select('select * from department_store where 1');

            return view('index', ['departments' => $results, 'page' => 'central']);
        }
        
        public function robinsonPageController() {
            $results = DB::select('select * from department_store where 1');

            return view('index', ['departments' => $results, 'page' => 'robinson']);
        }
        
        public function theMallPageController() {
            $results = DB::select('select * from department_store where 1');

            return view('index', ['departments' => $results, 'page' => 'theMall']);
        }
        
        public function outletMallPageController() {
            $results = DB::select('select * from department_store where 1');

            return view('index', ['departments' => $results, 'page' => 'outletMall']);
        }
        
        public function bigcPageController() {
            $results = DB::select('select * from department_store where 1');

            return view('index', ['departments' => $results, 'page' => 'bigc']);
        }
        
        public function lotusPageController() {
            $results = DB::select('select * from department_store where 1');
            
            if (isset($_GET['report_date_start']) && $_GET['report_date_start'] != ''
					&& isset($_GET['report_date_end']) && $_GET['report_date_end']) {
				$report_date_start_array = explode('-', trim($_GET['report_date_start']));
				$report_date_end_array = explode('-', trim($_GET['report_date_end']));
				
				$report_date_start = Carbon::create(2000 + $report_date_start_array[2], $report_date_start_array[1], $report_date_start_array[0], 0, 0, 0);
				$report_date_end = Carbon::create(2000 + $report_date_end_array[2], $report_date_end_array[1], $report_date_end_array[0], 0, 0, 0);
				
            	error_log('Report start: ' . $report_date_start . ' // Report end: ' . $report_date_end);
            	
            	$report_result = DB::table('lotus_report')->whereBetween('sales_date', [$report_date_start, $report_date_end])->paginate(15);
			} else {
				$report_result = DB::table('lotus_report')->where('style_no', '3736427')->paginate(15);
			}            
            
            if (isset($_GET['report_page'])) {
            	$report_page = $_GET['report_page'];
            } else {
            	$report_page = 0;
            }

            return view('index', ['departments' => $results, 'page' => 'lotus', 'report_page' => $report_page, 'report_result' => $report_result]);
        }
        
        // Test commit file
}
