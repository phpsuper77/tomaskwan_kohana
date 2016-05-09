<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Class extends Model_Base {

    const DEFAULT_IMAGE = 'https://placehold.it/320x320?text=no+image';

    public function getClassList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'id';
        if(!$filter['order'])
            $filter['order'] = 'desc';
        $prequery = 'SELECT * FROM class WHERE deleted=0';
        if($filter['user_id']) {
            $prequery .= ' AND user_id="'.$filter['user_id'].'"';
        }
        if($filter['search']) {
            $prequery .= ' AND name LIKE %'.$filter['search'].'% ';
        }
        if ($filter['start_date']) {
            $prequery .= ' and date_from>="' .$filter['start_date'].'"';
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        return $result->as_array();

    }

    public static function updateImage($user_id, $id,$image) {
        $query = DB::query(Database::UPDATE, 'UPDATE class SET image=:image WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':image', $image)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('class', $id));
    }

    public function getClassByRoute($route) {
        $query = DB::query(Database::SELECT,'SELECT c.*,p.route FROM class AS c JOIN page AS p ON c.user_id=p.user_id WHERE p.route=:route ORDER BY time_from')
            ->bind(':route', $route);

        $result = $query->execute();
        return $result->as_array();
    }

    public function checkClass($time,$date_to,$day,$trainer_id,$range=NULL) {

        $prequery = 'SELECT * FROM class WHERE trainer_id=:trainer_id';

        if($range!=NULL)
            $prequery .= ' AND :time BETWEEN time_from AND time_to';
        else
            $prequery .= ' AND time_from=:time';


        $prequery .= ' AND date_to>=:date_to';

        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':trainer_id', $trainer_id)
            ->bind(':time', $time)
            ->bind(':date_to', $date_to);

        $result = $query->execute()->as_array();

        if(count($result)>0)
        {
            if(in_array($day,unserialize($result[0]['week'])))
                return $result[0];
            else
                return FALSE;
        }
        else
            return FALSE;

    }

    public function getClassByPageId($page_id) {
        $query = DB::query(Database::SELECT,'SELECT c.*,p.route FROM class AS c JOIN page AS p ON c.user_id=p.user_id WHERE p.id=:page_id ORDER BY time_from')
            ->bind(':page_id', $page_id);
        $result = $query->execute();
        return $result->as_array();
    }

    // objects
    public static function addClass($user_id, $data) {
        $data['time_from'] = date('H:i',strtotime($data['time_from']));
        $data['time_to'] = date('H:i',strtotime($data['time_to']));
        if($data['date_to'])
            $data['date_to'] = date('Y-m-d',strtotime($data['date_to']));
        else
            $data['date_to'] = NULL;
        if($data['date_from'])
            $data['date_from'] = date('Y-m-d',strtotime($data['date_from']));
        else
            $data['date_from'] = NULL;
        $data['room'] = '';
        $query = DB::query(Database::INSERT, 'INSERT INTO class (instructions,description,location_id,user_id,name,room,trainer_id,time_from,time_to,date_from,date_to,max,week,price) VALUES (:instructions,:description,:location_id,:user_id,:name,:room,:trainer_id,:time_from,:time_to,:date_from,:date_to,:max,:week,:price)')
            ->bind(':user_id', $user_id)
            ->bind(':location_id', $data['location_id'])
            ->bind(':name', $data['name'])
            ->bind(':description', $data['description'])
            ->bind(':instructions', $data['instructions'])
            ->bind(':room', $data['room'])
            ->bind(':trainer_id', $data['trainer_id'])
            ->bind(':time_from', $data['time_from'])
            ->bind(':time_to', $data['time_to'])
            ->bind(':date_from', $data['date_from'])
            ->bind(':date_to', $data['date_to'])
            ->bind(':max', $data['max'])
            ->bind(':week', $data['week'])
            ->bind(':price', $data['price']);
        $result = $query->execute();
    }

    public static function updateClass($user_id, $data) {
        $data['time_from'] = date('H:i',strtotime($data['time_from']));
        $data['time_to'] = date('H:i',strtotime($data['time_to']));
        if($data['date_to'])
            $data['date_to'] = date('Y-m-d',strtotime($data['date_to']));
        else
            $data['date_to'] = NULL;
        if($data['date_from'])
            $data['date_from'] = date('Y-m-d',strtotime($data['date_from']));
        else
            $data['date_from'] = NULL;
        $query = DB::query(Database::UPDATE, 'UPDATE class SET '.
            'name=:name,'.
            'location_id=:location_id,'.
            'room=:room,'.
            'trainer_id=:trainer_id,'.
            'time_from=:time_from,'.
            'time_to=:time_to,'.
            'date_from=:date_from,'.
            'date_to=:date_to,'.
            'max=:max,'.
            'week=:week,'.
            'price=:price '.
            'WHERE '.
            'id=:id and '.
            'user_id=:user_id')
            ->bind(':name', $data['name'])
            ->bind(':location_id', $data['location_id'])
            ->bind(':room', $data['room'])
            ->bind(':trainer_id', $data['trainer_id'])
            ->bind(':time_from', $data['time_from'])
            ->bind(':time_to', $data['time_to'])
            ->bind(':date_from', $data['date_from'])
            ->bind(':date_to', $data['date_to'])
            ->bind(':max', $data['max'])
            ->bind(':week', $data['week'])
            ->bind(':price', $data['price'])
            ->bind(':user_id', $user_id)
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('class', $data['id']));
    }

/*
    public static function deleteClass($user_id, $id) {
        self::deleteObj('class', $user_id, $id);
    }
*/

    public static function getClassObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('class', $id));
        if ($ret === null) {
            $factory = new Model_Class();
            $attrs = $factory->getObjById('class', $id);
            if ($attrs) {
                $ret = new Model_Class();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('class', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getClassObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Class();
        //$filter['user_id'] = $user_id;
        $attrs_set = $factory->getClassList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Class();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getFullName() {
        return $this->getAttr('name'). ' (CLASS #'.$this->getId().')';
    }

    public function getShortName() {
        return $this->getAttr('name');
    }

    public function getName() {
        return $this->getAttr('name');
    }

    public function getPrice() {
        return $this->getAttr('price');
    }

    public function getUserPrice() {
        if ($this->getAttr('price') == 0) {
            return __('FREE');
        } else {
            return '$'.number_format($this->getAttr('price'),2);
        }
    }


    public function getDateFromInSecs() {
        return strtotime(str_replace("/","-",$this->getDateFrom()));
    }

    public function getDateToInSecs() {
        return strtotime(str_replace("/","-",$this->getDateTo()));
    }

    public function getDateFrom() {
        return $this->getDateAttr('date_from');
    }

    public function getDateTo() {
        return $this->getDateAttr('date_to');
    }

    public function getTimeFrom() {
        return $this->getTimeAttr('time_from');
    }

    public function getTimeTo() {
        return $this->getTimeAttr('time_from');
    }

    public function getWeekdays() {
        $ret = '';
        $hash = $this->getWeekHash();
        for ($i = 1; $i <= 7; $i++) {
            if (isset($hash[$i])) {
                switch ($i) {
                case 1:
                    $day = 'Monday';
                    break;
                case 2:
                    $day = 'Tuesday';
                    break;
                case 3:
                    $day = 'Wednesday';
                    break;
                case 4:
                    $day = 'Thursday';
                    break;
                case 5:
                    $day = 'Friday';
                    break;
                case 6:
                    $day = 'Saturday';
                    break;
                case 7:
                    $day = 'Sunday';
                    break;
                }
                if ($ret != '') {
                    $ret .= ", ";
                }
                $ret .= $day;
            }
        }
        return $ret;
    }

    public function getDescription() {
        $ret = $this->getAttr('description');
        if (empty($ret)) {
            $ret = "-";
        }
        return $ret;
    }

    public function getInstructions() {
        $ret = $this->getAttr('instructions');
        if (empty($ret)) {
            $ret = "-";
        }
        return $ret;
    }

    public function getStatus() {
        return $this->getAttr('status');
    }

    public function getRoom() {
        return $this->getAttr('room');
    }

    public function getWeekHash() {
        $ret = array_flip(unserialize($this->getAttr('week')));
        return $ret;
    }

    public function getLocationObj() {
        return Model_Location::getLocationObjById($this->getAttr('location_id'));
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getTrainerObj() {
        $ret = Model_User::getUserObjById($this->getAttr('trainer_id'));
        return $ret;
    }

    public function getImageUrl() {
        $ret = self::DEFAULT_IMAGE;
        if ($this->isAttr('image')) {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('user_id')."/class/".$this->getAttr('image');
        }
        return $ret;
    }
}
