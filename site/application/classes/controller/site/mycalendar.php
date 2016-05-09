<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_MyCalendar extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_json()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        // fullCalendar sent in GMT
        $start_day = $data['start']; // sunday
        $end_day = $data['end']; // sat

        $filter = array();
        $filter['start_date'] = $start_day;
        $filter['end_date'] = $end_day;

        if ($this->loginUserObj->isRoleHost()) {
            $eventObjs = $this->loginUserObj->getHostEventObjs($filter, 0, 10000);
        } else {
            $eventObjs = $this->loginUserObj->getEventObjs($filter, 0, 10000);
        }
        $datehash = array();
        foreach ($eventObjs as $eventObj) {
            $d = date('Y-m-d', $eventObj->getTimeFromInSecs());
            if (!isset($datehash[$d])) {
                $datehash[$d] = array();
            }
            $datehash[$d][] = $eventObj;
        }

        $start_secs = strtotime($start_day);
        $end_secs = strtotime($end_day);
        $events = array();
        for ($i = $start_secs; $i <= $end_secs; $i = $i + 24 * 60 * 60) {
            $next_day = $i + 24 * 60 * 60; 
            $dt = date('Y-m-d', $i);
            $eventObjs = array();
            if (isset($datehash[$dt])) {
                $eventObjs = $datehash[$dt];
            }
            foreach ($eventObjs as $eventObj) {
                $event_start = $eventObj->getTimeFromInSecs();
                $event_end = $eventObj->getTimeToInSecs();
                $ownerObj = $eventObj->getOwnerObj();
                $pageObj = $ownerObj->getPageObj();
                $hostObj = $eventObj->getHostObj();
                $hostPageObj = $hostObj->getPageObj();
                $event = array();
                $event['allDay'] = false;
                $event['start'] = date('Y-m-d H:i:s', $event_start);
                $event['end'] = date('Y-m-d H:i:s', $event_end);
                $event['start_time'] = $event_start;
                $event['end_time'] = $event_end;
                $event['name'] = $eventObj->getName();
                $event['title'] = $eventObj->getEventType();
                $event['host_name'] = $hostObj->getName();
                $event['host_id'] = $hostObj->getId();
                $event['host_url'] = $hostPageObj->getPageUrl();
                $event['owner_name'] = $ownerObj->getName();
                $event['owner_id'] = $ownerObj->getId();
                if ($pageObj) {
                    $event['owner_url'] = $pageObj->getPageUrl();
                } else {
                    $event['owner_url'] = '#';
                }
            $locationObj = $eventObj->getLocationObj();
            if ($locationObj) {
                $event['location_id'] = $locationObj->getId();
                $event['location'] = $locationObj->getShortName();
            }
                $event['type'] = $eventObj->getEventType();
                $event['id']= $eventObj->getId();
                $events[] = $event;
            }
        }

        // return json
        $this->auto_render = false;
        $this->is_ajax = TRUE;
        header('content-type: application/json');
        echo json_encode($events);
        exit;
    }

    public function action_show()
    {
        $this->template->content = View::factory('site/templates/mycalendar/show');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'calendar';
        $this->template->content->sidebar->active = 'calendar';
    }


}
