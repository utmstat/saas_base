<?php

namespace app\models;

use app\components\common\AppModel;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $level
 * @property string|null $category
 * @property float|null $log_time
 * @property string|null $prefix
 * @property string|null $message
 */
class Log extends AppModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'category' => 'Category',
            'log_time' => 'Log Time',
            'prefix' => 'Prefix',
            'message' => 'Message',
        ];
    }

    public function findDebug()
    {
        if($this->level == 4) {
            return null;
        }

        return self::find()
            ->andWhere(['id' => $this->id + 1])
            ->andWhere(['level' => 4])
            ->andWhere(['category' => 'application'])
            ->one();
    }
}
