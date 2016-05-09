<?php defined('SYSPATH') or die('No direct script access.');

require_once(APPPATH.'../resources/functions/GoogleMap.php');

class Minion_Task_Exec extends Minion_Task
{
    private function runImport($taskObj)
    {
        Model_Importer::execTask($taskObj);
    }

    public function execute(array $params)
    {
        $filter['status'] = Model_Task::STATUS_PENDING;
        $taskObjs = Model_Task::getTaskObjs($filter, 0, 1);
        foreach ($taskObjs as $taskObj) {
            if ($taskObj->getTaskType() == Model_Task::TYPE_IMPORT) {
                $this->runImport($taskObj);
            } else {
                echo "Unknown type: " . $taskObj->getTaskType() . "\n";
            }
        }
    }
}
