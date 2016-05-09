<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Staff extends Model_Base {

    private function getStaffList($filter, $skip = 0,$limit=10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'date';
        if(!$filter['order'])
            $filter['order'] = 'DESC';
        $prequery = 'SELECT * from staff where 1=1 ';
        if($filter['user_id']) {
            $prequery .= ' AND user_id="' . $filter['user_id'].'"';
        }
        if($filter['owner_id']) {
            $prequery .= ' AND owner_id="' . $filter['owner_id'].'"';
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        return $result->as_array();
    }

    public static function addStaff($user_id, $data) {
        if (!isset($data['date'])) {
            $data['date'] = date('Y-m-d H:i:s');
        }
        $query = DB::query(Database::INSERT, 'INSERT INTO staff (owner_id,user_id,date) VALUES (:owner_id,:user_id,:date)')
            ->bind(':owner_id', $user_id)
            ->bind(':user_id', $data['user_id'])
            ->bind(':date', $data['date']);
        $result = $query->execute();
    }

    public static function removeStaff($user_id, $data) {
        $query = DB::query(Database::DELETE, 'DELETE FROM staff WHERE owner_id = :owner_id AND user_id = :user_id')
            ->bind(':owner_id', $user_id)
            ->bind(':user_id', $data['user_id']);
        $result = $query->execute();
    }

    public function getStaffObjs($filter,$skip = 0,$limit=10000) {
        $ret = array();
        $factory = new Model_Staff();
        $attrs_set = $factory->getStaffList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Staff();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getHostObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

}
