<?php

/**
* @package Gradias RPG
* @author Myszu <admin@gradias.pl>
* @license GNU/GPL
* @version 0.1
* @copyright (C) 2009-2018 Gradias.pl Powered by Santic Engine based on Vallheru Engine
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
*
* This script is adding a certain amount of seconds, adjustable by $add variable,
* to current date and time and divides it to bigger values like minutes, hours, days
* and so on. Im pretty sure, that it could've been done easier, but I was curious
* how hard would it be this way. ;)
* I hope you will enjoy it and find it usefull.
*
*/

$title = "Countdown";
require_once("includes/head.php"); if (!$_GET['ajax']) require_once("includes/head_start.php"); 

/**
* Get the localization for game
*/
require_once("languages/".$player -> lang."/daily.php");
if ($player -> rank == 'Przybysz') 
{
    error (YOU_NOT);
}

/////////////////////////////////////////////////
//                SECONDS TO ADD               //
//       YOU CAN USE MATH FOR EASY SETUP       //
//           E.G. 60*60*24 IS ONE DAY          //
/////////////////////////////////////////////////
$add = 60;           
/////////////////////////////////////////////////


/////////////////////////////////////////////////
// VALUES OF BASE CLOCK - SHOWING CURRENT TIME //
/////////////////////////////////////////////////
$year = Date("Y");
$month = Date("n");
$e_month = Date("n");
$day = Date("j");
$hour = Date("G");
$minute = Date("i");
$second = Date("s");
/////////////////////////////////////////////////


/////////////////////////////////////////////////
//           VARIABLES OF TIME TO ADD          //
/////////////////////////////////////////////////
$seconds = 0;
$minutes = 0;
$hours = 0;
$days = 0;
$e_days = 0;
$months = 0;
$years = 0;
/////////////////////////////////////////////////


/////////////////////////////////////////////////
//   VALUES OF END TIME - TIME AFTER ADDITION  //
/////////////////////////////////////////////////
$f_second = Date("s");
$f_minute = Date("i");
$f_hour = Date("G");
$f_day = Date("j");
$f_month = Date("n");
$f_year = Date("Y");
/////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////// START OF COUNTING MECHANISM //////////////////////////////////////////////////////////////////////

// CONVERT SECONDS TO MINUTES
if ($add >= 60)
{
    $minutes += intval($add / 60);
    $f_minute += intval($add / 60);
    $seconds = ($add % 60);
    $f_second += ($add % 60);
}
else
{
    $seconds = $add;
    $f_second += $seconds;
}

if ($second + $seconds >= 60)
{
    $f_minute += intval(($second  +$seconds) / 60);
    $f_second = (($second + $seconds) % 60);
}

// CONVERT MINUTES TO HOURS
if ($minutes >= 60)
{
    $hours += intval($minutes / 60);
    $f_hour += intval($minutes / 60);
    $minutes = ($minutes % 60);
    $f_minute = $minute + $minutes;
}
else
{
    //$minutes = $minutes;
}

if ($minute + $minutes >= 60)
{
    $f_hour += intval(($minute + $minutes) / 60);
    $f_minute = (($minute + $minutes) % 60)+1;
}

// CONVERT HOURS TO DAYS
if ($hours >= 24)
{
    $days += intval($hours / 24);
    $f_day += intval($hours / 24);
    $hours = ($hours % 24);
    $f_hour = $hour + $hours;
}
else
{
    //$hours = $hours;
}

if ($hour + $hours >= 24)
{
    $f_day += intval(($hour + $hours) / 24);
    $f_hour = (($hour + $hours) % 24)+1;
}

// CONVERT DAYS TO MONTHS
$run = 1;

while ($run <= ($day + $days))
{
    if ($e_month == 1 || $e_month == 3 || $e_month == 5 || $e_month == 7 || $e_month == 8 || $e_month == 10) // CHECKING WHAT MONTH IS NOW - THIS DETERMINES HOW MANY DAYS ARE NEEDED TO CONVERT TO 1 MONTH 
    {
        if ($days >= 31) // CHECKING IF THERE IS MORE DAYS TO ADD, THEN THERE ARE IN CURRENT MONTH
        {
            // INCREASING MONTHS TO ADD VALUE
            $months++;
            // INCREASING FINAL MONTH VALUE
            $f_month++;
            // INCREASING OPERATIVE MONTH VALUE
            $e_month++;
            // SUBSTRACTING DAYS IN MONTH FROM DAYS TO ADD VALUE
            $days = ($days - 31);
            // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS DAYS TO ADD
            $f_day = $day + $days;
            // INCREASING RUN VALUE
            $run++;
        }
        elseif (($day + $days) >= 31) // CHECKING SUM OF DAYS TO ADD AND CURRENT DAY GIVES MORE DAYS, THEN THERE ARE IN CURRENT MONTH
        {
            // INCREASING FINAL MONTH VALUE
            $f_month++;
            // INCREASING OPERATIVE MONTH VALUE
            $e_month++;
            // CLONING VALUE OF DAYS TO OPERATE ON IT WITHOUT DECREASING IT VALUE
            $e_days = $days;
            // SUBSTRACTING DAYS IN MONTH FROM CLONED DAYS TO ADD VALUE
            $e_days = ($days - 31);
            // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS CLONED DAYS TO ADD
            $f_day = $day + $e_days;
            // ENDING THE LOOP
            break;
        }
        else // IF THERE IS NOT ENOUGH DAYS TO ADD, TO FORM NEW MONTH, BREAK THE LOOP
        {
        // ENDING THE LOOP
        break; 
        }
    }
    elseif ($e_month == 4 || $e_month == 6 || $e_month == 9 || $e_month == 11) // CHECKING WHAT MONTH IS NOW - THIS DETERMINES HOW MANY DAYS ARE NEEDED TO CONVERT TO 1 MONTH 
    {
        if ($days >= 30) // CHECKING IF THERE IS MORE DAYS TO ADD, THEN THERE ARE IN CURRENT MONTH
        {
            // INCREASING MONTHS TO ADD VALUE
            $months++;
            // INCREASING FINAL MONTH VALUE
            $f_month++;
            // INCREASING OPERATIVE MONTH VALUE
            $e_month++;
            // SUBSTRACTING DAYS IN MONTH FROM DAYS TO ADD VALUE
            $days = ($days - 30);
            // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS DAYS TO ADD
            $f_day = $day + $days;
            // INCREASING RUN VALUE
            $run++;
        }
        elseif (($day + $days) >= 30) // CHECKING SUM OF DAYS TO ADD AND CURRENT DAY GIVES MORE DAYS, THEN THERE ARE IN CURRENT MONTH
        {
            // INCREASING FINAL MONTH VALUE
            $f_month++;
            // INCREASING OPERATIVE MONTH VALUE
            $e_month++;
            // CLONING VALUE OF DAYS TO OPERATE ON IT WITHOUT DECREASING IT VALUE
            $e_days = $days;
            // SUBSTRACTING DAYS IN MONTH FROM CLONED DAYS TO ADD VALUE
            $e_days = ($days - 30);
            // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS CLONED DAYS TO ADD
            $f_day = $day + $e_days;
            // ENDING THE LOOP
            break;
        }
        else
        {
        // ENDING THE LOOP
        break;    
        }
    }
    elseif ($e_month == 2) // CHECKING WHAT MONTH IS NOW - THIS DETERMINES HOW MANY DAYS ARE NEEDED TO CONVERT TO 1 MONTH 
    {
        if ($f_year % 4 == 0) // CHEKING IF IT IS A LEAP YEAR
        {
            if ($days >= 29) // CHECKING IF THERE IS MORE DAYS TO ADD, THEN THERE ARE IN CURRENT MONTH
            {
                // INCREASING MONTHS TO ADD VALUE
                $months++;
                // INCREASING FINAL MONTH VALUE
                $f_month++;
                // INCREASING OPERATIVE MONTH VALUE
                $e_month++;
                // SUBSTRACTING DAYS IN MONTH FROM DAYS TO ADD VALUE
                $days = ($days - 29);
                // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS DAYS TO ADD
                $f_day = $day + $days;
                // INCREASING RUN VALUE
                $run++;
            }
            elseif (($day + $days) >= 29) // CHECKING SUM OF DAYS TO ADD AND CURRENT DAY GIVES MORE DAYS, THEN THERE ARE IN CURRENT MONTH
            {
                // INCREASING FINAL MONTH VALUE
                $f_month++;
                // INCREASING OPERATIVE MONTH VALUE
                $e_month++;
                // CLONING VALUE OF DAYS TO OPERATE ON IT WITHOUT DECREASING IT VALUE
                $e_days = $days;
                // SUBSTRACTING DAYS IN MONTH FROM CLONED DAYS TO ADD VALUE
                $e_days = ($days - 29);
                // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS CLONED DAYS TO ADD
                $f_day = $day + $e_days;
                // ENDING THE LOOP
                break;
            }
            else
            {
            // ENDING THE LOOP
            break;    
            }
        }
        elseif ($f_year % 4 != 0)// CHEKING IF IT IS NOT A LEAP YEAR
        {
            if ($days >= 28) // CHECKING IF THERE IS MORE DAYS TO ADD, THEN THERE ARE IN CURRENT MONTH
            {
                // INCREASING MONTHS TO ADD VALUE
                $months++;
                // INCREASING FINAL MONTH VALUE
                $f_month++;
                // INCREASING OPERATIVE MONTH VALUE
                $e_month++;
                // SUBSTRACTING DAYS IN MONTH FROM DAYS TO ADD VALUE
                $days = ($days - 28);
                // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS DAYS TO ADD
                $f_day = $day + $days;
                // INCREASING RUN VALUE
                $run++;
            }
            elseif (($day + $days) >= 28) // CHECKING SUM OF DAYS TO ADD AND CURRENT DAY GIVES MORE DAYS, THEN THERE ARE IN CURRENT MONTH
            {
                // INCREASING FINAL MONTH VALUE
                $f_month++;
                // INCREASING OPERATIVE MONTH VALUE
                $e_month++;
                // CLONING VALUE OF DAYS TO OPERATE ON IT WITHOUT DECREASING IT VALUE
                $e_days = $days;
                // SUBSTRACTING DAYS IN MONTH FROM CLONED DAYS TO ADD VALUE
                $e_days = ($days - 28);
                // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS CLONED DAYS TO ADD
                $f_day = $day + $e_days;
                // ENDING THE LOOP
                break;
            }
            else
            {
            // ENDING THE LOOP
            break;    
            }
        }
    }
    elseif ($e_month == 12) // CHECKING WHAT MONTH IS NOW - THIS DETERMINES HOW MANY DAYS ARE NEEDED TO CONVERT TO 1 MONTH 
    {
        if ($days >= 31) // CHECKING IF THERE IS MORE DAYS TO ADD, THEN THERE ARE IN CURRENT MONTH
        {
            // INCREASING MONTHS TO ADD VALUE
            $months++;
            // INCREASING FINAL MONTH VALUE
            $f_month = 1;
            // INCREASING OPERATIVE MONTH VALUE
            $e_month = 1;
            // SUBSTRACTING DAYS IN MONTH FROM DAYS TO ADD VALUE
            $days = ($days - 31);
            // FINAL YEAR VALUE IS EQUAL TO CURRENT YEAR PLUS YEARS TO ADD
            $f_year += 1;
            // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS DAYS TO ADD
            $f_day = $day + $days;
            // INCREASING RUN VALUE
            $run++;
        }
        elseif (($day + $days) >= 31) // CHECKING SUM OF DAYS TO ADD AND CURRENT DAY GIVES MORE DAYS, THEN THERE ARE IN CURRENT MONTH
        {
            // INCREASING FINAL MONTH VALUE
            $f_month = 1;
            // INCREASING OPERATIVE MONTH VALUE
            $e_month = 1;
            // CLONING VALUE OF DAYS TO OPERATE ON IT WITHOUT DECREASING IT VALUE
            $e_days = $days;
            // SUBSTRACTING DAYS IN MONTH FROM CLONED DAYS TO ADD VALUE
            $e_days = ($days - 31);
            // FINAL YEAR VALUE IS EQUAL TO CURRENT YEAR PLUS YEARS TO ADD
            $f_year += 1;
            // FINAL DAY VALUE IS EQUAL TO CURRENT DAY PLUS CLONED DAYS TO ADD
            $f_day = $day + $e_days;
            // ENDING THE LOOP
            break;
        }
        else
        {
        // ENDING THE LOOP
        break;    
        }
    }
}

// CONVERT MONTHS TO YEARS
if ($months >= 12)
{
    $years = intval(($months) / 12);
    $months = ($months % 12);
}

////////////////////////////////////////////////////////////////////// END OF COUNTING MECHANISM //////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////// RESULT ///////////////////////////////////////////////////////////////////////////////

$start = new DateTime("".$hour.":".$minute.":".$second." ".$month."/".$day."/".$year.""); // GETTING CURRENT DATE AND TIME
$d_start = date_format($start, 'G:i:s d M, Y'); // FORMATING CURRENT DATE AND TIME

echo "<br>Start: ".$d_start."<br>"; // SHOWS STARTING DATE (NOW)
echo "<br>Years: ".$years." 
<br>Months: ".$months."
<br>Days: ".$days."
<br>Hours: ".$hours."
<br>Minutes: ".$minutes."
<br>Seconds: ".$seconds."<br><br>"; // THIS WILL LIST HOW MANY YEARS, MONTHS, DAYS, HOURS, MINUTES AND SECONDS WILL HAVE TO PASS

$end = new DateTime("".$f_hour.":".$f_minute.":".$f_second." ".$f_month."/".$f_day."/".$f_year.""); //GETTING FINAL DATE AND TIME
$d_end = date_format($end, 'G:i:s d M, Y'); // FORMATING FINAL DATE AND TIME

echo "End: ".$d_end."<br>"; // SHOWS FINAL DATE AND TIME

if (!$_GET['ajax']) require_once("includes/foot.php");
?>

