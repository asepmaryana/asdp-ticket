<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('download_excel'))
{
    function download_excel($objPHPExcel, $filename='Laporan')
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
                
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    function download_word($objPHPWord, $filename='Laporan')
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="'.$filename.'.docx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPWord_IOFactory::createWriter($objPHPWord, 'Word2007');
        $objWriter->save('php://output');
    }
}    
?>