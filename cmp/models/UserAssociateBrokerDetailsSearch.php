<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserAssociateBrokerDetails;

/**
 * UserAssociateBrokerDetailsSearch represents the model behind the search form about `app\models\UserAssociateBrokerDetails`.
 */
class UserAssociateBrokerDetailsSearch extends UserAssociateBrokerDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'createdby', 'updatedby'], 'integer'],
            [['company_name', 'brand_name', 'akta_perusahaan', 'nib', 'sk_menkeh', 'npwp', 'ktp_direktur', 'bank_account', 'createdat', 'updatedat'], 'safe'],
            [['credits'], 'number'],
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
        $query = UserAssociateBrokerDetails::find();

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
            'user_id' => $this->user_id,
            'credits' => $this->credits,
            'createdby' => $this->createdby,
            'createdat' => $this->createdat,
            'updatedby' => $this->updatedby,
            'updatedat' => $this->updatedat,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'brand_name', $this->brand_name])
            ->andFilterWhere(['like', 'akta_perusahaan', $this->akta_perusahaan])
            ->andFilterWhere(['like', 'nib', $this->nib])
            ->andFilterWhere(['like', 'sk_menkeh', $this->sk_menkeh])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['like', 'ktp_direktur', $this->ktp_direktur])
            ->andFilterWhere(['like', 'bank_account', $this->bank_account]);

        return $dataProvider;
    }
}
