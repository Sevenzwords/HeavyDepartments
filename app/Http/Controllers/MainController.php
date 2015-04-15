<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent;

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

            return view('index', ['departments' => $results, 'page' => 'lotus']);
        }
        
        // Test commit file
}
