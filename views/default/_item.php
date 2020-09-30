<?php
use panix\engine\Html;
use panix\engine\CMS;

/**
 * @var \panix\mod\news\models\News|\panix\engine\behaviors\UploadFileBehavior $model
 * @var \yii\web\View $this
 */
$image = $model->getImageUrl('image', '430x225');

?>

<div class="card mb-3">
    <div class="card-header">
        <?= Html::a($model->name, $model->getUrl(), ['class' => 'h3']); ?>
        <span class="float-right">
            <i class="icon-time"></i>
            <small><?= CMS::date($model->created_at); ?></small>
        </span>
    </div>
    <div class="card-body">
        <div>
            <?php if ($image) { ?>
                <?= Html::img($image); ?>
            <?php } ?>
            <?= $model->isText('short_description'); ?>
        </div>
    </div>
    <div class="card-footer">
        <span class="views mr-3"><i class="icon-eye"></i> <span><?= $model->views; ?></span></span>
        <span class="author mr-3"><i class="icon-user-outline"></i> <?= $model->user->username; ?></span>
    </div>
</div>
