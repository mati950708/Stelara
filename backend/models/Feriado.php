<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "feriado".
 *
 * @property int $idferiado
 * @property string $feriado
 *
 * @property ProductHasUser[] $productHasUsers
 */
class Feriado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feriado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feriado'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idferiado' => Yii::t('app', 'Idferiado'),
            'feriado' => Yii::t('app', 'Feriado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasUsers()
    {
        return $this->hasMany(ProductHasUser::className(), ['feriado_idferiado' => 'idferiado']);
    }
}
