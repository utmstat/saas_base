<?php

namespace app\models;

use app\components\helpers\AppHelper;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\base\Model;

/**
 * RecoveryForm is the model behind the recovery form.
 */
class RecoveryForm extends Model
{
    const SCENARIO_REQUEST = 'request';
    const SCENARIO_RESET = 'reset';

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var string */
    public $passwordRepeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email'], 'trim'],
            [['email'], 'required'],
            [['email'], 'string', 'max' => 45],
            [['email'], 'email'],
            [
                'email',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['email' => 'email'],
                'message' => 'Пользователя с таким email не существует'
            ],
            [['password', 'passwordRepeat'], 'required'],
            [['password', 'passwordRepeat'], 'string', 'min' => 6, 'max' => 72],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password', 'passwordRepeat'],
        ];
    }

    /**
     * Sends recovery message.
     * @return bool
     */
    public function sendRecoveryMessage()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            return false;
        }

        $user->recovery_token = Uuid::uuid4()->toString();
        $user->recovery_sent_at = time();
        $user->save();

        $link = AppHelper::getFrontHost() . '/reset-password/' . $user->recovery_token . '/';
        $body = 'Для восстановления пароля перейдите по ссылке: ' .  $link;

        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($this->email)
            ->setSubject('Восстановление пароля')
            ->setHtmlBody($body)
            ->send();

        return true;
    }

    /**
     * Reset password
     * @param User $user
     * @return bool
     */
    public function resetPassword(User $user)
    {
        if (!$this->validate()) {
            return false;
        }

        $user->password = $this->password;
        return $user->save();
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Новый пароль',
            'passwordRepeat' => 'Повторить пароль',
        ];
    }
}
