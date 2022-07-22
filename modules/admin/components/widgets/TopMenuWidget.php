<?php

namespace app\modules\admin\components\widgets;

use app\components\common\AppWidget;

class TopMenuWidget extends AppWidget
{

    public function run()
    {
        $items = [
            [
                'label' => 'Пункт 1',
                'url' => 'https://example.com/'
            ],
            [
                'label' => 'Пункт 2',
                'items' => [
                    [
                        'label' => 'Раздел 2',
                        'url' => 'https://example.com/'
                    ]
                ]

            ],
            [
                'label' => 'Пункт 3',
                'url' => 'https://example.com/'
            ],
            [
                'label' => 'Пункт 4',
                'url' => 'https://example.com/'
            ],
        ];

        return $this->render('topMenuWidget', ['items' => $items]);
    }

}