<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('ext/head'); 
$today = date("Y-m-d"); 
?>
<body style="font-size: 11px;">
    <!-- START PAGE CONTAINER -->
    <div class="page-container page-navigation-toggled">
        <?php $this->load->view('ext/menu');?>
        <!-- PAGE CONTENT -->
        <div class="page-content">
<?php $this->load->view('ext/navigations'); ?>            
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Biweekly Report</h2>
                </div>
                <!-- END PAGE TITLE -->  
                <!-- PAGE CONTENT WRAPPER -->
                <div class="content-frame">
                    <div class="col-md-6">
                        <!-- START PANEL WITH CONTROL CLASSES -->
                        <form class="form-horizontal" action="<?=site_url()?>/report/download_biweekly" method="post" target="_blank">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Select Date Range</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group">                                        
                                            <label class="col-md-4 control-label">Date Start</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input name="start" id="start" data-date-end-date="0d" type="text" class="form-control datepicker" value="<?=$today?>">
                                                </div>
                                                <span class="help-block">Click on input field to get datepicker</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">                                        
                                            <label class="col-md-4 control-label">Date Until</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input name="end" id="end" type="text" class="form-control datepicker" data-date-end-date="0d" value="<?=$today?>">
                                                </div>
                                                <span class="help-block">Click on input field to get datepicker</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                                <div class="panel-footer">                                
                                    <button class="btn btn-primary pull-right">Generate Excel</button>
                                </div>
                            </div>
                        </form>
                        <!-- END PANEL WITH CONTROL CLASSES -->
                    </div>                
                </div>
                <!-- PAGE CONTENT WRAPPER --> 
    

        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
<?php $this->load->view('ext/scripts'); ?>  
    <script type="text/javascript">
        $('#end,#start').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
        });
    </script>


</body>
</html>