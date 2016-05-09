<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Review extends Model_Base {

    public function getReviewList($filter,$skip = 0,$limit=10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'date';
        if(!$filter['order'])
            $filter['order'] = 'DESC';
        $prequery = 'SELECT * FROM review AS r ';
        if($filter['user'] == TRUE) {
            $prequery .= ' WHERE r.user_id = :id';
        } else {
            $prequery .= ' WHERE r.owner_id = :id';
        }
/*
        $prequery = 'SELECT r.*,u.id AS uid,u.name,u.avatar,u.address,u.city,u.zip,p.route FROM review AS r ';
        if($filter['user'] == TRUE)
        {
            $prequery .= 'JOIN user AS u ON r.owner_id = u.id LEFT JOIN page AS p ON p.user_id=u.id WHERE r.user_id = :id';
        }
        else
        {
            $prequery .= 'JOIN user AS u ON r.user_id = u.id LEFT JOIN page AS p ON p.user_id=u.id WHERE r.owner_id = :id';
        }
*/
        if($filter['check'] == TRUE)
            $prequery .= ' AND r.check=\'0\'';
        if(isset($filter['to']) && isset($filter['from']))
            $prequery .= ' AND r.date BETWEEN \''.$filter['from'].'\' AND \''.$filter['to'].'\'';
        if(isset($filter['from']))
            $prequery .= ' AND r.date >= \''.$filter['from'].'\'';	
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':id', $filter['id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        return $result->as_array();
    }

    private static function getReviewById($id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM review WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        $items = $result->as_array();
        $ret = false; 
        if(count($items) > 0) {
            $ret = $items[0];
        }
        return $ret;
    }
    private static function getReview($user_id,$owner_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM review WHERE user_id=:user_id AND owner_id=:owner_id')
            ->bind(':user_id', $user_id)
            ->bind(':owner_id', $owner_id);

        $result = $query->execute();
        $items = $result->as_array();
        $ret = false; 
        if(count($items) > 0) {
            $ret = $items[0];
        }
        return $ret;
    }

    public function checkReview($user_id,$owner_id) {
        $review = self::getReview($user_id, $owner_id);
        if($review) {
            return true;
        } else {
            return false;
        }
    }

/*
    public function getNotes($owner_id) {
        $query = DB::query(Database::SELECT, 'SELECT AVG(facility) AS facility, AVG(service) AS service, AVG(clean) AS clean, AVG(vibe) AS vibe,'.
            'AVG(knowledge) AS knowledge, AVG(`like`) AS `like`, AVG(global) AS global FROM review WHERE owner_id=:owner_id')
            ->bind(':owner_id', $owner_id);

        $result = $query->execute()->as_array();
        return $result;
    }
*/

    // object
    public static function cancelReview($user_id, $id) {
        $review = self::getReviewByid($id);
        $query = DB::query(Database::DELETE, 'DELETE FROM review WHERE id = :id AND user_id = :user_id')
            ->bind(':id', $id)
            ->bind(':user_id', $user_id);
        $result = $query->execute();
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('rating', $review['owner_id']));

        // update owner's rating
        $ownerObj = Model_User::getUserObjById($review['owner_id']);
        if ($ownerObj) {
            $rating = Model_Rating::getRatingObjById($ownerObj->getId());
            Model_User::updateRating($ownerObj->getId(), $rating->getGlobal());
        }
    }

    public static function trashReview($user_id, $id) {
        $review = self::getReviewByid($id);
        $query = DB::query(Database::UPDATE, 'UPDATE review SET `check` = \'1\' WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('rating', $review['owner_id']));

        // update owner's rating
        $ownerObj = Model_User::getUserObjById($review['owner_id']);
        if ($ownerObj) {
            $rating = Model_Rating::getRatingObjById($ownerObj->getId());
            Model_User::updateRating($ownerObj->getId(), $rating->getGlobal());
        }
    }

    public static function addReview($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO review (owner_id,user_id,facility,service,clean,vibe,knowledge,`like`,global,text,`date`,`check`) VALUES (:owner_id,:user_id,:facility,:service,:clean,:vibe,:knowledge,:like,:global,:text,:date,\'0\')')
            ->bind(':owner_id', $data['owner_id'])
            ->bind(':user_id', $user_id)
            ->bind(':facility', $data['facility'])
            ->bind(':service', $data['service'])
            ->bind(':clean', $data['clean'])
            ->bind(':vibe', $data['vibe'])
            ->bind(':knowledge', $data['knowledge'])
            ->bind(':like', $data['like'])
            ->bind(':global', $data['global'])
            ->bind(':text', $data['text'])
            ->bind(':date', $data['date']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('rating', $data['owner_id']));

        // update owner's rating
        $ownerObj = Model_User::getUserObjById($data['owner_id']);
        if ($ownerObj) {
            $rating = Model_Rating::getRatingObjById($ownerObj->getId());
            Model_User::updateRating($ownerObj->getId(), $rating->getGlobal());
        }
    }

/*
    public function getNoteObjs($owner_id) {
        $ret = array();
        $factory = new Model_Review();
        $attrs_set = $factory->getNotes($owner_id);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Review();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
*/

    public function getReviewObjs($filter,$skip = 0,$limit=10000) {
        $ret = array();
        $factory = new Model_Review();
        $attrs_set = $factory->getReviewList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Review();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getName() {
        return $this->getAttr('name');
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getOwnerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getText() {
        return $this->getAttr('text');
    }

/*
    public function getAvatarImageUrl() {
        $ret = false;
        if ($this->isAttr('avatar') && $this->getAttr('avatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('uid')."/avatar/".$this->getAttr('avatar');
        } else {
            $ret = IMG.'logo_avatar.png';
        }
        return $ret;
    }

    public function getAvatarUrl() {
        $ret = false;
        if ($this->isAttr('avatar') && $this->getAttr('avatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('uid')."/avatar/".$this->getAttr('avatar');
        }
        return $ret;
    }
*/
}
