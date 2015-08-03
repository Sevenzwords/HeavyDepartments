/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

hvIndex = {};
hvIndex.csrfToken = '';
hvIndex.page = '';

$(document).ready(function() {
    hvIndex.csrfToken = $('#hv_hidden_container input[name="_token"]').val();
    hvIndex.page = $('#hv_hidden_container input[name="_page"]').val();
    
    hvIndex.init();
});

hvIndex.init = function() {
    hvIndex.bindButtons();
    
    /*$.ajax({
        url: '/process',
        headers: {
            'X-CSRF-TOKEN': hvIndex.csrfToken
        },
        method: 'post',
        data: {
            '_token': hvIndex.csrfToken
        },
        success: function(data, textStatus,jqXHR) {
            console.log('Test success!');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            
        }
    });*/
};

hvIndex.initUploadButton = function(department) {
    
    if (department == 'central' || department == 'robinson') {
        var file_type = 'csv';
    } else if (department == 'theMall' || department == 'lotus') {
        var file_type = 'xls';
    }
    
    var uploader = new plupload.Uploader({
        browse_button: 'hv_upload_file_button', // this can be an id of a DOM element or the DOM element itself
        url: '/process',
        headers: {
            'X-CSRF-TOKEN': hvIndex.csrfToken
        },
        max_file_size : '5mb',
        max_file_count : 1, // user can add no more then 1 file at a time
        filters : {
            mime_types : [
                {title : "Files of type", extensions : file_type}
            ]
        },
        multipart_params : {
            '_token': hvIndex.csrfToken,
            'department': department
        }
    });
    
    uploader.init();
    
    uploader.bind('FilesAdded', function(up, files) {
        var html = '';
        plupload.each(files, function(file) {
          html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
        });
        $('#hv_upload_form_container').append(html);
        
        uploader.start();
    });
    
    uploader.bind('UploadProgress', function(up, file) {
        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    });
    
    uploader.bind('Error', function(up, err) {
        $('#hv_upload_form_container').append("\nError #" + err.code + ": " + err.message);
    });
    
    uploader.bind('FileUploaded', function() {
        console.log(uploader.total.uploaded + ' // ' + uploader.total.failed);
    });

    
};

hvIndex.bindButtons = function() {
	$hv_report_date_selector_start = $('#hv_report_date_selector_start');
	$hv_report_date_selector_end = $('#hv_report_date_selector_end');
	$hv_show_report_submit = $('#hv_show_report_submit');
	
    hvIndex.initUploadButton(hvIndex.page);
    
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    
    $hv_report_date_selector_start.datepicker();
    $hv_report_date_selector_end.datepicker();
    
    $hv_show_report_submit.bind('click', function() {
    	var report_date_start = $hv_report_date_selector_start.val();
    	var report_date_end = $hv_report_date_selector_end.val();
    	
    	/*$.ajax({
            url: '/report-process',
            headers: {
                'X-CSRF-TOKEN': hvIndex.csrfToken
            },
            method: 'post',
            data: {
                '_token': hvIndex.csrfToken,
                'department': hvIndex.page,
                'report_date_start': report_date_start,
                'report_date_end': report_date_end
            },
            success: function(data, textStatus,jqXHR) {
                console.log('Test success!');
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error occured! ' + textStatus);
            }
        });*/
    	
    	window.location.href = window.location.href.split('?')[0] + '?report_date_start=' + report_date_start + '&report_date_end=' + report_date_end;
    });
    
    $('#hv_content_container #hv_form_container input#hv_submit_button').bind('click', function() {
        
    });
};

