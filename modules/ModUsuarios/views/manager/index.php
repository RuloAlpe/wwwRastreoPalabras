<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUsuarios */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ent Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ent Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_usuario',
            'txt_token',
            'txt_username',
            'txt_apellido_paterno',
            'txt_apellido_materno',
            // 'txt_auth_key',
            // 'txt_password_hash',
            // 'txt_password_reset_token',
            // 'txt_email:email',
            // 'fch_creacion',
            // 'fch_actualizacion',
            // 'id_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
