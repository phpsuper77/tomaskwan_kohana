<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Page extends Model_Base {


    private function getPageById($id) {
        $query = DB::query(Database::SELECT,'SELECT * FROM page where id=:id');
        $query->param(':id', $id);
        $result = $query->execute(); 
        $items = $result->as_array();
        $ret = false;
        if (count($items) == 1) {
            $ret = $items[0];
        }
        return $ret;
    }

    public function getPageByRoute($route) {
        $query = DB::query(Database::SELECT,'SELECT * FROM page where route=:route');
        $query->param(':route', $route);
        $result = $query->execute(); 
        $items = $result->as_array();
        $ret = false;
        if (count($items) == 1) {
            $ret = $items[0];
        }
        return $ret;
    }

    public static function getPageByUserid($user_id) {
        $cache = Cache::instance();
        $pid = $cache->get(self::getCacheKey('uid2pid', $user_id));
        $ret = false;
        if ($pid !== null) {
            $ret = self::getPageObjById($pid);
        } else {
            $query = DB::query(Database::SELECT,'SELECT * FROM page where user_id = :user_id LIMIT 1');
            $query->param(':user_id', $user_id);
            $result = $query->execute(); 
            $items = $result->as_array();
            if (count($items) == 1) {
                $pid = $items[0]['id'];
                $cache->set(self::getCacheKey('uid2pid', $user_id), $pid);
                $ret = self::getPageObjById($pid);
            }
        }
        return $ret;
    }

    public function checkRoute($route) {
        $query = DB::query(Database::SELECT, 'SELECT COUNT(route) AS n FROM page WHERE route = :route')
            ->bind(':route', $route);
        $result = $query->execute(); 
        return $result->as_array();
    }

    public static function _isPageActive($user_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM page WHERE user_id=:user_id AND active = \'1\'')
            ->bind(':user_id', $user_id);
        $result = $query->execute()->as_array(); 
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePageVisit($id) {
        $query = DB::query(Database::UPDATE, 'UPDATE page SET visit = visit+1 WHERE id = :id')
            ->bind(':id', $id);
        $result = $query->execute();		
/*
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('page', $id));
*/
    }

    // object
/*
    public static function deletePage($user_id, $page_user_id) {
        // delete non-page
        $query = DB::query(Database::DELETE, 'DELETE FROM settings,status,comment,`like` WHERE user_id = :user_id')
            ->bind(':user_id', $page_user_id);
        $result = $query->execute();
        // delete page
        $query = DB::query(Database::DELETE, 'DELETE FROM page WHERE user_id = :user_id')
            ->bind(':user_id', $page_user_id);
        $result = $query->execute();
    }
*/

    public static function updateBackground($user_id, $file) {
        $query = DB::query(Database::SELECT,'SELECT * FROM page where user_id=:user_id');
        $query->param(':user_id', $user_id);
        $result = $query->execute(); 
        $pages = $result->as_array();
        $page = $pages[0];

        $query = DB::query(Database::UPDATE, 'UPDATE page SET background=:file WHERE id = :id')
            ->bind(':file', $file)
            ->bind(':id', $page['id']);
        $result = $query->execute();
        $cache = Cache::instance();
        $cache->delete(self::getCacheKey('page', $page['id']));
    }

/*
    public static function activePage($user_id, $page_user_id, $active) {
        $query = DB::query(Database::UPDATE, 'UPDATE page SET active=:active WHERE user_id = :user_id')
            ->bind(':active', $active)
            ->bind(':user_id', $page_user_id);
        $result = $query->execute(); 
        $query = DB::query(Database::SELECT, 'SELECT u.id,s.session,s.price,st.id AS time FROM user AS u JOIN setting AS s ON u.id=s.user_id LEFT JOIN setting_time AS st ON u.id=st.user_id WHERE superior_id=:user_id')
            ->bind(':user_id', $page_user_id);
        $users = $query->execute()->as_array();
        foreach($users as $user)
        {
            if($user['session']>0 && $user['price']>0 && $user['time']!=NULL)
            {
                $query = DB::query(Database::UPDATE, 'UPDATE page SET active=:active WHERE user_id = :user_id')
                    ->bind(':active', $active)
                    ->bind(':user_id', $user['id']);
                $result = $query->execute();
            }
        }
    }
*/

    public static function addPageObj($data) {
        $query = DB::query(Database::INSERT, 'INSERT INTO page (user_id, route, active) VALUES (:user_id, :route, :active)')
            ->bind(':user_id', $data['user_id'])
            ->bind(':route', $data['route'])
            ->bind(':active', $data['active']);
        $result = $query->execute();
    }

    public static function getPageObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('page', $id));
        if ($ret === null) {
            $factory = new Model_Page();
            $attrs = $factory->getPageById($id);
            if ($attrs)  {
                $ret = new Model_Page();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('page', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getPageObjByRoute($route) {
        if (empty($route)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('route2id', $route));
        if ($ret !== null) {
            $ret = self::getPageObjById($ret);
        } else {
            $factory = new Model_Page();
            $attrs = $factory->getPageByRoute($route);
            if ($attrs) {
                $cache->set(self::getCacheKey('route2id', $route), $attrs['id']);
                $ret = self::getPageObjById($attrs['id']);
            }
        }
        return $ret;
    }

    // attributes
    public function getId() {
        return $this->getAttr('id');
    }

    public function getPageUrl() {
        return PATH."page/".$this->getAttr('route');
    }

    public function getTitle() {
        return $this->getAttr('title');
    }

    public function getRoute() {
        return $this->getAttr('route');
    }

    public function getUserObj() {
        return Model_User::getUserObjById($this->getUserId());
    }

    public function getReviewObjs() {
        $filter['id'] = $this->getUserId();
        return Model_Review::getReviewObjs($filter);
    }

    public function getRatingObj() {
        return Model_Rating::getRatingObjById($this->getUserId());
    }

    public function getUserId() {
        return $this->getAttr('user_id');
    }

/*
    public function getRole() {
        return $this->getAttr('role');
    }

    public function getAddress() {
        return $this->getAttr('address');
    }

    public function getCity() {
        return $this->getAttr('city');
    }

    public function getZip() {
        return $this->getAttr('zip');
    }

    public function getAbout() {
        return $this->getAttr('about');
    }

    public function getUnits() {
        return unserialize($this->getAttr('unit'));
    }
*/

    public function isVisible($loginUserObj) {
        $ret = false;
        $userObj = $this->getUserObj();
        if ($loginUserObj && ($userObj->getId() == $loginUserObj->getId()))
        {
            // user's own page
            $ret = true;
        }
        else 
        {
            $settingObj = $userObj->getSettingObj();
            if ($settingObj->isPublic()) 
            {
                if ($settingObj->isProfileView() == 1) 
                {
                    // everyone can view this
                    $ret = true;
                } 
                else 
                {
                    // profile_view = 0
                    if ($loginUserObj && $loginUserObj->isConnected($userObj->getId())) {
                        // connected user
                        $ret = true;
                    }
                }
            }
        }
        return $ret;
    }

    public function hasReviewFrom($userObj) {
        $owner_id = $this->getUserId();

        $query = DB::query(Database::SELECT, 'SELECT * FROM review WHERE user_id=:user_id AND owner_id=:owner_id')
            ->bind(':user_id', $userObj->getId())
            ->bind(':owner_id', $owner_id);

        $result = $query->execute();
        if(count($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function allowMessage($loginUserObj)
    {
        $ret = false;
        if (!$loginUserObj ||  $this->getUserId() != $loginUserObj->getId()) {
            $ret = true;
        }
        return $ret;
    }

    public function allowBooking($loginUserObj)
    {
        $ret = false;
        if ($loginUserObj && $this->getUserId() != $loginUserObj->getId()) {
            if ($this->getAttr('booking') == 1) {
                $settingObj = $this->getUserObj()->getSettingObj();
                if ($settingObj->isBooking()) {
                    $ret = true;
                }
            }
        }
        return $ret;
    }

    public function allowFreePass($loginUserObj)
    {
        $ret = false;
        if ($loginUserobj && $loginUserObj->isRoleUser()) {
            if ($this->getUserId() != $loginUserObj->getId()) {
                $settingObj = $this->getUserObj()->getSettingObj();
                if ($settingObj->isFreePass()) {
                    $ret = true;
                }
            }
        }
        return $ret;
    }

    public function isPageActive() {
        return $this->getAttr('active') == 1;
    }

    public function getAvatarImageUrl() {
        return $this->getUserObj()->getAvatarImageUrl();
    }

    public function getAvatarUrl() {
        return $this->getUserObj()->getAvatarUrl();
    }

    public function getBackground() {
        return $this->getAttr('background');
    }

    public function getBackgroundUrl() {
        $ret = false;
        if ($this->isAttr('background') && $this->getAttr('background') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/pages/".$this->getAttr('id')."/bg/".$this->getAttr('background');
        }
        return $ret;
    }
}
