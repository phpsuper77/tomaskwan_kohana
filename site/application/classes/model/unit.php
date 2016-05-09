<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Unit extends Model_Base {

    const TYPE_AMENITY = 'amenity';
    const TYPE_INTEREST = 'interest';
    const TYPE_MORTAR = 'mortar';
    const TYPE_PROFESSION = 'profession';

    public function getUnit($id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM unit WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        return $result->as_array();
    }
    public function getUnitList($type) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM unit WHERE type=:type ORDER BY name ASC')
            ->bind(':type', $type);
        $result = $query->execute();
        return $result->as_array();
    }

    // object
    public static function deleteUnit($user_id, $id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM unit WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute();
        $units =  $result->as_array();
        $unit = $units[0];

        $query = DB::query(Database::DELETE, 'DELETE FROM unit WHERE id = :id')
            ->bind(':id', $id);
        $result = $query->execute();

        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('unit', $unit['type']));
    }

    public static function addUnit($user_id, $data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO unit (type, name, class) VALUES (:type, :name, :class)')
            ->bind(':type', $data['type'])
            ->bind(':name', $data['name'])
            ->bind(':class', $data['class']);
        $result = $query->execute();
        $cache = Cache::instance();
        $ret = $cache->delete(self::getCacheKey('unit', $data['type']));
    }

    public static function updateUnit($user_id, $data) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM unit WHERE id=:id')
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $units =  $result->as_array();
        $unit = $units[0];

        $query = DB::query(Database::UPDATE, 'UPDATE unit SET name=:name, class=:class WHERE id = :id')
            ->bind(':name', $data['name'])
            ->bind(':class', $data['class'])
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $ret = $cache->delete(self::getCacheKey('unit', $unit['type']));
    }

    public static function getCityList() {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('city2', ''));
        if ($ret === null) {
            $query = DB::query(Database::SELECT, 'SELECT city from user where city<>"" and lat is NOT NULL group by city order by city asc');
            $result = $query->execute(); 
            $cities = $result->as_array();
            $ret = array();
            foreach ($cities as $city) {
                if (is_int($city)) {
                    continue;
                }
                $ret[] = ucwords($city['city']);
            }
            $cache->set(self::getCacheKey('city2', ''), $ret, 3600);
        }
        return $ret;
    }

    public static function getUnitObjById($id)
    {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('unitobj', $id));
        if ($ret === null) {
            $ret = array();
            $factory = new Model_Unit();
            $attrs_set = $factory->getUnit($id);
            if (count($attrs_set) == 1) {
                $obj = new Model_Unit();
                $obj->setAttrs($attrs_set[0]);
                $ret = $obj;
            }
            $cache->set(self::getCacheKey('unitobj', $id), $ret);
        }
        return $ret;
    }

    public static function getUnitObjs($type)
    {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('unit', $type));
        if ($ret === null) {
            $ret = array();
            $factory = new Model_Unit();
            $attrs_set = $factory->getUnitList($type);
            foreach ($attrs_set as $attrs) {
                $obj = new Model_Unit();
                $obj->setAttrs($attrs);
                $ret[] = $obj;
            }
            $cache->set(self::getCacheKey('unit', $type), $ret);
        }
        return $ret;
    }

    public function getUnitType()
    {
        return $this->getAttr('type');
    }

    public function getUnitClass()
    {
        return $this->getAttr('class');
    }
}
