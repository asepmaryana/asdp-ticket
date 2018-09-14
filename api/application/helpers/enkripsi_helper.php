<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('enkripsi'))
{
    function enkripsi($plainText)
    {
        $key    = 'bridgethenation2018';
        $byte   = mb_convert_encoding($key, 'UTF-8');
        $desKey = md5(utf8_encode($byte), true);
        $desKey .= substr($desKey,0,8);
        
        $data = mb_convert_encoding($plainText, 'UTF-8');
        
        // PKCS#7 padding
        $blocksize = mcrypt_get_block_size('tripledes', 'ecb');
        $paddingSize = $blocksize - (strlen($data) % $blocksize);
        $data .= str_repeat(chr($paddingSize), $paddingSize);
        
        // encrypt password
        $encData = mcrypt_encrypt('tripledes', $desKey, $data, 'ecb');
        
        return base64_encode($encData);
    }
}
?>