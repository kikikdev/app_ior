<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('ext/head'); 
$today = date("Y-m-d");  ?>
    <body style="font-size: 11px;">
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-toggled">
            <?php $this->load->view('ext/menu');?>
            <!-- PAGE CONTENT -->
            <div class="page-content">
    <?php $this->load->view('ext/navigations'); ?>            
                    <!-- PAGE TITLE -->
                    <div class="page-title">                    
                        <h2><span class="fa fa-arrow-circle-o-left"></span> Search Report</h2>
                    </div>
                    <!-- END PAGE TITLE -->  
                    <!-- PAGE CONTENT WRAPPER -->
                    <div class="content-frame">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- START PANEL WITH CONTROL CLASSES -->
                                <form class="form-horizontal" action="#" method="post">
                                    <div class="panel panel-warning">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="col-md-3">
                                                        <div class="form-group">                                        
                                                            <label class="col-md-3 control-label">Status</label>
                                                            <div class="col-md-9">
                                                                <select class='form-control' name='s_occ_status' id='s_occ_status' >
                                                                    <option value=""> - </option>
                                                                    <option value="11"> OPEN </option>
                                                                    <option value="12"> PROGRES </option>
                                                                    <option value="13"> WAITING CLOSE </option>
                                                                    <option value="99"> OVERDUE </option>
                                                                    <option value="00"> NCR </option>
                                                                    <option value="33"> CLOSE </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">                                        
                                                            <label class="col-md-3 control-label">Occ.Number</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                    <input name="s_occ_numb" type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">                                        
                                                            <label class="col-md-3 control-label">Occ.Subject</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                    <input name="s_occ_sub" type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">                                        
                                                            <label class="col-md-3 control-label">Occ.Category</label>
                                                            <div class="col-md-9">
                                                                    <select class='form-control select' name='s_occ_cat' id='s_occ_cat'>
                                                                        <option value=""> - </option>
                                                                        <?php echo modules::run('dashboard/getocc_cat'); ?>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">                                        
                                                            <label class="col-md-3 control-label">To.Unit</label>
                                                            <div class="col-md-9">
                                                                <select class='form-control' name='s_occ_to' id='s_occ_to'>
                                                                    <option value=""> - </option>
                                                                    <?php echo modules::run('dashboard/getocc_unit'); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div  class="form-group">
                                                            <label class="col-md-3 control-label">By.Unit</label>
                                                            <div class="col-md-9">
                                                                <select class='form-control' name='s_occ_by_unit' id='s_occ_by_unit' >
                                                                    <option value=""> - </option>
                                                                    <?php echo modules::run('dashboard/getocc_unit'); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">                                        
                                                            <label class="col-md-3 control-label">Risk.Index</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                    <input name="s_occ_risk" type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">                                        
                                                            <label class="col-md-2 control-label">Occ.Date</label>
                                                            <div class="col-md-5">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span>S</span></span>
                                                                    <input class="form-control" name="o_date_s" id="o_date_s" data-date-end-date="0d" required="" type="text" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span>U</span></span>
                                                                    <input class="form-control" name="o_date_u" id="o_date_u" data-date-end-date="0d" required="" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">                                        
                                                            <label class="col-md-2 control-label">Ins.Date</label>
                                                            <div class="col-md-5">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span>S</span></span>
                                                                    <input class="form-control" name="i_date_s" id="o_date_s" data-date-end-date="0d" required="" type="text" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><span>U</span></span>
                                                                    <input class="form-control" name="i_date_u" id="o_date_u" data-date-end-date="0d" required="" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Keyword</label>
                                                            <div class="col-md-9">                            
                                                               <textarea class="form-control" rows="4" name="s_occ_by_keyword" id="s_occ_by_keyword" maxlength="250"></textarea>                         
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>      
                                        <div class="panel-footer">                                
                                            <a class="btn btn-primary pull-right search">Search</a>
                                        </div>
                                    </div>
                                </form>
                                <!-- END PANEL WITH CONTROL CLASSES -->
                            </div>
                        </div>
                        <div class="row" style="max-height: 300px; max-width: 100%; overflow : scroll;">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="btn-group pull-right">
                                                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" onClick ="$('#search_result').tableExport({type:'csv',escape:'false'});"><img src='<?=base_url();?>assets/img/icons/csv.png' width="24"/> CSV</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onClick ="$('#search_result').tableExport({type:'excel',escape:'false'});"><img src='<?=base_url();?>assets/img/icons/xls.png' width="24"/> XLS</a></li>
                                                </ul>
                                        </div>
                                    </div>   
                                    <div class="panel-body panel-body-table">
                                        <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-actions related-m" id="search_result" style="font-size: 9px;">
                                            <thead style="background-color: #0d0251; font-size: 10px;"> 
                                                <tr bgcolor="">
                                                    <th align ="center" width="70">Act</th>
                                                    <th align ="center" width="100">IOR No.</th>
                                                    <th align ="center" width="100">Category</th>
                                                    <th align ="center" width="120">Sub.Category</th>
                                                    <th align ="center" width="200">Subject</th>
                                                    <th align ="center" width="200">Risk.Index</th>
                                                    <th align ="center" width="100">Occ.Date</th>
                                                    <th align ="center" width="200">Detail.Occurrence</th>
                                                    <th align ="center" width="100">Send.To</th>
                                                    <th align ="center" width="100">Insert.Date</th>
                                                    <th align ="center" width="100">Report.By</th>
                                                    <th align ="center" width="100">Insert.By</th>
                                                    <th align ="center" width="100">Status</th>
                                                    <th align ="center" width="100">Follow.On</th>
                                                    <th align ="center" width="100">Date</th>
                                                    <th align ="center" width="100">Follow Desc</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PAGE CONTENT WRAPPER --> 
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
    <?php $this->load->view('ext/scripts'); ?>  
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/tableExport.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jquery.base64.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/html2canvas.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tableexport/jspdf/libs/base64.js"></script>
<script type="text/javascript">
 $('#s_occ_to,#s_occ_by_unit,#s_occ_cat,#s_occ_status').select2({
            width : '100%'
            },{ allowClear: true }
        );
$('[name="o_date_s"],[name="o_date_u"],[name="i_date_s"],[name="i_date_u"]').datepicker({
    todayHighlight : true,
    autoclose: true,
    format : 'yyyy-mm-dd',
});
$('.search').on('click', function(){
    var s_numb = $('[name="s_occ_numb"]').val();
    var s_occ_sub = $('[name="s_occ_sub"]').val();
    var s_occ_cat = $('[name="s_occ_cat"]').val();
    var o_date_s = $('[name="o_date_s"]').val();
    var o_date_u = $('[name="o_date_u"]').val();
    var i_date_s = $('[name="i_date_s"]').val();
    var i_date_u = $('[name="i_date_u"]').val();
    var s_occ_to = $('[name="s_occ_to"]').val();
    var s_occ_by_unit = $('[name="s_occ_by_unit"]').val();
    var s_occ_status = $('[name="s_occ_status"]').val();
    var s_occ_risk = $('[name="s_occ_risk"]').val();
    var s_keyword  = $('[name="s_occ_by_keyword"]').val();
    $('.related-m').DataTable({
        "columnDefs": [{"targets": 13 ,
                                    "width": 160},
                        {"targets": 12 ,
                                    "width": 160},
                        {"targets": 4 ,
                                    "width": 5},
                        {"targets": 6 ,
                                    "width": 5}],
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "bJQueryUI": true,
        "bLengthChange": false,
        "ordering": false,
        "deferRender": true,
        "searching"    : false,
        "paging"    : false,
        "info"      :false,
            "ajax": {
            'type': 'POST',
            'url': '<?php echo site_url('report/search'); ?>',
            'data': {
               s_numb : s_numb,
               s_occ_sub : s_occ_sub,
               s_occ_cat : s_occ_cat,
               o_date_s : o_date_s,
               o_date_u : o_date_u,
               i_date_s : i_date_s,
               i_date_u : i_date_u,
               s_occ_to : s_occ_to,
               s_occ_by_unit : s_occ_by_unit,
               s_occ_status : s_occ_status,
               s_occ_risk : s_occ_risk,
               s_keyword : s_keyword ,
            },
            }                         
    });
});
function tutorial(id){
    $('#guidance_panel').attr("src","../../assets/img/help/overview.pdf"); 
    $('#overview').modal('show');
}
function overview(id){
    $('#guidance_panel').attr("src","../../assets/img/help/New_IOR_Database.mp4"); 
    $('#overview').modal('show');
}
function flowprocess(id){
    $('#guidance_panel').attr("src","../../assets/img/help/IOR_Flow_Process.mp4"); 
    $('#overview').modal('show');
}
function risktutor(id){
    $('#guidance_panel').attr("src","../assets/img/help/Risk_index_tutor.mp4"); 
    $('#overview').modal('show');
}
        </script>
    </body>
</html>