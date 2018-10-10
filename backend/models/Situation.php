<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "situation".
 *
 * @property int $idsituation
 * @property string $situation
 *
 * @property ProductHasUser[] $productHasUsers
 */
class Situation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'situation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['situation'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idsituation' => Yii::t('app', 'Idsituation'),
            'situation' => Yii::t('app', 'Situation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasUsers()
    {
        return $this->hasMany(ProductHasUser::className(), ['situation_idsituation' => 'idsituation']);
    }
}
