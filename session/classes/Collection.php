<?php

$collection = new Collection;

class Collection
{
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

    // get a random token
    function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
        }
        return $token;
    }

    // get a random color from predefined array
    function randColour()
    {
        // nice colors up in an array
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

        // get a random element from color's array
        $k = array_rand($colours);

        // put that $k element as index in that color array
        $v = $colours[$k];

        // return it
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
}
