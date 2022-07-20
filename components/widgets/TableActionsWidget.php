<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.11.17
 * Time: 20:07
 */

namespace app\components\widgets;


use app\components\common\AppWidget;

class TableActionsWidget extends AppWidget
{
    public $model;

    public $canView = false;

    public $canEdit = true;

    public $canDelete = true;

    public $canCopy = false;

    public $canRestore = false;

    public $canRecommendation = false;

    public $customs = [];

    public function run()
    {
        return $this->render('tableActionsWidget', ['model' => $this->model]);
    }
}
