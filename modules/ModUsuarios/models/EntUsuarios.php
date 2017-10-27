<?php

namespace app\modules\ModUsuarios\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\ModUsuarios\models\Utils;
use kartik\password\StrengthValidator;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ent_usuarios".
 *
 * @property string $id_usuario
 * @property string $txt_token
 * @property string $txt_username
 * @property string $txt_apellido_paterno
 * @property string $txt_apellido_materno
 * @property string $txt_auth_key
 * @property string $txt_password_hash
 * @property string $txt_password_reset_token
 * @property string $txt_email
 * @property string $fch_creacion
 * @property string $fch_actualizacion
 * @property string $id_status
 *
 * @property EntSesiones[] $entSesiones
 * @property CatStatusUsuarios $idStatus
 * @property EntUsuariosActivacion[] $entUsuariosActivacions
 * @property EntUsuariosCambioPass[] $entUsuariosCambioPasses
 * @property EntUsuariosFacebook $entUsuariosFacebook
 */
class EntUsuarios extends \yii\db\ActiveRecord implements IdentityInterface 

{
	const STATUS_PENDIENTED = 1;
	const STATUS_ACTIVED = 2;
	const STATUS_BLOCKED = 3;
	public $password;
	public $repeatPassword;
	public $image;
	
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'mod_usuarios_ent_usuarios';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						'password',
						'compare',
						'compareAttribute' => 'repeatPassword',
						'on' => 'registerInput',
						'message'=>'Las contraseñas deben coincidir'
				],
				[ 
						'txt_email',
						'trim' 
				],
				[ 
						'txt_username',
						'trim' 
				],
				[ 
						[ 
								'id_status' 
						],
						'integer' 
				],
				[ 
						[ 
								'txt_username',
								'txt_apellido_paterno',
								'txt_email' 
						],
						'required',
						'on' => 'registerInput',
						'message'=>'Campo requerido'
				],
				// [ 
				// 		[ 
				// 				'password'
				// 		],
				// 		// StrengthValidator::className (),
				// 		// 'min' => 10,
				// 		// 'digit' => 2,
				// 		// 'special' => 2,
				// 		// 'upper'=>2,
				// 		// 'lower'=>2,
				// 		// 'special'=>2,
				// 		// 'hasUser'=>false,
						
				// ],
				[ 
						[ 
								'password',
								'repeatPassword' 
						],
						'required',
						'on' => 'registerInput',
						'message'=>'Campo requerido' 
				],
				[ 
						[ 
								'password',
								'repeatPassword' 
						],
						'required',
						'on' => 'cambiarPass',
						'message'=>'Campo requerido' 
				],
				[ 
						[ 
								'fch_creacion',
								'fch_actualizacion' 
						],
						'safe' 
				],
				[ 
						[ 
								'txt_username',
								'txt_password_hash',
								'txt_password_reset_token',
								'txt_email' 
						],
						'string',
						'max' => 255,
						'message'=>'Solo puede ingresar 255 caracteres' 
				],
				[ 
						[ 
								'txt_apellido_paterno',
								'txt_apellido_materno' 
						],
						'string',
						'max' => 30,
						'message'=>'Solo puede ingresar 30 caracteres' 
				],
				[ 
						[ 
								'txt_auth_key' 
						],
						'string',
						'max' => 32 
				],
				[ 
						[ 
								'txt_email' 
						],
						'unique',
						'message'=>'El email ya se encuentra registrado'  
				],
				[ 
						[ 
								'txt_token' 
						],
						'unique' 
				],
				[ 
						[ 
								'txt_password_reset_token' 
						],
						'unique' 
				],
				[ 
						[ 
								'id_status' 
						],
						'exist',
						'skipOnError' => true,
						'targetClass' => CatStatusUsuarios::className (),
						'targetAttribute' => [ 
								'id_status' => 'id_status' 
						] 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'id_usuario' => 'Id Usuario',
				'txt_token' => 'Txt Token',
				'txt_username' => 'Txt Username',
				'txt_apellido_paterno' => 'Txt Apellido Paterno',
				'txt_apellido_materno' => 'Txt Apellido Materno',
				'txt_auth_key' => 'Txt Auth Key',
				'txt_password_hash' => 'Txt Password Hash',
				'txt_password_reset_token' => 'Txt Password Reset Token',
				'txt_email' => 'Txt Email',
				'fch_creacion' => 'Fch Creacion',
				'fch_actualizacion' => 'Fch Actualizacion',
				'id_status' => 'Id Status' 
		];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEntSesiones() {
		return $this->hasMany ( EntSesiones::className (), [ 
				'id_usuario' => 'id_usuario' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getIdStatus() {
		return $this->hasOne ( CatStatusUsuarios::className (), [ 
				'id_status' => 'id_status' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEntUsuariosActivacions() {
		return $this->hasMany ( EntUsuariosActivacion::className (), [ 
				'id_usuario' => 'id_usuario' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEntUsuariosCambioPasses() {
		return $this->hasMany ( EntUsuariosCambioPass::className (), [ 
				'id_usuario' => 'id_usuario' 
		] );
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEntUsuariosFacebook() {
		return $this->hasOne ( EntUsuariosFacebook::className (), [ 
				'id_usuario' => 'id_usuario' 
		] );
	}
	
	/**
	 * INCLUDE USER LOGIN VALIDATION FUNCTIONS*
	 */
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne ( $id );
	}
	
	/**
	 * @inheritdoc
	 */
	/* modified */
	public static function findIdentityByAccessToken($token, $type = null) {
		return static::findOne ( [ 
				'access_token' => $token 
		] );
	}
	
	/*
	 * removed
	 * public static function findIdentityByAccessToken($token)
	 * {
	 * throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	 * }
	 */
	/**
	 * Finds user by username
	 *
	 * @param string $username        	
	 * @return static|null
	 */
	public static function findByUsername($username) {
		return static::findOne ( [ 
				'txt_username' => $username 
		] );
	}
	
	/**
	 * Finds user by email
	 *
	 * @param string $email        	
	 * @return EntUsuarios|null
	 */
	public static function findByEmail($username) {
		return static::findOne ( [ 
				'txt_email' => $username,
				'id_status' => self::STATUS_ACTIVED
		] );
	}

	/**
	 * Busca un usuario por token
	 * @param string $token
	 * @return EntUsuarios|null
	 */
	public static function findByToken($token){
		return static::findOne ( [ 
			'txt_token' => $token,
	] );
	}
	
	/**
	 * Finds user by password reset token
	 *
	 * @param string $token
	 *        	password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token) {
		$expire = \Yii::$app->params ['user.txt_passwordResetTokenExpire'];
		$parts = explode ( '_', $token );
		$timestamp = ( int ) end ( $parts );
		if ($timestamp + $expire < time ()) {
			// token expired
			return null;
		}
		
		return static::findOne ( [ 
				'txt_password_reset_token' => $token 
		] );
	}
	
	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->txt_auth_key;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey () === $authKey;
	}
	
	/**
	 * Validates password
	 *
	 * @param string $password
	 *        	password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword ( $password, $this->txt_password_hash );
	}
	
	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password        	
	 */
	public function setPassword($password) {
		$this->txt_password_hash = Yii::$app->security->generatePasswordHash ( $password );
	}
	
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey() {
		$this->txt_auth_key = Yii::$app->security->generateRandomString ();
	}
	
	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		$this->txt_password_reset_token = Yii::$app->security->generateRandomString () . '_' . time ();
	}
	
	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this->txt_password_reset_token = null;
	}
	/**
	 * EXTENSION MOVIE *
	 */
	
	/**
	 * Guarda al usuario en la base de datos
	 *
	 * @return EntUsuarios
	 */
	public function signup($isFacebook=false) {
		
		if (! $this->validate ()) {
			return null;
		}
		
		$user = new EntUsuarios ();

		$user->image = UploadedFile::getInstance($this, 'image');

		$user->txt_token = Utils::generateToken ( 'usr' );
		$user->txt_username = $this->txt_username;
		$user->txt_apellido_paterno = $this->txt_apellido_paterno;
		$user->txt_apellido_materno = $this->txt_apellido_materno;
		$user->txt_email = $this->txt_email;
		if($user->image){
			$user->txt_imagen = $user->txt_token.".".$user->image->extension;
			if(!$user->upload()){
				return null;
			}
		}
		$user->setPassword ( $this->password );
		$user->generateAuthKey ();
		$user->fch_creacion = Utils::getFechaActual ();
		$user->id_tipo_usuario = 1;

		
		
		// Si esta activada la opcion de mandar correo de activación el usuario estara en status pendiente
		if (Yii::$app->params ['modUsuarios'] ['mandarCorreoActivacion'] && !$isFacebook) {
			$user->id_status = self::STATUS_PENDIENTED;
		} else {
			$user->id_status = self::STATUS_ACTIVED;
		}
		
		return $user->save () ? $user : null;
	}


	public function upload()
    {
		$path = "profiles/".$this->txt_token;
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
       
    	if($this->image->saveAs($path."/".$this->txt_imagen)){
			return true;
		}else{
			return false;	
		}
            
    }
	
	/**
	 * Agregamos los datos para el usuario
	 *
	 * @param unknown $dataUsuario        	
	 */
	public function addDataFromFaceBook($dataUsuario) {
		$this->txt_username = $dataUsuario ['profile'] ['first_name'];
		$this->txt_apellido_paterno = $dataUsuario ['profile'] ['last_name'];
		$this->txt_email = $dataUsuario ['profile'] ['email'];
		$this->id_tipo_usuario = 1;
		
		return $this;
	}
	
	/**
	 * Obtiene el nombre completo del usuario
	 *
	 * @return string
	 */
	public function getNombreCompleto() {
		return $this->txt_username . ' ' . $this->txt_apellido_paterno . ' ' . $this->txt_apellido_materno;
	}
	
	/**
	 * Actualiza el status del usuario a activado
	 *
	 * @return EntUsuarios|null
	 */
	public function activarUsuario() {
		$this->id_status = self::STATUS_ACTIVED;
		return $this->save () ? $this : null;
	}
	
	/**
	 * Actualiza el status del usuario a bloqueado
	 *
	 * @return EntUsuarios|null
	 */
	public function bloquearUsuario() {
		$this->id_status = self::STATUS_BLOCKED;
		return $this->save () ? $this : null;
	}

	/**
	 * Si la imagen esta vacia mandamos una por default
	 *
	 * @return string
	 */
	 public function getImageProfile() {
		$basePath = Yii::getAlias ( '@web' );
		
		$usuarioFacebook = $this->entUsuariosFacebook;
		
		if(empty($usuarioFacebook)){
			if ($this->txt_imagen) {
				return $basePath . '/profiles/' . $this->txt_token."/". $this->txt_imagen;
			}
			
			return $basePath . '/webAssets/images/site/user.png';
		}
		
		return 'http://graph.facebook.com/'.$usuarioFacebook->id_facebook.'/picture';
		
	}

	public function isRegisterFaceBook(){
		$usuarioFacebook = $this->entUsuariosFacebook;
		
		if(empty($usuarioFacebook)){
			return false;
		} else{
			return $usuarioFacebook;
		}
	}
}
