<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Static extends Controller_Site_Public
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
    }

    public function action_dmca()
    {
        $this->template->content = View::factory('site/templates/static/dmca');
    }

    public function action_send_us()
    {
        $data = Arr::map('sanitizeHTMLValue', $this->request->post());
        $data['ip'] = $_SERVER['REMOTE_ADDR'];

        sendMail('Contact Us','support@gymhit.com',json_encode($data));

        Cookie::set('success', __('THANK YOU. YOUR MESSAGE HAS BEEN SENT.'));
        $this->request->redirect('/static/contact_us');
    }

    public function action_about_us()
    {
        $this->template->content = View::factory('site/templates/static/about_us');
    }

    public function action_how_it_works()
    {
        $this->template->content = View::factory('site/templates/static/how_it_works');
    }

    public function action_terms_of_use()
    {
        $this->template->content = View::factory('site/templates/static/terms_of_use');
    }

    public function action_privacy()
    {
        $this->template->content = View::factory('site/templates/static/privacy');
    }

    public function action_contact_us()
    {
        $this->template->content = View::factory('site/templates/static/contact_us');
    }

    public function action_careers()
    {
        $this->template->content = View::factory('site/templates/static/careers');
    }
}
