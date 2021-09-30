$("#invidnopeg").keyup(function() { 
    var id = $("#invidnopeg").val();
    if (id.length > 5 || id.length == 6){
     $.ajax({
        url : "./dashboard/OpenEmplDetail/" + id,
        type: "POST",
        dataType: "JSON",
        beforeSend: function() {
          $('#tbl_inventory_body').remove();
        },
        success: function(data) {
          for(var i = 0; i < data.length; i++){
              $('#invidname').val(data[i].nama);
              $('#invidposition').val(data[i].jabatan);
              $('#invidunit').val(data[i].unit);
          }         
          getinventlist (id);           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {   
        }
});
}
});

 function reloadbefore()
{ 
    oTable.ajax.reload(null,false); 
}

function getinventlist (id) {
  $("#tbl_inventory").dataTable().fnDestroy()

  oTable =$('#tbl_inventory').DataTable( 
{
        "ajax": "./dashboard/ajax_listinvent/" + id,
        "scrollCollapse": true,
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "paging":   false,
        "ordering": false,
        "info":     false,
        "filter": false
});
}

$(document).ready(function() {
  $('#invMastOne').hide();
});

function IMinventory () {
    $('#invMastOne').show(); 
    }
function IMaddpic () {
    $('#invMastOne').hide();
    }
