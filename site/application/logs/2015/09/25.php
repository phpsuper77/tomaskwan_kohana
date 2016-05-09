<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2015-09-25 11:11:11 --- ERROR: Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH\cache\classes\kohana\cache\memcache.php [ 120 ]
2015-09-25 11:11:11 --- STRACE: Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH\cache\classes\kohana\cache\memcache.php [ 120 ]
--
#0 E:\xampp\htdocs\gymhit_web\site\modules\cache\classes\kohana\cache.php(137): Kohana_Cache_Memcache->__construct(Array)
#1 E:\xampp\htdocs\gymhit_web\site\application\classes\model\search.php(29): Kohana_Cache::instance()
#2 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\base.php(32): Model_Search->getSearch()
#3 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\public.php(7): Controller_Site_Base->before()
#4 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\index.php(9): Controller_Site_Public->before()
#5 [internal function]: Controller_Site_Index->before()
#6 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request\client\internal.php(103): ReflectionMethod->invoke(Object(Controller_Site_Index))
#7 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request.php(1154): Kohana_Request_Client->execute(Object(Request))
#9 E:\xampp\htdocs\gymhit_web\site\index.php(111): Kohana_Request->execute()
#10 {main}
2015-09-25 11:24:57 --- ERROR: Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH\cache\classes\kohana\cache\memcache.php [ 120 ]
2015-09-25 11:24:57 --- STRACE: Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH\cache\classes\kohana\cache\memcache.php [ 120 ]
--
#0 E:\xampp\htdocs\gymhit_web\site\modules\cache\classes\kohana\cache.php(137): Kohana_Cache_Memcache->__construct(Array)
#1 E:\xampp\htdocs\gymhit_web\site\application\classes\model\search.php(29): Kohana_Cache::instance()
#2 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\base.php(32): Model_Search->getSearch()
#3 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\public.php(7): Controller_Site_Base->before()
#4 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\index.php(9): Controller_Site_Public->before()
#5 [internal function]: Controller_Site_Index->before()
#6 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request\client\internal.php(103): ReflectionMethod->invoke(Object(Controller_Site_Index))
#7 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request.php(1154): Kohana_Request_Client->execute(Object(Request))
#9 E:\xampp\htdocs\gymhit_web\site\index.php(111): Kohana_Request->execute()
#10 {main}
2015-09-25 15:28:33 --- ERROR: Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH\cache\classes\kohana\cache\memcache.php [ 120 ]
2015-09-25 15:28:33 --- STRACE: Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH\cache\classes\kohana\cache\memcache.php [ 120 ]
--
#0 E:\xampp\htdocs\gymhit_web\site\modules\cache\classes\kohana\cache.php(137): Kohana_Cache_Memcache->__construct(Array)
#1 E:\xampp\htdocs\gymhit_web\site\application\classes\model\search.php(29): Kohana_Cache::instance()
#2 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\base.php(32): Model_Search->getSearch()
#3 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\public.php(7): Controller_Site_Base->before()
#4 E:\xampp\htdocs\gymhit_web\site\application\classes\controller\site\index.php(9): Controller_Site_Public->before()
#5 [internal function]: Controller_Site_Index->before()
#6 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request\client\internal.php(103): ReflectionMethod->invoke(Object(Controller_Site_Index))
#7 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 E:\xampp\htdocs\gymhit_web\site\system\classes\kohana\request.php(1154): Kohana_Request_Client->execute(Object(Request))
#9 E:\xampp\htdocs\gymhit_web\site\index.php(111): Kohana_Request->execute()
#10 {main}