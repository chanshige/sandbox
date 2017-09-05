<?php
namespace Jobchan\Util;

/**
 * Class Common
 *
 * @package Jobchan\Util
 */
class Common
{
    /**
     * Generate URL-encoded query string.
     *
     * @param array
     * @return string
     */
    public static function buildQuery()
    {
        $ret = [];
        foreach (func_get_args() as $value) {
            $ret += $value;
        }
        return http_build_query($ret, '', "&");
    }

    /**
     * Truncated string with specified width
     *
     * @param string $string
     * @param int    $width
     * @return string
     */
    public static function truncatedStr($string, $width = 60)
    {
        return mb_strimwidth($string, 0, $width, "...", "UTF-8");
    }
}
