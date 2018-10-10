<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Levainco</h1>

        <p><a class="btn btn-lg btn-success" href="index.php?r=product-has-user">Get started today</a></p>

    </div>

    <div class="body-content">
         <div class="row">
             <div class="col-lg-4">
                 <p><a class="btn btn-lg btn-info" href="index.php?r=situation">Situations</a></p>
             </div>
             <div class="col-lg-4">
                 <div class="jumbotron">
                     <p><a class="btn btn-small btn-primary" style="margin: auto" href="index.php?r=product">Products</a></p>
                 </div>
             </div>
             <div class="col-lg-4">
                 <p><a class="btn btn-lg btn-info pull-right" href="index.php?r=shop">Shops</a></p>
             </div>
         </div>
        <hr class="btn-info">
    </div>
</div>
