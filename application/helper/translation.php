<?php

$GLOBALS['translation_terms'] = parse_ini_file(APPLICATION.'Translation.ini', true);


function trans($term, $plural = 0, $plural_value = "s")
{
  $datas = $GLOBALS['translation_terms'];
  if(!array_key_exists($term, $datas)) return $term;

  $term = $datas[$term];

  if($plural) {
    $lastLetter = substr($term, -1, 1);
    if($lastLetter != $plural_value) $term = $term.$plural_value;
  }

  return $term;
}

function maj($string) {

  $string = str_replace(['é', 'è', 'à'], ['e', 'e', 'a'], $string);
  $string = strtoupper($string);
  return $string;
}

function showSelectSql($title) {
  $elements = explode('.', $title);

  (isset($elements[1])) ? $newElement = $elements[1] : $newElement = $elements[0];


  $lastElements = explode(' as ', $newElement);
  (isset($lastElements[1])) ? $newtTitle = $lastElements[1] : $newtTitle = $lastElements[0];

  return trim($newtTitle);

}

