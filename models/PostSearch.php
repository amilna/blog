<?php

namespace amilna\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amilna\blog\models\Post;
use amilna\blog\models\BlogCatPos;

/**
 * PostSearch represents the model behind the search form about `amilna\blog\models\Post`.
 */
class PostSearch extends Post
{

	
	/*public $blogcatposId;*/
	public $authorName;
	public $term;
	public $category;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'status', 'isdel'], 'integer'],
            [['title', 'description', 'content', 'tags', 'image', 'time', 'term', 'category','authorName'/*, blogcatposId*/], 'safe'],
            [['isfeatured'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'term' => Yii::t('app', 'Search'),            
            'category' => Yii::t('app', 'Category'),            
            'authorName' => Yii::t('app', 'Author'),            
        ]);
    }

	public static function find()
	{
		return parent::find()->where([Post::tableName().'.isdel' => 0]);
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
				if (substr($this->$field,0,2) == "< " || substr($this->$field,0,2) == "> " || substr($this->$field,0,2) == "<=" || substr($this->$field,0,2) == ">=" || substr($this->$field,0,2) == "<>") 
				{					
					array_push($params,[str_replace(" ","",substr($this->$field,0,2)), "lower(".($tab?$tab.".":"").$field.")", strtolower(trim(substr($this->$field,2)))]);
				}
				else
				{					
					array_push($params,["like", "lower(".($tab?$tab.".":"").$field.")", strtolower($this->$field)]);
				}				
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
				$number = explode(" ",trim($this->$field));							
				if (count($number) == 2)
				{									
					if (in_array($number[0],['>','>=','<','<=','<>']) && is_numeric($number[1]))
					{
						array_push($params,[$number[0], ($tab?$tab.".":"").$field, $number[1]]);	
					}
				}
				elseif (count($number) == 3)
				{															
					if (is_numeric($number[0]) && is_numeric($number[2]))
					{
						array_push($params,['>=', ($tab?$tab.".":"").$field, $number[0]]);		
						array_push($params,['<=', ($tab?$tab.".":"").$field, $number[2]]);		
					}
				}
				elseif (count($number) == 1)
				{					
					if (is_numeric($number[0]))
					{
						array_push($params,['=', ($tab?$tab.".":"").$field, str_replace(["<",">","="],"",$number[0])]);		
					}	
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
					if (substr($time[0],0,2) == "< " || substr($time[0],0,2) == "> " || substr($time[0],0,2) == "<=" || substr($time[0],0,2) == ">=" || substr($time[0],0,2) == "<>") 
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
        $query = $this->find();
        
        $query->joinWith(['author'/*,blogcatpos*/]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $userClass = Yii::$app->getModule('blog')->userClass;
        
        /* uncomment to sort by relations table on respective column
		$dataProvider->sort->attributes['blogcatposId'] = [			
			'asc' => ['{{%blogcatpos}}.id' => SORT_ASC],
			'desc' => ['{{%blogcatpos}}.id' => SORT_DESC],
		];*/
		$dataProvider->sort->attributes['authorName'] = [			
			'asc' => [$userClass::tableName().'.username' => SORT_ASC],
			'desc' => [$userClass::tableName().'.username' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['term'] = [			
			'asc' => ['title' => SORT_ASC],
			'desc' => ['title' => SORT_DESC],
		];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }				
		
		$query->andFilterWhere([
            'status' => $this->status,           
            'isdel' => $this->isdel,
            'isfeatured' => $this->isfeatured,
            /**/
        ]);
		
        $params = self::queryNumber([['id',$this->tableName()],['author_id']/*['id','{{%blogcatpos}}'],['id','{{%author}}']*/]);
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
				
		$query->andFilterWhere(['like','lower('.$userClass::tableName().'.username)',strtolower($this->authorName)]);
		
		if ($this->category || $this->term)
		{			
			
			$term = ($this->term?$this->term:$this->category);
			
			$dsn = $this->db->dsn;
			$cquery =  $this->find();	
			if (strtolower(substr($dsn,0,5)) == "mysql")
			{				
				$cquery->select(["GROUP_CONCAT(".$this->tableName().".id)"]);	
			}
			else
			{				
				$cquery->select(["array_agg(".$this->tableName().".id)"]);
			}	
									
			$cquery->leftJoin(BlogCatPos::tableName()." as cp",$this->tableName().".id = cp.post_id")
					->leftJoin(Category::tableName()." as c","cp.category_id = c.id");										
					
			if ($this->category)
			{				
				$cquery->andWhere("lower(c.title) = '".strtolower($term)."'");
			}
			else
			{
				$cquery->andWhere("lower(c.title) like '%".strtolower($term)."%' or lower(c.description) like '%".strtolower($term)."%'");
			}		
									
			$res = $cquery->scalar();
			$res = ($res == ""?"{}":$res);
				
			if ($this->category)
			{
				//$query->andFilterWhere(["OR","false",$this->tableName().".id = ANY ('".$res."')"]);
				$query->andFilterWhere(["OR","false","',".str_replace(["{","}"],"",$res).",' like concat('%,',".$this->tableName().".id,',%') "]);								
			}
			else
			{		
				$query->andFilterWhere(["OR","lower(title) like '%".strtolower($this->term)."%'",
					["OR","lower(description) like '%".strtolower($this->term)."%'",
						["OR","lower(tags) like '%".strtolower($this->term)."%'",
							["OR","lower(content) like '%".strtolower($this->term)."%'",
								//$this->tableName().".id = ANY ('".$res."')"
								"',".str_replace(["{","}"],"",$res).",' like concat('%,',".$this->tableName().".id,',%') "		
							]
						]
					]
				]);								
			}
		}				
		
        return $dataProvider;
    }
}
