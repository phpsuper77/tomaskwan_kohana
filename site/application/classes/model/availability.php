<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Availability extends Model_Base {

    const TYPE_TOUR = 1;
    const TYPE_SESSION = 2;

    public static function getAvailabilityList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'id';
        if(!$filter['order'])
            $filter['order'] = 'ASC';
        $prequery = 'SELECT * FROM availability WHERE user_id=:user_id';
        if($filter['search'])
            $prequery .= ' AND name LIKE %'.$filter['search'].'% ';
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':user_id', $filter['user_id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        return $result->as_array();
    }

    public static function updateAvailability($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE availability SET type=:type,status=:status,location_id=:location_id,session=:session, price=:price,owner_id=:owner_id,excluded_dates=:excluded_dates WHERE user_id = :user_id AND id=:id')
            ->bind(':status', $data['status'])
            ->bind(':type', $data['type'])
            ->bind(':location_id', $data['location_id'])
            ->bind(':excluded_dates', $data['excluded_dates'])
            ->bind(':session', $data['session'])
            ->bind(':price', $data['price'])
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':id', $data['id'])
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('available', $data['id']));
    }

    public function addAvailability($user_id,$data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO availability (user_id,owner_id,session,price,excluded_dates,location_id,status,type) values (:user_id,:owner_id,:session,:price,:excluded_dates,:location_id,:status,:type)')
            ->bind(':user_id', $user_id)
            ->bind(':status', $data['status'])
            ->bind(':type', $data['type'])
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':session', $data['session'])
            ->bind(':price', $data['price'])
            ->bind(':excluded_dates', $data['excluded_dates'])
            ->bind(':location_id', $data['location_id']);
        $result = $query->execute();
    }

    public static function getAvailabilityObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('available', $id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT,'SELECT * FROM availability WHERE id=:id')
                ->bind(':id', $id);
            $result = $query->execute();
            if (count($result) == 1) {
                $ret = new Model_Availability();
                $ret->setAttrs($result->as_array()[0]);
                $cache->set(self::getCacheKey('available', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getAvailabilityObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Availability();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getAvailabilityList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Availability();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function isEnabled() {
        return $this->getAttr('enabled') == 1;
    }

    public function acceptSession() {
        return ($this->getAttr('price') > 0);
    }

    public function getLocationObj() {
        return Model_Location::getLocationObjById($this->getAttr('location_id'));
    }

    public function getOwnerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getAvailabilityType() {
        return $this->getAttr('type');
    }

    public function getSession() {
        return $this->getAttr('session');
    }

    public function getRoom() {
        return $this->getAttr('room');
    }

    public function getStatus() {
        return $this->getAttr('status');
    }

    public function getExcludedDates() {
        $ret = array();
        $dates = explode(",",$this->getAttr('excluded_dates'));
        foreach ($dates as $date) {
            $d = date('Y-m-d', strtotime(trim($date)));
            $ret[] = $d;
        }
        return $ret;
    }

    public function getPrice() {
        return $this->getAttr('price');
    }

}
