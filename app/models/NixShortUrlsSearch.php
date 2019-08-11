<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * urlsSearch represents the model behind the search form about `app\models\NixShortUrls`.
 */
class NixShortUrlsSearch extends NixShortUrls
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'counter'], 'integer'],
            [['long_url', 'short_code', 'time_create', 'time_end'], 'safe'],
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
        $query = NixShortUrls::find()->addOrderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'time_create' => $this->time_create,
            'time_end' => $this->time_end,
            'counter' => $this->counter,
        ]);

        $query
            ->andFilterWhere(['like', 'long_url', $this->long_url])
            ->andFilterWhere(['like', 'short_code', $this->short_code]);

        return $dataProvider;
    }
}