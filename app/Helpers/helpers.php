<?php

function format_dated($data){
    return date('d M Y', strtotime($data));
}

function format_IDR ($data){
    return 'Rp '.number_format($data,0,',','.').' ,-';
}
function format_angka ($data){
    return number_format($data,0,',','.');
}
function filter_phone($data)
{
    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($data))){
        // cek apakah no hp karakter 1-2 adalah 62
        if(substr(trim($data), 0, 2)=='62'){
            $hp = trim($data);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($data), 0, 1)=='0'){
            $hp = '62'.substr(trim($data), 1);
        } 
        // cek apakah no hp karakter 1-3 adalah +62
        elseif(substr(trim($data), 0, 3)=='+62'){
            $hp = '62'.substr(trim($data), 3);
        }else {
            $hp = trim($data);
        }
    }
    return $hp;
}


?>