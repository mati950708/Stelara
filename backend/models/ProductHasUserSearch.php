<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductHasUser;

/**
 * ProductHasUserSearch represents the model behind the search form of `backend\models\ProductHasUser`.
 */
class ProductHasUserSearch extends ProductHasUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idphu', 'product_idproduct', 'user_id', 'piezasProducidas', 'piezasVendidas', 'piezasMerma', 'situation_idsituation', 'shop_idshop', 'feriado_idferiado'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductHasUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idphu' => $this->idphu,
            'product_idproduct' => $this->product_idproduct,
            'user_id' => $this->user_id,
            'piezasProducidas' => $this->piezasProducidas,
            'piezasVendidas' => $this->piezasVendidas,
            'piezasMerma' => $this->piezasMerma,
            'date' => $this->date,
            'situation_idsituation' => $this->situation_idsituation,
            'shop_idshop' => $this->shop_idshop,
            'feriado_idferiado' => $this->feriado_idferiado,
        ]);

        return $dataProvider;
    }
}
