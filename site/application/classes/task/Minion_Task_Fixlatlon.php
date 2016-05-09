<?php defined('SYSPATH') or die('No direct script access.');

require_once(APPPATH.'../resources/functions/GoogleMap.php');
 
class Minion_Task_Fixlatlon extends Minion_Task
{
    public function execute(array $params)
    {

	$MAP_OBJECT = new GoogleMapAPI();

	$query = DB::query(Database::SELECT, "SELECT * FROM user");
	$result = $query->execute();
	foreach ($result->as_array() as $attrs) 
	{
//		var_dump($attrs);
		$gcode = $MAP_OBJECT->getGeoCode($attrs['address'].','.$attrs['city'].','.$attrs['zip']);
		if (isset($gcode['lon'])) 
		{
echo $attrs['id']." - YES\n";
			$update = DB::query(Database::UPDATE, 'UPDATE user SET lat=:lat, lon=:lon WHERE id = :id')
					->bind(':lat', $gcode['lat'])
					->bind(':lon', $gcode['lon'])
				->bind(':id', $attrs['id']);
                	$status = $update->execute();
		}
	}
    }
}
