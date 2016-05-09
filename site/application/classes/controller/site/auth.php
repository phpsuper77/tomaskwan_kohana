<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Auth extends Controller_Site_Public
{
    public $template = 'site/index';	

    /**
     * As admin, we can login as another user. 
     */
    public function action_login_as()
    {
        if (!$this->loginUserObj || !$this->loginUserObj->isRoleAdmin())
        {
            $this->request->redirect('/');
        }
        $user_id = sanitizeValue($this->request->param('route'));
        $userObj = Model_User::getUserObjById($user_id);
        $user = $this->auth->force_login($userObj->getEmail());
        if ($user) {
            $session = Session::instance();
            $session->set('login_as.id', $this->loginUserObj->getId());
            $session->set('login_as.name', $this->loginUserObj->getName());
            Model_Audit::log($this->loginUserObj->getId(), Model_Audit::TYPE_LOGIN_AS, $user_id);
            $this->request->redirect('/dashboard');
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_login_as_back()
    {
        $session = Session::instance();
        $login_as_id = $session->get('login_as.id');
        if ($login_as_id) {
            $session->delete('login_as.id');
            $userObj = Model_User::getUserObjById($login_as_id);
            $user = $this->auth->force_login($userObj->getEmail());
            $this->request->redirect('/dashboard');
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_password_forgot()
    {
        $this->template->content = View::factory('site/templates/auth/password_forgot');
        if (isset($_POST['email'])) 
        {        				
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            if ($data['email'])
            {
                $userObj = Model_User::getUserObjByEmail($data['email']);
                $this->template->content->userObj = $userObj;
                if ($userObj) 
                {
                    $body = View::factory('site/emails/template');
                    $body->text = View::factory('site/emails/auth/password_forgot');
                    $body->text->userObj = $userObj;
                    $token['uid'] = $userObj->getId();
                    $token['ts'] = time();
                    $code = md5(rand(1,1000));
                    $userObj->updateAuthCode($code);
                    $body->text->code = $code;
                    sendMail('Message from Gymhit', $userObj->getEmail(), $body);
                }
            }
        }
    }

    public function action_password_review()
    {
        $this->template->content = View::factory('site/templates/auth/password_review');
        $data = Arr::map('sanitizeHTMLValue', $_GET);
        $this->template->content->code = $data['code'];
        $this->template->content->email = $data['email'];
    }

    public function action_password_reset()
    {
        $this->template->content = View::factory('site/templates/auth/password_reset_success');
        if (isset($_POST['code']) && isset($_POST['email'])) 
        {        				
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            if ($data['code'] && $data['password'] == $data['password_again'])
            {
                $userObj = Model_User::getUserObjByEmail($data['email']);
                if ($userObj && $userObj->getAuthCode() == $data['code']) 
                {
                    // reset password
                    $data['password'] = Auth::instance()->hash_password($data['password']);
                    $userObj->updatePassword($data);
                    $userObj->updateAuthCode('');
                    $this->template->content->userObj = $userObj;
                }
                else
                {
                    Cookie::set('error','Invalid Auth Code');
                    $this->request->redirect('/auth/password_review?email='.$_POST['email'].'&code='.$_POST['code']);
                }
            }
            else
            {
                Cookie::set('error','Invalid Auth Code');
                $this->request->redirect('/auth/password_review?email='.$_POST['email'].'&code='.$_POST['code']);
            }
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_register()
    {
        if (isset($_POST['submit'])) 
        {        				
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            $data['password'] = Auth::instance()->hash_password($data['password']);
            $data['create_date'] = date('Y-m-d H:i:s');
            $data['active_date'] = date('Y-m-d H:i:s');
            $data['birth_date'] = date('Y-m-d',strtotime($data['birth_date']));

            if($data['role'] == Model_User::ROLE_BUSINESS)
            {
                $data['title'] = $data['mortar'];
            }
            if($data['role'] == Model_user::ROLE_TRAINER)
            {
                $data['title'] = $data['profession'];
            }

            //add user
            $user_id = Model_User::addUserObj($data);
            Stats::track($user_id, 'auth.signup', array('src'=>$data['src']));

            $this->template = View::factory('ajax/success_register');
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_fbdisconnect()
    {
        if (!$this->loginUserObj)
        {
            $this->request->redirect('/');
        }
        $this->loginUserObj->updateFacebookId('');
        $this->request->redirect('/profile/account/'.$this->loginUserObj->getId().'#social');
    }

    public function action_fbconnect()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());

        require_once FS.'/Fb.php';
        $fb = Fb::getFb();
        $fb->setDefaultAccessToken($data['accessToken']);
        $response = $fb->get('/me?fields=id,name,email,picture');
        $fbProfile = $response->getGraphUser();
        $fid = $fbProfile->getField("id");

        $userObj = Model_User::getUserObjByEmail($data['email']);
        if (!$userObj)
        {
            $this->request->redirect('/');
        }
        $data['password'] = Auth::instance()->hash_password($data['password']);
        if ($data['password'] != $userObj->getAttr('password')) 
        {
            $this->request->redirect('/');
        }
        $userObj->updateFacebookId($fid);

        $user = $this->auth->force_login($data['email']);
        if ($user) {
            Model_Audit::log(Auth::instance()->get_user()['id'], Model_Audit::TYPE_LOGIN, 'fb2');
            $this->request->redirect('/dashboard');
        } else {
            $this->request->redirect('/');
        }
    }

    public function action_fblogin()
    {
        require_once FS.'/Fb.php';
        $fb = Fb::getFb();
        $helper = $fb->getJavaScriptHelper();
        $accessToken = $helper->getAccessToken();
        $fb->setDefaultAccessToken($accessToken);
        $response = $fb->get('/me?fields=id,name,email,picture');
        $fbProfile = $response->getGraphUser();
        $fid = $fbProfile->getField("id");
        $email = $fbProfile->getField("email");
        $picture = $fbProfile->getField("picture");

        $userObj = Model_User::getUserObjByEmail($email);
        if (!$userObj || $userObj->getFacebookId() != $fid) 
        {
            if ($this->loginUserObj && $userObj && $this->loginUserObj->getId() == $userObj->getId())
            {
                // from without user account
                $this->loginUserObj->updateFacebookId($fid);
                $this->request->redirect('/profile/account/'.$this->loginUserObj->getId().'#social');
            }
            else
            {
                // from login page
                $this->template->content = View::factory('site/templates/fblogin');
                $this->template->content->fbProfile = $fbProfile;
                $this->template->content->userObj = $userObj;
                $this->template->content->accessToken = $accessToken;
            }
        } 
        else 
        {
            // login
            $user = $this->auth->force_login($email);
            if ($user) {
                Stats::track($userObj->getId(), 'auth.signin', array('src'=>'fblogin'));
                Stats::setUser($userObj->getId(), array(
                    'role'=>$userObj->getAttr('role'),
                    'title'=>$userObj->getAttr('title'),
                    'birthday'=>$userObj->getAttr('birth_date'),
                    'zip'=>$userObj->getAttr('zip'),
                    'title'=>$userObj->getAttr('title'),
                    '$city'=>$userObj->getAttr('city'),
                    '$created'=>$userObj->getAttr('create_date'),
                ));
                Model_Audit::log(Auth::instance()->get_user()['id'], Model_Audit::TYPE_LOGIN, 'fb');
                $this->request->redirect('/dashboard');
            } else {
                error_log("WARNING: fb login failed $email $fid");
                $this->request->redirect('/');
            }
        }
    }

    public function action_login()
    {
        if (isset($_POST['submit'])) 
        {        	
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $user = $this->auth->loginUser($data['email'], $data['password'], NULL);
            if(!$user)
            {
                $this->template = View::factory('ajax/error_login');	
            }
            else
            {
                $user_id = Auth::instance()->get_user()['id'];
                $userObj = Model_User::getUserObjById($user_id);
                Stats::setUser($userObj->getId(), array(
                    'role'=>$userObj->getAttr('role'),
                    'title'=>$userObj->getAttr('title'),
                    'birthday'=>$userObj->getAttr('birth_date'),
                    'zip'=>$userObj->getAttr('zip'),
                    'title'=>$userObj->getAttr('title'),
                    '$city'=>$userObj->getAttr('city'),
                    '$created'=>$userObj->getAttr('create_date'),
                ));
                Stats::track($user_id, 'auth.signin', array('src'=>'password'));
                Model_Audit::log($user_id, Model_Audit::TYPE_LOGIN, '');
                $this->template = View::factory('ajax/blank');
            }
        }
        else
        {
            $this->request->redirect('/');
        }

    }

    public function action_logout()
    {
        Stats::track($user_id, 'auth.signout');
        $session = Session::instance();
        $session->delete('login_as.id');
        Auth::instance()->logout_user();
        $this->request->redirect('/');
    }

}
