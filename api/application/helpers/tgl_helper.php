<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('tgl'))
{
    function tgl($date)
    {
        if($date == '' || $date == '0000-00-00') return '';
        else {
            list($y, $m, $d) = explode('-', $date);
            return $d.'-'.$m.'-'.$y;
        }
    }
    
    function tgl_rev($date)
    {
        if($date == '' || $date == '00-00-0000') return '';
        else {
            list($d, $m, $y) = explode('-', $date);
            return $y.'-'.$m.'-'.$d;
        }
    }
}
?>