 function qtip (id) {
         $('.cont_unit'+id).qtip({
            overwrite: false,
            content: {
                text: function(event, api) {
                    $.ajax({
                        url: api.elements.target.attr('href') // Use href attribute as URL
                    })
                    .then(function(content) {
                        // Set the tooltip content upon successful retrieval
                        api.set('content.text', content);
                    }, function(xhr, status, error) {
                        // Upon failure... set the tooltip content to error
                        api.set('content.text', status + ': ' + error);
                    });
                    return 'Loading...'; // Set some initial text
                }
            },
            show: {
                ready: true
            },
            position: {
                viewport: $(window)
            },
            style: 'qtip-wiki'
         });
}
function ncr_close(id){ 
    at = $('#id_verifying').val();
    et = $('#dt_est_finish').val();
    pin = id ;

    if (pin == 1) {
        var ph = 'has been issued NCR ref..' ;
    }
    if (pin == 0) {
        var ph = 'This NCR has been closed / cancel..' ;
    }
    $.confirm({ 
    columnClass: 'col-md-5 col-md-offset-3',
    title: 'Please provide description and file...',
    content:'' +
        '<form action="" class="formNamefilefo" id="formNamefilefo">' +
        '<div class="form-group">' +
        '<label>Reason</label>' +
            '<input type="text" placeholder="'+ph+'" value="'+ph+'" class="c_reason form-control" required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Attachment </label>' +
            '<a onclick="filncr()" class="p_file btn btn-info form-control" style="color: orange ;"> Browse</a>'+
        '</div>'+
        '<div id="filegetnamencr">'+
        '</div>'+
        '</form>',
        icon: 'fa fa-question-circle',
    animation: 'scale',
    closeAnimation: 'scale',
    opacity: 0.5,
    buttons: {
                             'confirm1': {
                                            text: 'Submit',
                                            btnClass: 'btn-blue',
                                            action: function() {
                                                var c_reason = this.$content.find('.c_reason').val();
                                                var c_file = this.$content.find('.nm_file_ncr').val();
                                                var data = $('#formNamefilefo').serializeArray();
                                                data.push({name: 'at', value: at },{name: 'c_reason', value: c_reason},{name: 'pin', value: pin});
                                                if(!c_reason){
                                                    $.alert('<text class="text-danger"> Please provide a close/release reason</text>');
                                                    return false;
                                                }
                                                if(!c_file){
                                                    $.alert('<text class="text-danger"> Please provide a file</text>');
                                                    return false;
                                                }
                                                $.post('./occurrence/c_ncr',data,
                                                function(data) {
                                                    if (data == 5) {
                                                        $.alert('<strong class="text-danger">Succes add data</strong');
                                                    }
                                                })
                                            }
                                        },
                                cancel: function() {},
                        }
})
}
function showiorlist(id){
    if (!id) {
            url = "get_occ_for_self" ;
            $('.year_s').hide();
            $('#pan-title').text(' IOR Received');
            $('#pan-title-class').attr('class','fa fa-inbox');
    }
    else{
        url = id ;  
        $('.year_s').hide();
        $('.fb').addClass('hidden');
        $('.ed').removeClass('hidden');
            if (id == 'get_occ_by_unit_verified') {
             $('.year_s').show();
             $('.fb').removeClass('hidden');
             $('.ed').addClass('hidden');
             $('#btn_verivying').addClass('hidden');
             $('#follow_description').addClass('hidden');
             $('#pan-title').text('IOR Verified');
             $('#pan-title').text(' IOR Verified');
             $('#pan-title-class').attr('class','fa fa-flag');
        }
            if (id == 'get_occ_by_unit_verified_waiting_close') {
                 $('.year_s').hide();
                 $('.fb').removeClass('hidden');
                 $('.ed').addClass('hidden');
                 $('#btn_verivying').addClass('hidden');
                 $('#follow_description').addClass('hidden');
                 $('#pan-title').text(' IOR Waiting To Close');
                 $('#pan-title-class').attr('class','fa fa-flag');
            }
            if (id == 'get_occ_by_unit') {
            $('#btn_verivying').removeClass('hidden');
            $('#follow_description').addClass('hidden');
            $('#pan-title').text(' IOR Need Verification');
            $('#pan-title-class').attr('class','fa fa-star');;
            }
    }
        $('#create_ior').addClass('hidden');
        $('#data_follow').addClass('hidden');
        $('#ior_master_group').addClass('hidden');
        $('#ior_inbox').removeClass('hidden');

        t = $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 1 ,
                                    "width": 120,
                                    "orderable": false },
                                    {"targets": 2 ,
                                    "width": 220,
                                    "orderable": false },
                                    {"targets": 0 ,
                                    "width": 90,
                                    "searchable": false,
                                    "orderable": false }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    // "aLengthMenu": [[10, 25, 50, 100,500,1000,-1], [10, 25, 50,100,500,1000, "All"]],
                    "bLengthChange": false,
                    "order": [[ 7, 'DESC' ]] 
        });

    $.ajax({
        url: "./occurrence/attact_to_ftp",
        dataType: 'script',        
        success: function(){
            alert("works"); 
        }
    });


}

$('#s_year').on("change", function() { 
    var bc_id = $(this).val();
    $('#create_ior').addClass('hidden');
    $('#data_follow').addClass('hidden');
    $('#ior_master_group').addClass('hidden');
    $('#ior_inbox').removeClass('hidden');
    $('.fb').removeClass('hidden');
    $('.ed').addClass('hidden');
    $('#btn_verivying').addClass('hidden');
    $('#follow_description').addClass('hidden');
    $('#pan-title').text(' IOR Verified');
    $('#pan-title-class').attr('class','fa fa-flag');
        url = 'get_occ_by_unit_verified_by_year/'+bc_id ;
        t = $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 1 ,
                                    "width": 120,
                                    "orderable": false },
                                    {"targets": 2 ,
                                    "width": 220,
                                    "orderable": false },
                                    {"targets": 0 ,
                                    "width": 90,
                                    "searchable": false,
                                    "orderable": false }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    // "aLengthMenu": [[10, 25, 50, 100,500,1000,-1], [10, 25, 50,100,500,1000, "All"]],
                    "bLengthChange": false,
                    "order": [[ 7, 'DESC' ]] 
        });      

});

function showiorlist_in(){
    $('.year_s').hide();
    $('#pan-title').text(' IOR Received');
    $('#pan-title-class').attr('class','fa fa-inbox');
        url = "get_occ_for_self" ;
        $('#create_ior').addClass('hidden');
        $('#data_follow').addClass('hidden');
        $('#ior_master_group').addClass('hidden');
        $('#ior_inbox').removeClass('hidden');
        $('#btn_add_fo').removeClass('hidden');
        $('#btn_verivying').addClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 0 ,
                                    "width": 80,
                                    "searchable": false,
                                    "orderable": false },
                                    {"targets": 2 ,
                                    "width": 200},
                                    {"targets": 7,
                                    "width": 160}],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "bLengthChange": false,
                    "order": [[ 7, 'DESC' ]] 
        });
}
function showiorlist_out(){
    $('.year_s').hide();
    $('#pan-title').text(' IOR Send');
    $('#pan-title-class').attr('class','fa fa-rocket');
        $('#follow_description').addClass('hidden');
                url = "get_occ_by_self" ;
                $('#create_ior').addClass('hidden');
                $('#data_follow').addClass('hidden');
                $('#ior_master_group').addClass('hidden');
                $('#ior_inbox').removeClass('hidden');
                t = $('#occ_open').DataTable({
                            "ajax": "./occurrence/"+ url,
                            "columnDefs": [{"targets": 0 ,
                                            "width": 90,
                                            "searchable": false,
                                            "orderable": false },
                                            {"targets": 0 ,
                                            "width": 190,
                                            "searchable": false,
                                            "orderable": false }],
                            "processing": true,
                            "bDestroy": true,
                            "deferRender": true,
                            "pageLength": 10,
                            "bLengthChange": false,
                            "order": [[ 7, 'DESC' ]] 

                });
}
function showiorlist_verified(){
    $('#pan-title').text(' IOR Verified');
    $('#pan-title-class').attr('class','fa fa-flag');
        url = 'get_occ_by_unit_verified' ; 
            $('#btn_verivying').addClass('hidden');
            $('#follow_description').addClass('hidden');
            $('#create_ior').addClass('hidden');
            $('#data_follow').addClass('hidden');
            $('#ior_master_group').addClass('hidden');
            $('#ior_inbox').removeClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [ {"targets": 0 ,
                                    "width": 2,
                                    "searchable": false,
                                    "orderable": false },
                                    {"targets": 1 ,
                                    "width": 90 },
                                    {"targets": 2 ,
                                    "width": 10,
                                    "searchable": false,
                                    "orderable": false },
                                    {"targets": 7 ,
                                    "width": 500 }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "bLengthChange": false
        });
}
function show_non_iorlist(){
    $('.year_s').hide();
    $('#pan-title').text(' NON IOR');
    $('#pan-title-class').attr('class','fa fa-minus-circle');
        url = 'get_non_occ' ; 
            $('#btn_verivying').addClass('hidden');
            $('#follow_description').addClass('hidden');
            $('#create_ior').addClass('hidden');
            $('#data_follow').addClass('hidden');
            $('#ior_master_group').addClass('hidden');
            $('#ior_inbox').removeClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 2 ,
                                    "width": 220,
                                    "searchable": false,
                                    "orderable": false },
                                    {"targets": 0 ,
                                    "width": 90,
                                    "searchable": false,
                                    "orderable": false }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "bLengthChange": false,
                    "order": [[ 7, 'desc' ]] 
        });
}
function show_ohr_iorlist(){
    $('.year_s').hide();
    $('#pan-title').text(' OHR');
    $('#pan-title-class').attr('class','fa fa-minus-circle');
        url = 'get_non_area' ; 
            $('#btn_verivying').addClass('hidden');
            $('#follow_description').addClass('hidden');
            $('#create_ior').addClass('hidden');
            $('#data_follow').addClass('hidden');
            $('#ior_master_group').addClass('hidden');
            $('#ior_inbox').removeClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 2 ,
                                    "width": 220,
                                    "searchable": false,
                                    "orderable": false },
                                    {"targets": 0 ,
                                    "width": 90,
                                    "searchable": false,
                                    "orderable": false }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "bLengthChange": false,
                    "order": [[ 7, 'desc' ]] 
        });
}

function show_master_group(){
    $('#create_ior').addClass('hidden');
    $('#occ_risk_table').addClass('hidden');
    $('#data_follow').addClass('hidden');
    $('#ior_inbox').addClass('hidden');
    $('#ior_master_group').removeClass('hidden');
}

function showiorlist_again(){
    $('#pan-title').text(' IOR OUT');
    $('#pan-title-class').attr('class','fa fa-rocket');
        url = "get_occ_by_self" ;
        $('#create_ior').addClass('hidden');        
        $('#data_follow').addClass('hidden');
        $('#ior_master_group').addClass('hidden');
        $('#ior_inbox').removeClass('hidden');
        $('#btn_add_fo').addClass('hidden');
        $('#btn_verivying').addClass('hidden');
        t = $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 0 ,
                                    "width": 90,
                                    "searchable": false,
                                    "orderable": false },
                                    {"targets": 0 ,
                                    "width": 190,
                                    "searchable": false,
                                    "orderable": false }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "bLengthChange": false,
                    "order": [[ 1, 'asc' ]] 

        });
}
$('#f_occ_status').change(function(){
 $('#data_follow').addClass('hidden');
 var status = $('#f_occ_status').val();
 var unit   = $('#f_occ_unit').val();
    t = $('#occ_open').DataTable({
                "ajax": "./occurrence/get_occ_by_unit/"+status+'/'+unit,
                "columnDefs": [{"targets": 0 ,
                                "width": 90,
                                "searchable": false,
                                "orderable": false }],
                "processing": true,
                "bDestroy": true,
                "deferRender": true,
                "pageLength": 10,
                "aLengthMenu": [[10, 25, 50, 100,500,1000,-1], [10, 25, 50,100,500,1000, "All"]],
                "order": [[ 1, 'asc' ]] 

    });
});

$('#f_occ_unit').change(function(){
 $('#data_follow').addClass('hidden');
 var status = $('#f_occ_status').val();
 var unit = $('#f_occ_unit').val() ;   
    t = $('#occ_open').DataTable({
                "ajax": "./occurrence/get_occ_by_unit/"+status+'/'+unit,
                "columnDefs": [{"targets": 0 ,
                                "width": 90,
                                "searchable": false,
                                "orderable": false }],
                "processing": true,
                "bDestroy": true,
                "deferRender": true,
                "pageLength": 10,
                "aLengthMenu": [[10, 25, 50, 100,500,1000,-1], [10, 25, 50,100,500,1000, "All"]],
                "order": [[ 1, 'asc' ]] 

    });
});

function back(){
    $('#ior_inbox').removeClass('hidden');
    $('#ior_master_group').addClass('hidden');
    $('#data_follow').addClass('hidden');
    $('#occ_open').DataTable({
                    "ajax": "./occurrence/"+ url,
                    "columnDefs": [{"targets": 1 ,
                                    "width": 120,
                                    "orderable": false },
                                    {"targets": 2 ,
                                    "width": 220,
                                    "orderable": false },
                                    {"targets": 0 ,
                                    "width": 90,
                                    "searchable": false,
                                    "orderable": false }],
                    "processing": true,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    // "aLengthMenu": [[10, 25, 50, 100,500,1000,-1], [10, 25, 50,100,500,1000, "All"]],
                    "bLengthChange": false,
                    "order": [[ 7, 'DESC' ]] 
        });
}

$(document).ready(function() {
        showiorlist_in();
        var GA_opt = '<select class="form-control" name="sub_lvl_typ" id="sub_lvl_typ"><option value="GA"> GA </option><option value="Others">Others</option></select>';
        $('#send_to,#category,#sub_category,#sub_category_stats,#occ_status,#f_occ_status,#f_occ_unit,#addfoll_send_to,#sub_lvl_typ,#sub_apu_sub').select2({
            width : '100%'
            },{ allowClear: true }
        );

        $('#category').change(function(){
            var cat_id = $(this).val();
            var default_opt = '<option value="">- Set Category first -</option>';
            var catdeff = '<option value="-"> - </option>';
            if(cat_id == ''){
                $('#sub_category').select2().select2().html(default_opt);
            }else{
                $('#sub_category').select2().select2().html();
                $.post('./dashboard/getocc_subcat', 
                    { cat_id : cat_id
                    }, function(data){
                        $('#sub_category').select2().select2().html(catdeff);
                        $('#sub_category').select2().select2().html(data);
                    }
                    );
            }
        });
        
        $('#sub_category,#e_sub_category').change(function(){
            var sub_cat_id = $(this).val();
            var default_opt = '<option value="-ada"> - </option>';
            if(sub_cat_id == ''){
                $('#sub_category_stats,#e_sub_category_stats').select2().select2().html(default_opt);
            }else{
                $('#sub_category_stats,#e_sub_category_stats').select2().select2().html();
                $.post('./dashboard/getocc_subcat_spec', 
                    { sub_cat_id : sub_cat_id
                    }, function(data){
                        $('#sub_category_stats,#e_sub_category_stats').select2().select2().html(data);
                    }
                    );
            }
        });
        $('.table-responsive').on('show.bs.dropdown', function () {
           $('.table-responsive').css( "overflow", "inherit" );
       	});
  });
	    $('.table-responsive').on('hide.bs.dropdown', function () {
	       $('.table-responsive').css( "overflow", "auto" );
   		})

    function show_file_occ(id){
	    ocf = $('#occ_file').DataTable({
	                "ajax": "./occurrence/get_occ_file/" + id,
	                "bDestroy": true,
	                "deferRender": true,
	                "pageLength": 10,
	                "searching"    : false,
	                "paging":   false,
	                "bLengthChange": false,
	                "info" : false,
	    });
	}
	function showfollowlist(id){
	    tf = $('#occ_follow,#rev_occ_follow').DataTable({
	                "ajax": "./occurrence/get_occ_follow/" + id,
	                "columnDefs": [{"targets": 0 ,
	                                "width": 175,
	                                "searchable": false,
	                                "orderable": false }],
	                                // {"targets": 0 ,
	                                // "width": 250,
	                                // "searchable": false,
	                                // "orderable": false },
	                                // {"targets": 3 ,
	                                // "width": 90}],
	                "bDestroy": true,
	                "deferRender": true,
	                "pageLength": 10,
	                "searching"    : false,
	                "paging":   false,
	                "bLengthChange": false,
	                "order": [[ 4, 'desc' ]] 

	    });
	}
	function shownoccfollowlist(id){
	    tf = $('#occ_follow').DataTable({
	                "ajax": "./occurrence/Get_non_occ_follow/" + id,
	                "columnDefs": [{"targets": 0 ,
	                                "width": 175,
	                                "searchable": false,
	                                "orderable": false }],
	                                // {"targets": 0 ,
	                                // "width": 250,
	                                // "searchable": false,
	                                // "orderable": false },
	                                // {"targets": 3 ,
	                                // "width": 90}],
	                "bDestroy": true,
	                "deferRender": true,
	                "pageLength": 10,
	                "searching"    : false,
	                "paging":   false,
	                "bLengthChange": false,
	                "order": [[ 4, 'desc' ]] 

	    });
	}
    function showohrfollowlist(id){
        tf = $('#occ_follow').DataTable({
                    "ajax": "./occurrence/Get_OHR_occ_follow/" + id,
                    "columnDefs": [{"targets": 0 ,
                                    "width": 175,
                                    "searchable": false,
                                    "orderable": false }],
                                    // {"targets": 0 ,
                                    // "width": 250,
                                    // "searchable": false,
                                    // "orderable": false },
                                    // {"targets": 3 ,
                                    // "width": 90}],
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "searching"    : false,
                    "paging":   false,
                    "bLengthChange": false,
                    "order": [[ 4, 'desc' ]] 

        });
    }
    function showohrfollowOhrlist(id){
        tf = $('#occ_follow').DataTable({
                    "ajax": "./occurrence/Get_OHR_occ_follow/" + id,
                    "columnDefs": [{"targets": 0 ,
                                    "width": 175,
                                    "searchable": false,
                                    "orderable": false }],
                                    // {"targets": 0 ,
                                    // "width": 250,
                                    // "searchable": false,
                                    // "orderable": false },
                                    // {"targets": 3 ,
                                    // "width": 90}],
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength": 10,
                    "searching"    : false,
                    "paging":   false,
                    "bLengthChange": false,
                    "order": [[ 4, 'desc' ]] 

        });
    }
	function Get_detail_follow (id){
	    $.ajax({
	        url : "./occurrence/get_det_follow/" + id,
	        dataType: "JSON",
	        beforeSend: function() {
	            $('#follow_description').find('form')[0].reset() ;
	        },
	        success: function(data) {
	          for(var i = 0; i < data.length; i++){
	                $('#follow_by').text(': '+data[i].follow_by);
	                $('#follow_desc').text(': '+data[i].follow_desc);
	                $('#follow_estimated').text(': '+data[i].follow_est_finish);
	                show_file_occ_fo(data[i].follow_occ_file_id);
	          }
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error get data from ajax');
	        }
	    });
	    $('#follow_description').removeClass('hidden');
	}

function showing(id){
    $('.pr').addClass('severity-bod').removeClass('severity-width');
    $('.panel-toggled-severity'+id).removeClass('severity-bod').addClass('severity-width');
}
function hidding(id){
    
}
function preview(id){
    id = $('#preview_fn'+id).text();
    $('#obj_file').attr("data","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id); 
    //$('#obj_file_nd').attr("href","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id);
    //$('#nama-file').html(id);
    $.ajax({
        url:'https://ior.gmf-aeroasia.co.id/upload_guest/'+id,
        type:'HEAD',
        cache: false,
        error: function()
        {
            $('#obj_file_nd').attr("href","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id);
            $('#showimg').attr("src","https://ior.gmf-aeroasia.co.id/image.php?url=ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id);
            $('#obj_file_op').attr("href","https://ior.gmf-aeroasia.co.id/image.php?url=ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id,"target","_blank");
        },
        success: function()
        {
            $('#obj_file_nd').attr("href","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id);
            $('#showimg').attr("src","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id);
            $('#obj_file_op').attr("href","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id,"target","_blank");
        }
    });
    //$('#obj_file_nd2').attr("href","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id);
    // $('#obj_file_op').attr("href","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id,"target","_blank"); 
    $('#obj_file_n').text(id); 
    $('#preview_file').modal('show');
}
function preview_fo(id){
    id = $('#preview_fnfo'+id).text();
    $('#obj_file').attr("data","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id); 
    //$('#obj_file_nd').attr("href","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id);
    //$('#nama-file').html(id);
    //$('#obj_file_nd2').attr("href","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id);
    $.ajax({
        url:'https://ior.gmf-aeroasia.co.id/upload_guest/'+id,
        type:'HEAD',
        cache: false,
        error: function()
        {
            $('#obj_file_nd').attr("href","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id);
            $('#obj_file_op').attr("href","https://ior.gmf-aeroasia.co.id/image.php?url=ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id,"target","_blank"); 
        },
        success: function()
        {
            $('#obj_file_nd').attr("href","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id);
            $('#obj_file_op').attr("href","https://ior.gmf-aeroasia.co.id/upload_guest/"+ id,"target","_blank");
        }
    });
    // $('#obj_file_op').attr("href","ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/"+ id,"target","_blank"); 
    $('#obj_file_n').text(id); 
    $('#preview_file').modal('show');
}
function isNumberKey(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}
function isck_dtest(){
     var value = $('.p_est_date').val();
        if (value >= 20 ) {
            $('.p_est_date').val('20');
        }
}
$('#form_risk_index').on('submit', function(e) {
    e.preventDefault();
        $('#occ_risk_idx').val('');
        ra = $("input[name=probradio]:checked").val()+ $("input[name=severadio]:checked").val() ;
        $('#occ_risk_idx,#e_occ_risk_idx').val(ra);
            if (ra == '5A' || ra == '5B' || ra == '5C' || ra == '4A' || ra == '4B'|| ra == '3A') {
                $('#occ_risk_idx').attr('style','background-color: #ff0000 ; color:#ffef39 ;');
                $('#occ_risk_detail1').text('HIGH').attr('style','background-color: #ff0000 ; color:#ffef39 ;');
                $('#occ_risk_detail2').text('Do not permit any operation until sufficient control measures have been implemented to reduce risk to an acceptable level').attr('style','background-color: #ff0000 ; color:#ffef39 ;');
                 $('#occ_risk_table').removeClass('hidden');
            }
            if (ra == '5D' || ra == '5E' || ra == '4C' || ra == '3B' || ra == '3C' || ra == '2A' || ra == '2B') {
                $('#occ_risk_idx').attr('style','background-color: #d8ff00 ; color:#000000 ;');
                $('#occ_risk_detail1').text('MEDIUM - HIGH').attr('style','background-color: #d8ff00 ; color:#000000 ;');
                $('#occ_risk_detail2').text('Management attention and approval of risk control / mitigation actions required').attr('style','background-color: #d8ff00 ; color:#000000 ;');
                $('#occ_risk_table').removeClass('hidden');
            }
            if (ra == '4D' || ra == '4E' || ra == '3D' || ra == '4D' || ra == '2C' || ra == '1A' || ra == '1B') {
                $('#occ_risk_idx').attr('style','background-color: #d8ff00 ; color:#000000 ;');
                $('#occ_risk_detail1').text('MEDIUM - LOW').attr('style','background-color: #d8ff00 ; color:#000000 ;');
                $('#occ_risk_detail2').text('Acceptable after review of the operation').attr('style','background-color: #d8ff00; color:#000000 ;');
                $('#occ_risk_table').removeClass('hidden');
            }

            if (ra == '3E' || ra == '2D' || ra == '2E' || ra == '1C' || ra == '1D' || ra == '1E') {
                $('#occ_risk_idx').attr('style','background-color: #048a04 ; color:#ffef39 ;');
                $('#occ_risk_idx').attr('style','background-color: #048a04 ; color:#ffef39 ;');
                $('#occ_risk_detail1').text('MEDIUM - LOW').attr('style','background-color: #048a04 ; color:#ffef39 ;');
                $('#occ_risk_detail2').text('Acceptable after review of the operation').attr('style','background-color: #048a04; color:#ffef39 ;');
                $('#occ_risk_table').removeClass('hidden');
            }
        $('#risk_index_select').modal('hide');
});

$('#form_risk_index_close').on('submit', function(e) {
    e.preventDefault();
        $('#c_risk').val('');
        rac = $("input[name=probradio]:checked").val()+ $("input[name=severadio]:checked").val() ;
        // alert(rac);
        $('#c_risk').val(rac);
            if (rac == '5A' || rac == '5B' || rac == '5C' || rac == '4A' || rac == '4B'|| rac == '3A') {
                $('#c_risk').attr('style','background-color: #ff0000 ; color:#ffffff ;');
                // $('#occ_risk_table').removeClass('hidden');
            }
            if (rac == '5D' || rac == '5C' || rac == '4C' || rac == '4B' || rac == '3B' || rac == '3A' || rac == '2A') {
                $('#c_risk').attr('style','background-color: #ff8d00 ; color:#000000 ;');
                // $('#occ_risk_table').removeClass('hidden');
            }
            if (rac == '4D' || rac == '3D' || rac == '3C' || rac == '2C' || rac == '2B' || rac == '1B' || rac == '1A') {
                $('#c_risk').attr('style','background-color: #d8ff00 ; color:#000000 ;');
                // $('#occ_risk_table').removeClass('hidden');
            }
            if (rac == '5E' || rac == '4E' || rac == '3E' || rac == '2D' || rac == '1C') {
                $('#c_risk').attr('style','background-color: #07f107 ; color:#000000 ;');
                // $('#occ_risk_table').removeClass('hidden');
            }
            if (rac == '2E' || rac == '1D' || rac == '1E') {
                $('#c_risk').attr('style','background-color: #048a04 ; color:#ffffff ;');
                // $('#occ_risk_table').removeClass('hidden');
            }
        $('#risk_index_close_select').modal('hide');
});

function show_file_occ_fo(id){
    ocf = $('#occ_file_fo').DataTable({
                "ajax": "./occurrence/get_occ_file_fo/" + id,
                "bDestroy": true,
                "deferRender": true,
                "pageLength": 10,
                "searching"    : false,
                "paging":   false,
                "bLengthChange": false,
                "info" : false,
    });
}
function validator(){
        return $("#form_new_ior").validate({
                ignore: [],
                rules: {                                            
                        send_to: {
                                required: true
                        }
                    }                                        
                });                                    
}
$( "#occ_detail" ).on('input', function() {
    if ($(this).val().length>1395) {
        $.alert('<strong>Maximum  character is 1400 !</strong>');
    }
});
$('#file_m').on('click', function(){
    $('.dz-preview ').remove();
    $('.dz-filename').remove();
    $('#file_handler').modal({backdrop: 'static', keyboard: false},'show'
                            );
});
function filfol(){
    $('.dz-preview ').remove();
    $('.dz-filename').remove();

    $('#file_handler_pro').modal('show');
}
function filncr(){
    $('.dz-preview ').remove();
    $('.dz-filename').remove();

    $('#file_handler_ncr').modal('show');
}
$('#file_mfo').on('click', function(){
    $('.dz-preview ').remove();
    $('.dz-filename').remove();
    $('#file_handler_fo').modal({backdrop: 'static', keyboard: false},'show'
                            );
});
function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}
    var counter = 0;
    var counterfo = 0;
function check(){
    // counter++;
    // var rString = randomString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    // $('.dz-filename').each(function(){
    //     var str = $(this).text();
    //     var fn = str.substring(0, 30);
    //     var recep = '<input type="hidden" id="f1'+(counter)+'" class="nm_file" name="file_name[]" value="'+$(this).text()+'"><i class="fileclear" id="lb'+(counter)+'">'+fn+'... <a id="bb'+(counter)+'" href="#" onclick="remove('+(counter)+')" >remove</a><br></i>';
    // $('#filegetname').append(recep);
    // })
    $('#file_handler').modal('hide');
}
function remove(id){
    $('#bb'+id+'').remove();
    $('#f1'+id+'').remove();
    $('#lb'+id+'').remove();
}
function check_file_fo(){
    counterfo++;
    $('.dz-filename').each(function(){
        var str = $(this).text();
        var fnfo = str.substring(0, 25);
        var recep = '<input type="hidden" id="f1fo'+(counterfo)+'" class="nm_file_fo" name="file_name_fo[]" value="'+$(this).text()+'"><i id="lbfo'+(counterfo)+'">'+fnfo+'... <a id="bbfo'+(counterfo)+'" href="#" onclick="removefo('+(counterfo)+')" >remove</a><br></i>';
    $('#filegetnamefo').append(recep);
    }) 
    $('#file_handler_fo').modal('hide');
}
function check_file_pro(){
    // $('.file_name_fo').remove();
    // counterfo++;
    // $('.dz-filename').each(function(){
    //     var str = $(this).text();
    //     var fnfo = str.substring(0, 25);
    //     var recep = '<input type="hidden" id="f1fo'+(counterfo)+'" class="nm_file_fo" name="file_name_fo[]" value="'+$(this).text()+'"><i class="file_name_fo" id="lbfo'+(counterfo)+'">'+fnfo+'... <a id="bbfo'+(counterfo)+'" href="#" onclick="removefo('+(counterfo)+')" >remove</a><br></i>';
    // $('#filegetnamepro').append(recep);
    // }) 
    $('#file_handler_pro').modal('hide');
}
function check_file_ncr(){
    // $('.file_name_ncr').remove();
    // counterfo++;
    // $('.dz-filename').each(function(){
    //     var str = $(this).text();
    //     var fnfo = str.substring(0, 25);
    //     var recep = '<input type="hidden" id="f1fo'+(counterfo)+'" class="nm_file_fo" name="file_name_fo[]" value="'+$(this).text()+'"><i class="file_name_ncr" id="lbfo'+(counterfo)+'">'+fnfo+'... <a id="bbfo'+(counterfo)+'" href="#" onclick="removefo('+(counterfo)+')" >remove</a><br></i>';
    // $('#filegetnamencr').append(recep);
    // }) 
    $('#file_handler_ncr').modal('hide');
}
function removefo(id){
    $('#lbfo'+id+'').remove();
    $('#bbfo'+id+'').remove();
    $('#f1fo'+id+'').remove();   
}
$('#occ_risk_idx,#e_occ_risk_idx').on('click', function(){
    $('#list_probability').DataTable({
                    "ajax": "./occurrence/get_probability",
                    "processing": true,
                    "info" : false,
                    "bDestroy": true,
                    "deferRender": true,
                    "paging" : false,
                    "bLengthChange": false,
                    "searching"    : false,
                    "order": [[ 2, 'desc' ]],
                    "columnDefs": [{"targets": 1,
                                    "width": 600},
                                    {"targets": 3,
                                    "width": 100}],
    });
    $('#list_severity').DataTable({
                    "ajax": "./occurrence/get_severity/",
                    "processing": true,
                    "info" : false,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength" : 5,
                    "paging" : false,
                    "bLengthChange": false,
                    "searching"    : false,
                    // "order": [[ 4, 'desc' ]],
                    "columnDefs": [{"targets": 1,
                                    "width": 150},
                                    {"targets": 2,
                                    "width": 100},
                                    {"targets": 3,
                                    "width": 100},
                                    {"targets": 4,
                                    "width": 250},
                                    {"targets": 6,
                                    "width": 250}],
    });
    $('#risk_index_select').modal('show');
});
function purpose(){
    at = $('#id_verifying').val();
    et = $('#dt_est_finish').val();
    $.confirm({ 
    columnClass: 'col-md-5 col-md-offset-3',
    title: 'Give your close reason',
    content:'' +
        '<form action="" class="formNamefilefo" id="formNamefilefo">' +
        '<div class="form-group">' +
        '<label>Reason</label>' +
            '<input type="text" placeholder="" class="c_reason form-control" required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Attachment </label>' +
            '<a onclick="filfol()" class="p_file btn btn-info form-control" style="color: orange ;"> Browse</a>'+
        '</div>'+
        '<div id="filegetnamepro">'+
        '</div>'+
        '</form>',
        icon: 'fa fa-question-circle',
    animation: 'scale',
    closeAnimation: 'scale',
    opacity: 0.5,
    buttons: {
                             'confirm1': {
                                            text: 'Submit',
                                            btnClass: 'btn-blue',
                                            action: function() {
                                                var c_reason = this.$content.find('.c_reason').val();
                                                var c_file = this.$content.find('.nm_file_fo').val();
                                                var data = $('#formNamefilefo').serializeArray();
                                                data.push({name: 'at', value: at},{name: 'c_reason', value: c_reason});
                                                if(!c_reason){
                                                    $.alert('<text class="text-danger"> Please provide a close reason</text>');
                                                    return false;
                                                }
                                                if(!c_file){
                                                    $.alert('<text class="text-danger"> Please provide a file</text>');
                                                    return false;
                                                }
                                                $.post('./occurrence/c_ior',data,
                                                function(data) {
                                                    if (data == 5) {
                                                        $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE THIS IOR CREATED BY YOUR SELF, PLEASE WAIT ADMIN VERIFICATION</strong');
                                                    }
                                                    if (data == 4) {
                                                        $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE STILL IN PROGRESS BY UIC</strong');
                                                    }
                                                    if (data == 3) {
                                                        $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE STILL NO PROGRESS OR RESPONSE</strong');
                                                    }
                                                    if (data == 2) {
                                                        $.alert('IOR Closed but waiting to confirmed by unit reporter');
                                                        showiorlist_in()
                                                    }
                                                    if (data == 1) {
                                                        $.post('http://192.168.240.107/ior_reminder/notif_v_ciu_r.php', 
                                                                                        { post_id : at }, function(data){ }
                                                                                        );
                                                        $.post('http://192.168.240.107/ior_reminder/notif_v_ciu.php', 
                                                                { post_id : at }, function(data){ }
                                                                );
                                                        $.alert('IOR succes close');
                                                        showiorlist_in()
                                                    }
                                                })
                                            }
                                        },
                                cancel: function() {},
                        }
}) 
}
function purpose_close() {
    at = $('#id_verifying').val();
    et = $('#dt_est_finish').val();
    $.confirm({ 
                            columnClass: 'col-md-5 col-md-offset-3',
                            title: 'Is this ior already solved?',
                            content: 'You can give the reason if this ior is not clear or already clear',
                            icon: 'fa fa-question-circle',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            opacity: 0.5,
                            buttons: {
                                'confirm1': {
                                                text: 'Yes Close',
                                                btnClass: 'btn-blue',
                                                action: function() {
                                                        $.confirm({ 
                                                        columnClass: 'col-md-5 col-md-offset-3',
                                                        title: 'Give your close reason',
                                                        content:'' +
                                                            '<form action="" class="formName">' +
                                                            '<div class="form-group">' +
                                                            '<label>Reason</label>' +
                                                                '<input type="text" placeholder="" class="c_reason form-control" required />' +
                                                                '<label>Risk Index</label>' +
                                                                '<input type="text" placeholder="" class="c_risk form-control" autocomplete="off" required name="c_risk" id="c_risk"/>' +
                                                            '</div>' +
                                                            '</form>',
                                                        icon: 'fa fa-question-circle',
                                                        animation: 'scale',
                                                        closeAnimation: 'scale',
                                                        opacity: 0.5,
                                                        buttons: {
                                                             'confirm1': {
                                                                    text: 'Submit',
                                                                    btnClass: 'btn-blue',
                                                                    action: function() {
                                                                        var c_reason = this.$content.find('.c_reason').val();
                                                                        var c_risk = this.$content.find('.c_risk').val();
                                                                        var c_file = this.$content.find('.nm_file_fo').val();  
                                                                        console.log(c_risk);                                                                      
                                                                        if(!c_reason){
                                                                            $.alert('<text class="text-danger"> Please provide a close reason</text>');
                                                                            return false;
                                                                        }
                                                                        if(!c_risk){
                                                                            $.alert('<text class="text-danger"> Please provide a close risk index</text>');
                                                                            return false;
                                                                        }
                                                                        // if((c_risk !== '1E') || (c_risk !== '1D') || (c_risk !== '1C') || (c_risk !== '2E') || (c_risk !== '2D') || (c_risk !== '3E') || (c_risk !== '4E') || (c_risk !== '5E')){
                                                                        //     $.alert('<text class="text-danger"> Please risk index must be green</text>');
                                                                        //     return false;
                                                                        // }
                                                                        if(c_risk == '1A' || c_risk == '1B' ||  c_risk == '2A' || c_risk == '2B' || c_risk == '2C' || c_risk == '3A' || c_risk == '3B' || c_risk == '3C' || c_risk == '3D' || c_risk == '4A' ||  c_risk == '4B' ||  c_risk == '4C' ||  c_risk == '4D' || c_risk == '5A' || c_risk == '5B' || c_risk == '5C' || c_risk == '5D'){
                                                                            $.alert('<text class="text-danger"> Please risk index must be green</text>');
                                                                            return false;
                                                                        }
                                                                        // return false;                                                              
                                                                        $.post('./occurrence/c_ior',
                                                                        {at: at,c_reason:c_reason,c_file : c_file,c_risk : c_risk },
                                                                        function(data) {
                                                                            if (data == 5) {
                                                                                $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE THIS IOR CREATED BY YOUR SELF, PLEASE WAIT ADMIN VERIFICATION</strong');
                                                                            }
                                                                            if (data == 4) {
                                                                                $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE STILL IN PROGRESS BY UIC</strong');
                                                                            }
                                                                            if (data == 3) {
                                                                                $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE STILL NO PROGRESS OR RESPONSE</strong');
                                                                            }
                                                                            if (data == 2) {
                                                                                $.alert('IOR Closed but waiting to confirmed by unit reporter');
                                                                                showiorlist_in()
                                                                            }
                                                                            if (data == 1) {
                                                                                $.alert('IOR succes close');
                                                                                showiorlist_in()
                                                                            }
                                                                        })                                                                      
                                                                    }
                                                                    },
                                                                cancel: function() {},
                                                        }
                                                            })
  $.post('./occurrence/getjsresponse', { a : 'a'}, 
                                function(data){
                                    var def = '<option value=""> Pilih Tipe BC dahulu </option><option value="B"> B</option>';
                                    $('[name="c_risk"]').on("click", function() { 
                                        $('#list_probability,.list_probability').DataTable({
                                                        "ajax": "./occurrence/get_probability",
                                                        "processing": true,
                                                        "info" : false,
                                                        "bDestroy": true,
                                                        "deferRender": true,
                                                        "paging" : false,
                                                        "bLengthChange": false,
                                                        "searching"    : false,
                                                        "order": [[ 2, 'desc' ]],
                                                        "columnDefs": [{"targets": 1,
                                                                        "width": 600},
                                                                        {"targets": 3,
                                                                        "width": 100}],
                                        });
                                        $('#list_severity,.list_severity').DataTable({
                                                        "ajax": "./occurrence/get_severity/",
                                                        "processing": true,
                                                        "info" : false,
                                                        "bDestroy": true,
                                                        "deferRender": true,
                                                        "pageLength" : 5,
                                                        "paging" : false,
                                                        "bLengthChange": false,
                                                        "searching"    : false,
                                                        // "order": [[ 4, 'desc' ]],
                                                        "columnDefs": [{"targets": 1,
                                                                        "width": 150},
                                                                        {"targets": 2,
                                                                        "width": 100},
                                                                        {"targets": 3,
                                                                        "width": 100},
                                                                        {"targets": 4,
                                                                        "width": 250},
                                                                        {"targets": 6,
                                                                        "width": 250}],
                                        });
                                        $('#risk_index_close_select').modal('show');
                                    });
                                }
                        );
                                                            }
                                            },
                                'confirm2': {
                                                text: 'Still Not',
                                                btnClass: 'btn-orange',
                                                action: function() {
                                                    $.confirm({ 
                                                        columnClass: 'col-md-5 col-md-offset-3',
                                                        title: 'Still not close reason',
                                                        content:'' +
                                                            '<form action="" class="formName">' +
                                                            '<div class="form-group">' +
                                                            '<label>Reason</label>' +
                                                                '<input type="text" placeholder="" class="cc_reason form-control" required />' +
                                                            '</div>' +
                                                            '</form>',
                                                            icon: 'fa fa-question-circle',
                                                        animation: 'scale',
                                                        closeAnimation: 'scale',
                                                        opacity: 0.5,
                                                        buttons: {
                                                             'confirm1': {
                                                                            text: 'Submit',
                                                                            btnClass: 'btn-blue',
                                                                            action: function() {
                                                                                var cc_reason = this.$content.find('.cc_reason').val();
                                                                                if(!cc_reason){
                                                                                    $.alert('<text class="text-danger"> Provide a reason</text>');
                                                                                    return false;
                                                                                }
                                                                                $.post('./occurrence/cc_ior',
                                                                                {at: at,cc_reason:cc_reason},
                                                                                function(data) {
                                                                                    if (data == 1) {
                                                                                        $.alert('Please wait We will notice the UIC');
                                                                                        showiorlist_in()
                                                                                    }
                                                                                })
                                                                            }
                                                                        },
                                                                cancel: function() {},
                                                        }
                                                            })
                                                }
                                            },
                                cancel: function() {},
                            }
                })        
}
$('#form_new_ior').on('submit', function(e) {
    e.preventDefault();
        url = "./occurrence/save_new";
            $.ajax({                                            
                    url : url,
                    type: "POST",
                    data: $('#form_new_ior').serialize(),
                    dataType: "JSON",
                    beforeSend: function(){
                        $('#save_new').text('Sending...');
                        $('#save_new').attr('disabled',true);
                    },
                    success: function(data){ 
                        if(data.status = "true"){
                        $('#save_new').text("SEND");
                        $('#save_new').attr('disabled',false);
                        $('#occ_open').DataTable().ajax.reload();
                        id = data.target ;
                        // $.alert('<strong>Your report Has been send :) <br> please wait for verification </strong>');
                        post_check(id);
                        showiorlist_out();
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        alert('Failed!');
                        $('#save_new').text('SEND');
                        $('#save_new').attr('disabled',false); 
                      }
                });
});
function post_check(id){
    var post_id = id ;
                $.post('http://192.168.240.107/ior_reminder/notif.php', 
                    { post_id : post_id
                    }, function(data){
                        $.alert('<strong>Your report Has been send :) <br> please wait for verification </strong>');
                    }
                    );
    }
function add(){
    var subopth = '<input type="hidden" class="form-control" name="sub_lvl_typ" id="sub_lvl_typ"/>';
    var subCOMP_opth = '<input type="hidden" class="form-control" name="sub_apu_sub" id="sub_apu_sub" placeholder=" P/N "/>';
    $('#occ_risk_table').addClass('hidden');
    $('#occ_risk_idx').attr('style','background-color: #fffff ; color:#000000 ;');
    $("#send_to,#level_type,#category,#sub_category,#sub_category_stats").val(null).trigger("change");
    $('#foracty').html(subopth);
    $('#subforacty').html(subCOMP_opth);
    $('#level_type').prop('selectedIndex',0);
        $('#create_ior').find('form')[0].reset()
        $('#save_new').attr('disabled',false);
        $('.fileclear').remove();
        $('#create_ior').removeClass('hidden');
        $('#data_follow').addClass('hidden');
        $('#ior_inbox').addClass('hidden');
        $('#ior_master_group').addClass('hidden');
        $('.nm_file').remove();
}

function v_nocc_detail(id){
    unitlast = $('.unit-name').text();
    var subunit = unitlast.substring(3, 2);
    bylast = $('.name-name').text();
    $.ajax({
        url : "./occurrence/get_det_nocc/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc,.aat').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
            $('#ior_master_group').addClass('hidden');
            $('#data_follow').removeClass('hidden');
                $('#id_verifying').val('');
                $('#dt_ior_number').text('');
                $('#dt_occ_by').text('');
                $('#addfollid').val(''); 
                $('#dt_occ_by2').text('');
                $('#dt_occ_createddate').text('');
                $('#dt_occ_send_to').text('');
                $('#dt_occ_description').text('');
                $('#dt_risk_index').text('');
                $('#dt_occ_reff').text('');
                $('#dt_occ_subject').text('');
                $('#dt_occ_category').text('');
                $('#dt_occ_subcategory').text('');
                $('#dt_risk_reportby').text('');
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                $('#id_verifying').val(data[i].occ_id);
                $('#dt_ior_number').text(': '+data[i].occ_no);
                $('#dt_occ_by').text(': '+data[i].created_by);
                $('#addfollid').val(data[i].occ_id); 
                $('#dt_occ_by2').text(data[i].created_by);
                $('#dt_occ_createddate').text(': '+data[i].created_date);
                $('#dt_occ_send_to').text(': '+data[i].occ_send_to);
                $('#dt_occ_description').text(': '+data[i].occ_detail);
                $('#dt_risk_index').text(': '+data[i].occ_risk_index);
                $('#dt_occ_reff').text(': '+data[i].occ_reff);
                $('#dt_occ_subject').text(': '+data[i].occ_sub);
                $('#dt_occ_category').text(': '+data[i].cat_name);
                $('#dt_occ_subcategory').text(': '+data[i].cat_sub_desc);
                $('#dt_risk_reportby').text(': '+ data[i].created_by_name);
                $('#permission').text("NOT OCC").removeClass("badge-warning").addClass("badge-danger"); 
                $('#dt_est_finish').text('-');
                $('#dt_est_finish_od').countdown('1970-01-01', function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                $('#ior_inbox').addClass('hidden');               
                $('#ior_master_group').addClass('hidden');
                $('#data_follow').removeClass('hidden');
                shownoccfollowlist(data[i].occ_id);
                show_file_occ(data[i].occ_no);
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function v_ohr_detail(id){
    unitlast = $('.unit-name').text();
    var subunit = unitlast.substring(3, 2);
    bylast = $('.name-name').text();
    $.ajax({
        url : "./occurrence/get_det_ohr/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc,.aat,.ncb').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
            $('#ior_master_group').addClass('hidden');
            $('#data_follow').removeClass('hidden');
                $('#id_verifying').val('');
                $('#dt_ior_number').text('');
                $('#dt_occ_by').text('');
                $('#addfollid').val(''); 
                $('#dt_occ_by2').text('');
                $('#dt_occ_createddate').text('');
                $('#dt_occ_send_to').text('');
                $('#dt_occ_description').text('');
                $('#dt_risk_index').text('');
                $('#dt_occ_reff').text('');
                $('#dt_occ_subject').text('');
                $('#dt_occ_category').text('');
                $('#dt_occ_subcategory').text('');
                $('#dt_risk_reportby').text('');
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                if (where == 1 ) {
                    $('.high').append('<button onclick="ohr_attachment('+id+')" class="btn btn-default aat"><span class="fa fa-plus"></span>Add Attachment</button>');
                }
                $('#id_verifying').val(data[i].occ_id);
                $('#dt_ior_number').text(': '+data[i].occ_no);
                $('#dt_occ_by').text(': '+data[i].created_by);
                $('#addfollid').val(data[i].occ_id); 
                $('#dt_occ_by2').text(data[i].created_by);
                $('#dt_occ_createddate').text(': '+data[i].created_date);
                $('#dt_occ_send_to').text(': '+data[i].occ_send_to);
                $('#dt_occ_description').text(': '+data[i].occ_detail);
                $('#dt_risk_index').text(': '+data[i].occ_risk_index);
                $('#dt_occ_reff').text(': '+data[i].occ_reff);
                $('#dt_occ_subject').text(': '+data[i].occ_sub);
                $('#dt_occ_category').text(': '+data[i].cat_name);
                $('#dt_occ_subcategory').text(': '+data[i].cat_sub_desc);
                $('#dt_risk_reportby').text(': '+ data[i].created_by_name);
                $('#permission').text("Operational Hazard Area").removeClass("badge-danger").addClass("badge-ohr"); 
                $('#dt_est_finish').text('-');
                $('#dt_est_finish_od').countdown('1970-01-01', function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                $('#ior_inbox').addClass('hidden');
                $('#ior_master_group').addClass('hidden');
                $('#data_follow').removeClass('hidden');
                showohrfollowOhrlist(data[i].occ_no);
                refresh = data[i].occ_no ;
                show_file_occ(data[i].occ_no);
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function ohr_attachment(id){
    $.confirm({
                columnClass: 'col-md-5 col-md-offset-3',
                title: 'Provide attachment',
                    content:'' +
                            '<form action="" class="formName">' +
                            '<div class="form-group">' +
                                        '<label>Provide a description</label>' +
                                            '<textarea class="attachdescription form-control" rows="5" required /> </textarea>' +
                                        '</div>' +
                            '<div class="form-group">' +
                            '<div class="form-group">' +
                                        '<label>OHR To</label>' +
                                            '<select class="attachto form-control" onchange="" style=" -webkit-appearance: none;-moz-appearance: none; appearance: none;">'+
                                                '<option value="" selected> - </option>'+
                                                '<option value="1">Garuda Indonesia</option>'+
                                                '<option value="2">Citilink Indonesia</option>'+
                                                '<option value="3">Gapura Angkasa</option>'+
                                                '<option value="4">Aerofood ACS</option>'+
                                                '<option value="5">Aerotrans</option>'+
                                                '<option value="6">Asyst</option>'+
                                                '<option value="7">Angkasa Pura I</option>'+
                                                '<option value="8">Angkasa Pura II</option>'+
                                                '<option value="9">Otoritas Bandar Udara</option>'+
                                                '<option value="10">Other</option>'+
                                            '</select>' +
                                        '</div>' +
                            '<div class="form-group">' +
                            '<label>Attachment </label>' +
                                '<a onclick="filfol()" class="p_file btn btn-info form-control" style="color: orange ;"> Browse</a>'+
                            '</div>'+
                            '<div id="filegetnamepro">'+
                            '</div>'+
                            '</form>',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm1': {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var attachdtionescrip = this.$content.find('.attachdescription').val();
                            var ohrfile = this.$content.find('.nm_file_fo').val();
                            var attachto = this.$content.find('.attachto').val();
                            if(!attachdtionescrip){
                                                        $.alert('<text class="text-danger"> Please provide a description..</text>');
                                                        return false;
                                                    }
                            if(!ohrfile){
                                $.alert('<text class="text-danger"> Please provide a file if you want add attachment..</text>');
                                return false;
                            }
                            $.post('./occurrence/add_att_ohr', 
                            { ohrfile : ohrfile ,ocid : id ,attachdtionescrip : attachdtionescrip ,attachto : attachto }, function(data){ 
                                if(data.status = "true"){
                                    $.alert('Attachment has been added...');
                                    showohrfollowOhrlist(refresh);
                                }
                            });
                        }
                    },
                    cancel: function () {
                                   
                    }
                }
            });
}
function v_occ_detail(id){
    unitlast = $('.unit-name').text();
    var subunit = unitlast.substring(0, 2);
    console.log(subunit);
    bylast = $('.name-name').text();
    $.ajax({
        url : "./occurrence/get_det_occ/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc,.aat,.ncb').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');  
            $('#ior_master_group').addClass('hidden');
            $('#data_follow').removeClass('hidden');
                $('#id_verifying').val('');
                $('#dt_ior_number').text('');
                $('#dt_occ_by').text('');
                $('#addfollid').val(''); 
                $('#dt_occ_by2').text('');
                $('#dt_occ_createddate').text('');
                $('#dt_occ_send_to').text('');
                $('#dt_occ_description').text('');
                $('#dt_risk_index').text('');
                $('#dt_occ_reff').text('');
                $('#dt_occ_subject').text('');
                $('#dt_occ_category').text('');
                $('#dt_occ_subcategory').text('');
                $('#dt_risk_insertby').text('');
                $('#dt_risk_reportby').text('');
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
            var occsubunit = data[i].occ_send_to.substring(0, 2);
            if (data[i].occ_follow_last_by != null) {
               follaby = data[i].occ_follow_last_by.substring(0, 2);
            }   
            if (data[i].occ_follow_last_by == null) {
                follaby = 'kosong';
            }
            if (data[i].occ_follow_last_by != null){
                var occsublastfoll = data[i].occ_follow_last_by.substring(0, 2);
            }
                if ( ((data[i].occ_follow_last_by == unitlast) && (data[i].occ_follow_last_by == null)) 
                     || ((data[i].occ_send_to == unitlast) && (data[i].occ_follow_last_by == unitlast)) 
                     || ((data[i].occ_send_to == unitlast) && (data[i].occ_follow_last_by == null)) 
                     || ((occsubunit == subunit) && (data[i].occ_follow_last_by == null)) 
                     || ((occsubunit == subunit) && (occsublastfoll == occsubunit)) 
                     ) {
                    $('.ed,.eb,.fb,.op,.pc').remove();
                    if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 1) && (data[i].permission == 1)) {
                        $('.ed,.eb,.fb,.op,.pc').remove();
                        $('.high').append('<button class="btn btn-default op" onclick="occprocess()"><span class="fa fa-plus"></span>Progress</button>');
                    }
                    if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 2)) {
                        $('.ed,.eb,.fb,.op,.pc').remove();
                        $('.high').append('<button class="btn btn-default pc" onclick="purpose()"><span class="fa fa-plus"></span>Propose to Close</button>');
                    }
                }
                 if ((data[i].occ_follow_last_by == unitlast ||  follaby ==  subunit || follaby ==  'TQ' ))  {
                    $('.ed,.eb,.fb,.op,.pc').remove();
                    if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 1)) {
                        $('.ed,.eb,.fb,.op,.pc').remove();
                        $('.high').append('<button class="btn btn-default op" onclick="occprocess()"><span class="fa fa-plus"></span>Progress</button>');
                    }
                    if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 2)) {
                        $('.ed,.eb,.fb,.op,.pc').remove();
                        $('.high').append('<button class="btn btn-default pc" onclick="purpose()"><span class="fa fa-plus"></span>Propose to Close</button>');
                    }
                }
                if (((data[i].created_by == bylast)) && (data[i].occ_status == 1) && (data[i].occ_confirm_stats == 3)) {
                        $('.ed,.eb,.fb,.op,.pc').remove();
                        $('.high').append('<button class="btn btn-default pc" onclick="purpose_close()"><span class="fa fa-plus"></span>CLOSE IOR</button>');
                }
                $('#id_verifying').val(data[i].occ_id);
                $('#dt_ior_number').text(': '+data[i].occ_no);
                $('#dt_occ_by').text(': '+data[i].created_by);
                $('#addfollid').val(data[i].occ_id); 
                $('#dt_occ_by2').text(data[i].created_by);
                $('#dt_occ_createddate').text(': '+data[i].created_date);
                $('#dt_occ_send_to').text(': '+data[i].occ_send_to);
                descr = data[i].occ_detail ;
                document.getElementById("dt_occ_description").innerHTML = descr;
                $('#dt_risk_index').text(': '+data[i].occ_risk_index);
                $('#dt_occ_reff').text(': '+data[i].occ_reff);
                $('#dt_occ_subject').text(': '+data[i].occ_sub);
                $('#dt_occ_category').text(': '+data[i].cat_name);
                $('#dt_occ_subcategory').text(': '+ data[i].cat_sub_desc);
                if (data[i].created_hide == 1){
                $('#dt_risk_reportby').text(': Hidden');    
                $('#dt_risk_insertby').text(': Hidden');
                }
                if (data[i].created_hide == 0){
                $('#dt_risk_reportby').text(': '+ data[i].created_by_name);    
                $('#dt_risk_insertby').text(': '+ data[i].InsertBy);
                }
                
                $('.dt-verified').addClass('hidden');
                
                var etfdu   = data[i].occ_estfinish_date;
                var etfdus  = etfdu.substring(0, 10);
                var etresp  = data[i].occ_response_date;
                var etresps = etresp.substring(0, 10);
                    if (data[i].permission == 0){ 
                    $('#permission').text("NEED VERIFICATION").removeClass("badge-nedver").addClass("badge-danger"); 
                    $('#time_resp').text('Time.Response');
                    var rd = data[i].occ_response_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ' ' + ry + ' ');
                        $('#dt_est_finish_od').countdown(data[i].occ_response_date, function(event) {
                            $(this).html(event.strftime('%D days %H:%M:%S Left'));
                        });
                    }
                    if (data[i].permission == 1){
                        if (data[i].duedate >= 0 ){
                            $('#permission').text("Overdue").removeClass().addClass("badge badge-danger"); 
                            $('#stats_permision').addClass("hidden"); 
                            if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 1){
                                $('#stats_permision').addClass("hidden"); 
                                $('#stats_permision').text("Open").removeClass().addClass("badge badge-warning"); 
                            }
                        }
                        if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 1 && data[i].duedate <= 0 ){
                            $('#permission').text("Open").removeClass().addClass("badge badge-warning") ; 
                            $('#stats_permision').addClass("hidden"); 
                            if (data[i].duedate >= 0) {
                                $('#stats_permision').text("Overdue").removeClass().addClass("badge badge-danger"); 
                            }
                        }
                        if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 2 ){
                            $('#permission').text("Progress").removeClass().addClass("badge badge-succes") ; 
                            $('#stats_permision').addClass("hidden"); 
                        }
                        if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 3 ){
                            $('#permission').text("Waiting Close").removeClass().addClass("badge badge-succes") ; 
                            $('#stats_permision').addClass("hidden"); 
                        }
                        if (data[i].occ_status == 3 && data[i].occ_confirm_stats == 3 ){
                            $('#permission').text("Closed").removeClass().addClass("label label-success label-form"); 
                            $('#stats_permision').addClass("hidden"); 
                        }
                        if (data[i].occ_status == 0 && data[i].occ_confirm_stats == 0 ){
                            if (data[i].occ_status == 0 && data[i].occ_confirm_stats == 0 && data[i].occ_probability == 1 ) {
                                $('#permission').text("CLOSED").removeClass().addClass("badge badge-ncrclosed"); 
                                $('#stats_permision').addClass("hidden"); 
                            }
                            if (data[i].occ_status == 0 && data[i].occ_confirm_stats == 0 && data[i].occ_probability == 0 ) {
                                $('#permission').text("NCR").removeClass().addClass("badge badge-danger"); 
                                $('#stats_permision').text("Released").removeClass().addClass("badge badge-ncreleased"); 
                            }
                            if (data[i].occ_status == 0 && data[i].occ_confirm_stats == 0 && data[i].occ_probability == '-' ) {
                                $('#permission').text("NCR").removeClass().addClass("badge badge-danger"); 
                                $('#stats_permision').addClass("hidden"); 
                            }
                        }
                        if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 2 && data[i].duedate >= 0 ){
                            $('#permission').text("Progress").removeClass().addClass("badge badge-succes") ; 
                            $('#stats_permision').text("Overdue").removeClass().addClass("badge badge-danger"); 
                        }
                        
                    $('#time_resp').text('Est.Finish');
                    var rd = data[i].occ_estfinish_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ' ' + ry + ' ');
                    $('#dt_est_finish_od').countdown(data[i].countdown, function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                    } 
                $('#ior_inbox').addClass('hidden');
                $('#ior_master_group').addClass('hidden');
                $('#data_follow').removeClass('hidden');
                showfollowlist(data[i].occ_id);
                show_file_occ(data[i].occ_no);
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function del_follow(id){
    $.confirm({ 
        columnClass: 'col-md-5 col-md-offset-3',
        title: 'Are you sure want to delete this follow data?',
        icon: 'fa fa-question-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
             'confirm1': {
                            text: 'Yes Delete !',
                            btnClass: 'btn-blue',
                            action: function() {
                                $.post('./occurrence/deleting_follow_on',
                                {fid : id},
                                function(data) {
                                    if(data.status = "true"){
                                        $.alert('Delete success ....');
                                        showfollowlist(refer);
                                    }
                                })
                            }
                        },
                cancel: function() {},
        }
            })
}
function wrong_resp() {
    var wr = $('.p_wrongresp').val();
    if(wr == '0'){
        $('.fg_ed,.fg_file').addClass('hidden');
    }
    if(wr == '1'){
        $('.fg_ed,.fg_file').removeClass('hidden');
    }
}
function occprocess (){
    at = $('#id_verifying').val();
    et = $('#dt_est_finish').val();
    $.confirm({ 
        columnClass: 'col-md-5 col-md-offset-3',
        title: 'Please fill your response',
            content:'' +
                    '<form action="" class="formName" enctype="multipart/form-data">' +
                    '<div class="form-group">' +
                    '<label>Responsible ?</label>' +
                        '<select class="p_wrongresp form-control" onchange="wrong_resp()">'+
                               '<option value="1" selected>Yes i will process this IOR</option>'+
                               '<option value="0">This IOR is not our responsible unit</option>'+
                        '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Response/Reason</label>' +
                        '<input type="text" placeholder="" class="p_reason form-control" />' +
                    '</div>' +
                    '<div class="form-group fg_ed">' +
                    '<label>Add estimated finish day</label>' +
                        '<input type="text" onkeypress="return isNumberKey(event)" onkeyup="isck_dtest()" maxlength="2"  placeholder="maximum is 20 day" class="p_est_date form-control" size="5" />' +
                    '</div>' +
                    '<div class="form-group fg_file">' +
                    '<label>Attachment </label>' +
                        '<a onclick="filfol()" class="p_file btn btn-info form-control" style="color: orange ;"> Browse</a>'+
                    '<div id="filegetnamepro">'+
                    '</div>'+
                    '</div>' +
                    '</form>',
        icon: 'fa fa-question-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
                                 'confirm1': {
                                                text: 'Submit',
                                                btnClass: 'btn-blue',
                                                action: function() {
                                                    var p_reason = this.$content.find('.p_reason').val();
                                                    var p_est_date = this.$content.find('.p_est_date').val();
                                                    var p_file = this.$content.find('.nm_file_fo').val();
                                                    var p_wrongresp = this.$content.find('.p_wrongresp').val();
                                                    if(!p_reason){
                                                        $.alert('<text class="text-danger"> Please provide a valid reason</text>');
                                                        return false;
                                                    }
                                                    $.post('./occurrence/op_ior', 
                                                    {at: at,p_reason: p_reason,p_est_date : p_est_date ,p_file : p_file,p_wrongresp : p_wrongresp},
                                                    function(data) {
                                                         if (data == 1) {
                                                            $.alert('IOR status changed to Progress and we will notif to the reporter');
                                                            showiorlist_in();
                                                         } else if (data == 0) {
                                                            $.alert('We will notif to admin IF this ior is not for your unit ');
                                                            showiorlist_in();
                                                        } else {
                                                            $.alert('IOR status changed to Progress and we will notif to the reporter');
                                                            showiorlist_in();   
                                                        }
                                                    })
                                                }
                                            },
                                    cancel: function() {},
                            }
                                }); 
}
function tutorial(id){
    $('#guidance_panel').attr("src","../assets/img/help/overview.pdf"); 
    $('#overview').modal('show');
}
function overview(id){
    $('#guidance_panel').attr("src","../assets/img/help/New_IOR_Database.mp4"); 
    $('#overview').modal('show');
}
function flowprocess(id){
    $('#guidance_panel').attr("src","../assets/img/help/IOR_Flow_Process.mp4"); 
    $('#overview').modal('show');
}

$("#overview").on('hidden.bs.modal', function (e) {
    $('#guidance_panel').attr("src",""); 
});

