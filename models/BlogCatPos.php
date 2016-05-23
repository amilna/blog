<?php

namespace amilna\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_cat_pos}}".
 *
 * @property integer $category_id
 * @property integer $post_id
 * @property integer $isdel
 *
 * @property BlogCategory $category
 * @property BlogPost $post
 */
class BlogCatPos extends \yii\db\ActiveRecord
{
    public $dynTableName = '{{%blog_cat_pos}}';    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {        
        $mod = new BlogCatPos();         
        return $mod->dynTableName;
    }    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'post_id'], 'required'],
            [['category_id', 'post_id', 'isdel'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'post_id' => Yii::t('app', 'Post ID'),
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
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
