<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Directory extends Model_Base {

    public function getDirectoryListCount($filter) {
        $prequery = 'SELECT COUNT(*) as c FROM user AS u '.
            'WHERE u.role != \'0\' AND u.enabled = \'1\'';

        if($filter['role']==Model_User::ROLE_USER)
        {
            $prequery .= ' AND u.role = \'4\'';	
        }
        elseif($filter['role']==2)
        {
            $prequery .= ' AND u.role = \'2\'';
        }
        else
        {
            $prequery .= ' AND u.role != \'4\'';
        }

        if($filter['city'])
        {
            $prequery .= ' AND u.city = \''.$filter['city'].'\'';	
        }
        if($filter['amenity'])
        {
            $prequery .= ' AND u.unit = \'%:'.$filter['amenity'].';%\'';	
        }
        if($filter['title'])
        {
            $prequery .= ' AND u.title = \''.$filter['title'].'\'';	
        }

        if($filter['name'])
        {
            $prequery .= ' AND u.name LIKE \''.$filter['name'].'%\'';	
        }

        if ($filter['distance']) {
            $prequery .= ' AND ((6373 * acos(cos(radians(' . $filter['lat']. ')) * cos (radians(lat)) * cos (radians(lon) - radians(' .$filter['lon'].')) + sin(radians('.$filter['lat'].')) * sin(radians(lat)))) < '. $filter['distance'].')';	
        }

        $query = DB::query(Database::SELECT, $prequery);
        $result = $query->execute()->as_array(); 
        return $result[0]['c'];
    }

    public function getDirectoryList($filter, $skip = 0,$limit = 10000) {
        $prequery = 'SELECT u.* ';
        if ($filter['lat']) {
            $prequery .= ', (6373 * acos(cos(radians(' . $filter['lat']. ')) * cos (radians(lat)) * cos (radians(lon) - radians(' .$filter['lon'].')) + sin(radians('.$filter['lat'].')) * sin(radians(lat)))) as distance ';
        }
        $prequery .= ' FROM user AS u '.
                    'WHERE u.role != \'0\' AND u.enabled = \'1\'';

        if($filter['role']==Model_User::ROLE_USER)
        {
            $prequery .= ' AND u.role = \'4\'';	
        }
        elseif($filter['role']==2)
        {
            $prequery .= ' AND u.role = \'2\'';
        }
        else
        {
            $prequery .= ' AND u.role != \'4\'';
        }

        if($filter['city'])
        {
            $prequery .= ' AND u.city = \''.$filter['city'].'\'';	
        }

        if($filter['title'])
        {
            $prequery .= ' AND u.title = \''.$filter['title'].'\'';	
        }
        if($filter['amenity'])
        {
            $prequery .= ' AND u.unit = \'%:'.$filter['amenity'].';%\'';	
        }

        if($filter['name'])
        {
            $prequery .= ' AND u.name LIKE \''.$filter['name'].'%\'';	
        }
        if($filter['distance'])
        {
            $prequery .= ' HAVING distance < "' . $filter['distance'] .'"';
        }
    
        if ($filter['sort'] == 'name') {
            $prequery .= ' ORDER BY u.name ASC';
        } else if ($filter['sort'] == 'distance') {
            $prequery .= ' ORDER BY distance ASC';
        } else if ($filter['sort'] == 'role') {
            $prequery .= ' ORDER BY u.role ASC';
        } else if ($filter['sort'] == 'rating') {
            $prequery .= ' ORDER BY u.rating ASC';
        } else {
            $prequery .= ' ORDER BY u.name ASC, u.rating DESC';
        }

        $prequery .= ' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute()->as_array(); 
        return $result;
    }

    public static function getDirectoryObjCount($filter) {
        $factory = new Model_Directory();
        return $factory->getDirectoryListCount($filter);
    }

    public static function getDirectoryObjs($filter, $skip = 0, $limit = 10000) {
        $ret = array();
        $factory = new Model_Directory();
        $attrs_set = $factory->getDirectoryList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Directory();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getDistance() {
        return round($this->getAttr('distance'));
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('id'));
    }
}
