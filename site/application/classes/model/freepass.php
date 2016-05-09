<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Freepass extends Model_Base {

    public function getFreePassList($filter,$skip = 0,$limit = 10000) {

        if(!$filter['sort'])
            $filter['sort'] = 'fp.date';
        if(!$filter['order'])
            $filter['order'] = 'ASC';

        $prequery = 'SELECT fp.*,u.name,u.avatar,p.route FROM free_pass AS fp JOIN user AS u ON fp.user_id=u.id LEFT JOIN page AS p ON p.user_id=fp.user_id'.
            ' WHERE fp.owner_id=:owner_id';

        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';


        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':owner_id', $filter['owner_id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        return $result->as_array();

    }


    // objects
    public static function checkFreePass($user_id,$owner_id) {
        $query = DB::query(Database::SELECT, 'SELECT * from free_pass WHERE user_id=:user_id AND owner_id=:owner_id')
            ->bind(':user_id', $user_id)
            ->bind(':owner_id', $owner_id);
        $result = $query->execute()->as_array(); 
        if(count($result)>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public static function addFreePass($user_id, $data) {
        $date = date('Y-m-d H:i:s');
        $query = DB::query(Database::INSERT, 'INSERT INTO free_pass (user_id,owner_id,code,date) VALUES (:user_id,:owner_id,:code,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':code', $data['code'])
            ->bind(':date', $date);
        $result = $query->execute();
    }

    public static function getFreePassObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $filter['user_id'] = $user_id;
        $factory = new Model_Freepass();
        $attrs_set = $factory->getFreePassList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Freepass();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getOwnerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getAvatarUrl() {
        $ret = false;
        if ($this->isAttr('avatar') && $this->getAttr('avatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('user_id')."/avatar/".$this->getAttr('avatar');
        }
        return $ret;
    }
}
