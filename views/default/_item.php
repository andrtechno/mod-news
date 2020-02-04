<?php
use panix\engine\Html;


?>

<div class="single_blog">
    <div class="blog_thumb">
        <a href="blog-details.html"><img src="assets/img/blog/blog6.jpg" alt=""></a>
    </div>
    <div class="blog_content">
        <div><?= Html::a($model->name,$model->getUrl(),['class'=>'h3']);?></div>
        <div class="blog_meta">
            <span class="post_date"><i class="fa-calendar fa"></i> Februaey 02, 2019</span>
            <span class="author"><i class="fa fa-user-circle"></i> Posts by : admin</span>
            <span class="category">
                                        <i class="fa fa-folder-open"></i>
                                        <a href="#">Fashion</a>
                                    </span>
        </div>
        <div class="blog_desc">
            <?= $model->isText('short_description'); ?>
        </div>
        <div class="readmore_button d-none">
            <a href="blog-details.html">read more</a>
        </div>
    </div>
</div>