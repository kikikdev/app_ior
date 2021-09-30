<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('ext/head'); ?>
<body style="font-size: 11px;">
    <!-- START PAGE CONTAINER -->
    <div class="page-container page-navigation-toggled">
        <!-- page-navigation-top-fixed -->
        <?php $this->load->view('ext/menu');?>        
        <!-- PAGE CONTENT -->
        <div class="page-content">
            <?php $this->load->view('ext/navigations'); ?>            
            <!-- START CONTENT FRAME -->
            <div class="content-frame">                                    
                <!-- START CONTENT FRAME TOP -->
                <div class="content-frame-top">                        
                    <div class="page-title">                    
                        <h2><span class="fa fa-inbox"></span> IOR Data </h2>
                    </div>
                    <div class="pull-right">                            
                        <!-- <button class="btn btn-default"><span class="fa fa-cogs"></span> Settings</button> -->
                        <button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
                    </div>                        
                </div>
                <!-- END CONTENT FRAME TOP -->
                
                <!-- START CONTENT FRAME LEFT -->
                <div class="content-frame-left">
                    <div class="block">
                        <a onclick="add()" href="#" class="btn btn-warning btn-block btn-lg"><span class="fa fa-edit"></span> CREATE IOR</a>
                    </div>
                    <div class="block">
                        <div class="list-group border-bottom">
                            <?php if ($this->session->userdata('occ_users_1103')->role == 1) { ?>
                            <a onclick="showiorlist('get_occ_by_unit')" href="#" class="list-group-item"><span class="fa fa-star"></span> IOR Need Verification</a> 
                            <a onclick="showiorlist('get_occ_by_unit_verified_waiting_close')" href="#" class="list-group-item"><span class="fa fa-check-square"></span> IOR Waiting To Close</a> 
                            <a onclick="showiorlist('get_occ_by_unit_verified')" href="#" class="list-group-item"><span class="fa fa-flag"></span>IOR Verified</a>
                            <a onclick="show_non_iorlist()" href="#" class="list-group-item"><span class="fa fa-minus-circle"></span>Non IOR</a>
                            <a onclick="show_ohr_iorlist()" href="#" class="list-group-item"><span class="fa fa-filter"></span>OHR</a>
                            <?php } ?>
                            <a onclick="showiorlist_in()" href="#" class="list-group-item"><span class="fa fa-inbox"></span> IOR Received</a>
                            <a onclick="showiorlist_out()" href="#" class="list-group-item"><span class="fa fa-rocket"></span> IOR Send</a>
                            <?php if ($this->session->userdata('occ_users_1103')->role == 0) { ?>
                            <a onclick="show_non_iorlist()" href="#" class="list-group-item"><span class="fa fa-minus-circle"></span>Non IOR</a>
                            <a onclick="show_ohr_iorlist()" href="#" class="list-group-item"><span class="fa fa-filter"></span>OHR</a>
                            <?php } ?>
                           <!--  <?php //if ($this->session->userdata('occ_users_1103')->role == 1) { ?>
                            <a onclick="show_master_group()" href="#" class="list-group-item"><span class="fa fa-group"></span>Master Group</a>   
                            <?php //} ?> -->
                        </div>                        
                    </div>
                </div>
                <!-- END CONTENT FRAME LEFT -->
                
                <!-- START CONTENT FRAME BODY -->
                <div class="content-frame-body">                    
                    <div id="ior_inbox" class="panel panel-default" >
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-inbox" id="pan-title-class"></span><strong id="pan-title"> IOR Received</strong></h3>
                            <div class="pull-right year_s" style="width: 150px;">
                                <select class='form-control' name='s_year' id='s_year' >
                                    <option value=""> - all year - </option>
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                    <option value="2021"> 2021 </option>
                                    <option value="2022"> 2022 </option>
                                    <option value="2023"> 2023 </option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-body mail">
                            <div class="table-responsive">
                                <table class="table tbfontssz table-hover" id="occ_open">
                                    <thead style="background-color: #0d0251; font-size: 10px;" >
                                        <tr>
                                            <th>Action</th>
                                            <th>IOR.No</th>
                                            <th>Subject</th>
                                            <th>Occ.Date</th>
                                            <th>Reported.By</th>
                                            <th>Reported.To</th>
                                            <th>Next.Unit</th>
                                            <th>Entry.Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                <div class="panel-footer">                    
                </div>                            
            </div>

            <!-- <div id="ior_master_group" class="panel panel-default" >
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-inbox" id="pan-title-class"></span><strong id="pan-title"> IOR Master Group</strong></h3>
                        </div>
                        <div class="panel-body mail">
                            <div class="table-responsive">
                                <table class="table tbfontssz table-hover" id="occ_master_group">
                                    <thead style="background-color: #0d0251; font-size: 10px;" >
                                        <tr>
                                            <th>No</th>
                                            <th>Unit</th>
                                            <th>Group Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                <div class="panel-footer">
                    
                </div>                            
            </div> -->

            <div id="data_follow" class="panel panel-default hidden" style="min-height: 100%; overflow: auto ;">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title hidden" id="dt_occ_by"></h3>
                        <h3 class="panel-title">IOR Description</h3>
                    </div>
                    <div class="pull-right">
                        <div class="high">
                            <button id="add" onclick="back()" class="btn btn-default"><span class="fa fa-backward"></span>Back</button>
                        </div>
                    </div> 
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="block">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group" style="">
                                        <span class="col-md-2 control-label">IOR.Number</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_ior_number"></p></strong>
                                        </div>
                                    
                                        <span class="col-md-2 control-label">Subject</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_occ_subject"></p></strong>
                                        </div>
                                    
                                        <span class="col-md-2 control-label">Send.To</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_occ_send_to"></p></strong>
                                        </div>
                                    
                                        <span class="col-md-2 control-label">Reff</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_occ_reff"> </p></strong>
                                        </div>
                                    
                                        <span class="col-md-2 control-label">Category</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static text-warning" id="dt_occ_category"> </p></strong>
                                        </div>
                                    
                                        <span class="col-md-2 control-label">Sub.Category</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static text-warning" id="dt_occ_subcategory"> </p></strong>
                                        </div>
                                    
                                        <span class="col-md-2 control-label" style="">Risk.Index</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_risk_index"> </p></strong>
                                        </div>
                                        <span class="col-md-2 control-label" style="">Reported.By</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_risk_reportby"></p></strong>
                                        </div>
                                        <span class="col-md-2 control-label" style="">Insert.By</span>
                                        <div class="col-md-10">
                                        <strong><p class="form-control-static" id="dt_risk_insertby"></p></strong>
                                        </div>
                                        <span class="col-md-2 control-label hidden dt-verified">Verified By</span>
                                        <div class="col-md-10 hidden dt-verified">
                                        <strong><p class="form-control-static" id="dt_verified_by"></p></strong>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <span class="col-md-2 control-label">Description</span>
                                        <div class="col-md-10" style=": break-word ; word-wrap: break-all">
                                        <strong><p class="form-control-static" id="dt_occ_description"></p></strong>
                                        </div>
                                    </div>
                                <p class="col-sm-2 control-label">Status :</p>
                                <div class="col-md-10">
                                    <strong><label class="badge" id="permission"></label></strong>
                                    <strong><label class="badge hidden" id="stats_permision"></label></strong>
                                </div>
                                <div class="col-md-12">
                                    <p class="col-sm-2 control-label" id="time_resp"></p>
                                    <div class="col-md-5">
                                        <strong><p class="form-control-static" id="dt_est_finish"></p></strong>
                                    </div>
                                    <div class="col-md-5">
                                        <strong><label class="badge" id="dt_est_finish_od"></label></strong>
                                    </div>
                                </div>
                                <p class="col-sm-2 control-label">Attachment</p>
                                <div class="col-md-10">
                                    <div class="panel-body panel-body-table">
                                        <table class="table table-striped" id="occ_file">
                                            <thead style="display: none ;" >
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                        </form>
                        <input type="hidden" id="id_verifying" class="hidden" readonly="">
                        <input type="hidden" id="id_v_file" class="hidden" readonly="">
                                </div>
                            </div>
                <div class="col-md-6" >
                  <div class="table-responsive">  
                    <div class="block hidden" id="follow_description">
                        <h4>Follow Description</h4>                               
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <p class="col-sm-2 control-label">Follow By</p>
                                <div class="col-md-10">
                                    <strong><p class="form-control-static" id="follow_by"></p></strong>
                                </div>
                                <p class="col-sm-2 control-label">Desc</p>
                                <div class="col-md-10">
                                    <strong><p class="form-control-static" id="follow_desc"></p></strong>
                                </div>
                                <p class="col-sm-2 control-label">Estimated.Finish</p>
                                <div class="col-md-10">
                                    <strong><p class="form-control-static" id="follow_estimated"></p></strong>
                                </div>
                                <p class="col-sm-2 control-label">Attachment</p>
                                <div class="col-md-10">
                                    <strong><p class="form-control-static"> :</p></strong>
                                </div>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="panel-body panel-body-table">
                                <table class="table table-bordered table-striped" id="occ_file_fo">
                                    <thead style="display: none ;" >
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                        <table class="table table-hover tbfontssz" id="occ_follow">
                            <input type="hidden" id="addfollid">
                            <input type="hidden" id="follestimated" name="follestimated"/>
                            <thead style="background-color: #0d0251; font-size: 10px;" >
                                <tr>
                                    <th>Follow.Desc</th>
                                    <th>Follow.By</th>
                                    <th>Next.Unit</th>
                                    <th>Est.Finish</th>
                                    <th>Follow.Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
                        </div>

                        <div id="create_ior" class="block panel panel-default hidden">
                            <form role="form" class="form-horizontal" id="form_new_ior" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-md-1 control-label">To:</label>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='send_to' id='send_to' required="" >
                                            <option value=""> - </option>
                                            <?php echo modules::run('dashboard/getocc_unit'); ?>
                                        </select>
                                    </div>
                                    <label class="col-md-2 control-label">Hide.Reporter</label>
                                    <div class="col-md-3">                                    
                                        <label class="check">
                                            <input type="hidden" name="hide_reporter" value="0"/>
                                            <input type="checkbox" class="icheckbox" name="hide_reporter" value="1"/>
                                        </label>
                                    </div>    
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Subject:</label>
                                    <div class="col-md-5">                                        
                                        <input type="text" class="form-control" name="subject" id="subject" required="" />
                                    </div>
                                    <label class="col-md-1 control-label">Reference:</label>
                                    <div class="col-md-5">                                        
                                        <input type="text" class="form-control" name="occ_reference" id="occ_reference"/>
                                    </div>                   
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Category:</label>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='category' id='category' required="" >
                                            <option value=""> - </option>
                                            <?php echo modules::run('dashboard/getocc_cat'); ?>
                                        </select>
                                    </div>
                                    <label class="col-md-1 control-label">Sub.Category:</label>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='sub_category' id='sub_category' required="">
                                            <option>- Set Category First -</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='sub_category_stats' id='sub_category_stats' required="">
                                            <option>- Set Subcat First-</option>
                                        </select>
                                    </div>                                 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Ambiguity:</label>
                                    <div class="col-md-2">                                        
                                        <select class='form-control select' name='ambiguity' id='ambiguity' required="">
                                           <option value="0">No</option>
                                           <option value="1">Yes</option>
                                       </select>
                                   </div>
                                   <label class="col-md-1 control-label">Occ.Date:</label>
                                   <div class="col-md-3">                                        
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="text" class="form-control" name="occ_date" id="occ_date" data-date-end-date="0d" required="" />
                                    </div>
                                </div>
                                <label class="col-md-2 control-label">Estimated.Finish</label>
                                <div class="col-md-2">   
                                    <?php  $beginday= date("Y-m-d");
                                    $lastday = date('Y-m-d', strtotime($beginday. ' + 9 weekdays')); ?>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="text" class="form-control" name="occ_est_finish" id="occ_est_finish" required="" readonly="" value="<?=$lastday?>" />
                                    </div>
                                </div>                                  
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Attachments:</label>
                                <div class="col-md-1">                                        
                                    <button id="file_m" type="button" class="btn btn-primary">Browse</button>
                                </div>
                                <div class="col-md-8">                                        
                                    <div id="filegetname">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Level.Type:</label>
                                <div class="col-md-2">                                        
                                    <select class='form-control select' name='level_type' id='level_type' required="required">
                                        <option value="-" selected="selected"> - </option>
                                        <option value="Aircraft"> Aircraft </option>
                                        <option value="APU"> APU </option>
                                        <option value="Component"> Component </option>
                                        <option value="Engine"> Engine </option>
                                        <option value="Others"> Others </option>
                                    </select>
                                </div>
                                <div class="col-md-3" id="foracty">                                        
                                    
                                </div>
                                <div class="col-md-3" id="subforacty">
                                    
                                </div>                                 
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Risk.Index:</label>
                                <div class="col-md-2">
                                    <input type="text" class="btn-5a form-control" name="occ_risk_idx" id="occ_risk_idx" placeholder="Click Here" required="required" />
                                </div>
                                <div class="col-md-9">
                                    <table border="1" class="table table-bordered hidden" id="occ_risk_table">
                                        <tr>
                                            <td id="occ_risk_detail1"></td>
                                            <td id="occ_risk_detail2"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php if ($this->session->userdata('occ_users_1103')->role == 1 ) { ?>
                            <div class="form-group">
                                    <label class="col-md-1 control-label">Reported.By</label>
                                    <div class="col-md-2">                                        
                                        <input type="text" class="form-control" name="reported_by" id="reported_by"/>
                                    </div>
                                    <div class="col-md-3">                                        
                                        <input type="text" class="form-control" name="reported_by_name" id="reported_by_name" readonly=""/>
                                    </div>
                                    <div class="col-md-2">                                        
                                        <input type="text" class="form-control" name="reported_by_unit" id="reported_by_unit" readonly=""/>
                                    </div>

                            </div>

                            <?php } ?>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Descriptions:</label>
                                <div class="col-md-12">                            
                                   <textarea class="form-control" rows="5" name="occ_detail" id="occ_detail" maxlength="1400" placeholder="Max character is 1400" required=""></textarea>                         
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <button class="btn btn-warning" type="submit" id="save_new"><span class="fa fa-envelope"></span> Send</button>
                                        <input class="hidden" type="hidden" name="file_name[]" value="-" />
                                    </div>                                    
                                </div>
                            </div>
                            </form>
                        </div>
                    
                </div>
                <!-- END CONTENT FRAME BODY -->
            </div>
            <!-- END CONTENT FRAME -->     
<!-- START FILE HANDLER-->
            <div class="modal animated zoomIn" id="file_handler" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                       <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3><span class="fa fa-download"></span> Click Or Drop your attachmentsss</h3>
                                <form action="" class="dropzone" id="hallodz">

                                </form>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary pull-right" onclick="check()">Submit</button>
                                <button class="btn pull-right" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
<!-- FILE HANDLER -->

<!-- START ADD FOLLOW IOR FORM -->
    <div class="modal animated zoomIn" id="modal_add_follow" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="col-md-12">
               <div class="modal-content">
                <form class="form-horizontal form-modalnya" id="form_add_follow" action="#" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add Follow On to IOR No. <strong><span id="addsub"> </span></strong></h3>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        </div>
                        <div class="panel-body">                                                                        
                            <div class="row"> 
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Follow By</label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <input type="text" class="form-control" disabled="" value="<?=$this->session->userdata('occ_users_1103')->username; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Next.Unit</label>
                                        <div class="col-md-6">                                                           
                                            <select class='form-control' name='addfoll_send_to' id='addfoll_send_to' required="">
                                                <option value="-"> - </option>
                                                <?php echo modules::run('dashboard/getocc_unit'); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Attachment</label>
                                        <div class="col-md-3">   
                                            <button id="file_mfo" type="button" class="btn btn-primary">Browse</button>
                                        </div>
                                        <div class="col-md-6" id="filegetnamefo">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9 col-xs-12">                                                  
                                            <textarea class="form-control" rows="2" id="addfolldesc" name="addfolldesc" required=""></textarea>
                                            <span class="help-block">Describe your occurrence here </span>
                                        </div>
                                    </div>
                                            </div>
                                        </div>
                                        <br>
                                        <input type="hidden" class="hidden" name="file_name_fo[]" value="-" readonly=""/>
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary" type="submit" id="addfollbutton">Send</button>
                                        <button class="btn btn-default" data-dismiss="modal">Back</button>
                                    </div>
                                    <input type="hidden" id="addfollto" name="addfollto"/>
                                    <input type="hidden" id="ffollestimated" name="ffollestimated"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>        
<!-- END  ADD FOLLOW IOR FORM -->

<!-- START FILE HANDLER FOlLOW ON-->
                <div class="modal animated zoomIn" id="file_handler_pro" role="dialog" aria-hidden="true" style="z-index: 10023000 ;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-download"></span> Click Or Drop your attachment</h3>
                                    <form action="<?=site_url('fileupload/cobaupload')?>" class="dropzone" id="hallodzpro">
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary pull-right" onclick="check_file_pro()">Submit</button>
                                </div>
                             </div>
                            </div>
                        </div>
                    </div>
                </div>        
<!-- FILE HANDLER FOlLOW ON -->

<!-- START FILE HANDLER FOlLOW ON-->
                <div class="modal animated zoomIn" id="file_handler_fo" role="dialog" aria-hidden="true" style="z-index: 10023000 ;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3><span class="fa fa-download"></span> Click Or Drop your attachment</h3>
                                    <form action="<?=site_url('fileupload/cobaupload')?>" class="dropzone" id="hallodzfoll">

                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary pull-right" onclick="check_file_fo()">Submit</button>
                                </div>
                             </div>
                            </div>
                        </div>
                    </div>
                </div>        
<!-- FILE HANDLER FOlLOW ON -->
<!-- START RISK INDEX HANDLER-->
            <div class="modal animated zoomIn" id="risk_index_select" role="dialog" aria-hidden="true" style="z-index: 9999999999999999999;">
                <div class="modal-dialog modal-lg" style="width: 100%;">
                    <div class="modal-content">
                       <div class="col-md-12">
                            <div class="panel panel-default">
                                <form id="form_risk_index" >
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="panel-title-box">
                                                    <h3>Probability of occurrence</h3>
                                                </div>
                                                <table class="table table-bordered table-striped table-hover" id="list_probability" style="font-size: 11px;">
                                                    <thead style="background-color: #0d0251;">
                                                    <tr>
                                                        <th>Qualitative</th>
                                                        <th>Meaning</th>
                                                        <th>Value</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        <div class="col-md-8">
                                            <div class="panel-title-box">
                                                <h3>Severity of occurrence</h3>
                                            </div>
                                            <table class="table table-bordered table-striped table-hover" id="list_severity">
                                                <thead style="background-color: #0d0251;">
                                                <tr>
                                                    <th>Aviation</th>
                                                    <th>People</th>
                                                    <th>Environment</th>
                                                    <th>Security</th>
                                                    <th>Asset/Opr.</th>
                                                    <th>Compliance</th>
                                                    <th>IT System</th>
                                                    
                                                    <th></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
<!-- RISK HANDLER -->

<!-- START VIEW FILEHANDLER -->
    <div class="modal animated zoomIn" id="preview_file" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
             <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <span class="file-input">
                                <div class="file-preview">
                                    <div class="close fileinput-remove text-right" data-dismiss="modal">×</div>
                                    <div class="file-preview-thumbnails" align="center">
                                        <div class="file-preview-frame" id="preview-1503901337532-0" style="width:400px;height:300px;">
                                          <object id="obj_file" width="400px" height="300px" margin="5%">
                                            <param name="movie" value="d4nss ssa  12 as.pdf">
                                              <param name="controller" value="true">
                                              <param name="allowFullScreen" value="true">
                                              <param name="allowScriptAccess" value="always">
                                              <param name="autoPlay" value="false">
                                              <param name="autoStart" value="false">
                                              <param name="quality" value="high">
                                            <div class="file-preview-other" style="width:400px;height:300px;">
                                               <h2><i class="glyphicon glyphicon-file"></i></h2>
                                           </div>
                                       </object>
                                       <div class="text-center"><small id="obj_file_n"></small></div>
                                   </div>
                               </div>
                               <div class="clearfix"></div>
                               <div class="file-preview-status text-center text-success"></div>
                           </div>
                       </span>
                   </div>
               </div>
               <div class="panel-footer">
                <!-- <a href="" target="_blank" class="btn btn-primary pull-right" id="obj_file_nd" download="">Download</a> -->
                <a style="background-color: black ; " href="" target="_blank" class="btn btn-primary pull-right" id="obj_file_op">Download</a>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>        
<!-- START VIEW FILEHANDLER -->

<!-- START VIEW FILEHANDLER -->
    <div class="modal animated zoomIn" id="overview" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
             <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div align="center">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" id="guidance_panel"  style="width:800px; height:500px;" frameborder="0" allowfullscreen >
                                        
                                    </iframe>
                                  </div>
                            </div>
                        </div>
               </div>
                <div class="panel-footer">
                </div>
        </div>
    </div>
    </div>
    </div>
    </div>        
<!-- START VIEW FILEHANDLER -->

<?php if ($this->session->userdata('occ_users_1103')->role == 1 ) { ?>
<!-- START VIEW EDIT -->
    <div class="modal animated zoomIn" id="edit_ior" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
             <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                                <h3 class="panel-title">Edit IOR</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form role="form" class="form-horizontal" id="form_edit_ior" action="#" method="post">
                                <div class="form-group">
                                    <label class="col-md-1 control-label">To:</label>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='e_send_to' id='e_send_to' required="" >
                                            <option id="ge_send_to" value=""> - </option>
                                            <?php echo modules::run('dashboard/getocc_unit'); ?>
                                        </select>
                                    </div>    
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Subject:</label>
                                    <div class="col-md-5">                                        
                                        <input type="text" class="form-control" name="e_subject" id="e_subject" required="" />
                                    </div>
                                    <label class="col-md-1 control-label">Reference:</label>
                                    <div class="col-md-5">                                        
                                        <input type="text" class="form-control" name="e_occ_reference" id="e_occ_reference"/>
                                    </div>                   
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Category:</label>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='e_category' id='e_category' required="">
                                            <option id="ge_category" value=""> - </option>
                                            <?php echo modules::run('dashboard/getocc_cat'); ?>
                                        </select>
                                    </div>
                                    <label class="col-md-2 control-label">Sub.Category:</label>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='e_sub_category' id='e_sub_category' required="" >
                                            <option value=""> - </option>
                                            <?php echo modules::run('dashboard/getocc_subcats'); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">                                        
                                        <select class='form-control' name='e_sub_category_stats' id='e_sub_category_stats' required="">
                                            <option id="ge_sub_category_stats"> - </option>
                                        </select>
                                    </div>                                 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Ambiguity:</label>
                                    <div class="col-md-2">                                        
                                        <select class='form-control select' name='e_ambiguity' id='ambiguity' required="">
                                         <option value="0">No</option>
                                         <option value="1">Yes</option>
                                     </select>
                                 </div>
                                 <label class="col-md-1 control-label">Occ.Date:</label>
                                 <div class="col-md-3">                                        
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="text" class="form-control" name="e_occ_date" id="e_occ_date" data-date-end-date="0d" required="" />
                                    </div>
                                </div>                                 
                                </div>
                                <div class="form-group">
                                <label class="col-md-1 control-label">Risk.Index:</label>
                                <div class="col-md-3">
									 <input type="text" class="btn-5a form-control" name="e_occ_risk_idx" id="e_occ_risk_idx" placeholder="Click Here" required="required" />
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Descriptions:</label>
                                    <div class="col-md-12">                            
                                     <textarea class="form-control" rows="5" name="e_occ_detail" id="e_occ_detail" maxlength="1400" placeholder="Max character is 1400" required=""></textarea>                         
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary pull-right" id="u_ior" >Update</button>
                                            <a href="#" class="btn btn-default pull-right" data-dismiss="modal" >Cancel</a>
                                        </div>                                    
                                    </div>
                                </div>
                            </form>
                        </div>
                   </div>
               </div>
            </div>
        </div>
        </div>
    </div>        
<!-- START VIEW EDIT -->
<?php } ?>
</div>            
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<?php $this->load->view('ext/scripts'); ?>  
<?php $this->load->view('ext/landing_page_ext'); ?>  

<script type="text/javascript">
$(document).ready(function() {
    $('.year_s').hide();
            Dropzone.autoDiscover = false;
            var fileList = new Array;
            var i =0;
            $("#hallodz").dropzone({
                addRemoveLinks: true,
                init: function() {

                    this.on("success", function(file, serverFileName) {
                        fileList[i] = {"serverFileName" : serverFileName,"fileName" : file.name,"fileId" : i };
                        //console.log(fileList);
                        var a = fileList[i].serverFileName;
                        var a = a.replace(/\s/g,'');
                        var fn =a.substring(0, 30);
                        var recep = '<input type="hidden" id="f1'+(i)+'" class="nm_file" name="file_name[]" value="'+a+'"><i class="fileclear" id="lb'+(i)+'">'+fn+'... <a id="bb'+(counter)+'" href="#" onclick="remove('+(i)+')" >remove</a><br></i>';
                        $('#filegetname').append(recep);
                        i++;

                    });
                },
                url: "<?=site_url('fileupload/attach_ftp')?>"
            });

        });

$(document).ready(function() {
            Dropzone.autoDiscover = false;
            var fileList = new Array;
            var i =0;
            $("#hallodzpro").dropzone({
                addRemoveLinks: true,
                init: function() {

                    this.on("success", function(file, serverFileName) {
                        fileList[i] = {"serverFileName" : serverFileName,"fileName" : file.name,"fileId" : i };
                        i++;

                    });
                },
                url: "<?=site_url('fileupload/cobaupload')?>"
            });

        });
$(document).ready(function() {
            Dropzone.autoDiscover = false;
            var fileList = new Array;
            var i =0;
            $("#hallodzfoll").dropzone({
                addRemoveLinks: true,
                init: function() {

                    this.on("success", function(file, serverFileName) {
                        fileList[i] = {"serverFileName" : serverFileName,"fileName" : file.name,"fileId" : i };
                        i++;

                    });
                },
                url: "<?=site_url('fileupload/cobaupload')?>"
            });

    // // Setup - add a text input to each footer cell
    // $('#occ_open tfoot th').each( function () {
    //     // var title = $(this).text();
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
    // // DataTable
    // var table = $('#occ_open').DataTable();
    // // Apply the search
    // table.columns().every( function () {
    //     var that = this;
 
    //     $( 'input', this.footer() ).on( 'keyup change', function () {
    //         if ( that.search() !== this.value ) {
    //             that
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

    $('#s_year').select2({
                        width : '100%'
    });

    });
 $("#reported_by").keyup(function() { 
    var nopeg = $("#reported_by").val();
    if (nopeg.length > 5 || nopeg.length == 6){
        $.ajax({
            url : '<?php echo site_url('occurrence/getkaryawan/')?>/' + nopeg,
            dataType: "JSON",
            beforeSend: function() {
            },
            success: function(data) {
              for(var i = 0; i < data.length; i++){
                    $('#reported_by_name').val(data[i].EMPLNAME);
                    $('#reported_by_unit').val(data[i].UNIT);
              }
            },
            error: function (jqXHR, textStatus, errorThrown){
                
            }
        });  
     }
    });
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
function risktutor(id){
    $('#guidance_panel').attr("src","../assets/img/help/Risk_index_tutor.mp4"); 
    $('#overview').modal('show');
}

$("#overview").on('hidden.bs.modal', function (e) {
    $('#guidance_panel').attr("src",""); 
});
</script>

</body>
</html>