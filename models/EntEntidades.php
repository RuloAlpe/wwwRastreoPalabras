<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_entidades".
 *
 * @property string $id_entidad
 * @property integer $id_palabra_clave
 * @property integer $id_rastreo_texto
 * @property string $txt_nombre
 * @property string $txt_tipo
 * @property double $num_sentimiento
 * @property double $num_magnitud
 *
 * @property EntPalabrasClaves $idPalabraClave
 * @property EntRastreoTextos $idRastreoTexto
 */
class EntEntidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_entidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_palabra_clave', 'id_rastreo_texto', 'txt_nombre', 'txt_tipo', 'num_sentimiento', 'num_magnitud'], 'required'],
            [['id_palabra_clave', 'id_rastreo_texto'], 'integer'],
            [['num_sentimiento', 'num_magnitud'], 'number'],
            [['txt_nombre'], 'string', 'max' => 200],
            [['txt_tipo'], 'string', 'max' => 100],
            [['id_palabra_clave'], 'exist', 'skipOnError' => true, 'targetClass' => EntPalabrasClaves::className(), 'targetAttribute' => ['id_palabra_clave' => 'id_palabra_clave']],
            [['id_rastreo_texto'], 'exist', 'skipOnError' => true, 'targetClass' => EntRastreoTextos::className(), 'targetAttribute' => ['id_rastreo_texto' => 'id_rastreo_texto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_entidad' => 'Id Entidad',
            'id_palabra_clave' => 'Id Palabra Clave',
            'id_rastreo_texto' => 'Id Rastreo Texto',
            'txt_nombre' => 'Txt Nombre',
            'txt_tipo' => 'Txt Tipo',
            'num_sentimiento' => 'Num Sentimiento',
            'num_magnitud' => 'Num Magnitud',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPalabraClave()
    {
        return $this->hasOne(EntPalabrasClaves::className(), ['id_palabra_clave' => 'id_palabra_clave']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRastreoTexto()
    {
        return $this->hasOne(EntRastreoTextos::className(), ['id_rastreo_texto' => 'id_rastreo_texto']);
    }
}
