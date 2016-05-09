<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Message extends Model_Base {

    public function getMessageList($user_id, $trash, $direction, $skip = 0, $limit = null, $check = null) {
        //$subquery = 'SELECT m.*, u.id AS user_id,u.name AS user_name,u.role,u.avatar,u.address,u.city,u.zip FROM message AS m LEFT JOIN user AS u';
        $subquery = 'SELECT m.* FROM message as m ';

/*
        if($direction == 'inbox') {
            $subquery .= ' ON m.user_from = u.id';
        }
        if($direction == 'sent') {
            $subquery .= ' ON m.user_to = u.id';
        }
        if($direction == 'trash') {
            $subquery .= ' ON m.user_from = u.id LEFT JOIN user AS uu ON m.user_to = uu.id';
        }
*/

        $subquery .= ' WHERE m.user_id=:user_id AND m.trash=:trash';

        if($direction == 'inbox') {
            $subquery .= ' AND m.user_to=:user_id';
        }
        if($direction == 'sent') {
            $subquery .= ' AND m.user_from=:user_id';
        }

        if($check != null) {
            $subquery .= ' AND m.check=:check';
        }

        $subquery .= ' ORDER BY id desc';

        if($limit != null) {
            $subquery .= ' LIMIT :skip,:limit';
        }	
        $query = DB::query(Database::SELECT,$subquery)
            ->bind(':user_id', $user_id)
            ->bind(':trash', $trash);

        if($check != null) {
            $query
                ->bind(':check', $check);
        }

        if($limit != null) {
            $query
                ->bind(':skip', $skip)
                ->bind(':limit', $limit);
        }
        $result = $query->execute();
        return $result;
    }

    public function getMessageById($id) {
        $subquery = 'SELECT * FROM message WHERE id = :id';
        $query = DB::query(Database::SELECT, $subquery)
            ->bind(':id', $id);

        $result = $query->execute(); 
        $ret = $result->as_array();
        return $ret;
    }


    public function getUncheckedMessage($user_id) {
        $subquery = 'SELECT * FROM message WHERE user_id=:user_id AND user_to=:user_id AND `check`=\'0\' AND trash=\'0\'';
        $query = DB::query(Database::SELECT,$subquery)
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        return $result;
    }

    // object
    public static function addMessage($user_id, $data) {
        $users = array($data['user_to'],$data['user_from']);
        $users = array_filter($users);
        foreach($users as $uid)
        {
            $query = DB::query(Database::INSERT, 
                'INSERT INTO message (user_id, date, user_to, user_from, email, name, text, params) VALUES (:user_id, :date, :user_to, :user_from, :email, :name, :text, :params)')
                ->bind(':user_id', $uid)
                ->bind(':date', $data['date'])
                ->bind(':user_to', $data['user_to'])
                ->bind(':user_from', $data['user_from'])
                ->bind(':email', $data['email'])
                ->bind(':name', $data['name'])
                ->bind(':params', $data['params'])
                ->bind(':text', $data['text']);
            $result = $query->execute();
        }
    }

    public static function checkMessage($user_id, $id) {
        $query = DB::query(Database::UPDATE, 'UPDATE message SET `check` = \'1\' WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('msg', $id));
    }

    public static function trashMessage($user_id, $id,$trash) {
        $query = DB::query(Database::UPDATE, 'UPDATE message SET trash=:trash WHERE id = :id AND user_id=:user_id')
            ->bind(':trash', $trash)
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('msg', $id));
    }

    public static function deleteMessage($user_id, $id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM message WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('msg', $id));
    }

    public static function getMessageObjById($user_id, $id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('msg', $id));
        if ($ret === null) {
            $factory = new Model_Message();
            $attrs_set = $factory->getMessageById($id);
            if (count($attrs_set) == 1) {
                $attrs  = $attrs_set[0];
                $ret = new Model_Message();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('msg', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getMessageObjs($user_id, $trash, $direction, $skip = 0, $limit = null, $check = null) {
        $ret = array();
        $factory = new Model_Message();
        $attrs_set = $factory->getMessageList($user_id, $trash, $direction, $skip, $limit, $check);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Message();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getUserToObj() {
        return Model_User::getUserObjById($this->getAttr('user_to'));
    }

    public function getUserFromObj() {
        return Model_User::getUserObjById($this->getAttr('user_from'));
    }

    public function getUserName() {
        return $this->getAttr('user_name');
    }

    public function getEmail() {
        return $this->getAttr('email');
    }

    public function getText() {
        return $this->getAttr('text');
    }

    public function getAddress() {
        return $this->getAttr('address');
    }

    public function getCity() {
        return $this->getAttr('city');
    }

    public function getZip() {
        return $this->getAttr('zip');
    }

    public function getParams() {
        return json_decode($this->getAttr('params'), true);
    }

    public function hasAction() {
        $params = $this->getParams();
        return isset($params['action_name']);
    }

    public function getActionName() {
        $params = $this->getParams();
        return $params['action_name'];
    }

    public function getActionLink() {
        $params = $this->getParams();
        return $params['action_link'];
    }

    public function getDate() {
        return date('j F Y',strtotime($this->getAttr('date')));
    }

    public function getAvatarUrl() {
        $ret = false;
        if ($this->isAttr('avatar') && $this->getAttr('avatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('user_id')."/avatar/".$this->getAttr('avatar');
        }
        return $ret;
    }

}
