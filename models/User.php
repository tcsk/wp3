<?php

namespace app\models;

use Exception;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password
 *
 */
class User extends ActiveRecord implements IdentityInterface {

    private $_oldAttributes;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            ['password', 'required', 'on' => 'insert'],
            [['username'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 99],
            [['password'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'roleName' => Yii::t('app', 'Role Name'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id) {
        return static::find()->where(['id' => $id])->one();
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return User|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::find()->where(['id' => 1])->one();
    }

    /**
     * @return int|string|void
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string|void
     */
    public function getAuthKey() {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey) {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username) {
        return static::find()->where(['username' => $username])->one();
    }

    /**
     * @param $email
     * @return User|array|null
     */
    public static function findByEmail($email) {
        return static::find()->where(['email' => $email])->one();
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password) {
        return password_verify($password, $this->password);
    }

    public function afterFind() {
        $this->_oldAttributes = $this->attributes;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function isChanged($attribute) {
        return $this->_oldAttributes[$attribute] !== $this->attributes[$attribute];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        if (!$insert && $this->isChanged('password')) {
            if (empty($this->password)) {
                $this->password = $this->_oldAttributes['password'];
            } else {
                $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            }
        }
        return parent::beforeSave($insert);
    }

    public function assignNewRole($role) {
        $this->revokeAllRole();
        $this->assignRole($role);
    }

    private function assignRole($role) {
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        try {
            return $auth->assign($authorRole, $this->id);
        } catch (Exception $e) {
            return false;
        }
    }

    private function revokeAllRole() {
        $auth = Yii::$app->authManager;
        try {
            return $auth->revokeAll($this->id);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getAllAuthAssignment() {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthAssignment() {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getRoleName() {
        return $this->authAssignment->item_name ?? 'student';
    }
}
