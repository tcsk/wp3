<?php

use app\models\Instructor;
use app\models\Semester;
use app\models\Subject;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject_id')
        ->dropDownList(ArrayHelper::map(Subject::find()->all(), 'id', 'title'),
            ['prompt' => '-- tantárgy --'])
    ?>

    <?= $form->field($model, 'team')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instructor_id')
        ->dropDownList(ArrayHelper::map(Instructor::find()->all(), 'id', 'name'),
            ['prompt' => '-- oktató --'])
    ?>

    <?= $form->field($model, 'semester_id')
        ->dropDownList(ArrayHelper::map(Semester::find()->all(), 'id', 'semester'),
            ['prompt' => '-- félév --'])
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
