<?php

require_once(__DIR__.'/../../../modules/mixpanel/lib/Mixpanel.php');

class Stats {

    public static function track($userid, $event, $params = array()) {
        $mp = Mixpanel::getInstance(Kohana::$config->load('site.mixpanel.token'));
        $mp->identify($userid);
        $mp->track($event, $params);
    }

    public static function setUser($userid, $params = array()) {
        $mp = Mixpanel::getInstance(Kohana::$config->load('site.mixpanel.token'));
        $mp->people->set($userid, $params);
    }

    public static function trackCharge($userid, $amt) {
        $mp = Mixpanel::getInstance(Kohana::$config->load('site.mixpanel.token'));
        $mp->people->trackCharge($user_id, $amt);
    }
}
