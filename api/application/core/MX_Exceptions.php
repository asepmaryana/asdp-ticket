<?php
class MX_Exceptions extends CI_Exceptions {
    
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        set_status_header(500, $heading);
        echo json_encode(
            array(
                'status' => FALSE,
                'message' => $message
            )
        );
    }
    
    public function show_exception($exception) 
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');        
        set_status_header(500, "Internal Server Error");
        $response   = array();
        $response['status'] = false;
        $response['message']= $exception->getMessage();
        if(ENVIRONMENT == 'development') {
            $response['message'] .= '\n'.'File: '.$exception->getFile();
            $response['message'] .= '\n'.'Line: '.$exception->getLine();
        }
        echo json_encode($response);
    }
    
    public function show_php_error($severity, $message, $filepath, $line)
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        //set_status_header(500, $exception->getMessage());
        
        $response   = array();
        $response['status'] = false;
        $response['message']= $message;
        if(ENVIRONMENT === 'development') {
            $response['message'] .= '\n'.'File: '.$filepath;
            $response['message'] .= '\n'.'Line: '.$line;
            $response['message'] .= '\n'.'Severity: '.$severity;
        }
        echo json_encode($response);
    }
}
?>