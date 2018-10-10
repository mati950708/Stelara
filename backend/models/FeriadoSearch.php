<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Feriado;

/**
 * FeriadoSearch represents the model behind the search form of `backend\models\Feriado`.
 */
class FeriadoSearch extends Feriado
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idferiado'], 'integer'],
            [['feriado'], 'safe'],
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
        $query = Feriado::find();

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
            'idferiado' => $this->idferiado,
        ]);

        $query->andFilterWhere(['like', 'feriado', $this->feriado]);

        return $dataProvider;
    }
}
