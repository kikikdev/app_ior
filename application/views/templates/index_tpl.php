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
                    <li><a href="#">Performance Statistic</a></li>
                </ul>
                <!-- END BREADCRUMB -->                
                
<?php $date = date("Y-m-d h:i:s") ;?> 
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                        

                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="col-md-3">
                            <!-- START WIDGET SLIDER -->
                            <div class="widget widget-default widget-carousel">
                                <div class="owl-carousel" id="owl-example">
                                    <div>                                    
                                        <div class="widget-title">Total IOR</div>                                                                        
                                        <div class="widget-subtitle"><?=$date?></div>
                                        <div class="widget-int" id="total_received"></div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Open</div>
                                        <div class="widget-subtitle"></div>
                                        <div class="widget-int" id="total_open"></div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Progress</div>
                                        <div class="widget-subtitle"></div>
                                        <div class="widget-int" id="total_progress"></div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Closed</div>
                                        <div class="widget-subtitle"></div>
                                        <div class="widget-int" id="total_closed"></div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Transfer NCR</div>
                                        <div class="widget-subtitle"></div>
                                        <div class="widget-int" id="total_transfer"></div>
                                    </div>
                                </div>                            
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                             
                            </div>         
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                        <div class="col-md-3">
                        
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='<?=site_url('dashboard');?>';" style="cursor: pointer; cursor: hand;">
                                <div class="widget-item-left">
                                    <span class="fa fa-file-text"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="total_create"></div>
                                    <div class="widget-title">IOR</div>
                                    <div class="widget-subtitle">Have you created</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                        </a>
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon" onclick="alert('Be patient!');">
                                <div class="widget-item-left">
                                    <span class="fa fa-exclamation-circle"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="total_need_verified"></div>
                                    <div class="widget-title">Waiting Verification</div>
                                    <div class="widget-subtitle">IOR</div>
                                </div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-info widget-padding-sm">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                                <div class="widget-buttons widget-c3">
                                    <div class="col">
                                        <a href="#"><span class="fa fa-clock-o"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-calendar"></span></a>
                                    </div>
                                </div>                            
                            </div>                        
                            <!-- END WIDGET CLOCK -->
                            
                        </div>
                    </div>
                    <!-- END WIDGETS -->   
                
                    <!-- START CHART -->                    
                    <div class="row">
                        <div class="col-md-6">
                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="container2"></div>
                        </div>
                    </div>
                    <!-- END CHART -->  


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
        </div>
        <!-- END PAGE CONTAINER -->
    <?php $this->load->view('ext/scripts'); ?>

<script type="text/javascript">
$().ready(function() {
    v_summary();
});

function v_summary(){
            $.ajax({
                url : "<?php echo site_url('summary/get_summary/')?>/",
                dataType: "JSON",
                beforeSend: function() {
                },
                success: function(data) {
                  for(var i = 0; i < data.length; i++){
                        $('#total_received').text(data[i].ior_received);
                        $('#total_open').text(data[i].ior_open);
                        $('#total_progress').text(data[i].ior_progress);
                        $('#total_closed').text(data[i].ior_closed);
                        $('#total_transfer').text(data[i].ior_transfer_ncr);
                        $('#total_need_verified').text(data[i].w_verif);
                        $('#total_create').text(data[i].h_verif);
                  }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
    }

$.ajax({
            url :  '<?php echo site_url('summary/get_summary_monthly')?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data)
            {
                            Highcharts.chart('container', {
                                        chart: {
                                            type: 'line'
                                        },
                                        title: {
                                            text: 'Monthly average IOR in your unit'
                                        },
                                        subtitle: {
                                            text: 'Source: IOR Data'
                                        },
                                        xAxis: {
                                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                        },
                                        yAxis: {
                                            allowDecimals: false,
                                            title: {
                                                text: 'Total'
                                            }
                                        },
                                        credits: {
                                            enabled : false
                                        },
                                        plotOptions: {
                                            line: {
                                                dataLabels: {
                                                    enabled: true
                                                },
                                                enableMouseTracking: false
                                            }
                                        },
                                        series: [{
                                            name: '<?php echo $this->session->userdata('occ_users_1103')->unit; ?>',
                                            data: data
                                        }]
                                    });   
            }
});
$.ajax({
            url :  '<?php echo site_url('summary/get_summary_monthly_status')?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data)
            {
                           Highcharts.chart('container2', {
                    chart: {
                            type: 'column',
                            spacingBottom: 5,
                            spacingTop: 10,
                            spacingLeft: 10,
                            spacingRight: 10,

                            // Explicitly tell the width and height of a chart
                            width: null,
                            height: null
                    },
                    title: {
                        text: 'Monthly average IOR in your unit by status'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                                            allowDecimals: false,
                                            title: {
                                                text: 'Total'
                                            }
                            },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>'
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                 format: '{point.y}'
                            },
                             cursor: 'pointer'
                            
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series:[{
                            showInLegend: false,
                            type: 'column',
                            colorByPoint: true,
                            name: 'Total',                            
                            data : data 
                            }]
                }); 
            }
});
function showiorNEW(){
    showopened_in();
     $('#modal_view_ior_NEW').modal('show');
        $('#opened_in tbody').on('click', 'tr', function () {
            var data = t.row( this ).data();
            alert( 'You clicked on '+data[0]+'\'s row' );
    } );
}

function showopened_in(){
        url = "get_occ_for_self" ;
        t = $('#opened_in').DataTable({
                    "ajax": "<?php echo site_url('summary/');?>/"+ url,
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
                    // "bLengthChange": false,
                    "order": [[ 1, 'asc' ]] 

        });
}
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
    $('#guidance_panel').attr("src","../../assets/img/help/Risk_index_tutor.mp4"); 
    $('#overview').modal('show');
}
$("#overview").on('hidden.bs.modal', function (e) {
    $('#guidance_panel').attr("src",""); 
});
</script>
    </body>
</html>