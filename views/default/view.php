<?php
use panix\engine\widgets\Pjax;
use panix\engine\Html;
use panix\engine\CMS;

    /**
 * @var \panix\mod\news\models\News|\panix\engine\behaviors\UploadFileBehavior $model
 * @var \yii\web\View $this
 */
$image = $model->getImageUrl('image', '430x225');
Pjax::begin();
?>

<div class="card">
    <div class="card-header">
        <h1><?= ($this->h1) ? $this->h1 : $model->isString('name'); ?></h1>
        <span class="float-right">
            <i class="icon-time"></i>
            <small><?= CMS::date($model->created_at); ?></small>
        </span>
    </div>
    <div class="card-body">
        <?php if ($image) { ?>
            <?= Html::img($image); ?>
        <?php } ?>
        <div class="mce-content-body">
            <?= $model->isText('full_description'); ?>
        </div>
    </div>
    <div class="card-footer">
        <span class="views mr-3"><i class="icon-eye"></i> <span><?= $model->views; ?></span></span>
        <span class="author mr-3"><i class="icon-user-outline"></i> <?= $model->user->username; ?></span>
    </div>
</div>


<?php Pjax::end(); ?>
<?php
$tags = $model->tags;
$tagList = [];
if ($tags) {
    ?>
    <span><i class="fa fa-tags" aria-hidden="true"></i></span>
    <?php foreach ($tags as $tag) {
        /** @var \panix\engine\taggable\Tag $tag */
        $tagList[$tag->name] = $tag->frequency;
    }

    echo \panix\engine\taggable\TagWidget::widget([
        'items' => $tagList,
        'url' => ['/news/default/index'],
        'urlParam' => 'tag',
        'format' => 'inline'
    ]);
}
?>
<?php
if(Yii::$app->settings->get('news','comments')){
    echo panix\mod\comments\widgets\comment\CommentWidget::widget(['model' => $model]);
}
?>
