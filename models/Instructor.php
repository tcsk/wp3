<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "instructor".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Course[] $courses
 * @property User $createdBy
 * @property User $updatedBy
 */
class Instructor extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'instructor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            ['email', 'email'],
            ['email', 'unique'],
            [['name', 'email'], 'string', 'max' => 99],
            [['phone'], 'string', 'max' => 20],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function behaviors() {
        return [
            BlameableBehavior::class,
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCourses() {
        return $this->hasMany(Course::class, ['instructor_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return InstructorQuery the active query used by this AR class.
     */
    public static function find() {
        return new InstructorQuery(get_called_class());
    }
}
