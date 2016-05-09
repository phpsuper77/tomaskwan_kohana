<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Available extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $avaObj = Model_Availability::getAvailabilityObjById($id);
        if ($avaObj) {
            $this->template->content = View::factory('site/templates/available/view');
            $this->template->content->avaObj = $avaObj;
        $locationObjs = $this->loginUserObj->getLocationObjs();
        $staffOfObjs = $this->loginUserObj->getStaffOfObjs();
        $this->template->content->locationObjs = $locationObjs;
        $this->template->content->staffOfObjs = $staffOfObjs;
            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'booking';
            $this->template->content->sidebar->active = 'available';
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_edit()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $this->loginUserObj->updateAvailabilityObj($data);
        $this->request->redirect('/available/view/'.$data['id']);
    }

    public function action_add()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $this->loginUserObj->addAvailabilityObj($data);
        $this->request->redirect('/available/list');
    }

    public function action_create()
    {
        $this->template->content = View::factory('site/templates/available/create');
        $locationObjs = $this->loginUserObj->getLocationObjs();
        $staffOfObjs = $this->loginUserObj->getStaffOfObjs();
        $this->template->content->locationObjs = $locationObjs;
        $this->template->content->staffOfObjs = $staffOfObjs;
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'available';
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/available/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'available';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/available/list_ajax');
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_id'] = $this->loginUserObj->getId();
            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $avaObjs = $this->loginUserObj->getAvailabilityObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getAvailabilityObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->avaObjs = $avaObjs;
            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
        {
            $this->request->redirect('/available/list');	
        }
    }

    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteClass($id);
        $this->request->redirect('/available/list');
    }

}
