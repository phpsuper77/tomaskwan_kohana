<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Job extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

        if ($this->loginUserObj->isRoleUser())
        {
            $this->request->redirect('/');
        }
    }

    public function action_seeker()
    {

        $this->template->content = View::factory('site/templates/job/seeker');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'job';
        $this->template->content->sidebar->active = 'seeker';
        $this->template->content->professionObjs = Model_Unit::getUnitObjs('profession');
    }

    public function action_seeker_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';

            $this->template = View::factory('site/templates/job/seeker_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['user_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

            $seekerObjs = $this->loginUserObj->getJobSeekerObjs($data, $skip, $limit);
            $total = count($this->loginUserObj->getJobSeekerObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->seekerObjs = $seekerObjs;

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

    public function action_employer()
    {
        $this->template->content = View::factory('site/templates/job/employer');
        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->open = 'job';
        $this->template->content->sidebar->active = 'employer';
        // for direct message
    }

    public function action_employer_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';

            $this->template = View::factory('site/templates/job/employer_ajax');

            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['user_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

            $employerObjs = $this->loginUserObj->getEmployerObjs($data, $skip, $limit);
            $total = count($this->loginUserObj->getEmployerObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->employerObjs = $employerObjs;

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
