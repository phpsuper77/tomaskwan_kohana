<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Model_Base extends Model {

    const MAX_ATTR_LEN = 25;

    protected $_attrs = array();

    public static function getObjById($table, $id) {
        $ret = false;
        $query = DB::query(Database::SELECT,'SELECT * FROM '.$table.' WHERE id=:id and deleted=0')
            ->bind(':id', $id);
        $result = $query->execute();
        if (count($result) == 1) {
            $ret = $result->as_array()[0];
        }
        return $ret;
    }

    public static function getObjs($table, $filter=false, $order=false, $limit=false) {
        $ret = false;
        $query = DB::query(Database::SELECT,'SELECT * FROM '.$table . ' WHERE deleted=0');
        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }

    public static function updateObjStatus($table, $user_id, $id, $status) {
        $query = DB::query(Database::DELETE, 'UPDATE '.$table.' set status=:status WHERE id=:id AND user_id=:user_id')
            ->bind(':status', $status)
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
    }

    public static function deleteObj($table, $user_id, $id) {
        $query = DB::query(Database::DELETE, 'UPDATE '.$table.' set deleted=1 WHERE id=:id AND user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
    }

    // attributes
    public function setAttrs($attrs) 
    {
        $this->_attrs = $attrs;
    }

    public function setAttr($name, $v) 
    {
        $this->_attrs[$name] = $v;
    }

    public function getAttrs() 
    {
        return $this->_attrs;
    }

    public function getAttr($name) 
    {
        return $this->_attrs[$name];
    }

    public function getTruncatedAttr($name, $len = self::MAX_ATTR_LEN) {
        return strlen($this->getAttr($name))>$len ? substr($this->getAttr($name), 0, $len) . '...' : $this->getAttr($name);
    }

    public function isAttr($name) 
    {
        return isset($this->_attrs[$name]) && $this->_attrs[$name] != '';
    }

    public function getId() {
        return $this->getAttr('id');
    }

    public function getName() {
        return ucwords($this->getAttr('name'));
    }

    public function getShortName() {
        return $this->getTruncatedName(30);
    }

    public function getTextAttr($name) {
        return nl2br($this->getAttr($name));
    }

    public function getTruncatedName($len = self::MAX_ATTR_LEN) {
        return strlen($this->getName())>$len ? substr($this->getName(), 0, $len) . '...' : $this->getName();
    }

    public function getCreatedAt() {
        return $this->getAttr('date');
    }

    public function getDateAttr($name) {
        return date('d/m/Y', strtotime($this->getAttr($name)));
    }

    public function getTimeAttr($name) {
        return date('H:i', strtotime($this->getAttr($name)));
    }

    public function getModifiedAt() {
        return $this->getAttr('modify_date');
    }

    // caching
    public static function getCacheKey($type, $id) {
        return $type.'v3-'.$id;
    }

    public static function getCacheTimeout() {
        return 60 * 60 * 24;
    }
}
