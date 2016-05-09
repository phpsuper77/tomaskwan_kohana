<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Status extends Model_Base {

    public function getStatusList($user_id) {

        $query = DB::query(Database::SELECT, 'SELECT s.*,u.name,p.route FROM status AS s LEFT JOIN user AS u ON s.share_id=u.id '.
            'LEFT JOIN page AS p ON p.user_id=s.share_id WHERE s.user_id=:user_id ORDER BY date DESC')
            ->bind(':user_id', $user_id);

        $result = $query->execute();
        return $result->as_array();
    }

    public function getCommentList($status_id) {

        $query = DB::query(Database::SELECT, 'SELECT c.*,u.name,u.avatar,u.id AS user_id FROM comment AS c JOIN user AS u ON u.id=c.user_id '.
            'WHERE c.status_id=:status_id ORDER BY date DESC')
            ->bind(':status_id', $status_id);

        $result = $query->execute();
        return $result->as_array();
    }


    public function getLikeList($item_id,$category) {

        $query = DB::query(Database::SELECT, 'SELECT u.name,p.route FROM user AS u JOIN `like` AS l ON u.id=l.user_id JOIN page as p ON p.user_id=u.id '.
            'WHERE l.item_id=:item_id AND l.category=:category')
            ->bind(':item_id', $item_id)
            ->bind(':category', $category);

        $result = $query->execute();
        return $result->as_array();
    }

    public function checkLike($user_id,$item_id,$category) {

        $query = DB::query(Database::SELECT, 'SELECT * FROM `like` WHERE user_id=:user_id AND item_id=:item_id AND category=:category')
            ->bind(':user_id', $user_id)
            ->bind(':item_id', $item_id)
            ->bind(':category', $category);

        $result = $query->execute();
        if(count($result) > 0)
            return TRUE;
        else
            return FALSE;
    }

    // objects
    public static function addLike($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO `like` (user_id,item_id,category,date) VALUES (:user_id,:item_id,:category,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':item_id', $data['item_id'])
            ->bind(':category', $data['category'])
            ->bind(':date', $data['date']);

        $result = $query->execute();		
    }

    public static function addComment($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO comment (status_id,user_id,text,date) VALUES (:status_id,:user_id,:text,:date)')
            ->bind(':status_id', $data['status_id'])
            ->bind(':user_id', $user_id)
            ->bind(':text', $data['text'])
            ->bind(':date', $data['date']);

        $result = $query->execute();	

        return $result[0];	
    }

    public static function deleteStatus($user_id, $id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM status WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
    }

    public static function updateStatusShare($user_id, $id) {
        $query = DB::query(Database::UPDATE, 'UPDATE status SET shares = shares+1 WHERE id = :id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();		
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('status', $id));
    }

    public static function updateStatus($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE status SET subject=:subject, text=:text WHERE id = :id AND user_id=:user_id')
            ->bind(':subject', $data['subject'])
            ->bind(':text', $data['text'])
            ->bind(':user_id', $user_id)
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('status', $data['id']));
    }

    public static function addStatus($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO status (user_id,date,subject,text,top_pic,share_id) VALUES (:user_id,:date,:subject,:text,:top_pic,:share_id)')
            ->bind(':user_id', $user_id)
            ->bind(':date', $data['date'])
            ->bind(':subject', $data['subject'])
            ->bind(':text', $data['text'])
            ->bind(':top_pic', $data['top_pic'])
            ->bind(':share_id', $data['share_id']);
        $result = $query->execute();
        return $result[0];
    }

    public static function getCommentObjById($user_id, $id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('comment', $id));
        if ($ret === null) {
            $factory = new Model_Status();
            $attrs_set = $factory->getCommentById($user_id, $id);
            if (count($attrs_set) > 0) {
                $obj = new Model_Status();
                $obj->setAttrs($attrs_set[0]);
                $ret = $obj;
                $cache->set(self::getCacheKey('comment', $id), $ret);
            }
        }
        return $ret;
    }

    private function getCommentById($user_id, $id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM comment WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        return $result->as_array();
    }

    public static function getStatusObjById($user_id, $id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('status', $id));
        if ($ret === null) {
            $factory = new Model_Status();
            $attrs_set = $factory->getStatusById($user_id, $id);
            if (count($attrs_set) > 0) {
                $obj = new Model_Status();
                $obj->setAttrs($attrs_set[0]);
                $ret = $obj;
                $cache->set(self::getCacheKey('status', $id), $ret);
            }
        }
        return $ret;
    }

    private function getStatusById($user_id, $id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM status WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        return $result->as_array();
    }

    public static function getStatusObjs($user_id) {
        $ret = array();
        $factory = new Model_Status();
        $attrs_set = $factory->getStatusList($user_id);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Status();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getText() {
        return $this->getAttr('text');
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getPicUrl() {
        $ret = false;
        if ($this->isAttr('top_pic')) {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('user_id')."/status/".$this->getAttr('top_pic');
        }
        return $ret;
    }
}
