<?php

namespace amilna\blog\models;

use Yii;


/**
 * This is the model class for table "{{%blog_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $tags
 * @property string $image
 * @property integer $author_id
 * @property boolean $isfeatured
 * @property integer $status
 * @property string $time
 * @property integer $isdel
 *
 * @property BlogCatPos[] $blogCatPos
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
    public $dynTableName = '{{%blog_post}}';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {        
        $mod = new Post();        
        return $mod->dynTableName;              
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'content','status'], 'required'],
            [['content', 'image'], 'string'],
            [['author_id', 'status', 'isdel'], 'integer'],
            [['isfeatured'], 'boolean'],
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
            'content' => Yii::t('app', 'Content'),
            'tags' => Yii::t('app', 'Tags'),
            'image' => Yii::t('app', 'Image'),
            'author_id' => Yii::t('app', 'Author ID'),
            'isfeatured' => Yii::t('app', 'Featured'),
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
							0=>Yii::t('app','Draft'),							
							1=>Yii::t('app','Published'),
							2=>Yii::t('app','Archived'),
						],			
			'isfeatured'=>[							
							false=>Yii::t('app','No'),							
							true=>Yii::t('app','Featured'),						
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
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCatPos()
    {
        return $this->hasMany(BlogCatPos::className(), ['post_id' => 'id'])->where("isdel=0");
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        $userClass = Yii::$app->getModule('blog')->userClass;        
        return $this->hasOne($userClass::className(), ['id' => 'author_id']);
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
	
	public function getRecent($limit = 5)
	{
		return PostSearch::find()->andWhere('status = 1')->orderBy('id desc')->limit($limit)->all();		
	}
	
	public function getArchived($limit = 6)
	{
		$res =  $this->db->createCommand("SELECT 
				substring(concat('',time) from 1 for 7) as month
				FROM ".$this->tableName()." as p
				WHERE isdel = 0
				GROUP BY month				
				ORDER BY month desc
				LIMIT :limit")
				->bindValues(["limit"=>$limit])->queryAll();						
        
        return ($res == null?[]:$res);        
	}

}
