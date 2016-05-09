<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Specoffer extends Model_Base {

    const DEFAULT_IMAGE = 'https://placehold.it/320x320?text=no+image';

    const CATEGORY_ITEM = 'item';
    const CATEGORY_CLASS = 'class';

    public function getOfferList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'name';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT * FROM spec_offer WHERE owner_id=:owner_id';
        if($filter['switch'] == 'active')
        {
            $prequery .= ' AND active =\'1\'';	
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':owner_id', $filter['owner_id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }

    public function getOfferById($id) {
        $query = DB::query(Database::SELECT,'SELECT * FROM spec_offer WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }

    public function checkQuantity($id) {
        $query = DB::query(Database::SELECT,'SELECT COUNT(*) AS quant FROM booking WHERE type=\'specoffer\' AND offer_id=:offer_id')
            ->bind(':offer_id', $id);
        $result = $query->execute()->as_array();
        $ret = $result[0]['quant'];
        return $ret;
    }

    // objects
    public static function activeOffer($user_id, $id, $active) {
        $query = DB::query(Database::UPDATE, 'UPDATE spec_offer SET active=:active WHERE id = :id AND owner_id = :owner_id')
            ->bind(':id', $id)
            ->bind(':active', $active)
            ->bind(':owner_id', $user_id);
        $result = $query->execute(); 
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('offer', $id));
    }

/*
    public static function deleteOffer($user_id, $id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM spec_offer WHERE id = :id AND owner_id = :owner_id')
            ->bind(':id', $id)
            ->bind(':owner_id', $user_id);
        $result = $query->execute();
    }
*/

    public static function updateImage($user_id, $id,$image) {
        $query = DB::query(Database::UPDATE, 'UPDATE spec_offer SET image=:image WHERE id = :id AND owner_id=:owner_id')
            ->bind(':owner_id', $user_id)
            ->bind(':image', $image)
            ->bind(':id', $id);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('offer', $id));
    }

    public static function updateOffer($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE spec_offer SET name=:name,max=:max,date_to=:date_to,text=:text,price=:price WHERE id = :id AND owner_id=:owner_id')
            ->bind(':name', $data['name'])
            ->bind(':max', $data['max'])
            ->bind(':date_to', $data['date_to'])
            ->bind(':text', $data['text'])
            ->bind(':price', $data['price'])
            ->bind(':owner_id', $user_id)
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('offer', $data['id']));
    }

    public static function addOffer($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO spec_offer (owner_id,name,category,max,date_to,text,price,active) VALUES (:owner_id,:name,:category,:max,:date_to,:text,:price,\'0\')')
            ->bind(':owner_id', $user_id)
            ->bind(':name', $data['name'])
            ->bind(':category', $data['category'])
            ->bind(':max', $data['max'])
            ->bind(':date_to', $data['date_to'])
            ->bind(':text', $data['text'])
            ->bind(':price', $data['price']);

        $result = $query->execute();
        return $result[0];
    }

    public function getOfferObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Specoffer();
        $attrs_set = $factory->getOfferList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Specoffer();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getOfferObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('offer', $id));
        if ($ret === null) {
            $factory = new Model_Specoffer();
            $attrs_set = $factory->getOfferById($id);
            if (count($attrs_set) == 1) {
                $obj = new Model_Specoffer();
                $obj->setAttrs($attrs_set[0]);
                $ret = $obj;
                $cache->set(self::getCacheKey('offer', $id), $ret);
            }
        }
        return $ret;
    }

    public function getName() {
        return $this->getAttr('name') . ' (OFFER #'.$this->getId().')';
    }

    public function getTrainerObj() {
        return false;
    }

    public function getPrice() {
        return $this->getAttr('price');
    }

    public function getOwnerObj() {
        return Model_User::getUserObjById($this->getAttr('owner_id'));
    }

    public function getImageUrl() {
        $ret = self::DEFAULT_IMAGE;
        if ($this->isAttr('image')) {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('owner_id')."/specoffer/".$this->getAttr('image');
        }
        return $ret;
    }
}
