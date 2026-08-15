<?php

function use_helper($element)
{
  $elements = explode(',', $element);
  foreach($elements as $filename) {
    $filename = trim($filename);
    if(file_exists(HELPER.$filename.'.php')) {
      require_once(HELPER.$filename.'.php');
    }
  }
}

function dd($var, $stop = 1) {
  // dev only: never leak dumps to users in prod (log instead)
  if (in_array($_SERVER['REMOTE_ADDR'] ?? '', array('127.0.0.1', '::1'), true)) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  } else {
    error_log('dd(): ' . print_r($var, true));
  }
  if($stop == 1 ) exit;
}

function encodeInt(int $id) {
  $id = $id*3 + 7000;
  return urlencode(base64_encode($id));
//  return base_convert($id, 16, 36);  // 16/36
}

function decodeInt($value) {
  $newResult = base64_decode(urldecode($value));
  //$newResult = base_convert($value, 36, 16);
  return ($newResult - 7000)/3;
}


function encrypt($string) {

  $encrypt_method = "AES-256-CBC";
  $key            = hash('sha256', AES_KEY);
  $iv             = substr(hash('sha256', AES_IV), 0, 16);

  $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
  $output = base64_encode($output);
  return $output;
}

function decrypt($string) {

  $encrypt_method = "AES-256-CBC";
  $key            = hash('sha256', AES_KEY);
  $iv             = substr(hash('sha256', AES_IV), 0, 16);


  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  return $output;
}

function showGender($letter) {


    $html = "<span class='gender-icon-".$letter."'>";
    $html .= str_replace('h', 'g', $letter);
    $html .= "</span>";

    return $html;
}