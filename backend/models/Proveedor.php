<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "proveedor".
 *
 * @property int $id
 * @property string $nombre
 * @property int $telefono
 * @property string $direccion
 * @property string $observaciones
 * @property int $estado
 *
 * @property MateriaPrimaP[] $materiaPrimaPs
 */
class Proveedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proveedor';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'telefono'], 'required'],
            [['id', 'telefono', 'estado'], 'default', 'value' => null],
            [['id', 'telefono', 'estado'], 'integer'],
            [['direccion', 'observaciones'], 'string'],
            [['nombre'], 'string', 'max' => 45],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'telefono' => Yii::t('app', 'Telefono'),
            'direccion' => Yii::t('app', 'Direccion'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMateriaPrimaPs()
    {
        return $this->hasMany(MateriaPrimaP::className(), ['proveedor_id' => 'id']);
    }
}
