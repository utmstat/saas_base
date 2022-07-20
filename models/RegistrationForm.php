<?php

namespace app\models;

use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{

    public $phone;

    public $email;

    public $password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['phone', 'email', 'password'], 'trim'],
            [['phone', 'email', 'password'], 'required'],
            [['phone', 'email'], 'string', 'max' => 45],
            [['email'], 'email'],
            [
                ['phone'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Пользователь с таким телефоном уже зарегистрирован'
            ],
            [
                ['email'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Пользователь с таким email уже зарегистрирован'
            ],
            ['password', 'string', 'min' => 6, 'max' => 72],
        ];
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->setScenario('register');
        $user->setAttributes($this->attributes);

        if (!$user->register()) {
            return false;
        }

        return true;
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}
