<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Base {

    const ROLE_ADMIN = '0';
    const ROLE_BUSINESS = '1';
    const ROLE_TRAINER = '2';
    const ROLE_USER = '4';
    const ROLE_SCHOOL = '5';
    /* TK - DO NOT KNOW WHAT IS ROLE 3 */

    /**
     * Post-registration setup. We call this when accessing dashboard.
     */
    public function setup() {
        $pageObj = $this->getPageObj();
        if (!$pageObj) {
            $page['user_id'] = $this->getId();
            $page['route'] = Util::prepareUrl($this->getName());
            $page['active'] = 0;
            Model_Page::addPageObj($page);
        }
        $settingObj = $this->getSettingObj();
        if (!$settingObj) {
            Model_Settings::addSettingObj($this->getId(),1,0,0,0);
        }
    }

/*
    public function getInvitedUserList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'name';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT u.*';
        $prequery .= ' FROM user AS u ';
        $prequery .= ' JOIN connect AS c ON u.id = c.user_invite';
        $prequery .= ' WHERE 1=1';
        $prequery .= ' AND c.user_id = '.$filter['id'].' AND c.invitation = 0';
        $prequery .= ' ORDER BY u.'.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute()->as_array(); 
        return $result;
    }

    public function getInvitionUserList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'name';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT u.*,p.route,p.active';
        $prequery .= ' FROM user AS u ';
        $prequery .= ' JOIN connect AS c ON u.id = c.user_id';
        $prequery .= ' WHERE 1=1';
        $prequery .= ' AND c.user_invite = '.$filter['id'].' AND c.invitation = 0';
        $prequery .= ' ORDER BY u.'.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute()->as_array(); 
        return $result;
    }
*/

/*
    public function getConnectedUserList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'id';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }
        $prequery = 'SELECT * FROM connect c ';
        $prequery .= ' WHERE 1=1';
        $prequery .= ' AND (c.user_id = '.$filter['id'].' OR c.user_invite = '.$filter['id'].') AND c.invitation = 1';
        if($filter['search'])
        {
            $prequery .= ' AND (u.name LIKE \'%'.$filter['search'].'%\' OR u.email LIKE \'%'.$filter['search'].'%\')';
        }
        $prequery .= ' ORDER BY c.'.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $result = $query->execute()->as_array(); 
        return $result;
    }
*/

/*
    public function getAllStaffList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'name';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT u.*,p.route,p.active,us.name AS sname,ps.route AS sroute';
        $prequery .= ',s.session,s.price';
        $prequery .= ' FROM user AS u r_id LEFT JOIN user AS us ON u.superior_id=us.id'.
            ' LEFT JOIN page AS ps ON u.superior_id=ps.user_id';
        $prequery .= ' JOIN setting AS s ON u.id = s.user_id';
        $prequery .= ' WHERE 1=1';
        $prequery .= ' AND u.superior_id = '.$filter['id'];
        $prequery .= ' ORDER BY u.'.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute()->as_array(); 
        return $result;
    }
*/

    public function getUsersListCount($filter) {

        $prequery = 'SELECT COUNT(*) as c FROM user AS u WHERE 1=1 ';

        if ($filter['role']) {
            $prequery .= ' AND role='.$filter['role'];
        }

        if (isset($filter['enabled'])) {
            if ($filter['enabled'] == '') {
            } else {
                $prequery .= ' AND enabled='.$filter['enabled'];
            }
        } else {
            $prequery .= ' AND enabled=1';
        }

        if($filter['search'])
        {
            $prequery .= ' AND (u.name LIKE \''.$filter['search'].'%\' OR u.email LIKE \''.$filter['search'].'%\')';
        }
        $query = DB::query(Database::SELECT, $prequery);
        $result = $query->execute()->as_array(); 
        $ret = 0;
        if (isset($result[0]['c'])) {
            $ret = $result[0]['c'];
        }
        return $ret;
    }

    public function getUsersList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'id';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT u.* FROM user AS u WHERE 1=1 ';

        if ($filter['all']) {
            // all user
        } else {
            $prequery .= ' AND enabled=1';
        }

        if ($filter['role']) {
            $prequery .= ' AND role='.$filter['role'];
        }

        if (isset($filter['enabled'])) {
            if ($filter['enabled'] == '') {
            } else {
                $prequery .= ' AND enabled='.$filter['enabled'];
            }
        } else {
            $prequery .= ' AND enabled=1';
        }

        if($filter['search'])
        {
            $prequery .= ' AND (u.name LIKE \''.$filter['search'].'%\' OR u.email LIKE \''.$filter['search'].'%\')';
        }
        $prequery .= ' ORDER BY u.'.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute()->as_array(); 
        return $result;
    }

    public function getStaffList($filter,$skip = 0,$limit = 10000) {
        if(!$filter['sort'])
        {
            $filter['sort'] = 'id';
        }
        if(!$filter['order'])
        {
            $filter['order'] = 'ASC';
        }

        $prequery = 'SELECT u.* FROM user AS u ';
        $prequery .= ' WHERE enabled=1';

        if($filter['superior_id'])
        {
            $prequery .= ' AND (u.superior_id='.$filter['superior_id'].')';
        }
        if($filter['search'])
        {
            $prequery .= ' AND (u.name LIKE \'%'.$filter['search'].'%\' OR u.email LIKE \'%'.$filter['search'].'%\')';
        }
        $prequery .= ' ORDER BY u.'.$filter['sort'].' '.$filter['order'].' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute()->as_array(); 
        $ret = array();
        foreach ($result as $r) {
            $i = new Model_User();
            $i->setAttrs($r);
            $ret[] = $i;
        }
        return $ret;
    }

    public function getUsersFilter($filter) {
        $prequery = 'SELECT u.* FROM user AS u';
        if($filter['type'] != 'all')
        {
            $prequery .= ' JOIN connect AS c ON (u.id = c.user_id OR u.id = c.user_invite)';
        }

        $prequery .= ' WHERE u.role = 4';

        if($filter['id'])
        {
            $prequery .= ' AND u.id != '.$filter['id'];
        }

        if($filter['type'] != 'all')
        {
            $prequery .= ' AND (c.user_id = '.$filter['id'].' OR c.user_invite = '.$filter['id'].') AND u.id != '.$filter['id'].' AND c.invitation = 1';
        }
        $prequery .= ' AND u.name LIKE \'%'.$filter['name'].'%\' ORDER BY u.name ASC';

        $query = DB::query(Database::SELECT, $prequery);
        $result = $query->execute()->as_array(); 
        return $result;
    }

    public static function getCountByRole($role) {
        $query = DB::query(Database::SELECT, 'SELECT COUNT(*) AS rows FROM user WHERE role = :role');
        $query->param(':role', $role);
        $result = $query->execute(); 
        return $result->as_array()['0']['rows'];
    }

/*
    public function getDirectoryListCount($filter) {
        $prequery = 'SELECT COUNT(*) as c FROM user AS u '.
            'WHERE u.role != \'0\' AND u.enabled = \'1\'';

        if($filter['role']==Model_User::ROLE_USER)
        {
            $prequery .= ' AND u.role = \'4\'';	
        }
        elseif($filter['role']==2)
        {
            $prequery .= ' AND u.role = \'2\'';
        }
        else
        {
            $prequery .= ' AND u.role != \'4\'';
        }

        if($filter['title'])
        {
            $prequery .= ' AND u.title = \''.$filter['title'].'\'';	
        }

        if($filter['name'])
        {
            $prequery .= ' AND u.name LIKE \'%'.$filter['name'].'%\'';	
        }

        $prequery .= ' AND ((6373 * acos(cos(radians(' . $filter['lat']. ')) * cos (radians(lat)) * cos (radians(lon) - radians(' .$filter['lon'].')) + sin(radians('.$filter['lat'].')) * sin(radians(lat)))) < '. $filter['distance'].')';	

        $query = DB::query(Database::SELECT, $prequery);
        $result = $query->execute()->as_array(); 
        return $result[0]['c'];
    }

    public function getDirectoryList($filter, $skip = 0,$limit = 10000) {
        $prequery = 'SELECT u.* FROM user AS u '.
            'WHERE u.role != \'0\' AND u.enabled = \'1\'';

        if($filter['role']==Model_User::ROLE_USER)
        {
            $prequery .= ' AND u.role = \'4\'';	
        }
        elseif($filter['role']==2)
        {
            $prequery .= ' AND u.role = \'2\'';
        }
        else
        {
            $prequery .= ' AND u.role != \'4\'';
        }


        if($filter['title'])
        {
            $prequery .= ' AND u.title = \''.$filter['title'].'\'';	
        }

        if($filter['name'])
        {
            $prequery .= ' AND u.name LIKE \'%'.$filter['name'].'%\'';	
        }

        $prequery .= ' AND ((6373 * acos(cos(radians(' . $filter['lat']. ')) * cos (radians(lat)) * cos (radians(lon) - radians(' .$filter['lon'].')) + sin(radians('.$filter['lat'].')) * sin(radians(lat)))) < '. $filter['distance'].')';	

        if($filter['sort'] == 'name' || $filter['sort'] == 'distance' || $filter['sort'] == 'rating')
            $prequery .= ' ORDER BY u.name ASC';
        else
            $prequery .= ' ORDER BY u.'.$filter['sort'].',u.name ASC';
        $prequery .= ' LIMIT :skip,:limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);

        $result = $query->execute()->as_array(); 
        return $result;
    }
*/

    public function addUser($data) {
        if (!isset($data['create_date'])) {
            $data['create_date'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['active_date'])) {
            $data['active_date'] = date('Y-m-d H:i:s');
        }
        $query = DB::query(Database::INSERT, 
            'INSERT INTO user (name, password ,email, birth_date, title, address, city, state, zip, phone, role, create_date, active_date, superior_id, enabled, src) ' .
            'VALUES (:name, :password, :email, :birth_date, :title, :address, :city, :state, :zip, :phone, :role, :create_date, :active_date, :superior_id, :enabled, :src)')
            ->bind(':name', $data['name'])
            ->bind(':password', $data['password'])
            ->bind(':email', $data['email'])
            ->bind(':birth_date', $data['birth_date'])
            ->bind(':title', $data['title'])
            ->bind(':address', $data['address'])
            ->bind(':city', $data['city'])
            ->bind(':state', $data['state'])
            ->bind(':zip', $data['zip'])
            ->bind(':phone', $data['phone'])
            ->bind(':role', $data['role'])
            ->bind(':create_date', $data['create_date'])
            ->bind(':active_date', $data['active_date'])
            ->bind(':superior_id', $data['superior_id'])
            ->bind(':src', $data['src'])
            ->bind(':enabled', $data['enabled']);

        $result = $query->execute();

        return $result[0];
    }

    public function getUserByEmail($email) {

        $query = DB::query(Database::SELECT, 'SELECT * from user WHERE email = :email');
/*
        $query = DB::query(Database::SELECT, 'SELECT u.*, p.id AS page_id,p.route FROM user AS u LEFT JOIN page AS p ON u.id = p.user_id WHERE u.email = :email');
*/

        $query->param(':email', $email);
        $result = $query->execute(); 
        return $result->as_array();
    }

    public function getUserById($id) {
        $query = DB::query(Database::SELECT, 'SELECT * from user WHERE id = :id');
/*
        $query = DB::query(Database::SELECT, 'SELECT u.*, p.id AS page_id,p.background,p.route,s.profile_view,s.booking,s.free_pass,s.spec_offer,s.session,s.price,'.
            's.email AS semail,s.sms,sb.price_1,sb.price_3,sb.price_12,sb.period,sb.op_key '.
            ' FROM user AS u LEFT JOIN page AS p ON u.id = p.user_id LEFT JOIN setting AS s ON u.id = s.user_id LEFT JOIN setting_bill AS sb ON u.id=sb.user_id'.
            ' WHERE u.id = :id');
*/
        $query->param(':id', $id);
        $result = $query->execute(); 
        return $result->as_array();
    }

    public function getUserEmail($id) {
        $query = DB::query(Database::SELECT, 'SELECT email FROM user WHERE id = :id');
        $query->param(':id', $id);
        $result = $query->execute()->as_array(); 
        return $result[0]['email'];
    }

    public static function deleteCache($user_id) {
        $cache = Cache::instance();
        $userObj = self::getUserObjById($user_id);
        if ($userObj) {
            $cache->delete(self::getCacheKey('email', $userObj->getEmail()));
            $cache->delete(self::getCacheKey('user', $userObj->getId()));
        }
    }

/*
    public function deleteUser($id) {
        $query = DB::query(Database::DELETE, 'DELETE FROM user WHERE id = :id')
            ->bind(':id', $id);
        $result = $query->execute();
    }
*/

    public static function _updateAuthCode($user_id, $code) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET auth_code=:code WHERE id = :id')
            ->bind(':code', $code)
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

    public static function updateRating($user_id, $rating) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET rating=:rating WHERE id = :id')
            ->bind(':rating', $rating)
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

    public static function _updateFacebookId($user_id, $fid) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET fid=:fid WHERE id = :id')
            ->bind(':fid', $fid)
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

    public static function setActiveDate($id) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET active_date=:active_date WHERE id = :id')
            ->bind(':active_date', date('Y-m-d H:i:s'))
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

/*
    private static function _inviteUser($user_id, $user_invite, $invitation, $date=false) {
        if (!$date) {
            $date = date('Y-m-d H:i:s');
        }
        $query = DB::query(Database::INSERT, 'INSERT INTO connect (user_id,user_invite,invitation,date) VALUES (:user_id,:user_invite,:invitation,:date)')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite)
            ->bind(':invitation', $invitation)
            ->bind(':date', $date);
        $result = $query->execute();
    }
*/

/*
    private static function _deleteInvite($user_id, $user_invite) {
        $query = DB::query(Database::UPDATE, 'DELETE FROM connect WHERE invitation=0 AND user_id=:user_id AND user_invite=:user_invite')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
    }
*/

/*
    private static function _connectUser($user_id, $user_invite) {
        $query = DB::query(Database::UPDATE, 'UPDATE connect SET invitation=1 WHERE user_id=:user_id AND user_invite=:user_invite')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
    }
*/

/*
    private static function _disconnectUser($user_id, $user_invite) {
        $query = DB::query(Database::UPDATE, 'DELETE FROM connect WHERE user_id=:user_id AND user_invite=:user_invite')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
        $query = DB::query(Database::UPDATE, 'DELETE FROM connect WHERE user_id=:user_invite AND user_invite=:user_id')
            ->bind(':user_id', $user_id)
            ->bind(':user_invite', $user_invite);
        $result = $query->execute();
    }
*/

    public function isSuperior($id,$superior_id) {

        $query = DB::query(Database::SELECT, 'SELECT * FROM user WHERE id=:id AND superior_id = :superior_id')
            ->bind(':id', $id)
            ->bind(':superior_id', $superior_id);
        $result = $query->execute()->as_array(); 

        if(count($result) > 0)
            return TRUE;
        else
            return FALSE;
    }

    private function getNetworkComments($user_id) {

        $query = DB::query(Database::SELECT, 'SELECT c.date,u.name,p.route FROM status AS s JOIN comment AS c ON s.id = c.status_id '.
            'JOIN user AS u ON u.id=s.user_id LEFT JOIN page AS p ON p.user_id = s.user_id WHERE c.user_id=:user_id')
            ->bind(':user_id', $user_id);

        $result = $query->execute();
        return $result->as_array();
    }

    private function getNetworkLikes($user_id) {

        $query = DB::query(Database::SELECT, 'SELECT l.date,l.category,u1.name AS sname,u2.name AS cname,'.
            'p1.route AS sroute,p2.route AS croute FROM `like` AS l LEFT JOIN status AS s ON s.id = l.item_id LEFT JOIN comment AS c ON c.id = l.item_id '.
            'LEFT JOIN user as u1 ON u1.id = s.user_id LEFT JOIN user as u2 ON u2.id = c.user_id LEFT JOIN page AS p1 ON p1.user_id = u1.id '.
            'LEFT JOIN page AS p2 ON p2.user_id = u2.id WHERE l.user_id=:user_id')
            ->bind(':user_id', $user_id);

        $result = $query->execute();
        return $result->as_array();
    }

    public function getNetworkNews($user_id) {

        $filter['type'] = 'connections';
        $filter['id'] = $user_id;
        $news = array();
        $i = 0;

        $connects = $this->getUsersList($filter);


        foreach($connects as $connect)
        {

            $filter['id'] = $connect['id'];

            $friendConnects = $this->getUsersList($filter,0,6);
            foreach($friendConnects as $friendConnect)
            {
                $news[$i]['from_name'] = $connect['name'];
                $news[$i]['from_route'] = $connect['route'];
                $news[$i]['from_avatar'] = $connect['avatar'];
                $news[$i]['from_id'] = $connect['id'];
                $news[$i]['from_title'] = $connect['title'];
                $news[$i]['to_name'] = $friendConnect['name'];
                $news[$i]['to_route'] = $friendConnect['route'];
                $news[$i]['date'] = $friendConnect['date'];
                $news[$i]['type'] = 'connect';
                $i++;				
            }
            $friendComments = $this->getNetworkComments($filter['id']);
            foreach($friendComments as $friendComment)
            {
                $news[$i]['from_name'] = $connect['name'];
                $news[$i]['from_route'] = $connect['route'];
                $news[$i]['from_avatar'] = $connect['avatar'];
                $news[$i]['from_id'] = $connect['id'];
                $news[$i]['from_title'] = $connect['title'];
                $news[$i]['to_name'] = $friendComment['name'];
                $news[$i]['to_route'] = $friendComment['route'];
                $news[$i]['date'] = $friendComment['date'];
                $news[$i]['type'] = 'comment';
                $i++;				
            }
            $friendLikes = $this->getNetworkLikes($filter['id']);
            foreach($friendLikes as $friendLike)
            {
                $news[$i]['from_name'] = $connect['name'];
                $news[$i]['from_route'] = $connect['route'];
                $news[$i]['from_avatar'] = $connect['avatar'];
                $news[$i]['from_id'] = $connect['id'];
                $news[$i]['from_title'] = $connect['title'];
                if($friendLike['category'] == 'status')
                {
                    $news[$i]['to_name'] = $friendLike['sname'];
                    $news[$i]['to_route'] = $friendLike['sroute'];
                }
                else
                {
                    $news[$i]['to_name'] = $friendLike['cname'];
                    $news[$i]['to_route'] = $friendLike['croute'];
                }
                $news[$i]['date'] = $friendLike['date'];
                $news[$i]['type'] = 'like_'.$friendLike['category'];
                $i++;				
            }		
        }

        if(count($news) > 0)
        {
            //sort by date
            foreach($news as $key => $value)
            {
                $date[$key]  = $value['date'];
            }
            array_multisort($date, SORT_ASC, $news);
        }

        return $news;	
    }

    public function checkAge($id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM user WHERE id=:id')
            ->bind(':id', $id);
        $result = $query->execute()->as_array(); 

        $age = (int)date('Y') - (int)date('Y',strtotime($result[0]['birth_date']));

        if($age >= 18)
            return TRUE;
        else
            return FALSE;
    }

    // object
    public static function _activateUser($user_id, $uid, $active) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET enabled=:active WHERE id = :user_id')
            ->bind(':active', $active)
            ->bind(':user_id', $uid);
        $result = $query->execute();
        self::deleteCache($uid);
    }

    public function getJobSeekerObjs($data, $skip=0, $limit=10000) {
        $ret = array();
        $prequery = 'select page.id as page_id, page.*, user.* from user left join page on (user.id=page.user_id) left join setting on (user.id=setting.user_id) where ';
        $prequery .= ' user.role='.Model_User::ROLE_TRAINER;
        $prequery .= ' and setting.job=1';
        if($data['radius'])
        {
            $prequery .= ' AND ( 3959 * acos (cos ( radians('.$this->getLat().') ) * cos( radians( user.lat ) ) * cos( radians( user.lon ) - radians('.$this->getLon().') )  + sin( radians('.$this->getLat().') )  * sin( radians( user.lat ) )  ) < ' . $data['radius'] .')';
        }
        if($data['zip'])
        {
            $prequery .= ' AND (user.zip LIKE \'%'.$data['zip'].'%\')';
        }
        if($data['search'])
        {
            $prequery .= ' AND (user.name LIKE \'%'.$data['search'].'%\')';
        }
        $prequery .= ' limit :skip, :limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $attrs_set = $query->execute()->as_array(); 
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getEmployerObjs($data, $skip=0, $limit=10000) {
        $ret = array();
        $prequery = 'select page.id as page_id, page.*, user.* from user left join page on (user.id=page.user_id) left join setting on (user.id=setting.user_id) where ';
        $prequery .= ' (user.role='.Model_User::ROLE_BUSINESS.' or user.role='.Model_User::ROLE_SCHOOL.') ';
        $prequery .= ' and setting.job=1 ';
        if($data['radius'])
        {
            $prequery .= ' AND ( 3959 * acos (cos ( radians('.$this->getLat().') ) * cos( radians( user.lat ) ) * cos( radians( user.lon ) - radians('.$this->getLon().') )  + sin( radians('.$this->getLat().') )  * sin( radians( user.lat ) )  ) < ' . $data['radius'] .')';
        }
        if($data['zip'])
        {
            $prequery .= ' AND (user.zip LIKE \'%'.$data['zip'].'%\')';
        }
        if($data['search'])
        {
            $prequery .= ' AND (user.name LIKE \'%'.$data['search'].'%\')';
        }
        $prequery .= ' limit :skip, :limit';
        $query = DB::query(Database::SELECT, $prequery)
            ->bind(':skip', $skip)
            ->bind(':limit', $limit);
        $attrs_set = $query->execute()->as_array(); 
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function connectEmployee($user_id,$superior_id) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM user WHERE superior_id=:user_id')
            ->bind(':user_id', $superior_id);
        $users = $query->execute()->as_array();
        if(count($users) > 0)
        {
            $data['invitation'] = 1;
            foreach($users as $user)
            {
                $data['user_id'] = $user['id'];
                $data['user_invite'] = $user_id;
                self::inviteUser($data);							
            }
        }
    }

    public static function updatePasswordInfo($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET password=:password WHERE id = :id')
            ->bind(':password', $data['password'])
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

    public static function updateAvatarInfo($user_id, $file) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET avatar=:file WHERE id = :id')
            ->bind(':file', $file)
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

    public static function updateUserInfo($user_id, $data) {
        $query = DB::query(Database::UPDATE, 'UPDATE user SET name=:name, address=:address, city=:city, state=:state, zip=:zip, phone=:phone, about=:about, unit=:unit,'.
            ' title=:title WHERE id = :id')
            ->bind(':name', $data['name'])
            ->bind(':title', $data['title'])
            ->bind(':address', $data['address'])
            ->bind(':city', $data['city'])
            ->bind(':state', $data['state'])
            ->bind(':zip', $data['zip'])
            ->bind(':phone', $data['phone'])
            ->bind(':about', $data['about'])
            ->bind(':unit', $data['unit'])
            ->bind(':id', $user_id);
        $result = $query->execute();
        self::deleteCache($user_id);
    }

    public static function isConnect($user_id,$user2,$invitation=1) {
        $query = DB::query(Database::SELECT, 'SELECT * FROM connect WHERE user_id=:user1 AND user_invite=:user2 OR user_id=:user2 AND user_invite=:user1 '.
            'AND invitation = :invitation')
            ->bind(':user1', $user_id)
            ->bind(':user2', $user2)
            ->bind(':invitation', $invitation);
        $result = $query->execute()->as_array(); 

        if(count($result) > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function connectStaff($id) 
    {
        $data['user_id'] = $id;
        Model_Staff::addStaff($this->getId(), $data);    
    }

    public function disconnectStaff($id) 
    {
        $data['user_id'] = $id;
        Model_Staff::removeStaff($this->getId(), $data);    
    }

    public function addStaffObj($data) 
    {
        $id = Model_User::addUserObj($data);
        // connect up superior automatically
        Model_Invite::addInvite($data['superior_id'], $id, 1);
        // connect to everybody in unit
        self::connectEmployee($id,$data['superior_id']);
        return $id;
    }


    public static function addUserObj($data, $notify = true) 
    {
        $ret = false;

        // figure out geo before adding
        $map = new GoogleMapAPI();
        $gcode = $map->getGeoCode($data['address'].','.$data['city'].','.$data['zip']);
        $data['lat'] = $gcode['lat'];
        $data['lon'] = $gcode['lon'];

        // disable user by default
        if ($data['role'] == Model_User::ROLE_USER) {
            // user requires no approval
            $data['enabled'] = 1;
        } else {
            $data['enabled'] = 0;
        }

        // add user to database
        $factory = new Model_User();
        $user_id = $factory->addUser($data);

        $ret = $user_id;

        $page['user_id'] = $user_id;

        // add page
        $n = 0;
        do {
            if ($n == 0) {
                $page['route'] = Util::prepareUrl($data['name']);
            } else {
                $page['route'] = Util::prepareurl($data['name']).'-'.$n;
            }
            $busy = Model_Page::getPageObjByRoute($page['route']);
            $n++;
        } while($busy);

        if($data['role'] == Model_User::ROLE_USER)
        {
            $page['active'] = 1;
            Model_Settings::addSettingObj($user_id,1);
        }
        else
        {
            $page['active'] = 0;
            Model_Settings::addSettingObj($user_id,1,0,0,0);
            Model_Settings::addBillingSettingObj($user_id);
        }
        Model_Page::addPageObj($page);

        // send email
        if ($notify) {
            $body = View::factory('site/emails/template');
            if($data['role'] == Model_User::ROLE_USER)
            {
                $body->text = View::factory('site/emails/register_user');
            }
            else
            {
                $body->text = View::factory('site/emails/register_business');
            }
            $body->text->username = $data['name'];
            Util::sendMail('Welcome to Gymhit',$data['email'],$body);

            if($data['phone'])
            {
                //sending sms
                $body = View::factory('site/sms/register');
                sendSMS($data['phone'],$body);
            }
        }

        return $ret;
    }

    public static function getAllStaffObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getAllStaffList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getConnectionObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        return Model_Connection::getConnectionObjs($filter, $skip, $limit);
    }
/*
    public function getStaffCandidateObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $staffObjs = $this->getStaffObjs();
        $map = array();
        foreach ($staffObjs as $staffObj) {
          $map[$staffObj->getAttr('user_id')] = 1;
        }
        $filter['id'] = $this->getId();
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getConnectedUserList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            if (isset($map[$attrs['id']])) continue;
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
*/

/*
    public function getConnectedUserObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $filter['id'] = $this->getId();
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getConnectedUserList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = self::getUserObjById($attrs['user_id']);
            if ($obj) {
                $ret[] = $obj;
            }
        }
        return $ret;
    }
*/

    public function getInviteObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $filter['user_id'] = $this->getId();
        return Model_Invite::getInviteObjs($filter, $skip, $limit);
    }

/*
    public function getInvitedUserObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $filter['id'] = $this->getId();
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getInvitedUserList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public function getInviteUserObjs($skip=0, $limit= 10000) {
        $filter = array('type'=>'invitations','id'=>$this->getId());
        return self::getInvitedUserObjs($filter, $skip, $limit);
    }

    public function getInvitionUserObjs() {
        $filter = array('type'=>'invitations','id'=>$this->getId());
        return self::_getInvitionUserObjs($filter);
    }

    public static function _getInvitionUserObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getInvitionUserList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
*/

    public static function getUserObjsCount($filter = array())
    {
        $factory = new Model_User();
        $ret = $factory->getUsersListCount($filter);
        return $ret;
    }

    public static function getUserObjs($filter = array(), $skip = 0,$limit = 10000) 
    {
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getUsersList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }

    public static function getUserObjById($id) {
        if (empty($id)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('user', $id));
        if ($ret === null) {
            $factory = new Model_User();
            $attrs_set = $factory->getUserById($id);
            if (count($attrs_set) == 1) {
                $attrs  = $attrs_set[0];
                $ret = new Model_User();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('email', $ret->getEmail()), $ret->getId());
                $cache->set(self::getCacheKey('user', $id), $ret);
            }
        }
        return $ret;
    }

    public static function getUserObjByEmail($email) {
        if (empty($email)) {
            return false;
        }
        $cache = Cache::instance();
        $ret = $cache->get(self::getCacheKey('email', $email));
        if ($ret !== null) {
            $ret = self::getUserObjById($ret);
        } else {
            $factory = new Model_User();
            $attrs_set = $factory->getUserByEmail($email);
            if (count($attrs_set) == 1) {
                $attrs  = $attrs_set[0];
                $ret = new Model_User();
                $ret->setAttrs($attrs);
                $cache->set(self::getCacheKey('email', $ret->getEmail()), $ret->getId());
                $cache->set(self::getCacheKey('user', $id), $ret);
            }
        }
        return $ret;
    }


/*
    public static function getDirectoryObjCount($filter) {
        $factory = new Model_User();
        return $factory->getDirectoryListCount($filter);
    }

    public static function getDirectoryObjs($filter, $skip = 0, $limit = 10000) {
        $ret = array();
        $factory = new Model_User();
        $attrs_set = $factory->getDirectoryList($filter, $skip, $limit);
        foreach ($attrs_set as $attrs) {
            $obj = new Model_User();
            $obj->setAttrs($attrs);
            $ret[] = $obj;
        }
        return $ret;
    }
*/

    // pages
    public function getPageObjByRoute($route) {
        return Model_Page::getPageObjByRoute($route);
    }

    public function getPageObj() {
        return Model_Page::getPageByUserid($this->getId());
    }

    // free passes
    public function checkFreePass($owner_id) {
        return Model_Freepass::checkFreePass($this->getId(), $owner_id);
    }

    public function addFreePass($data) {
        return Model_Freepass::addFreePass($this->getId(), $data);
    }

    public function getFreePassObjs($filter=array(), $skip=0, $limit=10000) {
        return Model_Freepass::getFreePassObjs($this->getId(), $filter, $skip, $limit);
    }

    public function getReviewObjs($filter=array(), $skip=0, $limit=10000) {
        $filter['id'] = $this->getId();
        return Model_Review::getReviewObjs($filter, $skip, $limit);
    }

    public function getNoteObjs() {
        return Model_Review::getNoteObjs($this->getId());
    }

/*
    public function getConnectionObjs($filter, $skip=0, $limit=10000) {
        $filter['id'] = $this->getId();
        return Model_Dashboard::getConnectionObjs($filter, $skip, $limit);
    }
 */

    public function getTimeSettingObjs() {
        return Model_Timesettings::getTimeSettingObjs($this->getId());
    }

    public function getStaffTimeSettingObjs($owner_id) {
        return Model_StaffTimeSettings::getStaffTimeSettingObjs($this->getId(), $owner_id);
    }

    public function getUserObj($user_id) {
        return Model_User::getUserObjById($user_id);
    }

    public function getFriendObjs($filter = array(), $skip=0, $limit=10000) {
        $filter['type'] = 'connections';
        $filter['id'] = $this->getId();
        return self::getConnectedUserObjs($filter, $skip, $limit);
    }

/*
    public function getStaffObjsOLD($filter, $skip=0, $limit=10000) {
        $filter['type'] = 'staff';
        if (!isset($filter['superior_id'])) {
            $filter['superior_id'] = $this->getId();
        }
        return self::getStaffList($filter, $skip, $limit);
    }
*/

    public function getStaffObjs($filter = array(), $skip=0, $limit=10000) {
        $filter['owner_id'] = $this->getId();
        return Model_Staff::getStaffObjs($filter, $skip, $limit);
    }

    public function getStaffOfObjs($filter = array(), $skip=0, $limit=10000) {
        $filter['user_id'] = $this->getId();
        return Model_Staff::getStaffObjs($filter, $skip, $limit);
    }

    public function addStaffSettingTime($owner_id,$day,$time_from,$time_to,$time_custom) {
        Model_StaffTimeSettings::addTime($this->getId(),$owner_id,$day,$time_from,$time_to,$time_custom);
    }

    public function deleteStaffSettingTime($owner_id) {
        Model_StaffTimeSettings::deleteTime($this->getId(), $owner_id);
    }

    public function updateStaffSetting($data) {
        Model_StaffSettings::updateStaffSetting($this->getId(), $data);
    }

    public function getStaffSettingObj($owner_id) {
        $obj = Model_StaffSettings::getStaffSettingObjById($this->getId(), $owner_id);
        if (!$obj) {
            $data['owner_id'] = $owner_id;
            $data['enabled'] = 0;
            $data['price'] = 0;
            $data['session'] = 3600;
            $id = Model_StaffSettings::addStaffSettingObj($this->getId(), $data);
            $obj = Model_StaffSettings::getStaffSettingObjById($this->getId(), $id);
        }
        return $obj;
    }

    // friend
    public function isConnected($user_id, $invite=1) {
        return self::isConnect($this->getId(), $user_id, $invite);
    }

    public function isInvited($user_id) {
        return Model_Invite::isInvited($this->getId(), $user_id);
    }

    // status
    public function addStatus($data) {
        return Model_Status::addStatus($this->getId(), $data);
    }

    public function getStatusObjById($id) {
        return Model_Status::getStatusObjById($this->getId(), $id);
    }

    public function updateStatus($data) {
        return Model_Status::updateStatus($this->getId(), $data);
    }

    public function updateStatusShare($id) {
        return Model_Status::updateStatusShare($this->getId(), $id);
    }

    public function deleteStatus($id) {
        return Model_Status::deleteStatus($this->getId(), $id);
    }

    // comment
    public function getCommentObjById($id) {
        return Model_Status::getCommentObjById($this->getId(), $id);
    }

    public function addComment($data) {
        return Model_Status::addComment($this->getId(), $data);
    }

    public function addLike($data) {
        return Model_Status::addLike($this->getId(), $data);
    }

    // offer
    public function addOffer($data) {
        return Model_Specoffer::addOffer($this->getId(), $data);
    }

    public function updateOffer($data) {
        return Model_Specoffer::updateOffer($this->getId(), $data);
    }

    public function updateClassImage($id, $filename) {
        return Model_Class::updateImage($this->getId(), $id, $filename);
    }

    public function updateOfferImage($id, $filename) {
        return Model_Specoffer::updateImage($this->getId(), $id, $filename);
    }

    public function getOfferObjs($data, $skip=0, $limit=10000) {
        return Model_Specoffer::getOfferObjs($this->getId(), $data, $skip, $limit);
    }

    public function deleteOffer($id) {
        return Model_Specoffer::deleteOffer($this->getId(), $id);
    }

    public function activeOffer($id, $active) {
        return Model_Specoffer::activeOffer($this->getId(), $id, $active);
    }

    // unit
    public function addUnit($data) {
        return Model_Unit::addUnit($this->getId(), $data);
    }

    public function updateUnit($data) {
        return Model_Unit::updateUnit($this->getId(), $data);
    }

    public function deleteUnit($id) {
        return Model_Unit::deleteUnit($this->getId(), $id);
    }

    // message
    public function canNotify($type) {
        return Model_Settings::checkNotify($this->getId(), $data);
    }

    public function addMessage($data) {
        return Model_Message::addMessage($this->getId(), $data);
    }

    public function getMessageObjById($id) {
        return Model_Message::getMessageObjById($this->getId(), $id);
    }

    public function getMessageObjs($trash, $direction, $skip = 0, $limit = null, $check = null) {
        return Model_Message::getMessageObjs($this->getId(), $trash, $direction, $skip, $limit, $check);
    }

    public function checkMessage($id) {
        return Model_Message::checkMessage($this->getId(), $id);
    }

    public function deleteMessage($id) {
        return Model_Message::deleteMessage($this->getId(), $id);
    }

    public function trashMessage($id, $check) {
        return Model_Message::trashMessage($this->getId(), $id, $check);
    }

    // invoices
    public function getInvoiceObjs($filter, $skip=0, $limit = 10000) {
        return Model_Invoice::getInvoiceObjs($this->getId(), $filter, $skip, $limit);
    }

    public function getInvoiceObjById($id) {
        return Model_Invoice::getInvoiceObjById($this->getId(), $id);
    }

    public function payInvoice($id) {
        return Model_Invoice::payInvoice($this->getId(), $id);
    }

    public function addInvoice($data) {
        return Model_Invoice::addInvoice($this->getId(), $data);
    }

    public function updateInvoice($data) {
        return Model_Invoices::updateInvoice($this->getId(), $data);
    }

    // user
    public function deleteInvite($id) {
        return Model_Invite::deleteInvite($this->getId(), $id);
    }

    public function connectUser($id) {
        $this->deleteInvite($id);
        return Model_Connection::addConnection($this->getId(), $id);
    }

    public function disconnectUser($id) {
        return Model_Connection::deleteConnection($this->getId(), $id);
    }

    public function inviteUser($data) {
        return Model_Invite::addInvite($data['user_id'], $data['user_invite'], $data['invitation'], $data['date']);
    }

    public function updateUser($data) {
        return Model_User::updateUserInfo($this->getId(), $data);
    }

    public function updateAvatar($filename) {
        return Model_User::updateAvatarInfo($this->getId(), $filename);
    }

    public function updateBackground($filename) {
        return Model_Page::updateBackground($this->getId(), $filename);
    }

    public function updatePassword($data) {
        return Model_User::updatePasswordInfo($this->getId(), $data);
    }

    // settings
    public function getSettingObj() {
        return Model_Settings::getSettingObjbyId($this->getId());
    }

    public function addTime($day,$time_from,$time_to,$time_custom) {
        Model_Settings::addTime($this->getId(),$day,$time_from,$time_to,$time_custom);
    }

    public function deleteTime() {
        Model_Settings::deleteTime($this->getId());
    }

    public function updateSettings($data) {
        return Model_Settings::updateSettings($this->getId(), $data);
    }

    public function updateSocial($data) {
        return Model_Settings::updateSocial($this->getId(), $data);
    }

    public function updateSession($data) {
        return Model_Settings::updateSession($this->getId(), $data);
    }

    public function canAcceptOrder() {
        $ret = false;
        $billSetting = $this->getBillingSettingObj();
        if ($billSetting && $billSetting->isAttr('op_key')) {
            $ret = true;
        } else {
            $superiorObj = $this->getSuperiorObj();
            if ($superiorObj) {
                $billSetting = $superiorObj->getBillingSettingObj();
                if ($billSetting && $billSetting->isAttr('op_key')) {
                    $ret = true;
                }
            }
        }
        return $ret;
    }

    public function canAcceptTour() {
        $avaObjs = $this->getAvailabilityObjs();
        return (count($avaObjs) > 0);
    }

    public function canAcceptSession() {
        return $this->canAcceptOrder();
    }

    public function getBillingSettingObj() {
        return Model_Settings::getBillingSettingObjById($this->getId());
    }

    public function updateBillingSettings($data) {
        return Model_Settings::updateBillingSettings($this->getId(), $data);
    }

    // admin
    public function activateUser($user_id, $active) {
        return self::_activateUser($this->getId(), $user_id, $active);
    }

    // page
    public function activePage($page_user_id, $active) {
        return Model_Page::activePage($this->getId(), $page_user_id, $active);
    }

    // image
    public function addImage($data) {
        return Model_Gallery::addImage($this->getId(), $data);
    }

    public function deleteImage($id) {
        return Model_Gallery::deleteImage($this->getId(), $id);
    }

    public function getImageObj($id) {
        return Model_Gallery::getImageObj($this->getId(), $id);
    }

    public function getImageObjs() {
        return Model_Gallery::getImageObjs($this->getId(), 'gallery');
    }

    public function getCredentialObjs() {
        return Model_Gallery::getImageObjs($this->getId(), 'credential');
    }

    public function getStatusObjs() {
        return Model_Status::getStatusObjs($this->getId());
    }

    // User attributes
/*
    public function getPageId() {
        return $this->getAttr('page_id');
    }
*/

/*
    public function getPageUrl() {
        return PATH."page/".$this->getAttr('route');
    }
*/

    public function getTitle() {
        $unitObj = Model_Unit::getUnitObjById($this->getAttr('title'));
        if ($unitObj) {
            return $unitObj->getName();
        } else {
            return $this->getAttr('title');
        }
    }

    public function getEmail() {
        return $this->getAttr('email');
    }

    public function getPhone() {
        return $this->getAttr('phone');
    }

    public function getAddress() {
        return ucwords(strtolower($this->getAttr('address')));
    }

    public function getCity() {
        return ucwords(strtolower($this->getAttr('city')));
    }

    public function getState() {
        return ucwords(strtolower($this->getAttr('state')));
    }

    public function getZip() {
        return $this->getAttr('zip');
    }

    public function getBirthDate() {
        if ($this->isAttr('birth_date') && $this->getAttr('birth_date') != '0000-00-00') {
            return date('m/d/Y', strtotime($this->getAttr('birth_date')));
        } else {
            return '';
        }
    }

    public function getAbout() {
        return $this->getAttr('about');
    }

    public function getRole() {
        return $this->getAttr('role');
    }

    public function isPageActive() {
        return $this->getAttr('enabled')==1;
    }
    public function isActive() {
        return $this->getAttr('enabled')==1;
    }

    public function isRoleAdmin() {
        return $this->getAttr('role')==self::ROLE_ADMIN;
    }

    public function isRoleServiceProvider() {
        return $this->isRoleHost() || $this->isRoleTrainer();
    }

    public function isRoleHost() {
        return $this->getAttr('role')==self::ROLE_SCHOOL || $this->getAttr('role')==self::ROLE_BUSINESS;
    }

/*
    public function isRoleEmployer() {
        return $this->getAttr('role')==self::ROLE_SCHOOL || $this->getAttr('role')==self::ROLE_BUSINESS;
    }
*/

    public function isRoleSchool() {
        return $this->getAttr('role')==self::ROLE_SCHOOL;
    }

    public function isRoleUser() {
        return $this->getAttr('role')==self::ROLE_USER;
    }

    public function isRoleBusiness() {
        return $this->getAttr('role')==self::ROLE_BUSINESS;
    }

    public function isRoleTrainer() {
        return $this->getAttr('role')==self::ROLE_TRAINER;
    }

    public function getSuperiorId() {
        return $this->getAttr('superior_id');
    }

    public function getSuperiorObj() {
        return Model_User::getUserObjById($this->getAttr('superior_id'));
    }

/*
    public function getBackground() {
        return $this->getAttr('background');
    }
*/

    public function getSession() {
        return $this->getAttr('session');
    }

    public function getPrice() {
        return $this->getAttr('price');
    }

    public function getPrice1() {
        return $this->getAttr('price_1');
    }

    public function getPrice3() {
        return $this->getAttr('price_3');
    }

    public function getPrice12() {
        return $this->getAttr('price_12');
    }

    public function getPeriod() {
        return $this->getAttr('period');
    }

    public function getRoute() {
        return $this->getAttr('route');
    }

    public function getSuperiorRoute() {
        return $this->getAttr('sroute');
    }

    public function getSuperiorName() {
        return $this->getAttr('sname');
    }

    public function getLat() {
        return $this->getAttr('lat');
    }

    public function getLon() {
        return $this->getAttr('lon');
    }

    public function getEnabled() {
        return $this->getAttr('enabled');
    }

    public function getApproved() {
        return $this->getAttr('approved');
    }

    public function getRating() {
        return $this->getAttr('rating');
    }

    public function getActive() {
        return $this->getAttr('enabled');
    }

    public function getFacebookId() {
        return $this->getAttr('fid');
    }

    public function getAuthCode() {
        return $this->getAttr('auth_code');
    }

    public function isGoodAge() {
        $age = (int)date('Y') - (int)date('Y',strtotime($this->getAttr('birth_date')));
        if($age >= 18)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getCreateDate() {
        return date('m/d/Y',strtotime($this->getAttr('create_date')));
    }

    public function getActiveDate() {
        return date('m/d/Y H:i',strtotime($this->getAttr('active_date')));
    }

    public function getAvatarImageUrl() {
        $ret = false;
        if ($this->isAttr('avatar') && $this->getAttr('avatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('id')."/avatar/".$this->getAttr('avatar');
        } else {
            $ret = IMG.'logo_avatar.png';
        }
        return $ret;
    }

    public function getAvatarUrl() {
        $ret = false;
        if ($this->isAttr('avatar') && $this->getAttr('avatar') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/users/".$this->getAttr('id')."/avatar/".$this->getAttr('avatar');
        }
        return $ret;
    }

    public function getBackgroundUrl() {
        $ret = false;
        if ($this->isAttr('background') && $this->getAttr('background') != '') {
            $ret = Kohana::$config->load('site.s3.url')."/pages/".$this->getAttr('page_id')."/bg/".$this->getAttr('background');
        }
        return $ret;
    }

    public function updateAuthCode($code) {
        self::_updateAuthCode($this->getId(), $code);
    }

    public function updateFacebookId($fid) {
        self::_updateFacebookId($this->getId(), $fid);
    }

    // classes
    public function addClass($data) {
        Model_Class::addClass($this->getId(), $data);
    }

    public function updateClass($data) {
        Model_Class::updateClass($this->getId(), $data);
    }

    public function updateClassStatus($id, $status) {
        Model_Class::updateObjStatus('class', $this->getId(), $id, $status);
    }
/*
    public function deleteClass($id) {
        Model_Class::deleteClass($this->getId(), $id);
    }
*/

    public function getSuggestedClassObjs($skip = 0, $limit = 5) {
        $data = array();
        $data['start_date'] = date('Y-m-d');
        return Model_Class::getClassObjs($this->getId(), $data, $skip, $limit);
    }

    public function getClassObjs($data = array(), $skip = 0, $limit = 10000) {
        $data['user_id'] = $this->getId();
        return Model_Class::getClassObjs($this->getId(), $data, $skip, $limit);
    }

    public function canOfferClasses() {
        $role = $this->getRole();
        return ($role == Model_User::ROLE_SCHOOL || $role == Model_User::ROLE_BUSINESS || $role == Model_User::ROLE_TRAINER);
    }

    // cart
    public function checkoutOrder($data) {
        return Model_Order::checkoutOrder($this->getId(), $data);
    }

    public function getCartObj() {
        return Model_Order::getCartObj($this->getId());
    }

    public function getCartOrderObjs() {
        return Model_Order::getCartOrderObjs($this->getId());
    }

    public function getCartObjByOwnerId($ownerId) {
        return Model_Order::getCartObjByOwnerId($this->getId(), $ownerId);
    }

    public function getOrderIdByOwnerId($ownerId) {
        $order_id = false;
        $ownerObj = Model_User::getUserObjById($ownerId);
        if ($ownerObj) {
            $superiorObj = $ownerObj->getSuperiorObj();
            if ($superiorObj) {
                $ownerId = $superiorObj->getId();
            }
            $cartObj = $this->getCartObjByOwnerId($ownerId);
            if ($cartObj) {
                $order_id = $cartObj->getId();
            } else {
                $dataOrder['date'] = date('Y-m-d H:i:s');
                $dataOrder['user_id'] = $this->getId();
                $dataOrder['status'] = 'cart';
                $dataOrder['owner_id'] = $ownerId;
                $order_id = $this->addOrder($dataOrder);
            }
        }
        return $order_id;
    }

    public function deleteCart($id) {
        return Model_Order::deleteCart($this->getId(), $id);
    }

    public function checkOrder($data) {
        return Model_Order::checkOrder($this->getId(), $data);
    }

    // booking
    public function checkTour($owner_id) {
        return Model_Order::checkTour($this->getId(), $owner_id);
    }

    public function updateOrder($data) {
        return Model_Order::updateOrder($this->getId(), $date);
    }

    public function payOrder($id) {
        return Model_Order::payOrder($this->getId(), $id);
    }

    public function getOrderObjById($id) {
        return Model_Order::getOrderObjById($this->getId(), $id);
    }

    public function getOrderObjs($data, $skip=0, $limit=10000) {
        return Model_Order::getOrderObjs($this->getId(), $data, $skip, $limit);
    }

    public function addOrder($data) {
        return Model_Order::addOrder($this->getId(), $data);
    }

    public function addOrderItem($data) {
        return Model_Orderitem::addOrderItem($this->getId(), $data);
    }

    public function addEvent($data) {
        $data['user_id'] = $this->getId();
        return Model_Event::addEvent($this->getId(), $data);
    }

    public function addBooking($data) {
        return Model_Order::addBooking($this->getId(), $data);
    }

    public function updateBooking($data) {
        Model_Order::updateBooking($this->getId(), $data);
    }

    public function getDashboardBookingObj($data, $type) {
        return Model_Dashboard::getBookingObj($this->getId(), $data, $type);
    }

    public function getBookingInviteObjs($data, $skip = 0, $limit = 10000) {
        return Model_BookingInvite::getBookingInviteObjs($this->getId(), $data, $skip, $limit);
    }

    public function getOrderItemObjs($data, $skip = 0, $limit = 10000) {
        return Model_Orderitem::getOrderItemObjs($this->getId(), $data, $skip, $limit);
    }
/*
    public function getBookingObjs($data, $skip = 0, $limit = 10000) {
        return Model_Order::getBookingObjs($this->getId(), $data, $skip, $limit);
    }
 */

/*
    public function deleteBooking($id) {
        Model_Order::deleteBooking($this->getId(), $id);
    }
 */

    public function deleteOrderItem($id) {
        Model_Orderitem::deleteOrderItem($this->getId(), $id);
    }

    public function trashBooking($id) {
        Model_Order::trashBooking($this->getId(), $id);
    }

    public function getFullAddress() {
        return $this->getAttr('address') . ',' . $this->getAttr('city') . ', ' . $this->getAttr('zip');
    }

    // location
    public function addLocation($data) {
        return Model_Location::addLocation($this->getId(), $data);
    }

    public function getLocationObjs($data = array(), $skip = 0, $limit = 10000) {
        return Model_Location::getLocationObjs($this->getId(), $data, $skip, $limit);
    }

    public function updateLocationStatus($id, $status) {
        return Model_Location::updateStatus($this->getId(), $id, $status);
    }

/*
    public function deleteLocation($id) {
        return Model_Location::deleteLocation($this->getId(), $id);
    }
*/

    // page
    public function addPage() {
    }

    public function deletePage($user_id) {
        Model_Page::deletePage($this->getId(), $user_id);
    }

    // review
    public function addReview($data) {
        Model_Review::addReview($this->getId(), $data);
    }

    public function cancelReview($id) {
        Model_Review::cancelReview($this->getId(), $id);
    }

    public function trashReview($id) {
        Model_Review::trashReview($this->getId(), $id);
    }

    public function getMyClassObjById($order_item_id) {
        return Model_MyClass::getMyClassObjById($this->getId(), $order_item_id);
    }

    public function getMyClassObjs($data = array(), $skip = 0, $limit = 10000) {
        return Model_MyClass::getMyClassObjs($this->getId(), $data, $skip, $limit);
    }

    public function getEventObjById($id) {
        return Model_Event::getEventObjById($id);
    }

    public function getUpcomingEventObjs($data = array(), $skip = 0, $limit = 10000) {
        $data['user_id'] = $this->getId();
        return Model_Event::getUpcomingEventObjs($this->getId(), $data, $skip, $limit);
    }

    public function getHostedEventObjs($data = array(), $skip = 0, $limit = 10000) {
        $data['host_id'] = $this->getId();
        return Model_Event::getEventObjs($this->getId(), $data, $skip, $limit);
    }

    public function getHostEventObjs($data = array(), $skip = 0, $limit = 10000) {
        $data['host_id'] = $this->getId();
        return Model_Event::getEventObjs($this->getId(), $data, $skip, $limit);
    }

    public function getEventObjs($data = array(), $skip = 0, $limit = 10000) {
        $data['user_id'] = $this->getId();
        return Model_Event::getEventObjs($this->getId(), $data, $skip, $limit);
    }

    public function getMyOfferObjById($order_item_id) {
        return Model_MyOffer::getMyOfferObjById($this->getId(), $order_item_id);
    }

    public function getMyOfferObjs($data = array(), $skip = 0, $limit = 10000) {
        return Model_MyOffer::getMyOfferObjs($this->getId(), $data, $skip, $limit);
    }

    public function addAvailabilityTime($id,$day,$time_from,$time_to,$time_custom) {
        Model_AvailabilityTime::addTime($this->getId(),$id,$day,$time_from,$time_to,$time_custom);
    }

    public function deleteAvailabilityTime($id) {
        Model_AvailabilityTime::deleteTime($this->getId(), $id);
    }

    public function updateAvailabilityObj($data) {
        $data['user_id'] = $this->getId();
        $id = $data['id'];
        Model_Availability::updateAvailability($this->getId(), $data);
        if(count($data['check'])>0) {
            $this->deleteAvailabilityTime($id);
            foreach($data['check'] as $day => $value) {
                $this->addAvailabilityTime($id,$day,date('H:i:s',strtotime($data['time_from'][$day])),date('H:i:s',strtotime($data['time_to'][$day])),$data['time_custom'][$day]);
            }
        }
    }

    public function addAvailabilityObj($data) {
        $data['user_id'] = $this->getId();
        $id =  Model_Availability::addAvailability($this->getId(), $data);
        if(count($data['check'])>0) {
            //$this->deleteAvailabilityTime($ownerObj->getId());
            foreach($data['check'] as $day => $value) {
                $this->addAvailabilityTime($id,$day,date('H:i:s',strtotime($data['time_from'][$day])),date('H:i:s',strtotime($data['time_to'][$day])),$data['time_custom'][$day]);
            }
        }
        return $id;
    }

    public function getAvailabilityTimeObjs($id) {
        return Model_AvailabilityTime::getTimeObjs($this->getId(), $id);
    }

    public function getAvailabilityObjs($data = array(), $skip = 0, $limit = 10000) {
        $data['user_id'] = $this->getId();
        return Model_Availability::getAvailabilityObjs($this->getId(), $data, $skip, $limit);
    }

    // counts
    public function getMemberCount() {
        $id = $this->getId();
        $query = DB::query(Database::SELECT, 'SELECT COUNT(*) AS members FROM connect WHERE user_id=:id OR user_invite=:id')
            ->bind(':id', $id);
        $result = $query->execute()->as_array();
        return $result[0];
    }

    public function getRevenueCount() {
        $id = $this->getId();
        $query = DB::query(Database::SELECT, 'SELECT SUM(`sum`) AS revenue FROM `order` WHERE owner_id=:id')
            ->bind(':id', $id);
        $result = $query->execute()->as_array();
        return $result[0];
    }

    public function getVisitCount() {
        $id = $this->getId();
        $query = DB::query(Database::SELECT, 'SELECT visit FROM page WHERE user_id=:id')
            ->bind(':id', $id);
        $result = $query->execute()->as_array();
        return $result[0];
    }

    public function getLikeCount() {
        $id = $this->getId();
        $query = DB::query(Database::SELECT, 'SELECT COUNT(*) AS likes FROM `like` WHERE user_id=:id')
            ->bind(':id', $id);
        $result = $query->execute()->as_array();
        return $result[0];
    }

    public function getUnits() {
        return unserialize($this->getAttr('unit'));
    }
}
