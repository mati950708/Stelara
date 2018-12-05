<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>

 <div class="row" style="  margin-top:-20px;margin-bottom:70px; background: #87ACD6; height: 300px;">
        <center><img src="..\views\layouts\img\logo2.PNG" height="300px;" "></center>
        </div>  

<div class="site-index">
    <h1 align="center"> Panel de Administración</h1>
    <br/>;

    <div class="body-content">
        
         <div class="row">

            <div class="col-md-6">
              <div class="card mb-6 shadow-sm" >
                  <a href="index.php?r=registro">
                      <center>
                        <p><img src="..\views\layouts\img\registro.png" width="191" height="122" ></p>
                        <h2><b>Registros</b></h2>
                      </center>
                  </a>
            
              </div>
            </div>
            <div class="col-md-6"  onclick="location.href='index.php?r=cliente';">
              <div class="card mb-6 shadow-sm">
                  <a href="index.php?r=cliente">
                      <center>
                          <p><img src="..\views\layouts\img\clientes.png" width="191" height="122" ></p>
                          <h2><b>Clientes</b></h2>
                      </center>
                  </a>
              </div>
            </div>
         </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6">
              <div class="card mb-6 shadow-sm">
                  <a href="index.php?r=producto">
                      <center>
                          <p><img src="..\views\layouts\img\productos.png" width="191" height="122" ></p>
                          <h2><b>Productos</b></h2>
                      </center>
                  </a>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card mb-6 shadow-sm"></p>
                  <a href="index.php?r=proveedor">
                      <center>
                          <p><img src="..\views\layouts\img\proveedores.png" width="191" height="122" ></p>
                          <h2><b>Proveedores</b></h2>
                      </center>
                  </a>
              </div>
            </div>
          </div>
    </div>

   
</div>
