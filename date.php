<?php
$str = '2018-10-19 13:46:40.330';
$now = date('Y-m-d H:i:s');

$time= strtotime($str);
print $str.' --> '.date('d-m-Y', strtotime($str)).' - '.date('H:i:s', strtotime($str));
print '<br/>';

$day = floor(($time - time())/86400);
print 'remaining '.$day.' days';
?>