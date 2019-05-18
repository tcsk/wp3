<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Üdvözöljük</h1>

        <p class="lead">Alkalmazások fejlesztése projektlabor bemutató oldalán!</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <div class="row">
                <div class="col-sm-12">
                    <p>Ha még nincs felhaszálói fiókja, a regisztráció gombra kattintva létrehozhatja azt.
                    Ha már rendelkezik ilyennel, akkor a bejelentkezés gombra kattintva veheti igénybe
                    a szolgáltatásainkat.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6" style="text-align: center;">
                    <p><a class="btn btn-lg btn-success" href="/site/login">Bejelentkezés</a></p>
                </div>
                <div class="col-sm-6" style="text-align: center;">
                    <p><a class="btn btn-lg btn-primary" href="/site/register">Regisztráció</a></p>
                </div>
            </div>
        <?php else: ?>
            <div class="col-sm-12">
                <p>Válasszon a játékaink közül! Jó szórakozást kíván az afp2-group1 csapata :)</p>
            </div>
            <div class="row">
                <div class="col-sm-6" style="text-align: center;">
                    <p><a class="btn btn-lg btn-success" href="/game/memory">Memóriajáték</a></p>
                </div>
                <div class="col-sm-6" style="text-align: center;">
                    <p><a class="btn btn-lg btn-primary" href="/game/lexical">Kártyapárosítás</a></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Diák</h2>

                <p>
                    A regisztrált felhasználóink automatikusan megkapják a diák jogosultságot. Ez lehetőséget ad arra,
                    hogy a válasszon a játékaink közül. Az elért eredményeket rögzítjük, és megjelenítjük a
                    dicsőségfalon.
                </p>

                <p><a class="btn btn-default" href="/hall-of-fame">Dicsőségfal &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Tanár</h2>

                <p>
                    Tanár jogkörrel csak az adminisztrátorok ruházhatják fel a regisztrált felhasználóinkat.
                    A tanárok a diákok jogain kívül lehetőséget kapnak kategóriák és kártyapárok feltöltésére,
                    módosítására.
                </p>

                <p><a class="btn btn-default" href="/card-pair">Kártyapárok &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Admin</h2>

                <p>
                    Az adminisztrátorok megkapnak minden korábban felsorolt jogosultságot. Ezen kívül lehetőségük
                    van a felhasználók jogosultságainak és egyxéb adatainak a módosítására.
                </p>

                <p><a class="btn btn-default" href="/admin">Admin &raquo;</a>
                </p>
            </div>
        </div>

    </div>
</div>
