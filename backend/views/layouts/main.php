,<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

use yii\bootstrap\Modal;

$rol = "guest";
if (!Yii::$app->user->isGuest) {
    try{
        if (array_key_exists('Administrator', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $rol = "Administrador";
        }
    }catch(Exception $e){
    }
    try{
        if (array_key_exists('Worker', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $rol = "Trabajador";
        }
    }catch(Exception $e){
    }
}
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php
Modal::begin([
    'id' => 'edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false,
    ],
]);

echo "<div id='editContent'></div>";

Modal::end();
?>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Stelara',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        $rol == "Administrador"?
            ['label' => 'Inicio', 'url' => ['/site/index']]:'',
        $rol == "Administrador"?
            ['label' => 'Registros', 'url' => ['/registro']]:'',
        $rol == "Administrador"?
            ['label' => 'Clientes', 'url' => ['/cliente']]:'',
        $rol == "Administrador"?
            ['label' => 'Productos', 'items' => [
                ['label' => 'Ver Productos', 'url' => ['/producto']],
                ['label' => 'Ver Categoría de producto', 'url' => ['/categoria-p']],
            ],
            ]:'',
        $rol == "Administrador"?
            ['label' => 'Proveedor', 'items' => [
                ['label' => 'Ver Proveedores', 'url' => ['/proveedor']],
                ['label' => 'Ver Materias prima', 'url' => ['/materia-prima']]
            ],
            ]:'',
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <br>
    <br>
    <br>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Stelara <?= date('Y') ?></p>

        <p class="pull-right"><img src="http://www.itses.edu.mx/img/logo2.png" height="35px" style="margin-top: -10px;" alt=""></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
