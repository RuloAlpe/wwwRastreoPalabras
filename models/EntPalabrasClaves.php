<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_palabras_claves".
 *
 * @property integer $id_palabra_clave
 * @property integer $id_compania
 * @property string $id_usuario
 * @property string $txt_palabra_clave
 * @property double $num_sentimiento_general
 * @property double $num_magnitud_general
 * @property string $fch_busqueda
 *
 * @property EntCompanias $idCompania
 * @property ModUsuariosEntUsuarios $idUsuario
 * @property EntRastreoTextos[] $entRastreoTextos
 * @property RelPalabraPalabras[] $relPalabraPalabras
 * @property RelPalabraPersonas[] $relPalabraPersonas
 * @property RelPalabraSigResultado[] $relPalabraSigResultados
 */
class EntPalabrasClaves extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_palabras_claves';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_compania', 'id_usuario'], 'integer'],
            [['id_usuario', 'txt_palabra_clave'], 'required'],
            [['num_sentimiento_general', 'num_magnitud_general'], 'number'],
            [['fch_busqueda'], 'safe'],
            [['txt_palabra_clave'], 'string', 'max' => 100],
            [['id_compania'], 'exist', 'skipOnError' => true, 'targetClass' => EntCompanias::className(), 'targetAttribute' => ['id_compania' => 'id_compania']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => \app\modules\ModUsuarios\models\EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_palabra_clave' => 'Id Palabra Clave',
            'id_compania' => 'Id Compania',
            'id_usuario' => 'Id Usuario',
            'txt_palabra_clave' => 'Txt Palabra Clave',
            'num_sentimiento_general' => 'Num Sentimiento General',
            'num_magnitud_general' => 'Num Magnitud General',
            'fch_busqueda' => 'Fch Busqueda',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCompania()
    {
        return $this->hasOne(EntCompanias::className(), ['id_compania' => 'id_compania']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntRastreoTextos()
    {
        return $this->hasMany(EntRastreoTextos::className(), ['id_palabra_clave' => 'id_palabra_clave']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelPalabraPalabras()
    {
        return $this->hasMany(RelPalabraPalabras::className(), ['id_palabra_clave' => 'id_palabra_clave']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelPalabraPersonas()
    {
        return $this->hasMany(RelPalabraPersonas::className(), ['id_palabra_clave' => 'id_palabra_clave']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelPalabraSigResultados()
    {
        return $this->hasMany(RelPalabraSigResultado::className(), ['id_palabra_clave' => 'id_palabra_clave']);
    }
}
