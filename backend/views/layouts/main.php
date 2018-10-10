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

<div clavss="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Levainco',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        $rol == "Administrador"?
            ['label' => 'Home', 'url' => ['/site/index']]:'',
        $rol == "Administrador"?
            ['label' => 'Create user', 'url' => ['/product-has-user/user']]:'',
        $rol == "Administrador"?
        ['label' => 'Roles', 'url' => ['/rbac']]:'',
        $rol == "Administrador"?
        ['label' => 'Products', 'items' => [
            ['label' => 'View Products', 'url' => ['/product']],
            ['label' => 'View Categories', 'url' => ['/category']]
        ],
        ]:'',
        $rol == "Administrador"?
        ['label' => 'Shops', 'url' => ['/shop']]:'',
        $rol == "Administrador"?
        ['label' => 'Day work', 'items' => [
            ['label' => 'Work', 'url' => ['/product-has-user']],
            ['label' => 'Situations', 'url' => ['/situation']],
            ['label' => 'Feriado', 'url' => ['/feriado']]
        ],
        ]:'',
        $rol == "Trabajador"?
                ['label' => 'Work', 'url' => ['/product-has-user']]:'',
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
        <p class="pull-left">&copy; Levicon <?= date('Y') ?></p>

        <a href="#"><p class="pull-right">Need help?</p></a>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
