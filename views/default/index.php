<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="blog-default-index">
    
    <div class="jumbotron">
		<h2>Yii2 Extensions for Blogging</h2>
        <h1>Congratulations!</h1>
        

        <p class="lead">You have successfully installed Blog extension for your Yii-powered application.</p>

        <p><?= Html::a(Yii::t('app','Get start to manage posting category'),['//blog/category'],["class"=>"btn btn-lg btn-success"])?></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-4">
                <h2>Post</h2>

                <p>Discrete entries of written work, especially with regard to its style or quality, typically displayed in reverse chronological order (the most recent post appears first).</p>

                <p><?= Html::a(Yii::t('app','Go to Posts'),['//blog/post'],["class"=>"btn btn-primary"])?>
                <?= Html::a(Yii::t('app','Manage Posts'),['//blog/post/admin'],["class"=>"btn btn-warning"])?></p>
            </div>
            <div class="col-sm-4">
                <h2>Gallery</h2>

                <p>Page that acts like a room or building for the display of works of art (especially images).</p>

                <p><?= Html::a(Yii::t('app','Go to Galleries'),['//blog/gallery'],["class"=>"btn btn-primary"])?>
                <?= Html::a(Yii::t('app','Manage Galleries'),['//blog/gallery/admin'],["class"=>"btn btn-warning"])?></p>
            </div>
            <div class="col-sm-4">
                <h2>Banner</h2>

                <p>Manage heading or advertisement appearing on a web page in the form of a bar, column, or box.</p>

                <p><?= Html::a(Yii::t('app','Go to Banners'),['//blog/banner'],["class"=>"btn btn-primary"])?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h2>Pages</h2>

                <p>Static pages, very usefull for site information or company profiles.</p>

                <p><?= Html::a(Yii::t('app','Manage pages'),['//blog/page'],["class"=>"btn btn-primary"])?></p>
            </div>
            <div class="col-sm-6">
                <h2>File</h2>

                <p>Manage files that available to be downloaded by users.</p>

                <p><?= Html::a(Yii::t('app','Manage Files'),['//blog/file/admin'],["class"=>"btn btn-primary"])?></p>
            </div>            
        </div>

    </div>
</div>
