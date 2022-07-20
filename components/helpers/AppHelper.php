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
    public static function getProdHost()
    {
        return 'https://' . Yii::$app->request->hostName;
    }

    public static function getDevHost()
    {
        return 'http://' . Yii::$app->request->hostName;
    }

    public static function getFrontHost()
    {
        if (self::isProd()) {
            return self::getProdHost();
        }

        return self::getDevHost();
    }

    public static function isUserDisabled($id = null)
    {
        if ($id) {
            $model = User::findOne($id);
        } else {
            $model = User::getCurrentUser();
        }

        $result = false;

        if ($model) {
            if (!$model->is_active) {
                $result = true;
            } else {
                $result = false;
            }

        }

        return $result;
    }

    public static function isAdmin($id = null)
    {
        if ($id) {
            $model = User::findOne($id);
        } else {
            $model = User::getCurrentUser();
        }

        if ($model) {
            $result = in_array($model->email, Yii::$app->params['adminsEmail']);
        } else {
            $result = false;
        }

        return $result;
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
        return strpos(Yii::$app->request->pathInfo, '.com/admin') !== false || strpos(Yii::$app->request->pathInfo, '.ru/admin') !== false;
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
        $result = 'http://api.saas.ru/';
        $result = trim($result, '/');
        return $result;
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