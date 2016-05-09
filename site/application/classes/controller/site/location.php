<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Location extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
    }

    public function action_add()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['order_id'] = $this->loginUserObj->addLocation($data);
        }
        $this->request->redirect('/location/list');
    }

    public function action_edit()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            if($data['submit'] == 'edit')
            {		
                $this->loginUserObj->updateBooking($data);
                Cookie::set('success','editBooking');
                if($data['mode'] == 'dashboard')
                {
                    $this->request->redirect('/dashboard');

                }		
            }		
        }
        $this->request->redirect('/location/list');
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $locationObj = Model_Location::getLocationObjById($id);
        if ($locationObj) {
            $this->template->content = View::factory('site/templates/location/view');
            $this->template->content->locationObj = $locationObj;
            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'business';
            $this->template->content->sidebar->active = 'location';
        } else {
            $this->request->redirect('/location/list');
        }
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/location/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->addLocationModal = View::factory('site/templates/location/modal_add');
        $this->template->content->sidebar->open = 'business';
        $this->template->content->sidebar->active = 'location';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';
            $this->template = View::factory('site/templates/location/list_ajax');
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['owner_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 10;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

            $locationObjs = $this->loginUserObj->getLocationObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getLocationObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->locationObjs = $locationObjs;

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

    public function action_activate()
    {
        $id = sanitizeValue($this->request->param('route'));
        if (!$this->loginUserObj->updateLocationStatus($id, Model_Location::STATUS_ACTIVE)) {
            Cookie::set('error','failedDelete');
        }
        $this->request->redirect('/location/list');
    }

    public function action_deactivate()
    {
        $id = sanitizeValue($this->request->param('route'));
        if (!$this->loginUserObj->updateLocationStatus($id, Model_Location::STATUS_INACTIVE)) {
            Cookie::set('error','failedDelete');
        }
        $this->request->redirect('/location/list');
    }
/*
    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        if (!$this->loginUserObj->deleteLocation($id)) {
            Cookie::set('error','failedDelete');
        }
        $this->request->redirect('/location/list');
    }
*/
}
