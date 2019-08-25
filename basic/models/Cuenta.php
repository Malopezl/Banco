<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Cuenta".
 *
 * @property int $id
 * @property string $Nombre
 * @property double $Saldo
 * @property double $monto
 * @property int $isolation
 */
class Cuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Saldo', 'monto'], 'number'],
            [['isolation'], 'integer'],
            [['Nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Nombre' => 'Nombre',
            'Saldo' => 'Saldo',
            'monto' => 'Monto',
            'isolation' => 'Isolation',
        ];
    }
}
