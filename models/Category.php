<?php

namespace amilna\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 * @property string $description
 * @property string $image
 * @property boolean $status
 * @property integer $isdel
 *
 * @property BlogCatPos[] $blogCatPos
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends \yii\db\ActiveRecord
{
    
    public $dynTableName = '{{%blog_category}}';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {        
        $mod = new Category();        
        return $mod->dynTableName;        
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['parent_id', 'isdel'], 'integer'],
            [['description'], 'string'],
            [['status'], 'boolean'],
            [['title'], 'string', 'max' => 65],
            [['image'], 'string', 'max' => 255],
            [['title'], 'unique'],
            ['title', 'match', 'pattern' => '/^[a-zA-Z0-9 \-\(\)]+$/', 'message' => 'Title can only contain alphanumeric characters, spaces and dashes.'],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
            'isdel' => Yii::t('app', 'Isdel'),
        ];
    }		 
    
	public function itemAlias($list,$item = false,$bykey = false)
	{
		$lists = [
			/* example list of item alias for a field with name field
			'afield'=>[							
							0=>Yii::t('app','an alias of 0'),							
							1=>Yii::t('app','an alias of 1'),														
						],			
			*/			
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
        return $this->hasMany(BlogCatPos::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }
    
    public function	parents($id = false)
    {
		return $this->findBySql("SELECT id,title FROM ".$this->tableName().($id?" WHERE id != :id and status=true":" WHERE status=true")." order by title",($id?['id'=>$id]:[]))->all();
	}	
}
