<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Importer extends Model_Base {

    public static function getCols() {
        return array('firstname', 'lastname', 'email', 'address', 'state', 'phone', 'city', 'zip');
    }
    public static function getRow($rules, $line) {
        if ($line == "") {
            return false;
        }
        $tokens = str_getcsv($line);
        $row = array();
        if ($rules['col-lastname'] == '') {
            $row['name'] = trim(ucwords(strtolower($tokens[$rules['col-firstname']-1])));
        } else {
            $row['name'] = trim(ucwords(strtolower($tokens[$rules['col-firstname']-1] . ' ' . $tokens[$rules['col-lastname']-1])));
        }
        $cols = self::getCols();
        foreach ($cols as $col) {
            if ($col == 'firstname' || $col == 'lastname') {
                continue;
            }
            if ($rules['col-'.$col] != '') {
                $val = $tokens[$rules['col-'.$col]-1];
                if ($col == 'state') {
                    if (strlen($val) == 2) {
                        $val = strtoupper($val);
                    } else {
                        $val = trim(strtolower($val));
                    }
                } else if ($col == 'email') {
                    $val = trim(strtolower($val));
                } else if ($col == 'phone') {
                    $val = str_replace("(", "", $val);
                    $val = str_replace(")", "", $val);
                    $val = str_replace("-", "", $val);
                    if (strlen($val) == 10) {
                        $val = "(" . substr($val, 0, 3) . ") " . substr($val, 3, 3) . "-" . substr($val, 6);
                    } else if (strlen($val) == 11 && substr($val, 0, 1) == "1") {
                        $val = "(" . substr($val, 1, 3) . ") " . substr($val, 4, 3) . "-" . substr($val, 7);
                    }
                } else {
                    $val = trim(ucwords(strtolower($val)));
                }
                $row[$col] = $val;
            }
        }
        return $row;
    }

    public static function execTask($taskObj) {
        $taskObj->updateMsg('', Model_Task::STATUS_IN_PROGRESS);

        $params = $taskObj->getParams();
        $i = 0;
        $nc = 0;
        $oc = 0;
        $rules = $params['rules'];
        $fp = fopen($params['dir'].'/file.csv', "r");
        while (!feof($fp)) {
            $line = trim(fgets($fp));
            if ($rules['skip-header'] && $i == 0) {
                $i++;
                contine;
            }
            $row = self::getRow($rules, $line);
            if ($row) {
                $row['id'] = $i;
                if (isset($row['name']) && $row['name'] != '' && isset($row['email']) && $row['email'] != '') {
                    $userObj = Model_User::getUserObjByEmail($row['email']);
                    if ($userObj) {
                        $oc = $oc + 1;
                    } else {
                        $data = array();
                        $data['name'] = $row['name'];
                        $data['email'] = $row['email'];
                        $data['birth_date'] = '';
                        if (isset($row['role'])) {
                            $data['role'] = $row['role'];
                        } else {
                            $data['role'] = Model_User::ROLE_USER;
                        }
                        $data['password'] = sha1(microtime(true));
                        if (isset($row['address'])) {
                            $data['address'] = $row['address'];
                        }
                        if (isset($row['city'])) {
                            $data['city'] = $row['city'];
                        }
                        if (isset($row['state'])) {
                            $data['state'] = $row['state'];
                        }
                        if (isset($row['phone'])) {
                            $data['phone'] = $row['phone'];
                        }
                        if (isset($row['zip'])) {
                            $data['zip'] = $row['zip'];
                        }
                        if (isset($row['zip'])) {
                            $data['zip'] = $row['zip'];
                        }
                        $data['src'] = 'import-'.$taskObj->getId();
                        $id = Model_User::addUserObj($data, false /* no notify */);
                        if ($id) {
                            $nc = $nc + 1; // new user count
                            // setup connection
                            $newUserObj = Model_User::getUserObjById($id);
                            if ($newUserObj) {
                                $inviteData = array();
                                $inviteData['user_id'] = $newUserObj->getId();
                                $inviteData['user_invite'] = $params['id'];
                                $inviteData['invitation'] = 1;
                                $inviteData['date'] = date('Y-m-d H:i:s');
                                $newUserObj->inviteUser($inviteData);
                            }
                        }
                        if ($i % 100) {
                            $taskObj->updateMsg('rows:'.$i.' total:'. $params['total'] .' added:'.$nc. ' skipped:'.$oc, Model_Task::STATUS_IN_PROGRESS);
                        }
                    }
                }
            }
            $i++;
        }
        fclose($fp);
        $taskObj->updateMsg('', Model_Task::STATUS_COMPLETE);
    }
}
