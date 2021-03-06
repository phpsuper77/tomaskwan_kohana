<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Tour extends Controller_Site_Public
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        $this->route = sanitizeValue($this->request->param('route'));

        //model
        $this->modelStatus = new Model_Status();	
        $this->modelClass = new Model_Class();
        $this->modelSpecoffer = new Model_Specoffer();
        $this->modelFreePass = new Model_Freepass();

    }

    public function action_calendar_json()
    {
        $pageObj = Model_Page::getPageObjByRoute($this->route);
        $userObj = $pageObj->getUserObj();
        $settingObj = $userObj->getSettingObj();
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        // fullCalendar sent in GMT
        $start_day = $data['start']; // sunday
        $end_day = $data['end']; // sat

        $timeSettingObjs = $userObj->getTimeSettingObjs();

        $events = array();
        $incr = $settingObj->getSession();
        $locationObj = $settingObj->getLocationObj();
        foreach ($timeSettingObjs as $timeSettingObj) {
            $d = date('Y-m-d', strtotime($data['start']) + ($timeSettingObj->getDay() * 60 * 60 * 24));
            if (strlen($timeSettingObj->getTimeCustom())>0) {
                // custom time ranges
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
            } else {
                $timeFrom = strtotime($d . ' ' .$timeSettingObj->getTimeFrom());
                $timeTo = strtotime($d . ' ' . $timeSettingObj->getTimeTo());
                for ($i = $timeFrom; $i < $timeTo; $i = $i + $incr) {
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
        }

        // return json
        $this->auto_render = false;
        $this->is_ajax = TRUE;
        header('content-type: application/json');
        echo json_encode($events);
        exit;
    }

    public function action_schedule()
    {
        $pageObj = Model_Page::getPageObjByRoute($this->route);
        $userObj = $pageObj->getUserObj();
        $superiorObj = $userObj->getSuperiorObj();
        $settingObj = $userObj->getSettingObj();
        
        /*
        $filter['owner_id'] = $userObj->getId();
        $bookingObjs = $userObj->getBookingObjs($filter);
         */

        $this->template->content = View::factory('site/templates/tour/schedule');
        $this->template->content->route = $this->route;
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

    public function action_book()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $ownerObj = Model_User::getUserObjById($data['owner_id']);

        if ($ownerObj) {
            $eventData['time_from'] = date('Y-m-d H:i:s', $data['start_time']);
            $eventData['time_to'] = date('Y-m-d H:i:s', $data['end_time']);
            $eventData['location_id'] = $data['location_id'];
            $eventData['owner_id'] = $ownerObj->getId();
            $eventData['type'] = Model_Event::TYPE_TOUR;
            $eventData['status'] = Model_Event::STATUS_ACTIVE;
            $this->loginUserObj->addEvent($eventData);

            $eventData['owner_id'] = $this->loginUserObj->getId();
            $ownerObj->addEvent($eventData);
        }

        $this->request->redirect('/myevent/list');
    }

}
