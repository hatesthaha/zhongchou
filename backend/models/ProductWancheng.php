<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Term;
use backend\models\Product;
/**
 * ProductSearch represents the model behind the search form about `backend\models\Product`.
 */
class ProductWancheng extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['h_num', 's_num', 'top_ok', 'status', 'r_day', 'pay', 'created_at', 'updated_at', 'user_id', 'end_time', 'search_num', 'shenhe','term_id','sort','sorted_at','lucky_num'], 'integer',],
            [['total_money', 'target_money', 'zhichu_money', 'shouru_money'], 'number'],
            [['name'], 'string', 'max' => 255],
			[['content'], 'string'],
			[['img'], 'file', 'maxFiles' => 4,'extensions'=>'jpg,png,gif,jpeg'],
			[['c_img'], 'file', 'extensions'=>'jpg,png,gif,jpeg']
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
        $val = Term::get(8, Term::find()->all());
        $data="";
        foreach($val as $k=>$v){
            $data .= ",".$v['id'];
        }
        $query = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('term_id not in (7,8)');
            return $dataProvider;
        }
		$query->where('term_id in (2,3,4,5,6,7'.$data.')');
        $query->andFilterWhere([
            'id' => $this->id,
            'h_num' => $this->h_num,
            's_num' => $this->s_num,
            'total_money' => $this->total_money,
            'target_money' => $this->target_money,
            'top_ok' => $this->top_ok,
            'status' => 1,
            'r_day' => $this->r_day,
            'shenhe' => $this->shenhe,
            'pay' => $this->pay,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'end_time' => $this->end_time,
            'search_num' => $this->search_num,
            'zhichu_money' => $this->zhichu_money,
            'shouru_money' => $this->shouru_money,
			'term_id' => $this->term_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'c_img', $this->c_img]);

        return $dataProvider;
    }
	
	
	public static function getArrayTerm()
    {
		$terms = Term::find('name,id')->where('parent_id in (1,8) and id<>8')->all();
		$reterm = [];
		foreach ($terms as $t) {
			$reterm[$t['id']] = Yii::t('app', $t['name']);
		}
		//var_dump($reterm[12]);exit;
		//var_dump($reterm);exit;
        return $reterm;
    }
	
	
	
}
