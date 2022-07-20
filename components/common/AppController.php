<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 27.05.17
 * Time: 13:39
 */

namespace app\components\common;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AppController
 * @package app\components\common
 */
class AppController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => [
                            'site'
                        ],
                        'actions' => [
                            'index',
                        ]
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'controllers' => ['site'],
                        'actions' => ['login', 'register', 'index']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ]
                ]
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }
}