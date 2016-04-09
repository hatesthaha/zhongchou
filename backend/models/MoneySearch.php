<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Money;

/**
 * MoneySearch represents the model behind the search form about `backend\models\Money`.
 */
class MoneySearch extends Money
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'created_at', 'order_at', 'pay_at', 'deliver_at', 'over_at', 'status', 'updated_at'], 'integer'],
            [['uid','cid'],'string'],
            [['info', 'money', 'order_num'], 'safe'],
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
        $query = Money::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this->uid){
            $user = Member::find()->andFilterWhere(['like','name',$this->uid])->all();
            $sid = [];
            foreach($user as $key => $val){
                array_push($sid,$val['id']);
            }
            $query->andWhere(['in','uid', $sid]);
        }
        if($this->cid){
            $user = Product::find()->andFilterWhere(['like','name',$this->cid])->all();
            $cid = [];
            foreach($user as $key => $val){
                array_push($cid,$val['id']);
            }
            $query->andWhere(['in','cid', $cid]);
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'order_at' => $this->order_at,
            'pay_at' => $this->pay_at,
            'deliver_at' => $this->deliver_at,
            'over_at' => $this->over_at,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'money', $this->money])
            ->andFilterWhere(['like', 'order_num', $this->order_num])->OrderBy('updated_at DESC');

        return $dataProvider;
    }
}
