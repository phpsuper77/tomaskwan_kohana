<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_AvailabilityTime extends Model_Base {

    public static function getTime($user_id,$owner_id,$day) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM availability_time WHERE user_id = :user_id AND owner_id = :owner_id AND day=:day')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id)
            ->bind(':day', $day);
        $result = $query->execute()->as_array();
        if(count($result) >0)
            return $result[0];
        else
            return FALSE;
    }

    // object
    public static function deleteTime($user_id, $owner_id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM availability_time WHERE user_id = :user_id AND owner_id=:owner_id')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('avaTime', $user_id.':'.$owner_id));
    }

    public static function addTime($user_id,$owner_id,$day,$time_from,$time_to,$time_custom) {
        $query = DB::query(Database::INSERT, 'INSERT INTO availability_time (user_id,owner_id,day,time_from,time_to,time_custom) '.
            ' VALUES (:user_id,:owner_id,:day,:time_from,:time_to,:time_custom)')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id)
            ->bind(':day', $day)
            ->bind(':time_custom', $time_custom)
            ->bind(':time_from', $time_from)
            ->bind(':time_to', $time_to);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('avaTime', $user_id.':'.$owner_id));
    }

    public function getTimeObjs($user_id, $owner_id) {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('avaTime', $user_id.':'.$owner_id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT, 'SELECT * FROM availability_time WHERE user_id = :user_id AND owner_id=:owner_id')
                        ->bind(':owner_id', $owner_id)
                        ->bind(':user_id', $user_id);
            $attrs_set = $query->execute()->as_array();
            foreach ($attrs_set as $attrs) {
                $obj = new Model_AvailabilityTime();
                $obj->setAttrs($attrs);
                $ret[] = $obj;
            }
            $cache->set(self::getCacheKey('avaTime', $user_id.':'.$owner_id), $ret);
        }
        return $ret;
    }

    public function getDay() {
        return $this->getAttr('day');
    }

    public function getTimeCustom() {
        return $this->getAttr('time_custom');
    }

    public function getTimeFrom() {
        return $this->getAttr('time_from');
    }

    public function getTimeTo() {
        return $this->getAttr('time_to');
    }

}
