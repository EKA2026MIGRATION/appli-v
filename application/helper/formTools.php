<?php



function getSelected($value, $element)
{
  if($value != $element) return null ;
  return ' selected ';
}

function checked($first, $second) {
  if($first != $second) return null;
  return "checked";
}