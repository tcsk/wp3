<?php

/* @var $this View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use yii\web\View;

$this->title = 'WP3 - Tansegéd';

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Főoldal', 'url' => ['/']],
            [
                'label' => 'Szerkesztő',
                'visible' => Yii::$app->user->can('teacher'),
                'items' => [
                    ['label' => 'Tantárgyak', 'url' => ['/subject']],
                    ['label' => 'Kurzusok', 'url' => ['/course']],
                    ['label' => 'Oktatók', 'url' => ['/instructor']],
                    ['label' => 'Szemeszterek', 'url' => ['/semester']],
                ]
            ],
            ['label' => 'Admin', 'url' => ['/admin'], 'visible' => Yii::$app->user->can('admin')],
            ['label' => 'Regisztráció', 'url' => ['/site/register'], 'visible' => Yii::$app->user->isGuest],
            Yii::$app->user->isGuest ? (
            ['label' => 'Bejelentkezés', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Kijelentkezés (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php try {
            echo Alert::widget();
        } catch (Exception $e) {
        } ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; PTI-WP3 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
