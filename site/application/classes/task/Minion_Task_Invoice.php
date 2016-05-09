<?php defined('SYSPATH') or die('No direct script access.');

require_once(APPPATH.'../resources/functions/GoogleMap.php');

class Minion_Task_Invoice extends Minion_Task
{
    private function doBusiness($userObj)
    {
        $item = Model_Invoice::getItem(Model_Invoice::ITEM_ID_MEMBER_1M);
        $data = array();
        $data['sum'] = $item['sum']; 
        $data['msg'] = $item['name'] . ' - ' . date('m/Y'); 
        $data['item_id'] = Model_Invoice::ITEM_ID_MEMBER_1M;
        $userObj->addInvoice($data);
    }

    public function execute(array $params)
    {
        $filter['type'] = Model_User::ROLE_BUSINESS;
        $userObjs = Model_User::getUserObjs($filter, 0, 1000000);
        foreach ($userObjs as $userObj) {
            if ($userObj->isRoleBusiness()) {
                $this->doBusiness($userObj);
            }
        }
    }
}
