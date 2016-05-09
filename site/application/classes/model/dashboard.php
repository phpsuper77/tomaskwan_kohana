<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Dashboard extends Model_Base {

    public function getBookings($filter,$type=NULL) {
        $prequery = 'SELECT COUNT(*) AS bookings FROM booking AS b LEFT JOIN `order` AS o ON b.order_id = o.id WHERE (o.owner_id=:id OR b.trainer_id=:id)';
        if($type!=NULL)
        {
            $prequery .= ' AND b.type=:type';
        }

        if($filter['to'] && $filter['from'])
        {
            $prequery .= ' AND b.date BETWEEN \''.$filter['from'].'\' AND \''.$filter['to'].'\'';
        }
        if(!$filter['to'] && $filter['from'])
        {
            $prequery .= ' AND b.date >= \''.$filter['from'].'\'';
        }

        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':id', $filter['id'])
            ->bind(':type', $type);
        $result = $query->execute()->as_array(); 
        return $result[0];
    }

    public function getConnections($filter) {
        $prequery = 'SELECT c.*,u.name,u.avatar,p.route FROM connect AS c JOIN user AS u ON c.user_invite=u.id  JOIN page AS p ON p.user_id=c.user_invite WHERE c.user_id=:id';

        if($filter['to'] && $filter['from'])
        {
            $prequery .= ' AND c.date BETWEEN \''.$filter['from'].'\' AND \''.$filter['to'].'\'';
        }
        if(!$filter['to'] && $filter['from'])
        {
            $prequery .= ' AND c.date >= \''.$filter['from'].'\'';	
        }

        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':id', $filter['id']);
        $result = $query->execute(); 
        return $result->as_array();
    }	

    // object
    public static function getBookingObj($user_id, $filter, $type=NULL) {
        $ret = false;
        $factory = new Model_Dashboard();
        $attrs = $factory->getBookings($filter, $type);
        if (!$attrs) {
            $ret = new Model_Dashboard();
            $ret->setAttrs($attrs);
        }
        return $ret;
    }

    public static function getConnectionObjs($filter) {
        $ret = array();
        $factory = new Model_Dashboard();
        $attrs_set = $factory->getConnections($filter);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Dashboard();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getAccountCount() {
        $query = DB::query(Database::SELECT, 'SELECT COUNT(*) AS accounts FROM user');
        $result = $query->execute()->as_array(); 
        return $result[0];
    }	

    public static function getRevenueCount() {
        $query = DB::query(Database::SELECT, 'SELECT SUM(`sum`) AS revenue FROM invoice');
        $result = $query->execute()->as_array(); 
        return $result[0];
    }

}
