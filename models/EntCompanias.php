<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_companias".
 *
 * @property integer $id_compania
 * @property string $txt_nombre_compania
 *
 * @property EntPalabrasClaves[] $entPalabrasClaves
 * @property ModUsuariosEntUsuarios[] $modUsuariosEntUsuarios
 */
class EntCompanias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_companias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre_compania'], 'required'],
            [['txt_nombre_compania'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_compania' => 'Id Compania',
            'txt_nombre_compania' => 'Txt Nombre Compania',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPalabrasClaves()
    {
        return $this->hasMany(EntPalabrasClaves::className(), ['id_compania' => 'id_compania']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModUsuariosEntUsuarios()
    {
        return $this->hasMany(ModUsuariosEntUsuarios::className(), ['id_compania' => 'id_compania']);
    }
}
