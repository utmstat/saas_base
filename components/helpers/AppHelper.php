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
        if (Yii::$app->params['host']) {
            $result = Yii::$app->params['host'];
        } elseif (self::isProd()) {
            $result = self::getProdHost();
        } else {
            $result =  self::getDevHost();
        }
        return $result;
    }

    public static function getStaticHost()
    {
        if (Yii::$app->params['staticHost']) {
            $result = Yii::$app->params['staticHost'];
        } elseif (self::isProd()) {
            $result = 'https://static.' . Yii::$app->request->hostName;
        } else {
            $result =  self::getDevHost();
        }
        return $result;
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
}