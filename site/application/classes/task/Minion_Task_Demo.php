<?php defined('SYSPATH') or die('No direct script access.');
 
class Minion_Task_Demo extends Minion_Task
{
    public function execute(array $params)
    {
        var_dump($params);
        echo 'foobar';

	$userObj = Model_User::getUserObjById(1);
        var_dump($userObj);
    }
}
