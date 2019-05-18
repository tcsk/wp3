<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subject".
 *
 * @property string $id
 * @property string $title
 * @property string $code
 * @property string $description
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Course[] $courses
 * @property User $createdBy
 * @property User $updatedBy
 */
class Subject extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'code'], 'required'],
            [['description'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 45],
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
            'title' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
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
        return $this->hasMany(Course::class, ['subject_id' => 'id']);
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
     * @return SubjectQuery the active query used by this AR class.
     */
    public static function find() {
        return new SubjectQuery(get_called_class());
    }
}
