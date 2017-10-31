<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_palabra_personas".
 *
 * @property integer $id_palabra_clave
 * @property string $txt_persona
 *
 * @property EntPalabrasClaves $idPalabraClave
 */
class RelPalabraPersonas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_palabra_personas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_palabra_clave', 'txt_persona'], 'required'],
            [['id_palabra_clave'], 'integer'],
            [['txt_persona'], 'string', 'max' => 100],
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
            'txt_persona' => 'Txt Persona',
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
