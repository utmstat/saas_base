<?php

namespace app\components\widgets;

use app\components\common\AppWidget;
use Yii;

class FlashWidget extends AppWidget
{
    public function run()
    {
        $messages = [];

        foreach (Yii::$app->session->getAllFlashes() as $message) {
            if (is_string($message)){
                $messages[] = $message;
            }
        }

        return $this->render('flashWidget', ['messages' => $messages]);
    }
}