<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $title
 * @property string $filename
 * @property string $course_id
 * @property string $uploaded_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Course $course
 * @property User $createdBy
 * @property User $updatedBy
 */
class File extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'filename', 'course_id'], 'required'],
            [['course_id', 'created_by', 'updated_by'], 'integer'],
            [['uploaded_at'], 'safe'],
            [['title', 'filename'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
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
            'title' => Yii::t('app', 'Title'),
            'filename' => Yii::t('app', 'Filename'),
            'course_id' => Yii::t('app', 'Course ID'),
            'uploaded_at' => Yii::t('app', 'Uploaded At'),
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
    public function getCourse() {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
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
     * @return FileQuery the active query used by this AR class.
     */
    public static function find() {
        return new FileQuery(get_called_class());
    }

    public function beforeSave($insert) {
        $this->uploaded_at = new Expression('NOW()');
        return parent::beforeSave($insert);
    }
}
