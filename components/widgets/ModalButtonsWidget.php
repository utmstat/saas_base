<?php

namespace app\components\widgets;

use app\components\common\AppModel;
use app\components\common\AppWidget;

class ModalButtonsWidget extends AppWidget
{
    /** @var AppModel */
    public $model;

    /**
     * @inheritDoc
     */
    public function run()
    {
        $isUpdate = false;

        if ($this->model) {
            if (!$this->model->isNewRecord) {
                $isUpdate = true;
            }
        }

        return $this->render('modalButtonsWidget', ['isUpdate' => $isUpdate]);
    }
}