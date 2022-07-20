<?php

/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 30.05.17
 * Time: 23:33
 */

namespace app\components\common;

use Yii;

class ApiResponse
{
    /**
     * Статус ответа, повторяет стандартные http-коды,
     * 200 - все хорошо. 400 - есть ошибки валидации, 500 - Exception
     * Ставится автоматически
     * @var int
     */
    public $status;

    /**
     * Список ошибок модели
     * @var array
     */
    public $has_error;

    /**
     * Массив любых объектов
     * @var array
     */
    public $data;

    /**
     * @var string
     */
    public $message;

    /**
     * @var bool
     */
    public $onlyDataAsResponse = false;

    public function setMessage($value)
    {
        $this->message = $value;
    }

    public function setError($value, $sendError = true)
    {
        $this->has_error = 1;
        $this->message = $value;

        $exclude = [
            'Integration not found',
            'Project not found',
            'Project with hash not found'
        ];


        if (!is_array($value)) {
            $value = trim($value);
            $value = trim($value, '.');
        }

        if (!in_array($value, $exclude)) {
            if ($sendError) {
                Yii::error($value, __METHOD__);
            }
        }
    }

}