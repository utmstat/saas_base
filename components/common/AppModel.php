<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 23.05.17
 * Time: 20:12
 */

namespace app\components\common;

use app\components\helpers\DateHelper;
use app\components\Logger;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class AppModel extends ActiveRecord
{
    public $date_range;
    public $from_date;
    public $to_date;

    /**
     * Флаг что надо создать связку моделей для удобства юзера как базовая настройка
     * @var bool
     */
    protected $createChildModels = false;
    private static $cachedModels;
    protected $ignoreIsNewRecord = false;

    /**
     * @return object|ActiveQuery
     * @throws InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(AppQuery::className(), [get_called_class()]);
    }

    public function beforeValidate()
    {
        if (($this->isNewRecord && !$this->isSearchModel()) || $this->ignoreIsNewRecord) {
            if ($this->hasAttribute('created_at')) {
                if (!$this->created_at) {
                    $this->created_at = time();
                }
                $createdAt = $this->created_at;
            } else {
                $createdAt = time();
            }

            $dateInfo = getdate(strtotime($createdAt));
            $defaultValues = [
                'created_at' => $createdAt,
                'hour' => $dateInfo['hours'],
                'mday' => $dateInfo['mday'],
                'week' => date('W', strtotime($createdAt)),
                'wday' => $dateInfo['wday'],
                'mon' => $dateInfo['mon'],
                'yday' => $dateInfo['yday'],
                'year' => $dateInfo['year'],
                'day_timestamp' => strtotime(date('Y-m-d 00:00:00')),
            ];
            foreach ($defaultValues as $attr => $value) {
                if ($this->hasAttribute($attr) && !$this->$attr) {
                    $this->$attr = $value;
                }
            }
        }

        if (!$this->isSearchModel()) {
            if ($this->hasAttribute('updated_at')) {
                if (!$this->updated_at) {
                    $this->updated_at = time();
                }
                $updatedAt = $this->updated_at;
            } else {
                $updatedAt = time();
            }

            $defaultValues = [
                'updated_at' => $updatedAt,
            ];

            foreach ($defaultValues as $attr => $value) {
                if ($this->hasAttribute($attr) && !$this->$attr) {
                    $this->$attr = $value;
                }
            }
        }

        $this->prepareDates();

        return parent::beforeValidate();
    }

    /**
     * Задает атрибут и тутже сохраняет
     *
     * @param $attr
     * @param $value
     *
     * @return bool
     */
    public function setAttr($attr, $value)
    {
        return $this->updateAttributes([
            $attr => $value
        ]);
    }

    /**
     * Форматирует дату для корректного поиска по диапазону
     */
    protected function prepareDates()
    {
        if ($this->from_date) {
            $this->from_date = DateHelper::formatAsFrom($this->from_date);
        }

        if ($this->to_date) {
            $this->to_date = DateHelper::formatAsTo($this->to_date);
        }
    }

    /**
     * @return AppModel
     */
    public static function getEmptyModel()
    {
        $class = get_called_class();

        return new $class;
    }

    public static function getCachedModelById($id)
    {
        $index = get_called_class() . $id;
        if (!isset(self::$cachedModels[$index])) {
            $model = self::findOne($id);
            self::$cachedModels[$index] = $model;
        }

        return self::$cachedModels[$index];
    }

    /**
     * @throws \yii\db\Exception
     */
    public function truncate()
    {
        return Yii::$app->db->createCommand('TRUNCATE TABLE ' . self::tableName())->execute();
    }

    protected function isSearchModel()
    {
        $class = get_called_class();
        return strpos($class, 'Search') > 0;
    }

    /**
     * Проверяет, имеет ли юзер доступ к данной модели
     *
     * @param $userId
     *
     * @return bool
     */
    public function hasAccess($userId)
    {
        return true;
    }

    /**
     * Задает кранюю дату, на которую получены данные из апи в ch
     *
     * @param $timestamp
     * @param string $attr
     *
     * @throws Exception
     */
    public function updateLastParsedDayAt($timestamp, $attr = 'last_parsed_day_at')
    {
        if ($this->hasAttribute($attr)) {
            $this->setAttr($attr, DateHelper::getDayTimestamp($timestamp));
        } else {
            throw new Exception('Надо завести атрибут ' . $attr);
        }
    }

    public function getCopy()
    {
        $model = clone $this;

        $resetAttrs = ['id', 'created_at'];

        foreach ($resetAttrs as $attr) {
            if ($model->hasAttribute($attr)) {
                $model->{$attr} = null;
            }
        }

        $model->setIsNewRecord(true);

        return $model;
    }

    /**
     * @param string $attr
     * @param null $from
     * @return false|int
     */
    public function getDateStart($attr = 'last_parsed_day_at', $from = null)
    {
        $fromTs = strtotime($from);
        $lastTs = $this->$attr;

        if (!$from) {
            $fromTs = max($fromTs, time() - 86400 * 7);
        }

        if ($lastTs) {
            $nextTs = DateHelper::formatAsFrom($lastTs + 86400);
            $result = max($nextTs, $fromTs);
        } else {
            $result = $fromTs;
        }

        return DateHelper::formatAsFrom($result);
    }

    /**
     * @param null $to
     * @return false|int
     */
    public function getDateEnd($to = null)
    {
        if ($to) {
            $result = DateHelper::formatAsTo($to);
        } else {
            $result = time() - 86400;
        }
        return DateHelper::formatAsTo($result);
    }

    public function canDelete()
    {
        return true;
    }

    public function canUpdate()
    {
        return true;
    }

    protected function getAttrChanges()
    {
        $result = [];
        foreach ($this->attributes as $attr => $value) {
            if (!isset($this->oldAttributes[$attr]) || $this->oldAttributes[$attr] != $value)
                $result[$attr] = [
                    'old' => isset($this->oldAttributes[$attr]) ? $this->oldAttributes[$attr] : null,
                    'new' => $value
                ];
        }

        return $result;
    }

    public static function getAttrLabel($attr)
    {
        $class = get_called_class();
        $model = new $class;
        return ArrayHelper::getValue($model->attributeLabels(), $attr, $attr);
    }

    public function getAttributesValues()
    {
        $attrs = $this->attributes();
        $result = [];
        foreach ($attrs as $attr) {
            $result[$attr] = $this->$attr;
        }
        return $result;
    }

    /**
     * @param $attrs []
     */
    protected function castAttrsToString($attrs)
    {
        foreach ($attrs as $attr) {
            if ($this->hasAttribute($attr)) {
                $this->setAttr($attr, (string)$this->$attr);
            }
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $result = parent::save($runValidation, $attributeNames); 

//        if (!$result) {
//            switch (get_called_class()) {
//                case ServiceEventField::class:
//                    Yii::error($this->errors);
//                    Logger::error($this->errors);
//            }
//        }

        return $result;
    }
}
