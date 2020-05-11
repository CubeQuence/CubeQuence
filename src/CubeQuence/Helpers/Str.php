<?php

namespace CubeQuence\Helpers;

class Str
{
    /**
     * Determines if the given string contains the given value
     *
     * @param string $haystack
     * @param string $needle
     * 
     * @return bool
     */
    public static function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Determines if the given string starts with the given value
     *
     * @param string $haystack
     * @param string $start
     * 
     * @return bool
     */
    public static function beginsWith($haystack, $start)
    {
        return substr($haystack, 0, strlen($start)) === $start;
    }

    /**
     * Escape a string
     *
     * @param string $string
     * 
     * @return string
     */
    public static function escape($string)
    {
        $string = trim($string);
        $string = htmlspecialchars($string);
        $string = stripslashes($string);

        return $string;
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * 
     * @return string
     */
    public static function random($length = 32)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}
