<?php

class Geocoder {

    private static function geocodio_geo($street, $city, $state, $zip) {
        $ret = false;
        try {
            if ($street || $city || $state || $zip) {
                $url = "https://api.geocod.io/v1/geocode?api_key=" . 
                            Kohana::$config->load('site.geocodio.key') . 
                            "&street=".urlencode($street).
                            "&city=".urlencode($city).
                            "&state=".urlencode($state).
                            "&zip=".urlencode($zip);
                $ret = file_get_contents($url);
                $response = json_decode($ret, true);
                if ($response) {
                    $ret = array();
                    $ret['state'] = $response['results'][0]['address_components']['state'];
                    $ret['lat'] = $response['results'][0]['location']['lat'];
                    $ret['lon'] = $response['results'][0]['location']['lng'];
                }
            }
        } catch (Exception $e) {
            // do nothing
        }
        return $ret;
    }

    public static function geo($street, $city, $state, $zip) {
        return self::geocodio_geo($street, $city, $state, $zip);
    }

}
