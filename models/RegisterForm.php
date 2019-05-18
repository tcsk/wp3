<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model {
    public $username;
    public $password;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['username', 'password', 'email'], 'required'],
            ['username', 'validateUsername'],
            ['email', 'validateEmail'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateUsername($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUserByName();

            if ($user) {
                $this->addError($attribute, 'A felhasználónév már létezik.');
            }
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUserByEmail();

            if ($user) {
                $this->addError($attribute, 'Az e-mail cím már létezik.');
            }
        }
    }

    public function register() {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = password_hash($this->password, PASSWORD_BCRYPT);
            $user->email = $this->email;
            return $user->save();
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUserByName() {
        return User::findByUsername($this->username);
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUserByEmail() {
        return User::findByEmail($this->email);
    }
}
