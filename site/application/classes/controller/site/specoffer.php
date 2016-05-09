<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Specoffer extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        //model
        $this->modelSpecOffer = new Model_Specoffer();

        //check if user is logged
        $role = $this->loginUserObj->getRole();
        if ($role == Model_User::ROLE_USER || $role == Model_User::ROLE_ADMIN)
        {
            $this->request->redirect('/');
        }
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $offerObj = Model_Specoffer::getOfferObjById($id);
        if ($offerObj) {
            $this->template->content = View::factory('site/templates/specoffer/view');
            $this->template->content->offerObj = $offerObj;
            $this->template->content->buyerObjs = array();
            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'marketing';
            $this->template->content->sidebar->active = 'spec_offer';
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_add()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $data['owner_id'] = $this->loginUserObj->getId();
        if($data['date_to'])
        {
            $data['date_to'] = date("Y-m-d", strtotime($data['date_to']));
        }
        else
        {
            $data['date_to'] = NULL;
        }
        $data['id'] = $this->loginUserObj->addOffer($data);
        Cookie::set('success','addOffer');
        if(isset($_FILES['offer']))
        {
            $path = '/tmp/_specoffer_'.getmypid();
            @mkdir($path);
            $filename =time() .'.'.pathinfo(basename($_FILES['offer']['name']), PATHINFO_EXTENSION);
            $file = $path.'/'. $filename;
            if(move_uploaded_file($_FILES['offer']['tmp_name'], $file))
            {
                Util::cropImage($file,intval($data['x']),intval($data['y']),intval($data['w']),intval($data['h']),320,320);

                // Upload to S3
                $s3 = Amazon::instance()->get('s3');
                $result = $s3->putObject(array(
                    'Bucket' => Kohana::$config->load('site.s3.bucket'),
                    'Key' => Kohana::$config->load('site.s3.path')."/users/".$data['owner_id']."/specoffer/".$filename,
                    'Body' => fopen($file, "r"),
                    'ACL' => 'public-read',
                ));

                if ($result)
                {
                    $this->loginUserObj->updateOfferImage($data['id'],$filename);
                }
            }
        }		
        $this->request->redirect('/specoffer/list');	
    }

    public function action_edit()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $data['owner_id'] = $this->loginUserObj->getId();
        if($data['date_to'])
        {
            $data['date_to'] = date("Y-m-d", strtotime($data['date_to']));
        }
        else
        {
            $data['date_to'] = NULL;
        }
        $this->loginUserObj->updateOffer($data);
        Cookie::set('success','editOffer');	
        if(isset($_FILES['offer']))
        {
            $path = '/tmp/_specoffer_'.getmypid();
            @mkdir($path);
            $filename =time() .'.'.pathinfo(basename($_FILES['offer']['name']), PATHINFO_EXTENSION);
            $file = $path.'/'. $filename;
            if(move_uploaded_file($_FILES['offer']['tmp_name'], $file))
            {
                Util::cropImage($file,intval($data['x']),intval($data['y']),intval($data['w']),intval($data['h']),320,320);

                // Upload to S3
                $s3 = Amazon::instance()->get('s3');
                $result = $s3->putObject(array(
                    'Bucket' => Kohana::$config->load('site.s3.bucket'),
                    'Key' => Kohana::$config->load('site.s3.path')."/users/".$data['owner_id']."/specoffer/".$filename,
                    'Body' => fopen($file, "r"),
                    'ACL' => 'public-read',
                ));

                if ($result)
                {
                    $this->loginUserObj->updateOfferImage($data['id'],$filename);
                }
            }
        }		
        $this->request->redirect('/specoffer/list');	
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/specoffer/list');

        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->addSpecOfferModal = View::factory('site/templates/specoffer/modal_add');

        $this->template->content->sidebar->open = 'marketing';
        $this->template->content->sidebar->active = 'spec_offer';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';
            $this->template = View::factory('site/templates/specoffer/list_ajax');
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['owner_id'] = $this->loginUserObj->getId();

            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $offerObjs = $this->loginUserObj->getOfferObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getOfferObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;
            $this->template->offerObjs = $offerObjs;

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

    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteOffer($id);
        $this->request->redirect('/specoffer/list');

    }

    public function action_activate()
    {

        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->activeOffer($id,1);
        $this->request->redirect('/specoffer/list');			
    }

    public function action_deactivate()
    {

        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->activeOffer($id,0);
        $this->request->redirect('/specoffer/list');
    }

}
