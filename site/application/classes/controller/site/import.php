<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Import extends Controller_Site_Private
{
    public $template = 'site/index';	

    public function before()
    {
        parent::before();
        if (!$this->loginUserObj->isRoleAdmin())
        {
            $this->request->redirect('/');
        }
    }

    public function action_input()
    {
        $id = sanitizeValue($this->request->param('route'));
        $userObj = Model_User::getUserObjById($id);

        $this->template->content = View::factory('site/templates/import/input');
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = 'user';
        $this->template->sidebar->open = 'admin';
        $this->template->content->userObj = $userObj;
    }

    public function action_upload()
    {
        $id = sanitizeValue($this->request->param('route'));
        $userObj = Model_User::getUserObjById($id);

        $cols = Model_Importer::getCols();
        foreach ($cols as $col) {
            if (isset($_POST['col-'.$col])) {
                $rules['col-'.$col] = $_POST['col-'.$col];
            }
        }

        // options
        $rules['skip-header'] = $_POST['skip-header'];
        $rules['file-format'] = $_POST['file-format'];

        if(!isset($_FILES['file']))
        {
            $this->request->redirect('/import/input/'.$userObj->getId());
        }

        $txid = str_replace(".","",microtime(true));
        $tmpdir = "/tmp/data-".$txid;
        @mkdir($tmpdir);
        $tmpfile = $tmpdir."/file.csv";

        if(!move_uploaded_file($_FILES['file']['tmp_name'], $tmpfile))
        {
            $this->request->redirect('/import/input/'.$userObj->getId());
        }

        // parse header
        $i = 0;
        $maxLinesForPreview = 5;
        $rows = array();
        $fp = fopen($tmpfile, "r");
        while (!feof($fp)) {
            $line = trim(fgets($fp));
            if ($line == "") {
                continue;
            }
            if ($rules['skip-header'] && $i == 0) {
                $i++;
                continue;
            }
            if (count($rows) <= $maxLinesForPreview) {
                $row = Model_Importer::getRow($rules, $line);
                if ($row) {
                    $row['id'] = $i;
                    $rows[] = $row;
                }
            }
            $i++;
        }
        fclose($fp);

        $info = array();
        $info['rules'] = $rules;
        $info['total'] = $i;
        $info['rows'] = $rows;
        $info['dir'] = $tmpdir;
        $info['id'] = $userObj->getId();
        $info['ts'] = time();
        file_put_contents($tmpdir."/info.json", json_encode($info));

        $this->request->redirect('/import/preview/'.$txid);
    }

    public function action_preview()
    {
        $id = sanitizeValue($this->request->param('route'));
        $info = json_decode(file_get_contents("/tmp/data-".$id."/info.json"),true);
        $userObj = Model_User::getUserObjById($info['id']);

        $this->template->content = View::factory('site/templates/import/preview');
        $this->template->sidebar = View::factory('site/sidebar');
        $this->template->sidebar->active = 'user';
        $this->template->sidebar->open = 'admin';
        $this->template->content->userObj = $userObj;
        $this->template->content->id = $id;
        $this->template->content->info = $info;
    }

    public function action_start()
    {
        $id = sanitizeValue($this->request->param('route'));
        $info = json_decode(file_get_contents("/tmp/data-".$id."/info.json"),true);

        $task = Model_Task::addTask($this->loginUserObj->getId(), Model_Task::TYPE_IMPORT, Model_Task::STATUS_PENDING, json_encode($info));

        $this->request->redirect('/task/list');
    }

}
