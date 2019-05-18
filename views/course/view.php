<?php

use app\assets\UploadAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $dataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

UploadAsset::register($this);
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

    <p>
        Válasszon ki egy xls fájlt a dokumentációban megadott formátumban (docs/test.xls), és kattintson a feltölt gombra.
        Ezzel a jelenlegi menetrend törlődik!
    </p>

    <div class="row" style="margin: 25px;">
        <div class="col-sm-6">
            <form class="upload-form" method="post" enctype="multipart/form-data">
                <input class="upload-xls" type="file" accept="application/vnd.ms-excel" name="file"/>
                <input type="hidden" name="course" value="<?= $model->id ?>">
                <br>
                <input class="btn btn-success" type="submit" value="Feltölt">
            </form>
            <div class="err"></div>
        </div>
    </div>

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
