<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserEligibleCommissions;

/**
 * UserEligibleCommissionsSearch represents the model behind the search form about `app\models\UserEligibleCommissions`.
 */
class UserEligibleCommissionsSearch extends UserEligibleCommissions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_commission_id', 'prospect_booking_id', 'user_id', 'createdby', 'updatedby', 'deletedby'], 'integer'],
            [['commission_eligible_amount'], 'number'],
            [['status', 'createdat', 'updatedat', 'deletedat'], 'safe'],
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
        $query = UserEligibleCommissions::find();

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
            'user_commission_id' => $this->user_commission_id,
            'prospect_booking_id' => $this->prospect_booking_id,
            'user_id' => $this->user_id,
            'commission_eligible_amount' => $this->commission_eligible_amount,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
            'updatedby' => $this->updatedby,
            'updatedat' => $this->updatedat,
            'deletedby' => $this->deletedby,
            'deletedat' => $this->deletedat,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
