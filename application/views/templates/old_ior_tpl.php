<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('ext/head'); ?>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-toggled">
    <?php $this->load->view('ext/menu');?>

            <!-- PAGE CONTENT -->
            <div class="page-content">            
    <?php $this->load->view('ext/navigations'); ?>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Old Occurence data</a></li>
                </ul>
                <!-- END BREADCRUMB -->                

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <?php foreach($perunit->result() as $row) { ?>
                            <div class="col-md-2">
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon target-unit" id="<?=$row->occ_send_to;?>" style="cursor: pointer; cursor: hand;">
                                <div class="widget-item-left">
                                    <span class="fa fa-bar-chart-o"></span>
                                </div>                          
                                    <div class="widget-data">
                                        <div class="widget-int num-count" style="color: orange ; font-size: 12px;" >
                                            <?php if ($row->occ_send_to == '-') {
                                                echo 'UNKNOWN' ; } else { ?>
                                            <?=$row->occ_send_to;?> <?php } ?></div>
                                        <div class="widget-title" style="font-size: 16px ;"><?=$row->total_received;?></div>
                                        <div class="widget-subtitle">Occurence</div>
                                    </div>      
                                    <div class="widget-controls">                                
                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                    </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            </div>
                        <?php } ?>
                    </div>
                    <!-- END WIDGETS -->   

                </div>
                <!-- END PAGE CONTENT WRAPPER -->     

                
            </div>            
            <!-- END PAGE CONTENT -->
<!-- START VIEW FILEHANDLER -->
    <div class="modal animated zoomIn" id="overview" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div align="center">
                                    <iframe id="guidance_panel"  style="width:800px; height:500px;" frameborder="0" allowfullscreen >
                                        
                                    </iframe>
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

<!-- START DETAIL OLD HANDLER-->
            <div class="modal animated zoomIn" id="detail_occ_old" role="dialog" aria-hidden="true" style="z-index: 9999999999999999999;">
                <div class="modal-dialog modal-lg" style=" overflow-y: initial !important">
                    <div class="modal-content" style="max-height: 550px; overflow-y: auto;">
                       <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="col-md-12">
                            <div class="panel-body" style="overflow:  hidden ;">
                                <div class="table-responsive">
                                    <table class="table tbfontssz table-hover" id="list_old_occ">
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
                                <div class="panel-footer">
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
<!-- RISK HANDLER -->
        </div>
        <!-- END PAGE CONTAINER -->
    <?php $this->load->view('ext/scripts'); ?>

<script type="text/javascript">
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
$("#overview").on('hidden.bs.modal', function (e) {
    $('#guidance_panel').attr("src",""); 
    //$('#guidance_panel').attr("src",""); 
});


$('#file_m').on('click', function(){
    
});

$( ".target-unit" ).each(function(index) {
    $(this).on("click", function(){
    id = $(this).attr('id') ;
    idr =  id.replace(/\s/g, '')
         $('#detail_occ_old').modal('show');
            $('#list_old_occ').DataTable({
                    "ajax": "./../oldoccurrence/get_old_list/"+ idr,
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
    });
});

</script>
    </body>
</html>