<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * MoneySearch represents the model behind the search form about `backend\models\Money`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'cid', 'created_at', 'updated_at', 'order_at', 'pay_at', 'deliver_at', 'over_at', 'status'], 'integer'],
			 [['info', 'phone', 'name', 'address', 'payway'], 'string'],
            [['info', 'order_num', 'trade_no', 'payway'], 'safe'],
            [['money'], 'number'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'cid' => $this->cid,
            'money' => $this->money,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order_at' => $this->order_at,
            'pay_at' => $this->pay_at,
            'deliver_at' => $this->deliver_at,
            'over_at' => $this->over_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'order_num', $this->order_num])
            ->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'payway', $this->payway]);

        return $dataProvider;
    }
}
