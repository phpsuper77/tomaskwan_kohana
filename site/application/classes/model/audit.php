<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Audit extends Model_Base {

    const TYPE_LOGIN = 'login';
    const TYPE_LOGIN_AS = 'login_as';

    public static function log($user_id, $type, $msg) {
        $query = DB::query(Database::INSERT, 'INSERT INTO audit_logs (user_id,type,msg,date) VALUES (:user_id,:type,:msg,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':msg', $msg)
            ->bind(':date', date('Y-m-d H:i:s'))
            ->bind(':type', $type);
        $result = $query->execute();
    }

}
