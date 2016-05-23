<?php

namespace amilna\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_gallery}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $tags
 * @property boolean $status
 * @property integer $type
 * @property string $time
 * @property integer $isdel
 */
class Gallery extends \yii\db\ActiveRecord
{
    public $dynTableName = '{{%blog_gallery}}';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {        
        $mod = new Gallery();        
        return $mod->dynTableName;              
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'image', 'type'], 'required'],
            [['url'], 'string'],
            [['status'], 'boolean'],
            [['type', 'isdel'], 'integer'],
            [['tags','time'], 'safe'],
            [['title'], 'string', 'max' => 65],
            [['description'], 'string', 'max' => 155],
            //[['tags'], 'string', 'max' => 255]
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
            'url' => Yii::t('app', 'Url'),
            'tags' => Yii::t('app', 'Tags'),
            'status' => Yii::t('app', 'Enable'),
            'type' => Yii::t('app', 'Type'),
            'time' => Yii::t('app', 'Time'),
            'isdel' => Yii::t('app', 'Isdel'),
        ];
    }	
    
	public function itemAlias($list,$item = false,$bykey = false)
	{
		$lists = [
			/* example list of item alias for a field with name field */
			'type'=>[							
						0=>Yii::t('app','Image'),							
						1=>Yii::t('app','Movie'),														
					],			
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
		$models = $this->find()->all();
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
   
}
