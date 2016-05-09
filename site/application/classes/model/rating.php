<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Rating extends Model_Base {

    private static function getRatings($owner_id) {
        $query = DB::query(Database::SELECT, 'SELECT AVG(facility) AS facility, '.
            'AVG(service) AS service, AVG(clean) AS clean, AVG(vibe) AS vibe,'.
            'AVG(knowledge) AS knowledge, AVG(`like`) AS `like`, AVG(global) AS global '.
            'FROM review WHERE owner_id=:owner_id')
            ->bind(':owner_id', $owner_id);
        $result = $query->execute()->as_array();
        return $result;
    }

    public static function getRatingObjById($owner_id) {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('rating', $owner_id));
        if ($ret === null) {
            $attrs_set = self::getRatings($owner_id);
            if (count($attrs_set) == 1) {
                $obj = new Model_Rating();
                $obj->setAttrs($attrs_set[0]);
                $ret = $obj;
                $cache->set(self::getCacheKey('rating', $owner_id), $ret);
            }
        }
        return $ret;
    }

    public function getFacility() {
        return round($this->getAttr('facility'));
    }

    public function getService() {
        return round($this->getAttr('service'));
    }

    public function getClean() {
        return round($this->getAttr('clean'));
    }

    public function getVibe() {
        return round($this->getAttr('vibe'));
    }

    public function getKnowledge() {
        return round($this->getAttr('knowledge'));
    }

    public function getLike() {
        return round($this->getAttr('like'));
    }

    public function getGlobal() {
        return round($this->getAttr('global'));
    }

}
