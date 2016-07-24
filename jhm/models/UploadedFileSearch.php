<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UploadedFile;

/**
 * UploadedFileSearch represents the model behind the search form about `app\models\UploadedFile`.
 */
class UploadedFileSearch extends UploadedFile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'added_by'], 'integer'],
            [['candidate_first_name', 'candidate_last_name', 'file_name', 'path'], 'safe'],
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
        $query = UploadedFile::find();

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
            'added_by' => $this->added_by,
        ]);

        $query->andFilterWhere(['like', 'candidate_first_name', $this->candidate_first_name])
            ->andFilterWhere(['like', 'candidate_last_name', $this->candidate_last_name])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'path', $this->path]);

        return $dataProvider;
    }
}
