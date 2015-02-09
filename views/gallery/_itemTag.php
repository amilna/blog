<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\cap\models\AccountCode */

?>

   <li>
		<div>
			<img alt="150x150" src="<?= str_replace('/uploads/','/uploads/.thumbs/',$model->url) ?>">			
			<div class="text">
				<div class="inner">
					<span><h4><?= $model->description ?></h4></span>

					<br>
					
					<div>
						<a href="#" title="<?= Yii::t("app","Media type of ".$model::itemAlias('type',$model->type)) ?>">
							<i class="glyphicon glyphicon-<?= ($model->type == 0?'picture':'film') ?>"></i>
						</a>
						
						<a href="<?= $model->url ?>" data-rel="colorbox" class="cboxElement">
							<i class="glyphicon glyphicon-search-plus"></i>
						</a>
															
					</div> 
				</div>
			</div>
		</div>
	</li>


