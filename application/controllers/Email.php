<?php 
   class Email extends CI_Controller { 
 
      function __construct() { 
         parent::__construct(); 
      } 
		
      public function index() {
         $this->load->view('email/email_tpl');
      } 
  
      public function send_mail() { 
        //Load email library
         $this->load->library('email');

         //SMTP & mail configuration
         $config = array(
             'protocol'  => 'smtp',
             'smtp_host' => 'mail.gmf-aeroasia.co.id',
             'smtp_port' => 8008,
             'smtp_user' => 'app.notif',
             'smtp_pass' => 'app.notif',
             'mailtype'  => 'html',
             'charset'   => 'utf-8'
         );
         $this->email->initialize($config);
         $this->email->set_mailtype("html");
         $this->email->set_newline("\r\n");

         //Email content
         $htmlContent = '<h1>Sending email via SMTP server</h1>';
         $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

         $this->email->to('danangyogi11@gmail.com');
         $this->email->from('app.notif@gmf-aeroasia.co.id','MyWebsite');
         $this->email->subject('How to send email via SMTP server in CodeIgniter');
         $this->email->message($htmlContent);

         //Send email
         $this->email->send();
      }

}