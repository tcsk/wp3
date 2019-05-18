<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Üdvözöljük</h1>

        <p class="lead">Az Eszterházy Károly Egyetem Webprogramozás 3 kurzusának bemutató oldalán!</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <div class="row">
                <div class="col-sm-12">
                    <p>Ha még nincs felhasználói fiókja, a regisztráció gombra kattintva létrehozhatja azt.
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
                <p>
                    Jogosultsági szintjétől függően válasszon tevékenységet!
                </p>
            </div>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Hallgató</h2>

                <p>
                    A regisztrált felhasználóink automatikusan megkapják a hallgató jogosultságot.
                    Ez lehetőséget ad arra, hogy megtekintse a rögzített kurzusainkat. A kurzusok adatlap oldalát
                    pdf formátumban le is mentheti. A kurzusokhoz tananyagot, és egyéb letölthető
                    dokumentumokat adhat hozzá.
                </p>

                <p><a class="btn btn-default" href="/student-course">Kurzusok &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Szerkesztő</h2>

                <p>
                    Szerkesztő jogkörrel csak az adminisztrátorok ruházhatják fel a regisztrált felhasználóinkat.
                    A szerkesztők a hallgatók jogain kívül lehetőséget kapnak oktatók, kurzusok, tantárgyak és félévek
                    rögzítésére, módosítására és törlésére.
                </p>

                <p><a class="btn btn-default" href="/subject">Tantárgyak &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Admin</h2>

                <p>
                    Az adminisztrátorok megkapnak minden korábban felsorolt jogosultságot. Ezen kívül lehetőségük
                    van a felhasználók jogosultságainak és egyéb adatainak a módosítására.
                </p>

                <p><a class="btn btn-default" href="/admin">Admin &raquo;</a>
                </p>
            </div>
        </div>

    </div>
</div>
