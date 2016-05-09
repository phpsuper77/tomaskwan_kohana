<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_MyOffer extends Model_Base {

    const DEFAULT_IMAGE = 'https://placehold.it/320x320?text=no+image';

    public function getMyOfferList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'name';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $query = 'SELECT order_item.order_id,order_item.id as order_item_id, spec_offer.* FROM order_item '.
                    'join spec_offer on (spec_offer.id=order_item.object_id) WHERE '.
                    'order_item.type="specoffer" AND order_item.user_id=:user_id AND '.
                    'order_item.status='.Model_Orderitem::STATUS_PAID;
        if($filter['switch'] == 'active')
        {
            $query .= ' AND active =\'1\'';	
        }
        $query .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $query)
            ->bind(':user_id', $filter['user_id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }

    public static function getMyOfferObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_MyOffer();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getMyOfferList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_MyOffer();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getMyOfferObjById($user_id, $id) {
        $query = 'SELECT order_item.order_id,order_item.id as order_item_id, spec_offer.* FROM order_item '.
                    'join spec_offer on (spec_offer.id=order_item.object_id) WHERE '.
                    'order_item.type="specoffer" AND order_item.id=:id AND order_item.user_id=:user_id AND '.
                    'order_item.status='.Model_Orderitem::STATUS_PAID;
        $query = DB::query(Database::SELECT,$query)
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
        $ret = $result->as_array();
        $obj = false;
        if (count($ret) == 1) {
            $obj = new Model_MyOffer();
            $obj->setAttrs($ret[0]);
        }
        return $obj;
    }

    public function getId() {
        return $this->getAttr('order_item_id');
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
