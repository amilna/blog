<?php

namespace amilna\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amilna\blog\models\Post;

/**
 * PostSearch represents the model behind the search form about `amilna\blog\models\Post`.
 */
class PostSearch extends Post
{

	
	/*public $blogcatposId;*/
	public $author;
	public $search;
	public $category;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'status', 'isdel'], 'integer'],
            [['title', 'description', 'content', 'tags', 'image', 'time', 'search', 'category','author'/*, blogcatposId*/], 'safe'],
            [['isfeatured'], 'boolean'],
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

	private function queryString($fields)
	{		
		$params = [];
		foreach ($fields as $afield)
		{
			$field = $afield[0];
			$tab = isset($afield[1])?$afield[1]:false;			
			if (!empty($this->$field))
			{				
				array_push($params,["like", "lower(".($tab?$tab.".":"").$field.")", strtolower($this->$field)]);
			}
		}	
		return $params;
	}	
	
	private function queryNumber($fields)
	{		
		$params = [];
		foreach ($fields as $afield)
		{
			$field = $afield[0];
			$tab = isset($afield[1])?$afield[1]:false;			
			if (!empty($this->$field))
			{				
				$number = explode(" ",$this->$field);			
				if (count($number) == 2)
				{									
					array_push($params,[$number[0], ($tab?$tab.".":"").$field, $number[1]]);	
				}
				elseif (count($number) > 2)
				{															
					array_push($params,[">=", ($tab?$tab.".":"").$field, $number[0]]);
					array_push($params,["<=", ($tab?$tab.".":"").$field, $number[0]]);
				}
				else
				{					
					array_push($params,["=", ($tab?$tab.".":"").$field, str_replace(["<",">","="],"",$number[0])]);
				}									
			}
		}	
		return $params;
	}
	
	private function queryTime($fields)
	{		
		$params = [];
		foreach ($fields as $afield)
		{
			$field = $afield[0];
			$tab = isset($afield[1])?$afield[1]:false;			
			if (!empty($this->$field))
			{				
				$time = explode(" - ",$this->$field);			
				if (count($time) > 1)
				{								
					array_push($params,[">=", "concat('',".($tab?$tab.".":"").$field.")", $time[0]]);	
					array_push($params,["<=", "concat('',".($tab?$tab.".":"").$field.")", $time[1]." 24:00:00"]);
				}
				else
				{
					if (substr($time[0],0,2) == "< " || substr($time[0],0,2) == "> " || substr($time[0],0,2) == "<=" || substr($time[0],0,2) == ">=") 
					{					
						array_push($params,[str_replace(" ","",substr($time[0],0,2)), "concat('',".($tab?$tab.".":"").$field.")", trim(substr($time[0],2))]);
					}
					else
					{					
						array_push($params,["like", "concat('',".($tab?$tab.".":"").$field.")", $time[0]]);
					}
				}	
			}
		}	
		return $params;
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
        $query = Post::find();
        
        $query->joinWith(['author'/*,blogcatpos*/]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        /* uncomment to sort by relations table on respective column
		$dataProvider->sort->attributes['blogcatposId'] = [			
			'asc' => ['{{%blogcatpos}}.id' => SORT_ASC],
			'desc' => ['{{%blogcatpos}}.id' => SORT_DESC],
		];*/
		$dataProvider->sort->attributes['author'] = [			
			'asc' => ['{{%user}}.username' => SORT_ASC],
			'desc' => ['{{%user}}.username' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['search'] = [			
			'asc' => ['title' => SORT_ASC],
			'desc' => ['title' => SORT_DESC],
		];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }				
		
        $params = self::queryNumber([['id'],['author_id'],['isfeatured'],['status'],['isdel']/*['id','{{%blogcatpos}}'],['id','{{%author}}']*/]);
		foreach ($params as $p)
		{
			$query->andFilterWhere($p);
		}
        $params = self::queryString([['title'],['description'],['content'],['tags'],['image']/*['id','{{%blogcatpos}}'],['id','{{%author}}']*/]);
		foreach ($params as $p)
		{
			$query->andFilterWhere($p);
		}
        $params = self::queryTime([['time']/*['id','{{%blogcatpos}}'],['id','{{%author}}']*/]);
		foreach ($params as $p)
		{
			$query->andFilterWhere($p);
		}
		
		$userClass = Yii::$app->getModule('blog')->userClass;
		$query->andFilterWhere(['like','lower('.$userClass::tableName().'.username)',strtolower($this->author)]);
		
		$query->andFilterWhere(['like','lower(title)',strtolower($this->search)])
				->orFilterWhere(['like','lower(description)',strtolower($this->search)])
				->orFilterWhere(['like','lower(tags)',strtolower($this->search)])
				->orFilterWhere(['like','lower(content)',strtolower($this->search)]);
		
		if ($this->category || $this->search)
		{
			$term = ($this->search?$this->search:$this->category);
			$cquery =  new \yii\db\Query;
			$cquery->select(["p.id"])
					->from("{{%blog_post}} as p")
					->leftJoin("{{%blog_cat_pos}} as cp","p.id = cp.post_id")
					->leftJoin("{{%blog_category}} as c","cp.category_id = c.id");
					
			if ($this->category)
			{
				$query->andFilterWhere(["=","{{%blog_post}}.id",(-1)]);
				$cquery->where("lower(c.title) = '".strtolower($term)."'");
			}
			else
			{
				$cquery->where("lower(c.title) like '%".strtolower($term)."' or lower(c.description) like '%".strtolower($term)."'");
			}		
									
			$res = $cquery->all();					
			foreach ($res as $r)
			{
				$p = ["=","{{%blog_post}}.id",$r["id"]];
				$query->orFilterWhere($p);				
			}
        
		}
		
        return $dataProvider;
    }
}
