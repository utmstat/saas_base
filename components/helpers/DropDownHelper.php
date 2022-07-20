<?php


namespace app\components\helpers;


class DropDownHelper
{
    /**
     * @param $models
     * @param string $id
     * @param string $name
     * @return array
     */
    public static function getPlainData($models, $id = 'id', $name = 'name')
    {
        $result = [];

        foreach ($models as $model) {
            $result[$model->$id] = $model->$name;
        }

        return $result;
    }

}