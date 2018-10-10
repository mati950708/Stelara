<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $idproduct
 * @property string $name
 * @property string $price
 * @property int $category_idcategory
 *
 * @property Category $categoryIdcategory
 * @property ProductHasUser[] $productHasUsers
 * @property User[] $users
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['category_idcategory'], 'required'],
            [['category_idcategory'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['category_idcategory'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_idcategory' => 'idcategory']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idproduct' => Yii::t('app', 'Idproduct'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'category_idcategory' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryIdcategory()
    {
        return $this->hasOne(Category::className(), ['idcategory' => 'category_idcategory']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasUsers()
    {
        return $this->hasMany(ProductHasUser::className(), ['product_idproduct' => 'idproduct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('product_has_user', ['product_idproduct' => 'idproduct']);
    }
}
