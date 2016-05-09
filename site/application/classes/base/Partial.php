<?php defined('SYSPATH') or die('No direct script access.');

class Partial {

    public static function portlet_suggested_classes($loginUserObj, $title) {
        $view = View::factory('site/partials/portlet_suggested_classes');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $classObjs = $loginUserObj->getSuggestedClassObjs();
        $view->classObjs = $classObjs;
        return $view;
    }

    public static function form_register() {
        $view = View::factory('site/partials/form_register');
        $professionObjs = Model_Unit::getUnitObjs('profession');
        $mortarObjs = Model_Unit::getUnitObjs('mortar');
        $view->mortarObjs = $mortarObjs;
        $view->professionObjs = $professionObjs;
        return $view;
    }

    public static function portlet_session($loginUserObj, $title, $eventObj) {
        $view = View::factory('site/partials/portlet_session');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->eventObj = $eventObj;
        return $view;
    }

    public static function portlet_tour($loginUserObj, $title, $eventObj) {
        $view = View::factory('site/partials/portlet_tour');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->eventObj = $eventObj;
        return $view;
    }

    public static function portlet_class_order($loginUserObj, $title, $classObj) {
        $view = View::factory('site/partials/portlet_class_order');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->classObj = $classObj;
        return $view;
    }

    public static function portlet_class($loginUserObj, $title, $classObj, $paid = false) {
        $view = View::factory('site/partials/portlet_class');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->classObj = $classObj;
        $view->paid = $paid;
        return $view;
    }

    public static function portlet_location($loginUserObj, $title, $locationObj) {
        $view = View::factory('site/partials/portlet_location');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->locationObj = $locationObj;
        return $view;
    }

    public static function portlet_event($loginUserObj, $title, $eventObj) {
        $view = View::factory('site/partials/portlet_event');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->eventObj = $eventObj;
        return $view;
    }

    public static function portlet_user_reviews($loginUserObj, $title, $data, $skip, $limit) {
        $view = View::factory('site/partials/portlet_user_reviews');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->reviewObjs = $loginUserObj->getReviewObjs($data,$skip,$limit);
        return $view;
    }

    public static function portlet_user_invites($loginUserObj, $title, $data, $skip, $limit) {
        $view = View::factory('site/partials/portlet_user_invites');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $view->inviteObjs = $loginUserObj->getInviteObjs($data,$skip,$limit);
        return $view;
    }

    public static function portlet_user_events($loginUserObj, $title, $data, $skip, $limit) {
        $view = View::factory('site/partials/portlet_user_events');
        $view->loginUserObj = $loginUserObj;
        $view->title = $title;
        $eventObjs = $loginUserObj->getEventObjs($data,$skip,$limit);
        $view->eventObjs = $eventObjs;
        return $view;
    }

    public static function user_page_portlet($loginUserObj, $userObj) {
        $superiorObj = $userObj->getSuperiorObj();
        $view = View::factory('site/partials/user_page_portlet');
        $view->userObj = $userObj;
        $view->loginUserObj = $loginUserObj;
        return $view;
    }

    public static function portlet_user_large($loginUserObj, $title, $userObj) {
        $view = View::factory('site/partials/portlet_user_large');
        $view->userObj = $userObj;
        $view->title = $title;
        $view->loginUserObj = $loginUserObj;
        return $view;
    }

    public static function user_portlet($loginUserObj, $userObj) {
        $view = View::factory('site/partials/user_portlet');
        $view->userObj = $userObj;
        $view->loginUserObj = $loginUserObj;
        return $view;
    }

    public static function user_badge_small($loginUserObj, $userObj, $truncate=30) {
        $view = View::factory('site/partials/user_badge_small');
        $view->userObj = $userObj;
        $view->loginUserObj = $loginUserObj;
        $view->truncate = $truncate;
        return $view;
    }

    public static function user_badge_medium($loginUserObj, $userObj, $showSuperior = true) {
        $view = View::factory('site/partials/user_badge_medium');
        $view->userObj = $userObj;
        $view->loginUserObj = $loginUserObj;
        $view->showSuperior = $showSuperior;
        return $view;
    }

    public static function member_list_portlet($loginUserObj, $title, $userObjs) {
        $view = View::factory('site/partials/member_list_portlet');
        $view->title = $title;
        $view->userObjs = $userObjs;
        $view->loginUserObj = $loginUserObj;
        return $view;
    }
}
