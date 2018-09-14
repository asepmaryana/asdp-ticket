<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Pdf extends REST_Controller
{
	public function __construct() {
        parent::__construct();        
    }
	
    function test_get()
    {
        $this->load->library('M_pdf');
        $mpdf = $this->m_pdf->load([
            'mode' => 'utf-8',
            'format' => 'A4'
        ]);
        $html = $this->load->view('template', '', true);
        #print $html;
        $stylesheet = file_get_contents('../assets/plugin/bootstrap/css/bootstrap.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Rekap.'.date('YmdHis').'.pdf', 'D');
    }
}
?>