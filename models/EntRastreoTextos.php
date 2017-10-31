<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_rastreo_textos".
 *
 * @property integer $id_rastreo_texto
 * @property string $id_elemento_texto
 * @property integer $id_palabra_clave
 * @property string $txt_rastero_texto
 * @property double $num_sentimiento_texto
 * @property double $num_magnitud_texto
 * @property string $fch_rastreo
 * @property string $fch_elemento_texto
 *
 * @property EntPalabrasClaves $idPalabraClave
 */
class EntRastreoTextos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_rastreo_textos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_elemento_texto', 'id_palabra_clave', 'txt_rastero_texto', 'num_sentimiento_texto', 'num_magnitud_texto'], 'required'],
            [['id_elemento_texto', 'id_palabra_clave'], 'integer'],
            [['txt_rastero_texto'], 'string'],
            [['num_sentimiento_texto', 'num_magnitud_texto'], 'number'],
            [['fch_rastreo', 'fch_elemento_texto'], 'safe'],
            [['id_palabra_clave'], 'exist', 'skipOnError' => true, 'targetClass' => EntPalabrasClaves::className(), 'targetAttribute' => ['id_palabra_clave' => 'id_palabra_clave']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_rastreo_texto' => 'Id Rastreo Texto',
            'id_elemento_texto' => 'Id Elemento Texto',
            'id_palabra_clave' => 'Id Palabra Clave',
            'txt_rastero_texto' => 'Txt Rastero Texto',
            'num_sentimiento_texto' => 'Num Sentimiento Texto',
            'num_magnitud_texto' => 'Num Magnitud Texto',
            'fch_rastreo' => 'Fch Rastreo',
            'fch_elemento_texto' => 'Fch Elemento Texto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPalabraClave()
    {
        return $this->hasOne(EntPalabrasClaves::className(), ['id_palabra_clave' => 'id_palabra_clave']);
    }
}
