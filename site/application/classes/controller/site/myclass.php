<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_MyClass extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $myClassObj = $this->loginUserObj->getMyClassObjById($id);
        if ($myClassObj) {
            $trainerObj = $myClassObj->getTrainerObj();
            $locationObj = $myClassObj->getLocationObj();
            $this->template->content = View::factory('site/templates/myclass/view');
            $this->template->content->myClassObj = $myClassObj;
            $this->template->content->trainerObj = $trainerObj;
            $this->template->content->locationObj = $locationObj;
            $this->template->content->memberObjs = array($trainerObj, $this->loginUserObj);
            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'purchased';
            $this->template->content->sidebar->active = 'classes';
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/myclass/list');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'purchased';
        $this->template->content->sidebar->active = 'classes';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';
            $this->template = View::factory('site/templates/myclass/list_ajax');
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['owner_id'] = $this->target_user_id;

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $myClassObjs = $this->loginUserObj->getMyClassObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getMyClassObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;
            $this->template->myClassObjs = $myClassObjs;
            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
    }
}
