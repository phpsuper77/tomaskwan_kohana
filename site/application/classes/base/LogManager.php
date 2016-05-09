<?php defined('SYSPATH') or die('No direct access allowed.');

class LogManager
{
    const TYPE_SYSTEM = 'system';
    const TYPE_PAYMENT = 'payment';

    public static function info($msg, $type = self::TYPE_SYSTEM) {
        error_log("INFO [$type] - $msg");
    }

    public static function error($msg, $type = self::TYPE_SYSTEM) {
        error_log("ERROR [$type] - $msg");
    }
}
