<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Gallery extends Model_Base {

    public function getImage($user_id, $id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM gallery WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        return $result->as_array();
    }

    public function getImageList($user_id, $type) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM gallery WHERE user_id = :user_id AND type = :type ORDER BY date DESC')
            ->bind(':user_id', $user_id)
            ->bind(':type', $type);
        $result = $query->execute();
        return $result->as_array();
    }

    public function updateImage($data) {
        $query = DB::query(Database::UPDATE, 'UPDATE gallery SET title=:title, image=:image WHERE id = :id')
            ->bind(':title', $data['title'])
            ->bind(':image', $data['image'])
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('gallery', $data['id']));
    }

    // object
    public static function deleteImage($user_id, $id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM gallery WHERE id=:id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('gallery', $id));
    }	

    public static function addImage($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO gallery (user_id, title, type, image, date) VALUES (:user_id, :title, :type, :image, :date)')
            ->bind(':user_id', $user_id)
            ->bind(':title', $data['title'])
            ->bind(':type', $data['type'])
            ->bind(':image', $data['image'])
            ->bind(':date', $data['date']);

        $result = $query->execute();
        return $result[0];
    }

    public static function getImageObj($user_id, $id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('gallery', $id));
        if ($ret === null) {
            $factory = new Model_Gallery();
            $attrs_set = $factory->getImage($user_id, $id);
            if (count($attrs_set) == 1) {
                $ret = new Model_Gallery();
                $ret->setAttrs($attrs_set[0]);
                $cache->set(self::getCacheKey('gallery', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getImageObjs($user_id, $type) {
        $ret = array();
        $factory = new Model_Gallery();
        $attrs_set = $factory->getImageList($user_id, $type);
        foreach ($attrs_set as $attrs) {
            $gallery = new Model_Gallery();
            $gallery->setAttrs($attrs);
            $ret[] = $gallery;
        }
        return $ret;
    }

    public function getUserId() {
        return $this->getAttr('user_id');
    }

    public function getTitle() {
        return $this->getAttr('title');
    }

    public function getImageUrl() {
        $ret = false;
        if ($this->isAttr('image')) {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('user_id')."/gallery/".$this->getAttr('image');
        }
        return $ret;
    }
}
