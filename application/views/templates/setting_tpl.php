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
                    <li><a href="#">Setting</a></li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading ui-draggable-handle">                                    
                                                <div class="panel-title-box">
                                                <h5><strong>Manage Category Data</strong></h5>
                                                    <button id="add" onclick="o_m_category()" class="btn btn-default"><span class="fa fa-plus"></span>Add Cagtory</button>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                   <table class="table tbfontssz table-hover table-bordered tbfontsz" id="setcategory">
                                                      <thead style="background-color: #0d0251;">
                                                            <tr>
                                                              <th>No</th>
                                                              <th>Category Name</th>
                                                              <th></th>
                                                            </tr>
                                                      </thead>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading ui-draggable-handle">                                    
                                                <div class="panel-title-box">
                                                <h5><strong>Manage Sub Category Data</strong></h5>
                                                    <button id="add" onclick="o_m_category()" class="btn btn-default"><span class="fa fa-plus"></span>Add Sub.Category</button>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                   <table class="table tbfontssz table-hover table-bordered tbfontsz" id="setsubcategory">
                                                      <thead style="background-color: #0d0251;">
                                                            <tr>
                                                              <th>No</th>
                                                              <th>Sub Category Name</th>
                                                              <th>On</th>
                                                              <th></th>
                                                            </tr>
                                                      </thead>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                </div>
                <!-- END PAGE CONTENT WRAPPER -->     
<!-- MODAL MANAGE CATOGORY -->
<div class="modal fade" id="modal_m_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form class="form-horizontal" id="f_m_category" action="#" method="post">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Manage Category Data</h4>
              </div>
              <div class="modal-body">
                <div class="box box-info">
                  <div class="box-body">
                        <div class="form-group">                                        
                            <label class="col-md-3 control-label">Category Name</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input name="cat_name" type="text" class="form-control" required="">
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL MANAGE CATOGORY -->
   
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
    <?php $this->load->view('ext/scripts'); ?>  
    <?php // $this->load->view('ext/landing_page_ext'); ?>  

<script type="text/javascript">
    $('#occ_date').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
    });
    tbl_category = $('#setcategory').DataTable({
        "ajax": "<?php echo site_url('setting/getcat');?>",
        "processing": true,
        "columnDefs": [{"targets": 0,
        "width": 50},
        {"targets": 1,
        "width": 550},
        {"targets": 2,
        "width": 200}]
    });
    tbl_subcategory = $('#setsubcategory').DataTable({
      "ajax": "<?php echo site_url('setting/getsubcat');?>",
      "processing": true,
      "ordering" :false,
      "columnDefs": [
      {"targets": 0,
      "width": 50},
      {"targets": 1,
      "width": 200},
      {"targets": 2,
      "width": 100}]
  });
    $().ready(function() {
        $('#category,#sub_category').select2({
            width : '100%'
        });
        $('#category').change(function(){
            var cat_id = $(this).val();
            var default_opt = '<option value="">- Set category first -</option>';
            if(cat_id == ''){
                $('#sub_category').select2().select2().html(default_opt);
            }else{
                $('#sub_category').select2().select2().html();
                $.post('<?php echo site_url('dashboard/getocc_subcat'); ?>', 
                    { cat_id : cat_id
                    }, function(data){
                        $('#sub_category').select2().select2().html(data);
                    }
                    );
            }
        });
    });
    function add(){
        $('#modal_view_other').modal('show');
    }

function o_m_category(){
  save_method = 'add';
  $('#modal_m_category').find('form')[0].reset();
  $('#modal_m_category').modal('show');     
}
function e_category(id){
  save_method = 'update';
    $('#modal_m_category').modal('show');
        $.ajax({
            url : "<?php echo site_url('setting/get_det_cat/')?>/" + id,
            dataType: "JSON",
            beforeSend: function() {
                $('[name="cat_name"]').val(''); 
            },
            success: function(data) {
              for(var i = 0; i < data.length; i++){
                    $('[name="cat_name"]').val(data[i].cat_name);
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
}
$('#f_m_category').on('submit', function(e) {
    e.preventDefault();
    if(save_method == 'add') {
        url = "<?php echo site_url('setting/add_category')?>";
    }
    else {
        url = "<?php echo site_url('setting/edit_category')?>";
    }
            $.ajax({                                            
                    url : url,
                    type: "POST",
                    data: $('#f_m_category').serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data){
                        alert(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        alert('Network error !');
                    }
                });
});

</script>


    </body>
</html>