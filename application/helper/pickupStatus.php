<?php

/**
 *
 * List of functions HTML / FORMAT
 * used only in View templates
 *
 **/

function showIconStatus($status, $lastStatus) {

   
    if($status == "pec")
    {
      echo '<i class="material-icons status olive">check</i>';
    }
    elseif($status == "npec")
    {
      echo '<i class="material-icons status red">close</i>';
    }
    else // Status = null
    {
      echo '<i class="material-icons status blue">access_time</i>';
    }

}

/**
 *
 * List of functions HTML / FORMAT
 * used only in View templates
 *
 **/

function showCriticity($val) {

  $colors = [ 1 => "red", 2 => "orange" , 3 => "green", 99 => "grey"] ;

  if(!key_exists($val, $colors)) return null;

  return '<i class="material-icons" style="color: '.$colors[$val].'">circle</i>';

}
