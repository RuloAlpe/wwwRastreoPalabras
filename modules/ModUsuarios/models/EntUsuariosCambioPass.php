<?php

namespace app\modules\ModUsuarios\models;

use Yii;
use app\modules\modUsuarios\models\Utils;

/**
 * This is the model class for table "ent_usuarios_cambio_pass".
 *
 * @property string $id_usuario_cambio_pass
 * @property string $id_usuario
 * @property string $txt_token
 * @property string $txt_ip
 * @property string $txt_ip_cambio
 * @property string $fch_creacion
 * @property string $fch_finalizacion
 * @property string $fch_peticion_usada
 * @property string $b_usado
 *
 * @property EntUsuarios $idUsuario
 */
class EntUsuariosCambioPass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mod_usuarios_ent_usuarios_cambio_pass';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'txt_token', 'txt_ip'], 'required'],
            [['id_usuario', 'b_usado'], 'integer'],
            [['fch_creacion', 'fch_finalizacion', 'fch_peticion_usada'], 'safe'],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_ip', 'txt_ip_cambio'], 'string', 'max' => 20],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_cambio_pass' => 'Id Usuario Cambio Pass',
            'id_usuario' => 'Id Usuario',
            'txt_token' => 'Txt Token',
            'txt_ip' => 'Txt Ip',
            'txt_ip_cambio' => 'Txt Ip Cambio',
            'fch_creacion' => 'Fch Creacion',
            'fch_finalizacion' => 'Fch Finalizacion',
            'fch_peticion_usada' => 'Fch Peticion Usada',
            'b_usado' => 'B Usado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(EntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }
    
    /**
     * Guarda la peticion de contraseña
     * 
     * @param integer $idUsuario
     * @return EntUsuariosCambioPass | null
     */
    public function saveUsuarioPeticion($idUsuario){
    	$this->fch_creacion = Utils::getFechaActual();
    	$this->fch_finalizacion = Utils::getFechaVencimiento($this->fch_creacion);
    	$this->txt_ip = Yii::$app->getRequest()->getUserIP();
    	$this->txt_token = Utils::generateToken('sol');
    	$this->id_usuario = $idUsuario;
    	$this->b_usado = 0;
    	
    	return $this->save()?$this:null;
    }
    
    /**
     * Actualiza la peticion para finalizarla
     * @return EntUsuariosCambioPass | null
     */
    public function updateUsuarioPeticion(){
    	$this->b_usado = 1;
    	$this->txt_ip_cambio = Yii::$app->getRequest()->getUserIP();
    	$this->fch_peticion_usada = Utils::getFechaActual();
    	return $this->save()?$this:null;
    }
    
    /**
     * Recupera la peticion del usuario si se encuentra activada la validacion de fecha revisara 
     * que este a tiempo
     * 
     * @param string $t
     * @return NULL | EntUsuariosCambioPass
     */
    public function getPeticionByToken($t){
    	
    	$params = [':t'=>$t];
    	$where = 'txt_token=:t AND b_usado=1';
    	
    	if(Yii::$app->params ['modUsuarios'] ['recueperarPass'] ['diasValidos']){
    		$fechaActual = Utils::getFechaActual();
    		$where = 'txt_token=:t AND fch_finalizacion >=:fchActual AND b_usado=0';
    		$params[':fchActual'] = $fechaActual;
    	}
    	$model = EntUsuariosCambioPass::find()->where($where,$params)->one();
    	 
    	if(empty($model)){
    		return null;
    	}
    	 
    	return $model;
    }
}
