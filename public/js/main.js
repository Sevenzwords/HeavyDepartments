/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

hvMain = {};

$(document).ready(function() {
    hvMain.init();
});

hvMain.init = function() {
    hvMain.bindButtons();
};

hvMain.bindButtons = function() {
    $('#hv_content_container #hv_form_container input#hv_submit_button').bind('click', function() {
        
    });
}

