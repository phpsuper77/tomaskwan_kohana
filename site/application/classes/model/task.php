<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Task extends Model_Base {

    const TYPE_IMPORT = 'import';

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in-progress';
    const STATUS_ERROR = 'error';
    const STATUS_COMPLETE = 'complete';

    public static function addTask($user_id, $type, $status, $params) {
        $query = DB::query(Database::INSERT, 'INSERT INTO tasks (user_id,type,status,params,date,modify_date) VALUES (:user_id,:type,:status,:params,:date,:modify_date)')
            ->bind(':user_id', $user_id)
            ->bind(':status', $status)
            ->bind(':date', date('Y-m-d H:i:s'))
            ->bind(':modify_date', date('Y-m-d H:i:s'))
            ->bind(':params', $params)
            ->bind(':type', $type);
        $result = $query->execute();
        return $result[0];
    }

    public static function _updateMsg($id, $msg, $status) {
        $query = DB::query(Database::UPDATE, 'UPDATE tasks set status=:status, msg=:msg, modify_date=:modify_date where id=:id')
            ->bind(':msg', $msg)
            ->bind(':status', $status)
            ->bind(':modify_date', date('Y-m-d H:i:s'))
            ->bind(':id', $id);
        $result = $query->execute();
    }

    public function updateMsg($msg, $status) {
        self::_updateMsg($this->getId(), $msg, $status);
    }

    public function getTaskList($filter, $skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'id';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'DESC';
        }
        $prequery = 'SELECT * FROM tasks WHERE 1=1';
        if(isset($filter['status']))
        {
            $prequery .= ' AND status=\''.$filter['status'].'\'';
        }
        if(isset($filter['type']))
        {
            $prequery .= ' AND type=\''.$filter['type'].'\'';
        }
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute();
        $ret = $result->as_array();
        return $ret;
    }

    public static function getTaskObjs($filter=array(), $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Task();
        $attrs_set = $factory->getTaskList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Task();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }

    public function getStatus() {
        return $this->getAttr('status');
    }

    public function getTaskType() {
        return $this->getAttr('type');
    }

    public function getMsg() {
        return $this->getAttr('msg');
    }
    public function getParams() {
        return json_decode($this->getAttr('params'),true);
    }

}
