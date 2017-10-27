<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Poner descripcion de proyecto">
    <meta name="author" content="2 Geeks one Monkey">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="<?=Url::base()?>/webAssets/js/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
	 <script>
        var baseUrl = "<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>";
    </script>
    <?php $this->head() ?>
</head>
<body class="layout-full">
    <div class="animsition page">
        <div class="page-content">
            <?php $this->beginBody() ?>

            <?= $content ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <footer class="page-copyright page-copyright-inverse text-center">
                        <p>DEVELOPMENT BY <?=Yii::$app->params ['developmentBy']?></p>
                        <p>© <?=date('Y')?>. Todos los derechos reservados.</p>
                        <div class="social">
                        <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                            <i class="icon bd-twitter" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                            <i class="icon bd-facebook" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                            <i class="icon bd-google-plus" aria-hidden="true"></i>
                        </a>
                        </div>
                    </footer>
                </div>
            </div>
            <?php $this->endBody() ?>
        </div>    
    </div>
    <script>
(function(document, window, $) {
  'use strict';
  var Site = window.Site;
  $(document).ready(function() {
    Site.run();
  });
})(document, window, jQuery);
</script>
</body>
</html>
<?php $this->endPage() ?>
