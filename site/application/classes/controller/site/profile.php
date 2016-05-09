<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Profile extends Controller_Site_Private
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();

        //model
        $this->modelGallery = new Model_Gallery();
        $this->modelDashboard = new Model_Dashboard();

        $this->id = sanitizeValue($this->request->param('route'));
/*
        if($this->loginUserObj->getId() != $this->id && $this->modelUser->isSuperior($this->id,$this->loginUserObj->getId()) == false && $this->user['role'] != Model_User::ROLE_ADMIN || !$this->id)
        {
            $this->request->redirect('/dashboard/index');
        }
 */

        $this->template->content = View::factory('site/templates/profile/profile');
        $this->template->content->sidebar = View::factory('site/sidebar');

        $this->template->content->sidebar->active = 'account';
        $this->template->content->sidebar->open = 'account';
        $this->template->active = 'profile';

        $this->profileUserObj = Model_User::getUserObjById($this->id);
        $this->template->content->profileUserObj = $this->profileUserObj;

        $this->template->content->messageModal = View::factory('site/modals/message_logged2');

        $this->template->content->connects = $this->loginUserObj->getMemberCount();
        $this->template->content->bookings = $this->modelDashboard->getBookings(array('id'=>$this->id));
        $this->template->content->likes = $this->loginUserObj->getLikeCount();
    }

    public function action_index()
    {
        $this->template->content->profileContent = View::factory('site/templates/profile/overview');
    }

    public function action_avatar_remove()
    {
        $this->loginUserObj->updateAvatar('');
        $this->request->redirect('/profile/account/'.$this->loginUserObj->getId().'#avatar');
    }

    public function action_account()
    {
        if (isset($_POST['submit'])) 
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['id'] = $this->id;

            $tab = '';
            switch($_POST['submit'])
            {
            case 'personal':	
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'personal'));
                $data['unit'] = serialize($data['unit']);
                $this->profileUserObj->updateUser($data);
                Cookie::set('success','updatePersonal');
                $tab = '#personal';
                break;
            case 'avatar':
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'avatar'));
                if(isset($_FILES['avatar']))
                {
                    $path = '/tmp/_avatar_'.getmypid();
                    @mkdir($path);
                    $filename =time() .'.'.pathinfo(basename($_FILES['avatar']['name']), PATHINFO_EXTENSION);
                    $file = $path.'/'. $filename;
                    if(move_uploaded_file($_FILES['avatar']['tmp_name'], $file)) 
                    {
                        Util::cropImage($file,intval($data['x']),intval($data['y']),intval($data['w']),intval($data['h']),150,150);
                        // Upload to S3
                        $s3 = Amazon::instance()->get('s3');
                        $result = $s3->putObject(array(
                            'Bucket' => Kohana::$config->load('site.s3.bucket'),
                            'Key' => Kohana::$config->load('site.s3.path')."/users/".$data['id']."/avatar/".$filename,
                            'Body' => fopen($file, "r"),
                            'ACL' => 'public-read',
                        ));

                        if ($result) 
                        {
                            $this->profileUserObj->updateAvatar($filename);
                            Cookie::set('success','updateAvatar');
/*
                                if($data['id'] == $this->loginUserObj->getId())
                                {
                                    $this->user['avatar'] = basename($_FILES['avatar']['name']);
                                    $session = Session::instance();
                                    $session->set('gymhit_auth_user', $this->user);
                                }
 */
                        }
                    }
                    system("rm -rf $path");
                }
                $tab = '#avatar';
                break;
            case 'background':
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'background'));
                if(isset($_FILES['background']))
                {
                    $path = '/tmp/_bg_'.getmypid();
                    @mkdir($path);
                    $filename =time() .'.'.pathinfo(basename($_FILES['background']['name']), PATHINFO_EXTENSION);
                    $file = $path.'/'. $filename;
                    if(move_uploaded_file($_FILES['background']['tmp_name'], $file)) 
                    {
                        $s3 = Amazon::instance()->get('s3');
                        $result = $s3->putObject(array(
                            'Bucket' => Kohana::$config->load('site.s3.bucket'),
                            'Key' => Kohana::$config->load('site.s3.path')."/pages/".$data['page_id']."/bg/".$filename,
                            'Body' => fopen($file, "r"),
                            'ACL' => 'public-read',
                        ));
                        if ($result) 
                        {
                            $this->profileUserObj->updateBackground($filename);
                        }
                    }
                    system("rm -rf $path");
                }
                if(isset($data['backtype']) && $data['backtype'] == 0)
                {
                    $this->profileUserObj->updateBackground('');
                }
                Cookie::set('success','updateBackground');
                $tab = '#background';
                break;
            case 'password':
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'password'));
                $data['password'] = Auth::instance()->hash_password($data['password']);
                $this->profileUserObj->updatePassword($data);
                Cookie::set('success','updatePassword');
                $tab = '#password';
                break;

/*
            case 'tour':
                $this->loginUserObj->updateSession($data);
                if(count($data['check'])>0)
                {
                    $this->loginUserObj->deleteTime();
                    foreach($data['check'] as $day => $value)
                    {
                        $this->loginUserObj->addTime($day,date('H:i:s',strtotime($data['time_from'][$day])),date('H:i:s',strtotime($data['time_to'][$day])),$data['time_custom'][$day]);	
                    }
                }
                $tab = '#tour';
                break;
            case 'session':
                $this->loginUserObj->updateSession($data);
                if(count($data['check'])>0)
                {
                    $this->loginUserObj->deleteTime();
                    foreach($data['check'] as $day => $value)
                    {
                        $this->loginUserObj->addTime($day,date('H:i:s',strtotime($data['time_from'][$day])),date('H:i:s',strtotime($data['time_to'][$day])),$data['time_custom'][$day]);	
                    }
                }
                $tab = '#session';
                break;
*/

            case 'social':
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'social'));
                $this->loginUserObj->updateSocial($data);
                $tab = '#social';
                break;
            case 'settings':
                if(isset($data['public']) && $data['public'] == 0 && $this->profileUserObj->getAttr('route') != null)
                {
                        /*
                           $this->loginUserObj->deletePage($this->id);
                         */

                }
                if($data['public'] == 1 && $this->profileUserObj->getAttr('route') == null)
                {
                    //add site
                        /*
                           $n = 0;
                           do {
                           $n++;
                           $page['route'] = prepareUrl($data['name']).'-'.$n;
                           $busy = $this->modelPage->getPageByRoute($page['route']);
                           } while(count($busy) > 0);
                           $page['user_id'] = $this->id;
                           Model_Page::addPageObj($page);
                           Model_Settings::addSettingObj($this->id,1,0,0,0);
                         */

                }				
                $this->loginUserObj->updateSettings($data);

                //activate if set time,session,price and superior is active
                if(count($data['check'])>0 && $data['price']>0 && $data['session']>0 && $this->modelPage->isActive($data['superior_id']) == TRUE)
                {
                    $this->loginUserObj->activePage($this->id,1);				
                }

                Cookie::set('success','updateSettings');
                $tab = '#settings';
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'settings'));
                break;

            case 'billing':
                Stats::track($this->loginUserObj->getId(), 'setting.change', array('type'=>'billing'));
                $this->loginUserObj->updateBillingSettings($data);
                Cookie::set('success','updateBilling');
                $tab = '#billing';
                break;			
            }
            $this->request->redirect('/profile/account/'.$data['id'].$tab);
        }

        $this->template->content->profileContent = View::factory('site/templates/profile/account');
        $this->template->content->profileContent->userUnits = unserialize($this->profileUserObj->getAttr('unit'));	
        $this->template->content->profileContent->modelSettings = $this->modelSettings;
        $this->template->content->profileContent->profileUserObj = $this->profileUserObj;
        $this->template->content->profileContent->settingObj = $this->profileUserObj->getSettingObj();
        $this->template->content->profileContent->billingSettingObj = $this->profileUserObj->getBillingSettingObj();
        $this->template->content->profileContent->locationObjs = $this->profileUserObj->getLocationObjs();

        // titles
        if($this->profileUserObj->getRole() == Model_User::ROLE_BUSINESS)
        {
            $this->template->content->profileContent->titleObjs = Model_Unit::getUnitObjs('mortar');
        }
        if($this->profileUserObj->getRole() == Model_User::ROLE_TRAINER)
        {
            $this->template->content->profileContent->titleObjs = Model_Unit::getUnitObjs('profession');
        }
        if($this->profileUserObj->getRole() == Model_User::ROLE_SCHOOL)
        {
            $this->template->content->profileContent->titleObjs = Model_Unit::getUnitObjs('school');
        }

        // units
        if($this->profileUserObj->isRoleHost())
        {
            $this->template->content->profileContent->unitObjs = Model_Unit::getUnitObjs('amenity');
        }
        else
        {
            $this->template->content->profileContent->unitObjs = Model_Unit::getUnitObjs('interest');
        }
    }

    public function action_staff()
    {
        if (isset($_POST['submit'])) 
        {        				
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['password'] = Auth::instance()->hash_password($data['password']);
            $data['create_date'] = date('Y-m-d H:i:s');
            $data['active_date'] = date('Y-m-d H:i:s');
            $data['birth_date'] = date('Y-m-d',strtotime($data['birth_date']));
            $data['superior_id'] = $this->loginUserObj->getId();

            if($this->loginUserObj->getRole() == Model_User::ROLE_ADMIN)
            {
                $data['role'] = Model_User::ROLE_ADMIN;
            }
            else
            {
                $data['role'] = Model_User::ROLE_TRAINER;
            }

            //add user
            $page['user_id'] = $this->loginUserObj->addStaffObj($data);

            Cookie::set('success','addStaff');
            $this->request->redirect('/profile/staff/'.$this->id);

        }		

        $this->template->content->profileContent = View::factory('site/templates/profile/staff_list');
        $this->template->content->profileContent->type = 'staff';
        $this->template->content->profileContent->title = 'our staff';
        $this->template->content->profileContent->superior = $this->profileUserObj->getId();
        $this->template->content->profileContent->addEmployeeModal = View::factory('site/modals/add_employee');	
        $this->template->content->profileContent->addEmployeeModal->profileUserObj = $this->profileUserObj;
        $this->template->content->profileContent->addEmployeeModal->titleObjs = Model_Unit::getUnitObjs('profession');
    }

    public function action_staff_ajax()
    {
        if(isset($_POST['sort']))
        {
            require_once FS.'Pagination2.php';
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $data['type'] = 'staff';
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

            $this->template = View::factory('site/templates/profile/staff_ajax');
            $guserObjs = Model_User::getAllStaffObjs($data, $skip, $limit);
            $total = count(Model_User::getAllStaffObjs($data));

            $this->template->guserObjs = $guserObjs;
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

    public function action_credentials()
    {
        $this->template->content->profileContent = View::factory('site/templates/profile/credentials');
        $this->template->content->profileContent->id = $this->id;
        $this->template->content->profileContent->credentialObjs = $this->profileUserObj->getCredentialObjs();
        $this->template->content->sidebar->open = 'account';
        $this->template->content->sidebar->active = 'credentials';
        $this->template->active = 'credentials';
    }
}
