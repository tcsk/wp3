<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'autocomplete' => 'new-password', 'value' => '']) ?>

    <?= $form->field($model, 'roleName')->dropDownList([
        'admin' => Yii::t('app', 'admin'),
        'teacher' => Yii::t('app', 'teacher')
    ], ['prompt' => Yii::t('app', 'student')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Rögzítés', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
