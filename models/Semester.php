<?php

namespace app\models;

use Yii;

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
class Semester extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'semester', 'created_by'], 'required'],
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['semester'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'semester' => Yii::t('app', 'Semester'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['semester_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return SemesterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SemesterQuery(get_called_class());
    }
}
