<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="course-view">

    <h1><?= Html::encode($model->subject->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'subject_id',
                'value' => function ($data) {
                    return $data->subject->title;
                }
            ],
            [
                'attribute' => 'instructor_id',
                'value' => function ($data) {
                    return $data->instructor->name;
                }
            ],
            [
                'attribute' => 'semester_id',
                'value' => function ($data) {
                    return $data->semester->semester;
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($data) {
                    return $data->createdBy->username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($data) {
                    return $data->updatedBy->username;
                }
            ],
        ],
    ]) ?>

</div>
