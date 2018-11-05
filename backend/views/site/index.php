<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Stelara</h1>

        <p><a class="btn btn-lg btn-success" href="index.php?r=registro">Registros</a></p>

    </div>

    <div class="body-content">
         <div class="row">
             <div class="col-lg-4">
                 <p><a class="btn btn-lg btn-info" href="index.php?r=cliente">Clientes</a></p>
             </div>
             <div class="col-lg-4">
                 <div class="jumbotron">
                     <p><a class="btn btn-small btn-primary" style="margin: auto" href="index.php?r=producto">Productos</a></p>
                 </div>
             </div>
             <div class="col-lg-4">
                 <p><a class="btn btn-lg btn-info pull-right" href="index.php?r=proveedor">Proveedores</a></p>
             </div>
         </div>
        <hr class="btn-info">
    </div>
</div>
