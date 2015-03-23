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
        
        <!-- Css library -->
        <link rel="stylesheet" type="text/css" href="css/libs/bootstrap.min.css" />
        
        <!-- Javascript -->
        <script type="text/javascript" src="js/index.js?<?php echo time(); ?>"></script>
    </head>
    
    <body>
        <?php 
            if (env('APP_DEBUG', false) == true) {
                echo('Debug Mode Activated!');
            }
        ?>
        
        <div id="hv_header_container">
            Department store's report collector
        </div>
        
        <div id="hv_content_container">
            <?php if ($page == 'index') { ?>
                <form id="hv_form_container">
                    กรุณาเลือกห้าง
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
            <?php } else if ($page == 'central') { ?>
                <div id="hv_upload_form_container">
                    <div id="hv_upload_file_button" data-department="central">
                        อัพโหลดไฟล์
                    </div>
                </div>
            <?php } ?>
        </div> 
        
        <div id="hv_hidden_container">
            <input id="hv_csrf_token" type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
            <input id="hv_page_name" type="hidden" name="_page" value="<?php echo($page); ?>" />
        </div>
    </body>
</html>

