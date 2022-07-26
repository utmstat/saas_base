<?php

/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 23.05.17
 * Time: 18:45
 */

namespace app\components\helpers;

use app\models\User;
use Yii;
use yii\base\Exception;
use yii\console\Application;

class AppHelper
{
    /**
     * @return string
     */
    public static function getProdHost()
    {
        return 'https://' . Yii::$app->request->hostName;
    }

    /**
     * @return string
     */
    public static function getDevHost()
    {
        return 'http://' . Yii::$app->request->hostName;
    }

    public static function getProdApiHost()
    {
        return 'https://api.' . Yii::$app->request->hostName;
    }

    public static function getDevApiHost()
    {
        return 'http://api.' . Yii::$app->request->hostName;
    }

    /**
     * @return string
     */
    public static function getFrontHost()
    {
        if (self::isProd()) {
            return self::getProdHost();
        }

        return self::getDevHost();
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function isUserDisabled($id = null)
    {
        if ($id) {
            $model = User::findOne($id);
        } else {
            $model = User::getCurrentUser();
        }

        return $model ? !$model->is_active : false;
    }

    /**
     * Check if user is admin
     * @param int $id
     * @return bool
     */
    public static function isAdmin($id = null)
    {
        $model = $id ? User::findOne($id) : User::getCurrentUser();
        return $model && in_array($model->email, Yii::$app->params['adminsEmail']);
    }

    /**
     * Check if user is support
     * @param int $id
     * @return bool
     */
    public static function isSupport($id = null)
    {
        $model = $id ? User::findOne($id) : User::getCurrentUser();
        return $model && in_array($model->email, Yii::$app->params['supportEmail']);
    }

    public static function isCLI()
    {
        return PHP_SAPI === 'cli';
    }

    public static function isAdminModule()
    {
        if (Yii::$app instanceof Application) {
            return false;
        }
        return strpos(Yii::$app->request->pathInfo, '.com/admin') !== false || strpos(Yii::$app->request->pathInfo,
                '.ru/admin') !== false;
    }

    public static function isBasicModule()
    {
        return Yii::$app->controller->module->id === 'basic';
    }


    public static function isProd()
    {
        return Yii::$app->params['isProduction'];
    }

    public static function isLocal()
    {
        return Yii::$app->params['isLocal'];
    }

    public static function isDebug()
    {
        return Yii::$app->params['isDebug'] || Yii::$app->request->get('utmstat_debug') == 1;
    }

    public static function isGuest()
    {
        return Yii::$app->user->isGuest;
    }

    /**
     * @return User
     */
    public static function getCurrentUser()
    {
        return User::getCurrentUser();
    }

    public static function addDropDownEmptyValue($array, $nullIndex = null)
    {
        $result = [];
        $result[$nullIndex] = 'Неважно';
        foreach ($array as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public static function getModuleId()
    {
        if (Yii::$app->module) {
            $result = Yii::$app->module->id;
        } else {
            $result = null;
        }
        return $result;
    }

    public static function getBearerToken()
    {
        $result = null;
        if (isset(Yii::$app->request->headers['authorization'])) {
            $result = substr(Yii::$app->request->headers['authorization'], 7);
        }
        return $result;
    }

    public static function getApiHost()
    {
        if (Yii::$app->params['apiHost']) {
            $result = Yii::$app->params['apiHost'];
        } elseif (AppHelper::isProd()) {
            $result = self::getProdApiHost();
        } else {
            $result = self::getDevApiHost();
        }
        return trim($result, '/');
    }

    public static function generateCallTrace()
    {
        $e = new Exception();
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $result = array();

        foreach ($trace as $item) {
            $result[] = trim(substr($item, strpos($item, ' ')));
        }

        return $result;
    }
}