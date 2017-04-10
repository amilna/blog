<?php

namespace amilna\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_files}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $file
 * @property string $tags
 * @property boolean $status
 * @property integer $type
 * @property string $time
 * @property integer $isdel
 */
class File extends \yii\db\ActiveRecord
{
   public $dynTableName = '{{%blog_files}}';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {        
        $mod = new File();        
        return $mod->dynTableName;        
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'file'], 'required'],
            [['file'], 'string'],
            [['status'], 'boolean'],
            [['isdel'], 'integer'],
            [['tags','time'], 'safe'],
            [['title'], 'string', 'max' => 65],
            [['description'], 'string', 'max' => 155],
            ['title', 'match', 'pattern' => '/^[a-zA-Z0-9 \-\(\)]+$/', 'message' => 'Title can only contain alphanumeric characters, spaces and dashes.'],
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
            'file' => Yii::t('app', 'File'),
            'tags' => Yii::t('app', 'Tags'),
            'status' => Yii::t('app', 'Status'),            
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
