<?php

namespace amilna\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amilna\blog\models\Gallery;

/**
 * GallerySearch represents the model behind the search form about `amilna\blog\models\Gallery`.
 */
class GallerySearch extends Gallery
{

	public $tag;
	public $search;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'isdel'], 'integer'],
            [['title', 'description', 'url', 'tags', 'tag', 'time', 'search'], 'safe'],
            [['status'], 'boolean'],
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
        $query = Gallery::find();
        
                
        $query->joinWith([/**/]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        /* uncomment to sort by relations table on respective column */

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }				
		
        $query->andFilterWhere([
            'status' => $this->status,
            /**/
        ]);

        $params = self::queryNumber([['id'],['type'],['isdel']]);
		foreach ($params as $p)
		{
			$query->andFilterWhere($p);
		}
        $params = self::queryString([['title'],['description'],['url'],['tags']]);
		foreach ($params as $p)
		{
			$query->andFilterWhere($p);
		}
        $params = self::queryTime([['time']]);
		foreach ($params as $p)
		{
			$query->andFilterWhere($p);
		}
		
		$query->andFilterWhere(['like','lower(title)',strtolower($this->search)])
				->orFilterWhere(['like','lower(description)',strtolower($this->search)])
				->orFilterWhere(['like','lower(tags)',strtolower($this->search)])
				->orFilterWhere(['like','lower(url)',strtolower($this->search)]);
		
		if ($this->tag)
		{
			$query->andFilterWhere(['like',"lower(concat(',',tags,','))",strtolower(",".$this->tag.",")]);				
		}
		
        return $dataProvider;
    }
}
