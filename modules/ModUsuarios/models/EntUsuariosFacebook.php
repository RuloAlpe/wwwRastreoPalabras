<?php

namespace app\modules\ModUsuarios\models;

use Yii;

/**
 * This is the model class for table "ent_usuarios_facebook".
 *
 * @property string $id_usuario_facebook
 * @property string $id_usuario
 * @property string $id_facebook
 * @property string $txt_url_photo
 *
 * @property EntUsuarios $idUsuario
 */
class EntUsuariosFacebook extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'mod_usuarios_ent_usuarios_facebook';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'id_usuario',
								'id_facebook' 
						],
						'required' 
				],
				[ 
						[ 
								'id_usuario',
								'id_facebook'
						],
						'integer' 
				],
				[ 
						[ 
								'id_usuario' 
						],
						'unique' 
				],
				[ 
						[ 
								'id_facebook' 
						],
						'unique' 
				],
				[ 
						[ 
								'id_usuario' 
						],
						'exist',
						'skipOnError' => true,
						'targetClass' => EntUsuarios::className (),
						'targetAttribute' => [ 
								'id_usuario' => 'id_usuario' 
						] 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [ 
				'id_usuario_facebook' => 'Id Usuario Facebook',
				'id_usuario' => 'Id Usuario',
				'id_facebook' => 'Id Facebook',
				'txt_url_photo' => 'Txt Url Photo' 
		];
	}
	
	/**
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getIdUsuario() {
		return $this->hasOne ( EntUsuarios::className (), [ 
				'id_usuario' => 'id_usuario' 
		] );
	}
	
	/**
	 * Buscamos si el usuario ya esta registrado en facebook
	 * 
	 * @param string $id
	 * @return EntUsuariosFacebook|null        	
	 */
	public static function getUsuarioFaceBookByIdFacebook($id = null) {
		$usuarioFacebook = EntUsuariosFacebook::find ()->where ( 'id_facebook=:idFacebook', [ 
				':idFacebook' => $id 
		] )->one ();
		
		if (empty ( $usuario )) {
			return null;
		}
		
		return $usuarioFacebook;
	}
	
	/**
	 * Guarda la información para facebook
	 * @param unknown $userData
	 * @return EntUsuariosFacebook
	 */
	public function saveDataFacebook($userData){
		$this->id_facebook = $userData ['profile'] ['id'];
		$this->txt_url_photo = $userData ['pictureUrl'];
		
		return $this->save ()?$this:null;
	}
}
