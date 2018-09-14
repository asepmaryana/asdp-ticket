<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Word extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        
    }
	
    function test_get()
    {
        require_once APPPATH.'/third_party/phpword/PHPWord.php';
        
        $PHPWord = new PHPWord();
        $document = $PHPWord->loadTemplate(APPPATH.'/resource/templates/source.docx');
        
        // simple parsing
        $document->setValue('{var1}', 'BANDUNG');
        
        // prepare data for tables
        $data1 = array(
            'num' => array(1,2,3),
            'color' => array('red', 'blue', 'green'),
            'code' => array('ff0000','0000ff','00ff00')
        );
        $data2 = array(
            'val1' => array(1,2,3),
            'val2' => array('red', 'blue', 'green'),
            'val3' => array('a','b','c')
        );
        $data3 = array(
            'day' => array('Mon','Tue','Wed','Thu','Fri'),
            'dt' => array(12,14,13,11,10),
            'nt' => array(0,2,1,2,-1),
            'dw' => array('SSE at 3 mph', 'SE at 2 mph', 'S at 3 mph', 'S at 1 mph', 'Calm'),
            'nw' => array('SSE at 1 mph', 'SE at 1 mph', 'S at 1 mph', 'Calm', 'Calm')
        );
        
        // clone rows
        $document->cloneRow('TBL1', $data1);
        $document->cloneRow('TBL2', $data2);
        $document->cloneRow('DATA3', $data3);
        
        #download_word($document, 'Hasil');
        
        // save file
        $tmp_file = 'result.docx';
        
        #header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        #header('Content-Disposition: attachment;filename="Hasilnya.docx"');
        #header('Cache-Control: max-age=0');
        
        $document->save($tmp_file);
    }
}
?>