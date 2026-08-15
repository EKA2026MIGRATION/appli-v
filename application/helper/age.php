<?php

/**
 *
 * List of functions HTML / FORMAT
 * used only in View templates
 *
 **/


/**
 * Show age from birth date
 * @param string
 * @return string
 */
function showAge($bithdayDate, $text = " ans") {
   $date = new DateTime($bithdayDate);
   $now = new DateTime();
   $interval = $now->diff($date);
   return $interval->y.$text;
}
