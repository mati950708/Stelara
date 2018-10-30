<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bitacora".
 *
 * @property int $id
 * @property string $fecha
 * @property string $descripcion
 * @property string $producto
 */
class Bitacora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bitacora';
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
            [['id', 'descripcion'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string'],
            [['producto'], 'string', 'max' => 45],
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
            'fecha' => Yii::t('app', 'Fecha'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'producto' => Yii::t('app', 'Producto'),
        ];
    }
}
