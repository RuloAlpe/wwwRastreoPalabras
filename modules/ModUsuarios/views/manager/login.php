<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->registerCssFile(
    '@web/webassets/css/login3.css',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

if(Yii::$app->params ['modUsuarios'] ['facebook'] ['usarLoginFacebook']){
?>
<script>

logInWithFacebook = function() {
	FB.login(function(response) {
		if (response.authResponse) {

			// Now you can redirect the user or do an AJAX request to
			// a PHP script that grabs the signed request from the cookie.
		}
		checkLoginState();
	}, {
		scope : '<?=Yii::$app->params ['modUsuarios'] ['facebook'] ['permisosForzosos']?>',
		auth_type : 'rerequest'
	});
	return false;
};

function statusChangeCallback(response) {

	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {

		FB.api('/me/permissions', function(response) {
			var declined = [];
			for (i = 0; i < response.data.length; i++) {
				if (response.data[i].status == 'declined') {
					declined.push(response.data[i].permission)
				}
			}
			if(declined.toString()=="email"){
				
				alert("Parece que no aceptaste la solicitud de Facebook o no nos compartiste tu correo electrónico.");
				
			}else{
				// Logged into your app and Facebook.
				window.location.replace('<?=Yii::$app->params ['modUsuarios'] ['facebook'] ['CALLBACK_URL']?>');
				//window.location.replace('http://notei.com.mx/test/wwwComiteConcursante/index.php/usrUsuarios/callbackFacebook/t/3c391e5c9feec1f95282a36bdd5d41ba');
//				window.location
//						.replace('https://hazclicconmexico.comitefotomx.com/concursar/usrUsuarios/callbackFacebook/t/3c391e5c9feec1f95282a36bdd5d41ba');
			}
		});

		
	} else if (response.status === 'not_authorized') {
		alert("Rechazo ingresar mediante Facebook");
		// The person is logged into Facebook, but not your app.
	} else {
		
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
	}
}

function checkLoginState() {

	// FB.api('/me/permissions', function(response) {
	// var declined = [];
	// for (i = 0; i < response.data.length; i++) {
	// if (response.data[i].status == 'declined') {
	// declined.push(response.data[i].permission)
	// }
	// }
	// alert(declined.toString())
	// });
	// FB.login(
	// function(response) {
	// console.log(response);
	// statusChangeCallback(response);
	// },
	// {
	// scope: 'email',
	// auth_type: 'rerequest'
	// }
	// );

	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
		
	});
}

window.fbAsyncInit = function() {
	FB.init({
		appId:'<?=Yii::$app->params ['modUsuarios'] ['facebook'] ['APP_ID']?>',
		cookie : true, // enable cookies to allow the server to access
		// the session
		xfbml : true, // parse social plugins on this page
		version : 'v2.6' // use any version
	});

};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
		return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>

<?php }?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel">
        	<div class="panel-body">
          		<div class="brand">
            		<!-- <img class="brand-img" src="../../assets//images/logo-blue.png" alt="..."> -->
            		<h2 class="brand-text font-size-18 text-center"><?= Html::encode($this->title) ?></h2>
          		</div>
				<?php 
				$form = ActiveForm::begin([
						'id' => 'form-ajax',
						//'options' => ['class' => 'form-horizontal'],
						'enableAjaxValidation' => true,
						'enableClientValidation'=>true,
					]); 
				?>

				<?= $form->field($model, 'username')->textInput(['placeholder'=>'Usuario'])->label(false) ?>

        		<?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Contraseña'])->label(false) ?>

				<div class="form-group clearfix">
					<div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg pull-left">
						<?= $form->field($model, 'rememberMe')->checkbox([
							'template' => "{input} {label}",
						]) ?>
            
				
					
						<!-- <input type="checkbox" id="inputCheckbox" name="remember">
						<label for="inputCheckbox">Remember me</label> -->
					</div>
					<a class="pull-right" href="<?=Url::base()."/peticion-pass"?>">¿Olvidé mi contraseña?</a>
				</div>
				<?= Html::submitButton('<span class="ladda-label">Login</span>', ["data-style"=>"zoom-in", 'class' => 'btn btn-primary btn-block btn-lg margin-top-15  ladda-button', 'name' => 'login-button']) ?>
				<?php 
				if(Yii::$app->params ['modUsuarios'] ['facebook'] ['usarLoginFacebook']){
				?>
				<button type="button" class="btn btn-block btn-lg btn-facebook margin-top-15  ladda-button"
					data-style="zoom-in" onClick="logInWithFacebook()"
					 scope="<?=Yii::$app->params ['modUsuarios'] ['facebook'] ['permisos']?>">
					 <span class="ladda-label"><i class="fa fa-facebook"></i> Ingresar con Facebook</span>
				</button>
				<?php 
				}
				?>

				<?php ActiveForm::end(); ?>
          		<p class="margin-top-15">¿Aún no tienes una cuenta? <a href="<?=Url::base()."/sign-up"?>">Registrate</a></p>
        	</div>
      	</div>
      
    </div>  							
</div>
