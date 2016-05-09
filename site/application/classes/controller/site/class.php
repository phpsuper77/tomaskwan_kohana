<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Class extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        $this->modelClass = new Model_Class();

        if (!$this->loginUserObj->canOfferClasses())
        {
            $this->request->redirect('/');
        }
    }

    public function action_view()
    {
        $id = sanitizeValue($this->request->param('route'));
        $classObj = Model_Class::getClassObjById($id);
        if ($classObj) {
            $trainerObj = $classObj->getTrainerObj();
            //$locationObj = $classObj->getLocationObj();
            $this->template->content = View::factory('site/templates/class/view');
            $this->template->content->classObj = $classObj;
            $this->template->content->trainerObj = $trainerObj;
            //$this->template->content->locationObj = $locationObj;
            $this->template->content->memberObjs = array($trainerObj);
            $this->template->content->sidebar = View::factory('site/sidebar');
            $this->template->content->sidebar->open = 'purchased';
            $this->template->content->sidebar->active = 'classes';
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_add_cart()
    {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            foreach ($data['classes'] as $class) {
                $classObj = Model_Class::getClassObjById($class);
                $classOwnerObj = $classObj->getUserObj();
                $cartObj = $this->loginUserObj->getCartObjByOwnerId($classOwnerObj->getId());
                if ($cartObj) {
                    $data['order_id'] = $cartObj->getId();
                } else {
                    $dataOrder['date'] = date('Y-m-d H:i:s');
                    $dataOrder['user_id'] = $this->loginUserObj->getId();
                    $dataOrder['status'] = 'cart';
                    $dataOrder['owner_id'] = $classOwnerObj->getId();
                    $data['order_id'] = $this->loginUserObj->addOrder($dataOrder);
                }

                $data['user_id'] = $this->loginUserObj->getId();
                $data['type'] = Model_Order::TYPE_CLASS;
                $data['date'] = date('Y-m-d H:i:s');
                $this->loginUserObj->addBooking($data);
            }

            $this->request->redirect('/cart/list');	
    }

    public function action_add()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
    //    $data['room'] = '';
        $data['user_id'] = $this->loginUserObj->getId();
        $data['week'] = serialize($data['week']);
        $this->loginUserObj->addClass($data);
        Cookie::set('success','addClass');

        if(isset($_FILES['image']))
        {
            $path = '/tmp/_class_'.getmypid();
            @mkdir($path);
            $filename =time() .'.'.pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION);
            $file = $path.'/'. $filename;
            if(move_uploaded_file($_FILES['image']['tmp_name'], $file))
            {
                Util::cropImage($file,intval($data['x']),intval($data['y']),intval($data['w']),intval($data['h']),320,320);

                // Upload to S3
                $s3 = Amazon::instance()->get('s3');
                $result = $s3->putObject(array(
                    'Bucket' => Kohana::$config->load('site.s3.bucket'),
                    'Key' => Kohana::$config->load('site.s3.path')."/users/".$data['user_id']."/class/".$filename,
                    'Body' => fopen($file, "r"),
                    'ACL' => 'public-read',
                ));

                if ($result)
                {
                    $this->loginUserObj->updateClassImage($data['id'],$filename);
                }
            }
        }

        $this->request->redirect('/class/list');	
    }

    public function action_edit()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        //$data['room'] = '';
        $data['user_id'] = $this->loginUserObj->getId();
        $data['week'] = serialize($data['week']);
        $this->loginUserObj->updateClass($data);
        Cookie::set('success','editClass');	
        if(isset($_FILES['image']))
        {
            $path = '/tmp/_class_'.getmypid();
            @mkdir($path);
            $filename =time() .'.'.pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION);
            $file = $path.'/'. $filename;
            if(move_uploaded_file($_FILES['image']['tmp_name'], $file))
            {
                Util::cropImage($file,intval($data['x']),intval($data['y']),intval($data['w']),intval($data['h']),320,320);

                // Upload to S3
                $s3 = Amazon::instance()->get('s3');
                $result = $s3->putObject(array(
                    'Bucket' => Kohana::$config->load('site.s3.bucket'),
                    'Key' => Kohana::$config->load('site.s3.path')."/users/".$data['user_id']."/class/".$filename,
                    'Body' => fopen($file, "r"),
                    'ACL' => 'public-read',
                ));

                if ($result)
                {
                    $this->loginUserObj->updateClassImage($data['id'],$filename);
                }
            }
        }

        $this->request->redirect('/class/list');	
    }

    public function action_list()
    {
        $this->template->content = View::factory('site/templates/class/list');

        $this->template->content->sidebar = View::factory('site/sidebar');
        $this->template->content->addClassModal = View::factory('site/templates/class/modal_add');
        $locationObjs = $this->loginUserObj->getLocationObjs();
        $this->template->content->addClassModal->locationObjs = $locationObjs;
        $filter = array('sort'=>'id','order'=>'ASC');
        $this->template->content->addClassModal->staffObjs = $this->loginUserObj->getStaffObjs($filter);
        $this->template->content->sidebar->open = 'booking';
        $this->template->content->sidebar->active = 'class';
    }

    public function action_list_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';

            $this->template = View::factory('site/templates/class/list_ajax');
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['user_id'] = $this->loginUserObj->getId();
            // define pagination variables
            if (!$data['page']) $data['page'] = 1;
            $perPage = 15;
            $skip = ($data['page'] - 1) * $perPage;	
            $limit = $perPage;

            $classObjs = $this->loginUserObj->getClassObjs($data,$skip,$limit);
            $total = count($this->loginUserObj->getClassObjs($data));

            // paginatior object
            $paginator = new Pagination('', $total);
            $paginator->perPage = $perPage;

            $this->template->classObjs = $classObjs;
            if($total > $perPage)
            {
                $this->template->pages = $paginator->getPages($data['page']);
            }
        }
        else
        {
            $this->request->redirect('/class/list');	
        }
    }

    public function action_activate()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->updateClassStatus($id, '1');
        $this->request->redirect('/class/list');
    }

    public function action_deactivate()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->updateClassStatus($id, '0');
        $this->request->redirect('/class/list');
    }
/*
    public function action_delete()
    {
        $id = sanitizeValue($this->request->param('route'));
        $this->loginUserObj->deleteClass($id);
        $this->request->redirect('/class/list');
    }
*/
}
