<?php

namespace app\modules\ModUsuarios\models;

use Yii;

use app\modules\ModUsuarios\models\Utils;

/**
 * This is the model class for table "ent_usuarios_activacion".
 *
 * @property string $id_usuario_activacion
 * @property string $id_usuario
 * @property string $txt_token
 * @property string $txt_ip_activacion
 * @property string $fch_creacion
 * @property string $fch_activacion
 *
 * @property EntUsuarios $idUsuario
 */
class EntUsuariosActivacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mod_usuarios_ent_usuarios_activacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'txt_token'], 'required'],
            [['id_usuario'], 'integer'],
            [['fch_creacion', 'fch_activacion'], 'safe'],
            [['txt_token', 'txt_ip_activacion'], 'string', 'max' => 60],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_activacion' => 'Id Usuario Activacion',
            'id_usuario' => 'Id Usuario',
            'txt_token' => 'Txt Token',
            'txt_ip_activacion' => 'Txt Ip Activacion',
            'fch_creacion' => 'Fch Creacion',
            'fch_activacion' => 'Fch Activacion',
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
     * Guarda un registro para la activacion por correo electronico
     * 
     * @param integer $idUsuario
     * @return EntUsuariosActivacion
     */
    public function saveUsuarioActivacion($idUsuario){
    	$this->id_usuario = $idUsuario;
    	$this->txt_token = Utils::generateToken('act');
    	//$this->txt_ip_activacion = Yii::$app->getRequest()->getUserIP();
    	$this->fch_creacion = Utils::getFechaActual();
    	return $this->save()?$this:null;
    }
    
    /**
     * Busca la activacion por el token
     * @param unknown $t
     * @return EntUsuariosActivacion
     */
    public static function getActivacionByToken($t){
    	
    	$model = EntUsuariosActivacion::find()->where('txt_token=:t',[':t'=>$t])->one();
    	
    	if(empty($model)){
    		return null;
    	}
    	
    	return $model;
    }
    
    /**
     * Actualiza el registro de la activacion con fecha de la activacion
     * 
     *  @return EntUsuariosActivacion | null
     */
    public function actualizaActivacion(){
    	$this->txt_ip_activacion = Yii::$app->getRequest()->getUserIP();
    	$this->fch_activacion = Utils::getFechaActual();
    	
    	return $this->save()?$this:null;
    }
}
