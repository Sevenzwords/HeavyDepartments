<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    //$departments = json_decode($departments, true);
    //echo(print_r($departments, true));
    //echo($departments[0]['name']);
    if (!isset($departments)) {
        $departments = array();
    }
    
    if (!isset($page)) {
        $page = 'index';
    }
    
    if (!isset($report_result)) {
    	$report_result = '';
    }
    
    // Filter parameter
    $report_date_start = '';
    $report_date_end = '';
    
    if (isset($_GET['report_date_start']) && $_GET['report_date_start'] != '') {
    	$report_date_start = $_GET['report_date_start'];
    }
    
    if (isset($_GET['report_date_end']) && $_GET['report_date_end'] != '') {
    	$report_date_end = $_GET['report_date_end'];
    }
        
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>หน้าแรก</title>
        
        <!-- Javascript library -->
        <script type="text/javascript" src="js/libs/jquery/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="js/libs/plupload-2.1.2/js/plupload.full.min.js"></script>
        <script type="text/javascript" src="js/libs/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/libs/bootstrap/bootstrap-datepicker.js"></script>
        
        <!-- Css library -->
        <link rel="stylesheet" type="text/css" href="css/libs/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/libs/bootstrap/bootstrap-datepicker.css" />
        
        <!-- Javascript -->
        <script type="text/javascript" src="js/index.js?<?php echo time(); ?>"></script>
        
        <!-- Css -->
        <link rel="stylesheet" type="text/css" href="css/main.css?<?php echo time(); ?>" />
    </head>
    
    <body>
        <?php 
            if (env('APP_DEBUG', false) == true) {
                echo('Debug Mode Activated!');
            }
        ?>
        
        <div id="hv_header_container">
            <?php if ($page != 'index') {
                if ($page == 'central') {
                    echo('ห้าง Central');
                } else if ($page == 'robinson') {
                    echo('ห้าง Robinson');
                } else if ($page == 'lotus') {
                	echo('ห้าง Lotus');
                } else if ($page == 'theMall') {
                	echo('ห้าง The Mall');
                }
            } else {
                echo("Department store's report collector");
            } ?>         
        </div>
        
        <div id="hv_content_container">
            <?php if ($page == 'index') { ?>
                <form id="hv_form_container">
                    
                    <!-- <select>
                        <?php for ($i = 0; $i < count($departments); $i ++) { ?>
                            <option value="<?php echo $departments[$i]['name']; ?>"><?php echo $departments[$i]['name']; ?></option>
                        <?php } ?>
                    </select>
                    <br />
                    <input type="button" value="ตกลง" /> -->
                    
                    <?php 
                        for ($i = 0; $i < count($departments); $i ++) { ?>
                            <a href="/<?php echo(strtolower($departments[$i]['name'])); ?>"><?php echo($departments[$i]['name']); ?></a><br />
                    <?php } ?>
                </form>
            <?php } else { ?>
                <div id="hv_upload_form_container">
                    <input type="button" id="hv_upload_file_button" class="btn btn-info" data-department="<?php echo $page; ?>" value="อัพโหลดไฟล์" />
                </div>
                
                <div id="hv_report_view_container">
                	<div id="hv_datepicker_container" class="container">
                		ตั้งแต่:
					    <input id="hv_report_date_selector_start" type="text" data-date-format="dd-mm-yy" class="datepicker" 
					    	value="<?php echo $report_date_start; ?>"	
				    	/>
					    ถึง:
					    <input id="hv_report_date_selector_end" type="text" data-date-format="dd-mm-yy" class="datepicker" 
					    	value="<?php echo $report_date_end; ?>"	
					    />
					    <input id="hv_show_report_submit" type="button" class="btn btn-info" value="แสดง" />
					</div>
					<br />
					<div id="hv_report_result_container table-responsive">
						<table class="hv-report-table table-striped table-bordered table">
							<?php if (isset($report_result)) { ?>
								<tr>
									<td>
										ชื่อร้านค้า
									</td>
									<td>
										รายละเอียด
									</td>
									<td>
										วันที่ขาย
									</td>
									<td>
										จำนวน
									</td>
									<td>
										รายได้
									</td>
								</tr>
								<?php foreach ($report_result as $item) { ?>
									<tr>
										<td>
											<?php echo $item['name']; ?>
										</td>
										<td>
											<?php echo $item['description']; ?>
										</td>
										<td>
											<?php echo $item['sales_date']; ?>
										</td>
										<td>
											<?php echo $item['qty']; ?>
										</td>
										<td>
											<?php echo $item['gross_sales']; ?>
										</td>
									</tr>								
								<?php }
							}?>
						</table>
					</div>
					<?php 
						// Render a report as a pagination view					
						if (isset($_GET['report_date_start']) && $_GET['report_date_start'] != ''
								&& isset($_GET['report_date_end']) && $_GET['report_date_end'] != '') {
							echo $report_result->appends(['report_date_start' => $_GET['report_date_start']
									, 'report_date_end' => $_GET['report_date_end']])->render();
						} else {
							echo $report_result->render();
						}						
					?>
                </div>
            <?php } ?>
        </div> 
        
        <div id="hv_hidden_container">
            <input id="hv_csrf_token" type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
            <input id="hv_page_name" type="hidden" name="_page" value="<?php echo($page); ?>" />
        </div>
        
        <div id="hv_footer_container">
        	<input id="hv_export_excel_button" class="btn btn-info" type="button" value="Export" />
        </div>
    </body>
</html>

