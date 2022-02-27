<?php

namespace Helpers;

/**
 * Class DateTimeHelper
 */
class DateTimeHelper {

    /**
     * @param $dateString
     * @return \DateTime|false
     */
    public static function createDateTime($dateString) {
        return \DateTime::createFromFormat('d/m/Y H:i:s', $dateString);
    }

    /**
     * @param      $dateString
     * @param bool $withTime
     * @return string
     */
    public static function formatNicely($dateString, $withTime = true) {
        $date = self::createDateTime($dateString);

        $format = 'jS F Y';
        if ($withTime) {
            $format .= ' g:i A';
        }

        return $date->format($format);
    }

}