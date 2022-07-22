<?php

namespace app\components\widgets;

use app\components\common\AppWidget;
use app\components\helpers\TextHelper;
use app\models\Project;
use app\models\User;
use Yii;

/**
 * Class TopMenuWidget
 * @package app\components\widgets
 */
class TopMenuWidget extends AppWidget
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $items = [];
        $leftItems = [];
        $rightItems = [];

        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Вход', 'url' => ['/login'], 'options' => ['class' => 'btn btn-sm']];
            $items[] = [
                'label' => 'Регистрация',
                'url' => ['/register'],
                'options' => ['class' => 'btn btn-outline-success btn-sm']
            ];
        } else {
            $items[] = ['label' => $this->getProjectLabel(), 'items' => $this->getProjects()];
            $items[] = [
                'label' => 'Раздел 1',
                'items' => [
                    [
                        'label' => 'Пункт 1',
                        'url' => 'https://example.com/'
                    ],
                    [
                        'label' => 'Пункт 2',
                        'url' => 'https://example.com/'
                    ],
                ]
            ];
            $rightItems[] = [
                'label' => TextHelper::fitText(User::getCurrentUser()->email, 14),
                'items' => [
                    [
                        'label' => 'Выход',
                        'url' => '/logout'
                    ],
                ]
            ];
        }

        if (Yii::$app->user->isGuest) {
            $class = 'navbar-nav ml-auto';
        } else {
            $class = 'navbar-nav navbar-right mr-auto';
        }

        return $this->render('topMenuWidget', [
            'items' => $items,
            'class' => $class,
            'leftItems' => $leftItems,
            'rightItems' => $rightItems
        ]);
    }

    /**
     * Get user projects
     * @return array
     */
    private function getProjects()
    {
        $result = [];

        /**
         * @var $projects Project[]
         */
        $projects = Project::find()
            ->where(['user_id' => User::getCurrentUser()->id])
            ->all();

        foreach ($projects as $project) {
            $result[] = [
                'label' => $project->name,
                'url' => $project->getSetCurrentUrl()
            ];
        }

        $result[] = '<div class="dropdown-divider"></div>';

        $result[] = [
            'label' => 'Список проектов',
            'url' => '/project'
        ];

        return $result;
    }

    /**
     * Get project label
     * @return string
     */
    private function getProjectLabel()
    {
        $project = Project::getCurrentProject();
        if ($project) {
            $result = '#' . $project->id . ' ' . TextHelper::fitText($project->name, 10);
        } else {
            $result = 'Проект не найден';
        }
        return $result;
    }


}