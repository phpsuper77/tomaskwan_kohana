<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_StaffTimeSettings extends Model_Base {

    public static function getTime($user_id,$owner_id,$day) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM staff_setting_time WHERE user_id = :user_id AND owner_id = :owner_id AND day=:day')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id)
            ->bind(':day', $day);
        $result = $query->execute()->as_array();
        if(count($result) >0)
            return $result[0];
        else
            return FALSE;
    }

/*
    public function getMaxTime($user_id) {
        $query = DB::query(Database::SELECT, 'SELECT max(time_to) AS max FROM setting_time WHERE user_id = :user_id')
            ->bind(':user_id', $user_id);
        $result = $query->execute()->as_array();
        return $result[0]['max'];
    }

    public function getMinTime($user_id) {
        $query = DB::query(Database::SELECT, 'SELECT min(time_from) AS min FROM setting_time WHERE user_id = :user_id')
            ->bind(':user_id', $user_id);

        $result = $query->execute()->as_array();

        return $result[0]['min'];
    }

    public function checkTime($user_id,$time=NULL,$day=NULL) {
        $prequery = 'SELECT * FROM setting_time WHERE user_id = :user_id';
        if($time!=NULL && $day!=NULL)
            $prequery .= ' AND day=\''.$day.'\' AND \''.$time.'\'>=time_from AND \''.$time.'\'<=time_to';

        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':user_id', $user_id);
        $result = $query->execute()->as_array();
        if(count($result) >0)
            return TRUE;
        else
            return FALSE;
    }
*/


    // object
    public static function deleteTime($user_id, $owner_id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM staff_setting_time WHERE user_id = :user_id AND owner_id=:owner_id')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id);
        $result = $query->execute();
    }

    public static function addTime($user_id,$owner_id,$day,$time_from,$time_to,$time_custom) {
        $query = DB::query(Database::INSERT, 'INSERT INTO staff_setting_time (user_id,owner_id,day,time_from,time_to,time_custom) '.
            ' VALUES (:user_id,:owner_id,:day,:time_from,:time_to,:time_custom)')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id)
            ->bind(':day', $day)
            ->bind(':time_custom', $time_custom)
            ->bind(':time_from', $time_from)
            ->bind(':time_to', $time_to);
        $result = $query->execute();
    }

    public function getStaffTimeSettingObjs($user_id, $owner_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM staff_setting_time WHERE user_id = :user_id AND owner_id=:owner_id')
            ->bind(':owner_id', $owner_id)
            ->bind(':user_id', $user_id);
        $attrs_set = $query->execute()->as_array();
        foreach ($attrs_set as $attrs) {
            $obj = new Model_StaffTimeSettings();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
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
