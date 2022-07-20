<?php

namespace app\models;

use app\components\common\AppModel;
use app\components\helpers\ArrayHelper;
use Exception;
use RuntimeException;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 * @property int $id
 * @property int $is_active
 * @property int|null $is_defaulter
 * @property string $phone
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $first_name
 * @property string|null $last_name
 * @property float|null $balance_prev
 * @property float|null $balance
 * @property int|null $marker_id
 * @property int|null $customer_id
 * @property int $created_at
 * @property int $updated_at
 */
class User extends AppModel implements IdentityInterface
{
    public $password;

    private static $cachedCurrentUser;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find()->active()->andWhere(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new Exception('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @param $username
     * @return User|null
     * @throws InvalidConfigException
     */
    public static function findByUsername($username)
    {
        return static::find()->active()->andWhere(['email' => $username])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @return User
     */
    public static function getCurrentUser()
    {
        if (!self::$cachedCurrentUser) {
            $model = self::findOne(Yii::$app->user->id);
            self::$cachedCurrentUser = $model;
        }

        return self::$cachedCurrentUser;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'is_defaulter', 'marker_id', 'customer_id', 'created_at', 'updated_at'], 'integer'],
            [['phone', 'email', 'created_at', 'updated_at'], 'required'],
            [['email'], 'email'],
            [
                ['phone'],
                'unique',
                'message' => 'Пользователь с таким телефоном уже зарегистрирован'
            ],
            [
                ['email'],
                'unique',
                'message' => 'Пользователь с таким email уже зарегистрирован'
            ],
            [['password'], 'string', 'min' => 6, 'max' => 72, 'on' => ['register']],
            [['balance_prev', 'balance'], 'number'],
            [['phone', 'email', 'first_name', 'last_name'], 'string', 'max' => 45],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'is_defaulter' => 'Is Defaulter',
            'phone' => 'Phone',
            'email' => 'Email',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth key',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'balance_prev' => 'Balance Prev',
            'balance' => 'Balance',
            'marker_id' => 'Marker ID',
            'customer_id' => 'Customer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(static::class);
    }

    /** @inheritdoc */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'register' => ['email', 'password'],
        ]);
    }

    /**
     * This method is used to register new user account. If Module::enableConfirmation is set true, this method
     * will generate new confirmation token and use mailer to send it to the user.
     * @return bool
     * @throws \yii\db\Exception
     */
    public function register()
    {
        if ($this->getIsNewRecord() == false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = self::getDb()->beginTransaction();

        try {
            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            $this->initAfterRegister();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        }
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function initAfterRegister()
    {
    
    }
}
