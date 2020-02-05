<?php
use panix\engine\widgets\Pjax;

/**
 * @var \panix\mod\news\models\News $model
 */
Pjax::begin();
?>
    <h1><?= ($this->h1) ? $this->h1 : $model->isString('name'); ?></h1>
    <div class="mce-content-body">
        <?= $model->isText('full_description'); ?>
    </div>
<?php Pjax::end(); ?>

<?php
if(Yii::$app->settings->get('news','comments')){
    echo panix\mod\comments\widgets\comment\CommentWidget::widget(['model' => $model]);
}
?>
