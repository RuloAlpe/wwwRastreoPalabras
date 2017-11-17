<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\AccessControlExtend;
use app\modules\ModUsuarios\models\Twitter;
use app\models\EntPalabrasClaves;
use app\models\EntRastreoTextos;
use app\models\RelPalabraPalabras;
use app\models\RelPalabraPersonas;
use app\models\RelPalabraSigResultado;
use Google\Cloud\Language\LanguageClient;
use app\models\RelPalabraRefrescarUrl;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
        // return [
        //     'access' => [
        //         'class' => AccessControlExtend::className(),
        //         'only' => ['logout', 'about'],
        //         'rules' => [
        //             [
        //                 'actions' => ['logout'],
        //                 'allow' => true,
        //                 'roles' => ['admin'],
        //             ],
                   
        //         ],
        //     ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        //];
    //}

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionTest(){
         //$auth = Yii::$app->authManager;
    
        //  // add "updatePost" permission
        //  $updatePost = $auth->createPermission('about');
        //  $updatePost->description = 'Update post';
        //  $auth->add($updatePost);
        //         // add "admin" role and give this role the "updatePost" permission
        // // as well as the permissions of the "author" role
        // $admin = $auth->createRole('test');
         //$auth->add($admin);
        // $auth->addChild($admin, $updatePost);
        
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $usuario = Yii::$app->user->identity;
        // $auth = \Yii::$app->authManager;
        // $authorRole = $auth->getRole('test');
        // $auth->assign($authorRole, $usuario->getId());
        
        //Declara api de google
        require __DIR__.'\..\vendor\autoload.php';
        $language = new LanguageClient([
            'projectId' => 'modified-wonder-176917',
            'keyFilePath' => '../web/Mi primer proyecto-449267dd9cee.json'
        ]);

        //if( isset($_POST['hashtag']) && isset($_POST['numero']) ){
            //Id del usuario
            $userId = Yii::$app->user->identity->id_usuario;

            $palabraEnBD = EntPalabrasClaves::find()->where(['txt_palabra_clave'=>'#FelizMiercoles'])->andWhere(['id_usuario'=>$userId])->one();
            
            if(!$palabraEnBD){
                //echo "No se ha buscado esa palabra";exit();
                //Asignar valores a modelo palabra clave que busca el usuario
                $palabraClave = new EntPalabrasClaves();
                $palabraClave->txt_palabra_clave = "#FelizMiercoles";
                $palabraClave->id_usuario = $userId;
                $palabraClave->num_cantidad_elementos = 5;

                $jsonDecode = $this->buascarTwitter($palabraClave->txt_palabra_clave, $palabraClave->num_cantidad_elementos, null);
                $this->guardarElementosEnBD($jsonDecode, $language, $palabraClave);
            }else{
                //var_dump($palabraEnBD);exit();
                $jsonDecode = $this->actualizarTwitter($palabraEnBD);
                $this->guardarElementosEnBD($jsonDecode, $language, $palabraEnBD);
            }
        //}
            
        return $this->render('index');
    }

    public function buascarTwitter($palabra, $numElementos, $fecha = null){
        $arr = [];
        $arr[0] = $palabra;
        $twitter = new Twitter();
        $json = $twitter->getTweets($arr, $numElementos, $fecha);

        return json_decode($json);
    }

    public function actualizarTwitter($palabraClave){
        //$parametros = RelPalabraRefrescarUrl::find()->where(['id_palabra_clave'=>$palabraClave->id_palabra_clave])->one();
        $parametros = RelPalabraSigResultado::find()->where(['id_palabra_clave'=>$palabraClave->id_palabra_clave])->one();

        $twitter = new Twitter();
        //$json = $twitter->getActualizarTweets($parametros->txt_refrescar_url);
        $json = $twitter->getActualizarTweets($parametros->txt_parametros_sig_resultado);
        
        return json_decode($json);
    }

    public function guardarElementosEnBD($jsonDecode, $language, $palabraClave){
        $relSig = RelPalabraSigResultado::find()->where(['id_palabra_clave'=>$palabraClave->id_palabra_clave])->one();
        $relRef = RelPalabraRefrescarUrl::find()->where(['id_palabra_clave'=>$palabraClave->id_palabra_clave])->one();
        if($relSig && $relRef){
            $totalScore = $palabraClave->num_sentimiento_general;
            $totalMagnitud = $palabraClave->num_magnitud_general;
        }else{
            $totalScore = 0;
            $totalMagnitud = 0;    
        }
        
        //For para conocer el contenodo del json completo
        $num_items = count($jsonDecode->statuses);
        for($i=0; $i<$num_items; $i++){
            $rastreoTexto = new EntRastreoTextos();
            $texto = $jsonDecode->statuses[$i];

            //Analisis de texto traido por json se hace uno por uno de los elementos
            $annotation = $language->analyzeSentiment($texto->text);
            $sentimiento = $annotation->sentiment();

            //Guardar en la BD el texto, sentimiento y magnitud
            $rastreoTexto->id_elemento_texto = $texto->id_str;
            $rastreoTexto->id_palabra_clave = $palabraClave->id_palabra_clave;
            $rastreoTexto->txt_rastero_texto = mb_convert_encoding($texto->text, "UTF-8");
            $rastreoTexto->num_sentimiento_texto = $sentimiento['score'];
            $rastreoTexto->num_magnitud_texto = $sentimiento['magnitude'];
            $rastreoTexto->save();

            $totalScore = $totalScore + $rastreoTexto->num_sentimiento_texto;
            $totalMagnitud = $totalMagnitud + $rastreoTexto->num_magnitud_texto;

            //Conocer si tiene otras palabras clave relacionas en el texto
            $numPalabrasRelacionadas = count($texto->entities->hashtags);
            if($numPalabrasRelacionadas > 0){
                for($j = 0; $j < $numPalabrasRelacionadas; $j++) {
                    $palabraRelacionada = new RelPalabraPalabras();
                    $palabra = $texto->entities->hashtags[$j];
                    
                    $palabraRelacionada->id_palabra_clave = $palabraClave->id_palabra_clave;
                    $palabraRelacionada->txt_rel_palabra = $palabra->text;
                    $palabraRelacionada->save();
                }
            }

            //Conocer si tiene otras usuarios de twitter relacionas en el texto            
            $numUserRelacionados = count($texto->entities->user_mentions);
            if($numUserRelacionados > 0){
                for($k = 0; $k < $numUserRelacionados; $k++){
                    $userRelacionado = new RelPalabraPersonas();
                    $userRel = $texto->entities->user_mentions[$k];

                    $userRelacionado->id_palabra_clave = $palabraClave->id_palabra_clave;
                    $userRelacionado->txt_persona = $userRel->screen_name;
                    $userRelacionado->save();
                }
            }
        }

        //Calcular promedio score, magnitud y guardar palabra clave
        $countElementos = EntRastreoTextos::find()->where(['id_palabra_clave'=>$palabraClave->id_palabra_clave])->count();

        $palabraClave->num_sentimiento_general = $totalScore / $countElementos;
        $palabraClave->num_magnitud_general = $totalMagnitud / $countElementos;
        $palabraClave->save();

        //Guardar siguiente busqueda
        if($relSig && $relRef){
            $relSig->txt_parametros_sig_resultado = $jsonDecode->search_metadata->next_results;
            $relSig->save(false);

            $relRef->txt_refrescar_url = $jsonDecode->search_metadata->refresh_url;
            $relRef->save(false);
        }else{
            $siguienteBusqueda = new RelPalabraSigResultado();
            $siguienteBusqueda->id_palabra_clave = $palabraClave->id_palabra_clave;
            $siguienteBusqueda->txt_parametros_sig_resultado = $jsonDecode->search_metadata->next_results;
            $siguienteBusqueda->save();

            //Guardar url refresh
            $urlRefresh = new RelPalabraRefrescarUrl();
            $urlRefresh->id_palabra_clave = $palabraClave->id_palabra_clave;
            $urlRefresh->txt_refrescar_url = $jsonDecode->search_metadata->refresh_url;
            $urlRefresh->save();
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $this->layout = null;
        return $this->renderAjax('about');
    }

    public function actionGetcontrollersandactions()
    {
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[strtolower(substr($controller, 0, -14))][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;

        print_r($fulllist);
        exit;
        return $fulllist;
    }
}
