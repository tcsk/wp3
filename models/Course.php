<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "course".
 *
 * @property string $id
 * @property string $team
 * @property string $subject_id
 * @property string $instructor_id
 * @property string $semester_id
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Instructor $instructor
 * @property Semester $semester
 * @property Subject $subject
 * @property User $createdBy
 * @property User $updatedBy
 * @property File[] $files
 * @property Scedule[] $scedules
 */
class Course extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['subject_id', 'instructor_id', 'semester_id'], 'required'],
            [['id', 'subject_id', 'instructor_id', 'semester_id', 'created_by', 'updated_by'], 'integer'],
            ['team', 'string'],
            [['instructor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instructor::class, 'targetAttribute' => ['instructor_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::class, 'targetAttribute' => ['semester_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::class, 'targetAttribute' => ['subject_id' => 'id']],
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
            'team' => Yii::t('app', 'Csoport'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'instructor_id' => Yii::t('app', 'Instructor ID'),
            'semester_id' => Yii::t('app', 'Semester ID'),
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
    public function getInstructor() {
        return $this->hasOne(Instructor::class, ['id' => 'instructor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSemester() {
        return $this->hasOne(Semester::class, ['id' => 'semester_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubject() {
        return $this->hasOne(Subject::class, ['id' => 'subject_id']);
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
     * @return ActiveQuery
     */
    public function getFiles() {
        return $this->hasMany(File::class, ['course_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getScedules() {
        return $this->hasMany(Scedule::class, ['course_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find() {
        return new CourseQuery(get_called_class());
    }
}
