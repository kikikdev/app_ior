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
    var where = <?php echo $this->session->userdata('occ_users_1103')->role ;?> ;
    $('#occ_date').datepicker({
        maxDate : '2017-09-06',
        autoclose: true,
        format : 'yyyy-mm-dd',
    });
    $(document).ready(function() {
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
    by = $('.name-name').text();

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
                $('#e_subject').val();
                $('#e_occ_reference').val();
                $("#e_occ_risk_idx").val('');
                $('#e_occ_date').val();
                // $('#e_occ_detail').html();
                $('#e_occ_detail').val();
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
                var str = data[i].occ_detail;
                var res = str.replace("<br />", " ");
                // $('#e_occ_detail').html(res);
                $('#e_occ_detail').val(res);
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
            $('.ed,.eb,.fb,.op,.pc,.aat,.ncb').remove();
            $('#follow_description').addClass('hidden');
            $('#ior_inbox').addClass('hidden');
            $('#data_follow').removeClass('hidden');
                $('#id_verifying').val('');
                $('#id_v_file').val('');
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
                    $('.ed,.aat').remove();
                    $('.high').append('<button id="add" onclick="e_ior()" class="btn btn-default ed" id="to_f"><span class="fa fa-edit"></span>Edit Data</button></button><button id="btn_verivying" onclick="verifying()" class="btn btn-default ed"><span class="fa fa-mail-reply"></span>Verify</button>');
                $('#id_verifying').val(data[i].occ_id);
                $('#id_v_file').val(data[i].occ_no);
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
                $('#dt_occ_subcategory').text(': '+data[i].cat_sub_desc);
                $('#dt_risk_reportby').text(': '+ data[i].created_by_name);
                $('#dt_risk_insertby').text(': '+ data[i].InsertBy);
                $('.dt-verified').addClass('hidden');
                $('#stats_permision').addClass("hidden"); 
                var d = new Date(data[i].occ_response_date);
                var n = d.getDay();
                    if (data[i].permission == 0){ 
                    $('#permission').text("NEED VERIFICATION").removeClass("badge-warning").addClass("badge-needver");
                        if (data[i].verifikator_resp >= 0) {
                            $('#permission').text("NEED VERIFICATION").removeClass("badge-warning").removeClass("badge-needver").addClass("badge-danger"); 
                        } 
                    $('#time_resp').text('Time.Response');
                    var rd = data[i].occ_response_date;
                    var rr = rd.substring(8, 10);
                    var ry = rd.substring(0, 4);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value] + ' ' + ry + ' ');
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
    var wts = $('#'+id).attr('wts');
    unitlast = "<?php echo $this->session->userdata('occ_users_1103')->unit; ?>" ;
    bylast = "<?php echo $this->session->userdata('occ_users_1103')->username; ?>" ;
    $.ajax({
        url : "<?php echo site_url('occurrence/get_det_occ/')?>/" + id,
        dataType: "JSON",
        beforeSend: function() {
            $('.ed,.eb,.fb,.op,.pc,.aat').remove();
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
                $('#dt_risk_insertby').text('');
                $('#dt_risk_reportby').text('');
                $('#permission').text('');
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
                    $('.ed,.fb,.ncb').remove();
                        if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 3)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button class="btn btn-default pc" onclick="purpose_close()"><span class="fa fa-plus"></span>Close IOR</button>');
                            $('.high').append('<button id="add" onclick="addfollow()" class="btn btn-default fb" id="to_f"><span class="fa fa-plus"></span>Add Follow</button>');
                        }
                        if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 2)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button id="add" onclick="addfollow()" class="btn btn-default fb" id="to_f"><span class="fa fa-plus"></span>Add Follow</button>');
                            $('.high').append('<button id="rev" onclick="revisionior()" class="btn btn-default fb" id="to_f"><span class="fa fa-pencil"></span> Revision </button>');

                        }if ((data[i].occ_status == 1) && (data[i].occ_confirm_stats == 1)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button id="add" onclick="addfollow()" class="btn btn-default fb" id="to_f"><span class="fa fa-plus"></span>Add Follow</button>');
                            $('.high').append('<button id="rev" onclick="revisionior()" class="btn btn-default fb" id="to_f"><span class="fa fa-pencil"></span> Revision </button>');
                        }
                        if ((data[i].occ_status == 0) && (data[i].occ_confirm_stats == 0)) {
                            $('.ed,.eb,.fb,.op,.pc').remove();
                            $('.high').append('<button id="ncrc" onclick="ncr_close(0)" class="btn btn-default ncb"><span class="fa fa-plus"></span>Revision NCR</button> ');
                            $('.high').append('<button id="ncrc" onclick="ncr_close(1)" class="btn btn-default ncb"><span class="fa fa-plus"></span>Release Attachment</button>');
                            
                        }
                $('#id_verifying').val(data[i].occ_id);
                $('#dt_ior_number').text(': '+data[i].occ_no);
                $('#dt_occ_by').text(': '+data[i].created_by);
                $('#addfollid').val(data[i].occ_id); 
                $('#follestimated').val(data[i].occ_estfinish_date); 
                $('#dt_occ_by2').text(data[i].created_by);
                $('#dt_occ_createddate').text(': '+data[i].created_date);
                $('#dt_occ_send_to').text(': '+data[i].occ_send_to);
                $('#dt_risk_reportby').text(': '+ data[i].created_by+'/'+data[i].created_by_name+'/'+data[i].created_by_unit);
                $('#dt_risk_insertby').text(': '+ data[i].InsertBy);
                $('#dt_verified_by').text(': '+ data[i].hazard);
                $('.dt-verified').removeClass('hidden');
                
                // $('#dt_occ_description').text(': '+data[i].occ_detail);
                descr = data[i].occ_detail ;
                document.getElementById("dt_occ_description").innerHTML = descr;
                $('#dt_risk_index').text(': '+data[i].occ_risk_index);
                $('#dt_occ_reff').text(': '+data[i].occ_reff);
                $('#dt_occ_subject').text(': '+data[i].occ_sub);
                $('#dt_occ_category').text(': '+data[i].cat_name);
                $('#dt_occ_subcategory').text(': '+data[i].cat_sub_desc);
                    if (data[i].permission == 1){
                        if (data[i].duedate >= 0 ){
                            $('#permission').text("Overdue").removeClass().addClass("badge badge-danger"); 
                            $('#stats_permision').addClass("hidden"); 
                                if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 1) {
                                    $('#stats_permision').text("Open").removeClass().addClass("badge badge-warning"); 
                                }
                                if (data[i].occ_status == 1 && data[i].occ_confirm_stats == 3 ){
                                    $('#permission').text("Waiting Close").removeClass().addClass("badge badge-succes") ; 
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
                            if (wts >= 6) {
                                $('#permission').text("Waiting Close").removeClass().addClass("badge badge-danger") ; 
                                $('#stats_permision').addClass("hidden");     
                            }
                            if (wts <= 5) {
                                $('#permission').text("Waiting Close").removeClass().addClass("badge badge-succes") ; 
                                $('#stats_permision').addClass("hidden");     
                            }
                            
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
                    var rm = rd.substring(5, 7);
                    var current_date =  new Date(rd);
                    month_value = current_date.getMonth();
                    $('#dt_est_finish').text(' : ' + rr + ' ' + months[month_value]  + ' ' +  ry + ' ');
                    $('#dt_est_finish_od').countdown(data[i].countdown, function(event) {
                        $(this).html(event.strftime('%D days %H:%M:%S Left'));
                    });
                    }
                    $('#ior_inbox').addClass('hidden');
                    $('#data_follow').removeClass('hidden');
                showfollowlist(data[i].occ_id);
                refer = data[i].occ_id ;
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
function revisionior(id){
    $('#revbtn').attr('disabled',false); 
    $('#modal_revision').find('form')[0].reset() ;
    by = $('#addfollid').val();
    on = $('#dt_ior_number').text();
    est = $('#follestimated').val();
    $('#revsub').text(on);
    $('#revparam').val(by);
    $('#revest').val(est);


    $('#modal_revision').modal('show');
}
function verifying(){
    id_verifying = $('#id_verifying').val();
    id_v_file = $('#id_v_file').val();
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
                                                    {id_verifying : id_verifying,id_v_file : id_v_file},
                                                    function(data) {
                                                        if (data == 1) {
                                                            $.alert('You put this to <strong>IOR LIST</strong>');
                                                                //$.post('http://192.168.240.107/ior_reminder/notif_v_i.php', 
                                                               // { post_id : id_verifying }, function(data){ }
                                                                //);
                                                                // $.post('http://192.168.240.107/ior_reminder/notif_v_a_uci.php', 
                                                                // { post_id : id_verifying }, function(data){ }
                                                                // );
                                                            showiorlist('get_occ_by_unit');
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
                                            '<textarea class="n_occ_reason form-control" rows="5" required /> </textarea>' +
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
                                                    {id_verifying : id_verifying,n_occ_reason: n_occ_reason,id_v_file : id_v_file},
                                                    function(data) {
                                                        if (data) {
                                                            $.alert('You put this to <strong>NOT IOR LIST</strong>');
                                                            show_non_iorlist();
                                                        } else {
                                                            $.alert('Error Network, please try again later ');
                                                            showiorlist('get_occ_by_unit');
                                                        }
                                                    })
                                                }
                                            },
                                    cancel: function() {},
                            }
                                }) 
                        }
                    },
                    'confirm3': {
                        text: 'OHR',
                        action: function () {
                        $.confirm({ 
                            columnClass: 'col-md-5 col-md-offset-3',
                            title: 'Your reason ???',
                                content:'' +
                                        '<form action="" class="formName">' +
                                        '<div class="form-group">' +
                                        '<label>Describe your reason</label>' +
                                            '<textarea class="n_occ_reason form-control" rows="5" required /> </textarea>' +
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
                                                    var n_occ_reason = this.$content.find('.n_occ_reason').val();
                                                    var ohrfile = this.$content.find('.nm_file_fo').val();
                                                    if(!n_occ_reason){
                                                        $.alert('<text class="text-danger"> Please provide a valid reason</text>');
                                                        return false;
                                                    }
                                                     $.post('<?php echo site_url('occurrence/occ_no_area '); ?>', 
                                                    {id_verifying : id_verifying,n_occ_reason: n_occ_reason,id_v_file : id_v_file ,
                                                        ohrfile : ohrfile},
                                                    function(data) {
                                                        if (data) {
                                                            $.alert('You put this to <strong>OHR LIST</strong>');
                                                                $.post('http://192.168.240.107/ior_reminder/notif_v_ni.php', 
                                                                { post_id : data }, function(data){ }
                                                                );
                                                            show_ohr_iorlist();
                                                        } else {
                                                            $.alert('Error Network, please try again later ');
                                                            showiorlist('get_occ_by_unit');
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
    var foll_to = $('#addfollto').val();
    var next_unit_is = $('[name="addfoll_send_to"]').val();
    if (next_unit_is != '-') {
        $.post('http://192.168.240.107/ior_reminder/notif_v_a_follow.php', { post_id : foll_to , next_unit_is : next_unit_is }, function(data){
                        
        });
    }
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
$('#form_revision_ior').on('submit', function(e) {
    e.preventDefault();
    u_id = $('#id_verifying').val();
    url = "<?php echo site_url('occurrence/revision_ior')?>";
    $.confirm({
                title: 'Revision this ior data ??',
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
                                    url : url,
                                    type: "POST",
                                    data: $('#form_revision_ior').serialize(),
                                    dataType: "JSON",
                                    beforeSend: function(){
                                        $('#revbtn').text('Sending...');
                                        $('#revbtn').attr('disabled',true);
                                    },
                                    success: function(data){
                                        if(data.status = "true"){
                                            $.alert('IOR Reopened...');
                                            $('#revbtn').text('SEND');
                                            $('#revbtn').attr('disabled',false); 
                                            $('#modal_revision').modal('hide');
                                            v_occ__detail(refer);
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown){
                                        alert('Failed!');
                                        $('#revbtn').text('SEND');
                                        $('#revbtn').attr('disabled',false); 
                                      }
                                });  
                        }
                    },
                    cancel: function () {
                                   
                                },
                }
            });
}); 
<?php } ?>
</script>