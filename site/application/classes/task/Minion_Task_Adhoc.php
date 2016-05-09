<?php defined('SYSPATH') or die('No direct script access.');

require_once(APPPATH.'../resources/functions/GoogleMap.php');

class Minion_Task_Adhoc extends Minion_Task
{
    public function execute(array $params)
    {
echo "STARTED\n";
echo "STARTED\n";
echo "STARTED\n";
        $fp = fopen("/tmp/a.csv", "r");
$i = 0;
echo "fopened\n";
        while (!feof($fp)) {
            $line = trim(fgets($fp));
echo "$line\n";
            if ($line == '') continue;
            $tokens = str_getcsv($line);
//var_dump($tokens);
            if ($tokens[7] == '') {
            echo "no email\n";
                continue;
            }

            $info = array();
            $info['company'] = ucwords($tokens[0]);
            $info['address'] = ucwords($tokens[1]);
            $info['city'] = ucwords($tokens[2]);
            $info['state'] = ucwords($tokens[3]);
            $info['zip'] = $tokens[4];
            $info['phone'] = "(".substr($tokens[6],0,3).") " . substr($tokens[6],3,3). "-" . substr($tokens[6],6);
            $info['email'] = strtolower($tokens[7]);
            $info['first'] = ucwords($tokens[11]);
            $info['last'] = ucwords($tokens[12]);
            $info['spa'] = $tokens[13];
            $info['crossfit'] = $tokens[14];
            $info['chiro'] = $tokens[15];
            $info['massage'] = $tokens[16];
            $info['training'] = $tokens[17];
            $info['src'] = '85k';
//var_dump($info);

            //echo json_encode($info) . "\n";
echo "XXX Checking user for ".$info['email']."\n";

            $userObj = Model_User::getUserObjByEmail($info['email']);
            if ($userObj) {
echo "Known user for ".$info['email']."\n";
                continue;
            }

            $data = array();
            $data['name'] = $info['company'];
$meta = array();
$meta['first'] = $info['first'];
$meta['last'] = $info['last'];
            $data['meta'] = json_encode($meta);
            $data['email'] = $info['email'];
            $data['birth_date'] = '';
            $data['role'] = Model_User::ROLE_BUSINESS;
            $data['password'] = sha1(microtime(true));
            $data['address'] = $info['address'];
            $data['city'] = $info['city'];
            $data['state'] = $info['state'];
            $data['phone'] = $info['phone'];
            $data['zip'] = $info['zip'];
            $data['src'] = '85k';
echo "Adding user ".$data['email']."\n";
            $id = Model_User::addUserObj($data, false);
echo "Saved user $id\n";
$i = $i + 1;
//            if ($i > 10) break;
        }
        fclose($fp);
    }
}
