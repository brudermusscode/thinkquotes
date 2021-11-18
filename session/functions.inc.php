<?php


// convert timestamps
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


// trim text
function trim_text($input, $length, $ellipses = true, $strip_html = true)
{
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return $trimmed_text;
}

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 0) return $min;
    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1;
    $bits = (int) $log + 1;
    $filter = (int) (1 << $bits) - 1;
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter;
    } while ($rnd >= $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, strlen($codeAlphabet))];
    }
    return $token;
}

function randColour()
{
    $colours = [
        '#F34236', // RED
        '#E81E62', // PINK
        '#9B27AF', // PURPLE
        '#663AB6', // DEEP PURPLE
        '#3E50B4', // INDIGO
        '#2195F2', // BLUE
        '#03A8F3', // LIGHT BLUE
        '#00BBD3', // CYAN
        '#009587', // TEAL
        '#4BAE4F', // GREEN
        '#8AC249', // LIGHT GREEN
        '#CCDB39', // LIME
        '#FEEA3B', // YELLOW
        '#FEC007', // AMBER
        '#FE9700', // ORANGE
        '#FE5622', // DEEP ORANGE
        '#785447', // BROWN
        '#5F7C8A'  // BLUE GREY
    ];

    $k = array_rand($colours);
    $v = $colours[$k];
    return $v;
}


// preg_replace && preg:match
function only($strg, $which)
{

    switch ($which) {
        case "let&num":
            $strg = preg_replace("/[^A-Za-z0-9]/", '', $strg);
            break;
        case "num":
            $strg = preg_replace("/[^0-9]/", '', $strg);
            break;
        case "let":
            $strg = preg_replace("/[^A-Za-z]/", '', $strg);
            break;
        default:
            $strg = $strg;
    }
    return $strg;
}


// handle page behaviours
if (isset($is_page) && $is_page) {

    // check if maintenance
    if ($main["maintenance"] == "1") {
        if ($isLoggedIn) {
            if ($_SESSION["admin"] == '0') {
                if ($page !== "maintenance") {
                    header("Location: " . $main["maintenanceurl"]);
                }
            }
        } else {
            if ($page !== "maintenance") {
                header("Location: " . $main["maintenanceurl"]);
            }
        }
    } else {
        if ($isLoggedIn) {
            if ($_SESSION["admin"] == '0') {
                if ($page === "maintenance") {
                    header("Location: " . $main["url"]);
                }
            }
        } else {
            if ($page === "maintenance") {
                header("Location: " . $main["url"]);
            }
        }
    }
}
