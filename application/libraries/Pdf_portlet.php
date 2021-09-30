<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf_portlet {
    
    function pdf_portlet()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        
        // return new mPDF('utf-8', 'A4');
        return new mPDF('utf-8', array(200,260));

        
    }
}