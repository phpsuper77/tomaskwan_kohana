<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_SyncCities extends Minion_Task
{
    public function execute(array $params)
    {
        $query = DB::query(Database::SELECT, "SELECT city, lat, lon FROM user group by city");
        $result = $query->execute();
        foreach ($result->as_array() as $attrs) 
        {
            try {
                echo ucwords(strtolower($attrs['city'])) . " " . $attrs['lat']. " " . $attrs['lon']."\n";
                $insert = DB::query(Database::INSERT, "INSERT INTO cities (city, lat, lon) VALUES (:city, :lat, :lon)")
                    ->bind(':city', ucwords(strtolower($attrs['city'])))
                    ->bind(':lat', $attrs['lat'])
                    ->bind(':lon', $attrs['lon']);
                $result = $insert->execute();
            } catch (Exception $e) {
            }
        }
    }
}
