<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_palabra_refrescar_url".
 *
 * @property integer $id_palabra_clave
 * @property string $txt_refrescar_url
 *
 * @property EntPalabrasClaves $idPalabraClave
 */
class RelPalabraRefrescarUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_palabra_refrescar_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_palabra_clave', 'txt_refrescar_url'], 'required'],
            [['id_palabra_clave'], 'integer'],
            [['txt_refrescar_url'], 'string', 'max' => 200],
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
            'txt_refrescar_url' => 'Txt Refrescar Url',
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
