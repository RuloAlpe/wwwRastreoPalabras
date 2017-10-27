<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\AccessControlExtend;
use app\modules\ModUsuarios\models\EntUsuariosSearch;
use app\modules\ModUsuarios\models\Utils;
use app\modules\ModUsuarios\models\EntUsuarios;
use yii\web\Response;
use app\modules\ModUsuarios\models\EntUsuariosActivacion;

class SuperAdminController extends Controller
{

    /**
     * Listado de usuarios de la aplicacion
     */
    public function actionIndex()
    {
        $searchModel = new EntUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReenviarEmailActivacion($token)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        $usuario = EntUsuarios::findByToken($token);

        $activacion = new EntUsuariosActivacion ();
        $activacion->saveUsuarioActivacion ( $usuario->id_usuario );

        // Enviar correo de activación
        $utils = new Utils();
	 	// Parametros para el email
        $parametrosEmail['url'] = Yii::$app->urlManager->createAbsoluteUrl([
             'activar-cuenta/' . $activacion->txt_token
        ]);
        $parametrosEmail['user'] = $usuario->getNombreCompleto();
					
	 	// Envio de correo electronico
        if($utils->sendEmailActivacion($usuario->txt_email, $parametrosEmail)){
            $respuesta['status']="success";
        }else{
             $respuesta['status']="error";
        }

        return $respuesta;
    }

    public function actionAgregarRol()
    {

    }

    public function actionAgregarPermiso()
    {

    }


}