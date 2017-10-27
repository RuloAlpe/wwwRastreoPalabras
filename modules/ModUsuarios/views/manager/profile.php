<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Mi perfil";
$usuario = Yii::$app->user->identity;

$this->registerCssFile(
    '@web/webassets/css/profile.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webassets/js/sign-up.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
  );
?>
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <div class="panel">
    <div class="panel-body">
        <div class="brand text-center">
          <a class="avatar avatar-lg js-img-avatar">
                <img class="js-image-preview" src="<?=Url::base()."/webAssets/images/site/user.png"?>">
              </a>
        </div>
        <?= $this->render('_form', [
          'model' => $model,
        ]) ?>
       
    </div>
  </div>
</div>
</div>