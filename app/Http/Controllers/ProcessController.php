<?php namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use RuntimeException;
//use Maatwebsite\Excel\Excel;
use Excel;

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
	
	public function getDates()
	{
		return [];
	}
        
    // init departmentSelector page
    public function departmentProcess() {
        if (isset($_POST['department']) && $_POST['department'] != '') {
            $department = $_POST['department'];
        } 
            
        if (isset($_FILES['file'])) {
            $file = fopen($_FILES['file']['tmp_name'], "r");
            $i = 0;
                
            if ($department == 'central') {
                while(! feof($file)) {
                    $row = fgetcsv($file);

                    if (count($row) == 23) {
                        echo(print_r($row, true));
                    }
                }
            } else if ($department == 'theMall') {
                /*require_once('excel_reader2.php');
                $data = new Spreadsheet_Excel_Reader($_FILES['file']['name']);
                echo(print_r($data, true));*/
                    
                Excel::load($_FILES['file']['tmp_name'], function($reader) {
                    // reader methods
                    //  error_log(print_r($reader, true));
                    $results = $reader->get();
                        
                    //error_log(print_r($results, true));
                    foreach($results as $result) {
                        echo $result[5];
                    }
                });
            } else if ($department == 'lotus') {
            	Excel::load($_FILES['file']['tmp_name'], function($reader) {
                	
                	// reader methods
                	//  error_log(print_r($reader, true));
                	$results = $reader->get();
                	$json['status'] = 0;
                		
                	// Column Mapping
                	$vendor = 'consignment_sales_report';
                	$name = 0;
                	$store_no = 1;
                	$store_name = 2;
                	$style_no = 3;
                	$description = 4;
                	$sales_date = 5;
                	$qty = 6;
                	$gross_sales = 7;
                	$return_amt = 8;
                	$net_sales_inc_vat = 9;
                	$vat_amt = 10;
                	$net_sales_exc_vat = 11;
                	$gp = 12;
                	$gp_amount = 13;
                	$vat_gp_amount = 14;
                	$gp_amount_inc_vat = 15;
                	$ap_amount = 16;
                	$vat_amt = 17;
                	$ap_amount_inc_vat = 18;
                		
                	foreach($results as $result) {
                		if ($result[$name] && $result[$name] != 'NAME') {
                			$id = DB::table('lotus_report')->insertGetId(
                				[
                					'vendor' => $result[$vendor],
                					'name' => $result[$name],
                					'store_no' => $result[$store_no],
                					'store_name' => $result[$store_name],
                					'style_no' => $result[$style_no],
                					'description' => $result[$description],
                					'sales_date' => $result[$sales_date],
                					'qty' => $result[$qty],
                					'gross_sales' => $result[$gross_sales],
                					'return_amt' => $result[$return_amt],
                					'net_sales_inc_vat' => $result[$net_sales_inc_vat],
                					'vat_amt' => $result[$vat_amt],
                					'net_sales_exc_vat' => $result[$net_sales_exc_vat],
                					'gp' => $result[$gp],
                					'gp_amount' => $result[$gp_amount],
                					'vat_gp_amount' => $result[$vat_gp_amount],
                					'gp_amount_inc_vat' => $result[$gp_amount_inc_vat],
                					'ap_amount' => $result[$ap_amount],
                					'vat_amt' => $result[$vat_amt],
                					'ap_amount_inc_vat' => $result[$ap_amount_inc_vat]
                				]
                			);
                				
                			if (!$id) {
                				$json['status'] = 1;
                			}
                		}              			
                	}
                		
               		echo(json_encode($json));
               	});
            }
                
            fclose($file);
        } else {
            exit();
        }
    }
        
    public function departmentReportProcess() {
        if (isset($_POST['department']) && $_POST['department'] != '') {
        	$report_date_start = $_POST['report_date_start'] . ' 00:00:00';
        	
        	
        	if (isset($_POST['report_date_end']) && $_POST['report_date_end'] != '') {
        		$report_date_end = $_POST['report_date_end'] . ' 00:00:00';
        	} else {
        		$repost_date_end = 'NOW()';
        	}
        	
        	if (isset($_POST['report_page']) && $_POST['report_page'] != '') {
        		$report_page = $_POST['report_page'];
        	} else {
        		$report_page = 0;
        	}
        	
        	
        	switch($_POST['department']) {
        		case 'lotus':     				
        			// Test query builder
        			//$report = DB::table('lotus_report')->where('sales_date', '>', $_POST['report_date_start'])->get();
        			$report = DB::table('lotue_report')->whereBetween('sales_date', [$report_date_start, $report_date_end])
        			 								   ->skip($report_page)->limit(30);
       				
       				echo(print_r($report, true));
       				
       				break;
       			default:
       				break;
       		}
       	}
	}
	
	public function departmentReportExport () {
		if (isset($_POST['report_date_start']) && $_POST['report_date_start'] != ''
				&& isset($_POST['report_date_end']) && $_POST['report_date_end'] != '') {
			Excel::create('Report-' . Carbon::now(), function($excel) {
				// Set the title
				$excel->setTitle('Report');
				
				// Chain the setters
				$excel->setCreator('Admin')
					  ->setCompany('Heavy');
				
				// Call them separately
				$excel->setDescription('A demonstration to change the file properties');
				
				$excel->sheet('Sheetname', function($sheet) {
				
					// Sheet manipulation
				
				});
			
			})->download('xlsx');
		}
	}
}
