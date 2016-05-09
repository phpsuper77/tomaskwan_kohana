<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * File Auth driver.
 * [!!] this Auth driver does not support roles nor autologin.
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2010 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Kohana_Auth_File extends Auth {

	// User list
	protected $_users;

	/**
	 * Constructor loads the user list into the class.
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Load user list
		$this->_users = Arr::get($config, 'users', array());
	}

	/**
	 * Logs a user in.
	 *
	 * @param   string   username
	 * @param   string   password
	 * @param   boolean  enable autologin (not supported)
	 * @return  boolean
	 */
	public function loginUser($email, $password, $remember) 
  	{
		$password = $this->hash($password);
   
		$modelUser = new Model_User();
		$user = $modelUser->getUserByEmail($email);
		if ($user[0]['password'] == $password)
		{
			$user_data['id'] = $user[0]['id'];
			$user_data['name'] = $user[0]['name'];
			$user_data['role'] = $user[0]['role'];
			$user_data['avatar'] = $user[0]['avatar'];
			$user_data['route'] = $user[0]['route'];
			$user_data['superior'] = $user[0]['superior_id'];
			$modelUser->setActiveDate($user_data['id']);
		
			return $this->complete_UserLogin($user_data);
		}

		// Login failed
		return false;
  }

	/**
	 * Forces a user to be logged in, without specifying a password.
	 *
	 * @param   mixed    username
	 * @return  boolean
	 */
	public function force_login($email)
	{
		// Complete the login
		$modelUser = new Model_User();
		$user = $modelUser->getUserByEmail($email);
		if ($user)
		{
			$user_data['id'] = $user[0]['id'];
			$user_data['name'] = $user[0]['name'];
			$user_data['role'] = $user[0]['role'];
			$user_data['avatar'] = $user[0]['avatar'];
			$user_data['route'] = $user[0]['route'];
			$user_data['superior'] = $user[0]['superior_id'];
			Model_User::setActiveDate($user_data['id']);
		
			return $this->complete_UserLogin($user_data);
		}
		// Complete the login
		return false;
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   username
	 * @return  string
	 */
	public function password($email)
	{
		return Arr::get($this->_users, $email, FALSE);
	}

	/**
	 * Compare password with original (plain text). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	//public function check_password($password)
	//{
	//	$username = $this->get_user();

	//	if ($username === FALSE)
	//	{
	//		return FALSE;
	//	}

	//	return ($password === $this->password($username));
	//}
	
	public function registerUser($data) {
		
		$data['password'] = $this->hash($data['password']);
		$modelUser = new Model_User();
		$modelUser->addUser($data);		
	}

} // End Auth File
