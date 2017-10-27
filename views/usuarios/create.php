<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ModUsuarios\models\EntUsuarios */

$this->title = 'Create Ent Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Ent Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
