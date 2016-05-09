<?php


abstract class Kohana_Auth {

// Auth instances
protected static $_instance;

/**
* Singleton pattern
*
* @return Auth
*/
public static function instance()
{
if ( ! isset(Auth::$_instance))
{
// load the configuration for this type
$config = Kohana::$config->load('auth');

if ( ! $type = $config->get('driver'))
{
$type = 'file';
}

// set the session class name
$class = 'Auth_'.ucfirst($type);

// create a new session instance
Auth::$_instance = new $class($config);
}

return Auth::$_instance;
}

protected $_session;

protected $_config;

/**
* Loads Session and configuration options.
*
* @return void
*/
public function __construct($config = array())
{
	// Save the config in the object
	$this->_config = $config;

	$this->_session = Session::instance();
}

abstract public function loginUser($email, $password, $remember);

abstract public function password($email);

//abstract public function check_password($password);

/**
* Gets the currently logged in user from the session.
* Returns NULL if no user is currently logged in.
*
* @return mixed
*/
	
public function get_user($default = NULL)
{
	return $this->_session->get($this->_config['session_user_key'], $default);
}


/**
* Log out a user by removing the related session variables.
*
* @param boolean completely destroy the session
* @param boolean remove all tokens for user
* @return boolean
*/

//admin
public function logout_user($destroy = FALSE, $logout_all = FALSE)
{
	if ($destroy === TRUE)
	{
		// Destroy the session completely
		$this->_session->destroy();
	}
	else
	{
		// remove the user from the session
		$this->_session->delete($this->_config['session_user_key']);

		// regenerate session_id
		$this->_session->regenerate();
	}

	// double check
	return ! $this->logged_in_user();
}

//admin
public function logged_in_user($role = false)
{
	$user = $this->get_user();

	if($user && $role)
	{
		if(!isset($user['role']))
			$user['role'] = 0;

		if($user['role'] >= $role)
			return true;
	
		return false;
	}

	if($user)
		return true;

	return false;
}

/**
* Creates a hashed hmac password from a plaintext password. This
* method is deprecated, [Auth::hash] should be used instead.
*
* @deprecated
* @param string plaintext password
*/
public function hash_password($password)
{
	return $this->hash($password);
}

/**
* Perform a hmac hash, using the configured method.
*
* @param string string to hash
* @return string
*/
public function hash($str)
{
	if ( ! $this->_config['hash_key'])
		throw new Kohana_Exception('A valid hash key must be set in your auth config.');

	return hash_hmac($this->_config['hash_method'], $str, $this->_config['hash_key']);
}
	
protected function complete_UserLogin($user_data)
{
	// Regenerate session_id
	$this->_session->regenerate();

	// Store username in session
	$this->_session->set($this->_config['session_user_key'], $user_data);

	return TRUE;
}



//register user
abstract public function registerUser($data);

} // End Auth