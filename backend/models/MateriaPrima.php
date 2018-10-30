<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "materia_prima".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $observaciones
 * @property int $proveedor_id
 *
 * @property Proveedor $proveedor
 */
class MateriaPrima extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materia_prima';
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
            [['id', 'proveedor_id'], 'required'],
            [['id', 'proveedor_id'], 'default', 'value' => null],
            [['id', 'proveedor_id'], 'integer'],
            [['descripcion', 'observaciones'], 'string'],
            [['nombre'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
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
            'descripcion' => Yii::t('app', 'Descripcion'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'proveedor_id' => Yii::t('app', 'Proveedor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Proveedor::className(), ['id' => 'proveedor_id']);
    }
}
