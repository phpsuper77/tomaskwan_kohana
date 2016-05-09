<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Los_Angeles');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('EN-en');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
    'base_url'   => '/',
    'errors' => TRUE,
    'index_file' => FALSE,
    'profile'       => (Kohana::$environment == Kohana::DEVELOPMENT),
    'caching'       => (Kohana::$environment == Kohana::PRODUCTION)
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
       
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
$modules = array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
	 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	// 'mango'      => MODPATH.'mango',        // Mango DB - mongoDB class
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
        'aws' => MODPATH.'kohana-aws',
        'minion' => MODPATH.'minion',
);


if (Kohana::$config->load('site.debug-toolbar')) {
    $modules['debug-toolbar'] = MODPATH.'debug-toolbar';
}

Kohana::modules($modules);

/**
 * Custom classes
 */
require_once(__DIR__.'/classes/base/Util.php');
require_once(__DIR__.'/classes/base/LogManager.php');
require_once(__DIR__.'/classes/base/Partial.php');
require_once(__DIR__.'/classes/base/Stats.php');
require_once(__DIR__.'/classes/base/Geocoder.php');
require_once(__DIR__.'/../resources/functions/functions.php');
require_once(__DIR__.'/../resources/functions/GoogleMap.php');
require_once(__DIR__.'/../resources/functions/JSMin.php');

/**
 * Session
 */
Session::$default = 'native';
Session::instance();

/**
 * Cookie
 */
// Set the magic salt to add to a cookie
Cookie::$salt = '4ed22de0b37ee47f8587bbf616c81a8c';
// Set the number of seconds before a cookie expires
Cookie::$expiration = DATE::DAY; // by default until the browser close
// Restrict the path that the cookie is available to
//Cookie::$path = '/';
// Restrict the domain that the cookie is available to
//Cookie::$domain = 'localhost';
// Only transmit cookies over secure connections
//Cookie::$secure = TRUE;
// Only transmit cookies over HTTP, disabling Javascript access
//Cookie::$httponly = TRUE;

// Cache
Cache::$default = 'memcache';

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('home1', 'home1')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'home1',
		'action'     => 'index'
	));

Route::set('dashboard', 'dashboard')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'dashboard',
		'action'     => 'index'
	));

Route::set('page', 'page/(<route>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'page',
		'action'     => 'index'
	));


Route::set('error', 'error/<action>/<message>', array('action' => '.+', 'message' => '.+'))
->defaults(array(
		'directory' => 'site',
        'controller' => 'error'
));

Route::set('default', '(<controller>(/<action>(/<route>(/<param>))))')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'index',
		'action'     => 'home'
	));

