<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_MyOrder extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $orderObj = $this->loginUserObj->getOrderObjById($id);
        if ($orderObj) {
            $itemObjs = Model_OrderItem::getOrderItemObjsByOrderId($orderObj->getId());

            $this->template->content = View::factory('site/templates/myorder/view');
            $this->template->content->orderObj = $orderObj;
            $this->template->content->ownerObj = $orderObj->getOwnerObj();
            $this->template->content->itemObjs = $itemObjs;

            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'payment';
            $this->template->content->sidebar->active = 'order';
        } else {
            $this->request->redirect('/');
        }
                                        }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/myorder/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'payment';
        $this->template->content->sidebar->active = 'order';
    }

    public function action_list_ajax()
    {		
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/myorder/list_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            if($this->loginUserObj->getRole() == Model_User::ROLE_USER)
            {
                $data['user_id'] = $this->loginUserObj->getId();
            }
            else
            {
                $data['owner_id'] = $this->loginUserObj->getId();
            }

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;
            $orderObjs = $this->loginUserObj->getOrderObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getOrderObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->orderObjs = $orderObjs;
            $this->template->modelOrder = $this->modelOrder;

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
}
