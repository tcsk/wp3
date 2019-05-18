<?php

use app\assets\UploadAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $dataProvider */
/* @var $noButton */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

UploadAsset::register($this);
?>
<div class="course-view">

    <h1><?= Html::encode($model->subject->title) ?></h1>

    <?php if (!isset($noButton)): ?>
        <p>
            <a class="btn btn-primary" href="/student-course/report?id=<?= $model->id ?>" target="_blank">
                Adatlap Letöltése
            </a>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'subject_id',
                'value' => function ($data) {
                    return $data->subject->title;
                }
            ],
            'team',
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

    <h2>Menetrend</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description',
            'deadline'
        ],
    ]); ?>

</div>
