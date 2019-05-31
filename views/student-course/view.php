<?php

use app\assets\UploadAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $dataProvider */
/* @var $docDataProvider */
/* @var $pdf */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

UploadAsset::register($this);
?>
<div class="course-view">

    <h1><?= Html::encode($model->subject->title) ?></h1>

    <?php if (!$pdf): ?>
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
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description',
            'deadline'
        ],
    ]); ?>

    <h2>Letölthető Dokumentumok</h2>

    <?php if (!$pdf): ?>
        <p>
            Új dokumentum hozzáadásához adja meg a dokumentum címét, válasszon ki egy fájlt (doc, docx, xls, xlsx, pdf,
            képek), majd kattintson a feltölt gombra!
        </p>
        <div class="row" style="margin: 25px;">
            <div class="col-sm-6">
                <form class="student-upload-form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="title" placeholder="A dokumentum címe" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="file"
                               accept="application/pdf, application/vnd.ms-excel, application/vnd.ms-word, image/*"
                               name="file"/>
                    </div>
                    <input type="hidden" name="course" value="<?= $model->id ?>">
                    <br>
                    <input class="btn btn-success" type="submit" value="Feltölt">
                </form>
                <div class="err"></div>
            </div>
        </div>
    <?php endif; ?>


    <?= GridView::widget([
        'dataProvider' => $docDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'title',
                'value' => function ($data) {
                    return "<a href='/uploads/$data->filename'  download>$data->title</a>";
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($data) {
                    return $data->createdBy->username;
                }
            ],
            'uploaded_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return Yii::$app->user->can('teacher') ||
                            $model->created_by == Yii::$app->user->id;
                    }
                ],
                'urlCreator' => function ($action, $model) {
                    if ($action === 'delete') {
                        $url = Url::to(['student-course/delete', 'id' => $model->id]);
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>

</div>