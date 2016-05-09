<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Settings extends Model_Base {

    public static function updateSocial($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE setting SET facebook=:facebook,linkedin=:linkedin,pinterest=:pinterest,twitter=:twitter,google=:google WHERE user_id = :id')
            ->bind(':facebook', $data['facebook'])
            ->bind(':linkedin', $data['linkedin'])
            ->bind(':pinterest', $data['pinterest'])
            ->bind(':twitter', $data['twitter'])
            ->bind(':google', $data['google'])
            ->bind(':id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('setting', $user_id));
    }

    public static function updateSession($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE setting SET location_id=:location_id,session=:session, price=:price,excluded_dates=:excluded_dates WHERE user_id = :id')
            ->bind(':location_id', $data['location_id'])
            ->bind(':excluded_dates', $data['excluded_dates'])
            ->bind(':session', $data['session'])
            ->bind(':price', $data['price'])
            ->bind(':id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('setting', $user_id));
    }

    public static function updateSettings($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE setting SET profile_view=:profile_view,booking=:booking,free_pass=:free_pass,spec_offer=:spec_offer, email=:email, sms=:sms,job=:job,public=:public WHERE user_id = :id')
            ->bind(':profile_view', $data['profile_view'])
            ->bind(':booking', $data['booking'])
            ->bind(':free_pass', $data['free_pass'])
            ->bind(':spec_offer', $data['spec_offer'])
            ->bind(':email', $data['email'])
            ->bind(':sms', $data['sms'])
            ->bind(':job', $data['job'])
            ->bind(':public', $data['public'])
            ->bind(':id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('setting', $user_id));
    }

/*
    public function deleteSettings($user_id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM setting WHERE user_id = :user_id')
            ->bind(':user_id', $user_id);
        $result = $query->execute();
    }
*/

    public function getTime($user_id,$day) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM setting_time WHERE user_id = :user_id AND day=:day')
            ->bind(':user_id', $user_id)
            ->bind(':day', $day);
        $result = $query->execute()->as_array();
        if(count($result) >0)
            return $result[0];
        else
            return FALSE;
    }

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


    public static function getOpKey($user_id) {
        $billSettingObj = self::getBillingSettingObjById($user_id);
        $ret = false;
        if ($billSettingObj) {
            $ret = $billSettingObj->getAttr('op_key');
        }
        return $ret;
    }

    // object
    public static function deleteTime($user_id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM setting_time WHERE user_id = :user_id')
            ->bind(':user_id', $user_id);
        $result = $query->execute();
    }

    public static function addTime($user_id,$day,$time_from,$time_to,$time_custom) {
        $query = DB::query(Database::INSERT, 'INSERT INTO setting_time (user_id,day,time_from,time_to,time_custom) '.
            ' VALUES (:user_id,:day,:time_from,:time_to,:time_custom)')
            ->bind(':user_id', $user_id)
            ->bind(':day', $day)
            ->bind(':time_custom', $time_custom)
            ->bind(':time_from', $time_from)
            ->bind(':time_to', $time_to);
        $result = $query->execute();
    }

    public static function updateBillingSettings($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE setting_bill SET price_1=:price_1,price_3=:price_3,price_12=:price_12,period=:period,op_key=:op_key'.
            ' WHERE user_id = :user_id')
            ->bind(':user_id', $user_id)
            ->bind(':price_1', $data['price_1'])
            ->bind(':price_3', $data['price_3'])
            ->bind(':price_12', $data['price_12'])
            ->bind(':period', $data['period'])
            ->bind(':op_key', $data['op_key']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('billsetting', $user_id));
    }

    public static function checkNotify($user_id, $type) {
        $settingObj = self::getSettingObjById($user_id);
        if ($settingObj && $settingObj->getAttr($type) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function addBillingSettingObj($user_id) {
        $query = DB::query(Database::INSERT, 'INSERT INTO setting_bill (user_id,period)  VALUES (:user_id,\'1\')')
            ->bind(':user_id', $user_id);
        $result = $query->execute();
    }

    public function addSettingObj($user_id,$profile_view,$booking=NULL,$free_pass=NULL,$spec_offer=NULL,$email=1,$sms=1) {
        $query = DB::query(Database::INSERT, 'INSERT INTO setting (user_id,profile_view,booking,free_pass,spec_offer,email,sms) VALUES (:user_id,:profile_view,:booking,:free_pass,:spec_offer,:email,:sms)')
            ->bind(':user_id', $user_id)
            ->bind(':profile_view', $profile_view)
            ->bind(':booking', $booking)
            ->bind(':free_pass', $free_pass)
            ->bind(':spec_offer', $spec_offer)
            ->bind(':email', $email)
            ->bind(':sms', $sms);

        $result = $query->execute();
    }

    public static function getBillingSettingObjById($user_id) {
        if (empty($user_id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('billsetting', $user_id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT,'SELECT * FROM setting_bill WHERE user_id=:user_id')
                ->bind(':user_id', $user_id);
            $result = $query->execute();
            if (count($result) == 1) {
                $ret = new Model_Settings();
                $ret->setAttrs($result->as_array()[0]);
            }
            $cache->set(self::getCacheKey('billsetting', $user_id), $ret);
        }
        return $ret;
    }

    public static function getSettingObjById($user_id) {
        if (empty($user_id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('setting', $user_id));
        if ($ret === null) {
            $query = DB::query(Database::SELECT,'SELECT * FROM setting WHERE user_id=:user_id')
                ->bind(':user_id', $user_id);
            $result = $query->execute();
            if (count($result) == 1) {
                $ret = new Model_Settings();
                $ret->setAttrs($result->as_array()[0]);
                $cache->set(self::getCacheKey('setting', $user_id), $ret);
            }
        }
        return $ret;
    }

    public function isProfileView() {
        return ($this->getAttr('profile_view')==1);
    }

    public function isBooking() {
        return ($this->getAttr('booking')==1);
    }

    public function isFreePass() {
        return ($this->getAttr('free_pass')==1);
    }

    public function isSpecialOffer() {
        return ($this->getAttr('spec_offer')==1);
    }

    public function isEmail() {
        return ($this->getAttr('email')==1);
    }

    public function isSMS() {
        return ($this->getAttr('sms')==1);
    }

    public function isPublic() {
        return ($this->getAttr('public')==1);
    }

    public function isJob() {
        return ($this->getAttr('job')==1);
    }

    public function acceptSession() {
        return ($this->getAttr('price') > 0);
    }

    public function getSession() {
        return $this->getAttr('session');
    }

    public function getLocationId() {
        return $this->getAttr('location_id');
    }

    public function getLocationObj() {
        return Model_Location::getLocationObjById($this->getAttr('location_id'));
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

    public function getFacebook() {
        return $this->getAttr('facebook');
    }

    public function getLinkedIn() {
        return $this->getAttr('linkedin');
    }

    public function getPinterest() {
        return $this->getAttr('pinterest');
    }

    public function getTwitter() {
        return $this->getAttr('twitter');
    }

    public function getGoogle() {
        return $this->getAttr('google');
    }
}
