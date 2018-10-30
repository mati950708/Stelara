<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "registro".
 *
 * @property int $id
 * @property int $cantidad
 * @property string $fecha
 * @property int $estado
 * @property string $observaciones
 * @property int $producto_id
 * @property int $tipo_r_id
 * @property int $cliente_id
 * @property string $precio_venta
 * @property string $precio_costo
 *
 * @property Cliente $cliente
 * @property Producto $producto
 * @property TipoR $tipoR
 */
class Registro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro';
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
            [['id', 'cantidad', 'producto_id', 'tipo_r_id', 'cliente_id'], 'required'],
            [['id', 'cantidad', 'estado', 'producto_id', 'tipo_r_id', 'cliente_id'], 'default', 'value' => null],
            [['id', 'cantidad', 'estado', 'producto_id', 'tipo_r_id', 'cliente_id'], 'integer'],
            [['fecha'], 'safe'],
            [['observaciones'], 'string'],
            [['precio_venta', 'precio_costo'], 'number'],
            [['id'], 'unique'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['tipo_r_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoR::className(), 'targetAttribute' => ['tipo_r_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'fecha' => Yii::t('app', 'Fecha'),
            'estado' => Yii::t('app', 'Estado'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'producto_id' => Yii::t('app', 'Producto ID'),
            'tipo_r_id' => Yii::t('app', 'Tipo R ID'),
            'cliente_id' => Yii::t('app', 'Cliente ID'),
            'precio_venta' => Yii::t('app', 'Precio Venta'),
            'precio_costo' => Yii::t('app', 'Precio Costo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['id' => 'cliente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'producto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoR()
    {
        return $this->hasOne(TipoR::className(), ['id' => 'tipo_r_id']);
    }
}
