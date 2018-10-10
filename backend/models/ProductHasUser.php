<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "product_has_user".
 *
 * @property int $idphu
 * @property int $product_idproduct
 * @property int $user_id
 * @property int $piezasProducidas
 * @property int $piezasVendidas
 * @property int $piezasMerma
 * @property string $date
 * @property int $situation_idsituation
 * @property int $shop_idshop
 *
 * @property Product $productIdproduct
 * @property Shop $shopIdshop
 * @property Situation $situationIdsituation
 * @property Feriado $feriadoIdferiado
 * @property User $user
 */
class ProductHasUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_has_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_idproduct', 'user_id', 'shop_idshop'], 'required'],
            [['product_idproduct', 'user_id', 'piezasProducidas', 'piezasVendidas', 'piezasMerma', 'situation_idsituation', 'shop_idshop'], 'integer'],
            [['date'], 'safe'],
            [['product_idproduct'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_idproduct' => 'idproduct']],
            [['shop_idshop'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_idshop' => 'idshop']],
            [['situation_idsituation'], 'exist', 'skipOnError' => true, 'targetClass' => Situation::className(), 'targetAttribute' => ['situation_idsituation' => 'idsituation']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idphu' => Yii::t('app', 'Idphu'),
            'product_idproduct' => Yii::t('app', 'Product'),
            'user_id' => Yii::t('app', 'User ID'),
            'piezasProducidas' => Yii::t('app', 'Piezas Producidas'),
            'piezasVendidas' => Yii::t('app', 'Piezas Vendidas'),
            'piezasMerma' => Yii::t('app', 'Piezas Merma'),
            'date' => Yii::t('app', 'Date'),
            'situation_idsituation' => Yii::t('app', 'Situation'),
            'feriado_idferiado' => Yii::t('app', 'Feriado'),
            'shop_idshop' => Yii::t('app', 'Shop'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductIdproduct()
    {
        return $this->hasOne(Product::className(), ['idproduct' => 'product_idproduct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopIdshop()
    {
        return $this->hasOne(Shop::className(), ['idshop' => 'shop_idshop']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituationIdsituation()
    {
        return $this->hasOne(Situation::className(), ['idsituation' => 'situation_idsituation']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeriadoIdferiado()
    {
        return $this->hasOne(Feriado::className(), ['idferiado' => 'feriado_idferiado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
