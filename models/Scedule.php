<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "scedule".
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $deadline
 * @property string $course_id
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Course $course
 * @property User $createdBy
 * @property User $updatedBy
 */
class Scedule extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'scedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'deadline', 'course_id'], 'required'],
            [['description'], 'string'],
            [['deadline'], 'safe'],
            [['course_id', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'Description'),
            'deadline' => Yii::t('app', 'Deadline'),
            'course_id' => Yii::t('app', 'Course ID'),
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
     * @return SceduleQuery the active query used by this AR class.
     */
    public static function find() {
        return new SceduleQuery(get_called_class());
    }
}
