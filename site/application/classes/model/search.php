<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Search extends Model_Base {


    public function addSearch($speciality,$city=NULL) {
        $prequery = 'SELECT * FROM search WHERE speciality=:speciality';
        if($city!=NULL)
            $prequery .= ' AND city=\''.$city.'\'';

        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':speciality', $speciality);
        $result = $query->execute()->as_array();
        if(count($result)>0)
        {
            $query = DB::query(Database::UPDATE, 'UPDATE search SET number=number+1 WHERE id = :id')
                ->bind(':id', $result[0]['id']);	
        }
        else
        {
            $query = DB::query(Database::INSERT, 'INSERT INTO search (speciality,city) VALUES (:speciality,:city)')
                ->bind(':speciality', $speciality)
                ->bind(':city', $city);
        }		
        $result = $query->execute();
    }

    public function getSearch($city=FALSE) {
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('city1', $city));
        if ($ret === null) {
            $prequery = 'SELECT * FROM search';
            if($city==TRUE)
                $prequery .= ' WHERE city!=\'NULL\'';
            $prequery .= ' GROUP BY speciality ORDER BY number DESC LIMIT 5';
            $query = DB::query(Database::SELECT,$prequery);
            $result = $query->execute();
            $ret = $result->as_array();
            $cache->set(self::getCacheKey('city1', $city), $ret, 1800);
        }
        return $ret;
    }
}
