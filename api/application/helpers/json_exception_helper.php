<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function show_json_error($message, $status_code = 500, $status_message = '')
{
   header('Cache-Control: no-cache, must-revalidate');
   header('Content-type: application/json');
   set_status_header($status_code, $status_message);

   echo json_encode(
     array(
         'status' => FALSE,
         'error' => 'Server Error',
         'message' => $message
     )
   );

   exit;
}
?>