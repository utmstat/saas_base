<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.06.17
 * Time: 16:12
 */

namespace app\components\widgets;

use app\components\common\AppWidget;

class FormButtonsWidget extends AppWidget
{
    public $updateText;

    public $createText;

    public $id;

    /**
     * @inheritDoc
     */
    public function run()
    {
        if (!$this->createText) {
            $this->createText = 'Создать';
        }

        if (!$this->updateText) {
            $this->updateText = 'Сохранить';
        }

        if (!$this->id) {
            $this->id = uniqid();
        }

        return $this->render('formButtonsWidget');
    }
}