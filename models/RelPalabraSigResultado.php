<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_palabra_sig_resultado".
 *
 * @property integer $id_palabra_clave
 * @property string $txt_parametros_sig_resultado
 *
 * @property EntPalabrasClaves $idPalabraClave
 */
class RelPalabraSigResultado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_palabra_sig_resultado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_palabra_clave', 'txt_parametros_sig_resultado'], 'required'],
            [['id_palabra_clave'], 'integer'],
            [['txt_parametros_sig_resultado'], 'string', 'max' => 500],
            [['id_palabra_clave'], 'exist', 'skipOnError' => true, 'targetClass' => EntPalabrasClaves::className(), 'targetAttribute' => ['id_palabra_clave' => 'id_palabra_clave']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_palabra_clave' => 'Id Palabra Clave',
            'txt_parametros_sig_resultado' => 'Txt Parametros Sig Resultado',
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
