<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Timesettings extends Model_Base {

    public function getTimeSettingObjs($user_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM setting_time WHERE user_id = :user_id')
            ->bind(':user_id', $user_id);
        $attrs_set = $query->execute()->as_array();
        foreach ($attrs_set as $attrs) {
            $obj = new Model_TimeSettings();
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
