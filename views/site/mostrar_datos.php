<?php
use app\models\EntEntidades;
use app\models\EntRastreoTextos;
?>

<div class="row col-md-12">
    <?php
    if($palabraEnBD){
        $entidades = EntEntidades::find()->where(['id_palabra_clave'=>$palabraEnBD->id_palabra_clave])->andWhere(['!=', 'num_sentimiento', 0])->all();
        $textos = EntRastreoTextos::find()->where(['id_palabra_clave'=>$palabraEnBD->id_palabra_clave])->andWhere(['!=', 'num_sentimiento_texto', 0])->all();
    ?>
    <div class="col-md-6">
        <h3>Textos analizados</h3>
        <?php
            if($textos){
                foreach($textos as $texto){
        ?>
                    <div class="item col-lg-12">
                        <div class="well">
        <?php
                            echo "<p>".$texto->txt_rastreo_texto."</p>";      
                            echo "Sentimiento: ".$texto->num_sentimiento_texto;
                            echo "<br/>";
        ?>
                        </div>
                    </div>
        <?php
                }
            }else{
                echo "No hay textos con sentimientos";
            }
        ?>
    </div>

    <div class="col-md-6">
        <h3>Sentimiento de entidades</h3>
        <?php    
            if($entidades){
                foreach($entidades as $entidad){
        ?>
                    <div class="item col-lg-12">
                        <div class="well">
        <?php
                            echo "<p>Nombre: ".$entidad->txt_nombre."</p>";       
                            echo "<p>Tipo: ".$entidad->txt_tipo."</p>";
                            echo "<p>Sentimiento: ".$entidad->num_sentimiento."</p>";
        ?>
                        </div>
                    </div>
        <?php              
                }
            }else{
                echo "No hay entidades con sentimientos";
            }
        ?>
    </div>
    <?php
    }
    ?>
</div>