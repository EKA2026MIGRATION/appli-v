<?php

/**
 *
 * List of functions HTML / FORMAT
 * used only in View templates
 *
 **/


/**
 * Show date with new format
 * @param string
 * @return string
 */
function showDate($date, $format = 'd/m/Y') {
  if($date == "NaN-NaN-NaN") return $date;
  $myDate = new DateTimeFrench($date);
  return $myDate->format($format);
}

function showHour($hour) {

  if(strlen($hour)>10) return null;


  $time = explode(':', $hour);
  return $time[0].':'.$time[1];
}

function isDate($date)
{
   return (DateTime::createFromFormat('Y-m-d', $date) !== false);
}

/**
 * return month
 * @param string
 * @return string
 */
function getMonth($date) {
  return showDate($date, 'F');
}

/**
 * return year of date
 * @param string
 * @return string
 */
function getYear($date, $format = 'Y') {
  return showDate($date, $format);
}

/**
 * return week of date
 * @param string
 * @return string
 */
function getWeek($date, $format = 'W') {
  return showDate($date, $format);
}

/**
 * return time H:m
 * @param string
 * @return string
 */
function showTime($time, $format = 'H:i')
{
  return showDate($time, $format);
}

/**
 * return difference time
 * @param string
 * @return string
 */
function timeSpend($start, $end, $format = '%H:%I')
{
  $datetime1 = new DateTime($start);
  $datetime2 = new DateTime($end);
  $interval = $datetime1->diff($datetime2);
  return $interval->format($format);
}

// use only if time format is HH/MM
function incrementTime($time, $duration) {

    $timeOrigin = explode(':', $time);
    $duration   = explode(':', $duration);

    $hour = (int)$timeOrigin[0] + (int)$duration[0];
    $min  = (int)$timeOrigin[1] + (int)$duration[1];
    
    if($min > 59) {
        $min = $min - 60;
        $hour++;
    }
    if($min < 10) $min = '0'.$min;
    return $hour.':'.$min;

}

/**
/**
 * return difference date
 * @param string
 * @return string
 */
 function diffDate($start , $end )
 {
     $date1 = showDate($start, 'Ymd');
     $date2 = showDate($end, 'Ymd');
     return $date2-$date1;

 }

function newDiffDate($start, $end) {
    $date1 = new DateTime($start);
    $date2 = new DateTime($end);
    $interval = $date1->diff($date2);
    return intval($interval->format('%a'));
}

function convertTimeSpend($seconds) {
  return $seconds;
  $minutes = $seconds/60;
  $hours   = $minutes/60;
  $days    = $hours/24;
  return $days.' '.$hours.' '.$minutes;
}

function getDateStartWeek($date_ref = null) {
    if(!$date_ref) $date_ref = date('Y-m-d');
    // Calcul de l'écart entre le jour de $day et le lundi (=1)
    $rel = 1 - date('N', strtotime ($date_ref));
    //calcul du lundi avec cet écart
    $monday = date('Y-m-d', strtotime("$rel days", strtotime($date_ref)));
    return $monday;
}

function getDateEndWeek($date_ref = null) {
  $monday = getDateStartWeek($date_ref);
  $sunday = nextDay($monday, 6);
  return $sunday;
}

function getStartMonth($date, $format = "Y-m-d") {
    $startMonth = showDate($date, 'Y').'-'.showDate($date, 'm').'-01';
    return showDate($startMonth, $format);
}

function getEndMonth($date, $format = "Y-m-d") {
  $first = [1, 3, 5, 7, 8, 10, 12];

  $elements = explode('-', $date);

  $month = $elements[1]+0;
  
  if(in_array($month, $first)) {
    $day = '31';
  } else {
    if($month == "2") {
      $day = "28";
    } else {
      $day = "30";
    }
  }
  return showDate($elements[0].'-'.$month.'-'.$day, $format);
}

function nextDay($date_ref, $n = 1)
{
  return date('Y-m-d', strtotime($date_ref.", +".$n." day"));
}

function prevDay($date_ref, $n = 1)
{
  return date('Y-m-d', strtotime($date_ref.", -".$n." day"));
}

function addHour($date, $format = "H:i:s", $val = 2) {
    $current_date = new DateTime($date);
    $new_date = $current_date;
    $new_date->modify('+'.$val.' hours');
    return $new_date->format($format);
}

function lessHour($date, $format = "H:i:s", $val = 1) {
  $current_date = new DateTime($date);
  $new_date = $current_date;
  $new_date->modify('-'.$val.' hour');
  return $new_date->format($format);
}

function showDatePickerNavigation($endPoint, $date, $currentActiveStaffId = null)
{

  if($currentActiveStaffId) {
    $prevLeftLink = HOST.$endPoint.'/'.prevDay($date).'/idDriver/'.$currentActiveStaffId.'/';
    $nextRightLink = HOST.$endPoint.'/'.nextDay($date).'/idDriver/'.$currentActiveStaffId.'/';

  } else {
    $prevLeftLink = HOST.$endPoint.'/'.prevDay($date)."/";
    $nextRightLink = HOST.$endPoint.'/'.nextDay($date)."/";
  }
  include(VIEW.'render/blockTemplate/_datePickerNavigation.php');
}

function showDuration($duration) {
  $element = explode(':', $duration);
  $html = "";
  if($element[0] != '00') {
    $html .= ' '.$element[0].' jour';
    if($element[0] != '01') $html .= 's';
  }
  if($element[1] != '00') {
    $html .= ' '.$element[1].' heure';
    if($element[1] != '01') $html .= 's';
  }
  if($element[2] != '00') $html .= ' '.$element[2].' minutes ';
  return $html;
}

 function showMoment($start, $end, $midi = false) {
    $element1 = explode(':', $start);
    $element2 = explode(':', $end);
    $startKey = $element1[0].$element1[1];
    $endKey   = $element2[0].$element2[1];

    $val = "inconnu";

    if($endKey <= 1200) {
      $val = "Matinée";
    }

    if($startKey <= 1200 && $endKey >= 1300) {
      $val = "Journée";
    }

    if($startKey >= 1300) {
      $val = 'Après-midi';
    }

    if($midi) {
      if($startKey >= 1100 && $endKey < 1400) {
        $val = "Midi";
      }
    }

    return $val;
}

/**
 * Return moment from start and end time
 *
 * @param $start
 * @param null $end
 * @param null $midi
 * @return mixed|null
 */
function showMomentShort($start, $end = null, $midi = null) {
    if($end) {
      $moment = showMoment($start, $end, $midi);
    } else {
      $moment = $start;
    }

    $trans = ['Matinée' => 'am', 'Journée' => 'day', 'Après-midi' => 'pm', '/' => 'unknown', 'Midi' => 'md'];
    if(!isset($trans[$moment])) return null;
    return $trans[$moment];
}

/**
 * Return color moment
 *
 *
 * @param $moment
 * @return mixed|null
 */
function showColorMoment($moment) {
    $color  = ['am' => '#FFECB3', 'pm' => '#C8E6C9', 'day' => '#BBDEFB', 'md' => '#E6D5F8'];
    $color2 = ['Matinée' => '#FFECB3', 'Après-midi' => '#C8E6C9', 'Journée' => '#BBDEFB', 'Midi' => '#E6D5F8'];

    if(isset($color[$moment])) return $color[$moment];
    if(isset($color2[$moment])) return $color2[$moment];
    return null;
}

/**
 * Calculate if today is birthday
 *
 * @param $birthday
 * @param $currentDate
 * @return $html
 */
function itIsBirthdate($birthday) {
    $birthdayFormatted = DateTime::createFromFormat('Y-m-d', $birthday)->format('m-d');
    if (in_array($birthdayFormatted, $_SESSION['DAYS_WEEK'])) {
        return true;
    }
    return false;
}