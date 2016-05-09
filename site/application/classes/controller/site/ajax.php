<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Ajax extends Controller_Site_Public
{
    public $template = 'ajax/bool_message';

    public function before()
    {
        parent::before();
        $this->modelReview = new Model_Review();
        $this->modelOrder = new Model_Order();

        $this->auto_template_render = FALSE;

    }

    public function action_validateName()
    {

        if (isset($_POST['name'])) 
        {
            $match = preg_match("/^[A-Za-z0-9 \.\(\)\-]+$/", $_POST['name']);
            if($match)
                $this->template->bool = "true";
            else
                $this->template->bool = "false";
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_validatePhone()
    {

        if (isset($_POST['phone'])) 
        {
            $match = preg_match("/^\(\d\d\d\)\s*\d\d\d\-\d\d\d\d$/", $_POST['phone']);
            if($match)
                $this->template->bool = "true";
            else
                $this->template->bool = "false";
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_validateEmail()
    {

        if (isset($_POST['email'])) 
        {
            $userObj = Model_User::getUserObjByEmail($_POST['email']);
            if(!$userObj)
            {
                $this->template->bool = "true";
            }
            else
            {
                $this->template->bool = "false";		
            }
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_validateAge()
    {

        if (isset($_POST['birth_date'])) 
        {
            $age = (int)date('Y') - (int)date('Y',strtotime($_POST['birth_date']));
            if($age>=13)
                $this->template->bool = "true";
            else
                $this->template->bool = "false";		
        }
        else
        {
            $this->request->redirect('/');
        }
    }

    public function action_checkReview()
    {
        if (!$this->loginUserObj) 
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $this->loginUserObj->trashReview($data['id']);
            $this->template = View::factory('ajax/blank');
        }		
    }

    public function action_checkBooking()
    {
        if (!$this->loginUserObj) 
        {
            $this->request->redirect('/');
        }

        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $this->loginUserObj->trashBooking($data['id']);
            $this->template = View::factory('ajax/blank');

        }		
    }		
}
