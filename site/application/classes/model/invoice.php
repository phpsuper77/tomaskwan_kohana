<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Invoice extends Model_Base {

    const ITEM_ID_MEMBER_1M = '1';

    private static $_items = array(
            self::ITEM_ID_MEMBER_1M => array(
                'name' => "Membership 1 Month",
                'sum' => "100",
            ),
        );


    public static function getItem($item_id) {
        return self::$_items[$item_id];
    }

    public function getInvoices($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
            $filter['sort'] = 'date';
        if(!$filter['order'])
            $filter['order'] = 'DESC';
        $prequery = 'SELECT * FROM invoice WHERE user_id=:user_id';
        $prequery .= ' ORDER BY '.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';

        $query = DB::query(Database::SELECT,$prequery)
            ->bind(':user_id', $filter['user_id'])
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute();
        return $result->as_array();
    }

    public function checkInvoice($user_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM invoice WHERE user_id = :user_id ORDER BY date DESC LIMIT 1')
            ->bind(':user_id', $user_id);

        $result = $query->execute()->as_array();

        if(strtotime($result[0]['date'].' +'.$result[0]['period'].' months') <= strtotime('now') || count($result)==0)
            return TRUE;
        else
            return FALSE;
    }

    public function checkUnpaidInvoice($user_id) {
        $status = 'pending';
        $query = DB::query(Database::SELECT, 'SELECT * FROM invoice WHERE user_id = :user_id AND status = :status ORDER BY date ASC LIMIT 1')
            ->bind(':user_id', $user_id)
            ->bind(':status', $status);

        $result = $query->execute()->as_array();
        if(strtotime($result[0]['date'].' +2 weeks') <= strtotime('now'))
            return $result;
        else
            return FALSE;
    }

    public function checkPrices($user_id) {
        $billSettingObj = Modal_Settings::getSettingObjById($user_id);
        $ret = false;
        if ($billSettingObj) {
            if ($billSettingObj->getAttr('price_1') > 0 || $billSettingObj->getAttr('price_3') > 0 || $billSettingObj->getAttr('price_12') > 0) {
                $ret = true;
            }
        }
        return $ret;
    }

    public function getInvoiceById($id,$user_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM invoice WHERE id = :id AND user_id = :user_id')
            ->bind(':id', $id)
            ->bind(':user_id', $user_id);
        $result = $query->execute()->as_array();
        return $result[0];
    }

    public static function getInvoiceByOrderId($op_order) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM invoice WHERE op_order = :op_order')
            ->bind(':op_order', $op_order);
        $result = $query->execute()->as_array();
        $ret = false;
        if (count($result) > 0) {
            $ret = $result[0];
        }
        return $ret;
    }

    // objects
    public static function addInvoice($user_id, $data) {
        $status = 'pending';
        $query = DB::query(Database::INSERT, 'INSERT INTO invoice (user_id,date,status,sum,msg,item_id) VALUES (:user_id,:date,:status,:sum,:msg,:item_id)')
            ->bind(':user_id', $user_id)
            ->bind(':date', date('Y-m-d H:i:s'))
            ->bind(':status', $status)
            ->bind(':sum', $data['sum'])
            ->bind(':msg', $data['msg'])
            ->bind(':item_id', $data['item_id']);
        $result = $query->execute();
        return $result[0];
    }

    public static function updateInvoice($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE invoice SET op_host=:op_host,op_order=:op_order WHERE id = :id and user_id=:user_id')
            ->bind(':op_host', $data['op_host'])
            ->bind(':op_order', $data['op_order'])
            ->bind(':user_id', $user_id)
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('invoice', $data['id']));
    }

    private static function initiatePayment($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE invoice SET txid=:txid,op_host=:op_host,op_order=:op_order,op_start=:op_start WHERE id=:id and user_id=:user_id')
            ->bind(':txid', $data['txid'])
            ->bind(':op_host', $data['op_host'])
            ->bind(':op_order', $data['op_order'])
            ->bind(':op_start', date('Y-m-d H:i:s'))
            ->bind(':user_id', $user_id)
            ->bind(':id', $data['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('invoice', $data['id']));
    }


    public static function paymentSuccess($user_id, $op_order) {
        $status = 'paid';
        $invoice = self::getInvoiceByOrderId($op_order);
        $query = DB::query(Database::UPDATE, 'UPDATE invoice SET op_error=:op_error,status=:status,op_end=:op_end WHERE op_order=:op_order and user_id=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':status', $status)
            ->bind(':op_error', $op_error)
            ->bind(':op_order', $op_order)
            ->bind(':op_end', date('Y-m-d H:i:s'));
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('invoice', $invoice['id']));
    }

    public static function paymentError($user_id, $op_order, $op_error) {
        $status = 'pending'; // or failed
        $invoice = self::getInvoiceByOrderId($op_order);
        $query = DB::query(Database::UPDATE, 'UPDATE invoice SET op_error=:op_error,status=:status,op_end=:op_end WHERE op_order=:op_order and user_id=:user_id')
            ->bind(':status', $status)
            ->bind(':op_error', $op_error)
            ->bind(':user_id', $user_id)
            ->bind(':op_order', $op_order)
            ->bind(':op_end', date('Y-m-d H:i:s'));
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('invoice', $invoice['id']));
    }

/*
    public static function paymentErrorByTxId($user_id, $txid, $op_error) {
        $status = 'pending'; // or failed
        $query = DB::query(Database::UPDATE, 'UPDATE invoice SET op_error=:op_error,status=:status,op_end=:op_end WHERE txid=:txid and user_id=:user_id')
            ->bind(':status', $status)
            ->bind(':op_error', $op_error)
            ->bind(':user_id', $user_id)
            ->bind(':txid', $txid)
            ->bind(':op_end', date('Y-m-d H:i:s'));
        $result = $query->execute();
    }
*/

    public static function paymentStart($user_id, $data) {
        $invoiceObj = self::getInvoiceObjById($user_id, $data['id']);
        $userObj = $invoiceObj->getUserObj();
        $op_key = Kohana::$config->load('optimal')->get('key');
        $txid = $data['id'].'-'.time();
        $txdata = array();
        $txdata['key'] = $op_key;
        $txdata['id'] = $txid;
        $txdata['sum'] = $invoiceObj->getAttr('sum');
        $txdata['success'] = Kohana::$config->load('site')->get('main.url').'invoice/op_success';
        $txdata['error'] = Kohana::$config->load('site')->get('main.url').'invoice/op_error';
        $txdata['customerMail'] = $userObj->getEmail();
        $txdata['merchantMail'] = Kohana::$config->load('optimal')->get('merchantMail');
        $res = Util::payTransaction($txdata);
        if (isset($res['id'])) {
            $status = array();
            $status['op_order'] = $res['id'];
            $status['op_host'] = $res['link'][0]['uri'];
            $status['txid'] = $txid;
            $status['id'] = $invoiceObj->getId();
            $status['sum'] = $data['sum'];
            self::initiatePayment($user_id, $status);
            return $status['op_host'];
        } else {
            return false;
        }
    }

/*
    public static function payInvoice($user_id, $id) {
        $status = 'paid';
        $query = DB::query(Database::UPDATE, 'UPDATE invoice SET status=:status WHERE id = :id AND user_id=:user_id')
            ->bind(':status', $status)
            ->bind(':user_id', $user_id)
            ->bind(':id', $id);
        $result = $query->execute();
    }
 */
    public function getInvoiceObjs($user_id, $filter, $skip = 0,$limit = 10000) {
        $ret = array();
        $factory = new Model_Invoice();
        $filter['user_id'] = $user_id;
        $attrs_set = $factory->getInvoices($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_Invoice();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getInvoiceObjById($user_id, $id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('invoice', $id));
        if ($ret === null) {
            $factory = new Model_Invoice();
            $attrs = $factory->getInvoiceById($id, $user_id);
            if ($attrs) {
                $ret = new Model_Invoice();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('invoice', $id), $ret);
            }
        }
        return $ret;
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getAttr('user_id'));
    }
}
