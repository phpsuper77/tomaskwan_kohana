<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Search extends Controller_Site_Public
{
    public $template = 'site/index';

    public function before()
    {
        parent::before();
        $this->modelSearch = new Model_Search();
    }

    public function action_city_typedown()
    {
            // TODO to model
            $data = Arr::map('sanitizeHTMLValue', $this->request->query());
            $cache = Cache::instance();
            $ret = $cache->get('city6-typedown-'. strtolower($data['term']));
            if ($ret === null) {
                $cmd = "SELECT city from cities where ".
                    "lower(city) like '" .strtolower($data['term']) . "%' LIMIT 0,10";
                $query = DB::query(Database::SELECT, $cmd);
                $results = $query->execute()->as_array();
                $ret = array();
                foreach ($results as $result) {
                    $ret[] = array('id'=>ucwords($result['city']), 'value'=>ucwords($result['city']) ,'label'=>ucwords($result['city']));
                }
                $cache->set('city6-typedown-'.strtolower($data['term']), $ret);
            }

            // return json
            $this->auto_render = false;
            $this->is_ajax = TRUE;
            header('content-type: application/json');
            echo json_encode($ret);
            exit;
    }

    public function action_user_typedown()
    {
            // TODO to model
            $data = Arr::map('sanitizeHTMLValue', $this->request->query());
            $cache = Cache::instance();
            $ret = $cache->get('user6-typedown-'. strtolower($data['term']));
            if ($ret === null) {
                $cmd = "SELECT id, name from user where ".
                    "lower(name) like '" .strtolower($data['term']) . "%' AND enabled=1 AND role=4 LIMIT 0,10";
                $query = DB::query(Database::SELECT, $cmd);
                $results = $query->execute()->as_array();
                $ret = array();
                foreach ($results as $result) {
                    $userObj = Model_User::getUserObjById($result['id']);
                    if ($userObj) {
                        $ret[] = array('id'=>ucwords($result['name']), 'value'=>ucwords($result['name']) ,'label'=>'<img class="img-circle avatar-30" src="'.$userObj->getAvatarImageUrl().'">&nbsp;'.ucwords($result['name']));
                    }
                }
                $cache->set('user6-typedown-'.strtolower($data['term']), $ret);
            }

            // return json
            $this->auto_render = false;
            $this->is_ajax = TRUE;
            header('content-type: application/json');
            echo json_encode($ret);
            exit;
    }

    public function action_index()
    {
            $filter = Arr::map('sanitizeHTMLValue', $this->request->query());

            $this->template->content = View::factory('site/templates/search/index');

            if(!$filter['sort'])
            {
                $filter['sort'] = 'relevance';
            }

            if(!$filter['distance'])
            {
                $filter['distance'] = 15;
            }

            $filter['order'] = 'asc';

            //add to search history
            if($filter['title'] && !$filter['city'])
            {
                $this->modelSearch->addSearch($filter['title']);
            }
            if($filter['title'] && $filter['city'])
            {
                $this->modelSearch->addSearch($filter['title'],$filter['city']);	
            }

            $cache = Cache::instance();

            if($filter['city'])
            {
                $start = $cache->get('geo-'.strtolower($filter['city']));
                if (!$start) {
                    $start = Geocoder::geo('', $filter['city'], '', '');
                    $cache->set('geo-'.strtolower($filter['city']), $start);
                    if (!$start) {
                        unset($filter['city']);
                    }
                }
            }
            if(!$filter['city'] && $this->loginUserObj)
            {
                $start['lat'] = $this->loginUserObj->getLat();
                $start['lon'] = $this->loginUserObj->getLon();
            }
            if(!$filter['city'] && !$this->loginUserObj)
            {
                $filter['city'] = 'Roseville';
                $start = $cache->get('geo-'.strtolower($filter['city']));
                if (!$start) {
                    $start = Geocoder::geo('', $filter['city'], '', '');
                    $cache->set('geo-'.strtolower($filter['city']), $start);
                }
            }

            if ($start) {
                $filter['lat'] = $start['lat'];
                $filter['lon'] = $start['lon'];
            } else {
                $filter['lat'] = '33.8670578';
                $filter['lon'] = '-98.5272304';
            }

            // define pagination variables
            if (!$filter['page']) $filter['page'] = 1;
            $perPage = 5;
            $skip = ($filter['page'] - 1) * $perPage;
            $limit = $perPage;

            $dirObjs = Model_Directory::getDirectoryObjs($filter, $skip, $limit);
            $count = Model_Directory::getDirectoryObjCount($filter);

            $filter['page_count'] = (int)($count/$perPage);

            //calculate zoom
            $zoom = 18 - $filter['distance'];
            if($zoom < 11)
                $zoom = 11;

            $this->template->content->dirObjs = $dirObjs;
            $this->template->content->count = $count;

            $this->template->content->modelUser = $this->modelUser;
            $this->template->content->geodistance = $geodistance;
            $this->template->content->filter = $filter;
            $this->template->content->slider = $slider;
            $this->template->content->start = $start;
            $this->template->content->zoom = $zoom;

            if (Auth::instance()->logged_in_user())
            {
                $this->template->userBar->toggler = ' hidden';
            }
    }

    public function action_users()
    {
        if(isset($_GET['send']))
        {
            $filter = Arr::map('sanitizeHTMLValue', $this->request->query());

            $this->template->content = View::factory('site/templates/search/users');

            if(!$filter['sort'])
            {
                $filter['sort'] = 'name';
            }

            $filter['order'] = 'asc';

            // define pagination variables
            if (!$filter['page']) $filter['page'] = 1;
            $perPage = 5;
            $skip = ($filter['page'] - 1) * $perPage;
            $limit = $perPage;

            $dirObjs = Model_Directory::getDirectoryObjs($filter, $skip, $limit);
            $count = Model_Directory::getDirectoryObjCount($filter);

            $filter['page_count'] = (int)($count/$perPage);

            $this->template->content->dirObjs = $dirObjs;
            $this->template->content->count = $count;

            $this->template->content->modelUser = $this->modelUser;
            $this->template->content->geodistance = $geodistance;
            $this->template->content->filter = $filter;
            $this->template->content->slider = $slider;

            if (Auth::instance()->logged_in_user())
            {
                $this->template->userBar->toggler = ' hidden';
            }
        }
    }

}
