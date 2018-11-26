<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property string $nombre
 * @property string $precio_unit
 * @property int $cantidad_actual
 * @property int $estado
 * @property string $observaciones
 * @property int $category_id
 * @property string $costo_unit
 *
 * @property CategoriaP $category
 * @property Registro[] $registros
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
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
            [['id', 'precio_unit', 'costo_unit', 'category_id', 'nombre'], 'required'],
            [['id', 'cantidad_actual', 'estado', 'category_id'], 'default', 'value' => null],
            [['id', 'estado', 'category_id'], 'integer'],
            [['precio_unit', 'costo_unit'], 'number', 'min' => 1],
            [['observaciones'], 'string'],
            [['nombre'], 'string', 'max' => 45],
            ['precio_unit', 'compare', 'compareAttribute' => 'costo_unit', 'operator' => '>'],
            ['costo_unit', 'compare', 'compareAttribute' => 'precio_unit', 'operator' => '<'],
            [['cantidad_actual'], 'integer'],
            [['id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaP::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'precio_unit' => Yii::t('app', 'Precio Unitario'),
            'cantidad_actual' => Yii::t('app', 'Cantidad Actual'),
            'estado' => Yii::t('app', 'Estado'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'category_id' => Yii::t('app', 'Categoría'),
            'costo_unit' => Yii::t('app', 'Costo Unitario'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoriaP::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::className(), ['producto_id' => 'id']);
    }
}
