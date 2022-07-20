<?php

namespace app\components\widgets;

use app\components\common\AppWidget;
use Yii;
use yii\helpers\Html;

/**
 * Class TopMenuWidget
 * @package app\components\widgets
 */
class TopMenuWidget extends AppWidget
{
    public function run()
    {
        $items = [
            ['label' => 'Главная', 'url' => ['/site/index']],
        ];

        if(Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Авторизация', 'url' => ['/login']];
            $items[] = ['label' => 'Регистрация', 'url' => ['/register']];
        } else {
//            $items[] = ['label' => 'Проекты', 'url' => ['/project']];
            $items[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->email . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
        }

        return $this->render('topMenuWidget', ['items' => $items]);
    }


}