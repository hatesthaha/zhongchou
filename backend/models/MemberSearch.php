<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Member;

/**
 * MemberSearch represents the model behind the search form about `backend\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sign', 'created_at', 'updated_at', 'gender', 'product_id', 'prestige','day','ceiling'], 'integer'],
            [['name', 'auth_key', 'password_hash', 'password_reset_token', 'phone', 'cardid', 'head', 'autograph', 'level', 'email', 'signature', 'address', 'seen', 'search_record'], 'safe'],
            [['tmoney'], 'number'],
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
        $query = Member::find();

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
            'sign' => $this->sign,
            'tmoney' => $this->tmoney,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gender' => $this->gender,
            'product_id' => $this->product_id,
            'prestige' => $this->prestige,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'cardid', $this->cardid])
            ->andFilterWhere(['like', 'head', $this->head])
            ->andFilterWhere(['like', 'autograph', $this->autograph])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'seen', $this->seen])
            ->andFilterWhere(['like', 'search_record', $this->search_record]);

        return $dataProvider;
    }
}
