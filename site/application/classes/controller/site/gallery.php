<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Gallery extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();

        //model
        $this->id = sanitizeValue($this->request->param('route'));
/*
        if($this->loginUserObj->getId() != $this->id && $this->loginUserObj->getRole() != Model_User::ROLE_ADMIN || !$this->id)
        {
            $this->request->redirect('/dashboard/index');
        }
 */
    }

    public function action_index()
    {
        $this->template->content = View::factory('site/templates/gallery');
        $this->template->content->imageObjs = Model_Gallery::getImageObjs($this->id,'gallery');
        $this->template->content->sidebar = View::factory('site/sidebar');

        $this->template->content->sidebar->active = 'gallery';
        $this->template->content->sidebar->open = 'account';
    }

    public function action_add()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());

            // Upload to S3
            $matches = array();

            $tokens = explode(",", $data['image']);
            if (preg_match("/data:image\/(.*);base64/", $tokens[0], $matches))
            {
                // add to S3
                $path = '/tmp/__gallery_'.getmypid();
                @mkdir($path);
                $filename = time().'.'.$matches[1];
                $file = $path . '/' . $filename;
                $fp = fopen($file, "w+");
                fwrite($fp, base64_decode($tokens[1]));
                fclose($fp);
                $s3 = Amazon::instance()->get('s3');
                $result = $s3->putObject(array(
                    'Bucket' => Kohana::$config->load('site.s3.bucket'),
                    'Key' => Kohana::$config->load('site.s3.path')."/users/".$this->id."/gallery/".$filename,
                    'Body' => fopen($file, "r"),
                    'ACL' => 'public-read',
                ));
                system("rm -rf $path");

                // add to database
                if ($result) {
                    $data['image'] = $filename;
                    $data['user_id'] = $this->id;
                    $data['date'] = date('Y-m-d H:i:s');
                    $data['id'] = $this->loginUserObj->addImage($data);
                    $this->template = View::factory('ajax/image');
                    $this->template->imageObj = $this->loginUserObj->getImageObj($data['id']);
                }
            }
        }
    }

    public function action_delete()
    {
        if(isset($_POST['submit']))
        {
            $data = Arr::map('sanitizeHTMLValue', $this->request->post());
            $this->loginUserObj->deleteImage($data['id']);
            $this->template = View::factory('ajax/blank');
        }
    }

}
