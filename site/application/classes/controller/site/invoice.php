<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Invoice extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        if ($this->loginUserObj->isRoleUser()) {
            $this->request->redirect('/');
        }
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/invoice/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'business';
        $this->template->content->sidebar->active = 'invoice';	
    }

    public function action_invoice_list()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/invoice/list_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['user_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $invoiceObjs = $this->loginUserObj->getInvoiceObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getInvoiceObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->invoiceObjs = $invoiceObjs;

            if($total > $perPage) 
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
        {
            $this->request->redirect('/');	
        }
    }

    public function action_pay()
    {
        $id = sanitizeValue($this->request->param('route'));
        $data = array();
        $data['id'] = $id;
        $data['modify_date'] = date('Y-m-d H:i:s');
        $url = Model_Invoice::paymentStart($this->loginUserObj->getId(),$data);
        if ($url) {
            $this->request->redirect($url);
            Cookie::set('success','finalize');
        }
    }


    public function action_op_success()
    {
        // retrieve call from optimal payment
        $op_order = $_GET['id'];
        Model_Invoice::paymentSuccess($this->loginUserObj->getId(), $op_order);
        $this->request->redirect('/invoice/list');
    }

    public function action_op_error()
    {
        if (isset($_GET['id'])) {
            $op_error = $_GET['transaction_errorMessage'];
            Model_Invoice::paymentError($this->loginUserObj->getId(), $_GET['id'], $op_error);
            Cookie::set('error', $op_error);
        } else if (isset($_GET['nbx_merchant_reference'])) {
            $nbx_merchant_reference = $_GET['nbx_merchant_reference'];
            $op_error = $_GET['nbx_status'];
            Model_Invoice::paymentErrorByTxId($this->loginUserObj->getId(), $nbx_merchant_reference, $op_error);
            Cookie::set('error', $op_error);
        }
        $this->request->redirect('/invoice/list');

        /*
         * [Sun Aug 30 07:06:01 2015] [error] [client 98.234.222.27] XXX op_error get Array\n(\n    [nbx_return_url] => \n    [nbx_currency_code] => USD\n    [nbx_status] => declined\n    [nbx_failure_redirect_url] => \n    [nbx_merchant_reference] => 18-1440918316\n    [nbx_timeout] => \n    [nbx_success_redirect_url] => \n    [nbx_netbanx_reference] => \n    [nbx_email] => thomask@etechfocus.com\n    [nbx_success_url] => \n    [nbx_payment_amount] => 29700\n    [nbx_failure_url] => \n)\n
         * */
    }

/*
    public function action_pay()
    {
        $id = sanitizeValue($this->request->param('route'));
        if (!$id) {
            $this->request->redirect('/invoice/index');
        }

        $invoiceObj = $this->loginUserObj->getInvoiceObjById($id);
        if($invoiceObj)
        {			
            if(!$invoiceObj->getAttr('op_host'))
            {
                $invoiceObj->getAttr('key', Kohana::$config->load('optimal')->get('key'));
                $invoiceObj->getAttr('merchantMail', Kohana::$config->load('optimal')->get('merchantMail'));
                $invoiceObj->getAttr('customerMail', $this->loginUserObj->getEmail());
                $invoiceObj->getAttr('success', FULLPATH.PATH.'/invoice/success');
                $invoiceObj->getAttr('error', FULLPATH.PATH.'/invoice/error');

                //sending request to op
                $data = payTransaction($invoice);

                if(isset($data->error))
                {
                    Cookie::set('error',$data->error->message);	
                    $this->request->redirect('/invoice/index');					
                }
                else
                {
                    $invoiceObj->setAttr('op_host', $data->link[0]->uri);
                    $invoiceObj->setAttr('op_order', $data->id);
                    $this->loginUserObj->updateInvoice($invoiceObj->getAttrs());
                }				
            }
            //redirect to op host
            $this->request->redirect($invoiceObj->getAttr('op_host'));
        }
        else
            $this->request->redirect('/invoice/index');

    }

    public function action_success()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());

        if(isset($data['id']))
        {
            $data['key'] = Kohana::$config->load('optimal')->get('key');

            //checking status
            $response = checkTransaction($data);
            if($response->transaction->status == 'success')
            {
                $this->loginUserObj->payInvoice($response->merchantRefNum);
                Cookie::set('success','pay');

                //activate page
                $this->loginUserObj->activePage(1);	
            }
        }
        $this->request->redirect('/invoice/index');	
    }

    public function action_error()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->query());
        Cookie::set('error',$data['transaction_errorMessage']);	
        $this->request->redirect('/invoice/index');	
    }
 */
}
