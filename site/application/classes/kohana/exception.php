<?php defined('SYSPATH') or die('No direct script access.');
 
class Kohana_Exception extends Kohana_Kohana_Exception
{
    public static function handler(Exception $e)
    {
        // track error
        $user_id = '';
        if (Auth::instance()->logged_in_user()) {
            $user_id = Auth::instance()->get_user()['id'];
        }
        Stats::track($user_id, 'error.'.get_class($e), array('url'=>$_SERVER['REQUEST_URI']));

        // handle error
        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            parent::handler($e);
        }
        else
        {
            Kohana::$log->add(Log::ERROR, Kohana_Exception::text($e));
            switch (get_class($e))
            {
                case 'HTTP_Exception_404':
/*
                    $response = new Response;
                    $response->status(404);
                    $view = View::factory('error/404');
                    $view->url = $_SERVER['REQUEST_URI'];
                    echo $response->body($view)->send_headers()->body();
*/

                    $params = array(
                         'action'  => '404',
                         'message' => rawurlencode($e->getMessage())
                    );
                    echo Request::factory(Route::get('error')->uri($params))
                         ->execute()
                         ->send_headers()
                         ->body();
                    break;
                default:
/*
                    $response = new Response;
                    $response->status($e->getCode());
                    $view = View::factory('error/default');
                    $view->error = $e->getMessage();
                    echo $response->body($view)->send_headers()->body();
                    return TRUE;
*/
                    $params = array(
                         'action'  => 'default',
                         'message' => rawurlencode($e->getMessage())
                    );
                    echo Request::factory(Route::get('error')->uri($params))
                         ->execute()
                         ->send_headers()
                         ->body();
                    break;
            }
        }

    }
}
