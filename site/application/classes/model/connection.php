<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Connection extends Model_Base {

    private static function _getConnectionList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'id';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'DESC';
        }
        $prequery = 'SELECT * FROM connect ';
        $prequery .= ' WHERE 1=1';
        $prequery .= ' AND (user_id = '.$filter['id'].' OR user_invite = '.$filter['id'].') ';
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute()->as_array(); 
        return $result;
    }

    public static function getConnectionObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $ret = array();
        $attrs_set = self::_getConnectionList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Connection();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function deleteConnection($user_id, $user_invite) {
error_log("XXX delete user_id=$user_id user_invite=$user_invite");
        $query = DB::query(Database::UPDATE, 'DELETE FROM connect WHERE user_id=:user_id AND user_invite=:user_invite')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
        $query = DB::query(Database::UPDATE, 'DELETE FROM connect WHERE user_id=:user_invite AND user_invite=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
    }

    public static function addConnection($user_id, $user_invite) {
        $date = date('Y-m-d H:i:s');
        $query = DB::query(Database::INSERT, 'INSERT INTO connect (user_id,user_invite,date) VALUES (:user_id,:user_invite,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite)
            ->bind(':date', $date);
        $result = $query->execute();
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr("user_id"));
    }

    public function getInviteUserObj() {
        return Model_User::getUserObjById($this->getAttr("user_invite"));
    }
}
