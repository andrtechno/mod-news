<?php

use panix\ext\tinymce\TinyMce;
use yii\web\JsExpression;

/**
 * @var \panix\engine\bootstrap\ActiveForm $form
 * @var \panix\mod\news\models\News $model
 * @var \yii\web\View $this
 */

?>

<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>
<?php if (Yii::$app->getModule('news')->enableCategory) { ?>
    <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\panix\mod\news\models\NewsCategory::find()->published()->all(), 'id', 'name')) ?>
<?php } ?>
<?=
$form->field($model, 'short_description')->tinyMceShort([
    'rows' => 6,
    'maxlength' => $this->context->module->shortMaxLength
]);
?>

<?=
$form->field($model, 'full_description')->widget(TinyMce::class, [
    'options' => ['rows' => 6],
]);
?>
<?= $form->field($model, 'tagValues')->widget(\panix\ext\taginput\TagInput::class) ?>
<?= $form->field($model, 'image', [
    'parts' => [
        '{buttons}' => $model->getFileHtmlButton('image')
    ],
    'template' => '<div class="col-sm-4 col-lg-2">{label}</div>{beginWrapper}{input}{buttons}{error}{hint}{endWrapper}'
])->fileInput() ?>

<?php

//$model->created_at = date('Y-m-d H:i:s',$model->created_at);
//echo $model->created_at;
//Yii::$app->formatter->timeZone = $this->timezone;
?>
<?= $form->field($model, 'created_at')->widget(\panix\engine\jui\DatetimePicker::class,['dateFormat' => 'yyyy-MM-dd','timezone'=>'UTC']) ?>

