<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Invite extends Model_Base {

    public function getInviteList($filter, $skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'id';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT * ';
        $prequery .= ' FROM invite ';
        $prequery .= ' WHERE invitation=0';
        if ($filter['user_id']) {
            $prequery .= ' AND user_id = '.$filter['user_id'];
        }
        if ($filter['user_invite']) {
            $prequery .= ' AND user_invite = '.$filter['user_invite'];
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute()->as_array(); 
        return $result;
    }

    public static function addInvite($user_id, $user_invite, $invitation, $date=false) {
        if (!$date) {
            $date = date('Y-m-d H:i:s');
        }
        $query = DB::query(Database::INSERT, 'INSERT INTO invite (user_id,user_invite,invitation,date) VALUES (:user_id,:user_invite,:invitation,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite)
            ->bind(':invitation', $invitation)
            ->bind(':date', $date);
        $result = $query->execute();
    }

    public static function isInvited($user_id, $user2) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM invite WHERE (user_id=:user1 AND user_invite=:user2) OR (user_id=:user2 AND user_invite=:user1) ')
            ->bind(':user1', $user_id)
            ->bind(':user2', $user2);
        $result = $query->execute()->as_array();
        if(count($result) > 0)
            return TRUE;
        else
            return FALSE;
    }

    public static function deleteInvite($user_id, $user_invite) {
        $query = DB::query(Database::UPDATE, 'DELETE FROM invite WHERE invitation=0 AND user_id=:user_id AND user_invite=:user_invite')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
    }

    public static function getInviteObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $ret = array();
        $attrs_set = self::getInviteList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Invite();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr("user_id"));
    }

    public function getInviteUserObj() {
        return Model_User::getUserObjById($this->getAttr("user_invite"));
    }
}
