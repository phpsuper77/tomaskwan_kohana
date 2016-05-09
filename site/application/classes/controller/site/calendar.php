<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Calendar extends Controller_Site_Public
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

/*
    public function action_available()
    {
        $route = sanitizeValue($this->request->param('route'));
        $pageObj = Model_Page::getPageObjByRoute($route);
        $userObj = $pageObj->getUserObj();
        if ($userObj->isRoleTrainer()) {
            $this->action_session();
        } else {
            $this->action_tour();
        }
    }
*/

    private function getSessionEventsForCustom($data, $excludehash, $datehash, $timeSettingObj, $settingObj, $hostObj, $hostNo) {
        $day = $timeSettingObj->getDay();
        if ($day == 7) {
            $day = 0;
        }
        $d = date('Y-m-d', strtotime($data['start']) + ($day * 60 * 60 * 24));
        $incr = $settingObj->getSession();
        $events = array();
        $ranges = explode(",", trim($timeSettingObj->getTimeCustom())); 
        foreach ($ranges as $range) {
            $time = explode("-", trim($range));
            if (count($time) > 1) {
                $timeFromStr = $d . ' ' . trim($time[0]).':00:00';
                $timeToStr = $d . ' ' . trim($time[1]).':00:00';
                $timeFrom = strtotime($timeFromStr);
                $timeTo = strtotime($timeToStr);
            } else {
                $timeFromStr = $d . ' ' . trim($time[0]).':00:00';
                $timeToStr = $d . ' ' . trim($time[0] + 1).':00:00';
                $timeFrom = strtotime($timeFromStr);
                $timeTo = strtotime($timeToStr);
            }
            for ($i = $timeFrom; $i < $timeTo; $i = $i + $incr) {
                $dt = date('Y-m-d', $i);
                if (isset($excludehash[$dt])) {
                    continue;
                }
                if ($i <= time()) {
                    continue;
                }
                $event = array();
                $event['allDay'] = false;
                $event['start'] = date('Y-m-d H:i:s', $i);
                $event['end'] = date('Y-m-d H:i:s', ($i + $incr));
                $event['start_time'] = $i;
                $event['end_time'] = $i + $incr;
                $event['title'] = "Available";
                $event['type'] = "available";
                $event['price'] = $settingObj->getPrice();
                $locationObj = $settingObj->getLocationObj();
                $event['location_id'] = $locationObj->getId();
                $event['location'] = $locationObj->getName();
                $event['host'] = $hostObj->getName();
                $event['host_id'] = $hostObj->getId();
                $event['host_no'] = $hostNo;
                $event['id']= md5(microtime());

                // check to see if we need to exlucde this available event
                $skip = false;
                if (isset($datehash[$dt])) {
                    $eventObjs = $datehash[$dt];
                    foreach ($eventObjs as $eventObj) {
                        $startInSecs = $eventObj->getTimeFromInSecs();
                        $endInSecs = $eventObj->getTimeToInSecs();
                        if (!(($i + $incr) < $startInSecs || $i > $endInSecs)) {
                            // event overlap, skip this
                            $skip = true;
                            break;
                        } 
                    }
                }

                if (!$skip) {
                    $events[] = $event;
                }
            }
        }
        return $events;
    }

    private function getSessionEventsForTime($data, $excludehash, $datehash, $timeSettingObj, $settingObj, $hostObj, $hostNo) {
        $day = $timeSettingObj->getDay();
        if ($day == 7) {
            $day = 0;
        }
        $d = date('Y-m-d', strtotime($data['start']) + ($day * 60 * 60 * 24));
        $incr = $settingObj->getSession();
        $events = array();
        $timeFrom = strtotime($d . ' ' .$timeSettingObj->getTimeFrom());
        $timeTo = strtotime($d . ' ' . $timeSettingObj->getTimeTo());
        for ($i = $timeFrom; $i < $timeTo; $i = $i + $incr) {
            $dt = date('Y-m-d', $i);
            if (isset($excludehash[$dt])) {
                continue;
            }
            if ($i <= time()) {
                continue;
            }
            $event = array();
            $event['allDay'] = false;
            $event['start'] = date('Y-m-d H:i:s', $i);
            $event['end'] = date('Y-m-d H:i:s', ($i + $incr));
            $event['start_time'] = $i;
            $event['end_time'] = $i + $incr;
            $event['title'] = "Available";
            $event['type'] = "available";
            $event['price'] = $settingObj->getPrice();
            $locationObj = $settingObj->getLocationObj();
            $event['location_id'] = $locationObj->getId();
            $event['location'] = $locationObj->getName();
            $event['host'] = $hostObj->getName();
            $event['host_id'] = $hostObj->getId();
            $event['host_no'] = $hostNo;
            $event['id']= md5(microtime());

            // check to see if we need to exlucde this available event
            $skip = false;
            if (isset($datehash[$dt])) {
                $eventObjs = $datehash[$dt];
                foreach ($eventObjs as $eventObj) {
                    $startInSecs = $eventObj->getTimeFromInSecs();
                    $endInSecs = $eventObj->getTimeToInSecs();
                    if (!(($i + $incr) <= $startInSecs || $i >= $endInSecs)) {
                        // event overlap, skip this
                        $skip = true;
                        break;
                    } 
                }
            }
            if (!$skip) {
                $events[] = $event;
            }
        }
        return $events;
    }

    public function action_session_json()
    {
        $route = sanitizeValue($this->request->param('route'));
        $pageObj = Model_Page::getPageObjByRoute($route);
        $userObj = $pageObj->getUserObj();
        $settingObj = $userObj->getSettingObj();
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        // existing events
        $filter = array();
        $filter['start_date'] = $data['start'];
        $filter['end_date'] = $data['end'];
        $eventObjs = $userObj->getEventObjs($filter, 0, 10000);
        $datehash = array();
        foreach ($eventObjs as $eventObj) {
            $d = date('Y-m-d', $eventObj->getTimeFromInSecs());
            if (!isset($datehash[$d])) {
                $datehash[$d] = array();
            }
            $datehash[$d][] = $eventObj;
        }

        // handle excluded dates

        // fullCalendar sent in GMT
        $start_day = $data['start']; // sunday
        $end_day = $data['end']; // sat

        $events = array();

        $avaObjs = $userObj->getAvailabilityObjs(array());
        $i = 1;
        foreach ($avaObjs as $avaObj) {
            $hostObj = $avaObj->getOwnerObj();
            if (!$hostObj) {
                $hostObj = $userObj;
            }
            $excluded_dates = $avaObj->getExcludedDates();
            $excludehash = array_flip($excluded_dates);
            $timeSettingObjs = $userObj->getAvailabilityTimeObjs($avaObj->getId());
            foreach ($timeSettingObjs as $timeSettingObj) {
                if (strlen($timeSettingObj->getTimeCustom())>0) {
                    $evts = $this->getSessionEventsForCustom($data, $excludehash, $datehash, $timeSettingObj, $avaObj, $hostObj, $i);
                    foreach ($evts as $evt) {
                        $events[] = $evt;
                    }
                } else {
                    $evts = $this->getSessionEventsForTime($data, $excludehash, $datehash, $timeSettingObj, $avaObj, $hostObj, $i);
                    foreach ($evts as $evt) {
                        $events[] = $evt;
                    }
                }
            }
            $i = $i + 1;
        }

        // return json
        $this->auto_render = false;
        $this->is_ajax = TRUE;
        header('content-type: application/json');
        echo json_encode($events);
        exit;
    }

    public function action_session()
    {
        $route = sanitizeValue($this->request->param('route'));
        $pageObj = Model_Page::getPageObjByRoute($route);
        $userObj = $pageObj->getUserObj();
        $staffOfObjs = $userObj->getStaffOfObjs(array());
        $superiorObj = $userObj->getSuperiorObj();
        $settingObj = $userObj->getSettingObj();
        
        /*
        $filter['owner_id'] = $userObj->getId();
        $bookingObjs = $userObj->getBookingObjs($filter);
         */

        $this->template->content = View::factory('site/templates/calendar/session');
        $this->template->content->route = $this->route;
        $this->template->content->scheduleObjs = $scheduleObjs;
        //$this->template->content->owner = $pageObj->getUserId();
        $this->template->content->pageObj = $pageObj;
        $this->template->content->userObj = $userObj;
        $this->template->content->staffOfObjs = $staffOfObjs;
        $this->template->content->friendObjs = $userObj->getFriendObjs(array(), 0, 9);
        $this->template->content->superiorObj = $superiorObj;
    //    $this->template->content->bookingObjs = $bookingObjs;
        $this->template->content->settingObj = $settingObj;
/*
        $this->template->content->modelOrder = new Model_Order();
        $this->template->content->addBookingModal = View::factory('site/templates/session/modal_add');
        $this->template->content->addBookingModal->pageObj = $pageObj;
        $this->template->content->addBookingModal->userObj = $userObj;
        $this->template->content->addBookingModal->settingObj = $settingObj;
*/
    }
                // custom time ranges
    public function getTourEventsForCustom($data, $excludehash, $timeSettingObj, $settingObj)
    {
        $events = array();
        $d = date('Y-m-d', strtotime($data['start']) + ($timeSettingObj->getDay() * 60 * 60 * 24));
        $incr = $settingObj->getSession();
        $locationObj = $settingObj->getLocationObj();
        $ranges = explode(",", trim($timeSettingObj->getTimeCustom()));
        foreach ($ranges as $range) {
            $time = explode("-", trim($range));
            if (count($time) > 1) {
                $timeFromStr = $d . ' ' . trim($time[0]).':00:00';
                $timeToStr = $d . ' ' . trim($time[1]).':00:00';
                $timeFrom = strtotime($timeFromStr);
                $timeTo = strtotime($timeToStr);
            } else {
                $timeFromStr = $d . ' ' . trim($time[0]).':00:00';
                $timeToStr = $d . ' ' . trim($time[0] + 1).':00:00';
                $timeFrom = strtotime($timeFromStr);
                $timeTo = strtotime($timeToStr);
            }
            for ($i = $timeFrom; $i < $timeTo; $i = $i + $incr) {
                $dt = date('Y-m-d', $i);
                if (isset($excludehash[$dt])) {
                    continue;
                }
                if ($i <= time()) {
                    continue;
                }
                $event = array();
                $event['allDay'] = false;
                $event['start'] = date('Y-m-d H:i:s', $i);
                $event['end'] = date('Y-m-d H:i:s', ($i + $incr));
                $event['start_time'] = $i;
                $event['end_time'] = $i + $incr;
                $event['title'] = "Available";
                $event['type'] = "available";
                $event['price'] = $settingObj->getPrice();
                $event['location'] = $locationObj->getFullName();
                $event['location_id'] = $locationObj->getId();
                $event['id']= md5(microtime());
                $events[] = $event;
            }
        }
        return $events;
    }

    private function getTourEventsForTime($data, $excludehash, $timeSettingObj, $settingObj) 
    {
        $events = array();
        $incr = $settingObj->getSession();
        $d = date('Y-m-d', strtotime($data['start']) + ($timeSettingObj->getDay() * 60 * 60 * 24));
        $locationObj = $settingObj->getLocationObj();

        $timeFrom = strtotime($d . ' ' .$timeSettingObj->getTimeFrom());
        $timeTo = strtotime($d . ' ' . $timeSettingObj->getTimeTo());
        for ($i = $timeFrom; $i < $timeTo; $i = $i + $incr) {
            $dt = date('Y-m-d', $i);
            if (isset($excludehash[$dt])) {
                continue;
            }
            if ($i <= time()) {
                continue;
            }
            $event = array();
            $event['allDay'] = false;
            $event['start'] = date('Y-m-d H:i:s', $i);
            $event['end'] = date('Y-m-d H:i:s', ($i + $incr));
            $event['start_time'] = $i;
            $event['end_time'] = $i + $incr;
            $event['title'] = "Available";
            $event['type'] = "available";
            $event['price'] = $settingObj->getPrice();
            $event['location'] = $locationObj->getFullName();
            $event['location_id'] = $locationObj->getId();
            $event['id']= md5(microtime());
            $events[] = $event;
        }

        return $events;
    }

    public function action_tour_json()
    {
        $route = sanitizeValue($this->request->param('route'));
        $pageObj = Model_Page::getPageObjByRoute($route);
        $userObj = $pageObj->getUserObj();
        $settingObj = $userObj->getSettingObj();
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        // fullCalendar sent in GMT
        $start_day = $data['start']; // sunday
        $end_day = $data['end']; // sat

        $events = array();

        $avaObjs = $userObj->getAvailabilityObjs(array());
        $i = 1;
        foreach ($avaObjs as $avaObj) {
            // handle excluded dates
            $excluded_dates = $avaObj->getExcludedDates();
            $excludehash = array_flip($excluded_dates);
            $timeSettingObjs = $userObj->getAvailabilityTimeObjs($avaObj->getId());

            foreach ($timeSettingObjs as $timeSettingObj) {
                if (strlen($timeSettingObj->getTimeCustom())>0) {
                    $evts = $this->getTourEventsForCustom($data, $excludehash, $timeSettingObj, $avaObj);
                    foreach ($evts as $evt) {
                        $events[] = $evt;
                    }
                } else {
                    $evts = $this->getTourEventsForTime($data, $excludehash, $timeSettingObj, $avaObj);
                    foreach ($evts as $evt) {
                        $events[] = $evt;
                    }
                }
            }
        }

        // return json
        $this->auto_render = false;
        $this->is_ajax = TRUE;
        header('content-type: application/json');
        echo json_encode($events);
        exit;
    }

    public function action_tour()
    {
        $route = sanitizeValue($this->request->param('route'));
        $pageObj = Model_Page::getPageObjByRoute($route);
        $userObj = $pageObj->getUserObj();
        $superiorObj = $userObj->getSuperiorObj();
        $settingObj = $userObj->getSettingObj();

        /*
        $filter['owner_id'] = $userObj->getId();
        $bookingObjs = $userObj->getBookingObjs($filter);
         */

        $this->template->content = View::factory('site/templates/calendar/tour');
        $this->template->content->route = $route;
        $this->template->content->scheduleObjs = $scheduleObjs;
        //$this->template->content->owner = $pageObj->getUserId();
        $this->template->content->pageObj = $pageObj;
        $this->template->content->userObj = $userObj;
        $this->template->content->friendObjs = $userObj->getFriendObjs(array(), 0, 9);
        $this->template->content->superiorObj = $superiorObj;
    //    $this->template->content->bookingObjs = $bookingObjs;
        $this->template->content->settingObj = $settingObj;
        $this->template->content->modelOrder = new Model_Order();

/*
        $this->template->content->addBookingModal = View::factory('site/templates/tour/modal_add');
        $this->template->content->addBookingModal->pageObj = $pageObj;
        $this->template->content->addBookingModal->userObj = $userObj;
        $this->template->content->addBookingModal->settingObj = $settingObj;
*/
    }

    public function action_tour_book()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $ownerObj = Model_User::getUserObjById($data['owner_id']);

        if ($ownerObj) {
            $eventData['time_from'] = date('Y-m-d H:i:s', $data['start_time']);
            $eventData['time_to'] = date('Y-m-d H:i:s', $data['end_time']);
            $eventData['location_id'] = $data['location_id'];
            $eventData['owner_id'] = $ownerObj->getId();
            $eventData['price'] = 0;
            $eventData['room'] = '';
            $eventData['host_id'] = $ownerObj->getId();
            $eventData['type'] = Model_Event::TYPE_TOUR;
            $eventData['status'] = Model_Event::STATUS_ACTIVE;
            $this->loginUserObj->addEvent($eventData);

            $eventData['owner_id'] = $this->loginUserObj->getId();
            $ownerObj->addEvent($eventData);
        }

        $this->request->redirect('/myevent/list');
    }

}
