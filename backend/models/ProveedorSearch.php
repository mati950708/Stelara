<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Proveedor;

/**
 * ProveedorSearch represents the model behind the search form of `backend\models\Proveedor`.
 */
class ProveedorSearch extends Proveedor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'telefono'], 'integer'],
            [['nombre', 'direccion', 'observaciones'], 'safe'],
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
        $query = Proveedor::find();

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
            'id' => $this->id,
            'telefono' => $this->telefono,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'direccion', $this->direccion])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
