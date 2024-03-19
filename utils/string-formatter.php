<?php


namespace Delinternet\Plugins\Utils;


class StringFormatter
{
    public static function shortText($string = "", $length = 58)
    {
        if (strlen($string) > $length) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length)) . "...";
        }
        return $string;
    }
}
