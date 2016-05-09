<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_MyReview extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

    }

    public function action_list()
    {
        $type = sanitizeValue($this->request->param('route'));
        $this->template->content = View::factory('site/templates/myreview/list');
        $this->template->content->reviewModal = View::factory('site/templates/myreview/modal');

        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->sidebar->active = 'reviews';
        $this->template->content->sidebar->open = 'user';

    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination3.php';
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['type'] = 'reviews';
            $param = sanitizeValue($this->request->param('param'));
            $data['id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;
            $limit = $perPage;

            if($this->user['role'] == Model_User::ROLE_USER)
            {
                $data['user'] = TRUE;
            }
            else
            {
                $data['user'] = FALSE;
            }

            $this->template = View::factory('site/templates/myreview/list_ajax');
            $reviewObjs = Model_Review::getReviewObjs($data,$skip,$limit);
            $total = count(Model_Review::getReviewObjs($data));

            $this->template->reviewObjs = $reviewObjs;
            $this->template->type = $data['type'];

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            if($total > $perPage)
                $this->template->pages = $paginator->getPages($data['page']);
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_cancel()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->cancelReview($id,$this->loginUserObj->getId());
        $this->request->redirect('/myreview/list');
    }
}
