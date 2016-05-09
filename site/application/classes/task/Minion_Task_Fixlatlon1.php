<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Fixlatlon1 extends Minion_Task
{
    public function execute(array $params)
    {

	$query = DB::query(Database::SELECT, "SELECT * FROM user WHERE id=12853 and geo_date is NULL");
	$result = $query->execute();
	foreach ($result->as_array() as $attrs) 
	{
        $ret = Geocodio::lookup($attrs['address'], $attrs['city'], '', $attrs['zip']);
        if (isset($ret['results'][0]['location'])) {
            $gcode['state'] = $ret['results'][0]['address_components']['state'];
            $gcode['lat'] = $ret['results'][0]['location']['lat'];
            $gcode['lon'] = $ret['results'][0]['location']['lng'];

            echo json_encode($ret) . "\n";

			$update = DB::query(Database::UPDATE, 'UPDATE user SET geo_date=:geo_date, state=:state, lat=:lat, lon=:lon WHERE id = :id')
					    ->bind(':geo_date', date('Y-m-d H:i:s'))
					    ->bind(':state', $gcode['state'])
					    ->bind(':lat', $gcode['lat'])
					    ->bind(':lon', $gcode['lon'])
				        ->bind(':id', $attrs['id']);
            $status = $update->execute();
		} else {
			$update = DB::query(Database::UPDATE, 'UPDATE user SET geo_date=:geo_date WHERE id = :id')
					    ->bind(':geo_date', date('Y-m-d H:i:s'))
				        ->bind(':id', $attrs['id']);
            $status = $update->execute();
        }
	}
    }
}
