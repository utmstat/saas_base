<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 06.07.17
 * Time: 1:20
 */

namespace app\components\common;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class AppQuery
 * @package app\components\common
 */
class AppQuery extends ActiveQuery
{
    public function currentUser()
    {
        return $this->andWhere(['user_id' => Yii::$app->user->id]);
    }
}