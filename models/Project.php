<?php

namespace app\models;

use app\components\common\AppModel;
use app\components\helpers\ArrayHelper;
use app\components\helpers\CookieHelper;
use app\components\StaticCache;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "project".
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $updated_at
 * @property int $created_at
 * @property User $user
 */
class Project extends AppModel
{
    const COOKIE_CURRENT_PROJECT = 'current_project';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'updated_at', 'created_at'], 'required'],
            [['user_id', 'updated_at', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [
                ['user_id', 'name'],
                'unique',
                'targetAttribute' => ['user_id', 'name'],
                'message' => 'Проект с таким названием уже есть.'
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Название',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }


    /**
     * Gets query for [[User]].
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array|ActiveRecord|Project
     * @throws InvalidConfigException
     */
    public static function getCurrentProject()
    {
        $id = (int)Yii::$app->session->get(self::COOKIE_CURRENT_PROJECT);

        if (!$id) {
            $id = (int)CookieHelper::get(self::COOKIE_CURRENT_PROJECT);
        }

        $result = StaticCache::get(__METHOD__, $id);

        if (!$result) {
            $user = User::getCurrentUser();
            $result = null;

            if (!$result && $user && $id) {
                $result = self::findOne(['id' => $id, 'user_id' => $user->id]);
            }

            if (!$result && $user) {
                $result = self::find()->where(['user_id' => $user->id])->one();
            }
            StaticCache::set(__METHOD__, $id, $result);
        }

        return $result;
    }

    public function getSetCurrentUrl()
    {
        return Url::to(['project/set-current', 'id' => $this->id]);
    }

    public function canDelete()
    {
        return Project::find()
                ->where(['user_id' => $this->user_id])
                ->count() > 1;
    }

    /**
     * Get list by user
     * @param int|null $userId
     * @return array
     * @throws InvalidConfigException
     */
    public static function getListByUser($userId = null)
    {
        if (!$userId) {
            $userId = User::getCurrentUser()->id;
        }
        return ArrayHelper::map(self::find()
            ->andWhere(['user_id' => $userId])
            ->orderBy(['name' => SORT_ASC])
            ->select(['id', 'name'])
            ->asArray()
            ->all(),
            'id',
            'name');
    }
}
