<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.11.17
 * Time: 20:07
 */

namespace app\components\widgets;

use app\components\common\AppWidget;
use yii\db\ActiveRecord;

class TableActionsWidget extends AppWidget
{
    /** @var ActiveRecord */
    public $model;

    /** @var bool */
    public $canView = false;

    /** @var bool */
    public $canEdit = true;

    /** @var bool */
    public $canDelete = true;

    /** @var bool */
    public $canCopy = false;

    /** @var bool */
    public $canRestore = false;

    /** @var bool */
    public $canRecommendation = false;

    /** @var array */
    public $customs = [];

    /**
     * @inheritDoc
     */
    public function run()
    {
        return $this->render('tableActionsWidget', ['model' => $this->model]);
    }
}
