<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>

 <div class="row" style="  margin-top:-120px;margin-bottom:70px; "> 
        <center>     
<img src=" ..\views\layouts\img\stelara.jpg" ">
</center>
        </div>  

<div class="site-index">
    <h1 align="center"> Panel de Administración</h1>
    <br/>;

    <div class="body-content">
        
         <div class="row">

            <div class="col-md-6" onclick="location.href='index.php?r=registro';" >
              <div class="card mb-6 shadow-sm" >
                
                    <center>  <p>    <img src="..\views\layouts\img\registro.jpg" width="300" height="300" ></p>
                 </center>
            
              </div>
            </div>
            <div class="col-md-6"  onclick="location.href='index.php?r=cliente';">
              <div class="card mb-6 shadow-sm">
                <center> <p>     <img src=" ..\views\layouts\img\clientes.jpg" width="300" height="300"> </p>
                     </center>
              </div>
            </div>
            <div class="col-md-6" onclick="location.href='index.php?r=producto';">
              <div class="card mb-6 shadow-sm">
               <center>   <p>   <img src="  ..\views\layouts\img\productos.jpg" width="300" height="300"></p>
                  </center>
              </div>
            </div>

            <div class="col-md-6" onclick="location.href='index.php?r=proveedor';">
              <div class="card mb-6 shadow-sm"></p>
              <center>    <p>   <img src=" ..\views\layouts\img\proveedores.jpg" width="300" height="300"></p>
                  </center>
              </div>
            </div>
          </div>
    </div>

   
</div>
