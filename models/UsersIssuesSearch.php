<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsersIssues;
//use app\models\Projects;
/**
 * UsersIssuesSearch represents the model behind the search form about `app\models\UsersIssues`.
 */
class UsersIssuesSearch extends UsersIssues
{
    //public $id_project;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', /*'id_issue',*/ 'is_creator'], 'integer'],
            [['id_issue', 'name'], 'safe'],
            //[['id_project', 'name'], 'safe'],
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
        
        //$this->id_project = $_GET['id_project'];
        
        $query = UsersIssues::find();
        $query->joinWith(['idIssue'])
        
        ->join(	'JOIN',
                'projects',
				'projects.id = issues.id_project'
			); 
        
        ////idIssue.
        //$query->joinWith(['idProject', 'idProject.id']);
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
            'id_user' => $this->id_user,
            //'id_issue' => $this->id_issue,
            'is_creator' => $this->is_creator,
        ])
                
        ->andFilterWhere(['like', 'issues.name', $this->id_issue]);
        //->andFilterWhere(['like', 'projects.name', '']);
        return $dataProvider;
    }
}