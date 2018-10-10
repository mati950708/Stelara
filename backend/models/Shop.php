<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $idshop
 * @property string $name
 *
 * @property User[] $users
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idshop' => Yii::t('app', 'Idshop'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['shop_idshop' => 'idshop']);
    }
}
