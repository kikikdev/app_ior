$('.for-ldap').on('submit', function(e) {
    e.preventDefault();
  u = $('.for-un').val();
  p = $('.for-pw').val();
   $.post('index.php/site/login', 
        {uname : u,pwd : p},
        function(data) {
              if (data == 1) {
                  window.location = "index.php/dashboard";
              }
              else if (data == 2) {
                  alert('users not exist wherever OR wrong password!');
              }
              else if (data == 3) {
                  alert('Your username is exist on LDAP, but your password is wrong!');
              }
              else {
                  window.location = "index.php/dashboard";
              }
        })
});

$('[name="occ_date"]').datepicker({
        todayHighlight: true,
        autoclose: true,
        format : 'yyyy-mm-dd',
    });

$('.new-ior').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
            $.ajax({                                            
                    url : 'index.php/site/send_ior',
                    type: "POST",
                    data: formData,
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('.btn-primary').text('Sending...');
                        $('.btn-primary').attr('disabled',true);
                    },
                    success: function(data){ 
                        if(data.status = "true"){
                        $.alert('<strong>Your report has been send, report progress will be notif to your email.</strong>');
                        $('.btn-primary').text("Submit");
                        $('.btn-primary').attr('disabled',false);
                        $('#tab-first').css("display","block");
                        $('#tab-second').css("display","none");

                        // window.location.replace(window.location.href);
                        }
                        
                        // window.location.replace('https://ior.gmf-aeroasia.co.id/');
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        alert('Failed!');
                        $('.btn-primary').text('Submit');
                        $('.btn-primary').attr('disabled',false); 
                      }
                });
});

$(document).ready(function() {
  $('#tab-first').show();  
    $('#tab-second').hide();
    $('#tab-three').hide();
    $('#tab-four').hide();
    $('#dp1').datepicker();
});

function GuestAcc () {
    $('#tab-first').show();  
    $('#tab-second').hide();
    $('#tab-three').hide();
    $('#tab-four').hide(); 
    }
function ViewRecord () {
    $('#tab-first').hide(); 
    $('#tab-second').show();
    $('#tab-three').hide();
    $('#tab-four').hide();   
    }
function Appointment () {
    $('#tab-first').hide(); 
    $('#tab-second').hide();
    $('#tab-three').show();  
    $('#tab-four').hide();
    }
function InventMaster () {
    $('#tab-first').hide(); 
    $('#tab-second').hide();
    $('#tab-three').hide();
    $('#tab-four').show();  
    }