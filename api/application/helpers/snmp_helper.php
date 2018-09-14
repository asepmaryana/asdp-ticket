<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('snmpValue'))
{
    function snmpValue($val)
    {
		return (strpos($val, ':') !== false) ? trim(substr($val, strpos($val, ':')+1, strlen($val))) : $val;
    }
}

if ( ! function_exists('unit_size'))
{
    function unit_size($val)
    {
		$val = intval($val);
		if($val > (1024 * 1024 * 1024)) return ceil($val/(1024 * 1024 * 1024)).'T';
		elseif($val > (1024 * 1024)) return ceil($val/(1024 * 1024)).'G';
		elseif($val > (1024)) return ceil($val/(1024)).'M';
		else return ceil($val).'K';
    }
}
?>