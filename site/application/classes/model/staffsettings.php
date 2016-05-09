<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_StaffSettings extends Model_Base {

    public static function updateStaffSetting($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE staff_setting SET enabled=:enabled,room=:room,session=:session, price=:price,excluded_dates=:excluded_dates WHERE user_id = :user_id AND owner_id=:owner_id')
            ->bind(':enabled', $data['enabled'])
            ->bind(':room', $data['room'])
            ->bind(':excluded_dates', $data['excluded_dates'])
            ->bind(':session', $data['session'])
            ->bind(':price', $data['price'])
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('staffsetting', $user_id.":".$data['owner_id']));
    }

    public function addStaffSettingObj($user_id,$data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO staff_setting (user_id,owner_id,session,price,excluded_dates,room,enabled) values (:user_id,:owner_id,:session,:price,:excluded_dates,:room,:enabled)')
            ->bind(':user_id', $user_id)
            ->bind(':enabled', $data['enabled'])
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':session', $data['session'])
            ->bind(':price', $data['price'])
            ->bind(':excluded_dates', $data['excluded_dates'])
            ->bind(':room', $data['room']);
        $result = $query->execute();
    }

    public static function getStaffSettingObjById($user_id, $owner_id) {
        if (empty($user_id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('staffsetting', $user_id.":".$owner_id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT,'SELECT * FROM staff_setting WHERE user_id=:user_id AND owner_id=:owner_id')
                ->bind(':owner_id', $owner_id)
                ->bind(':user_id', $user_id);
            $result = $query->execute();
            if (count($result) == 1) {
                $ret = new Model_StaffSettings();
                $ret->setAttrs($result->as_array()[0]);
                $cache->set(self::getCacheKey('staffsetting', $user_id.":".$owner_id), $ret);
            }
        }
        return $ret;
    }

    public function isEnabled() {
        return $this->getAttr('enabled') == 1;
    }

    public function acceptSession() {
        return ($this->getAttr('price') > 0);
    }

    public function getSession() {
        return $this->getAttr('session');
    }

    public function getRoom() {
        return $this->getAttr('room');
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
