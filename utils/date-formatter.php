<?php


namespace Delinternet\Plugins\Utils;


class DateFormatter
{
    public static function fromNow($time_diff)
    {
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;
        $month = $day * 30.44; 
        $year = $day * 365.25;

        if ($time_diff < $minute) {
            $time_ago = sprintf(_n('%s second ago', '%s seconds ago', $time_diff, 'text-domain'), $time_diff);
        } elseif ($time_diff < $hour) {
            $time_ago = sprintf(_n('%s minute ago', '%s minutes ago', floor($time_diff / $minute), 'text-domain'), floor($time_diff / $minute));
        } elseif ($time_diff < $day) {
            $time_ago = sprintf(_n('%s hour ago', '%s hours ago', floor($time_diff / $hour), 'text-domain'), floor($time_diff / $hour));
        } elseif ($time_diff < $week) {
            $time_ago = sprintf(_n('%s day ago', '%s days ago', floor($time_diff / $day), 'text-domain'), floor($time_diff / $day));
        } elseif ($time_diff < $month) {
            $time_ago = sprintf(_n('%s week ago', '%s weeks ago', floor($time_diff / $week), 'text-domain'), floor($time_diff / $week));
        } elseif ($time_diff < $year) {
            $time_ago = sprintf(_n('%s month ago', '%s months ago', floor($time_diff / $month), 'text-domain'), floor($time_diff / $month));
        } else {
            $time_ago = sprintf(_n('%s year ago', '%s years ago', floor($time_diff / $year), 'text-domain'), floor($time_diff / $year));
        }

        return $time_ago;
    }
}
