<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "semester".
 *
 * @property string $id
 * @property string $semester
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Course[] $courses
 * @property User $createdBy
 * @property User $updatedBy
 */
class Semester extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'semester';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['semester'], 'required'],
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['semester'], 'string', 'max' => 45],
            [['id'], 'unique'],
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
            'semester' => Yii::t('app', 'Semester'),
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
        return $this->hasMany(Course::class, ['semester_id' => 'id']);
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
     * @return SemesterQuery the active query used by this AR class.
     */
    public static function find() {
        return new SemesterQuery(get_called_class());
    }
}
