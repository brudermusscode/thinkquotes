<?php

class convertToAgo
{

    function timeago($time, $tense = 'ago')
    {
        // declaring periods as static function var for future use
        static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');

        // checking time format
        if (!(strtotime($time) > 0)) {
            return trigger_error("Wrong time format: '$time'", E_USER_ERROR);
        }

        // getting diff between now and time
        $now  = new DateTime('now');
        $time = new DateTime($time);
        $diff = $now->diff($time)->format('%y %m %d %h %i %s');
        // combining diff with periods
        $diff = explode(' ', $diff);
        $diff = array_combine($periods, $diff);
        // filtering zero periods from diff
        $diff = array_filter($diff);
        // getting first period and value
        $period = key($diff);
        $value  = current($diff);

        // if input time was equal now, value will be 0, so checking it
        if (!$value) {
            $period = 'seconds';
            $value  = 0;
        } else {
            // converting days to weeks
            if ($period == 'day' && $value >= 7) {
                $period = 'week';
                $value  = floor($value / 7);
            }
            // adding 's' to period for human readability
            if ($value > 1) {
                $period .= 's';
            }
        }

        // returning timeago
        return "$value $period $tense";
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function convert_datetime($str)
    {

        list($date, $time) = explode(' ', $str);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        return $timestamp;
    }

    function makeAgo($timestamp)
    {

        $difference = time() - $timestamp;
        $periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        for ($j = 0; $difference >= $lengths[$j]; $j++)
            $difference /= $lengths[$j];
        $difference = round($difference);
        if ($difference != 1) $periods[$j] .= "s";
        $text = "$difference $periods[$j] ago";
        return $text;
    }
}
