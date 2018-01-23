<?php

use app\models\EntEntidades;

/* @var $this yii\web\View */

$this->title = 'Buscar por hashtag';
?>

<div id="inicio" class="row">
  <div class="col-md-12">
    <form>
      <div class="form-group">
        <input type="text" class="form-control" name="hashtag" placeholder="Introducir hashtag ej. #hashtag">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="numero" placeholder="Numero de twits a buscar max 100">
      </div>

      <input type="checkbox" name="tiempo" value="1" checked>24 horas
      <input type="checkbox" name="tiempo" value="2">5 dias
      <input type="checkbox" name="tiempo" value="3">10 dias
      <br>
      <!-- <h3>Buscar por Usuario</h3>  
      <div class="form-group">
        <input type="text" class="form-control" name="user" placeholder="Introducir usuario ej. usuario">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="numeroUser" placeholder="Numero de twits a buscar max 100">
      </div> -->

      <button id="submitAnalizar" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label">Buscar</span></button>
    </form>
  </div>

  <div id="js-datos" class="container">
    
  </div>

</div>

<script>
    var basePath = "<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>";

    $(document).ready(function(){
/*      var chart = c3.generate({
        bindto: '#chart',
        data: {
          columns: [
            ['data1', 30, 200, 100, 400, 150, 250],
            ['data2', 50, 20, 10, 40, 15, 25]
          ]
          /*var columns = [];
          var data1 = ['data1', 30, 200, 100, 400, 150, 250];
          var data2 = ['data2', 50, 20, 10, 40, 15, 25];
          columns.push(data1);
          columns.push(data2);

          return columns;*/
/*        }
      });
      /*$(':checkbox').on('change',function(){
      var th = $(this), name = th.prop('name'); 
      if(th.is(':checked')){
          $(':checkbox[name="'  + name + '"]').not($(this)).prop('checked',false);   
        }
      });*/
      var l = Ladda.create(document.getElementById("submitAnalizar"));
      $('#submitAnalizar').on('click', function(e){
        e.preventDefault();
        l.start();
        var datos = $("form").serialize();
        //console.log(datos);
        $.ajax({
          url: basePath + 'site/index',
          data: datos,
          dataType : 'html',
          type: "POST",
          success: function(resp){
            //console.log(resp);
            l.stop();
            $('#js-datos').html(resp);
          }
        });
      });
    });
</script>