<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Mubannews;

/**
 * MubannewsSearch represents the model behind the search form about `backend\models\Mubannews`.
 */
class MubannewsSearch extends Mubannews
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['template_id', 'name', 'first', 'key1', 'key2', 'key3', 'key4', 'remark'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Mubannews::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'template_id', $this->template_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'first', $this->first])
            ->andFilterWhere(['like', 'key1', $this->key1])
            ->andFilterWhere(['like', 'key2', $this->key2])
            ->andFilterWhere(['like', 'key3', $this->key3])
            ->andFilterWhere(['like', 'key4', $this->key4])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
