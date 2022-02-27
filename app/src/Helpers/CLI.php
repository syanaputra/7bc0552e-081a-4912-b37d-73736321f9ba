<?php
namespace Helpers;

/**
 * Class CLI
 */
class CLI {

    /**
     * @param $message
     */
    public static function write($message) {
        echo "{$message} \n";
    }

    /**
     * @param $message
     * @return false|string
     */
    public static function read($message) {
        return readline($message);
    }
}