<?php

namespace amilna\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_banner}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $front_image
 * @property string $tags
 * @property string $url
 * @property boolean $status
 * @property integer $position
 * @property string $time
 * @property integer $isdel
 */
class Banner extends \yii\db\ActiveRecord
{
    public $dynTableName = '{{%blog_banner}}';    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {        
        $mod = new Banner();        
        return $mod->dynTableName;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'image'], 'required'],
            [['image', 'front_image'], 'string'],
            [['status','image_only'], 'boolean'],
            [['position', 'isdel'], 'integer'],
            [['tags','time'], 'safe'],
            [['title'], 'string', 'max' => 65],
            [['description'], 'string', 'max' => 155],
            [[ 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'front_image' => Yii::t('app', 'Front Image'),
            'tags' => Yii::t('app', 'Tags'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
            'image_only' => Yii::t('app', 'Image Only'),
            'position' => Yii::t('app', 'Position'),
            'time' => Yii::t('app', 'Time'),
            'isdel' => Yii::t('app', 'Isdel'),
        ];
    }		
    
	public function itemAlias($list,$item = false,$bykey = false)
	{
		$lists = [
			/* example list of item alias for a field with name field */
			'status'=>[							
						0=>Yii::t('app','No'),							
						1=>Yii::t('app','Yes'),														
					],						
						
		];				
		
		if (isset($lists[$list]))
		{					
			if ($bykey)
			{				
				$nlist = [];
				foreach ($lists[$list] as $k=>$i)
				{
					$nlist[$i] = $k;
				}
				$list = $nlist;				
			}
			else
			{
				$list = $lists[$list];
			}
							
			if ($item !== false)
			{			
				return	(isset($list[$item])?$list[$item]:false);
			}
			else
			{
				return $list;	
			}			
		}
		else
		{
			return false;	
		}
	}  
	
	public function getTags()
	{
		$models = Banner::find()->all();
		$tags = [];
		foreach ($models as $m)
		{
			$ts = explode(",",$m->tags);
			foreach ($ts as $t)
			{	
				if (!in_array($t,$tags))
				{
					$tags[$t] = $t;
				}
			}	
		}
		return $tags;
	}  
	
	public function getLast()
    {                
        $res = $this->db->createCommand("SELECT 
					count(id) 
					FROM ".Banner::tableName()." 
					WHERE isdel = :isdel")
					->bindValues(["isdel"=>0])->queryScalar();		
        
        return ($res == null?0:$res);        
    }
    
    public function updatePosition($position)
    {                
        
        $models = Banner::find()->where("id != :id",["id"=>$this->id])->orderBy("position")->all();                
		
		$pos = 0;		
		$mis = false;					
		$low = false;
		$up = false;	
		$mod = "-";
		$m = false;
		
        foreach ($models as $model)
        {									
			$mis = ($mis === false && $model->position != $pos?$pos:$mis);				
			$pos = $pos+1;			
			$m = $model;
		}
        
        $alter = ($mis === false && $position > $pos?false:true);
        if ($m) {
			$mis = ($mis === false?$m->position+1:$mis);
		}
        
        $mod = ($position > $mis?"-":"+");
        $low = ($position > $mis?$mis:$position);
        $up = ($position < $mis?$mis:$position+1);
                
        $res = true;                        
        if ($low !== false && $up !== false && $alter === true)
        {								
			$res = $this->db->createCommand("UPDATE ".Banner::tableName()." 
						SET position = (position".$mod."1) 
						WHERE position >= :low AND position < :up AND id != :id")
						->bindValues(["low"=>$low,"up"=>$up,"id"=>$this->id])->execute();
		}				
        return $res;        
    }        
    
}
