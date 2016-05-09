<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Location extends Model_Base {

    const STATUS_INACTIVE = '0';
    const STATUS_ACTIVE = '1';

    public function getLocationList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'id';
        if(!$filter['order'])
            $filter['order'] = 'ASC';
        if(!$filter['from'])
            $filter['from'] = date('Y-m-d',strtotime('-14 days'));

        $prequery = 'SELECT * FROM location as b WHERE deleted=0';

        if(isset($filter['user_id']))
            $prequery .= ' AND b.user_id = \''.$filter['user_id'].'\'';

        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        return $result->as_array();

    }

    public static function addLocation($user_id, $data) {
        $date = date('Y-m-d H:i:s');
        $query = DB::query(Database::INSERT, 'INSERT INTO location (name,user_id,room,address,city,state,zip,note,date) VALUES (:name,:user_id,:room,:address,:city,:state,:zip,:note,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':name', $data['name'])
            ->bind(':room', $data['room'])
            ->bind(':address', $data['address'])
            ->bind(':city', $data['city'])
            ->bind(':state', $data['state'])
            ->bind(':zip', $data['zip'])
            ->bind(':note', $data['note'])
            ->bind(':date', $date);
        $result = $query->execute();
        return $result[0];
    }

    public static function updateStatus($user_id, $id, $status) {
        self::updateObjStatus('location', $user_id, $id, $status);
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('location', $id));
    }

/*
    public static function deleteLocation($user_id, $id) {
        // TODO - check if we have references
        self::deleteObj('location', $user_id, $id);
        return true;
    }
*/

    public static function getLocationObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Location();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getLocationList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Location();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getLocationObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('location', $id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT,'SELECT * FROM location WHERE id=:id AND deleted=0')
                ->bind(':id', $id);
            $result = $query->execute();
            $list = $result->as_array();
            if (count($list) == 1) {
                $ret = new Model_Location();
                $ret->setAttrs($list[0]);
                $cache->set(self::getCacheKey('location', $id), $ret);
            }
        }
        return $ret;
    }

    public function getFullName() {
        return $this->getRoom() . ' - ' . $this->getAddress() .', '. $this->getCity();
    }

    public function getShortName() {
        return $this->getCity();
    }

    public function getStatus() {
        return $this->getAttr('status');
    }

    public function getRoom() {
        return $this->getAttr('room');
    }

    public function getAddress() {
        return $this->getAttr('address');
    }

    public function getCity() {
        return $this->getAttr('city');
    }

    public function getState() {
        return $this->getAttr('state');
    }

    public function getZip() {
        return $this->getAttr('zip');
    }

    public function getPhone() {
        return $this->getAttr('note');
    }

    public function getNote() {
        return $this->getAttr('note');
    }
}
