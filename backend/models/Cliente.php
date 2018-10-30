<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apaterno
 * @property string $amaterno
 * @property string $telefono
 * @property string $direccion
 * @property string $observaciones
 * @property int $estado
 *
 * @property Registro[] $registros
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
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
            [['id'], 'required'],
            [['id', 'telefono', 'estado'], 'default', 'value' => null],
            [['id', 'telefono', 'estado'], 'integer'],
            [['direccion', 'observaciones'], 'string'],
            [['nombre', 'apaterno', 'amaterno'], 'string', 'max' => 45],
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
            'apaterno' => Yii::t('app', 'Apaterno'),
            'amaterno' => Yii::t('app', 'Amaterno'),
            'telefono' => Yii::t('app', 'Telefono'),
            'direccion' => Yii::t('app', 'Direccion'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::className(), ['cliente_id' => 'id']);
    }
}
