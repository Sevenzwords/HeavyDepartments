<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    echo(print_r($departments, true));
    //$departments = json_decode($departments, true);
    //echo(print_r($departments, true));
    //echo($departments[0]['name']);
    $page = 'index';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="widt=device-width, initial-scale=1, user-scalable=no">
        <title>หน้าแรก</title>
        
        <!-- Javascript library -->
        <script type="text/javascript" src="js/libs/jquery/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="js/libs/plupload-2.1.2/plupload.min.js"></script>
        
        <!-- Css library -->
        <link rel="stylesheet" type="text/css" href="css/libs/bootstrap.min.css" />
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
                    <select>
                        <?php for ($i = 0; $i < count($departments); $i ++) { ?>
                            <option value="<?php echo $departments[$i]['name']; ?>"><?php echo $departments[$i]['name']; ?></option>
                        <?php } ?>
                    </select>
                    <br />
                    <input type="button" value="ตกลง" />
                </form>
            <?php } else if ($page == 'central') { ?>
                
            <?php } ?>
        </div> 
    </body>
</html>

