<?php

namespace app\models\search;

use app\models\History;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * HistorySearch represents the model behind the search form about `app\models\History`.
 *
 * @property array $objects
 */
class HistorySearch extends History
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
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
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = History::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'ins_ts' => SORT_DESC,
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // If validation fails, return empty data provider
            return $dataProvider;
        }

        // Apply filtering conditions
        $query->andFilterWhere([
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'object', $this->object]);

        // Load related models
        $query->with([
            'customer',
            'user',
            'sms',
            'task',
            'call',
            'fax',
        ]);

        return $dataProvider;
    }
}
