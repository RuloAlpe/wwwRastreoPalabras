<?php

namespace app\modules\ModUsuarios\models;

use Yii;

/**
 * This is the model class for table "ent_sesiones".
 *
 * @property string $id_sesion
 * @property string $id_usuario
 * @property string $id_status
 * @property string $fch_creacion
 * @property string $fch_logout
 * @property string $num_minutos_sesion
 * @property string $txt_ip
 * @property string $txt_ip_logout
 *
 * @property EntUsuarios $idUsuario
 * @property CatStatusSesiones $idStatus
 */
class EntSesiones extends \yii\db\ActiveRecord
{
	const STATUS_INICIO_SESION = 1;
	const STATUS_FIN_SESION = 2;
	const STATUS_FIN_SESION_INCOMPLETA = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mod_usuarios_ent_sesiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'txt_ip'], 'required'],
            [['id_usuario', 'id_status', 'num_minutos_sesion'], 'integer'],
            [['fch_creacion', 'fch_logout'], 'safe'],
            [['txt_ip', 'txt_ip_logout'], 'string', 'max' => 32],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => CatStatusSesiones::className(), 'targetAttribute' => ['id_status' => 'id_status']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sesion' => 'Id Sesion',
            'id_usuario' => 'Id Usuario',
            'id_status' => 'Id Status',
            'fch_creacion' => 'Fch Creacion',
            'fch_logout' => 'Fch Logout',
            'num_minutos_sesion' => 'Num Minutos Sesion',
            'txt_ip' => 'Txt Ip',
            'txt_ip_logout' => 'Txt Ip Logout',
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
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(CatStatusSesiones::className(), ['id_status' => 'id_status']);
    }
    
    /**
     * 
     */
    public function revisarInicioSesion(){
    	
    }
    
    /**
     * Guarda el inicio de sesión de un usuario
     * 
     * @param integer $idUsuario
     * @return EntSesiones | null
     */
    public function saveSessionUsuario($idUsuario){
    	$this->id_usuario = $idUsuario;
    	$this->id_status = self::STATUS_INICIO_SESION;
    	$this->fch_creacion = Utils::getFechaActual();
    	$this->txt_ip = Yii::$app->getRequest()->getUserIP();
    	
    	return $this->save()?$this:null;
    }
    
    /**
     * Actualiza la finalizacion de sesión
     * 
     * @param integer $idUsuario
     * @return EntSesiones | null
     */
    public function saveSessionFinalizada($idUsuario){
    	$this->id_usuario = $idUsuario;
    	$this->id_status = self::STATUS_FIN_SESION;
    	$this->fch_logout = Utils::getFechaActual();
    	$this->txt_ip_logout = Yii::$app->getRequest()->getUserIP();
    	 
    	return $this->save()?$this:null;
    }
}
