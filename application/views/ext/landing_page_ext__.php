<script type="text/javascript">
    var months = new Array(12);
                        months[0] = "January";
                        months[1] = "February";
                        months[2] = "March";
                        months[3] = "April";
                        months[4] = "May";
                        months[5] = "June";
                        months[6] = "July";
                        months[7] = "August";
                        months[8] = "September";
                        months[9] = "October";
                        months[10] = "November";
                        months[11] = "December";
    var where = '<?php $this->session->userdata('occ_users_1103')->role ?>' ;
    $('#occ_date').datepicker({
        maxDate : '2017-09-06',
        autoclose: true,
        format : 'yyyy-mm-dd',
    });
    $(document).ready(function() {
        showiorlist_in();
        var GA_opt = '<select class="form-control" name="sub_lvl_typ" id="sub_lvl_typ"><option value="GA"> GA </option><option value="Others">Others</option></select>';
        $('#send_to,#category,#sub_category,#sub_category_stats,#occ_status,#f_occ_status,#f_occ_unit,#addfoll_send_to,#sub_lvl_typ,#sub_apu_sub,#e_occ_risk_idx').select2({
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
                $.post('<?php echo site_url('dashboard/getocc_subcat'); ?>', 
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
                $.post('<?php echo site_url('dashboard/getocc_subcat_spec'); ?>', 
                    { sub_cat_id : sub_cat_id
                    }, function(data){
                        $('#sub_category_stats,#e_sub_category_stats').select2().select2().html(data);
                    }
                    );
            }
        });

        $('#level_type').change(function(){
            var lvltpval = $(this).val();
            var GA_opt = '<select class="form-control sub_lvl_typ" name="sub_lvl_typ" id="sub_lvl_typ"><option value="GA"> GA </option><option value="Others">Others</option></select>';
            var subGA_opt = '<select class="form-control" name="sub_apu_sub" id="sub_apu_sub">"<?=modules::run('dashboard/getocc_acreg_ga');?>"</select>'
            var APU_opt = '<input type="text" class="form-control" name="sub_lvl_typ" id="sub_lvl_typ" placeholder="Describe your apu here."/>';
            
            var COMP_opt = '<input type="text" class="form-control" name="sub_lvl_typ" id="sub_lvl_typ" placeholder=" S/N "/>';
            var subCOMP_opt = '<input type="text" class="form-control" name="sub_apu_sub" id="sub_apu_sub" placeholder=" P/N "/>';
            var subopth = '<input type="hidden" class="form-control" name="sub_lvl_typ" id="sub_lvl_typ"/>';
            var subCOMP_opth = '<input type="hidden" class="form-control" name="sub_apu_sub" id="sub_apu_sub" placeholder=" P/N "/>';

            if(lvltpval == 'Aircraft'){
                $('#foracty').html(GA_opt);
                
                $('#subforacty').html(subGA_opt);
                $('#sub_lvl_typ,#sub_apu_sub').select2({
                    width : '100%'
                });

                $('.sub_lvl_typ').change(function(){
                    var sublvltpval = $(this).val();
                    if(sublvltpval == 'GA'){
                        $('#subforacty').html(subGA_opt);
                        $('#sub_apu_sub').select2({
                            width : '100%'
                        });
                    }
                    if(sublvltpval == 'Others'){
                        $('#subforacty').html(subCOMP_opth);
                    }
                });
            }
            if(lvltpval == '-'){
                $('#foracty').html(subopth);
                $('#subforacty').html(subCOMP_opth);
            } 
            if(lvltpval == 'APU'){
                $('#foracty').html(APU_opt);
                $('#subforacty').html(subCOMP_opth)
            }
            if(lvltpval == 'Component'){ 
                $('#foracty').html(COMP_opt);
                $('#subforacty').html(subCOMP_opt);
            }
            if(lvltpval == 'Engine'){
                $('#foracty').html(COMP_opt);
                $('#subforacty').html(subCOMP_opth);
            }
            if(lvltpval == 'Others'){
                $('#foracty').html(subopth);
                $('#subforacty').html(subCOMP_opth);
            }         
        });
        
        $('.table-responsive').on('show.bs.dropdown', function () {
           $('.table-responsive').css( "overflow", "inherit" );
       });
    });
    $('.table-responsive').on('hide.bs.dropdown', function () {
       $('.table-responsive').css( "overflow", "auto" );
   })
    by = "<?php echo $this->session->userdata('occ_users_1103')->username; ?>" ;  
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
function showiorlist(id){
    if (!id) {
             url = "get_occ_for_self" ;
            $('#pan-title').text(' IOR Received');
            $('#pan-title-class').attr('class','fa fa-inbox');
    }
    else{
        url = id ;  
        $('.fb').addClass('hidden');
        $('.ed').removeClass('hidden');
            if (id == 'get_occ_by_unit_verified') {
             $('.fb').removeClass('hidden');
             $('.ed').addClass('hidden');
             $('#btn_verivying').addClass('hidden');
             $('#follow_description').addClass('hidden');
             $('#pan-title').text(' IOR Verified');
             $('#pan-title-class').attr('class','fa fa-flag');
        }
        else {
            $('#btn_verivying').removeClass('hidden');
            $('#follow_description').addClass('hidden');
            $('#pan-title').text(' IOR Need Verification');
            $('#pan-title-class').attr('class','fa fa-star');;

        }
    }
        $('#create_ior').addClass('hidden');
        $('#data_follow').addClass('hidden');
        $('#ior_inbox').removeClass('hidden');

        t = $('#occ_open').DataTable({
                    "ajax": "<?php echo site_url('occurrence/');?>/"+ url,
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
                    // "aLengthMenu": [[10, 25, 50, 100,500,1000,-1], [10, 25, 50,100,500,1000, "All"]],
                    "bLengthChange": false,
                    "order": [[ 7, 'DESC' ]] 
        });
}
function showiorlist_in(){
    $('#pan-title').text(' IOR Received');
    $('#pan-title-class').attr('class','fa fa-inbox');
        url = "get_occ_for_self" ;
        $('#create_ior').addClass('hidden');
        $('#data_follow').addClass('hidden');
        $('#ior_inbox').removeClass('hidden');
        $('#btn_add_fo').removeClass('hidden');
        $('#btn_verivying').addClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "<?php echo site_url('occurrence/');?>/"+ url,
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
    $('#pan-title').text(' IOR Send');
    $('#pan-title-class').attr('class','fa fa-rocket');
        $('#follow_description').addClass('hidden');
                url = "get_occ_by_self" ;
                $('#create_ior').addClass('hidden');
                $('#data_follow').addClass('hidden');
                $('#ior_inbox').removeClass('hidden');
                t = $('#occ_open').DataTable({
                            "ajax": "<?php echo site_url('occurrence/');?>/"+ url,
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
            $('#ior_inbox').removeClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "<?php echo site_url('occurrence/');?>/"+ url,
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
    $('#pan-title').text(' NON IOR');
    $('#pan-title-class').attr('class','fa fa-minus-circle');
        url = 'get_non_occ' ; 
            $('#btn_verivying').addClass('hidden');
            $('#follow_description').addClass('hidden');
            $('#create_ior').addClass('hidden');
            $('#data_follow').addClass('hidden');
            $('#ior_inbox').removeClass('hidden');
            $('#occ_open').DataTable({
                    "ajax": "<?php echo site_url('occurrence/');?>/"+ url,
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
                    "order": [[ 1, 'asc' ]] 
        });
}
function showiorlist_again(){
    $('#pan-title').text(' IOR OUT');
    $('#pan-title-class').attr('class','fa fa-rocket');
        url = "get_occ_by_self" ;
        $('#create_ior').addClass('hidden');
        $('#data_follow').addClass('hidden');
        $('#ior_inbox').removeClass('hidden');
        $('#btn_add_fo').addClass('hidden');
        $('#btn_verivying').addClass('hidden');
        t = $('#occ_open').DataTable({
                    "ajax": "<?php echo site_url('occurrence/');?>/"+ url,
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
                "ajax": "<?php echo site_url('occurrence/get_occ_by_unit');?>/"+status+'/'+unit,
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
                "ajax": "<?php echo site_url('occurrence/get_occ_by_unit');?>/"+status+'/'+unit,
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
$(function () {
        $('#chart_ior_1').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly IOR This Year'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'IOR'
                }
            },
            tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>'
                    },
            plotOptions: {
                        series: {
                            borderWidth: 1,
                            dataLabels: {
                                enabled: true
                            },
                             cursor: 'pointer'
                            
                        }
                    },
            credits: {
                        enabled: false
                    },
            series: [{
                name: 'Open',
                data: [49, 71, 106, 129, 144, 176, 135, 148, 216, 194, 95, 54]
            }, {
                name: 'Monitoring',
                data: [83, 78, 98, 93, 106, 84, 105, 104, 91, 83, 106, 92]
    
            }, {
                name: 'Close',
                data: [42, 33, 34, 39, 52, 75, 57, 60, 47, 39, 46, 51]
            }]
        });
});
function v_nocc_detail(id){
    unitlast = "<?php echo $this->session->userdata('occ_users_1103')->unit; ?>" ;
    var subunit = unitlast.substring(3, 2);
    bylast = "<?php echo $this->session->userdata('occ_users_1103')->username; ?>" ;
    $.ajax({
        url : "<?php echo site_url('occurrence/get_det_nocc/')?>/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
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
                $('#permission').text("NOT OCC").removeClass("badge-warning").addClass("badge-danger"); 
                $('#dt_est_finish').text('-');
                $('#dt_est_finish_od').countdown('1970-01-01', function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                $('#ior_inbox').addClass('hidden');
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
function v_occ_detail(id){
    unitlast = "<?php echo $this->session->userdata('occ_users_1103')->unit; ?>" ;
    var subunit = unitlast.substring(3, 2);
    bylast = "<?php echo $this->session->userdata('occ_users_1103')->username; ?>" ;
    $.ajax({
        url : "<?php echo site_url('occurrence/get_det_occ/')?>/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
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
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                if (((data[i].occ_follow_last_by == unitlast) && (data[i].occ_follow_last_by == null)) || ((data[i].occ_send_to == unitlast) && (data[i].occ_follow_last_by == unitlast)) || ((data[i].occ_send_to == unitlast) && (data[i].occ_follow_last_by == null)) )  {
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
                if (((data[i].occ_follow_last_by == unitlast)))  {
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
                $('#dt_occ_description').text(': '+data[i].occ_detail);
                $('#dt_risk_index').text(': '+data[i].occ_risk_index);
                $('#dt_occ_reff').text(': '+data[i].occ_reff);
                $('#dt_occ_subject').text(': '+data[i].occ_sub);
                $('#dt_occ_category').text(': '+data[i].cat_name);
                $('#dt_occ_subcategory').text(': '+ data[i].occ_sub_category);
                
                var etfdu   = data[i].occ_estfinish_date;
                var etfdus  = etfdu.substring(0, 10);
                var etresp  = data[i].occ_response_date;
                var etresps = etresp.substring(0, 10);
                    if (data[i].permission == 0){ 
                    $('#permission').text("NEED VERIFICATION").removeClass("badge-warning").addClass("badge-danger"); 
                    $('#time_resp').text('Time.Response');
                    var rd = data[i].occ_response_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ry + ' ');
                        $('#dt_est_finish_od').countdown(data[i].occ_response_date, function(event) {
                            $(this).html(event.strftime('%D days %H:%M:%S Left'));
                        });
                    }
                    if (data[i].permission == 1){
                    $('#permission').text("VERIFIED").removeClass("badge-danger").addClass("badge-warning") ; 
                    $('#time_resp').text('Est.Finish');
                    var rd = data[i].occ_estfinish_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ry + ' ');
                    $('#dt_est_finish_od').countdown(data[i].countdown, function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                    } 
                $('#ior_inbox').addClass('hidden');
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
                                                    $.post('<?php echo site_url('occurrence/op_ior '); ?>', 
                                                    {at: at,p_reason: p_reason,p_est_date : p_est_date ,p_file : p_file,p_wrongresp : p_wrongresp},
                                                    function(data) {
                                                        if (data == 1) {
                                                            $.post('http://192.168.240.107/ior_reminder/notif_v_opi.php', 
                                                                { post_id : at }, function(data){ }
                                                                );
                                                            $.alert('IOR status changed to Progress and we will notif to the reporter');
                                                            showiorlist_in()
                                                        }
                                                        if (data == 0) {
                                                            $.alert('We will notif to admin IF this ior is not for your unit ');
                                                            showiorlist_in();
                                                        }
                                                    })
                                                }
                                            },
                                    cancel: function() {},
                            }
                                }); 
}
function purpose(){
    at = $('#id_verifying').val();
    et = $('#dt_est_finish').val();
    $.confirm({ 
    columnClass: 'col-md-5 col-md-offset-3',
    title: 'Give your close reason',
    content:'' +
        '<form action="" class="formName">' +
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
                                                if(!c_reason){
                                                    $.alert('<text class="text-danger"> Please provide a close reason</text>');
                                                    return false;
                                                }
                                                if(!c_file){
                                                    $.alert('<text class="text-danger"> Please provide a file</text>');
                                                    return false;
                                                }
                                                $.post('<?php echo site_url('occurrence/c_ior '); ?>',
                                                {at: at,c_reason:c_reason,c_file : c_file },
                                                function(data) {
                                                    if (data == 4) {
                                                        $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE STILL IN PROGRESS BY UIC</strong');
                                                    }
                                                    if (data == 3) {
                                                        $.alert('<strong class="text-danger">IOR CANT CLOSE,CAUSE STILL NO PROGRESS OR RESPONSE</strong');
                                                    }
                                                    if (data == 2) {
                                                        $.post('http://192.168.240.107/ior_reminder/notif_v_cir.php', 
                                                                { post_id : at }, function(data){ }
                                                                );
                                                        $.post('http://192.168.240.107/ior_reminder/notif_v_cir.php', 
                                                                { post_id : at }, function(data){ }
                                                                );
                                                        $.alert('IOR Closed but waiting to confirmed by unit reporter');
                                                        showiorlist_in()
                                                    }
                                                    if (data == 1) {
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
                                                            '<label>Close reason</label>' +
                                                                '<input type="text" placeholder="" class="c_reason form-control" required />' +
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
                                                                        var c_file = this.$content.find('.nm_file_fo').val();
                                                                        if(!c_reason){
                                                                            $.alert('<text class="text-danger"> Please provide a close reason</text>');
                                                                            return false;
                                                                        }
                                                                        $.post('<?php echo site_url('occurrence/c_ior '); ?>',
                                                                        {at: at,c_reason:c_reason,c_file : c_file },
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
                                                            '<label>Close reason</label>' +
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
                                                                                $.post('<?php echo site_url('occurrence/cc_ior '); ?>',
                                                                                {at: at,cc_reason:cc_reason},
                                                                                function(data) {
                                                                                    if (data == 1) {
                                                                                        $.post('http://192.168.240.107/ior_reminder/notif_v_nci.php', 
                                                                                        { post_id : at }, function(data){ }
                                                                                        );
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
function show_file_occ(id){
    ocf = $('#occ_file').DataTable({
                "ajax": "<?php echo site_url('occurrence/get_occ_file');?>/" + id,
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
    tf = $('#occ_follow').DataTable({
                "ajax": "<?php echo site_url('occurrence/get_occ_follow');?>/" + id,
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
        url : "<?php echo site_url('occurrence/get_det_follow/')?>/" + id,
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
function show_file_occ_fo(id){
    ocf = $('#occ_file_fo').DataTable({
                "ajax": "<?php echo site_url('occurrence/get_occ_file_fo');?>/" + id,
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
$('#form_new_ior').on('submit', function(e) {
    e.preventDefault();
    // dtval = $('.note-editable').text();
    // $('#occ_detail').val(dtval);
        url = "<?php echo site_url('occurrence/save_new')?>";
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
}

$('#file_m').on('click', function(){
    $('.dz-preview ').remove();
    //$('.nm_file').remove();
    $('.dz-filename').remove();
    $('#file_handler').modal({backdrop: 'static', keyboard: false},'show'
                            );
});
function filfol(){
    $('.dz-preview ').remove();
    $('.dz-filename').remove();

    $('#file_handler_pro').modal('show');
}
$('#file_mfo').on('click', function(){
    $('.dz-preview ').remove();
    //$('.nm_file_fo').remove();
    $('.dz-filename').remove();
    $('#file_handler_fo').modal({backdrop: 'static', keyboard: false},'show'
                            );
});
    var counter = 0;
    var counterfo = 0;
function check(){
    counter++;
    $('.dz-filename').each(function(){
        var str = $(this).text();
        var fn = str.substring(0, 30);
        var recep = '<input type="hidden" id="f1'+(counter)+'" class="nm_file" name="file_name[]" value="'+$(this).text()+'"><i class="fileclear" id="lb'+(counter)+'">'+fn+'... <a id="bb'+(counter)+'" href="#" onclick="remove('+(counter)+')" >remove</a><br></i>';
    $('#filegetname').append(recep);
    })
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
    $('.file_name_fo').remove();
    counterfo++;
    $('.dz-filename').each(function(){
        var str = $(this).text();
        var fnfo = str.substring(0, 25);
        var recep = '<input type="hidden" id="f1fo'+(counterfo)+'" class="nm_file_fo" name="file_name_fo[]" value="'+$(this).text()+'"><i class="file_name_fo" id="lbfo'+(counterfo)+'">'+fnfo+'... <a id="bbfo'+(counterfo)+'" href="#" onclick="removefo('+(counterfo)+')" >remove</a><br></i>';
    $('#filegetnamepro').append(recep);
    }) 
    $('#file_handler_pro').modal('hide');
}
function removefo(id){
    $('#lbfo'+id+'').remove();
    $('#bbfo'+id+'').remove();
    $('#f1fo'+id+'').remove();   
}
$('#occ_risk_idx').on('click', function(){
    $('#list_probability').DataTable({
                    "ajax": "<?php echo site_url('occurrence/get_probability');?>",
                    "processing": true,
                    "info" : false,
                    "bDestroy": true,
                    "deferRender": true,
                    "paging" : false,
                    "bLengthChange": false,
                    "order": [[ 2, 'desc' ]],
                    "columnDefs": [{"targets": 1,
                                    "width": 600},
                                    {"targets": 3,
                                    "width": 200}],
        });
    $('#list_severity').DataTable({
                    "ajax": "<?php echo site_url('occurrence/get_severity');?>",
                    "processing": true,
                    "info" : false,
                    "bDestroy": true,
                    "deferRender": true,
                    "pageLength" : 5,
                    "paging" : false,
                    "bLengthChange": false,
                    "order": [[ 2, 'desc' ]],
                    "columnDefs": [{"targets": 1,
                                    "width": 600},
                                    {"targets": 3,
                                    "width": 200}],
        });
    $('#risk_index_select').modal('show');
});
$('#form_risk_index').on('submit', function(e) {
    e.preventDefault();
        $('#occ_risk_idx').val('');
        ra = $("input[name=probradio]:checked").val()+ $("input[name=severadio]:checked").val() ;
        $('#occ_risk_idx').val(ra);
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
function showing(id){
    $('.panel-toggled-severity'+id).removeClass('severity-bod');
}
function hidding(id){
    $('.panel-toggled-severity'+id).addClass('severity-bod');
}
function preview(id){
    id = $('#preview_fn'+id).text();
    $('#obj_file').attr("data","ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/"+ id); 
    $('#obj_file_nd').attr("download","ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/"+ id);  
    $('#obj_file_op').attr("href","ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/"+ id,"target","_blank"); 
    $('#obj_file_n').text(id); 
    $('#preview_file').modal('show');
}
function preview_fo(id){
    id = $('#preview_fnfo'+id).text();
    $('#obj_file').attr("data","ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/"+ id); 
    $('#obj_file_nd').attr("download","ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/"+ id);  
    $('#obj_file_op').attr("href","ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/"+ id,"target","_blank"); 
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
<?php if ($this->session->userdata('occ_users_1103')->role == 1 ) { ?> 
    $('#e_occ_date').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
    });
function e_ior(){
    $('#edit_ior').modal('show');
    id = $('#id_verifying').val();
    $.ajax({
        url : "<?php echo site_url('occurrence/get_det_occ/')?>/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('#e_send_to,#e_category,#e_sub_category,#e_sub_category_stats').select2();
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                $("#e_send_to").val(data[i].occ_send_to).trigger('change');
                $('#e_subject').val(data[i].occ_sub);
                $('#e_occ_reference').val(data[i].occ_reff);
                $("#e_category").val(data[i].occ_category).trigger('change');
                $("#e_sub_category").val(data[i].occ_sub_category).trigger('change');
				$("#e_occ_risk_idx").val(data[i].occ_risk_index).trigger('change');
                $('#e_occ_date').val(data[i].occ_date);
                $('#e_occ_detail').val(data[i].occ_detail);
                $('#e_occ_risk_idx').val(data[i].occ_risk_index);
                default_opt = data[i].occ_sub_category ;
          }
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
$('#e_category').change(function(){
            var cat_id = $(this).val();
            var catdeff = '<option value="-"> - </option>';
            if(cat_id == ''){
                $('#e_sub_category').select2().select2().html(default_opt);
            }else{
                $('#e_sub_category').select2().select2().html();
                $.post('<?php echo site_url('dashboard/getocc_subcat'); ?>', 
                    { cat_id : cat_id
                    }, function(data){
                        $('#e_sub_category').select2().select2().html(catdeff);
                        $('#e_sub_category').select2().select2().html(data);
                        $("#e_sub_category").val(default_opt).trigger('change');
                    }
                    );
            }
        });
function v_occ_detaiI(id){
    unitlast = "<?php echo $this->session->userdata('occ_users_1103')->unit; ?>" ;
    bylast = "<?php echo $this->session->userdata('occ_users_1103')->username; ?>" ;
    $.ajax({
        url : "<?php echo site_url('occurrence/get_det_occ/')?>/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
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
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                    $('.ed').remove();
                    $('.high').append('<button id="add" onclick="e_ior()" class="btn btn-default ed" id="to_f"><span class="fa fa-edit"></span>Edit Data</button></button><button id="btn_verivying" onclick="verifying()" class="btn btn-default ed"><span class="fa fa-mail-reply"></span>Verify</button>');
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
                var d = new Date(data[i].occ_response_date);
                var n = d.getDay();
                    if (data[i].permission == 0){ 
                    $('#permission').text("NEED VERIFICATION").removeClass("badge-warning").addClass("badge-danger"); 
                    $('#time_resp').text('Time.Response');
                    var rd = data[i].occ_response_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ry + ' ');
                    $('#dt_est_finish_od').countdown(data[i].occ_response_date, function(event) {
                        $(this).html(event.strftime('%n days %H:%M:%S Left'));
                    });
                    }
                $('#ior_inbox').addClass('hidden');
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
function v_occ__detail(id){
    unitlast = "<?php echo $this->session->userdata('occ_users_1103')->unit; ?>" ;
    bylast = "<?php echo $this->session->userdata('occ_users_1103')->username; ?>" ;
    $.ajax({
        url : "<?php echo site_url('occurrence/get_det_occ/')?>/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
            $('#data_follow').removeClass('hidden');
                $('#id_verifying').val('');
                $('#dt_ior_number').text('');
                $('#follestimated').val(''); 
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
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                    $('.ed,.fb').remove();
                        if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 3)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button class="btn btn-default pc" onclick="purpose_close()"><span class="fa fa-plus"></span>Close IOR</button>');
                            $('.high').append('<button id="add" onclick="addfollow()" class="btn btn-default fb" id="to_f"><span class="fa fa-plus"></span>Add Follow</button>');
                        }
                        if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 2)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button id="add" onclick="addfollow()" class="btn btn-default fb" id="to_f"><span class="fa fa-plus"></span>Add Follow</button>');
                        }if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 1)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button id="add" onclick="addfollow()" class="btn btn-default fb" id="to_f"><span class="fa fa-plus"></span>Add Follow</button>');
                        }
                $('#id_verifying').val(data[i].occ_id);
                $('#dt_ior_number').text(': '+data[i].occ_no);
                $('#dt_occ_by').text(': '+data[i].created_by);
                $('#addfollid').val(data[i].occ_id); 
                $('#follestimated').val(data[i].occ_estfinish_date); 
                $('#dt_occ_by2').text(data[i].created_by);
                $('#dt_occ_createddate').text(': '+data[i].created_date);
                $('#dt_occ_send_to').text(': '+data[i].occ_send_to);
                $('#dt_occ_description').text(': '+data[i].occ_detail);
                $('#dt_risk_index').text(': '+data[i].occ_risk_index);
                $('#dt_occ_reff').text(': '+data[i].occ_reff);
                $('#dt_occ_subject').text(': '+data[i].occ_sub);
                $('#dt_occ_category').text(': '+data[i].cat_name);
                $('#dt_occ_subcategory').text(': '+data[i].cat_sub_desc);
                    if (data[i].permission == 1 ){
                    $('#permission').text("VERIFIED").removeClass("badge-danger").addClass("badge-warning") ; 
                    $('#time_resp').text('Est.Finish');
                    var rd = data[i].occ_estfinish_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var rm = rd.substring(5, 7);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ry + ' ');
                    $('#dt_est_finish_od').countdown(data[i].countdown, function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                    }
                    $('#ior_inbox').addClass('hidden');
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
function addfollow(id){
    $('#addfollbutton').text('SEND');
    $('#addfollbutton').attr('disabled',false); 
    $('#modal_add_follow').find('form')[0].reset() ;
    by = $('#addfollid').val();
    on = $('#dt_ior_number').text();
    est = $('#follestimated').val();
    $('#addsub').text(on);
    $('#addfollto').val(by);
    $('#ffollestimated').val(est);
    $("#addfoll_send_to").val(null).trigger("change");
    $('#modal_add_follow').modal('show');
}
function verifying (){
    id_verifying = $('#id_verifying').val();
    $.confirm({
                title: 'IS THIS AN IOR???',
                content: 'If yes, we will send notification to unit reported',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm1': {
                        text: 'YES',
                        btnClass: 'btn-blue',
                        action: function () {
                            $.post('<?php echo site_url('occurrence/occ_verified '); ?>', 
                                                    {id_verifying : id_verifying},
                                                    function(data) {
                                                        if (data == 1) {
                                                            $.alert('You put this to <strong>IOR LIST</strong>');
                                                                $.post('http://192.168.240.107/ior_reminder/notif_v_i.php', 
                                                                { post_id : id_verifying }, function(data){ }
                                                                );
                                                                $.post('http://192.168.240.107/ior_reminder/notif_v_a_uci.php', 
                                                                { post_id : id_verifying }, function(data){ }
                                                                );
                                                            showiorlist_verified();
                                                        } else {
                                                            $.alert('Error Network, please try again later ');
                                                            
                                                        }
                                                    })
                        }
                    },
                    'confirm2': {
                        text: 'NOT IOR',
                        action: function () {
                        $.confirm({ 
                            columnClass: 'col-md-5 col-md-offset-3',
                            title: 'Your reason ???',
                                content:'' +
                                        '<form action="" class="formName">' +
                                        '<div class="form-group">' +
                                        '<label>Describe your reason</label>' +
                                            '<input type="text" placeholder="" class="n_occ_reason form-control" required />' +
                                        '</div>' +
                                        '<div class="form-group">' +
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
                                                    var n_occ_reason = this.$content.find('.n_occ_reason').val();
                                                    if(!n_occ_reason){
                                                        $.alert('<text class="text-danger"> Please provide a valid reason</text>');
                                                        return false;
                                                    }
                                                     $.post('<?php echo site_url('occurrence/occ_no_verified '); ?>', 
                                                    {id_verifying : id_verifying,n_occ_reason: n_occ_reason},
                                                    function(data) {
                                                        if (data == 1) {
                                                            $.alert('You put this to <strong>NOT IOR LIST</strong>');
                                                                $.post('http://192.168.240.107/ior_reminder/notif_v_ni.php', 
                                                                { post_id : data.where }, function(data){ }
                                                                );
                                                            showiorlist_in();
                                                        } else {
                                                            $.alert('Error Network, please try again later ');
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
                    cancel: function () {
                                   
                                },
                }
            });
}
$('#form_edit_ior').on('submit', function(e) {
    e.preventDefault();
    u_id = $('#id_verifying').val();
    $.confirm({
                title: 'Update this ior data ??',
                content: '',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm1': {
                        text: 'YES',
                        btnClass: 'btn-blue',
                        action: function () {
                            $.ajax({                                            
                                url : "<?php echo site_url('occurrence/occ_update')?>/"+ u_id,
                                data: $('#form_edit_ior').serialize(),
                                type: "POST",
                                dataType: "JSON",
                                beforeSend: function(){
                                   
                                },
                                success: function(data){
                                    if(data == 110){
                                        $.alert('Update succes');
                                        v_occ_detaiI(u_id);
                                        $('#edit_ior').modal('hide');
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown){
                                    alert('Failed to update !!');
                                }
                               });
                        }
                    },
                    cancel: function () {
                                   
                                },
                }
            });
});
$('#form_add_follow').on('submit', function(e) {
    e.preventDefault();
        url = "<?php echo site_url('occurrence/save_follow_on')?>";
            $.ajax({                                            
                    url : url,
                    type: "POST",
                    data: $('#form_add_follow').serialize(),
                    dataType: "JSON",
                    beforeSend: function(){
                        $('#addfollbutton').text('Sending...');
                        $('#addfollbutton').attr('disabled',true);
                    },
                    success: function(data){
                        if(data.status = "true"){
                        $.alert('<strong>Your follow data has been added</strong>');
                        $('#addfollbutton').text("Send Succes");
                        $('#addfollbutton').attr('disabled',true); 
                        $('#modal_add_follow').modal('hide');
                        $('#modal_add_follow').find('form')[0].reset() ;
                        $('#occ_follow').DataTable().ajax.reload();
                        by = $('#addfollid').val();
                        v_occ__detail(by);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        alert('Failed!');
                        $('#addfollbutton').text('SEND');
                        $('#addfollbutton').attr('disabled',false); 
                      }
                });   
});
<?php } ?>
</script>