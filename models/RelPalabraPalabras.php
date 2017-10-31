<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_palabra_palabras".
 *
 * @property integer $id_palabra_clave
 * @property string $txt_rel_palabra
 *
 * @property EntPalabrasClaves $idPalabraClave
 */
class RelPalabraPalabras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_palabra_palabras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_palabra_clave', 'txt_rel_palabra'], 'required'],
            [['id_palabra_clave'], 'integer'],
            [['txt_rel_palabra'], 'string', 'max' => 100],
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
            'txt_rel_palabra' => 'Txt Rel Palabra',
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
